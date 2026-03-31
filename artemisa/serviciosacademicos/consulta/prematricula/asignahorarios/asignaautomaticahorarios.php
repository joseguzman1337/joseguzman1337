<?php 
/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/
session_start();
ini_set('max_execution_time','6000');

require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php' );
$salatmp=$sala;
require_once(realpath(dirname(__FILE__))."/../../../funciones/validacion.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/errores_plandeestudio.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/funciontiempo.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/funcionip.php");
$rutaado=("../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/FuncionesCadena.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/FuncionesFecha.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/DatosGenerales.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("funciones/funcionesvalidacupo.php");
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php' ); 
require_once("funciones/clasearboldesicionhorario.php");



$fechahoy=date("Y-m-d H:i:s");
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$ip=$formulario->GetIP();
$objetobase=new BaseDeDatosGeneral($sala);
$codigoperiodo = $_SESSION['codigoperiodosesion'];


unset($estructuramateriashorarios);
//require_once('../seguridadprematricula.php');

$materiasunserial = unserialize(stripcslashes($_GET['materiassinhorarios']));

$materiasunserialtmp=$materiasunserial;

//echo "<pre>";
//print_r($materiasunserial);
//echo "</pre>";

// Esta variable se usa en el resto de la aplicación en el archivo calculocreditossemestre
$materiaselegidas = $materiasunserial;

$materiasserial = serialize($materiasunserial);
$codigoestudiante = $_SESSION['codigo'];
if ($_GET['lineaunica']) {
    $getenfasis = "tieneenfasis";
}
//print_r($materiasunserial);
//echo "<br>";
//echo "<br>";
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
$datosestudiante = $objetobase->conexion->query($query_datosestudiante);
$totalRows_datosestudiante = $datosestudiante->RecordCount();
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
	$datosestudiante = $objetobase->conexion->query($query_datosestudiante);
	$totalRows_datosestudiante = $datosestudiante->RecordCount();
}
$row_datosestudiante = $datosestudiante->FetchRow();
$codigocarrera = $row_datosestudiante['codigocarrera'];
$codigotipoestudiante = $row_datosestudiante['codigotipoestudiante'];
$codigojornada = $row_datosestudiante['codigojornada'];
$codigosituacioncarreraestudiante = $row_datosestudiante['codigosituacioncarreraestudiante'];
$codigoperiodoestudiante = $row_datosestudiante['codigoperiodo'];
$codigoreferenciatipoestudiante = $row_datosestudiante['codigoreferenciatipoestudiante'];
$codigoreferenciacobromatriculacarrera = $row_datosestudiante['codigoreferenciacobromatriculacarrera'];
$idestudiantegeneral = $row_datosestudiante['idestudiantegeneral'];
$codigomodalidadacademica = $row_datosestudiante['codigomodalidadacademica'];
$semestredelestudiante = $row_datosestudiante['semestre'];
$cantidadsemestreplanestudio = $row_datosestudiante['cantidadsemestreplanestudio'];
$codigoindicadortipocarrera = $row_datosestudiante['codigoindicadortipocarrera'];



/*echo "CODIGOCARRERA=".$codigocarrera."<br>";
echo "CODIGOPERIODO=".$codigoperiodo."<br>";
echo "IDESTUDIANTEGENERAL=".$idestudiantegeneral."<br>";
echo "CODIGOJORANADA=".$codigojornada;
*/

$query_horarioinicial = "SELECT h.idgrupo, d.codigomateria 
FROM horario h, grupo g, detalleprematricula d, estudiante e, prematricula p 
where h.idgrupo = d.idgrupo 
and e.codigoestudiante = p.codigoestudiante 
and p.idprematricula = d.idprematricula 
and p.codigoperiodo = '$codigoperiodo' 
and g.codigoperiodo = p.codigoperiodo 
and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%') 
and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%') 
and e.codigoestudiante = '$codigoestudiante' 
and g.codigoestadogrupo like '1%'
and g.codigoindicadorhorario like '1%'
and d.idgrupo = g.idgrupo";
//echo "$query_horarioinicial<br>";
$horarioinicial=$objetobase->conexion->query($query_horarioinicial);
$totalRows_premainicial1 = $horarioinicial->RecordCount();
$tienehorario = false;
echo $tiene_prema = false;
while($row_horarioinicial = $horarioinicial->FetchRow())
{
	
	$grupo_inicial[] = $row_horarioinicial['idgrupo'];
	$materia_inicial[] = $row_horarioinicial['codigomateria'];
	//echo $row_horarioinicial['idgrupo']."<br>";
	$tienehorario = true;
	$tiene_prema = true;
}

// Seleccion de los grupos sin horario
/*$query_horarioinicial = "SELECT g.idgrupo, d.codigomateria 
FROM grupo g, detalleprematricula d, estudiante e, prematricula p 
where e.codigoestudiante = p.codigoestudiante 
and p.idprematricula = d.idprematricula 
and p.codigoperiodo = '$codigoperiodo' 
and g.codigoperiodo = p.codigoperiodo 
and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%') 
and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%') 
and e.codigoestudiante = '$codigoestudiante' 
and g.codigoestadogrupo like '1%'
and g.codigoindicadorhorario like '2%'
and d.idgrupo = g.idgrupo";
//echo "$query_horarioinicial<br>";
$horarioinicial=$objetobase->conexion->query($query_horarioinicial);
$totalRows_premainicial1 = $horarioinicial->RecordCount();
$tienehorario = false;
while($row_horarioinicial = $horarioinicial->FetchRow())
{
	echo"<h1>Entro aqui</h1><pre>";
	print_r($row_horarioinicial);
	echo"</pre>";
	$grupo_inicial[] = $row_horarioinicial['idgrupo'];
	$materia_inicial[] = $row_horarioinicial['codigomateria'];
	$tiene_prema = true;
	//echo $row_horarioinicial['idgrupo']."<br>";
	//$tienehorario = true;
}*/

