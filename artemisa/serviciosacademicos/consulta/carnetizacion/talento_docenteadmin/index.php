<?php
require_once(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));
require_once("controlador/controlPlantilla.php");
require_once("controlador/controlAdministrativoDocente.php");
require_once("controlador/controlConsultaUsuario.php");
require_once("modelo/generalModelo.php");
$controlPrincipal = controlPlantilla::ctrPrincipal();