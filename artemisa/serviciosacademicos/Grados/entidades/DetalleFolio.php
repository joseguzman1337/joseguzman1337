<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Dirección de Tecnología - Universidad el Bosque
   * @package entidades
   */
  
  class DetalleFolio{
  	
	/**
	 * @type int
	 * @access private
	 */
	private $idDetalleFolio;
	
	/**
	 * @type Folio
	 * @access private
	 */
	private $folio;
	
	/**
	 * @type RegistroGrado
	 * @access private
	 */
	private $registroGrado;
	
	/**
	 * @type int
	 * @access private
	 */
	private $estadoDetalleFolio;
	
	/**
	 * @type int
	 * @access private
	 */
	private $tipoDetalleFolio;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */	 
	public function DetalleFolio( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el id del detalle del folio
	 * @param int $idDetalleFolio
	 * @access public
	 * @return void
	 */
	public function setIdDetalleFolio( $idDetalleFolio ){
		$this->idDetalleFolio = $idDetalleFolio;
	}
	
	/**
	 * Retorna el id del detalle del folio
	 * @access public
	 * @return int
	 */
	public function getIdDetalleFolio( ){
		return $this->idDetalleFolio;
	}
	
	/**
	 * Modifica el folio del detalle
	 * @param Folio $folio
	 * @access public
	 * @return void
	 */
	public function setFolio( $folio ){
		$this->folio = $folio;
	}
	
	/**
	 * Retorna el folio del detalle
	 * @access public
	 * @return Folio
	 */
	public function getFolio( ){
		return $this->folio;
	}
	
	/**
	 * Modifica el registro de grado del detalle
	 * @param RegistroGrado $registroGrado
	 * @access public
	 * @return void
	 */
	public function setRegistroGrado( $registroGrado ){
		$this->registroGrado = $registroGrado;
	}
	
	/**
	 * Retorna el registro de grado del detalle
	 * @access public
	 * @return RegistroGrado
	 */
	public function getRegistroGrado( ){
		return $this->registroGrado;
	}
	
	/**
	 * Modifica el estado de detalle del folio
	 * @param int $estadoDetalleFolio
	 * @access public
	 * @return void
	 */
	public function setEstadoDetalleFolio( $estadoDetalleFolio ){
		$this->estadoDetalleFolio = $estadoDetalleFolio;
	}
	
	/**
	 * Retorna el estado del detalle del folio
	 * @access public
	 * @return int
	 */
	public function getEstadoDetalleFolio( ){
		return $this->estadoDetalleFolio;
	}
	
	/**
	 * Modifica el tipo de detalle del folio
	 * @param TipoDetalleFolio $tipoDetalleFolio
	 * @access public
	 * @return void
	 */
	public function setTipoDetalleFolio( $tipoDetalleFolio ){
		$this->tipoDetalleFolio = $tipoDetalleFolio;
	}
	
	/**
	 * Retorna el tipo de detalle del folio
	 * @access public
	 * @return TipoDetalleFolio
	 */
	public function getTipoDetalleFolio( ){
		return $this->tipoDetalleFolio;
	}
	
	
	
	
	
  }
?>