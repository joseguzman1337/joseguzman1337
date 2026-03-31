<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

/*session_start();

if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
}*/

switch($_REQUEST['actionID']){
    case 'Excel':{
            define(AJAX,'TRUE'); 
            global $C_Reporte_Bienestar,$userid,$db; 
            MainGeneral();
           // JsGeneral();
            
            $Hora = date('Y-m-d');
            
            header('Content-type: application/vnd.ms-excel');
            header("Content-Disposition: attachment; filename=".$Hora.".xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            
           /* 34923	ubcultura
           34922	ubdeportes
           34884	ubsalud
           36533	ubvoluntariado*/
           
           if($userid==34922){
            $Op = 1;
           }else if($userid==34923){
            $Op = 2;
           }else if($userid==34884){
            $Op = 3;
           }else if($userid==36533){
            $Op = 4;
           }
            
            $C_Reporte_Bienestar->Display($Op,1);
    }break;
    case 'CambiarPeriodo':{
        global $userid,$db;
        MainJson();
        
        //echo '<pre>';print_r($_POST);die;
        /*
        [actionID] => CambiarPeriodo
        [periodo] => 20141
        [Est] => 50146
        [op] => 4
        [Tipo] => 2
        [idBienestar] => 262
        */
        $Periodo      = $_POST['periodo'];
        $Est          = $_POST['Est'];
        $op           = $_POST['op'];
        $Tipo         = $_POST['Tipo'];
        $idBienestar  = $_POST['idBienestar'];
        if($op==1){ 
            /********Deportes************/
            if($Tipo==1){
                //[idBienestar] => 288-613  idBienestar-id_TallerBienstar
                $C_id = explode('-',$idBienestar); 
                
                $SQL_Update='UPDATE talleresBienestarEstudiante
                             
                             SET    periodo_fin="'.$Periodo.'"
                             
                             WHERE  id_bienestar="'.$C_id[0].'" AND codigoestado=100 AND  id_talleresBienestarEstudiante="'.$C_id[1].'" AND tipoTaller=1';
            }else if($Tipo==2){ 
                $SQL_Update='UPDATE bienestar
                             
                             SET
                                    periodofinalseleccion="'.$Periodo.'"
                                    
                             WHERE  
                                    idbienestar="'.$idBienestar.'"  AND  idestudiantegenral="'.$Est.'"  AND codigoestado=100';
            }
           
        }else if($op==2){ 
            /************Talleres*************/
            if($Tipo==1){
                $SQL_Update='UPDATE bienestar
                             
                             SET
                                    periodo_ini_Grup="'.$Periodo.'"
                                    
                             WHERE  
                                    idbienestar="'.$idBienestar.'"  AND  idestudiantegenral="'.$Est.'"  AND codigoestado=100';
            }else if($Tipo==2){
                 $SQL_Update='UPDATE bienestar
                             
                             SET
                                    periodo_fin_Grup="'.$Periodo.'"
                                    
                             WHERE  
                                    idbienestar="'.$idBienestar.'"  AND  idestudiantegenral="'.$Est.'"  AND codigoestado=100';
                
            }else if($Tipo==3){
                $C_id = explode('-',$idBienestar); 
                
                $SQL_Update='UPDATE talleresBienestarEstudiante
                             
                             SET    periodo_fin="'.$Periodo.'"
                             
                             WHERE  id_bienestar="'.$C_id[0].'" AND codigoestado=100 AND  id_talleresBienestarEstudiante="'.$C_id[1].'" AND tipoTaller=2';
            }
           // echo '<pre>';print_r($_POST);die;
        }else if($op==3){ 
            /***********Salud***************/
        }else if($op==4){
            /***********Voluntariado*******************/
            if($Tipo==1){
                $SQL_Update='UPDATE bienestar
                             
                             SET
                                    fechaFinalVoluntareado="'.$Periodo.'"
                                    
                             WHERE  
                                    idbienestar="'.$idBienestar.'"  AND  idestudiantegenral="'.$Est.'"  AND  pertenecevoluntariado=0 AND codigoestado=100';
            }else if($Tipo==2){
                $SQL_Update='UPDATE bienestar
                             SET
                                    periodoFinalApoyoBienestar="'.$Periodo.'"
                                    
                             WHERE  
                                    idbienestar="'.$idBienestar.'"  AND  idestudiantegenral="'.$Est.'"  AND  pertenecegrupapoyo=0 AND codigoestado=100';
                                    
            }else if($Tipo==3){
               $SQL_Update='UPDATE bienestar
                             SET
                                    periodoFinalMonitor="'.$Periodo.'"
                                    
                             WHERE  
                                    idbienestar="'.$idBienestar.'"  AND  idestudiantegenral="'.$Est.'"  AND  monitorbienestar=0 AND codigoestado=100';
            }
           
        }
        
      // echo '$SQL->'.$SQL_Update;die;
            
            if($Update=&$db->Execute($SQL_Update)===false){
                $a_vectt['val']			=false;
                $a_vectt['descrip']		='Error al Cambiar el Periodo final'.$SQL_Update;
                echo json_encode($a_vectt);
                exit;
            }
            
            $a_vectt['val']			=true;
            $a_vectt['descrip']		='Se ha Modificado';
            echo json_encode($a_vectt);
            exit;
    }break;
    case 'IrDisplay':{
       define(AJAX,'FALSE'); 
       global $C_Reporte_Bienestar,$userid,$db; 
       MainGeneral();
       
       $C_Reporte_Bienestar->Display($_POST['Op']);
        
    }break;
    case 'Detalle':{
       define(AJAX,'TRUE'); 
       global $C_Reporte_Bienestar,$userid,$db; 
       MainGeneral();
       
       $Estudiante_id         = $_REQUEST['Estudiante_id'];
       $Op                    = $_REQUEST['Op'];
       
       $C_Reporte_Bienestar->Detalle($Estudiante_id,$Op); 
        
    }break;
    default:{ 
       define(AJAX,'FALSE'); 
       global $C_Reporte_Bienestar,$userid,$db; 
       MainGeneral();
       JsGeneral();
        /* 34923	ubcultura
           34922	ubdeportes
           34884	ubsalud
           36533	ubvoluntariado*/
           
           if($userid==34922){
            $Op = 1;
           }else if($userid==34923){
            $Op = 2;
           }else if($userid==34884){
            $Op = 3;
           }else if($userid==36533){
            $Op = 4;
           }
         
       //echo 'user->'.$userid.'<br>op->'.$Op;
       
       if(!$Op){
        echo '<blink><strong style="color:#F00; font-size:18px">No Tiene Permisos para esta Opci&oacute;n</strong></blink>';
     	exit();
       }
       $C_Reporte_Bienestar->CargarDisplay($Op);
        
    }break;
    
}

function MainGeneral(){
	
	
		global $C_Reporte_Bienestar,$userid,$db;
		$proyectoMonitoreo = "Monitoreo";
	    include("../../templates/template.php");
		
		include('Reporte_Bienestar_class.php');  $C_Reporte_Bienestar = new Reporte_Bienestar();
		
		if(AJAX=='FALSE'){
			
		$db=writeHeader("Reporte Bienestar",true);	
			
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
		
		
		if($Usario_id=&$db->Execute($SQL_User)===false){
						echo 'Error en el SQL Userid...<br>';
						die;
					}
					
	
		$userid=$Usario_id->fields['id'];	
		
		}else if(AJAX=='TRUE'){
			$db=writeHeaderBD();
			
			 $SQL_Num='SELECT 

							numerodocumento
							
							FROM 
							
							estudiantegeneral
							
							WHERE
							
							idestudiantegeneral="'.$_SESSION['MM_Username'].'"';	
							
					if($Nummero=&$db->Execute($SQL_Num)===false){
							echo 'Erroe en El SQl Numero De Documento';
							die;
						}				   
							   
							  
            $userid = $Usario_id->fields['id'];
       
		
		}
	}/*MainGeneral*/	
function MainJson(){
	
	    global $userid,$db;
	    include("../../templates/template.php");
		$db=writeHeaderBD();
	    include_once("./functionsVoluntariado.php");
	    include_once("./functionsSalud.php");
		
		#echo '<pre>';print_r($_SESSION);		

					$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
		
		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>';
				die;
			}

				
		
            $userid = $Usario_id->fields['id'];
        
		 
	}
function JsGeneral(){
    ?>
    <script type="text/javascript" language="javascript" src="Reporte_Bienestar.js"></script>
    <script>
    function Fecha(id){ 
        $( "#"+id ).datepicker({
            changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
        });
     } 
    </script>
    <?PHP
}    

?>