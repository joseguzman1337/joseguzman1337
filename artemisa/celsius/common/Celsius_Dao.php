<?php
require_once "Zend__Select.php";
require_once "../exceptions/DuplicateKey_Exception.php";

class Celsius_Dao {
	function Celsius_Dao(){
		
		require_once "Configuracion.php";
		$dbParams["host"] = Configuracion::get_DB_Host().":".Configuracion::get_DB_Port();
		$dbParams["username"] = Configuracion::get_DB_User();
		$dbParams["password"] = Configuracion::get_DB_Password();
		$dbParams["dbname"] = Configuracion::get_DB_DatabaseName();
		$conn = mysql_connect($dbParams['host'],$dbParams['username'],$dbParams['password']);
		if ($conn===FALSE)
			return $this->createException("No se pudo establecer la conexion con la BBDD");
		
		$res = mysql_select_db($dbParams['dbname']);
		if ($res===FALSE)
			return $this->createException("No se pudo seleccionar la BBDD");
		
	}
	
	/**
	 * Genera una excepcion de BDD
	 * @throws DB_exception
	 */
	function createException($message){
		$errNo = mysql_errno();
		if ($errNo == 1022 || $errNo == 1062)
			//codigo de errores de mysql para claves duplicadas
			return new DuplicateKey_Exception($message,mysql_error(), $errNo);
		else
			return new DB_Exception($message,mysql_error(), $errNo);
	}
	
	function insert($table, $bind){
        // col names come from the array keys
        $cols = array_keys($bind);

        // build the statement
        $sql = "INSERT INTO $table "
             . '(' . implode(', ', $cols) . ') '
             . 'VALUES (:' . implode(', :', $cols) . ')';
		
		// execute the statement and return the number of affected rows
        $result=$this->query($sql,$bind);
        
        if (is_a($result, "Celsius_Exception"))
			return $result;
						
        return $this->last_insert_id();
    }
	
	function updateAll($table, $bind, $where){
		return $this->update($table, $bind, $where, 0);
	}
	
	/**
	 * @param string where contiene la condicion para modificacion. no puede ser blanco, 
	 * si lo que se quiere hacer es actualizar el contenido de toda la tabla, se debe
	 *  enviar 1 como valor del where
	 */
    
	function update($table, $bind, $where, $limit = 1)
    {
        if (empty($where))
    		return new DB_Exception("Debe especificar el valor del parametro where.");
    		
        // build "col = :col" pairs for the statement
        $set = array();
        foreach ($bind as $col => $val) {
            $set[] = "$col = :$col";
        }
		
		if (is_array($where)){
			$AUX = "";
			foreach($where as $conditionName => $conditionValue){
				if ($AUX !== "")
					$AUX.=" AND ";
				$AUX.="($conditionName = '$conditionValue')";
			}
			$where = $AUX;
		}
		
        // build the statement
        $sql = "UPDATE $table "
             . 'SET ' . implode(', ', $set)
             . (($where) ? " WHERE $where" : '');
        
        if (!empty($limit))
        	$sql .= " LIMIT $limit";
		// execute the statement and return the number of affected rows
        $result = $this->query($sql, $bind);
        if (is_a($result, "Celsius_Exception"))
			return $result;
			
        return $this->affected_rows();
    }
    
	function deleteAll($table, $where){
		return $this->delete($table, $where,0);
	}
	
	/**
	 * @param string where contiene la condicion para borrado. no puede ser blanco, 
	 * si lo que se quiere hacer esborrar el contenidod e toda la tabla, se debe
	 *  enviar 1 como valor del where
	 */
    function delete($table, $where,$limit = 1){
    	if (empty($where))
    		return new DB_Exception("Debe especificar el valor del parametro where.");
        // build the statement
        $sql = "DELETE FROM $table "
             . (($where) ? " WHERE $where" : '');

		if (!empty($limit))
        	$sql .= " LIMIT $limit";
        // execute the statement and return the number of affected rows
        $result = $this->query($sql);
        if (is_a($result, "Celsius_Exception"))
			return $result;
			
        return $this->affected_rows();
    }
    
	function affected_rows(){
	   return mysql_affected_rows();	

	}
	
	function insertOnDuplicate($table, $bind){
        // col names come from the array keys
        $cols = array_keys($bind);

        // build the statement
        $sql = "INSERT INTO $table "
             . '(' . implode(', ', $cols) . ') '
             . 'VALUES (:' . implode(', :', $cols) . ')';

        // execute the statement and return the number of affected rows
        $result=$this->query($sql,$bind);
        if (is_a($result, "Celsius_Exception"))
			return $result;
			
        return $this->last_insert_id();
    }
	
	
	
	
	
	function query($sql, $bind=array()){
		
		foreach($bind as $key => $value){
			$sql = preg_replace("/:$key\b/", $this->quote($value), $sql);
		}

		$res = mysql_query($sql);
		//$res = mysql_unbuffered_query($sql);
		if ($res===FALSE)
			return $this->createException("Se produjo un error al tratar de ejecutar la sentencia sql ((($sql)))");
		else 
			return $res;
	}
	
	function quote( $value){
		/*if (get_magic_quotes_gpc() === 1)
			return "'".$value."'";
		else*/
			return "'".mysql_escape_string($value)."'";
	}
	
	function quoteInto($cond, $value){
		return str_replace("?", "'".mysql_escape_string($value)."'", $cond);
	}
	
	function freeResources($resources){
		mysql_free_result($resources);
	}
	
	function last_insert_id (){
		return mysql_insert_id();
	}
	
	function fetchAll($sql, $bind = array()){
		
		
		if (strtolower(get_class($sql)) == strtolower("Zend__Select"))
        	$sql=$sql->__toString();
      //var_export($sql);
        $result = $this->query($sql, $bind);
        if (is_a($result, "Celsius_Exception"))
			return $result;
		if ($result === TRUE)
			//es una clausula de modificacion
			return $result;
			
		$data = array();
        while ($row = $this->_fetch($result)) {
            $data[] = $row;
        }
		
		$this->freeResources($result);
        return $data;
    }
    
    function _fetch($result){
		return mysql_fetch_assoc($result);	
    }

	function fetchRow($sql, $bind =array()){
		
        if (strtolower(get_class($sql)) == strtolower("Zend__Select"))
        	$sql=$sql->__toString();
        
       // var_export($sql);
        $result = $this->query($sql, $bind);
        if (is_a($result, "Celsius_Exception"))
			return $result;
		if ($result === TRUE)
			//es una clausula de modificacion
			return TRUE;
			
        $row = $this->_fetch($result);
        $this->freeResources($result);
        return $row;
    }
	
	function select(){
		return new Zend__Select($this);
	}
}
?>