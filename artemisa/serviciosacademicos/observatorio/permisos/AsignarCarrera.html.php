<?PHP
session_start();
switch($_REQUEST['actionID']){
    case 'EliminarAsignacion':{
        global $db,$userid;
        
        MainJson();
        $SQL='UPDATE  Obs_AsignarCarrera
              
              SET     useridestado="'.$userid.'",
                      codigoestado=200,
                      CodigoPeriodoFinal="'.$_GET['codigoperiodo'].'" 
              WHERE   id_AsignarCarrera="'.$_GET['id'].'" AND codigoestado=100';
              
             if($UPDATE=$db->Execute($SQL)===false){
                $a_vectt['val']			='FALSE';
                $a_vectt['descrip']		='Error en el SQL de UPDATE... '.$SQL;
                echo json_encode($a_vectt);
                exit; 
            }
            
        $a_vectt['val']			='TRUE';
        $a_vectt['descrip']		='Se ha Eliminado la Asignacion.';
        echo json_encode($a_vectt);
        exit;   
    }break;
    case 'BuscarDataASigancion':{
        global $db,$userid,$C_Asignar;
        define(AJAX,true);
        
        MainGeneral();
        
        $Periodo        = $C_Asignar->Periodo();
        $id_Docente     = $_GET['id_Docente'];
        
        $C_Asignar->BuscarData($id_Docente,$Periodo);
    }break;
    case 'SaveDocenteCarrera':{
        global $db,$userid,$C_Asignar;
        define(AJAX,true);
        
        MainGeneral();
        
        $Periodo        = $C_Asignar->Periodo();
        
        $id_Docente     = $_GET['id_Docente'];
        $id_Carrera     = $_GET['id_Carrera'];
        
        
        $SQL_V='SELECT
                
                id_AsignarCarrera
                
                FROM
                
                Obs_AsignarCarrera
                
                WHERE
                
                id_Docente="'.$id_Docente.'"
                AND
                id_Carrera="'.$id_Carrera.'"
                AND
                codigoperiodo<="'.$Periodo.'"
                AND
                (CodigoPeriodoFinal>="'.$Periodo.'" OR CodigoPeriodoFinal IS NULL)
                AND 
                codigoestado=100';
                
                if($Valida=&$db->Execute($SQL_V)===false){
                    $a_vectt['val']			='FALSE';
                    $a_vectt['descrip']		='Error en el SQL de $SQL_V... '.$SQL_V;
                    echo json_encode($a_vectt);
                    exit;
                }
                
            if(!$Valida->EOF){
                
                $a_vectt['val']			='TRUE';
                $a_vectt['descrip']		='El Docente ya Tiene la Carrera Asignada.';
                echo json_encode($a_vectt);
                exit; 
                
            }    
        
        $SQL_Insert='INSERT INTO Obs_AsignarCarrera(id_Docente,id_Carrera,codigoperiodo,entrydate,userid)VALUES("'.$id_Docente.'","'.$id_Carrera.'","'.$Periodo.'",NOW(),"'.$userid.'")';
        
            if($Insert=$db->Execute($SQL_Insert)===false){
                $a_vectt['val']			='FALSE';
                $a_vectt['descrip']		='Error en el SQL de Insert... '.$SQL_Insert;
                echo json_encode($a_vectt);
                exit; 
            }
            
        $a_vectt['val']			='TRUE';
        $a_vectt['descrip']		='Se ha Asignado la Carrera Corectamente.';
        echo json_encode($a_vectt);
        exit;    
        
    }break;
    case 'AutocompleteDocente':{
        global $db,$userid;
        
        MainJson();
        
        $Letra   		= $_REQUEST['term'];
        
           $SQL_Buscar='SELECT 
                        
                        u.nombres,
                        u.apellidos,
                        u.numerodocumento,
                        u.idusuario,
                        d.iddocente
                        
                        FROM docente d INNER JOIN usuario u ON d.numerodocumento=u.numerodocumento
                        							 
                        WHERE 
                        
                        (u.numerodocumento LIKE "%'.$Letra.'%"
                        OR
                        u.usuario LIKE "%'.$Letra.'%"
                        OR
                        u.apellidos LIKE "%'.$Letra.'%"
                        OR
                        u.nombres LIKE "%'.$Letra.'%")
                        AND
                        u.codigorol=2
                        AND
                        u.codigotipousuario LIKE "50%"';
                                    
                        if($ResultUsuario=&$db->Execute($SQL_Buscar)===false){
                            $a_vectt['val']			='FALSE';
                            $a_vectt['descrip']		='Error en el SQL de Busqueda de Usuarios... '.$SQL_Buscar;
                            echo json_encode($a_vectt);
                            exit; 
                        } 
                        
                        $Result = array();
                        
                        while(!$ResultUsuario->EOF){
                            /************************************/
                              $C_Result['label']                 = $ResultUsuario->fields['nombres'].' '.$ResultUsuario->fields['apellidos'].' :: '.$ResultUsuario->fields['numerodocumento'];
						      $C_Result['value']                 = $ResultUsuario->fields['nombres'].' '.$ResultUsuario->fields['apellidos'].' :: '.$ResultUsuario->fields['numerodocumento'];
                              $C_Result['id_iddocente']            = $ResultUsuario->fields['iddocente'];
                              array_push($Result,$C_Result);
                            /************************************/
                            $ResultUsuario->MoveNext();
                        }//while  
                        
             	echo json_encode($Result);        
    }break;
    default:{
        global $db,$userid,$C_Asignar;
        define(AJAX,false);
        
        MainGeneral();
        MainJSGeneral();
        
        $C_Asignar->Principal();
    }break;
}
function MainGeneral(){
    global $db,$userid,$C_Asignar;
    
    include_once ('AsignarCarrera.class.php');
    
    $C_Asignar = new AsignarCarrera();
    
    if(AJAX==false){
        
    include("../templates/templateObservatorio.php");
    
     $db =writeHeader('Asignar Carrera Docentes',true,"Asignar",1);
    
    }else{
        
        include ('../templates/mainjson.php');
        
    }
    
   	$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
	
	if($Usario_id=&$db->Execute($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>';
		die;
	}
	
	$userid=$Usario_id->fields['id'];
    
}//function MainGeneral
function MainJson(){
	
	global $db,$userid;
	
	include ('../templates/mainjson.php');
	
	
	$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
	
	if($Usario_id=&$db->Execute($SQL_User)===false){
		echo 'Error en el SQL Userid...<br>';
		die;
	}
	
	$userid=$Usario_id->fields['id'];
	
}//function MainJson
function MainJSGeneral(){
    ?>
    <script type="text/javascript" language="javascript" src="Consola_Permisos.js?v=2"></script> 
    <?PHP
}//MainJSGeneral
?>