<?php
    /**
	 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
	 * @copyright Dirección de Tecnología Universidad el Bosque
	 * @package entidades
	 */
	
	include '../entidades/PlanProgramaLinea.php';
	
	class ControlPlanProgramaLinea{
		
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		/**
		 * Constructor
		 * @param Singleton $persistencia
		 */
		public function ControlPlanProgramaLinea( $persistencia ){
			$this->persistencia = $persistencia;
		}
		
		/**
		 * Registrar Plan Programa Linea 
		 * @param int $txtIdPlanDesarrollo
		 * @param int $txtIdLineaEstrategica
		 * @param int $txtIdPrograma
		 * @param Usuario $idPersona
		 * @return booelan
		 */
		public function crear( $txtIdPlanDesarrollo, $txtIdLineaEstrategica , $txtIdPrograma, $idPersona ) {
			$planProgramaLinea = new PlanProgramaLinea( $this->persistencia );
			
			$planDesarrollo = new PlanDesarrollo( null );
			$planDesarrollo->setIdPlanDesarrollo($txtIdPlanDesarrollo);
			
			$lineaEstrategica = new LineaEstrategica( null );
			$lineaEstrategica->setIdLineaEstrategica($txtIdLineaEstrategica);
			
			$programa = new Programa( null );
			$programa->setIdProgramaPlanDesarrollo( $txtIdPrograma );
			
			$planProgramaLinea->setPlanDesarrollo( $planDesarrollo );
			$planProgramaLinea->setLineaEstrategica( $lineaEstrategica );
			$planProgramaLinea->setPrograma( $programa );
			return $planProgramaLinea->crearPlanProgramaLinea( $idPersona );
		}
		
		/**
		 * Actualizar Linea Estrategica del Plan Desarrollo Programa Linea
	 	 * @param int $txtIdLineaEstrategica, int $idPersona, int $txtIdPrograma, string $txtActualizaResponsablePrograma
		 * @access public
		 * @return boolean
		 */
		public function actualizar( $txtIdLineaEstrategica, $idPersona, $txtIdPrograma ){
			$planProgramaLinea = new PlanProgramaLinea( $this->persistencia );
			$planProgramaLinea->actualizarPlanProgramaLinea( $txtIdLineaEstrategica , $idPersona, $txtIdPrograma );
			return $planProgramaLinea;
		}
		
		
                /*
                * @modified Diego Rivera <riveradiego@unbosque.edu.co>
                * control que carga consulta para ver programas dependiento la linea estrategica
                * @param $idPlandesarrollo
                * @access public
                * @return array
                * @since March  15, 2017*/
		
		public function verProgramasLineas( $idPlandesarrollo , $idLinea ){
			$planProgramaLInea = new PlanProgramaLinea( $this->persistencia );
			return $planProgramaLInea->consultarPlanesLineas( $idPlandesarrollo , $idLinea );
		}
		/*Modified Diego Rivera <riveradiego@unbosque.edu.co>
                 *Se añade parametro $idLina con  el fin de realizar busqueda a traves del id de la linea estrategia
                 *Since May 8 , 2018
                 */
		public function verLinea ( $idFacultad, $codigoperiodo=null , $codigoCarrera = null , $idLinea = null ) {
			$planProgramaLInea = new PlanProgramaLinea( $this->persistencia );
			return $planProgramaLInea->verLineasEstrategica( $idFacultad, $codigoperiodo , $codigoCarrera , $idLinea );
		}

		/*Modified Diego Rivera <riveradiego@unbosque.edu.co>
		*se añade parametro $codigoperiodo
		*Since September 21,2017
		*/
		public function verPrograma ( $idFacultad , $idLinea , $codigoCarrera = null , $codigoperiodo = null ) {
			$planProgramaLInea = new PlanProgramaLinea( $this->persistencia );
			return $planProgramaLInea->verLineasPrograma( $idFacultad , $idLinea , $codigoCarrera , $codigoperiodo );
		}
		
		/*Modified Diego Rivera <riveradiego@unbosque.edu.co>
		*se añade parametro $codigoperiodo
		*Since September 21,2017
		*/
		public function verProyecto ( $idFacultad , $idLinea , $idPrograma , $codigoCarrera = null , $codigoperiodo = null ){
			$planProgramaLInea = new PlanProgramaLinea( $this->persistencia );
			return $planProgramaLInea->verLineasProyecto( $idFacultad , $idLinea , $idPrograma , $codigoCarrera , $codigoperiodo );	
		}
	}
?>