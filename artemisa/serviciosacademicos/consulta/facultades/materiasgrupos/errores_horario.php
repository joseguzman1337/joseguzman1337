<?php 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

	$error1 = "Campo requerido";


	$error2 = "La hora digitada es incorrecta";


	$error3 = "Debe digitar un valor numérico";


?>