<?php
  /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package control
   */
  
  include '../entidades/FechaGrado.php';
  
  class ControlFechaGrado{
  	
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
	public function ControlFechaGrado( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	
	/**
	 * Actualiza la fecha de Grado
 	 * @param FechaGrado $fechaGrado
	 * @access public
	 * @return boolean
	 */
	public function actualizar( $fechaGrado, $idPersona ) {
			
		if( $fechaGrado->existeFechaGrado( ) == 0 ){
			$fechaGrado->crearFechaGrado( $idPersona );
			echo 0;
		}else{
			echo 1;
		}	
		return true;
	}
	
	/**
	 * Actualiza la fecha de Grado
 	 * @param FechaGrado $fechaGrado $idPersona , $fechaGradoActual , $fechaMaxCumplimiento 
	 * @access public
	 * @return boolean
	 */
	public function fechaGradoActualizar( $fechaGrado, $idPersona , $fechaGradoActual , $fechaMaxCumplimiento,$idFechaGrado ){

		if( $fechaGrado->existeFechaGradoActualizar( ) == 0) {
				$fechaGrado->actulizarFechaGrado( $idPersona, $fechaGradoActual , $fechaMaxCumplimiento ,$idFechaGrado );
				echo 0;
		}else {
				echo 1;
		}

		return true;

	}

	/**
	 * Consulta la fecha de Grado
 	 * @param $filtroFecha
	 * @access public
	 * @return boolean
	 */
	public function consultarFechaGrado( $filtroFecha ) {
		$fechasGrado = new FechaGrado( $this->persistencia );
		return $fechasGrado->consultar( $filtroFecha );
	}
	
	/**
	 * Buscar Fecha Grado
	 * @access public
	 * @return void
	 */
	public function buscarFechaGrado( $txtFechaGrado ){
		$fechaGrado = new FechaGrado( $this->persistencia );
		$fechaGrado->setIdFechaGrado( $txtFechaGrado );
		$fechaGrado->buscarFechaGrado( );
		return $fechaGrado;
		
	}
	
	/**
	 * Buscar Fecha Grado Carrera
	 * @access public
	 * @return void
	 */
	public function buscarFechaGradoCarrera( $txtCodigoCarrera ){
		$fechaGrado = new FechaGrado( $this->persistencia );
		$fechaGrado->buscarFechaGradoCarrera( $txtCodigoCarrera );
		return $fechaGrado;
		
	}
	
	
	/**
	 * Valida los campos de la queja
	 * @access Queja $queja
	 * @access public
	 * @return String 
	 */
	public function validar( $fechaGrado ) {
		$error = "";
		
		
		$carrera = $fechaGrado->getCarrera( )->getCodigoCarrera( );
		if( $carrera == "-1" )
			$error .= "Seleccione una carrera"."<br />";
		
		if( $fechaGrado->getFechaGraduacion( ) == "" )
			$error .= "Por favor ingrese una fecha de grado"."<br />";
			
		if( $fechaGrado->getFechaMaxima( ) == "" )
			$error .= "Por favor ingrese una fecha máxima de cumplimiento de requisitos"."<br />";
		
		if( $fechaGrado->getPeriodo( )->getCodigo( ) == "-1" )
			$error .= "Por favor seleccione un período"."<br />";
		
		if( $fechaGrado->getTipoGrado( )->getIdTipoGrado( ) == "-1" )
			$error .= "Por favor seleccione un Tipo de Grado"."<br />";
				
		if( $error != "" )
			$error = "La fecha de grado no se ha podido ingresar </br>
					  hasta no completar los siguientes campos</br>" . $error;
		return $error;
	}
	
	
  }
?>