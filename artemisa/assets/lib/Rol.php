<?php
 /**
    * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Universidad el Bosque - Dirección de Tecnología
    * @package entidades 
    */
class Rol { 

	/**
	 * @type int
	 * @access private
	 */
	private $id;

	/**
	 * @type String
	 * @access private
	 */
	private $nombre;

	/**
	 * @type String
	 * @access private
	 */
	private $codigo;

	/**
	 * @type String
	 * @access private
	 */
	private $relacion;

	/**
	 * @type float
	 * @access private
	 */
	private $valor;

	/**
	 * @type String
	 * @access private
	 */
	private $tipo;

	/**
	 * @type String
	 * @access private
	 */
	private $estado;

	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;

	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function Rol ( $persistencia ) {
		$this->persistencia = $persistencia;
	}


	/**
	 * Modifica el id del rol 
	 * @param int $id
	 * @access public
	 * @return void
	 */
	public function setId ( $id ) {
		$this->id = $id;
	}

	/**
	 * Retorna el id del rol 
	 * @access public
	 * @return int
	 */
	public function getId (  ) {
		return $this->id;
	}


	/**
	 * Modifica el nombre del rol 
	 * @param String $nombre
	 * @access public
	 * @return void
	 */
	public function setNombre ( $nombre ) {
		$this->nombre = $nombre;
	}


	/**
	 * Retorna el nombre del rol 
	 * @access public
	 * @return int
	 */
	public function getNombre (  ) {
		return $this->nombre;
	}


	/**
	 * Modifica el codigo del rol 
	 * @param String $codigo
	 * @access public
	 * @return void
	 */
	public function setCodigo ( $codigo ) {
		$this->codigo = $codigo;
	}


	/**
	 * Retorna el codigo del rol 
	 * @access public
	 * @return String
	 */
	public function getCodigo (  ) {
		return $this->codigo;
	}


	/**
	 * Modifica la relacion del rol 
	 * @param String $relacion
	 * @access public
	 * @return void
	 */
	public function setRelacion ( $relacion ) {
		$this->relacion = $relacion;
	}


	/**
	 * Retorna la relacion del rol 
	 * @access public
	 * @return String
	 */
	public function getRelacion (  ) {
		return $this->relacion;
	}


	/**
	 * Modifica el valor del rol 
	 * @param String $valor
	 * @access public
	 * @return void
	 */
	public function setValor ( $valor ) {
		$this->valor = $valor;
	}


	/**
	 * Retorna el valor del rol 
	 * @access public
	 * @return String
	 */
	public function getValor (  ) {
		return $this->valor;
	}


	/**
	 * Modifica el tipo del rol 
	 * @param String $valor
	 * @access public
	 * @return void
	 */
	public function setTipo ( $tipo ) {
		$this->tipo = $tipo;
	}


	/**
	 * Retorna el tipo del rol 
	 * @access public
	 * @return String
	 */
	public function getTipo (  ) {
		return $this->tipo;
	}


	/**
	 * Modifica el estado del rol 
	 * @param String $valor
	 * @access public
	 * @return void
	 */
	public function setEstado ( $estado ) {
		$this->estado = $estado;
	}


	/**
	 * Retorna el estado del rol 
	 * @access public
	 * @return String
	 */
	public function getEstado (  ) {
		return $this->estado;
	}
	
	
	/**
	 * Buscar secretaria por usuario
	 * @param $txtUsuario
	 * @access public
	 * @return void
	 */
	public function buscarSecretaria( $txtIdRol, $txtUsuario ){
		$sql = "SELECT
					COUNT(R.idrol) AS cantidad_rol
				FROM
					rol R
				INNER JOIN usuariorol UR ON (R.idrol = UR.idrol)
                INNER JOIN UsuarioTipo UT ON (UR.idusuariotipo = UT.UsuarioTipoId)
                INNER JOIN usuario U ON (UT.UsuarioId = U.idusuario)
				WHERE R.idrol = ?
				AND U.usuario = ?
				AND R.nombrerol LIKE '%Secretaria%'";
				
		$this->persistencia->crearSentenciaSQL( $sql );
		$this->persistencia->setParametro( 0 , $txtIdRol , true );
		$this->persistencia->setParametro( 1 , $txtUsuario , true );
		//echo $this->persistencia->getSQLListo( )."<br />";
		$this->persistencia->ejecutarConsulta(  );
		$cantidad = 0;
		
		if( $this->persistencia->getNext( ) )
			$cantidad = $this->persistencia->getParametro( "cantidad_rol" );
		
		$this->persistencia->freeResult( );
		
		return $cantidad;
	}
	
		
}
?>