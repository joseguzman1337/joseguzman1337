<?php
session_start();
require_once(realpath(dirname(__FILE__) . "/../../sala/includes/adaptador.php"));

require_once('controlador/principalControlador.php');
require_once('controlador/carreraControlador.php');
include('modelo/carreraModelo.php');
controladorPrincipal::ctrPrincipal();