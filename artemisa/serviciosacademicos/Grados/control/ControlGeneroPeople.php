<?php
   /**
    * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Dirección de Tecnología - Universidad el Bosque
    * @package control
    */
   
   include '../entidades/GeneroPeople.php';
   
   class ControlGeneroPeople{
   	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param $persistencia Singleton
	 */
	public function ControlGeneroPeople( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Buscar Codigo TipoDocumento People
	 * @param int $txtTipoDocumento
	 * @access public
	 * @return void
	 */
	public function buscarCodigoGeneroPeople( $txtCodigoGenero ){
		$generoPeople = new GeneroPeople( $this->persistencia );
		$generoPeople->buscarCodigoGeneroPeople( $txtCodigoGenero );
		return $generoPeople;
		
	}
	
	
   }
?>