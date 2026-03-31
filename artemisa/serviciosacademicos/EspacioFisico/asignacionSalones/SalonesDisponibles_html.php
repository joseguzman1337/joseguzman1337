<?php
session_start();
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
}
switch($_REQUEST['actionID']){
    case 'SalonesLibres':{
        global $C_SalonesDisponibles,$V_SalonesDisponibles,$userid,$db;
        define(AJAX,true);
        MainGeneral();
       
        $horaInicioSolicitud  = $_POST['datetimepicker1'];
        $horaFinSolicitud     = $_POST['datetimepicker2'];
        $accesoDiscapacitados = $_POST['accDiscapacitados'];//on activo
        $fechaInicio               = $_POST['fechaInicio'];
        $fechaFinal               = $_POST['fechaFinal'];
        $dia                      = $_POST['dia'];
        $Sede                     = $_POST['Sede'];
        include_once('../Solicitud/SolicitudEspacio_class.php'); $C_Solicitud  = new SolicitudEspacio();
        
        $C_Fecha = $C_Solicitud->FechasFuturas('35',$fechaInicio,$fechaFinal,$dia);
       // echo '<pre>';print_r($C_Fecha);die;
        $Resultado = $C_SalonesDisponibles->DataFuncion($db,'2',$C_Fecha,$horaInicioSolicitud,$horaFinSolicitud,$accesoDiscapacitados,$Sede,$userid);
        //echo '<pre>';print_r($Resultado);
        $V_SalonesDisponibles->EspaciosLibres($db,$Resultado,$C_Fecha,$dia,$accesoDiscapacitados,$horaInicioSolicitud,$horaFinSolicitud);
    }break;
    default:{
        global $C_SalonesDisponibles,$V_SalonesDisponibles,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        JSGeneral();
        //var_dump(is_file('../Interfas/InterfazSolicitud_class.php'));die;
                
        $Dias = $C_SalonesDisponibles->SemanaDias($db);  
        $Sedes = $C_SalonesDisponibles->Sedes($db);
        
        $V_SalonesDisponibles->Display($Dias,$Sedes);
    }break;
}
function MainGeneral(){

		
		global $C_SalonesDisponibles,$V_SalonesDisponibles,$userid,$db;
		
	    include("../templates/template.php"); 	
        
        
        if(AJAX==false){  
            $db = writeHeader('Salones Disponibles',true);
        }else{
            $db = getBD();
        }
	
		include('SalonesDisponibles_class.php');  $C_SalonesDisponibles = new SalonesDisponibles();
        include('SalonesDisponibles_View.php');  $V_SalonesDisponibles = new ViewSalonesDisponibles();
	
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
function JSGeneral(){
    ?>
    <link rel="stylesheet" type="text/css" href="../asignacionSalones/css/jquery.datetimepicker.css"/>
    <script type="text/javascript" src="../asignacionSalones/js/jquery.js"></script>
    <script type="text/javascript" src="../asignacionSalones/js/jquery.datetimepicker.js"></script>
    <script type="text/javascript" src="../asignacionSalones/SalonesDisponibles.js"></script>
    <?PHP
}    
?>