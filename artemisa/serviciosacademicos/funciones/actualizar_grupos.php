<?php 
function actualizargrupos($idgrupo, $codigoperiodo, $sala)
{
    $query_cupoelectiva = "select g.maximogrupoelectiva, m.codigomateria, g.maximogrupo, m.nombremateria, g.idgrupo, m.codigocarrera
	from grupo g, materia m
	where g.codigomateria = m.codigomateria
	and g.codigoperiodo = '$codigoperiodo'
	and g.maximogrupoelectiva > 0
	and g.idgrupo = '$idgrupo'";
	$cupoelectiva = mysql_query($query_cupoelectiva, $sala) or die(mysql_error());
	$row_cupoelectiva = mysql_fetch_assoc($cupoelectiva);
	$totalRows_cupoelectiva = mysql_num_rows($cupoelectiva);
    
	$codigocarrera = $row_cupoelectiva['codigocarrera'];
	
	if ($totalRows_cupoelectiva == "")
	 {
	    $query_actualizar = "SELECT COUNT(d.idgrupo) AS matriculados
		FROM detalleprematricula d, estudiante e, prematricula p
		WHERE (d.codigoestadodetalleprematricula LIKE '1%' OR d.codigoestadodetalleprematricula LIKE '3%')
		and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
		and p.idprematricula = d.idprematricula
		and p.codigoestudiante = e.codigoestudiante		
		AND d.idgrupo = '$idgrupo'
		and p.codigoperiodo = '$codigoperiodo'";
		$actualizar = mysql_query($query_actualizar, $sala) or die(mysql_error());
		$totalRows_actualizar = mysql_num_rows($actualizar);
		$row_actualizar = mysql_fetch_assoc($actualizar);
		$matriculados = $row_actualizar['matriculados'];
		
		$query_updgrupo="UPDATE grupo SET 
		matriculadosgrupo = '$matriculados'
		WHERE idgrupo = '$idgrupo'";
		//echo "<br> $query_updgrupo";
		$updgrupo = mysql_query($query_updgrupo, $sala) or die(mysql_error());
		
		$query_updgrupo="UPDATE grupo SET 
		matriculadosgrupoelectiva = '0'
		WHERE idgrupo = '$idgrupo'";
		//echo "<br> $query_updgrupo";
		$updgrupo = mysql_query($query_updgrupo, $sala) or die(mysql_error());
	 }
	else
	 {
	    $query_actualizar = "SELECT COUNT(d.idgrupo) AS matriculados
		FROM detalleprematricula d, estudiante e, prematricula p
		WHERE (d.codigoestadodetalleprematricula LIKE '1%' OR d.codigoestadodetalleprematricula LIKE '3%')
		and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
		and p.idprematricula = d.idprematricula
		and p.codigoestudiante = e.codigoestudiante		
		AND d.idgrupo = '$idgrupo'
		and p.codigoperiodo = '$codigoperiodo'";
		$actualizar = mysql_query($query_actualizar, $sala) or die(mysql_error());
		$totalRows_actualizar = mysql_num_rows($actualizar);
		$row_actualizar = mysql_fetch_assoc($actualizar);
		
		$matriculados = $row_actualizar['matriculados'];
		
		$query_actualizarcarrera = "SELECT COUNT(d.idgrupo) AS matriculadoscarrera
		FROM detalleprematricula d, estudiante e, prematricula p
		WHERE (d.codigoestadodetalleprematricula LIKE '1%' OR d.codigoestadodetalleprematricula LIKE '3%')
		and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
		and p.idprematricula = d.idprematricula
		and p.codigoestudiante = e.codigoestudiante		
		AND d.idgrupo = '$idgrupo'
		and p.codigoperiodo = '$codigoperiodo'
		and e.codigocarrera = '$codigocarrera'";
		$actualizarcarrera = mysql_query($query_actualizarcarrera, $sala) or die(mysql_error());
		$totalRows_actualizarcarrera = mysql_num_rows($actualizarcarrera);
		$row_actualizarcarrera = mysql_fetch_assoc($actualizarcarrera);
		//echo $query_actualizarcarrera;
		$matriculadoscarrera = $row_actualizarcarrera['matriculadoscarrera'];
	  
	    $query_updgrupo="UPDATE grupo SET 
		matriculadosgrupo = '$matriculadoscarrera'
		WHERE idgrupo = '$idgrupo'";
		//echo "<br> $query_updgrupo";
		$updgrupo = mysql_query($query_updgrupo, $sala) or die(mysql_error());
	  
	    $matriculadoscarreradiferencia = $matriculados - $matriculadoscarrera;
		
	    $query_updgrupo="UPDATE grupo SET 
		matriculadosgrupoelectiva = '$matriculadoscarreradiferencia'
		WHERE idgrupo = '$idgrupo'";
		//echo "<br> $query_updgrupo";
		$updgrupo = mysql_query($query_updgrupo, $sala) or die(mysql_error());
	  
	 }
}

?>