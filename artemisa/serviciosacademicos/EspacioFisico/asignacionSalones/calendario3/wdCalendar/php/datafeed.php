
<?php
// include_once("dbconfig.php");
require_once("../../../../templates/template.php");
include_once("functions.php");


function addCalendar($st, $et, $sub, $ade){
  $ret = array();
  try{
    $db = new DBConnection();
    $db->getConnection();
    $sql = "insert into `jqcalendar` (`subject`, `starttime`, `endtime`, `isalldayevent`) values ('"
      .mysql_real_escape_string($sub)."', '"
      .php2MySqlTime(js2PhpTime($st))."', '"
      .php2MySqlTime(js2PhpTime($et))."', '"
      .mysql_real_escape_string($ade)."' )";
    //echo($sql);
    if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'add success';
      $ret['Data'] = mysql_insert_id();
    }
  }catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}
function addCalendarNewEvento($data){
        //var_dump(is_file('../../../../templates/template.php'));die;
        include_once("../../../../templates/template.php");
		
        $db = getBD();
        
        $SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
        
        include_once('../../../../Solicitud/AsignacionSalon.php');
        include_once('../../../../Solicitud/festivos.php');
        
        
        $C_Festivo  = new festivos();
        
        $C_AsignacionSalon = new AsignacionSalon();
        
        $FechaUnica = $_POST['FechaUnica'];
        $Max          = $_POST['NumEstudiantes'];
        $Acceso       = $_POST['Acceso'];
        if($Acceso=='on'){
            $Acceso = 1;
        }else{
            $Acceso = 0;
        }
        $Sede        = $_POST['Campus'];
        $TipoSalon   = $_POST['TipoSalon'];
        $Grupo_id       = $_POST['Grupo'];
        
        if($FechaUnica){
            $HoraInicial_unica  = $_POST['HoraInicial_unica'];
            $HoraFin_unica      = $_POST['HoraFin_unica']; 
            
            $CodigoDia[] = $C_AsignacionSalon->DiasSemana($FechaUnica,'Codigo');
            
            $Hora        = $C_AsignacionSalon->Horas($HoraInicial_unica,$HoraFin_unica);
            
            $Info[0][0]=$FechaUnica.' '.$Hora['Horaini'];
            $Info[0][1]=$FechaUnica.' '.$Hora['Horafin'];
        }else{
            $Data = $_POST;
        
            $Info = $C_AsignacionSalon->DisponibilidadMultiple($db,$Data,'arreglo','../../../');
            $FechaIni    = $_POST['FechaIni'];
            $FechaFin    = $_POST['FechaFin'];
            $CodigoDia   = $_POST['DiaSemana'];
            $numIndices  = $_POST['numIndices'];
            
            
        }
        
        $EspacioCheck  = $_POST['EspacioCheck'];
        
        for($i=0;$i<count($EspacioCheck);$i++){
            /***************************************************/
            if($EspacioCheck[$i]){
                $Espacios[] = $EspacioCheck[$i];    
            }
            /***************************************************/
        }//for
        
        $Limit  = Count($CodigoDia)-1;
        
        for($i=0;$i<=$Limit;$i++){
            /****************************************************/
            
            if($FechaUnica){
                $Fecha_inicial = $FechaUnica;
                $Fecha_final   = $FechaUnica;
                
            }else{
                $Fecha_inicial = $FechaIni;
                $Fecha_final   = $FechaFin;
                
            }
            
            
            
            $SQL_Insert='INSERT INTO SolicitudAsignacionEspacios(codigotiposalon,AccesoDiscapacitados,FechaInicio,FechaFinal,idsiq_periodicidad,ClasificacionEspaciosId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaUltimaModificacion,codigodia)VALUES("'.$TipoSalon.'","'.$Acceso.'","'.$Fecha_inicial.'","'.$Fecha_final.'","35","'.$Sede.'","'.$userid.'","'.$userid.'",NOW(),NOW(),"'.$CodigoDia[$i].'")';
            
            if($InsertSolicituNew=&$db->Execute($SQL_Insert)===false){
                $a_vectt['val']			=false;
                $a_vectt['descrip']		='Error al Insertar Solicitud..';
                $a_vectt['Data'] =rand();
                return $a_vectt;
            }
            
            ##########################
            $Last_id=$db->Insert_ID();
            ##########################
            
           $InserGrupo='INSERT INTO SolicitudEspacioGrupos(SolicitudAsignacionEspacioId,idgrupo)VALUES("'.$Last_id.'","'.$Grupo_id.'")';  
             
             if($GrupoSolicitud=&$db->Execute($InserGrupo)===false){
                $a_vectt['val']			=false;
                $a_vectt['descrip']		='Error al Insertar Solicitud Grupo..';
                $a_vectt['Data'] =rand();
                return $a_vectt;
             }
            /****************************************************/
            
            for($x=0;$x<count($Info);$x++){
                /******************************************************/
                 $FechaFutura_1 = $Info[$x][0];
                 $FechaFutura_2 = $Info[$x][1];
                 
                 $C_FechaData_1  = explode(' ',$FechaFutura_1);
                 $C_FechaData_2  = explode(' ',$FechaFutura_2);
                 
                 $C_DatosDia  = explode('-',$C_FechaData_1[0]);
                    
                 $dia  = $C_DatosDia[2];
                 $mes  = $C_DatosDia[1];
                    
                 $Festivo = $C_Festivo->esFestivo($dia,$mes);
                 $DomingoTrue = $C_AsignacionSalon->DiasSemana($Fecha);
                 if($Festivo==false){//$Festivo No es Festivo
                    if(($DomingoTrue!=7) || ($DomingoTrue!='7')){
                    $Fecha  = $C_FechaData_1[0];
                    $Hora_1 = $C_FechaData_1[1];
                    $Hora_2 = $C_FechaData_2[1]; 
                    
                    $Asignacion='INSERT INTO AsignacionEspacios(FechaAsignacion,SolicitudAsignacionEspacioId,UsuarioCreacion,UsuarioUltimaModificacion,FechaCreacion,FechaultimaModificacion,ClasificacionEspaciosId,HoraInicio,HoraFin)VALUES("'.$Fecha.'","'.$Last_id.'","'.$userid.'","'.$userid.'",NOW(),NOW(),"'.$Espacios[$x].'","'.$Hora_1.'","'.$Hora_2.'")';
                
                       if($InsertAsignar=&$db->Execute($Asignacion)===false){
                            $a_vectt['val']			=false;
                            $a_vectt['descrip']		='Error al Insertar Asignacion del Espacio..';
                            $a_vectt['Data'] =rand();
                            return $a_vectt;
                        }
                    }//Diferente de domingo
                 }//if
                /******************************************************/
            }//for
            /****************************************************/
        }//for
        
          
        $a_vectt['val']			=true;
        $a_vectt['descrip']		='Se ha Creado la Solicitud y Asignacion Correctamente...';
        $a_vectt['Data'] =rand();
        
        
        return $a_vectt;
         
    
}

