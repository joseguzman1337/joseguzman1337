<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include('../../../sala/includes/adaptador.php');
include('../modelo/carreraModelo.php');

$codCarrera=$_POST['codCarrera'];
if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    $programasUbosque = modeloCarrera::mdlProgramasUB();
    $select = "";
    foreach ($programasUbosque as $key => $value) {
        $idCarreraBd = $value["codigocarrera"];
        $nombreCarrera = $value["nombrecarrera"];
        if($codCarrera != $idCarreraBd){
            $select .= '<option value="'.$idCarreraBd.'">'.$nombreCarrera.'-'.$idCarreraBd.'</option>';
        }else{
                $select .= '<option value="'.$idCarreraBd.'" selected>'.$nombreCarrera.'</option>';
        }
    }
    echo $select;
}
?>
