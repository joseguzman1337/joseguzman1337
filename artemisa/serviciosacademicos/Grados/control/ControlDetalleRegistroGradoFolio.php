<?php
  /**
 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package control
 */

include '../entidades/DetalleRegistroGradoFolio.php';


	class ControlDetalleRegistroGradoFolio{
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
		
		
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function ControlDetalleRegistroGradoFolio( $persistencia ) {
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Buscar Detalle Registro Grado Folio 
	 * @param int $idPersona
	 * @access public
	 * @return void
	 */
	public function buscarDetalleRegistroGradoFolio( $txtIdRegistroGrado ) {
		$detalleRegistroGradoFolio = new DetalleRegistroGradoFolio( $this->persistencia );
		$detalleRegistroGradoFolio->buscarDetalleRegistroGradoFolio( $txtIdRegistroGrado );
		return $detalleRegistroGradoFolio;
	}
	
	/**
	 * Actualizar DetalleRegistroGraduadoFolio
 	 * @param int txtNumeroFolio, $txtIdRegistroGrado
	 * @access public
	 * @return boolean
	 */
	public function actualizarFolioDetalleRegistro( $txtNumeroFolio, $txtIdRegistroGrado ){
		$detalleRegistroGraduadoFolio = new DetalleRegistroGradoFolio( $this->persistencia );
		$detalleRegistroGraduadoFolio->insertarDetalleRegistroGradoFolio($txtNumeroFolio, $txtIdRegistroGrado);
		return $detalleRegistroGraduadoFolio;
		 
	}
	
	
}
?>