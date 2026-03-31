<?php
include("pram.inc");
//require_once('nusoap.php');
require_once('class.dbwebservices.php');

if($_POST['tipocliente'] == "" && !isset($_SESSION['usertype']))
{
?>
	<script language="javascript">
	alert("Debe seleccionar el tipo de cliente, natural o jurídico");
	history.go(-1);
	</script>
<?php
	exit();
}
else
{
	if(!isset($_SESSION['usertype']))
	{
		$GLOBALS['usertype'];
		session_register("usertype");
	}
	$_SESSION['usertype'] = $_POST['tipocliente'];	
}
//session_start();
/**
 *==============================================================================
 * Descripción:         Pagina encargada de enviar los parametros              |
 *                      requeridos al WebServices PSE de Avisortech Ltda.      |
 * Desarrollado por:    Avisortech Ltda.                                       |
 *                      (571) - 3458833 - (571) - 4937039.                     |
 *                      Carrera 26 # 63 a - 22 Piso 5. - Bogotá D.C - Colombia.|
 * Desarrollo para:     Universidad del Bosque. Bogotá D.C - Colombia          |
 * Autor:               Nicolás G. Rico                                        |
 *                      Ing. Desarrollador Avisortech Ltda.                    |
 *                      nicolas.guaneme@avisortech.com                         |
 * Fecha:               26 de Octubre de 2005.                                 |
 * Versión:             0.1 release.                                           |
 *==============================================================================
 */
     $ConDB = new DB_mysql;
     $ConDB->conectar($database_sala);
     $ConDB->setReference1($_POST['txtReference1']);
     $ConDB->setTransValue($_POST['txtValor']);
     $ConDB->setReference2($_POST['txtReference2']);
     $ConDB->setSrvCode($SrvCode);
     $ConDB->consulta("SELECT TicketId FROM LogPagos");
     $ConDB->getNextTicketId();
     $proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
     $proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
     $proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
     //201.245.75.110:8081
	 // http://68.178.148.167/payment/webservice/MPPWebServices.asmx?WSDL
	 $client = new soapclient("http://200.31.79.250/clientmpp/secure/pay_entityws.aspx", true,$proxyhost, $proxyport, $proxyusername, $proxypassword);
	 //$client = new soapclient("http://68.178.148.205/corepsem/webservice/MPPWebServices.asmx?WSDL", true,$proxyhost, $proxyport, $proxyusername, $proxypassword);
     $proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
     $err = $client->getError();
     if ($err) {
    	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
     }
	 
	 $proxy = $client->getProxy();
     
	 $param[] = array(
        'EntityCode'        => $EntityCode,
        'TicketId'          => $ConDB->getTicketId(),
		//'TicketId'          => 8080,
        'SrvCode'           => $SrvCode,
        'PaymentDesc'       => 'PAGO PSE',
        'TransValue'        => $ConDB->getTransValue(),
        'TransVatValue'     => '0',
        'UserType'          => $UserType,
        'Reference1'        => $ConDB->getReference1(),
        'Reference2'        => $ConDB->getReference2(),
        'Reference3'        => $ConDB->getReference3(),
        'PaymentSystem'     => $PaymentSystem, //PSE
        'URLResponse'       => $URLResponse . "?t=" .$ConDB->getTicketId(),
        'FICode'            => $_POST['cmbBanco']
     );
	 $result = $client->call('createTransactionPayment', array($param), '', '', true, true);
	 // Revisar posibles errores
    if ($proxy->fault) {
    	echo '<h2>Fault</h2><pre>';
    	print_r($result);
    	echo '</pre>';
    } else {
		// Revisar mas errores
    	$err = $proxy->getError();
    	if ($err) {
    		// Mostrar el error.
    		echo '<h2>Error</h2><pre>' . $err . '</pre>';
    	} else {
            $value = $result['ReturnCode'];
			$valueTemp = $ConDB->getReturnCodeDesc($value);
			$query_selestadoorden = "select o.codigoestadoordenpago, concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre, eg.numerodocumento
			from ordenpago o, estudiantegeneral eg, estudiante e
			where o.numeroordenpago = '".$ConDB->getReference1()."'
			and eg.idestudiantegeneral = e.idestudiantegeneral
			and e.codigoestudiante = o.codigoestudiante";
			$selestadoorden=mysql_db_query($database_sala,$query_selestadoorden) or die("$query_selestadoorden".mysql_error());
			$totalRows_selestadoorden = mysql_num_rows($selestadoorden);	
			$row_selestadoorden = mysql_fetch_array($selestadoorden);
				
			if($value == "SUCCESS"){
				//session_start();
				
				//--------------------------------//
				// Agregado para seleccionar el digito en que se encuentra la orden para poderle hacer el update y que no se me pierda la informacion
				// Primero miro cual es el estado actual de la orden
				$digitoorden = ereg_replace("^[0-9]{1,1}","",$row_selestadoorden['codigoestadoordenpago']);
                //-------------------------------//
				$ConDB->updateEstadoOrden($ConDB->getReference1(),$digitoorden);
                $ConDB->consulta($ConDB->getstrConsulta());
                
				//$_SESSION['Ticket'] = $ConDB->getTicketId();
                $Ticketa = $ConDB->getTicketId();
                session_register('Ticketa');
                $ConDB->insertLogPagos();
//                echo $_SESSION['Ticketa'];
                $ConDB->consulta($ConDB->getstrConsulta());
                header ("Location: ".$result['Url']);
            } 
			else 
			{
			  if ($result['TranState'] == 'PENDING')
			  {
			  	$ConDB->updatePagoPENDING($result['BankProcessDate'],$result['BankName'],$result['TrazabilityCode'],$_GET['t']);
          		$ConDB->consulta($ConDB->getstrConsulta());
			  }
 			  //echo "Por aca va";
			  // Agregado para seleccionar el digito en que se encuentra la orden para poderle hacer el update y que no se me pierda la informacion
			  // Primero miro cual es el estado actual de la orden
			  $ConDB->setReference2($row_selestadoorden['numerodocumento']);
              $ConDB->setnombreEstudiante($row_selestadoorden['nombre']);
              $ConDB->setBankProcessDate($result['BankProcessDate']);
			  $ConDB->setTransValue($result['TransValue']);
			  $ConDB->setReference1($result['Reference1']);
			  $ConDB->setFIName($result['BankName']);
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
if($_REQUEST['debug'])
{ 
	print_r($result);
    echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
}
// Final del cliente.*/
?>
