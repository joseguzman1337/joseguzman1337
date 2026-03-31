<?php
session_start();
/*if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} */
switch($_REQUEST['actionID']){
   case 'DetallePoblacion':{
    global $db,$userid,$C_Desercion,$C_DetalleDesercion;
        define(AJAX,false);
        define(Titulo,6);
        MainGeneral();
        MainJSGeneral();
        
        $codigocarrera = $_REQUEST['codigocarrera'];
        $periodo       = $_REQUEST['periodo'];
        $tipo          = $_REQUEST['tipo'];
        $op            = $_REQUEST['op'];
		
        include_once('DesercionDetalle_Class.php'); $C_DetalleDesercion = new DetalleDesercion();
        
		//$periodo2 = $C_DetalleDesercion->PeriodoAnterior($periodo);
		
        $C_Datos        = $C_Desercion->CausasDesercion($periodo,$codigocarrera,'1');
        
        //echo '<pre>';print_r($C_Datos);
        
        $C_DetalleDesercion->Display($codigocarrera,$periodo,$C_Datos,$tipo,$op);
        
   }break;
   case 'EstratoSemestral':{
    global $db,$userid,$C_Desercion;
        define(AJAX,false);
        define(Titulo,5);
        MainGeneral();
        MainJSGeneral();
        
        
        $C_Desercion->DisplaySocioEconomicoSemestral();   
   }break; 
   case 'InfoTabla':{
        global $db,$userid,$C_Desercion;
        define(AJAX,true);
        MainGeneral();
        MainJSGeneral();
        
        $C_Desercion->InfoTabla();
        
        
   }break; 
   case 'SaveData':{
        global $db,$userid;
        
        MainJson();
        
        
        $Periodo        = $_POST['Periodo'];
        $Valor          = $_POST['Valor'];
        $Typo           = $_POST['Typo'];
        
          $SQL='SELECT 
                
                id_datosNacionales
                
                FROM 
                
                DatosNacionales
                
                WHERE
                
                tipo="'.$Typo.'"
                AND
                periodo="'.$Periodo.'"
                AND
                codigoestado=100';
                
                if($Existe=&$db->Execute($SQL)===false){
                    echo 'Error en el SQL de Verificacion...<br>'.$SQL;
                    die;
                }
        if($Existe->EOF){
            
            $Insert='INSERT INTO DatosNacionales(tipo,valor,periodo,entrydate,userid)VALUES("'.$Typo.'","'.$Valor.'","'.$Periodo.'",NOW(),"'.$userid.'")';
            
            if($DataInsert=&$db->Execute($Insert)===false){
                $a_vectt['val']			='FALSE';
                $a_vectt['descrip']		='Error en El INSERR ... '.$Insert;
                echo json_encode($a_vectt);
                exit;
            }
            
        }else{
            
            $a_vectt['val']			='EXISTE';
            $a_vectt['descrip']		='Ya Existe Informacion con Relacion a ese tipo de dato y ese periodo.';
            echo json_encode($a_vectt);
            exit;
            
        }//if
        
        
        $a_vectt['val']			='TRUE';
        $a_vectt['descrip']		='Se ha Registrado Correctamente.';
        echo json_encode($a_vectt);
        exit;
        
   }break; 
   case 'Data':{
        global $db,$userid,$C_Desercion;
        define(AJAX,false);
        define(Titulo,4);
        MainGeneral();
        MainJSGeneral();
        
        
        $C_Desercion->TablaData();         
    
   }break;  
   case 'Cohorte':{
        global $db,$userid,$C_Desercion;
        define(AJAX,true);
        MainGeneral();
        MainJSGeneral();
        
        $C_Desercion->DisplayCohorte();
   }break; 
   case 'Fromularios':{
        global $db,$userid,$C_Desercion;
        define(AJAX,false);
        define(Titulo,1);
        MainGeneral();
        MainJSGeneral();
        
        
        $C_Desercion->Formularios();         
    
   }break; 
   case 'Retencion':{
        global $db,$userid,$C_Desercion;
        define(AJAX,false);
        define(Titulo,3);
        MainGeneral();
        MainJSGeneral();
        
        
        $C_Desercion->Retencion();         
   }break;  
   case 'BuscarInfo2':{
        global $db,$userid,$C_Desercion;
        define(AJAX,true);
        MainGeneral();
        /*
        0=Semestral
        1=Anual
        2=Cohorte
		3 =semestral en caliente
        */
        if($_POST['TypeDesercion']==0 || $_POST['TypeDesercion']=='0'){
            $C_Desercion->RetencionSemestral($_POST['Periodo']);
        }else if($_POST['TypeDesercion']==1 || $_POST['TypeDesercion']=='1'){
			$C_Desercion->DisplayAnual($_POST['Periodo'],2);
        }else if($_POST['TypeDesercion']==2 || $_POST['TypeDesercion']=='2'){
            $C_Desercion->DisplayCohorte($_POST['Periodo'],2);
        }else if($_POST['TypeDesercion']==3 || $_POST['TypeDesercion']=='3'){
            //$C_Desercion->DisplaySemestral($_POST['Periodo'],$_POST['TypeModalidad'],$_POST['TypePrograma']);
        }

   }break;  
   case 'BuscarInfo':{
        global $db,$userid,$C_Desercion;
        define(AJAX,true);
        MainGeneral();
        /*
        0=Semestral
        1=Anual
        2=Cohorte
		3 =semestral en caliente
        */
        if($_POST['TypeDesercion']==0 || $_POST['TypeDesercion']=='0'){
            $C_Desercion->Display($_POST['Periodo'],1);
        }else if($_POST['TypeDesercion']==1 || $_POST['TypeDesercion']=='1'){
            $C_Desercion->DisplayAnual($_POST['Periodo'],1);
        }else if($_POST['TypeDesercion']==2 || $_POST['TypeDesercion']=='2'){
            $C_Desercion->DisplayCohorte($_POST['Periodo'],1);
        }else if($_POST['TypeDesercion']==3 || $_POST['TypeDesercion']=='3'){
            $C_Desercion->DisplaySemestral($_POST['Periodo'],$_POST['TypeModalidad'],$_POST['TypePrograma']);
        }

   }break; 
   case 'Semestral':{
        global $db,$userid,$C_Desercion;
        
        MainJson();
        
        $C_Desercion->Display($_POST['CodigoPeriodo']);         
   }break;
   case 'Consola':{
        global $db,$userid,$C_Desercion;
        define(AJAX,false);
        define(Titulo,2);
        MainGeneral();
        MainJSGeneral();
        
        
        $C_Desercion->Consola();         
   }break;        
}
function MainGeneral(){
    
    global $db,$userid,$C_Desercion;
    
    //include ('../templates/mainjson.php');
    if(AJAX==false){
    include("../templates/templateObservatorio.php");
    if(Titulo==1){
        $Titulo = 'Gr&aacute;ficas <br> UEB vs Nacional';
    }else if(Titulo==2){
       $Titulo = 'Deserci&oacute;n'; 
    }else if(Titulo==3){
        $Titulo = 'Permanencia'; 
    }else if(Titulo==4){
        $Titulo = 'Estad&iacute;sticas Nacionales'; 
    }else if(Titulo==5){
        $Titulo = 'Deserci&oacute;n Socio-Economica'; 
    }else if(Titulo==6){
        $Titulo = 'Detalle Deserci&oacute;n'; 
    }
    
    
    $db =writeHeader($Titulo,true,"Desercion",1);
    }else{
         include ('../templates/mainjson.php');
    }
    
    include ('Desercion_class.php');  $C_Desercion = new Desercion();
	
	
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
    <script type="text/javascript" language="javascript" src="Desercion.js?v=5"></script> 
    <?PHP
}//MainJSGeneral
?>