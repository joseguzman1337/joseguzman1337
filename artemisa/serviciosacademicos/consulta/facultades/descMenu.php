<?php
header('Content-Type: text/html; charset=UTF-8');
$rutaado="../../funciones/adodb/";
require_once("../../Connections/salaado-pear.php");
$menu=ereg_replace("_"," ",$_GET['desc']);
$query="SELECT m.transaccionmenuopcion FROM menuopcion m WHERE m.nombremenuopcion='".$menu."'";
$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();
echo $row_operacion['transaccionmenuopcion'];
?>