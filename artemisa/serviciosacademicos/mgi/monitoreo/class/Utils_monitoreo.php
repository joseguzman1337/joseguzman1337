<?php

/*
 * Clase con funciones generales útiles para el desarrollo de la aplicación de monitoreo
 */
// this starts the session 
 session_start(); 
 
$ruta = "../";
while (!is_file($ruta.'ManagerEntity.php'))
{
    $ruta = $ruta."../";
}
require_once($ruta.'ManagerEntity.php');
class Utils_monitoreo {
    var $rutaProyecto = "monitoreo";
    
    function __construct() {
        
    }
    
    public function processData($action,$table,$fields = array(),$usePost=true,$debug=false) {     
        if(!isset($_SESSION['MM_Username'])){
            //$_SESSION['MM_Username'] = 'admintecnologia';
            echo "No ha iniciado sesión en el sistema"; die();
        }
        
        $entity = new ManagerEntity("usuario",$this->rutaProyecto);
        $entity->sql_select = "idusuario";
        $entity->prefix ="";
        $entity->sql_where = " usuario='".$_SESSION['MM_Username']."' ";
        //$entity->debug = true;
        $data = $entity->getData();
        $userid = $data[0]['idusuario'];
        $entity = new ManagerEntity($table,$this->rutaProyecto);
        $currentdate  = date("Y-m-d H:i:s");
        $idname= "idsiq_".$table;
        $fields['fecha_modificacion'] = $currentdate;
        $fields['usuario_modificacion'] = $userid;
        $fields["codigoestado"] = 100;
        
        if($usePost){
            foreach ($_POST as $key => $value)  {
                if (strcmp($key,"action") == 0) {
                } else{ $fields[$key] = $value; }
            }
        }
        //var_dump($action);
        //exit();

        if(strcmp($action,"save")==0){
            $fields['fecha_creacion'] = $currentdate;
            $fields['usuario_creacion'] = $userid;
            return $this->saveData($entity, $fields,$debug);
        } else if(strcmp($action,"update")==0){
            return $this->updateData($entity, $fields, $idname);
        } else if(strcmp($action,"inactivate")==0){
            return $this->inactivateData($entity, $fields, $idname);
        } else if(strcmp($action,"activate")==0){
            return $this->activateData($entity, $fields, $idname);
        }

    }
    
    public function saveData($entity, $fields,$debug=false) {  
       $entity->SetEntity($fields);
       if($debug){
            $entity->debug = true;
       }
       return $entity->insertRecord();
    }
    
    public function updateData($entity, $fields, $idname) { 
        $entity->SetEntity($fields);
        $entity->fieldlist[$idname]['pkey']=$fields[$idname];
        //var_dump($_POST);
        //var_dump($entity);
        //$entity->debug = true;        
        $entity->updateRecord();
        return $fields[$idname];
    }
    
    public function inactivateData($entity, $fields, $idname) { 
        
        $entity->sql_where = "idsiq_".$entity->tablename." = ".$fields[$idname]."";
        //$entity->debug = true;
        $data = $entity->getData();
        $data = $data[0];
        
        foreach ($data as $key => $value)  {
            if ((strcmp($key,"fecha_modificacion") == 0) || (strcmp($key,"usuario_modificacion") == 0)) {
            } else{ $fields[$key] = $value; }
        }
        
        $fields["codigoestado"] = 200;
        $entity->SetEntity($fields);
        $entity->fieldlist[$idname]['pkey']=$fields[$idname];
        
        //$entity->debug = true;        
        $entity->updateRecord(); 
        return $fields[$idname];
    }
    
    
    public function activateData($entity, $fields, $idname) { 
        
        $entity->sql_where = "idsiq_".$entity->tablename." = ".$fields[$idname]."";
        //$entity->debug = true;
        $data = $entity->getData();
        $data = $data[0];
        
        foreach ($data as $key => $value)  {
            if ((strcmp($key,"fecha_modificacion") == 0) || (strcmp($key,"usuario_modificacion") == 0)) {
            } else{ $fields[$key] = $value; }
        }
        
        $fields["codigoestado"] = 100;
        $entity->SetEntity($fields);
        $entity->fieldlist[$idname]['pkey']=$fields[$idname];
        
        //$entity->debug = true;        
        $entity->updateRecord();
        return $fields[$idname];
    }    
    
