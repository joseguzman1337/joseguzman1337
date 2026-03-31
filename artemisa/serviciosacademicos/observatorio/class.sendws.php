<?php
//echo '<pre>';print_r($_POST);die;
   /* $_POST['PaymentSystem'] = 0;
    $_POST['tipocliente'] = '0';
    $_POST['txtValor'] = 256000;
    $_POST['txtReference1'] = 1909277;
    $_POST['txtReference2'] = 1033715602;
    $_POST['txtReference3'] ='CC';*/

//echo '<pre>';print_r($_POST);


include("pram.inc");
//require_once('nusoap.php');
require_once('class.dbwebservices.php');
 if(!$_POST["token"]){
include_once('../serviciosacademicos/funciones/clases/autenticacion/redirect.php');
}
require_once(dirname(__FILE__).'/../nusoap/lib/nusoap.php');
//var_dump(is_file(dirname(__FILE__)."/../serviciosacademicos/Connections/conexionECollect.php"));die;  
require_once(dirname(__FILE__)."/../serviciosacademicos/Connections/conexionECollect.php");

if ($_POST['tipocliente'] == "" && !isset($_SESSION['usertype'])) {
?>
    <script language="javascript">
        alert("Debe seleccionar el tipo de cliente, natural o jurÃ­dico");
        history.go(-1);
    </script>
<?php

    exit();
} else {
    if (!isset($_SESSION['usertype'])) {
        $GLOBALS['usertype'];
        session_register("usertype");
    }
    $_SESSION['usertype'] = $_POST['tipocliente'];
}

$UserType = $_SESSION['usertype'];
//session_start();
/**
 * ==============================================================================
 * Descripciï¿½n:         Pagina encargada de enviar los parametros              |
 *                      requeridos al WebServices PSE de Avisortech Ltda.      |
 * Desarrollado por:    Avisortech Ltda.                                       |
 *                      (571) - 3458833 - (571) - 4937039.                     |
 *                      Carrera 26 # 63 a - 22 Piso 5. - Bogotï¿½ D.C - Colombia.|
 * Desarrollo para:     Universidad del Bosque. Bogotï¿½ D.C - Colombia          |
 * Autor:               Nicolï¿½s G. Rico                                        |
 *                      Ing. Desarrollador Avisortech Ltda.                    |
 *                      nicolas.guaneme@avisortech.com                         |
 * Fecha:               26 de Octubre de 2005.                                 |
 * Versiï¿½n:             0.1 release.                                           |
 * ==============================================================================
 */
$ConDB = new DB_mysql;
switch ($_POST['txtReference3']) {
    case "CC":
        $tipodocumento = "CC";
        break;
    case "TI":
        $tipodocumento = "TI";
        break;
    case "CE":
        $tipodocumento = "CE";
        break;
    case "RC":
        $tipodocumento = "RC";
        break;
    case "PA":
        $tipodocumento = "PP";
        break;
    case "NI":
        $tipodocumento = "NIT";
        break;
    case "CM":
        $tipodocumento = "CC";
        break;
    case "CB":
        $tipodocumento = "IDC";
        break;
    case "DU":
        $tipodocumento = "CC";
        break;
    case "CI":
        $tipodocumento = "CC";
        break;
    case "DN":
        $tipodocumento = "CC";
        break;
    default:
        $tipodocumento = "CC";
        break;
}
$ConDB->conectar($database_sala);
$ConDB->setReference1($_POST['txtReference1']);
$ConDB->setTransValue($_POST['txtValor']);
$ConDB->setReference2($_POST['txtReference2']);
$ConDB->setReference3($tipodocumento);
$ConDB->setSrvCode($SrvCode);
$ConDB->consulta("SELECT TicketId FROM LogPagos");
//$ConDB->getNextTicketId();
$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
$proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
$proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
//201.245.75.110:8081
// http://68.178.148.167/payment/webservice/MPPWebServices.asmx?WSDL
//$client = new soapclient("http://190.144.204.16/ecollect/webservice/MPPServices.asmx?WSDL", true,$proxyhost, $proxyport, $proxyusername, $proxypassword);
//$client = new soapclient("http://pse.unbosque.edu.co/ecollect/webservice/MPPServices.asmx?WSDL", true, $proxyhost, $proxyport, $proxyusername, $proxypassword);
//$client = new soapclient("http://68.178.148.205/corepsem/webservice/MPPWebServices.asmx?WSDL", true,$proxyhost, $proxyport, $proxyusername, $proxypassword);
$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
//$proxyhost, $proxyport, $proxyusername, $proxypassword
//$client = new soapclient("http://pagoselectronicos.unbosque.edu.co/eCollectExpressPruebas/webservice/eCollectWebservicesv2.asmx?WSDL", true);
//$client = new soapclient("http://pse.unbosque.edu.co/eCollectExpress/webservice/eCollectWebservicesv2.asmx?WSDL", true);
$client = new nusoap_client(WEBSERVICEPSE, true);
//$client = new soapclient("http://200.31.75.118/eCollectExpressPruebas/webservice/eCollectWebservicesv2.asmx?WSDL", true);
//$client = new soapclient("http://zeus.mipuntodepago.com/d_express/webservice/eCollectWebservicesv2.asmx?WSDL", true);
$err = $client->getError();//-->Ojo hay que descomentar despues;

