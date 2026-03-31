<?php
  /**
   * @author Carlos Alberto Suárez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package control
   */
  
  include '../entidades/TrabajoGrado.php';
  
  class ControlTrabajoGrado{
  	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
	
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 * @access public
	 */
	public function ControlTrabajoGrado( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Busca Trabajo de Grado por Estudiante
	 * @param int $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function buscarTrabajoGrado( $txtCodigoEstudiante ) {
		$trabajoGrado = new TrabajoGrado( $this->persistencia );
		
		$estudiante = new Estudiante( null );
		$estudiante->setCodigoEstudiante( $txtCodigoEstudiante );
		
		$trabajoGrado->setEstudiante( $estudiante );
		if($trabajoGrado->buscar( ) != 0 ){
			$trabajoGrado = "../css/images/circuloVerde.png";
			
			$existeTGrado = 1;
			
		}else{
			$trabajoGrado = "../css/images/circuloRojo.png";
			
			$existeTGrado = 0;
			
		}
		return array( 'trabajoGrado' => $trabajoGrado, 'existeTGrado' => $existeTGrado ) ;
		
	}
	
	/**
	 * Busca Trabajo de Grado por Estudiante
	 * @param int $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function buscarTGradoEstudiante( $txtCodigoEstudiante ) {
		$trabajoGrado = new TrabajoGrado( $this->persistencia );
		
		$estudiante = new Estudiante( null );
		$estudiante->setCodigoEstudiante( $txtCodigoEstudiante );
		
		$trabajoGrado->setEstudiante( $estudiante );
		
		$trabajoGrado->buscarTGradoEstudiante( );
		
		return $trabajoGrado;
		
	}
	
  }
?>