<?php
session_start();
/////////////////busca la ruta del managerentity
$ruta = '';
while (!is_file($ruta.'ManagerEntity.php')){
    $ruta = $ruta."../";
}
require_once($ruta.'ManagerEntity.php');

///////////trae el id del usuario //////////*
$entity = new ManagerEntity("usuario");
$entity->sql_select = "idusuario";
$entity->prefix ="";
$entity->sql_where = " usuario='".$_SESSION['MM_Username']."' ";
//$entity->debug = true;
$data_u = $entity->getData();

$userid = $data_u[0]['idusuario'];


$table = $_REQUEST['entity'];
$action = $_REQUEST['action'];
$currentdate  = date("Y-m-d H:i:s");
$_POST['fechamodificacion'] = $currentdate;
$_POST['usuariomodificacion'] = $userid;
$_POST['ip'] = $REMOTE_ADDR;
$idname= "idobs_".$table;
$id_nam=$_REQUEST[$idname];

$entity = new ManagerEntity($table,"observatorio");
if($action=='inactivate' and !empty($_REQUEST['id_del'])){
 
    $_POST[$idname]=$_REQUEST['id_del'];
    $_REQUEST[$idname]=$_REQUEST['id_del'];
    $entity->SetEntity($_POST);
    $entity->fieldlist[$idname]['pkey']=$_REQUEST[$idname];
    //$entity->debug = true;
    $entity->deleteRecord();
    $id=$id_nam;
}else{
    if(!empty($id_nam)){
            ////*********para eliminar o modificar normalmente*******/////////
            $entity->SetEntity($_POST);
            $entity->fieldlist[$idname]['pkey']=$_REQUEST[$idname];
            if($action=='inactivate'){
              // $entity->debug = true;
                $entity->deleteRecord();
                $id=$id_nam;
            }else{
               // $entity->debug = true;        
                $entity->updateRecord();
                $id=$id_nam;
            }
        $result='Se modifico exitosamente';
    }else{
        $d=$entity->SetEntity($_POST);
        $_POST['fechacreacion'] = $currentdate;
        $_POST['usuariocreacion'] = $userid;
        /////////****insertar normal******/////////
        $entity->SetEntity($_POST);
        $entity->debug = true;
        $id=$entity->insertRecord();
        $result='Se registro exitosamente';
    }
}
$data = array('success'=> true,'message'=> $result,'id'=>$id);
//print_r($data);
echo json_encode($data);
?>