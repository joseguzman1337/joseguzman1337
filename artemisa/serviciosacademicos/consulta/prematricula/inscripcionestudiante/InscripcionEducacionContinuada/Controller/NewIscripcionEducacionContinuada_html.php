<?php
    /*
    * Ivan Dario Quintero Rios
    * Modificado 28 de Diciembre 2017
    */

$rutaVistas = "../View"; /*carpeta donde se guardaran las vistas (html) de la aplicaci�n */
require_once(realpath(dirname(__FILE__))."/../../../../../../Mustache/load.php"); /*Ruta a /html/Mustache */
include('../../../../../../assets/Complementos/piepagina.php');
$piepagina = new piepagina;

if(empty($_REQUEST['action_ID']))
{
    $action = "";
}else
{
    $action = $_REQUEST['action_ID'];
}

switch($action){
    default:{
        global $db,$C_Inscripcion;
        $clase = true;
        MainGeneral($clase);
        
        $grupo            = $_REQUEST['Grupo'];        
        
        $TipoDocumento    = $C_Inscripcion->TipoDocumento($db);
        $Genero           = $C_Inscripcion->Genero($db);
        $LabelAgrupacion  = $C_Inscripcion->TextoCurso($db,$grupo);
        $CursosAgrupacion = $C_Inscripcion->CursosAgrupcion($db,$grupo);        
        
        $template_index = $mustache->loadTemplate('NewIscripcionEducacionContinuada_new'); 
        
        if($LabelAgrupacion['Codigo']==1)
        {        
            $Info['title']               = 'Inscripción Educación Continuada';
            $Info['TipoDocumento']       = $TipoDocumento;
            $Info['Genero']              = $Genero;
            $Info['Grupo']               = $grupo;
            $Info['LabelCurso']          = $LabelAgrupacion['Label'];
            $Info['codigoperiodo']       = $LabelAgrupacion['periodo'];            
            $Info['agrupaciones']        = $CursosAgrupacion;
        }else{
            $Info['title']               = 'Inscripción Educación Continuada';
            $Info['LabelCurso']          = $LabelCurso['Label'];
        }
        echo $template_index->render($Info);
    }break;
}//switch

function MainGeneral($clase)
{
    global $db,$C_Inscripcion;
    
    include_once ('../../../../../EspacioFisico/templates/template.php');
   
    if($clase==true){
        include_once ('../Class/NewIscripcionEducacionContinuada_class.php');  
        $C_Inscripcion = new Inscripcion();
    }
    $db = getBD();
    
 }//function MainGeneral
?>
