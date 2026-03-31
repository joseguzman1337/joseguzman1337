<?php
session_start();
ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');
require_once("../../../funciones/clases/motor/motor.php");
$exportar = new matriz($_SESSION[$_GET['arreglo']]);
$exportar->exportar_array($_SESSION[$_GET['arreglo']],$_GET['nombre'],$_GET['formato']);
echo '<script language="javascript">window.close()</script>';
?>
