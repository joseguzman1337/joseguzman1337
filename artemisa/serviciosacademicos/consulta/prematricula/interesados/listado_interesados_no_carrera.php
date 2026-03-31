<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
$query="
SELECT p.* FROM preinscripcion p
WHERE p.idpreinscripcion NOT IN (SELECT p.idpreinscripcion FROM preinscripcion CARRERA)
";
?>