if($tiene_prema){


alerta_javascript("Ya ha seleccionado una prematricula, \\n puede cambiarla por horario manual o anulando la orden de pago");

echo "<script language='javascript'>";

	
	if($_GET['documentoingreso'])
	{
		history.go(-2);
		/*echo "window.location.reload('../matriculaautomatica.php?documentoingreso=".$_GET['documentoingreso']."')";*/
	}
	else
	{
		history.go(-2);
		/*echo "window.location.reload('../matriculaautomatica.php?programausadopor=".$_GET['programausadopor']."')";*/
	}

	echo "</script>";
}
// Selecciona los datos de la materia y los horarios para las materias que tiene el estudiante
if(is_array($materiasunserial))
{
	foreach($materiasunserial as $llave => $codigomateria)
	{
		//echo "$llave => $codigomateria";
		// Selecciona los datos de las materias para aquellas que no son electivas, de acuerdo al plan de estudio
		//echo "<br>NUEVA MATERIA<br>";

		$query_datosmateria = "select m.nombremateria, m.codigomateria, dpe.semestredetalleplanestudio
		from materia m, detalleplanestudio dpe, planestudioestudiante pee
		where m.codigomateria = '$codigomateria'
		and pee.codigoestudiante = '$codigoestudiante'
		and m.codigomateria = dpe.codigomateria
		and pee.idplanestudio = dpe.idplanestudio
		and pee.codigoestadoplanestudioestudiante like '1%'";
		// Otro query para selecciona los datos de las materias cuando el anterior es vacio para las demás materias
		// Tanto enfasis como electivas libres
		$datosmateria=$objetobase->conexion->query($query_datosmateria);
		$totalRows_datosmateria = $datosmateria->RecordCount();
		if($totalRows_datosmateria == "")
		{
			// Toma los datos de la materia si es enfasis
			$query_datosmateria = "select m.nombremateria, m.codigomateria, dle.semestredetallelineaenfasisplanestudio as semestredetalleplanestudio
			from materia m, detallelineaenfasisplanestudio dle, lineaenfasisestudiante lee
			where m.codigomateria = '$codigomateria'
			and lee.codigoestudiante = '$codigoestudiante'
			and m.codigomateria = dle.codigomateriadetallelineaenfasisplanestudio
			and lee.idplanestudio = dle.idplanestudio
			and lee.idlineaenfasisplanestudio = dle.idlineaenfasisplanestudio
			and dle.codigoestadodetallelineaenfasisplanestudio like '1%'";
			// Otro query para selecciona los datos de las materias cuando el anterior es vacio para las demás materias
			// Tanto enfasis como electivas libres
			$datosmateria=$objetobase->conexion->query($query_datosmateria);
			$totalRows_datosmateria = $datosmateria->RecordCount();
			// Si se trata de una electiva
		}
		//echo "<br>";
		//print_r($row_datosmateria);
		//echo "<br>";
		if($totalRows_datosmateria == "")
		{
			$query_datosmateria = "select m.nombremateria, m.codigomateria
			from materia m
			where m.codigomateria = '$codigomateria'
			and m.codigoestadomateria = '01'";
			//and m.codigotipomateria = '4'";
			$datosmateria = $objetobase->conexion->query($query_datosmateria);
			$totalRows_datosmateria = $datosmateria->RecordCount();
			if(ereg("grupo[0-9]+",$llave))
			{
				// Si la llave esta en materia la coje y la manda como codigomateriaelectiva
				$query_materiapapa = "select m.nombremateria, m.codigomateria
				from materia m
				where m.codigomateria = '".ereg_replace("grupo","",$llave)."'
				and m.codigoestadomateria = '01'";

				$materiapapa= $objetobase->conexion->query($query_materiapapa);
				$totalRows_materiapapa =  $materiapapa->RecordCount();
				if($totalRows_materiapapa != "")
				{
					$mpapa = $llave;
				}
			}
			else if(ereg("electiva[0-9]+",$llave))
			{
				// Al tratarse de una electiva selecciona la electiva del plan de estudios para el estudiante
				$query_materiapapa = "select m.nombremateria, m.codigomateria
				from materia m
				where m.codigomateria = '".ereg_replace("electiva","",$llave)."'
				and m.codigoestadomateria = '01'";
			//echo "<br>$query_materiapapa";
				$materiapapa= $objetobase->conexion->query($query_materiapapa);
				$totalRows_materiapapa =  $materiapapa->RecordCount();
				if($totalRows_materiapapa != "")
				{
					$mpapa = $llave;
				}
			}


		}
		$row_datosmateria = $datosmateria->FetchRow();
			$query_pertenecemateria = "select codigomateria
			from materia
			where codigomateria = '".$row_datosmateria['codigomateria']."'
			and codigocarrera = '$codigocarrera'";
					$pertenecemateria=$objetobase->conexion->query($query_pertenecemateria);
					//echo "$query_pertenecemateria<br>";
					$totalRows_pertenecemateria = $pertenecemateria->RecordCount();
					$sincupo = false;
					if($totalRows_pertenecemateria != "")
					{
						$estructuradatosmateria[$codigomateria]['pertenecemateria']=1;
					}
					else
					{
						$estructuradatosmateria[$codigomateria]['pertenecemateria']=0;
					}


		$estructuradatosmateria[$row_datosmateria['codigomateria']]['nombremateria']=$row_datosmateria['nombremateria'];
		$estructuradatosmateria[$row_datosmateria['codigomateria']]['semestreplanestudio']=$row_datosmateria['semestredetalleplanestudio'];
		if($totalRows_materiapapa != "")
			$estructuradatosmateria[$row_datosmateria['codigomateria']]['materiapapa']=$mpapa;
		else
			$estructuradatosmateria[$row_datosmateria['codigomateria']]['materiapapa']=0;
		//echo "<pre><br>";
		//print_r($estructuradatosmateria);
		//echo "</pre><br>";

				// Selecciona los datos de los grupos para una materia   
				//echo "GRUPOS:<br>";
				$query_datosgrupos = "select g.idgrupo, concat(d.nombredocente,' ',d.apellidodocente) as nombre, 
				g.maximogrupo,  g.maximogrupoelectiva, g.matriculadosgrupo, g.matriculadosgrupoelectiva, 
				g.codigoindicadorhorario, g.nombregrupo, g.fechainiciogrupo, g.fechafinalgrupo 
				from grupo g, docente d
				where g.numerodocumento = d.numerodocumento
				and g.codigomateria = '$codigomateria'
				and g.codigoperiodo = '$codigoperiodo'
				and g.codigoestadogrupo = '10'";				
				$datosgrupos=$objetobase->conexion->query($query_datosgrupos);
				$totalRows_datosgrupos = $datosgrupos->RecordCount();
			if($totalRows_datosgrupos != "")
			{

				while ($row_datosgrupo = $datosgrupos->FetchRow()){
					/*echo "<br>&nbsp;---->";
					print_r($row_datosgrupo);
					echo "<br>";*/
					

					$estructuramateriashorarios[$row_datosmateria['codigomateria']][$row_datosgrupo['idgrupo']]['maximogrupo']=$row_datosgrupo['maximogrupo'];
					$estructuramateriashorarios[$row_datosmateria['codigomateria']][$row_datosgrupo['idgrupo']]['matriculadosgrupoelectiva']=$row_datosgrupo['matriculadosgrupoelectiva'];
					$estructuramateriashorarios[$row_datosmateria['codigomateria']][$row_datosgrupo['idgrupo']]['matriculadosgrupo']=$row_datosgrupo['matriculadosgrupo'];
					$estructuramateriashorarios[$row_datosmateria['codigomateria']][$row_datosgrupo['idgrupo']]['nombredocente']=$row_datosgrupo['nombre'];
					$estructuramateriashorarios[$row_datosmateria['codigomateria']][$row_datosgrupo['idgrupo']]['nombregrupo']=$row_datosgrupo['nombregrupo'];
					$estructuramateriashorarios[$row_datosmateria['codigomateria']][$row_datosgrupo['idgrupo']]['fechainiciogrupo']=$row_datosgrupo['fechainiciogrupo'];
					$estructuramateriashorarios[$row_datosmateria['codigomateria']][$row_datosgrupo['idgrupo']]['fechafinalgrupo']=$row_datosgrupo['fechafinalgrupo'];
					$estructuramateriashorarios[$row_datosmateria['codigomateria']][$row_datosgrupo['idgrupo']]['codigoindicadorhorario']=$row_datosgrupo['codigoindicadorhorario'];

						/*if($row_datosgrupo['matriculadosgrupo'] >= ($row_datosgrupo['maximogrupo']-$row_datosgrupo['maximogrupoelectiva']))
							$estructuramateriashorarios[$row_datosmateria['codigomateria']][$row_datosgrupo['idgrupo']]['cupolleno']=1;
						else
							$estructuramateriashorarios[$row_datosmateria['codigomateria']][$row_datosgrupo['idgrupo']]['cupolleno']=0;
						
						if(!$estructuradatosmateria[$row_datosmateria['codigomateria']]['pertenecemateria']){
							if($row_datosgrupo['maximogrupoelectiva'] != 0)
							{
								if($row_datosgrupo['matriculadosgrupoelectiva'] >= $row_datosgrupo['maximogrupoelectiva'])
									{
										$estructuramateriashorarios[$row_datosmateria['codigomateria']][$row_datosgrupo['idgrupo']]['cupolleno']=1;
									}
							}
						}*/
						$estructuramateriashorarios[$row_datosmateria['codigomateria']][$row_datosgrupo['idgrupo']]['cupolleno']= validacupoelectiva($row_datosgrupo,$estructuradatosmateria[$row_datosmateria['codigomateria']]['pertenecemateria']);
						
						$tieneprimergrupoconhorarios = 0;
						$grupoencontrado = false;
							// Selecciona los datos de los horarios
							//echo "<br>";
							$query_datoshorarios = "select h.codigodia, h.horainicial, h.horafinal, s.nombresalon, s.codigosalon, d.nombredia,d.codigodia,h.idhorario
							from horario h, dia d, salon s
							where h.codigodia = d.codigodia
							and h.codigosalon = s.codigosalon
							and h.idgrupo = '".$row_datosgrupo['idgrupo']."'
							order by 1,2,3";
							$datoshorarios=$objetobase->conexion->query($query_datoshorarios);
							//echo "$query_datoshorarios<br>";
							$totalRows_datoshorarios = $datoshorarios->RecordCount();
							$conhorario=0;
							while ($row_datoshorarios = $datoshorarios->FetchRow()){
									/*echo "<br>&nbsp;---->";
									print_r($row_datoshorarios);
									echo "<br>";*/
									$estructuramateriashorarios[$row_datosmateria['codigomateria']][$row_datosgrupo['idgrupo']][$conhorario]['horainicial']=$row_datoshorarios['codigodia']*10000+horaaminutos($row_datoshorarios['horainicial']);
									$estructuramateriashorarios[$row_datosmateria['codigomateria']][$row_datosgrupo['idgrupo']][$conhorario]['horafinal']=$row_datoshorarios['codigodia']*10000+horaaminutos($row_datoshorarios['horafinal']);
									$estructuramateriashorarios[$row_datosmateria['codigomateria']][$row_datosgrupo['idgrupo']][$conhorario]['dia']=$row_datoshorarios['codigodia'];
									$estructuramateriashorarios[$row_datosmateria['codigomateria']][$row_datosgrupo['idgrupo']][$conhorario]['salon']=$row_datoshorarios['codigosalon'];
									$estructuramateriashorarios[$row_datosmateria['codigomateria']][$row_datosgrupo['idgrupo']][$conhorario]['nombredia']=$row_datoshorarios['nombredia'];
									$estructuramateriashorarios[$row_datosmateria['codigomateria']][$row_datosgrupo['idgrupo']][$conhorario]['idhorario']=$row_datoshorarios['idhorario'];
									
									
									$query_detallehorarios = "select dh.idhorariodetallefecha,dh.fechadesdehorariodetallefecha,dh.fechahastahorariodetallefecha
									from horariodetallefecha dh
									where dh.codigoestado=100
									and dh.idhorario =".$row_datoshorarios['idhorario'];
										$datosdetallehorarios=$objetobase->conexion->query($query_detallehorarios);
										//echo "$query_datoshorarios<br>";
										$totalRows_detallehorarios = $datosdetallehorarios->RecordCount();
										while ($row_detallehorarios = $datosdetallehorarios->FetchRow()){
										//print_r($row_detallehorarios);
											$estructuramateriashorarios[$row_datosmateria['codigomateria']][$row_datosgrupo['idgrupo']][$conhorario]['detallehorario'][$row_detallehorarios['idhorariodetallefecha']]['fechadesde']=$row_detallehorarios['fechadesdehorariodetallefecha'];
											$estructuramateriashorarios[$row_datosmateria['codigomateria']][$row_datosgrupo['idgrupo']][$conhorario]['detallehorario'][$row_detallehorarios['idhorariodetallefecha']]['fechahasta']=$row_detallehorarios['fechahastahorariodetallefecha'];
										}
									$conhorario++;
									//echo "<br>";
									
							}

						
					}
				}				
	}
}

