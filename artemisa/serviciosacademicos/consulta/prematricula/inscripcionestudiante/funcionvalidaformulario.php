<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
// Esta función retorna el porcentaje de diligenciación de un formulario 
// El cero indica que el campo no ha sido diligenciado
function valida_formulario($nombremodulo, $tabla_campos, $where, $db)
{
	$tablaini = 0;
	$strcampo = "";
	foreach($tabla_campos as $tabla => $campo)
	{
		foreach($campo as $nombrecampo => $diligenciado)
		{
			$strcampo = $strcampo."$nombrecampo, ";
		}
		$strcampo = ereg_replace(", $","",$strcampo);
		$querys[$tabla] = "select $strcampo from $tabla where ".$where[$tabla]."";
	}
	//print_r($querys);
	
	$cuentavacios = 0;
	$cuentacampos = 0;
	foreach($querys as $tabla => $query_seltabla)
	{
		$seltabla = $db->Execute($query_seltabla);
		$totalRows_seltabla = $seltabla->RecordCount();
		$row_seltabla = $seltabla->FetchRow();
		foreach($row_seltabla as $campo => $valor)
		{
			//echo "$campo => $valor<br>";
			if($valor != "" && $valor != "0")
			{
				//echo "<h3>$campo => $valor</h3>";
				$cuentallenos++;
			}
			$cuentacampos++;
		}
		$ratadiligenciada[$tabla] = $cuentallenos/$cuentacampos; 
	}
	$ratas = 0;
	foreach($ratadiligenciada as $tabla => $rata)
	{
		//echo "$tabla => $rata<br>";
		$ratas = $ratas + $rata;
	}
	//echo "$ratatotal[$nombremodulo]=$ratas/".count($ratadiligenciada)."";
	$ratatotal[$nombremodulo]=$ratas/count($ratadiligenciada);
	return $ratatotal;
}
?>