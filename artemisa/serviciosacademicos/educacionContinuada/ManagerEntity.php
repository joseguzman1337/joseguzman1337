<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ManagerEntity
 *
 * @author Administrador
 */
//header( 'Content-type: text/html; charset=ISO-8859-1' );

$ruta = "";
    while (!is_file($ruta.'mgi/db_1.inc'))
    {
            $ruta = $ruta."../";
    }

require $ruta.'mgi/db_1.inc';


class ManagerEntity {
    //put your code here     
    var $calssobj=null;
    var $class = null;
    var $headers=null;
    var $entity=null;
    var $tablename = null;
    var $sql_select = null;
    var $sql_from = null;
    var $sql_where = null;
    var $sql_groupby= null;
    var $sql_having = null;
    var $sql_orderby = null ;
    var $errors = null;
    var $fieldlist = null;
    var $debug = null;
    var $prefix = "";
    var $dbname = "sala";
    
    function __construct($entity) {
        $file = $entity."Class.php";
        $this->tablename = $entity;
        $this->entity = $entity."Class";
        
        if(file_exists(dirname(__FILE__)."/class/".$file) or file_exists(dirname(__FILE__)."\class\"".$file)){
            if(file_exists(dirname(__FILE__)."/class/".$file)){
                $classfile = dirname(__FILE__)."/class/".$file; 
                include_once $classfile;                
            }else{
                $classfile = dirname(__FILE__)."\class\"".$file;
                include_once $classfile;                  
            }
            $this->class = $this->createEntity($this->entity);
            $this->calssobj = $this->object_to_array(new $this->class);
        }else{
            return false;
        }
    }
    
    function createEntity(){        
        return new $this->entity;
    }
    
    function  object_to_array($mixed) {
        if(is_object($mixed)) $mixed = (array) $mixed;
            if(is_array($mixed)) {
            $new = array();
            foreach($mixed as $key => $val) {
                $key = preg_replace("/^\\0(.*)\\0/","",$key);
                $new[$key] = $val;
            }
        }
        else $new = $mixed;
        return $new;
    }
    
    
    function SetEntity($data){
        foreach ($this->calssobj as $name=>$value){
            $set = "set".$name;
            if (array_key_exists($name, $data))$this->class->$set($data["$name"]);
        }        
    }
    
    function updateRecord (){
      $this->errors = array();
      global $dbconnect, $query;
      $dbconnect = db_connect() or trigger_error("SQL", E_USER_ERROR);
      $fieldlist = $this->fieldlist;

      $where  = NULL;
      $update = NULL;
      
      foreach ($this->object_to_array($this->class) as $item => $value) {
         if (isset($fieldlist[$item]['pkey'])) {
            $where .= "$item='$value' AND ";
         } else {
             //var_dump($value);
             if($value!=""){ 
                 if(strcmp($value,"NULL")==0){
                     $update .= "$item=NULL, ";
                 } else {
                    $update .= "$item='$value', ";
                 }
             }
         } // if
      } // foreach
      $where  = rtrim($where, ' AND ');
      $update = rtrim($update, ', ');
      $query = "UPDATE $this->prefix$this->tablename SET $update WHERE $where";  
   
      global $dbconnect;
      $dbconnect = db_connect() or trigger_error("SQL", E_USER_ERROR);
        
      if($this->debug == true){
          echo utf8_decode($query);
          exit();
      }
      $result = mysql_query($query, $dbconnect);   
     
      return;
   } // updateRecord
    
   function insertquery($query){

        $this->errors = array();
        global $dbconnect;
        $dbconnect = db_connect() or trigger_error("SQL", E_USER_ERROR);
        if($this->debug == true){
            echo $query;            
            exit();
        }       
        
        $result = @mysql_query($query, $dbconnect);
        
        if (mysql_errno() <> 0) {
            if (mysql_errno() == 1062) {
            $this->errors[] = "A record already exists with this ID.";
            } else {
            trigger_error("SQL", E_USER_ERROR);
            } // if
        } // if
        $id = mysql_insert_id();
        return $id;
    }
    
