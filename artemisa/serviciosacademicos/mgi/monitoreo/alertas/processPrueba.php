<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once("../variables.php");
if($_POST["idTipoResponsable"]==""&&$_POST["action"]=="update"){
    $_POST["idTipoResponsable"] = 0;
}
include($rutaTemplate.'templateProcess.php');

$apiA = new API_Alertas();

// 58 = Prueba de nuevo indicador numerico (ACL EXPERIMENTADO PROVEEDOR)
$parametros["siq_indicador"]=58;
 $apiA->enviarAlertaPeriodicaConPlantilla($_REQUEST["idsiq_tipoAlerta"],$parametros);
?>
