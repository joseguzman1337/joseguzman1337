<?php
    /**
	 * @author Andres Ariza <arizaandres@unbosque.edu.do>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @package control
	 * @since November 15, 2016
	*/
	
	
	require_once('../entidades/Meta.php');
	require_once('../entidades/MetaSecundaria.php');
	include('../../../kint/Kint.class.php');
	
	class ControlMeta{
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
		public function ControlMeta( $persistencia ){ 
			$this->persistencia = $persistencia;
		} 
		
		/**
		 * Consulta los Indicadores
		 * @access public
		 * @return Array<indicador>
		 */
		public function consultarMeta( $variables=null ){
			$meta = new Meta( $this->persistencia ); 
			return $meta->consultarMeta( $variables );
		}
		
			/**
		 * Consulta la meta dependien el id de la meta
		 * @access public
		 * @return Array<indicador>
		 */
		
		public function consultarMetaId( $variables=null ){
			$meta = new Meta( $this->persistencia ); 
			return $meta->consultarMetaSeleccionada( $variables );
		}
		
		/**
		 * Registrar Meta Principal al Indicador del Plan de Desarrollo
		 * @param string $txtIdIndicador
		 * @param string $txtNombreMeta
		 * @param Usuario $idPersona
		 * @return booelan
		 */
		public function crearMetaPrincipal( $txtIdIndicador , $txtNombreMeta , $txtAlcanceMeta, $idPersona , $txtIdProyecto) {
			$meta = new Meta( $this->persistencia );
			
			$indicador = new Indicador( null );
			$indicador->setIndicadorPlanDesarrolloId( $txtIdIndicador );
			
			$meta->setIndicador( $indicador );
			
			$meta->setNombreMetaPlanDesarrollo( $txtNombreMeta );
			$meta->setAlcanceMeta( $txtAlcanceMeta );
		    $meta->setProyectoPlanDesarrolloId( $txtIdProyecto );
			return $meta->crearMeta( $idPersona );
			
		}
		
		
		/**
		 * Registrar Metas Secundarias a la Meta Principal del Plan de Desarrollo
		 * @param string $txtIdIndicador
		 * @param string $txtNombreMeta
		 * @param Usuario $idPersona
		 * @return booelan
		 */
		public function crearMetaSecundarias( $txtIdMetaPrincipal , $txtNombreMetaSecundaria , $txtFechaInicioMetaSecundaria, $txtFechaFinMetaSecundaria, $txtValorMetaSecundaria, $txtAccionMetaSecundaria, $txtResponsableMetaSecundaria, $idPersona , $emailResponsableMetaSecundaria ) {
			$metaSecundaria = new MetaSecundaria( $this->persistencia );
			if( $metaSecundaria->cuentaMetaSecundarias($txtIdMetaPrincipal) < 15 ){
				$meta = new Meta( null );
				$meta->setMetaIndicadorPlanDesarrolloId( $txtIdMetaPrincipal );
				
				$metaSecundaria->setMeta( $meta );
				
				$metaSecundaria->setNombreMetaSecundaria( $txtNombreMetaSecundaria );
				$metaSecundaria->setFechaInicioMetaSecundaria( $txtFechaInicioMetaSecundaria );
				$metaSecundaria->setFechaFinMetaSecundaria( $txtFechaFinMetaSecundaria );
				$metaSecundaria->setValorMetaSecundaria( $txtValorMetaSecundaria );
				$metaSecundaria->setActividadMetaSecundaria( $txtAccionMetaSecundaria );
				$metaSecundaria->setResponsableMetaSecundaria( $txtResponsableMetaSecundaria );
				$metaSecundaria->setEmailResponsableMetaSecundaria( $emailResponsableMetaSecundaria );
				
				return $metaSecundaria->crearMetaSecundaria( $idPersona );
			}else{
				echo 1;
			}
			
		}
		
		/**
		 * Registrar Metas Secundarias a la Meta Principal del Plan de Desarrollo
		 * @param int  $txtIdMetaSecundaria 
		 * @return metaSecundaria
		 */
		public function buscarMetaSecundaria( $txtIdMetaSecundaria ) {
			$metaSecundaria = new MetaSecundaria( $this->persistencia );
			return $metaSecundaria->consultarMetaSecundaria( 0, $txtIdMetaSecundaria ); 
		}
		
		/**
		 * Busca Meta Plan Desarrollo por Id
		 * @param int $txtIdMetaPrincipal
		 * @access public
		 * @return void
		 */
		public function buscarMetaPlanDesarrollo( $txtIdMetaPrincipal ) {
			$meta = new Meta( $this->persistencia );
			$meta->buscarMetaPlanDesarrollo( $txtIdMetaPrincipal );
			return $meta;
		}
		
		
		/**
		 * Cuenta Número de Metas Secundarias
		 * @param int $txtIdMetaPrincipal
		 * @access public
		 * @return void
		 */
		public function cuentaMetaSecundarias( $txtIdMetaPrincipal ) {
			$metaSecundaria = new MetaSecundaria( $this->persistencia );
			return $metaSecundaria->cuentaMetaSecundarias( $txtIdMetaPrincipal );
		}
		
		/**
		 * Actualizar Meta Principal
	 	 * @param string $txtMetaActualizaPrincipal, int $txtValorMetaActualizaPrincipal, date $txtVigenciaActualizaMetaPrincipal, int $idPersona, int $txtIdMetaPrincipal
		 * @access public
		 * @return boolean
		 */
		public function actualizarMeta( $txtMetaActualizaPrincipal, $txtValorMetaActualizaPrincipal, $txtVigenciaActualizaMetaPrincipal, $idPersona, $txtIdMetaPrincipal ){
			$meta = new Meta( $this->persistencia );
			$meta->actualizarMeta( $txtMetaActualizaPrincipal, $txtValorMetaActualizaPrincipal, $txtVigenciaActualizaMetaPrincipal, $idPersona, $txtIdMetaPrincipal );
			return $meta;
		}
		
		/**
		 * Eliminar Meta Secundaria
	 	 * @param string $txtMetaActualizaPrincipal, int $txtValorMetaActualizaPrincipal, date $txtVigenciaActualizaMetaPrincipal, int $idPersona, int $txtIdMetaPrincipal
		 * @access public
		 * @return boolean
		 */
		public function eliminarMetaSecundaria( $idPersona, $txtIdMetaSecundaria  ){
			$metaSecundaria = new MetaSecundaria( $this->persistencia );
			$metaSecundaria->eliminaMetaSecundaria( $idPersona, $txtIdMetaSecundaria );
			return $metaSecundaria;
		}
		
		/**
		 * Actualizar Meta Secundaria
	 	 * @param object $varialbes
		 * @access public
		 * @return boolean
		 */
		public function actualizarMetaSecundaria( $variables ){
			//ddd($variables);
			if( !empty($variables->txtIdMetaSecundaria) && !empty($variables->txtActualizaMeta) 
			 && !empty($variables->txtFechaActualizaInicioMeta) && !empty($variables->txtFechaActualizaFinalMeta) 
			 && !empty($variables->txtActualizaValorMeta) && !empty($variables->txtActualizaAccionMeta) && !empty($variables->txtActualizaResponsableMeta) ){
				$metaSecundaria = new MetaSecundaria( $this->persistencia );
				$metaSecundaria->actualizarMetaSecundaria( $variables );
				return $metaSecundaria;/**/
			}else{
				echo "error";
				return false;
			}
		}
		
		/**
		 * Busca Meta Secundaria Plan Desarrollo por Id
		 * @param int $txtIdMetaSecundaria
		 * @access public
		 * @return void
		 */
		public function buscarMetaSecundariaId( $txtIdMetaSecundaria ) {
			$metaSecundaria = new MetaSecundaria( $this->persistencia );
			$metaSecundaria->buscarMetaSecundariaId( $txtIdMetaSecundaria );
			return $metaSecundaria;
		}
		
		/**
		 * Actualizar Avance Responsable, Supervisor
	 	 * @param string $txtMetaActualizaPrincipal, int $txtValorMetaActualizaPrincipal, date $txtVigenciaActualizaMetaPrincipal, int $idPersona, int $txtIdMetaPrincipal
		 * @access public
		 * @return boolean
		 */
		public function actualizaAvanceMetaSecundaria( $txtAvancePropuesto, $txtAvanceSupervisor, $idPersona, $txtIdMetaSecundaria  ){
			$metaSecundaria = new MetaSecundaria( $this->persistencia );
			$metaSecundaria->actualizaAvanceMetaSecundaria( $txtAvancePropuesto, $txtAvanceSupervisor, $idPersona, $txtIdMetaSecundaria );
			return $metaSecundaria;
		}
		
		/**
		 * Consulta metas secundarias respecto a la meta principal
		 * @param  int $metaPrincipal
		 * @return array
		 */
		
		public function verSecundarias( $metaPrincipal ){
			$metaSecundaria = new MetaSecundaria( $this->persistencia );
			return $metaSecundaria->consultarSecundarias($metaPrincipal);
		
		}
		
		/**
		 * actualiza el avance de la meta principal
		 * @param  int $avance , $idMeta 
		 * @return boolean
		 */
		public function actualizarAvanceMetaPrincipal ( $avance , $idMeta ){
				$meta = new Meta( $this->persistencia );
				return $meta->actualizarAvanceMeta( $avance, $idMeta );	
		}
		
		/*Modified Diego Rivera<riveradiego@unbosque.edu.co
			 *se añade parametro proyectoPlanDesarrolloId  con el fin que almacene el id de la tabla proyecto plan desarrollo en la meta principal
			 * Since April 10,2017
			 */
			public function crearMetaPrincipalNueva( $txtIdIndicador , $txtNombreMeta , $txtAlcanceMeta, $idPersona , $proyectoPlanDesarrolloId ) {
			$meta = new Meta( $this->persistencia );
			$indicador = new Indicador( null );
			$indicador->setIndicadorPlanDesarrolloId( $txtIdIndicador );
			$meta->setIndicador( $indicador );
			$meta->setNombreMetaPlanDesarrollo( $txtNombreMeta );
			$meta->setAlcanceMeta( $txtAlcanceMeta );
			$meta->setProyectoPlanDesarrolloId( $proyectoPlanDesarrolloId );
	
			return $meta->crearMetaPrincipal( $idPersona );
			
		}
		
		public function metaProyecto ( $codigoFacultad , $codigoCarrera , $idProyecto , $idIndicador , $idLinea , $idPrograma ) {
			$meta = new Meta( $this->persistencia );
			return $meta->verMetas( $codigoFacultad , $codigoCarrera , $idProyecto , $idIndicador , $idLinea , $idPrograma );
		}
	}
?>