<?php
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$actual_linkb = explode("/aspirantes", $actual_link);

define('TIEMPOACTIVACION', 86400); //Segundos
define('ENLACEACTIVACION', $actual_linkb[0].'/aspirantes/usuarioaspirante/registrarpasodos.php');
define('ENLACERECUPERACION', $actual_linkb[0].'/aspirantes/usuarioaspirante/recuperarclave.php');
define('ENLACEINGRESOASPIRANTE', $actual_linkb[0].'/aspirantes/admisiones/inscripcion_aspirante.php');

?>