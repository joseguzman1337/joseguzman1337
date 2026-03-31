<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//header( 'Content-type: text/html; charset=ISO-8859-1' );

require_once('../Connections/salasiq.php');
$rutaado = "../funciones/adodb/";
require_once('../Connections/salaado.php');

require_once '../class/ManagerEntity.php';

if(!isset($_SESSION['MM_Username'])){
    $_SESSION['MM_Username'] = 'admintecnologia';
}

$entity = new ManagerEntity("usuario");
$entity->sql_select = "idusuario";
$entity->prefix ="";
$entity->sql_where = " usuario='".$_SESSION['MM_Username']."' ";
//$entity->debug = true;
$data = $entity->getData();
$userid = $data[0]['idusuario'];
$table = $_REQUEST['entity'];
$entity = new ManagerEntity($table);
$currentdate  = date("Y-m-d H:i:s");
$record = array();
if($_REQUEST['grupo']){
    //print_r($_REQUEST['idsperfilv_p']);
    $idinsert = implode( ', ', $_REQUEST['idsperfilv_p'] );
    $entityc = new ManagerEntity("estudiantegrupo");
    $entityc->sql_select = "idsiq_estudiantegrupo";
    $entityc->sql_where = " idestudiantegeneral NOT IN ($idinsert) and idsiq_grupoconvenio = ".$_REQUEST['idsiq_grupoconvenio']."  ";
   // $entityc->debug = true;
    $datac = $entityc->getData();
    
    foreach ($datac as $id_estu){  
       // print $id_estu['idsiq_estudiantegrupo'].'   ';
        $re=$db->execute("delete from siq_estudiantegrupo where idsiq_estudiantegrupo='".$id_estu['idsiq_estudiantegrupo']."' ");
      // echo "delete from siq_estudiantegrupo where idsiq_estudiantegrupo='".$id_estu['idsiq_estudiantegrupo']."' ";
    }
    foreach ($_REQUEST['idsperfilv_p'] as $id){   
        $entity->sql_select = "idestudiantegeneral";        
        $entity->sql_where = " idestudiantegeneral='".$id."' and idsiq_grupoconvenio = ".$_REQUEST['idsiq_grupoconvenio']."";
        //$entity->debug = true;
        $data = $entity->getData();
        $record["codigocarrera"]=$_REQUEST['codigocarrera'];
        $record["codigomodalidadacademica"]=$_REQUEST['codigomodalidadacademica'];
        $record["idgrupo"]=$_REQUEST['idgrupo'];
        $record["codigoestado"] = 100;    
        $record["idestudiantegeneral"] = $id;
        $record["codigoestudiante"] = $id;
        $record["idsiq_grupoconvenio"]=$_REQUEST['idsiq_grupoconvenio'];
        $record["fechamodificacion"] = $currentdate;
        $record["usuariomodificacion"] = $userid;
        $record["fechacreacion"] = $currentdate;
        $record["usuariocreacion"] = $userid;
       // print_r($record);
        if($data[0]['idestudiantegeneral']!=$id){
            $entity->SetEntity($record);
            $entity->insertRecord();
        }
    }
}
?>