function addDetailedCalendar($st, $et, $sub, $ade, $dscr, $loc, $color, $tz){
  $ret = array();
  try{
    $db = new DBConnection();
    $db->getConnection();
    $sql = "insert into `jqcalendar` (`subject`, `starttime`, `endtime`, `isalldayevent`, `description`, `location`, `color`) values ('"
      .mysql_real_escape_string($sub)."', '"
      .php2MySqlTime(js2PhpTime($st))."', '"
      .php2MySqlTime(js2PhpTime($et))."', '"
      .mysql_real_escape_string($ade)."', '"
      .mysql_real_escape_string($dscr)."', '"
      .mysql_real_escape_string($loc)."', '"
      .mysql_real_escape_string($color)."' )";
    //echo($sql);
    if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'add success';
      $ret['Data'] = mysql_insert_id();
    }
  }catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}

function listCalendarByRange($sd, $ed){
  $ret = array();
  $ret['events'] = array();
  $ret["issort"] =true;
  $ret["start"] = php2JsTime($sd);
  $ret["end"] = php2JsTime($ed);
  $ret['error'] = null;
  try{
    $db = getBD();
    $sql = "SELECT ae.AsignacionEspaciosId as Id, 
            CONCAT(ae.FechaAsignacion,' ',ae.HoraInicio) as StartTime, 
            CONCAT(ae.FechaAsignacion,' ',ae.HoraFin) as EndTime,
            CONCAT('  ',c.codigocarrera,' :: ',c.nombrecarrera, ' :: ' ,m.codigomateria,' :: ',m.nombremateria ) as title,
            c.codigocarrera
            FROM AsignacionEspacios ae
            INNER JOIN ClasificacionEspacios cee ON cee.ClasificacionEspaciosId = ae.ClasificacionEspaciosId
            INNER JOIN tiposalon ts ON ts.codigotiposalon=cee.codigotiposalon
            INNER JOIN SolicitudEspacioGrupos  sg ON  sg.SolicitudAsignacionEspacioId=ae.SolicitudAsignacionEspacioId 
            INNER JOIN grupo  g ON g.idgrupo=sg.idgrupo 
            INNER JOIN materia m ON g.codigomateria=m.codigomateria
            INNER JOIN carrera c ON m.codigocarrera=c.codigocarrera
            WHERE ae.ClasificacionEspaciosId='".$_GET['id']."'
            AND ae.codigoestado = 100
            AND CONCAT(ae.FechaAsignacion,' ',ae.HoraInicio) between '".php2MySqlTime($sd)."' AND '".php2MySqlTime($ed)."' 
            
            UNION
            
            SELECT ae.AsignacionEspaciosId as Id, 
                CONCAT(ae.FechaAsignacion,' ',ae.HoraInicio) as StartTime, 
                CONCAT(ae.FechaAsignacion,' ',ae.HoraFin) as EndTime,
                CONCAT('  ',s.NombreEvento,' :: ',s.UnidadNombre, ' :: Asistentes ' ,s.NumAsistentes ) as title,
                c.codigocarrera
                FROM AsignacionEspacios ae
                INNER JOIN ClasificacionEspacios cee ON cee.ClasificacionEspaciosId = ae.ClasificacionEspaciosId
                INNER JOIN tiposalon ts ON ts.codigotiposalon=cee.codigotiposalon
                INNER JOIN SolicitudAsignacionEspacios s ON  s.SolicitudAsignacionEspacioId=ae.SolicitudAsignacionEspacioId
                LEFT JOIN SolicitudEspacioGrupos  sg ON  sg.SolicitudAsignacionEspacioId=ae.SolicitudAsignacionEspacioId 
                LEFT JOIN grupo  g ON g.idgrupo=sg.idgrupo 
                LEFT JOIN materia m ON g.codigomateria=m.codigomateria
                LEFT JOIN carrera c ON m.codigocarrera=c.codigocarrera
                WHERE ae.ClasificacionEspaciosId='".$_GET['id']."'
                AND ae.codigoestado = 100
                AND s.codigomodalidadacademica<>001
                AND CONCAT(ae.FechaAsignacion,' ',ae.HoraInicio) between '".php2MySqlTime($sd)."' AND '".php2MySqlTime($ed)."' ";
            
    $handle = mysql_query($sql);
    $i=0;
    
    $Num = mysql_num_rows($handle);
    
    if($Num!=0 || $Num>=1){
    
        while ($row = mysql_fetch_object($handle)) {
    
          
    
          //echo '<pre>';print_r($ColorCarrera);die;
          // echo $i++;
          //$ret['events'][] = $row;
          //$attends = $row->AttendeeNames;
          //if($row->OtherAttendee){
          //  $attends .= $row->OtherAttendee;
          //}
          //echo $row->StartTime;
          $ret['events'][] = array(
            $row->Id,
            $row->title,
            php2JsTime(mySql2PhpTime($row->StartTime)),
            php2JsTime(mySql2PhpTime($row->EndTime)),
            // $row->IsAllDayEvent,
            0, //Coresponde al campo IsAllDayEvent,
            0, //more than one day event
            //$row->InstanceType,
            0,//Recurring event,
            // $row->Color,
            $row->codigocarrera, // Corresponde al campo Color
            1,//editable
            // $row->Location, 
            NULL, //Corresponde al campo Location
            ''//$attends
          );
        }
    }
    // print_r($ret);
  }catch(Exception $e){
     $ret['error'] = $e->getMessage();
  }
  return $ret;
}

