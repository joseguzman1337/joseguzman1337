<?php
// Recibe el número de días que se quieren calcular a partir de la fecha de hoy
function valorestadisticoestudiante($codigoestudiante, $codigoperiodo, $sala)
{
	//echo "<br>calculocreditossemestre.php<br>"; 

	// Primero seleccionamos los datos de la prematricula
	// Datos de la primera prematricula hecha
	
	// Este script recibe los siguientes parametros:
	// $codigoperiodo, $codigoestudiante y $usarcondetalleprematricula (True para hacerlo con lo que hay en prematricula, False para hacerlo con otro arreglo)
	$cuentaelectivas = 0;
	
	$usarcondetalleprematricula = true;
	if($usarcondetalleprematricula)
	{
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
					$materiaselegidas[] = $row_premainicial1['codigomateria'];
				}
				else
				{
					//echo "acad con electiva<br>";
					if(!isset($materiaselegidas[$row_premainicial1['codigomateriaelectiva']]))
					{
						$materiaselegidas[$row_premainicial1['codigomateriaelectiva']] = $row_premainicial1['codigomateria'];
					}
					else
					{
						$cuentaelectivas++;
						$materiaselegidas[$row_premainicial1['codigomateriaelectiva']."elect$cuentaelectivas"] = $row_premainicial1['codigomateria'];
					}
				}
			}
		}
		else
		{
			//echo "acad 3<br>";
		}
	}
	
	// Toma del plan de estudios los datos de las materias
	
	// Este arreglo sirve para guardar el semestre que mas se repite
	// Tomo el maximo numero de semestres del plan de estudio
	$query_semestreplanes = "select max(cantidadsemestresplanestudio*1) as semestre
	from planestudio";
	$semestreplanes=mysql_query($query_semestreplanes, $sala) or die("$query_semestreplanes");
	$totalRows_semestreplanes = mysql_num_rows($semestreplanes);
	$row_semestreplanes = mysql_fetch_array($semestreplanes);
	for($semestreini = 1; $semestreini <= $row_semestreplanes['semestre']; $semestreini++)
	{
		$semestre[$semestreini] = 0;
	}
	//$numerocreditoselectivas = 0;
	$creditos = 0;
	$creditoscalculados = 0;
	// En materiaselegidas debo guardar todo lo que halla sido insertado en detalleprematricula
	if(isset($materiaselegidas))
	{
		foreach($materiaselegidas as $codigomateriaelectiva2 => $codigomateria2)
		{
			if(ereg($codigomateriaelectiva2,"^[0-9]{1,7}elect[0-9]+$"))
			{
				ereg($codigomateriaelectiva2,"^[0-9]{1,7}",$registers);
				$codigmateriaelectiva2 = $registers[0];
			}
			$eselectivalibre = false;
			$eselectivatecnica = false;
			//echo "<br>$codigomateriaelectiva2 => $codigomateria2<br>";
			
			// Primero calcula el numero de creditos mirando en la carga con el plan de estudios que tenga seleccionado
			
			// Toma todas las materias del plan de estudios, si no esta aca la materia es por que es una electiva tecnica(enfasis) o libre
			//echo "<br>$codigomateria2 NUCLEO<br>";
			$query_datosmateriaselegidas = "select m.nombremateria, m.codigomateria, dpe.semestredetalleplanestudio, dpe.numerocreditosdetalleplanestudio as numerocreditos
			from materia m, detalleplanestudio dpe, planestudioestudiante pee
			where m.codigomateria = '$codigomateria2'
			and pee.codigoestudiante = '$codigoestudiante'
			and m.codigomateria = dpe.codigomateria
			and pee.idplanestudio = dpe.idplanestudio
			and pee.codigoestadoplanestudioestudiante like '1%'";
			//and d.codigotipomateria not like '4%'";
			//echo "$query_premainicial1<br>";
			$datosmateriaselegidas=mysql_query($query_datosmateriaselegidas, $sala) or die("$query_datosmateriaselegidas<br>".mysql_error());
			$totalRows_datosmateriaselegidas = mysql_num_rows($datosmateriaselegidas);
			if($totalRows_datosmateriaselegidas == "")
			{
				//echo "<br>$codigomateria2 ENFASIS<br>";
				// Toma los datos de la materia si es enfasis
				$query_datosmateriaselegidas = "select m.nombremateria, m.codigomateria, dle.semestredetallelineaenfasisplanestudio as semestredetalleplanestudio,
				dle.numerocreditosdetallelineaenfasisplanestudio as numerocreditos
				from materia m, detallelineaenfasisplanestudio dle, lineaenfasisestudiante lee
				where m.codigomateria = '$codigomateria2'
				and lee.codigoestudiante = '$codigoestudiante'
				and m.codigomateria = dle.codigomateriadetallelineaenfasisplanestudio
				and lee.idplanestudio = dle.idplanestudio
				and lee.idlineaenfasisplanestudio = dle.idlineaenfasisplanestudio
				and dle.codigoestadodetallelineaenfasisplanestudio like '1%'";
				// Otro query para selecciona los datos de las materias cuando el anterior es vacio para las demás materias
				// Tanto enfasis como electivas libres
				$datosmateriaselegidas=mysql_query($query_datosmateriaselegidas, $sala) or die("$query_datosmateriaselegidas".mysql_error());
				$totalRows_datosmateriaselegidas = mysql_num_rows($datosmateriaselegidas);
				// Si se trata de una electiva
			}
			if($totalRows_datosmateriaselegidas == "")
			{
				// Mira si tiene papa, si el papa es electiva libre (posee idgrupolinea == 100) toma los creditos directamente del hijo
				// Si es tecnica toma los creditos directamente del papa 
				// Si no tiene papa toma los datos como si fuera una materia externa		
				$query_datosmateriapapa = "select m.nombremateria, m.codigomateria, dpe.semestredetalleplanestudio, dpe.numerocreditosdetalleplanestudio as numerocreditos,
				dpe.codigotipomateria, gm.codigotipogrupomateria
				from grupomaterialinea gml, materia m, grupomateria gm, detalleplanestudio dpe, planestudioestudiante pee
				where gm.codigoperiodo = '$codigoperiodo'
				and gml.codigomateria = '$codigomateriaelectiva2'
				and gml.codigoperiodo = gm.codigoperiodo
				and gm.codigoperiodo = gml.codigoperiodo
				and pee.codigoestudiante = '$codigoestudiante'
				and pee.idplanestudio = dpe.idplanestudio
				and dpe.codigomateria = m.codigomateria
				and gml.codigomateria = m.codigomateria
				and gml.idgrupomateria = gm.idgrupomateria
				and pee.codigoestadoplanestudioestudiante like '1%'
				order by m.nombremateria";
				$datosmateriapapa = mysql_query($query_datosmateriapapa, $sala) or die("$query_datosmateriapapa");
				//echo "$totalRows_datosmateriapapa uno <br> $query_datosmateriapapa<br>";
				$totalRows_datosmateriapapa = mysql_num_rows($datosmateriapapa);
				if($totalRows_datosmateriapapa == "")
				{
					// Mira si se trata de una materia electiva
					$query_datosmateriapapa = "select m.nombremateria, m.codigomateria, dpe.semestredetalleplanestudio, dpe.numerocreditosdetalleplanestudio as numerocreditos,
					dpe.codigotipomateria, m.codigoindicadorgrupomateria
					from materia m, detalleplanestudio dpe, planestudioestudiante pee
					where m.codigomateria = '$codigomateriaelectiva2'
					and pee.codigoestudiante = '$codigoestudiante'
					and pee.idplanestudio = dpe.idplanestudio
					and dpe.codigomateria = m.codigomateria
					and pee.codigoestadoplanestudioestudiante like '1%'
					order by m.nombremateria";
					$datosmateriapapa = mysql_query($query_datosmateriapapa, $sala) or die("$query_datosmateriapapa");
					$row_datosmateriapapa = mysql_fetch_array($datosmateriapapa);
					$totalRows_datosmateriapapa = mysql_num_rows($datosmateriapapa);
					//echo "$totalRows_datosmateriapapa uno <br> $query_datosmateriapapa<br>";
					if($row_datosmateriapapa['codigotipomateria'] == '4' && $row_datosmateriapapa['codigoindicadorgrupomateria'] == "200")
					{
						// La materia es electiva
						// Materia electiva libre
						// Si entra es por que la materia hija es libre y debe tomar el numero de creditos de ella
						//echo "<br>$codigomateria2 LIBRE<br>";
						$query_datosmateriaselegidas = "select m.nombremateria, m.codigomateria, m.numerocreditos
						from materia m
						where m.codigomateria = '$codigomateria2'
						and m.codigoestadomateria = '01'";
						//echo "$query_datosmateriaselegidas";
						$datosmateriaselegidas = mysql_query($query_datosmateriaselegidas, $sala) or die("$query_datosmateriaselegidas");
						$totalRows_datosmateriaselegidas = mysql_num_rows($datosmateriaselegidas);
						$eselectivalibre = true;
					}
					else
					{
						//echo "<br>$codigomateria2 EXTERNA<br>";
						// En el caso de haber hecho la prematricula y de tratarse de una materia externa en carga academica se
						// Actualmente todos los planes de estudio tiene el mismo numero de creditos para una materia
						// Toca empezar a guardar el plan de estudio de la materia externa en cargaacademica y de este tomar el semestre y
						// y los creditos de la materia y efectuar el conteo de creditos a partir de aca.
						// Debido a que esto no se hiso  para el semestre 20052 toca dejar el codigo siguiente.
						$query_datosmateriaselegidas = "select m.nombremateria, m.codigomateria, d.semestredetalleplanestudio, d.numerocreditosdetalleplanestudio as numerocreditos,
						d.codigotipomateria
						from materia m, detalleplanestudio d, cargaacademica c
						where m.codigomateria = '$codigomateria2'
						and m.codigoestadomateria = '01'
						and c.codigoestudiante = '$codigoestudiante'
						and c.codigomateria = d.codigomateria
						and c.idplanestudio = d.idplanestudio
						and c.codigomateria = d.codigomateria
						and d.codigoestadodetalleplanestudio like '1%'
						and c.codigoestadocargaacademica like '1%'";
						$datosmateriaselegidas=mysql_query($query_datosmateriaselegidas, $sala) or die("$query_datosmateriaselegidas");
						//echo "$query_datosmateriaselegidas<br>";
						$totalRows_datosmateriaselegidas = mysql_num_rows($datosmateriaselegidas);
						// Este codigo sirve para le periodo 20052
						// Después de este periodo quitarlo, el problema es que no esta colocando el semestre que es, este lo coloca si es del plan de estudios
						// cualquiera
					}
					if($totalRows_datosmateriaselegidas == "")
					{
						$query_datosmateriaselegidas = "select m.nombremateria, m.codigomateria, m.numerocreditos, d.semestredetalleplanestudio
						from materia m, detalleplanestudio d
						where m.codigomateria = '$codigomateria2'
						and m.codigoestadomateria = '01'
						and d.codigomateria = m.codigomateria";
						//echo "DOS <br> $query_datosmateriaselegidas <br>";
						$datosmateriaselegidas = mysql_query($query_datosmateriaselegidas, $sala) or die("$query_datosmateriaselegidas");
						$totalRows_datosmateriaselegidas = mysql_num_rows($datosmateriaselegidas);
					}
					// Este lo coloca si no pertenece a ningun plan de estudios, esta colocando el 1 por defecto.
					if($totalRows_datosmateriaselegidas == "")
					{
						$query_datosmateriaselegidas = "select m.nombremateria, m.codigomateria, m.numerocreditos, 1 as semestredetalleplanestudio
						from materia m
						where m.codigomateria = '$codigomateria2'
						and m.codigoestadomateria = '01'";
						//echo "DOS <br> $query_datosmateriaselegidas <br>";
						$datosmateriaselegidas = mysql_query($query_datosmateriaselegidas, $sala) or die("$query_datosmateriaselegidas");
						$totalRows_datosmateriaselegidas = mysql_num_rows($datosmateriaselegidas);
					}
				}
				else 
				{
					// Si entra aca quiere decir que la materia tiene hijos.
					//echo "$totalRows_datosmateriapapa uno <br> $query_datosmateriapapa<br>";
					
					$row_datosmateriapapa = mysql_fetch_array($datosmateriapapa);
					
					//echo "Electiva $codigomateria2 <br>";
					
					// Se hizo pro si coloco alguna materia libre en grupomaterialinea
					if($row_datosmateriapapa['codigotipogrupomateria'] == "100")
					{
						// Materia electiva libre
						// Si entra es por que la materia hija es libre y debe tomar el numero de creditos de ella
						//echo "<br>$codigomateria2 LIBRE<br>";
						$query_datosmateriaselegidas = "select m.nombremateria, m.codigomateria, m.numerocreditos
						from materia m
						where m.codigomateria = '$codigomateria2'
						and m.codigoestadomateria = '01'";
						//echo "$query_datosmateriaselegidas";
						$datosmateriaselegidas = mysql_query($query_datosmateriaselegidas, $sala) or die("$query_datosmateriaselegidas");
						$totalRows_datosmateriaselegidas = mysql_num_rows($datosmateriaselegidas);
						$eselectivalibre = true;
					}
					else if($row_datosmateriapapa['codigotipogrupomateria'] == "200")
					{
						// Materia electiva tecnica
						// Si entra aca es por que la materia debe tomar el numero de creditos del papa
						$query_datosmateriaselegidas = "select m.nombremateria, m.codigomateria, m.numerocreditos
						from materia m
						where m.codigomateria = '$codigomateria2'
						and m.codigoestadomateria = '01'";
						//echo "$query_datosmateriaselegidas";
						$datosmateriaselegidas = mysql_query($query_datosmateriaselegidas, $sala) or die("$query_datosmateriaselegidas");
						$totalRows_datosmateriaselegidas = mysql_num_rows($datosmateriaselegidas);
						$creditospapa = $row_datosmateriapapa['numerocreditos'];
						$eselectivatecnica = true;
					}
				}
			}
			if($totalRows_datosmateriaselegidas != "")
			{
				$row_datosmateriaselegidas = mysql_fetch_array($datosmateriaselegidas);
				$codigotipomateria = $row_datosmateriaselegidas['codigotipomateria'];
				$codigomateria = $row_datosmateriaselegidas['codigomateria'];
				if($eselectivatecnica)
				{
					$creditosmateria = $creditospapa;
				}
				else
				{
					$creditosmateria = $row_datosmateriaselegidas['numerocreditos'];
				}
				// Obligatoria y lineas de enfasis
				//if($codigotipomateria != '4')
				if(!$eselectivalibre)
				{
					$creditos = $creditos + $creditosmateria;
					//echo "<br><strong>$creditos</strong><br>";
					// Guardo la materiahija y le asigno el papa 
					$materia[$$codigomateriaelectiva2] = $codigomateria2;
					if($row_datosmateriaselegidas['semestredetalleplanestudio'] == "externa")
					{
						$semestre[$_GET['semestrerep']] = $semestre[$_GET['semestrerep']] + $creditosmateria;
						//echo 'Entro $semestre['.$_GET['semestrerep'].'] = $semestre['.$_GET['semestrerep'].'] + $creditosmateria <br>';
					}
					else
					{
						if($row_datosmateriaselegidas['semestredetalleplanestudio'] == "")
						{
							$semestre[$row_datosmateriapapa['semestredetalleplanestudio']] = $semestre[$row_datosmateriapapa['semestredetalleplanestudio']] + $creditosmateria;
							//echo '$semestre['.$row_datosmateriapapa['semestredetalleplanestudio'].'] = $semestre['.$row_datosmateriapapa['semestredetalleplanestudio'].'] + $creditosmateria <br>';
							//echo $semestre[$row_datosmateriapapa['semestredetalleplanestudio']]." = ".$semestre[$row_datosmateriapapa['semestredetalleplanestudio']]." + $creditosmateria <br>";
						}
						else
						{
							$semestre[$row_datosmateriaselegidas['semestredetalleplanestudio']] = $semestre[$row_datosmateriaselegidas['semestredetalleplanestudio']] + $creditosmateria;
							//echo '$semestre['.$row_datosmateriaselegidas['semestredetalleplanestudio'].'] = $semestre['.$row_datosmateriaselegidas['semestredetalleplanestudio'].'] + $creditosmateria <br>';
							//echo $semestre[$row_datosmateriaselegidas['semestredetalleplanestudio']]." = ".$semestre[$row_datosmateriaselegidas['semestredetalleplanestudio']]." + $creditosmateria <br>";
						}
					}
				}
				else
				{
					// Electivas libres
					// Toma la electiva libre que va a ver el chino
					// Los creditos de las electivas no se suman ya que el estudiante puede tomarlos en cualquier momento
					// de la carrera, debido a que no tienen ningún tipo de referencia
					//$creditos = $creditos + $creditosmateria;
					//$creditos = $creditos + $creditosmateria;
					//echo "<br>NO SUMA<br>";
					$materia[] = $codigomateria2;
					// Las electivas libres no afectan el semestre
				}
			}
			else
			{
				//echo "Esta materia $codigomateria2 no pertenece al plan de estudios<br>";
			}
		}
	}
	else
	{
		//$semestre[1] = 0;
	}
	//echo "Creditos : $creditoscalculados<br>";
	//exit();
	/***** Total de creditos *******/
	//echo "El numero de creditos es : $creditos <br>";
	
	/***** Retorna el (los) semestre(s) con el valor máximo de creditos *****/
	// Para seleccionar el periodo anterior hago lo siguiente
	$valortotal = 0;
	foreach($semestre as $key => $value)
	{
		// En $key esta el semestre y en $value esta el numero de creditos
		//echo "$key => $value<br>";
		$query_selvalorsemestre = "select dc.semestredetallecohorte, dc.valordetallecohorte
		from cohorte c, estudiante e, detallecohorte dc
		where c.codigocarrera = e.codigocarrera
		and e.codigoperiodo
		and c.idcohorte = dc.idcohorte
		and c.codigoperiodo = '$codigoperiodo'
		and e.codigoestudiante = '$codigoestudiante'
		and dc.semestredetallecohorte = '$key'
		and e.codigoperiodo*1 between c.codigoperiodoinicial*1 and c.codigoperiodofinal*1";
		//echo "$query_horarioinicial<br>";
		$selvalorsemestre = mysql_query($query_selvalorsemestre, $sala) or die("$query_selvalorsemestre");
		$totalRows_selvalorsemestre = mysql_num_rows($selvalorsemestre);
		// Primer registro
		$row_selvalorsemestre = mysql_fetch_array($selvalorsemestre);
		$valordetallecohorte = $row_selvalorsemestre['valordetallecohorte'];
		//echo "<br>Cohorte: $valordetallecohorte";
		
		// El total de cretitos del semestre es
		$query_seltotalcreditossemestre = "select sum(d.numerocreditosdetalleplanestudio) as totalcreditossemestre, d.idplanestudio
		from detalleplanestudio d, planestudioestudiante p
		where d.idplanestudio = p.idplanestudio
		and p.codigoestudiante = '$codigoestudiante'
		and d.semestredetalleplanestudio = '$key'
		and p.codigoestadoplanestudioestudiante like '1%'
		and d.codigotipomateria not like '4'
		and d.codigotipomateria not like '5'
		group by 2 ";
		//echo "$query_seltotalcreditossemestre<br>";
		$seltotalcreditossemestre = mysql_query($query_seltotalcreditossemestre	, $sala) or die("$query_seltotalcreditossemestre");
		$totalRows_seltotalcreditossemestre = mysql_num_rows($seltotalcreditossemestre);
		$row_seltotalcreditossemestre = mysql_fetch_array($seltotalcreditossemestre);
		$totalcreditossemestre = $row_seltotalcreditossemestre['totalcreditossemestre'];
		
		@$valorcredito = $valordetallecohorte/$totalcreditossemestre;
		//echo "<br>Valor credito:<br>$valorcredito = $valordetallecohorte/$totalcreditossemestre";
		
		$valorcreditossel = $valorcredito*$value;
		//echo "<br><br>$valorcreditossel = $valorcredito*$value";
		$valortotal = $valortotal + $valorcreditossel;
		//echo "<h1>$valortotal</h1>";
	}
	return $valortotal;
}
//require("../Connections/sala2.php");
//mysql_select_db($database_sala, $sala);

//echo "<h1>".valorestadisticoestudiante(17956, 20061, $sala)."</h1>";
?>