<?php

require_once('../Connections/salasiq.php');
$rutaado = "../funciones/adodb/";
require_once('../Connections/salaado.php');
require_once '../class/ManagerEntity.php';

$entity2 = new ManagerEntity("carrera");
$entity2->prefix = "";
$entity2->sql_where = " codigomodalidadacademica=".$_REQUEST['id']." ";
//$entity2->debug = true;
$data2 = $entity2->getData();
$cnd=count($data2);
echo $cnd.'<br>';
 for($i=0;$i<=$cnd;$i++){
     $cod= $data2[$i]['codigocarrera'];
     $nom= $data2[$i]['nombrecarrera'];
     echo '<option value="'.$cod.'">'.$nom.'</option>';
}

?>

