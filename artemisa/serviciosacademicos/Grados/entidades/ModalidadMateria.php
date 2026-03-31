<?php
/**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnoogía
 * @package entidades
 */

 class ModalidadMateria{
 	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoModalidadMateria;
	
	/**
	 * @type String
	 * @access private
	 */
	private $nombreModalidadMateria;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param $persistencia
	 */
	public function ModalidadMateria( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el codigo de la modalidad de la materia
	 * @param int $codigoModalidadMateria
	 * @access public
	 * @return void
	 */
	public function setCodigoModalidadMateria( $codigoModalidadMateria ){
		$this->codigoModalidadMateria = $codigoModalidadMateria;
	}
	
	/**
	 * Retorna el codigo de la modalidad de la materia
	 * @access public
	 * @return int
	 */
	public function getCodigoModalidadMateria( ){
		return $this->codigoModalidadMateria;
	}
	
	/**
	 * Modifica el nombre de la modalidad de la materia
	 * @param string $nombreModalidadMateria
	 * @access public
	 * @return void
	 */
	public function setNombreModalidadMateria( $nombreModalidadMateria ){
		$this->nombreModalidadMateria = $nombreModalidadMateria;
	}
	
	/**
	 * Retorna el nombre de la modalidad de la materia
	 * @access public
	 * @return string
	 */
	public function getNombreModalidadMateria( ){
		return $this->nombreModalidadMateria;
	}
 

}

 
?>