//echo "<br><br><br><br><br><br>";
//echo "<pre>";
//print_r($estructuramateriashorarios);
//echo "</pre>";

?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
<link rel="stylesheet" type="text/css" href="../../../funciones/sala_genericas/estilos.css">
<script type='text/javascript'>
function muestracarguediv(visibilidad){
	var oCargue = document.getElementById('carguediv');
	oCargue.style.visibility = visibilidad;
	var oHorario = document.getElementById('tablahorario');
	if(oHorario!=null){
		//alert(visibilidad);	
		if(visibilidad=='hidden')
			visibilidadhorario='visible';
		else
			visibilidadhorario='hidden';
		oHorario.style.visibility = visibilidadhorario;
	}
}
var tmpdiv;
function muestradiv(iddiv){
	var carguediv=document.getElementById(iddiv);
	visibilidad=carguediv.style.visibility;
		if(tmpdiv!=null)
			tmpdiv.style.visibility='hidden';
			
	if(visibilidad=='hidden')
		carguediv.style.visibility='visible';
	else
		carguediv.style.visibility='hidden';
	tmpdiv=carguediv;
	return false;
}
function cambiaestadocampo(idcampo,obj){
	var carguecampo=document.getElementById(idcampo);
	if(obj.checked){
	carguecampo.disabled=false;
	}
	else{
	carguecampo.disabled=true;
	}

	
}
function validafecha()
{

var carguecampo=document.getElementById("fechapago");
	if(carguecampo.value==''){
		alert("Fecha de pago invalida, no puede ser vacia");
		return false;
	}
	return true;
}