    function insertRecord (){
        $this->errors = array();
        global $dbconnect, $query;
        $dbconnect = db_connect() or trigger_error("SQL", E_USER_ERROR);
        $fieldlist = $this->fieldlist;

        $query = "INSERT INTO $this->prefix$this->tablename SET ";
        
        foreach ($this->object_to_array($this->class) as $item => $value) {
            if($value!=""){
                $query .= "$item='$value', ";
            }
        } // foreach
        $query = rtrim($query, ', ');
        $query = $query;
        if($this->debug == true){
            echo $query;            
            exit();
        }       
      
        $result = @mysql_query($query, $dbconnect);
        if (mysql_errno() <> 0) {
            if (mysql_errno() == 1062) {
            $this->errors[] = "A record already exists with this ID.";
            } else {
            trigger_error("SQL", E_USER_ERROR);
            } // if
        } // if
        $id = mysql_insert_id();
        return $id;
    } // insertRecord
    
    
    function deleteRecord (){
      $this->errors = array();
      global $dbconnect, $query;
      $dbconnect = db_connect() or trigger_error("SQL", E_USER_ERROR);
      $fieldlist = $this->fieldlist;
      $where  = NULL;
      
      foreach ($this->object_to_array($this->class) as $item => $value) {      
              
         if (isset($fieldlist[$item]['pkey'])) {
            $where .= "$item='$value' AND ";
         } else {
            if ($item=='usuariomodificacion' or $item=='fechamodificacion') {
                $update .= "$item='$value', ";
             }
         } 
         
      } // foreach
      $where  = rtrim($where, ' AND ');
      $query = "UPDATE $this->prefix$this->tablename SET ".$update." codigoestado='200' WHERE $where";
     // print $query;
      if ($this->debug == true){
                echo $query;
                exit();
            }
      $result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_ERROR);      
      return;
      
   } // deleteRecord
   
    function getData($sql_where=""){
        if (empty($this->sql_select)) {
            $select_str = '*';    // the default is all fields
        } else {
            $select_str = $this->sql_select;
        } // if

        if (empty($this->sql_from)) {
            $from_str = $this->tablename;   // the default is current table
        } else {
            $from_str = $this->sql_from;
        } // if    
        
        if (empty($where)) {
            $where_str = NULL;
        } else {
            $where_str = "WHERE $where";
        } // if

        if (!empty($this->sql_where)) {
            if (!empty($where_str)) {
                $where_str .= " AND $this->sql_where";
            } else {
                $where_str = "WHERE $this->sql_where";
            } // if
        } // if
        if (!empty($this->sql_groupby)) {
        $group_str = "GROUP BY $this->sql_groupby";
        } else {
        $group_str = NULL;
        } // if

        if (!empty($this->sql_having)) {
        $having_str = "HAVING $this->sql_having";
        } else {
        $having_str = NULL;
        } // if

        if (!empty($this->sql_orderby)) {
        $sort_str = "ORDER BY $this->sql_orderby";
        } else {
        $sort_str = NULL;
        } // if
        
        /**
         * Caso 2812 
         * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
         * Se valida si existe o esta definida la variable $rows_per_page 
         * @since  Julio 17, 2019.
        */
    
        if (isset($rows_per_page) &&  $rows_per_page > 0) {
        $limit_str = 'LIMIT ' .($pageno - 1) * $rows_per_page .',' .$rows_per_page;
        } else {
        $limit_str = NULL;
        } // if
        
        $query = "SELECT $select_str
            FROM $this->prefix$from_str 
                 $where_str 
                 $group_str 
                 $having_str 
                 $sort_str 
                 $limit_str";
            if ($this->debug == true){
                echo $query . '<br>';
            }         
            
            $dbconnect = db_connect($this->dbname) or trigger_error("SQL", E_USER_ERROR);
            
            $query = utf8_decode($query);            
            //echo $query;
            $result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_ERROR);
            $array = array();
            while ($row = mysql_fetch_assoc($result)) {
            $array[] = $row;
            } // while
            
            mysql_free_result($result);
            return $array;
    }
    
    function __destruct() {
        
    }
    
}