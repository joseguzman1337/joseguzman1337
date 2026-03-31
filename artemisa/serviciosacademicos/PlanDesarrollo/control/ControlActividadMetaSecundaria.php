<?php
    /**
	 * @author Carlos Alberto Suárez Garrido <suarezcarlos@unbosque.edu.co>
	 * @copyright Dirección de Tecnología - Universidad el Bosque
	 * @package entidades
	 */
	
	include '../entidades/ActividadMetaSecundaria.php';
	
	class ControlActividadMetaSecundaria{
		
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		/**
		 * Constructor
		 * @param Singleton $persistencia
		 */
		public function ControlActividadMetaSecundaria( $persistencia ){
			$this->persistencia = $persistencia;
		}
		
		/**
		 * Registrar Actividad Meta Secundaria
		 * @param string $txtIdIndicador
		 * @param string $txtNombreMeta
		 * @param Usuario $idPersona
		 * @return booelan
		 */
		public function crearActividadMetaSecundaria( $txtIdMetaSecundaria, $txtNombreActividad , $txtFechaActividad, $idPersona ){
			$actividadMetaSecundaria = new ActividadMetaSecundaria( $this->persistencia );
			
			$metaSecundaria = new MetaSecundaria( null );
			$metaSecundaria->setMetaSecundariaPlanDesarrolloId( $txtIdMetaSecundaria );
			
			$actividadMetaSecundaria->setMetaSecundaria( $metaSecundaria );
			$actividadMetaSecundaria->setNombreActividadMetaSecundaria( $txtNombreActividad );
			$actividadMetaSecundaria->setFechaActividadMetaSecundaria( $txtFechaActividad );
			
			return $actividadMetaSecundaria->registrarActividad( $idPersona );
			
		}
		
		/**
		 * Existe Actividad Meta Secundaria
		 * @param int $txtIdMetaSecundaria
		 * @access public
		 * @return void
		 */
		public function existeActividadMeta( $txtIdMetaSecundaria ) {
			$actividadMetaSecundaria = new ActividadMetaSecundaria( $this->persistencia );
			return $actividadMetaSecundaria->existeActividad( $txtIdMetaSecundaria );
		}
		
		
		/**
		 * Actualiza Actividad
	 	 * @param int $txtIdMetaSecundaria
		 * @access public
		 * @return boolean
		 */
		public function actualizarActividad( $txtNombreActividad, $txtFechaActividad, $idPersona, $txtIdMetaSecundaria  ){
			$actividadMetaSecundaria = new ActividadMetaSecundaria( $this->persistencia );
			$actividadMetaSecundaria->actualizarActividadMetaSecundaria( $txtNombreActividad, $txtFechaActividad, $idPersona, $txtIdMetaSecundaria );
			return $actividadMetaSecundaria;
		}
		
		/**
		 * Busca Actividad Meta Secundaria Id
		 * @param int $txtIdMetaSecundaria
		 * @access public
		 * @return void
		 */
		public function buscarActividadMetaSecundariaId( $txtIdMetaSecundaria ) {
			$actividadMetaSecundaria = new ActividadMetaSecundaria( $this->persistencia );
			$actividadMetaSecundaria->buscarActividadMetaSecundariaId( $txtIdMetaSecundaria );
			return $actividadMetaSecundaria;
		}
		
		/**
		 * Actualiza Observacion Actividad
	 	 * @param int $txtObservacionSupervisor, $idPersona, $txtIdActividadMetaSecundaria 
		 * @access public
		 * @return boolean
		 */
		public function actualizarObservacionActividad( $txtObservacionSupervisor, $idPersona, $txtIdActividadMetaSecundaria  ){
			$actividadMetaSecundaria = new ActividadMetaSecundaria( $this->persistencia );
			$actividadMetaSecundaria->actualizarObservacionActividadMetaSecundaria( $txtObservacionSupervisor, $idPersona, $txtIdActividadMetaSecundaria );
			return $actividadMetaSecundaria;
		}
		
	}
?>