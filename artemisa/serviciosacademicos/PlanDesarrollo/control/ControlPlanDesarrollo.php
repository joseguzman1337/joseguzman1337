<?php
    /**
	 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
	 * @copyright Dirección de Tecnología Universidad el Bosque
	 * @package control
	 */
	
	include '../entidades/PlanDesarrollo.php';
	
	class ControlPlanDesarrollo{
		
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		
		/**
		 * Constructor
		 * @param $persistencia Singleton
		 */
		public function ControlPlanDesarrollo( $persistencia ){
			$this->persistencia = $persistencia;
		}
		
		/**
		 * Busca un Plan Desarrollo por Facultad
		 * @param String $txtCodigoFacultad
		 * @access public
		 * @return PlanDesarrollo
		 */
		public function buscarPlanDesarrollo( $txtCodigoFacultad ) {
			$planDesarrollo = new PlanDesarrollo( $this->persistencia );
			$planDesarrollo->buscarPlanDesarrolloFacultad( $txtCodigoFacultad );
			return $planDesarrollo;
		}
		
		/**
		 * Busca un Plan Desarrollo por Carrera
		 * @param String $txtCodigoCarrera
		 * @access public
		 * @return PlanDesarrollo
		 */
		public function buscarPlanDesarrolloCarrera( $txtCodigoCarrera ) {
			$planDesarrollo = new PlanDesarrollo( $this->persistencia );
			$planDesarrollo->buscarPlanDesarrolloCarrera( $txtCodigoCarrera );
			return $planDesarrollo;
		}
		
		
		public function buscarFacultadesPlanDesarrollo( $txtCodigoFacultad ){
			$planDesarrollo = new PlanDesarrollo( $this->persistencia );
			return $planDesarrollo->verFacultadesPlanDesarrollo( $txtCodigoFacultad );
			
		}
		
		public function verPlanesDesarrollo( $codigoFacultad ){
			$planDesarrollo = new PlanDesarrollo( $this->persistencia );
			return $planDesarrollo->verPlanDesarrolloFacultad( $codigoFacultad );
			
		}	
		
		/*
		* Ivan quintero <quinteroivan@unbosque.edu.co>
		* se crear la siguinete funcion para la opcion de reportes de planeacion
		*/
		
		public function ConsultarPalnesDesarrollo() {
			$planDesarrollo = new PlanDesarrollo( $this->persistencia );
			return $planDesarrollo->ConsultarPlanesDesarrollo( );
			//return $planDesarrollo;
		}
	}
?>