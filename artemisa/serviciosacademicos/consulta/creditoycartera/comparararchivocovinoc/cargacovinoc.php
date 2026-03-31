<?php 
session_start();
require_once('../../../Connections/sala2.php'); 
require_once('../../../funciones/funcionip.php' );
$ip = "SIN DEFINIR";
$ip = tomarip();
$hoy = date("Y-m-d H:i:s");
mysql_select_db($database_sala, $sala);
$superuser = $_SESSION['MM_Username'];
$sql = "UPDATE zdatoscovinoc
set procesado = '100',
ip = '$ip',
usuario = '$superuser',
fechaproceso = '$hoy '
where procesado = ''";	
$result = mysql_query($sql,$sala) or die("$sql");


$sql = "LOAD DATA LOCAL INFILE '/var/tmp/covinoc.txt' INTO TABLE zdatoscovinoc";	
$result = mysql_query($sql,$sala) or die("$sql");

$sql = "DELETE FROM zdatoscovinoc 
WHERE ( numerodocumento = '' or  nombreestudiante = '')";	
$result = mysql_query($sql,$sala) or die("$sql");


echo "<script language='javascript'>
window.close();
</script>";
?>
