<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Dirección de Tecnología - Universidad el Bosque
   * @package entidades
   */
  
  
  include '../entidades/DeudaPeople.php';
  
  class ControlDeudaPeople{
  	
	
	/**
	 * @type Singleton
	 * @access private
	 */
	private $persistencia;
		
		
	/**
	 * Constructor
	 * @param Singleton $persistencia
	 */
	public function ControlDeudaPeople( $persistencia ) {
		$this->persistencia = $persistencia;
	}
	
	
	/**
	 * Inserta un registro de incentivo academico a un estudiante
 	 * @param FechaGrado $fechaGrado
	 * @access public
	 * @return boolean
	 */
	public function crearDeudaPeople( $txtCodigoEstudiante ){
		$deudaPeople = new DeudaPeople( $this->persistencia );
		if( $deudaPeople->existeDeudaPeople( $txtCodigoEstudiante ) == 0 ){
			$deudaPeople->crearDeudaPeople( $txtCodigoEstudiante );
		}
		return $deudaPeople;
	}
	
	/**
	 * Buscar si existe Deuda en People
	 * @param int $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function existeDeudaPeople( $txtCodigoEstudiante ){
		$deudaPeople = new DeudaPeople( $this->persistencia );
		if( $deudaPeople->existeDeudaPeople( $txtCodigoEstudiante ) != 0 ){
			$deudaPeople = "../css/images/circuloRojo.png";
			$existeDeudaPeople = 0;
		}else{
			$deudaPeople = "../css/images/circuloVerde.png";
			$existeDeudaPeople = 1;
		}
		return array( 'deudaPeople' => $deudaPeople, 'existeDeudaPeople' => $existeDeudaPeople );	
	}
	
	/**
	 * Actualizar Deuda People
 	 * @param int $txtCodigoEstudiante
	 * @access public
	 * @return boolean
	 */
	public function actualizarDeudaPeople( $txtCodigoEstudiante ){
		$deudaPeople = new DeudaPeople( $this->persistencia );
		$deudaPeople->actualizarDeudaPeople( $txtCodigoEstudiante );
		return $deudaPeople;
	}
	
	/**
	 * Contar Deuda People
	 * @access public
	 * @return void
	 */
	public function contarDeudaPeople( ){
		$deudaPeople = new DeudaPeople( $this->persistencia );
		return $deudaPeople->contarDeudaPeople( );	
	}
	
	/**
	 * Eliminar Registros de la Deuda de People
	 * @access public
	 * @return boolean
	 */
	public function eliminarDeudaPeople( ){
		$deudaPeople = new DeudaPeople( $this->persistencia );
		$deudaPeople->eliminarDeudaPeople( );
		return $deudaPeople;
		 
	}
	
	
	/**
	 * Buscar si existe Deuda People Estudiante
	 * @param int $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function existeDeudaPeopleEstudiante( $txtCodigoEstudiante ){
		$deudaPeople = new DeudaPeople( $this->persistencia );
		return $deudaPeople->existeDeudaPeople( $txtCodigoEstudiante );
	}
	
	
  }
  
  
?>