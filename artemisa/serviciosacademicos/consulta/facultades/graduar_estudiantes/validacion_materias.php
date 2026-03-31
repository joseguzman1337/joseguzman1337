<?php
// Esta funcion recibe el estudiante, la materia que se quiere verificar, el plan de estudios donde se encuentra la materia y la base de datos.
function materiaaprobada($codigoestudiante, $codigomateria, $idplanestudio, $reprobada, $conexion)
{
	$query_materianota = "SELECT n.codigomateria, n.notadefinitiva, m.notaminimaaprobatoria, n.codigoperiodo
	FROM notahistorico n, materia m
	WHERE n.codigoestudiante = '$codigoestudiante'
	AND m.codigomateria = n.codigomateria
	AND (n.codigomateria = '$codigomateria' OR n.codigomateriaelectiva = '$codigomateria')
	and n.codigoestadonotahistorico like '1%'
	ORDER BY 4 ";
	//echo "$query_materianota<br>";
	$materianota=mysql_query($query_materianota, $conexion) or die("$query_materianota");
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
	$materiaequivalente=mysql_query($query_materiaequivalente, $conexion) or die("$query_materiaequivalente");
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
			$materianota=mysql_query($query_materianota, $conexion) or die("$query_materianota");
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


<?php

function generarcargaestudiante($codigoestudiante,$conexion){
	// Proceso para generar la carga académica
	// Toma todas las materias del plan de estudios
	$query_materiasplanestudio = "select d.idplanestudio, d.codigomateria, m.nombremateria, m.codigoindicadorgrupomateria,
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
	$materiasplanestudio=mysql_query($query_materiasplanestudio, $conexion) or die("$query_materiasplanestudio");
	$totalRows_materiasplanestudio = mysql_num_rows($materiasplanestudio);
	$rowmateriasplanestudio=mysql_fetch_assoc($materiasplanestudio);
	//print_r($rowmateriasplanestudio);
	//echo "Total: $totalRows_materiasplanestudio<br>";
	$quitarmateriasdelplandestudios = "";
	if($totalRows_materiasplanestudio != "")
	{
		// Este arreglo sirve para guardar el semestre que mas se repite
		// Tomo el maximo numero de semestres del plan de estudio
		$query_semestreplanes = "select max(cantidadsemestresplanestudio*1) as semestre
	from planestudio";
		$semestreplanes=mysql_query($query_semestreplanes, $conexion) or die("$query_semestreplanes");
		$totalRows_semestreplanes = mysql_num_rows($semestreplanes);
		$row_semestreplanes = mysql_fetch_array($semestreplanes);
		for($semestreini = 1; $semestreini <= $row_semestreplanes['semestre']; $semestreini++)
		{
			$semestre[$semestreini] = 0;
		}
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
					//echo "materiaaprobada($codigoestudiante, ".$row_materiasplanestudio['codigomateria'].", ".$row_materiasplanestudio['idplanestudio'].", $reprobada, $conexion<br>";
					@$estadomateria = materiaaprobada($codigoestudiante, $row_materiasplanestudio['codigomateria'], $row_materiasplanestudio['idplanestudio'], $reprobada, $conexion);
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
				where le.codigoestudiante = '$codigoestudiante'";
					//and d.codigotipomateria not like '5%'
					//and d.codigotipomateria not like '4%'";
					//echo "$query_materiasplanestudio<br>";
					$poseelineaenfasis=mysql_query($query_poseelineaenfasis, $conexion) or die("$query_poseelineaenfasis");
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
			// Selecciona las materias de la linea de enfasis de este estudiante las cuales deben estar activas
			$query_materiaslineaenfasis = "select d.idplanestudio, d.idlineaenfasisplanestudio,
		d.codigomateriadetallelineaenfasisplanestudio as codigomateria, m.nombremateria, 
		d.semestredetallelineaenfasisplanestudio*1 as semestredetalleplanestudio, t.nombretipomateria, 
		t.codigotipomateria, d.numerocreditosdetallelineaenfasisplanestudio as numerocreditosdetalleplanestudio
		from detallelineaenfasisplanestudio d, materia m, tipomateria t, lineaenfasisestudiante l
		where d.codigomateriadetallelineaenfasisplanestudio = m.codigomateria
		and d.codigotipomateria = t.codigotipomateria
		and l.idplanestudio = d.idplanestudio
		and l.codigoestudiante = '$codigoestudiante'
		and l.idlineaenfasisplanestudio = d.idlineaenfasisplanestudio
		and d.codigoestadodetallelineaenfasisplanestudio like '1%'
		group by 3
		order by 2,5";
			//and d.codigotipomateria not like '5%'
			//and d.codigotipomateria not like '4%'";
			//echo "$query_materiaslineaenfasis<br>";
			$materiaslineaenfasis=mysql_query($query_materiaslineaenfasis, $conexion) or die("$query_materiaslineaenfasis");
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
			$materiaslineaenfasis=mysql_query($query_materiaslineaenfasis, $conexion) or die("$query_materiaslineaenfasis");
			$totalRows_materiaslineaenfasis = mysql_num_rows($materiaslineaenfasis);
		}
		if(@$totalRows_materiaslineaenfasis != "")
		{
			while($row_materiaslineaenfasis = mysql_fetch_array($materiaslineaenfasis))
			{
				$quitarmateriasdelplandestudios = "$quitarmateriasdelplandestudios and m.codigomateria <> '".$row_materiaslineaenfasis['codigomateria']."'";
				@$estadomateria = materiaaprobada($codigoestudiante, $row_materiaslineaenfasis['codigomateria'], $idplan, $reprobada, $conexion);
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
		@$materiasafiltrar = $materiasporver;
		//print_r($materiasporver);
		@$materiasconprerequisito = $materiasporver;
		@$materiasobigatoriasquitar = $materiasobligatorias;
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
				$materiasprerequisito=mysql_query($query_materiasprerequisito, $conexion) or die("$query_materiasprerequisito");
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

	if(isset($materiasporver))
	{
		$debematerias=true;
		$mensaje="$mensaje Debe materias ";
		//echo "debematerias";
	}
	else
	{
		$debematerias=false;
	}
	return $debematerias;
}
//exit();
//print_r($materiaspropuestas);
?>
