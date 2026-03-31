<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
if(!isset($_SESSION['MM_Username'])){
	echo "<h1>Usted no está autorizado para abrir esta pagina</h1>";
	exit();
}
ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');
$rutaado=("../../../funciones/adodb/");
require_once('../../../Connections/salaado-pear.php');
require_once("../matriculas/funciones/obtener_datos.php");
require_once("funciones/obtenerDatos.php");
require_once('../../../funciones/clases/motorv2/motor.php');

if(isset($_GET['codigomodalidadacademica']) and isset($_GET['codigocarrera']) and isset($_GET['codigoperiodo']))
{
	$_SESSION['codigomodalidadacademica']=$_GET['codigomodalidadacademica'];
	$_SESSION['codigocarrera']=$_GET['codigocarrera'];
	$_SESSION['codigoperiodo_reporte']=$_GET['codigoperiodo'];
}
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<?php
$estadisticasSeguimiento = new estadisticasSeguimiento($_SESSION['codigoperiodo_reporte'],$_SESSION['codigomodalidadacademica'],$_SESSION['codigocarrera'],null,&$sala);
$estadisticasMatriculas = new obtener_datos_matriculas($sala,$_SESSION['codigocarrera_reporte']);
$arrayEstadisticasSeguimiento=$estadisticasSeguimiento->creaArrayEstadisticasSeguimiento();
$motor = new matriz($arrayEstadisticasSeguimiento,"Informe de Seguimiento a Interesados y Aspirantes",'principal.php',"si","si","menu.php","",false,"si","../../../");
$motor->jsVarios();
$motor->agregarllave_drilldown('interesados_total','principal.php','detalle.php','interesados_total','codigocarrera','','','','','Click aquí para detalle de interesados','');
$motor->agregarllave_drilldown('interesados_con_seg','principal.php','detalle.php','interesados_con_seg','codigocarrera','','','','','Click aquí para detalle de interesados con algún seguimiento','');
$motor->agregarllave_drilldown('interesados_sin_seg','principal.php','detalle.php','interesados_sin_seg','codigocarrera','','','','','Click aquí para detalle de interesados sin seguimiento','');
$motor->agregarllave_drilldown('aspirantes_total','principal.php','detalle.php','aspirantes_total','codigocarrera','','','','','Click aquí para detalle de aspirantes');
$motor->agregarllave_drilldown('aspirantes_con_seg','principal.php','detalle.php','aspirantes_con_seg','codigocarrera','','','','','Click aquí para detalle de aspirantes con algún seguimiento');
$motor->agregarllave_drilldown('aspirantes_sin_seg','principal.php','detalle.php','aspirantes_sin_seg','codigocarrera','','','','','Click aquí para detalle de aspirantes sin seguimiento');
$motor->mostrarTitulo=true;
$motor->botonRecargar=false;
$motor->mostrar();
?>


<?php
function tabla($matriz,$texto="")
{
	if(is_array($matriz))
	{
		echo "<table border=1 cellpadding='2' cellspacing='1' align=center>\n";
		echo "<caption align=TOP>$texto</caption>";
		escribir_cabeceras($matriz[0]);
		for($i=0; $i < count($matriz); $i++)
		{
			echo "<tr>\n";
			while($elemento=each($matriz[$i]))
			{
				echo "<td nowrap>$elemento[1]&nbsp;</td>\n";
			}
			echo "</tr>\n";
		}
		echo "</table>\n";
	}
	else
	{
		echo $texto." Matriz no valida<br>";
	}
}

function escribir_cabeceras($matriz)
{
	echo "<tr>\n";
	while($elemento = each($matriz))
	{
		echo "<td>$elemento[0]</a></td>\n";
	}
	echo "</tr>\n";
}
?>