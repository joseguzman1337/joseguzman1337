<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
function pasaranotahistorico($idnotahistorico, $sala)
{
	// 1. Toma la nota de tmpnotahistorico y la inserta a notahistorico
	$query_seltmpnotahistorico = "SELECT idnotahistorico, codigoperiodo, codigomateria, codigomateriaelectiva, 
	codigoestudiante, notadefinitiva, codigotiponotahistorico, origennotahistorico, fechaprocesonotahistorico, 
	idgrupo, idplanestudio, idlineaenfasisplanestudio, observacionnotahistorico, codigoestadonotahistorico, 
	codigotipomateria, idusuario, ip, indicadorcargareal 
	FROM tmpnotahistorico
	where idnotahistorico = '$idnotahistorico'";
	//echo "<h3>$query_seltmpnotahistorico</h3>";
	$seltmpnotahistorico = mysql_query($query_seltmpnotahistorico, $sala) or die("$query_seltmpnotahistorico".mysql_error());
	$totalRows_seltmpnotahistorico = mysql_num_rows($seltmpnotahistorico);
	$row_seltmpnotahistorico = mysql_fetch_assoc($seltmpnotahistorico);
	
	$codigoperiodo = $row_seltmpnotahistorico['codigoperiodo'];
	$codigomateria = $row_seltmpnotahistorico['codigomateria'];
	$codigomateriaelectiva = $row_seltmpnotahistorico['codigomateriaelectiva'];
	$codigoestudiante = $row_seltmpnotahistorico['codigoestudiante'];
	$notadefinitiva = $row_seltmpnotahistorico['notadefinitiva'];
	$codigotiponotahistorico = $row_seltmpnotahistorico['codigotiponotahistorico'];
	$origennotahistorico = $row_seltmpnotahistorico['origennotahistorico'];
	$fechaprocesonotahistorico = $row_seltmpnotahistorico['fechaprocesonotahistorico'];
	$idgrupo = $row_seltmpnotahistorico['idgrupo'];
	$idplanestudio = $row_seltmpnotahistorico['idplanestudio'];
	$idlineaenfasisplanestudio = $row_seltmpnotahistorico['idlineaenfasisplanestudio'];
	$observacionnotahistorico = $row_seltmpnotahistorico['observacionnotahistorico'];
	$codigoestadonotahistorico = $row_seltmpnotahistorico['codigoestadonotahistorico'];
	$codigotipomateria = $row_seltmpnotahistorico['codigotipomateria'];
	
	$query_insnotahistorico = "INSERT INTO notahistorico(idnotahistorico, codigoperiodo, codigomateria, codigomateriaelectiva, codigoestudiante, notadefinitiva, codigotiponotahistorico, origennotahistorico, fechaprocesonotahistorico, idgrupo, idplanestudio, idlineaenfasisplanestudio, observacionnotahistorico, codigoestadonotahistorico, codigotipomateria) 
    VALUES(0, '$codigoperiodo', '$codigomateria', '$codigomateriaelectiva', '$codigoestudiante', '$notadefinitiva', '$codigotiponotahistorico', '$origennotahistorico', '$fechaprocesonotahistorico', '$idgrupo', '$idplanestudio', '$idlineaenfasisplanestudio', '$observacionnotahistorico', '$codigoestadonotahistorico', '$codigotipomateria')";
	//echo "<h3>$query_insnotahistorico</h3>";
	$insnotahistorico = mysql_query($query_insnotahistorico, $sala) or die("$query_insnotahistorico".mysql_error());
	$idnotahistoricoreal = mysql_insert_id();
	
	// Pasa el indicador del registro a 100
	$query_updtmpnotahistorico = "UPDATE tmpnotahistorico 
    SET indicadorcargareal='100', idnotahistoricoreal='$idnotahistoricoreal'
    WHERE idnotahistorico = '$idnotahistorico'";
	//echo "<h3>$query_updtmpnotahistorico</h3>";
	$updtmpnotahistorico = mysql_query($query_updtmpnotahistorico, $sala) or die("$query_updtmpnotahistorico".mysql_error());
	
	// 2. Toma el lugar de tmplugarorigennota y lo pasa a lugarorigennota
	$query_seltmplugarorigennota = "SELECT l.idlugarorigennota, l.nombrelugarorigennota, l.direccionlugarorigennota, 
	l.telefonolugarorigennota, l.emaillugarorigennota, l.contactolugarorigennota, l.fechainiciolugarorigennota, 
	l.fechafinallugarorigennota, l.idtipolugarorigennota, l.indicadorcargareal, l.idlugarorigennotareal
    FROM tmplugarorigennota l, tmpnotahistorico n, tmprotacionnotahistorico r
	where n.idnotahistorico = '$idnotahistorico'
	and r.idnotahistorico = n.idnotahistorico
	and l.idlugarorigennota = r.idlugarorigennota";
	//echo "<h3>$query_seltmplugarorigennota</h3>";
	$seltmplugarorigennota = mysql_query($query_seltmplugarorigennota, $sala) or die("$query_seltmplugarorigennota".mysql_error());
	$totalRows_seltmplugarorigennota = mysql_num_rows($seltmplugarorigennota);
	while($row_seltmplugarorigennota = mysql_fetch_assoc($seltmplugarorigennota))
	{
		$idlugarorigennota = $row_seltmplugarorigennota['idlugarorigennota'];
		$nombrelugarorigennota = $row_seltmplugarorigennota['nombrelugarorigennota'];
		$direccionlugarorigennota = $row_seltmplugarorigennota['direccionlugarorigennota'];
		$telefonolugarorigennota = $row_seltmplugarorigennota['telefonolugarorigennota'];
		$emaillugarorigennota = $row_seltmplugarorigennota['emaillugarorigennota'];
		$contactolugarorigennota = $row_seltmplugarorigennota['contactolugarorigennota'];
		$fechainiciolugarorigennota = $row_seltmplugarorigennota['fechainiciolugarorigennota'];
		$fechafinallugarorigennota = $row_seltmplugarorigennota['fechafinallugarorigennota'];
		$idtipolugarorigennota = $row_seltmplugarorigennota['idtipolugarorigennota'];
			
		if($row_seltmplugarorigennota['indicadorcargareal'] == "200")
		{
			// Debe insertar los datos del lugar, y la rotación
			$query_inslugarorigennota = "INSERT INTO lugarorigennota(idlugarorigennota, nombrelugarorigennota, direccionlugarorigennota, telefonolugarorigennota, emaillugarorigennota, contactolugarorigennota, fechainiciolugarorigennota, fechafinallugarorigennota, idtipolugarorigennota) 
			VALUES(0, '$nombrelugarorigennota', '$direccionlugarorigennota', '$telefonolugarorigennota', '$emaillugarorigennota', '$contactolugarorigennota', '$fechainiciolugarorigennota', '$fechafinallugarorigennota', '$idtipolugarorigennota')";
			//echo "<h3>$query_inslugarorigennota</h3>";
			$inslugarorigennota = mysql_query($query_inslugarorigennota, $sala) or die("$query_inslugarorigennota".mysql_error());
			$idlugarorigennotareal = mysql_insert_id();
		}
		if($row_seltmplugarorigennota['indicadorcargareal'] == "100")
		{
			// Debe traer los datos del lugar real
			$idlugarorigennotareal = $row_seltmplugarorigennota['idlugarorigennotareal'];
		}
	
		// Pasa el indicador del registro a 100
		$query_updtmplugarorigennota = "UPDATE tmplugarorigennota 
		SET indicadorcargareal='100', idlugarorigennotareal='$idlugarorigennotareal'
		WHERE idlugarorigennota = '$idlugarorigennota'";
		//echo "<h3>$query_updtmplugarorigennota</h3>";
		$updtmplugarorigennota = mysql_query($query_updtmplugarorigennota, $sala) or die("$query_updtmplugarorigennota".mysql_error());
		
		$query_insrotacionnotahistorico = "INSERT INTO rotacionnotahistorico(idrotacionnotahistorico, idnotahistorico, idlugarorigennota) 
		VALUES(0, '$idnotahistoricoreal', '$idlugarorigennotareal')";
		//echo "<h3>$query_insrotacionnotahistorico</h3>";
		$insrotacionnotahistorico = mysql_query($query_insrotacionnotahistorico, $sala) or die("$query_insrotacionnotahistorico".mysql_error());
	}
}
?>