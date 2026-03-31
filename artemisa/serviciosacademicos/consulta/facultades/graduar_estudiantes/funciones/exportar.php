<?php
session_start();
require("motor.php");
$exportar = new matriz($_SESSION['datos'],"Listado Elegibles");
$exportar->exportar_array($_SESSION['datos'],$_GET['nombre'],$_GET['formato']);
?>
