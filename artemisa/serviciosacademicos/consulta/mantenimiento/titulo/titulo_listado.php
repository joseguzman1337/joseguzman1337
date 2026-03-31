<?php
session_start();
 include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$rutaado=("../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado-pear.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/motor/motor.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');

$query="select * from titulo";
$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();
do
{
	$array_interno[]=$row_operacion;
}
while($row_operacion=$operacion->fetchRow());
$arreglo_titulo=$array_interno;

?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script><script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
<?php
$informe=new matriz($arreglo_titulo,"MANTENIMIENTO TITULOS","titulo_listado.php","si","no","menu.php");
$informe->agregarllave_drilldown('codigotitulo','titulo_listado.php','titulo.php','titulos','codigotitulo');
/*$informe->definir_llave_globo_general('Programa');
$informe->agregarllave_drilldown('Interesados','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Interesados','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."","","","","Seguimiento a alumnos interesados");
$informe->agregar_llaves_totales('Interesados');
*/
$informe->mostrar();
?>