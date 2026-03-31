<?php
    /**
	 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @package entidades
	 */
	
	include '../entidades/PazySalvo.php';
  	include '../entidades/DetallePazySalvo.php';
  	include '../entidades/TipoPazySalvo.php';
	
	class ControlPazySalvoEstudiante{
		
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
		
		
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function ControlPazySalvoEstudiante( $persistencia ) {
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Consultar Otros
	 * @param int $txtCodigoEstudiante, $txtCodigoPeriodo
	 * @access public
	 * @return <Array>DetallePazySalvo
	 */
	public function consultarPazySalvo( $txtCodigoEstudiante, $txtCodigoPeriodo ){
		$detallePazySalvo = new DetallePazySalvo( $this->persistencia );
		return $detallePazySalvo->consultarPazySalvo( $txtCodigoEstudiante, $txtCodigoPeriodo );
	}
	
	/**
	 * Buscar Pago Derecho de Grados
	 * @param int $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function buscarPazySalvo( $txtCodigoEstudiante, $txtCodigoPeriodo ){
		$detallePazySalvo = new DetallePazySalvo( $this->persistencia );
		return $detallePazySalvo->buscarPazySalvo( $txtCodigoEstudiante, $txtCodigoPeriodo );
		
	}


}
?>