    public function getActives($db,$fields,$table,$order="",$orderType="ASC",$prefix="siq_",$asArray=false) {  
        $sql = "";
        if($order!=""){
            $sql = "select ".$fields." from ".$prefix.$table." where codigoestado = '100' ORDER BY ".$order." ".$orderType;
        } else {
            $sql = "select ".$fields." from ".$prefix.$table." where codigoestado = '100'";            
        } 
        
        if($asArray){
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }
        
        return $rows;
    }
    
    public function getAll($db,$fields,$table,$order="",$orderType="ASC",$group="",$prefix="siq_",$where="") {
        $sql = "select ".$fields." from ".$prefix.$table;       
         if($where!=""){
            $sql = $sql." WHERE ".$where; 
         }
         if($group!=""){
             $sql = $sql." GROUP BY ".$group;
         }
         if($order!=""){
            $sql = $sql." ORDER BY ".$order." ".$orderType;
         }   
         
         $rows = $db->Execute($sql);  
        return $rows;
    }

   public function getAllComplex($db,$fields,$table,$where,$asArray=false) {  
        $sql = "select ".$fields." from ".$table." where ".$where;
        
        if($asArray){
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }
        
        return $rows;
    }
    
    public function getDataEntity($table,$id,$prefix="siq_") {
        $entity = new ManagerEntity($table,$this->rutaProyecto);  
        $entity->sql_where = "id".$prefix.$table." = ".$id."";
        $entity->prefix = $prefix;
        //$entity->debug = true;
        $data = $entity->getData();
        $data = $data[0];
        
        return $data;
    }
    
    public function getDataNonEntity($db,$fields,$table,$where) {  
        $row = $db->GetRow("select ".$fields." from ".$table." where ".$where);         
        return $row;
    }
    
    public function updateDataComplex($db,$fields,$table,$where) {  
        $row = $db->Execute("UPDATE ".$table." SET ".$fields." WHERE ".$where);         
        return $row;
    }
    
    public function getDataActiveEntity($table,$id,$prefix="siq_") {
        $entity = new ManagerEntity($table,$this->rutaProyecto);  
        $entity->sql_where = "id".$prefix.$table." = ".$id." AND codigoestado='100'";
        $entity->prefix = $prefix;
        //$entity->debug = true;
        $data = $entity->getData();
        $data = $data[0];
        
        return $data;
    }
        
    public function inactivateDataJoin($joinBy, $table, $id,$db, $secondaries="", $joins="") { 
        $sql = "UPDATE siq_".$table." SET codigoestado=200 WHERE ".$joinBy."=".$id;
        $result = $db->Execute($sql);
                
        if($secondaries!=""&&$joins!=""){
            $tables = explode(',', $secondaries);       
            $joinsBy = explode(',', $joins);       
            for ($i = 1; $i < count($tables); $i++) {
                if($i==1){
                    $sql = "UPDATE siq_".$tables[$i]." SET codigoestado=200 WHERE ".$joinsBy[$i]." IN (SELECT idsiq_".$tables[$i-1];
                    $sql = $sql." FROM siq_".$tables[$i-1]." WHERE ".$joinsBy[$i-1]."=".$id.")";
                    $result = $db->Execute($sql);
                } else if ($i==2){
                    $sql = "UPDATE siq_".$tables[$i]." SET codigoestado=200 WHERE ".$joinsBy[$i]." IN (SELECT idsiq_".$tables[$i-1];
                    $sql = $sql." FROM siq_".$tables[$i-1]." WHERE ".$joinsBy[$i-1]." IN (SELECT idsiq_".$tables[$i-2];
                    $sql = $sql." FROM siq_".$tables[$i-2]." WHERE ".$joinsBy[$i-2]."=".$id."))";
                    $result = $db->Execute($sql);                    
                } else if ($i==3){
                    $sql = "UPDATE siq_".$tables[$i]." SET codigoestado=200 WHERE ".$joinsBy[$i]." IN (SELECT idsiq_".$tables[$i-1];
                    $sql = $sql." FROM siq_".$tables[$i-1]." WHERE ".$joinsBy[$i-1]." IN (SELECT idsiq_".$tables[$i-2];
                    $sql = $sql." FROM siq_".$tables[$i-2]." WHERE ".$joinsBy[$i-2]." IN (SELECT idsiq_".$tables[$i-3];
                    $sql = $sql." FROM siq_".$tables[$i-3]." WHERE ".$joinsBy[$i-3]."=".$id.")))";
                    $result = $db->Execute($sql);                    
                }
            }
         } 
        
        return $result;
    }  
    
