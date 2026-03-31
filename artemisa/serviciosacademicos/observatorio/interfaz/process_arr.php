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
$data_u = $entity->getData();

$userid = $data_u[0]['idusuario'];

$id='';
$table = $_REQUEST['entity'];

$action = isset($_REQUEST['action'])? $_REQUEST['action'] : '';
$currentdate  = date("Y-m-d H:i:s");
$_POST['fechamodificacion'] = $currentdate;
$_POST['usuariomodificacion'] = $userid;
$_POST['ip'] = $REMOTE_ADDR;
$idname= "idobs_".$table;
$id_nam = isset($_REQUEST[$idname])? $_REQUEST[$idname] : '';
$entity = new ManagerEntity($table,"observatorio");
if ($table=='competencias_nacional'){
    $entity2 = new ManagerEntity("competencias_nacional");
    $iestu=$_POST['idobs_competencias_nacional'];
    $idcom=$_POST['idobs_competencia'];
    $Tpun=$_POST['puntaje'];
    
    $i=0;
    foreach($idcom as $d_com){
        $punta=$Tpun[$i];
        if(!empty($iestu[$i])){
            $_POST['idobs_competencias_nacional']=$iestu[$i];
            $_POST['fechamodificacion'] = $currentdate;
            $_POST['usuariomodificacion'] = $userid;
            $_POST['puntaje']= $punta;
           
            $entity->fieldlist['idobs_competencias_nacional']['pkey']=$iestu[$i];
            $entity->SetEntity($_POST);
            //$entity->debug = true;        
            $entity->updateRecord();
            $result='Se modifico exitosamente';
            
        } else{
            $_POST['idobs_competencias_nacional']='';
            $_POST['coddigoperiodo']=$_POST['codigoperiodo'];
            $_POST['codigoestado']=$_POST['codigoestado'];
            $_POST['idobs_competencias']=$d_com;
            $_POST['puntaje']= $punta;
            $_POST['fechacreacion'] = $currentdate;
            $_POST['usuariocreacion'] = $userid;
            $entity->SetEntity($_POST);
            //$entity->debug = true;
            $entity->insertRecord();
            $result='Se registro exitosamente'; 
        }
        $i++;
    }
    
}
if ($table=='estudiante_competencia'){
    $entity2 = new ManagerEntity("estudiante_competencia");
    $iestu=$_POST['idobs_estudiante_competencia'];
    $idcom=$_POST['idobs_competencia'];
    $Tpun=$_POST['puntaje'];
    $Tniv=$_POST['nivel'];
    $Tquin=$_POST['quintil'];
    
    $i=0;
    foreach($idcom as $d_com){
        $punta=$Tpun[$i];
        $nive=$Tniv[$i];
        $quin=$Tquin[$i];
        if(!empty($iestu[$i])){
            $_POST['idobs_estudiante_competencia']=$iestu[$i];
            $_POST['fechamodificacion'] = $currentdate;
            $_POST['usuariomodificacion'] = $userid;
            $_POST['puntaje']= $punta;
            $_POST['nivel']= $nive;
            $_POST['quintil']=$quin;
           
            $entity->fieldlist['idobs_estudiante_competencia']['pkey']=$iestu[$i];
            $entity->SetEntity($_POST);
            //$entity->debug = true;        
            $entity->updateRecord();
            $result='Se modifico exitosamente';
            
        } else{
            $_POST['idobs_estudiante_competencia']='';
            $_POST['coddigoperiodo']=$_POST['codigoperiodo'];
            $_POST['codigoestado']=$_POST['codigoestado'];
            $_POST['codigoestudiante']=$_POST['codigoestudiante'];
            $_POST['idobs_competencias']=$d_com;
            $_POST['puntaje']= $punta;
            $_POST['nivel']= $nive;
            $_POST['quintil']=$quin;
            $_POST['fechacreacion'] = $currentdate;
            $_POST['usuariocreacion'] = $userid;
            $entity->SetEntity($_POST);
            //$entity->debug = true;
            $entity->insertRecord();
            $result='Se registro exitosamente'; 
        }
        $i++;
    }
    
}
if ($table=='estudiantes_grupos_riesgo'){
    //echo "aca";
    $destino=$_REQUEST['destino'];
    $canP=  count($destino);
    $entity2 = new ManagerEntity("estudiantes_grupos_riesgo");
    $entity2->sql_where = " idobs_grupos='".$_POST['idobs_grupos']."' ";
    //$entity2->debug = true;

    $data_g = $entity2->getData();
    foreach($data_g as $dtg){
        $_POST['id_estudiantes_grupos_riesgo']=$dtg['id_estudiantes_grupos_riesgo'];
       
        $action='inactivate';
        if($action=='inactivate'){
            $_POST['fechamodificacion'] = $currentdate;
            $_POST['usuariomodificacion'] = $userid;
            $entity->fieldlist['id_estudiantes_grupos_riesgo']['pkey']=$_POST['id_estudiantes_grupos_riesgo'];
            $entity->SetEntity($_POST);
           // $entity->debug = true;
            $entity->deleteRecord();
        }
    }
    for ($i=0; $i<$canP; $i++){
       //echo $destino[$i].'-->>';
        if(strstr($destino[$i],'-')){ 
            $pieces = explode("-", $destino[$i]);
          //  print_r($pieces);
            //echo "<-->";
            $_POST['id_estudiantes_grupos_riesgo']=$pieces[0];
            $_POST['fechamodificacion'] = $currentdate;
            $_POST['usuariomodificacion'] = $userid;
            $_POST['codigoestado']=$_POST['codigoestado'];
           // echo '<<-<<'.$pieces[0];
            $entity->fieldlist['id_estudiantes_grupos_riesgo']['pkey']=$pieces[0];
            $entity->SetEntity($_POST);
        //  $entity->debug = true;        
            $entity->updateRecord();
            $result='Se modifico exitosamente';
        }else{
            $_POST['id_estudiantes_grupos_riesgo']='';
            $_POST['idestudiantegeneral']=$destino[$i];
            $_POST['idobs_grupos']=$_POST['idobs_grupos'];
            $_POST['codigoestado']=$_POST['codigoestado'];
            $_POST['fechacreacion'] = $currentdate;
            $_POST['usuariocreacion'] = $userid;
            $entity->SetEntity($_POST);
         //  $entity->debug = true;
            $entity->insertRecord();
            $result='Se registro exitosamente';
        }
             
    }
}

