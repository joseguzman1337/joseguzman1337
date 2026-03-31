<?php
session_start();
include_once('../../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
