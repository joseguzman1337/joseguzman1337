<?php
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
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

$action = $_REQUEST['action'];
$currentdate  = date("Y-m-d H:i:s");
$_POST['fechamodificacion'] = $currentdate;
$_POST['usuariomodificacion'] = $userid;
$_POST['ip'] = $_SERVER['REMOTE_ADDR'];
$idname= "idobs_".$table;
$id_nam = isset($_REQUEST[$idname])? $_REQUEST[$idname] : '';


//$entity = new ManagerEntity($table,"observatorio");

$ca_ce=0; $ca=0;
$_POST['codigoperiodo'] = isset($_POST['codigoperiodo'])? $_POST['codigoperiodo'] : '';
$_POST['codigoestudiante'] = isset($_POST['codigoestudiante'])? $_POST['codigoestudiante'] : '';
$_POST['codigoestado'] = isset($_POST['codigoestado'])? $_POST['codigoestado'] : '';
$_POST['idobs_admitidos_cab_entrevista'] = isset($_POST['idobs_admitidos_cab_entrevista'])? $_POST['idobs_admitidos_cab_entrevista'] : '';
/******************* modificaion 22/09/2014 Ing.Milton Chacon*************************/
global $userid,$db;
		
include_once("../../ReportesAuditoria/templates/mainjson.php");
//////obtener idestudiantil////
   
    $query_idestu = "SELECT idestudiantegeneral FROM estudiante WHERE codigoestudiante= ".$_POST['codigoestudiante']."";
    
    //echo $query_idestu;
    $idestudiantegeneral = $db->Execute($query_idestu);
    $data_idestu=$idestudiantegeneral->GetArray();
    $data_idestu=$data_idestu[0]["idestudiantegeneral"];
    //echo $data_idestu;
    
    
    function verRespuestaDetallePersonal($idEstudiante,$idPregunta){
        global $ruta, $db;
            $query_buscarespuesta = "SELECT EstudianteDetallesPersonalesId 
                                    FROM EstudianteDetallesPersonales 
                                    WHERE idestudiantegeneral='".$idEstudiante."' AND idobs_admitidos_contexto='".$idPregunta."'";
            //echo $query_buscarespuesta."<br>";
            $respuestaestu = $db->Execute($query_buscarespuesta);
            $totalRows = $respuestaestu->RecordCount();
            
            if($totalRows==0){
                return "null";
            }else{
                $rowrespuesta=$respuestaestu->FetchRow();
                return $rowrespuesta["EstudianteDetallesPersonalesId"];
            }
             
            
        
    }
    
   /////fin obteneridstudiantil


$idname= "idobs_".$table;

$entity = new ManagerEntity($table,"observatorio");