</script>
<div id='carguediv' style='position:absolute; left:300px; top:300px; width:209px; height:34px; z-index:1; visibility: hidden;  background-color: #FFFFFF; layer-background-color: #FFFFFF;'>
  <table width='300' border='0'>
    <tr>
      <td><img  src="../../facultades/imagesAlt2/cargando.gif" name="cargando"></td>
    </tr>
    <tr>
      <td>Calculando opciones de Horario...</td>
    </tr>
  </table>
</div>

<form name="form2" action='asignaautomaticahorarios.php?documentoingreso=<?php echo $_GET['documentoingreso']."&materiassinhorarios=$materiasserial&$getenfasis&lineaunica=".$_GET['lineaunica']."&semestrerep=".$_GET['semestrerep'];?>' method="POST" >
<input type="hidden" name="AnularOK" value=""> 

<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
<?php
//$formulario->dibujar_fila_titulo("Seleccione la prioridad de sus asignaturas",'labelresaltado',2);

		unset($fila);


		$fila["Asignaturas_Seleccionadas"]="";//
		$fila["Prioridad_(Opcional)"]="";//
		//$fila["Fecha_de_inicio"]=$estructuramateriashorarios[$materia][$grupo]['fechainiciogrupo'];//
		//$fila["Fecha_de_Vencimiento"]=$estructuramateriashorarios[$materia][$grupo]['fechafinalgrupo'];//
		//$fila["Max_Grupo"]=$estructuramateriashorarios[$materia][$grupo]['maximogrupo'];//
		//$fila["Max_Prematricula"]=$estructuramateriashorarios[$materia][$grupo]['matriculadosgrupoelectiva']+$estructuramateriashorarios[$materia][$grupo]['matriculadosgrupo'];//
		
		$formulario->dibujar_filas_texto($fila,'tdtituloresaltado','','colspan=1','colspan=1');
		unset($fila);

		if(isset($_GET['mejoresramashorario']))
			$mejoresramashorariotmp = unserialize(stripcslashes($_GET['mejoresramashorario']));


foreach($estructuradatosmateria  as $materia => $nombremateria ){
	$formulario->filatmp[0]="Seleccionar";
	for($i=0;$i<count($estructuradatosmateria);$i++){
	$formulario->filatmp[($i+1)]=$i+1;
	}
	
		$checked="checked";
		$desabilitar="";	

		if(!isset($_GET['mejoresramashorario'])){
			if($_REQUEST['Aceptar'])
				if(!isset($_POST['prioridad'.$materia])||$_POST['prioridad'.$materia]==''){
					$checked="";
					$desabilitar="disabled";
				}
		}
		else{
			if(!isset($mejoresramashorariotmp[0][1][$materia])||$mejoresramashorariotmp[0][1][$materia]==''){
				$checked="";
				$desabilitar="disabled";
			}			
		}
		
			


		


		$campo[0]='menu_fila'; $parametros[0]="'prioridad$materia','".$_POST['prioridad'.$materia]."',' $desabilitar'";
		$campo[1]='boton_tipo'; $parametros[1]="'checkbox','checkmateria$materia','1','onclick=\"cambiaestadocampo(\'prioridad$materia\',this);\" $checked'";
		$formulario->dibujar_campos($campo,$parametros,$nombremateria['nombremateria']." (Semestre ".$nombremateria['semestreplanestudio'].")","tdtitulogris",'prioridad'.$materia,'');
		$formulario->filatmp=NULL;
}


		$conboton=0;

		$parametrobotonenviar[$conboton]="'submit','Aceptar','Aceptar','onclick=\"muestracarguediv(\'visible\');\"'";
		$boton[$conboton]='boton_tipo';							
		$conboton++;					

                        if ($_GET['lineaunica']) {
            $parametrobotonenviar[$conboton] = "'hidden','lineaunica','" . $_GET['lineaunica'] . "'";
            $boton[$conboton] = 'boton_tipo';
        }
		
