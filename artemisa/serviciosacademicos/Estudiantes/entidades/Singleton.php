<?php
/**
 * @author Diego Fernando RIvera Castro <riveradiego@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidades
 */ 
 

 class Singleton{
 	
	/**
	 * Conectar con la Base de Datos
	 */
	private $conection;
	
	/**
	 * Parametros de la Consulta
	 * @type Array()
	 * @access private
	 */
	private $parametros;
	
	/**
	 * Sql de la Consulta
	 * @type String
	 * @access private
	 */
	private $sql;
	
	/**
	 * Maneja el acceso de datos devueltos por una consulta
	 * @type Resulset
	 * @access private
	 */
	private $resulset;
	
	/**
	 * Statement de la consulta
	 * @type Statemet
	 * @access private 
	 */
	private $stmt;
	
	/**
	 * Numero de radicado para guardar log
	 * @type String
	 * @access private
	 */
	private $radicadoLog;
	
	/**
	 * Guarda Sesion
	 * @type boolean
	 * @access private
	 */
	private $grabar = "false";
	
	/**
	 * Nombre del host de la base de datos
	 * @type String
	 * @access private
	 */
	private $host = "";
	
	/**
	 * Nombre del Usuario
	 * @type String
	 * @access private
	 */
	private $user = "";
	
	/**
	 * Contrasenia del Usuario
	 * @type String
	 * @access private
	 */
	private $pass = "";
	
	/**
	 * Nombre de la Base de Datos
	 * @type String
	 * @access private
	 */
	private $db = "";
	
	/**
	 * Constructor
	 */
	public function Singleton( ){
		include "../../Connections/sala2.php";
		$this->host = $hostname_sala;
		$this->user = $username_sala;
		$this->pass = $password_sala;
		$this->db = $database_sala;
		$this->parametros = null;
		$this->resulset = null;
	}
	/**
	 * Realiza la conexion a la base de datos 
	 * @return void
	 */
	public function conectar( ){
		$this->radicadoLog = "";
		$this->conection = mysql_connect($this->host , $this->user , $this->pass);
		mysql_select_db($this->db , $this->conection ) or die('Could not select database.');
	}
	
	public function parametros( $usuario , $password , $host , $db ){
		$this->user = $usuario;
		$this->pass = $password;
		$this->host = $host;
		$this->db = $db;
	}
	
	public function crearSentenciaSQL( $sql ){
		$this->resulset = null;
		$this->parametros = array( );
		$this->sql = $sql;
	}
	
	public function setParametro( $id , $valor , $estado ){
		if( count( $this->parametros ) == $id ){
			if( $estado )
				$this->parametros[ $id ] = "'". $valor ."'";
			else{
				$this->parametros[ $id ] = $valor;
			}
		}
	}
	
	public function getParametros( ){
		return $this->parametros;
	}
	
	public function ejecutarConsulta( ){
		for ($i = count( $this->parametros ) -1; $i >= 0; $i-- ){
			$pos = strrpos( $this->sql , "?");
			$this->sql = substr( $this->sql , 0 , $pos ) .	$this->parametros[$i] .substr( $this->sql, $pos+1, strlen( $this->sql ) - 1 );
		}
		
		$this->sql = preg_replace("[^A-Za-z0-9]", "", $this->sql );
		$this->resulset = @mysql_query( utf8_encode( $this->sql ) , $this->conection ) or die( );

		if( !$this->resulset )
			echo 'Error: en la consulta';
		else
			return $this->resulset;
	}
	
	public function ejecutarUpdate( ){
		for( $i = count( $this->parametros ) -1; $i >= 0; $i--){
			$pos = strrpos( $this->sql, "?");
			$this->sql = substr( $this->sql , 0 , $pos ) .	$this->parametros[$i] . substr( $this->sql , $pos + 1 , strlen( $this->sql ) - 1 );
		}
		$this->sql = preg_replace("[^A-Za-z0-9]", "", $this->sql );
		$resulset = @mysql_query( $this->sql , $this->conection ) or die( $this->traducir( mysql_error( $this->conection ) ) );

		if( !$resulset ){
			echo 'Error: en la consulta';
			exit;
		}else{
			return ($resulset);
		}
	}
	
	public function getSQL( ){
		return $this->sql;
	}
	
	public function getSQLListo( ){
		$sqlTem = $this->sql;
		for( $i = count( $this->parametros ) - 1; $i >= 0; $i--){
			$pos = strrpos( $sqlTem , "?");
			$sqlTem = substr( $sqlTem , 0 , $pos ).	$this->parametros[$i] . substr( $sqlTem , $pos + 1 , strlen( $sqlTem ) - 1 );
		}
		$sqlTem = preg_replace("[^A-Za-z0-9]", "", $sqlTem );
		return $sqlTem;
	}
	
	public function getNext( ){
		$this->stmt = mysql_fetch_array( $this->resulset );
		return $this->stmt;
	}
	
	public function getParametro( $parametro ){
		return trim( $this->stmt[ $parametro ] );
	}
	
	public function freeResult( ){
		$this->parametros = NULL;
		$this->sql = "";
		return mysql_free_result( $this->resulset );
	}
	
	public function lastId( ){
		return  mysql_insert_id( );
	}
	
	public function close( ){
		//return mysql_close( $this->conection );
	}
	
	public function confirmarTransaccion( ){
		//return mysql_query( $this->conection , "COMMIT" );
	}
	
	public function cancelarTransaccion( ){
		//return mysql_query( $this->conection , "ROLLBACK" );
	}
	
	public function serializar( ){
		return serialize( $this );
	}
	
	public function unserializar( $var ){
		return unserialize( $var );
	}
	
	/**
	 * Modifica el estado del log
	 * @param String $radicadoLog
	 * @return void
	 */
	public function setRadicadoLog( $radicadoLog ){
		$this->radicadoLog = $radicadoLog;
	}
	
	
	public function traducir( $texto ){
		return $texto;
	}
	
	public function guardarSQL( $sql ){
		
		
	}
	
	
	
	
	
	
	
	
 }
   
?>