$_SESSION['contadorentradasgettransaction']=0;
$err = false;

if ($err) {
    echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

$proxy = $client->getProxy();

/*$ConDB->getReference1(),
    'Reference2' => $ConDB->getReference2(),
    'Reference3' => $ConDB->getReference3(),*/
$referencias["referencia1"]=$ConDB->getReference1();
$referencias["referencia2"]=$ConDB->getReference2();
$referencias["referencia3"]=$ConDB->getReference3();
$clave=base64_encode(serialize($referencias));

$param[] = array(
    'EntityCode' => $EntityCode,
    //'TicketId' => $ConDB->getTicketId(),
    //'TicketId'          => 8080,
    'SrvCode' => $SrvCode,
    'PaymentDesc' => 'PAGO PSE',
    'TransValue' => $ConDB->getTransValue(),
    'TransVatValue' => '0',
    'UserType' => $UserType,
    'ReferenceArray' => array($ConDB->getReference1(),$ConDB->getReference2(),$ConDB->getReference3()),
    'PaymentSystem' => $PaymentSystem, //PSE
    //'URLResponse' => $URLResponse . "?t=" . $ConDB->getTicketId(),
    'URLResponse' => '',
    'URLRedirect' => $URLResponse . "?s=" . $clave."&origen=1",
    'FICode' => $_POST['cmbBanco']
);

$clavedecode=base64_decode($clave);
//echo "<BR>CLAVE=".$clavedecode."<BR>";
/*$_SESSION["sesionpagopse"][$clavedecode]["ticketid"]="";
$_SESSION["sesionpagopse"][$clavedecode]["referencia1"]=$ConDB->getReference1();
$_SESSION["sesionpagopse"][$clavedecode]["referencia2"]=$ConDB->getReference2();
$_SESSION["sesionpagopse"][$clavedecode]["referencia3"]=$ConDB->getReference3();
*/
$PaymentDesc="PAGO PSE";
    $SrvCode="10001";
if ($PaymentSystem == 1) {
    $PaymentDesc= 'PAGO TARJETA';
    $SrvCode="10002";
} else if($PaymentSystem == 100){
    $PaymentDesc= 'PAGO BANCO';
    $SrvCode="10003";
}


/*echo "Request<pre>";
print_r($param);
echo "</pre>";*/
//exit();

/*$param2="<createTransactionPayment xmlns='http://www.avisortech.com/eCollectWebservices'>
            <request >
                <EntityCode >".$EntityCode."</EntityCode>
                <SrvCode >".$SrvCode."</SrvCode>
                <PaymentDesc >PAGO PSE</PaymentDesc>
                <TransValue >".$ConDB->getTransValue()."</TransValue>
                <TransVatValue >0</TransVatValue>
                <UserType >".$UserType."</UserType>
                <ReferenceArray >".$ConDB->getReference1()."</ReferenceArray>
                <ReferenceArray >".$ConDB->getReference2()."</ReferenceArray>
                <ReferenceArray >".$ConDB->getReference3()."</ReferenceArray>
                <PaymentSystem >".$PaymentSystem."</PaymentSystem>
                <URLResponse ></URLResponse>
                <URLRedirect >".$URLResponse . "?s=" . $clave."</URLRedirect>
                <FICode/>
            </request>
        </createTransactionPayment>";*/



//$param2="<createTransactionPayment xmlns='http://www.avisortech.com/eCollectWebservices'><request ><EntityCode >".$EntityCode."</EntityCode><SrvCode >".$SrvCode."</SrvCode><PaymentDesc >".$PaymentDesc."</PaymentDesc><TransValue >".$ConDB->getTransValue()."</TransValue><TransVatValue >0</TransVatValue><UserType >".$UserType."</UserType><ReferenceArray >".$ConDB->getReference1()."</ReferenceArray><ReferenceArray >".$ConDB->getReference2()."</ReferenceArray><ReferenceArray >".$ConDB->getReference3()."</ReferenceArray><PaymentSystem >".$PaymentSystem."</PaymentSystem><URLResponse ></URLResponse><URLRedirect >".$URLResponse . "?s=" . $clave."</URLRedirect><FICode/></request></createTransactionPayment>";
$param2="<createTransactionPayment xmlns='http://www.avisortech.com/eCollectWebservices'><request ><EntityCode >".$EntityCode."</EntityCode><SrvCode >".$SrvCode."</SrvCode><PaymentDesc >".$PaymentDesc."</PaymentDesc><TransValue >".$ConDB->getTransValue()."</TransValue><TransVatValue >0</TransVatValue><UserType >".$UserType."</UserType><ReferenceArray >".$ConDB->getReference1()."</ReferenceArray><ReferenceArray >".$ConDB->getReference2()."</ReferenceArray><ReferenceArray >".$ConDB->getReference3()."</ReferenceArray><PaymentSystem >".$PaymentSystem."</PaymentSystem><URLResponse ></URLResponse><URLRedirect >".$URLResponse . "?s=" . $clave."</URLRedirect><FICode/></request></createTransactionPayment>";

//echo '<pre>';print_r($param2);

$result = $client->call('createTransactionPayment', $param2, '', '', false, false);

//var_dump($result);
//echo '<pre>';print_r($result);

// Revisar posibles errores
/* echo '<h2>POST</h2><pre>';
    print_r($_POST);
    echo '</pre>';
  echo '<h2>Response</h2><pre>';
    print_r($result);
    echo '</pre>';
    echo '<h2>Request</h2>';
    echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';*/
  //  $result['eCollectUrl']=str_replace("200.31.75.118","pse.unbosque.edu.co",$result['eCollectUrl']);
//exit();

if ($proxy->fault) { 
    echo '<h2>Fault</h2><pre>';
    print_r($result);
    echo '</pre>';
} else { 
    
    // Revisar mas errores
    $err = $proxy->getError();//-->OJO hay que descomentar
   $err = false;
  
    if ($err) {
        // Mostrar el error.
        echo '<h2>Error</h2><pre>' . $err . '</pre>';
    } else { 
        
		$result = $result["createTransactionPaymentResult"];
        $value = $result['ReturnCode'];
        //$value = "SUCCESS";//-->Quitar despues----->OJO
        $_SESSION["sesionpagopse"][$clavedecode]["ticketid"]=$result['TicketId'];
        $valueTemp = $ConDB->getReturnCodeDesc($value);
        $query_selestadoorden = "select o.codigoestadoordenpago, concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre, eg.numerodocumento
			from ordenpago o, estudiantegeneral eg, estudiante e
			where o.numeroordenpago = '" . $ConDB->getReference1() . "'
			and eg.idestudiantegeneral = e.idestudiantegeneral
			and e.codigoestudiante = o.codigoestudiante";
        $selestadoorden = mysql_db_query($database_sala, $query_selestadoorden) or die("$query_selestadoorden" . mysql_error());
        $totalRows_selestadoorden = mysql_num_rows($selestadoorden);
        $row_selestadoorden = mysql_fetch_array($selestadoorden);
        //echo $value;
        
        if ($value == "SUCCESS") {
            //session_start();
            //--------------------------------//
            // Agregado para seleccionar el digito en que se encuentra la orden para poderle hacer el update y que no se me pierda la informacion
            // Primero miro cual es el estado actual de la orden
            $digitoorden = ereg_replace("^[0-9]{1,1}", "", $row_selestadoorden['codigoestadoordenpago']);
            //-------------------------------//
            $ConDB->updateEstadoOrden($ConDB->getReference1(), $digitoorden);
            $ConDB->consulta($ConDB->getstrConsulta());

            //$_SESSION['Ticket'] = $ConDB->getTicketId();
            //$Ticketa = $ConDB->getTicketId();
            $Ticketa = $result['TicketId'];
            session_register('Ticketa');
            $ConDB->setTicketId($Ticketa);

       $query_selestadoorden = "select * from LogPagos where
            reference1='".$ConDB->getReference1()."'
        and reference2='".$ConDB->getReference2()."'
        and reference3='".$ConDB->getReference3()."'
            and FlagButton='1'";  
        $selestadoorden = mysql_db_query($database_sala, $query_selestadoorden) or die("$query_selestadoorden" . mysql_error());
        $totalRows_selestadoorden = mysql_num_rows($selestadoorden);


            if($totalRows_selestadoorden<1){
               // echo 'entro...';
                $ConDB->setFlagButton("1");
            //echo '<br>paso..';
            $ConDB->insertLogPagos();
           // echo 'Insert--->';
            }else{
             echo "PROCESO DE PAGO YA INICIADO ";
             echo "<script language='javascript'>
                 alert('No se puede iniciar la operacion debido".
             " a que el numero de referencia o numero de".
             " factura se encuentra actualmente asociado a otro proceso de pago".
             " iniciado previamente, por favor espere unos minutos e intente nuevamente hasta".
             " que el sistema obtenga el resultado final de la transacción.');
                 window.location.href='../serviciosacademicos/consulta/prematricula/matriculaautomaticaordenmatricula.php'
                 </script>";
             exit();
            }
//                echo $_SESSION['Ticketa'];

//echo '<br>AhoraAca....';
//var_dump($result);//['eCollectUrl'];die;
            $ConDB->consulta($ConDB->getstrConsulta());
           // exit();
           
           if(!$_POST["token"]){
            echo "<script language='javascript'> window.location.href='" . $result['eCollectUrl'] . "'</script>";
            }else{
                //http://BUSRVPSEDES/d_eCollectexpress/secure/services.aspx?WsPm=383264466242746876386371505466714E35776261673D3D
                $UrlNew =$result['eCollectUrl'];// str_replace('BUSRVPSEDES','200.31.88.58:8080',$result['eCollectUrl']);
                echo $UrlNew;
            }
            //header ("Location: ".$result['Url']);
        } else {
            /*if ($result['TranState'] == 'PENDING') {
                $ConDB->updatePagoPENDING($result['BankProcessDate'], $result['BankName'], $result['TrazabilityCode'], $_GET['t']);
                $ConDB->consulta($ConDB->getstrConsulta());
            }*/
            if (ereg("FAIL", $value)) {
                // El ticket es invalido entonces se aumenta en dos en la base de datos
                //$nuevoticket = $this->getTicketId()+2;

                $query_inslogpagos = "INSERT INTO LogPagos (TicketId,SrvCode,Reference1,Reference2,Reference3,PaymentDesc,TransValue,TransVatValue,SoliciteDate,BankProcessDate,FIName,StaCode,TrazabilityCode)
					VALUES ('".$result['TicketId']."','$SrvCode'" . ",'" . $ConDB->getReference1() . "'" . ",'" . $ConDB->getReference2() . "'" . ",'" . $ConDB->getReference3() . "','" . $param['PaymentDesc'] . "','" . $ConDB->getTransValue() . "','0','" . date("Y-m-d H:i:s") . "','" . $result['BankProcessDate'] . "','" . $result['BankName'] . "','$value','" . $result['TrazabilityCode'] . "'" . ")";
                //$strCons = "INSERT INTO LogPagos (TicketId,SrvCode,Reference1,Reference2,Reference3,PaymentDesc,TransValue,TransVatValue,SoliciteDate,FIName,TrazabilityCode) VALUES ('" . $this->getTicketId() . "','" . $this->getSrvCode() . "'" . ",'" . $this->getReference1() . "'" . ",'" . $this->getReference2() . "'" . ",'" . $this->getReference3() . "','" . $this->getPaymentDesc() . "','" . $this->getTransValue() . "','" . $this->getTransVatValue() . "','" . date("Y-d-m:H:i:s") . "','" . $this->getFIName() . "','" . $this->getTrazabilityCode() . "'" . ");";
                //echo $query_inslogpagos;
                //$inslogpagos = mysql_db_query($database_sala, $query_inslogpagos) or die("$query_inslogpagos<br>" . mysql_error());
            }
            //echo "Por aca va";
            // Agregado para seleccionar el digito en que se encuentra la orden para poderle hacer el update y que no se me pierda la informacion
            // Primero miro cual es el estado actual de la orden
            $ConDB->setReference2($row_selestadoorden['numerodocumento']);
            $ConDB->setnombreEstudiante($row_selestadoorden['nombre']);
            //$ConDB->setBankProcessDate($result['BankProcessDate']);
            $ConDB->setTransValue($result['TransValue']);
            $ConDB->setReference1($result['Reference1']);
            //$ConDB->setFIName($result['BankName']);
            $ConDB->setTrazabilityCode($result['TrazabilityCode']);

            //$ConDB->insertLogPagos();
            //$ConDB->consulta($ConDB->getstrConsulta());

            $ConDB->verRecibo();
            //echo $ConDB->getstrMensaje();
            //print_r($result);
            //print_r($param);
        }
        //        print_r($result);
    }
}
$ConDB = null;
//if($_REQUEST['debug'])
//{
/*echo "<pre>";
print_r($param);
echo "</pre>";

echo "<pre>Lo que viener por el POST<br>";
print_r($_POST);
echo "</pre>";
echo "<pre>";
print_r($result);
echo "</pre>";
echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';*/
//}
// Final del cliente.*/
?>
