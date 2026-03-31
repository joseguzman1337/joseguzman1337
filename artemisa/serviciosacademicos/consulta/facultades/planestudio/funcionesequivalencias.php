<?php
is_file(dirname(__FILE__) ."/../../../utilidades/ValidarSesion.php")
    ? include_once(dirname(__FILE__) .'/../../../utilidades/ValidarSesion.php')
    : include_once(realpath(dirname(__FILE__) .'/../../../utilidades/ValidarSesion.php'));
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

if(!isset($_SESSION['MM_Username']) || empty($_SESSION['MM_Username'])) {
    session_start();
}

function eliminarequivalencias($codigomateria, $idplanestudio, $idlineaenfasis, $sala)
{
	// La correspondencia siempre va a ser uno a uno
	$query_selequivalencias = "select r.codigomateriareferenciaplanestudio, r.fechainicioreferenciaplanestudio, r.fechavencimientoreferenciaplanestudio
	from referenciaplanestudio r
	where r.idplanestudio = '$idplanestudio'
	and r.codigomateria = '$codigomateria'
	and r.idlineaenfasisplanestudio = '$idlineaenfasis'
	and r.codigotiporeferenciaplanestudio = '300'";
	$selequivalencias = mysql_query($query_selequivalencias, $sala) or die("$query_selequivalencias");
	$totalRows_selequivalencias = mysql_num_rows($selequivalencias);
	$row_selequivalencias = mysql_fetch_assoc($selequivalencias);
		
	$query_delreferenciaplanestudio = "DELETE FROM referenciaplanestudio 
	WHERE idplanestudio = '$idplanestudio'
	and idlineaenfasisplanestudio = '$idlineaenfasis'
	and codigomateria = '$codigomateria'
	and codigotiporeferenciaplanestudio like '3%'";
	$delreferenciaplanestudio = mysql_query($query_delreferenciaplanestudio, $sala) or die("$query_delreferenciaplanestudio");
	
	if($totalRows_selequivalencias != "")
	{
		$codigomateriaequivalente = $row_selequivalencias['codigomateriareferenciaplanestudio'];
		return eliminarequivalencias($codigomateriaequivalente, $idplanestudio, $idlineaenfasis, $sala);
	}
	else
	{
		return;
	}
}

function seleccionarequivalencias(&$Arregloequivalencias, $codigomateria, $idplanestudio, $idlineaenfasis, $sala)
{
	//echo "$codigomateria<br>";	
	// La correspondencia siempre va a ser uno a uno
	$query_selequivalencias = "select r.codigomateriareferenciaplanestudio, r.fechainicioreferenciaplanestudio, r.fechavencimientoreferenciaplanestudio
	from referenciaplanestudio r
	where r.idplanestudio = '$idplanestudio'
	and r.codigomateria = '$codigomateria'
	and r.idlineaenfasisplanestudio = '$idlineaenfasis'
	and r.codigotiporeferenciaplanestudio = '300'";
	//echo "$query_selequivalencias<br>";
	$selequivalencias = mysql_query($query_selequivalencias, $sala) or die("$query_selequivalencias");
	$totalRows_selequivalencias = mysql_num_rows($selequivalencias);
	$row_selequivalencias = mysql_fetch_assoc($selequivalencias);
	if($totalRows_selequivalencias != "")
	{
		$codigomateriaequivalente = $row_selequivalencias['codigomateriareferenciaplanestudio'];
		$Arregloequivalencias[] = $codigomateriaequivalente;
		return seleccionarequivalencias($Arregloequivalencias, $codigomateriaequivalente, $idplanestudio, $idlineaenfasis, $sala);
	}
	else
	{
		return;
	}
}
?>