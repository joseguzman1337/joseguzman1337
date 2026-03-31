<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

function generacargaestudiante($codigoestudiante,$idplandeestudios,$objetobase){
// Proceso para generar la carga académica
// Toma todas las materias del plan de estudios
// La variable $quitaparacartas se usa para las cartas de los estudiantes graduandos
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
$quitaparacartas
order by 4,3";
//and d.codigotipomateria not like '5%'
//and d.codigotipomateria not like '4%'";
//echo "$query_materiasplanestudio<br>";
$materiasplanestudio=$objetobase->conexion->query($query_materiasplanestudio) or die("$query_materiasplanestudio");
$totalRows_materiasplanestudio = $materiasplanestudio->RecordCount();
//echo "Total: $totalRows_materiasplanestudio<br>";
$quitarmateriasdelplandestudios = "";
$tieneunplandeestudios = true;
if($totalRows_materiasplanestudio != "")
{
	// Este arreglo sirve para guardar el semestre que mas se repite
	// Tomo el maximo numero de semestres del plan de estudio
	$query_semestreplanes = "select max(cantidadsemestresplanestudio*1) as semestre
	from planestudio";
	$semestreplanes=$objetobase->conexion->query($query_semestreplanes) or die("$query_semestreplanes");
	$totalRows_semestreplanes = $semestreplanes->RecordCount;
	$row_semestreplanes = $semestreplanes->FetchRow();
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
	$conmateriaplan=0;
	while($row_materiasplanestudio = $materiasplanestudio->FetchRow())
	{				
		$materiasplandeestudio[$conmateriaplan]=$row_materiasplanestudio;
		$conmateriaplan++;
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
					/*if($row_materiasplanestudio["codigomateria"]==739){
						echo "<pre>";
						print_r($materiasporver);
						echo "</pre>";
					}*/

				//echo "materiaaprobada($codigoestudiante, ".$row_materiasplanestudio['codigomateria'].", ".$row_materiasplanestudio['idplanestudio'].", $reprobada, $sala<br>";
				$estadomateria = materiaaprobada($codigoestudiante, $row_materiasplanestudio['codigomateria'], $row_materiasplanestudio['idplanestudio'], $reprobada, $objetobase);
					//if($row_materiasplanestudio["codigomateria"]==739)
						//echo "ESTADO MATERIAS 739=".$estadomateria;
				
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
				and (NOW() between le.fechainiciolineaenfasisestudiante and le.fechavencimientolineaenfasisestudiante)";
				//and d.codigotipomateria not like '5%'
				//and d.codigotipomateria not like '4%'";
				//echo "$query_materiasplanestudio<br>";
				$poseelineaenfasis=$objetobase->conexion->query($query_poseelineaenfasis) or die("$query_poseelineaenfasis");
				$totalRows_poseelineaenfasis = $poseelineaenfasis->RecordCount();
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
		and (NOW() between l.fechainiciolineaenfasisestudiante and l.fechavencimientolineaenfasisestudiante)
		group by 3
		order by 2,5";
		//and d.codigotipomateria not like '5%'
		//and d.codigotipomateria not like '4%'";
		//echo "$query_materiaslineaenfasis<br>";
		$materiaslineaenfasis=$objetobase->conexion->query($query_materiaslineaenfasis) or die("$query_materiaslineaenfasis");
		$totalRows_materiaslineaenfasis = $materiaslineaenfasis->RecordCount();
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
		$materiaslineaenfasis=$objetobase->conexion->query($query_materiaslineaenfasis) or die("$query_materiaslineaenfasis");
		$totalRows_materiaslineaenfasis = $materiaslineaenfasis->RecordCount();
	}
	if($totalRows_materiaslineaenfasis != "")
	{
		while($row_materiaslineaenfasis = $materiaslineaenfasis->FetchRow())
		{
			$quitarmateriasdelplandestudios = "$quitarmateriasdelplandestudios and m.codigomateria <> '".$row_materiaslineaenfasis['codigomateria']."'";
			//echo "".$codigoestudiante.", ".$row_materiaslineaenfasis['codigomateria'].", ".$idplan.", ".$reprobada."<br>";
			$estadomateria = materiaaprobada($codigoestudiante, $row_materiaslineaenfasis['codigomateria'], $idplan, $reprobada,$objetobase);
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
		
		//echo "MATERIAS POR VER<pre>";
		//print_r($materiasobligatorias);
		//echo "</pre>";
		
		
				
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
			//if($value1['codigomateria']==739)
			//echo "$query_materiasprerequisito<br>";
			$materiasprerequisito=$objetobase->conexion->query($query_materiasprerequisito) or die("$query_materiasprerequisito");
			$totalRows_materiasprerequisito = $materiasprerequisito->RecordCount();
			if($totalRows_materiasprerequisito != "")
			{
				$tieneprerequisito = false;
				//echo "<br>PAPA: ".$value1['codigomateria']."";
				while($row_materiasprerequisito = $materiasprerequisito->FetchRow())
				{
					// Cada una de las materias prerequisitos se busca en el arreglo, si esta no incluye la materia
					foreach($materiasconprerequisito as $key2 => $value2)
					{
						//echo "<br>".$row_materiasprerequisito['codigomateriareferenciaplanestudio']." = ".$value2['codigomateria']."<br>";
						if($row_materiasprerequisito['codigomateriareferenciaplanestudio'] == $value2['codigomateria'])
						{
							//if($value1['codigomateria']==1121)
							//echo "<br>".$row_materiasprerequisito['codigomateriareferenciaplanestudio']." = ".$value2['codigomateria']."<br>";

							$tieneprerequisito = true;
							//return;
						}
					}
				}
				if(!$tieneprerequisito)
				{
					$quitarobligatoria = false;
					/*if(isset($materiasobigatoriasquitar))
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
					}*/
					if(!$quitarobligatoria)
					{
						$materiaspropuestas[] = $value1;
						/*echo "<pre>";
						print_r($materiaspropuestas);
						echo "</pre>";						
						echo "<br>";*/
						// Selección de la carga obligatoria
						$cargaobligatoria[] = $value1['codigomateria'];
						$semestre[$value1['semestredetalleplanestudio']]++;
					}
				}
			}
			else
			{
				$quitarobligatoria = false;
				/*if(isset($materiasobigatoriasquitar))
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
				}*/
				if(!$quitarobligatoria)
				{
					$materiaspropuestas[] = $value1;
					/*echo "<pre>";
					print_r($materiaspropuestas);
					echo "</pre>";

					echo "<br>";*/
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
	//echo "MATERIAS PROPUESTAS<pre>";
	//print_r($materiaspropuestas);
	//echo "</pre>";

	
}
else
{
	//echo '<h1 align="center">Este estudiante no tiene asignado un plan de estudios</h1>';
	$tieneunplandeestudios = false;
	//exit();
}
//exit();
//print_r($materiaspropuestas);

$listadomaterias["propuestas"]=$materiaspropuestas;
$listadomaterias["electivas"]=$electivaslibresplan;
$listadomaterias["quitarmaterias"]=$quitarmateriasdelplandestudios;
$listadomaterias["materiasplandeestudio"]=$materiasplandeestudio;
return $listadomaterias;
}

function encuentraprematricula($codigoperiodosesion,$codigoestudiante,$cursosvacacionalessesion,$objetobase){
//$codigoperiodo=$formulario->carga_periodo(4);
//$formulario->agregar_tablas('estudiante','codigoestudiante');
$query_premainicial1 = "SELECT d.codigomateria, d.codigotipodetalleprematricula
FROM detalleprematricula d, prematricula p, materia m, estudiante e
where d.codigomateria = m.codigomateria 
and d.idprematricula = p.idprematricula
and p.codigoestudiante = e.codigoestudiante
and e.codigoestudiante = '".$codigoestudiante."'
and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula = '23')
and p.codigoperiodo = '".$codigoperiodosesion."'";
//echo "$query_premainicial1<br>";
$premainicial1=$objetobase->conexion->query($query_premainicial1) or die("$query_premainicial1");
$totalRows_premainicial1 =$premainicial1->RecordCount();
$tieneprema = false;
while($row_premainicial1 = $premainicial1->FetchRow())
{
	$prematricula_inicial[] = $row_premainicial1['codigomateria'];
	//if(!isset($_SESSION['cursosvacacionalessesion']))
	//{
		// Si la materia ya esta como curso vacacional hay que quitarla de la prematricula
		//if(ereg("^2+",$row_premainicial1['codigotipodetalleprematricula']))
		if(isset($cursosvacacionalessesion))
		{
			$quitarporcursosvacacionales[$row_premainicial1['codigomateria']] = true;
		}
		else if(ereg("^2+",$row_premainicial1['codigotipodetalleprematricula']))
		{
			$quitarporcursosvacacionales[$row_premainicial1['codigomateria']] = true;
		}
		
	//}
	$tieneprema = true;
}

return $prematricula_inicial;
}
function recuperarmateriasgrupo($materiagrupo,$codigoperiodo,$objetobase){
				$query_datosgrupo = "select d.codigomateria, m.nombremateria, m.numerohorassemanales,
				 m.numerocreditos as numerocreditosdetalleplanestudio
				from detallegrupomateria d, materia m, grupomaterialinea gm
				where d.codigomateria = m.codigomateria
				and gm.codigomateria = '$materiagrupo'
				and gm.idgrupomateria = d.idgrupomateria
				and gm.codigoperiodo = '$codigoperiodo'
				order by m.nombremateria";
				//echo $query_datosgrupo,"<br><br>";
				$datosgrupo=$objetobase->conexion->query($query_datosgrupo) or die("$query_datosgrupo");
				$totalRows_datosgrupo = $datosgrupo->RecordCount();
				if($totalRows_datosgrupo != "")
				{
					$entroengrupo = false;
					$creditoshijo = "";
					while($row_datosgrupo = $datosgrupo->FetchRow())
					{
						$materiaselectivas[]=$row_datosgrupo;
						
					}
				}
			return $materiaselectivas;
}
function  recuperarelectivaslibres($quitarmateriasdelplandestudios,$codigoperiodo,$objetobase){
		$query_datoselectivas = "select m.codigomateria, m.nombremateria, m.numerohorassemanales, m.numerocreditos
		from materia m, grupomateria gm, detallegrupomateria d
		where gm.codigotipogrupomateria = '100'
		and gm.codigoperiodo = '$codigoperiodo'
		and d.idgrupomateria = gm.idgrupomateria
		and m.codigomateria = d.codigomateria
		$quitarmateriasdelplandestudios
		order by m.nombremateria";
		//echo "<br>$query_datoselectivas";
		$datoselectivas=$objetobase->conexion->query($query_datoselectivas) or die("$query_datoselectivas");
		$totalRows_datoselectivas = $datoselectivas->RecordCount();
		if($totalRows_datoselectivas != "")
		{
			$electivasaprobadas1 = $electivasaprobadas;
			$cuentamateriaselectivas = 0;
			while($row_datoselectivas = $datoselectivas->FetchRow())
			{
				$materiaselectivas[]=$row_datoselectivas;
			}
		}

return $materiaselectivas;
}
function anadirmaterias($materiaspropuestas,$quitarmateriasdelplandestudios,$codigoperiodo,$objetobase,$tipo){

$materiasanadidas=$materiaspropuestas;
$conadd=count($materiaspropuestas);
switch($tipo){
case "electivas":
			for($i=0;$i<count($materiaspropuestas);$i++){
				if(ereg("^1+",$materiaspropuestas[$i]['codigoindicadorgrupomateria']))
					$materiasanadidastmp[]=recuperarmateriasgrupo($materiaspropuestas[$i]['codigomateria'],$codigoperiodo,$objetobase);
			}
break;
case "electivaslibres":
			//for($i=0;$i<count($materiaspropuestas);$i++){
				//if(ereg("^1+",$materiaspropuestas[$i]['codigoindicadorgrupomateria']))
		$materiasanadidastmp[]=recuperarelectivaslibres($quitarmateriasdelplandestudios,$codigoperiodo,$objetobase);
			//}
break;
}

for($i=0;$i<count($materiasanadidastmp);$i++){
	for($j=0;$j<count($materiasanadidastmp[$i]);$j++){
		$materiasanadidas[$conadd]=$materiasanadidastmp[$i][$j];
		$conadd++;
	}
}

//echo "materiasanadidastmp<pre>";
//print_r($materiasanadidastmp);
//echo "</pre>";

return $materiasanadidas;

}

function encuentramateriasrestringidas($codigoperiodo,$codigoestudiante,$cursosvacacionalessesion,$postidplanestudio,$datosplanestudios,$objetobase){

			$tabla="planestudioestudiante";
			$nombreidtabla="idplanestudio";
			$idtabla=$datosplanestudios['idplanestudio'];
			$fechahoy=date("Y-m-d H:i:s");

			$prematricula_inicial=encuentraprematricula($codigoperiodo,$codigoestudiante,$cursosvacacionalessesion,$objetobase);

			$materiaspropuestas1=generacargaestudiante($codigoestudiante,$idplandeestudios,$objetobase);

			$materiaspropuestas1["propuestas"]=anadirmaterias($materiaspropuestas1["propuestas"],$materiaspropuestas1["quitarmaterias"],$codigoperiodo,$objetobase,"electivas");
			$materiaspropuestas1["propuestas"]=anadirmaterias($materiaspropuestas1["propuestas"],$materiaspropuestas1["quitarmaterias"],$codigoperiodo,$objetobase,"electivaslibres");

			//echo "<pre>";
			//print_r($materiaspropuestas1["propuestas"]);
			//echo "</pre>";

			unset($fila);
			$fila['idplanestudio']=$postidplanestudio;
			$condicion=" and codigoestudiante='$codigoestudiante' and
						('$fechahoy' between fechainicioplanestudioestudiante and fechavencimientoplanestudioestudiante)";
			$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla,$condicion,0);
			
			$materiaspropuestas2=generacargaestudiante($codigoestudiante,$idplandeestudios,$objetobase);
			$materiaspropuestas2["propuestas"]=anadirmaterias($materiaspropuestas2["propuestas"],$materiaspropuestas1["quitarmaterias"],$codigoperiodo,$objetobase,"electivas");
			$materiaspropuestas2["propuestas"]=anadirmaterias($materiaspropuestas2["propuestas"],$materiaspropuestas1["quitarmaterias"],$codigoperiodo,$objetobase,"electivaslibres");

			unset($fila);
			$fila['idplanestudio']=$datosplanestudios['idplanestudio'];
			$condicion=" and ('$fechahoy' between fechainicioplanestudioestudiante and fechavencimientoplanestudioestudiante)";
			$objetobase->actualizar_fila_bd($tabla,$fila,'codigoestudiante',$codigoestudiante,$condicion,0);


			/*echo "<pre>";
			print_r($prematricula_inicial);
			echo "</pre>";
			
			echo "<pre>";
			print_r($materiaspropuestas2["propuestas"]);
			echo "</pre>";*/

			
			
			for($i=0;$i<count($materiaspropuestas2["propuestas"]);$i++){
				$propuestas[$i]=$materiaspropuestas2["propuestas"][$i]['codigomateria'];
			}
			
			if(is_array($prematricula_inicial))
			$diferenciaplan=array_diff($prematricula_inicial,$propuestas);

			//echo "diferencia<pre>";
			//print_r($diferenciaplan);
			//echo "</pre>";
			
			for($i=0;$i<count($materiaspropuestas1["propuestas"]);$i++)
			{
				if(is_array($diferenciaplan))
					if(eregi("^[0-9]{1,15}$",array_search($materiaspropuestas1["propuestas"][$i]['codigomateria'],$diferenciaplan)))
						$materiasrestringidas[]=$materiaspropuestas1["propuestas"][$i];
			}

			return $materiasrestringidas;
}

function  imprimematerias($formulario,$materias,$titulo){


			unset($fila);
			$formulario->dibujar_fila_titulo($titulo,'labelresaltado',5);
			$fila["Codigo"]="";
			$fila["Asignatura"]="";
			$fila["Semestre"]="";
			$fila["Creditos"]="";
			$formulario->dibujar_filas_texto($fila,'tdtitulogris','','colspan=1','colspan=1');

			unset($fila);
			for($i=0;$i<count($materias);$i++)
			{	//if(!empty($estructuramateriashorarios[$materia][$grupo][$i]['horainicial'])){
				$fila[$materias[$i]["codigomateria"]]="";
				$fila[$materias[$i]["nombremateria"]]="";
				$fila[$materias[$i]["semestredetalleplanestudio"]]="";
				$fila[$materias[$i]["numerocreditosdetalleplanestudio"]]="";
				$formulario->dibujar_filas_texto($fila,'','','colspan=1','colspan=1');
				unset($fila);				
				//}
			}
			


}
function imprimebotones($formulario,$codigoestudiante,$listalineaenfasis=0,$imprimebotonactualiza=0){ 
			$formulario->boton_tipo('hidden','Actualizar2',1);

			$conboton=0;
			if($imprimebotonactualiza)
			{
			$parametrobotonenviar2[$conboton]="'submit','Actualizar','Actualizar definitivamente','onclick=\"return confirm(\'En realidad quiere guardar los cambios realizados\');\"'";
			$boton2[$conboton]='boton_tipo';
			$conboton++;
			}
			$parametrobotonenviar2[$conboton]="'Historial_Plan_Estudio','listadohistorialplanestudio.php','codigoestudiante=".$codigoestudiante."',900,300,5,5,'yes','yes','no','yes','yes'";
			$boton2[$conboton]='boton_ventana_emergente';
			$conboton++;
			if($listalineaenfasis){
				$parametrobotonenviar2[$conboton]="'Historial_Linea_Enfasis','listadohistoriallineaenfasis.php','codigoestudiante=".$codigoestudiante."',900,300,5,5,'yes','yes','no','yes','yes'";
				$boton2[$conboton]='boton_ventana_emergente';
				$conboton++;
			}

			$parametrobotonenviar2[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
			$boton2[$conboton]='boton_tipo';
			$formulario->dibujar_campos($boton2,$parametrobotonenviar2,"","tdtitulogris",'Enviar');

}
function encontrarperiodoshistorico($codigoestudiante,$objetobase){
		//if (! isset ($_GET['totalperiodos']) )
		//{
		   $query_historicoperiodos = "SELECT distinct n.codigoperiodo, p.nombreperiodo, e.codigosituacioncarreraestudiante  
           from notahistorico n, periodo p, estudiante e, carreraperiodo cp
           where n.codigoestudiante = '$codigoestudiante'
  		   and e.codigoestudiante = n.codigoestudiante
   		   and e.codigocarrera = cp.codigocarrera
		   and cp.codigoperiodo = p.codigoperiodo
  		   and n.codigoperiodo = cp.codigoperiodo
		   and n.codigoestadonotahistorico like '1%'
    	   order by 1";
		  //echo $query_historicoperiodos;												
           $res_historicoperiodos = $objetobase->conexion->query($query_historicoperiodos);
           $total_periodosperiodos = $res_historicoperiodos->RecordCount();

          $peridohistorico['totalperiodos'] = $total_periodosperiodos;
          $j = 0;
			  while ($solicitud_historicoperiodos = $res_historicoperiodos->FetchRow()){
				  //echo $solicitud_historicoperiodos['codigoperiodo'], "<br>";
				  $periodohistorico[$j] = $solicitud_historicoperiodos['codigoperiodo'];
				  //echo $periodoshistorico[$j],"<br>"; 
				  $j ++;
			  }
		 //}
		 
		return $periodohistorico;

}
function encuentrahistoricomateria($periodoshistorico,$codigoestudiante,$objetobase,$salatmp)
{

	$query_materiashistorico = "select n.codigomateria, n.notadefinitiva, case n.notadefinitiva > '5'
	when 0 then n.notadefinitiva
	when 1 then n.notadefinitiva / 100
	end as nota, n.codigoperiodo, m.nombremateria
	from notahistorico n, materia m
	where n.codigoestudiante = '$codigoestudiante' 
	and n.codigomateria = m.codigomateria
	AND codigoestadonotahistorico LIKE '1%'	
	order by 5, 3 ";	
	//echo $query_materiashistorico,"jaja"; 
	//exit();
	$materiashistorico = $objetobase->conexion->query($query_materiashistorico);
	$totalRows_materiashistorico = $materiashistorico->RecordCount();
	$cadenamateria = "";	
	
	while($row_materiashistorico = $materiashistorico->FetchRow())
	{
		// Coloco las materias equivalentes del estudiante en un arreglo y selecciono 
		// la mayor de esas notas, con el codigo de la materia mayor.
		// Arreglo de las materias con las mejores notas del estudiante
		if($materiapapaito = seleccionarequivalenciapapa($row_materiashistorico['codigomateria'],$codigoestudiante,$salatmp))
		{
			//echo "PAPA ".$row_materiashistorico['codigomateria']." $materiapapaito<br>";
			$formato = " n.codigomateria = ";
			// Con la materia papa selecciono las equivalencias y miro si estan en estudiante, y selecciono la mayor nota con su codigo
			// $Cad_equivalencias = seleccionarequivalenciascadena($materiapapaito, $codigoestudiante, $formato, $sala)."<br>";
			// $Array_materiashistorico[$row_materiashistorico['codigomateria']] = $row_materiashistorico;
			// echo "($cadequivalencias";	
			// exit();
			$row_mejornota =  seleccionarequivalenciasrow($materiapapaito, $codigoestudiante, $formato, $salatmp);
			$Array_materiashistorico[$row_mejornota['codigomateria']] = seleccionarequivalenciasrow($materiapapaito, $codigoestudiante, $formato, $salatmp);
			//echo "materia: ".$row_mejornota['codigomateria']." nota ".$row_mejornota['nota']."<br>";
		}
		else
		{
			$Array_materiashistorico[$row_materiashistorico['codigomateria']] = $row_materiashistorico;
		}
	}
	//exit();
	$Array_materiashistoricoinicial = $Array_materiashistorico;
	// Del arreglo que forme anteriormente debo quitar las equivalencias con menor nota
	// Para esto primero creo un arreglo con las equivalencias de cada materia
	foreach($Array_materiashistorico as $codigomateria => $row_materia)
	{
		//echo "$codigomateria => ".$row_materia['codigoperiodo']." => ".$row_materia['nota']."<br>";
		$otranota = $row_materia['nota']*100;
		// Arreglo bidimensional con las materias en cada periodo
		$cadenamateria = "$cadenamateria (n.codigomateria = '".$row_materia['codigomateria']."' and (n.notadefinitiva = '".$row_materia['nota']."' or n.notadefinitiva = '$otranota')) or";
		$Array_materiasperiodo[$row_materia['codigoperiodo']][] = $row_materia;
	}
	//exit();
	$cadenamateria = $cadenamateria."fin";
	$cadenamateria = ereg_replace("orfin","",$cadenamateria);



		$cuentacambioperiodo = 0;
		$sumaulas            = "&nbsp;";
		$sumacreditos        = "&nbsp;";
		$periodocalculo      = "";
		$indicadorperiodo    = 0;
		$ultimoperiodo       = 0;
		
		$conmateriashistorico=0;

		for ($i=0;$i<count($periodoshistorico);$i++)
  		{
			if ($periodoshistorico[$i] == true)
      		{	
				//echo "".$periodoshistorico[$i]."-<br>";
				unset($ultimoperiodo);
				$ultimoperiodo = $periodoshistorico[$i];
				if ($indicadorperiodo == 0)
		 		{
					$periodocalculo = "n.codigoperiodo = '".$periodoshistorico[$i]."'";
				  	$indicadorperiodo = 1;
		 		}
				else		
		 		{
		  			$periodocalculo = "$periodocalculo or n.codigoperiodo = '".$periodoshistorico[$i]."'";
		 		}
				if(!$graduadoegresado)
				{
					$query_historico = "SELECT n.idnotahistorico, n.codigoperiodo,m.nombremateria,m.codigomateria,n.codigomateriaelectiva,n.notadefinitiva,c.nombrecortocarrera,eg.expedidodocumento,ti.nombretitulo,
					t.nombretiponotahistorico,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,e.codigoestudiante,eg.numerodocumento,
					(m.ulasa+m.ulasb+m.ulasc) AS total,m.codigoindicadorcredito,m.numerocreditos,pe.nombreperiodo,doc.nombredocumento,e.codigotipoestudiante,n.codigotiponotahistorico, m.codigotipocalificacionmateria
					FROM notahistorico n,materia m,tiponotahistorico t,estudiante e,carrera c,titulo ti,periodo pe,documento doc,estudiantegeneral eg
					WHERE e.idestudiantegeneral = eg.idestudiantegeneral
					and n.codigoestudiante = '".$codigoestudiante."'
					AND n.codigoestadonotahistorico LIKE '1%'
					and n.codigoestudiante = e.codigoestudiante
					and n.codigotiponotahistorico = t.codigotiponotahistorico
					and eg.tipodocumento = doc.tipodocumento
					and e.codigocarrera = c.codigocarrera 
					and m.codigomateria = n.codigomateria
					and pe.codigoperiodo = n.codigoperiodo
					AND pe.codigoperiodo = '".$periodoshistorico[$i]."'
					and c.codigotitulo = ti.codigotitulo
					and ($cadenamateria)
					ORDER BY 1,2";
					//echo $query_historico;	
					//exit();											
					$res_historico = $objetobase->conexion->query($query_historico) ;
					//$solicitud_historico = mysql_fetch_assoc($res_historico);
				}
				else
				{
					$query_historico = "SELECT n.idnotahistorico, n.codigoperiodo,m.nombremateria,m.codigomateria,n.codigomateriaelectiva,n.notadefinitiva,c.nombrecortocarrera,eg.expedidodocumento,ti.nombretitulo,
					t.nombretiponotahistorico,eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,e.codigoestudiante,eg.numerodocumento,
					(m.ulasa+m.ulasb+m.ulasc) AS total,m.codigoindicadorcredito,m.numerocreditos,pe.nombreperiodo,doc.nombredocumento,e.codigotipoestudiante,n.codigotiponotahistorico, m.codigotipocalificacionmateria
					FROM notahistorico n,materia m,tiponotahistorico t,estudiante e,carrera c,titulo ti,periodo pe,documento doc,estudiantegeneral eg
					WHERE e.idestudiantegeneral = eg.idestudiantegeneral
					and n.codigoestudiante = '".$codigoestudiante."'
					AND n.codigoestadonotahistorico LIKE '1%'
					and n.codigoestudiante = e.codigoestudiante
					and n.codigotiponotahistorico = t.codigotiponotahistorico
					and eg.tipodocumento = doc.tipodocumento
					and e.codigocarrera = c.codigocarrera 
					and m.codigomateria = n.codigomateria
					and pe.codigoperiodo = n.codigoperiodo
					AND pe.codigoperiodo = '".$periodoshistorico[$i]."'
					and c.codigotitulo = ti.codigotitulo					
					and ($cadenamateria)
					ORDER BY 1,2";		//			and n.notadefinitiva >= m.notaminimaaprobatoria
					//echo $query_historico;
					//exit();
					$res_historico = $objetobase->conexion->query($query_historico);
				}
				while($solicitud_historico = $res_historico->FetchRow())
				{
					$mostrarpapa = "";
					if(!$graduadoegresado)
					{
						$query_materia = "SELECT *
						FROM notahistorico n
						WHERE n.codigoperiodo = '".$solicitud_historico['codigoperiodo']."'
						and n.codigoestudiante = '".$codigoestudiante."'
						AND n.codigoestadonotahistorico LIKE '1%'
						and ($cadenamateria)";
					}
					else
					{
						$query_materia = "SELECT *
						FROM notahistorico n, materia m
						WHERE n.codigoperiodo = '".$solicitud_historico['codigoperiodo']."'
						and n.codigoestudiante = '".$codigoestudiante."'
						AND n.codigoestadonotahistorico LIKE '1%'						
						and n.codigomateria = m.codigomateria
						and ($cadenamateria)";
					}
					// echo $query_historico;					and n.notadefinitiva >= m.notaminimaaprobatoria							
				  	$res_materia = $objetobase->conexion->query($query_materia);
				   	$solicitud_materia = $res_materia->FetchRow();
				   	$totalRows = $res_materia->RecordCount();	
					$query_materiaelectiva = "SELECT *
					FROM materia
					WHERE codigoindicadoretiquetamateria LIKE '1%'
					and codigomateria = '".$solicitud_historico['codigomateriaelectiva']."'";
					//echo $query_materiaelectiva;												
					$materiaelectiva = $objetobase->conexion->query($query_materiaelectiva);
					$row_materiaelectiva = $materiaelectiva->FetchRow();
					$totalRows_materiaelectiva = $materiaelectiva->RecordCount();	
					if($totalRows_materiaelectiva != "")
					{
						$solicitud_historico['codigomateria'] = $row_materiaelectiva['codigomateria'];
						$solicitud_historico['nombremateria'] = $row_materiaelectiva['nombremateria'];
						// Toca definir como hacer con el calculo de creditos (Se hace con el papa o con el hijo)
						//$solicitud_historico['codigoindicadorcredito'] = $row_materiaelectiva['codigoindicadorcredito'];
					}
				  else
	               {		   
						if ($solicitud_historico['codigomateriaelectiva'] <> "" and $solicitud_historico['codigomateriaelectiva'] <> "1")
						  {	
							$mostrarpapa = "";							
							$query_materiaelectiva1 = "SELECT nombremateria
							FROM materia
							WHERE codigomateria = ".$solicitud_historico['codigomateriaelectiva']."";
							//echo $query_materiaelectiva1;
							//echo $row_Recordset1['codigomateria']." as ".$query_materiaelectiva;												
							$materiaelectiva1 = $objetobase->conexion->query($query_materiaelectiva1) ;
							$row_materiaelectiva1 = $materiaelectiva1->FetchRow();
							$totalRows_materiaelectiva1 = $materiaelectiva1->RecordCount();	
							if ($totalRows_materiaelectiva1 <> 0)
							 {
							  $mostrarpapa = $row_materiaelectiva1['nombremateria'];
			                 }
						   }
  		           }				
					
					if($solicitud_historico['codigoperiodo'] != "")
					{								
						

						if ($periodo <> $solicitud_historico['codigoperiodo'])
						{
							$nombreultimoperiodo = $solicitud_historico['nombreperiodo'];
						}
						// Selecciona los datos de los sitios de rotación
							if($solicitud_historico['codigoindicadorcredito'] == 200)  
							{
								$sumaulas=$sumaulas+$solicitud_historico['total'];
							} 
							if($solicitud_historico['codigoindicadorcredito'] == 100)  
							{
									//echo $solicitud_historico['numerocreditos']; 
									$materiashistoricotmp[$conmateriashistorico]['numerocreditos']=$solicitud_historico['numerocreditos'];
							}	 

					 $materiashistoricotmp[$conmateriashistorico]['codigomateriaelectiva']=$solicitud_historico['codigomateriaelectiva'];
					 $materiashistoricotmp[$conmateriashistorico]['codigomateria'] = $solicitud_historico['codigomateria'];
					 $nombremateriatmp = "";
					  if ($mostrarpapa <> "")  $nombremateriatmp.="$mostrarpapa /  ";
						$nombremateriatmp.= $solicitud_historico['nombremateria'].$lugaresderotacion;
					  $materiashistoricotmp[$conmateriashistorico]['nombremateria'] = $nombremateriatmp;
					$materiashistoricotmp[$conmateriashistorico]['periodovisto'] =$periodoshistorico[$i];
    				  $conmateriashistorico++;

						if ($solicitud_historico['notadefinitiva'] > 5)
						{    
							//$nota = substr(($solicitud_historico['notadefinitiva'] / 100),0,3);	
							$nota = number_format(($solicitud_historico['notadefinitiva'] / 100),1);	       
						}
						else
						{
							$nota = number_format($solicitud_historico['notadefinitiva'],1);
						}
						$cuentacambioperiodo ++;    
		 				//echo "$cuentacambioperiodo == $totalRows <br>";
						if ($cuentacambioperiodo == $totalRows)
						{	
							$cuentacambioperiodo = 0;
							$periodosemestral = $solicitud_historico['codigoperiodo']; 
							//require('calculopromediosemestralmacheteado.php');
                            $promediosemestralperiodo = PeriodoSemestralReglamento ($codigoestudiante,$periodosemestral,$cadenamateria,$_GET['tipocertificado'],$salatmp);    
							if ($promediosemestralperiodo > 5)
							{
								$promediosemestralperiodo =  number_format(($promediosemestralperiodo / 100),1);		  	
							}
							$promediosemestralperiodo = number_format($promediosemestralperiodo,1);
				//$total = substr($solicitud_historico['notadefinitiva'],0,3); 
							$numero =  substr($promediosemestralperiodo,0,1); 	   
							$numero2 = substr($promediosemestralperiodo,2,2); 
							//require('convertirnumeros.php');
							//echo $numu."&nbsp;&nbsp;".$numu2."&nbsp;";
							$sumaulas="&nbsp;";
							$sumacreditos = "&nbsp;";
						}
						$periodo = $solicitud_historico['codigoperiodo'];
					}
				} //fin de while solicitud_historico
				
			//} // if 1	
		} // if	
	} //for

return $materiashistoricotmp;
}
function encuentramateriashistorico($codigoperiodo,$codigoestudiante,$cursosvacacionalessesion,$postidplanestudio,$datosplanestudios,$objetobase,$salatmp){

			$tabla="planestudioestudiante";
			$nombreidtabla="idplanestudio";
			$idtabla=$datosplanestudios['idplanestudio'];
			$fechahoy=date("Y-m-d H:i:s");

			$prematricula_inicial=encuentraprematricula($codigoperiodo,$codigoestudiante,$cursosvacacionalessesion,$objetobase);

			$materiaspropuestas1=generacargaestudiante($codigoestudiante,$idplandeestudios,$objetobase);
			$materiaspropuestas1["propuestas"]=anadirmaterias($materiaspropuestas1["propuestas"],$materiaspropuestas1["quitarmaterias"],$codigoperiodo,$objetobase,"electivas");
			$materiaspropuestas1["propuestas"]=anadirmaterias($materiaspropuestas1["propuestas"],$materiaspropuestas1["quitarmaterias"],$codigoperiodo,$objetobase,"electivaslibres");

			$periodoshistorico=encontrarperiodoshistorico($codigoestudiante,$objetobase);
			$materiashistorico=encuentrahistoricomateria($periodoshistorico,$codigoestudiante,$objetobase,$salatmp);
			
			unset($fila);
			$fila['idplanestudio']=$postidplanestudio;
			$condicion=" and codigoestudiante='$codigoestudiante' and
						('$fechahoy' between fechainicioplanestudioestudiante and fechavencimientoplanestudioestudiante)";
			$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla,$condicion,0);
			
			$materiaspropuestas2=generacargaestudiante($codigoestudiante,$idplandeestudios,$objetobase);
			$materiaspropuestas2["propuestas"]=anadirmaterias($materiaspropuestas2["propuestas"],$materiaspropuestas1["quitarmaterias"],$codigoperiodo,$objetobase,"electivas");
			$materiaspropuestas2["propuestas"]=anadirmaterias($materiaspropuestas2["propuestas"],$materiaspropuestas1["quitarmaterias"],$codigoperiodo,$objetobase,"electivaslibres");

			unset($fila);
			$fila['idplanestudio']=$datosplanestudios['idplanestudio'];
			$condicion=" and ('$fechahoy' between fechainicioplanestudioestudiante and fechavencimientoplanestudioestudiante)";
			$objetobase->actualizar_fila_bd($tabla,$fila,'codigoestudiante',$codigoestudiante,$condicion,0);

			echo "<pre>";
			//print_r($materiaspropuestas2["materiasplandeestudio"]);
			echo "</pre>";
			
			/*echo "<pre>";
			print_r($prematricula_inicial);
			echo "</pre>";
			*/			
			/*echo "<pre>";
			print_r($materiaspropuestas2["propuestas"]);
			echo "</pre>";*/			
			/*echo "<pre>";
			print_r($materiashistorico);
			echo "</pre>";*/
			
			for($i=0;$i<count($materiaspropuestas2["materiasplandeestudio"]);$i++){
				$planestudionuevo[$i]=$materiaspropuestas2["materiasplandeestudio"][$i]['codigomateria'];
			}

			for($i=0;$i<count($materiashistorico);$i++){
				/*if(trim($materiashistorico[$i]['codigomateriaelectiva'])!="1"){
				echo $materiashistorico[$i]['codigomateriaelectiva']."=>".$listahistorico[$i]."=".$materiashistorico[$i]['codigomateria'].";";
				echo "<br>";	
					$listahistorico[$i]=$materiashistorico[$i]['codigomateriaelectiva'];
				}
				else*/
					$listahistorico[$i]=$materiashistorico[$i]['codigomateria'];				
			}

			$diferenciaplan=array_diff($listahistorico,$planestudionuevo);

			/*echo "diferencia<pre>";
			print_r($diferenciaplan);
			echo "</pre>";*/
			
			for($i=0;$i<count($materiaspropuestas1["materiasplandeestudio"]);$i++)
			{
				if(is_array($diferenciaplan))	
				if(eregi("^[0-9]{1,15}$",array_search($materiaspropuestas1["materiasplandeestudio"][$i]['codigomateria'],$diferenciaplan))){
					$materiaspropuestas1["materiasplandeestudio"][$i]["equivalencias"]=seleccionarequivalencias($materiaspropuestas1["materiasplandeestudio"][$i]['codigomateria'], $postidplanestudio, $salatmp);
					if(!is_array($materiaspropuestas1["materiasplandeestudio"][$i]["equivalencias"]))
						$materiasrestringidas[]=$materiaspropuestas1["materiasplandeestudio"][$i];
				}
			}

			/*echo "materiasrestringidas<pre>";
			print_r($materiasrestringidas);
			echo "</pre>";*/

			return $materiasrestringidas;
}

function encuentramateriasrestringidasenfasis($codigoperiodo,$codigoestudiante,$cursosvacacionalessesion,$postidlineaenfasisplanestudio,$datoslineaenfasis,$objetobase){
	
			$tabla="lineaenfasisestudiante";
			$nombreidtabla="idplanestudio";
			$idtabla=$datoslineaenfasis['idplanestudio'];
			
			$fechahoy=date("Y-m-d H:i:s");

			$prematricula_inicial=encuentraprematricula($codigoperiodo,$codigoestudiante,$cursosvacacionalessesion,$objetobase);

			$materiaspropuestas1=generacargaestudiante($codigoestudiante,$idplandeestudios,$objetobase);

			$materiaspropuestas1["propuestas"]=anadirmaterias($materiaspropuestas1["propuestas"],$materiaspropuestas1["quitarmaterias"],$codigoperiodo,$objetobase,"electivas");
			$materiaspropuestas1["propuestas"]=anadirmaterias($materiaspropuestas1["propuestas"],$materiaspropuestas1["quitarmaterias"],$codigoperiodo,$objetobase,"electivaslibres");

			//echo "<pre>";
			//print_r($materiaspropuestas1["propuestas"]);
			//echo "</pre>";

			unset($fila);
			echo "<pre>";
			//print_r($datoslineaenfasis);
			echo "</pre>";

			$fila['idlineaenfasisplanestudio']=$postidlineaenfasisplanestudio;
			$condicion=" and codigoestudiante='".$codigoestudiante."'
					and ('$fechahoy' between fechainiciolineaenfasisestudiante and fechavencimientolineaenfasisestudiante)";
			$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla,$condicion,0);
			
			$materiaspropuestas2=generacargaestudiante($codigoestudiante,$idplandeestudios,$objetobase);
			$materiaspropuestas2["propuestas"]=anadirmaterias($materiaspropuestas2["propuestas"],$materiaspropuestas1["quitarmaterias"],$codigoperiodo,$objetobase,"electivas");
			$materiaspropuestas2["propuestas"]=anadirmaterias($materiaspropuestas2["propuestas"],$materiaspropuestas1["quitarmaterias"],$codigoperiodo,$objetobase,"electivaslibres");

			unset($fila);
			
			$fila['idlineaenfasisplanestudio']=$datoslineaenfasis['idlineaenfasisplanestudio'];
			$condicion="and ('$fechahoy' between fechainiciolineaenfasisestudiante and fechavencimientolineaenfasisestudiante)";
			$objetobase->actualizar_fila_bd($tabla,$fila,'codigoestudiante',$codigoestudiante,$condicion,0);


			/*echo "<pre>";
			print_r($prematricula_inicial);
			echo "</pre>";*/
			echo "<pre>";
			//print_r($materiaspropuestas1["propuestas"]);
			echo "</pre>";
			
			for($i=0;$i<count($materiaspropuestas2["propuestas"]);$i++){
				$propuestas[$i]=$materiaspropuestas2["propuestas"][$i]['codigomateria'];
			}
			if(is_array($prematricula_inicial))
			$diferenciaplan=array_diff($prematricula_inicial,$propuestas);

			
			for($i=0;$i<count($materiaspropuestas1["propuestas"]);$i++)
			{
				//echo "if(array_search(".$materiaspropuestas1["propuestas"][$i]['codigomateria'].",".$diferenciaplan.")!='') <br>";
				//if($materiaspropuestas1["propuestas"][$i]['codigomateria']==1536)
				//echo "resultadosearch=".array_search($materiaspropuestas1["propuestas"][$i]['codigomateria'],$diferenciaplan)."<br>";
				//echo "resultadosearch=".array_search($materiaspropuestas1["propuestas"][$i]['codigomateria'],$diferenciaplan)."<br>";
				//unset($indice);
				//$indice=array_search($materiaspropuestas1["propuestas"][$i]['codigomateria'],$diferenciaplan);
				if(is_array($diferenciaplan)){
					if(eregi("^[0-9]{1,15}$",array_search($materiaspropuestas1["propuestas"][$i]['codigomateria'],$diferenciaplan))){
						$materiasrestringidas[]=$materiaspropuestas1["propuestas"][$i];
						
				}
					//print_r($materiaspropuestas1["propuestas"][$i]);
					//echo "".$diferenciaplan[$indice]."<br>" ;
				}
			}

/* 			echo "diferencia<pre>";
			print_r($diferenciaplan);
			echo "</pre>";

			echo "materiasrestringidas<pre>";
			print_r($materiasrestringidas);
			echo "</pre>";
 */
			return $materiasrestringidas;
}

function encuentramateriashistoricoenfasis($codigoperiodo,$codigoestudiante,$cursosvacacionalessesion,$postidlineaenfasisplanestudio,$datoslineaenfasis,$objetobase,$salatmp){

			$tabla="lineaenfasisestudiante";
			$nombreidtabla="idplanestudio";
			$idtabla=$datoslineaenfasis['idplanestudio'];
			$fechahoy=date("Y-m-d H:i:s");

			$prematricula_inicial=encuentraprematricula($codigoperiodo,$codigoestudiante,$cursosvacacionalessesion,$objetobase);

			$materiaspropuestas1=generacargaestudiante($codigoestudiante,$idplandeestudios,$objetobase);
			$materiaspropuestas1["propuestas"]=anadirmaterias($materiaspropuestas1["propuestas"],$materiaspropuestas1["quitarmaterias"],$codigoperiodo,$objetobase,"electivas");
			$materiaspropuestas1["propuestas"]=anadirmaterias($materiaspropuestas1["propuestas"],$materiaspropuestas1["quitarmaterias"],$codigoperiodo,$objetobase,"electivaslibres");

			$periodoshistorico=encontrarperiodoshistorico($codigoestudiante,$objetobase);
			$materiashistorico=encuentrahistoricomateria($periodoshistorico,$codigoestudiante,$objetobase,$salatmp);
			
			unset($fila);
			//echo "DATOSLINEAENFASIS<pre>";
			//print_r($datoslineaenfasis);
			//echo "</pre>";

			$fila['idlineaenfasisplanestudio']=$postidlineaenfasisplanestudio;
			$condicion=" and codigoestudiante='".$codigoestudiante."'
			and ('$fechahoy' between fechainiciolineaenfasisestudiante and fechavencimientolineaenfasisestudiante)";
			$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla,$condicion,0);
			
			$materiaspropuestas2=generacargaestudiante($codigoestudiante,$idplandeestudios,$objetobase);
			$materiaspropuestas2["propuestas"]=anadirmaterias($materiaspropuestas2["propuestas"],$materiaspropuestas1["quitarmaterias"],$codigoperiodo,$objetobase,"electivas");
			$materiaspropuestas2["propuestas"]=anadirmaterias($materiaspropuestas2["propuestas"],$materiaspropuestas1["quitarmaterias"],$codigoperiodo,$objetobase,"electivaslibres");

			unset($fila);

			$fila['idlineaenfasisplanestudio']=$datoslineaenfasis['idlineaenfasisplanestudio'];
			$condicion="and ('$fechahoy' between fechainiciolineaenfasisestudiante and fechavencimientolineaenfasisestudiante)";
			$objetobase->actualizar_fila_bd($tabla,$fila,'codigoestudiante',$codigoestudiante,$condicion,0);

			//echo "<pre>";
			//print_r($materiaspropuestas2["materiasplandeestudio"]);
			//echo "</pre>";			
			/*echo "<pre>";
			print_r($prematricula_inicial);
			echo "</pre>";
			*/			
			/*echo "<pre>";
			print_r($materiaspropuestas2["propuestas"]);
			echo "</pre>";*/			
			/*echo "<pre>";
			print_r($materiashistorico);
			echo "</pre>";*/
			
			for($i=0;$i<count($materiaspropuestas2["materiasplandeestudio"]);$i++){
				$planestudionuevo[$i]=$materiaspropuestas2["materiasplandeestudio"][$i]['codigomateria'];
			}

			for($i=0;$i<count($materiashistorico);$i++){
				/*if(trim($materiashistorico[$i]['codigomateriaelectiva'])!="1"){
				echo $materiashistorico[$i]['codigomateriaelectiva']."=>".$listahistorico[$i]."=".$materiashistorico[$i]['codigomateria'].";";
				echo "<br>";	
					$listahistorico[$i]=$materiashistorico[$i]['codigomateriaelectiva'];
				}
				else*/
					$listahistorico[$i]=$materiashistorico[$i]['codigomateria'];				
			}

			$diferenciaplan=array_diff($listahistorico,$planestudionuevo);

			/*echo "diferencia<pre>";
			print_r($diferenciaplan);
			echo "</pre>";*/
			
			for($i=0;$i<count($materiaspropuestas1["materiasplandeestudio"]);$i++)
			{
				if(is_array($diferenciaplan))
				if(eregi("^[0-9]{1,15}$",array_search($materiaspropuestas1["materiasplandeestudio"][$i]['codigomateria'],$diferenciaplan))){
					$materiaspropuestas1["materiasplandeestudio"][$i]["equivalencias"]=seleccionarequivalencias($materiaspropuestas1["materiasplandeestudio"][$i]['codigomateria'], $postidplanestudio, $salatmp);
					if(!is_array($materiaspropuestas1["materiasplandeestudio"][$i]["equivalencias"]))
						$materiasrestringidas[]=$materiaspropuestas1["materiasplandeestudio"][$i];
				}
			}

			return $materiasrestringidas;
}


?>
