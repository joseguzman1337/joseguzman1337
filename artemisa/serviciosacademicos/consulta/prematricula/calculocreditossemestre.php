<?php

// Recibe la materias del estudiante, la conexión, el codigoestudiante

// El calculo de creditos debe contener solamente aquellas materias que tengan concepto matricula
function estagrupo_jornada($sala, $codigomateria, $codigoestudiante, $codigoperiodo)
{
	// Toma el grupo que tiene inscrito el estudiante
	$query_datagrupo = "SELECT d.idgrupo, h.codigodia, h.horainicial, h.horafinal, e.codigojornada, e.codigocarrera
	FROM detalleprematricula d, prematricula p, estudiante e, horario h, grupo g
	where d.idprematricula = p.idprematricula
	and p.codigoestudiante = e.codigoestudiante
	and e.codigoestudiante = '$codigoestudiante'
	and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
	and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%')
	and p.codigoperiodo = '$codigoperiodo'
	and d.codigomateria = '$codigomateria'
	and h.idgrupo = d.idgrupo
	and g.idgrupo = h.idgrupo
	and g.codigoindicadorhorario like '1%'";
	$datagrupo = mysql_query($query_datagrupo, $sala) or die("$query_datagrupo");
	$totalRows_datagrupo = mysql_num_rows($datagrupo);

	if($totalRows_datagrupo != ""){
		while($row_datagrupo = mysql_fetch_array($datagrupo)){
			// Mira si la hora inicio y hora final estan en su jornada junto con el dia
			$query_selcobroexcedente = "select c.nombrecobroexcedentecambiojornada, dc.horainiciodetallecobroexcedentecambiojornada, dc.horafinaldetallecobroexcedentecambiojornada
			from cobroexcedentecambiojornada c, detallecobroexcedentecambiojornada dc, subperiodo s, carreraperiodo cp
			where c.codigojornada = '".$row_datagrupo['codigojornada']."'
			and c.codigocarrera = '".$row_datagrupo['codigocarrera']."'
			and dc.idcobroexcedentecambiojornada = c.idcobroexcedentecambiojornada
			and dc.codigodia = '".$row_datagrupo['codigodia']."'
			and c.codigoestado like '1%'
			and dc.codigoestado like '1%'
			and cp.codigoperiodo = '$codigoperiodo'
			and s.idcarreraperiodo = cp.idcarreraperiodo
			and s.idsubperiodo = c.idsubperiodo
			and '".$row_datagrupo['horainicial']."' between dc.horainiciodetallecobroexcedentecambiojornada and dc.horafinaldetallecobroexcedentecambiojornada
			and '".$row_datagrupo['horafinal']."' between dc.horainiciodetallecobroexcedentecambiojornada and dc.horafinaldetallecobroexcedentecambiojornada";
			$selcobroexcedente=mysql_query($query_selcobroexcedente, $sala) or die("$query_selcobroexcedente".mysql_error());
			$totalRows_selcobroexcedente = mysql_num_rows($selcobroexcedente);

			if($totalRows_selcobroexcedente == "" || $totalRows_selcobroexcedente == 0){
				// Mira si la carrera esta controlando el cambio de jornada
				$query_selcobroexcedente = "select c.nombrecobroexcedentecambiojornada, dc.horainiciodetallecobroexcedentecambiojornada, dc.horafinaldetallecobroexcedentecambiojornada
				from cobroexcedentecambiojornada c, detallecobroexcedentecambiojornada dc, subperiodo s, carreraperiodo cp
				where c.codigojornada = '".$row_datagrupo['codigojornada']."'
				and c.codigocarrera = '".$row_datagrupo['codigocarrera']."'
				and dc.idcobroexcedentecambiojornada = c.idcobroexcedentecambiojornada
				and dc.codigodia = '".$row_datagrupo['codigodia']."'
				and c.codigoestado like '1%'
				and dc.codigoestado like '1%'
				and cp.codigoperiodo = '$codigoperiodo'
				and s.idcarreraperiodo = cp.idcarreraperiodo
				and s.idsubperiodo = c.idsubperiodo";
				$selcobroexcedente=mysql_query($query_selcobroexcedente, $sala) or die("$query_selcobroexcedente".mysql_error());
				$totalRows_selcobroexcedente = mysql_num_rows($selcobroexcedente);

				// Si entra es por que debe controlar y el grupo esta en otra jornada
				if($totalRows_selcobroexcedente != ""){
					return false;
				}
			}
		}
	}
	return true;
}