if ($table=='registro_riesgo_causas'){
    
    //los riesgos escogidos
    $riesgo= explode(",", $_POST['riesgo']);
    //print_r($riesgo);
    $conP= explode(",", $_POST['conP']);
    //print_r($conP);
    $canP=  count($conP);
        for ($i=0; $i<$canP; $i++){
            //echo $conP[$i].'-->';
               if ($conP[$i]!=0){
                       $action='';
                        //echo $conP[$i].'<>'.$riesgo[$i].'-->';
                        $_POST['idobs_registro_riesgo_causas']=$conP[$i]; 
                        $_POST['idobs_causas']=$riesgo[$i];
                        $_POST['codigoestado']=$_POST['codigoestado'];
                        $entity->SetEntity($_POST);
                        $entity->fieldlist['idobs_registro_riesgo_causas']['pkey']=$_POST['idobs_registro_riesgo_causas'];
                        if ($riesgo[$i]==0){
                            $action='inactivate';
                        }
                        if($action=='inactivate'){
                            //$entity->debug = true;
                            $entity->deleteRecord();
                            $id=$id_nam;
                        }else{
                           // if($conP[$i]==39){
                            //$entity->debug = true;        
                            $entity->updateRecord();
                            //$id=$id_nam;
                            //}
                        }
                        $result='Se actualizo exitosamente';
                   }else{
                       if ($riesgo[$i]!=0){
                            $_POST['idobs_registro_riesgo_causas']='';
                            $_POST['idobs_causas']=$riesgo[$i];
                            $_POST['codigoestado']=$_POST['codigoestado'];
                            $_POST['fechacreacion'] = $currentdate;
                            $_POST['usuariocreacion'] = $userid;
                            /////////****insertar normal******/////////
                            $entity->SetEntity($_POST);
                            //$entity->debug = true;
                            $id=$entity->insertRecord();
                            $result='Se registro exitosamente';
                       }
                   }
            }
     }
   if ($table=='remision'){
       $CaR= explode(",", $_POST['remision']);
       $CaRT = count($CaR);
       $conP=explode(",", $_POST['idremision']);
        for ($i=0; $i<$CaRT; $i++){
            if (!empty($conP[$i])){
                        $action='';
                        $_POST['idobs_tiporemision']= $CaR[$i];
                        $_POST['idobs_remision']=$conP[$i]; 
                        $_POST['codigoestado']=$_POST['codigoestado'];
                        $entity->SetEntity($_POST);
                        $entity->fieldlist['idobs_remision']['pkey']=$_POST['idobs_remision'];
                        if ($CaR[$i]==0){
                            $action='inactivate';
                        }
                        if($action=='inactivate'){
                            //$entity->debug = true;
                            $entity->deleteRecord();
                            $id=$id_nam;
                        }else{
                            //$entity->debug = true;        
                            $entity->updateRecord();
                            //$id=$id_nam;
                        }
                        $result='Se actualizo exitosamente';
            }else{
                if ($CaR[$i]!=0){
                   // echo $CaR[$i].'-->';
                    $_POST['idobs_tiporemision']= $CaR[$i];
                    $_POST['idobs_remision']='';
                    $_POST['codigoestado']=$_POST['codigoestado'];
                    $_POST['fechacreacion'] = $currentdate;
                    $_POST['usuariocreacion'] = $userid;
                    /////////****insertar normal******/////////
                    $entity->SetEntity($_POST);
                    //$entity->debug = true;
                    $id=$entity->insertRecord();
                    $result='Se registro exitosamente';
               }
            }
        }
   }
   if ($table=='primera_instancia'){
    $entity = new ManagerEntity('primera_instancia_causas',"observatorio");
    //los riesgos escogidos
    $riesgo= $_POST['idobs_causas'];
    $CaR = count($_POST['idobs_causas']);
    $herr=$_POST['idobs_herramientas_deteccion'];
    //print_r($_POST['idobs_causas']);
    $conP=$_POST['idobs_primera_instancia_causas'];
    //print_r($_POST['idobs_primera_instancia_causas']);
    $canP=  count($_POST['idobs_primera_instancia_causas']);
        for ($i=0; $i<$CaR; $i++){
               if (!empty($conP[$i])){
                       $action='';
                        $tpid=$_POST['idobs_tiporiesgo_'.$riesgo[$i]][0];
                        $_POST['idobs_tiporiesgo']= $tpid;
                        $_POST['idobs_primera_instancia_causas']=$conP[$i]; 
                        //$_POST['idobs_causas']=$riesgo[$i];
                        $_POST['codigoestado']=$_POST['codigoestado'];
                        $entity->SetEntity($_POST);
                        $entity->fieldlist['idobs_primera_instancia_causas']['pkey']=$_POST['idobs_primera_instancia_causas'];
                        if ($riesgo[$i]==0){
                            $action='inactivate';
                        }
                        if($action=='inactivate'){
                            //$entity->debug = true;
                            $entity->deleteRecord();
                            $id=$id_nam;
                        }else{
                            //$entity->debug = true;        
                            $entity->updateRecord();
                            //$id=$id_nam;
                        }
                        $result='Se actualizo exitosamente';
                   }else{
                       if ($riesgo[$i]!=0){
                            $tpid=$_POST['idobs_tiporiesgo_'.$riesgo[$i]][0];
                            $_POST['idobs_tiporiesgo']= $tpid;
                            $_POST['idobs_primera_instancia_causas']='';
                            $_POST['idobs_herramientas_deteccion']=$herr[$i];
                            $_POST['idobs_causas']=$riesgo[$i];
                            $_POST['codigoestado']=$_POST['codigoestado'];
                            $_POST['fechacreacion'] = $currentdate;
                            $_POST['usuariocreacion'] = $userid;
                            /////////****insertar normal******/////////
                            $entity->SetEntity($_POST);
                            //$entity->debug = true;
                            $id=$entity->insertRecord();
                            $result='Se registro exitosamente';
                       }
                   }
            }
     }
//}
$data = array('success'=> true,'message'=> $result,'id'=>$id);
//print_r($data);
echo json_encode($data);
?>