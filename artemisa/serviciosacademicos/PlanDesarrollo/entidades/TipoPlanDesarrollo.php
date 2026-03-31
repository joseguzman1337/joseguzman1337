<?php
    /**
	 * @author Carlos Alberto Suárez Garrido <suarezcarlos@unbosque.edu.co>
	 * @copyright Dirección de Tecnología Universidad el Bosque
	 * @package entidades
	 */
	
	class TipoPlanDesarrollo{
		
		/**
		 * @type int
		 * @access private
		 */
		private $idTipoPlanDesarrollo;
		
		/**
		 * @type String
		 * @access private
		 */
		private $nombreTipoPlanDesarrollo;
		
		/**
		 * @type int
		 * @access private
		 */
		private $estadoTipoPlanDesarrollo;
		
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		/**
		 * Constructor
		 * @param SIngleton $persistencia
		 */
		public function TipoPlanDesarrollo( $persistencia ){
			$this->persistencia = $persistencia;
		}
		
		/**
		 * Modifica el id del tipo de plan de desarrollo
		 * @param int $idTipoPlanDesarrollo
		 * @access public
		 */
		public function setIdTipoPlanDesarrollo( $idTipoPlanDesarrollo ){
			$this->idTipoPlanDesarrollo = $idTipoPlanDesarrollo;
		}
		
		/**
		 * Retorna el id del tipo de plan de desarrollo
		 * @return int
		 */
		public function getIdTipoPlanDesarrollo( ){
			return $this->idTipoPlanDesarrollo;
		}
		
		/**
		 * Modifica el nombre del tipo de plan de desarrollo
		 * @param String $nombreTipoPlanDesarrollo
		 * @access public
		 */
		public function setNombreTipoPlanDesarrollo( $nombreTipoPlanDesarrollo ){
			$this->nombreTipoPlanDesarrollo = $nombreTipoPlanDesarrollo;
		}
		
		/**
		 * Retorna el nombre del tipo de plan de desarrollo
		 * @return String
		 */
		public function getNombreTipoPlanDesarrollo( ){
			return $this->nombreTipoPlanDesarrollo;
		}
		
		/**
		 * Modifica el estado del plan de desarrollo
		 * @param int $estadoTipoPlanDesarrollo
		 * @access public 
		 */
		public function setEstadoTipoPlanDesarrollo( $estadoTipoPlanDesarrollo ){
			$this->estadoTipoPlanDesarrollo = $estadoTipoPlanDesarrollo;
		}
		
		/**
		 * Retorna el estado del plan de desarrollo
		 * @return int
		 */
		public function getEstadoTipoPlanDesarrollo( ){
			return $this->estadoTipoPlanDesarrollo;
		}
		
	}
?>