function calcular_valormatriculaotrajornada($sala, $codigocarrera, $codigoperiodo, $codigojornada,$codigoestudiante=false){ //,
	$valor = 0;
    $tabla ="";
    $Condicion = "";
    if(isset($codigocarrera) && !empty($codigocarrera)){
    	$sqlmodalidad = "select codigomodalidadacademica from carrera where codigocarrera = $codigocarrera";
		$selmodalidad=mysql_query($sqlmodalidad, $sala);
		$row_modalidad = mysql_fetch_array($selmodalidad);
		// debido a que los programas de pregrado manejan jornada nocturna para los demas devuelve 0
		if(!empty($row_modalidad['codigomodalidadacademica']) && $row_modalidad['codigomodalidadacademica'] != "200"){
			 $valor =0;
		}else{
			if($codigoestudiante){

				$query_selplanestudiante= "select p.idplanestudio
				from planestudioestudiante p, planestudio pe
				where p.codigoestudiante = '$codigoestudiante'
				and p.idplanestudio = pe.idplanestudio
				and pe.codigoestadoplanestudio like '1%'
				and p.codigoestadoplanestudioestudiante like '1%'";
				$selplanestudiante=mysql_query($query_selplanestudiante, $sala) or die("$query_selplanestudiante".mysql_error());
				$totalRows_selplanestudiante = mysql_num_rows($selplanestudiante);
				$row_selplanestudiante = mysql_fetch_array($selplanestudiante);
				$idplan = $row_selplanestudiante['idplanestudio'];
				if($idplan=='615' || $idplan==615){
					$Condicion = ' AND c.idplanestudio=516';
				}else{
					$tabla = '';
					$Condicion = "";
				}

			}

			// Voy a la tabla jornadacarrera y hallo el plan de estudio y la cohorte
			// de la que debe sacar el valor
		    $query_selcobroexcedente = "select c.nombrecobroexcedentecambiojornada, c.idplanestudio, c.idcohorte
			from cobroexcedentecambiojornada c, subperiodo s, carreraperiodo cp ".$tabla."
			where c.codigojornada = '$codigojornada'
			and c.codigocarrera = '$codigocarrera'
			and c.codigoestado like '1%'
			and cp.codigoperiodo = '$codigoperiodo'
			and s.idcarreraperiodo = cp.idcarreraperiodo
			and s.idsubperiodo = c.idsubperiodo
			 ".$Condicion.";";
			$selcobroexcedente=mysql_query($query_selcobroexcedente, $sala) or die("$query_selcobroexcedente".mysql_error());


			$totalRows_selcobroexcedente = mysql_num_rows($selcobroexcedente);
			$row_selcobroexcedente = mysql_fetch_array($selcobroexcedente);
			// Ahora con la cohorte y el semestre hallo el valor
			$query_selcohorte = "select max(dc.valordetallecohorte) as valordetallecohorte
			from detallecohorte dc
			where dc.idcohorte = '".$row_selcobroexcedente['idcohorte']."'";
			$selcohorte = mysql_query($query_selcohorte, $sala) or die("$query_selcohorte".mysql_error());
			$totalRows_selcohorte = mysql_num_rows($selcohorte);
			$row_selcohorte = mysql_fetch_array($selcohorte);

			if (!isset($row_selcobroexcedente['idplanestudio']) || empty($row_selcobroexcedente['idplanestudio'])) {
				$idplan = $row_selplanestudiante['idplanestudio'];
			}else{
				$idplan = $row_selcobroexcedente['idplanestudio'];
			}
			// Ahora con el plan de estudio hallo el numero de creditos del plan de estudios, y hallo el valor por credito
			// del plan de estudio
			$query_selcreditosplan = "SELECT p.idplanestudio, p.nombreplanestudio, p.fechacreacionplanestudio,
			p.responsableplanestudio, p.cargoresponsableplanestudio, p.cantidadsemestresplanestudio,
			c.nombrecarrera, p.numeroautorizacionplanestudio, t.nombretipocantidadelectivalibre,
			p.cantidadelectivalibre, p.fechainioplanestudio, p.fechavencimientoplanestudio, dp.codigomateria,
			dp.semestredetalleplanestudio, sum(dp.numerocreditosdetalleplanestudio) as creditos
			FROM planestudio p, carrera c, tipocantidadelectivalibre t, detalleplanestudio dp
			WHERE p.codigocarrera = c.codigocarrera
			AND p.codigotipocantidadelectivalibre = t.codigotipocantidadelectivalibre
			AND p.idplanestudio = '".$idplan."'
			and p.idplanestudio = dp.idplanestudio
			group by 1";
			$selcreditosplan = mysql_query($query_selcreditosplan, $sala) or die("$query_selcreditosplan".mysql_error());
			$row_selcreditosplan = mysql_fetch_array($selcreditosplan);

			// Multiplico el numero de semestres del plan de estudio por la cohorte mas alta y lo divido por los creditos del plan de estudio
			if(isset($row_selcreditosplan['creditos']) && $row_selcreditosplan['creditos'] == 0)
			{
				$valor = 0;
			}else
			{
				$valor = $row_selcohorte['valordetallecohorte']*$row_selcreditosplan['cantidadsemestresplanestudio']/
					$row_selcreditosplan['creditos'];
			}

		}
	}

	return $valor;
}

