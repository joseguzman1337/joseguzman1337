<?php 
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
     require_once('../../Connections/sala2.php');
     mysql_select_db($database_sala, $sala);	     
	 $ruta = "../../funciones/";
	 require('../../funciones/ordenpago/claseordenpago.php');      
	 //session_start();	
	 
	 $query_selperiodo = "select p.codigoperiodo, e.codigoestadoperiodo
 	 from periodo p, estadoperiodo e
 	 where p.codigoestadoperiodo = e.codigoestadoperiodo
	 and e.codigoestadoperiodo = '3'";					
	 $selperiodo = mysql_query($query_selperiodo, $sala) or die("$query_selperiodo");
	 $totalRows_selperiodo=mysql_num_rows($selperiodo);	
	 $row_selperiodo=mysql_fetch_array($selperiodo);
   
   if (! $row_selperiodo)
    {
	 $query_selperiodo = "select p.codigoperiodo, e.codigoestadoperiodo
 	 from periodo p, estadoperiodo e
 	 where p.codigoestadoperiodo = e.codigoestadoperiodo
	 and e.codigoestadoperiodo = '1'";					
	$selperiodo = mysql_query($query_selperiodo, $sala) or die("$query_selperiodo");
	$totalRows_selperiodo=mysql_num_rows($selperiodo);	
	$row_selperiodo=mysql_fetch_array($selperiodo);
	}
   
   
   $codigoestudiante = $_GET['codigoestudiante'];
   $codigoperiodo = $row_selperiodo['codigoperiodo'];
   $documentosapordenpago = $_GET['registro'];
   $codigoconcepto = $_GET['concepto']; 
   $valorconcepto =  $_GET['valor']; 
   $codigotipodetalle = '2';
   $fechadetallefechafinanciera = $_GET['fecha']; 
   $totalconrecargo = $_GET['valor']; 
  
  /* $tmp = stripslashes($valorconcepto); 
   $tmp = urldecode($tmp); 
   $valorconcepto = unserialize($tmp); */
   
   $nuevaorden = new Ordenpago($sala, $codigoestudiante, $codigoperiodo, $numeroordenpago=0, $idprematricula=1, $fechaentregaordenpago='', $codigoestadoordenpago=10, $codigoimprimeordenpago='01', $observacionordenpago='', $codigocopiaordenpago=100, $documentosapordenpago, $idsubperiodo=1, $documentocuentaxcobrarsap='', $documentocuentacompensacionsap='', $fechapagosapordenpago='');
   $nuevaorden->crear_ordenpago_porconcepto($codigoconcepto, $valorconcepto, $codigotipodetalle, $fechadetallefechafinanciera, $porcentajedetallefechafinanciera=0, $totalconrecargo);
  // $nuevaorden-> crear_ordenpago_estadodecuenta($valorconcepto, $codigotipodetalle, $fechadetallefechafinanciera, $porcentajedetallefechafinanciera, $totalconrecargo);
   echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=estado_cuenta.php'>";   
 ?>   