    public function getDataEntityJoin($table,$joinBy,$value,$prefix="siq_") {
        $entity = new ManagerEntity($table,$this->rutaProyecto);  
        $entity->sql_where = $joinBy." = ".$value;
        $entity->prefix = $prefix;
        //$entity->debug = true;
        $data = $entity->getData();
        $data = $data[0];
        
        return $data;
    }
    
    public function getResponsabilidadesIndicador($db,$idIndicador) {
        $return = array();
        $responsabilidad = "";
        //$responsabilidadTodas = "";
        $ids = array();
        //$idsTodas = array();
        
        $userid = $this->getIDUsuario();
         //$tiposResponsabilidad = array();
         $rows = $db->GetAll("SELECT idsiq_tipoResponsabilidad,nombre FROM siq_tipoResponsabilidad WHERE codigoestado='100'");
         
         $sql="SELECT g.idsiq_indicadorGenerico,a.idsiq_aspecto as aspecto,c.idsiq_caracteristica as caracteristica,
             f.idsiq_factor as factor FROM siq_indicador i 
            inner join siq_indicadorGenerico g on g.idsiq_indicadorGenerico = i.idIndicadorGenerico  
            inner join siq_aspecto a on a.idsiq_aspecto = g.idAspecto 
            inner join siq_caracteristica c on c.idsiq_caracteristica = a.idCaracteristica 
            inner join siq_factor f on f.idsiq_factor = c.idFactor 
            WHERE idsiq_indicador='".$idIndicador."'";
         
         $propiedadesIndicador = $db->GetRow($sql);
         
         //var_dump($propiedadesIndicador);
         
         $num = count($rows);
         for($i=0; $i < $num; $i++){
             $total = 0;
             
             //directamente con el indicador
             $sql = "SELECT COUNT('idIndicador') FROM siq_responsableIndicador WHERE idIndicador='".$idIndicador."' AND codigoestado='100' 
                 AND idUsuarioResponsable='".$userid."' AND idTipoResponsabilidad='".$rows[$i]["idsiq_tipoResponsabilidad"]."'";       
         
             $row = $db->GetRow($sql);
             
             $total = $total + intval($row[0]);
             
             //con el aspecto
             $sql = "SELECT COUNT('idAspecto') FROM siq_responsableAspecto WHERE idAspecto='".$propiedadesIndicador["aspecto"]."' AND codigoestado='100' 
                 AND idUsuarioResponsable='".$userid."' AND idTipoResponsabilidad='".$rows[$i]["idsiq_tipoResponsabilidad"]."'";    
             
             $row = $db->GetRow($sql);
             
             $total = $total + intval($row[0]);
             
             //con la caracteristica
             $sql = "SELECT COUNT('idCaracteristica') FROM siq_responsableCaracteristica WHERE idCaracteristica='".$propiedadesIndicador["caracteristica"]."' AND codigoestado='100' 
                 AND idUsuarioResponsable='".$userid."' AND idTipoResponsabilidad='".$rows[$i]["idsiq_tipoResponsabilidad"]."'";    
             
             $row = $db->GetRow($sql);
             
             $total = $total + intval($row[0]);
             
             //con el factor
             $sql = "SELECT COUNT('idFactor') FROM siq_responsableFactor WHERE idFactor='".$propiedadesIndicador["factor"]."' AND codigoestado='100' 
                 AND idUsuarioResponsable='".$userid."' AND idTipoResponsabilidad='".$rows[$i]["idsiq_tipoResponsabilidad"]."'";    
             
             $row = $db->GetRow($sql);
             
             $total = $total + intval($row[0]);
             
             $pre = ", ";
             /*if($responsabilidadTodas!=""){
                 $responsabilidadTodas = $responsabilidadTodas.$pre.$rows[$i]["nombre"];
             } else {
                 $responsabilidadTodas = $responsabilidadTodas.$rows[$i]["nombre"];
             }
             
             array_push($idsTodas,$rows[$i]["idsiq_tipoResponsabilidad"]);*/
             
             if( ($responsabilidad!="") && ($total>0) ){
                 $responsabilidad = $responsabilidad.$pre.$rows[$i]["nombre"];
                array_push($ids,$rows[$i]["idsiq_tipoResponsabilidad"]);
             } else if($total>0){
                 $responsabilidad = $responsabilidad.$rows[$i]["nombre"];
                array_push($ids,$rows[$i]["idsiq_tipoResponsabilidad"]);
             }
             
         }
        
        /*if($responsabilidad==""){
            $responsabilidad = $responsabilidadTodas;
            $ids = $idsTodas;
        }*/
        
        $return[0]=$responsabilidad;
        $return[1]=$ids;
        
        return $return;
    }
    