function calcularCreditosxSemestreMateriasMatriculadas($sala,$codigoperiodo,$codigoestudiante){
	$semestre = array();
	$obtenerMaterias = "SELECT d.codigomateria, d.codigomateriaelectiva, edp.nombreestadodetalleprematricula, d.idgrupo, d.numeroordenpago
				FROM detalleprematricula d, prematricula p, materia m, estudiante e, estadodetalleprematricula edp
				where d.codigomateria = m.codigomateria 
				and d.idprematricula = p.idprematricula
				and p.codigoestudiante = e.codigoestudiante
				and e.codigoestudiante = '$codigoestudiante'
				and edp.codigoestadodetalleprematricula = d.codigoestadodetalleprematricula
				and (p.codigoestadoprematricula like '4%')
				and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula = '23')
				and p.codigoperiodo = '$codigoperiodo'";

	$materiasMatriculadas = mysql_query($obtenerMaterias, $sala) or die("$obtenerMaterias".mysql_error());
	$totalRows = mysql_num_rows($materiasMatriculadas);
	for($i=0; $i<$totalRows; $i++){
		$row_materia = mysql_fetch_array($materiasMatriculadas);
		$codigo = $row_materia["codigomateriaelectiva"];
		if($row_materia["codigomateriaelectiva"]==0){
			$codigo = $row_materia["codigomateria"];
		}
		$query_materia = "select m.nombremateria, m.codigomateria, dpe.semestredetalleplanestudio, 
				dpe.numerocreditosdetalleplanestudio as numerocreditos from materia m, detalleplanestudio dpe, 
				planestudioestudiante pee where m.codigomateria = '$codigo' and pee.codigoestudiante = '$codigoestudiante' 
				and m.codigomateria = dpe.codigomateria and pee.idplanestudio = dpe.idplanestudio and pee.codigoestadoplanestudioestudiante like '1%'";
		$materiaDetalle = mysql_query($query_materia, $sala) or die("$query_materia".mysql_error());
		$row_detalle = mysql_fetch_array($materiaDetalle);
		if(isset($semestre[$row_detalle["semestredetalleplanestudio"]])){
			$semestre[$row_detalle["semestredetalleplanestudio"]] += $row_detalle["numerocreditos"];
		} else {
			$semestre[$row_detalle["semestredetalleplanestudio"]] = $row_detalle["numerocreditos"];
		}
	}
	return $semestre;
}

