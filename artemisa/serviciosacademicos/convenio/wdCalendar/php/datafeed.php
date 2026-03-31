<?php
include_once("dbconfig.php");
include_once("functions.php");
//require_once("../../../mgi/templates/template.php");
include_once ('../../../EspacioFisico/templates/template.php');
$db = getBD();

function addCalendar($st, $et, $sub, $ade){
  $ret = array();
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'add success';
      $ret['Data'] =rand();
  return $ret;
}


function addDetailedCalendar($st, $et, $sub, $ade, $dscr, $loc, $color, $tz){
  $ret = array();
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'add success';
      $ret['Data'] = rand();
  return $ret;
}

function listCalendarByRange($sd, $ed, $cnt, $db,$stLimited=NULL, $etLimited=NULL,$type="month"){
  $ret = array();
  $ret['events'] = array();
  $ret["issort"] =true;
  $ret["start"] = php2JsTime($sd);
  $ret["end"] = php2JsTime($ed);
  $ret['error'] = null;
  /*$title = array('team meeting', 'remote meeting', 'project plan review', 'annual report', 'go to dinner');
  $location = array('Lodan', 'Newswer', 'Belion', 'Moore', 'Bytelin');
  for($i=0; $i<$cnt; $i++) {
      $rsd = rand($sd, $ed);
      $red = rand(3600, 10800);
      if(rand(0,10) > 8){
          $alld = 1;
      }else{
          $alld=0;
      }
      $ret['events'][] = array(
        rand(10000, 99999),
        $title[rand(0,4)],
        php2JsTime($rsd),
        php2JsTime($red),
        rand(0,1),
        $alld, //more than one day event
        0,//Recurring event
        rand(-1,13),
        1, //editable
        $location[rand(0,4)], 
        ''//$attends
      );*/
  
    try{   
        
        //$api = new API_Monitoreo();
        //$indicadores_responsable = $api->getQueryIndicadoresACargo();
        //var_dump($indicadores_responsable);die();
        //generar nuevas actividades si necesito desde la fecha de inicio a la fecha final y solo de los indicadores del usuario logueado
        //if($etLimited!=NULL){
        //    $api->generarNuevasActividadesActualizacionIndicador($db,php2MySqlTime($stLimited),php2MySqlTime($etLimited)); 
        //} else {
       //     $api->generarNuevasActividadesActualizacionIndicador($db,php2MySqlTime($sd),php2MySqlTime($ed));
       // }
        
        //$result =$db->GetRow($indicadores_responsable);
        
        //var_dump("aja");die();
        //if(count($result)>0){
            /*$sql = "select * from `siq_actividadActualizar` a 
                inner join siq_relacionIndicadorMonitoreo r on a.idMonitoreo=r.idMonitoreo AND 
                r.idIndicador IN (".$indicadores_responsable.") 
                where a.`fecha_limite` between '"
            .php2MySqlTime($sd)."' and '". php2MySqlTime($ed)."' AND a.codigoestado='100'";*/
            if($_SESSION['MM_Username']== 'admintecnologia')
            {
/*
                 $sql = "SELECT * from RotacionEstudiantes 
						WHERE codigoestado = 100 
						and SubgrupoId=1 
						AND (FechaIngreso between '"
							.php2MySqlTime($sd)."' and '". php2MySqlTime($ed)."'
							OR FechaEgreso between '"
							.php2MySqlTime($sd)."' and '". php2MySqlTime($ed)."')
						UNION
						SELECT * from RotacionEstudiantes 
						WHERE codigoestado = 100 
						and SubgrupoId<>1 
						AND (FechaIngreso between '"
							.php2MySqlTime($sd)."' and '". php2MySqlTime($ed)."'
							OR FechaEgreso between '"
							.php2MySqlTime($sd)."' and '". php2MySqlTime($ed)."')
						GROUP BY SubgrupoId, FechaIngreso, FechaEgreso";    
/**/
               $sql = "select * from RotacionEstudiantes where codigoestado = 100";
            } else
            {
                $sql = "SELECT * from RotacionEstudiantes 
						WHERE codigoestado = 100 
						and codigocarrera = '".$_SESSION['codigofacultad']."'
						and SubgrupoId=1 
						AND (FechaIngreso between '"
							.php2MySqlTime($sd)."' and '". php2MySqlTime($ed)."'
							OR FechaEgreso between '"
							.php2MySqlTime($sd)."' and '". php2MySqlTime($ed)."')
						UNION
						SELECT * from RotacionEstudiantes 
						WHERE codigoestado = 100 
						and codigocarrera = '".$_SESSION['codigofacultad']."'
						and SubgrupoId<>1 
						AND (FechaIngreso between '"
							.php2MySqlTime($sd)."' and '". php2MySqlTime($ed)."'
							OR FechaEgreso between '"
							.php2MySqlTime($sd)."' and '". php2MySqlTime($ed)."')
						GROUP BY SubgrupoId, FechaIngreso, FechaEgreso";    
            }
			//echo $sql;
			
            
            /*"select * from `siq_actividadActualizar` a inner join siq_relacionIndicadorMonitoreo r on a.idMonitoreo=r.idMonitoreo 
                inner join (".$indicadores_responsable.") rid on rid.idsiq_indicador = r.idIndicador                 
                where a.`fecha_limite` between '"
            .php2MySqlTime($sd)."' and '". php2MySqlTime($ed)."' AND a.codigoestado='100' ORDER BY a.fecha_limite";*/
        /*} else {
                $sql = "select * from `siq_actividadActualizar` where `fecha_limite` between '"
            .php2MySqlTime($sd)."' and '". php2MySqlTime($ed)."' AND codigoestado='100'";
        }*/
        
        //var_dump($sql);die();
        $handle = $db->execute($sql); 
        $allday = 0;    
        //var_dump(php2MySqlTime($ed));
        //var_dump(php2MySqlTime($sd));
                
        //Si es vista semanal o diaria muestro la actividad en el dia de resto no
        /*$endDate = new DateTime(php2MySqlTime($ed));
        $startDate = new DateTime(php2MySqlTime($sd));                
        $numDays = $endDate->diff($startDate);   
        
        //var_dump($numDays->days);
        if($numDays->days<8){
             $allday = 0;
        }*/
        
        //var_dump($allday);
        foreach($handle as $row)
        {
            $grupo = $row['SubgrupoId'];
                       
            if($grupo != '1')
            {
                $nombre= "Grupo ".$grupo;
            }else{
                $sqlnombreestudiante = "select nombresestudiantegeneral from estudiantegeneral eg 
				inner join estudiante e on eg.idestudiantegeneral=e.idestudiantegeneral 
				where e.codigoestudiante = '".$row['codigoestudiante']."'";
                $nombre = $db->GetRow($sqlnombreestudiante);
                $nombre = $nombre['nombresestudiantegeneral'];    
            }
            
            switch($row['JornadaId'])
            {
                case '1':
                {
                    $horainicial = '07:00:00';
                    $horafinal = '17:00:00';
                    $color = 12;
                }break;
                case '2':
                {
                    $horainicial = '07:00:00';
                    $horafinal = '12:00:00';
                    $color = 5;
                }break;
                case '3':
                {
                    $horainicial = '13:00:00';
                    $horafinal = '17:00:00';
                    $color=10;
                }break;
            }
/*
			$date = php2MySqlTime($sd);
			$date = explode(" ", $date);
			$fecha = $date[0];
			if($type=="day"){
				$ret['events'][] = array(
					$row['RotacionEstudianteId'],
					$nombre." ",//$row->Subject,
					php2JsTime(mySql2PhpTime($fecha." ".$horainicial)), //'2012-07-02 03:00:00'
					php2JsTime(mySql2PhpTime($fecha." ".$horafinal)), //'2012-07-02 03:00:00'
					$allday,//all day
					0, //more than one day event
					//$row->InstanceType,
					0,//Recurring event,
					// 1=rojo pa desactualizado, 12=medio naranja porque el blanco de texto pailas, 3=morado pa rechazado?, 9=verde pa actualizado, 11= amarillo pendiente
					$color,//rand(-1,13),//$row->idEstado, //color
					0,//editable  
					$nombre,
					$row['FechaEgreso'], 
					$row['FechaIngreso'], 
					$row['codigomateria'], 
					$row['IdUbicacionInstitucion'], 
					$row['idsiq_convenio'],
					$row['IdInstitucion'],
					$row['idestudiantegeneral'],
					$row['SubgrupoId']
				);
			} else if($type=="week"){
				$ret['events'][] = array(
/**/
			
			if($type=="week" || $type=="day"){
			
			 include_once('../../../EspacioFisico/Solicitud/PruebaFechasCalendario.php');
             $Fecha_Reales = Fechas($row['FechaIngreso'],$row['FechaEgreso']);
             //echo '<pre>';print_r($Fecha_Reales);die;
             
             for($i=0;$i<count($Fecha_Reales);$i++){
                $ret['events'][] = array(
					$row['RotacionEstudianteId'],
					$nombre." ",//$row->Subject,
					php2JsTime(mySql2PhpTime($Fecha_Reales[$i]." ".$horainicial)), //'2012-07-02 03:00:00' $row['FechaIngreso']
					php2JsTime(mySql2PhpTime($Fecha_Reales[$i]." ".$horafinal)), //'2012-07-02 03:00:00' $row['FechaIngreso']
					$allday,//all day
					0, //more than one day event
					//$row->InstanceType,
					0,//Recurring event,
					// 1=rojo pa desactualizado, 12=medio naranja porque el blanco de texto pailas, 3=morado pa rechazado?, 9=verde pa actualizado, 11= amarillo pendiente
					$color,//rand(-1,13),//$row->idEstado, //color
					0,//editable  
					$nombre,
					$row['FechaEgreso'], 
					$row['FechaIngreso'], 
					$row['codigomateria'], 
					$row['IdUbicacionInstitucion'], 
					$row['idsiq_convenio'],
					$row['IdInstitucion'],
					$row['idestudiantegeneral'],
					$row['SubgrupoId']
				);
             }//for
				
			} else {           
				$ret['events'][] = array(
					$row['RotacionEstudianteId'],
					$nombre." ",//$row->Subject,
					php2JsTime(mySql2PhpTime($row['FechaIngreso']." ".$horainicial)), //'2012-07-02 03:00:00'
					php2JsTime(mySql2PhpTime($row['FechaEgreso']." ".$horafinal)), //'2012-07-02 03:00:00'
					$allday,//all day
					0, //more than one day event
					//$row->InstanceType,
					0,//Recurring event,
					// 1=rojo pa desactualizado, 12=medio naranja porque el blanco de texto pailas, 3=morado pa rechazado?, 9=verde pa actualizado, 11= amarillo pendiente
					$color,//rand(-1,13),//$row->idEstado, //color
					0,//editable  
					$nombre,
					$row['FechaEgreso'], 
					$row['FechaIngreso'], 
					$row['codigomateria'], 
					$row['IdUbicacionInstitucion'], 
					$row['idsiq_convenio'],
					$row['IdInstitucion'],
					$row['idestudiantegeneral'],
					$row['SubgrupoId']
				);
			}
        }
            }catch(Exception $e){
        $ret['error'] = $e->getMessage();
    }
  //echo '<pre>';print_r($ret);
  return $ret;
}

function listCalendar($day, $type, $db=NULL){
  $phpTime = js2PhpTime($day);
  $stLimited=null;
  $etLimited=null;
  
  //echo $phpTime . "+" . $type;
  switch($type){
    case "month":
      $stLimited = mktime(0, 0, 0, date("m", $phpTime), 1, date("Y", $phpTime));
      $etLimited = mktime(0, 0, -1, date("m", $phpTime)+1, 1, date("Y", $phpTime));
      
      //Me toco ampliar la búsqueda desde el mes anterior al último dia del mes siguiente porque el calendario muestra más
      //que solo el mes, sino también varios días de los otros meses
      $mon = date("m", $phpTime) +1;
        
      $st = mktime(0, 0, 0, date("m", $phpTime)-1, 1, date("Y", $phpTime));
      $et = mktime(0, 0, -1, date("m", $phpTime)+1, date("t",strtotime(date("Y", $phpTime)."-".$mon."-01")), date("Y", $phpTime));
      $cnt = 50;
      break;
    case "week":
      //suppose first day of a week is monday 
      $monday  =  date("d", $phpTime) - date('N', $phpTime) + 1;
      //echo date('N', $phpTime);
      $st = mktime(0,0,0,date("m", $phpTime), $monday, date("Y", $phpTime));
      $et = mktime(0,0,-1,date("m", $phpTime), $monday+7, date("Y", $phpTime));
      $cnt = 20;
      break;
    case "day":
      $st = mktime(0, 0, 0, date("m", $phpTime), date("d", $phpTime), date("Y", $phpTime));
      $et = mktime(0, 0, -1, date("m", $phpTime), date("d", $phpTime)+1, date("Y", $phpTime));
      $cnt = 5;
      break;
  }
  //echo $st . "--" . $et;
  return listCalendarByRange($st, $et, $cnt, $db, $stLimited, $etLimited,$type);
}

function updateCalendar($id, $st, $et){
  $ret = array();
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Succefully';
  return $ret;
}

function updateDetailedCalendar($id, $st, $et, $sub, $ade, $dscr, $loc, $color, $tz){
  $ret = array();
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Succefully';
  return $ret;
}

function removeCalendar($id){
  $ret = array();
      $ret['IsSuccess'] = true;
      $ret['Msg'] = 'Succefully';
  return $ret;
}

function addActivity(){
  $ret = array();
  $utils = new Utils_monitoreo();
  
  if($_POST["idPeriodicidad"]==""&&$_POST["action"]=="update"){
    $_POST["idPeriodicidad"] = 0;
    $_POST["dia_predefinido"] = 0;
  }
  if(isset($_POST["idPeriodicidad"])&&$_POST["idPeriodicidad"]!=""){
    $choosenDate = explode("-", $_POST["fecha_prox_monitoreo"]);
    $_POST["dia_predefinido"] = $choosenDate[2];
}
  $action = $_POST["action"];
  //var_dump($_POST);
  $result = $utils->processData($action, $_POST["entity"]);
  //var_dump($result);
  
  $api = new API_Monitoreo();
    $monitoreo = $_POST["idsiq_monitoreo"];
    $action = $_POST["action2"];
    
    if($result!=NULL&&$result!=0){
        $_POST["idMonitoreo"] = $result;
        $monitoreo = $result;
    }
  //var_dump($monitoreo);
    $result = $utils->processData($action, $_POST["entity2"]);
  //var_dump($result);
        
    //Debe inactivar las actividades que no esten actualizadas a excepción de la activa que le cambia la fecha limite
    $api->generarActividadesActualizacionIndicador($monitoreo);
  //var_dump(" pase todas");
    
    $fields["fecha_proximo_vencimiento"] = $_POST["fecha_prox_monitoreo"];
    $fields["idsiq_indicador"] = $_POST["idIndicador"];
    $result = $utils->processData("update", "indicador", $fields);  
  
      $ret['IsSuccess'] = true;
      $ret['Msg'] = "Se ha programado la nueva fecha de actualización correctamente.";
  return $ret;
}

header('Content-type:text/javascript;charset=UTF-8');
$method = $_GET["method"];
switch ($method) {
    case "add":
        $ret = addCalendar($_POST["CalendarStartTime"], $_POST["CalendarEndTime"], $_POST["CalendarTitle"], $_POST["IsAllDayEvent"]);
        break;
    case "list":
        $ret = listCalendar($_POST["showdate"], $_POST["viewtype"],$db);
        break;
    case "update":
        $ret = updateCalendar($_POST["calendarId"], $_POST["CalendarStartTime"], $_POST["CalendarEndTime"]);
        break; 
    case "remove":
        $ret = removeCalendar( $_POST["calendarId"]);
        break;
    case "adddetails":
        /*$id = $_GET["id"];
        $st = $_POST["stpartdate"] . " " . $_POST["stparttime"];
        $et = $_POST["etpartdate"] . " " . $_POST["etparttime"];
        if($id){
            $ret = updateDetailedCalendar($id, $st, $et, 
                $_POST["Subject"], $_POST["IsAllDayEvent"]?1:0, $_POST["Description"], 
                $_POST["Location"], $_POST["colorvalue"], $_POST["timezone"]);
        }else{
            $ret = addDetailedCalendar($st, $et,                    
                $_POST["Subject"], $_POST["IsAllDayEvent"]?1:0, $_POST["Description"], 
                $_POST["Location"], $_POST["colorvalue"], $_POST["timezone"]);
        }   */
        $ret = addActivity();
        break; 


}
echo json_encode($ret); 

?>
