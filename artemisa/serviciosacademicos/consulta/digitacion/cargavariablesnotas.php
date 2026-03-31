<?php require_once('../../Connections/sala2.php');
session_start();
require_once('../../funciones/clases/autenticacion/redirect.php' ); 

$_SESSION['periodos'] = $_GET['nombreperiodo'];
$_SESSION['grupos'] = $_GET['grupo'];
$_SESSION['materias'] =  $_GET['materia'];
$_SESSION['facultades'] = $_GET['facultad'];
echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=cursossala.php'>";
?>