// Este script recibe los siguientes parametros:
// $codigoperiodo, $codigoestudiante y $usarcondetalleprematricula
// (True para hacerlo con lo que hay en prematricula, False para hacerlo con otro arreglo)
$cuentaelectivas = 0;
if($usarcondetalleprematricula){
	// Si no es colegio entra al if
	if($codigomodalidadacademica != 100){
		if(!isset($_SESSION['cursosvacacionalessesion'])){
			// De este query quito las ordenes de cuso de esducacion continuada
			$query_premainicial1 = "SELECT d.codigomateria, d.codigomateriaelectiva
			FROM detalleprematricula d, prematricula p, materia m, estudiante e
			where d.codigomateria = m.codigomateria
			and d.idprematricula = p.idprematricula
			and p.codigoestudiante = e.codigoestudiante
			and e.codigoestudiante = '$codigoestudiante'
			and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
			and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula = '23')
			and p.codigoperiodo = '$codigoperiodo'
            and d.codigomateria <> all (
            SELECT d.codigomateria
			FROM detalleprematricula d, prematricula p, materia m, estudiante e, detalleordenpago do, concepto c
			where d.codigomateria = m.codigomateria
			and d.idprematricula = p.idprematricula
			and p.codigoestudiante = e.codigoestudiante
			and e.codigoestudiante = '$codigoestudiante'
			and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
			and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula = '23')
			and p.codigoperiodo = '$codigoperiodo'
            and d.numeroordenpago = do.numeroordenpago
            and do.codigoconcepto = c.codigoconcepto
            and c.codigoindicadoraplicacobrocreditosacademicos like '1%'
            )";
		}
		else
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
		}
	}
	else
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
	}
	$premainicial1=mysql_query($query_premainicial1, $sala) or die("$query_premainicial1");
	$totalRows_premainicial1 = mysql_num_rows($premainicial1);
	if($totalRows_premainicial1){
		while($row_premainicial1 = mysql_fetch_array($premainicial1)){
			if($row_premainicial1['codigomateriaelectiva'] == ""){
				$materiaselegidas[] = $row_premainicial1['codigomateria'];
			}
			else{

				if(!isset($materiaselegidas[$row_premainicial1['codigomateriaelectiva']])){
					$materiaselegidas[$row_premainicial1['codigomateriaelectiva']] = $row_premainicial1['codigomateria'];
				}
				else{
					$cuentaelectivas++;
					$materiaselegidas[$row_premainicial1['codigomateriaelectiva']."elect$cuentaelectivas"] = $row_premainicial1['codigomateria'];
				}
			}
		}
	}
}

// Toma del plan de estudios los datos de las materias

// Este arreglo sirve para guardar el semestre que mas se repite
// Tomo el maximo numero de semestres del plan de estudio
$query_semestreplanes = "select max(cantidadsemestresplanestudio*1) as semestre from planestudio";
$semestreplanes=mysql_query($query_semestreplanes, $sala) or die("$query_semestreplanes");
$totalRows_semestreplanes = mysql_num_rows($semestreplanes);
$row_semestreplanes = mysql_fetch_array($semestreplanes);
for($semestreini = 1; $semestreini <= $row_semestreplanes['semestre']; $semestreini++){
	$semestre[$semestreini] = 0;
}
//$numerocreditoselectivas = 0;
$creditos = 0;
$creditosjornadaestudiante = 0;
$creditoscalculados = 0;
// En materiaselegidas debo guardar todo lo que halla sido insertado en detalleprematricula
$totalMateriaElectiva=0;

