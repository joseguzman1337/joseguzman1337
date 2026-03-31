<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../class/ManagerEntity.php';
if(!isset($_SESSION['MM_Username']))$_SESSION['MM_Username'] = 'admintecnologia';
$entity = new ManagerEntity("usuario");
$entity->sql_select = "idusuario";
$entity->prefix ="";
$entity->sql_where = " usuario='".$_SESSION['MM_Username']."' ";
$data = $entity->getData();
$userid = $data[0]['idusuario'];
$entity = new ManagerEntity("corte");
$entity->sql_select = "idsiq_corte";
$entity->sql_where = " idsiq_grupoconvenio='".$_POST['idsiq_grupoconvenio']."' and codigoestado = 100;";
$data = $entity->getData();
$table = $_REQUEST['entity'];
$entity = new ManagerEntity($table);
$currentdate  = date("Y-m-d H:i:s");
$idname= "idsiq_".$table;
$_POST['fechamodificacion'] = $currentdate;
$_POST['usuariomodificacion'] = $userid;
if(is_array($data) and count($data)>0){
    foreach($data as $row){
        if($_POST["nota".$row[idsiq_corte]]){
            foreach ($_POST["nota".$row[idsiq_corte]] as $key => $value){                
                $entity->SetEntity($_POST);
                $entity->sql_where = " idsiq_corte = '".$row[idsiq_corte]."' and codigoestado = 100 and codigoestudiante = '".$key."'";
                $dataCal = $entity->getData();
                $_POST['idsiq_corte']=$row["idsiq_corte"];
                $_POST['codigoestudiante']=$key;
                $_POST['nota']=$_POST["nota".$row[idsiq_corte]][$key];
                $_POST['numerofallaspractica']=$_POST["numerofallaspractica".$row[idsiq_corte]][$key];
                $_POST['numerofallasteorica']=$_POST["numerofallasteorica".$row[idsiq_corte]][$key];
                $_POST['codigoestado']=100;               
                if(is_array($dataCal) and count($dataCal)>0){
                    $_POST['idsiq_nota'] = $dataCal[0]['idsiq_nota'];
                    $_POST['fechacreacion'] = $dataCal[0]['fechacreacion'];
                    $_POST['usuariocreacion'] = $dataCal[0]['usuariocreacion'];
                    $entity->SetEntity($_POST);
                    $entity->fieldlist[idsiq_corte]['pkey']=$row[idsiq_corte];
                    $entity->fieldlist[codigoestudiante]['pkey']=$key;
                    $entity->fieldlist[codigoestado]['pkey']=100;
                    $entity->updateRecord();
                }else{
                    $_POST['fechacreacion'] = $currentdate;
                    $_POST['usuariocreacion'] = $userid;
                    $entity->SetEntity($_POST);
                    $entity->insertRecord();
                }
            }
        }
    }
}
?>
