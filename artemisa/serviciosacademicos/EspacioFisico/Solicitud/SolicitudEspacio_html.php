<?php 
session_start();
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
}



switch($_REQUEST['actionID']){
    
    
    case 'SaveSolicitud':{
        global $db,$userid;
        MainJson();
        
        echo '<pre>';print_r($_POST);die;
        /*
        [actionID] => SaveSolicitud
        [Modalidad] => 200
        [Programa] => 5
        [Materia] => 718
        [Grupo] => 71198
        [NumEstudiantes] => 41
        [Acceso] => on
        [Campus] => 4
        [FechaIni] => 2014-01-27
        [FechaFin] => 2014-07-04
        [FrecuenciaOnline] => 35
        [Frecuencia] => 35
        [DiasOnline] => ::1::4
        [numIndices] => 0
        [Observacion] => Prueba de Observacion
        */
        /************************************************************/
        if($_POST['Acceso']=='on'){
            $Acceso   = 1;    
        }else{
            $Acceso   = 0;
        }
        
        $Frecuencia   = $_POST['Frecuencia'];
        
        /************************************************************/
          $SQL='SELECT 

                id_temp, 
                id_tiposalon,
                DATE (fecha_ini) AS fecha_ini,
                DATE (fecha_fin) AS fecha_fin,
                `start`,
                `end`,
                sede,
                codigodia,
                TIME(fecha_ini) AS h_inicial,
                TIME(fecha_fin) AS h_final
                
                FROM temp_solicitud 
                
                WHERE codigoestado=100 AND `status`=0 AND usuario="'.$userid.'"';
                
                if($Consulta=&$db->Execute($SQL)===false){
                    $a_vectt['val']			=false;
                    $a_vectt['descrip']		='Error al Buscar..';
                    echo json_encode($a_vectt);
                    exit;
                }
        
        $Result = $Consulta->GetArray();
        
        
        
        for($i=0;$i<count($Result);$i++){
            
            $SQL_Insert='INSERT INTO SolicitudAsignacionEspacios(codigotiposalon,AccesoDiscapacitados,FechaInicio,FechaFinal,idsiq_periodicidad,ClasificacionEspaciosId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaUltimaModificacion,HoraInicio,HoraFin,codigodia)VALUES("'.$Result[$i]['id_tiposalon'].'","'.$Acceso.'","'.$Result[$i]['fecha_ini'].'","'.$Result[$i]['fecha_fin'].'","'.$Frecuencia.'","'.$Result[$i]['sede'].'","'.$userid.'","'.$userid.'",NOW(),NOW(),"'.$Result[$i]['h_inicial'].'","'.$Result[$i]['h_final'].'","'.$Result[$i]['codigodia'].'")';    
            
            if($SaveSolicitud=&$db->Execute($SQL_Insert)===false){
                $a_vectt['val']			=false;
                $a_vectt['descrip']		='Error al Insertar Solicitud..';
                echo json_encode($a_vectt);
                exit;
            }
            
        }//for
    }break;
    case 'EditarSolicitudEvento':{
        global $db,$userid;
        MainJson();
        /*
    [Temp_id] => 4
    [TipoSalon] => 01
    [F_inicial] => 2014-06-23
    [F_final] => 2014-06-23
    [H_inicial] => 10:00:00
    [H_final] => 11:00:00
        */
        $id           = $_POST['Temp_id'];
        $TipoSalon    = $_POST['TipoSalon'];
        
        $Update='UPDATE temp_solicitud
                 SET    id_tiposalon="'.$TipoSalon.'"
                 WHERE  id_temp="'.$id.'" AND codigoestado=100';
                 
        if($Modificar=&$db->Execute($Update)===false){
            $a_vectt['val']			=false;
            $a_vectt['descrip']		='Error al Asignar el Tipo Salon...';
            echo json_encode($a_vectt);
            exit;
        }  
        
        $a_vectt['val']			=true;
        $a_vectt['descrip']		='Se ha Asignado Correctamente el tipo de salon.';
        echo json_encode($a_vectt);
        exit;  
        
        //ViewFechas     
    }break;
    case 'EditarEvento':{
        global $C_SolicitudEspacio,$userid,$db;
        
        define(AJAX,false);
        MainGeneral();
        JsGeneral();
        
        $id  = $_GET['id'];
       
       $C_SolicitudEspacio->EditarEvento($id);
       
    }break;
    case 'AddTr':{
        global $C_SolicitudEspacio,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        
        $C_SolicitudEspacio->AddTrNew($_POST['NumFiles']);
    }break;
    case 'VerCalenadario':{
        global $C_SolicitudEspacio,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        //JsGeneral();
       
        $Result = $C_SolicitudEspacio->CalcularFechas($_POST);
        
        $a_vectt['val']			=true;
        $a_vectt['Dato']		=$Result;
        echo json_encode($a_vectt);
        exit;
    }break;
    case 'Cupo':{
        global $userid,$db;
        MainJson();
        
        $SQL='SELECT
                
                g.idgrupo,
                g.maximogrupo AS Cupo
                
              FROM
                
                grupo g
                
              WHERE
                
                g.idgrupo="'.$_POST['Grupo'].'"';
                
            if($Cupo=&$db->Execute($SQL)===false){
                $a_vectt['val']			=false;
                $a_vectt['descrip']		='Error en El SQL ... <br><br>'.$SQL;
                echo json_encode($a_vectt);
                exit;  
            }   
            
            if(!$Cupo->EOF){
                $a_vectt['val']			=true;
                $a_vectt['Cupo']		=$Cupo->fields['Cupo'];
                echo json_encode($a_vectt);
                exit; 
            }else{
                $a_vectt['val']			=true;
                $a_vectt['Cupo']		='';
                echo json_encode($a_vectt);
                exit;
            } 
    }break;
    case 'Grupo':{
        global $C_SolicitudEspacio,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        //JsGeneral();
        
        $C_SolicitudEspacio->Grupo($_POST['Programa'],$_POST['Materia']);
    }break;
    case 'Materia':{
        global $C_SolicitudEspacio,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        //JsGeneral();

        $C_SolicitudEspacio->Materia($_POST['Programa']);
    }break;
    case 'Programa':{
        global $C_SolicitudEspacio,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        //JsGeneral();
        
        $C_SolicitudEspacio->Programa($_POST['Modalidad']);
    }break;
    default:{
        global $C_SolicitudEspacio,$userid,$db;
        
        define(AJAX,false);
        MainGeneral();
        JsGeneral();
        //echo '<pre>';print_r($_SESSION);
        $C_SolicitudEspacio->Principal();
    }break;
}
function MainGeneral(){
	
		
		global $C_SolicitudEspacio,$userid,$db;
		
		//var_dump(is_file("templates/template.php"));die;
        include("../templates/template.php"); 
        
        if(AJAX==false){
            $db = writeHeader('Solicitud Espacio F&iacute;sico',true);
        }else{
            $db = getBD();
        }
	 
		include('SolicitudEspacio_class.php');  $C_SolicitudEspacio = new SolicitudEspacio();
	
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
    <script type="text/javascript" language="javascript" src="SolicitudEspacio.js"></script>
    <script type="text/javascript" language="javascript" src="../js/jquery.clockpick.1.2.9.js"></script>
    <script type="text/javascript" language="javascript" src="../js/jquery.clockpick.1.2.9.min.js"></script>
    <script type="text/javascript" language="javascript" src="../js/jquery.bpopup.min.js"></script>
   
    <script>
     $('#ui-datepicker-div').css('display','none');
     $('#BBIT_DP_CONTAINER').css('display','none');
    
    
    </script>
    <?PHP
}    
?>