if(isset($materiaselegidas)){
	$semestreMatriculado=calcularCreditosxSemestreMateriasMatriculadas($sala,$codigoperiodo,$codigoestudiante);

	foreach($materiaselegidas as $codigomateriaelectiva2 => $codigomateria2){
		if(ereg($codigomateriaelectiva2,"^[0-9]{1,7}elect[0-9]+$")){
			ereg($codigomateriaelectiva2,"^[0-9]{1,7}",$registers);
			$codigmateriaelectiva2 = $registers[0];
		}
		$codigomateriaelectiva2=str_replace("grupo","",$codigomateriaelectiva2);
		$eselectivalibre = false;
		$eselectivatecnica = false;

		//consulta si la materia pertence al plan de estudio del estudiante
		$query_datosmateriaselegidas = "select m.nombremateria, m.codigomateria, dpe.semestredetalleplanestudio, 
		dpe.numerocreditosdetalleplanestudio as numerocreditos
		from materia m, detalleplanestudio dpe, planestudioestudiante pee
		where m.codigomateria = '$codigomateria2' and pee.codigoestudiante = '$codigoestudiante'
		and m.codigomateria = dpe.codigomateria and pee.idplanestudio = dpe.idplanestudio
		and pee.codigoestadoplanestudioestudiante like '1%'";
		$datosmateriaselegidas=mysql_query($query_datosmateriaselegidas, $sala) or die("$query_datosmateriaselegidas<br>".mysql_error());
		$totalRows_datosmateriaselegidas = mysql_num_rows($datosmateriaselegidas);

		if($totalRows_datosmateriaselegidas == ""){
			// consulta si la materia pertence a linea de enfasis
			$query_datosmateriaselegidas = "select m.nombremateria, m.codigomateria, 
			dle.semestredetallelineaenfasisplanestudio as semestredetalleplanestudio,
			dle.numerocreditosdetallelineaenfasisplanestudio as numerocreditos
			from materia m, detallelineaenfasisplanestudio dle, lineaenfasisestudiante lee
			where m.codigomateria = '$codigomateria2'
			and lee.codigoestudiante = '$codigoestudiante'
			and m.codigomateria = dle.codigomateriadetallelineaenfasisplanestudio
			and lee.idplanestudio = dle.idplanestudio
			and lee.idlineaenfasisplanestudio = dle.idlineaenfasisplanestudio
			and dle.codigoestadodetallelineaenfasisplanestudio like '1%'
			and (NOW() between lee.fechainiciolineaenfasisestudiante and lee.fechavencimientolineaenfasisestudiante)";
			$datosmateriaselegidas=mysql_query($query_datosmateriaselegidas, $sala) or die("$query_datosmateriaselegidas".mysql_error());
			$totalRows_datosmateriaselegidas = mysql_num_rows($datosmateriaselegidas);
			// Si se trata de una electiva
		}

		if($totalRows_datosmateriaselegidas == ""){
			// Mira si tiene papa, si el papa es electiva libre (posee idgrupolinea == 100) toma los creditos directamente del hijo
			// Si es tecnica toma los creditos directamente del papa
			// Si no tiene papa toma los datos como si fuera una materia externa
			$query_datosmateriapapa = "select m.nombremateria, m.codigomateria, dpe.semestredetalleplanestudio, 
			dpe.numerocreditosdetalleplanestudio as numerocreditos,
			dpe.codigotipomateria, gm.codigotipogrupomateria
			from grupomaterialinea gml, materia m, grupomateria gm, detalleplanestudio dpe, planestudioestudiante pee
			where gm.codigoperiodo = '$codigoperiodo' and gml.codigomateria = '$codigomateriaelectiva2'
			and gml.codigoperiodo = gm.codigoperiodo and gm.codigoperiodo = gml.codigoperiodo 
			and pee.codigoestudiante = '$codigoestudiante' and pee.idplanestudio = dpe.idplanestudio 
			and dpe.codigomateria = m.codigomateria and gml.codigomateria = m.codigomateria
			and gml.idgrupomateria = gm.idgrupomateria and pee.codigoestadoplanestudioestudiante like '1%'
			order by m.nombremateria";
			$datosmateriapapa = mysql_query($query_datosmateriapapa, $sala) or die("$query_datosmateriapapa");
			$totalRows_datosmateriapapa = mysql_num_rows($datosmateriapapa);

			if($totalRows_datosmateriapapa == ""){
				// Mira si se trata de una materia electiva
				$query_datosmateriapapa = "select m.nombremateria, m.codigomateria, dpe.semestredetalleplanestudio,
 				dpe.numerocreditosdetalleplanestudio as numerocreditos,
				dpe.codigotipomateria, m.codigoindicadorgrupomateria
				from materia m, detalleplanestudio dpe, planestudioestudiante pee
				where m.codigomateria = '$codigomateriaelectiva2' and pee.codigoestudiante = '$codigoestudiante'
				and pee.idplanestudio = dpe.idplanestudio and dpe.codigomateria = m.codigomateria
				and pee.codigoestadoplanestudioestudiante like '1%' order by m.nombremateria";
				$datosmateriapapa = mysql_query($query_datosmateriapapa, $sala) or die("$query_datosmateriapapa");
				$row_datosmateriapapa = mysql_fetch_array($datosmateriapapa);
				$totalRows_datosmateriapapa = mysql_num_rows($datosmateriapapa);

				if($row_datosmateriapapa['codigotipomateria'] == '4'){
					// La materia es electiva libre
					// Si entra es por que la materia hija es libre y debe tomar el numero de creditos de ella
					$query_datosmateriaselegidas = "select m.nombremateria, m.codigomateria, m.numerocreditos
					from materia m where m.codigomateria = '$codigomateria2' and m.codigoestadomateria = '01'";
					$datosmateriaselegidas = mysql_query($query_datosmateriaselegidas, $sala) or die("$query_datosmateriaselegidas");
					$cnsMateriaElectiva = mysql_fetch_array($datosmateriaselegidas);
					$totalMateriaElectiva += $cnsMateriaElectiva[2];
					$totalRows_datosmateriaselegidas = mysql_num_rows($datosmateriaselegidas);
					$eselectivalibre = true;
				}
				else{
					// En el caso de haber hecho la prematricula y de tratarse de una materia externa en carga academica se
					// Actualmente todos los planes de estudio tiene el mismo numero de creditos para una materia
					// Toca empezar a guardar el plan de estudio de la materia externa en cargaacademica y de este tomar el semestre y
					// y los creditos de la materia y efectuar el conteo de creditos a partir de aca.
					// Debido a que esto no se hiso  para el semestre 20052 toca dejar el codigo siguiente.
					$query_datosmateriaselegidas = "select m.nombremateria, m.codigomateria, 
					d.semestredetalleplanestudio, d.numerocreditosdetalleplanestudio as numerocreditos,
					d.codigotipomateria
					from materia m, detalleplanestudio d, cargaacademica c
					where m.codigomateria = '$codigomateria2' and m.codigoestadomateria = '01'
					and c.codigoestudiante = '$codigoestudiante' and c.codigomateria = d.codigomateria
					and c.idplanestudio = d.idplanestudio and c.codigomateria = m.codigomateria
					and d.codigoestadodetalleplanestudio like '1%' and c.codigoestadocargaacademica like '1%'";
					$datosmateriaselegidas=mysql_query($query_datosmateriaselegidas, $sala) or die("$query_datosmateriaselegidas");
					$totalRows_datosmateriaselegidas = mysql_num_rows($datosmateriaselegidas);
				}

				if($totalRows_datosmateriaselegidas == ""){
					$query_datosmateriaselegidas = "select m.nombremateria, m.codigomateria, m.numerocreditos, d.semestredetalleplanestudio
					from materia m, detalleplanestudio d where m.codigomateria = '$codigomateria2'
					and m.codigoestadomateria = '01' and d.codigomateria = m.codigomateria";
					$datosmateriaselegidas = mysql_query($query_datosmateriaselegidas, $sala) or die("$query_datosmateriaselegidas");
					$totalRows_datosmateriaselegidas = mysql_num_rows($datosmateriaselegidas);
				}
				else{
					/*Se declara una variable o bandera que indica que es una materia externa que tiene plan de estudio
					para que mas abajo no tenga en cuenta esta materia y no recalcule el semestre con esta materia*/
					$esmateriaexternaconplan=true;
				}

				// Si no pertenece a ningun plan de estudios, esta colocando el 1 por defecto.
				if($totalRows_datosmateriaselegidas == ""){
					/*
					Cuando se ha agregado como materia externa y no corresponde al plan de estudios se selecciona la informacion de la materia, en esta parte del codigo lo que se hizo
					fue agregar la validacion que mira si el tipo de materia es electiva libre con el fin de no cobrarla ya q se estaba generando cobro de creditos por materias de este tipo.
					Se hace la validacion y se crea la variable $numcreditoelectiva que acumula los creditos de electivas libres.
					Esta modificacion o ajuste se realizo el dia agosto 14 de 2013
					*/
					$query_datosmateriaselegidas = "select m.nombremateria, m.codigomateria, m.numerocreditos, 1 as semestredetalleplanestudio, m.codigotipomateria
					from materia m where m.codigomateria = '$codigomateria2' and m.codigoestadomateria = '01'";
					$datosmateriaselegidas = mysql_query($query_datosmateriaselegidas, $sala) or die("$query_datosmateriaselegidas");
					$totalRows_datosmateriaselegidas = mysql_num_rows($datosmateriaselegidas);
					$row_datosmateriaselegidas = mysql_fetch_array($datosmateriaselegidas);

					if($row_datosmateriaselegidas['codigotipomateria'] == '4'){
						$query_datosmateriaselegidas = "select m.nombremateria, m.codigomateria, m.numerocreditos
						from materia m where m.codigomateria = '$codigomateria2' and m.codigoestadomateria = '01'";
						$datosmateriaselegidas = mysql_query($query_datosmateriaselegidas, $sala) or die("$query_datosmateriaselegidas");
						$totalRows_datosmateriaselegidas = mysql_num_rows($datosmateriaselegidas);
						$numcreditoelectiva=$numcreditoelectiva+$row_datosmateriaselegidas['numerocreditos'];
						$eselectivalibre = true;
					}
					else{
						$query_datosmateriaselegidas = "select m.nombremateria, m.codigomateria, m.numerocreditos
						from materia m where m.codigomateria = '$codigomateria2' and m.codigoestadomateria = '01'";
						$datosmateriaselegidas = mysql_query($query_datosmateriaselegidas, $sala) or die("$query_datosmateriaselegidas");
						$totalRows_datosmateriaselegidas = mysql_num_rows($datosmateriaselegidas);
					}
				}
			}
			else{
				// Si entra aca quiere decir que la materia tiene hijos.
				$row_datosmateriapapa = mysql_fetch_array($datosmateriapapa);
				// Se hizo pro si coloco alguna materia libre en grupomaterialinea
				if($row_datosmateriapapa['codigotipogrupomateria'] == "100"){
					// Materia electiva libre
					// Si entra es por que la materia hija es libre y debe tomar el numero de creditos de ella
					$query_datosmateriaselegidas = "select m.nombremateria, m.codigomateria, m.numerocreditos
					from materia m where m.codigomateria = '$codigomateria2' and m.codigoestadomateria = '01'";
					$datosmateriaselegidas = mysql_query($query_datosmateriaselegidas, $sala) or die("$query_datosmateriaselegidas");
					$result = mysql_fetch_array($datosmateriaselegidas);
					$totalMateriaElectiva +=  $result[2];
					$totalRows_datosmateriaselegidas = mysql_num_rows($datosmateriaselegidas);
					$eselectivalibre = true;
				}
				else if($row_datosmateriapapa['codigotipogrupomateria'] == "200"){
					// Materia electiva tecnica
					// Si entra aca es por que la materia debe tomar el numero de creditos del papa
					$query_datosmateriaselegidas = "select m.nombremateria, m.codigomateria, m.numerocreditos
					from materia m where m.codigomateria = '$codigomateria2' and m.codigoestadomateria = '01'";
					$datosmateriaselegidas = mysql_query($query_datosmateriaselegidas, $sala) or die("$query_datosmateriaselegidas");
					$totalRows_datosmateriaselegidas = mysql_num_rows($datosmateriaselegidas);
					$creditospapa = $row_datosmateriapapa['numerocreditos'];
					$totalMateriaElectiva += $creditospapa;
					$eselectivatecnica = true;
				}
			}
		}

		if($totalRows_datosmateriaselegidas != ""){
            $row_datosmateriaselegidas = mysql_fetch_array($datosmateriaselegidas);
			$codigotipomateria = $row_datosmateriaselegidas['codigotipomateria'];
			$codigomateria = $row_datosmateriaselegidas['codigomateria'];

			if($eselectivatecnica){
				$creditosmateria = $creditospapa;
			}
			else if(!$eselectivalibre){
				$creditosmateria = $row_datosmateriaselegidas['numerocreditos'];
			    $creditos = $creditos + $creditosmateria;
				$estadoJornada = estagrupo_jornada($sala, $codigomateria2, $codigoestudiante, $codigoperiodo);
				if($estadoJornada){
				    $creditosjornadaestudiante = $creditosjornadaestudiante + $creditosmateria;
				}
				// Guardo la materiahija y le asigno el papa
				$materia[$codigomateriaelectiva2] = $codigomateria2;
				if(!$esmateriaexternaconplan){
					if($row_datosmateriaselegidas['semestredetalleplanestudio'] == "externa"){
						$semestre[$_GET['semestrerep']] = $semestre[$_GET['semestrerep']] + $creditosmateria;
			  		}
			  		else{
				 		if($row_datosmateriaselegidas['semestredetalleplanestudio'] == ""){
							$semestre[$row_datosmateriapapa['semestredetalleplanestudio']] = $semestre[$row_datosmateriapapa['semestredetalleplanestudio']] + $creditosmateria;
					  	}
					  	else{
							$semestre[$row_datosmateriaselegidas['semestredetalleplanestudio']] = $semestre[$row_datosmateriaselegidas['semestredetalleplanestudio']] + $creditosmateria;
					  	}
				  	}
				}
				else{
					 $semestre[$row_datosmateriaselegidas['semestredetalleplanestudio']] = $semestre[$row_datosmateriaselegidas['semestredetalleplanestudio']] + $creditosmateria;
				}
			}
		}
		else{
			echo "Esta materia $codigomateria2 no pertenece al plan de estudios<br>";
		}
	}//foreach

}
else{
	$semestre[1] = 1;
}
if(isset($semestre[''])){
	if($semestre[''] !=0 || $semestre[''] !=""){
		$semestreTemp = $semestre;
		$semestreTemp[""] = 0;
		$maximocreditos=max($semestreTemp);
		$buscarindice=array_search($maximocreditos, $semestreTemp);
		$semestre[$buscarindice]=$semestre[$buscarindice]+$semestre[''];
	}
}

