<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$rutaVistas = "../View"; /*carpeta donde se guardaran las vistas (html) de la aplicación */
require_once(realpath(dirname(__FILE__))."/../../../../../Mustache/load.php"); /*Ruta a /html/Mustache */
//echo '<pre>';print_r($_POST);
 switch($_REQUEST['action_ID']){
    case 'Buscar':{
        global $db,$userid,$C_CambioCargaAcademica;
        define(CLASE,true);
        MainGeneral();
        
        $C_CambioCargaAcademica->BuscarInfo($db,$_POST);
    }break;
    case 'Save':{
        global $db,$userid,$C_CambioCargaAcademica;
        define(CLASE,true);
        MainGeneral();
        
        $C_CambioCargaAcademica->SaveValidaciones($db,$_POST);
    }break;
    default:{
        global $db,$userid;
        define(CLASE,false);
        MainGeneral();
      
        $template_index = $mustache->loadTemplate('CambioCargaAcademica'); /*carga la plantilla index*/
        
        $Info['title']               = 'Cambio de Carga Académica';
         
        
        echo $template_index->render($Info);
    }break;
 }
 function MainGeneral(){
    global $db,$userid,$C_CambioCargaAcademica;
    
    include_once ('../../../../EspacioFisico/templates/template.php');
   
    if(CLASE==true){
        include_once ('../Class/CambioCargaAcademica_class.php');  $C_CambioCargaAcademica = new CambioCargaAcademica();
    }
    $db = getBD();
    
    $SQL_User='SELECT idusuario as id,codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
    
    if($Usario_id=&$db->Execute($SQL_User)===false){
    		echo 'Error en el SQL Userid...<br>'.$SQL_User;
    		die;
    	}
    
     $userid=$Usario_id->fields['id'];
 }//function MainGeneral
?>