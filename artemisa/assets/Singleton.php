<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidades
 */ 

 define('SITE_ROOT', __DIR__);

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
	 * Sql de la Consulta paginado
	 * @type String
	 * @access private
	 */
	private $sqlPagination;
	
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


	/*Modifieed Diego Rivera <riveradiego@unbosque.edu.co>
	* Se cambias require_once por require  debido a inconvenientes de conexion en plan de desarrollo
	*Since March 05,2018
	*/
	public function Singleton( ){
		$hostname_sala = "";
		$username_sala = "";
		$password_sala = "";
		$database_sala = "";
		$root = realpath(SITE_ROOT."/../serviciosacademicos/Connections/sala2.php"); 
		$t = require($root); 
		$this->host = @$hostname_sala;
		$this->user = @$username_sala;
		$this->pass = @$password_sala;
		$this->db = @$database_sala;
		$this->parametros = null;
		$this->resulset = null;
	}
	/**
	 * Realiza la conexion a la base de datos 
	 * @return void
	 */
	public function conectar( ){
                if(empty($this->db)){
                    $hostname_sala = "";
                    $username_sala = "";
                    $password_sala = "";
                    $database_sala = "";
                    $root = realpath(SITE_ROOT."/../serviciosacademicos/Connections/sala2.php"); 
                    $t = require($root); 
                    $this->host = @$hostname_sala;
                    $this->user = @$username_sala;
                    $this->pass = @$password_sala;
                    $this->db = @$database_sala;
                }
		$this->radicadoLog = ""; 
		$this->conection = mysql_connect($this->host , $this->user , $this->pass);
		mysql_select_db($this->db , $this->conection ) or die('Could not select database.');
	}
	
	public function parametros( $usuario , $password , $host , $db ){
		$this->user = $usuario;
		$this->pass = $password;
		$this->host = $host;
		$this->db = $db;
                if(empty($this->db)){
                    $hostname_sala = "";
                    $username_sala = "";
                    $password_sala = "";
                    $database_sala = "";
                    $root = realpath(SITE_ROOT."/../serviciosacademicos/Connections/sala2.php"); 
                    $t = require($root); 
                    $this->host = @$hostname_sala;
                    $this->user = @$username_sala;
                    $this->pass = @$password_sala;
                    $this->db = @$database_sala;
                }
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
	
	public function ejecutarConsulta( $pagination=false ){
		if($pagination){
			$localsql = $this->sqlPagination;
		}else{
			$localsql = $this->sql;
		}
		for ($i = count( $this->parametros ) -1; $i >= 0; $i-- ){
			$pos = strrpos( $localsql , "?");
			$localsql = substr( $localsql , 0 , $pos ) .	$this->parametros[$i] .substr( $localsql, $pos+1, strlen( $localsql ) - 1 );
		}
		
		$localsql = preg_replace("[^A-Za-z0-9]", "", $localsql );
		$this->resulset = @mysql_query( utf8_encode( $localsql ) , $this->conection ) or die( $this->traducir( mysql_error( $this->conection ) ) );
		//$this->guardarSQL( $this->sql );
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
		//$this->guardarSQL( $this->sql );
		if( !$resulset ){
			echo 'Error: en la consulta';
                        return false;
			exit;
		}else{
			return true;
			exit;
		}
	}
	
	public function getSQL( ){
		return $this->sql;
	}
	
	public function getSQLListo( $pagination=false ){
		if($pagination){
			$sqlTem = " -_-".$this->sqlPagination;
		}else{
			$sqlTem = " -_-".$this->sql;
		}
		for( $i = count( $this->parametros ) -1; $i >= 0; $i--){
			$pos = strrpos( $sqlTem, "?");
			$sqlTem = substr( $sqlTem , 0 , $pos ) . $this->parametros[$i] . substr( $sqlTem , $pos + 1 , strlen( $sqlTem ) - 1 );
		}
		$sqlTem = preg_replace("[^A-Za-z0-9]", "", $sqlTem ); 
                $sqlTem = explode("-_-",$sqlTem);
		return $sqlTem[1];
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
		
		/*$ddf = fopen("../logs/".date("d-m-y_h_i_s").".log","a");
		fwrite($ddf, "Fecha : " . date("d-m-y h:i:s") );
		fwrite($ddf, "\n" );
		fwrite($ddf, "SQL: " . $sql );
		fwrite($ddf, "\n" );
		fclose($ddf);*/
		
		
		/*$ddf = fopen("../log/sql/".date( "Y_m_d_H_i_s").".log","a");
		fwrite($ddf, date("d-m-y h:i:s"). "\n\n" );
		fwrite($ddf, $sql . "\n");
		fwrite($ddf, "\n");
		fwrite($ddf, "\n");
		fclose($ddf);*/
	}
	
	public function getTotalRows() {
		$totalRows = mysql_num_rows($this->resulset);
		return $totalRows; 
	}
	
	public function paginarResultados($page, $totalRows){
		if(empty($_SESSION)){
			session_start();
		}
		
		//Limito la busqueda
		if(!empty($_SESSION["pagination"]["size"])){
			$size = $_SESSION["pagination"]["size"];
		}else{
			$size = 20;
			$_SESSION["pagination"]["size"] = $size;
		}
		//examino la página a mostrar y el inicio del registro a mostrar 
		if (!$page) {
		   $start = 0;
		   $page = 1;
		} else {
		   $start = ($page - 1) * $size;
		   $_SESSION["pagination"]["start"] = $start;
		}
		/*d($totalRows);
		d($size);
		d($start);/**/
		//calculo el total de páginas
		$totalPages = ceil( $totalRows / $size);
		$_SESSION["pagination"]["totalPages"] = $totalPages;
		
		if (!preg_match('/limit/',strtolower($this->sql))){
			$this->sqlPagination = $this->sql . " LIMIT ".$start."," . $size;
		}
		//d($this->sqlPagination);
		unset($this->result);
		return $this->ejecutarConsulta(true);

	}
 }
   
?>