if ($table=='admitidos_entrevista'){
     if (!empty($_REQUEST['idconP'])){
         $id_nam= isset($_REQUEST['idobs_admitidos_campos_evaluar'])? $_REQUEST['idobs_admitidos_campos_evaluar'] : '';
        
         $idCP=explode(",",$_REQUEST['idconP']);
         $riesgo=explode(",",$_REQUEST['ries']);
         $decr=explode("|",$_REQUEST['desc']);
         $idadmP=explode(",",$_REQUEST['idadmP']);
         $i=0;
        foreach($idCP as $ca){
            $ca = str_replace("'", "", $ca);
            $ca = str_replace("\\", "", $ca);
            $riesg[$i] = str_replace("'", "", $riesgo[$i]);
            $decr[$i] = str_replace("'", "", $decr[$i]);
            $idadmP[$i] = str_replace("'", "", $idadmP[$i]);
            $idadmP[$i] = str_replace("\\", "", $idadmP[$i]);
            //echo $decr[$i].'-->';
            $_POST['idobs_admitidos_campos_evaluar']=$ca;
            $_POST['idobs_admitidos_cab_entrevista']=$_POST['idobs_admitidos_cab_entrevista'];
            $_POST['puntaje']=$riesg[$i];
            $_POST['descripcion']=$decr[$i];
            $_POST['codigoestado']=$_POST['codigoestado'];
            $_POST['idobs_admitidos_entrevista']=$idadmP[$i];
            $id_nam=$idadmP[$i];
            if(!empty($idadmP[$i])){
                   $entity->SetEntity($_POST);
                   if($action=='inactivate'){
                       $entity->fieldlist['idobs_admitidos_entrevista']['pkey']=$_POST['idobs_admitidos_entrevista'];
                     //  $entity->debug = true;
                       $entity->deleteRecord();
                       $id=$id_nam;
                   }else{
                       $entity->fieldlist['idobs_admitidos_entrevista']['pkey']=$_POST['idobs_admitidos_entrevista'];
                       //$entity->debug = true;        
                       $entity->updateRecord();
                       $id=$id_nam;
                   }
               $result='Se modifico exitosamente';
            }else{

                $_POST['fechacreacion'] = $currentdate;
                $_POST['usuariocreacion'] = $userid;
                $entity->SetEntity($_POST);
                //$entity->debug = true;
                $id=$entity->insertRecord();
                $result='Se registro exitosamente';
            }
            $i++;
        }
        
        $entity1 = new ManagerEntity('admitidos_cab_entrevista',"observatorio");
        $_POST['puntaje']=$_POST['puntajeT'];
        $_POST['descripcion_general']=$_POST['descripcion_general'];
         
         $entity1->fieldlist['idobs_admitidos_cab_entrevista']['pkey']=$_POST['idobs_admitidos_cab_entrevista'];
         $entity1->SetEntity($_POST);
         //$entity1->debug = true;        
         $entity1->updateRecord();
     }
     
     
}
if ($table=='admitidos_entrevista_conte'){
    if (!empty($_REQUEST['idconP'])){
         $id_nam = isset($_REQUEST['idobs_admitidos_campos_evaluar'])? $_REQUEST['idobs_admitidos_campos_evaluar'] : '';

         $idCP=explode(",",$_REQUEST['idconP']);
         $idC=explode(",",$_REQUEST['idcon']);
         $riesgo=explode(",",$_REQUEST['ries']);
         $decr=explode("|",$_REQUEST['desc']);
         $idCP=explode(",",$_REQUEST['idconP']);
         $idadmP=explode(",",$_REQUEST['idadmP']);
         $i=0;
         $_POST['idobs_admitidos_contextoP']=$ca;
         $_POST['idobs_admitidos_contexto']=$idC[$i];
         $_POST['idobs_tiporiesgo']=$riesgo[$i];
         $_POST['descripcion']=$decr[$i];
         $_POST['codigoestado']=$_POST['codigoestado'];
         $_POST['idobs_admitidos_cab_entrevista']=$_POST['idobs_admitidos_cab_entrevista'];
            
         $i=0;
        foreach($idCP as $ca){
            $ca = str_replace("'", "", $ca);
            $ca = str_replace("\\", "", $ca);
            $idC[$i] = str_replace("'", "", $idC[$i]);
            $idC[$i] = str_replace("\\", "", $idC[$i]);            
            $riesg[$i] = str_replace("'", "", $riesgo[$i]);
            $decr[$i] = str_replace("'", "", $decr[$i]);
            $idadmP[$i] = str_replace("'", "", $idadmP[$i]);
            $idadmP[$i] = str_replace("\\", "", $idadmP[$i]);
            $_POST['idobs_admitidos_contextoP']=$ca;
            $_POST['idobs_admitidos_contexto']=$idC[$i];
            $_POST['idobs_tiporiesgo']=$riesg[$i];
            $_POST['descripcion']=$decr[$i];
            $_POST['codigoestado']=$_POST['codigoestado'];
            $_POST['idobs_admitidos_cab_entrevista']=$_POST['idobs_admitidos_cab_entrevista'];
            $_POST['idobs_admitidos_entrevista_conte']=$idadmP[$i];
            $id_nam=$idadmP[$i];
            //echo $decr[$i].'-->';
            ///////MODIFICADO MILTON CHACON 22/09/2014/////////////////
            
            if (isset($_POST["idobs_admitidos_contexto"]) AND $_POST["idobs_admitidos_contexto"]!==''){
                        if (!filter_var($_POST["idobs_admitidos_contexto"], FILTER_VALIDATE_INT)){
                            echo '<script language="JavaScript">alert("-> '.$POST["idobs_admitidos_contexto"].'<- no es un valor valido para guardar")</script>';
                            
                        }else{
                            //echo "-".$data_idestu.":".$_POST['idobs_admitidos_contextoP'].":".$_POST["idobs_admitidos_contexto"];
                            $idRespuesta=verRespuestaDetallePersonal($data_idestu,$_POST['idobs_admitidos_contextoP']);
                                
                                if($idRespuesta=="null"){
                                    $query_detapersonales = "INSERT INTO EstudianteDetallesPersonales(idestudiantegeneral,idobs_admitidos_contexto,IdItemRespuesta,FechaCreacion,UsuarioCreacion,CodigoEstado) 
                                                            VALUES('".$data_idestu."','".$ca."','".$_POST["idobs_admitidos_contexto"]."',NOW(),'".$userid."','100')";
                                    
                                   
                                    
                                }else{
                                    $query_detapersonales="UPDATE EstudianteDetallesPersonales
					SET IdItemRespuesta='".$_POST["idobs_admitidos_contexto"]."',
                        FechaModificacion=NOW(),
                        UsuarioModificacion='".$userid."'
                    WHERE idestudiantegeneral = '".$data_idestu."'
					and idobs_admitidos_contexto = '".$ca."'
					and codigoestado like '1%'";
                                    
                                   
                                    //$detapersonales = $db->Execute($query_detapersonales); 
                                }  
                                 $detapersonales = $db->Execute($query_detapersonales); 
                                 //echo "$query_detapersonales<br>";
                                
                            
                        }
            }
            
            ///////////////FIN MODIFICACION/////////////////////////////////
            if(!empty($idadmP[$i])){
                   $entity->SetEntity($_POST);
                   if($action=='inactivate'){
                       $entity->fieldlist['idobs_admitidos_entrevista_conte']['pkey']=$_POST['idobs_admitidos_entrevista_conte'];
                       //$entity->debug = true;
                       $entity->deleteRecord();
                       $id=$id_nam;
                   }else{
                       $entity->fieldlist['idobs_admitidos_entrevista_conte']['pkey']=$_POST['idobs_admitidos_entrevista_conte'];
                       //$entity->debug = true;        
                       $entity->updateRecord();
                       $id=$id_nam;
                   }
               $result='Se modifico exitosamente';
           }else{

               $_POST['fechacreacion'] = $currentdate;
               $_POST['usuariocreacion'] = $userid;
               $entity->SetEntity($_POST);
               //$entity->debug = true;
               $id=$entity->insertRecord();
               $result='Se registro exitosamente';
           }
           $i++;
        }
    
    }
    
}
if ($table=='admitidos_cab_entrevista'){
    ////////// GUARDA LOS DATOS DE LA CABECERA DE LA ENTREVISTA
    $entity->SetEntity($_POST);
    $_POST['documentacion_requerida'] = isset($_POST['documentacion_requerida'])? $_POST['documentacion_requerida'] : '';
    $_POST['idobs_estadoadmision'] = isset($_POST['idobs_estadoadmision'])? $_POST['idobs_estadoadmision'] : '';
    $_POST['recomienda_admision_porque'] = isset($_POST['recomienda_admision_porque'])? $_POST['recomienda_admision_porque'] : '';
    $_POST['seguimiento'] = isset($_POST['seguimiento'])? $_POST['seguimiento'] : '';
    $_POST['recomienda_seguimiento'] = isset($_POST['recomienda_seguimiento'])? $_POST['recomienda_seguimiento'] : '';
    $_POST['fecha_admision'] = isset($_POST['fecha_admision'])? $_POST['fecha_admision'] : '';
    $_POST['admitido'] = isset($_POST['admitido'])? $_POST['admitido'] : '';
    if (!empty($_POST['admitido'] )){
        $_POST['quien_admite']=$userid;
    }
   // echo $_POST['quien_admite'].'-->>'; 
    $id_nam=$_REQUEST[$idname];
    if(!empty($id_nam)){
             $entity->fieldlist[$idname]['pkey']=$_REQUEST[$idname];
            if($action=='inactivate'){
               //$entity->debug = true;
                $entity->deleteRecord();
                $id=$id_nam;
            }else{
                $entity->SetEntity($_POST);
               // $entity->debug = true;        
                $entity->updateRecord();
                $id=$id_nam;
            }
        $result='Se modifico exitosamente';
    }else{
        
        $_POST['fechacreacion'] = $currentdate;
        $_POST['usuariocreacion'] = $userid;
        $entity->SetEntity($_POST);
        //$entity->debug = true;
        $id=$entity->insertRecord();
        $result='Se registro exitosamente';
    }
    
    if (!empty($_REQUEST['iddocu'])){
        $entity = new ManagerEntity('documentos_pendientes',"observatorio");
        $_POST['idobs_admitidos_cab_entrevista']=$id;
        $_POST['codigoestado']=$_POST['codigoestado'];
        $_POST['fechacreacion'] = $currentdate;
        $_POST['usuariocreacion'] = $userid;
        $doc=explode(",",$_REQUEST['iddocu']);
        $docP=explode(",",$_REQUEST['docP']);
        $i=0;		
        foreach($doc as $ca){
            $ca = str_replace("'", "", $ca);
            if($ca==0){
                if($docP[$i]!=0){ $action='inactivate'; }
                $_POST['idobs_documentos_pendientes']=$docP[$i];
                $entity->SetEntity($_POST);
                if($action=='inactivate'){
                    $entity->fieldlist['idobs_documentos_pendientes']['pkey']=$_POST['idobs_documentos_pendientes'];
                    //$entity->debug = true;
                    $entity->deleteRecord();
                    $id=$id_nam;
                }else{
                    $entity->fieldlist['idobs_documentos_pendientes']['pkey']=$_POST['idobs_documentos_pendientes'];
                    //$entity->debug = true;        
                    $entity->updateRecord();
                    $id=$id_nam;
                }
            }else{
               // echo $docP[$i].'--><br>';
                if($docP[$i]==0){                   
                }else{
                    $_POST['idobs_documentos_pendientes']=$docP[$i];
                    $entity->fieldlist['idobs_documentos_pendientes']['pkey']=$_POST['idobs_documentos_pendientes'];
                    $entity->SetEntity($_POST);
                    //$entity->debug = true;        
                    $entity->updateRecord();
                    $id=$id_nam;
                }
                
            }
           $i++; 
        }
		if($docP[$i]==0)
		{                    				
                    $entity->insertRecordDocumentos($_POST);
                    $result='Se registro exitosamente';
        }
    }
    if (!empty($_REQUEST['user'])){
        $entity = new ManagerEntity('admitidos_user',"observatorio");
        $doc=explode(",",$_REQUEST['user']);
        $iddoc=explode(",",$_REQUEST['iduser']);
        $i=0;
        foreach($doc as $ca){
            $ca = str_replace("'", "", $ca);
            $ca = str_replace("\\", "", $ca);
            $iddoc[$i]= str_replace("'", "", $iddoc[$i]);
            $iddoc[$i] = str_replace("\\", "", $iddoc[$i]);
             $_POST['idusuario']=$ca;
             $_POST['idobs_admitidos_user']=$id;
            // echo $ca.'-->';
            if($iddoc[$i]==''){
                    if(!empty($ca)){
                       //  echo $iddoc[$i].'<-->';
                        $_POST['fechacreacion'] = $currentdate;
                        $_POST['usuariocreacion'] = $userid;
                        $_POST['idobs_admitidos_user']='';
                        $entity->SetEntity($_POST);
                        //$entity->debug = true;
                        $entity->insertRecord();
                        $result='Se registro exitosamente';
                    }
                }else{
                    //echo $iddoc[$i].'<<-->>';
                    $_POST['idobs_admitidos_user']=$iddoc[$i];
                    $entity->fieldlist['idobs_admitidos_user']['pkey']=$_POST['idobs_admitidos_user'];
                    $entity->SetEntity($_POST);
                   // $entity->debug = true;        
                    $entity->updateRecord();
                    $id=$id_nam;
                }
            $i++;
        }
    }
    
    ///////////
}
$data = array('success'=> true,'message'=> $result,'id'=>$id);
//print_r($data);
echo json_encode($data);
?>