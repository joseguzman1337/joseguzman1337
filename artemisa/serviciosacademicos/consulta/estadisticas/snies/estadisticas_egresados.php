<?php
//session_start();
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
?>
<script language="Javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>
<script language="javascript">
function enviar()
{
	document.form1.submit()
}
</script>
<?php
$rutaado=("../../../funciones/adodb/");
require_once('../../../Connections/salaado-pear.php');
require_once('../../../funciones/clases/motor/motor.php');
require_once("funciones/obtener_datos.php");
?>
<?php
setlocale(LC_MONETARY, 'en_US');
$fechahoy=date("Y-m-d H:i:s");
$contador=0;
if(!isset($_SESSION['datos']))
{
	$snies = new snies($sala,'20061');
	$array_carreras=$snies->obtener_carreras();
	$array_egresados=$snies->obtener_egresados();
	foreach ($array_egresados as $llave_egresados => $valor_egresados)
	{
		$datos_estudiante=$snies->obtener_datos_estudiante($valor_egresados['codigoestudiante']);
		$datos_carrera=$snies->obtener_reg_icfes($valor_egresados['codigocarrera']);
		$array_datos[$contador]['codigocarrera']=$valor_egresados['codigocarrera'];
		$array_datos[$contador]['idestudiantegeneral']=$datos_estudiante['idestudiantegeneral'];
		$array_datos[$contador]['codigoestudiante']=$valor_egresados['codigoestudiante'];
		$array_datos[$contador]['cod_ies']='01729';
		$array_datos[$contador]['num_icfes']='';
		$array_datos[$contador]['cc_id']=$datos_estudiante['nombrecortodocumento'];
		$array_datos[$contador]['num_id']=$datos_estudiante['numerodocumento'];
		$array_datos[$contador]['nombre1']=$datos_estudiante['nombresestudiantegeneral'];
		$array_datos[$contador]['nombre2']='';
		$array_datos[$contador]['apellido1']=$datos_estudiante['apellidosestudiantegeneral'];
		$array_datos[$contador]['apellido2']='';
		$array_datos[$contador]['sexo']=$datos_estudiante['genero'];
		$array_datos[$contador]['fec_nace']=$datos_estudiante['fecha_nacimiento'];
		$array_datos[$contador]['fec_grado']=$valor_egresados['fechagradoregistrograduado'];
		$array_datos[$contador]['cod_pro']=$datos_carrera['numeroregistrocarreraregistro'];
		$array_datos[$contador]['nom_pro']=$valor_egresados['nombrecarrera'];
		$array_datos[$contador]['num_acta']=$valor_egresados['numeroactaregistrograduado'];
		$array_datos[$contador]['num_folio']=$valor_egresados['idregistrograduadofolio'];
		$contador++;
	}

	if(is_array($array_datos))
	{
		$_SESSION['datos']=$array_datos;
	}
}

$tabla = new matriz($_SESSION['datos'],'Datos Egresados SNIES','estadisticas_egresados.php','si','si','');
//$tabla->agregar_llaves_totales('');
//var_dump($tabla);
$tabla->mostrar();
//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=tabla_estadisticas_matriculas.php'>";
//echo '<script language="javascript">window.location.reload("tabla_estadisticas_matriculas.php");</script>';
?>