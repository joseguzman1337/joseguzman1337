<?php
    /**
	 * @author Andres Ariza <arizaandres@unbosque.edu.do>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @package control
	 * @since November 10, 2016
	*/
	
	
	require_once('../entidades/Indicador.php'); 
	require_once('../entidades/EscalaValor.php'); 
	include_once ('../../../kint/Kint.class.php');
	class ControlIndicador{
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
		public function ControlIndicador( $persistencia ){ 
			$this->persistencia = $persistencia;
		} 
		
		/**
		 * Consulta los Indicadores
		 * @access public
		 * @return Array<indicador>
		 */
		public function consultarIndicador( $proyectoConsulta=0, $meta=0 ){
			$indicador = new Indicador( $this->persistencia );
			return $indicador->consultarIndicador( $proyectoConsulta, $meta);
		}
		
		/**
		 * Consulta los Indicadores
		 * @access public
		 * @return Array<indicador>
		 */
		public function consultarDetallesIndicador( $indicadorPlanDesarrolloId ){
			$indicador = new Indicador( $this->persistencia );
			return $indicador->consultarDetallesIndicador( $indicadorPlanDesarrolloId );
		}
		
		/**
		 * Registrar Indicador del Plan de Desarrollo
		 * @param string $txtIdIndicador
		 * @param string $txtNombreMeta
		 * @param Usuario $idPersona
		 * @return booelan
		 */
		public function crearIndicadorPlanDesarrollo( $txtIdTipoIndicador , $txtIdProyecto, $txtNombreIndicador , $idPersona ) {
			$indicador = new Indicador( $this->persistencia );
			
			$tipoIndicador = new TipoIndicador( null );
			$tipoIndicador->setIdTipoIndicador( $txtIdTipoIndicador );
			
			$indicador->setTipoIndicador( $tipoIndicador );
			
			$proyecto = new Proyecto( null );
			$proyecto->setProyectoPlanDesarrolloId( $txtIdProyecto );
			
			$indicador->setProyecto( $proyecto );
			
			$indicador->setNombreIndicador( $txtNombreIndicador );
			
			return $indicador->crearIndicador( $idPersona );
			
		}
		
		
		/**
		 * Actualizar Indicador
	 	 * @param int $txtIdTipoIndicador, string $txtActualizaIndicador, int $idPersona, int $txtIdIndicador
		 * @access public
		 * @return boolean
		 */
	
		public function actualizarIndicador( $txtIdTipoIndicador, $txtActualizaIndicador, $idPersona, $txtIdIndicador  ){
			$indicador = new Indicador( $this->persistencia );
			$indicador->actualizarIndicador( $txtIdTipoIndicador, $txtActualizaIndicador, $idPersona, $txtIdIndicador );
			return $indicador;
		}
		
		public function verIndicadorProyecto( $idProyecto , $nombreIndicador){
			$indicador = new Indicador( $this->persistencia );
			return $indicador->indicadorProyecto( $idProyecto , $nombreIndicador );
		}
		
	/*	public function verIndicador( $indicador , $proyecto ){
			$indicador = new Indicador( $this->persistencia );
			return $indicador->verIndicadorId( $indicador , $proyecto );
		}*/
		
		public function verIndicadorMeta ( $idProyecto ,$periodo = null ) {
			$indicador = new Indicador( $this->persistencia );
			return 	$indicador-> verIndicadorMetaProyecto ( $idProyecto, $periodo );
			
		}
	}
?>