<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
session_start;
	/*include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); */

$rutaVistas = "../View"; /*carpeta donde se guardaran las vistas (html) de la aplicaci�n */
//var_dump(IS_FILE("../../../../Mustache/load.php"));die;

require_once(realpath(dirname(__FILE__))."/../../../../Mustache/load.php"); /*Ruta a /html/Mustache */
	
 switch($_REQUEST['action_ID']){
    case 'BuscarCarrera':{
        global $db,$C_continuada;
        define(CLASE,true);
        MainGeneral();
        
        $C_continuada->AutoCarreraNueva($db,$_REQUEST['term']);
        
    }break;
    case 'CambioCarrera':{
    /*
    [idestudiantegeneral] => 111717
    [id] => 3
    [codigoestudiante] => 166110
    [codigoperiodo] => 20152
    */
        global $db,$C_continuada;
        define(CLASE,true);
        MainGeneral();
        
        $codigoestudiante    = $_POST['codigoestudiante'];
        $id                  = $_POST['id'];
        $idestudiantegeneral = $_POST['idestudiantegeneral'];
        $codigoperiodo       = $_POST['codigoperiodo'];
        
        $Datos = $C_continuada->DataEstudiante($db,$codigoestudiante,$codigoperiodo);
        
        $template_index = $mustache->loadTemplate('CarreraCambioEdu'); /*carga la plantilla index*/
        $Info['NombreEstudiante']      = $Datos[0]['fulname'];
        $Info['numerodocumento']       = $Datos[0]['numerodocumento'];
        $Info['Celular']               = $Datos[0]['celularestudiantegeneral'];
        $Info['Correo']                = $Datos[0]['emailestudiantegeneral'];
        $Info['nombrecarrera']         = $Datos[0]['nombrecarrera'];
        
        $Info['codigoestudiante']      = $codigoestudiante;
        $Info['id']                    = $id;
        $Info['idestudiantegeneral']   = $idestudiantegeneral;
        $Info['codigoperiodo']         = $codigoperiodo;
        
        echo $template_index->render($Info);
    }break;
    default:{
	
        global $db,$C_continuada;
        define(CLASE,true);
        MainGeneral();
		$data=$C_continuada->ReporteOrden($db);
        $template_index = $mustache->loadTemplate('reporteOrdenPago'); /*carga la plantilla index*/
        $Info['title']               = 'Reporte Orden Educación Continuada';
        $Info['data']       = $data;
        
        echo $template_index->render($Info);
    }break;
 }
 function MainGeneral(){
    global $db,$C_continuada;
    //var_dump(IS_FILE("../../../EspacioFisico/templates/template.php"));die;
    include_once ('../../../EspacioFisico/templates/template.php');
   
    if(CLASE==true){
        include_once ('UtilsContinuada_class.php');  $C_continuada = new UtilsContinuada();
    }
    $db = getBD();
    
 }//function MainGeneral
?>