<?php
include("../templates/template.php");
$db = getBD();

$q = strtolower($_REQUEST["carrera"]);
$cat = strtolower($_REQUEST["categories"]);
$utils = new Utils_datos();

if (!$q) die();

if($cat===""){
    $data = $utils->getDataForm($db,$_REQUEST["table"],$_REQUEST["periodo"]);
} else {
    if(isset($_REQUEST["nombreOrder"])){
        $data = $utils->getDataFormCategoryDynamic($db,$_REQUEST["table"],$_REQUEST["periodo"],$cat,$_REQUEST["nombreOrder"],true,$q);
    } else {
        $data = $utils->getDataFormCategoryDynamic($db,$_REQUEST["table"],$_REQUEST["periodo"],$cat,"nombre",true,$q);
    }
}

// return the array as json
echo json_encode($data);
?>
