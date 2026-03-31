<?php
  /**
   * @author Carlos Alberto Suarez <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package entidades
   */
  
  class TipoMateria{
  	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoTipoMateria;
	
	/**
	 * @type String
	 * @access private
	 */
	private $nombreTipoMateria;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param $persistencia
	 */
	public function TipoMateria( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el codigo de tipo de materia
	 * @param int $codigoTipoMateria
	 * @access public
	 * @return void
	 */
	public function setCodigoTipoMateria( $codigoTipoMateria ){
		$this->codigoTipoMateria = $codigoTipoMateria;
	}
	
	/**
	 * Retorna el codigo de tipo de materia
	 * @access public
	 * @return int
	 */
	public function getCodigoTipoMateria( ){
		return $this->codigoTipoMateria;
	}
	
	/**
	 * Modifica el nombre del tipo de materia
	 * @param string $nombreTipoMateria
	 * @access public
	 * @return void
	 */
	public function setNombreTipoMateria( $nombreTipoMateria ){
		$this->nombreTipoMateria = $nombreTipoMateria;
	}
	
	/**
	 * Retorna el nombre del tipo de materia
	 * @access public
	 * @return string
	 */
	public function getNombreTipoMateria( ){
		return $this->nombreTipoMateria;
	}
  }
?>