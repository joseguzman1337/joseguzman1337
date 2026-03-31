<?php
 /**
  * @author Carlos Alberto Suárez Garrido <suarezcarlos@unbosque.edu.co>
  * @copyright Universidad el Bosque - Dirección de Tecnología
  * @package entidades
  */
 
 class Pais{
 	
	/**
	 * @type int
	 * @access private
	 */
	private $id;
	
	/**
	 * @type string
	 * @access private
	 */
	private $nombre;
	
	/**
	 * @type int
	 * @access private
	 */
	private $codigo;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estado;
	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoSapPais;
	
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function Pais ( $persistencia ) {
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el identificador del Pais
	 * @param int $id
	 * @access public
	 * @return void
	 */
	public function setId( $id ){
		$this->id = $id;
	}
	
	/**
	 * Retorna el identificador del Pais
	 * @access public
	 * @return int
	 */
	public function getId( ){
		return $this->id;
	}
	
	/**
	 * Modifica el nomre del Pais
	 * @param string $nombre
	 * @access public
	 * @return void
	 */
	public function setNombre( $nombre ){
		$this->nombre = $nombre;
	}
	
	/**
	 * Retorna el nombre del Pais
	 * @access public
	 * @return String
	 */
	public function getNombre( ){
		return $this->nombre;
	}
	
	/**
	 * Modifica el estado del Pais
	 * @param int $estado
	 * @access public
	 * @return void 
	 */
	public function setEstado( $estado ){
		$this->estado = $estado;
	}
	
	/**
	 * Retorna el estado del Pais
	 * @access public
	 * @return int
	 */
	public function getEstado( ){
		return $this->estado;
	}	
	
	
	/**
	 * Modifica el codigo sap del Pais
	 * @param int $codigoSapPais
	 * @access public
	 * @return void
	 */
	public function setCodigoSapPais( $codigoSapPais ){
		$this->codigoSapPais = $codigoSapPais;
	}
	
	/**
	 * Retorna el codigo sap del Pais
	 * @access public
	 * @return int
	 */
	public function getCodigoSapPais( ){
		return $this->codigoSapPais;
	}
	
 }
?>