if($_GET['documentoingreso'])
{
		$parametrobotonenviar[$conboton]="'button','regresar','Regresar','onclick=window.location.href=\'../matriculaautomatica.php?documentoingreso=".$_GET['documentoingreso']."\''";
		$boton[$conboton]='boton_tipo';
		$conboton++;					

		$parametrobotonenviar[$conboton]="'hidden','documentoingreso','".$_GET['documentoingreso']."'";
		$boton[$conboton]='boton_tipo';
		//$conboton++;					
}
else
{
	if(isset($_SESSION['cursosvacacionalessesion'])){
		$parametrobotonenviar[$conboton]="'button','regresar','Regresar','onclick=\"window.location.href=\'../matriculaautomatica.php?cursosvacacionales=\'\"'";
	} else {
		$parametrobotonenviar[$conboton]="'button','regresar','Regresar','onclick=\"window.location.href=\'../matriculaautomatica.php?programausadopor=".$_GET['programausadopor']."\'\"'";
	}
		$boton[$conboton]='boton_tipo';
		//$conboton++;					
}
	$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar','',0,'colspan=1');

if(isset($_REQUEST['Aceptar'])){
	foreach($estructuradatosmateria  as $materia => $nombremateria ){
		$estructuradatosmateria[$materia]['prioridad']=$_POST['prioridad'.$materia]+$estructuradatosmateria[$materia]['semestreplanestudio']*100;
	}
}

$formulario->dibujar_fila_titulo("Nota: La selección de la prioridad de las asignaturas es opcional",'labelresaltado',4);

//echo "<pre>";
//print_r($estructuradatosmateria);
//echo "</pre>";


?>
</table>
</form>

<?php

