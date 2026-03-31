<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Clase encargada de la gestión de indicadores y alarmas
 *
 * @author proyecto_mgi_cp
 */
// this starts the session 

    session_start();
   /* include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
    
require_once('ManagerEntity.php');

class API_Monitoreo {
    var $rutaProyecto = "monitoreo";
    
    var $db = null;
    
    public function __construct() {
        
    }
    
    public function initialize($database) {
        $this->db = $database;
    }
    
    private function getUserID(){
        if(!isset($_SESSION['MM_Username'])){
            //$_SESSION['MM_Username'] = 'admintecnologia';
            echo "No ha iniciado sesión en el sistema"; die();
        }
        $entity = new ManagerEntity("usuario",$this->rutaProyecto);
        $entity->sql_select = "idusuario";
        $entity->prefix ="";
        $entity->sql_where = " usuario='".$_SESSION['MM_Username']."' ";
        
        $data = $entity->getData();
        $userid = $data[0]['idusuario'];
        
        return $userid;
    }
    
    public function actualizarEstadoIndicador($idIndicador, $idEstado, $ubicacion="", $fecha_vencimiento = ""){
        $result = "OK";
        $success = false;
        // echo "actualizar1<br/>";
        $userid = $this->getUserID();
        
        $fields = array();
        $entity = new ManagerEntity("indicador",$this->rutaProyecto);
        $entity->fieldlist["idsiq_indicador"]['pkey']=$idIndicador;
        
        $currentdate  = date("Y-m-d H:i:s");
        $fields['fecha_modificacion'] = $currentdate;
        $fields['usuario_modificacion'] = $userid;
        $fields['idEstado'] = $idEstado;
        $fields["idsiq_indicador"] = $idIndicador;
        
        //Si es que pasa a actualizado
        if($idEstado==4){
        
            $fields['fecha_ultima_actualizacion'] = date("Y-m-d");
            $fields['fecha_proximo_vencimiento'] = $fecha_vencimiento;
            if($ubicacion!=""){
                $fields['ubicacion'] = $ubicacion;
            }
            $entity->SetEntity($fields);
            // echo "actualizar2<br/>";
            $result = $entity->updateRecord();  
            $success = true;
        } else{       
            $entity->SetEntity($fields);
            // echo "actualizar3<br/>";
            $result = $entity->updateRecord();
            $success = true;
        }
        // echo "actualizar4<br/>";
        return array("success"=>$success,"message"=>$result);
    }
    
    public function enviarIndicadorARevision ($idIndicador){
        $fields = array();
        // echo "check1<br/>";
        $adjuntos = $this->checkIndicadorAdjuntos($idIndicador);
        if($adjuntos){
        // echo "check2<br/>";
            $relacion = $this->getRelacionIndicadorMonitoreo($idIndicador);
         //echo "check4<br/>";

            //Si tiene monitoreo, verifica que tenga actividad y sino la crea con fecha limite la del monitoreo
            if($relacion!=NULL&&$relacion["idsiq_relacionIndicadorMonitoreo"]!=""){
        // echo "check5<br/>";
                $actividad = $this->getActividadActualizarActiva($relacion["idMonitoreo"]);
//var_dump($actividad);
        // echo "check6<br/>";
                if($actividad==NULL||$actividad==""){
         //echo "check7<br/>";
                    $idActividad = $this->generarActividadesActualizacionIndicador($relacion["idMonitoreo"]);
			//		echo "id--->".$idActividad;
         //echo "check8<br/>";
                } else {
                    $idActividad = $actividad["idsiq_actividadActualizar"];
                }

         //echo "check9<br/>";
                //En revisión
                $this->actualizarEstadoActividadActualizacion($idActividad, 2);
         //echo "check10<br/>";

            } 
            //Si no tiene monitoreo, lo crea con la fecha de hoy y crea la actividad
            else {
        // echo "check3<br/>";
                $userid = $this->getUserID();

                $entity = new ManagerEntity("monitoreo",$this->rutaProyecto);

                $currentdate  = date("Y-m-d H:i:s");
                $fields['fecha_creacion'] = $currentdate;
                $fields['usuario_creacion'] = $userid;
                $fields['fecha_modificacion'] = $currentdate;
                $fields['usuario_modificacion'] = $userid;
                $fields["codigoestado"] = 100;
                $fields['fecha_prox_monitoreo'] = date("Y-m-d");

                $entity->SetEntity($fields);
                $idMon = $entity->insertRecord();

                $entity = new ManagerEntity("relacionIndicadorMonitoreo",$this->rutaProyecto);
                $fields["idIndicador"] = $idIndicador;
                $fields["idMonitoreo"] = $idMon;

                $entity->SetEntity($fields);
                $entity->insertRecord();

        // echo "check11<br/>";
                $idActividad = $this->generarActividadesActualizacionIndicador($idMon);
//echo "id2 --->".$idActividad;
         //echo "check12<br/>";
                //En revisión
                $this->actualizarEstadoActividadActualizacion($idActividad, 2);
         //echo "check13<br/>";
            }

            return $this->actualizarEstadoIndicador($idIndicador,3);
        } else {
            return array("success"=>false,"message"=>"Aún no se han cargado en el sistema los documentos relacionados al indicador.");
        }
    }
    
    public function registrarRevisionCalidadIndicador ($idIndicador, $aprobado, $comentarios = ""){
        $result = "OK";
        $success = false;
        $fecha="0000-00-00";
        
        //Si es rechazado devuelve el indicador a "En proceso" y cambia la actividad a "rechazada"
        if($aprobado==0){
            if($comentarios!=""){
                $return = $this->actualizarEstadoActividadActualizacionPorIndicador($idIndicador,4);
                if($return["success"]==true){
                    $values = explode(";", $return["message"]);
                    
                    $this->generarRevisionCalidadIndicador($values[1],$comentarios,$aprobado);
                    return $this->actualizarEstadoIndicador($idIndicador,2);
                } else {
                    return $return;
                }
            } else {
                return array("success"=>$success,"message"=>"Debe contener un comentario que indique el porque se rechazo.");
            }
        } 
        //Si es aprobado cambia el indicador a "Actualizado" y cambia la actividad a "Actualizada" y se actualiza el monitoreo
        else{           
            $return = $this->actualizarEstadoActividadActualizacionPorIndicador($idIndicador,3);
            
            if($return["success"]==true){
                $values = explode(";", $return["message"]);
                //if($comentarios!=""){
                    $this->generarRevisionCalidadIndicador($values[1],$comentarios,$aprobado);   
                //}

                $userid = $this->getUserID();

                $currentdate  = date("Y-m-d H:i:s");
                $fields['fecha_creacion'] = $currentdate;
                $fields['usuario_creacion'] = $userid;
                $fields['fecha_modificacion'] = $currentdate;
                $fields['usuario_modificacion'] = $userid;
                $fields["codigoestado"] = 100;

                $mon = new ManagerEntity("monitoreo",$this->rutaProyecto);  
                $mon->sql_where = "idsiq_monitoreo = ".$values[0]."";
                //$mon->debug = true;
                $data = $mon->getData();
                $data = $data[0];

                //Si no es periodico, entonces lo inactivo
                if(($data["idPeriodicidad"]==NULL) || ($data["idPeriodicidad"]=="")){
                    $fields["codigoestado"] = 200;
                    $fields["idsiq_monitoreo"] = $values[0];
                    $mon->fieldlist["idsiq_monitoreo"]['pkey']=$values[0];
                    $mon->SetEntity($fields);

                    $mon->updateRecord();
                    
                    //inactivar la relación que ya no sirve
                    $relacion = $this->getRelacionIndicadorMonitoreo($idIndicador);
                    $entity = new ManagerEntity("relacionIndicadorMonitoreo",$this->rutaProyecto);
                    $entity->fieldlist["idsiq_relacionIndicadorMonitoreo"]['pkey']=$relacion["idsiq_relacionIndicadorMonitoreo"];
                    $relacion["codigoestado"] = 200;
                    $entity->SetEntity($relacion);
                    
                    $entity->updateRecord();                    
                }
                //Si es periodico, entonces calculo la proxima fecha de monitoreo y la actualizo y tambien pa el indicador la nueva de vcto
                else {
                    $fields["codigoestado"] = 100;
                    $fields["idsiq_monitoreo"] = $values[0];
                    
                    //verificar que haya una actividad vigente sino generarla y actualizar la relacion actividad-monitoreo
                    $activity = $this->getActividadActualizarActiva($data["idsiq_monitoreo"]);
                    
                    if($activity!=NULL&&$activity["idsiq_actividadActualizar"]!=""){                        
                       //Todo bien, solo es actualizar la fecha del monitoreo con la proxima actividad
                        $date = $activity["fecha_limite"];
                    } else {                 
                    
                        //calculo de la nueva fecha
                        $periodicidad = new ManagerEntity("periodicidad",$this->rutaProyecto);  
                        $periodicidad->sql_where = "idsiq_periodicidad = ".$data["idPeriodicidad"]."";
                        //$mon->debug = true;
                        $data2 = $periodicidad->getData();
                        $data2 = $data2[0];

                        $sign = "+";
                        if($data2["valor"]<0){
                            $sign = "";
                        }
                                                    
                            $fin_mes = false;
                            if($data["fin_de_mes"]==1){
                                $fin_mes = true;
                            }
                            $day = $data["dia_predefinido"];
                            if($day==NULL){
                                list($year,$month,$day) = explode("-",$data["fecha_prox_monitoreo"]);
                            }

                        $period = "days";
                        if($data2["tipo_valor"]==1&&$data2["valor"]==1){
                            $period = "day";
                        } else if($data2["tipo_valor"]==2){
                            $period = "month";
                            //list($year,$month,$day) = explode("-",$data["fecha_prox_monitoreo"]);
                        } else {
                            $period = "year";              
                        } 

                        if($period=="month"){
                            $date = strtotime($this->addMonth($data["fecha_prox_monitoreo"], $day,$data2["valor"]));
                        }else if($period=="year"){
                            $date = strtotime($this->addYear($data["fecha_prox_monitoreo"], $day,$data2["valor"],$fin_mes));
                        } else{
                            $date = strtotime(date("Y-m-d", strtotime($data["fecha_prox_monitoreo"])) . " ".$sign.$data2["valor"]." ".$period);
                        }

                        $date = date("Y-m-d", $date);
                        
                        //Me toca generar una nueva actividad
                        $this->generarActividadesActualizacionIndicador($data["idsiq_monitoreo"]);
                    }
                    
                    $fields['fecha_prox_monitoreo'] = $date;
                    $fecha = $date;
                    $mon->fieldlist["idsiq_monitoreo"]['pkey']=$values[0];
                    $mon->SetEntity($fields);

                    $mon->updateRecord();
                }
            } else {
                return $return;
            }
            
            return $this->actualizarEstadoIndicador($idIndicador,4,"",$fecha);
        }
    }
    
    public function generarActividadesActualizacionIndicador($idMonitoreo){
        $idActividad = null;
        $userid = $this->getUserID();
        
        $mon = new ManagerEntity("monitoreo",$this->rutaProyecto);  
        $mon->sql_where = "idsiq_monitoreo = ".$idMonitoreo."";
        //$mon->debug = true;
        $data = $mon->getData();
        $data = $data[0];
                
        $currentdate  = date("Y-m-d H:i:s");
        $fields['fecha_creacion'] = $currentdate;
        $fields['usuario_creacion'] = $userid;
        $fields['fecha_modificacion'] = $currentdate;
        $fields['usuario_modificacion'] = $userid;
        $fields["codigoestado"] = 100;
        // echo "actividades1<br/>";
        if(($data["idPeriodicidad"]==NULL) || ($data["idPeriodicidad"]=="")){
            //Tengo que inactivar las actividades anteriores
            $this->inactivateActividades($idMonitoreo,$currentdate,$userid);
             // echo "actividades2";
            $entity = new ManagerEntity("actividadActualizar",$this->rutaProyecto);
            $fields['idMonitoreo'] = $idMonitoreo;
            $fields['fecha_limite'] = $data["fecha_prox_monitoreo"];
            
            //Pendiente
            $fields['idEstado'] = 1;
			
            $entity->SetEntity($fields);
			//$entity->debug = true;
            $entity->insertRecord();
			
        } else {     
            //Tengo que inactivar las actividades anteriores
            $this->inactivateActividades($idMonitoreo,$currentdate,$userid);
             // echo "actividades3<br/>";
            //Si es periodico, creo la siguiente actividad correspondiente y todas las del año actual de una
            $entity = new ManagerEntity("actividadActualizar",$this->rutaProyecto);
            $fields['idMonitoreo'] = $idMonitoreo;
            $fields['fecha_limite'] = $data["fecha_prox_monitoreo"];
            
            //Pendiente
            $fields['idEstado'] = 1;

            $entity->SetEntity($fields);
            $entity->insertRecord();
            
            $periodicidad = new ManagerEntity("periodicidad",$this->rutaProyecto);  
            $periodicidad->sql_where = "idsiq_periodicidad = ".$data["idPeriodicidad"]."";
            //$mon->debug = true;
            $data2 = $periodicidad->getData();
            $data2 = $data2[0];
            
            $sign = "+";
            if($data2["valor"]<0){
                $sign = "";
            }
            
                $fin_mes = false;
                if($data["fin_de_mes"]==1){
                    $fin_mes = true;
                }
                $day = $data["dia_predefinido"];
                //Esto nunca deberia pasar pero por si acaso
                if($day==NULL){
                   list($year,$month,$day) = explode("-",$actividad["fecha_limite"]);
                }
            
            $period = "days";
            if($data2["tipo_valor"]==1&&$data2["valor"]==1){
                $period = "day";
            } else if($data2["tipo_valor"]==2){
                $period = "month";
                //list($year,$month,$day) = explode("-",$data["fecha_prox_monitoreo"]);
            } else {
                $period = "year";              
            }
            
            $endYear = strtotime(date("Y-m-d", strtotime(date('Y')."-12-31")));  
            
            if($period=="month"){
                $date = strtotime($this->addMonth($data["fecha_prox_monitoreo"], $day,$data2["valor"],$fin_mes));
            }else if($period=="year"){
                    $date = strtotime($this->addYear($data["fecha_prox_monitoreo"], $day,$data2["valor"],$fin_mes));
            } else{
                $date = strtotime(date("Y-m-d", strtotime($data["fecha_prox_monitoreo"])) . " ".$sign.$data2["valor"]." ".$period);
            }
                                    
            while($endYear >= $date) {
			 // echo "en el ciclo de actividades<br/>";
                $entity = new ManagerEntity("actividadActualizar",$this->rutaProyecto);
                $fields['idMonitoreo'] = $idMonitoreo;
                $fields['fecha_limite'] = date("Y-m-d",$date);

                //Pendiente
                $fields['idEstado'] = 1;

                $entity->SetEntity($fields);                
                //$entity->debug = true;
                $entity->insertRecord();
                                
                if($period=="month"){
                    $date = strtotime($this->addMonth(date("Y-m-d", $date), $day,$data2["valor"],$fin_mes));
                }else if($period=="year"){
                    $date = strtotime($this->addYear(date("Y-m-d", $date), $day,$data2["valor"],$fin_mes));
                } else{
                    $date = strtotime(date("Y-m-d", $date) . " ".$sign.$data2["valor"]." ".$period);
                } 
            }      
        }
		
		$actividad = $this->getActividadActualizarActiva($idMonitoreo);
		//var_dump($actividad);
                if($actividad==NULL||$actividad==""){
                } else {
                    $idActividad = $actividad["idsiq_actividadActualizar"];
                }
				return $idActividad;
    }
    
    function compareArrays($v1,$v2)
    {
        return strcasecmp($v1['idsiq_indicador'] , $v2['idsiq_indicador']);
    }
    
    public function generarNuevasActividadesActualizacionIndicador($db, $startDate, $endDate){
        $indicadores_responsable = $this->getQueryIndicadoresACargo();        
        
        $result2 =$db->GetAll($indicadores_responsable);
        
        if(count($result2)>0){
          $sql = "SELECT r.idIndicador, r.idsiq_relacionIndicadorMonitoreo, r.idMonitoreo, m.idPeriodicidad  
            FROM `siq_actividadActualizar` a, siq_relacionIndicadorMonitoreo r , siq_monitoreo m  
            WHERE r.idMonitoreo NOT IN ( SELECT a.idMonitoreo FROM `siq_actividadActualizar` a 
            WHERE a.`fecha_limite` between '".$startDate."' and '". $endDate."' AND a.codigoestado='100') 
            AND r.codigoestado='100' AND m.idsiq_monitoreo=r.idMonitoreo AND m.codigoestado='100' 
            AND r.idIndicador IN (".$indicadores_responsable.") 
            AND m.idPeriodicidad IS NOT NULL GROUP BY r.idMonitoreo, r.idIndicador";
          
          $sql1 = "SELECT r.idIndicador, r.idsiq_relacionIndicadorMonitoreo, r.idMonitoreo, m.idPeriodicidad  
            FROM `siq_actividadActualizar` a, siq_relacionIndicadorMonitoreo r , siq_monitoreo m  
            WHERE r.idMonitoreo NOT IN ( SELECT a.idMonitoreo FROM `siq_actividadActualizar` a 
            WHERE a.`fecha_limite` between '".$startDate."' and '". $endDate."' AND a.codigoestado='100') 
            AND r.codigoestado='100' AND m.idsiq_monitoreo=r.idMonitoreo AND m.codigoestado='100' 
            AND m.idPeriodicidad IS NOT NULL GROUP BY r.idMonitoreo, r.idIndicador";
        } /*else {
           $sql = "SELECT r.idIndicador, r.idsiq_relacionIndicadorMonitoreo, r.idMonitoreo, m.idPeriodicidad  
            FROM `siq_actividadActualizar` a, siq_relacionIndicadorMonitoreo r , siq_monitoreo m  
            WHERE r.idMonitoreo NOT IN ( SELECT a.idMonitoreo FROM `siq_actividadActualizar` a 
            WHERE a.`fecha_limite` between '".$startDate."' and '". $endDate."' AND a.codigoestado='100') 
            AND r.codigoestado='100' AND m.idsiq_monitoreo=r.idMonitoreo AND m.codigoestado='100'  
            AND m.idPeriodicidad IS NOT NULL GROUP BY r.idMonitoreo, r.idIndicador";
        }*/
        
        $result1 =$db->GetAll($sql1);
