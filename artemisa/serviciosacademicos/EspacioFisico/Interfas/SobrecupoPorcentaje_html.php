<?php
session_start();
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
}
        
       
//echo '<pre>';print_r($_REQUEST['actionID']);
switch($_REQUEST['actionID']){
    case 'AprobarSobrecupo':{
        global $db,$userid;
        MainJson();
        
        $id  = $_POST['id'];
        
        $Update='UPDATE SobreCupoClasificacionEspacios
                 SET    EstadoAprobacion=1,
                        FechaUltimaModificacion=NOW(),
                        UsuarioUltimaModificacion="'.$userid.'"
                 WHERE  SobreCupoClasificacionEspacioId="'.$id.'" AND codigoestado=100';
                 
              if($Cambio=&$db->Execute($Update)===false){
                $a_vectt['val']			=false;
                $a_vectt['descrip']		='Error al Aprobar el Sobrecupo....<br><br>'.$Update;
                echo json_encode($a_vectt);
                exit;
              }   
              
            $a_vectt['val']			=true;
            $a_vectt['descrip']		='Se ha Aprobado Correctamente el Sobrecupo...';
            echo json_encode($a_vectt);
            exit;
    }break;
    case 'ConsolaSobrecupo':{
        global $db,$C_SobrecupoPorcentaje,$userid;
       
        define(AJAX,false);
        MainGeneral();
        JsGeneral();
        $id  =  str_replace('row_','',$_REQUEST['id']);
        
        $C_SobrecupoPorcentaje->VerSolicitudSobrecupo($db,$id);
    }break;
    case 'SaveHora':{
        global $db,$userid;
        MainJson();
        
        $Periodo  = $_POST['Periodo'];
        $Sede     = $_POST['Sede'];
        $Hora_ini = $_POST['Hora_ini'];
        $Hora_fin = $_POST['Hora_fin'];
        
        /******************************************************/
        $C_Horaini = explode(' ',$Hora_ini);//Dessarmar la Hora Inicial
        //echo '<pre>';print_r($C_Horaini);die;
        if($C_Horaini[1]=='AM' || $C_Horaini[1]=='am' || $C_Horaini[1]=='A.M.' || $C_Horaini[1]=='a.m.'){
            $Horaini = $C_Horaini[0];
        }else{
            $H_inicial = explode(':',$C_Horaini[0]);
            
            if($C_Horaini[1]=='PM' || $C_Horaini[1]=='pm' || $C_Horaini[1]=='P.M.' || $C_Horaini[1]=='p.m.'){
                if($H_inicial[0]==12){
                    $Horaini = $H_inicial[0].':'.$H_inicial[1];
                }else{
                    $C_DHora_2 = explode(':',$H_inicial[0]);
                    $H = $C_DHora_2[0]+12;
                    $Horaini = $H.':'.$C_DHora_2[1];
                }
            }
        }//if hora Inicial
        
        $C_Horafin = explode(' ',$Hora_fin);//Dessarmar la Hora final
        
        if($C_Horafin[1]=='AM' || $C_Horafin[1]=='am' || $C_Horafin[1]=='A.M.' || $C_Horafin[1]=='a.m.'){ 
            $Horafin = $C_Horafin[0];
        }else{ 
           
           if($C_Horafin[1]=='PM' || $C_Horafin[1]=='pm' || $C_Horafin[1]=='P.M.' || $C_Horafin[1]=='p.m.'){ 
                if($C_Horafin[0]==12){ 
                    $Horafin = $C_Horafin[0].' '.$C_Horafin[1];
                }else{ 
                    $C_DHora = explode(':',$C_Horafin[0]);
                    $H = $C_DHora[0]+12;
                    $Horafin = $H.':'.$C_DHora[1];
                }
            }
        }//if hora final
        /******************************************************/
        $SQL='INSERT INTO HorasInactivas(codigoperiodo,ClasificacionEspacioId,HoraInicial,HoraFinal,FechaCreacion,UsuarioCreacion,FechaUltimaModificacion,UsuarioUltimaModificacion)VALUES("'.$Periodo.'","'.$Sede.'","'.$Horaini.'","'.$Horafin.'",NOW(),"'.$userid.'",NOW(),"'.$userid.'")';
        
        if($Insert=&$db->Execute($SQL)===false){
            $a_vectt['val']			=false;
            $a_vectt['descrip']		='Error al Insertar....<br><br>'.$SQL;
            echo json_encode($a_vectt);
            exit;
        }
        
        $a_vectt['val']			=true;
        $a_vectt['descrip']		='Se ha Registrado Correctamente...';
        echo json_encode($a_vectt);
        exit;
    }break;
    case 'SavePorcentaje':{
        global $db,$userid;
        MainJson();
        
        $Num     = $_POST['Num'];
        $Periodo = $_POST['Periodo'];
        
        $SQL='INSERT INTO PorcentajeEspacio(Porcentaje,codigoperiodo,FechaCreacion,UsuarioCreacion,FechaUltimaModificacion,UsuarioUltimaModificacion)VALUES("'.$Num.'","'.$Periodo.'",NOW(),"'.$userid.'",NOW(),"'.$userid.'")';
        
        if($Insert=&$db->Execute($SQL)===false){
            $a_vectt['val']			=false;
            $a_vectt['descrip']		='Error al Insertar....<br><br>'.$SQL;
            echo json_encode($a_vectt);
            exit;
        }
        
        $a_vectt['val']			=true;
        $a_vectt['descrip']		='Se ha Registrado Correctamente...';
        echo json_encode($a_vectt);
        exit;
        
    }break;
    default:{
        global $db,$C_SobrecupoPorcentaje,$userid;
       
        define(AJAX,false);
        MainGeneral();
        JsGeneral();
        include_once('../../mgi/Menu.class.php');  $C_Menu_Global  = new Menu_Global();
        include('InterfazSolicitud_class.php');  $C_InterfazSolicitud = new InterfazSolicitud();
       
       $Data = $C_InterfazSolicitud->UsuarioMenu($db,$userid);
        
       //echo '<pre>';print_r($Data);die;
        
        if($Data['val']==true){
            for($i=0;$i<count($Data['Data']);$i++){
                /**********************************************/
                $URL[] = $Data['Data'][$i]['Url'];
                
                $Nombre[] = $Data['Data'][$i]['Nombre'];
                
                if($Data['Data'][$i]['Url']=='SobrecupoPorcentaje_html.php'){
                    $Active[] = '1'; 
                }else{
                    $Active[] = '0'; 
                }
                /**********************************************/
            }//for
        }else{
            echo $Data['Data'];die; 
        }//if
        
        $C_Menu_Global->writeMenu($URL,$Nombre,$Active,true);
        
        $RolEspacioFisico   = $Data['Data'][0]['RolEspacioFisicoId']; 
        
        $C_SobrecupoPorcentaje->Display($db,$RolEspacioFisico);
      
    }break;
}
function MainGeneral(){

		
		global $C_SobrecupoPorcentaje,$userid,$db;
		
		//var_dump(is_file("templates/template.php"));die;
        include("../templates/template.php"); 	
        
        if(AJAX==false){  
            $db = writeHeader('Interfaz Sobrecupo y Porcentaje',true);
        }else{
            $db = getBD();
        }
	
		include('SobrecupoPorcentaje_class.php');  $C_SobrecupoPorcentaje = new SobrecupoPorcentaje();
	
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
    <script type="text/javascript" language="javascript" src="../js/jquery.bpopup.min.js"></script>
    <script type="text/javascript" language="javascript" src="../js/jquery.clockpick.1.2.9.js"></script>
    <script type="text/javascript" language="javascript" src="../js/jquery.clockpick.1.2.9.min.js"></script>
    <script type="text/javascript" language="javascript" src="SobrecupoPorcentaje.js"></script>
    <?PHP
} 
?>