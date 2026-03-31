<?php
function validacion_documentos($codigocarrera,$codigogenero,$codigoestudiante,$conexion){
	$query_documentos = "SELECT d.nombredocumentacion, d.iddocumentacion
from documentacion d,documentacionfacultad df
where d.iddocumentacion = df.iddocumentacion
and df.codigocarrera = '$codigocarrera'
and df.fechainiciodocumentacionfacultad <= '".date("Y-m-d")."'
and df.fechavencimientodocumentacionfacultad >= '".date("Y-m-d")."'
AND (df.codigogenerodocumento = '300' 
OR df.codigogenerodocumento = '$codigogenero')";
	//echo $query_documentos,"<br>";
	//exit();
	$documentos = mysql_query($query_documentos, $conexion) or die($query_documentos.mysql_error());
	$totalRows_documentos = mysql_num_rows($documentos);
	//echo $query_documentos;
	while($row_documentos = mysql_fetch_assoc($documentos))
	{
		// Selecciona los documentos para la facultad que posee un estudiante
		$query_documentosestudiante = "SELECT d.codigotipodocumentovencimiento
		FROM documentacionestudiante d,documentacionfacultad df,tipovencimientodocumento t
	    where d.codigoestudiante = '$codigoestudiante'
		and d.iddocumentacion = '".$row_documentos['iddocumentacion']."'
		AND d.codigotipodocumentovencimiento = '100' 
		and d.iddocumentacion = df.iddocumentacion
		AND d.codigotipodocumentovencimiento = t.codigotipovencimientodocumento";
		$documentosestudiante = mysql_query($query_documentosestudiante, $conexion) or die("$query_documentosestudiante".mysql_error());
		$totalRows_documentosestudiante = mysql_num_rows($documentosestudiante);
		$row_documentosestudiante = mysql_fetch_assoc($documentosestudiante);
		//echo $query_documentosestudiante;echo "<br>";
		//echo  $totalRows_documentosestudiante;
		//print_r($row_documentosestudiante); echo "<br>";

		if($totalRows_documentosestudiante == "")
		{
			$pendiente = true;
			return $pendiente;
		}
		else if($row_documentosestudiante['codigotipodocumentovencimiento'] == '100')
		{
			$pendiente = false;
			continue;
		}
		else
		{
			$pendiente = true;
			return $pendiente;
		}
		//echo $row_documentos['nombredocumentacion'];
		//echo "<br>";
		//echo $pendiente;
	}

}

?>