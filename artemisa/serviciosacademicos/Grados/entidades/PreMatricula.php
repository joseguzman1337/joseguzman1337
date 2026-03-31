<?php
 /**
  * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
  * @copyright Universidad el Bosuqe - Dirección de Tecnología
  * @package entidades
  */
 
 class PreMatricula{
 	
	/**
	 * @type int
	 * @access private
	 */
	private $id;
	
	/**
	 * @type date
	 * @access private
	 */
	private $fechaPreMatricula;
	
	/**
	 * @type Periodo
	 * @access private
	 */
	private $periodo;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estado;
	
	/**
	 * @type int
	 * @access private
	 */
	private $semestrePreMatricula;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */	 
	public function PreMatricula( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el identificador de la prematricula
	 * @param int $id
	 * @access public
	 * @return void
	 */
	public function setIdPreMatricula( $id ){
		$this->id = $id;
	}
	
	/**
	 * Retorna el identificador de la prematricula
	 * @access public
	 * @return int
	 */
	public function getIdPreMatricula( ){
		return $this->id;
	}
	
	/**
	 * Modifica la fecha de la prematricula
	 * @param date $fechaPreMatricula
	 * @access public
	 * @return void
	 */
	public function setFechaPreMatricula( $fechaPreMatricula ){
		$this->fechaPreMatricula = $fechaPreMatricula;
	}
	
	/**
	 * Retorna la fecha de la prematricula
	 * @access public
	 * @return date
	 */
	public function getFechaPreMatricula( ){
		return $this->fechaPreMatricula;
	}
	
	
	/**
	 * Modifica el periodo de la prematricula
	 * @param Periodo $periodo
	 * @access public
	 * @return void
	 */
	public function setPeriodo( $periodo ){
		$this->periodo = $periodo;
	}
	
	/**
	 * Retorna el periodo de la prematricula
	 * @access public
	 * @return Periodo
	 */
	public function getPeriodo( ){
		return $this->periodo;
	}
	
	/**
	 * Modifica el estado de la prematricula
	 * @param int $estado
	 * @access public
	 * @return void
	 */
	public function setEstado( $estado ){
		$this->estado = $estado;
	}
	
	/**
	 * Retorna el estado de la prematricula
	 * @access public
	 * @return int
	 */
	public function getEstado( ){
		return $this->estado;
	}
	
	/**
	 * Modifica el semestre de la premtaricula
	 * @param int $semestrePreMatricula
	 * @access public
	 * @return void
	 */
	public function setSemestrePreMatricula( $semestrePreMatricula ){
		$this->semestrePreMatricula = $semestrePreMatricula;
	}
	
	/**
	 * retorna el semestre de la prematricula
	 * @access public
	 * @return int
	 */
	public function getSemestrePreMatricula( ){
		return $this->semestrePreMatricula;
	}
	
 }
?>