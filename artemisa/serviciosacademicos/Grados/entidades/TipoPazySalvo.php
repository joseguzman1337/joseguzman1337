<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package entidades
   */
  
  class TipoPazySalvo{
  	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoPazySalvo;
	
	/**
	 * @type String
	 * @access private
	 */
	private $nombreTipoPazySalvo;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */	 
	public function TipoPazySalvo( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el codigo del Tipo de Paz y Salvo
	 * @param int $codigoPazySalvo
	 * @access public
	 * @return void
	 */
	public function setCodigoPazySalvo( $codigoPazySalvo ){
		$this->codigoPazySalvo = $codigoPazySalvo;
	}
	
	/**
	 * Retorna el codigo del Tipo de Paz y Salvo
	 * @access public
	 * @return int
	 */
	public function getCodigoPazySalvo( ){
		return $this->codigoPazySalvo;
	}
	
	/**
	 * Modifica el nombre del tipo de paz y salvo
	 * @param string $nombreTipoPazySalvo
	 * @access public
	 * @return void
	 */
	public function setNombreTipoPazySalvo( $nombreTipoPazySalvo ){
		$this->nombreTipoPazySalvo = $nombreTipoPazySalvo;
	}
	
	/**
	 * Retorna el nombre del tipo de paz y salvo
	 * @access public
	 * @return string
	 */
	public function getNombreTipoPazySalvo( ){
		return $this->nombreTipoPazySalvo;
	}
	
	
	
  }
?>