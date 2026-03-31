<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Dirección de Tecnología - Universidad el Bosque
   * @package entidades
   */
  
  
  include '../entidades/DocumentoDigital.php';
  
  class ControlDocumentoDigital{
  	
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
		
		
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function ControlDocumentoDigital( $persistencia ) {
		$this->persistencia = $persistencia;
	}
	
	
	/**
	 * Inserta un registro en la tabla documento digital
 	 * @param FechaGrado $fechaGrado
	 * @access public
	 * @return boolean
	 */
	public function crearDocumentoDigital( $txtCodigoEstudiante, $txtRutaDocumento, $txtIdUsuario ){
		$documentoDigital = new DocumentoDigital( $this->persistencia );
		$documentoDigital->crearDocumentoDigital( $txtCodigoEstudiante, $txtRutaDocumento, $txtIdUsuario );
		return $documentoDigital;
	}
	
	
	
	
  }
  
  
?>