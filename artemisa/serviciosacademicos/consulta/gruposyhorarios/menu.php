<?php
session_start();
if(!isset($_SESSION['MM_Username']))
{
	echo "<h1>Usted no está autorizado para ver esta página</h1>";
	//exit();
}
?>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<script type="text/javascript" src="../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../funciones/clases/formulario/globo.js"></script>
<?php
$fechahoy=date("Y-m-d H:i:s");
$rutaado=("../../funciones/adodb/");
require_once('../../Connections/salaado-pear.php');
require_once('../../funciones/clases/formulario/clase_formulario.php');
$formulario = new formulario($sala,"form1","post","","true","","","","../../../");
$formulario->javaScript();
?>
<form name="form1" action="" method="POST">
<caption align="left">Informes Salones Periodo <?php echo $_SESSION['codigoperiodosesion']?></caption>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<?php
$formulario->celda_horizontal_calendario("fechadesdehorariodetallefecha","Fecha Inicial","","requerido","","Fecha inicial para el informe");
$formulario->celda_horizontal_calendario("fechahastahorariodetallefecha","Fecha Final","","requerido","","Fecha final para el informe");
//$formulario->celda_horizontal_calendarioFechaHora("fechadesdehorariodetallefecha","Fecha/hora inicial","","fecha","horainicial","","","Rango inicial para el informe","","%Y-%m-%e","%H:%M:%S");
//$formulario->celda_horizontal_calendarioFechaHora("fechahastahorariodetallefecha","Fecha/hora final","","fecha","horafinal","","","Rango final para el informe","","%Y-%m-%e","%H:%M:%S");
$formulario->celda_horizontal_combo("codigosede","Sede","sede","","codigosede","nombresede","requerido","","","nombresede","Informe por Sede, o criterio para poder seleccionar salón","onChange='document.form1.submit()'");
$formulario->celda_horizontal_combo("codigosalon","Salón","salon","","codigosalon","codigosalon","","","codigosede='".$_POST['codigosede']."'","codigosalon","Informe por salón","");
?>

</table>
<input type="submit" name="Enviar" value="Enviar">
</form>
<?php
if(isset($_REQUEST['Enviar']))
{
	$formulario->submitir();
	$validacion=$formulario->valida_formulario();
	if($validacion==true)
	{
		list($ano_ini,$mes_ini,$dia_ini)=explode("-",$_REQUEST['fechadesdehorariodetallefecha']);
		list($ano_fin,$mes_fin,$dia_fin)=explode("-",$_REQUEST['fechahastahorariodetallefecha']);
		
		$fecha_ini=$ano_ini."-".($mes_ini*1)."-".($dia_ini*1);
		$fecha_fin=$ano_fin."-".($mes_fin*1)."-".($dia_fin*1);
		
		echo '<script language="javascript">reCarga("listado.php?fechaini='.$fecha_ini.'&fechafin='.$fecha_fin.'&codigosede='.$_REQUEST['codigosede'].'&codigosalon='.$_REQUEST['codigosalon'].'&link_origen=menu.php")</script>';
	}
}
?>
