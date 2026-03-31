<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of table
 *
 * @author stipmp
 */
include 'db.inc';

class Table {
    //put your code here
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
    
    function Table($name) {
        $this->tablename = $name;
    }
    
    
    
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

        if ($rows_per_page > 0) {
        $limit_str = 'LIMIT ' .($pageno - 1) * $rows_per_page .',' .$rows_per_page;
        } else {
        $limit_str = NULL;
        } // if
        
        $query = "SELECT $select_str
            FROM $from_str 
                 $where_str 
                 $group_str 
                 $having_str 
                 $sort_str 
                 $limit_str";
            if ($this->debug == true){
                echo $query;
            }
            $dbconnect = db_connect($this->dbname) or trigger_error("SQL", E_USER_ERROR);
            $result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_ERROR);
            $array = array();
            while ($row = mysql_fetch_assoc($result)) {
            $array[] = $row;
            } // while

            mysql_free_result($result);
            return $array;
    }
    function setFields(){        
        global $dbconnect, $query;
        $dbconnect = db_connect($this->dbname) or trigger_error("SQL", E_USER_ERROR);
        $query = "SELECT * FROM $this->tablename LIMIT  1";              
        if($this->debug == true){
            echo $query;
            exit();
        }
        $result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_ERROR); 
        $row = mysql_fetch_assoc($result);
        foreach ($row as $value => $key){                
            $setFields[] = $value;
        }
        $this->fieldlist = $setFields;
    }

    function updateRecord ($fieldarray){
      $this->errors = array();
      global $dbconnect, $query;
      $dbconnect = db_connect($this->dbname) or trigger_error("SQL", E_USER_ERROR);
      $fieldlist = $this->fieldlist;
      //print_r($fieldlist);
      foreach ($fieldarray as $field => $fieldvalue) {
         if (!in_array($field, $fieldlist)) {
            unset ($fieldarray[$field]);
         } // if
      } // foreach
      $where  = NULL;
      $update = NULL;
      foreach ($fieldarray as $item => $value) {
         if (isset($fieldlist[$item]['pkey'])) {
            $where .= "$item='$value' AND ";
         } else {
            $update .= "$item='$value', ";
         } // if
      } // foreach
      $where  = rtrim($where, ' AND ');
      $update = rtrim($update, ', ');
      $query = "UPDATE $this->tablename SET $update WHERE $where";       
      if($this->debug == true){
          echo $query;
          exit();
      }
      $result = mysql_query($query, $dbconnect) or trigger_error("SQL", E_USER_ERROR);      
      return;
   } // updateRecord
   
   function insertRecord ($fieldarray){
      $this->errors = array();
      global $dbconnect, $query;
      $dbconnect = db_connect($this->dbname) or trigger_error("SQL", E_USER_ERROR);
      $fieldlist = $this->fieldlist;
      foreach ($fieldarray as $field => $fieldvalue) {
         if (!in_array($field, $fieldlist)) {
            unset ($fieldarray[$field]);
         } // if
      } // foreach
      $query = "INSERT INTO $this->tablename SET ";
      foreach ($fieldarray as $item => $value) {
         $query .= "$item='$value', ";
      } // foreach
      $query = rtrim($query, ', ');
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
      return;   	   
   } // insertRecord
}

?>
