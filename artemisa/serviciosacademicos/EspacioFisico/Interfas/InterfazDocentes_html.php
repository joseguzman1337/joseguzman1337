<?php
session_start();
//echo '<pre>';print_r($_SESSION);die;
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
}
     
//echo '<pre>';print_r($_REQUEST['actionID']);
switch($_REQUEST['actionID']){
    default:{
        global $db,$C_InterfazDocente,$userid,$codigorol;
       
        define(AJAX,false);
        MainGeneral();
        JsGeneral();
        /*$codigorol=2;
        $_SESSION['numerodocumento']=19358214;*/
        if($_SESSION['numerodocumento'] && $codigorol==2){
            $C_InterfazDocente->Display($db,$_SESSION['numerodocumento']);    
        }else{
            	echo '<blink><strong style="color:#F00; font-size:18px">Su Usuario No es Docente...</strong></blink>';
                exit();
        }
        
    }break;
}
function MainGeneral(){

		
		global $C_InterfazDocente,$userid,$db,$codigorol;
		
		//var_dump(is_file("../templates/template.php"));die;
        include("../templates/template.php"); 	
        
        if(AJAX==false){  
            $db = writeHeader('Interfaz Solicitud',true);
        }else{
            $db = getBD();
        }
	
		include('InterfazDocentes_class.php');  $C_InterfazDocente = new InterfazDocente();
        
       // echo 'Nmae->'.$_SESSION['MM_Username'];
	
		$SQL_User='SELECT idusuario as id, codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		$userid=$Usario_id->fields['id'];
        $codigorol=$Usario_id->fields['codigorol'];
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
    <link rel="stylesheet" type="text/css" href="../asignacionSalones/css/jquery.datetimepicker.css"/>
    <script type="text/javascript" src="../asignacionSalones/js/jquery.datetimepicker.js"></script>
    <script type="text/javascript" src="../../mgi/js/ajax.js">/*TODAS LAS FUCNIONES DE AJAX*/</script>
    <script type="text/javascript" language="javascript" src="InterfazSolicitud.js"></script>
    <!--<script type="text/javascript" language="javascript" src="SolicitudExterna.js"></script>-->
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
     function Ver_EstadoSolicitudDocente(){
        /***************************************************/
    
            var id =  $('#Id_Solicitud').val();    
            
            if(!$.trim(id)){
                alert('Selecionar un Item de la Tabla.');
                return false;
            } 
             
            $.ajax({//Ajax
        		   type: 'POST',
        		   url: 'InterfazSolicitud_html.php',
        		   async: false,
        		   dataType: 'html',
        		   data:({actionID: 'Ver_EstadoSolicitud',id:id,Op:1,Omitir:1}),
        		   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        		   success: function(data){
        					
        					$('#container').html(data);
        							
        		   } 
        	}); //AJAX
        /**************************************************/
     }//function Ver_EstadoSolicitudDocente
     </script>
     
    <?PHP
}    
?>