<?php
session_start();
/*if(!isset ($_SESSION['MM_Username'])){
	?>
	<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>
	<?PHP
    exit();
} */
switch($_REQUEST['actionID']){
    case 'Save':{
        global $userid,$db;
        
        MainJson();
      
        $Modalidad_id           = $_POST['Modalidad_id'];
        $Periodo_id             = $_POST['Periodo_id'];
        $Programa_id            = $_POST['Programa_id'];
        $codigoestudiante       = $_POST['codigoestudiante'];
        $TipoApoyo              = $_POST['TipoApoyo'];
        $Descripcion            = $_POST['Descripcion'];
        
        /************************************************************************************************/
        $SQL_Insert='INSERT INTO ApoyosAcademicos(modalidad_id,codigoperiodo,carrera_id,codigoestudiante,tipo_id,descripcion,entrydate,userid)VALUES("'.$Modalidad_id.'","'.$Periodo_id.'","'.$Programa_id.'","'.$codigoestudiante.'","'.$TipoApoyo.'","'.$Descripcion.'",NOW(),"'.$userid.'")';
        
        if($InsertApoyoAcademico=&$db->Execute($SQL_Insert)===false){
            $a_vectt['val']			='FALSE';
            $a_vectt['descrip']		='Error en Inser de los Apoyos Academicos... '.$SQL_Insert;
            echo json_encode($a_vectt);
            exit; 
        }
        
            $a_vectt['val']			='True';
            //$a_vectt['descrip']		='Error en Inser de los Apoyos Academicos... '.$SQL_Insert;
            echo json_encode($a_vectt);
            exit; 
        /************************************************************************************************/
    }break;
    case 'AutocompleteDocumento':{
        global $userid,$db;
        
        MainJson();
        
        $Letra   		= $_REQUEST['term'];
        $Programa_id    = $_REQUEST['Programa_id'];
        
        
          $SQL_Estudiante='SELECT 

                            e.codigoestudiante,
                            eg.idestudiantegeneral,
                            eg.nombresestudiantegeneral,
                            eg.apellidosestudiantegeneral,
                            eg.numerodocumento
                            
                            
                            FROM 
                            
                            estudiantegeneral eg INNER JOIN estudiante e ON eg.idestudiantegeneral=e.idestudiantegeneral
                            
                            WHERE
                            
                           
                            e.codigocarrera="'.$Programa_id.'"
                            AND
                            eg.numerodocumento LIKE "%'.$Letra.'%"';
                            
                if($Data_Estudiante=&$db->Execute($SQL_Estudiante)===false){
                    echo 'Error en el SQL ....<br><br>'.$SQL_Estudiante;
                    die;
                } 
                
                $Result = array();
                
                while(!$Data_Estudiante->EOF){
                    /*********************************************************/
                    	$C_Result['label']                 = $Data_Estudiante->fields['numerodocumento'];
						$C_Result['value']                 = $Data_Estudiante->fields['numerodocumento'];
                        $C_Result['NombreEstudiante']      = $Data_Estudiante->fields['nombresestudiantegeneral'].' '.$Data_Estudiante->fields['apellidosestudiantegeneral'];
                        $C_Result['idEstudianteGeneral']   = $Data_Estudiante->fields['idestudiantegeneral'];
                        $C_Result['CodigoEstudiante']      = $Data_Estudiante->fields['codigoestudiante'];
					 /*********************************************/
					 array_push($Result,$C_Result);
                    /*********************************************************/
                    $Data_Estudiante->MoveNext();
                }           
         	echo json_encode($Result);                   
        
    }break;
    case 'AutocompletarEstudiante':{
        global $userid,$db;
        
        MainJson();
        
        $Letra   		= $_REQUEST['term'];
        $Periodo_id     = $_REQUEST['Periodo_id'];
        $Programa_id    = $_REQUEST['Programa_id'];
        
        
          $SQL_Estudiante='SELECT 

                            e.codigoestudiante,
                            eg.idestudiantegeneral,
                            eg.nombresestudiantegeneral,
                            eg.apellidosestudiantegeneral,
                            eg.numerodocumento
                            
                            
                            FROM 
                            
                            estudiantegeneral eg INNER JOIN estudiante e ON eg.idestudiantegeneral=e.idestudiantegeneral
                            
                            WHERE
                            
                           
                            e.codigocarrera="'.$Programa_id.'"
                            AND
                            (eg.nombresestudiantegeneral LIKE "%'.$Letra.'%" OR eg.apellidosestudiantegeneral LIKE "%'.$Letra.'%")';
                            
                if($Data_Estudiante=&$db->Execute($SQL_Estudiante)===false){
                    echo 'Error en el SQL ....<br><br>'.$SQL_Estudiante;
                    die;
                } 
                
                $Result = array();
                
                while(!$Data_Estudiante->EOF){
                    /*********************************************************/
                    	$C_Result['label']                 = $Data_Estudiante->fields['nombresestudiantegeneral'].' '.$Data_Estudiante->fields['apellidosestudiantegeneral'];
						$C_Result['value']                 = $Data_Estudiante->fields['nombresestudiantegeneral'].' '.$Data_Estudiante->fields['apellidosestudiantegeneral'];
                        $C_Result['NumeroDocumento']       = $Data_Estudiante->fields['numerodocumento'];
                        $C_Result['idEstudianteGeneral']   = $Data_Estudiante->fields['idestudiantegeneral'];
                        $C_Result['CodigoEstudiante']      = $Data_Estudiante->fields['codigoestudiante'];
					 /*********************************************/
					 array_push($Result,$C_Result);
                    /*********************************************************/
                    $Data_Estudiante->MoveNext();
                }           
         	echo json_encode($Result);                   
        
    }break;
    case 'BuscarProgram':{
        global $db,$userid,$C_ApoyoAcademico;
        define(AJAX,true);
        
        MainGeneral();
        
        $C_ApoyoAcademico->Programas($_POST['Modalidad_id']);
        
    }break;
    default:{
        global $db,$userid,$C_ApoyoAcademico;
        define(AJAX,false);
        
        MainGeneral();
        MainJSGeneral();
        
        $C_ApoyoAcademico->Display();
    }break;
}
function MainGeneral(){
    
    global $db,$userid,$C_ApoyoAcademico;
    
    //include ('../templates/mainjson.php');
    
    if(AJAX==false){
        include("../templates/templateObservatorio.php");
        $db =writeHeader("Formulario de Apoyos <br> Acad&eacute;micos",true,"Apoyo Academico",1);
        
    }else{
        include ('../templates/mainjson.php');
	    
    }
    
    
    
    include ('ApoyoAcademico_class.php');  $C_ApoyoAcademico = new ApoyoAcademico();
	
	
	$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
	
	if($Usario_id=&$db->Execute($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>';
		die;
	}
	
	$userid=$Usario_id->fields['id'];
    
}
function MainJson(){
	
	global $db,$userid;
	
	
	include ('../templates/mainjson.php');
	
	$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
	
	if($Usario_id=&$db->Execute($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>';
		die;
	}
	
	$userid=$Usario_id->fields['id'];
	
}
function MainJSGeneral(){
    ?>
    <script type="text/javascript" language="javascript" src="ApoyoAcademico.js"></script> 
    <?PHP
}//MainJSGeneral
?>