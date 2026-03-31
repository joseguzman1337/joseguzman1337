<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
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
$data = $entity->getData();
$userid = $data[0]['idusuario'];



$table = $_REQUEST['entity'];
$table1 = $_REQUEST['entity2'];
$action = $_REQUEST['action'];
$currentdate  = date("Y-m-d H:i:s");
$_POST['fechamodificacion'] = $currentdate;
$_POST['usuariomodificacion'] = $userid;
$_POST['ip'] = $REMOTE_ADDR;
$idname= "idobs_".$table;
$id_nam=$_REQUEST[$idname];
$_POST['codigoperiodo']=$_POST['codigoperiodo'];
$entity = new ManagerEntity($table,"observatorio");

/*if(!empty($id_nam)){
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
    $entity->SetEntity($_POST);
    $_POST['fechacreacion'] = $currentdate;
    $_POST['usuariocreacion'] = $userid;
    $entity->SetEntity($_POST);
    //$entity->debug = true;
    $id=$entity->insertRecord();
    $result='Se registro exitosamente';
}
 if (!empty($_REQUEST['causa'])){
        $entity2 = new ManagerEntity('primera_instancia_causas',"observatorio");
        $doc=explode(",",$_REQUEST['causa']);
        $herr=explode(",",$_REQUEST['herr']);
        $tcausa=explode(",",$_REQUEST['tcausa']);
        $ries=explode(",",$_REQUEST['ries']);
        $i=0;
        foreach($doc as $ca){
            $ca = str_replace("'", "", $ca);
            $herr[$i] = str_replace("'", "", $herr[$i]);
            $tcausa[$i] = str_replace("'", "", $tcausa[$i]);
            $ries[$i] = str_replace("'", "", $ries[$i]);
            $_POST['idobs_causas']=$ca;
            $_POST['idobs_primera_instancia']=$id;
            $_POST['codigoperiodo']=$_POST['codigoperiodo'];
            $tc=0;
            for ($j=0;$j<count($tcausa);$j++){
                if ($tc==$tcausa[$j]){
                  $_POST['idobs_herramientas_deteccion']=$herr[$i];
                  $_POST['idobs_tiporiesgo']=$ries[$i];
                }else{
                   $_POST['idobs_herramientas_deteccion']=$herr[$i];
                   $_POST['idobs_tiporiesgo']=$ries[$i];
                }
                $tc=$tcausa[$j];
            }
            $entity2->SetEntity($_POST);
            //$entity2->debug = true;
            $entity2->insertRecord();
            $result='Se registro exitosamente';
            $i++;
        }
        
    }
*/
$data = array('success'=> true,'message'=> $result,'id'=>$id);
//print_r($data);
echo json_encode($data);
?>