<?php

/*
 * Clase con funciones generales útiles para el desarrollo de la aplicación de monitoreo
 */
require_once('ManagerEntity.php');
class Utils_monitoreo {
    function __construct() {
        
    }
    
    public function processData($action,$table,$fields) {     

        if(!isset($_SESSION['MM_Username'])){
            $_SESSION['MM_Username'] = 'admintecnologia';
        }
        $fields = array();
        $entity = new ManagerEntity("usuario");
        $entity->sql_select = "idusuario";
        $entity->prefix ="";
        $entity->sql_where = " usuario='".$_SESSION['MM_Username']."' ";
        //$entity->debug = true;
        $data = $entity->getData();
        $userid = $data[0]['idusuario'];
        $entity = new ManagerEntity($table);
        $currentdate  = date("Y-m-d H:i:s");
        $idname= "idsiq_".$table;
        $fields['fecha_modificacion'] = $currentdate;
        $fields['usuario_modificacion'] = $userid;
        
        foreach ($_POST as $key => $value)  {
            if (strcmp($key,"action") == 0) {
            } else{ $fields[$key] = $value; }
        }
        //var_dump($fields);
        //exit();

        if(strcmp($action,"save")==0){
            $fields['fecha_creacion'] = $currentdate;
            $fields['usuario_creacion'] = $userid;
            return $this->saveData($entity, $fields);
        } else if(strcmp($action,"update")==0){
            return $this->updateData($entity, $fields, $idname);
        } else if(strcmp($action,"inactivate")==0){
            return $this->inactivateData($entity, $fields, $idname);
        } else if(strcmp($action,"activate")==0){
            return $this->activateData($entity, $fields, $idname);
        }

    }
    
    public function saveData($entity, $fields) {    
       $entity->SetEntity($fields);
       return $entity->insertRecord();
    }
    
    public function updateData($entity, $fields, $idname) { 
        $entity->SetEntity($fields);
        $entity->fieldlist[$idname]['pkey']=$fields[$idname];
        //var_dump($fields[$idname]);
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
        
        $fields["cod_estado"] = 200;
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
        
        $fields["cod_estado"] = 100;
        $entity->SetEntity($fields);
        $entity->fieldlist[$idname]['pkey']=$fields[$idname];
        
        //$entity->debug = true;        
        $entity->updateRecord();
        return $fields[$idname];
    }    
    
    public function getActives($db,$fields,$table) {     
        $rows = $db->Execute("select ".$fields." from siq_".$table." where cod_estado = '100'");
        return $rows;
    }
    
    public function getAll($db,$fields,$table) {     
        $rows = $db->Execute("select ".$fields." from siq_".$table);
        return $rows;
    }
    
    public function getDataEntity($table,$id,$prefix="siq_") {
        $entity = new ManagerEntity($table);  
        $entity->sql_where = "id".$prefix.$table." = ".$id."";
        $entity->prefix = $prefix;
        //$entity->debug = true;
        $data = $entity->getData();
        $data = $data[0];
        
        return $data;
    }
    
    
    function __destruct() {
        
    }
}

?>
