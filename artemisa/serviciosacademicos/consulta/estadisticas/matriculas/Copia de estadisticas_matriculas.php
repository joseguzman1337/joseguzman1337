<?php
session_start();
require_once('../../../funciones/clases/autenticacion/redirect.php');
ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');
//print_r($_SESSION);
error_reporting(0);
if(isset($_GET['codigomodalidadacademica']) and isset($_GET['codigocarrera']) and isset($_GET['codigoperiodo']))
{
	$_SESSION['codigomodalidadacademica']=$_GET['codigomodalidadacademica'];
	$_SESSION['codigocarrera']=$_GET['codigocarrera'];
	$_SESSION['codigoperiodo_reporte']=$_GET['codigoperiodo'];
}
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
require_once('funciones/funcion-barra.php');
require_once("funciones/obtener_datos.php");
?>
<?php
setlocale(LC_MONETARY, 'en_US');
$fechahoy=date("Y-m-d H:i:s");
?>
<?php
$contador=0;
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<table width='100%'  border='0'><tr><td><div align='center'><h3>Este proceso puede demorar algunos minutos, porfavor espere...</h3></div></td></tr></table>";
echo "<div id='progress' style='position:relative;padding:0px;width:768px;height:60px;left:25px;'>";
$datos_matriculas=new obtener_datos_matriculas($sala,$_SESSION['codigoperiodo_reporte']);
if(isset($_SESSION['codigomodalidadacademica']) and isset($_SESSION['codigocarrera']))
{
	if($_SESSION['codigomodalidadacademica']=="todos" and $_SESSION['codigocarrera']=="todos")
	{
		$carreras=$datos_matriculas->obtener_carreras("","");
	}
	elseif($_SESSION['codigomodalidadacademica']=="todos" and $_SESSION['codigocarrera']!="todos")
	{
		$carreras=$datos_matriculas->obtener_carreras("",$_SESSION['codigocarrera']);
	}
	elseif($_SESSION['codigomodalidadacademica']!="todos" and $_SESSION['codigocarrera']=="todos")
	{
		$carreras=$datos_matriculas->obtener_carreras($_SESSION['codigomodalidadacademica'],"");
	}
	else
	{
		$carreras=$datos_matriculas->obtener_carreras("",$_SESSION['codigocarrera']);
	}
}
foreach ($carreras as $llave_carreras => $valor_carreras)
{

	if($contador % 3==0)
	{
		echo '<img src="funciones/barra.gif" width="8" height="28">';
	}
	$datos_matriculas->barra();
	$array_datos[$contador]['codigocarrera']=$valor_carreras['codigocarrera'];
	$array_datos[$contador]['Centro_Beneficio']=$valor_carreras['centrobeneficio'];
	$array_datos[$contador]['Programa']=$valor_carreras['nombrecarrera'];
	$array_datos[$contador]['Interesados']=$datos_matriculas->obtener_preinscripcion_estadopreinscripcionestudiante_general($valor_carreras['codigocarrera'],'conteo');
	$array_datos[$contador]['Aspirantes']=$datos_matriculas->ObtenerAspirantesSinmatriculaSinPago($valor_carreras['codigocarrera'],$_SESSION['codigoperiodo_reporte'],'conteo');
	$array_datos[$contador]['a_seguir_aspirantes_vs_inscritos']=$datos_matriculas->obtener_datos_aspirantes_vs_inscritos($_SESSION['codigoperiodo_reporte'],$valor_carreras['codigocarrera'],'conteo');
	$array_datos[$contador]['Inscritos']=$datos_matriculas->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago($_SESSION['codigoperiodo_reporte'],$valor_carreras['codigocarrera'],153,'conteo');
	$array_datos[$contador]['a_seguir_inscritos_vs_matriculados_nuevos']=$datos_matriculas->seguimiento_inscripcionvsmatriculadosnuevos($valor_carreras['codigocarrera'],'conteo');
	$array_datos[$contador]['Matriculados_Nuevos']=$datos_matriculas->obtener_datos_estudiantes_matriculados_nuevos($valor_carreras['codigocarrera'],'conteo');
	$array_datos[$contador]['Matriculados_Antiguos']=$datos_matriculas->obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante($valor_carreras['codigocarrera'],20,'conteo');
	$array_datos[$contador]['Matriculados_Transferencia']=$datos_matriculas->obtener_datos_estudiantes_matriculados_transferencia($valor_carreras['codigocarrera'],'conteo');
	$array_datos[$contador]['Matriculados_Reintegro']=$datos_matriculas->obtener_datos_estudiantes_reintegro($valor_carreras['codigocarrera'],'conteo');
	$array_datos[$contador]['Total_Matriculados']=$datos_matriculas->obtener_total_matriculados($valor_carreras['codigocarrera'],'conteo');	
	$array_datos[$contador]['Matriculados_Repitentes_1_semestre']=$datos_matriculas->obtener_datos_estudiantes_matriculados_repitentes($valor_carreras['codigocarrera'],20,'conteo');
	$array_datos[$contador]['Matriculados_Transferencia_1_semestre']=$datos_matriculas->obtener_datos_estudiantes_matriculados_transferencia_1_semestre($valor_carreras['codigocarrera'],'conteo');
	$array_datos[$contador]['Matriculados_Reintegro_1_semestre']=$datos_matriculas->obtener_datos_estudiantes_reintegro_1_semestre($valor_carreras['codigocarrera'],'conteo');
	$array_datos[$contador]['Total_Matriculados_1_semestre']=$datos_matriculas->obtener_total_matriculados_1_semestre($valor_carreras['codigocarrera'],'conteo');	
	$array_datos[$contador]['a_seguir_Prematriculados']=$datos_matriculas->obtener_datos_cuentaoperacionprincipal_ordenesnopagas($_SESSION['codigoperiodo_reporte'],$valor_carreras['codigocarrera'],151,'conteo');
	$array_datos[$contador]['a_seguir_No_prematriculados']=$datos_matriculas->obtener_datos_estudiantes_noprematriculados($valor_carreras['codigocarrera'],'conteo');
	$contador++;
}

echo "</div>";
if(is_array($array_datos))
{
	$_SESSION['array_estadisticas']=$array_datos;
}
//$datos_matriculas->listar($array_datos);
 echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=tabla_estadisticas_matriculas.php'>";
//echo '<script language="javascript">window.location.reload("tabla_estadisticas_matriculas.php");</script>';
?>