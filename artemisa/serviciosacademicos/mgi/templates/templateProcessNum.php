<?php

require_once("templateNumericos.php");
$db = writeHeaderSearchs();

$utils = new Utils_Numericos();

$action = $_POST["action"];

$val1 = $_POST["valor1"];
$val2 = $_POST["valor2"];
if ($val1 && $val2){
//if ($action = "save1" ||$action = "update1"){
      $porcentaje = 0.0;
      $resultado = $val1 / $val2;
      $porcentaje = ($resultado * 100 ); 
//var_dump($val1);
//var_dump($val2);
//var_dump($resultado);
//var_dump($porcentaje);
      $result = $utils->processData($action, $_POST["entity"],$resultado,$porcentaje);
       //die();
}else{
  $result = $utils->processData($action, $_POST["entity"]);
}
?>
