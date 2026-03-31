<?php
 /**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package control
 */

include '../entidades/Folio.php';


	class ControlFolio {
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
		
		
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function ControlFolio( $persistencia ) {
		$this->persistencia = $persistencia;
	}
		
	
	/**
	 * Busca Maximo IDFolio
	 * @access public
	 * @return void
	 */
	public function buscarMaximoFolio( ) {
		$folio = new Folio( $this->persistencia );
		return $folio->buscarMaximoFolio( );
	}
	
	/**
	 * Actualizar DetalleRegistroGraduadoFolio
 	 * @param int txtNumeroFolio, $txtIdRegistroGrado
	 * @access public
	 * @return boolean
	 */
	public function actualizarFolioGraduado( $txtNumeroFolio, $idPersona){
		$folio = new Folio( $this->persistencia );
		$folio->insertarFolio($txtNumeroFolio, $idPersona);
		return $folio;
		 
	}
	
	
}
?>