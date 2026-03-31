<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package entidades
   */
  
  class DetalleOrdenPago{
  	
	/**
	 * @type int
	 * @access private
	 */
	private $valorConcepto;
	
	/**
	 * @type int
	 * @access private
	 */
	private $tipoConcepto;
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function DetalleOrdenPago( $persistencia){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Modifica el valor del Concepto
	 * @param int $valorConcepto
	 * @access public
	 * @return void
	 */
	public function setValorConcepto( $valorConcepto ){
		$this->valorConcepto = $valorConcepto;
	}
	
	/**
	 * Retorna el valor del Concepto
	 * @access public
	 * @return int
	 */
	public function getValorConcepto( ){
		return $this->valorConcepto;
	}
	
	/**
	 * Modifica el tipo de Concepto del Detalle
	 * @param int $tipoConcepto
	 * @access public
	 * @return void
	 */
	public function setTipoConcepto( $tipoConcepto ){
		$this->tipoConcepto = $tipoConcepto;
	}
	
	/**
	 * Retorna el tipo de Concepto del Detalle
	 * @access public
	 * @return int
	 */
	public function getTipoConcepto( ){
		return $this->tipoConcepto;
	}
	
  }
?>