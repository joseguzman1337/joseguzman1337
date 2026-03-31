<?php
class connection {
	private $_connection;
	private $_sql;
	static private $_instance = null;
	function connection( $host, $db, $user, $password ) {
		$this->_connection = mysql_connect( $host, $user, $password );
		mysql_select_db( $db, $this->_connection );
	}
	function &getInstance() {
		require_once('../../../../../Connections/sala2.php');
		mysql_close($sala);
		$conf["DB_HOST"]        = $hostname_sala;
		$conf["DB_USER"]        = $username_sala;
		$conf["DB_PASSWORD"]    = $password_sala;
		$conf["DB_NAME"]        = $database_sala;
		if( connection::$_instance == null ){
			connection::$_instance = new connection($conf["DB_HOST"], $conf["DB_NAME"], $conf["DB_USER"], $conf["DB_PASSWORD"]);
		}
		return connection::$_instance;
	}
	function getConnection() {
		return $this->_connection;
	}
	function exec($sql=null) {
		$this->_sql = $sql;
		$res = mysql_query( $this->_sql, connection::$_instance->getConnection() );
		return $res;
	}
}
