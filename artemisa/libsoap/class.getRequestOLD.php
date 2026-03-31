<?php
include("pram.inc");
require_once('nusoap.php');
require('class.dbwebservices.php');
//session_start();

$usuario = $_SESSION['MM_Username'];
$codigoestudiante = $_SESSION['codigo'];

$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
$proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
$proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
//201.245.75.110:8081
//http://68.178.148.167/payment/webservice/MPPWebServices.asmx?WSDL

$client = new soapclient("http://pse.unbosque.edu.co/ecollect/webservice/MPPServices.asmx?WSDL", true,	$proxyhost, $proxyport, $proxyusername, $proxypassword);
//$client = new soapclient("http://68.178.148.205/corepsem/webservice/MPPWebServices.asmx?WSDL", true,	$proxyhost, $proxyport, $proxyusername, $proxypassword);
$err = $client->getError();
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}
$proxy = $client->getProxy();

$param[] = array(
        'EntityCode'        => $EntityCode,
        'TicketId'          => $_GET['t']
 );

$result = $client->call('getTransactionInformation', array($param), '', '', true, true);
// Check for a fault
if ($proxy->fault) 
{
	echo '<h2>Fault</h2><pre>';
	print_r($result);
	echo '</pre>';
} 
else 
{
	// Check for errors
	$err = $proxy->getError();
	if ($err) 
	{
		// Display the error
		echo '<h2>Error</h2><pre>' . $err . '</pre>';
	} 
	else 
	{
		$query_selestadoorden = "select o.codigoestadoordenpago, concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre, eg.numerodocumento
		from ordenpago o, estudiantegeneral eg, estudiante e
		where o.numeroordenpago = '".$result['Reference1']."'
		and eg.idestudiantegeneral = e.idestudiantegeneral
		and e.codigoestudiante = o.codigoestudiante";
		$selestadoorden=mysql_db_query($database_sala,$query_selestadoorden) or die("$query_selestadoorden".mysql_error());
		$totalRows_selestadoorden = mysql_num_rows($selestadoorden);	
        $row_selestadoorden = mysql_fetch_array($selestadoorden);
		
		// Primero miro cual es el estado actual de la orden
		$digitoorden = ereg_replace("^[0-9]{1,1}","",$row_selestadoorden['codigoestadoordenpago']);
		    
        if ($result['TranState'] == 'OK')
		{
			// Primero miro cual es el estado actual de la orden
		  	$digitoorden = ereg_replace("^[0-9]{1,1}","",$row_selestadoorden['codigoestadoordenpago']);
		  
			$query_selestadoprematricula = "select p.codigoestadoprematricula 
			from prematricula p, ordenpago o
			WHERE o.numeroordenpago = '".$result['Reference1']."'
			and o.idprematricula = p.idprematricula";
			$selestadoprematricula=mysql_db_query($database_sala,$query_selestadoprematricula) or die("$query_selestadoprematricula".mysql_error());
			$totalRows_selestadoprematricula = mysql_num_rows($selestadoprematricula);	
			$row_selestadoprematricula = mysql_fetch_array($selestadoprematricula);
			$digitoprematricula = ereg_replace("^[0-9]{1,1}","",$row_selestadoprematricula['codigoestadoprematricula']);
			  
			$ConPSE = new DB_mysql;
			$ConPSE->conectar($database_sala);
          
		  	$ConPSE->updatePagoOK($result['BankProcessDate'],$result['BankName'],$result['TrazabilityCode'],$_GET['t']);
          	$ConPSE->consulta($ConPSE->getstrConsulta());
          
		  	$ConPSE->updateEstadoPagoOK($result['Reference1'],$digitoorden);
          	$ConPSE->consulta($ConPSE->getstrConsulta());
          
		  	$ConPSE->updateTablasU($result['BankProcessDate'],$result['Reference1'],$digitoorden);
          	$ConPSE->consulta($ConPSE->getstrConsulta());
          
		  	$ConPSE->updateFechaPagoU();
          	$ConPSE->consulta($ConPSE->getstrConsulta());
          
		  	$ConPSE->setReference2($result['Reference2']);
		  
		  	// Update de la tabla de detalle prematricula para la orden de pago pasada
		  	$ConPSE->updateTablaPrematricula($result['Reference1'],$digitoprematricula);
		  	$ConPSE->consulta($ConPSE->getstrConsulta());
          
		  	$ConPSE->updateTablaDetallePrematricula($result['Reference1']);
		  	$ConPSE->consulta($ConPSE->getstrConsulta());
          
		  	$ConPSE->nombre();
		  	$ConPSE->setReference2($row_selestadoorden['numerodocumento']);
          	$ConPSE->setnombreEstudiante($row_selestadoorden['nombre']);
          	$ConPSE->setBankProcessDate($result['BankProcessDate']);
          	$ConPSE->setTransValue($result['TransValue']);
          	$ConPSE->setReference1($result['Reference1']);
          	$ConPSE->setFIName($result['BankName']);
          	$ConPSE->setTrazabilityCode($result['TrazabilityCode']);
		 
		  	$ConPSE->setstrMensaje($ConPSE->getReturnCodeDesc($result['TranState']));
		  
		  	$query_conceptoorden = "select do.codigoconcepto
          	from detalleordenpago do
          	WHERE do.numeroordenpago = '".$result['Reference1']."'
          	and do.codigoconcepto = 'C9048'";
          	$conceptoorden=mysql_db_query($database_sala,$query_conceptoorden) or die("$query_conceptoorden".mysql_error());
          	$totalRows_conceptoorden = mysql_num_rows($conceptoorden);          
	      	$row_conceptoorden = mysql_fetch_array($conceptoorden);
		  	if ($row_conceptoorden <> "")
          	{
          		$query_inscripcion = "UPDATE ordenpago o,estudiante e,inscripcion i,estudiantecarrerainscripcion ec
				SET i.codigosituacioncarreraestudiante = '107', e.codigosituacioncarreraestudiante = '107'
				WHERE o.codigoestudiante = e.codigoestudiante
				AND e.idestudiantegeneral = i.idestudiantegeneral 
				AND e.codigocarrera = ec.codigocarrera
				AND i.idinscripcion = ec.idinscripcion
				AND o.numeroordenpago = '".$result['Reference1']."'";
				$inscripcion=mysql_db_query($database_sala,$query_inscripcion) or die("$query_inscripcion".mysql_error());
		  	}
		  	//$ConPSE->setstrMensaje("El pago se ha realizado satisfactoriamente.");
		  	//header ("Location: http://172.16.7.109/desarrollo1/serviciosacademicospse/consulta/prematricula/ticket.php?ordenpago=".$result['Reference1']."");
		  	// require('../serviciosacademicospse/consulta/prematricula/ticket.php');
		  	$ConPSE->verRecibo();
			
			//header ("Location: http://201.245.75.110:8084/sala/serviciosacademicos/consulta/facultades/consultafacultades.htm");
		  
		  	// Hacer que se vaya al ticket
		 	//header ("Location: http://172.16.7.109/desarrollo1/serviciosacademicospse/consulta/prematricula/matriculaautomatica.php?programausadopor=");
		  	$numeroordenpago = $result['Reference1'];
  		  	$ruta = "../serviciosacademicos/";
		  	require("../serviciosacademicos/interfacessap/informa_pago_internet.php");
		  	saprfc_close($rfc);
		  	//echo "dasdasdasd ",$respuesta;
		  	//exit();
  	    
		 	// Si la orden pertenece a un plan de pagos
		 	$query_plan = "SELECT * FROM ordenpagoplandepago
         	WHERE numerorodencoutaplandepagosap = '$numeroordenpago'"; 
	     	//echo $query_data,"<br>";
	     	$plan = mysql_db_query($database_sala,$query_plan) or die(mysql_error());
	     	$row_plan = mysql_fetch_assoc($plan);
	     	$totalRows_plan = mysql_num_rows($plan);
	       $numeroordenpagohijo = $numeroordenpago;
		 	if ($row_plan <> "")
		 	{ //if 2 
				$numeroordenpago = $row_plan['numerorodenpagoplandepagosap'];
				$digito = ereg_replace("^[0-9]{1,1}","",$row_data['codigoestadoordenpago']);
				//echo $query_prematricula;
			
				$query_ordenpago = "UPDATE ordenpago
				set codigoestadoordenpago = 4".$digito.",
				documentocuentaxcobrarsap = '$documentocuentaxcobrarsap',
				documentocuentacompensacionsap = '$documentocuentacompensacionsap',
				fechapagosapordenpago = '$fechapagosapordenpago'
				where numeroordenpago = '$numeroordenpago'";
		   		// echo $query_ordenpago;
				$ordenpago=mysql_db_query($database_sala,$query_ordenpago) or die("$query_ordenpago".mysql_error());
	
				$query_detalleprematricula = "UPDATE detalleprematricula 
				set codigoestadodetalleprematricula = '30'
				where numeroordenpago = '$numeroordenpago'
				and codigoestadodetalleprematricula like '1%'";
				$detalleprematricula=mysql_db_query($database_sala,$query_detalleprematricula) or die("$query_detalleprematricula".mysql_error());   
	
				$query_conceptoorden = "select do.codigoconcepto
				from detalleordenpago do
				WHERE do.numeroordenpago = '$numeroordenpago'
				and do.cuentaoperacionprincipal = '153'";
				$conceptoorden=mysql_db_query($database_sala,$query_conceptoorden) or die("$query_conceptoorden".mysql_error());
				$totalRows_conceptoorden = mysql_num_rows($conceptoorden);          
				$row_conceptoorden = mysql_fetch_array($conceptoorden);
	
				$query_planes = "update ordenpagoplandepago 
				set codigoindicadorprocesosap = '300'
				WHERE numerorodencoutaplandepagosap = '$numeroordenpagohijo'";
				$planes=mysql_db_query($database_sala,$query_planes) or die("$query_planes".mysql_error());  
				
				if ($row_conceptoorden <> "")
				{ // if 2
			   		$query_inscripcion = "UPDATE ordenpago o,estudiante e,inscripcion i,estudiantecarrerainscripcion ec
			   		SET i.codigosituacioncarreraestudiante = '107',
			   		e.codigosituacioncarreraestudiante = '107'
			   		WHERE o.codigoestudiante = e.codigoestudiante
			   		AND e.idestudiantegeneral = i.idestudiantegeneral 
			   		AND e.codigocarrera = ec.codigocarrera
			   		AND i.idinscripcion = ec.idinscripcion
			   		AND o.numeroordenpago = '$numeroordenpago'";
			   		$inscripcion=mysql_db_query($database_sala,$query_inscripcion) or die("$query_inscripcion".mysql_error());
				} // if 2
			}
		
			// Esto se hace para pasar los descuentos de la orden a aplicado en la tabal descuento vs deudas
			$query_detalleorden = "SELECT d.codigoconcepto,d.valorconcepto,o.codigoperiodo,o.codigoestudiante
			FROM ordenpago o,detalleordenpago d
			WHERE o.numeroordenpago = '$numeroordenpago'
			AND o.numeroordenpago = d.numeroordenpago
			AND d.codigotipodetalleordenpago = '2'";
			//echo $query_data,"<br>";
			$detalleorden = mysql_db_query($database_sala,$query_detalleorden) or die(mysql_error());
			while($row_detalleorden = mysql_fetch_assoc($detalleorden))
			{
				$query_consultadvd="SELECT iddescuentovsdeuda
				FROM descuentovsdeuda
				WHERE codigoestudiante = '".$row_detalleorden['codigoestudiante']."'
				and codigoestadodescuentovsdeuda = '01'
				and codigoperiodo = '".$row_detalleorden['codigoperiodo']."'
				and codigoconcepto = '".$row_detalleorden['codigoconcepto']."'
				and valordescuentovsdeuda = '".$row_detalleorden['valorconcepto']."'";                                
				$consultadvd=mysql_db_query($database_sala,query_consultadvd);
				$row_respuestadvd=mysql_fetch_array($consultadvd);
	
				if ($row_respuestadvd <> "")
				{
					$base3="update descuentovsdeuda
					set  codigoestadodescuentovsdeuda = '03' 
					where iddescuentovsdeuda = '".$row_respuestadvd['iddescuentovsdeuda']."'"; 
					$sol3=mysql_db_query($database_sala,$base3);            
				 }                                 
			}
        } 
		else if ($result['TranState'] == 'PENDING')
		{
			$ConPSE = new DB_mysql;
			$ConPSE->conectar($database_sala);
			
			$ConPSE->updatePagoPENDING($result['BankProcessDate'],$result['BankName'],$result['TrazabilityCode'],$_GET['t']);
          	$ConPSE->consulta($ConPSE->getstrConsulta());
          
			$ConPSE->setReference2($row_selestadoorden['numerodocumento']);
            $ConPSE->setnombreEstudiante($row_selestadoorden['nombre']);
            $ConPSE->setstrMensaje($ConPSE->getReturnCodeDesc($result['TranState']));
			$ConPSE->setBankProcessDate($result['BankProcessDate']);
			$ConPSE->setTransValue($result['TransValue']);
			$ConPSE->setReference1($result['Reference1']);
			$ConPSE->setFIName($result['BankName']);
			$ConPSE->setTrazabilityCode($result['TrazabilityCode']);
        	
			$ConPSE->conectar($database_sala);
        	$ConPSE->verRecibo();
		}
		else 
		{
			// Display the result
			//echo '<h2>Result</h2><pre>';
			//$ConPSE->setstrMensaje("Ha ocurrido un fallo en la transacción.");
			$ConPSE = new DB_mysql;
			$ConPSE->conectar($database_sala);
			  
			$ConPSE->setstrMensaje($ConPSE->getReturnCodeDesc($result['TranState']));
			
			$query_selestadoprematricula = "select p.codigoestadoprematricula 
			from prematricula p, detalleprematricula d
			WHERE d.numeroordenpago = '".$result['Reference1']."'
			and d.idprematricula = p.idprematricula";
			$selestadoprematricula=mysql_db_query($database_sala,$query_selestadoprematricula) or die("$query_selestadoprematricula".mysql_error());
			$totalRows_selestadoprematricula = mysql_num_rows($selestadoprematricula);	
			$row_selestadoprematricula = mysql_fetch_array($selestadoprematricula);
			$digitoprematricula = ereg_replace("^[0-9]{1,1}","",$row_selestadoprematricula['codigoestadoprematricula']);
			
			// Como la transaccion fallo vuelve y deja la orden lista para ser pagada  
			$ConPSE->updateEstadoOrdenPrematicula($result['Reference1'],$digitoprematricula);
			$ConPSE->consulta($ConPSE->getstrConsulta());
			
			// Luego modifico en el Log
			$query_updlog = "UPDATE LogPagos 
			SET StaCode='".$result['TranState']."'
			WHERE Reference1 = '".$result['Reference1']."'
			and TicketId = '".$_GET['t']."'";
			$updlog=mysql_db_query($database_sala,$query_updlog) or die("$query_updlog".mysql_error());
			
			$query_ordenpago = "UPDATE ordenpago
			set codigoestadoordenpago = 1".$digitoorden."
			where numeroordenpago = '".$result['Reference1']."'";
			// echo $query_ordenpago;
			$ordenpago=mysql_db_query($database_sala,$query_ordenpago) or die("$query_ordenpago".mysql_error());
		
			$ConPSE->setReference2($row_selestadoorden['numerodocumento']);
			$ConPSE->setnombreEstudiante($row_selestadoorden['nombre']);
			$ConPSE->setBankProcessDate($result['BankProcessDate']);
			$ConPSE->setTransValue($result['TransValue']);
			$ConPSE->setReference1($result['Reference1']);
			$ConPSE->setFIName($result['BankName']);
			$ConPSE->setTrazabilityCode($result['TrazabilityCode']);
		 
		 	$ConPSE->verRecibo();
		
			//require('../serviciosacademicospse/consulta/prematricula/ticket.php');
			//print_r($result);
		
			//		echo '</pre>';
        }
	}
}
//echo '<h2>Proxy Debug</h2><pre>' . htmlspecialchars($proxy->debug_str, ENT_QUOTES) . '</pre>';
//echo '<h2>Client Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';*/

?>
