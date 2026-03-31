<?php
   /**
    * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Universidad el Bosque - Dirección de Tecnología
    * @package entidades
    */
   
   class ModalidadAcademica{
   	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoModalidadAcademica;
	
	/**
	 * @type String
	 * @access private
	 */
	private $nombreModalidadAcademica;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoModalidadAcademica;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param $persistencia
	 */
	public function ModalidadAcademica( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el codigo de la modalidad academica
	 * @param int $codigoModalidadAcademica
	 * @access public
	 * @return void
	 */
	public function setCodigoModalidadAcademica( $codigoModalidadAcademica ){
		$this->codigoModalidadAcademica = $codigoModalidadAcademica;
	}
	
	/**
	 * Retorna el codigo de la modalidad academica
	 * @access public
	 * @return int
	 */
	public function getCodigoModalidadAcademica( ){
		return $this->codigoModalidadAcademica;
	}
	
	/**
	 * Modifica el nombre de la modalidad academica
	 * @param String $nombreModalidadAcademica
	 * @access public
	 * @return void
	 */
	public function setNombreModalidadAcademica( $nombreModalidadAcademica ){
		$this->nombreModalidadAcademica = $nombreModalidadAcademica;
	}
	
	/**
	 * Retorna el nombre de la modalidad academica
	 * @access public
	 * @return String
	 */
	public function getNombreModalidadAcademica( ){
		return $this->nombreModalidadAcademica;
	}
	
	/**
	 * Modifica el estado de la modalidad academica
	 * @param String $estadoModalidadAcademica
	 * @access public
	 * @return void
	 */
	public function setEstadoModalidadAcademica( $estadoModalidadAcademica ){
		$this->estadoModalidadAcademica = $estadoModalidadAcademica;
	}
	
	/**
	 * Retorna el estado de la modalidad academica
	 * @access public
	 * @return int
	 */
	public function getEstadoModalidadAcademica( ){
		return $this->estadoModalidadAcademica;
	}
   }
?>