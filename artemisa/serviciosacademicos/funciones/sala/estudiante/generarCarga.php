<?php

function materiaaprobada($codigoestudiante, $codigomateria, $idplanestudio, $reprobada){
	global $db;
	$query_materianota = "SELECT n.codigomateria, n.notadefinitiva, m.notaminimaaprobatoria, n.codigoperiodo".
	" FROM notahistorico n, materia m ".
	" WHERE n.codigoestudiante = $codigoestudiante ".
	" AND m.codigomateria = n.codigomateria ".
	" AND (n.codigomateria = $codigomateria OR n.codigomateriaelectiva = $codigomateria ) ".
    " AND n.codigoestadonotahistorico = 100 ".
	" AND n.codigoestadonotahistorico like '1%' ORDER BY 4 ";
	$materianota = $db->Execute($query_materianota);
	$totalRows_materianota = $materianota->RecordCount();
	// Entra si la materia tienen nota historica para este estudiante
	// Sino busca la materia equivalente
	if($totalRows_materianota != ""){
		while($row_materianota = $materianota->FetchRow()){
			// Si la nota es aprobada retorna verdadero
			if($row_materianota['notadefinitiva'] >= $row_materianota['notaminimaaprobatoria']){
				$reprobada = false;
				return "aprobada";
			}else{
				$reprobada = true;
			}
		}//while
	}

	$query_materiaequivalente = "select r.idplanestudio, r.codigomateriareferenciaplanestudio ".
	" from referenciaplanestudio r ".
	" where r.idplanestudio = '$idplanestudio' ".
	" and r.codigomateria = '$codigomateria' ".
	" and r.codigotiporeferenciaplanestudio like '3%'";
	$materiaequivalente = $db->Execute($query_materiaequivalente);
	$totalRows_materiaequivalente = $materiaequivalente->RecordCount();
	// Si tiene materia equivalente entra a hacer lo mismo, es decir a mirar si la equivalente esta aprobada
	// Para el sigiente plan de estudios de la carrera donde aparezca esta materia
	// Sino retorna falso
	if($totalRows_materiaequivalente != ""){
		while($row_materiaequivalente = $materiaequivalente->FetchRow()){
			$codigoequivalente = $row_materiaequivalente['codigomateriareferenciaplanestudio'];
			$query_materianota = "SELECT n.codigomateria, n.notadefinitiva, m.notaminimaaprobatoria, n.codigoperiodo".
			" FROM notahistorico n, materia m ".
			" WHERE n.codigoestudiante = '$codigoestudiante' ".
			" AND m.codigomateria = n.codigomateria ".
			" AND (n.codigomateria = '$codigoequivalente' OR n.codigomateriaelectiva = '$codigoequivalente') ".
			" and n.codigoestadonotahistorico like '1%' ORDER BY 4 ";
			$materianota = $db->Execute($query_materianota);
			$totalRows_materianota = $materianota->RecordCount();
			// Entra si la materia tienen nota historica para este estudiante
			// Sino busca la materia equivalente
			if($totalRows_materianota != ""){
				while($row_materianota = $materianota->FetchRow()){
					// Si la nota es aprobada retorna verdadero
					if($row_materianota['notadefinitiva'] >= $row_materianota['notaminimaaprobatoria']){
						$reprobada = false;
						return "aprobada";
					}else{
						$reprobada = true;
					}
				}
			}
		}
	}else{
		return "porver";
	}
	if($reprobada){
		return "reprobada";
	}else{
		return "porver";
	}
}

