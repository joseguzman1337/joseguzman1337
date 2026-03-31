<?php
/**
* @package SPLIB
* $Id: PEARDBAdapter.php,v 1.1 2007/05/16 14:50:55 Abraham Castro Exp $
*/
/**
* Include PEAR::DB
*/
require_once 'DB.php';
/**
* PEAR::DB Adapater Class for MySQL Connections
* Adapts PEAR to the SPLIB/Database/MySQL API
* @access public
* @package SPLIB
*/
class PEARDBAdapter {
    /**
    * Instance of PEAR::DB subclass
    * @access private
    * @var object
    */
    var $db;

    /**
    * PEARDBAdapter constructor
    * @param string host (MySQL server hostname)
    * @param string dbUser (MySQL User Name)
    * @param string dbPass (MySQL User Password)
    * @param string dbName (Database to select)
    * @access public
    */
    function PEARDBAdapter ($host,$dbUser,$dbPass,$dbName) {
        $dsn = "mysql://$dbUser:$dbPass@$host/$dbName";
        $this->db = & DB::connect($dsn);
    }

    /**
    * Returns an instance of PEARDBResultAdapter to fetch rows with
    * @param $sql string the database query to run
    * @return PEARDBResultAdapter
    * @access public
    */
    function & query($sql) {
        // Call the PEAR::DB query() method
        $result = & $this->db->query($sql);

        // Wrap the result in a PEARDBResultAdapter
        return new PEARDBResultAdapter($result);
    }
}

// Adapater for PEAR::DB Result
/**
* PEAR::DB Result Class
* Adapts PEAR to the SPLIB/Database/MySQLResult API
* @access public
* @package SPLIB
*/
class PEARDBResultAdapter {
    /**
    * Instance of PEAR::DB Result subclass
    * @access private
    * @var object
    */
    var $result;

    /**
    * PEARDBResultAdapter constructor
    * @param object instance of PEAR::DB Result subclass
    * @access public
    */
    function PEARDBResultAdapter(& $result) {
        $this->result = & $result;
    }

    /**
    * Adapts the PEAR::DB Result fetchRow() method
    * @return mixed row from database or false when finished
    * @access public
    */
    function & fetch() {
        // Call the PEAR::DB Result fetchRow() method
        if ( $row = & $this->result->fetchRow(DB_FETCHMODE_ASSOC) ) {
            return $row;
        } else {
            return false;
        }
    }
}
?>