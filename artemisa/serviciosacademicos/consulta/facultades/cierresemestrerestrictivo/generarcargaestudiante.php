<?php
// Proceso para generar la carga académica
// Toma todas las materias del plan de estudios
unset($materiaspropuestas);
unset($electivaslibresplan);
unset($materiasporver);
unset($materiasobligatorias);
unset($materiaspropuestas);
unset($materiaspasadas);
unset($materiaspropuestas);
unset($cargaobligatoria);
unset($semestre);
unset($materiasafiltrar);
unset($materiasobigatoriasquitar);
unset($materiasconprerequisito);

    $numerocreditoselectivas = 0;
	$tieneelectivas = false;
	$tieneenfasis = false;
	$estudiantetieneenfasis = false; 
	// String que va a guardar las materias del plan de estudios para quitarselas a las electivas libres, en caso de existir una obligatoria
	$quitarmateriasdelplandestudios = "";	
	
$query_materiasplanestudio = "select d.idplanestudio, d.codigomateria, m.nombremateria, 
d.semestredetalleplanestudio*1 as semestredetalleplanestudio, 
t.nombretipomateria, t.codigotipomateria, d.numerocreditosdetalleplanestudio
from planestudioestudiante p, detalleplanestudio d, materia m, tipomateria t
where p.codigoestudiante = '$codigoestudiante'
and p.idplanestudio = d.idplanestudio
and p.codigoestadoplanestudioestudiante like '1%'
and d.codigoestadodetalleplanestudio like '1%'
and d.codigomateria = m.codigomateria
and d.codigotipomateria = t.codigotipomateria
order by 4,3";
//and d.codigotipomateria not like '5%'
//and d.codigotipomateria not like '4%'";
//echo "$query_materiasplanestudio<br>";

