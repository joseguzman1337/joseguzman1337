<?php
   /**
   * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
   * @copyright Universidad el Bosque - Dirección de Tecnología
   * @package control
   */
  
  include '../entidades/ActaAcuerdo.php';
  include '../entidades/DetalleActaAcuerdo.php';
  
  class ControlActaAcuerdo{
  	
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
	public function ControlActaAcuerdo( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Actualiza la fecha de Grado
 	 * @param FechaGrado $fechaGrado
	 * @access public
	 * @return boolean
	 */
	public function crearActaAcuerdo( $actaAcuerdo, $idPersona ) {
			
		//if( $actaAcuerdo->existeActaAcuerdo( ) == 0 ){
				
			$actaAcuerdo->crearActaAcuerdo( $idPersona );
			return true;
		/*}else{
			return false;
		}*/
	}
	
	/**
	 * Actualiza la fecha de Grado
 	 * @param FechaGrado $fechaGrado
	 * @access public
	 * @return boolean
	 */
	public function crearDetalleActaAcuerdo( $detalleActaAcuerdo, $idPersona ) {
			
		$detalleActaAcuerdo->crearDetalleAC( $idPersona );
			
		return true;
	}
	
	/**
	 * Buscar si existe acta
	 * @param int $txtFechaGrado, $txtCodigoCarrera
	 * @access public
	 * @return void
	 */
	public function buscarActaAcuerdo( $txtFechaGrado, $txtCodigoCarrera ){
		$actaAcuerdo = new ActaAcuerdo( $this->persistencia );
		return $actaAcuerdo->buscarActaAcuerdo( $txtFechaGrado, $txtCodigoCarrera );		
	}
	
	/**
	 * Buscar si existe acuerdo
	 * @param int $txtFechaGrado, $txtCodigoCarrera, $txtIdActa
	 * @access public
	 * @return void
	 */
	public function existeAcuerdo( $txtFechaGrado, $txtCodigoCarrera ){
		$actaAcuerdo = new ActaAcuerdo( $this->persistencia );
		return $actaAcuerdo->existeAcuerdo($txtFechaGrado, $txtCodigoCarrera);		
	}
	
	/**
	 * Busca acta por FechaGrado, Carrera
	 * @param int $txtFechaGrado, $txtCodigoCarrera
	 * @access public
	 * @return void
	 */
	public function buscarActa( $txtFechaGrado, $txtCodigoCarrera, $txtCodigoEstudiante ) {
		$actaAcuerdo = new ActaAcuerdo( $this->persistencia );
		$actaAcuerdo->buscarActa( $txtFechaGrado, $txtCodigoCarrera, $txtCodigoEstudiante);
		return $actaAcuerdo;
	}
	
	/**
	 * Busca acta por Id, FechaGrado, Carrera
	 * @param int $idPersona
	 * @access public
	 * @return void
	 */
	public function buscarActaId( $txtFechaGrado, $txtIdActa, $txtCodigoCarrera ) {
		$actaAcuerdo = new ActaAcuerdo( $this->persistencia );
		$actaAcuerdo->buscarActaId($txtFechaGrado, $txtIdActa, $txtCodigoCarrera);
		return $actaAcuerdo;
	}
	
	
	/**
	 * Buscar id actaAcuerdo por secretaria
	 * @param int $txtCodigoEstudiante, $txtFechaGrado, $txtCodigoCarrera
	 * @access public
	 * @return void
	 */
	public function buscarDetalleActaAcuerdoId( $txtCodigoEstudiante, $txtFechaGrado, $txtCodigoCarrera ) {
		$actaAcuerdo = new ActaAcuerdo( $this->persistencia );
		$actaAcuerdo->buscarDetalleActaAcuerdoId($txtCodigoEstudiante, $txtFechaGrado, $txtCodigoCarrera);
		return $actaAcuerdo;
	}
	
	/**
	 * Buscar si existe Detalle Acuerdo Acta
	 * @param int $txtIdActa, $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function buscarDetalleActa( $txtIdActa, $txtCodigoEstudiante ){
		$detalleActaAcuerdo = new DetalleActaAcuerdo( $this->persistencia );
		if( $detalleActaAcuerdo->buscarDetalleActa( $txtIdActa, $txtCodigoEstudiante ) != 0 ){
			$detalleActaAcuerdo = "../css/images/circuloVerde.png";
		}else{
			$detalleActaAcuerdo = "../css/images/circuloRojo.png";
		}
		return $detalleActaAcuerdo;
		
	}
	
	/**
	 * Buscar Detalle Acuerdo Acta por Estudiante
	 * @param int $txtIdActa, $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function buscarDetalleActaId( $txtIdActa, $txtCodigoEstudiante ){
		$detalleActaAcuerdo = new DetalleActaAcuerdo( $this->persistencia );
		$detalleActaAcuerdo->buscarDetalleActaId($txtIdActa, $txtCodigoEstudiante);
		return $detalleActaAcuerdo;
		
	}
	
	/**
	 * Consulta los estudiantes que tiene acta de consejo de facultad
	 * @access public
	 * @return Array<Estudiantes>
	 */
	public function consultarEstudianteActa( $txtFechaGrado ){
		$detalleActaAcuerdo = new DetalleActaAcuerdo( $this->persistencia );
		return $detalleActaAcuerdo->consultarEstudianteActa( $txtFechaGrado );
	}
	
	/**
	 * Consulta los estudiantes que tiene acuerdo de consejo directivo
	 * @access public
	 * @return Array<Estudiantes>
	 */
	public function consultarEstudianteAcuerdo( $txtFechaGrado ){
		$detalleActaAcuerdo = new DetalleActaAcuerdo( $this->persistencia );
		return $detalleActaAcuerdo->consultarEstudianteAcuerdo( $txtFechaGrado );
	}
	
	/**
	 * Anular Acta Estudiante
 	 * @param int txtIdDetalleActa
	 * @access public
	 * @return boolean
	 */
	public function anularActa( $detalleActaAcuerdo ){
		$anularActa = $detalleActaAcuerdo->anularActa( );
		return true;
	}
	
	/**
	 * Actualizar Acta Estudiante
 	 * @param int $idPersona, $txtIdDetalleActa, $txtIdActa, $txtCodigoEstudiante
	 * @access public
	 * @return boolean
	 */
	public function actualizarDetalleAcuerdo( $txtIdActa, $txtCodigoEstudiante ){
		$detalleActaAcuerdo = new DetalleActaAcuerdo( $this->persistencia );
		$detalleActaAcuerdo->actualizarDetalleAcuerdo( $txtIdActa, $txtCodigoEstudiante );
		return $detalleActaAcuerdo;
	}
	
	/**
	 * Buscar Estudiante por DetalleAcuerdoActaId
	 * @param int $txtIdActa, $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function buscarEstudianteDetalleActaId( $txtIdDetalleActa ){
		$detalleActaAcuerdo = new DetalleActaAcuerdo( $this->persistencia );
		$detalleActaAcuerdo->buscarEstudianteDetalleActaId( $txtIdDetalleActa );
		return $detalleActaAcuerdo;
		
	}
	
	
	/**
	 * Consulta los estudiantes que tienen acta facultad usuario consejo directivo
	 * @access public
	 * @return Array<Estudiantes>
	 */
	public function consultarEActas( $filtroActa, $txtIdRol ){
		$detalleActaAcuerdo = new DetalleActaAcuerdo( $this->persistencia );
		return $detalleActaAcuerdo->consultarEActas( $filtroActa, $txtIdRol );
	}
	
	
	/**
	 * Buscar acuerdo
	 * @param int $txtFechaGrado, $txtCodigoCarrera, $txtIdActa
	 * @access public
	 * @return void
	 */
	public function buscarAcuerdo( $txtFechaGrado, $txtCodigoCarrera, $txtIdActa, $txtCodigoEstudiante ){
		$actaAcuerdo = new ActaAcuerdo( $this->persistencia );
		$actaAcuerdo->buscarAcuerdo($txtFechaGrado, $txtCodigoCarrera, $txtIdActa, $txtCodigoEstudiante);
		return $actaAcuerdo;	
	}
	
	/**
	 * Actualizar Acuerdo
 	 * @param int $txtNumeroAcuerdo, $txtFechaAcuerdo, $idPersona, $txtIdActa
	 * @access public
	 * @return boolean
	 */
	public function actualizarAcuerdo( $txtNumeroAcuerdo, $txtFechaAcuerdo, $txtNumeroActaAcuerdo, $idPersona, $txtIdActa ){
		$actaAcuerdo = new ActaAcuerdo( $this->persistencia );
		$actaAcuerdo->crearAcuerdo($txtNumeroAcuerdo, $txtFechaAcuerdo, $txtNumeroActaAcuerdo, $idPersona, $txtIdActa);
		return $actaAcuerdo;
	}
	
	/**
	 * Buscar si existe Detalle Acuerdo Acta
	 * @param int $txtIdActa, $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function buscarDetalleAcuerdo( $txtIdActa, $txtCodigoEstudiante ){
		$detalleAcuerdo = new DetalleActaAcuerdo( $this->persistencia );
		if( $detalleAcuerdo->buscarDetalleAcuerdo( $txtIdActa, $txtCodigoEstudiante ) != 0 ){
			$detalleAcuerdo = "../css/images/circuloVerde.png";
		}else{
			$detalleAcuerdo = "../css/images/circuloRojo.png";
		}
		return $detalleAcuerdo;
		
	}
	
	
	/**
	 * Anular Acuerdo
 	 * @param int txtIdDetalleActa
	 * @access public
	 * @return boolean
	 */
	public function anularAcuerdo( $txtIdDetalleActa ){
		$detalleActaAcuerdo = new DetalleActaAcuerdo( $this->persistencia );
		return $detalleActaAcuerdo->anularAcuerdo( $txtIdDetalleActa );
	}
	
	
	
	/**
	 * Consulta los estudiantes que tienen acta facultad y acuerdo de consejo directivo para usuario secretaria general
	 * @access public
	 * @return Array<Estudiantes>
	 */
	public function consultarEAcuerdo( $filtroAcuerdo ){
		$detalleActaAcuerdo = new DetalleActaAcuerdo( $this->persistencia );
		return $detalleActaAcuerdo->consultarEAcuerdo( $filtroAcuerdo );
	}
	
	
	/**
	 * Consulta las actas y acuerdos 
	 * @access public
	 * @return Array<AcuerdoActas>
	 */
	public function consultarActaAcuerdos( $txtFechaGrado ){
		$actaAcuerdo = new ActaAcuerdo( $this->persistencia );
		return $actaAcuerdo->consultarActaAcuerdos( $txtFechaGrado );
	}
	
        public function consultarActaAcuerdosAgrupada( $txtFechaGrado ){
		$actaAcuerdo = new ActaAcuerdo( $this->persistencia );
		return $actaAcuerdo->consultarActaAcuerdosAgrupados( $txtFechaGrado );
	}
        
	
	/**
	 * Consulta estudiantes generar acuerdo
	 * @access public
	 * @return Array<AcuerdoActas>
	 */
	public function consultarAcuerdoPDF( $txtFechaGrado, $txtIdActaAcuerdo ){
		$detalleActaAcuerdo = new DetalleActaAcuerdo( $this->persistencia );
		return $detalleActaAcuerdo->consultarAcuerdoPDF($txtFechaGrado, $txtIdActaAcuerdo);
	}
        
        public function consultarAcuerdoPDFNumero( $txtFechaGrado, $txtActaAcuerdoNumero ){
		$detalleActaAcuerdo = new DetalleActaAcuerdo( $this->persistencia );
		return $detalleActaAcuerdo->consultarAcuerdoPDFNumero($txtFechaGrado, $txtActaAcuerdoNumero);
	}
	
        
	/**
	 * Consulta estudiantes generar acta
	 * @access public
	 * @return Array<AcuerdoActas>
	 */
	public function consultarActaPDF( $txtFechaGrado, $txtIdActaAcuerdo ){
		$detalleActaAcuerdo = new DetalleActaAcuerdo( $this->persistencia );
		return $detalleActaAcuerdo->consultarActaPDF( $txtFechaGrado, $txtIdActaAcuerdo );
	}
	
	
	/**
	 * Actualizar Envio Correo Secretaria
 	 * @param int $txtIdActaAcuerdo, $txtCodigoEstudiante
	 * @access public
	 * @return boolean
	 */
	public function actualizarEnvioSecretaria( $txtIdActaAcuerdo, $txtCodigoEstudiante ){
		$detalleActaAcuerdo = new DetalleActaAcuerdo( $this->persistencia );
		return $detalleActaAcuerdo->actualizarEnvioSecretaria( $txtIdActaAcuerdo, $txtCodigoEstudiante ); 
	}
	
	/**
	 * Actualizar Envio Correo Vicerrectoria
 	 * @param int $txtIdActaAcuerdo, $txtCodigoEstudiante
	 * @access public
	 * @return boolean
	 */
	public function actualizarEnvioVicerrectoria( $txtIdActaAcuerdo, $txtCodigoEstudiante ){
		$detalleActaAcuerdo = new DetalleActaAcuerdo( $this->persistencia );
		return $detalleActaAcuerdo->actualizarEnvioVicerrectoria($txtIdActaAcuerdo, $txtCodigoEstudiante); 
	}
	
	/**
	 * Buscar si existe acta y no acuerdo
	 * @param int $txtFechaGrado, $txtCodigoCarrera, $txtIdActa
	 * @access public
	 * @return void
	 */
	public function existeActaAcuerdo( $txtFechaGrado ){
		$actaAcuerdo = new ActaAcuerdo( $this->persistencia );
		return $actaAcuerdo->existeActaAcuerdo( $txtFechaGrado );		
	}
	
	/**
	 * Consulta las actas y acuerdos por Periodo
	 * @access public
	 * @return Array<AcuerdoActas>
	 */
	public function consultarActaAcuerdosPeriodo( $txtFechaGrado, $txtCodigoPeriodo ){
		$actaAcuerdo = new ActaAcuerdo( $this->persistencia );
		return $actaAcuerdo->consultarActaAcuerdosPeriodo( $txtFechaGrado, $txtCodigoPeriodo );
	}
	/**
	 * Registra actaacuerdo
	 * @access public
	 * @return void
	 */
        public function crearActaAcuerdoDistancia( $actaAcuerdo, $idPersona ) {

                $actaAcuerdo->crearActaAcuerdoDistancia( $idPersona );
                return true;
        }
        /**
	 * registra detalle actaacuerdo
	 * @access public
	 * @return void
	 */
        public function crearDetalleActaAcuerdoDistancia( $detalleActaAcuerdo, $idPersona ) {

            $detalleActaAcuerdo->crearDetalleACAdiconal( $idPersona );
            return true;
	}
	
  }
?>