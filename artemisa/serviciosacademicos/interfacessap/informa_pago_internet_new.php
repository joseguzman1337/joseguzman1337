<?php
$numeroordenpago = $_GET['numeroordenpago']; 
$ruta="../";

	require_once($ruta.'consulta/generacionclaves.php');
	require($ruta.'Connections/sala2.php');
    mysql_select_db($database_sala, $sala);  
    require($ruta.'Connections/sap.php');
	require($ruta.'funciones/cambia_fecha_sap.php');	
	
	$query_estadoconexionexterna = "select e.codigoestadoconexionexterna, e.nombreestadoconexionexterna, e.codigoestado, 
    e.hostestadoconexionexterna, e.numerosistemaestadoconexionexterna, e.mandanteestadoconexionexterna, 
    e.usuarioestadoconexionexterna, e.passwordestadoconexionexterna
    from estadoconexionexterna e
    where e.codigoestado like '1%'";
    //and dop.codigoconcepto = '151'
   //echo "sdas $query_ordenes<br>";
   $estadoconexionexterna = mysql_query($query_estadoconexionexterna,$sala) or die("$query_estadoconexionexterna<br>".mysql_error());     
   $totalRows_estadoconexionexterna = mysql_num_rows($estadoconexionexterna);
   $row_estadoconexionexterna = mysql_fetch_array($estadoconexionexterna);
	
	if(ereg("^1.+$",$row_estadoconexionexterna['codigoestadoconexionexterna']))
	{
		$login = array (                              // Set login data to R/3 
		"ASHOST"=>$row_estadoconexionexterna['hostestadoconexionexterna'],           	// application server host name 
		"SYSNR"=>$row_estadoconexionexterna['numerosistemaestadoconexionexterna'],      // system number 
		"CLIENT"=>$row_estadoconexionexterna['mandanteestadoconexionexterna'],          // client 
		"USER"=>$row_estadoconexionexterna['usuarioestadoconexionexterna'],             // user 
		"PASSWD"=>$row_estadoconexionexterna['passwordestadoconexionexterna'],			// password
		"CODEPAGE"=>"1100");              												// codepage  
	
		$rfc = saprfc_open($login);
		if(!$rfc) 
		{
			// We have failed to connect to the SAP server
			//echo "<br><br>Failed to connect to the SAP server".saprfc_error();
			//exit(1);
		}
	}
   
	
	$rfcfunction = "ZFICA_PAGOS_PSE_CREAR";
	$resultstable = "TPAGOS"; 
	$rfchandle = saprfc_function_discover($rfc, $rfcfunction);
	unset($numrows);
	unset($tabla);
	//echo $row_estadoconexionexterna['mandanteestadoconexionexterna'],"<br>",$hostname_sala;
	//$contador =0;
	if(!$rfchandle )
	{
		// We have failed to discover the function
		echo "We have failed to discover the function" . saprfc_error($rfc);
		//exit(1);
	}
	else
	{ 		
	//$numeroordenpago = '1024051';	
	echo "<br>Numero00000000000000000"   .$numeroordenpago."<br>";
	//CREA CUENTA CORREO
	$objetoclaveusuario=new GeneraClaveUsuario($numeroordenpago,$salaobjecttmp);

	//do{	
	saprfc_import ($rfchandle,"AUFNR",$numeroordenpago);	
	$rfcresult = saprfc_call_and_receive($rfchandle);
   // print_r($rfcresult);
	//echo "<br>";
	$numrows = saprfc_table_rows($rfchandle,$resultstable);
 	// echo $numrows,"numero";
	 for ($i=1; $i <= $numrows; $i++)
	 {
	  $tabla[$i] = saprfc_table_read($rfchandle,$resultstable,$i);
	 }	
   // print_r($tabla);
    $respuesta = saprfc_export($rfchandle,"MENSAJE");
  //  echo "rta".$respuesta;

if ($tabla <> "")
 {  // if 1 	 
	  foreach ($tabla as $valortabla => $totaltabla)
	  { // foreach 1
	     foreach ($totaltabla as $valor1tabla => $total1tabla) 
		  { // foreach 2
		    if ($valor1tabla == "AUFNR") 
			 {
			   $numeroordenpago = $total1tabla;
			   echo $orden,"<br>";
			 }
		    if ($valor1tabla == "FECHA")
			 {
			   $fechapagosapordenpago = cambiaf_a_sala($total1tabla);
		       echo $fechapago,"<br>";
			 }	  
		    if ($valor1tabla == "CXCOB")
			 {
			   $documentocuentaxcobrarsap = $total1tabla;
			  echo $cuenta,"<br>";
			 }	 
			 if ($valor1tabla == "RCAJA")
			 {
  		      $documentocuentacompensacionsap = $total1tabla;
 		      echo $recibo,"<br>";
			 }	   
		  } // foreach 2
  

		    $query_ordenpago = "UPDATE ordenpago
			set documentocuentaxcobrarsap = '$documentocuentaxcobrarsap',
			documentocuentacompensacionsap = '$documentocuentacompensacionsap',
			fechapagosapordenpago = '$fechapagosapordenpago'
			where numeroordenpago = '$numeroordenpago'";
		    echo $query_ordenpago,"aca";
			$ordenpago=mysql_db_query($database_sala,$query_ordenpago) or die("$query_ordenpago".mysql_error()); 
     } // foreach 1
 }

//}while(!isset($tabla)); 
}
//echo "salio";
//exit();
echo "<pre>$numeroordenpago TABLA: ";
print_r($tabla);
echo "</pre>";
?>
OK