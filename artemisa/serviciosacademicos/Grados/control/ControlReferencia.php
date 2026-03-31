<?php
/**
* @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
* @copyright Universidad el Bosque - Dirección de Tecnología
* @package entidades
*/

 include '../entidades/Referencia.php';

 class ControlReferencia{
 	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;


	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function ControlReferencia( $persistencia ) {
		$this->persistencia = $persistencia;
		
	}
	
	/**
	 * Consultar los tipos de reportes
	 * @access public
	 * @return Array<Referencia>
	 */
	public function consultar( ){
		$tipoReporte = new Referencia( $this->persistencia );
		return $tipoReporte->consultar( );
	}
	
	/**
	 * Consultar Documentos a Duplicar
	 * @access public
	 * @return Array<Referencia>
	 */
	public function consultarDocumentoDuplicado( ){
		$tipoReporte = new Referencia( $this->persistencia );
		return $tipoReporte->consultarDocumentoDuplicado( );
	}
 }
?>