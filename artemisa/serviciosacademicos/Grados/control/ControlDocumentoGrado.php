<?php
   /**
    * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Dirección de Tecnología - Universidad el Bosque
    * @package control
    */
   
   include '../entidades/TipoDocumentoGrado.php';
   include '../entidades/DocumentoGrado.php';
   
   class ControlDocumentoGrado{
   	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Cosntructor
	 * @param $persistencia Singleton
	 */
	public function ControlDocumentoGrado( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Consulta los tipo documento grado
	 * @access public
	 * @return Array<TipoDocumentoGrado>
	 */
	public function consultarTipoDocumentoGrado( ){
		$tipoDocumentoGrado = new TipoDocumentoGrado( $this->persistencia );
		return $tipoDocumentoGrado->consultarTipoDocumentoGrado( );
		
	}
	
	/**
	 * Insertar Acta de Grado
 	 * @param int $txtNumeroActaGrado, $idPersona
	 * @access public
	 * @return boolean
	 */
	public function crearFirmaDocumentoGrado( $txtIdRegistroGrado, $txtIdIncentivo, $txtIdDirectivo, $txtCodigoTipoDocumentoGrado, $txtCodigoIncentivo ){
		$documentoGrado = new DocumentoGrado( $this->persistencia );
		$documentoGrado->crearFirmaDocumentoGrado( $txtIdRegistroGrado, $txtIdIncentivo, $txtIdDirectivo, $txtCodigoTipoDocumentoGrado, $txtCodigoIncentivo );
		return $documentoGrado;
	}
	
	
   }
?>