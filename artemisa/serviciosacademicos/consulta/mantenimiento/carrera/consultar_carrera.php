<?php
session_start();
$rutaado=("../../../funciones/adodb/");
require_once('../../../funciones/clases/autenticacion/redirect.php');
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/motor/motor.php");
//require_once('../../../Connections/sap_ado_pear.php');
$fechahoy=date("Y-m-d H:i:s");
//if(!isset($_SESSION['arreglo_carreras']))
{
	$query="SELECT c.codigocarrera,c.nombrecarrera,ma.nombremodalidadacademica
	FROM carrera c,modalidadacademica ma
	WHERE
	c.fechainiciocarrera < '$fechahoy' AND  c.fechavencimientocarrera > '$fechahoy'
	AND c.codigomodalidadacademica=ma.codigomodalidadacademica
	ORDER BY c.nombrecarrera
	";
	$operacion=$sala->query($query);
	$row_operacion=$operacion->fetchRow();
	do
	{
		$array_interno[]=$row_operacion;
	}
	while($row_operacion=$operacion->fetchRow());
	$_SESSION['arreglo_carreras']=$array_interno;
}
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script><script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
<?php
$informe=new matriz($array_interno,"MANTENIMIENTO CARRERAS","consultar_carrera.php","si","si","menu.php");
$informe->agregarllave_drilldown('nombrecarrera','consultar_carrera.php','insertar_carrera.php','carreradetalle','codigocarrera','','','','','',"");
/*
$informe->definir_llave_globo_general('Programa');
$informe->agregarllave_drilldown('Interesados','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Interesados','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."","","","","Seguimiento a alumnos interesados");
$informe->agregar_llaves_totales('Interesados');
*/
$informe->mostrar();