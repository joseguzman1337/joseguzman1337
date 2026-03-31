<?php
 /**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */

 include '../entidades/TipoDocumento.php';
 
 class ControlTipoDocumento{
 	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 * @access public
	 */
	public function ControlTipoDocumento( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Consulta los tipos de documentos
	 * @access public
	 * @return Array<TipoDocumento>
	 */
	public function consultar( ){
		$tipoDocumento = new TipoDocumento( $this->persistencia );
		return $tipoDocumento->consultar( );
	}
 }
?>