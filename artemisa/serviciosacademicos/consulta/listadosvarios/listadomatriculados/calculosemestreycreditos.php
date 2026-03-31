<?php
$query_selectdetalleprematricula = "SELECT d.*, m.*, tm.* 
FROM detalleprematricula d, materia m, tipomateria tm
WHERE d.idprematricula = '$idprematricula'
AND d.codigomateria = m.codigomateria 
AND (d.codigoestadodetalleprematricula LIKE '1%' OR d.codigoestadodetalleprematricula LIKE '3%') 
AND m.codigotipomateria = tm.codigotipomateria 
AND m.codigocarrera = '$codigocarrera'";
//echo "<br>$query_selectdetalleprematricula<br>";
$selectdetalleprematricula = mysql_query($query_selectdetalleprematricula, $sala) or die(mysql_error());
$totalRows_selectdetalleprematricula = mysql_num_rows($selectdetalleprematricula);
//echo "<br>$totalRows_selectdetalleprematricula<br>";
$creditos = 0;
$semestre = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0);
$entro = false;
$contadormateria = 1;
$calculosemestre = false;
if($totalRows_selectdetalleprematricula != "")
{
	while($row_selectdetalleprematricula = mysql_fetch_assoc($selectdetalleprematricula))
	{
		$idprematriculaactual = $row_selectdetalleprematricula['idprematricula'];
		$codigoperiodo = $row_selectdetalleprematricula['codigoperiodo'];
		$codigocarrera = $row_selectdetalleprematricula['codigocarrera'];
		$codigotipomateria = $row_selectdetalleprematricula['codigotipomateria'];
		$codigomateria = $row_selectdetalleprematricula['codigomateria'];
		$materiacreditos[$contadormateria] = $codigomateria;
		//$query_materia = "SELECT numerocreditos, semestre FROM materia m WHERE m.codigomateria = '$codigomateria' AND m.codigocarrera = '$codigocarrera'";
		//$res_materia = mysql_query($query_materia, $sala) or die(mysql_error());
		//$totalRows_materia = mysql_num_rows($res_materia);
		//$row_materia = mysql_fetch_assoc($res_materia);
		//$idgrupomateria = $row_materia['idgrupomateria'];
		$creditosmateria = $row_selectdetalleprematricula['numerocreditos'];
		//echo "CREDITOS: $creditos<br>";
		// Obligatoria y Propuesta 
		if($codigotipomateria <> '4')
		{
			// Toma todas las materias
			$creditos = $creditos + $creditosmateria;
			$semestre[$row_selectdetalleprematricula['semestre']] = $semestre[$row_selectdetalleprematricula['semestre']] + $creditosmateria;
			$calculosemestre = true;
		}
		// Electivas libres
		else if($codigotipomateria == '4')
		{
			$creditos = $creditos + $creditosmateria;
			$calculosemestre = true;
		}
		//echo "<br>$creditos<br>";
		$contadormateria++;
	}
	$query_faltantes = "SELECT d.* 
	FROM detalleprematricula d
	WHERE d.idprematricula = '$idprematricula'
	AND (d.codigoestadodetalleprematricula LIKE '1%' OR d.codigoestadodetalleprematricula LIKE '3%')";
	//echo "<br>$query_selectdetalleprematricula<br>";
	$faltantes = mysql_query($query_faltantes, $sala) or die(mysql_error());
	$totalRows_faltantes = mysql_num_rows($faltantes);
	$contador = 1;
	if($totalRows_selectdetalleprematricula != $totalRows_faltantes)
	{
		while($row_faltantes = mysql_fetch_assoc($faltantes))
		{
			$entro = false;
			foreach($materiacreditos as $key => $codigomate)
			{
				if($codigomate == $row_faltantes['codigomateria'])
					$entro = true;
			}
			if(!$entro)
				$materiaporfuera[] = $row_faltantes['codigomateria'];
		}
		if(isset($materiaporfuera))
		{
			foreach($materiaporfuera as $key2 => $codigomateriaporfuera)
			{
				//echo "<br>$codigo : MATE $codigomateriaporfuera<br>";
				$query_selmateria = "SELECT m.*, tm.* 
				FROM materia m, tipomateria tm
				WHERE m.codigomateria = '$codigomateriaporfuera'
				AND m.codigotipomateria = tm.codigotipomateria";
				//echo "<br>$query_selectdetalleprematricula<br>";
				$selmateria = mysql_query($query_selmateria, $sala) or die(mysql_error());
				$totalRows_selmateria = mysql_num_rows($selmateria);
				$row_selmateria = mysql_fetch_assoc($selmateria);
				$codigotipomateria = $row_selmateria['codigotipomateria'];
				//$query_materia = "SELECT numerocreditos, semestre FROM materia m WHERE m.codigomateria = '$codigomateria' AND m.codigocarrera = '$codigocarrera'";
				//$res_materia = mysql_query($query_materia, $sala) or die(mysql_error());
				//$totalRows_materia = mysql_num_rows($res_materia);
				//$row_materia = mysql_fetch_assoc($res_materia);
				//$idgrupomateria = $row_materia['idgrupomateria'];
				$creditosmateria = $row_selmateria['numerocreditos'];
				//echo "CREDITOS: $creditos<br>";
				// Obligatoria y Propuesta 
				if($codigotipomateria <> '4')
				{
					// Toma todas las materias
					$creditos = $creditos + $creditosmateria;
					$semestre[$row_selmateria['semestre']] = $semestre[$row_selmateria['semestre']] + $creditosmateria;
					$calculosemestre = true;
				}
				// Electivas libres
				else if($codigotipomateria == '4')
				{
					$creditos = $creditos + $creditosmateria;
					$calculosemestre = true;
				}
			}
		}
	}
	if(!$calculosemestre)
	{
		$semestreactual = 0;
		$creditos = 0;
				
		$query_selectidprematricula = "SELECT idprematricula
		FROM ordenpago
		WHERE numeroordenpago = $numerodeorden";
		//echo "<br>$query_selectidprematricula";
		$selectidprematricula = mysql_query($query_selectidprematricula, $sala) or die(mysql_error());
		$totalRows_selectidprematricula = mysql_num_rows($selectidprematricula);
		$row_selectidprematricula = mysql_fetch_assoc($selectidprematricula);
		$idprematriculaactual = $row_selectidprematricula['idprematricula'];
	}
	else
	{
		/***** Total de creditos *******/
		//echo "El numero de creditos es : $creditos <br>";
		
		/***** Retorna el (los) semestre(s) con el valor máximo de creditos *****/
		$maxcreditos = max($semestre);
		//echo "El máximo número de creditos en un semestre es $maxcreditos<br>";
				
		/************** Semestre real del alumno ********************/
		// Coloca los semestre con mayor número de creditos en una matriz, tomandolos del primero al decimo
		$res_sem = array_keys ($semestre, $maxcreditos);
		// Tooma el semestre de la primera posicion indicando que es el priemer semestre de los escogidos 
		$semestreactual=$res_sem[0]; 
	}
}
unset($materiacreditos);
unset($materiaporfuera);
?>