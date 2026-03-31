<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Dirección de Tecnología - Univerisdad el Bosque
   * @package entidades
   */
  
  
  class TipoDetalleFolio{
  	
	/**
	 * @type int
	 * @access private
	 */
	private $idTipoDetalleFolio;
	
	/**
	 * @type String
	 * @access private
	 */
	private $nombreTipoDetalleFolio;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoTipoDetalleFolio;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function TipoDetalleFolio( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el id del tipo de detalle del folio
	 * @param int $idTipoDetalleFolio
	 * @access public
	 * @return void
	 */
	public function setIdTipoDetalleFolio( $idTipoDetalleFolio ){
		$this->idTipoDetalleFolio = $idTipoDetalleFolio;
	}
	
	/**
	 * Retorna el id del tipo de detalle del folio
	 * @access public
	 * @return int
	 */
	public function getIdTipoDetalleFolio( ){
		return $this->idTipoDetalleFolio;
	}
	
	/**
	 * Modifica el nombre del tipo de detalle del folio
	 * @param String $nombreTipoDetalleFolio
	 * @access public
	 * @return void
	 */
	public function setNombreTipoDetalleFolio( $nombreTipoDetalleFolio ){
		$this->nombreTipoDetalleFolio = $nombreTipoDetalleFolio;
	}
	
	/**
	 * Retorna el nombre del tipo de detalle del folio
	 * @access public
	 * @return String
	 */
	public function getNombreTipoDetalleFolio( ){
		return $this->nombreTipoDetalleFolio;
	}
	
	/**
	 * Modifica el estado del tipo de detalle del folio
	 * @param int $estadoTipoDetalleFolio
	 * @access public
	 * @return void
	 */
	public function setEstadoTipoDetalleFolio( $estadoTipoDetalleFolio ){
		$this->estadoTipoDetalleFolio = $estadoTipoDetalleFolio;
	}
	
	/**
	 * Retorna el estado del tipo de detalle del folio
	 * @access public
	 * @return int
	 */
	public function getEstadoTipoDetalleFolio( ){
		return $this->estadoTipoDetalleFolio;
	}
	
	
	
	
	
  }
?>