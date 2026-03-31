<?php require_once('../../Connections/sala2.php' );
session_start();
require_once('../../funciones/clases/autenticacion/redirect.php' ); 

$codigoestudiante = $_GET['codigoestudiante'];
$periodoactual = $_SESSION['codigoperiodosesion'];
  mysql_select_db($database_sala, $sala);
 $query_log = "SELECT m.codigomateria,m.nombremateria,nombreestadodetalleprematricula,idgrupo,fechalogfechadetalleprematricula,usuario
 FROM prematricula p,logdetalleprematricula l,estadodetalleprematricula dp,materia m
 WHERE p.idprematricula = l.idprematricula
 AND dp.codigoestadodetalleprematricula = l.codigoestadodetalleprematricula
 AND l.codigomateria = m.codigomateria 
 AND p.codigoestudiante = '$codigoestudiante'
 AND p.codigoperiodo = '$periodoactual'
 order by 5 desc";
//echo $query_log;
 $log = mysql_query($query_log, $sala) or die(mysql_error());
 $row_log = mysql_fetch_assoc($log);
 $totalRows_log = mysql_num_rows($log);
 if (!$row_log)
  {
    echo '<script language="JavaScript">alert("No se produjo ningun Resultado"); history.go(-1);</script>';
  }
?>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo2 {
	font-size: x-small;
	font-weight: bold;
}
.Estilo4 {font-size: xx-small}
-->
</style>


<form action="" method="post" name="f1" class="Estilo1">
<p align="center"><strong>LOG PREMATRICULA </strong></p>
<p align="center">&nbsp;</p>
<table width="90%" border="1" align="center" bordercolor="#003333">
  <tr  bgcolor="#C5D5D6">
    <td><div align="center" class="Estilo2">Código Materia</div></td>
    <td><div align="center" class="Estilo2">Nombre Materia</div></td>
    <td><div align="center" class="Estilo2">Estado Materia</div></td>
	<td><div align="center" class="Estilo2">Grupo</div></td>
	<td><div align="center" class="Estilo2">Fecha</div></td>
	<td><div align="center" class="Estilo2">Usuario</div></td>
  </tr>
<?php 
 do {
?> 
  <tr>
    <td><span class="Estilo4"><?php echo $row_log['codigomateria']; ?></span></td>
    <td><div align="center" class="Estilo4"><?php echo $row_log['nombremateria']; ?></div></td>
    <td><div align="center" class="Estilo4"><?php echo $row_log['nombreestadodetalleprematricula']; ?></div></td>
	<td><div align="center" class="Estilo4"><?php echo $row_log['idgrupo']; ?></div></td>
	<td><div align="center" class="Estilo4"><?php echo $row_log['fechalogfechadetalleprematricula']; ?></div></td>
	<td><div align="center" class="Estilo4"><?php echo $row_log['usuario']; ?></div></td>
  </tr> 
<?php 
 }while($row_log = mysql_fetch_assoc($log));
?> 
</table>
<br>
<div align="center"><span class="Estilo24">
<input name="Regresar" type="button" value="Regresar" onClick="history.go(-1)">
</span></div>
</form>
