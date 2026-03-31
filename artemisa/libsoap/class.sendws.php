<?php
/**
 * @modifed Ivan dario quintero rios <quinteroivan@unbosque.edu.co>
 * @since Mayo 8 del 2019
 * Limpieza de codigo, modificaicion de funciones depreciadas, 
 */

    include("pram.inc");    
    require_once(PATH_SITE.'/includes/adaptador.php');
    require_once (PATH_ROOT.'/kint/Kint.class.php');

    if (!isset($_POST["token"])){
        include_once(dirname(__FILE__).'/../serviciosacademicos/funciones/clases/autenticacion/redirect.php');
    }
    require_once(dirname(__FILE__) . '/../nusoap/lib/nusoap.php');
    require_once(dirname(__FILE__) . "/../serviciosacademicos/Connections/conexionECollect.php");    
    
    require_once(dirname(__FILE__).'/controladorFunciones.php');
    $controlador = new controladorFunciones();    
    
    if ($_POST['tipocliente'] == "" && !isset($_SESSION['usertype'])) {
        ?>
        <script language="javascript">
            alert("Debe seleccionar el tipo de cliente, natural o jurÃ­dico");
            history.go(-1);
        </script>
        <?php
        exit();
    } else {
        $_SESSION['usertype'] = $_POST['tipocliente'];
    }
    $UserType =     $_SESSION['usertype'];    
    $referencia1 = $_POST['txtReference1'];
    $referencia2 = $_POST['txtReference2'];
    $referencia3 = $_POST['txtReference3'];
    $valor = $_POST['txtValor'];
    
    //validar existencia de variable cmbBanco
    if(!isset($_POST['cmbBanco'])){
        $codigobanco= "";
    }else{
        $codigobanco= $_POST['cmbBanco'];
    }
    
    $PaymentDesc = "PAGO PSE";
    $SrvCode = "10001";
    //validacion de medio de pago
    
    if ($PaymentSystem == 1) {
        $PaymentDesc = 'PAGO TARJETA';
        $SrvCode = "10002";
    } else if ($PaymentSystem == 100) {
        $PaymentDesc = 'PAGO BANCO';
        $SrvCode = "10003";
    }
    //consulta tipo de documento en people
    $tipodocumento = $controlador->documentopeople($db, $referencia3);      
    
    //consulta el ultimo ticked creado
    $ticketid = $controlador->Ultimoticket($db, $referencia1, $referencia2, $tipodocumento, $valor);     

    //llamdo al servicio del cliente para el web service
    $client = new nusoap_client(WEBSERVICEPSE, true);
    
    //informe de errores
    $err = $client->getError(); 
    
    
    //definicion de variable de seccion del contador
    $_SESSION['contadorentradasgettransaction'] = 0;    
    $err = false;
    if ($err) {
        echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
    }
    
    $referencias["referencia1"] = $referencia1;
    $referencias["referencia2"] = $referencia2;
    $referencias["referencia3"] = $tipodocumento;
    //creacion de cifrado de las referencias
    $clave = base64_encode(serialize($referencias));

    //creacion de array de parametros para envio
    $param[] = array(
        'EntityCode' => $EntityCode,
        'SrvCode' => $SrvCode,
        'PaymentDesc' => $PaymentDesc,
        'TransValue' => $valor,
        'TransVatValue' => '0',
        'UserType' => $UserType,
        'ReferenceArray' => array($referencia1, $referencia2, $tipodocumento),
        'PaymentSystem' => $PaymentSystem, //PSE    
        'URLResponse' => '',
        'URLRedirect' => $URLResponse . "?s=" . $clave . "&origen=1",
        'FICode' => $codigobanco
    );    

    $clavedecode = base64_decode($clave);
    
    //definicion de variables y valores al xml de envio
    $param2 = "<createTransactionPayment xmlns='http://www.avisortech.com/eCollectWebservices'><request ><EntityCode >".$EntityCode. 
    "</EntityCode><SrvCode >".$SrvCode."</SrvCode><PaymentDesc >".$PaymentDesc."</PaymentDesc><TransValue >".$valor." ".
    "</TransValue><TransVatValue >0</TransVatValue><UserType >".$UserType."</UserType><ReferenceArray >".$referencia1." ".
    "</ReferenceArray><ReferenceArray >".$referencia2."</ReferenceArray><ReferenceArray >".$tipodocumento."</ReferenceArray>".
    "<PaymentSystem >".$PaymentSystem."</PaymentSystem><URLResponse ></URLResponse><URLRedirect >".$URLResponse."?s=".$clave.
    "</URLRedirect><FICode/></request></createTransactionPayment>";
        
    //llamado a la funcion de creacion de transaccion
    $result = $client->call('createTransactionPayment', $param2, '', '', false, false); 
   
    //informe de errores
    if (!$client or $err = $client->getError()) {
        echo $err."<br />";
        return FALSE;
    }
    
    //validacion de resultados
    if ($result == null) {     
        echo '<h2>Fault datos</h2><pre>';
        print_r($result);    
        echo '</pre>';
    } else {  
        $err = false;
        if ($err) {        
            echo '<h2>Error</h2><pre>'.$err.'</pre>';
        } else {
            //asignacion de resultados
            $result = $result["createTransactionPaymentResult"];
            $value = $result['ReturnCode'];           
            $_SESSION["sesionpagopse"][$clavedecode]["ticketid"] = $result['TicketId'];
            $valueTemp = $controlador->ReturnCodeDesc($value, $referencia1, $resultado['TicketId'], '1');
            //consulta de estado de la orden
            $row_selestadoorden = $controlador->estadoOrden($db, $referencia1);        
            //si el resultados es satisfactorio
            if ($value == "SUCCESS") {                
                //obtiene el digito del estado de la orden
                $digitoorden = substr($row_selestadoorden, 1);                            
                //Actualizacion de orden de pago a estado en proceso                
                $controlador->updateEstadoPago($db,$referencia1,$digitoorden, '6');                
                //asignacion de ticket
                $Ticketa = $result['TicketId'];           

                $contadorintentos = $controlador->contadorlogpagos($db, $referencia1, $referencia2, $referencia3);     
                //valida que la cantidad de registros del estado de la orden sean menor a uno
                if ($contadorintentos['contador'] == '0') {
                    $setFlagButton="1";
                    $estado= "PENDING";   
                    $controlador->insertlogpagos($db, $Ticketa, $SrvCode, $referencia1, $referencia2, $tipodocumento, $PaymentDesc, 
                            $valor, $codigobanco, $estado, date("Y-m-d H:i:s"), $Ticketa, $setFlagButton);
                } else {
                    echo "PROCESO DE PAGO YA INICIADO ";
                    echo "<script language='javascript'>
                     alert('No se puede iniciar la operacion debido" .
                    " a que el numero de referencia o numero de" .
                    " factura se encuentra actualmente asociado a otro proceso de pago" .
                    " iniciado previamente, por favor espere unos minutos e intente nuevamente hasta" .
                    " que el sistema obtenga el resultado final de la transacción.');
                     window.location.href='../serviciosacademicos/consulta/prematricula/matriculaautomaticaordenmatricula.php'
                     </script>";
                    exit();
                }

                if (!isset($_POST["token"])) {                 
                    echo "<script language='javascript'> window.location.href='".$result['eCollectUrl']."'</script>";
                } else {
                    $UrlNew = $result['eCollectUrl'];
                    echo $UrlNew;
                }
            } else {
                if (preg_match("/FAIL/", $value)) {                    
                    //creacion de registro de log
                    $estado= "FAIL";  
                    $controlador->insertlogpagos($db, $result['TicketId'], $SrvCode, $referencia1, $referencia2, $tipodocumento, 
                            $param['PaymentDesc'], $valor, $result['BankName'], $estado, $result['BankProcessDate'], $result['TrazabilityCode']);
                }
                //definicion de variables para visualizar el comprobante de pago
                $Reference2=$referencia2;
                $nombreEstudiante= $controlador->nombre($db, $referencia2);
                $TransValue=$result['TransValue'];
                $Reference1=$result['Reference1'];
                $Reference3=$result['Reference3'];
                $TrazabilityCode=$result['TrazabilityCode'];

                verComprobante($db, $Reference1, $Reference2, $Reference3, $TransValue, $result['BankProcessDate'], $result['BankName'], 
                        $TrazabilityCode, $result['TicketId'], $valueTemp, $controlador);
            }//else    
        }//else resultado
    }

//funcion visualizacion comprobante
function verComprobante($db, $Reference1, $Reference2, $Reference3, $TransValue, $BankProcessDate, $BankName, $TrazabilityCode, $TicketId, $valueTemp, $controlador) {
    //definicion de encabezado de comprobante
    
    //consulta de datos de la universidad para detalles
    $row_universidad = $controlador->datosuniversidad($db);
    
    //consulta de estao de la orden
    $row_selestadoorden = $controlador->estadoOrden($db, $Reference1);
    
    if(!isset($_SESSION['codigo'])){
        $codigoestudiante = $controlador->consultaestudiante($db, $Reference1, $Reference2, $Reference3);
        $_SESSION['codigo'] = $codigoestudiante['codigoestudiante'];
    }
    
    $nombre = $controlador->nombre($db, $Reference1, $Reference2,$Reference3);
    
    //consulta de concepto
    $nombreconcepto = $controlador->nombreconcepto($db, $Reference1);
    
    //consulta de conceptos    
    $totalRows_conceptosordenpagomatricula = $controlador->estadoconcepto($db, $Reference1, '100');
    
    //validacion conceptos de matricula
    if ($totalRows_conceptosordenpagomatricula != "") {
        // La orden tiene conceptos de matricula
        $link = "../serviciosacademicos/consulta/prematricula/matriculaautomaticaordenmatricula.php?servicepse=1";
    } else {
        //valida conceptos de inscripcion
        $totalRows_conceptosordenpagoinscripcion = $controlador->estadoconcepto($db, $Reference1, '600');         
        
        if ($totalRows_conceptosordenpagoinscripcion != "") {
            // La orden tiene conceptos de inscripcion
            $link = "../serviciosacademicos/consulta/prematricula/inscripcionestudiante/formulariopreinscripcion.php?documentoingreso=". 
            $this->getReference2()."&logincorrecto";
        } 
    }//else
    
    $html = "<html><head><title>Comprobante de pago</title><meta http-equiv='Content-Type' content='text/html; charset=utf-8'></head><style type='text/css'>".
    "<!-- .textogris {font-family: Tahoma; font-size: 12px;  }  ".
    " .Estilo1 {font-family: Tahoma; font-size: 12px; ; color:#808080; font-weight: bold;} ".
    " .Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; } ".
    " .Estilo3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; font-weight: bold; } ".
    " .style1 {color: #FF0000} --> </style>".
    " <body>";
           
    $html.= "<table width='600' border='0' align='center'><tr><td><div align='center'>".
    "<img src='../imagenes/logouniversidad.jpeg' width='200' height='62' onClick='print()'><br><span class='Estilo5'>".
    $row_universidad['personeriauniversidad']."<br>".$row_universidad['entidadrigeuniversidad']."<br>".$row_universidad['nituniversidad']."</span>".
    "</div></td></tr></table><br><table width='57%' height='324' border='0' align='center' cellpadding='1' cellspacing='0'><tr>".
    "<td class='marco' bgcolor='#000000'><table border=0 cellpadding=2 cellspacing=0 width='100%' bgcolor='#FFFFFF'><tr>".
    "<td height='23' colspan='2' align='center' class='titulos'><strong>Comprobante de Pago </strong></td></tr>".
    "<tr align='center'><td class='textonegro' colspan='3' height='48'><hr size='1' color='#B5B5B5' width='90%'></td></tr>".
    "<tr><td class=textoverde width='16%'>&nbsp;</td><td class=textogris width='90%'><table width='100%'  border='0' cellspacing='2' cellpadding='0'>".
    "<tr><td class='textogris'>NIT:</td><td><span class='Estilo1'>".$row_universidad['nituniversidad']."</span></td></tr><tr>".
    "<td class='textogris'>Empresa:</td><td><span class='Estilo1'>".$row_universidad['nombreuniversidad']."</span></td></tr><tr><tr>".
    "<td class='textogris'>Total a pagar: </td><td class='textogris'><span class='Estilo1'>$ ".number_format($TransValue)."</span>".
    "</td></tr><tr><td class='textogris'>Fecha de Transacci&oacute;n: </td><td class='textogris'><span class='Estilo1'>".$BankProcessDate."</span>".
    "</td></tr><tr><td class='textogris'>Banco:</td><td class='textogris'><span class='Estilo1'>".$BankName."</span></td></tr><tr>".
    "<td class='textogris'>Código único de seguimiento de la transacción en PSE (CUS): </td><td><span class='Estilo1'>".$TrazabilityCode."</span></td>".
    "</tr><tr><td class='textogris'>N&uacute;mero de Transacci&oacute;n: </td><td class='textogris'><span class='Estilo1'>".$TicketId."</span></td>".
    "</tr><tr><td class='textogris'>N&uacute;mero de número de orden de pago: </td><td class='textogris'><span class='Estilo1'>".$Reference1."</span></td>".
    "</tr><tr><td class='textogris'>Descripci&oacute;n del Pago: </td><td class='textogris'><span class='Estilo1'>".$nombreconcepto."</span></td>".
    "</tr><tr><td class='textogris'>IP de Origen: </td><td class='textogris'><span class='Estilo1'>".$_SERVER["REMOTE_ADDR"]."</span></td>".
    "</tr><td class='textogris'>Documento de Identidad:</td><td><span class='Estilo1'>".$row_selestadoorden['numerodocumento']."</span></td>".
    "</tr><tr><td class='textogris'>Nombres y Apellidos: </td><td class='textogris'><span class='Estilo1'>".$nombre."</span></td>".
    "</tr><tr><td class='textogris'>&nbsp;</td><td class='textogris'>&nbsp;</td></tr><tr><td class='textogris'><div align='center'></div></td><td class='textogris'>".
    "<div align='center'></div></td></tr></table><b>&nbsp;</b><table width='100%'  border='0' align='center' cellpadding='1' cellspacing='1'>".
    "<tr><td width='100%' align='left' class='textogris style1'>".$valueTemp."</td></tr></table><b>&nbsp;</b><table width='100%'  border='0' align='center' cellpadding='1' cellspacing='1'>".
    "<tr><td width='50%' align='right'>".
    "";
    
    $html.="<a href='".$link."'><img src='../imagenes/ico_back.jpg' width='58' height='52'></a></td>".
    "<td width='50%'><img src='../imagenes/ico_print.jpg' width='58' height='52' style='border:2px solid blue;' onClick='print()'></td>".
    "</tr></table></td><td class=textogris align='left'><b>&nbsp;</b></td></tr></table></td></tr></table><br><div align='center' class='Estilo5'>".
    $row_universidad['direccionuniversidad']." - P B X".$row_universidad['telefonouniversidad']." - FAX:".$row_universidad['faxuniversidad']."<br>".
    $row_universidad['paginawebuniversidad']." - ".$row_universidad['nombreciudad']." ".$row_universidad['nombrepais']."</div></body></html>";
    
    echo $html;
    
}//function