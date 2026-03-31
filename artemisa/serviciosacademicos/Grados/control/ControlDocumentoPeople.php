<?php
   /**
    * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Dirección de Tecnología - Universidad el Bosque
    * @package control
    */
   
   include '../entidades/DocumentoPeople.php';
   
   class ControlDocumentoPeople{
   	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param $persistencia Singleton
	 */
	public function ControlDocumentoPeople( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Buscar Codigo TipoDocumento People
	 * @param int $txtTipoDocumento
	 * @access public
	 * @return void
	 */
	public function buscarTipoDocumentoPeople( $txtTipoDocumento ){
		$documentoPeople = new DocumentoPeople( $this->persistencia );
		$documentoPeople->buscarTipoDocumentoPeople( $txtTipoDocumento );
		return $documentoPeople;
		
	}
	
	
   }
?>