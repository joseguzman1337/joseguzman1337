<?php

/* La funcion recibe el idgrupo y el codigoperiodo para actualizar el numero de matriculados 
en un grupo para un periodo que se quiere actualizar */
function actualizarmatriculados($idgrupo, $codigoperiodo, $codigocarrera, $sala)
{
	// Toca mirar si el grupo tiene cupo como electiva
	
	// Cuenta todos los detallesprematriculas que pertenecen a un grupo
	// Debe contar los inscritos en electivas aparte y los inscritos en grupo fijo aparte 
	
	// Mira si el grupo tiene cupo para electivas o Mira si el grupo pertenece a la carrera
	// Si se cumple una de las dos condiciones deja igual
	// Sino modifica
	$query_cupoelectiva = "select g.maximogrupoelectiva, m.codigomateria, g.maximogrupo, m.nombremateria, g.idgrupo, m.codigocarrera
	from grupo g, materia m
	where g.codigomateria = m.codigomateria
	and g.codigoperiodo = '$codigoperiodo'
	and g.maximogrupoelectiva > 0
	and g.idgrupo = '$idgrupo'";
	$cupoelectiva = mysql_query($query_cupoelectiva, $sala) or die(mysql_error());
	$totalRows_cupoelectiva = mysql_num_rows($cupoelectiva);
	if($totalRows_cupoelectiva == "")
	{
		$query_actualizar = "SELECT COUNT(d.idgrupo) AS matriculados
		FROM detalleprematricula d, estudiante e, prematricula p
		WHERE (d.codigoestadodetalleprematricula LIKE '1%' OR d.codigoestadodetalleprematricula LIKE '3%')
		and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
		and p.idprematricula = d.idprematricula
		and p.codigoestudiante = e.codigoestudiante
		and e.codigosituacioncarreraestudiante not like '1%'
		and e.codigosituacioncarreraestudiante not like '5%'
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
	}
	else
	{
		//echo "<br>Hay maximo grupo electiva<br>";
		$row_cupoelectiva = mysql_fetch_assoc($cupoelectiva);
		// Si la carrera es la misma para en la que se encuentra el estudiante
		// Adiciona el cupo en maximocupogrupo tomando solamente los estudiantes de la carrera
		// echo $row_cupoelectiva['codigocarrera']."== $codigocarrera <br>";
		if($row_cupoelectiva['codigocarrera'] == $codigocarrera)
		{
			$query_actualizar = "SELECT COUNT(d.idgrupo) AS matriculados
			FROM detalleprematricula d, estudiante e, prematricula p
			WHERE (d.codigoestadodetalleprematricula LIKE '1%' OR d.codigoestadodetalleprematricula LIKE '3%')
			and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
			and p.idprematricula = d.idprematricula
			and p.codigoestudiante = e.codigoestudiante
			and e.codigosituacioncarreraestudiante not like '1%'
			and e.codigosituacioncarreraestudiante not like '5%'
			AND d.idgrupo = '$idgrupo'
			and p.codigoperiodo = '$codigoperiodo'
			and e.codigocarrera = '$codigocarrera'";
			$actualizar = mysql_query($query_actualizar, $sala) or die(mysql_error());
			$totalRows_actualizar = mysql_num_rows($actualizar);
			$row_actualizar = mysql_fetch_assoc($actualizar);
			$matriculados = $row_actualizar['matriculados'];
			
			$query_updgrupo="UPDATE grupo SET 
			matriculadosgrupo = '$matriculados'
			WHERE idgrupo = '$idgrupo'";
			//echo "<br> $query_updgrupo";
			$updgrupo = mysql_query($query_updgrupo, $sala) or die(mysql_error());
		}
		else
		{
			// Actualiza el maximogrupoelectiva
			$query_actualizar = "SELECT COUNT(d.idgrupo) AS matriculados
			FROM detalleprematricula d, estudiante e, prematricula p
			WHERE (d.codigoestadodetalleprematricula LIKE '1%' OR d.codigoestadodetalleprematricula LIKE '3%')
			and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
			and p.idprematricula = d.idprematricula
			and p.codigoestudiante = e.codigoestudiante
			and e.codigosituacioncarreraestudiante not like '1%'
			and e.codigosituacioncarreraestudiante not like '5%'
			AND d.idgrupo = '$idgrupo'
			and p.codigoperiodo = '$codigoperiodo'
			and e.codigocarrera = '$codigocarrera'";
			$actualizar = mysql_query($query_actualizar, $sala) or die(mysql_error());
			$totalRows_actualizar = mysql_num_rows($actualizar);
			$row_actualizar = mysql_fetch_assoc($actualizar);
			$matriculados = $row_actualizar['matriculados'];
			
			$query_updgrupo="UPDATE grupo SET 
			matriculadosgrupoelectiva = '$matriculados'
			WHERE idgrupo = '$idgrupo'";
			//echo "<br> $query_updgrupo";
			$updgrupo = mysql_query($query_updgrupo, $sala) or die(mysql_error());
		}
	}
}
?>
