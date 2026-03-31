<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<div align="center"><span class="Estilo2">HISTORICO DE MODIFICACIONES DE REGISTROS</span></div>

<?php 
require_once("funciones/tabla_fn.php"); 
require_once('../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
$query_log_registrograduado="SELECT lrg.*,tmrg.nombretipomodificaregistrograduado 
FROM logregistrograduado lrg, tipomodificaregistrograduado tmrg
WHERE lrg.codigotipomodificaregistrograduado=tmrg.codigotipomodificaregistrograduado 
order by lrg.idlogregistrograduado asc
";

$log_registrograduado=mysql_query($query_log_registrograduado,$sala) or die(mysql_error());
tabla($log_registrograduado);
?>