function listCalendar($day, $type){
  $phpTime = js2PhpTime($day);
  //echo $phpTime . "+" . $type;
  switch($type){
    case "month":
      $st = mktime(0, 0, 0, date("m", $phpTime), 1, date("Y", $phpTime));
      $et = mktime(0, 0, -1, date("m", $phpTime)+1, 1, date("Y", $phpTime));
      break;
    case "week":
      //suppose first day of a week is monday 
      $monday  =  date("d", $phpTime) - date('N', $phpTime) + 1;
      //echo date('N', $phpTime);
      $st = mktime(0,0,0,date("m", $phpTime), $monday, date("Y", $phpTime));
      $et = mktime(0,0,-1,date("m", $phpTime), $monday+7, date("Y", $phpTime));
      break;
    case "day":
      $st = mktime(0, 0, 0, date("m", $phpTime), date("d", $phpTime), date("Y", $phpTime));
      $et = mktime(0, 0, -1, date("m", $phpTime), date("d", $phpTime)+1, date("Y", $phpTime));
      break;
  }
  //echo $st . "--" . $et;
  return listCalendarByRange($st, $et);
}

function updateCalendar($id, $st, $et){
  $ret = array();
  try{
    $db = new DBConnection();
    $db->getConnection();
    $sql = "update `jqcalendar` set"
      . " `starttime`='" . php2MySqlTime(js2PhpTime($st)) . "', "
      . " `endtime`='" . php2MySqlTime(js2PhpTime($et)) . "' "
      . "where `id`=" . $id;
    //echo $sql;
    if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Succefully';
    }
  }catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}

