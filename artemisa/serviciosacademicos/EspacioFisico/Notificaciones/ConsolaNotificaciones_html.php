<?php
session_start();
/*if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
}*/
switch($_REQUEST['actionID']){
    case 'EnviarEmail':{
        include_once('NotificacionEspaciosFisicos_class.php'); $C_NotificacionEspaciosFisicos = new NotificacionEspaciosFisicos();
        include_once('ConsolaNotificaciones_View.php');        $V_ConsolaNotificaciones = new ViewConsolaNotificaciones();
        global $userid,$db;
        MainJson();
        //echo '<pre>';print_r($_POST);
        /*
        [Solicitud_id] => 
        [actionID] => EnviarEmail
        [example_length] => 100
        [Enviar] => Array
            (
                [0] => 30
                [1] => 31
                [2] => 607
                [3] => 1018
                [4] => 2163
            )
        */
        
        $Enviar = $_POST['Enviar'];
        
        for($i=0;$i<count($Enviar);$i++){
            
            $id = $Enviar[$i];
            
            $Alumnos = $C_NotificacionEspaciosFisicos->AlumnosSolicitudCambio($db,$id);
           /*
            (
                [0] => 56516
                [codigoestudiante] => 56516
                [1] => CHRISTIAN YESID LUNA GALINDO
                [FulName] => CHRISTIAN YESID LUNA GALINDO
                [2] => clunag@unbosque.edu.co
                [Correo] => clunag@unbosque.edu.co
            )
            */
            for($j=0;$j<count($Alumnos);$j++){
                $CodigoEstudiante = $Alumnos[$j]['codigoestudiante'];
                $Correo           = $Alumnos[$j]['Correo'];
                $FulName          = $Alumnos[$j]['FulName'];   
                
                $Info = $C_NotificacionEspaciosFisicos->InfoManualCambios($db,$id,$CodigoEstudiante);
                
                //echo '<pre>';print_r($Info);
                $Mensaje = $V_ConsolaNotificaciones->Mensaje($Info,$FulName);
                
                $to = $Correo;
                //echo '<br><br>'.$Mensaje;
                $tittle = 'Cambios De Aula o Camcelaci&oacute;n de Clase';
                
                $Resultado = $C_NotificacionEspaciosFisicos->EnviarCorreo($to,$tittle,$Mensaje,true);
            }//for            
        }//for
        
        for($i=0;$i<count($Enviar);$i++){
            $id = $Enviar[$i];
            
            $C_NotificacionEspaciosFisicos->CambiarAEnviado($db,$id);
        }
        
        $a_vectt['val']			=true;
        $a_vectt['descrip']		='Se ha Notificado...';
        echo json_encode($a_vectt);
        exit;  
    }break;
    default:{
        global $C_ConsolaNotificaciones,$V_ConsolaNotificaciones,$userid,$db;
        define(AJAX,false);
        MainGeneral();
        JSGeneral();
        
        include_once('../../mgi/Menu.class.php');
        include_once('../Interfas/InterfazSolicitud_class.php');  $C_InterfazSolicitud = new InterfazSolicitud();

        $C_Menu_Global  = new Menu_Global();
        
        $Data = $C_InterfazSolicitud->UsuarioMenu($db,$userid);
        
       //echo '<pre>';print_r($Data);die;
        
        if($Data['val']==true){
            for($i=0;$i<count($Data['Data']);$i++){
                /**********************************************/
                if('InterfazSolicitud_html.php'==$Data['Data'][$i]['Url']){
                    $URL[] = '../Interfas/'.$Data['Data'][$i]['Url'];
                }else if('InterfazSolicitud_html.php?actionID=Creacion'==$Data['Data'][$i]['Url']){
                    $URL[] = '../Interfas/'.$Data['Data'][$i]['Url'];
                }else if('../asignacionSalones/SalonesDisponibles_html.php'==$Data['Data'][$i]['Url']){
                    $URL[] = $Data['Data'][$i]['Url'];
                }else if('../Notificaciones/ConsolaNotificaciones_html.php'==$Data['Data'][$i]['Url']){
                    $URL[] = $Data['Data'][$i]['Url'];
                }
                
                
                $Nombre[] = $Data['Data'][$i]['Nombre'];
                
                if($Data['Data'][$i]['Url']=='../Notificaciones/ConsolaNotificaciones_html.php'){
                    $Active[] = '1';    
                }else{
                    $Active[] = '0';
                }
                
                /**********************************************/
            }//for
        }else{
            echo $Data['Data'];die; 
        }//if
        
    //echo '<pre>';print_r($URL);
        
        $C_Menu_Global->writeMenu($URL,$Nombre,$Active);
        
        $Data = $C_ConsolaNotificaciones->InfoConsola($db);
        $V_ConsolaNotificaciones->Display($Data);
    }break;
}
function MainGeneral(){

		
		global $C_ConsolaNotificaciones,$V_ConsolaNotificaciones,$userid,$db;
		
	    include("../templates/template.php"); 	
        
        
        if(AJAX==false){  
            $db = writeHeader('Consola de Notificaciones',true);
        }else{
            $db = getBD();
        }
	
		include('ConsolaNotificaciones_class.php');  $C_ConsolaNotificaciones = new ConsolaNotificaciones();
        include('ConsolaNotificaciones_View.php');   $V_ConsolaNotificaciones = new ViewConsolaNotificaciones();
	
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
    <script type="text/javascript" src="ConsolaNotificaciones.js"></script>
    <?PHP
}    
?>
