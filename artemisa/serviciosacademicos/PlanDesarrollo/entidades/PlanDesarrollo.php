<?php
    /**
	 * @author Carlos Alberto Suárez Garrido <suarezcarlos@unbosque.edu.co>
	 * @copyright Dirección de Tecnología Universidad el Bosque
	 * @package entidades
	 */

	class PlanDesarrollo{
		
		/**
		 * @tyepe int
		 * @access private
		 */
		private $idPlanDesarrollo;
		
		/**
		 * @type TipoPlanDesarrollo
		 * @access private
		 */
		private $tipoPlanDesarrollo;
		
		/**
		 * @type String
		 * @access private
		 */
		public $nombrePlanDesarrollo;
		
		/**
		 * @type int
		 * @access private
		 */
		private $consecutivoPadrePD;
		
		/**
		 * @type Facultad
		 * @access private
		 */
		private $facultad;
		private $carrera;
		
		/**
		 * @type String
		 * @access private
		 */
		private $justificacionPlanDesarrollo;
		
		/**
		 * @type date
		 * @access private
		 */
		private $fechaCreacionPD;
		
		/**
		 * @type date
		 * @access private
		 */
		private $fechaModificacionPD;
		
		/**
		 * @type Usuario
		 * @access private
		 */
		private $usuario;
		
		/**
		 * @type String
		 * @access private
		 */
		private $accionPlanDesarrollo;
		
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		/**
		 * Constructor
		 * @param $persistencia Singleton
		 */		
			

		
		
		 public function PlanDesarrollo( $persistencia ){
		 	$this->persistencia = $persistencia;
		 }
		 
		 /**
		  * Modifica el id del Plan de Desarrollo
		  * @param int $idPlanDesarrollo
		  * @access public 
		  */
		 public function setIdPlanDesarrollo( $idPlanDesarrollo ){
		 	$this->idPlanDesarrollo = $idPlanDesarrollo;
		 }
		 
		 /**
		  * Retorna el id del Plan de Desarrollo
		  * @access public
		  * @return int
		  */
		 public function getIdPlanDesarrollo( ){
		 	return $this->idPlanDesarrollo;
		 }
		 
		 /**
		  * Modifica el tipo de Plan de Desarrollo
		  * @param $tipoPlanDesarrollo TipoPlanDesarrollo
		  * @access public
		  */
		 public function setTipoPlanDesarrollo( $tipoPlanDesarrollo ){
		 	$this->tipoPlanDesarrollo = $tipoPlanDesarrollo;
		 }
		 
		 /**
		  * Retorna el tipo de Plan de Desarrollo
		  * @access public
		  * @return TipoPlanDesarrollo
		  */
		 public function getTipoPlanDesarrollo( ){
		 	return $this->tipoPlanDesarrollo;
		 }
		 
		 /**
		  * Modifica el nombre del Plan de Desarrollo
		  * @param String $nombrePlanDesarrollo
		  * @access public
		  */
		 public function setNombrePlanDesarrollo( $nombrePlanDesarrollo ){
		 	$this->nombrePlanDesarrollo = $nombrePlanDesarrollo;
		 }
		 
		 /**
		  * Retorna el nombre del Plan de Desarrollo
		  * @access public
		  * @return String
		  */
		 public function getNombrePlanDesarrollo( ){
		 	return $this->nombrePlanDesarrollo;
		 }
		 
		 /**
		  * Modifica el consecutivo padre del Plan de Desarrollo
		  * @param int $consecutivoPadrePD
		  * @access public
		  */
		 public function setConsecutivoPadrePD( $consecutivoPadrePD ){
		 	$this->consecutivoPadrePD = $consecutivoPadrePD;
		 }
		 
		 /**
		  * Retorna el consecutivo padre del Plan de Desarrollo
		  * @access public
		  * @return int
		  */
		 public function getConsecutivoPadrePD( ){
		 	return $this->consecutivoPadrePD;
		 }
		 
		 /**
		  * Modifica la facultad responsable del plan de desarrollo
		  * @param Facultad $facultad
		  * @access public
		  */
		 public function setFacultad( $facultad ){
		 	$this->facultad = $facultad;
		 }
		 
		 /**
		  * Retorna la facultad responsable del plan de desarrollo
		  * @access public
		  * @return Facultad
		  */
		 public function getFacultad( ){
		 	return $this->facultad;
		 }

		  public function setCarrera( $carrera ){
		 	$this->carrera = $carrera;
		 }
		 
		 public function getCarrera( ){
		 	return $this->carrera;
		 }
		 
		 
		 /**
		  * Modifica la justificación del plan de desarrollo
		  * @param String $justificacionPlanDesarrollo
		  * @access public
		  */
		 public function setJustificacionPlanDesarrollo( $justificacionPlanDesarrollo ){
		 	$this->justificacionPlanDesarrollo = $justificacionPlanDesarrollo;
		 }
		 
		 /**
		  * Retorna la justificación del plan de desarrollo
		  * @access public
		  * @return String
		  */
		 public function getJustificacionPlanDesarrollo( ){
		 	return $this->justificacionPlanDesarrollo;
		 }
		 
		 /**
		  * Modifica la fecha de creacion del plan de desarrollo
		  * @param date $fechaCreacionPD
		  * @access public
		  */
		 public function setFechaCreacionPD( $fechaCreacionPD ){
		 	$this->fechaCreacionPD = $fechaCreacionPD;
		 }
		 
		 /**
		  * Retorna la fecha de creacion del plan de desarrollo
		  * @access public
		  * @return date
		  */
		 public function getFechaCreacionPD( ){
		 	return $this->fechaCreacionPD;
		 }
		 
		 /**
		  * Modifica la fecha de actualización del plan de desarrollo
		  * @param date $fechaModificacionPD
		  * @access public
		  */
		 public function setFechaModificacionPD( $fechaModificacionPD ){
		 	$this->fechaModificacionPD = $fechaModificacionPD;
		 }
		 
		 /**
		  * Retorna la fecha de actualizacion del plan de desarrollo
		  * @access public
		  * @return date
		  */
		 public function getFechaModificacionPD( ){
		 	return $this->fechaModificacionPD;
		 }
		 
		 /**
		  * Modifica el usuario de creacion o modificacion del plan de desarrollo
		  * @param Usuario $usuario
		  * @access public
		  */
		 public function setUsuario( $usuario ){
		 	$this->usuario = $usuario;
		 }
		 
		 /**
		  * Retorna el usuario de creacion o modificacion del plan de desarrollo
		  * @access public
		  * @return Usuario
		  */
		 public function getUsuario( ){
		 	return $this->usuario;
		 }
		 
		 /**
		  * Modifica la accion del plan de desarrollo
		  * @param String $accionPlanDesarrollo
		  * @access public
		  */
		 public function setAccionPlanDesarrollo( $accionPlanDesarrollo ){
		 	$this->accionPlanDesarrollo = $accionPlanDesarrollo;
		 }
		 
		
		public $PlanDesarrolloId;
		
		public $NombrePlanDesarrollo;
		
		
		 /**
		  * Retorna la accion del plan de desarrollo
		  * @access public
		  * @return String
		  */
		 public function getAccionPlanDesarrollo( ){
		 	return $this->accionPlanDesarrollo;
		 }

		 /**
		 * Buscar Plan Desarrollo por CodigoFacultad
		 * @param $txtCodigoFacultad
		 * @access public
		 */
		
		public function buscarPlanDesarrolloFacultad( $txtCodigoFacultad ){
				
			$sql = "SELECT P.PlanDesarrolloId, P.NombrePlanDesarrollo
					FROM PlanDesarrollo P
					WHERE P.CodigoFacultad = ?
					AND P.EstadoPlanDesarrollo = 100";
					
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $txtCodigoFacultad , false );
			//echo $this->persistencia->getSQLListo( );
			$this->persistencia->ejecutarConsulta( );
			if( $this->persistencia->getNext( ) ){
				$this->setIdPlanDesarrollo( $this->persistencia->getParametro( "PlanDesarrolloId" ) );
				$this->setNombrePlanDesarrollo( $this->persistencia->getParametro( "NombrePlanDesarrollo" ) );
			}
			
		}
		
		/**
		 * Buscar Plan Desarrollo por CodigoCarrera
		 * @param $txtCodigoCarrera
		 * @access public
		 */
		public function buscarPlanDesarrolloCarrera( $txtCodigoCarrera ){
				
			$sql = "SELECT P.PlanDesarrolloId, P.NombrePlanDesarrollo
					FROM PlanDesarrollo P
					WHERE P.CodigoCarrera = ?
					AND P.EstadoPlanDesarrollo = 100";
					
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $txtCodigoCarrera , false );
			//echo $this->persistencia->getSQLListo( );
			$this->persistencia->ejecutarConsulta( );
			if( $this->persistencia->getNext( ) ){
				$this->setIdPlanDesarrollo( $this->persistencia->getParametro( "PlanDesarrolloId" ) );
				$this->setNombrePlanDesarrollo( $this->persistencia->getParametro( "NombrePlanDesarrollo" ) );
			}
			
		}
		
		/*Modified DIego Rivera <riveradiego@unbosque.edu.co>
		 *Se añade parametro $txtCodigoFacultad con el fin de filtrar carreras dependiendo el codigo de la facultad
		 *Since April 24 ,2017
		 * */
		public function verFacultadesPlanDesarrollo( $txtCodigoFacultad ) {
			$facultades=array( );
			$sql="
			SELECT
				facultad.CodigoFacultad,
				facultad.nombrefacultad
			FROM
				PlanDesarrollo pd
			INNER JOIN facultad ON facultad.codigofacultad = pd.CodigoFacultad
			WHERE  pd.CodigoFacultad= ? 
			GROUP BY
				pd.CodigoFacultad
			order by facultad.nombrefacultad 	
			";
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $txtCodigoFacultad , true );
			$this->persistencia->ejecutarConsulta(  );
			
			while( $this->persistencia->getNext( ) ){
					
				$planDesarrollo = new PlanDesarrollo($this->persistencia);
				$facultad= new Facultad($this->persistencia);
				$facultad->setCodigoFacultad( $this->persistencia->getParametro( "CodigoFacultad" ));
				$facultad->setNombreFacultad( $this->persistencia->getParametro( "nombrefacultad" ));		
				
				$facultades[]=$facultad;
							
			}
			
			return $facultades;
			
		}
		
		public function verPlanDesarrolloFacultad( $codigoFacultad ){
			$plan = array( );
			$sql ="
			SELECT
				pd.NombrePlanDesarrollo,
				pd.CodigoCarrera
			FROM
				PlanDesarrollo pd
			WHERE
				pd.CodigoFacultad = ?
	
			order by pd.NombrePlanDesarrollo
			";
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $codigoFacultad , true );
			$this->persistencia->ejecutarConsulta(  );
			
			while( $this->persistencia->getNext( ) ){
					
				$planDesarrollo = new PlanDesarrollo($this->persistencia);	
				$planDesarrollo->setNombrePlanDesarrollo( $this->persistencia->getParametro( "NombrePlanDesarrollo" ));	
				$planDesarrollo->setCarrera( $this->persistencia->getparametro("CodigoCarrera"));
				
				$plan[] = $planDesarrollo;
			
			}
		
			return $plan;
		}
		
		
		
		public function ConsultarPlanesDesarrollo(){
			$planes = array( );
			$sql = "SELECT P.PlanDesarrolloId, P.NombrePlanDesarrollo FROM PlanDesarrollo P";

			$this->persistencia->crearSentenciaSQL( $sql );
			//echo $this->persistencia->getSQLListo( );
			$this->persistencia->ejecutarConsulta( );
			$c=0;
			while( $this->persistencia->getNext( ) ){
				$plan = new PlanDesarrollo( null );
				$plan->PlanDesarrolloId = $this->persistencia->getParametro( "PlanDesarrolloId" );
				$plan->NombrePlanDesarrollo = $this->persistencia->getParametro( "NombrePlanDesarrollo" );

				$planes[$c] = $plan;
				$c++;
			}
			$this->persistencia->freeResult( );	 
		
			return $planes;
		}
		
	}
?>