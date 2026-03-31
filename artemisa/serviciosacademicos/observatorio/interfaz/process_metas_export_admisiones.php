<?php
/////////////////busca la ruta del managerentity
session_start();
$ruta = "../";
while (!is_file($ruta.'ManagerEntity.php'))
{
    $ruta = $ruta."../";
}
require_once($ruta.'ManagerEntity.php');
   

/*if(!isset($_SESSION['MM_Username'])){
    $_SESSION['MM_Username'] = 'admintecnologia';
}*/

///////////trae el id del usuario //////////*
if (!empty($_SESSION['MM_Username'])){
    $entity = new ManagerEntity("usuario");
    $entity->sql_select = "idusuario";
    $entity->prefix ="";
    $entity->sql_where = " usuario='".$_SESSION['MM_Username']."' ";
    //$entity->debug = true;
    $data = $entity->getData();
    $userid = $data[0]['idusuario'];
}else{
    $userid ='';
}

$table = $_REQUEST['entity'];
$action = $_REQUEST['action'];
$currentdate  = date("Y-m-d H:i:s");

$_POST['fechamodificacion'] = $currentdate;
$_POST['usuariomodificacion'] = $userid;
$idname= "idobs_".$table;
$id_nam=$_REQUEST[$idname];


$entity = new ManagerEntity($table,"observatorio");


//$entity = new ManagerEntity($table);
foreach ($_FILES as $key) {
    if($key['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
      $nombre = $key['name'];//Obtenemos el nombre del archivo
      $temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
      $tamano= ($key['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB
      $row=1; $c=0;
      $handle = fopen($temporal, "r"); //Coloca el nombre de tu archivo .csv que contiene los datos
      while (($data1 = fgetcsv($handle, 1000, ";")) !== FALSE) {
         // print_r($data1);
         // echo "-->".$row.'<br>';      
              $_POST['codigoperiodo']=$_POST['periodo'];
              $_POST['codigomodalidadacademica']=$_POST['modalidad'];
              $_POST['codigoestado']=$_POST['estado'];
            
            $_POST['fecha_crear']=$data1[22];
            $_POST['codigocarrera']=$data1[0];
            $_POST['interesados']=$data1[2];
            $_POST['aspirantes']=$data1[3];
            $_POST['inscritos']=$data1[4];
            $_POST['meta_inscritos']=$data1[5];
            $_POST['logros']=$data1[6];
            $_POST['inscritos_totales']=$data1[7];
            $_POST['inscripcion_p1_p2']=$data1[8];
            $_POST['inscritos_no_evaluados']=$data1[9];
            $_POST['por_inscritos_no_evaluados']=$data1[10];
            $_POST['lista_espera']=$data1[11];
            $_POST['evaluados_no_adminitdos']=$data1[12];
            $_POST['admitidos_no_matriculados']=$data1[13];
            $_POST['administos_no_ingresaron']=$data1[14];
            $_POST['matriculados_nuevos_sala']=$data1[15];
            $_POST['meta_matriculados']=$data1[16];
            $_POST['logros2']=$data1[17];
            $_POST['matriculados_periodo']=$data1[18];
            $_POST['matriculados_p1_p2']=$data1[18];
            $_POST['matriculados_periodo_totales']=$data1[19];
            $_POST['matriculados_antiguos']=$data1[20];
            $_POST['matriculados_totales']=$data1[21];
              
              
              $entity->sql_where = "fecha_crear='".$_POST['fecha_crear']."' and codigomodalidadacademica= '".$_POST['modalidad']."' and codigoperiodo='".$_POST['codigoperiodo']."' and codigocarrera='".$_POST['codigocarrera']."'";
             // $entity->debug = true;
              $data_p = $entity->getData();
              $can=count($data_p);
            // print_r($data_p);
             if ($row>1){
              if ($can==0){
                 $_POST['fechacreacion'] = $currentdate;
                 $_POST['usuariocreacion'] = $userid;
                $entity->SetEntity($_POST);
                // $entity->debug = true; 
                $entity->insertRecord();//inserta
                
              }else{
                $id_m=$data_p[0]['idobs_'.$table];
                $_POST['idobs_'.$table]=$id_m;
                $entity->SetEntity($_POST);
                $entity->fieldlist[$idname]['pkey']=$_POST['idobs_'.$table];
                //$entity->debug = true;        
                $entity->updateRecord();
                
              }  
          }
          $row++; $c++;
      }
    }else{
      //echo $key['error']; //Si no se cargo mostramos el error
    }
  }
 $id=0;
$result='Se registro exitosamente';
$data = array('success'=> true,'message'=> $result,'id'=>$id);
//print_r($data);
echo json_encode($data);
?>