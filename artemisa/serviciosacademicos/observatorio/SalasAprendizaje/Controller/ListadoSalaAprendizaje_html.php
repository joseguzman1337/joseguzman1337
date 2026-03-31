<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
session_start();

if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesi�n en el sistema</strong></blink>';
	exit();
}

$rutaVistas = "../View"; /*carpeta donde se guardaran las vistas (html) de la aplicación */
require_once(realpath(dirname(__FILE__))."/../../../../Mustache/load.php"); /*Ruta a /html/Mustache */
//echo '<pre>';print_r($_POST);
 switch($_REQUEST['action_ID']){
    case 'UpdateSalaAprendizaje':{
        global $db,$userid,$C_ListadoSalaAprendizaje;
        define(CLASE,true);
        MainGeneral();
        
        $C_ListadoSalaAprendizaje->UpdateSalaAprendizaje($db,$_POST,$userid);
    }break;
    case 'Editar':{
        global $db,$userid,$C_ListadoSalaAprendizaje;
        define(CLASE,true);
        MainGeneral();
        
        $id  = $_REQUEST['id'];
        $title = 'Salas de Aprendizaje';
        
        $Data = $C_ListadoSalaAprendizaje->InfoSalaAprendizaje($db,$id);
        
        $template_index = $mustache->loadTemplate('EditarSalaAprendizaje'); /*carga la plantilla index*/
        
        $Info['title']          = 'Editar Sala de Aprendizaje';
        $Info['NombreSala']     = $Data[0]['NombreSala'];
        $Info['Programa']       = $Data[0]['Programa'];
        $Info['CodigoCarrera']        = $Data[0]['CodigoCarrera'];
        $Info['Periodo']        = $Data[0]['Periodo'];
        $Info['Sesion']         = $C_ListadoSalaAprendizaje->SesionSalaAprendizaje($db,$id);
        $Info['Total']          = $C_ListadoSalaAprendizaje->SesionSalaAprendizaje($db,$id,1);
        $Info['id']             = $id;
        $Info['baner']          = $C_ListadoSalaAprendizaje->banerPrincipal($title);
        
        echo $template_index->render($Info);
         
    }break;
    case 'EliminarSalaAprendizaje':{
        global $db,$userid,$C_ListadoSalaAprendizaje;
        define(CLASE,true);
        MainGeneral();
        
        $id  = $_POST['id'];
        
        $C_ListadoSalaAprendizaje->ElimnarSalaAprendizaje($db,$id,$userid);
    }break;
    case 'VerJson';{
        global $db,$userid,$C_ListadoSalaAprendizaje;
        define(CLASE,true);
        MainGeneral();
        
        $id  = $_POST['id'];
        
        $Data = $C_ListadoSalaAprendizaje->InfoSalaAprendizaje($db,$id);
        
        $Info['Justificacion']  = $Data[0]['Justificacion'];
        $Info['Objetivos']      = $Data[0]['Objetivos'];
        $Info['Evaluacion']     = $Data[0]['Evaluacion'];
        $Info['Bibliografia']   = $Data[0]['Bibliografia'];
        
        echo json_encode($Info);
        exit;
    }break;
    case 'Ver':{
        global $db,$userid,$C_ListadoSalaAprendizaje;
        define(CLASE,true);
        MainGeneral();
        
        $id  = $_POST['id'];
        
        $Data = $C_ListadoSalaAprendizaje->InfoSalaAprendizaje($db,$id);
        
        $template_index = $mustache->loadTemplate('VerSalaAprendizaje'); /*carga la plantilla index*/
        
        $Info['title']          = 'Ver Sala de Aprendizaje';
        $Info['NombreSala']     = $Data[0]['NombreSala'];
        $Info['Programa']       = $Data[0]['Programa'];
        $Info['Periodo']        = $Data[0]['Periodo'];
        $Info['Sesion']         = $C_ListadoSalaAprendizaje->SesionSalaAprendizaje($db,$id);
        
        echo $template_index->render($Info);
    }break;
    default:{
        global $db,$userid,$C_ListadoSalaAprendizaje;
        define(CLASE,true);
        MainGeneral();
        $op = $_REQUEST['Op'];
        $title = 'Salas de Aprendizaje';
        
        $template_index = $mustache->loadTemplate('ListadoSalaAprendizaje'); /*carga la plantilla index*/
        
        $Info['title']       = 'Listado de Salas de Aprendizaje';
        $Info['Data']        = $C_ListadoSalaAprendizaje->ListadoSalas($db,$_SESSION['codigoperiodosesion']);
        if($op){
        $Info['baner']       = $C_ListadoSalaAprendizaje->banerPrincipal($title);
        }
        echo $template_index->render($Info);
    }break;
 }
 function MainGeneral(){
    global $db,$userid,$C_ListadoSalaAprendizaje;
    
    include_once ('../../../EspacioFisico/templates/template.php');
   
    if(CLASE==true){
        include_once ('../Class/ListadoSalaAprendizaje_class.php');  $C_ListadoSalaAprendizaje = new ListadoSalaAprendizaje();
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