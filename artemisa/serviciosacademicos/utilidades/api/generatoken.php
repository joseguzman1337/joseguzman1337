<?php

require_once('./funcionesValidacion.php');

$usuario=$_POST['usuario'];
$password=$_POST['password'];
@$segunda=$_POST['segunda'];
@$rol=$_POST['rol'];
@$plataforma = $_POST['plataforma'];
@$devicetoken = $_POST['devicetoken'];

$lll = autenticarUsuario($usuario, $password, $segunda, $rol, $plataforma, $devicetoken);

echo json_encode($lll);


?>
