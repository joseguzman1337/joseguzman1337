<?php
session_start();
if(!isset($_SESSION['MM_Username']))
{
	echo "<h1>Usted no está autorizado para ver esta página</h1>";
	exit();
}
ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');
//error_reporting(2047);
?>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
</STYLE>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<script type="text/javascript" src="../../funciones/javascript/funciones_javascript.js"></script>
<!--<a href="menu.php">Atrás</a>-->
<?php
$fechahoy=date("Y-m-d H:i:s");
$rutaado=("../../funciones/adodb/");
require_once('../../Connections/salaado-pear.php');
require_once("../../funciones/clases/motorv2/motor.php");
require_once("../../funciones/clases/formulariov2/clase_formulario.php");
require_once("funciones/calendarioSalones.php");
$codigoperiodo=$_SESSION['codigoperiodosesion'];
if(empty($codigoperiodo))
{
	echo "<h1>Se ha perdido la sesión, no se puede continuar</h1>";
	exit();
}
if($_GET['depurar']=='si')
{
	$depurar=true;
	$sala->debug=true;
}
else
{
	$depurar=false;
}

if ($HTTP_GET_VARS["dia"] != "") {
	$dia = $HTTP_GET_VARS["dia"]; } else {
		$dia = date("d");			 }

		if ($HTTP_GET_VARS["mes"]) {
			$mes = $HTTP_GET_VARS["mes"]; } else {
				$mes = date("m");			 }

				if ($HTTP_GET_VARS["ano"]) {
					$ano = $HTTP_GET_VARS["ano"]; } else {
						$ano = date("Y");			 }

						if($HTTP_GET_VARS["semana"]){
							$semana=$HTTP_GET_VARS["semana"]; } else {

								$semana = date("W");}

								if(isset($_REQUEST['fecha']) and $_REQUEST['fecha']<>"")
								{
									list($ano,$mes,$dia)=explode("-",$_REQUEST['fecha']);
								}

								$cal = new CalendarioSalones($dia,$mes,$ano,&$sala);

								if(!isset($_GET['semana']))
								{
									$semana=$cal->devuelveNumeroSemanaFecha($ano,$mes,$dia);
								}
								else
								{
									$semana=$_GET['semana'];
								}

								$cal->asignaSemana($semana);
								$cal->HKSetaPaginaRaiz("?");

								$formulario = new formulario(&$sala,"formulario","get","",true,"listado_nuevo.php");
								$formulario->rutaraiz="../../../";
								$formulario->jsCalendario();
?>
<body>
<h3>Seleccione Sede:</h3>
<br>
<form id="form1" name="form1" method="get" action="">
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<?php $formulario->celda_horizontal_combo("codigosede","Sede","sede","","codigosede","nombresede","requerido","","","nombresede","Informe por Sede, o criterio para poder seleccionar salón","onChange='document.form1.submit()'");?>
<?php $formulario->celda_horizontal_combo("codigosalon","Salón","salon","","codigosalon","codigosalon","requerido","","codigosede='".$_GET['codigosede']."'","codigosalon","Informe por salón","");?>
<?php $formulario->celda_horizontal_calendario("fecha","Fecha","fecha","","","Ir a fecha exacta");?>
</table>
<?php $formulario->Boton("Enviar","Enviar");?>
<br><br>
<?php
if(isset($_REQUEST['Enviar']))
{
	$cal->asignarCodigoSalon($_REQUEST['codigosalon']);
	$cal->asignarCodigoperiodo($codigoperiodo);
	$cal->iteradorMeses();
	$array_dias=$cal->iteradorSemanas();
	//print_r($array_dias);
?>
<?php 
$array_rango_horas=$cal->generaRangosEstandar();
list($a,$m,$d)=explode("-",$array_dias[0]['fecha']);
if($m<10)
{
	$m="0".$m;
}
$array_dias[0]['fecha']=$a."-".$m."-".$d;
?>
<h3 align="center">Horario Salón <?php echo $_GET['codigosalon']?> periodo <?php echo $codigoperiodo?> Semana <?php echo $cal->semana?> desde <?php echo $cal->fechaini?> hasta <?php echo $cal->fechafin?></h3>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" onClick="print()" width="100%">
<tr>
	<td align="center">Hora Ini</td>
	<td align="center">Hora Fin</td>
	<?php foreach ($array_dias as $llave_d => $valor_d){?>
	<td align="center" width="180"><?php echo $valor_d['dia']?></td>
	<?php }?>
</tr>
<?php foreach ($array_rango_horas as $llave_h => $valor_h){?>
<tr>
	<td align="center" height="30"><?php echo $valor_h['hora_ini']?></td>
	<td align="center"><?php echo $valor_h['hora_fin']?></td>
	<?php foreach ($array_dias as $llave_d => $valor_d){
		$horario=$cal->obtenerHorarioSalonconHorariodetallefecha($_REQUEST['codigosalon'],$valor_d['fecha'],$valor_h['hora_ini'],$valor_h['hora_fin'],$codigodia);
		if(!empty($horario))
		{
			$colorHorario=$cal->obtenerColorHorario($horario['codigocarrera']);
		}
		else
		{
			$colorHorario=null;
		}
		?>
		<td align="center" bgcolor="<?php echo $colorHorario?>"><?php if(!empty($horario['idhorariodetallefecha']))
		{
			echo $horario['nombremateria']," ","(",$horario['codigomateria'],")";
			echo "<br>";
			echo $horario['nombrecarrera'];
		}
		else
		{
			echo "&nbsp;";
		}?></td>
	<?php }?>
</tr>
<?php } ?>
</table>
<?php } ?>
</form>