   private function getIDUsuario(){
       if(!isset($_SESSION['MM_Username'])){
            //$_SESSION['MM_Username'] = 'admintecnologia';
           echo "No ha iniciado sesión en el sistema"; exit();
        }
                
        $entity = new ManagerEntity("usuario",$this->rutaProyecto);
        $entity->sql_select = "idusuario";
        $entity->prefix ="";
        $entity->sql_where = " usuario='".$_SESSION['MM_Username']."' ";
        //$entity->debug = true;
        $data = $entity->getData();
        $userid = $data[0]['idusuario'];
        
        return $userid;
   }
   
   public function getPeriodicidadesMonitoreo($db,$asArray=false) {  

        $sql = "select periodicidad,idsiq_periodicidad from siq_periodicidad where codigoestado = '100' 
                AND aplica_monitoreo='1' ORDER BY periodicidad ASC";        
        
        if($asArray){
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }
        
        return $rows;
    }
    
    public function getPeriodicidadesAlerta($db,$asArray=false) {  
        $sql = "select periodicidad,idsiq_periodicidad from siq_periodicidad where codigoestado = '100' 
                AND aplica_alerta='1' ORDER BY periodicidad ASC";
        
        if($asArray){
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }
        
        return $rows;
    }
    
    public function getAreasIndicadores($db,$active=true,$asArray=false) {  

        $sql = "select nombre,idsiq_area from siq_area where disponible='0' ";
        if($active){
            $sql = $sql . "AND codigoestado = '100' ";
        }
        $sql = $sql . "ORDER BY nombre ASC";        
        
        if($asArray){
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }
        
        return $rows;
    }
    
    public function getFacultadesConProgramas($db,$asArray=false) {  
        $currentdate  = date("Y-m-d H:i:s");
        $sql = "select f.codigofacultad,f.nombrefacultad from facultad f 
            inner join carrera c on c.codigofacultad=f.codigofacultad WHERE c.fechavencimientocarrera>'".$currentdate."' 
             GROUP BY f.codigofacultad ORDER BY nombrefacultad ASC";        
        
        if($asArray){
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }
        
        return $rows;
    }
    
    public function getDocumentoIndicador($db,$idIndicador) {  
        
        $sql = "SELECT idsiq_documento FROM siq_documento WHERE codigoestado='100' AND siqindicador_id='".$idIndicador."' ";        
        $row = $db->GetRow($sql);
        
        return $row;
    }
        
    public function esIndicadorExterno($db,$idIndicador) {  
        $externo = false;
        
        $sql = "SELECT externo FROM siq_funcionIndicadores WHERE codigoestado='100' AND idIndicador='".$idIndicador."' ";        
        $row = $db->GetRow($sql);
        if($row["externo"]==1){
            $externo = true;
        }
        
        return $externo;
    }
    
    public function getUser(){
        if(!isset($_SESSION['MM_Username'])){
            //$_SESSION['MM_Username'] = 'admintecnologia';
            echo "No ha iniciado sesión en el sistema"; die();
        }
        $entity = new ManagerEntity("usuario",$this->rutaProyecto);
        $entity->sql_select = "idusuario,usuario,nombres,apellidos";
        $entity->prefix ="";
        $entity->sql_where = " usuario='".$_SESSION['MM_Username']."' ";
        
        $data = $entity->getData();
        $user = $data[0];
        
        return $user;
    }
    
    function __destruct() {
        
    }
}

?>
