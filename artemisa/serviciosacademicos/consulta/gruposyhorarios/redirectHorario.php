<?php
session_start();

$_SESSION['codigo'] = $_GET["codigoestudiante"];
header('Location: ../prematricula/matriculaautomaticahorariosseleccionados.php?programausadopor=');
?>