function obtenerNota($codigoestudiante, $codigomateria, $idplanestudio, $haynota=false)
{
	global $db;
	$query_materianota = "SELECT n.codigomateria, n.notadefinitiva, m.notaminimaaprobatoria, n.codigoperiodo ".
	" FROM notahistorico n, materia m ".
	" WHERE n.codigoestudiante = '$codigoestudiante' ".
	" AND m.codigomateria = n.codigomateria ".
	" AND (n.codigomateria = '$codigomateria' OR n.codigomateriaelectiva = '$codigomateria') ".
	" and n.codigoestadonotahistorico like '1%' ORDER BY 4 ";
	$materianota = $db->Execute($query_materianota);
	$totalRows_materianota = $materianota->RecordCount();
	// Entra si la materia tienen nota historica para este estudiante
	// Sino busca la materia equivalente
	$notamayor = "";
	$haynota = false;
	if($totalRows_materianota != ""){
		while($row_materianota = $materianota->FetchRow()){
			$haynota = true;
			// Si la nota es aprobada retorna verdadero
            if($notamayor < $row_materianota['notadefinitiva']) {
                $notamayor = $row_materianota['notadefinitiva'];
            }
		}
	}
	$query_materiaequivalente = "select r.idplanestudio, r.codigomateriareferenciaplanestudio ".
	" from referenciaplanestudio r ".
	" where r.idplanestudio = '$idplanestudio' ".
	" and r.codigomateria = '$codigomateria' ".
	" and r.codigotiporeferenciaplanestudio like '3%'";
	$materiaequivalente = $db->Execute($query_materiaequivalente);
	$totalRows_materiaequivalente = $materiaequivalente->RecordCount();
	// Si tiene materia equivalente entra a hacer lo mismo, es decir a mirar si la equivalente esta aprobada
	// Para el sigiente plan de estudios de la carrera donde aparezca esta materia
	// Sino retorna falso
	if($totalRows_materiaequivalente != ""){
		while($row_materiaequivalente = $materiaequivalente->FetchRow()){
			$codigoequivalente = $row_materiaequivalente['codigomateriareferenciaplanestudio'];
			$query_materianota = "SELECT n.codigomateria, n.notadefinitiva, m.notaminimaaprobatoria, n.codigoperiodo".
			" FROM notahistorico n, materia m ".
			" WHERE n.codigoestudiante = '$codigoestudiante' ".
			" AND m.codigomateria = n.codigomateria ".
			" AND (n.codigomateria = '$codigoequivalente' OR n.codigomateriaelectiva = '$codigoequivalente') ".
			" and n.codigoestadonotahistorico like '1%' ORDER BY 4 ";
			$materianota = $db->Execute($query_materianota);
			$totalRows_materianota = $materianota->RecordCount();
			// Entra si la materia tienen nota historica para este estudiante
			// Sino busca la materia equivalente
			if($totalRows_materianota != ""){
				while($row_materianota = $materianota->FetchRow()){
					// Si la nota es aprobada retorna verdadero
					$haynota = true;
                    if($notamayor < $row_materianota['notadefinitiva']) {
                        $notamayor = $row_materianota['notadefinitiva'];
                    }
				}
			}
		}
	}
	return $notamayor;
}

