<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

$rutaVistas = "../View"; /*carpeta donde se guardaran las vistas (html) de la aplicaci?n */
 
require_once(realpath(dirname(__FILE__))."/../../../Mustache/load.php"); /*Ruta a /html/Mustache */

 switch($_REQUEST['action_ID']){
   case 'SaveData':{
        global $db,$C_CambioPlanEstudio,$userid;
        define(CLASE,true);
        define(ESTUDIANTE,true);
        MainGeneral();        
        SeccionStarActiva($db);  
        //echo '<pre>';print_r($_FILES);
        /*echo '<pre>';print_r($_POST);
        echo '<pre>';print_r($_FILES);*/
         $type = $_FILES['Archivo']['type'];
         $tmp_name = $_FILES['Archivo']['tmp_name'];
        
        $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
       
        $mime = finfo_file($finfo, $tmp_name); 
        finfo_close($finfo);                   
        
        
      //echo '<br>$type->'.$type.'<br>$mime->'.$mime;   
        
        if(($type!='application/vnd.ms-excel') || ($mime!='text/plain')){
            $info['val'] = false;
            $info['msj'] = "Error en el Tipo de Archivo Excel CSV";
            echo json_encode($info);
            exit;
        }
        
        if($_POST['opc']!=1){
            $C_CambioPlanEstudio->Validacion($db,$_POST['programa'],$_POST['PlanOld'],$_POST['PlanNew']);
        }else{
            $C_CambioPlanEstudio->LecturaArchivo($db,$_POST['programa'],$_POST['PlanNew'],$_FILES);
        }
             
        $a_vectt['val']			=true;
        $a_vectt['descrip']     ='Se ha Realizado el Cambio.';
        echo json_encode($a_vectt);
        exit;      
    }break;
    case 'PlanEstudio':{
        global $db,$C_CambioPlanEstudio,$userid;
        define(CLASE,true);
        define(ESTUDIANTE,true);
        MainGeneral();        
        SeccionStarActiva($db);  
        
        $id = $_POST['dato']; 
        
        $dato = $C_CambioPlanEstudio->PlanEstudio($db,$id);
         
        if($_POST['text']=='PlanOld'){
            $C_CambioPlanEstudio->ViewSelect($dato,'PlanOld');
        }else{
            $C_CambioPlanEstudio->ViewSelect($dato,'PlanNew');
        }
    }break;
    case 'Programa':{
        global $db,$C_CambioPlanEstudio,$userid;
        define(CLASE,true);
        define(ESTUDIANTE,true);
        MainGeneral();        
        SeccionStarActiva($db);  
        
        $id = $_POST['dato']; 
        
        $dato = $C_CambioPlanEstudio->Programa($db,$id);
        
        $C_CambioPlanEstudio->ViewSelect($dato,'programa','VerPlanEstudio');
    }break;
   default:{ 
        global $db,$C_CambioPlanEstudio,$userid;
        define(CLASE,true);
        define(ESTUDIANTE,true);
        MainGeneral();        
        SeccionStarActiva($db);  
        $data = $C_CambioPlanEstudio->Modalidad($db);
       
        $Info['Label'] ='Cambio de Plan Estudio';
        $Info['title'] ='Cambio de Plan Estudio';
        $Info['Modalidad'] ='Modalidad Académica';
        $Info['modalidad'] = 'modalidad';
        $Info['funcionModalida']= 'BuscarPrograma';
        $Info['DataModalidad'] = $C_CambioPlanEstudio->Modalidad($db);
        $Info['Programa'] ='Programa Académico';
        $Info['PlanOld'] ='Plan Estudio Actual';
        $Info['PlanNew'] ='Plan Estudio Nuevo';
        
        $template_index = $mustache->loadTemplate('CambioPlanEstudio'); /*carga la plantilla index*/
        
        
        echo $template_index->render($Info);
    }break;
 }
 function MainGeneral(){
    global $db,$C_CambioPlanEstudio;
    
    include_once ('../../EspacioFisico/templates/template.php');
   
    if(CLASE==true){
        include_once ('../Class/CambioPlanEstudio_class.php');  $C_CambioPlanEstudio = new CambioPlanEstudio();
    }
    $db = getBD();
   
 }//function MainGeneral
 function SeccionStarActiva($db){
    
    if(ESTUDIANTE==true){
    global $userid;    
     session_start();
        if(!isset ($_SESSION['MM_Username'])){
        	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
        	exit();
        }
        
        $SQL_User='SELECT idusuario as id,codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
    }     
 }//function SeccionStarActiva
?>