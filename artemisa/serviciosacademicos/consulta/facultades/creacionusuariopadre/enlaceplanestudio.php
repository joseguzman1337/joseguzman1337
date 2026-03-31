<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    
session_start();
if(!isset ($_SESSION['MM_Username'])){

echo "No tiene permiso para acceder a esta opción";
exit();
}

$codigoestudiante=$_SESSION['codigo'];
echo "<script language='javascript'>
        window.location.href='../planestudioestudiante/planestudioestudiante.php?codigoestudiante=$codigoestudiante' ; </script>";

?>