// Proceso para generar la carga académica
// Toma todas las materias del plan de estudios
// La variable $quitaparacartas se usa para las cartas de los estudiantes graduandos
function generarCarga($codigoestudiante){
	global $db;
	$query_materiasplanestudio = "select d.idplanestudio, d.codigomateria, m.nombremateria, m.codigoindicadorgrupomateria,".
	" d.semestredetalleplanestudio*1 as semestredetalleplanestudio, ".
	" t.nombretipomateria, t.codigotipomateria, d.numerocreditosdetalleplanestudio ".
	" from planestudioestudiante p, detalleplanestudio d, materia m, tipomateria t ".
	" where p.codigoestudiante = '$codigoestudiante' ".
	" and p.idplanestudio = d.idplanestudio and p.codigoestadoplanestudioestudiante like '1%' ".
	" and d.codigoestadodetalleplanestudio like '1%' and d.codigomateria = m.codigomateria ".
	" and d.codigotipomateria = t.codigotipomateria order by 4,3";
	$materiasplanestudio = $db->Execute($query_materiasplanestudio);
	$totalRows_materiasplanestudio = $materiasplanestudio->RecordCount();
	$quitarmateriasdelplandestudios = "";
	$tieneunplandeestudios = true;
	if($totalRows_materiasplanestudio != ""){
		// Tomo el maximo numero de semestres de los planes de estudio existentes
		$query_semestreplanes = "select max(cantidadsemestresplanestudio*1) as semestre from planestudio";
		$semestreplanes = $db->Execute($query_semestreplanes);
		$row_semestreplanes = $semestreplanes->FetchRow();
		
		for($semestreini = 1; $semestreini <= $row_semestreplanes['semestre']; $semestreini++){
			$semestre[$semestreini] = 0;
		}
		$numerocreditoselectivas = 0;
		$tieneelectivas = false;
		$tieneenfasis = false;
		$estudiantetieneenfasis = false;
		// String que va a guardar las materias del plan de estudios para quitarselas
        // a las electivas libres, en caso de existir una obligatoria
		$quitarmateriasdelplandestudios = "";
		while($row_materiasplanestudio = $materiasplanestudio->FetchRow()){
			$idplan = $row_materiasplanestudio['idplanestudio'];
			$quitarmateriasdelplandestudios = " $quitarmateriasdelplandestudios and m.codigomateria <> '".
            $row_materiasplanestudio['codigomateria']."'";
            // Mira si cada materia no ha sido aprobada para meterla en la carga
            // Por el momento toma totas las materias
            if(!isset($reprobada) || empty($reprobada)){
                $reprobada = true;
            }
            if($row_materiasplanestudio['codigotipomateria'] != '5'){
                $estadomateria = materiaaprobada($codigoestudiante, $row_materiasplanestudio['codigomateria'],
                    $row_materiasplanestudio['idplanestudio'], $reprobada);
                if($estadomateria == "porver"){
                    $materiasporver[] = $row_materiasplanestudio;
                }else if($estadomateria == "reprobada"){
                    // Estas materias son obligatorias
                    $materiasobligatorias[] = $row_materiasplanestudio;
                    // Selección de la carga obligatoria
                    $cargaobligatoria[] = $row_materiasplanestudio['codigomateria'];
                    $materiasporver[] = $row_materiasplanestudio;
                    $semestre[$row_materiasplanestudio['semestredetalleplanestudio']]++;
                }else if($estadomateria == "aprobada"){
                    if(!isset($notadefinitiva) || empty($notadefinitiva)){
                        $notadefinitiva = "";
                    }
                    $row_materiasplanestudio['notadefinitiva'] = $notadefinitiva;
                    $materiaspasadas[] = $row_materiasplanestudio;
                }else{
                    echo "error";
                }
                if($row_materiasplanestudio['codigotipomateria'] == '4') {
                    $numerocreditoselectivas = $numerocreditoselectivas + $row_materiasplanestudio['numerocreditosdetalleplanestudio'];
                    $electivaslibresplan[] = $row_materiasplanestudio;
                    $tieneelectivas = true;
                }


            }else if($row_materiasplanestudio['codigotipomateria'] == '5'){
                // Aqui es para las lineas de enfasis
                $tieneenfasis = true;
                // Primero miro si el estudiante ya tiene linea de enfasis.
                $query_poseelineaenfasis = "select le.idlineaenfasisplanestudio ".
                " from lineaenfasisestudiante le".
                " where le.codigoestudiante = '$codigoestudiante' ".
                " and (NOW() between le.fechainiciolineaenfasisestudiante ".
                " and le.fechavencimientolineaenfasisestudiante)";
                $poseelineaenfasis = $db->Execute($query_poseelineaenfasis);
                $totalRows_poseelineaenfasis = $poseelineaenfasis->RecordCount();

                if($totalRows_poseelineaenfasis != "")
                {
                    // Selecciona las materias de la línea y efectua el proceso de carga para esas materias
                    $estudiantetieneenfasis = true;
                }
            }
			$idplanestudioini = $row_materiasplanestudio['idplanestudio'];
		}//while
		if($estudiantetieneenfasis){
			// Selecciona las materias de la linea de enfasis de este estudiante las cuales deben estar activas
			$query_materiaslineaenfasis = "select d.idplanestudio, d.idlineaenfasisplanestudio, ".
			" d.codigomateriadetallelineaenfasisplanestudio as codigomateria, m.nombremateria, ".
			" d.semestredetallelineaenfasisplanestudio*1 as semestredetalleplanestudio, t.nombretipomateria, ".
			" t.codigotipomateria, d.numerocreditosdetallelineaenfasisplanestudio as numerocreditosdetalleplanestudio ".
			" from detallelineaenfasisplanestudio d, materia m, tipomateria t, lineaenfasisestudiante l ".
			" where d.codigomateriadetallelineaenfasisplanestudio = m.codigomateria ".
			" and d.codigotipomateria = t.codigotipomateria ".
			" and l.idplanestudio = d.idplanestudio ".
			" and l.codigoestudiante = '$codigoestudiante' ".
			" and l.idlineaenfasisplanestudio = d.idlineaenfasisplanestudio ".
			" and d.codigoestadodetallelineaenfasisplanestudio like '1%' ".
			" and (NOW() between l.fechainiciolineaenfasisestudiante and l.fechavencimientolineaenfasisestudiante) ".
			" group by 3 order by 2,5";
			$materiaslineaenfasis = $db->Execute($query_materiaslineaenfasis);
			$totalRows_materiaslineaenfasis = $materiaslineaenfasis->RecordCount();
		}else if($tieneenfasis){
			// Selecciona todas las materias del plan de estudio que son enfais
			// Es decir toma todos los enfasis
			$query_materiaslineaenfasis = "select d.idplanestudio, d.idlineaenfasisplanestudio, ".
			" d.codigomateriadetallelineaenfasisplanestudio as codigomateria, m.nombremateria, ".
			" d.semestredetallelineaenfasisplanestudio*1 as semestredetalleplanestudio, t.nombretipomateria, ".
			" t.codigotipomateria, d.numerocreditosdetallelineaenfasisplanestudio as numerocreditosdetalleplanestudio ".
			" from detallelineaenfasisplanestudio d, materia m, lineaenfasisplanestudio l, tipomateria t ".
			" where d.idplanestudio = '$idplan' ".
			" and d.codigomateriadetallelineaenfasisplanestudio = m.codigomateria ".
			" and d.codigotipomateria = t.codigotipomateria ".
			" and l.idplanestudio = d.idplanestudio ".
			" group by 3 order by 2,5";
			$materiaslineaenfasis = $db->Execute($query_materiaslineaenfasis);
			$totalRows_materiaslineaenfasis = $materiaslineaenfasis->RecordCount();
		}
		if($totalRows_materiaslineaenfasis != ""){
			while($row_materiaslineaenfasis = $materiaslineaenfasis->FetchRow()){
				$quitarmateriasdelplandestudios = "$quitarmateriasdelplandestudios and m.codigomateria <> '".$row_materiaslineaenfasis['codigomateria']."'";
				$estadomateria = materiaaprobada($codigoestudiante, $row_materiaslineaenfasis['codigomateria'], $idplan, $reprobada);
				if($estadomateria == "porver"){
					$materiasporver[] = $row_materiaslineaenfasis;
				}else if($estadomateria == "reprobada"){
					// No la puse por que no hay linea de enfasis
					// Estas materias son obligatorias
					$materiasobligatorias[] = $row_materiaslineaenfasis;
					// Selección de la carga obligatoria
					$cargaobligatoria[] = $row_materiaslineaenfasis['codigomateria'];
					$materiasporver[] = $row_materiaslineaenfasis;
					$semestre[$row_materiaslineaenfasis['semestredetalleplanestudio']]++;
				}else if($estadomateria == "aprobada"){
					$materiaspasadas[] = $row_materiaslineaenfasis;
				}else{
					echo "error";
				}
			}//while
		}
		$materiasafiltrar = $materiasporver;
		$materiasconprerequisito = $materiasporver;
		if(isset($materiasobligatorias) && !empty($materiasobligatorias)){
            $materiasobigatoriasquitar = $materiasobligatorias;
        }else{
            $materiasobigatoriasquitar = "";
        }

		// Solamente se filtran las materias por ver, es decir las sugeridas
		if(isset($materiasafiltrar)){
			foreach($materiasafiltrar as $key1 => $value1){
				// Debe tomar las materias que no tengan prerequisito, o el prerequisito este aprobado
				// Las materias del anterior arreglo deben filtrarse por las que no tengan prerequisito o el prerequisito este aprobado.
				// Mejor dicho si el prereqisito de una materia no se encuentra en este mismo arreglo se acepta la materia si no No.
				$query_materiasprerequisito = "select r.codigomateriareferenciaplanestudio ".
				" from referenciaplanestudio r ".
				" where r.idplanestudio = '".$value1['idplanestudio']."' ".
				" and r.codigomateria = '".$value1['codigomateria']."' ".
				" and r.codigotiporeferenciaplanestudio like '1%' ".
				" and r.codigoestadoreferenciaplanestudio = '101'";
				$materiasprerequisito = $db->Execute($query_materiasprerequisito);
				$totalRows_materiasprerequisito = $materiasprerequisito->RecordCount();
				if($totalRows_materiasprerequisito != ""){
					$tieneprerequisito = false;
					while($row_materiasprerequisito = $materiasprerequisito->FetchRow()){
						// Cada una de las materias prerequisitos se busca en el arreglo, si esta no incluye la materia
						foreach($materiasconprerequisito as $key2 => $value2){
							if($row_materiasprerequisito['codigomateriareferenciaplanestudio'] == $value2['codigomateria']){
								$tieneprerequisito = true;
							}
						}//foreach
					}
					if(!$tieneprerequisito){
						$quitarobligatoria = false;
						if(!$quitarobligatoria){
							$materiaspropuestas[] = $value1;
							// Selección de la carga obligatoria
							$cargaobligatoria[] = $value1['codigomateria'];
							$semestre[$value1['semestredetalleplanestudio']]++;
						}
					}
				}else{
					$quitarobligatoria = false;
					if(!$quitarobligatoria){
						$materiaspropuestas[] = $value1;
						// Selección de la carga obligatoria
						$cargaobligatoria[] = $value1['codigomateria'];
						$semestre[$value1['semestredetalleplanestudio']]++;
					}
				}
			}//foreach
		}else{
			//echo '<h1 align="center">El estudiante no tiene materias para ver</h1>';
		}
	}else{
		//echo '<h1 align="center">Este estudiante no tiene asignado un plan de estudios</h1>';
		$tieneunplandeestudios = false;
		//exit();
	}
	$materiasretornar['aprobadas'] = $materiaspasadas;
	$materiasretornar['cargapropuesta'] = $materiaspropuestas;
	$materiasretornar['cargaobligatoria'] = $cargaobligatoria;
	return $materiasretornar;
}

?>