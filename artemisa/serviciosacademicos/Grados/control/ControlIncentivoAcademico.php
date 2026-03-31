<?php
   /**
    * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Universidad el Bosque - Dirección de Tecnología
    * @package control
    */
   
   include '../entidades/IncentivoAcademico.php';
   
   class ControlIncentivoAcademico{
   	
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
	public function ControlIncentivoAcademico( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Consulta los incentivos
	 * @access public
	 * @return Array<Incentivos>
	 */
	public function consultarIncentivo( ){
		$incentivo = new IncentivoAcademico( $this->persistencia );
		return $incentivo->consultarIncentivo( );
	}
	
	
	/**
	 * Busca un incentico por Id
	 * @param int $txtCodigoIncentivo
	 * @access public
	 * @return void
	 */
	public function buscarIncentivoId( $txtCodigoIncentivo ) {
		$incentivo = new IncentivoAcademico( $this->persistencia );
		$incentivo->setIdIncentivo( $txtCodigoIncentivo );
		$incentivo->buscarIncentivoId( );
		return $incentivo;
	}
	
	/**
	 * Inserta un registro de incentivo academico a un estudiante
 	 * @param FechaGrado $fechaGrado
	 * @access public
	 * @return boolean
	 */
	public function crearRegistroIncentivo( $txtCodigoEstudiante, $txtCodigoIncentivo, $txtCodigoCarrera, $txtNombreIncentivo, $txtNumeroIncentivo, $txFechaActaIncentivo, $txtObservacionIncentivo, $idPersona ){ 
		$incentivo = new IncentivoAcademico( $this->persistencia );
		return $incentivo->crearRegistroIncentivo( $txtCodigoEstudiante, $txtCodigoIncentivo, $txtCodigoCarrera, $txtNombreIncentivo, $txtNumeroIncentivo, $txFechaActaIncentivo, $txtObservacionIncentivo, $idPersona );
		
	}
	
	/**
	 * Consulta los incentivos de los Estudiantes
	 * @access public
	 * @return Array<Incentivos>
	 */
	public function listarIncentivoEstudiante( $txtCodigoEstudiante, $txtCodigoCarrera ){
		$incentivo = new IncentivoAcademico( $this->persistencia );
		return $incentivo->listarIncentivoEstudiante( $txtCodigoEstudiante, $txtCodigoCarrera );
	}
	
	/**
	 * Anular Incentivos
 	 * @param int $txtIdRegistroIncentivo
	 * @access public
	 * @return boolean
	 */
        
        /**
        *@modified Diego Rivera<riveradiego@unbosque.edu.co>
        *Se añade varialbe idpersona a metodo acutalizarIncentivos
        *@Since January 29,2019 
        */
	public function actualizarIncentivos( $txtIdRegistroIncentivo ,$idPersona){
		$incentivo = new IncentivoAcademico( $this->persistencia );
		$incentivo->anularIncentivos( $txtIdRegistroIncentivo, $idPersona );
		return $incentivo;
	}
	
	/**
	 * Existe Incentivo Estudiante IdIncentivo y Carrera
	 * @param $txtCodigoEstudiante, $txtCodigoIncentivo, $txtCodigoCarrera 
	 * @access public
	 * @return void 
	 */
	public function existeIncentivo( $txtCodigoEstudiante, $txtCodigoIncentivo, $txtCodigoCarrera ){
		$incentivo = new IncentivoAcademico( $this->persistencia );
		return $incentivo->existeIncentivo( $txtCodigoEstudiante, $txtCodigoIncentivo, $txtCodigoCarrera );
	}
	
	/**
	 * Existe Incentivo estudiante Carrera
	 * @param $txtCodigoEstudiante, $txtCodigoCarrera 
	 * @access public
	 * @return void 
	 */
	public function existeIncentivoEstudiante( $txtCodigoEstudiante, $txtCodigoCarrera ){
		$incentivo = new IncentivoAcademico( $this->persistencia );
		return $incentivo->existeIncentivoEstudiante($txtCodigoEstudiante, $txtCodigoCarrera);
	}
	
	/**
	 * Existe Incentivo FechaGrado
	 * @param $txtCodigoEstudiante, $txtCodigoCarrera 
	 * @access public
	 * @return void 
	 */
	public function existeIncentivoFechaGrado( $txtFechaGrado ){
		$incentivo = new IncentivoAcademico( $this->persistencia );
		return $incentivo->existeIncentivoFechaGrado( $txtFechaGrado );
	}
	
	/**
	 * Busca incentico Estudiante Carrera
	 * @param int $idPersona
	 * @access public
	 * @return void
	 */
	public function buscarIncentivoEstudiante( $txtCodigoEstudiante, $txtCodigoCarrera ) {
		$incentivo = new IncentivoAcademico( $this->persistencia );
		$incentivo->buscarIncentivoEstudiante( $txtCodigoEstudiante, $txtCodigoCarrera );
		return $incentivo;
	}
	
	/**
	 * Actualizar Acuerdo Incentivo
 	 * @param int $txtNumeroActaIncentivo, $txtNumeroAcuerdoIncentivo, $txtFechaIncentivo, $txtNumeroConsecutivoIncentivo, $txtCodigoEstudiante, $txtIdRegistroIncentivo
	 * @access public
	 * @return boolean
	 */
	public function actualizarAcuerdoIncentivo( $txtNumeroActaIncentivo, $txtNumeroAcuerdoIncentivo, $txtFechaIncentivo, $txtNumeroConsecutivoIncentivo, $txtCodigoEstudiante, $txtIdRegistroIncentivo ){
		$incentivo = new IncentivoAcademico( $this->persistencia );
		$incentivo->actualizarAcuerdoIncentivo($txtNumeroActaIncentivo, $txtNumeroAcuerdoIncentivo, $txtFechaIncentivo, $txtNumeroConsecutivoIncentivo, $txtCodigoEstudiante, $txtIdRegistroIncentivo);
		return $incentivo;
	}
	
	/**
	 * VerIncentivoEstudiantes 
 	 * @param int  $txtCodigoEstudiante , $txtCodigoCarrera
	 * @access public
	 * @return  Array<Incentivos>
	 */
	public function VerIncentivoEstudiantes( $txtCodigoEstudiante , $txtCodigoCarrera ) {
		$incentivo = new IncentivoAcademico( $this->persistencia );
		return $incentivo->VerIncentivoEstudiante( $txtCodigoEstudiante, $txtCodigoCarrera );
		
	}

	/**
	 *  
 	 * @param $estudianteId , $carreraId , $incentivoId
	 * @access public
	 * @return  void 
	 */
	public function buscarIncentivoEstudiantes( $estudianteId , $carreraId , $incentivoId ) {
		$incentivo = new IncentivoAcademico( $this->persistencia );
		$incentivo->buscarIncentivoEstudiantes( $estudianteId , $carreraId , $incentivoId );
		return $incentivo;
	}
		/**
	 *  
 	 * @param int  $acta, $id 
 	 * @param string   $fecha , $observacion 
	 * @access public
	 * @return  void
	 */
	public function actualizarIncentivoRegistros( $acta , $fecha , $observacion , $id , $idPersona ){
		$incentivo = new IncentivoAcademico( $this->persistencia );
		return $incentivo->actualizarIncentivoRegistro( $acta , $fecha , $observacion , $id , $idPersona );
		//return $incentivo;

	}
   }
?>