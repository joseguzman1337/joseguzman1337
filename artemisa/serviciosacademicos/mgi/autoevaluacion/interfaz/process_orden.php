<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

/////////////////busca la ruta del managerentity
$ruta = "../";
while (!is_file($ruta.'ManagerEntity.php'))
{
    $ruta = $ruta."../";
}
require_once($ruta.'ManagerEntity.php');
$ruta = "../";
while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
    }
    require_once($ruta.'Connections/sala2.php');
    $rutaado = $ruta."funciones/adodb/";
require_once($ruta.'Connections/salaado.php');

/*if(!isset($_SESSION['MM_Username'])){
    $_SESSION['MM_Username'] = 'admintecnologia';
}*/


///////////trae el id del usuario //////////*
$entity = new ManagerEntity("usuario");
$entity->sql_select = "idusuario";
$entity->prefix ="";
$entity->sql_where = " usuario='".$_SESSION['MM_Username']."' ";
//$entity->debug = true;
$data = $entity->getData();
$userid = $data[0]['idusuario'];

$table = $_REQUEST['entity'];
$action = $_REQUEST['action'];
$currentdate  = date("Y-m-d H:i:s");
$_POST['fechamodificacion'] = $currentdate;
$_POST['usuariomodificacion'] = $userid;
$idname= "idsiq_".$table;
$id_nam=$_REQUEST[$idname];

$entity = new ManagerEntity($table,"autoevaluacion");
$Tca=count($_REQUEST['preg']);
$idpgre=$_REQUEST['preg'];
$idsecc=$_REQUEST['secc'];
$idAin=$_REQUEST['Ains'];
$orden=$_REQUEST['orden'];

//print_r($orden);

for($i=0; $i<$Tca; $i++){
    $id_preg=$idpgre[$i];
    $id_secc=$idsecc[$i];
    $_POST['idsiq_Ainstrumento']=$idAin[$i];
    $_POST['orden']=$orden[$i];
    $entity->SetEntity($_POST);
    $entity->fieldlist['idsiq_Ainstrumento']['pkey']=$_POST['idsiq_Ainstrumento'];  
    //$entity->debug = true;        
    $entity->updateRecord();
    
}
$result='Se registro exitosamente';
$data = array('success'=> true,'message'=> $result,'id'=>$id);
//print_r($data);
echo json_encode($data);
?>