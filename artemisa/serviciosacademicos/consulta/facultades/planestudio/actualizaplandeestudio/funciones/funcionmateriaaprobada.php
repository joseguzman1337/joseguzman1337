<?php
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
// Esta funcion recibe el estudiante, la materia que se quiere verificar, el plan de estudios donde se encuentra la materia y la base de datos.
function materiaaprobada($codigoestudiante, $codigomateria, $idplanestudio, $reprobada, $objetobase)
{
	//if($codigomateria==739)
//				echo "<br>Entro 739";

	$query_materianota = "SELECT n.codigomateria, n.notadefinitiva, m.notaminimaaprobatoria, n.codigoperiodo
	FROM notahistorico n, materia m
	WHERE n.codigoestudiante = '$codigoestudiante'
	AND m.codigomateria = n.codigomateria
	AND (n.codigomateria = '$codigomateria' OR n.codigomateriaelectiva = '$codigomateria')
	and n.codigoestadonotahistorico like '1%'
	ORDER BY 4 ";
	//echo "$query_materianota<br>";
	$materianota=$objetobase->conexion->query($query_materianota) or die("$query_materianota");
	$totalRows_materianota = $materianota->RecordCount();
	// Entra si la materia tienen nota historica para este estudiante
	// Sino busca la materia equivalente
	if($totalRows_materianota != "")
	{
		while($row_materianota = $materianota->FetchRow())
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
	//if($codigomateria==739)
		//echo "$query_materiaequivalente<br>";
	$materiaequivalente=$objetobase->conexion->query($query_materiaequivalente) or die("$query_materiaequivalente");
	$totalRows_materiaequivalente = $materiaequivalente->RecordCount();
	// Si tiene materia equivalente entra a hacer lo mismo, es decir a mirar si la equivalente esta aprobada
	// Para el sigiente plan de estudios de la carrera donde aparezca esta materia
	// Sino retorna falso
	if($totalRows_materiaequivalente != "")
	{
		while($row_materiaequivalente = $materiaequivalente->FetchRow())
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

			//echo "$query_materianota<br>";
			$materianota=$objetobase->conexion->query($query_materianota) or die("$query_materianota");
			$totalRows_materianota = $materianota->RecordCount();
			// Entra si la materia tienen nota historica para este estudiante
			// Sino busca la materia equivalente
			if($totalRows_materianota != "")
			{
				while($row_materianota = $materianota->FetchRow())
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