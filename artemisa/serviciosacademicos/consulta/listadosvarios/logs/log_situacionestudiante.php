<style type="text/css">
<!--
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo5 {font-size: 9px}
-->
</style>
<?php
require_once('../../../Connections/sala2.php');
require_once('../../mantenimiento/funciones/tabla_fn.php');
mysql_select_db($database_sala, $sala);
if(!isset($codigoestudiante)){
	$codigoestudiante = $_GET["codigoestudiante"];
}
$query_log_situacionestudiante="select concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) ".
" as nombre,e.codigoestudiante,nombresituacioncarreraestudiante ".
" as situacion_estudiante,hse.codigoperiodo,usuario,fechahistoricosituacionestudiante as fecha,".
" fechainiciohistoricosituacionestudiante as fechainicio, ".
" fechafinalhistoricosituacionestudiante as fechafinal ".
" from historicosituacionestudiante hse, situacioncarreraestudiante sce, estudiante e,estudiantegeneral eg ".
" where ".
" hse.codigosituacioncarreraestudiante=sce.codigosituacioncarreraestudiante and ".
" hse.codigoestudiante='".$codigoestudiante."' and e.codigoestudiante=hse.codigoestudiante ".
" and e.idestudiantegeneral=eg.idestudiantegeneral ";
$log_situacionestudiante=mysql_query($query_log_situacionestudiante,$sala);

$fechahoy=date("Y-m-d H:i:s");

?>
<div align="center">
  <p><img src="../../../../imagenes/logoweb2.jpg" width="200" height="62" onClick="print()"></p>
  <p class="Estilo2">LOG SITUACION ESTUDIANTE </p>
  <p align="right" class="Estilo5">Fecha: <?php echo $fechahoy;?>&nbsp;</p>
  <?php
  tabla($log_situacionestudiante);
 ?>
</div>