$materiasplanestudio=mysql_query($query_materiasplanestudio, $sala) or die("$query_materiasplanestudio");
$totalRows_materiasplanestudio = mysql_num_rows($materiasplanestudio);
//echo "Total: $totalRows_materiasplanestudio<br>";
$quitarmateriasdelplandestudios = "";
if($totalRows_materiasplanestudio != "")
{
	// Este arreglo sirve para guardar el semestre que mas se repite
	$semestre = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0);
	$numerocreditoselectivas = 0;
	$tieneelectivas = false;
	$tieneenfasis = false;
	$estudiantetieneenfasis = false; 
	// String que va a guardar las materias del plan de estudios para quitarselas a las electivas libres, en caso de existir una obligatoria
	$quitarmateriasdelplandestudios = "";
	while($row_materiasplanestudio = mysql_fetch_array($materiasplanestudio))
	{
		$idplan = $row_materiasplanestudio['idplanestudio'];
		//echo $row_materiasplanestudio['codigomateria']."<br>";
		$quitarmateriasdelplandestudios = "$quitarmateriasdelplandestudios and m.codigomateria <> '".$row_materiasplanestudio['codigomateria']."'";
		if($row_materiasplanestudio['codigotipomateria'] == '4')
		{
			$numerocreditoselectivas = $numerocreditoselectivas + $row_materiasplanestudio['numerocreditosdetalleplanestudio'];
			$electivaslibresplan[] = $row_materiasplanestudio;
			$tieneelectivas = true;
		}
		else
		{
			// Mira si cada materia n ha sido aprobada para meterla en la carga
			// Por el momento toma totas las materias
			//$reprobada=true;
			if($row_materiasplanestudio['codigotipomateria'] != '5')
			{
				//echo "materiaaprobada($codigoestudiante, ".$row_materiasplanestudio['codigomateria'].", ".$row_materiasplanestudio['idplanestudio'].", $reprobada, $sala<br>";
				$estadomateria = materiaaprobada($codigoestudiante, $row_materiasplanestudio['codigomateria'], $row_materiasplanestudio['idplanestudio'], $reprobada, $sala);
				if($estadomateria == "porver")
				{
					$materiasporver[] = $row_materiasplanestudio;
					//echo "entro <br>";
				}
				else if($estadomateria == "reprobada")
				{
					//echo "REPRO: $reprobada : ".$row_materiasplanestudio['codigomateria']."<br>";
					// Estas materias son obligatorias
					$materiasobligatorias[] = $row_materiasplanestudio;
					// Selección de la carga obligatoria
					$cargaobligatoria[] = $row_materiasplanestudio['codigomateria'];
					$materiasporver[] = $row_materiasplanestudio;
					$semestre[$row_materiasplanestudio['semestredetalleplanestudio']]++;
				}
				else if($estadomateria == "aprobada")
				{
					//echo "bien<br>";
					$materiaspasadas[] = $row_materiasplanestudio;
				}
				else
				{
					echo "error";
				}
			}
			else if($row_materiasplanestudio['codigotipomateria'] == '5')
			{
				// Aqui es para las lineas de enfasis
				$tieneenfasis = true;
				// Primero miro si el estudiante ya tiene linea de enfasis.
				$query_poseelineaenfasis = "select le.idlineaenfasisplanestudio
				from lineaenfasisestudiante le
				where le.codigoestudiante = '$codigoestudiante'
				and fechavencimientolineaenfasisestudiante > now()";
				//and d.codigotipomateria not like '5%'
				//and d.codigotipomateria not like '4%'";
				//echo "$query_materiasplanestudio<br>";
				$poseelineaenfasis=mysql_query($query_poseelineaenfasis, $sala) or die("$query_poseelineaenfasis");
				$totalRows_poseelineaenfasis = mysql_num_rows($poseelineaenfasis);
				if($totalRows_poseelineaenfasis != "")
				{
					// Selecciona las materias de la línea y efectua el proceso de carga para esas materias
					$estudiantetieneenfasis = true; 
				}			
			}
		}
		$idplanestudioini = $row_materiasplanestudio['idplanestudio'];
	}
	if($estudiantetieneenfasis)
	{
		// Selecciona las materias de la linea de enfasis de este estudiante
		$query_materiaslineaenfasis = "select d.idplanestudio, d.idlineaenfasisplanestudio, 
		d.codigomateriadetallelineaenfasisplanestudio as codigomateria, m.nombremateria, 
		d.semestredetallelineaenfasisplanestudio*1 as semestredetalleplanestudio, t.nombretipomateria, 
		t.codigotipomateria, d.numerocreditosdetallelineaenfasisplanestudio as numerocreditosdetalleplanestudio
		from detallelineaenfasisplanestudio d, materia m, tipomateria t, lineaenfasisestudiante l
		where d.codigomateriadetallelineaenfasisplanestudio = m.codigomateria
		and d.codigotipomateria = t.codigotipomateria
		and l.idplanestudio = d.idplanestudio
		and l.idlineaenfasisplanestudio = d.idlineaenfasisplanestudio
		and l.fechavencimientolineaenfasisestudiante > now()
		and l.codigoestudiante = '$codigoestudiante'		
		group by 3
		order by 2,5";
		//and d.codigotipomateria not like '5%'
		//and d.codigotipomateria not like '4%'";
		//echo "$query_materiaslineaenfasis<br>";
		$materiaslineaenfasis=mysql_query($query_materiaslineaenfasis, $sala) or die("$query_materiaslineaenfasis");
		$totalRows_materiaslineaenfasis = mysql_num_rows($materiaslineaenfasis);
	}
	else if($tieneenfasis)
	{
		// Selecciona todas las materias del plan de estudio que son enfais
		// Es decir toma todos los enfasis
		$query_materiaslineaenfasis = "select d.idplanestudio, d.idlineaenfasisplanestudio, 
		d.codigomateriadetallelineaenfasisplanestudio as codigomateria, m.nombremateria, 
		d.semestredetallelineaenfasisplanestudio*1 as semestredetalleplanestudio, t.nombretipomateria, 
		t.codigotipomateria, d.numerocreditosdetallelineaenfasisplanestudio as numerocreditosdetalleplanestudio
		from detallelineaenfasisplanestudio d, materia m, lineaenfasisplanestudio l, tipomateria t
		where d.idplanestudio = '$idplan'
		and d.codigomateriadetallelineaenfasisplanestudio = m.codigomateria
		and d.codigotipomateria = t.codigotipomateria
		and l.idplanestudio = d.idplanestudio
		group by 3
		order by 2,5";
		//and d.codigotipomateria not like '5%'
		//and d.codigotipomateria not like '4%'";
		//echo "$query_materiaslineaenfasis<br>";
		$materiaslineaenfasis=mysql_query($query_materiaslineaenfasis, $sala) or die("$query_materiaslineaenfasis");
		$totalRows_materiaslineaenfasis = mysql_num_rows($materiaslineaenfasis);
	}
	if($totalRows_materiaslineaenfasis != "")
	{
		while($row_materiaslineaenfasis = mysql_fetch_array($materiaslineaenfasis))
		{
			$quitarmateriasdelplandestudios = "$quitarmateriasdelplandestudios and m.codigomateria <> '".$row_materiaslineaenfasis['codigomateria']."'";
			$estadomateria = materiaaprobada($codigoestudiante, $row_materiaslineaenfasis['codigomateria'], $idplan, $reprobada, $sala);
			if($estadomateria == "porver")
			{
				$materiasporver[] = $row_materiaslineaenfasis;
				//echo "entro <br>";
			}
			else if($estadomateria == "reprobada")
			{
				// No la puse por que no hay linea de enfasis
				//echo "REPRO: $reprobada : ".$row_materiasplanestudio['codigomateria']."<br>";
				// Estas materias son obligatorias
				$materiasobligatorias[] = $row_materiaslineaenfasis;
				// Selección de la carga obligatoria
				$cargaobligatoria[] = $row_materiaslineaenfasis['codigomateria'];
				$materiasporver[] = $row_materiaslineaenfasis;
				$semestre[$row_materiaslineaenfasis['semestredetalleplanestudio']]++;
			}
			else if($estadomateria == "aprobada")
			{
				//echo "bien<br>";
				$materiaspasadas[] = $row_materiaslineaenfasis;
			}
			else
			{
				echo "error";
			}
		}		
	}
	$materiasafiltrar = $materiasporver;
	//print_r($materiasporver);
	$materiasconprerequisito = $materiasporver;
	$materiasobigatoriasquitar = $materiasobligatorias;
	// Solamente se filtran las materias por ver, es decir las sugeridas
	if(isset($materiasafiltrar))
	{
		foreach($materiasafiltrar as $key1 => $value1)
		{
			// Debe tomar las materias que no tengan prerequisito, o el prerequisito este aprobado
			// Las materias del anterior arreglo deben filtrarse por las que no tengan prerequisito o el prerequisito este aprobado.
			// Mejor dicho si el prereqisito de una materia no se encuentra en este mismo arreglo se acepta la materia si no No.
			$query_materiasprerequisito = "select r.codigomateriareferenciaplanestudio
			from referenciaplanestudio r
			where r.idplanestudio = '".$value1['idplanestudio']."'
			and r.codigomateria = '".$value1['codigomateria']."'
			and r.codigotiporeferenciaplanestudio like '1%'
			and r.codigoestadoreferenciaplanestudio = '101'";
			//echo "$query_materiasprerequisito<br>";
			$materiasprerequisito=mysql_query($query_materiasprerequisito, $sala) or die("$query_materiasprerequisito");
			$totalRows_materiasprerequisito = mysql_num_rows($materiasprerequisito);
			if($totalRows_materiasprerequisito != "")
			{
				$tieneprerequisito = false;
				//echo "<br>PAPA: ".$value1['codigomateria']."";
				while($row_materiasprerequisito = mysql_fetch_array($materiasprerequisito))
				{
					// Cada una de las materias prerequisitos se busca en el arreglo, si esta no incluye la materia
					foreach($materiasconprerequisito as $key2 => $value2)
					{
						//echo "<br>".$row_materiasprerequisito['codigomateriareferenciaplanestudio']." = ".$value2['codigomateria']."<br>";
						if($row_materiasprerequisito['codigomateriareferenciaplanestudio'] == $value2['codigomateria'])
						{
							//echo "<br>".$row_materiasprerequisito['codigomateriareferenciaplanestudio']." = ".$value2['codigomateria']."<br>";
							$tieneprerequisito = true;
							//return;
						}
					}
				}
				if(!$tieneprerequisito)
				{
					$quitarobligatoria = false;
					if(isset($materiasobigatoriasquitar))
					{	
						foreach($materiasobigatoriasquitar as $key3 => $value3)
						{
							//echo $value1['codigomateria']." == ".$value3['codigomateria']."<br>";
							if($value1['codigomateria'] == $value3['codigomateria'])
							{
								//echo $value1['codigomateria']." == ".$value3['codigomateria']."<br>";
								$quitarobligatoria = true;
							}
						}
					}
					if(!$quitarobligatoria)
					{
						$materiaspropuestas[] = $value1;
						// Selección de la carga obligatoria
						$cargaobligatoria[] = $value1['codigomateria'];
						$semestre[$value1['semestredetalleplanestudio']]++;
					}
				}
			}
			else
			{
				$quitarobligatoria = false;
				if(isset($materiasobigatoriasquitar))
				{	
					foreach($materiasobigatoriasquitar as $key3 => $value3)
					{
						//echo $value1['codigomateria']." == ".$value3['codigomateria']."<br>";
						if($value1['codigomateria'] == $value3['codigomateria'])
						{
							//echo $value1['codigomateria']." == ".$value3['codigomateria']."<br>";
							$quitarobligatoria = true;
						}
					}
				}
				if(!$quitarobligatoria)
				{
					$materiaspropuestas[] = $value1;
					// Selección de la carga obligatoria
					$cargaobligatoria[] = $value1['codigomateria'];
					$semestre[$value1['semestredetalleplanestudio']]++;
				}
			}		
		}
	}
	else
	{
		//echo '<h1 align="center">El estudiante no tiene materias para ver</h1>';
	}
}
else
{
	//echo "Este estudiante no tiene asignado un plan de estudios";
	//exit();
}
//exit();
//print_r($materiaspropuestas);
?>
