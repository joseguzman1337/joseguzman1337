<?php
include("../templates/template.php");
$db = getBD();

$q = strtolower($_REQUEST["carrera"]);
$cat = strtolower($_REQUEST["categories"]);
$utils = new Utils_datos();

if (!$q) die();

if($cat===""){
    $data = array();
} else {
    if(isset($_REQUEST["nombreOrder"])){
        $data = $utils->getValorDynamic($db,$_REQUEST["table"],$_REQUEST["periodo"],$cat,$_REQUEST["valorPeriodo"],$_REQUEST["idCategory"],"",$_REQUEST["nombreOrder"],$q);
    } else {
        $data = $utils->getValorDynamic($db,$_REQUEST["table"],$_REQUEST["periodo"],$cat,$_REQUEST["valorPeriodo"],$_REQUEST["idCategory"],"","nombre",$q);
    }
}

// return the array as json
echo json_encode($data);
?>
