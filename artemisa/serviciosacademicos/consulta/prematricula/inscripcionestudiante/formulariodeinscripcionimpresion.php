<?php
    
session_start();
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
//$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php');
require_once('../../../funciones/sala/estudiante/estudiante.php');  
require_once('../../../funciones/sala/inscripcion/inscripcion.php'); 
//require_once("../../../funciones/funcionboton.php");


$ruta = "../../../funciones/sala/inscripcion/";

set_time_limit(900000000);

//print_r($_SERVER);
//echo $_SERVER['argv'][0];
if(!isset($_SESSION['fppal']))
	$_SESSION['fppal'] = $_SERVER['argv'][0];
	
//echo "<pre>".print_r($_SESSION)."</pre>";
	

//echo "<h1>".$_SESSION['fppal']."</h1>";
?>
<html>
<head><title>FORMULARIO DE INSCRIPCION</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="JavaScript" src="calendario/javascripts.js"></script>
<script type="text/javascript">
function alternar(division){
	//alert(division.style.display);
	calcular_edad();
	if (division.style.display=="none")
    {
    	division.style.display="";
    }
    else
    {
    	division.style.display="none"
    } 
}
function recargar(direccioncompleta, direccioncompletalarga)
{
	document.informacionAspirante.direccion1.value=direccioncompletalarga;
	document.informacionAspirante.direccion1oculta.value=direccioncompleta;
}
function calcular_edad()
{
	var fecha = document.informacionAspirante.fecha1.value;
	now = new Date()
	bD = fecha.split('-');
	if(bD.length == 3)
	{
		born = new Date(bD[0], bD[1]*1-1, bD[2]);
	   	years = Math.floor((now.getTime() - born.getTime()) / (365.25 * 24 * 60 * 60 * 1000));
	}
	document.informacionAspirante.edad1.value = years;
    return years;
}
// Esta funcion recargar1 sirve para los datos de estudios
function recargar1(codigocolegio, nombrecolegio)
{
 	document.informacionEstudios.idinstitucioneducativa.value = codigocolegio;
 	document.informacionEstudios.institucioneducativa.value = nombrecolegio;
}
</script>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
</head>
<body>
<h3>FORMULARIO DE INSCRIPCIÓN</h3>
<b>AÑO
<?php
//print_r($_REQUEST);
$idsubperiodo = $_REQUEST['idsubperiodo']; 
$query_per = "select cp.codigoperiodo 
from subperiodo s, carreraperiodo cp
where s.idcarreraperiodo  = cp.idcarreraperiodo
and s.idsubperiodo = '$idsubperiodo'";
//echo $query_valida,"<br>";
$per = $db->Execute($query_per);
$totalRows_per = $per->RecordCount();
$row_per = $per->FetchRow();

echo substr($row_per['codigoperiodo'],0,4);
?>
&nbsp;&nbsp;&nbsp;&nbsp;
Periodo Calendario para el cual se inscribe: &nbsp; 
<?php
echo substr($row_per['codigoperiodo'],4,1);
?>
</b><br>
<?php
$numerodocumento = $_REQUEST['documento'];
$codigomodalidadacademica = $_REQUEST['modalidad'];
$codigomodalidadacademicasesion = $_SESSION['modalidadacademicasesion'];

$idestudiantegeneral = tomarIdestudiantegeneral($numerodocumento);
$estudiantegeneral = new estudiantegeneral($idestudiantegeneral);
//echo "<pre>".print_r($estudiantegeneral)."</pre>";

$idsubperiodo = $_REQUEST['idsubperiodo'];
$idinscripcion = $_REQUEST['inscripcionactiva'];
$_SESSION['inscripcionsession'] = $idinscripcion;
$inscripcion = new inscripcion($estudiantegeneral, $idsubperiodo, $idinscripcion,$codigomodalidadacademica);
?>
<b>CARRERA O PROGRAMA A QUE ASPIRA:
<?php
//$db->debug = true;
/*Modified Diego Rivera<riveradiego@unbsque.edu.co>
 *Se añade subconsulta en consulta $query_estudiantecarrera con el fin de determinar el  ultimo periodo academico registrado respecto a la carrera inscrita
 *AND e.codigoperiodo =(select max(codigoperiodo) from estudiante where  idestudiantegeneral='".$idestudiantegeneral."
 * *Since May 16,2018   
 *  */
$query_estudiantecarrera = "select c.nombrecarrera,e.codigoestudiante from carrera c, estudiante e 
where c.codigocarrera = '".$_SESSION['codigocarrerasesion']."' AND e.codigocarrera=c.codigocarrera 
AND e.idestudiantegeneral='".$idestudiantegeneral."' AND e.codigoperiodo =(select max(codigoperiodo) from estudiante where  idestudiantegeneral='".$idestudiantegeneral."')";
$estudiantecarrera = $db->Execute($query_estudiantecarrera);
$totalRows_estudiantecarrera = $estudiantecarrera->RecordCount();
$row_estudiantecarrera = $estudiantecarrera->FetchRow();
?>
<label style="text-decoration: underline;">
<?php 
echo $row_estudiantecarrera['nombrecarrera'];
?>
</label>
</b>
<?php
$query_estudiantecarrera = "select lugarRotacionBase from LugarRotacionCarreraEstudiante c, LugarRotacionCarrera l 
where c.codigoestudiante = '".$row_estudiantecarrera['codigoestudiante']."' AND c.codigoestado=100 
AND l.LugarRotacionCarreraID=c.LugarRotacionCarreraID";
$estudiantecarrera2 = $db->Execute($query_estudiantecarrera);
$totalRows_estudiantecarrera = $estudiantecarrera2->RecordCount();
$row_estudiantecarrera2 = $estudiantecarrera2->FetchRow();
if($totalRows_estudiantecarrera >0){ ?>
<br><b>LUGAR DE ROTACIÓN:
<label style="text-decoration: underline;">
<?php echo $row_estudiantecarrera2["lugarRotacionBase"]; ?>
</label>
</b>
<?php }
$inscripcion->imprimirFormulario();
?>
<script type="text/javascript">
	calcular_edad();
</script>
<?php
//exit();
?>
</body>
<script type="text/javascript">
	window.print();
	//alert("Se va a cerrar");
	//window.close();
</script>
</html>
