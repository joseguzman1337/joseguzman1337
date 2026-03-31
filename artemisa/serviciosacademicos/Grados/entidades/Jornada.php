<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package entidades 
   */
  
  class Jornada{
  	
	/**
	 * @type int
	 * @access private
	 */
	private $codigo;
	
	/**
	 * @type String
	 * @access private
	 */
	private $nombre;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function Jornada( $persistencia){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el codigo de la Jornada
	 * @param int $codigo
	 * @access public
	 * @return void
	 */
	public function setCodigo( $codigo ){
		$this->codigo = $codigo;
	}
	
	/**
	 * Retorna el codigo de la Jornada
	 * @access public
	 * @return int
	 */
	public function getCodigo( ){
		return $this->codigo;
	}
	
	/**
	 * Modifica el nombre de la jornada
	 * @param string $nombre
	 * @access public
	 * @return void
	 */
	public function setNombre( $nombre ){
		$this->nombre = $nombre;
	}
	
	/**
	 * Retorna el nombre de la jornada
	 * @access public
	 * @return String
	 */
	public function getNombre( ){
		return $this->nombre;
	}
	
	
  }
?>