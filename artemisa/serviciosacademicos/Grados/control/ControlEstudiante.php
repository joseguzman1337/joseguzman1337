<?php
   /**
    * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Universidad el Bosque - Dirección de Tecnología
    * @package entidades
    */
   
   ini_set('display_errors','On');
   set_time_limit(0);
   
   include '../entidades/Estudiante.php';
   include '../entidades/PreMatricula.php';
   include '../entidades/SituacionCarreraEstudiante.php';
   include '../entidades/PlanEstudioEstudiante.php';
   include '../entidades/PlanEstudio.php';
   include '../entidades/Genero.php';
   include '../entidades/TipoGrado.php';
   
   
   class ControlEstudiante{
   	
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
	public function ControlEstudiante( $persistencia ){
		$this->persistencia = $persistencia;
	}
	
	/**
	 * Consulta los estudiantes de ultimo semestre
	 * @access public
	 * @return Array<Estudiantes>
	 */
	public function consultarEstudiantesUltimoSemestre( $filtro, $codigoModalidadAcademica=200 ){
		$estudiante = new Estudiante( $this->persistencia );
		return $estudiante->consultar( $filtro, $codigoModalidadAcademica );
	}
	
	/**
	 * Busca un Estudiante por Codigo
	 * @param String $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function buscarEstudiante( $txtCodigoEstudiante ) {
		$estudiante = new Estudiante( $this->persistencia );
		$estudiante->setCodigoEstudiante( $txtCodigoEstudiante );
		$estudiante->buscarEstudiante( );
		return $estudiante;
	}
        
    /**
     * Buscar Lugar Rotación Estudiante Esp. Anestesiologia
     * @param $txtCodigoEstudiante
     * @access public
     */    
    public function buscarRotacionEstudiante( $txtCodigoEstudiante ){
        $estudiante = new Estudiante( $this->persistencia );
        $rotacion=$estudiante->buscarRotacionEstudiante( $txtCodigoEstudiante );
        return $rotacion;
    }
	
	/**
	 * Actualiza Datos Estudiante
 	 * @param Estudiante $estudiante
	 * @access public
	 * @return boolean
	 */
	public function actualizarEstudiante( $estudiante , $txtCodigoEstudiante ){
		
		$controlClienteWebService = new ControlClienteWebService( $this->persistencia );
		$actualizaWebService = $controlClienteWebService->modificaDatosEstudiante( $estudiante , $txtCodigoEstudiante );
			
			
		if( $actualizaWebService["ERRNUM"] != 0 ){
			echo "Ha ocurrido un problema";
		}else{
		
			$estudiante->actualizarEstudiante( );
			/*
			 * @modified David Perez <perezdavid@unbosque.edu.co>
			 * @since  Septiembre 25, 2017
			 * Cambios en bloque para deshabilitar el reporte de terceros a Campus debido a lentitud extrema en el proceso
			*/
			$estudiante->insertaLogtraceintegracionps( $actualizaWebService );
			/*Fin cambios*/
			$controlEstudianteDocumento = new ControlEstudianteDocumento( $this->persistencia );
			
			$txtIdEstudiante = $estudiante->getIdEstudiante( );
			$txtTipoDocumento = $estudiante->getTipoDocumento( )->getIniciales( );
			$txtNumeroDocumento = $estudiante->getNumeroDocumento( );
			$txtExpedidoDocumento = $estudiante->getExpedicion( );
			
			$estudianteDocumento = $controlEstudianteDocumento->buscarEstudianteDocumento( $txtIdEstudiante, $txtTipoDocumento, $txtNumeroDocumento );
			
			$txtIdEstudianteDocumento = $estudianteDocumento->getIdEstudianteDocumento( );
			
			$txtFechaVencimientoDocumento = $estudianteDocumento->getFechaVencimientoEstudianteDocumento( );
			
			$fechaHoy = date("Y-m-d");
			
			
			
			if( $txtIdEstudianteDocumento != "" ){
				
				if( $txtTipoDocumento != $estudianteDocumento->getEstudiante( )->getTipoDocumento( )->getIniciales( ) || $txtNumeroDocumento != $estudianteDocumento->getEstudiante( )->getNumeroDocumento( ) ){
					$controlEstudianteDocumento->actualizarEstudianteDocumento( $txtIdEstudiante, $txtIdEstudianteDocumento );
					$controlEstudianteDocumento->crearEstudianteDocumento( $txtIdEstudiante, $txtTipoDocumento, $txtNumeroDocumento, $txtExpedidoDocumento );
				}else{
					if( $txtFechaVencimientoDocumento <= $fechaHoy ){
						$controlEstudianteDocumento->actualizarFechaVencimientoEstudianteDocumento( $txtIdEstudiante, $txtIdEstudianteDocumento );
					}
				}
			}else{
				$controlEstudianteDocumento->crearEstudianteDocumento( $txtIdEstudiante, $txtTipoDocumento, $txtNumeroDocumento, $txtExpedidoDocumento );	
			}
			echo "Cambios guardados correctamente";
		}
		return true;
	}
	
	/**
	 * Busca estudiante que no tenga registrada un acta
	 * @param String $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function buscarEstudianteActa( $txtCodigoEstudiante ) {
		$estudiante = new Estudiante( $this->persistencia );
		$estudiante->setCodigoEstudiante( $txtCodigoEstudiante );
		$estudiante->buscarEstudianteActa( );
		return $estudiante;
	}
	
	/**
	 * Busca un estudiante que no tenga registrado acuerdo
	 * @param String $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function buscarEstudianteAcuerdo( $txtCodigoEstudiante ) {
		$estudiante = new Estudiante( $this->persistencia );
		$estudiante->setCodigoEstudiante( $txtCodigoEstudiante );
		$estudiante->buscarEstudianteAcuerdo( );
		return $estudiante;
	}
	
	/**
	 * Valida los campos de la queja
	 * @access Queja $queja
	 * @access public
	 * @return String 
	 */
	public function validar( $cmbFacultadTMando, $cmbCarreraTMando, $cmbPeriodoTMando ) {
		$error = "";
		
		if( $cmbFacultadTMando == "-1" )
			$error .= "Seleccione una Facultad"."<br />";
		
		if( $cmbCarreraTMando == "-1" )
			$error .= "Seleccione una Carrera"."<br />";
			
		if( $cmbPeriodoTMando == "-1" )
			$error .= "Seleccione un Período"."<br />";
				
		if( $error != "" )
			$error = "La fecha de grado no se ha podido ingresar </br>
					  hasta no completar los siguientes campos</br>" . $error;
		return $error;
	}
	
	
	/**
	 * Consulta Estudiantes a Graduarse Ultimo Semestre
	 * @access public
	 * @return Array<Estudiantes>
	 */
	public function consultarEstudianteGraduarse( ){
		$estudiante = new Estudiante( $this->persistencia );
		return $estudiante->consultarEstudianteGraduarse( );
	}
	
	/**
	 * Consulta Estudiantes a por Facultad
	 * @access public
	 * @return Array<Estudiantes>
	 */
	public function consultarEstudianteNotificarFacultad( $codigoFacultad, $codigoCarrera ){
		$estudiante = new Estudiante( $this->persistencia );
		return $estudiante->consultarEstudianteNotificarFacultad( $codigoFacultad, $codigoCarrera );
	}
	
	/**
	 * Consulta Estudiantes Notificacion Inglés
	 * @access public
	 * @return Array<Estudiantes>
	 */
	public function consultarEstudiantesNotificarIngles( ){
		$estudiante = new Estudiante( $this->persistencia );
		return $estudiante->consultarEstudiantesNotificarIngles( );
	}
	
	/**
	 * Buscar Plan Estudio Estudiante
	 * @param int $txtCodigoEstudiante
	 * @access public
	 * @return void
	 */
	public function buscarPlanEstudioEstudiante( $txtCodigoEstudiante ){
		$planEstudioEstudiante = new PlanEstudioEstudiante( $this->persistencia );
		$planEstudioEstudiante->buscarPlanEstudioEstudiante( $txtCodigoEstudiante );
		return $planEstudioEstudiante;
		
	}
	
	
	/**
	 * Existe Linea de Enfasis
	 * @param $txtCodigoCarrera 
	 * @access public
	 * @return void 
	 */
	public function existeLineaEnfasis( $txtCodigoCarrera ){
		$planEstudio = new PlanEstudio( $this->persistencia );
		return $planEstudio->existeLineaEnfasis( $txtCodigoCarrera );
	}
	
	
	/**
	 * Consulta los estudiantes de ultimo semestre
	 * @access public
	 * @return Array<Estudiantes>
	 */
	public function consultarCronEstudiante( $txtCodigoCarrera ){
		$estudiante = new Estudiante( $this->persistencia );
		return $estudiante->consultarCronEstudiante($txtCodigoCarrera);
	}
	
	/**
	 * Consultar Genero
	 * @access public
	 * @return Array
	 */
	public function consultarGenero( ){
		$genero = new Genero( $this->persistencia );
		return $genero->consultarGenero( );
	}
	
	/**
	 * Busca Estado Civil Estudiante People
	 * @param int $txtTipoDocumento
	 * @access public
	 * @return void
	 */
	public function buscarEstadoCivilPeople( $txtNumeroDocumento ){
		$estudiante = new Estudiante( $this->persistencia );
		$estudiante->buscarEstadoCivilPeople( $txtNumeroDocumento );
		return $estudiante;
		
	}
	
	/**
	 * Actualiza Datos Estudiante
 	 * @param Estudiante $estudiante
	 * @access public
	 * @return boolean
	 */
	public function actualizarEstudianteSinCambios( $estudiante ){
		
		
		$agregar = $estudiante->actualizarEstudiante( );
		if( $agregar != ""){
			echo "Ha ocurrido un problema";
		}else{
			$controlEstudianteDocumento = new ControlEstudianteDocumento( $this->persistencia );
			
			$txtIdEstudiante = $estudiante->getIdEstudiante( );
			$txtTipoDocumento = $estudiante->getTipoDocumento( )->getIniciales( );
			$txtNumeroDocumento = $estudiante->getNumeroDocumento( );
			$txtExpedidoDocumento = $estudiante->getExpedicion( );
			
			$estudianteDocumento = $controlEstudianteDocumento->buscarEstudianteDocumento( $txtIdEstudiante, $txtTipoDocumento, $txtNumeroDocumento );
			
			
			
			$txtIdEstudianteDocumento = $estudianteDocumento->getIdEstudianteDocumento( );
			
			$txtFechaVencimientoDocumento = $estudianteDocumento->getFechaVencimientoEstudianteDocumento( );
			
			$fechaHoy = date("Y-m-d");
			
			if( $txtIdEstudianteDocumento != "" ){
				
				if( $txtTipoDocumento != $estudianteDocumento->getEstudiante( )->getTipoDocumento( )->getIniciales( ) || $txtNumeroDocumento != $estudianteDocumento->getEstudiante( )->getNumeroDocumento( ) ){
					$controlEstudianteDocumento->actualizarEstudianteDocumento( $txtIdEstudiante, $txtIdEstudianteDocumento );
					$controlEstudianteDocumento->crearEstudianteDocumento( $txtIdEstudiante, $txtTipoDocumento, $txtNumeroDocumento, $txtExpedidoDocumento );
				}else{
					if( $txtFechaVencimientoDocumento <= $fechaHoy ){
						$controlEstudianteDocumento->actualizarFechaVencimientoEstudianteDocumento( $txtIdEstudiante, $txtIdEstudianteDocumento );
					}
				}
			}else{
				$controlEstudianteDocumento->crearEstudianteDocumento( $txtIdEstudiante, $txtTipoDocumento, $txtNumeroDocumento, $txtExpedidoDocumento );	
			}
			
			echo "Cambios guardados correctamente";
		}
		return true;
	}

	/**
	 * Actualizar Situacion Carrera Estudiante
 	 * @param int txtIdDetalleActa
	 * @access public
	 * @return boolean
	 */
	public function actualizarSituacionCarreraEstudiante( $txtCodigoEstudiante ){
		$estudiante = new Estudiante( $this->persistencia );
		$estudiante->actualizarSituacionCarreraEstudiante( $txtCodigoEstudiante );
		return $estudiante;
		 
	}
        /**
	 * consulta codigo y nombre Estudiante
 	 * @param int idcarrera,numerodocumento
	 * @access public
	 * @return boolean
	 */
	public function estudianteCarrera( $idCarrera , $numeroDocumento ){
		$estudiante = new Estudiante( $this->persistencia );
		$estudiante->estudianteCarrera( $idCarrera , $numeroDocumento );
                return $estudiante;
		 
	}	
	
	
   }
?>