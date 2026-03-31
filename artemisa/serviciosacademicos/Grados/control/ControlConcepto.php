<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package entidades
   */
  
  include '../entidades/Concepto.php';
  include '../entidades/OrdenPago.php';
  include '../entidades/DetalleOrdenPago.php';
  
  
  class ControlConcepto{
  	
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
		
		
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function ControlConcepto( $persistencia ) {
		$this->persistencia = $persistencia;
	}
	
	
	/**
	 * Buscar si existe Pago Derecho de Grados
	 * @param int $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function buscarDerechoGrado( $txtCodigoEstudiante ){
		$concepto = new Concepto( $this->persistencia );
		if($concepto->buscar( $txtCodigoEstudiante ) != 0 ){
			$concepto = "../css/images/circuloVerde.png";
			
			$existeDerechoGrado = 1;
			
		}else{
			$concepto = "../css/images/circuloRojo.png";
			
			$existeDerechoGrado = 0;
			
		}
		return array('concepto' => $concepto, 'existeDGrado' => $existeDerechoGrado );
		
	}
	
	/**
	 * Buscar Pago Derecho de Grados
	 * @param int $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function buscarEstudianteDG( $txtCodigoEstudiante ){
		$concepto = new Concepto( $this->persistencia );
		$concepto->buscarEstudianteDG( $txtCodigoEstudiante );
		return $concepto;
	}
	
	/**
	 * Buscar si existe Pago Derecho de Grados
	 * @param int $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function buscarExisteOtrosP( $txtCodigoEstudiante, $txtCodigoPeriodo ){
		$concepto = new Concepto( $this->persistencia );
		
		$controlPazySalvo = new ControlPazySalvoEstudiante( $this->persistencia );
		
		$detallePazySalvo = $controlPazySalvo->buscarPazySalvo( $txtCodigoEstudiante, $txtCodigoPeriodo );
		
		if( $concepto->buscarExisteOtros($txtCodigoEstudiante, $txtCodigoPeriodo) != 0 || $detallePazySalvo != 0 ){
			$concepto = "../css/images/circuloRojo.png";
			
			$pendienteOtro = 0;
			
		}else{
			$concepto = "../css/images/circuloVerde.png";
			
			$pendienteOtro = 1;
			
		}
		return array( 'conceptoOtro' => $concepto, 'pendienteOtro' => $pendienteOtro );
		
	}
	
	/**
	 * Consultar Otros
	 * @param int $txtCodigoEstudiante, $txtCodigoPeriodo
	 * @access public
	 * @return <Array>Concepto
	 */
	public function consultarOtros( $txtCodigoEstudiante, $txtCodigoPeriodo ){
		$concepto = new Concepto( $this->persistencia );
		return $concepto->consultarOtros( $txtCodigoEstudiante, $txtCodigoPeriodo );
	}
	
	/**
	 * Consultar Pagos Pendientes por Orden de Pago
	 * @param int $txtCodigoEstudiante, $txtCodigoPeriodo
	 * @access public
	 * @return <Array>Concepto
	 */
	public function consultarConceptoOrdenPago( $txtNumeroOrdenPago ){
		$concepto = new Concepto( $this->persistencia );
		return $concepto->consultarConceptoOrdenPago( $txtNumeroOrdenPago );
	}
	
  }
?>