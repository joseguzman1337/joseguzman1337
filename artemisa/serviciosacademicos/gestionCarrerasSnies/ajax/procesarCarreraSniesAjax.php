<?php
include('../../../sala/includes/adaptador.php');
include('../modelo/carreraModelo.php');
$procesoEjecucion = $_POST["ejecucionAjax"];
$codCarrera =  $_POST["selecCarrera"];
$fechaInicioCarreraSnies =  $_POST["fechaInicioCarrera"];
$fechaFinCarreraCarreraSnies =  $_POST["fechaFinCarrera"];
$codigoSnies = $_POST["codigoSnies"];
if ($procesoEjecucion=='crear'){
    $cnsDuplicidadCarreraSnies = modeloCarrera::mdlVerificaCarreraSnies($codCarrera,$codigoSnies);
    if (count($cnsDuplicidadCarreraSnies)>0){
        echo json_encode(1);
    }else{
        $insert = modeloCarrera::mdlInsertaCarreraRegistro($codigoSnies,$codCarrera,$fechaInicioCarreraSnies,$fechaFinCarreraCarreraSnies);
        if($insert)
        {
            echo json_encode(5);// 5 carrera snies registrada correctamente
        }else{
            echo json_encode(1);
        }
    }

}else if($procesoEjecucion=='modificar'){
     $contadorFila = $_POST["contadorFila"];
     $idRegistroSnies = $_POST["identificador"];
     $idCarrera =  $_POST["selecCarrera"];
     $codigoSnies = $_POST["codigoSnies"];
     $fechaFincarreraSnies = $_POST["fechaFinCarrera"];
     $cnsDuplicidadCarreraSnies = modeloCarrera::mdlVerificaCarreraSnies($idCarrera,$codigoSnies);
     if (count($cnsDuplicidadCarreraSnies)>0){
         $codCarreraBd = $cnsDuplicidadCarreraSnies['codigocarrera'];
         $codigoSniesBd =$cnsDuplicidadCarreraSnies['codigosniescarreraregistro'];
         $update = modeloCarrera::mdlUpdateCarreraRegistro($idRegistroSnies,$codigoSnies,$idCarrera,$fechaFincarreraSnies);
          if ($update == 0){
              echo json_encode(2);// si no surgio ningun cambio el update
          }else{
              echo json_encode(3);// si se realizo correctamente el proceso
          }
     }
}

?>

