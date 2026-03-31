<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

$rutaVistas = "../view"; /*carpeta donde se guardaran las vistas (html) de la aplicación */
require_once(realpath(dirname(__FILE__))."/../../../../../../Mustache/load.php"); /*Ruta a /html/Mustache */

 switch($_REQUEST['action_ID']){    
    case 'ListCrueces':{
        $Estudiantes = $_POST['Estudiantes'];
        
        global $db,$userid,$C_Rotacion;
        define(CLASE,true);
        MainGeneral();
        
        $C_Rotacion->ListCruce($db,$Estudiantes);
    }break;
    case 'NewRotacionSubGrupo':{
        global $db,$userid,$C_Rotacion;
        define(CLASE,true);
        MainGeneral();
        $Datos = $_POST;
        $C_Rotacion->InsertRotacion($db,$Datos,$userid);
        
    }break;
    case 'UpdateData':{
        global $db,$userid,$C_Rotacion;
        define(CLASE,true);
        MainGeneral();
        $Datos = $_POST;
        $C_Rotacion->InsertRotacion($db,$Datos,$userid);
        
    }break;
    case 'Instituciones':{
        global $db,$userid,$C_Rotacion;
        define(CLASE,true);
        MainGeneral();
        
        $C_Rotacion->VerInstituciones($db,$_POST['id']);
        
    }break;
     case 'EliminarRotacion':{
        global $db,$userid,$C_Rotacion;
        define(CLASE,true);
        MainGeneral();
        $Datos = $_POST;
        $C_Rotacion->EliminarRotaccion($db,$Datos);
       
    }break;
    case 'CalcularHoras':
    {
        $jornada = $_POST['jornada'];
        $dias = $_POST['dias'];
        switch($jornada)
        {
            case '1':
            {
                $totalhoras = $dias * 12;
            }break;
            case '2':
            {
                $totalhoras = $dias * 5;
            }break;
            case '3':
            {
                $totalhoras = $dias * 5;
            }break;
            case '4':
            {
                $totalhoras = $dias * 5;
            }break;
            case '5':
            {
                $totalhoras = $dias * 12;
            }break;
            case '6':
            {
                $totalhoras = '0';
            }break;
            case '7':
            {
                $totalhoras = $dias * 4;
            }break;
            /* Caso 105713.
             * Modificado por Luis Dario Gualteros C <castroluid@unbosque.edu.co>
             * Se adicina la jornada de 7.00 a 17:00 de acuerdo a la solicitud de Medicina Familiar. 
             * @since Octubre 9, 2018
            */
            case '8':
            {
             $totalhoras = $dias * 10;   
            }break;
            //End Caso 105713.
        }
       echo $totalhoras;
    }break;
    default:{ 
        global $db,$userid,$C_Rotacion;
        define(CLASE,true);
        MainGeneral();
        
        $arrayP = str_split($_SESSION['codigoperiodosesion'], strlen($_SESSION['codigoperiodosesion'])-1);
        $PeriodView = $arrayP[0].'-'.$arrayP[1]; +
        
        $grupo = $_REQUEST['idgrupo'];      
        $SubGrupo = $_REQUEST['SubgrupoId'];
        
        $Carrera     = $C_Rotacion->CareraGrupo($db,$grupo); 
        $Data        = $C_Rotacion->CareraGrupo($db,$grupo,1); 
        $Jornada     = $C_Rotacion->Jornadas($db, $id);        
        $Especialida = $C_Rotacion->Espcialidad($db,$Carrera);
        $dias_opcionales = $C_Rotacion->Diasopcionales($db,$SubGrupo);
        $C_Rotacion  = $C_Rotacion->Instituciones($db,$Carrera);
                
        $template_index = $mustache->loadTemplate('RotacionSubGrupo'); /*carga la plantilla index*/
        
        $Info['title']       = 'Rotacion de Sub-Grupos';
        $Info['Fecha_1']     = 'Ingreso';
        $Info['Fecha_2']     = 'Egreso';
        $Info['Periodo']     = $PeriodView; 
        $Info['Rotacion']    = $C_Rotacion;
        $Info['PeriodoHidden']    = $_SESSION['codigoperiodosesion'];
        $Info['MateriaName'] = $Data['NameMateria'];
        $Info['GrupoName']   = $Data['NameGrupo'];
        $Info['SubgrupoId']  = $SubGrupo;
        $Info['idgrupo']     = $grupo;
        $Info['JornadaData'] = $Jornada;
        $Info['EspcialidaData'] = $Especialida;
        $Info['codigomateria'] = $Data['codigomateria'];
        $Info['Carrera'] = $Carrera;
        if($dias_opcionales[1]== '100'){$Info['dia1']= "checked";}
        if($dias_opcionales[2]== '100'){$Info['dia2']= "checked";}
        if($dias_opcionales[3]== '100'){$Info['dia3']= "checked";}
        if($dias_opcionales[4]== '100'){$Info['dia4']= "checked";}
        if($dias_opcionales[5]== '100'){$Info['dia5']= "checked";}
        if($dias_opcionales[6]== '100'){$Info['dia6']= "";}
        if($dias_opcionales[7]== '100'){$Info['dia7']= "";}
        echo $template_index->render($Info);
    }break;   
 }
 function MainGeneral(){
    global $db,$userid,$C_Rotacion;
    
    include_once ('../../../../../EspacioFisico/templates/template.php');
    if(CLASE==true){
        include_once ('RotacionSubGrupos_class.php');  $C_Rotacion = new RotacionSubGrupos();
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
