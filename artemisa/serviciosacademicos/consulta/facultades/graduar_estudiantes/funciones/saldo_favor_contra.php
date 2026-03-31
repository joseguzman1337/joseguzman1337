<?php 	 
function saldoencontra($codigoestudiante,$database_sala,$sala,$rfc,$login,$rfchandle)
{
	//echo $codigoestudiante;
	$debe=false;
	mysql_select_db($database_sala, $sala);
	unset($saldoafavor);
	unset($saldoencontra);

	$query_estadoconexionexterna = "select e.codigoestadoconexionexterna, e.nombreestadoconexionexterna,hostestadoconexionexterna,numerosistemaestadoconexionexterna,
		mandanteestadoconexionexterna,usuarioestadoconexionexterna,passwordestadoconexionexterna
		from estadoconexionexterna e
		where e.codigoestado like '1%'";
	$estadoconexionexterna = mysql_query($query_estadoconexionexterna,$sala) or die("$query_estadoconexionexterna<br>".mysql_error());
	$totalRows_estadoconexionexterna = mysql_num_rows($estadoconexionexterna);
	$row_estadoconexionexterna = mysql_fetch_array($estadoconexionexterna);
	//print_r($row_estadoconexionexterna);
	if(ereg("^1.+$",$row_estadoconexionexterna['codigoestadoconexionexterna']))
	{
		$host = $row_estadoconexionexterna['hostestadoconexionexterna'];
		$sistema = $row_estadoconexionexterna['numerosistemaestadoconexionexterna'];
		$mandante =  $row_estadoconexionexterna['mandanteestadoconexionexterna'];
		$usuario = $row_estadoconexionexterna['usuarioestadoconexionexterna'];
		$clave = $row_estadoconexionexterna['passwordestadoconexionexterna'];

		$login = array (                              // Set login data to R/3
		"ASHOST"=>"$host",             // application server host name
		"SYSNR"=>"$sistema",                     // system number
		"CLIENT"=>"$mandante",                    // client
		"USER"=>"$usuario",                  // user
		"PASSWD"=>"$clave",
		"CODEPAGE"=>"1100");              // codepage
		$rfc = saprfc_open($login);
		if(!$rfc)
		{
			// We have failed to connect to the SAP server
			//echo "<br><br>Failed to connect to the SAP server".saprfc_error();
			//exit(1);
		}

	}
	//echo $mandante;
	$query_dataestudiante = "SELECT *
       FROM estudiante e,estudiantegeneral eg 
       WHERE e.idestudiantegeneral = eg.idestudiantegeneral
   	   and e.codigoestudiante = '".$codigoestudiante."'";
	// echo $query_dataestudiante;
	$dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante".mysql_error());
	$row_dataestudiante = mysql_fetch_assoc($dataestudiante);
	$totalRows_dataestudiante = mysql_num_rows($dataestudiante);

	if ($row_dataestudiante <> "")
	{
		$numerodocumento = $row_dataestudiante['idestudiantegeneral'];
	}

	$rfcfunction = "ZFKK_OPEN_ITEMS_FOR_ACC_READ";
	$entrego = "I_GPART";
	$resultstable = "T_FKKOP";

	$rfc = saprfc_open($login);

	if(!$rfc)
	{
		// echo "Failed to connect to the SAP server".saprfc_error();
	}

	@$rfchandle = saprfc_function_discover($rfc, $rfcfunction);

	if(!$rfchandle)
	{
		// echo "We have failed to discover the function".saprfc_error($rfc);
	}
	// traigo la tabla interna de SAP
	@saprfc_table_init($rfchandle,$resultstable);
	// importo el numero de documento a consultar
	@saprfc_import($rfchandle,$entrego,$numerodocumento);

	@$rfcresults = saprfc_call_and_receive($rfchandle);

	$numrows = saprfc_table_rows($rfchandle,$resultstable);
	//echo $numrows;
	for ($i=1; $i <= $numrows; $i++)
	{
		$results[$i] = saprfc_table_read($rfchandle,$resultstable,$i);
	}

	if ($results <> "")
	{  // if 1


		foreach ($results as $valor => $total)
		{ // foreach 1
			foreach ($total as $valor1 => $total1)
			{ // foreach 2
				if ($valor1 == "HVORG")
				{
					$opprincipal = $total1;
					// echo $opprincipal,"<br>";
				}
				if ($valor1 == "TVORG")
				{
					$opparcial = $total1;
				}
				if ($valor1 == "FAEDN")
				{
					$fechavence =  $total1;
				}
				if ($valor1 == "BETRW")
				{
					$valor =  $total1;
				}
				if ($valor1 == "OPBEL")
				{
					$contabilizar =  $total1;
				}
				if ($valor1 == "PRCTR")
				{
					$cb =  $total1;
				}
			} // foreah 2

			$query_concepto = "SELECT *
		   FROM concepto 
		   WHERE cuentaoperacionprincipal = '$opprincipal'
		   and cuentaoperacionparcial = '$opparcial'";
			// echo $query_concepto,"<br>";
			$concepto = mysql_query($query_concepto, $sala) or die("$query_concepto".mysql_error());
			$row_concepto = mysql_fetch_assoc($concepto);
			$totalRows_concepto = mysql_num_rows($concepto);

			$codigocarrera = "";

			$query_carrera = "SELECT *
		   FROM carrera c
		   WHERE  c.codigocentrobeneficio = '$cb'
		   AND c.codigotipocosto = '100'";
			//echo $query_carrera;
			$carrera = mysql_query($query_carrera, $sala) or die("$query_carrera".mysql_error());
			$row_carrera = mysql_fetch_assoc($carrera);
			$totalRows_carrera = mysql_num_rows($carrera);

			if (! $row_carrera)
			{
				$query_carrera = "SELECT m.codigocarrera
			   FROM numeroordeninternasap n,grupo g,materia m
			   WHERE numeroordeninternasap = '$cb'
			   AND g.idgrupo = n.idgrupo
			   AND m.codigomateria = g.codigomateria";
				// echo $query_carrera;
				$carrera = mysql_query($query_carrera, $sala) or die("$query_carrera".mysql_error());
				$row_carrera = mysql_fetch_assoc($carrera);
				$totalRows_carrera = mysql_num_rows($carrera);
			}

			$codigocarrera = $row_carrera['codigocarrera'];

			if ($codigocarrera == "")
			{
				$codigocarrera = $row_dataestudiante['codigocarrera'];
			}

			$query_codigoestudiantecarrera = "SELECT *
		   FROM estudiante e, prematricula p
		   WHERE e.idestudiantegeneral = '".$row_dataestudiante['idestudiantegeneral']."'
		   AND e.codigocarrera = '$codigocarrera'
		   and p.codigoestudiante = e.codigoestudiante";
			//echo $query_codigoestudiantecarrera,"<br><br><br>";
			$codigoestudiantecarrera = mysql_query($query_codigoestudiantecarrera, $sala) or die("$query_codigoestudiantecarrera".mysql_error());
			$row_codigoestudiantecarrera = mysql_fetch_assoc($codigoestudiantecarrera);
			$totalRows_codigoestudiantecarrera = mysql_num_rows($codigoestudiantecarrera);

			$codigoestudiante =  $row_codigoestudiantecarrera['codigoestudiante'];



			if ($row_concepto <> "")
			{
				if ($row_concepto['codigoconcepto'] == '149' and $codigocarrera <> '98')
				{
					$row_concepto['codigoconcepto'] = '154';
				}
				// echo $row_concepto['codigoconcepto'],"-",$codigocarrera;
				if ($row_concepto['codigotipoconcepto'] == '02')
				{
					$saldoafavor[] = array($codigocarrera,$row_concepto['codigoconcepto'],$row_concepto['nombreconcepto'],$fechavence,$valor,$contabilizar,$codigoestudiante);
				}
				else
				if ($row_concepto['codigotipoconcepto'] == '01')
				{
					$saldoencontra[] = array($codigocarrera,$row_concepto['codigoconcepto'],$row_concepto['nombreconcepto'],$fechavence,$valor,$contabilizar,$codigoestudiante);
					//echo "debe";
					return true;
				}
		} // foreach 1
	} // if 1
}
}
	?>
