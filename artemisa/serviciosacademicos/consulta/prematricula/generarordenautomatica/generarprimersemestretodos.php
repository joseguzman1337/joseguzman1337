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
$query_periodoactivo = "select nombreperiodo, codigoestadoperiodo
from periodo where codigoperiodo = '$codigoperiodo'";
//echo "$query_periodoactivo<br>";
$periodoactivo = mysql_db_query($database_sala,$query_periodoactivo) or die("$query_periodoactivo");
$totalRows_periodoactivo = mysql_num_rows($periodoactivo);
$row_periodoactivo = mysql_fetch_array($periodoactivo);
$nombreperiodo = $row_periodoactivo['nombreperiodo'];
if($row_periodoactivo['codigoestadoperiodo'] != '1')
{
?>
<script language="javascript">
	alert("No puede ingresar a la generación de ordenes de pago para periodos inactivos");
	history.go(-1);
</script>
<?php
}
require('funcionvalidarcrucehorarios.php');
require('funcionseleccionarhorarios.php');
// Pagina de donde se llamo esta pagina
/*$pagina = $_SERVER['HTTP_REFERER'];
$inicio_pagina = strpos ($pagina, "?");
$dir = substr ($pagina, $inicio_pagina);
*/
$ffechapago = 1;

$fechapago = $_GET['fechapago'];
//echo "$codigo y $codigoperiodo y ".$_GET['programausadopor'];
require("fechadepagotodos.php");

?>
<html>
<head>
<title>Estudiantes Nuevos Con Orden Automática</title>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: x-small;
}
.Estilo4 {font-size: 12; }
.Estilo5 {font-family: Tahoma; font-size: 12; }
-->
</style>
</head>
<body>
<?php
// Si la feha es invalida
$cuentatodos = 0;
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
?>
<div align="center">
<p align="center" class="Estilo1"><strong>Estudiantes a los que se les genero orden de pago: </strong></p>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td align="center" bgcolor="#C5D5D6" class="Estilo1"><strong>Nombre Estudiante</strong>&nbsp;</td>
    <td align="center" bgcolor="#C5D5D6" class="Estilo1"><strong>Documento</strong>&nbsp;</td>
	<td align="center" bgcolor="#C5D5D6" class="Estilo1"><strong>Orden de Pago</strong>&nbsp;</td>	
  </tr>
