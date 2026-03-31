<?php
session_start();
require_once('../../../../Connections/salap.php');
mysql_select_db($database_sala, $sala);
$codigocarrera = '610';
$codigoperiodo = '20052';
$semestreinicial = '1';
$query_semestre = "SELECT e.codigoestudiante, concat(e.apellidosestudiante,' ',e.nombresestudiante) as nombre, 
s.nombresituacioncarreraestudiante
FROM estudiante e, prematricula p, situacioncarreraestudiante s, ordenpago o
where e.codigocarrera = '$codigocarrera'
and e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
and p.codigoestudiante = e.codigoestudiante
and p.semestreprematricula = '$semestreinicial'
and (p.codigoestadoprematricula like '1%' or p.codigoestadoprematricula like '4%')
and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%')
and o.codigoestudiante = e.codigoestudiante
and p.codigoperiodo = '$codigoperiodo'
and o.codigoperiodo = p.codigoperiodo
order by 1";
//echo "<br>$query_semestre";
$semestre1 = mysql_query($query_semestre, $sala) or die(mysql_error());
$total_semestre = mysql_num_rows($semestre1);
// Si el estudiante tiene prematricula activa y alguna orden de pago activa le muestra los datos
if($total_semestre != "")
{
	while($row_semestre = mysql_fetch_assoc($semestre1))
	{
		// Para cada estudiante mirar las materias prematriculadas
		// Tomo un arreglo con las materias de la prematricula		
		$codigoestudiante = $row_semestre['codigoestudiante'];
		echo "<h1>$codigoestudiante</h1>";
		$query_premainicial1 = "SELECT d.codigomateria, d.codigomateriaelectiva
		FROM detalleprematricula d, prematricula p, materia m, estudiante e
		where d.codigomateria = m.codigomateria 
		and d.idprematricula = p.idprematricula
		and p.codigoestudiante = e.codigoestudiante
		and e.codigoestudiante = '$codigoestudiante'
		and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
		and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula = '23')
		and p.codigoperiodo = '$codigoperiodo'";
		//echo "$query_premainicial1<br>";
		$premainicial1=mysql_query($query_premainicial1, $sala) or die("$query_premainicial1");
		$totalRows_premainicial1 = mysql_num_rows($premainicial1);
		if($totalRows_premainicial1)
		{
			while($row_premainicial1 = mysql_fetch_array($premainicial1))
			{
				if($row_premainicial1['codigomateriaelectiva'] == "")
				{
					//echo "acad sin electiva<br>";
					$materiaselegidas1[] = $row_premainicial1['codigomateria'];
				}
				else
				{
					//echo "acad con electiva<br>";
					$materiaselegidas1[$row_premainicial1['codigomateriaelectiva']] = $row_premainicial1['codigomateria'];
				}
			}
		}
		foreach($materiaselegidas1 as $key => $value)
		{
			echo "$key => $value<br>";
		}
		
		// Si el estudiante tiene prematricula entra al if 
		if(isset($materiaselegidas))
		{
			// Para cada estudiante mirar la carga automática generada
			// Tomo un arreglo con las materias de la prematricula
			require("matriculaautomatica.php");
			foreach($materiascarga as $key => $value)
			{
				echo "$key => $value<br>";
			}
		}
		unset($materiascarga);
		unset($materiaselegidas1);
	}
}

?>