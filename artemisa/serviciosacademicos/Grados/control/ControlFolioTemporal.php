<?php
   /**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package control
 */

include '../entidades/FolioTemporal.php';


	class ControlFolioTemporal{
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
		
		
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function ControlFolioTemporal( $persistencia ) {
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Buscar Detalle Registro Grado Folio 
	 * @param int $idPersona
	 * @access public
	 * @return void
	 */
	public function buscarFolioTemporal( $txtIdRegistroGrado ) {
		$folioTemporal = new FolioTemporal( $this->persistencia );
		$folioTemporal->buscarFolioTemporal( $txtIdRegistroGrado );
		return $folioTemporal;
	}
	
	/**
	 * Actualizar Folio Temporal
 	 * @param int txtNumeroFolio, $txtIdRegistroGrado
	 * @access public
	 * @return boolean
	 */
	public function actualizarFolioTemporal( $txtNumeroFolio, $txtIdRegistroGrado ){
		$folioTemporal = new FolioTemporal( $this->persistencia );
		$folioTemporal->actualizarFolioTemporal( $txtNumeroFolio, $txtIdRegistroGrado );
		return $folioTemporal;
		 
	}
	
	/**
	 * Insertar PrevisualizacionFolioTemporal
	 * @param int txtNumeroFolio, $txtIdRegistroGrado
	 * @access public
	 * @return boolean
	 */
	public function insertarFolioTemporal( $txtIdRegistroGrado , $txtNumeroFolio ){
		$folioTemporal = new FolioTemporal( $this->persistencia );
		
		$controlDetalleRegistroGradoFolio = new ControlDetalleRegistroGradoFolio( $this->persistencia );
		
		$detalleRegistroGradoFolio = $controlDetalleRegistroGradoFolio->buscarDetalleRegistroGradoFolio( $txtIdRegistroGrado );
		
		$controlFolioTemporal = new ControlFolioTemporal( $this->persistencia );
		
		$txtIdDetalleRegistroGradoFolio = $detalleRegistroGradoFolio->getIdDetalleRegistroGradoFolio( );
		
		if( $txtIdDetalleRegistroGradoFolio != "" ){
			
			$txtNumeroFolioDetalleRegistroGradoFolio = $detalleRegistroGradoFolio->getFolio( )->getIdFolio( );
			
			$txtFolioTemporal = $controlFolioTemporal->buscarFolioTemporal( $txtIdRegistroGrado );
			
			$txtIdFolioTemporal = $txtFolioTemporal->getIdFolioTemporal( );
			
			if( $txtIdFolioTemporal == "" ){
				
				$folioTemporal->crearFolioTemporal( $txtIdRegistroGrado, $txtNumeroFolioDetalleRegistroGradoFolio );
			}else{
				
				$folioTemporal->actualizarFolioTemporal( $txtNumeroFolioDetalleRegistroGradoFolio, $txtIdRegistroGrado );
			}
		 
			
		}else{
			
			$txtFolioTemporal = $controlFolioTemporal->buscarFolioTemporal( $txtIdRegistroGrado );
			
			$txtIdFolioTemporal = $txtFolioTemporal->getIdFolioTemporal( );
			
			if( $txtIdFolioTemporal == "" ){
				
				$folioTemporal->crearFolioTemporal( $txtIdRegistroGrado, $txtNumeroFolio );
			}else{
				
				$folioTemporal->actualizarFolioTemporal( $txtNumeroFolio, $txtIdRegistroGrado );
			}
			
		}
		
		
		
	}
	
}
?>