//$result2 =$db->GetAll($indicadores_responsable);
//$result =$db->GetAll($query_programa);
//var_dump($query_programa1);
//var_dump(count($result1));
//var_dump(count($result2));

//var_dump(count($result));
$result = array_uintersect($result1, $result2,"compareArrays");
     //var_dump(count($result));

        $userid = $this->getUserID();
        //var_dump($sql);die();
        
        $currentdate  = date("Y-m-d H:i:s");
        $fields['fecha_creacion'] = $currentdate;
        $fields['usuario_creacion'] = $userid;
        $fields['fecha_modificacion'] = $currentdate;
        $fields['usuario_modificacion'] = $userid;
        $fields["codigoestado"] = 100;
        
        //Pendiente
        $fields['idEstado'] = 1;
        
        $result =$db->Execute($sql);
        
        //var_dump($result);
        //var_dump($result->getArray());
        //die();
        //$i = 0;        
       // while ($row = $result->FetchRow()) {
            foreach ($result as $key => $row){
            
            //obtengo la ultima actividad activa del indicador para a partir de esa fecha crear las demás
            $actividad = $this->getUltimaActividadActualizarActiva($row["idMonitoreo"]);
            
            $mon = new ManagerEntity("monitoreo",$this->rutaProyecto);  
            $mon->sql_where = "idsiq_monitoreo = ".$row["idMonitoreo"]."";
            //$mon->debug = true;
            $monitoreo = $mon->getData();
            $monitoreo = $monitoreo[0];            
            
            $periodicidad = new ManagerEntity("periodicidad",$this->rutaProyecto);  
            $periodicidad->sql_where = "idsiq_periodicidad = ".$row["idPeriodicidad"]."";
            //$mon->debug = true;
            $data2 = $periodicidad->getData();
            $data2 = $data2[0];
            
            $sign = "+";
            if($data2["valor"]<0){
                $sign = "";
            }
            
                $fin_mes = false;
                if($monitoreo["fin_de_mes"]==1){
                    $fin_mes = true;
                }
                $day = $monitoreo["dia_predefinido"];
                if($day==NULL){
                   list($year,$month,$day) = explode("-",$actividad["fecha_limite"]);
                }
            
            $period = "days";
            if($data2["tipo_valor"]==1&&$data2["valor"]==1){
                $period = "day";
            } else if($data2["tipo_valor"]==2){
                $period = "month";
                //var_dump($monitoreo);
            } else {
                $period = "year";              
            }
            
            //$endYear = strtotime(date("Y-m-d", strtotime(date('Y',strtotime($endDate))."-12-31")));  
            $endYear = strtotime(date("Y-m-d", strtotime(date('Y',strtotime($endDate))."-".date('m',strtotime($endDate))."-".date('d',strtotime($endDate)))));  
            
            if($period=="month"){
                $date = strtotime($this->addMonth($actividad["fecha_limite"], $day,$data2["valor"],$fin_mes));
            } else if($period=="year"){
                $date = strtotime($this->addYear($actividad["fecha_limite"], $day,$data2["valor"],$fin_mes));
            } else{
                $date = strtotime(date("Y-m-d", strtotime($actividad["fecha_limite"])) . " ".$sign.$data2["valor"]." ".$period);
            }
            
            $fields['idMonitoreo'] = $row["idMonitoreo"];
            
            /*var_dump(date("Y-m-d",$date));
            var_dump(date("Y-m-d",$endYear));
            var_dump($endDate);
            var_dump($row);
            var_dump($actividad);
            var_dump($endYear >= $date);
            die();*/      
            
            //if($i>4){
               /* var_dump($row);
                var_dump($actividad);
                var_dump($monitoreo);
                //var_dump(date("Y-m-d",$date));
                //var_dump(date("Y-m-d",$endYear));
                //var_dump($endDate);
                var_dump($endYear >= $date);
                //die();*/
            //}
            //$i = $i + 1;
            
            //Creo las actividades que necesite por el resto del año
            while($endYear >= $date) {
                $entity = new ManagerEntity("actividadActualizar",$this->rutaProyecto);
                $fields['fecha_limite'] = date("Y-m-d",$date);

                $entity->SetEntity($fields);                
                //$entity->debug = true;
                $entity->insertRecord();
                                
                if($period=="month"){
                    $date = strtotime($this->addMonth(date("Y-m-d", $date), $day,$data2["valor"],$fin_mes));
                } else if($period=="year"){
                    $date = strtotime($this->addYear(date("Y-m-d", $date), $day,$data2["valor"],$fin_mes));
                } else {
                    $date = strtotime(date("Y-m-d", $date) . " ".$sign.$data2["valor"]." ".$period);                    
                }
                
                /*var_dump($row["idMonitoreo"]);
                var_dump($monitoreo);
                var_dump($fin_mes);
                var_dump($day);
                var_dump($fields);
                var_dump(date("Y-m-d",$date));
                var_dump(date("Y-m-d",$endYear));*/
            }
        }        
    }
    
    /*****
     * Funciones de uso privado por la clase 
     */    
    private function inactivateActividades($idMonitoreo,$currentdate,$userid){        
        $fields['fecha_modificacion'] = $currentdate;
        $fields['usuario_modificacion'] = $userid;
        
        $entity = new ManagerEntity("actividadActualizar",$this->rutaProyecto);  
        $entity->sql_where = "idMonitoreo = ".$idMonitoreo." AND codigoestado=100 AND idEstado=1";
        //$entity->debug = true;
        $data = $entity->getData();
        
        $i = 0;
        $row = $data[$i];
        while($row["idsiq_actividadActualizar"]!=""&&$row["idsiq_actividadActualizar"]!=NULL){
                                
            foreach ($row as $key => $value)  {
                if ((strcmp($key,"fecha_modificacion") == 0) || (strcmp($key,"usuario_modificacion") == 0)) {
                } else{ $fields[$key] = $value; }
            }
            $fields["codigoestado"] = 200;
            
            $entity->SetEntity($fields);
            $entity->fieldlist["idsiq_actividadActualizar"]['pkey']=$fields["idsiq_actividadActualizar"];
            
            $entity->updateRecord();
            
            $i = $i + 1;
            $row = $data[$i];
        }
    }
    
    /*********
     * Lo que hace es que me suma solo el mes... 
     * porque php si tengo 31 de enero + 1 mes me da 2 de marzo si febrero tiene 28 dias
     * mientras este método me retorna el 28 de febrero
     */    
    private function addMonth($date,$day2,$months,$fin_mes=false){
        list($year,$month,$day) = explode("-",$date);

        // add month here
        $month = $month + $months;
        while($month>12){
            $month = $month-12;
            $year = $year + 1;
        }
        
        if($fin_mes){
            $day = date("t",strtotime($year."-".$month."-01"));
        } else {
            // to avoid a month-wrap, set the day to the number of days of the new month if it's too high
            $day = min($day2,date("t",strtotime($year."-".$month."-01"))); 
        }

        $date = $year."-".$month."-".$day;
        
        return $date;
    }
    
    /**
     *
     * @param string $date --> fecha inicial
     * @param type $day2 --> dia predefinido 
     * @param type $years --> años a sumar
     * @param type $fin_mes --> si el dia siempre es a fin de mes o no
     * @return string 
     */
    private function addYear($date,$day2,$years,$fin_mes=false){
        list($year,$month,$day) = explode("-",$date);
        
        // add year here
        $year = $year + $years;
        
        if($fin_mes){
            $day = date("t",strtotime($year."-".$month."-01"));
        } else {
            // to avoid a month-wrap, set the day to the number of days of the new month if it's too high
            $day = min($day2,date("t",strtotime($year."-".$month."-01"))); 
        }

        $date = $year."-".$month."-".$day;
        
        return $date;
    }
    
    private function generarRevisionCalidadIndicador($idActividad,$comentarios,$aprobacion){
        
        $userid = $this->getUserID();
        
        $entity = new ManagerEntity("revisionCalidadIndicador",$this->rutaProyecto);  
                
        $currentdate  = date("Y-m-d H:i:s");
        $fields['fecha_creacion'] = $currentdate;
        $fields['usuario_creacion'] = $userid;
        $fields['fecha_modificacion'] = $currentdate;
        $fields['usuario_modificacion'] = $userid;
        $fields["codigoestado"] = 100;
        $fields["idActualizacion"] = $idActividad;
        $fields["comentarios"] = $comentarios;
        $fields["aprobado"] = $aprobacion;
        
        $entity->SetEntity($fields);
        return $entity->insertRecord();
    }
    
    private function actualizarEstadoActividadActualizacion($idActividad, $idEstado){
        $result = "OK";
        $success = false;
        
        $userid = $this->getUserID();
        if($idActividad==null || $idActividad==""){
		} else {
			$fields = array();
			$entity = new ManagerEntity("actividadActualizar",$this->rutaProyecto);
			$fields["idsiq_actividadActualizar"] = $idActividad;
			$entity->fieldlist["idsiq_actividadActualizar"]['pkey']=$idActividad;
					
			$currentdate  = date("Y-m-d H:i:s");
			$fields['fecha_modificacion'] = $currentdate;
			$fields['usuario_modificacion'] = $userid;
			$fields['idEstado'] = $idEstado;
			 //echo "Aindicador1";
			if($idEstado==3){
				$fields['fecha_actualizacion'] = date("Y-m-d"); 
				 //echo "Aindicador2";
				$fields['usuario_actualizacion'] = $this->getUsuarioResponsableActualizarIndicador($idActividad,true,$this->db,true);  
			}
			$entity->SetEntity($fields);
			 //echo "Aindicador3"; print_r($entity);
			//$entity->debug = true;
			$result = $entity->updateRecord();
			 //echo "Aindicador4";
		 }
        return array("success"=>$success,"message"=>$result);
    }
    
    private function actualizarEstadoActividadActualizacionPorIndicador($idIndicador, $idEstado){
        $result = "Error";
        $success = false;
        // echo "indicador1";
        $userid = $this->getUserID();
        // echo "indicador2";
        
        $relacion = $relacion = $this->getRelacionIndicadorMonitoreo($idIndicador); 
 //echo "indicador3";		
        $actividad = $this->getActividadActualizarActiva($relacion["idMonitoreo"]);
        // echo "indicador4"; print_r($actividad);
        if($actividad!=NULL){
            $fields = array();
            $entity = new ManagerEntity("actividadActualizar",$this->rutaProyecto);
            $fields["idsiq_actividadActualizar"] = $actividad["idsiq_actividadActualizar"];
            $entity->fieldlist["idsiq_actividadActualizar"]['pkey']=$actividad["idsiq_actividadActualizar"];

            $currentdate  = date("Y-m-d H:i:s");
            $fields['fecha_modificacion'] = $currentdate;
            $fields['usuario_modificacion'] = $userid;
            $fields['idEstado'] = $idEstado;
            if($idEstado==3){
                $fields['fecha_actualizacion'] = date("Y-m-d");  
				// echo "indicador6"; 
                $fields['usuario_actualizacion'] = $this->getUsuarioResponsableActualizarIndicador($idIndicador,false,$this->db,true);           
            }
            $entity->SetEntity($fields);
//print_r($entity);
            $entity->updateRecord();
            
            $success = true;
            $result = $actividad["idsiq_actividadActualizar"];
        } else if($idEstado==4){
			
		}
        // echo "indicador5"; 
        return array("success"=>$success,"message"=>$relacion["idMonitoreo"].";".$result);
    }
    
    public function getRelacionIndicadorMonitoreo($idIndicador, $monitoreo=false){ 
        $entity = new ManagerEntity("relacionIndicadorMonitoreo",$this->rutaProyecto);
        if($monitoreo){
            $entity->sql_where = " idMonitoreo='".$idIndicador."' ";
        } else {
            $entity->sql_where = " idIndicador='".$idIndicador."' ";
        }
        $relacion = $entity->getData();
        $relacion = $relacion[0];
        
        return $relacion;
    }
    
    public function getActividadActualizarActiva($idMonitoreo){
        $entity = new ManagerEntity("actividadActualizar",$this->rutaProyecto);
        //$entity->sql_where = " idMonitoreo='".$idMonitoreo."' AND idEstado NOT IN (3,4) ORDER BY fecha_limite ASC ";
        $entity->sql_where = " idMonitoreo='".$idMonitoreo."' AND idEstado NOT IN (3) AND codigoestado='100' ORDER BY fecha_limite ASC ";
        //$entity->debug=true;
        $actividad = $entity->getData();
        $actividad = $actividad[0];
        
        return $actividad;
    }
    
    private function getUltimaActividadActualizarActiva($idMonitoreo){
        $entity = new ManagerEntity("actividadActualizar",$this->rutaProyecto);
        //$entity->sql_where = " idMonitoreo='".$idMonitoreo."' AND idEstado NOT IN (3,4) ORDER BY fecha_limite ASC ";
        $entity->sql_where = " idMonitoreo='".$idMonitoreo."' AND codigoestado='100' ORDER BY fecha_limite DESC ";
        //$entity->debug=true;
        $actividad = $entity->getData();
        $actividad = $actividad[0];
        
        return $actividad;
    }
    
    private function checkIndicadorAdjuntos($idIndicador){
        $adjuntosCargados = true;
        
        $indicador = new ManagerEntity("indicador",$this->rutaProyecto);  
        $indicador->sql_where = "idsiq_indicador = '".$idIndicador."'";
        
            //$mon->debug = true;
        $data = $indicador->getData();
        $data = $data[0];
        
        $indicadorG = new ManagerEntity("indicadorGenerico",$this->rutaProyecto);  
        $indicadorG->sql_where = "idsiq_indicadorGenerico = '".$data["idIndicadorGenerico"]."'";
        
            //$mon->debug = true;
        $dataGen = $indicadorG->getData();
        $dataGen = $dataGen[0];
        
        $doc = new ManagerEntity("documento",$this->rutaProyecto);  
        $doc->sql_where = "codigoestado='100' AND siqindicador_id='".$idIndicador."'";
        $dataDoc = $doc->getData();
        $dataDoc = $dataDoc[0];
        
        //si es documental, percepción y numérico chequee el principal
        if($dataGen["idTipo"]==1 || $dataGen["idTipo"]==2 || $dataGen["idTipo"]==3){
            $docAnalisis = new ManagerEntity("archivo_documento",$this->rutaProyecto);  
            $docAnalisis->sql_where = "codigoestado='100' AND siq_documento_id='".$dataDoc["idsiq_documento"]."' AND tipo_documento='1'";
            $dataDocAnalisis = $docAnalisis->getData();
            
            if(count($dataDocAnalisis)==0){
                $adjuntosCargados = false;
            }
        }
        
		//ya no nos importa el analisis
        /*if($data["es_objeto_analisis"]==1){
            $docAnalisis = new ManagerEntity("archivo_documento",$this->rutaProyecto);  
            $docAnalisis->sql_where = "codigoestado='100' AND siq_documento_id='".$dataDoc["idsiq_documento"]."' AND tipo_documento='2'";
            $dataDocAnalisis = $docAnalisis->getData();
            
            if(count($dataDocAnalisis)==0){
                $adjuntosCargados = false;
            }
        }*/
        
        if($data["tiene_anexo"]==1){
            $docAnexo = new ManagerEntity("archivo_documento",$this->rutaProyecto);  
            $docAnexo->sql_where = "codigoestado='100' AND siq_documento_id='".$dataDoc["idsiq_documento"]."' AND tipo_documento='3'";
            $dataDocAnexo = $docAnexo->getData();
            
            if(count($dataDocAnexo)==0){
                $adjuntosCargados = false;
            }
            
        }
        
        return $adjuntosCargados;        
    }
    
    public function getQueryIndicadoresACargo($userid=null){
        if($userid==null){
            $userid = $this->getUserID();
        }
        
        $indicadores_responsable = "(SELECT raf.idsiq_indicador FROM v_responsableIndicadorFactor raf WHERE raf.idUsuarioResponsable='".$userid."' )
                                    UNION
                                    (SELECT rac.idsiq_indicador FROM v_responsableIndicadorCaracteristica rac WHERE rac.idUsuarioResponsable='".$userid."')        
                                    UNION
                                    (SELECT raa.idsiq_indicador FROM v_responsableIndicadorAspecto raa WHERE raa.idUsuarioResponsable='".$userid."')  
                                    UNION
                                    (SELECT gi.idsiq_indicador FROM siq_indicador gi   
                                                    JOIN siq_responsableIndicador ri ON ri.idIndicador=gi.idsiq_indicador AND ri.codigoestado='100' AND ri.idUsuarioResponsable='".$userid."' 
                                                    WHERE gi.codigoestado='100') ";  
        
        return $indicadores_responsable;
    }
	
	public function getQueryFactoresACargo($userid=null,$permisos=null){
        if($userid==null){
            $userid = $this->getUserID();
        }
		$responsabilidad = "";
		if($permisos==null){
            $responsabilidad = " AND idTipoResponsabilidad IN ($permisos)";
        }
		
        $indicadores_responsable = "(SELECT c.idFactor FROM v_responsableIndicadorFactor raf 
									INNER JOIN siq_indicador i on i.idsiq_indicador=raf.idsiq_indicador and i.codigoestado='100'   
									INNER JOIN siq_indicadorGenerico ig on ig.idsiq_indicadorGenerico=i.idIndicadorGenerico 
									INNER JOIN siq_aspecto a on a.idsiq_aspecto=ig.idAspecto  
									INNER JOIN siq_caracteristica c on c.idsiq_caracteristica=a.idCaracteristica 
									WHERE raf.idUsuarioResponsable='".$userid."' $responsabilidad 
									GROUP BY c.idFactor)
                                    UNION
                                    (SELECT c.idFactor FROM v_responsableIndicadorCaracteristica rac 
									INNER JOIN siq_indicador i on i.idsiq_indicador=rac.idsiq_indicador and i.codigoestado='100' 
									INNER JOIN siq_indicadorGenerico ig on ig.idsiq_indicadorGenerico=i.idIndicadorGenerico 
									INNER JOIN siq_aspecto a on a.idsiq_aspecto=ig.idAspecto 
									INNER JOIN siq_caracteristica c on c.idsiq_caracteristica=a.idCaracteristica									
									WHERE rac.idUsuarioResponsable='".$userid."' $responsabilidad)        
                                    UNION
                                    (SELECT c.idFactor FROM v_responsableIndicadorAspecto raa 
									INNER JOIN siq_indicador i on i.idsiq_indicador=raa.idsiq_indicador and i.codigoestado='100'  
									INNER JOIN siq_indicadorGenerico ig on ig.idsiq_indicadorGenerico=i.idIndicadorGenerico
									INNER JOIN siq_aspecto a on a.idsiq_aspecto=ig.idAspecto 
									INNER JOIN siq_caracteristica c on c.idsiq_caracteristica=a.idCaracteristica 
									WHERE raa.idUsuarioResponsable='".$userid."' $responsabilidad)  
                                    UNION
                                    (SELECT c.idFactor FROM siq_indicador gi   
									INNER JOIN siq_indicador i on i.idsiq_indicador=gi.idsiq_indicador 
									INNER JOIN siq_indicadorGenerico ig on ig.idsiq_indicadorGenerico=i.idIndicadorGenerico
									INNER JOIN siq_aspecto a on a.idsiq_aspecto=ig.idAspecto 
									INNER JOIN siq_caracteristica c on c.idsiq_caracteristica=a.idCaracteristica 
                                    INNER JOIN siq_responsableIndicador ri ON ri.idIndicador=gi.idsiq_indicador AND ri.codigoestado='100' AND ri.idUsuarioResponsable='".$userid."' $responsabilidad 
                                                    WHERE gi.codigoestado='100') ";  
        
        return $indicadores_responsable;
    }
	
	public function getQueryCaracteristicasACargo($userid=null,$permisos=null){
        if($userid==null){
            $userid = $this->getUserID();
        }
		$responsabilidad = "";
		if($permisos==null){
            $responsabilidad = " AND idTipoResponsabilidad IN ($permisos)";
        }
		
        $indicadores_responsable = "(SELECT a.idCaracteristica FROM v_responsableIndicadorFactor raf 
									INNER JOIN siq_indicador i on i.idsiq_indicador=raf.idsiq_indicador and i.codigoestado='100'   
									INNER JOIN siq_indicadorGenerico ig on ig.idsiq_indicadorGenerico=i.idIndicadorGenerico 
									INNER JOIN siq_aspecto a on a.idsiq_aspecto=ig.idAspecto  
									WHERE raf.idUsuarioResponsable='".$userid."' $responsabilidad 
									GROUP BY a.idCaracteristica)
                                    UNION
                                    (SELECT a.idCaracteristica FROM v_responsableIndicadorCaracteristica rac 
									INNER JOIN siq_indicador i on i.idsiq_indicador=rac.idsiq_indicador and i.codigoestado='100' 
									INNER JOIN siq_indicadorGenerico ig on ig.idsiq_indicadorGenerico=i.idIndicadorGenerico 
									INNER JOIN siq_aspecto a on a.idsiq_aspecto=ig.idAspecto 								
									WHERE rac.idUsuarioResponsable='".$userid."' $responsabilidad)        
                                    UNION
                                    (SELECT a.idCaracteristica FROM v_responsableIndicadorAspecto raa 
									INNER JOIN siq_indicador i on i.idsiq_indicador=raa.idsiq_indicador and i.codigoestado='100'  
									INNER JOIN siq_indicadorGenerico ig on ig.idsiq_indicadorGenerico=i.idIndicadorGenerico
									INNER JOIN siq_aspecto a on a.idsiq_aspecto=ig.idAspecto 
									WHERE raa.idUsuarioResponsable='".$userid."' $responsabilidad)  
                                    UNION
                                    (SELECT a.idCaracteristica FROM siq_indicador gi   
									INNER JOIN siq_indicador i on i.idsiq_indicador=gi.idsiq_indicador 
									INNER JOIN siq_indicadorGenerico ig on ig.idsiq_indicadorGenerico=i.idIndicadorGenerico
									INNER JOIN siq_aspecto a on a.idsiq_aspecto=ig.idAspecto 
                                    INNER JOIN siq_responsableIndicador ri ON ri.idIndicador=gi.idsiq_indicador AND ri.codigoestado='100' AND ri.idUsuarioResponsable='".$userid."' $responsabilidad 
                                                    WHERE gi.codigoestado='100') ";  
        
        return $indicadores_responsable;
    }
    
    public function getQueryIndicadoresACargoActualizar($userid=null){
        if($userid==null){
            $userid = $this->getUserID();
        }
        
        $indicadores_responsable = "(SELECT raf.idsiq_indicador FROM v_responsableIndicadorFactor raf WHERE raf.idUsuarioResponsable='".$userid."' AND raf.idTipoResponsabilidad='1' )
                                    UNION
                                    (SELECT rac.idsiq_indicador FROM v_responsableIndicadorCaracteristica rac WHERE rac.idUsuarioResponsable='".$userid."' AND rac.idTipoResponsabilidad='1')        
                                    UNION
                                    (SELECT raa.idsiq_indicador FROM v_responsableIndicadorAspecto raa WHERE raa.idUsuarioResponsable='".$userid."' AND raa.idTipoResponsabilidad='1')  
                                    UNION
                                    (SELECT gi.idsiq_indicador FROM siq_indicador gi   
                                                    JOIN siq_responsableIndicador ri ON ri.idIndicador=gi.idsiq_indicador AND ri.codigoestado='100' AND ri.idUsuarioResponsable='".$userid."' 
                                                        AND ri.idTipoResponsabilidad='1' WHERE gi.codigoestado='100') "; 
        
        return $indicadores_responsable;
    }
    
    
    
    public function getUsuarioResponsableActualizarIndicador($idIndicador, $actividad=false, $db=null, $usuActualizo=false) {
        if($db==null){
            if (!is_file("./templates/template.php"))
            {
                $ruta = "../";
                while (!is_file($ruta.'templates/template.php'))
                {
                    $ruta = $ruta."../";
                }
                include_once($ruta."templates/template.php");
            } else {
                include_once("./templates/template.php");
            }
            $db = writeHeaderBD();
            //var_dump($db);
        }
        
        $this->db = $db;
        $userid = $this->getUserID();
        
        $id = $idIndicador;
        if($actividad){
            //el id es el de la actividad y me toca encontrar el indicador
            $act = new ManagerEntity("actividadActualizar",$this->rutaProyecto);  
            $act->sql_where = "idsiq_actividadActualizar = ".$idIndicador."";
            //$mon->debug = true;
            $actividad = $act->getData();
            $actividad = $actividad[0];
            
            $relacionMonitoreo = $this->getRelacionIndicadorMonitoreo($actividad["idMonitoreo"],true);
            
            $id = $relacionMonitoreo["idIndicador"];
        }
        
        $usuario = "";
        $users = array();
         $sql="SELECT g.idsiq_indicadorGenerico,a.idsiq_aspecto as aspecto,c.idsiq_caracteristica as caracteristica,
             f.idsiq_factor as factor FROM siq_indicador i 
            inner join siq_indicadorGenerico g on g.idsiq_indicadorGenerico = i.idIndicadorGenerico  
            inner join siq_aspecto a on a.idsiq_aspecto = g.idAspecto 
            inner join siq_caracteristica c on c.idsiq_caracteristica = a.idCaracteristica 
            inner join siq_factor f on f.idsiq_factor = c.idFactor 
            WHERE idsiq_indicador='".$id."'";
         
         //var_dump($sql);
         $propiedadesIndicador = $db->GetRow($sql);
         
         //var_dump($propiedadesIndicador);
             
             //directamente con el indicador
             $sql = "SELECT CONCAT(nombres,' ',apellidos) as nombre, u.idusuario FROM usuario u 
                 inner join siq_responsableIndicador r on r.idUsuarioResponsable=u.idusuario
                 WHERE r.idIndicador='".$id."' AND r.codigoestado='100' AND r.idTipoResponsabilidad='1' GROUP BY u.idusuario";       
         
             $result = $db->Execute($sql);
             while ($row = $result->FetchRow()) {
                 array_push($users, $row['idusuario']);
                 if($usuario == ""){
                     $usuario = $row["nombre"];
                        if($userid == $row['idusuario']){
                            $actualizando = $row["nombre"];
                        }                     
                 } else {                     
                    $usuario = $usuario.", ".$row["nombre"];
                        if($userid == $row['idusuario']){
                            $actualizando = $row["nombre"];
                        }
                 }
             }
             
             //con el aspecto
             $sql = "SELECT CONCAT(nombres,' ',apellidos) as nombre, u.idusuario FROM usuario u 
                 inner join siq_responsableAspecto r on r.idUsuarioResponsable=u.idusuario
                 WHERE r.idAspecto='".$propiedadesIndicador["aspecto"]."' AND r.codigoestado='100' AND r.idTipoResponsabilidad='1' GROUP BY u.idusuario";      
             
             $result = $db->Execute($sql);
             while ($row = $result->FetchRow()) {          
                 $esta = array_search($row['idusuario'], $users);
                 if($esta!==null&&$esta!==false){
                     
                 }else{
                    if($usuario == ""){
                        $usuario = $row["nombre"];
                        if($userid == $row['idusuario']){
                            $actualizando = $row["nombre"];
                        }
                    } else {                     
                        $usuario = $usuario.", ".$row["nombre"];
                        if($userid == $row['idusuario']){
                            $actualizando = $row["nombre"];
                        }
                    }
                    array_push($users, $row['idusuario']);
                 }
             }
             
             //con la caracteristica
             $sql = "SELECT CONCAT(nombres,' ',apellidos) as nombre, u.idusuario FROM usuario u 
                 inner join siq_responsableCaracteristica r on r.idUsuarioResponsable=u.idusuario
                 WHERE r.idCaracteristica='".$propiedadesIndicador["caracteristica"]."' AND r.codigoestado='100' AND r.idTipoResponsabilidad='1' GROUP BY u.idusuario";      
             
             $result = $db->Execute($sql);
             while ($row = $result->FetchRow()) {          
                 $esta = array_search($row['idusuario'], $users);
                 if($esta!==null&&$esta!==false){
                     
                 }else{
                    if($usuario == "" ){
                        $usuario = $row["nombre"];
                        if($userid == $row['idusuario']){
                            $actualizando = $row["nombre"];
                        }
                    } else {                     
                        $usuario = $usuario.", ".$row["nombre"];
                        if($userid == $row['idusuario']){
                            $actualizando = $row["nombre"];
                        }
                    }
                    array_push($users, $row['idusuario']);
                 }
             }
             
             //con el factor
             $sql = "SELECT CONCAT(nombres,' ',apellidos) as nombre, u.idusuario FROM usuario u 
                 inner join siq_responsableFactor r on r.idUsuarioResponsable=u.idusuario
                 WHERE r.idFactor='".$propiedadesIndicador["factor"]."' AND r.codigoestado='100' AND r.idTipoResponsabilidad='1' GROUP BY u.idusuario";      
             
             $result = $db->Execute($sql);
             while ($row = $result->FetchRow()) {                 
                 $esta = array_search($row['idusuario'], $users);
                 if($esta!==null&&$esta!==false){
                     
                 }else{
                    if($usuario == ""){
                        $usuario = $row["nombre"];
                        if($userid == $row['idusuario']){
                            $actualizando = $row["nombre"];
                        }
                    } else {                     
                        $usuario = $usuario.", ".$row["nombre"];
                        if($userid == $row['idusuario']){
                            $actualizando = $row["nombre"];
                        }
                    }
                    array_push($users, $row['idusuario']);
                 }
             }
        
        if(!$usuActualizo){
            return $usuario;
        } else {
            return $actualizando;
        }
    }
    
    public function getIDUsuarioResponsableActualizarIndicador($idIndicador, $db) {        
        $this->db = $db;
        
        $id = $idIndicador;
        $users = array();
        
         $sql="SELECT g.idsiq_indicadorGenerico,a.idsiq_aspecto as aspecto,c.idsiq_caracteristica as caracteristica,
             f.idsiq_factor as factor FROM siq_indicador i 
            inner join siq_indicadorGenerico g on g.idsiq_indicadorGenerico = i.idIndicadorGenerico  
            inner join siq_aspecto a on a.idsiq_aspecto = g.idAspecto 
            inner join siq_caracteristica c on c.idsiq_caracteristica = a.idCaracteristica 
            inner join siq_factor f on f.idsiq_factor = c.idFactor 
            WHERE idsiq_indicador='".$id."'";
         
         //var_dump($sql);
         $propiedadesIndicador = $db->GetRow($sql);
         
         //var_dump($propiedadesIndicador);
             
             //directamente con el indicador
             $sql = "SELECT u.idusuario FROM usuario u 
                 inner join siq_responsableIndicador r on r.idUsuarioResponsable=u.idusuario
                 WHERE r.idIndicador='".$id."' AND r.codigoestado='100' AND r.idTipoResponsabilidad='1' GROUP BY u.idusuario";       
         
             $result = $db->Execute($sql);
             while ($row = $result->FetchRow()) {
                 array_push($users, $row['idusuario']);
             }
             
             //con el aspecto
             $sql = "SELECT u.idusuario FROM usuario u 
                 inner join siq_responsableAspecto r on r.idUsuarioResponsable=u.idusuario
                 WHERE r.idAspecto='".$propiedadesIndicador["aspecto"]."' AND r.codigoestado='100' AND r.idTipoResponsabilidad='1' GROUP BY u.idusuario";      
             
             $result = $db->Execute($sql);
             while ($row = $result->FetchRow()) {
                 $esta = array_search($row['idusuario'], $users);
                 if($esta!==null&&$esta!==false){
                     
                 }else{
                    array_push($users, $row['idusuario']);
                 }
             }
             
             //con la caracteristica
             $sql = "SELECT u.idusuario FROM usuario u 
                 inner join siq_responsableCaracteristica r on r.idUsuarioResponsable=u.idusuario
                 WHERE r.idCaracteristica='".$propiedadesIndicador["caracteristica"]."' AND r.codigoestado='100' AND r.idTipoResponsabilidad='1' GROUP BY u.idusuario";      
             
             $result = $db->Execute($sql);
             while ($row = $result->FetchRow()) {
                 $esta = array_search($row['idusuario'], $users);
                 if($esta!==null&&$esta!==false){
                     
                 }else{
                    array_push($users, $row['idusuario']);
                 }
             }
             
             //con el factor
             $sql = "SELECT u.idusuario FROM usuario u 
                 inner join siq_responsableFactor r on r.idUsuarioResponsable=u.idusuario
                 WHERE r.idFactor='".$propiedadesIndicador["factor"]."' AND r.codigoestado='100' AND r.idTipoResponsabilidad='1' GROUP BY u.idusuario";      
             
             $result = $db->Execute($sql);
             while ($row = $result->FetchRow()) {
                 $esta = array_search($row['idusuario'], $users);
                 if($esta!==null&&$esta!==false){
                     
                 }else{
                    array_push($users, $row['idusuario']);
                 }
             }
        
        return $users;
    }
    
    public function getIDUsuarioResponsableSeguimientoIndicador($idIndicador, $db) {        
        $this->db = $db;
        
        $id = $idIndicador;
        $users = array();
        
         $sql="SELECT g.idsiq_indicadorGenerico,a.idsiq_aspecto as aspecto,c.idsiq_caracteristica as caracteristica,
             f.idsiq_factor as factor FROM siq_indicador i 
            inner join siq_indicadorGenerico g on g.idsiq_indicadorGenerico = i.idIndicadorGenerico  
            inner join siq_aspecto a on a.idsiq_aspecto = g.idAspecto 
            inner join siq_caracteristica c on c.idsiq_caracteristica = a.idCaracteristica 
            inner join siq_factor f on f.idsiq_factor = c.idFactor 
            WHERE idsiq_indicador='".$id."'";
         
         //var_dump($sql);
         $propiedadesIndicador = $db->GetRow($sql);
         
         //var_dump($propiedadesIndicador);
             
             //directamente con el indicador
             $sql = "SELECT u.idusuario FROM usuario u 
                 inner join siq_responsableIndicador r on r.idUsuarioResponsable=u.idusuario
                 WHERE r.idIndicador='".$id."' AND r.codigoestado='100' AND r.idTipoResponsabilidad='2' GROUP BY u.idusuario";       
         
             $result = $db->Execute($sql);
             while ($row = $result->FetchRow()) {
                 array_push($users, $row['idusuario']);
             }
             
             //con el aspecto
             $sql = "SELECT u.idusuario FROM usuario u 
                 inner join siq_responsableAspecto r on r.idUsuarioResponsable=u.idusuario
                 WHERE r.idAspecto='".$propiedadesIndicador["aspecto"]."' AND r.codigoestado='100' AND r.idTipoResponsabilidad='2' GROUP BY u.idusuario";      
             
             $result = $db->Execute($sql);
             while ($row = $result->FetchRow()) {
                 $esta = array_search($row['idusuario'], $users);
                 if($esta!==null&&$esta!==false){
                     
                 }else{
                    array_push($users, $row['idusuario']);
                 }
             }
             
             //con la caracteristica
             $sql = "SELECT u.idusuario FROM usuario u 
                 inner join siq_responsableCaracteristica r on r.idUsuarioResponsable=u.idusuario
                 WHERE r.idCaracteristica='".$propiedadesIndicador["caracteristica"]."' AND r.codigoestado='100' AND r.idTipoResponsabilidad='2' GROUP BY u.idusuario";      
             
             $result = $db->Execute($sql);
             while ($row = $result->FetchRow()) {
                 $esta = array_search($row['idusuario'], $users);
                 if($esta!==null&&$esta!==false){
                     
                 }else{
                    array_push($users, $row['idusuario']);
                 }
             }
             
             //con el factor
             $sql = "SELECT u.idusuario FROM usuario u 
                 inner join siq_responsableFactor r on r.idUsuarioResponsable=u.idusuario
                 WHERE r.idFactor='".$propiedadesIndicador["factor"]."' AND r.codigoestado='100' AND r.idTipoResponsabilidad='2' GROUP BY u.idusuario";      
             
             $result = $db->Execute($sql);
             while ($row = $result->FetchRow()) {
                 $esta = array_search($row['idusuario'], $users);
                 if($esta!==null&&$esta!==false){
                     
                 }else{
                    array_push($users, $row['idusuario']);
                 }
             }
        
        return $users;
    }
    
    public function __destruct() {
        
    }
}

?>
