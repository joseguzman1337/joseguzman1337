<?php

require_once('../Connections/salasiq.php');
$rutaado = "../funciones/adodb/";
require_once('../Connections/salaado.php');
require_once '../class/ManagerEntity.php';

$entity2 = new ManagerEntity("carrera");
$entity2->prefix = "";
if($_REQUEST['codigomodalidad']==200){
$entity2->sql_where = " codigofacultad=".$_REQUEST['idfacultad']." and codigomodalidadacademica=200 ";
}
elseif($_REQUEST['codigomodalidad']==300){
$entity2->sql_where = " codigofacultad=".$_REQUEST['idfacultad']." and codigomodalidadacademica=300 ";
}
//$entity2->debug = true;
$data2 = $entity2->getData();
$cnd=count($data2);
//print_r($cnd);
//echo "okok";
echo '<option value=""> </option>';
 for($i=0;$i<=$cnd;$i++){
     $cod= $data2[$i]['codigocarrera'];
     $nom= $data2[$i]['nombrecarrera'];
     echo '<option value="'.$cod.'">'.$nom.'</option>';
}

?>

