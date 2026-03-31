<?php
session_start();
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesi�n en el sistema</strong></blink>';
	exit();
}

$rutaVistas = "../View"; /*carpeta donde se guardaran las vistas (html) de la aplicación */
require_once(realpath(dirname(__FILE__))."/../../../../Mustache/load.php"); /*Ruta a /html/Mustache */
//echo '<pre>';print_r($_POST);
 switch($_REQUEST['action_ID']){
    
    case 'Save':{
        global $db,$userid,$C_SalaAprendizaje;
        define(CLASE,true);
        MainGeneral();        
        
        $C_SalaAprendizaje->InsertSalaAprendizaje($db,$_POST,$userid);
    }break;
    case 'AutoPrograma':{
        global $db,$userid,$C_SalaAprendizaje;
        define(CLASE,true);
        MainGeneral();
        
        $Letra = $_REQUEST['term'];
        
        $C_SalaAprendizaje->DepartamentoPrograma($db,$Letra);
    }break;
    case 'AddTr':{
        global $db,$userid,$C_SalaAprendizaje;
        define(CLASE,true);
        MainGeneral();
        
        $i = $_POST['NumFiles'];
        
        $C_SalaAprendizaje->AddTr($db,$i);
    }break;
    default:{
        global $db,$userid,$C_SalaAprendizaje,$C_ListadoSalaAprendizaje;
        define(CLASE,true);
        MainGeneral();
        $op = $_REQUEST['Op'];
        $title = 'Salas de Aprendizaje';
        $C_periodo = $C_SalaAprendizaje->Periodo($db);
        $C_Competencia = $C_SalaAprendizaje->Competencias($db,$_SESSION['codigoperiodosesion']);
        
        $template_index = $mustache->loadTemplate('CrearSalaAprendizaje'); /*carga la plantilla index*/
        
        $Info['title']       = 'Creación de Salas de Aprendizaje';
        $Info['Periodo']     = $C_periodo;
        $Info['Competencia'] = $C_Competencia;
        if($op){
        $Info['baner']       = $C_ListadoSalaAprendizaje->banerPrincipal($title);
        }
        
        echo $template_index->render($Info);
    }break;
 }
 function MainGeneral(){
    global $db,$userid,$C_SalaAprendizaje,$C_ListadoSalaAprendizaje;
    
    include_once ('../../../EspacioFisico/templates/template.php');
    if(CLASE==true){
        include_once ('../Class/CrearSalaAprendizaje_class.php');  $C_SalaAprendizaje = new CrearSalaAprendizaje();
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