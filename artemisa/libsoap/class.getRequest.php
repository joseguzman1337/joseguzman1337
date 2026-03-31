<?php

include("pram.inc");
require_once(PATH_SITE."/includes/adaptador.php");

require_once(dirname(__FILE__)."/../nusoap/lib/nusoap.php");
require_once(dirname(__FILE__)."/../serviciosacademicos/Connections/conexionECollect.php");
require_once(dirname(__FILE__).'/controladorFunciones.php');
require_once(dirname(__FILE__)."/../serviciosacademicos/consulta/interfacespeople/funcionesPS.php");
require_once(dirname(__FILE__)."/../sala/entidadDAO/ColaNotificacionPagoPsDAO.php");

$controlador = new controladorFunciones();

//valida si existe la variable de session
if(isset($_SESSION['MM_Username'])){
    $usuario = $_SESSION['MM_Username'];
    if($_SESSION["MM_Username"]=="Manejo Sistema"){
        unset($_SESSION['auth']);
        unset($_SESSION["MM_Username"]);
        unset($_SESSION['rol']);
    }
}
//valida si existe la variable de session
if(isset($_SESSION['codigo'])){
    $codigoestudiante = $_SESSION['codigo'];
}

//valida si existe la variable de origen
if(isset($_REQUEST['origen'])){
    $origen= $_REQUEST['origen'];
}else{
    $origen = "1";
}
//asigna el codigo de get
$referencias = unserialize(base64_decode($_GET["s"]));

//VERIFICA EL ULTIMO TICKED CREADO EN EL PROCESO
$row_ticket = $controlador->maximoticket($db, $referencias["referencia1"]);

//DEFINICION DEL WEB SERVICES DE PAGOS PSE
$client = new nusoap_client(WEBSERVICEPSE,true, false, false, false, false, 0, 200);

//informe de errores
if (!$client or $err = $client->getError()) {
    echo $err."<br />";
    return FALSE;
}
//DEFINICION DE LOS PARAMETROS DE CONSULTA
$param[] = array( 'EntityCode' => $EntityCode, 'TicketId' => $row_ticket);
//DEFINICION DEL METODO DE CONSULTA Y LOS PARAMETROS DE ENVIO
$resultado = $client->call('getTransactionInformation', array("request"=>array( 'EntityCode' => $EntityCode, 'TicketId' => $row_ticket)));

//SE ASIGNAS LOS RESULTADOS DE RESPUESTA DEL METODO DEL WEBSERVICE

if(isset($resultado["getTransactionInformationResult"]['ReferenceArray'])){
    $result['Reference1'] = $resultado["getTransactionInformationResult"]['ReferenceArray']['0'];
    $result['Reference2'] = $resultado["getTransactionInformationResult"]['ReferenceArray']['1'];
    $result['Reference3'] = $resultado["getTransactionInformationResult"]['ReferenceArray']['2'];
}else{
  $result['Reference1'] = $referencias["referencia1"];
  $result['Reference2'] = $referencias["referencia2"];
  $result['Reference3'] = $referencias["referencia3"];
}
$result['TranState'] = $resultado["getTransactionInformationResult"]['TranState'];
$result['ReturnCode'] = $resultado["getTransactionInformationResult"]['ReturnCode'];
$result['BankProcessDate'] = $resultado["getTransactionInformationResult"]['BankProcessDate'];
$result['BankName'] = $resultado["getTransactionInformationResult"]['BankName'];
$result['TrazabilityCode'] = $resultado["getTransactionInformationResult"]['TrazabilityCode'];
$result['TransValue'] = $resultado["getTransactionInformationResult"]['TransValue'];
$_GET["t"] = $row_ticket;

//VARIABLE DE CICLO DEL PROCESO
$sigue = 0;

if ( $result['TranState'] != 'BANK' &&  $result['TranState'] != 'OK' || $result['TranState'] == '' || $result['TranState'] == null){
    $sigue = 1;
}