/***** Total de creditos *******/
/***** Retorna el (los) semestre(s) con el valor máximo de creditos *****/
@$maxcreditos = max($semestre);
/************** Semestre real del alumno ********************/
// Coloca los semestre con mayor número de creditos en una matriz, tomandolos del primero al decimo
@$res_sem = array_keys ($semestre, $maxcreditos);
// Tooma el semestre de la primera posicion indicando que es el priemer semestre de los escogidos
$res_sem[0];

if(isset($semestreMatriculado) && !empty($semestreMatriculado)){
	$semestreF = $semestre;
	foreach($semestreMatriculado as $key=>$val){
		$semestreF[$key] += $val;
	}

	$maxs = array_keys($semestreF, max($semestreF));
	$res_sem[0] = $maxs[0];
}

if($res_sem[0] == 1 && $maxcreditos == 0){
    // Para seleccionar el periodo anterior hago lo siguiente
    $query_selperidoanterior = "select cp.idcarreraperiodo, p.codigoperiodo
    from periodo p, carreraperiodo cp where cp.codigoperiodo = p.codigoperiodo and cp.codigocarrera = '$codigocarrera'
    order by 2 desc";
    $selperidoanterior = mysql_db_query($database_sala,$query_selperidoanterior) or die("$query_selperidoanterior");
    $totalRows_seltotalcreditossemestre = mysql_num_rows($selperidoanterior);
    // Primer registro
    $row_selperidoanterior = mysql_fetch_array($selperidoanterior);
    // Segundo registro
    $row_selperidoanterior = mysql_fetch_array($selperidoanterior);

    // Selecciona el semestre que aparece en la prematricula del periodo anterior
   	// Si no hiso prematricula en el pasado le asigna el semestre que aparece en estudiante
 	$query_premainicial1 = "SELECT p.semestreprematricula
	FROM prematricula p
	where p.codigoestudiante = '$codigoestudiante'
    and p.codigoperiodo = '".$row_selperidoanterior['codigoperiodo']."'";
	$premainicial1=mysql_query($query_premainicial1, $sala) or die("$query_premainicial1");
	$row_premainicial1 = mysql_fetch_array($premainicial1);
    $totalRows_premainicial1 = mysql_num_rows($premainicial1);
    if($totalRows_premainicial1 != ""){
        // Selecciona el semestre de la prematricula, mira el plan de estudios si tiene, si el numero es mayor toma el del plan de estudio
        if($cuentaconplandeestudio){
            // Si el plan de estudio es mayor que el de la prematricula + 1, entonces toma el de la prematricula + 1
            // Si no toma el del plan de estudio
            if($cantidadsemestresplanestudio >= $row_premainicial1['semestreprematricula']+1){
                $res_sem[0] = $row_premainicial1['semestreprematricula']+1;
            }
            else{
                $res_sem[0] = $cantidadsemestresplanestudio;
            }
        }
        else{
            $res_sem[0] = $row_premainicial1['semestreprematricula']+1;
        }
    }
    else{
        $res_sem[0] = $semestredelestudiante;
    }
}

if($_SESSION['codigofacultad']==206 && (!isset($res_sem[0]) || $res_sem[0]=="") ){
    $_SESSION['codigo'];//Estudiante
    $_SESSION['codigoperiodosesion'];//Periodo

    $SQL='SELECT MAX(p.semestreprematricula)+1 
	FROM estudiante e INNER JOIN prematricula p ON p.codigoestudiante=e.codigoestudiante
	WHERE e.codigoestudiante="'.$_SESSION['codigo'].'" AND p.codigoestadoprematricula IN(40,41)';
	$SemestreAlterno=mysql_query($SQL, $sala) or die("$SQL");
	$row_SemestreAlterno = mysql_fetch_array($SemestreAlterno);
	$semestrecalculado = $row_SemestreAlterno[0];
}else{
    $semestrecalculado = $res_sem[0];
}

$creditoscalculados	= $creditos;
$creditosotrajornada = $creditoscalculados - $creditosjornadaestudiante;
if(isset($numcreditoelectiva) && !empty($numcreditoelectiva)){
	$numcreditoelectivalibre= $numcreditoelectiva;
}else{
	$numcreditoelectivalibre = $totalMateriaElectiva;
}
unset($materia);
unset($materiaselegidas);
?>
