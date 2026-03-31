<?php
session_start();
require_once('../../../funciones/clases/autenticacion/redirect.php');
ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');
//print_r($_GET);
error_reporting(0);
?>
<?php
$rutaado=("../../../funciones/adodb/");
require_once('../../../Connections/salaado-pear.php');
//require_once("funciones/obtener_datos.php");
//echo "DESCRIPTOR=".$_SESSION['descriptor_reporte'] ;
?>
<?php
//ini_set('memory_limit', '64M');
//ini_set('max_execution_time','90');
//echo ini_get('memory_limit');
//print_r( ini_get_all());
error_reporting(0);
$_SESSION['nombreprograma'] = "matriculaautomaticabusquedaestudiante.php";
if(!isset($_SESSION['array_sesion']))
{
	echo '<script language="javascript">alert("Sesion perdida, no se puede continuar")</script>';
	exit();
}
require_once("../../../funciones/clases/motor/motor.php");
?>
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<?php
if(isset($_GET['codigoestudiante']))
{
	$_SESSION['estudiante']=$_GET['codigoestudiante'];
}
?>
<?php
//echo "<h1>".count($_SESSION['array_sesion'])."</h1>";
//echo $_SESSION['MM_Username'];
error_reporting(2047);
$queryUsuarioFacultad="SELECT uf.codigofacultad FROM usuariofacultad uf WHERE uf.usuario='".$_SESSION['MM_Username']."'";
$usuarioFacultad=$sala->query($queryUsuarioFacultad);
$rowUsuarioFacultad=$usuarioFacultad->fetchRow();
do{
	$arrayAcceso[]=$rowUsuarioFacultad['codigofacultad'];
}
while(	$rowUsuarioFacultad=$usuarioFacultad->fetchRow());

//print_r($arrayAcceso);

$informe=new matriz($_SESSION['array_sesion'],$_SESSION['titulo'],"tabla_estadisticas_matriculas_detalle.php","si","si","tabla_estadisticas_matriculas.php","menu.php");
if($_SESSION['descriptor_reporte']=='Interesados' or $_SESSION['descriptor_reporte']=='subtotal_Interesados')
{
	if($_SESSION['MM_Username'] == 'admintecnologia' or $_SESSION['MM_Username'] == 'escobarcarlosf' or $_SESSION['MM_Username']=='adminatencionusuario' or $_SESSION['MM_Username']=='admincredito'){
		$informe->agregarllave_drilldown('nombre','../../estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php','../../prematricula/interesados/preinscripcion_seguimiento.php',"seguimiento",'idpreinscripcion','','','','','','');
		$informe->agregarllave_drilldown('emailestudiante','tabla_estadisticas_matriculas.php','../../prematricula/loginpru.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'codigoestudiante','estudiante','emailestudiante');
	}

	else{
		if(in_array($_SESSION['codigocarrera_reporte'],$arrayAcceso)){
			$informe->agregarllave_drilldown('nombre','../../estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php','../../prematricula/interesados/preinscripcion_seguimiento.php',"seguimiento",'idpreinscripcion','','','','','','');
			$informe->agregarllave_drilldown('emailestudiante','tabla_estadisticas_matriculas.php','../../prematricula/loginpru.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'codigoestudiante','estudiante','emailestudiante');
		}
	}

}
elseif($_SESSION['descriptor_reporte']=='Aspirantes' or $_SESSION['descriptor_reporte']=='subtotal_Aspirantes' or $_SESSION['descriptor_reporte']=='Inscritos'  or $_SESSION['descriptor_reporte']=='subtotal_Inscripciones' or $_SESSION['descriptor_reporte']=='a_seguir_aspirantes_vs_inscritos' or $_SESSION['descriptor_reporte']=='subtotal_a_seguir_aspirantes_vs_inscritos' or $_SESSION['inscripcionvsmatriculadosnuevos'])
{
	if($_SESSION['MM_Username'] == 'admintecnologia' or $_SESSION['MM_Username'] == 'escobarcarlosf' or $_SESSION['MM_Username']=='adminatencionusuario' or $_SESSION['MM_Username']=='admincredito'){
		$informe->agregarllave_drilldown('nombre','../serviciosacademicos/consulta/estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php','../../../../aspirantes/enlineacentral.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'numerodocumento','documentoingreso');
	}
	else{
		if(in_array($_SESSION['codigocarrera_reporte'],$arrayAcceso)){
			$informe->agregarllave_drilldown('nombre','../serviciosacademicos/consulta/estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php','../../../../aspirantes/enlineacentral.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'numerodocumento','documentoingreso');
		}
	}
}
else
{
	if($_SESSION['MM_Username'] == 'admintecnologia' or $_SESSION['MM_Username'] == 'escobarcarlosf' or $_SESSION['MM_Username']=='adminatencionusuario' or $_SESSION['MM_Username']=='admincredito'){
		$informe->agregarllave_drilldown('nombre','../../estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php','../../prematricula/loginpru.php','pantallaestudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'codigoestudiante','estudiante');
	}
	else{
		if(in_array($_SESSION['codigocarrera_reporte'],$arrayAcceso)){
			$informe->agregarllave_drilldown('nombre','../../estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php','../../prematricula/loginpru.php','pantallaestudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'codigoestudiante','estudiante');
		}
	}

}
if ($_SESSION['descriptor_reporte']<>"Interesados" and $_SESSION['descriptor_reporte']=="Aspirantes" or  $_SESSION['descriptor_reporte']=="a_seguir_aspirantes_vs_inscritos" or $_SESSION['descriptor_reporte']=="Inscritos" or $_SESSION['descriptor_reporte']=="Prematriculados" or $_SESSION['descriptor_reporte']=="Noprematriculados")
{
	if($_SESSION['MM_Username'] == 'admintecnologia' or $_SESSION['MM_Username'] == 'escobarcarlosf' or $_SESSION['MM_Username']=='adminatencionusuario' or $_SESSION['MM_Username']=='admincredito'){
		$informe->agregarllave_drilldown('numerodocumento','../serviciosacademicos/consulta/estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php','../../prematricula/aspirante/aspiranteseguimiento.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'numerodocumento','documentoingreso',"","Seguimiento al aspirante");
	}
	else{
		if(in_array($_SESSION['codigocarrera_reporte'],$arrayAcceso)){
			$informe->agregarllave_drilldown('numerodocumento','../serviciosacademicos/consulta/estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php','../../prematricula/aspirante/aspiranteseguimiento.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'numerodocumento','documentoingreso',"","Seguimiento al aspirante");
		}
	}
}

if($_SESSION['MM_Username'] == 'admintecnologia' or $_SESSION['MM_Username'] == 'escobarcarlosf' or $_SESSION['MM_Username']=='adminatencionusuario' or $_SESSION['MM_Username']=='admincredito'){
	$informe->agregarllave_drilldown('email','tabla_estadisticas_matriculas.php','../../prematricula/loginpru.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'codigoestudiante','estudiante','email');
	$informe->agregarllave_drilldown('email2','tabla_estadisticas_matriculas.php','../../prematricula/loginpru.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'codigoestudiante','estudiante','email2');
}
else{
	if(in_array($_SESSION['codigocarrera_reporte'],$arrayAcceso)){
		$informe->agregarllave_drilldown('email','tabla_estadisticas_matriculas.php','../../prematricula/loginpru.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'codigoestudiante','estudiante','email');
		$informe->agregarllave_drilldown('email2','tabla_estadisticas_matriculas.php','../../prematricula/loginpru.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'codigoestudiante','estudiante','email2');
	}
}

$informe->mostrar();
?>