function updateDetailedCalendar($id, $st, $et, $sub, $ade, $dscr, $loc, $color, $tz){
  $ret = array();
  try{
    $db = new DBConnection();
    $db->getConnection();
    $sql = "update `jqcalendar` set"
      . " `starttime`='" . php2MySqlTime(js2PhpTime($st)) . "', "
      . " `endtime`='" . php2MySqlTime(js2PhpTime($et)) . "', "
      . " `subject`='" . mysql_real_escape_string($sub) . "', "
      . " `isalldayevent`='" . mysql_real_escape_string($ade) . "', "
      . " `description`='" . mysql_real_escape_string($dscr) . "', "
      . " `location`='" . mysql_real_escape_string($loc) . "', "
      . " `color`='" . mysql_real_escape_string($color) . "' "
      . "where `id`=" . $id;
    //echo $sql;
    if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Succefully';
    }
  }catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}

function removeCalendar($id){
  $ret = array();
  try{
    $db = new DBConnection();
    $db->getConnection();
    $sql = "delete from `jqcalendar` where `id`=" . $id;
    if(mysql_query($sql)==false){
      $ret['IsSuccess'] = false;
      $ret['Msg'] = mysql_error();
    }else{
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Succefully';
    }
  }catch(Exception $e){
     $ret['IsSuccess'] = false;
     $ret['Msg'] = $e->getMessage();
  }
  return $ret;
}




header('Content-type:text/javascript;charset=UTF-8');
$method = $_REQUEST["method"];
// echo "<pre>"; print_r($_POST);

switch ($method) {
    case "addNew":
        $ret = addCalendarNewEvento($_POST);
        break;
    case "add":
        $ret = addCalendar($_POST["CalendarStartTime"], $_POST["CalendarEndTime"], $_POST["CalendarTitle"], $_POST["IsAllDayEvent"]);
        break;
    case "list":
        $ret = listCalendar($_POST["showdate"], $_POST["viewtype"]);
        break;
    case "update":
        $ret = updateCalendar($_POST["calendarId"], $_POST["CalendarStartTime"], $_POST["CalendarEndTime"]);
        break; 
    case "remove":
        $ret = removeCalendar( $_POST["calendarId"]);
        break;
    case "adddetails":
        $st = $_POST["stpartdate"] . " " . $_POST["stparttime"];
        $et = $_POST["etpartdate"] . " " . $_POST["etparttime"];
        if(isset($_GET["id"])){
            $ret = updateDetailedCalendar($_GET["id"], $st, $et, 
                $_POST["Subject"], isset($_POST["IsAllDayEvent"])?1:0, $_POST["Description"], 
                $_POST["Location"], $_POST["colorvalue"], $_POST["timezone"]);
        }else{
            $ret = addDetailedCalendar($st, $et,                    
                $_POST["Subject"], isset($_POST["IsAllDayEvent"])?1:0, $_POST["Description"], 
                $_POST["Location"], $_POST["colorvalue"], $_POST["timezone"]);
        }        
        break; 


}
echo json_encode($ret); 


