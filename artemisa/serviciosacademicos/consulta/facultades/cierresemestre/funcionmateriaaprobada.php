<?php
// Esta funcion recibe el estudiante, la materia que se quiere verificar, el plan de estudios donde se encuentra la materia y la base de datos.
function materiaaprobada($codigoestudiante, $codigomateria, $idplanestudio, $reprobada, $sala)
{
	$query_materianota = "SELECT n.codigomateria, n.notadefinitiva, m.notaminimaaprobatoria, n.codigoperiodo
	FROM notahistorico n, materia m
	WHERE n.codigoestudiante = '$codigoestudiante'
	AND m.codigomateria = n.codigomateria
	AND (n.codigomateria = '$codigomateria' OR n.codigomateriaelectiva = '$codigomateria')
	and n.codigoestadonotahistorico like '1%'
	ORDER BY 4 ";
	//echo "$query_materianota<br>";
	$materianota=mysql_query($query_materianota, $sala) or die("$query_materianota");
	$totalRows_materianota = mysql_num_rows($materianota);
	// Entra si la materia tienen nota historica para este estudiante
	// Sino busca la materia equivalente
	if($totalRows_materianota != "")
	{
		while($row_materianota = mysql_fetch_array($materianota))
		{
			// Si la nota es aprobada retorna verdadero
			if($row_materianota['notadefinitiva'] >= $row_materianota['notaminimaaprobatoria'])
			{
				$reprobada = false;
				return "aprobada";
			}
			else
			{
				$reprobada = true;
			}
		}
	}
	$query_materiaequivalente = "select r.idplanestudio, r.codigomateriareferenciaplanestudio
	from referenciaplanestudio r
	where r.idplanestudio = '$idplanestudio'
	and r.codigomateria = '$codigomateria'
	and r.codigotiporeferenciaplanestudio like '3%'";
	//echo "$query_materiaequivalente<br>";
	$materiaequivalente=mysql_query($query_materiaequivalente, $sala) or die("$query_materiaequivalente");
	$totalRows_materiaequivalente = mysql_num_rows($materiaequivalente);
	// Si tiene materia equivalente entra a hacer lo mismo, es decir a mirar si la equivalente esta aprobada
	// Para el sigiente plan de estudios de la carrera donde aparezca esta materia
	// Sino retorna falso
	if($totalRows_materiaequivalente != "")
	{
		while($row_materiaequivalente = mysql_fetch_array($materiaequivalente))
		{
			$codigoequivalente = $row_materiaequivalente['codigomateriareferenciaplanestudio'];
			$query_materianota = "SELECT n.codigomateria, n.notadefinitiva, m.notaminimaaprobatoria, n.codigoperiodo
			FROM notahistorico n, materia m
			WHERE n.codigoestudiante = '$codigoestudiante'
			AND m.codigomateria = n.codigomateria
			AND (n.codigomateria = '$codigoequivalente' OR n.codigomateriaelectiva = '$codigoequivalente')
			and n.codigoestadonotahistorico like '1%'
			ORDER BY 4 ";
			//echo "$query_materianota<br>";
			$materianota=mysql_query($query_materianota, $sala) or die("$query_materianota");
			$totalRows_materianota = mysql_num_rows($materianota);
			// Entra si la materia tienen nota historica para este estudiante
			// Sino busca la materia equivalente
			if($totalRows_materianota != "")
			{
				while($row_materianota = mysql_fetch_array($materianota))
				{
					// Si la nota es aprobada retorna verdadero
					if($row_materianota['notadefinitiva'] >= $row_materianota['notaminimaaprobatoria'])
					{
						$reprobada = false;
						return "aprobada";
					}
					else
					{
						$reprobada = true;
					}
				}
			}
		}
	}
	else
	{
		//$reprobada = false;
		return "porver";
	}
	if($reprobada)
	{
		return "reprobada";
	}
	else
	{
	//$reprobada = false;
		return "porver";
	}
}
?>