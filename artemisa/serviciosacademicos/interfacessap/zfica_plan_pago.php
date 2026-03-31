<?php
	require('../Connections/sala2.php');
	mysql_select_db($database_sala, $sala);
	/* echo $_GET['CREA'],"crea<br>";
	echo $_GET['aufnr'],"orden<br>";
	echo $_GET['GARANTIA'],"garantia<br>"; */
	//$_GET['aufnr'] = $_GET['parametro'];
	//  http://172.16.7.109/calidad/desarrollo/serviciosacademicos/interfacessap/zfica_plan_pago.php?aufnr=$1  //Este pedazo de codigo se coloca en sala2
	$query_estadoconexionexterna = "select e.codigoestadoconexionexterna, e.nombreestadoconexionexterna,hostestadoconexionexterna,numerosistemaestadoconexionexterna,
	mandanteestadoconexionexterna,usuarioestadoconexionexterna,passwordestadoconexionexterna
	from estadoconexionexterna e
	where e.codigoestado like '1%'";
	//echo $query_estadoconexionexterna;
	$estadoconexionexterna = mysql_query($query_estadoconexionexterna,$sala) or die("$query_estadoconexionexterna<br>".mysql_error());
	$totalRows_estadoconexionexterna = mysql_num_rows($estadoconexionexterna);
	$row_estadoconexionexterna = mysql_fetch_array($estadoconexionexterna);
    //echo $_GET['aufnr'],"orden<br>";
	$host     = $row_estadoconexionexterna['hostestadoconexionexterna'];
    $sistema  = $row_estadoconexionexterna['numerosistemaestadoconexionexterna'];
	$mandante = $row_estadoconexionexterna['mandanteestadoconexionexterna'];
	$usuario  = $row_estadoconexionexterna['usuarioestadoconexionexterna'];
	$clave    = $row_estadoconexionexterna['passwordestadoconexionexterna'];

	$login = array (                       // Set login data to R/3
            "ASHOST"  =>"$host",           // application server host name
            "SYSNR"   =>"$sistema",        // system number
            "CLIENT"  =>"$mandante",       // client
            "USER"    =>"$usuario",        // user
            "PASSWD"  =>"$clave",          // Clave
			"CODEPAGE"=>"1100");           // codepage
           $rfc = saprfc_open($login);

	 $rfcfunction  = "ZFICA_REPORTAR_PLAN_PAGOS";
	 $entrego      = "F_AUFNR";
	 $resultstable = "SALIDA";
	 $rfchandle    = saprfc_function_discover($rfc, $rfcfunction);

	if(!$rfchandle)
	{
	  echo "We have failed to discover the function".saprfc_error($rfc);
	 // exit(1);
	}
	// traigo la tabla interna de SAP
	saprfc_table_init($rfchandle,$resultstable);
	// importo el numero de documento a consultar

	$orden = $_GET['aufnr'];
	//echo $orden;
	//$orden = '000001047108';
	saprfc_import($rfchandle,$entrego,$orden);
	$rfcresults = saprfc_call_and_receive($rfchandle);
    $numrows = saprfc_table_rows($rfchandle,$resultstable);

 	 for ($i=1; $i <= $numrows; $i++)
	 {
	  $tabla[$i] = saprfc_table_read($rfchandle,$resultstable,$i);
	 }

   if ($tabla <> "")
	 {  // if 1
	  foreach ($tabla as $valortabla => $totaltabla)
	  { // foreach 1
	     foreach ($totaltabla as $valor1tabla => $total1tabla)
		  { // foreach 2
		    if ($valor1tabla == "DOCPP_SAP")
			 {
			   $numeroplan = $total1tabla;
			   echo $numeroplan,"<br>";
			 }
		    if ($valor1tabla == "DOCCC_SAP")
			 {
			   $documentocuentaxcobrarsap = $total1tabla;
      		   echo $documentocuentaxcobrarsap,"<br>";
			 }
		    if ($valor1tabla == "AUFNR")
			 {
			   $numeroordenpago = $total1tabla;
			   echo $numeroordenpago,"<br>";
			 }
		  } // foreach 2


   if ($_GET['CREA'] == '1')
	 {
		$insertSQL = "INSERT INTO ordenpagoplandepago (idordenpagoplandepago,fechaordenpagoplandepago,numerodocumentoplandepagosap,cuentaxcobrarplandepagosap,numerorodenpagoplandepagosap,numerorodencoutaplandepagosap,codigoestado,codigoindicadorprocesosap)";
        $insertSQL.= "VALUES ('0','".date("Y-m-d")."','$numeroplan','$documentocuentaxcobrarsap','$numeroordenpago','1','100','100')";
	   	$Result1 = mysql_query($insertSQL, $sala) or die("$insertSQL".mysql_error());
	 }

	 if ($_GET['ANULA'] == '1')
	 {
		$insertSQL = "update ordenpagoplandepago
		set codigoestado = '200'
	    where numerorodenpagoplandepagosap = '$numeroordenpago'";
	   	$Result1 = mysql_query($insertSQL, $sala) or die(mysql_error());
	 }

	if ($_GET['GARANTIA'] == '1')
	 {
		$insertSQL = "update ordenpagoplandepago
	    set codigoindicadorprocesosap	= '200'
	    where numerorodenpagoplandepagosap = '$numeroordenpago'";
	   	$Result1 = mysql_query($insertSQL, $sala) or die(mysql_error());
	 }

  } // foreach 1
} // if 1
echo "$insertSQL";
saprfc_close($rfc);
?>