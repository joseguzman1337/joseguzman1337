<?php
/*****************************   VALIDACION DE CONEXION Y EXISTENCIA DE TABLA DE CENTROS DE BENEFICIO EN SAP **********/
function valida_centrobeneficio($rfc)
{
	if($_REQUEST['codigomodalidadacademica'])
	{
		$codigomodalidadacademica=$_REQUEST['codigomodalidadacademica'];
	}
	elseif(isset($_GET['codigocarrera']) and $_GET['codigocarrera']!="")
	{
		if(!$_REQUEST['codigomodalidadacademica'])
		{
			$query="";
			$carrera=new ADODB_Active_Record('carrera');
			$carrera->Load("codigocarrera='".$_GET['codigocarrera']."'");
			//echo $carrera->codigomodalidadacademica;
			$codigomodalidadacademica=$carrera->codigomodalidadacademica;
		}
		else
		{
			$codigomodalidadacademica=$_REQUEST['codigomodalidadacademica'];
		}
	}
	{
		$rfcfunction = "ZFICA_CENTROS_BENEF";
		$resultstable = "T_CEBE";
		$entrego = "MODAC";
		$modac = $codigomodalidadacademica;
		$rfchandle = saprfc_function_discover($rfc, $rfcfunction);
		// traigo la tabla interna de SAP
		saprfc_table_init($rfchandle,$resultstable);
		// importo parametro de entrada
		saprfc_import($rfchandle,$entrego,$modac);
		$rfcresults = saprfc_call_and_receive($rfchandle);
		$numrows = saprfc_table_rows($rfchandle,$resultstable);
		for ($i=1; $i <= $numrows; $i++)
		{
			$results[$i] = saprfc_table_read($rfchandle,$resultstable,$i);
		}
		//var_dump($results);
		if ($results <> "")
		{  // if 1
			foreach ($results as $valor => $total)
			{ // foreach 1
				foreach ($total as $valor1 => $total1)
				{ // foreach 2
					if ($valor1 == "PRCTR")
					{
						$codigocentrobeneficio = $total1;
						//echo $opprincipal,"<br>";
					}
					if ($valor1 == "LTEXT")
					{
						$nombrecentrobeneficio = $total1;
					}
				} // foreach 2
				$totalconceptos[] = array($codigocentrobeneficio,$nombrecentrobeneficio);
			} // foreach 1
		} // if 1
	}

	if(is_array($totalconceptos))
	{
		foreach ($totalconceptos as $valor => $total)
		{ // foreach 1
			$contador = 1;
			$codigosap = "";
			foreach ($total as $valor1 => $total1)
			{ // foreach 2
				if ($contador == 1)
				{
					$codigosap = $codigosap . $total1;
					$contador++;
				}
				else
				if ($contador == 2)
				{
					$codigosap = $codigosap. "-" . $total1;
					$contador++;
				}
			} // foreach 2
			$insertacodigo = explode("-", $codigosap);
			$valor=$insertacodigo[0];
			$name = explode("-", $_POST['codigocentrobeneficio']);
			$label=strtoupper($insertacodigo[0])."-".$insertacodigo[1];
			$array_combo_centrobeneficio[$contador_array]['etiqueta']=$label;
			$array_combo_centrobeneficio[$contador_array]['valor']=$valor;
			$contador_array++;
		}
		return $array_combo_centrobeneficio;
	}
}	/************************************************************************************************************/
?>