<?php
session_start();
//print_r($_SESSION['exportar']);
require_once("funciones/imprimir_arrays_bidimensionales.php");
require_once("funciones/exportar_array.php");
$exportar = new exportar($_SESSION['exportar'],"xls","prueba.xls");
$exportar->listar_array();
?>