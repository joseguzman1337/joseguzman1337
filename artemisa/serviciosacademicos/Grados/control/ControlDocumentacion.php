<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package control
   */
  
  include '../entidades/Documentacion.php';  
   
   class ControlDocumentacion{
   	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
		
		
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function ControlDocumentacion( $persistencia ) {
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Buscar si existe documentacion pendiente
	 * @param int $txtCodigoCarrera, $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function buscarPendientes( $txtCodigoCarrera, $txtCodigoEstudiante ){
		$documentacion = new Documentacion( $this->persistencia );
		
		$rango = $documentacion->buscar( $txtCodigoCarrera, $txtCodigoEstudiante );
		
		switch( true ){
			
			case ( $rango >= 1 && $rango <= 6 ):
				$documentacion = "../css/images/circuloAmarillo.png";
				
				$existeDocumento = 0;
				
			break;
			
			case ( $rango >= 7 ):
				$documentacion = "../css/images/circuloRojo.png";
				
				$existeDocumento = -1;
				
			break;
			
			case ( $rango == 0 ):
				$documentacion = "../css/images/circuloVerde.png";
				
				$existeDocumento = 1;
				
			break;
		}
		
		return array('documentacion' => $documentacion, 'existeDocumento' => $existeDocumento );
		
	}
	
	/**
	 * Buscar Si tiene Pendiente Ingles
	 * @param int $txtCodigoCarrera, $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function buscarPendienteIngles( $txtCodigoEstudiante, $txtCodigoCarrera ){
		$documentacion = new Documentacion( $this->persistencia );
		
		if( $documentacion->buscarIngles($txtCodigoEstudiante, $txtCodigoCarrera) != 0 ){
			$documentacion = "../css/images/circuloVerde.png";
			
			$pendienteIngles = 1;
			
		}else{
			$documentacion = "../css/images/circuloRojo.png";
			
			$pendienteIngles = 0;
				
		}
		
		return array( 'pendienteIngles' => $documentacion, 'existeIngles' => $pendienteIngles );
		
	}
	
	/**
	 * Busca Doc Pendientes
	 * @param int $txtCodigoCarrera, $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function consultarDocPendiente( $txtCodigoCarrera, $txtCodigoEstudiante ) {
		$documento = new Documentacion( $this->persistencia );
		return $documento->consultarDocPendiente( $txtCodigoCarrera, $txtCodigoEstudiante );
	}
	
	/**
	 * Buscar Si tiene documento de Ingles
	 * @param int $txtCodigoCarrera, $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function buscarDocIngles( $txtCodigoEstudiante, $txtCodigoCarrera ){
		$documentacion = new Documentacion( $this->persistencia );
		$documentacion->buscarDocIngles($txtCodigoEstudiante, $txtCodigoCarrera);
		return $documentacion;
	}
	
	
	
   }
?>