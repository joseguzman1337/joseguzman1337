<?php
session_start();
/*if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} */
switch($_REQUEST['actionID']){
    case 'ViewPrerenciasRestricion':{
        global $C_DisenoEspacioFisico,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        
        $C_DisenoEspacioFisico->ViewExpecionesRestriciones($_POST['id']);
    }break;
    case 'CambiarStado':{
        global $db,$userid;
        
        MainJson();
        
        //id,stado
        
        $SQL_Up='UPDATE   PrioridadesRestricciones
                
                 SET      codigoestado="'.$_POST['stado'].'",
                          UsuarioUltimaModificacion="'.$userid.'",
                          FechaUltimaModificacion=NOW()
                 
                 WHERE    PrioridadesRestriccionesId="'.$_POST['id'].'"';
                 
                 if($CambioStatus=&$db->Execute($SQL_Up)===false){
                        $a_vectt['val']			=false;
                        $a_vectt['descrip']		='Error en la Modificacion del Stado Exepcion... <br><br>'.$SQL_Up;
                        echo json_encode($a_vectt);
                        exit;
                 }
                 
            $a_vectt['val']			=true;
            $a_vectt['descrip']		='Se ha Modificacdo el Estado Correctamente.';
            echo json_encode($a_vectt);
            exit; 
    }break;
    case 'CambiarStatus':{
        global $db,$userid;
        
        MainJson();
        
        //id,status
        
        $SQL_Up='UPDATE   PrioridadesRestricciones
                
                 SET      Estatus="'.$_POST['status'].'",
                          codigoestado=100,
                          UsuarioUltimaModificacion="'.$userid.'",
                          FechaUltimaModificacion=NOW()
                 
                 WHERE    PrioridadesRestriccionesId="'.$_POST['id'].'"';
                 
                 if($CambioStatus=&$db->Execute($SQL_Up)===false){
                        $a_vectt['val']			=false;
                        $a_vectt['descrip']		='Error en la Modificacion del Status Exepcion... <br><br>'.$SQL_Up;
                        echo json_encode($a_vectt);
                        exit;
                 }
                 
            $a_vectt['val']			=true;
            $a_vectt['descrip']		='Se ha Modificacdo el Estatus Correctamente.';
            echo json_encode($a_vectt);
            exit;      
        
    }break;
    case 'Exepciones':{
        global $db,$userid;
        
        MainJson();
        
        /*codigocarrera,id:id,status*/
        
        $Modalidad = $_POST['Modalidad'];
        
        if($_POST['codigocarrera']==1){
             $SQL='SELECT 

                    codigocarrera AS id,
                    nombrecarrera AS Nombre 
                    
                    FROM carrera
                    
                    WHERE
                    
                    codigomodalidadacademica="'.$Modalidad.'" AND codigocarrera NOT IN ("1","2")
                    
                    ORDER BY  nombrecarrera ASC';
                    
              if($Carreras=&$db->Execute($SQL)===false){
                    $a_vectt['val']			=false;
                    $a_vectt['descrip']		='Error en Buscar Todas las Carreras... <br><br>'.$SQL;
                    echo json_encode($a_vectt);
                    exit;
              }  
              
              $C_carreras = $Carreras->GetArray();
              
              for($i=0;$i<count($C_carreras);$i++){
                
              
                    $SQL='SELECT 

                          p.codigocarrera
                            
                          FROM PrioridadesRestricciones p INNER JOIN PrioridadesRestriccionesEspaciosFisicos pf ON p.PrioridadesRestriccionesId=pf.PrioridadesRestriccionesId 
                            																
                          AND pf.ClasificacionEspaciosId="'.$_POST['id'].'" AND p.codigocarrera="'.$C_carreras[$i]['id'].'"';
                          
                          if($Valida=&$db->Execute($SQL)===false){
                                $a_vectt['val']			=false;
                                $a_vectt['descrip']		='Error en El Validar Exepcion... <br><br>'.$SQL;
                                echo json_encode($a_vectt);
                                exit;
                          }
                    
                    if($Valida->EOF){
                    
                                $SQL_insert='INSERT INTO PrioridadesRestricciones(codigocarrera,Estatus,codigoestado,UsuarioCreacion,FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion)VALUES("'.$C_carreras[$i]['id'].'","'.$_POST['status'].'",100,"'.$userid.'",NOW(),"'.$userid.'",NOW())';
                                
                                if($NewExepcion=&$db->Execute($SQL_insert)===false){
                                    $a_vectt['val']			=false;
                                    $a_vectt['descrip']		='Error en El Insert Exepcion... <br><br>'.$SQL_insert;
                                    echo json_encode($a_vectt);
                                    exit;
                                }
                                /***************************/
                                $Last_id = $db->Insert_ID();
                                /***************************/
                                
                                $SQL_Relacion='INSERT INTO PrioridadesRestriccionesEspaciosFisicos(PrioridadesRestriccionesId,ClasificacionEspaciosId)VALUES("'.$Last_id.'","'.$_POST['id'].'")';
                                
                                if($RelacionNew=&$db->Execute($SQL_Relacion)===false){
                                    $a_vectt['val']			=false;
                                    $a_vectt['descrip']		='Error en El Insert Relacion... <br><br>'.$SQL_Relacion;
                                    echo json_encode($a_vectt);
                                    exit;
                                }
                    }    
              }//for
              
                $a_vectt['val']			=true;
                $a_vectt['descrip']		='Se Ha Alamceno Correctamente';
                echo json_encode($a_vectt);
                exit;
        }else{
        
            $SQL='SELECT 
    
                  p.codigocarrera
                    
                  FROM PrioridadesRestricciones p INNER JOIN PrioridadesRestriccionesEspaciosFisicos pf ON p.PrioridadesRestriccionesId=pf.PrioridadesRestriccionesId 
                    																
                  AND pf.ClasificacionEspaciosId="'.$_POST['id'].'" AND p.codigocarrera="'.$_POST['codigocarrera'].'"';
                  
                  if($Valida=&$db->Execute($SQL)===false){
                        $a_vectt['val']			=false;
                        $a_vectt['descrip']		='Error en El Validar Exepcion... <br><br>'.$SQL;
                        echo json_encode($a_vectt);
                        exit;
                  }
            
            if($Valida->EOF){
            
            $SQL_insert='INSERT INTO PrioridadesRestricciones(codigocarrera,Estatus,codigoestado,UsuarioCreacion,FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion)VALUES("'.$_POST['codigocarrera'].'","'.$_POST['status'].'",100,"'.$userid.'",NOW(),"'.$userid.'",NOW())';
            
            if($NewExepcion=&$db->Execute($SQL_insert)===false){
                $a_vectt['val']			=false;
                $a_vectt['descrip']		='Error en El Insert Exepcion... <br><br>'.$SQL_insert;
                echo json_encode($a_vectt);
                exit;
            }
            /***************************/
            $Last_id = $db->Insert_ID();
            /***************************/
            
            $SQL_Relacion='INSERT INTO PrioridadesRestriccionesEspaciosFisicos(PrioridadesRestriccionesId,ClasificacionEspaciosId)VALUES("'.$Last_id.'","'.$_POST['id'].'")';
            
            if($RelacionNew=&$db->Execute($SQL_Relacion)===false){
                $a_vectt['val']			=false;
                $a_vectt['descrip']		='Error en El Insert Relacion... <br><br>'.$SQL_Relacion;
                echo json_encode($a_vectt);
                exit;
            }
            
            $a_vectt['val']			=true;
            $a_vectt['descrip']		='Se Ha Alamceno Correctamente';
            echo json_encode($a_vectt);
            exit;
            }else{
                    $a_vectt['val']			=false;
                    $a_vectt['descrip']		='Se Ha Encontrado Un registro Ya Relacionado';
                    echo json_encode($a_vectt);
                    exit;
            }
       } 
    }break;
    case 'Update':{ 
       
       /*
            [actionID] => Update
            [id_Registro] => 19
            [PadreId] => 5
            [Campus] => 4
            [Edificio] => 6
            [newEspacio] => M306
            [Descrip] => 
            [Dirrecion] => 
            [Acceso] => on
            [T_salon] => 02
            [Capacidad] => 20
            [FechaIni] => 2014-06-01
            [FechaFin] => 2014-06-30
       */
        global $db,$userid;
          
        MainJson();
        
        if($_POST['Acceso']=='on'){
            $Acceso = 1;
        }else{
            $Acceso = 0;
        }
        
        if($_POST['PadreId']==3){
            $Padre_id = '1';
        }else if($_POST['PadreId']==4){
            $Padre_id = $_POST['Campus'];
        }else if($_POST['PadreId']>=5){
            $Padre_id = $_POST['Edificio'];
        }
        
        $SQL_Up='UPDATE   ClasificacionEspacios
        
                 SET     Nombre="'.$_POST['newEspacio'].'",
                         CapacidadEstudiantes="'.$_POST['Capacidad'].'",
                         AccesoDiscapacitados="'.$Acceso.'",
                         codigotiposalon="'.$_POST['T_salon'].'",
                         descripcion="'.$_POST['Descrip'].'",
                         direccion="'.$_POST['Dirrecion'].'",
                         UsuarioUltimaModificacion="'.$userid.'",
                         FechaUltimaModificacion=NOW(),
                         ClasificacionEspacionPadreId="'.$Padre_id.'"
                 
                 WHERE
                         ClasificacionEspaciosId="'.$_POST['id_Registro'].'" AND  codigoestado=100';
                        
                 if($Modificar=&$db->Execute($SQL_Up)===false){
                    $a_vectt['val']			=false;
                    $a_vectt['descrip']		='Error en El Modificar ... <br><br>'.$SQL_Up;
                    echo json_encode($a_vectt);
                    exit;
                 }  
                 
                 
        $SQL='UPDATE DetalleClasificacionEspacios
              SET
                    FechaInicioVigencia="'.$_POST['FechaIni'].'",
                    FechaFinVigencia="'.$_POST['FechaFin'].'",
                    UsuarioUltimaModificacion="'.$userid.'",
                    FechaUltimaModificacion=NOW()
              WHERE
                    ClasificacionEspaciosId="'.$_POST['id_Registro'].'"';
        
         if($DetalleFechas=&$db->Execute($SQL)===false){
            $a_vectt['val']			=false;
            $a_vectt['descrip']		='Error en El Modificar Fechas Vigencias... <br><br>'.$SQL;
            echo json_encode($a_vectt);
            exit;
        }
        
                        
        $a_vectt['val']			=true;
        $a_vectt['descrip']		='Se ha Modificado Correctamente.';
        echo json_encode($a_vectt);
        exit;                         
        
    }break;
    case 'Editar':{
        global $C_DisenoEspacioFisico,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        JsGeneral();
        $id  =  str_replace('row_','',$_POST['id']);
        
       // $id  =  19;
        
        $SQL='SELECT  
                      c.ClasificacionEspaciosId  AS id,
                      c.Nombre,
                      c.descripcion,
                      e.Nombre as Tipo,
                      e.EspaciosFisicosId,
                      d.FechaInicioVigencia,
                      d.FechaFinVigencia,
                      c.CapacidadEstudiantes,
                      c.AccesoDiscapacitados,
                      c.EspaciosFisicosId,
                      c.codigotiposalon,
                      c.direccion,
                      c.ClasificacionEspacionPadreId
              FROM 
                      ClasificacionEspacios  c INNER JOIN EspaciosFisicos e ON e.EspaciosFisicosId=c.EspaciosFisicosId 
                                               INNER JOIN DetalleClasificacionEspacios d ON d.ClasificacionEspaciosId=c.ClasificacionEspaciosId
                                               
              WHERE 
                      c.ClasificacionEspaciosId<>1 
                      AND 
                      e.codigoestado=100 
                      AND 
                      c.codigoestado=100 
                      AND
                      c.ClasificacionEspaciosId="'.$id.'"';
                      
            if($Result=&$db->Execute($SQL)===false){
                echo 'Error en el SQl de Busqueda Data....<br>'.$SQL;
                die;
            }  
            
            $Dato = $Result->GetArray(); 
            
            for($i=0;$i<count($Dato);$i++){
                
                  $SQL='SELECT
                        	    c.Nombre, c.ClasificacionEspacionPadreId AS PadreId2 , cc.Nombre AS Nombre_padre2
                        FROM 
                        
                                ClasificacionEspacios c INNER JOIN  ClasificacionEspacios cc ON c.ClasificacionEspacionPadreId=cc.ClasificacionEspaciosId
                        
                        WHERE   c.ClasificacionEspaciosId="'.$Dato[$i]['ClasificacionEspacionPadreId'].'"';
                      
                      if($Row=&$db->Execute($SQL)===false){
                        echo 'Error en el SQL del detalle...<br><br>'.$SQL;
                        die;
                      }
                      
                $Dato[$i][]                 = $Row->fields['Nombre'];      
                $Dato[$i]['NombrePadreId']  = $Row->fields['Nombre'];
                $Dato[$i][]                 = $Row->fields['PadreId2'];      
                $Dato[$i]['PadreId2']       = $Row->fields['PadreId2'];
                $Dato[$i][]                 = $Row->fields['Nombre_padre2'];      
                $Dato[$i]['NombrePadreId2'] = $Row->fields['Nombre_padre2'];
            } 
            
            $C_DisenoEspacioFisico->Editar($Dato);      
        
    }break;
    case 'Consola':{
        global $C_DisenoEspacioFisico,$userid,$db;
        define(AJAX,false);
        MainGeneral();
        JsGeneral();
        $C_DisenoEspacioFisico->Consola($db);
    }break;
    case 'Save':{
        //echo '<pre>';print_r($_POST);
        /*
        [actionID] => Save
        [Espacio] => 3
        [Campus] => -1
        [Edificio] => -1
        [newEspacio] => usquen
        [Descrip] => asdsdsd
        [Dirrecion] => sddsd
        [T_salon] => -1
        [Capacidad] => 
        [FechaIni] => 2014-05-01
        [FechaFin] => 2014-05-21
        [Acceso]=> on
        */
        global $db,$userid;
        
        MainJson();
        
        if($_POST['T_salon']=='-1'){
            $T_Salon = 32;
        }else{
           $T_Salon = $_POST['T_salon']; 
        }
        
        if($_POST['Acceso']=='on'){
            $Acceso = 1;
        }else{
            $Acceso = 0;
        }
        
        if($_POST['Espacio']==3){
            $Padre_id = '1';
        }else if($_POST['Espacio']==4){
            $Padre_id = $_POST['Campus'];
        }else if($_POST['Espacio']>=5){
            $Padre_id = $_POST['Edificio'];
        }
        
        $SQL_insert='INSERT INTO ClasificacionEspacios(Nombre,CapacidadEstudiantes,AccesoDiscapacitados,EspaciosFisicosId,codigotiposalon,descripcion,direccion,UsuarioCreacion,FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion,ClasificacionEspacionPadreId)VALUES("'.$_POST['newEspacio'].'","'.$_POST['Capacidad'].'","'.$Acceso.'","'.$_POST['Espacio'].'","'.$T_Salon.'","'.$_POST['Descrip'].'","'.$_POST['Dirrecion'].'","'.$userid.'",NOW(),"'.$userid.'",NOW(),"'.$Padre_id.'")';
        
        if($NewClasificacionEspacios=&$db->Execute($SQL_insert)===false){
            $a_vectt['val']			=false;
            $a_vectt['descrip']		='Error en El Insert ... <br><br>'.$SQL_insert;
            echo json_encode($a_vectt);
            exit;
        }
        /***************************/
        $Last_id = $db->Insert_ID();
        /***************************/
        
        
        $SQL='INSERT INTO DetalleClasificacionEspacios(FechaInicioVigencia,FechaFinVigencia,ClasificacionEspaciosId,UsuarioCreacion,FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion)VALUES("'.$_POST['FechaIni'].'","'.$_POST['FechaFin'].'","'.$Last_id.'","'.$userid.'",NOW(),"'.$userid.'",NOW())';
        
         if($DetalleFechas=&$db->Execute($SQL)===false){
            $a_vectt['val']			=false;
            $a_vectt['descrip']		='Error en El Insert Fechas Vigencias... <br><br>'.$SQL;
            echo json_encode($a_vectt);
            exit;
        }
        
        $a_vectt['val']			=true;
        $a_vectt['id']			=$Last_id;
        $a_vectt['descrip']		='Se ha Creado Correctamente...';
        echo json_encode($a_vectt);
        exit;
    }break;
    case 'Edificio':{
        global $C_DisenoEspacioFisico,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        //JsGeneral();
        
        $C_DisenoEspacioFisico->EspacioCategoria('Edificio','4','',$_POST['Campus']);
    }break;
    case 'Programa':{
        global $C_DisenoEspacioFisico,$userid,$db;
        define(AJAX,true);
        MainGeneral();
        JsGeneral();
        
        $C_DisenoEspacioFisico->Programa($_POST['Modalidad']);
    }break;
    case 'VentanaExepcion':{
        global $C_DisenoEspacioFisico,$userid,$db;
        
        if($_POST['Op']==1){
            define(AJAX,true);
            $id = str_replace('row_','',$_POST['registro']);
        }else{
            define(AJAX,false);
            $id = $_REQUEST['registro'];  
        }
        MainGeneral();
        JsGeneral();
        $C_DisenoEspacioFisico->AddExepciones($id); 
    }break;
    default:{
        global $C_DisenoEspacioFisico,$userid,$db;
        
        define(AJAX,false);
        MainGeneral();
        JsGeneral();
        $C_DisenoEspacioFisico->Principal();
    }break;
}
function MainGeneral(){
	
		
		global $C_DisenoEspacioFisico,$userid,$db;
		
		//var_dump(is_file("templates/template.php"));die;
        include("../templates/template.php"); 
        
        if(AJAX==false){
            $db = writeHeader('Dise&ntilde;o Espacio F&iacute;sico',true);
        }else{
            $db = getBD();
        }
	 
		include('DisenoEspacioFisico_class.php');  $C_DisenoEspacioFisico = new DisenoEspacioFisico();
	
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
    <script type="text/javascript" language="javascript" src="../Administradores/DisenoEspacioFisico.js"></script>
    <script type="text/javascript" >
           $(document).ready(function(){
    		$("#FechaIni").datepicker({ 
    			changeMonth: true,
    			changeYear: true,
    			showOn: "button",
    			buttonImage: "../../css/themes/smoothness/images/calendar.gif",
    			buttonImageOnly: true,
    			dateFormat: "yy-mm-dd"
    		});
            $("#FechaFin").datepicker({ 
    			changeMonth: true,
    			changeYear: true,
    			showOn: "button",
    			buttonImage: "../../css/themes/smoothness/images/calendar.gif",
    			buttonImageOnly: true,
    			dateFormat: "yy-mm-dd"
    		});
            $('#ui-datepicker-div').css('display','none');
        }); 
    </script>
   
    <?PHP
}    
?>