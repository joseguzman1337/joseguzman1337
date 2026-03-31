<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../Connections/sala2.php');
require_once('../../../funciones/funcionip.php');
session_start();
$ruta = "../../../funciones/";
$rutaorden = "../../../funciones/ordenpago/";
require_once($rutaorden.'claseordenpago.php');
mysql_select_db($database_sala, $sala);

if(!isset($_GET['visualizarordenes']))
{
	if(isset($_GET['todos']))
	{
		$ordenesxestudiante = new Ordenesestudiante($sala, $_GET['codigoestudiante'], $_GET['codigoperiodo']);
		$cuentaconceptos = $ordenesxestudiante->existe_conceptosinscripcion($pagos, $porpagar, $enproceso, $sinpagar, $cuentaconceptos);
		// Aca entran los conceptos de la facultad, 153 y 152
		if(!$ordenesxestudiante->validar_generacionordenesinscripcion())
		{
?>
<script language="javascript">
	history.go(-1);
</script>
<?php
			exit();
		}
		@$ordenesxestudiante->generarordenpago_conceptosinscripcion($sinpagar);
	?>
	<script language="javascript">
		window.location.reload("generarordenpagoinscripcion.php?documentoingreso=<?php echo $_GET['documentoingreso'];?>&codigoestudiante=<?php echo $_GET['codigoestudiante'];?>&codigoperiodo=<?php echo $_GET['codigoperiodo'];?>");
	</script>
	<?php
	}
	else if(isset($_GET['formulario']))
	{
		$ordenesxestudiante = new Ordenesestudiante($sala, $_GET['codigoestudiante'], $_GET['codigoperiodo']);
		//$cuentaconceptos = $ordenesxestudiante->existe_conceptosinscripcion($pagos, $porpagar, $enproceso, $sinpagar, $cuentaconceptos);
		$conceptos[] = 152;
		if(!$ordenesxestudiante->validar_generacionordenesinscripcion())
		{
?>
<script language="javascript">
	history.go(-1);
</script>

<?php
			exit();
		}
		$ordenesxestudiante->generarordenpago_conceptosinscripcion($conceptos);
		$cuentaconceptos = $ordenesxestudiante->existe_conceptosinscripcion($pagos, $porpagar, $enproceso, $sinpagar, $cuentaconceptos);
	?>
	<script language="javascript">
		window.location.reload("generarordenpagoinscripcion.php?documentoingreso=<?php echo $_GET['documentoingreso'];?>&codigoestudiante=<?php echo $_GET['codigoestudiante'];?>&codigoperiodo=<?php echo $_GET['codigoperiodo'];?>");
	</script>
	<?php
	}
	else 
	{
		$ordenesxestudiante = new Ordenesestudiante($sala, $_GET['codigoestudiante'], $_GET['codigoperiodo']);
		$cuentaconceptos = $ordenesxestudiante->existe_conceptosinscripcion($pagos, $porpagar, $enproceso, $sinpagar, $cuentaconceptos);
	}
}
else
{
	$ordenesxestudiante = new Ordenesestudiante($sala, $_GET['codigoestudiante'], $_GET['codigoperiodo']);
}
?>
<html>
<head>
<title>Visualizar Ordenes Inscripción</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; font-weight: bold; }
-->
</style>
<body>
<!-- <h2 align="center">
<?php
if(!isset($_GET['visualizarordenes']))
{
?>
FORMULARIO DE VISUALIZACIÓN Y GENERACIÓN DE ORDES DE PAGO PARA INSCRIPCIONES
<?php
}
else
{
?>
FORMULARIO DE VISUALIZACIÓN DE ORDES DE PAGO
<?php
}
?>
</h2> -->
<?php
// 1. Muestra los conceptos de inscripción que debe generar el estudiante
//echo "dos ".$cuentaconceptos['sinpagar'];
if(!isset($_GET['visualizarordenes']))
{
	if($cuentaconceptos['sinpagar'] > 0)
	{
		// Antes de generar la orden de pago se deben hacer todas las validaciones
		//echo $ordenesxestudiante->validar_generacionordenesinscripcion();
		//exit();
		if(!$ordenesxestudiante->validar_generacionordenesinscripcion())
		{
?>
<script language="javascript">
	history.go(-1);
</script>
<?php
		}
		
		if(!ereg("estudiante",$_SESSION['MM_Username']))
		{
			//$ordenesxestudiante->mostrar_generacionordenesinscripcion($sinpagar);
		}
		else
		{
			// Si va generar ambos, quiere decir que lo hace el estudiante, toca cobrarle los conceptos 
			// de formulario e inscripción a valor de internet
			//$ordenesxestudiante->mostrar_generacionordenesinscripcion($sinpagar, $generarambos=true);
		}
	}
}
//$ordenesxestudiante->mostrar_ordenespago($rutaorden,"");
?>
<div align="center">
<br>
<br>
<?php
//if(!isset($_GET['visualizarordenes']))
//{
echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../../../aspirantes/enlineacentral.php?documentoingreso=".$_GET['documentoingreso']."'>";
?>
<script language="javascript">
	//window.location.reload("formulariopreinscripcion.php?documentoingreso=<?php echo $_GET['documentoingreso']; ?>&logincorrecto");
</script>
<?php
//}
?>
<!-- <input type="button" value="Regresar" onClick="window.location.reload('formulariopreinscripcion.php?documentoingreso=<?php echo $_GET['documentoingreso']; ?>&logincorrecto')"> -->
</div>
</body>
<script language="javascript">
function recargar(dir)
{
	window.location.reload("generarordenpagoinscripcion.php"+dir+"&planestudio='.$idplanestudio.'&visualizado");
	history.go();
}
</script>
</html>
