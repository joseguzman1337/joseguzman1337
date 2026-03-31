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

   //////////inserta los resgistros
   // print_r($_POST['codigocarrera1']);
   // if (!empty($_POST['carrera'])){//es el arreglo de las preguntas
    $entity = new ManagerEntity("admisiones_estadisticas");
    $entity->sql_where= "fecha_crear='".date('Y-m-d')."'";
    //$entity->debug = true;
    $dataR = $entity->getData();
    if(count($dataR)==0){
    
        $i=0;
        $_POST['idobs_admisiones_estadisticas']=$_POST['idobs_admisiones_estadisticas1'];
        $_POST['codigoperiodo']=$_POST['codigoperiodo'];
        $_POST['codigoestado']=$_POST['codigoestado'];
        $_POST['fecha_crear']=$_POST['fecha']; 
        $_POST['codigomodalidadacademica']=$_POST['codigomodalidadacademica'];
        //print_r($_POST['carrera'] );
        foreach($_POST['carrera'] as $cp=>$vp){ //recorre el arreglo
            $_POST['codigocarrera']=$_POST['carrera'][$i];
            $_POST['interesados']=$_POST['interesados1'][$i];
            $_POST['aspirantes']=$_POST['aspirante1'][$i];
            $_POST['inscritos']=$_POST['inscritos1'][$i];
            $_POST['meta_inscritos']=$_POST['metas'][$i];
            $_POST['logros']=$_POST['log_por'][$i];
            $_POST['inscritos_totales']=$_POST['instot'][$i];
            $_POST['inscripcion_p1_p2']=$_POST['inspor'][$i];
            $_POST['inscritos_no_evaluados']=$_POST['insnoeva'][$i];
            $_POST['por_inscritos_no_evaluados']=$_POST['ins_noeva'][$i];
            $_POST['lista_espera']=$_POST['litaespera'][$i];
            $_POST['evaluados_no_adminitdos']=$_POST['evanoadmin'][$i];
            $_POST['admitidos_no_matriculados']=$_POST['adminnomatr'][$i];
            $_POST['administos_no_ingresaron']=$_POST['adminnoing'][$i];
            $_POST['matriculados_nuevos_sala']=$_POST['matri_nuevos'][$i];
            $_POST['meta_matriculados']=$_POST['metas_matri'][$i];
            $_POST['logros2']=$_POST['log_por_mat'][$i];
            $_POST['matriculados_periodo']=$_POST['matvs_por'][$i];
            $_POST['matriculados_p1_p2']=$_POST['matvs_por'][$i];
            $_POST['matriculados_periodo_totales']=$_POST['total_matri_ac'][$i];
            $_POST['matriculados_antiguos']=$_POST['matri_anti'][$i];
            $_POST['matriculados_totales']=$_POST['total_matri'][$i];
            
            if (empty($_POST['idobs_admisiones_estadisticas1'][$i])){
                 $_POST['fechacreacion'] = $currentdate;
                 $_POST['usuariocreacion'] = $userid;
            //      if (!empty($_POST['meta1'][$i])){
                    $entity->SetEntity($_POST);
                    //$entity->debug = true;
                    $entity->insertRecord();//inserta
              //    }
            }else{
              
                $entity->SetEntity($_POST);
                $entity->fieldlist[$idname]['pkey']=$_POST['idobs_admisiones_estadisticas'];
              //  $entity->debug = true;        
               // $entity->updateRecord();
            }
            $i++;
       // }
    }
   

$result='Se registro exitosamente';
    }else{
        $result='Ya registro el dia de hoy';
    }
$data = array('success'=> true,'message'=> $result,'id'=>$id);
//print_r($data);
echo json_encode($data);
?>