<style type="text/css">
<!--
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo6 {font-size: 9px}
-->
</style>
<?php
require_once('../../../Connections/sala2.php');
require_once('../../mantenimiento/funciones/tabla_fn.php');
mysql_select_db($database_sala, $sala);
/*
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se agrega la siguiente validacion para que por el metodo GET permita mostrar informacion del log tipo estudiante. 
 * @since Noviembre 6, 2018
 */ 
if(!isset($codigoestudiante)){
	$codigoestudiante = $_GET["codigoestudiante"];
}
$query_log_situacionestudiante="select concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre,e.codigoestudiante,nombretipoestudiante as tipo_estudiante,hte.codigoperiodo,usuario,fechahistoricotipoestudiante as fecha,fechainiciohistoricotipoestudiante as fechainicio, fechafinalhistoricotipoestudiante as fechafinal,iphistoricotipoestudiante as ip from historicotipoestudiante hte, tipoestudiante te, estudiante e,estudiantegeneral eg where 
hte.codigotipoestudiante=te.codigotipoestudiante and
hte.codigoestudiante='$codigoestudiante' and
e.codigoestudiante=hte.codigoestudiante and
e.idestudiantegeneral=eg.idestudiantegeneral
";
//echo $query_log_situacionestudiante;
$log_situacionestudiante=mysql_query($query_log_situacionestudiante,$sala);


$fechahoy=date("Y-m-d H:i:s");

?>
<div align="center">
  <p><img src="../../../../imagenes/logoweb2.jpg" width="200" height="62" onClick="print()"></p>
  <p class="Estilo2">LOG TIPO ESTUDIANTE </p>
  <p align="right" class="Estilo6">Fecha: <?php echo $fechahoy;?>&nbsp;</p>
  <?php
  tabla($log_situacionestudiante);
 ?>
</div>
