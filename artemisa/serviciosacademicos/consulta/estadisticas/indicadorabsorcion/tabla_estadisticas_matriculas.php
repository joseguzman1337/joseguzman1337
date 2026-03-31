<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
//require_once('../../../funciones/clases/autenticacion/redirect.php');
ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');

unset($_SESSION['sesionFecha_Proximo_Contacto']);
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<?php
//ini_set('memory_limit', '64M');
//ini_set('max_execution_time','90');
//echo ini_get('memory_limit');
//print_r( ini_get_all());
//error_reporting(0);
$_SESSION['get']=$_GET;
if(!isset($_SESSION['array_estadisticas']))
{
	echo '<script language="javascript">alert("Sesion perdida, no se puede continuar")</script>';
	exit();
}
require_once("../../../funciones/clases/motor/motor.php");
?>
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<?php
$informe=new matriz($_SESSION['array_estadisticas'],"Estadísticas matrículas periodo ".$_SESSION['codigoperiodo_reporte'],"tabla_estadisticas_matriculas.php","si","no","menu.php","estadisticas_matriculas.php");
$informe->definir_llave_globo_general('Programa');
$informe->agregarllave_drilldown('Inscritos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Inscritos','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']);
$informe->agregarllave_drilldown('Inscritos_Admitidos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Inscritos_Admitidos','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']);
$informe->agregarllave_drilldown('Admitidos_Matriculados','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Admitidos_Matriculados','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']);


$informe->agregar_llaves_totales('Inscritos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Inscritos',"codigoperiodo=".$_SESSION['codigoperiodo_reporte'],'codigocarrera','','Inscritos');
$informe->agregar_llaves_totales('Inscritos_Admitidos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Inscritos_Admitidos',"codigoperiodo=".$_SESSION['codigoperiodo_reporte'],'codigocarrera','','Inscritos_Admitidos');
$informe->agregar_llaves_totales('Admitidos_Matriculados','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Admitidos_Matriculados',"codigoperiodo=".$_SESSION['codigoperiodo_reporte'],'codigocarrera','','Admitidos_Matriculados');
$informe->mostrar();
?>
<?php
$matriz=$_SESSION['array_estadisticas'];
$array_combo_columnas=array_keys($matriz[0]);
function DatosColumnaParaEstadisticas($columna_nombres,$columna_valores,$matriz)
{
	unset($_SESSION['datos_pie']);
	for ($i=0;$i<count($matriz);$i++)
	{
		$array_datos_pie[$i]=array('etiquetas'=>$array_etiquetas_pie[$i]=$matriz[$i][$columna_nombres],'valores'=>$matriz[$i][$columna_valores]);
	}
	$_SESSION['datos_pie']=$array_datos_pie;
}
?>
<form name="form2" method="get" action="">
<input name="Grafico" type="submit" id="Grafico" value="Grafico">
<select name="columna" id="columna">
<option value="">Seleccionar</option>
<?php foreach ($array_combo_columnas as $llave => $valor)
{ ?>
	<option value="<?php echo $valor?>"><?php echo $valor?></option>
<? } ?>
</select>

<?php
if($_GET['columna']<>"")
{
	DatosColumnaParaEstadisticas('Programa',$_GET['columna'],$matriz);


?>
	<script language="javascript">window.open('pie_estadisticas_matriculas.php?datos_pie=<?php echo $datos_pie;?>&etiquetas_pie=<?php echo $datos_etiquetas_pie?>&columna=<?php echo $_GET['columna']?>')</script>
<? } ?>
</form>