//si el valor es negativo
if ($sigue == 1){
    //si el codigo de retorno es fallido por no identificacion
    if(isset($result['ReturnCode']) && $result['ReturnCode'] == 'FAIL_TICKETIDNOTFOUND'){
        //valida que la oden esta pagda en la anterior pasarela de pagos
        $listadoorden = $controlador->ordenpagada($db, $result['Reference1']);
        $fallo = '1';
        if(count($listadoorden) >= 1){
            foreach($listadoorden as $estadoorden){
                //si los datos estan pagados
                if($estadoorden['StaCode'] == "OK") {
                    //valida si la orden esta pendiente de pagar o activa
                    if($estadoorden['codigoestadoordenpago'] == '60' || $estadoorden['codigoestadoordenpago'] == '61'
                            || $estadoorden['codigoestadoordenpago'] == '11' || $estadoorden['codigoestadoordenpago'] == '10'){
                        $controlador->updateEstadoPago($db,$result['Reference1'],'0', '4');
                        $controlador->updateFechaPagoU($db,$estadoorden['TicketId']);
                    }
                    $datosorden = $estadoorden;
                    $fallo = '0';
                }//ok
            }//foreach
        }
        //si la orden se encuentra en un estado falido se valida que este en los estados de 60 y 10  para generar un nuevo intento de pago
        if($fallo == '1'){
            $estadoorden = $controlador->estadoOrden($db, $result['Reference1']);
            if(!isset($estadoorden) || $estadoorden == '60' || $estadoorden == '61' || $estadoorden == '11' || $estadoorden == '10'){
                $controlador->updateEstadoPago($db,$result["Reference1"],'0', '1');
                $ticket = $controlador->maximoticket($db, $result["Reference1"]);
                $stacode = $controlador->estadolog($db, $result["Reference1"], $ticket);
                if($stacode <> 'NOT_AUTHORIZED'){
                    $stacode = 'EXPIRED';
                }
                if(!isset($result['FIName']) || empty($result['FIName'])){
                    $result['FIName'] = "";
                }
                $controlador->updatePagoLog($db, $ticket, $result['Reference1'], $stacode, $result['BankProcessDate'], $result['BankName'], $result['TrazabilityCode'] );
                $strMensaje = "Su intento de pago fue fallido o no autorizado. El cual ha sido actualizado. Por favor inténtelo nuevamente.";
                verComprobante($db, $stacode, $result["Reference1"], $result["Reference2"], $result["Reference3"], $result['TransValue'], $result['BankProcessDate'], $result['FIName'],
                            $result['TrazabilityCode'], $ticket, $strMensaje, $controlador);
            }
        }else{
            //consulta el mensaje por medio del estado
            $stacode = $controlador->estadolog($db, $result["Reference1"], $row_ticket);
            $strMensaje=$controlador->ReturnCodeDesc('OK', $result['Reference1'], $row_ticket, $origen);
            verComprobante($db, $stacode , $result['Reference1'], $result['Reference2'], $result['Reference3'], $datosorden['TransValue'], $datosorden['BankProcessDate'], $datosorden['FIName'],
                           $datosorden['TrazabilityCode'], $row_ticket, $strMensaje, $controlador);
        }
        //end
    }else{
        if($result['TranState'] != 'OK'){
            $controlador->updateEstadoPago($db,$result["Reference1"],'0', '1');
            $controlador->updatePagoLog($db, $row_ticket, $result['Reference1'], $result['TranState'], $result['BankProcessDate'], $result['BankName'], $result['TrazabilityCode'] );
        }
        /**end */
        //SI LA OPERACION NO OBTENE LOS RESULTADOS SE IDENTIFICA UN PROCESO PENDIENTE Y SE MUESTRA EL SIGUIENTE MENSAJE
        $strMensaje = "Su transacción fue ".$result['TranState'].", por favor intente nuevamente o comuníquese con su entidad bancaria para realizar su pago.";
        verComprobante($db, $result['TranState'], $result["Reference1"], $result["Reference2"], $result["Reference3"], $result['TransValue'], $result['BankProcessDate'], $result['BankName'],
                    $result['TrazabilityCode'], $row_ticket, $strMensaje, $controlador);
    }
}//if sigue
else{
    //SE INCREMENTA LA VARIABLE DEL CONTADOR DE CONSULTAS DE LA TRANSACCION
    if(isset($_SESSION['contadorentradasgettransaction'])){
        $_SESSION['contadorentradasgettransaction']++;
    }else{
        $_SESSION['contadorentradasgettransaction']= '1';
    }

    if ($result == null) {
        echo '<h2>Fault</h2><pre>';
        print_r($result);
        echo '</pre>';
    }
    else {
        //consulta de estado de la orden y datos del usuario
        $estadoorden = $controlador->estadoOrden($db, $result['Reference1']);

        //VALIDA EL ESTADO DE LA ORDEN
        $digitoorden = substr($estadoorden, 1);
        $TicketId=$_GET["t"];
        $TransValue=$result['TransValue'];
        $Reference1=$result['Reference1'];
        $Reference2=$result['Reference2'];
        $Reference3=$result['Reference3'];
        $BankProcessDate=$result['BankProcessDate'];

        if(isset($result['BankName']) && !empty($result['BankName'])){
            $FIName=$result['BankName'];
        }else{
            $banco  = $controlador->ordenpagada($db, $Reference1);
            $FIName = $banco['FIName'];
        }

        $TrazabilityCode=$result['TrazabilityCode'];
        //consulta el mesaje del estado
        $strMensaje=$controlador->ReturnCodeDesc($result['TranState'], $Reference1,$TicketId, $origen);
        $FlagButton="0";

        //SI EL ESTADO DE RESPUESTA ES OK
        if ($result['TranState'] == 'OK'){
            //identificacion del digito del estado de la orden
            $digitoorden = substr($estadoorden, 1);
            //si el estadoa de la orden es diferente a pagada
            if($estadoorden <> '40' && $estadoorden <> '41' && $estadoorden <> '44'
                    && $estadoorden <> '51' && $estadoorden <> '52'){
                //Actualizacion de la orden en la tabla orden a pagada
                $controlador->updateEstadoPago($db,$result['Reference1'],$digitoorden, '4');
                //Actualiza el registro de la tala de ordendenpago la fecha actual
                $controlador->updateFechaPagoU($db, $result['Reference1']);
            }
            //consulta el tipo de orden
            $tipoorden= $controlador->tipoorden($db, $result['Reference1']);

            switch($tipoorden){
                case '153':{
                    //Inscripcion
                    //inicia proceso de inscripcion y sus detalles
                    require_once('../serviciosacademicos/funciones/inscribir.php');
                    $inscribir = new inscribirEstudiante();
                    $inscribir->hacerInscripcion($db, $result['Reference1']);
                }break;
                case '151':{
                    //Matricula
                    //Consulta el estado de la orden de prematricula
                    $estadoprematricula= $controlador->estadoprematricula($db, $result['Reference1']);
                    //si esl estado de la premtraicula es difrente a pagado
                    if($estadoprematricula <> '40' && $estadoprematricula <> '41'){
                        //Actualiza la prematricula y la orden de pago a pagar
                        $controlador->updateprematricula($db, $result['Reference1'], '0');
                        //Actualiza el detalleprematricula
                        $controlador->updatedetalleprematricula($db, $result['Reference1'], '30');
                    }
                    //actualizacion de estado estudiante a "matriculado"
                    $codigoestudiante = $controlador->consultaestudiante($db, $Reference1, $Reference2, $Reference3);
                    $controlador->estadomatriculado($db, $codigoestudiante['codigoestudiante']);
                }break;
                case '0080':{
                    //PlanPagos
                    // Consulta si la orden pertenece a un plan de pagos
                    $row_plan = $controlador->consultaplanpagos($db, $result['Reference1']);
                    //Valida si el codigoestado existe y es diferente de vacio
                    if (isset($row_plan['codigoestado']) && !empty($row_plan['codigoestado'])) {
                        //asignacion de la orden de pago a numeroordenpagohijo
                        $numeroordenpagohijo = $result['Reference1'];

                        //Define el numero de plan de pago como numero de orden padre
                        $numeroordenpagopadre = $row_plan['numerorodenpagoplandepagosap'];
                        //consulta el estado de la orden
                        $estadoordenpadre = $controlador->estadoOrden($db, $numeroordenpagopadre);

                        //si el estado de la orden es diferente a pagada
                        if($estadoordenpadre != '40' && $estadoordenpadre != '41'
                            && $estadoordenpadre != '44' && $estadoordenpadre != '52'){
                            //Obtiene el indicativo del estado de la orden
                            $digitoorden = substr($estadoordenpadre, 1);
                            //Actualizacion de la orden en la tabla orden a pagada
                            $controlador->updateEstadoPago($db,$numeroordenpagopadre,$digitoorden, '4');
                            //Actualiza el registro de la tala de ordendenpago la fecha actual
                            $controlador->updateFechaPagoU($db, $numeroordenpagopadre);
                        }//if

                        //consulta el estado de la prematricula
                        $estadoprematricula= $controlador->estadoprematricula($db, $numeroordenpagopadre);
                        //si el estado de la premtraicula es difrente a pagado
                        if($estadoprematricula <> '40' && $estadoprematricula <> '41'){
                            //obtiene el indicativo del estado de la orden
                            $digitoprematricula = substr($estadoprematricula, 1);
                            //Actualiza la prematricula y la orden de pago a pagar
                            $controlador->updateprematricula($db, $numeroordenpagopadre, $digitoprematricula);
                            //Actualiza el detalleprematricula
                            $controlador->updatedetalleprematricula($db, $numeroordenpagopadre, '30');
                        }
                        //Actualiza el estado del plan de pago a 300
                        $controlador->updateplanpagos($db, $numeroordenpagohijo, '300');
                        //actualizacion de estado estudiante a "matriculado"
                        $codigoestudiante = $controlador->consultaestudiante($db, $Reference1, $Reference2, $Reference3);
                        $controlador->estadomatriculado($db, $codigoestudiante['codigoestudiante']);
                    }
                }break;
            }//swicth
            //consulta estado en logpagos
            $ticket = $controlador->Ultimoticket($db, $result['Reference1'], $result['Reference2'], $result['Reference3'], $result['TransValue'], 'OK');
            //valida si eexite ticketd en ok
            if(!isset($ticket) || empty($ticket)){
                //Actualizacion de la orden en logpagos a estado OK
                $controlador->updatePagoLog($db, $TicketId,  $result['Reference1'], 'OK', $result['BankProcessDate'], $result['BankName'], $result['TrazabilityCode'], $FlagButton);
            }
            //registrar en el logTrance
            $controlador->registrarLog($db, 3, $row_ticket, $result );
            // Consulta para aplicar los descuentos de la orden a validando la tabla descuento vs deudas
            $detalleorden = $controlador->detalleorden($db, $result['Reference1']);

            foreach($detalleorden as $ordenes){
                //Consulta el descueto a aplicar
                $consultadvd = $controlador->ConsultarDescuentos($db, $ordenes['codigoestudiante'],$ordenes['codigoperiodo'], $ordenes['codigoconcepto'] , $ordenes['valorconcepto']);
            }//foreach
            //visualiza comprobante de pago
            $stacode = $controlador->estadolog($db, $result["Reference1"], $TicketId);
            verComprobante($db, $stacode, $Reference1, $Reference2, $Reference3, $TransValue, $BankProcessDate, $FIName, $TrazabilityCode, $TicketId, $strMensaje, $controlador);
        }else{
            //Si el estado es pendiente
            if ($result['TranState'] == 'PENDING'){
                //Actualiza la tabla logpagos
                $controlador->updatePagoLog($db, $TicketId, $result['Reference1'], 'PENDING', $result['BankProcessDate'], $result['BankName'], $result['TrazabilityCode'] );
                $stacode = $controlador->estadolog($db, $result["Reference1"], $TicketId);
                verComprobante($db, $stacode, $Reference1, $Reference2, $Reference3, $TransValue, $BankProcessDate, $FIName, $TrazabilityCode, $TicketId, $strMensaje, $controlador);
            }else {
                //consulta el estado de la prematricula
                $row_selestadoprematricula =  $controlador->estadoprematricula($db, $Reference1);
                //obtiene el id
                $digitoprematricula = substr($row_selestadoprematricula['codigoestadoprematricula'], 1);

                // Como la transaccion fallo vuelve y deja la orden lista para ser pagada
                $controlador->updateEstadoPago($db, $result['Reference1'], $digitoprematricula, '1');
                // Actualiza el logpagos
                $controlador->updatePagoLog($db, $_GET['t'], $result['Reference1'], $result['TranState'] );

                $controlador->updatePagoLog($db, $row_ticket, $Reference1, null, $result['BankProcessDate'], $result['BankName'], $result['TrazabilityCode'], $FlagButton );
                $stacode = $controlador->estadolog($db, $result["Reference1"], $TicketId);
                verComprobante($db, $stacode, $Reference1, $Reference2, $Reference3, $TransValue, $BankProcessDate, $FIName, $TrazabilityCode, $TicketId, $strMensaje, $controlador);
            }
        }//else
    }//else result
}
//funcion visualizacion comprobante
function verComprobante($db, $TranState, $Reference1, $Reference2, $Reference3, $TransValue, $BankProcessDate, $BankName, $TrazabilityCode, $TicketId, $strMensaje, $controlador) {
    //consulta de datos de la universidad para detalles
    $row_universidad = $controlador->datosuniversidad($db);

    if(!isset($_SESSION['codigo'])){
        $codigoestudiante = $controlador->consultaestudiante($db, $Reference1, $Reference2, $Reference3);
        $_SESSION['codigo'] = $codigoestudiante['codigoestudiante'];
    }
    //consulta datos del estudiante
    $nombre = $controlador->nombre($db,$Reference2);

    //consulta de concepto
    $conceptoorden = $controlador->nombreconcepto($db, $Reference1);

    //consulta de conceptos
    $totalRows_conceptosordenpagomatricula = $controlador->estadoconcepto($db, $Reference1, '100');

    //validacion conceptos
    if ($totalRows_conceptosordenpagomatricula != "") {
        // La orden tiene conceptos de matricula
        $link = "../serviciosacademicos/consulta/prematricula/matriculaautomaticaordenmatricula.php?servicepse=1";
    } else {
        $totalRows_conceptosordenpagoinscripcion = $controlador->estadoconcepto($db, $Reference1, '600');
        if ($totalRows_conceptosordenpagoinscripcion != "") {
            // La orden tiene conceptos de inscripcion
            $link = "../serviciosacademicos/consulta/prematricula/inscripcionestudiante/formulariopreinscripcion.php?documentoingreso=".$Reference2."&logincorrecto";
        } else {
            // Cargar las variable de sesion del estudiante si no las tiene
            // La orden tiene otros conceptos
             $link = "../serviciosacademicos/consulta/prematricula/matriculaautomaticaordenmatricula.php?servicepse=1";
        }
    }//else

    //definicion de encabezado de comprobante
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
    "</tr><tr><td class='textogris'>Descripci&oacute;n del Pago: </td><td class='textogris'><span class='Estilo1'>".$conceptoorden."</span></td>".
    "</tr><tr><td class='textogris'>IP de Origen: </td><td class='textogris'><span class='Estilo1'>".$_SERVER["REMOTE_ADDR"]."</span></td>".
    "</tr><td class='textogris'>Documento de Identidad:</td><td><span class='Estilo1'>".$Reference2."</span></td>".
    "</tr><tr><td class='textogris'>Nombres y Apellidos: </td><td class='textogris'><span class='Estilo1'>".$nombre."</span></td>".
    "</tr><tr><td class='textogris'>&nbsp;</td><td class='textogris'>&nbsp;</td></tr><tr><td class='textogris'><div align='center'></div></td><td class='textogris'>".
    "<div align='center'></div></td></tr></table><b>&nbsp;</b><table width='100%'  border='0' align='center' cellpadding='1' cellspacing='1'>".
    "<tr><td width='100%' align='left' class='textogris style1'><b>".$strMensaje."</b></td></tr></table><b>&nbsp;</b><table width='100%'  border='0' align='center' cellpadding='1' cellspacing='1'>".
    "<tr><td width='50%' align='right'>";

    $html.="<a href='".$link."'><img src='../imagenes/ico_back.jpg' width='58' height='52'></a></td>".
    "<td width='50%'><img src='../imagenes/ico_print.jpg' width='58' height='52' style='border:2px solid blue;' onClick='print()'></td>".
    "</tr></table></td><td class=textogris align='left'><b>&nbsp;</b></td></tr></table></td></tr></table><br><div align='center' class='Estilo5'>".
    $row_universidad['direccionuniversidad']." - P B X".$row_universidad['telefonouniversidad']." - FAX:".$row_universidad['faxuniversidad']."<br>".
    $row_universidad['paginawebuniversidad']." - ".$row_universidad['nombreciudad']." ".$row_universidad['nombrepais']."</div></body></html>";

    echo $html;

    //Author: Lina Quintero
    //Fecha: 27-04-2021
    //$row_ticket: valida si el pago esta dentro de las fechas habilitadas para enviar a people el pago en el mes activo
    $row_ticket = $controlador->fechasreportarpagopeople($db, $TicketId);

    if (isset($TranState) && ($TranState == 'OK' || $TranState == 'APROBADA')) {
        //Notificacion a people del pago si $row_ticket es true
        if ($row_ticket) {

            $colaNotificacionPago = new \Sala\entidadDAO\ColaNotificacionPagoPsDAO();
            $banderaEnvioPeople = $colaNotificacionPago->getOrderInProcess($Reference1);

            if ($banderaEnvioPeople == 0 || $banderaEnvioPeople == 1) {
                reportarPagoPeople($db, $Reference1, $TicketId);
            }
        }
    }
}//function