//unset($_SESSION['mejoresramashorario']);
if(isset($_REQUEST['Aceptar'])){

echo "<script type='text/javascript'>
muestracarguediv('visible');
</script>
";
ob_flush();
flush();
if (!isset($_GET['mejoresramashorario'])){


	foreach($materiasunserial as $llave=>$codigomateriainicial){
		if(!isset($_POST['prioridad'.$codigomateriainicial])||$_POST['prioridad'.$codigomateriainicial]==''){
			unset($estructuradatosmateria[$codigomateriainicial]);
			unset($estructuramateriashorarios[$codigomateriainicial]);
		}
	}
//$horainicial=mktime(date("H"),date("i"),date("s"));

//echo "<br>".date("H:i:s");

$objetoarbolhorario=new arbolDesicionHorario($estructuramateriashorarios,$estructuradatosmateria,$codigocarrera,$codigoperiodo,$codigojornada,$objetobase);
//echo "MEJORES RAMAS<pre>";
//print_r($objetoarbolhorario->mejoresramas);
//echo "</pre>";

/*for($i=0;$i<count($objetoarbolhorario->mejoresramas);$i++){
	for($j=0;$j<count($objetoarbolhorario->mejoresramas);$j++){
			if(is_array($objetoarbolhorario->mejoresramas[$i][1]))
				if(is_array($objetoarbolhorario->mejoresramas[$j][1])){
				$diferencia=array_diff($objetoarbolhorario->mejoresramas[$i][1],$objetoarbolhorario->mejoresramas[$j][1]);
					echo "DIFERENCIA ENTRE $i Y $j<br>";
							print_r($diferencia);
							if(empty($diferencia)){
							echo "NO HAY DIFERENCIAS";
							}
							
					echo "<br>";
		}
	}

}*/
//$horafinal=mktime(date("H"),date("i"),date("s"));

//echo "<br>".date("H:i:s")."<br>";
//echo "Diferencia=".($horafinal-$horainicial)."<br>";

$objetoarbolhorario->restriccionJornada();

$mejoresramashorario=$objetoarbolhorario->mejoresramas;


// Esta variable se usa en el resto de la aplicación en el archivo calculocreditossemestre
$materiaselegidas = $materiasunserial;
}

?>


<?php
//print_r($_SESSION);


if(!isset($_SESSION['materiassinhorarios']))
$_SESSION['materiassinhorarios']=$materiasserial;

if(!isset($_SESSION['lineaunica']))
$_SESSION['lineaunica']=$_GET['lineaunica'];

if(!isset($_SESSION['semestrerep']))
$_SESSION['semestrerep']=$_GET['semestrerep'];

$mensajesexcluidas[0]="";
$mensajesexcluidas[1]="Por fuera de la Jornada ";
$mensajesexcluidas[2]="Sin cupo Ver Articulo 41 Reglamento Estudiantil";
$mensajesexcluidas[3]="Este grupo requiere horario, dirijase a su facultad para informarlo";
$mensajesexcluidas[4]="Cruce de horarios Ver Articulo 41 Reglamento Estudiantil";


?>
<div id="tablahorario" style=" visibility: visible;">
<form name="form1" action='../matriculaautomaticahorarios.php?documentoingreso=<?php echo $_GET['documentoingreso']."&materiassinhorarios=$materiasserial&$getenfasis&lineaunica=".$_GET['lineaunica']."&semestrerep=".$_GET['semestrerep'];?>' method="POST" >
<input type="hidden" name="AnularOK" value=""> 
<?php
//echo 
$ffechapago = 1;
$entrofechavencimiento=0;
if($codigomodalidadacademica == 100 && !$tiene_prema)
{
?>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<tr>
<td colspan="2"><label id="labelresaltado">Seleccione el tipo de orden que quiere generar</label></td>
</tr>
<tr>
<td><strong>Orden de Matricula</strong>
  <input type="radio" name="tipoorden" value="0"  checked></td>
<td>
<strong>Orden de Pensión</strong><input type="radio" name="tipoorden" value="1">
</td>
</tr>
</table>
<?php	
}

if(ereg("^1.+",$codigoreferenciatipoestudiante) && !ereg("^3.+$",$codigoindicadortipocarrera))
{
	// Si entra es por que para este tipo de estudiante debe solicitar fecha de vencimiento de la orden
	$entrofechavencimiento=1;
	if(ereg("estudiante",$_SESSION["MM_Username"]))
	{
		$readonly = "readonly='true'"; 
		$_POST['fechapago']=calcularfechafutura(5, $salatmp);
	}

?>
<br>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
    <tr>
	<td colspan="2"><p>Fecha de plazo de pago de la orden para estudiantes nuevos. <br>
	Esta fecha aplica en caso de generarse una nueva orden de pago.</p>
	</td>
	</tr>
	<tr> 
      <td><strong>Fecha</strong></td>
      <td><input type="text" name="fechapago" value="<?php if(isset($_POST['fechapago'])) { echo $_POST['fechapago']; }?>" <?php echo $readonly ?>> aaaa-mm-dd
	  <?php
				/*if(isset($_POST['fechapago']))
				{
					//echo "entro";
					$fechapago = $_POST['fechapago'];
					$imprimir = true;
					$ffechapago = validar($fechapago,"fecha",$error3,&$imprimir);
					if($ffechapago != 0)
					{
						require('insertarfecha.php');
					}
					else
					{
						$ffechapago = 0;
						echo "La fecha digitada no es correcta<br>";
					}
				}*/
}		
?>
  	  </td>
    </tr>
</table>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
<?php 
if(isset($_GET['nuevaopcion']))
$opcionhorario=$_GET['nuevaopcion'];
else
$opcionhorario=0;

if (isset($_GET['mejoresramashorario']))
{
	
	$mejoresramashorario = unserialize(stripcslashes($_GET['mejoresramashorario']));
	$mejoresramashorarioserial = serialize($mejoresramashorario);

}
else
{
	$mejoresramashorario=$objetoarbolhorario->mejoresramas;
	for($i=0;$i<count($mejoresramashorario);$i++){
		unset($mejoresramashorario[$i]['horarios']);
	}
	$mejoresramashorarioserial = serialize($mejoresramashorario);
}
//echo "<pre>";
//print_r($mejoresramashorario);
//echo "</pre>";
$formulario->dibujar_fila_titulo("HORARIO AUTOMATICO OPCION ".($opcionhorario+1)."",'labelresaltado',4,"align='center'");

echo "<td align='right' colspan='4' class='tdtitulogris'><b>Opciones Horario:</b>";
$i=0;
foreach($mejoresramashorario as  $materia => $grupo  ){

	if(is_array($mejoresramashorario[$i][1])){
			echo "&nbsp;<a href='asignaautomaticahorarios.php?Aceptar&documentoingreso=".$_GET['documentoingreso']."&$getenfasis&lineaunica=".$_GET['lineaunica']."&semestrerep=".$_GET['semestrerep']."&nuevaopcion=".$i."&materiassinhorarios=$materiasserial&mejoresramashorario=$mejoresramashorarioserial'>[".($i+1)."]</a>";
	}
$i++;
}
echo "</td>";

if(isset($mejoresramashorario[$opcionhorario][1]))
foreach($mejoresramashorario[$opcionhorario][1] as  $materia => $grupo  ){

$formulario->dibujar_fila_titulo($estructuradatosmateria[$materia]['nombremateria']." Cod. ".$materia,'labelresaltado',4);

		//$parametrobotonenviar="'hidden','Anular','Anular'";
		//$boton='boton_tipo';
		$formulario->boton_tipo('hidden',"grupo".$materia,$grupo);
		if($estructuradatosmateria[$materia]['materiapapa']!=""){
			$materiapapa=$estructuradatosmateria[$materia]['materiapapa'];
			
			$formulario->boton_tipo('hidden',"papa".$materia,$materiapapa);
		}
		
		//$fila["Materia"]=$estructuradatosmateria[$materia]['nombremateria'];//
		//$fila["Codigo_Materia"]=$materia;//
		$fila["Semestre_Materia"]=$estructuradatosmateria[$materia]['semestreplanestudio'];
		$fila["Codigo_Grupo"]=$grupo;//
		$fila["Docente"]=$estructuramateriashorarios[$materia][$grupo]['nombredocente'];//
		$fila["Nombre_Grupo"]=$estructuramateriashorarios[$materia][$grupo]['nombregrupo'];//

		$formulario->dibujar_filas_texto($fila,'tdtitulogris','','colspan=1','colspan=1');
		unset($fila);

		$fila["Cupo_Maximo"]=$estructuramateriashorarios[$materia][$grupo]['maximogrupo'];//
		$fila["Prematriculados"]=$estructuramateriashorarios[$materia][$grupo]['matriculadosgrupoelectiva']+$estructuramateriashorarios[$materia][$grupo]['matriculadosgrupo'];//
		$fila["Fecha_de_inicio"]=$estructuramateriashorarios[$materia][$grupo]['fechainiciogrupo'];//
		$fila["Fecha_de_Vencimiento"]=$estructuramateriashorarios[$materia][$grupo]['fechafinalgrupo'];//
		//$fila["Max_Grupo"]=$estructuramateriashorarios[$materia][$grupo]['maximogrupo'];//
		//$fila["Max_Prematricula"]=$estructuramateriashorarios[$materia][$grupo]['matriculadosgrupoelectiva']+$estructuramateriashorarios[$materia][$grupo]['matriculadosgrupo'];//
		
		$formulario->dibujar_filas_texto($fila,'tdtitulogris','','colspan=1','colspan=1');
		
		
		unset($fila);

		//$formulario->dibujar_filas_texto($fila,'tdtitulogris','','colspan=4','colspan=4');
		//unset($fila);

		
		if(!isset($estructuramateriashorarios[$materia][$grupo][0])){

			//$fila["Este_grupo_no_necesita_horario"]="";
			$formulario->dibujar_fila_titulo("Este grupo no necesita horario",'labelresaltado',4);
			unset($fila);
		
		}
		else
		{
		echo "<tr><td colspan=4>";
		echo "<table border='1' cellpadding='0' cellspacing='0'  width='100%' bordercolor='#E9E9E9'>"; 

		$fila["Dia"]="";
		$fila["Hora_Inicial"]="";
		$fila["Hora_Final"]="";
		$fila["Fecha_Desde"]="";
		$fila["Fecha_Hasta"]="";
		$fila["Salon"]="";
		$formulario->dibujar_filas_texto($fila,'tdtitulogris','','colspan=1','colspan=1');
		unset($fila);

		}

//echo "<br><h3>Horas</h3><br>";
$encuentrahorarios=0;
		for($i=0;$i<count($estructuramateriashorarios[$materia][$grupo]);$i++)
		{
		if(!empty($estructuramateriashorarios[$materia][$grupo][$i]['horainicial'])){
			$encuentrahorarios=1;
			//if(is_array($estructuramateriashorarios[$materia][$grupo][$i]['detallehorario']))
			//$dianombre= "<a href='' onclick=\"return muestradiv('idhorario".$estructuramateriashorarios[$materia][$grupo][$i]['idhorario']."');\">".$estructuramateriashorarios[$materia][$grupo][$i]['nombredia']."</a>";
			//else
			$dianombre=$estructuramateriashorarios[$materia][$grupo][$i]['nombredia'];
			
			$minutoshorainicial=$estructuramateriashorarios[$materia][$grupo][$i]['horainicial'] - $estructuramateriashorarios[$materia][$grupo][$i]['dia']*10000;
			$minutoshorafinal=$estructuramateriashorarios[$materia][$grupo][$i]['horafinal'] - $estructuramateriashorarios[$materia][$grupo][$i]['dia']*10000;
			//echo $minutoshorainicial."=".$estructuramateriashorarios[$materia][$grupo][$i]['horainicial']." - ".$estructuramateriashorarios[$materia][$grupo][$i]['dia']."*10000";
			//echo "<br>";
			$minutoshorainicial=minutosahora($minutoshorainicial);
			$minutoshorafinal=minutosahora($minutoshorafinal);			
			unset($fila);
			//echo "<tr><td colspan=4>";
			if(is_array($estructuramateriashorarios[$materia][$grupo][$i]['detallehorario'])){		
						
						//$fila["Detalle_Dia_".$estructuramateriashorarios[$materia][$grupo][$i]['nombredia']]="";
						//$fila["Fecha_Hasta"]="";
						//$formulario->dibujar_filas_texto($fila,'tdtituloresaltado','','colspan=4 bgcolor=\'#FFFFFF\' ','colspan=4 ');
						//unset($fila);

						//$formulario->dibujar_filas_texto($fila,'','','colspan=1','colspan=1');

						//$formulario->dibujar_filas_texto($fila,'tdtitulogris','','colspan=2 bgcolor=\'#FFFFFF\' ','colspan=2 bgcolor=\'#FFFFFF\' ');
						unset($fila);

						foreach($estructuramateriashorarios[$materia][$grupo][$i]['detallehorario'] as $iddetallehorario => $arraydetallehorario ){
							$fila[$dianombre]="";
							$fila[$minutoshorainicial]="";
							$fila[$minutoshorafinal]="";
							$fila[$arraydetallehorario['fechadesde']]="";
							$fila[$arraydetallehorario['fechahasta']]="";
							$fila[$estructuramateriashorarios[$materia][$grupo][$i]['salon']]="";

							//$fila[$estructuramateriashorarios[$materia][$grupo][$i]['salon']]="";
							$formulario->dibujar_filas_texto($fila,'','','colspan=1','colspan=1');
							unset($fila);

	
						}
						
				}
				else{
							$fila[$dianombre]="";
							$fila[$minutoshorainicial]="";
							$fila[$minutoshorafinal]="";
							$fila["&nbsp; "]="";
							$fila["&nbsp;"]="";
							$fila[$estructuramateriashorarios[$materia][$grupo][$i]['salon']]="";
							//$fila[$estructuramateriashorarios[$materia][$grupo][$i]['salon']]="";
							$formulario->dibujar_filas_texto($fila,'','','colspan=1','colspan=1');
							unset($fila);

				}

		}
			unset($fila);
		}
		unset($fila);
		if($encuentrahorarios){
			echo "</table>";
			echo "</td></tr>";

		}


}



echo "<td align='right' colspan='4' class='tdtitulogris'><b>Opciones Horario:</b>";
//echo "<td align='right' >";
/*if(isset($_GET['nuevaopcion'])&&$_GET['nuevaopcion']>0)
echo "<a href='asignaautomaticahorarios.php?Aceptar&documentoingreso=".$_GET['documentoingreso']."&$getenfasis&lineaunica=".$_GET['lineaunica']."&semestrerep=".$_GET['semestrerep']."&nuevaopcion=".($_GET['nuevaopcion']-1)."&materiassinhorarios=$materiasserial&mejoresramashorario=$mejoresramashorarioserial'><<< Anterior </a>&nbsp;";*/
//if($_GET['nuevaopcion']<4)
$i=0;
foreach($mejoresramashorario as  $materia => $grupo  ){

	if(is_array($mejoresramashorario[$i][1])){
			echo "&nbsp;<a href='asignaautomaticahorarios.php?Aceptar&documentoingreso=".$_GET['documentoingreso']."&$getenfasis&lineaunica=".$_GET['lineaunica']."&semestrerep=".$_GET['semestrerep']."&nuevaopcion=".$i."&materiassinhorarios=$materiasserial&mejoresramashorario=$mejoresramashorarioserial'>[".($i+1)."]</a>";
	}
$i++;
}
echo "</td>";

if(isset($mejoresramashorario[$opcionhorario][1])){
		$conboton=0;
		
		if($entrofechavencimiento)
			$onclickfechavence="onclick=\'return validafecha()\'";
		else
			$onclickfechavence="";
	
		$parametrobotonenviar[$conboton]="'submit','grabar','Grabar','$onclickfechavence'";
		$boton[$conboton]='boton_tipo';							
		$conboton++;	

                if ($_GET['lineaunica']) {
                               $parametrobotonenviar[$conboton] = "'hidden','lineaunica','" . $_GET['lineaunica'] . "'";
                               $boton[$conboton] = 'boton_tipo';
                 }
if($_GET['documentoingreso'])
{

		$parametrobotonenviar[$conboton]="'button','regresar','Regresar','onclick=window.location.href=\'../matriculaautomatica.php?documentoingreso=".$_GET['documentoingreso']."\''";
		$boton[$conboton]='boton_tipo';
		$conboton++;					

		$parametrobotonenviar[$conboton]="'hidden','documentoingreso','".$_GET['documentoingreso']."'";
		$boton[$conboton]='boton_tipo';
		//$conboton++;					


}
else
{
	if(isset($_SESSION['cursosvacacionalessesion'])){
		$parametrobotonenviar[$conboton]="'button','regresar','Regresar','onclick=\"window.location.href=\'../matriculaautomatica.php?cursosvacacionales=\'\"'";
	} else {
		$parametrobotonenviar[$conboton]="'button','regresar','Regresar','onclick=\"window.location.href=\'../matriculaautomatica.php?programausadopor=".$_GET['programausadopor']."\'\"'";
	}
		$boton[$conboton]='boton_tipo';
		//$conboton++;					
}



		$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar','',0,'colspan=2');
		///dibujar_campos($tipo,$parametros,$titulo,$estilo_titulo,$idtitulo,$tipo_titulo="",$imprimir=0,$tdcomentario="")
}
if(is_array($mejoresramashorario[$opcionhorario][2])){
$formulario->dibujar_fila_titulo("MATERIAS EXCLUIDAS ",'labelresaltado',4);

	foreach($mejoresramashorario[$opcionhorario][2] as  $materia => $vgrupo  ){
	
		foreach($vgrupo as  $grupo => $nomensaje  ){


			$formulario->dibujar_fila_titulo($estructuradatosmateria[$materia]['nombremateria']." Cod. ".$materia." <----> ".$mensajesexcluidas[$nomensaje],'labelresaltado',4);
			//$fila["Codigo_Materia"]=$materia;//
			$fila["Semestre_Materia"]=$estructuradatosmateria[$materia]['semestreplanestudio'];

			$fila["Codigo_Grupo"]=$grupo;//
			$fila["Docente"]=$estructuramateriashorarios[$materia][$grupo]['nombredocente'];//
			$fila["Nombre_Grupo"]=$estructuramateriashorarios[$materia][$grupo]['nombregrupo'];//
			
			if($nomensaje==1){
			$fila["Seleccionar"]="<input type='checkbox' name='grupo".$materia."' value='$grupo' >";
			}
			$formulario->dibujar_filas_texto($fila,'tdtitulogris','','colspan=1','colspan=1');
			unset($fila);
			
			
			$fila["Cupo_Maximo"]=$estructuramateriashorarios[$materia][$grupo]['maximogrupo'];//
			$fila["Prematriculados"]=$estructuramateriashorarios[$materia][$grupo]['matriculadosgrupoelectiva']+$estructuramateriashorarios[$materia][$grupo]['matriculadosgrupo'];//
			$fila["Fecha_de_inicio"]=$estructuramateriashorarios[$materia][$grupo]['fechainiciogrupo'];//
			$fila["Fecha_de_Vencimiento"]=$estructuramateriashorarios[$materia][$grupo]['fechafinalgrupo'];//
			//$fila["Max_Grupo"]=$estructuramateriashorarios[$materia][$grupo]['maximogrupo'];//
			//$fila["Max_Prematricula"]=$estructuramateriashorarios[$materia][$grupo]['matriculadosgrupoelectiva']+$estructuramateriashorarios[$materia][$grupo]['matriculadosgrupo'];//
			
			$formulario->dibujar_filas_texto($fila,'tdtitulogris','','colspan=1','colspan=1');
			
			
			unset($fila);
		//$fila["Semestre_Materia"]=$estructuradatosmateria[$materia]['semestreplanestudio'];
		//$formulario->dibujar_filas_texto($fila,'tdtitulogris','','colspan=4','colspan=4');
		//unset($fila);

			
		if(isset($estructuramateriashorarios[$materia][$grupo][0])){

		$fila["Dia"]="";
		$fila["Hora_Inicial"]="";
		$fila["Hora_Final"]="";
		$fila["Salon"]="";
		$formulario->dibujar_filas_texto($fila,'tdtitulogris','','colspan=1','colspan=1');
		unset($fila);



			for($i=0;$i<count($estructuramateriashorarios[$materia][$grupo]);$i++)
			{	if(!empty($estructuramateriashorarios[$materia][$grupo][$i]['horainicial'])){
				$fila[$estructuramateriashorarios[$materia][$grupo][$i]['nombredia']]="";
				$minutoshorainicial=$estructuramateriashorarios[$materia][$grupo][$i]['horainicial'] - $estructuramateriashorarios[$materia][$grupo][$i]['dia']*10000;
				$minutoshorafinal=$estructuramateriashorarios[$materia][$grupo][$i]['horafinal'] - $estructuramateriashorarios[$materia][$grupo][$i]['dia']*10000;
				$minutoshorainicial=minutosahora($minutoshorainicial);
				$minutoshorafinal=minutosahora($minutoshorafinal);			
				$fila[$minutoshorainicial]="";
				$fila[$minutoshorafinal]="";
				$fila[$estructuramateriashorarios[$materia][$grupo][$i]['salon']]="";
				$formulario->dibujar_filas_texto($fila,'','','colspan=1','colspan=1');
				unset($fila);
				
				}
				//unset($fila);
			}
			
		}
			
	
		}
	}
}


}

echo "<script type='text/javascript'>muestracarguediv('hidden');</script>";
?>
  </table>
</form>
</div>
