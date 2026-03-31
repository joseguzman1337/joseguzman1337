<?php
session_start();
//$_ESSION['MM_Username'] = 'admintecnologia';

/*if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
}*/
switch($_REQUEST['actionID']){
    case 'BusacrXTodo':{
        global $C_MotorAsignacion,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        
        $C_MotorAsignacion->BuscarDataReporte($db,$_POST,4,$userid);
    }break;
    case 'Lista':{
        global $C_MotorAsignacion,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        $Datos  = $_POST['Datos'];
        
        $C_MotorAsignacion->ListaView($db,$Datos);
        
    }break;
    case 'MotorSave':{
        global $userid,$db;
        MainJson();
        
        //echo '<pre>';print_r($_POST);die;
        
        $Data_SolicitudID = $_POST['Data_SolicitudID'];
        $Type             = $_POST['Type'];
        
        $DataExite        = array();
        for($i=0;$i<count($Data_SolicitudID);$i++){
           /***********************************************************/
              $SQL='SELECT 

                    MotorSolicitudEspacioId AS id,
                    SolicitudPadreId AS idSoli
                    
                    FROM 
                    
                    MotorSolicitudEspacio
                    
                    WHERE
                    
                    codigoestado=100
                    AND
                    Estado=1
                    AND
                    SolicitudPadreId="'.$Data_SolicitudID[$i].'"';
                    
              if($Existe=&$db->Execute($SQL)===false){
                    $a_vectt['val']			=false;
                    $a_vectt['descrip']		='Error al Validar la Solicitud...';
                    echo json_encode($a_vectt);
                    exit;
              }     
              
              if($Existe->EOF){
                /***********************Insert********************************/
                $Insert='INSERT INTO MotorSolicitudEspacio(SolicitudPadreId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaUltimaModificacion,TipoBuscar)VALUES("'.$Data_SolicitudID[$i].'","'.$userid.'","'.$userid.'",NOW(),NOW(),"'.$Type.'")';
                
                    if($Existe=&$db->Execute($Insert)===false){
                        $a_vectt['val']			=false;
                        $a_vectt['descrip']		='Error al Insertar la Solicitud al Motor...';
                        echo json_encode($a_vectt);
                        exit;
                    } 
              }else{
                /***********************Array********************************/
                $DataExite[] = $Data_SolicitudID[$i];
              }            
           /***********************************************************/ 
        }//for
        
        if(count($DataExite)>=1){
            $a_vectt['val']			='Existen';
            $a_vectt['descrip']		='Se han Almacenado en el Motor Correctamente...';
            $a_vectt['descrip1']	='Ya existen unas Solicitudes Parametrizadas en el Motor de Asigancion';
            $a_vectt['descrip2']    ='a continuacion se generara la lista de las Solicitudes Existentes...';  
            $a_vectt['DataExite']	=$DataExite;         
        }else{            
            $a_vectt['val']			=true;
            $a_vectt['descrip']		='Se han Almacenado en el Motor Correctamente...';
        }
            echo json_encode($a_vectt);
            exit;
    }break;
    case 'BusacrXMateria':{
        global $C_MotorAsignacion,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        /*
        [Modalidad] => 200
        [ProgramaAcade] => 5
        [Materia] => 54
        */
        $C_MotorAsignacion->BuscarDataReporte($db,$_POST,3,$userid);
    }break;
    case 'BusacrXPrograma':{
        global $C_MotorAsignacion,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        /*
        [actionID] => BusacrXPrograma
        [Modalidad] => 200
        [ProgramaAcade] => 5
        */
        $C_MotorAsignacion->BuscarDataReporte($db,$_POST,2,$userid);
    }break;
    case 'BusacrXNummeros':{
        global $C_MotorAsignacion,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        /*
        [TypeBuscar] => 1 ó 2 ó 3 ó 4
        [Num_1] => 10
        [Num_2] => 50
        */
        $C_MotorAsignacion->BuscarDataReporte($db,$_POST,1,$userid);
    }break;
    case 'Materias':{
        global $C_MotorAsignacion,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        
        $C_MotorAsignacion->SolicitudMateria($db,$_POST['id'],$userid);
    }break;
    case 'Programas':{
        global $C_MotorAsignacion,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        
        $C_MotorAsignacion->ProgramaAcademico($db,$_POST['id'],$_POST['Op'],$userid);
    }break;
    default:{
        global $C_MotorAsignacion,$userid,$db;
        define(AJAX,false);
        MainGeneral();
        JsGeneral();
        
        $C_MotorAsignacion->Display($db);
    }break;
}
function MainGeneral(){

 	global $C_MotorAsignacion,$userid,$db;
		
		//var_dump(is_file("../templates/template.php"));die;
        include("../templates/template.php"); 	
        
        if(AJAX==false){  
            $db = writeHeader('Motor de Asignacion',true);
        }else{
            $db = getBD();
        }
	
		include('Motor_Asignacion_class.php');  $C_MotorAsignacion = new MotorAsignacion();
        
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		$userid=$Usario_id->fields['id'];
	}
function MainJson(){
	global $userid,$db;
		
		
		include("../templates/template.php");
		
		$db = getBD();
        
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
	}
function JsGeneral(){
    ?>
    <link rel="stylesheet" href="../css/jquery.clockpick.1.2.9.css" type="text/css" /> 
    <link rel="stylesheet" href="../css/Styleventana.css" type="text/css" />
     <script type="text/javascript" src="../../mgi/js/ajax.js">/*TODAS LAS FUCNIONES DE AJAX*/</script>
    <script type="text/javascript" language="javascript" src="Motor_Asignacion.js"></script>
    <script type="text/javascript" language="javascript" src="../js/jquery.bpopup.min.js"></script>
    <script type="text/javascript" language="javascript" src="../js/jquery.clockpick.1.2.9.js"></script>
    <script type="text/javascript" language="javascript" src="../js/jquery.clockpick.1.2.9.min.js"></script>
    <!--------------------Js Para Alert Diseño JAlert----------------------->
    <!--<script type="text/javascript" language="javascript" src="../js/JalertQuery/jquery.ui.draggable.js"></script>-->
    <script type="text/javascript" language="javascript" src="../js/JalertQuery/jquery.alerts.js"></script>
    <link rel="stylesheet" href="../js/JalertQuery/jquery.alerts.css" type="text/css" />
    <script>
     $('#ui-datepicker-div').css('display','none');
     $('#BBIT_DP_CONTAINER').css('display','none');
     </script>
    <?PHP
}    

?>