<?php
	require('../funcionmateriaaprobada.php');
	
	// Primero selecciona todos los estudiantes que son nuevos y que estan para el periodo activo y que no tengan orden de pago
	
	// Para quitar los que no tengan orden los tomo de primeras
	$query_selestudiantesconorden = "SELECT concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) AS nombre, e.codigocarrera, e.numerocohorte, e.codigotipoestudiante, 
	e.codigosituacioncarreraestudiante, e.codigojornada, e.codigoestudiante, eg.numerodocumento, p.codigoperiodo 
	FROM estudiante e, estudiantegeneral eg, periodo p, ordenpago o, prematricula pre
	WHERE e.idestudiantegeneral = eg.idestudiantegeneral 
	AND e.codigosituacioncarreraestudiante = '300'
	AND e.codigotipoestudiante = '10'
	AND e.codigocarrera = '".$_SESSION['codigofacultad']."'
	AND e.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
	AND e.codigoperiodo = p.codigoperiodo 
	AND p.codigoestadoperiodo = '1'
	and o.codigoestudiante = e.codigoestudiante
	and o.codigoperiodo = p.codigoperiodo
	and pre.codigoestudiante = e.codigoestudiante
	and o.idprematricula = pre.idprematricula
	and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%')";
	//echo "$query_selestudiantes<br>";
	//exit();
	$selestudiantesconorden = mysql_db_query($database_sala,$query_selestudiantesconorden) or die("$query_selestudiantesconorden");
	$totalRows_selestudiantesconorden = mysql_num_rows($selestudiantesconorden);
	$quitarorden = "";
	while($row_selestudiantesconorden = mysql_fetch_array($selestudiantesconorden))
	{
		$quitarordenes = "$quitarordenes and e.codigoestudiante <> '".$selestudiantesconorden['codigoestudiante']."'";
	}
	
	// Estudiantes a los que posiblemete se les va a generar orden de pago
	$query_selestudiantes = "SELECT concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) AS nombre, e.codigocarrera, e.numerocohorte, e.codigotipoestudiante, 
	e.codigosituacioncarreraestudiante, e.codigojornada, e.codigoestudiante, eg.numerodocumento, p.codigoperiodo 
	FROM estudiante e, estudiantegeneral eg, periodo p
	WHERE e.idestudiantegeneral = eg.idestudiantegeneral 
	AND e.codigosituacioncarreraestudiante = '300'
	AND e.codigotipoestudiante = '10'
	AND e.codigocarrera = '".$_SESSION['codigofacultad']."'
	AND e.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
	AND e.codigoperiodo = p.codigoperiodo 
	AND p.codigoestadoperiodo = '1'
	$quitarordenes";
	//echo "$query_selestudiantes<br>";
	//exit();
	$selestudiantes = mysql_db_query($database_sala,$query_selestudiantes) or die("$query_selestudiantes");
	$totalRows_selestudiantes = mysql_num_rows($selestudiantes);
	// Si el query es vacio quiere decir que el estudiante ingreso en un periodo diferente al activo
	if($totalRows_selestudiantes != "")
	{
		while($row_selestudiantes = mysql_fetch_array($selestudiantes))
		{
			$codigo = $row_selestudiantes['codigoestudiante'];
			$codigoestudiante = $row_selestudiantes['codigoestudiante'];
			
			// Estos datos se usaran en toda la aplicación

			// Seleccionar los datos del estudiante
			
			// El primer query genera resultados si el estudiante tiene plan de estudios.
			$cuentaconplandeestudio = true;
			$query_datosestudiante = "select concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre, e.codigocarrera, 
			e.numerocohorte, e.codigotipoestudiante, e.codigosituacioncarreraestudiante, e.codigojornada, e.codigoperiodo, pe.cantidadsemestresplanestudio,
			t.codigoreferenciatipoestudiante, c.codigoreferenciacobromatriculacarrera, e.idestudiantegeneral, c.codigomodalidadacademica, e.semestre,
			c.codigoindicadortipocarrera, c.codigoreferenciacobromatriculacarrera
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
				e.numerocohorte, e.codigotipoestudiante, e.codigosituacioncarreraestudiante, e.codigojornada, e.codigoperiodo, c.codigoindicadorplanestudio,
				t.codigoreferenciatipoestudiante, c.codigoreferenciacobromatriculacarrera, e.idestudiantegeneral, c.codigomodalidadacademica, e.semestre,
				c.codigoindicadortipocarrera, c.codigoreferenciacobromatriculacarrera
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
			$codigoreferenciacobromatriculacarrera = $row_datosestudiante['codigoreferenciacobromatriculacarrera'];
			$codigoreferenciamodalidadacademica = $row_datosestudiante['codigoreferenciamodalidadacademica'];
			$idestudiantegeneral = $row_datosestudiante['idestudiantegeneral'];
			$codigomodalidadacademica = $row_datosestudiante['codigomodalidadacademica'];
			$semestredelestudiante = $row_datosestudiante['semestre'];
			$cantidadsemestreplanestudio = $row_datosestudiante['cantidadsemestreplanestudio'];
			$codigoindicadortipocarrera = $row_datosestudiante['codigoindicadortipocarrera'];
			
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
			
			// Selecciona el subperiodo activo del estudiante
			$query_selsubperiodoestudiante = "select s.idsubperiodo, s.codigoestadosubperiodo
			from subperiodo s, carreraperiodo c
			where c.codigocarrera = '$codigocarrera'
			and c.idcarreraperiodo = s.idcarreraperiodo
			and c.codigoperiodo = '$codigoperiodo'
			and s.codigoestadosubperiodo not like '2%'
			order by 2 desc";
			//echo "$query_selsubperiodoestudiante<br>";
			$selsubperiodoestudiante = mysql_db_query($database_sala,$query_selsubperiodoestudiante) or die("$query_selsubperiodoestudiante");
			$totalRows_selsubperiodoestudiante = mysql_num_rows($selsubperiodoestudiante);
			$row_selsubperiodoestudiante = mysql_fetch_array($selsubperiodoestudiante);
			$idsubperiodo = $row_selsubperiodoestudiante['idsubperiodo'];
			//echo $idsubperiodo;
			//exit();
			
			// Selecciona las carreras del estudiante
			$query_selcarrerasestudiante = "select e.codigoestudiante
			from estudiante e
			where e.idestudiantegeneral = '$idestudiantegeneral'";
			//echo "$query_datocohorte<br>";
			$selcarrerasestudiante = mysql_db_query($database_sala,$query_selcarrerasestudiante) or die("$query_selcarrerasestudiante");
			$totalRows_selcarrerasestudiante = mysql_num_rows($selcarrerasestudiante);
			
			// Selecciona la cohorte del estudiante
			$query_datocohorte = "select numerocohorte, codigoperiodoinicial, codigoperiodofinal
			from cohorte
			where codigocarrera = '$codigocarrera'
			and codigoperiodo = '$codigoperiodo'
			and '$codigoperiodoestudiante'*1 between codigoperiodoinicial*1 and codigoperiodofinal*1";
			//echo "$query_datocohorte<br>";
			$datocohorte = mysql_db_query($database_sala,$query_datocohorte) or die("$query_datocohorte");
			$totalRows_datocohorte = mysql_num_rows($datocohorte);
			$row_datocohorte = mysql_fetch_array($datocohorte);
			$numerocohorte = $row_datocohorte['numerocohorte'];
			
			//echo "<h1>$codigoestudiante</h1>";
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
			//echo "<h1>Semestre : ".$res_sem[0]."</h1>";
			
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
						//echo "Total creditos = $totalcreditos : $codigomateria sem:".$value3['semestredetalleplanestudio']."<br>";
						
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
			//echo "<br><br>Maximo: ".max($totalgrupos)."<br><br>";
			$maximototalgrupos = max($totalgrupos);
			
			//echo "<h1>Materias iniciales:</h1>";
			
			foreach($materias as $key21 => $value21)
			{
				//echo "$key21 => $value21 <br>";
			}
			
			// Ordena las materias de mayor a menor numero de grupos teniendo como indice el codiog de la materia y como valor el tamaño del grupo
			arsort($totalgrupos);
				
			// Ordeno las materias de mayor a menor numero de grupos teniendo como valor el codigo de la materia
			//echo "<br>Arreglo de materias ordenadas<br>";
			$materiaselegidas = array_keys($totalgrupos);
			
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
				//echo "Toca asignarle al estudiante las materias en el grupo uno<br>";
			}
			else
			{
				foreach($gruposseleccionados as $key6 => $value6)
				{
					//echo "$key6 => $value6 <br>";
				}
			}
				
			// Cojo la materia y le asocio el grupo en un arreglo
			$i = 0;
			//echo "<h1>Materias escogidas:</h1>";
			foreach($materiaselegidas as $key6 => $value6)
			{
				//echo "$key6 => $value6 <br>";
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
				//echo "$key7 => $value7 <br>";
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
	
			// Si el estudiante es nuevo se le debe cobrar el 100% de la matricula
			$procesoautomatico = true;
			$_GET['programausadopor'] = "facultad";
			
			$ip = tomarip();
			$procesoautomaticotodos = true;
			
			$ruta="../../../funciones/";
			require_once("../../../funciones/ordenpago/claseordenpago.php");
			$orden = new Ordenpago($sala, $codigoestudiante, $codigoperiodo);
			
			require_once('../../../Connections/sap.php' );
			
			require("../matriculaautomaticaguardar.php");
			
			// A la prematricula si hay materias con grupo 2 las dejo listas para el cambio de grupo
			$query_upddetalleprematriculaanterior = "UPDATE detalleprematricula 
			SET codigoestadodetalleprematricula = '23'
			WHERE idprematricula = '$idprematricula'
			and idgrupo = '2'";
			$upddetalleprematriculaanterior = mysql_query($query_upddetalleprematriculaanterior,$sala) or die("$query_upddetalleprematriculaanterior"); 
			
			unset($cambiodegrupo);
			unset($ordenesdepago);
			unset($codigomaterias);
			unset($idgrupos);
			unset($estadodetalle);
			unset($materiascongrupo);
			unset($materiaspapa);
			unset($materiaselegidas);
			unset($semestre);
			unset($pecuniariosacobrar);
			unset($codigoconceptoarreglo);
			unset($valorconcepto);
			unset($codigotipodetalle);
			//exit();
			/*$matriz = get_defined_vars();
				// imprimir $b
			echo "<h1>Variables</h1>";
			
			foreach($matriz as $unakey => $unvalue)
			{
				echo "<br>$unakey<br>";
				print_r($unvalue);
			}
			exit();
			*/
			// Unset al 100 las variables que más pueda				
			unset($semestre);
			unset($materiasporver);
			unset($cargaobligatoria);
			unset($materiaspropuestas);
			unset($matreriaspasadas);
			unset($matreriasafiltrar);
			unset($materiascongrupo);
			unset($materiasconprerequisito);
			unset($totalgrupos);
			unset($materias);
			unset($materiaselegidas);
			unset($gruposseleccionados);
			unset($res_sem);
			
			unset($prematricula_inicial);
			unset($semestre);
			unset($electivaslibresplan);
			unset($materiasporver);
			unset($cargaobligatoria);
			unset($materiasobligatorias);
			unset($materiaspasadas);
			unset($materiasquitarcarga);
			unset($materiasponercarga);
			unset($materiasfinal);
			unset($materiaspropuestas);
			unset($materiascongrupo);
			unset($materiasenfasis);
			unset($prematriculafiltrar);	
			unset($materiaspantallainicial);	
			unset($electivasaprobadas);
			
			// Unset para las variables de la  generación de la prematricula			
			unset($codigoconceptoarreglo);
			unset($valorconcepto);
			unset($codigotipodetalle);
?>
  <tr>
    <td align="center" class="Estilo1"><strong><?php echo $row_selestudiantes['nombre']; ?></strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong><?php echo $row_selestudiantes['numerodocumento']; ?></strong>&nbsp;</td>	
	<td align="center" class="Estilo1"><strong><?php echo $numeroordenpago; ?></strong>&nbsp;</td>	
  </tr>
<?php
			/*if($cuentatodos < 2)
			{	
				exit();
			}
			$cuentatodos++;*/
			saprfc_close($rfc);
		}
	}
	else
	{
?>
 <tr>
    <td align="center" class="Estilo1" colspan="3">No Hay Estudiantes Nuevos</td>	
  </tr>
<?php
	}
?>
</table>
<script language="javascript">
	window.location.reload("listadogeneracionprimersemestretodos.php");
</script>
<?php
}
?>
</form>
</div>
</body>
</html>
