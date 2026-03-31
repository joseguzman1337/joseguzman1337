<?php

/*
 * Clase con funciones generales útiles para el desarrollo de la aplicación de monitoreo
 */
$ruta = "../";
while (!is_file($ruta.'ManagerEntity.php'))
{
    $ruta = $ruta."../";
}
require_once($ruta.'ManagerEntity.php');
class Utils_numericos {
    var $rutaProyecto = "sign_numericos";
    
    function __construct() {
        
    }
    
    public function processData($action,$table,$resultado , $porcentaje,$fields = array(),$usePost=true) {  
         //var_dump("HOLA entre");
       
        if(!isset($_SESSION['MM_Username'])){
            $_SESSION['MM_Username'] = 'admintecnologia';
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
       
        //exit();
       
        //die();

        if(strcmp($action,"save")==0){
            $fields['fecha_creacion'] = $currentdate;
            $fields['usuario_creacion'] = $userid;
             //$entity->debug = true;
             //var_dump($entity);
            return $this->saveData($entity, $fields);
        }else if(strcmp($action,"save1")==0){
             $fields['fecha_creacion'] = $currentdate;
            $fields['usuario_creacion'] = $userid;
             $fields['resultado'] =$resultado;
              $fields['porcentaje'] = $porcentaje;
              //$entity->debug = true;
              //var_dump($entity);
              // die();
             return $this->saveData($entity, $fields);
        }else if(strcmp($action,"update1")==0){
             $fields['fecha_creacion'] = $currentdate;
            $fields['usuario_creacion'] = $userid;
             $fields['resultado'] =$resultado;
              $fields['porcentaje'] = $porcentaje;
              //$entity->debug = true;
              //var_dump($entity);
              // die();
           return $this->updateData($entity, $fields, $idname);
        }else if(strcmp($action,"update")==0){
            return $this->updateData($entity, $fields, $idname);
        } else if(strcmp($action,"inactivate")==0){
            return $this->inactivateData($entity, $fields, $idname);
        } else if(strcmp($action,"activate")==0){
            return $this->activateData($entity, $fields, $idname);
        }

    }
    
    public function saveData($entity, $fields) {  
       $entity->SetEntity($fields);
       //$entity->debug = true;
      //var_dump($entity);
       // die();
       return $entity->insertRecord();
    }
    
    public function updateData($entity, $fields, $idname) { 
        
        $entity->SetEntity($fields);
        $entity->fieldlist[$idname]['pkey']=$fields[$idname];
             
        $entity->updateRecord();
        return $fields[$idname];
    }
    
    public function inactivateData($entity, $fields, $idname) { 
         
        $entity->sql_where = "idsiq_".$entity->tablename." = ".$fields[$idname]."";
       
        $data = $entity->getData();
        $data = $data[0];
        foreach ($data as $key => $value)  {
            if ((strcmp($key,"fecha_modificacion") == 0) || (strcmp($key,"usuario_modificacion") == 0)) {
            } else{ $fields[$key] = $value; }
        }
        
        $fields["codigoestado"] = 200;
        $entity->SetEntity($fields);
        $entity->fieldlist[$idname]['pkey']=$fields[$idname];
        
         
        $entity->updateRecord();
        // var_dump($entity);
        //die();
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
        //var_dump($sql);
        //die();
        if($asArray){
            $rows = $db->GetAll($sql);
        } else {
            $rows = $db->Execute($sql);
        }
        
        return $rows;
    }
    
     public function getActivesFuncion($db,$fields,$table,$order="",$orderType="ASC",$prefix="siq_",$asArray=false) {  
        $sql = "";
        if($order!=""){
            $sql = "select ".$fields." from ".$prefix.$table."  ORDER BY ".$order." ".$orderType;
        } else {
            $sql = "select ".$fields." from ".$prefix.$table." ";            
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
        $data = $entity->getData();
        $data = $data[0];
        
        return $data;
    }
    
    public function getDataNonEntity($db,$fields,$table,$where) {  
        $row = $db->GetRow("select ".$fields." from ".$table." where ".$where);         
        return $row;
    }
    
    public function getDataActiveEntity($table,$id,$prefix="siq_") {
        $entity = new ManagerEntity($table,$this->rutaProyecto);  
        $entity->sql_where = "id".$prefix.$table." = ".$id." AND codigoestado=100";
        $entity->prefix = $prefix;
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
        // var_dump($result);
        return $result;
    }  
    
    public function getDataEntityJoin($table,$joinBy,$value,$prefix="siq_") {
        $entity = new ManagerEntity($table,$this->rutaProyecto);  
        $entity->sql_where = $joinBy." = ".$value;
        $entity->prefix = $prefix;
        $data = $entity->getData();
        $data = $data[0];
        
        return $data;
    }
    
    function __destruct() {
        
    }
}

?>
