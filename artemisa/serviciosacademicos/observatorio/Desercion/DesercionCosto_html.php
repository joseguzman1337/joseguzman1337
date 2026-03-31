<?php
session_start();


switch($_REQUEST['actionID']){
    case 'Glosario':{
       global $db,$userid,$C_DesercionCostos;
        define(AJAX,false);
        MainGeneral();
        MainJSGeneral();
        
        $C_DesercionCostos->Glosario(); 
    }break;
    case 'BuscarPeriodo':{
        global $db,$userid;
        
        MainJson();
        
        $arrayP     = str_split($_POST['Periodo'], strlen($_POST['Periodo'])-1);
                                
        $P_Periodo  = $arrayP[0];
        
       
        
        
        if($_POST['Op']==1 || $_POST['Op']=='1'){
             $Periodos   = $P_Periodo.'1-'.$P_Periodo.'2';
        }
        
        if($_POST['Op']==2 || $_POST['Op']=='2'){
             $Periodos   = $P_Periodo;
        }
        
        $a_vectt['val']			='TRUE';
        $a_vectt['Periodos']	=$Periodos;
        echo json_encode($a_vectt);
        exit;
        
    }break;
    case 'Text':{
        global $db,$userid;
        
        MainJson();
        
        switch($_POST['TypeGrafica']){
            case '0':{
               ?>
               Este gr&aacute;fico nos muestra un comparativo de los costos de deserci&oacute;n institucionales  de la Universidad El Bosque en diferentes periodos, todos traidos a un valor presente.
               <?PHP
            }break;
            case '1':{
               ?>
               En esta opci&oacute;n encontramos  dos gr&aacute;ficos, el primero costo de deserci&oacute;n por periodo nos muestra el costo de deserci&oacute;n institucional (consolidado de todos los programas de pregrado) semestre a semestre en un periodo espec&iacute;fico. El segundo gr&aacute;fico participaci&oacute;n costo de deserci&oacute;n por semestre nos trae un gr&aacute;fico comparativo (gr&aacute;fico pastel) de la participaci&oacute;n (medido en porcentaje %)de cada semestre  en un periodo espec&iacute;fico.
               <?PHP
            }break;
            case '2':{
               ?>
               Este gr&aacute;fico nos muestra el comparativo de costos de deserci&oacute;n por programas de pregrado de la Universidad El Bosque, en un periodo espec&iacute;fico
               <?PHP
            }break;
            case '3':{
               ?>
               Este gr&aacute;fico nos muestra el comparativo de costos de deserci&oacute;n semestre a semestre de un programa espec&iacute;fico de pregrado de La Universidad El Bosque en un  periodo espec&iacute;fico seleccionado.
               <?PHP
            }break;
            
        }
    }break;
    case 'Consola':{
        global $db,$userid,$C_DesercionCostos;
        define(AJAX,false);
        define(Titulo,1);
        MainGeneral();
        MainJSGeneral();
        
        $C_DesercionCostos->Consola();
        
    }break;
    case 'BuscarPrograma':{
        global $db,$userid,$C_DesercionCostos;
        
        MainGeneral();
        MainJSGeneral();
        
        $C_DesercionCostos->ModalidadDinamica($_POST['Modalida']);
        
    }break;
    case 'BuscarDemografica':{
        global $db,$userid,$C_DesercionCostos;
        
        MainGeneral();
        MainJSGeneral();
        
        $C_DesercionCostos->TablaReporte($_POST['Periodo'],$_POST['Modalida'],$_POST['Carrera_id'],$_POST['TypeEstudiante']);
    }break;
    case 'Reporte':{
        global $db,$userid,$C_DesercionCostos;
        define(AJAX,false);
        define(Titulo,0);
        MainGeneral();
        MainJSGeneral();
        
        $C_DesercionCostos->Reporte();
        
    }break;
    default:{
        global $db,$userid,$C_DesercionCostos;
        
        MainGeneral();
        MainJSGeneral();
        
        $C_DesercionCostos->Display();
        
    }break;
}//switch
function MainGeneral(){
    
    global $db,$userid,$C_DesercionCostos;
    
    //include ('../templates/mainjson.php');
    if(AJAX==false){
    include("../templates/templateObservatorio.php");
    
    if(Titulo==1){
        
        $Titulo = 'Costos De Deserci&oacute;n';
        
    }else{
        $Titulo = 'Reporte Demogr&aacute;fico';
    }
    
    $db =writeHeader($Titulo,true,"Causas Asistencias",1);
    }else{
         include ('../templates/mainjson.php');
    }
    
    include ('DesercionCosto_Class.php');  $C_DesercionCostos = new DesercionCostos();
	
	
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
    <script type="text/javascript" language="javascript" src="Desercion.js"></script> 
    <?PHP
}//MainJSGeneral

?>