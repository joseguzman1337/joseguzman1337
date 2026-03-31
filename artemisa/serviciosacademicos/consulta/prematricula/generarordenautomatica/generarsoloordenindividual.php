<?php
// Inicialmente es para generarle a los de primer semestre 
// Debido a que solamente funciona para materias obligatorias y propuestas
// Falta líneas de énfasis
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
require_once(realpath(dirname(__FILE__))."/../../../funciones/funcionip.php");
mysql_select_db($database_sala, $sala);

require_once('../../../funciones/clases/autenticacion/redirect.php' );
//require_once('funcionseleccionhorarios.php');
$codigoperiodo = $_SESSION['codigoperiodosesion'];
require('funcionvalidarcrucehorarios.php');
require('funcionseleccionarhorarios.php');

// Pagina de donde se llamo esta pagina
/*$pagina = $_SERVER['HTTP_REFERER'];
$inicio_pagina = strpos ($pagina, "?");
$dir = substr ($pagina, $inicio_pagina);
*/
$ffechapago = 1;

$codigo = $_GET['estudiante'];
$codigoestudiante = $_GET['estudiante'];
$fechapago = $_GET['fechapago'];
//echo "$codigo y $codigoperiodo y ".$_GET['programausadopor'];
require("fechadepago.php");

// Si la feha es invalida
if($ffechapago == 0)
{
?>
<script language="javascript">
	alert("La fecha digitada no es correcta");
	history.go(-1);
</script>
<?php
}
else if(isset($_GET['Aceptar']))
{
	require('../funcionmateriaaprobada.php');
	
	// Estos datos se usaran en toda la aplicación

	// Seleccionar los datos del estudiante
	
	// El primer query genera resultados si el estudiante tiene plan de estudios.
	$cuentaconplandeestudio = true;
	$query_datosestudiante = "select concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre, e.codigocarrera, 
	e.numerocohorte, e.codigotipoestudiante, e.codigosituacioncarreraestudiante, e.codigojornada, e.codigoperiodo, pe.cantidadsemestresplanestudio,
	t.codigoreferenciatipoestudiante, m.codigoreferenciamodalidadacademica, e.idestudiantegeneral, c.codigomodalidadacademica, e.semestre
	from estudiante e, estudiantegeneral eg, tipoestudiante t, carrera c, modalidadacademica m, planestudioestudiante pee, planestudio pe
	where e.codigoestudiante = '$codigoestudiante'
	and eg.idestudiantegeneral = e.idestudiantegeneral
	and e.codigotipoestudiante = t.codigotipoestudiante
	and e.codigocarrera = c.codigocarrera
	and c.codigomodalidadacademica = m.codigomodalidadacademica
	and pee.codigoestudiante = e.codigoestudiante
	and pee.codigoestadoplanestudioestudiante like '1%'
	and pe.idplanestudio = pee.idplanestudio
	and pe.codigoestadoplanestudio like '1%'";
	//echo "$query_datosestudiante<br>";
	$datosestudiante = mysql_db_query($database_sala,$query_datosestudiante) or die("$query_datosestudiante".mysql_error());
	$totalRows_datosestudiante = mysql_num_rows($datosestudiante);
	if($totalRows_datosestudiante == "")
	{
		$cuentaconplandeestudio = false;
		// El segundo query genera resultados si el estudiante no tiene plan de estudios.
		$query_datosestudiante = "select concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre, e.codigocarrera, 
		e.numerocohorte, e.codigotipoestudiante, e.codigosituacioncarreraestudiante, e.codigojornada, e.codigoperiodo, 
		t.codigoreferenciatipoestudiante, m.codigoreferenciamodalidadacademica, e.idestudiantegeneral, c.codigomodalidadacademica, e.semestre
		from estudiante e, estudiantegeneral eg, tipoestudiante t, carrera c, modalidadacademica m
		where e.codigoestudiante = '$codigoestudiante'
		and eg.idestudiantegeneral = e.idestudiantegeneral
		and e.codigotipoestudiante = t.codigotipoestudiante
		and e.codigocarrera = c.codigocarrera
		and c.codigomodalidadacademica = m.codigomodalidadacademica";
		//echo "$query_datosestudiante<br>";
		$datosestudiante = mysql_db_query($database_sala,$query_datosestudiante) or die("$query_datosestudiante".mysql_error());
		$totalRows_datosestudiante = mysql_num_rows($datosestudiante);
	}
	$row_datosestudiante = mysql_fetch_array($datosestudiante);
	$codigocarrera = $row_datosestudiante['codigocarrera'];
	$codigotipoestudiante = $row_datosestudiante['codigotipoestudiante'];
	$codigojornada = $row_datosestudiante['codigojornada'];
	$codigosituacioncarreraestudiante = $row_datosestudiante['codigosituacioncarreraestudiante'];

	$codigoperiodoestudiante = $row_datosestudiante['codigoperiodo'];
	$codigoreferenciatipoestudiante = $row_datosestudiante['codigoreferenciatipoestudiante'];
	$codigoreferenciamodalidadacademica = $row_datosestudiante['codigoreferenciamodalidadacademica'];
	$idestudiantegeneral = $row_datosestudiante['idestudiantegeneral'];
	$codigomodalidadacademica = $row_datosestudiante['codigomodalidadacademica'];
	$semestredelestudiante = $row_datosestudiante['semestre'];
	$cantidadsemestreplanestudio = $row_datosestudiante['cantidadsemestreplanestudio'];
	
	//echo "<br>$codigoreferenciamodalidadacademica<br>";
	//exit();
	$generarordenes100 = false;
	$generarprematricula = true;
	if(!$cuentaconplandeestudio)
	{
		// Para los estudiantes que no tengan plan de estudios no se le pueden inscribir asignaturas 
		// y la generación de ordenes de pago va a ser por el 100%
		$generarordenes100 = true;
		$generarprematricula = false;
	}
	//$codigotipoestudiante = $row_datosestudiante['codigotipoestudiante'];
	
	// Selecciona la cohorte del estudiante
	$query_datocohorte = "select numerocohorte, codigoperiodoinicial, codigoperiodofinal
	from cohorte
	where codigocarrera = '$codigocarrera'
	and codigoperiodo = '$codigoperiodoestudiante'
	and '$codigoperiodoestudiante'*1 between codigoperiodoinicial*1 and codigoperiodofinal*1";
	//echo "$query_datocohorte<br>";
	$datocohorte = mysql_db_query($database_sala,$query_datocohorte) or die("$query_datocohorte");
	$totalRows_datocohorte = mysql_num_rows($datocohorte);
	$row_datocohorte = mysql_fetch_array($datocohorte);
	$numerocohorte = $row_datocohorte['numerocohorte'];

	
	require("../generarcargaestudiante.php");
	
	$query_selcreditoscarrera = "select c.maximonumerocredito
	from carrera c, estudiante e
	where c.codigocarrera = e.codigocarrera
	and e.codigoestudiante = '$codigoestudiante'";
	$selcreditoscarrera=mysql_query($query_selcreditoscarrera, $sala) or die("$query_selcreditoscarrera");
	$totalRows_selcreditoscarrera = mysql_num_rows($selcreditoscarrera);
	$row_selcreditoscarrera = mysql_fetch_array($selcreditoscarrera);
	$maximonumerocredito = $row_selcreditoscarrera['maximonumerocredito'];
		
	if(isset($materiasobligatorias))
	{
		$numerocreditosreprobadas = 0;
		foreach($materiasobligatorias as $key4 => $value4)
		{
			// Tomo el número de créditos
			$numerocreditosreprobadas = $numerocreditosreprobadas + $value4['numerocreditosdetalleplanestudio'];
					
			$codigomateria = $value4['codigomateria'];
			$materias[] = $value4['codigomateria'];
			
			$query_datosgrupos = "select g.idgrupo, concat(d.nombredocente,' ',d.apellidodocente) as nombre, g.maximogrupo, g.matriculadosgrupo, g.codigoindicadorhorario 
			from grupo g, docente d
			where g.numerodocumento = d.numerodocumento
			and g.codigomateria = '$codigomateria'
			and g.codigoperiodo = '$codigoperiodo'
			and g.codigoestadogrupo = '10'";
			$datosgrupos=mysql_query($query_datosgrupos, $sala) or die("$query_datosgrupos");
			$totalRows_datosgrupos = mysql_num_rows($datosgrupos);
			// Selecciona los datos de los grupos para una materia, de esos grupos hacer la funcion para seleccionar por materia los que tengan cupo   
			// y no se crucen
		}
	}
		
	$totalcreditos = $numerocreditosreprobadas;
	// Toma el semestre que mas se repite del arreglo
	$maximosemestre = max($semestre);
	$res_sem = array_keys ($semestre, $maximosemestre);
	$res_sem[0];
	echo "<h1>Semestre : ".$res_sem[0]."</h1>";
	
	if(isset($materiaspropuestas))
	{
		foreach($materiaspropuestas as $key3 => $value3)
		{
			//echo "$key3 => ".$value3['codigomateria']."<br>";
			// Tomo las materias hasta que no se pase del 100% del número de créditos
			
			/***///Este esta comentado y es para "todos"
			//if($maximonumerocredito > ($totalcreditos + $value3['numerocreditosdetalleplanestudio']))
			//{
				//$totalcreditos = $totalcreditos + $value3['numerocreditosdetalleplanestudio'];
				$codigomateria = $value3['codigomateria'];
				echo "Total creditos = $totalcreditos : $codigomateria sem:".$value3['semestredetalleplanestudio']."<br>";
				
				/***///Este esta comentado y es para "todos"
				//if($res_sem[0] >= $value3['semestredetalleplanestudio'])
				
				// Selecciona los grupos de primer semestre
				if($res_sem[0] == $value3['semestredetalleplanestudio'])
				{
					$materias[] = $value3['codigomateria'];
					$query_datosgrupos = "select g.idgrupo, concat(d.nombredocente,' ',d.apellidodocente) as nombre, g.maximogrupo, g.matriculadosgrupo, g.codigoindicadorhorario 
					from grupo g, docente d
					where g.numerodocumento = d.numerodocumento
					and g.codigomateria = '$codigomateria'
					and g.codigoperiodo = '$codigoperiodo'
					and g.codigoestadogrupo = '10'";
					$datosgrupos=mysql_query($query_datosgrupos, $sala) or die("$query_datosgrupos");
					$totalRows_datosgrupos = mysql_num_rows($datosgrupos);
					
					//echo "<br>$codigomateria = ";
					//echo "$totalRows_datosgrupos <br>";
					if($totalRows_datosgrupos != "")
					{
						$totalgrupos[$codigomateria] = $totalRows_datosgrupos-1;
					}
					else
					{
						$totalgrupos[$codigomateria] = 0;
					}
				}
			//}
		}
	}
	echo "<br><br>Maximo: ".max($totalgrupos)."<br><br>";
	$maximototalgrupos = max($totalgrupos);
	
	echo "<h1>Materias iniciales:</h1>";
	
	foreach($materias as $key21 => $value21)
	{
		echo "$key21 => $value21 <br>";
	}
		
	// Ordena las materias de mayor a menor numero de grupos teniendo como indice el codiog de la materia y como valor el tamaño del grupo
	arsort($totalgrupos);
			
	// Ordeno las materias de mayor a menor numero de grupos teniendo como valor el codigo de la materia
	echo "<br>Arreglo de materias ordenadas<br>";
	$materiaselegidas = array_keys($totalgrupos);
		
	// Selecciona los grupos sin cruces, de acuerdo a la carrera mira que grupos selecciona si grupos en la mañana o grupos en la noche
	// Selecciona los grupos sin cruces, de acuerdo a la carrera mira que grupos selecciona si grupos en la mañana o grupos en la noche
	if($codigocarrera == 123 || $codigocarrera == 118 || $codigocarrera == 133)
	{
		$gruposseleccionados = seleccionarhorariosporjornada($materiaselegidas, $codigoperiodo, '01', $sala);
	}
	else if($codigocarrera == 124 || $codigocarrera == 119 || $codigocarrera == 134)
	{
		$gruposseleccionados = seleccionarhorariosporjornada($materiaselegidas, $codigoperiodo, '02', $sala);
	}
	else
	{
		$gruposseleccionados = seleccionarhorarios($materiaselegidas, $codigoperiodo, $sala);
	}
	if($gruposseleccionados == false)
	{
		echo "Toca asignarle al estudiante las materias en el grupo uno<br>";
	}
	else
	{
		foreach($gruposseleccionados as $key6 => $value6)
		{
			echo "$key6 => $value6 <br>";
		}
	}
	
	// Cojo la materia y le asocio el grupo en un arreglo
	$i = 0;
	echo "<h1>Materias escogidas:</h1>";
	foreach($materiaselegidas as $key6 => $value6)
	{
		echo "$key6 => $value6 <br>";
		if($gruposseleccionados == false)
		{
			$materiascongrupo[$value6] = 2;
		}
		else
		{
			//echo "$key6 => $value6 <br>";
			// Si se ha seleccionado grupo para la materia entra al if
			// Si no va al else y le adiciona por defecto el grupo 2 el cual en el sistema se encuentra anulado
			if($gruposseleccionados[$i] != "")
			{
				$materiascongrupo[$value6] = $gruposseleccionados[$i];
			}
			else
			{
				$materiascongrupo[$value6] = 2;
			}
			$i++;
		}
	}
		
	// Este arreglo se usa en grabardetalleprematricula.php
	foreach($materiascongrupo as $key7 => $value7)
	{
		echo "$key7 => $value7 <br>";
	}
	
	// Si el estudiante es nuevo se le debe cobrar el 100% de la matricula
	if(isset($_GET['tieneenfasis']))
	{
		$calcularcreditosenfasis = true;
		//echo "CALCULARA CREDITOS<br>";
	}
	else
	{
		$calcularcreditosenfasis = false;
	}
	//exit();
	if(isset($_GET['lineaunica']))
	{
		$lineaescogida = $_GET['lineaunica'];
	}
	else
	{
		$lineaescogida = "";
	}
	echo "<br>linea".$_GET['lineaunica']."<br>enfasis".$_POST['tieneenfasis']."$calcularcreditosenfasis<br>";
		
	$_GET['programausadopor'] = "facultad";
	echo "<br>".$_GET['programausadopor'];
	
	$ip = tomarip();
	$procesoautomatico = true;
	$procesoautomaticotodos = false;
	require("../matriculaautomaticaguardar.php");
		
	// A la prematricula si hay materias con grupo 2 las dejo listas para el cambio de grupo
	$query_upddetalleprematriculaanterior = "UPDATE detalleprematricula 
	SET codigoestadodetalleprematricula = '23'
	WHERE idprematricula = '$idprematricula'
	and idgrupo = '2'";
	$upddetalleprematriculaanterior = mysql_query($query_upddetalleprematriculaanterior,$sala) or die("$query_upddetalleprematriculaanterior"); 
	
	//exit();
	unset($semestre);
	unset($cargaobligatoria);
	unset($materiaspropuestas);
	unset($matreriaspasadas);
	unset($materiasporver);
	unset($materiascongrupo);
	// Electivas libres obligatorias debe insertar como? no se.
	// Electivas libres no inscribe
	//unset($electivaslibresplan);
	unset($totalgrupos);
	unset($materias);
	unset($materiaselegidas);
	unset($gruposseleccionados);
}
?>
<script language="javascript">
	//window.location.reload("../../prematricula/matriculaautomaticaordenmatricula.php?programausadopor=creditoycartera")
</script>