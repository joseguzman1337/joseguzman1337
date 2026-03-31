<?php
   /**
    * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Universidad el Bosque - Dirección de Tecnología
    * @package entidades
    */
   
   class ModalidadSIC{
   	
	/**
	 * @type int
	 * @access private
	 */
	private $codigoModalidadAcademicaSic;
	
	/**
	 * @type String
	 * @access private
	 */
	private $nombreModalidadAcademicaSic;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoModalidadAcademicaSic;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param $persistencia
	 */
	public function ModalidadSIC( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el codigo de la modalidad academica
	 * @param int $codigoModalidadAcademica
	 * @access public
	 * @return void
	 */
	public function setCodigoModalidadAcademicaSic( $codigoModalidadAcademicaSic ){
		$this->codigoModalidadAcademicaSic = $codigoModalidadAcademicaSic;
	}
	
	/**
	 * Retorna el codigo de la modalidad academica
	 * @access public
	 * @return int
	 */
	public function getCodigoModalidadAcademicaSic( ){
		return $this->codigoModalidadAcademicaSic;
	}
	
	/**
	 * Modifica el nombre de la modalidad academica
	 * @param String $nombreModalidadAcademica
	 * @access public
	 * @return void
	 */
	public function setNombreModalidadAcademicaSic( $nombreModalidadAcademicaSic ){
		$this->nombreModalidadAcademicaSic = $nombreModalidadAcademicaSic;
	}
	
	/**
	 * Retorna el nombre de la modalidad academica
	 * @access public
	 * @return String
	 */
	public function getNombreModalidadAcademicaSic( ){
		return $this->nombreModalidadAcademicaSic;
	}
	
	/**
	 * Modifica el estado de la modalidad academica
	 * @param String $estadoModalidadAcademica
	 * @access public
	 * @return void
	 */
	public function setEstadoModalidadAcademicaSic( $estadoModalidadAcademicaSic ){
		$this->estadoModalidadAcademicaSic = $estadoModalidadAcademicaSic;
	}
	
	/**
	 * Retorna el estado de la modalidad academica
	 * @access public
	 * @return int
	 */
	public function getEstadoModalidadAcademicaSic( ){
		return $this->estadoModalidadAcademicaSic;
	}
	
	
   }
?>