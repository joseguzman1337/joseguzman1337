<?php
    /**
	 * @author Andres Ariza <arizaandres@unbosque.edu.do>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @package control
	 * @since November 15, 2016
	*/
	
	//include('../../../kint/Kint.class.php');
	class Meta{
		
		 /**
		 * @type int
		 * @access private
		 */
		private $metaIndicadorPlanDesarrolloId;
		
		 /**
		 * @type int
		 * @access private
		 */
		private $indicador;
		
		 /**
		 * @type String
		 * @access private
		 */
		private $nombreMetaPlanDesarrollo;
		
		 /**
		 * @type int
		 * @access private
		 */
		private $alcanceMeta;
		
		 /**
		 * @type datetime
		 * @access private
		 */
		private $vigenciaMeta;
		
		 /**
		 * @type int
		 * @access private
		 */
		private $estadoMeta;
		
		 /**
		 * @type String
		 * @access private
		 */
		private $objetivoMeta;
		
		 /**
		 * @type int
		 * @access private
		 */
		private $avanceMetaPlanDesarrollo;
		
		 /**
		 * @type array
		 * @access private
		 */
		private $metasSecundarias;
		
		
		/**
		 * @type ProgramaProyecto
		 * @access private
		 */
		private $programaProyecto;
		 /**
		 * @type datetime
		 * @access private
		 */
		private $fechaCreacion;
		
		 /**
		 * @type datetime
		 * @access private
		 */
		private $fechaUltimaModificacion;
		
		 /**
		 * @type int
		 * @access private
		 */
		private $usuarioCreacion;
		
		 /**
		 * @type string
		 * @access private
		 */
		private $usuarioModificacion;
		
		/**
		 * modified diegorivera<riveradiego@unbosque.edu.co>
		 * se añade $proyectoPlanDesarrolloId;  se añadio campo en bd 
		 * Since April 05,2017
		 * @type int
		 * @access private
		 * 
		 */
		
		private $proyectoPlanDesarrolloId;
		
		
		private $porcentaje;
		private $porcentajeMeta;
		/**
		 * @type Singleton
		 * @access private
		 */ 
		 
		private $persistencia;
		
		/**
		 * Constructor
		 * @param Singleton $persistencia
		 */
		public function Meta( $persistencia ){ 
			$this->persistencia = $persistencia;
		}
		
		
		/**
		 * Modifica el id de la Meta
		 * @param int $metaIndicadorPlanDesarrolloId
		 * @access public
		 * @return void
		 */
		public function setMetaIndicadorPlanDesarrolloId( $metaIndicadorPlanDesarrolloId){
			$this->metaIndicadorPlanDesarrolloId= $metaIndicadorPlanDesarrolloId;
		}
		
		/**
		 * Retorna el id de la Meta
		 * @access public
		 * @return int
		 */
		public function getMetaIndicadorPlanDesarrolloId( ){
			return $this->metaIndicadorPlanDesarrolloId;
		}
		
		/**
		 * Modifica el indicacorplandesarrollo de la Meta
		 * @param int $indicador
		 * @access public
		 * @return void
		 */
		public function setIndicador( $indicador ){
			$this->indicador = $indicador;
		}
		
		/**
		 * Retorna el indicacorplandesarrollo de la Meta
		 * @access public
		 * @return int
		 */
		public function getIndicador( ){
			return $this->indicador;
		}
		
		/**
		 * Modifica el Nombre de la Meta
		 * @param String $nombreMetaPlanDesarrollo
		 * @access public
		 * @return void
		 */
		public function setNombreMetaPlanDesarrollo( $nombreMetaPlanDesarrollo ){
			$this->nombreMetaPlanDesarrollo = $nombreMetaPlanDesarrollo;
		}
		
		/**
		 * Retorna el nombre de la Meta
		 * @access public
		 * @return String
		 */
		public function getNombreMetaPlanDesarrollo( ){
			return $this->nombreMetaPlanDesarrollo;
		}
		
		/**
		 * Modifica el alcance de la Meta
		 * @param int $alcanceMeta
		 * @access public
		 * @return void
		 */
		public function setAlcanceMeta( $alcanceMeta ){
			$this->alcanceMeta = $alcanceMeta;
		}
		
		/**
		 * Retorna el Alcance de la Meta
		 * @access public
		 * @return int
		 */
		public function getAlcanceMeta( ){
			return $this->alcanceMeta;
		}
		
		/**
		 * Modifica la vigencia de la Meta
		 * @param datetime $vigenciaMeta
		 * @access public
		 * @return void
		 */
		public function setVigenciaMeta( $vigenciaMeta ){
			$this->vigenciaMeta = $vigenciaMeta;
		}
		
		/**
		 * Retorna la vigencia de la Meta
		 * @access public
		 * @return datetime
		 */
		public function getVigenciaMeta( ){
			return $this->vigenciaMeta;
		}
		
		/**
		 * Modifica el estado de la Meta
		 * @param int $estadoMeta
		 * @access public
		 * @return void
		 */
		public function setEstadoMeta( $estadoMeta ){
			$this->estadoMeta = $estadoMeta;
		}
		
		/**
		 * Retorna el estado de la Meta
		 * @access public
		 * @return int
		 */
		public function getEstadoMeta( ){
			return $this->estadoMeta;
		}
		
		/**
		 * Modifica el estado de la Meta
		 * @param String $objetivoMeta
		 * @access public
		 * @return void
		 */
		public function setObjetivoMeta( $objetivoMeta ){
			$this->objetivoMeta = $objetivoMeta;
		}
		
		/**
		 * Retorna el estado de la Meta
		 * @access public
		 * @return String
		 */
		public function getObjetivoMeta( ){
			return $this->objetivoMeta;
		}
		
		/**
		 * Modifica el avance de la Meta
		 * @param int $avanceMetaPlanDesarrollo
		 * @access public
		 * @return void
		 */
		public function setAvanceMetaPlanDesarrollo( $avanceMetaPlanDesarrollo ){
			$this->avanceMetaPlanDesarrollo = $avanceMetaPlanDesarrollo;
		}
		
		/**
		 * Retorna el avance de la Meta
		 * @access public
		 * @return int
		 */
		public function getAvanceMetaPlanDesarrollo( ){
			if(!empty($this->avanceMetaPlanDesarrollo)){
				return $this->avanceMetaPlanDesarrollo;
			}else{
				return 0;
			}
		}
		
		/**
		 * Modifica las Metas secundarias de la Meta
		 * @param array $metasSecundarias
		 * @access public
		 * @return void
		 */
		public function setMetasSecundarias( $metasSecundarias ){
			$this->metasSecundarias = $metasSecundarias;
		}
		
		/**
		 * Retorna las Metas secundarias de la Meta
		 * @access public
		 * @return array
		 */
		public function getMetasSecundarias( ){
			return $this->metasSecundarias;
		}
		
		
		/**
		 * Modifica ProgramaProyecto
		 * @param array $programaProyecto
		 * @access public
		 * @return void
		 */
		public function setProgramaProyecto( $programaProyecto ){
			$this->programaProyecto = $programaProyecto;
		}
		
		/**
		 * Retorna ProgramaProyecto
		 * @access public
		 * @return array
		 */
		public function getProgramaProyecto( ){
			return $this->programaProyecto;
		}
		
		/**
		 * Modifica la fecha de creacion de la Meta
		 * @param datetime fechaCreacion
		 * @access public
		 * @return void
		 */
		public function setFechaCreacion( $fechaCreacion ){
			$this->fechaCreacion = $fechaCreacion;
		}
		
		/**
		 * Retorna la fecha de creacion de la Meta
		 * @access public
		 * @return datetime
		 */
		public function getFechaCreacion( ){
			return $this->fechaCreacion;
		}
		
		/**
		 * Modifica la fecha de modificacion de la Meta
		 * @param datetime fechaUltimaModificacion
		 * @access public
		 * @return void
		 */
		public function setFechaUltimaModificacion( $fechaUltimaModificacion ){
			$this->fechaUltimaModificacion = $fechaUltimaModificacion;
		}
		
		/**
		 * Retorna la fecha de modificacion de la Meta
		 * @access public
		 * @return datetime
		 */
		public function getFechaUltimaModificacion( ){
			return $this->fechaUltimaModificacion;
		}
		
		/**
		 * Modifica el usuario de creacion de la Meta
		 * @param int usuarioCreacion
		 * @access public
		 * @return void
		 */
		public function setUsuarioCreacion( $usuarioCreacion ){
			$this->usuarioCreacion = $usuarioCreacion;
		}
		
		/**
		 * Retorna usuario de creacion de la Meta
		 * @access public
		 * @return int
		 */
		public function getUsuarioCreacion( ){
			return $this->usuarioCreacion;
		}
		
		public function setPorcentaje ( $porcentaje ){
			$this->porcentaje = $porcentaje;
		}
		
		public function getPorcentaje ( ){
			return $this->porcentaje;
		}
		
		public function setPorcentajeMeta ( $porcentajeMeta ){
			$this->porcentajeMeta = $porcentajeMeta;
		}
		
		public function getPorcentajeMeta ( ){
			return $this->porcentajeMeta;
		}
		/**
		 * Modifica el usuario de modificacion de la Meta
		 * @param int usuarioModificacion
		 * @access public
		 * @return void
		 */
		public function setUsuarioModificacion( $usuarioModificacion ){
			$this->usuarioModificacion = $usuarioModificacion;
		}
		
		/**
		 * Retorna usuario de modificacion de la Meta
		 * @access public
		 * @return int
		 */
		public function getUsuarioModificacion( ){
			return $this->usuarioModificacion;
		}
		
		
		public function setProyectoPlanDesarrolloId( $proyectoPlanDesarrolloId ){
		 $this->proyectoPlanDesarrolloId = $proyectoPlanDesarrolloId;
		}
		
		public function getProyectoPlanDesarrolloId( ){
			return $this->proyectoPlanDesarrolloId;
		}
		
		/**
		 * Consultar Indicadores
		 * @access public
		 */
		public function consultarMeta( $variables ){							
			if( isset ( $_SESSION["datoSesion"] ) ){
				$user = $_SESSION["datoSesion"];
				$idPersona = $user[ 0 ];
				$luser = $user[ 1 ];
				$lrol = $user[3]; 
				$txtCodigoFacultad = $user[4];
				$persistencian = new Singleton( );
				$persistencian = $persistencian->unserializar( $user[ 5 ] );
				$persistencian->conectar( );
			}
			
			$metas = array( );
			$temp = array( );
			$inner='';
			$where = array();
			$params = array();
			
			
			if(  !empty($variables->cmbProyectoConsultar) ){
				/*
				* @Ivan quintero <quinteroivan@unbosque.edu.co>
				* Se modifica  a consulta ya que el campo esta relacionado dentra de la misma tabla
				$inner = 'INNER JOIN IndicadorPlanDesarrollo ipd ON (ipd.IndicadorPlanDesarrolloId = mipd.IndicadorPlanDesarrolloId)';
				* END
				*/
				$where[] = 'mipd.ProyectoPlanDesarrolloId = ?';
				$objParam = new stdClass();
				$objParam->value = $variables->cmbProyectoConsultar;
				$objParam->text = false;
				$count = count($where);
				if(empty($count)){
					$count=0;
				}else{
					$count--;
				}
				$params[$count] = $objParam; 
				unset($objParam);
			}
			
		
			
			$where[] = 'mipd.EstadoMeta=100';
			$sql = "SELECT mipd.MetaIndicadorPlanDesarrolloId,
						   mipd.IndicadorPlanDesarrolloId,
						   mipd.NombreMetaPlanDesarrollo,
						   mipd.AlcanceMeta,
						   mipd.VigenciaMeta,
						   mipd.EstadoMeta,
						   mipd.ObjetivoMeta,
						   mipd.FechaCreacion,
						   mipd.FechaUltimaModificacion,
						   mipd.UsuarioCreacion,
						   mipd.UsuarioModificacion,
						   mipd.AvanceMetaPlanDesarrollo
					  FROM MetaIndicadorPlanDesarrollo mipd ";
					  
			if(!empty($inner)){
				$sql .= $inner;
			}
			
			if(!empty($where)){
				$sql .= ' 
				     WHERE '.implode(' AND ',$where);
			}
			
			$this->persistencia->crearSentenciaSQL( $sql );
			
			if(!empty($params)){
				foreach($params as $k=>$v){
					$this->persistencia->setParametro( $k, $v->value, $v->text );
				}
			}
			
			 
			$this->persistencia->ejecutarConsulta(  );
			while( $this->persistencia->getNext( ) ){
				$meta = new Meta( $this->persistencia );
				$meta->setMetaIndicadorPlanDesarrolloId( $this->persistencia->getParametro( "MetaIndicadorPlanDesarrolloId" ) );
				
				$indicador = new Indicador( $persistencian );
				$indicador = $indicador->consultarDetallesIndicador( $this->persistencia->getParametro( "IndicadorPlanDesarrolloId" ) );
				$indicador = $indicador[0];
				$meta->setIndicador( $indicador ); 
				 
				$meta->setNombreMetaPlanDesarrollo( $this->persistencia->getParametro( "NombreMetaPlanDesarrollo" ) ); 
				$meta->setAlcanceMeta( $this->persistencia->getParametro( "AlcanceMeta" ) ); 
				$meta->setVigenciaMeta( $this->persistencia->getParametro( "VigenciaMeta" ) ); 
				$meta->setEstadoMeta( $this->persistencia->getParametro( "EstadoMeta" ) ); 
				$meta->setObjetivoMeta( $this->persistencia->getParametro( "ObjetivoMeta" ) ); 
				
				$meta->setFechaCreacion( $this->persistencia->getParametro( "FechaCreacion" ) );
				$meta->setFechaUltimaModificacion( $this->persistencia->getParametro( "FechaUltimaModificacion" ) );
				$meta->setUsuarioCreacion( $this->persistencia->getParametro( "UsuarioCreacion" ) );
				$meta->setUsuarioModificacion( $this->persistencia->getParametro( "UsuarioModificacion" ) );
				$meta->setAvanceMetaPlanDesarrollo( $this->persistencia->getParametro( "AvanceMetaPlanDesarrollo" ));
				
				
				$metas[] = $meta;
			}
			$this->persistencia->freeResult( );/**/
			foreach($metas as $meta){
				$metasecundaria = null;
				$metasecundaria = new MetaSecundaria($this->persistencia);
				
				$meta->setMetasSecundarias($metasecundaria->consultarMetaSecundaria( $meta->getMetaIndicadorPlanDesarrolloId() ));
				$temp[] = $meta;
			}
			
			$metas = $temp;
			unset($temp);
			
			return 	$metas;/**/
		}
		
		
		
		/*Modified Diego Rivera <riveradiego@unbosque.edu.co>
		 * se crea nueva funcon debido a incomvenientes al cargar las lista desplegables
		 * Since March 29,2017
		 * 
		 *  */
		 public function consultarMetaSeleccionada( $variables ){							
			if( isset ( $_SESSION["datoSesion"] ) ){
				$user = $_SESSION["datoSesion"];
				$idPersona = $user[ 0 ];
				$luser = $user[ 1 ];
				$lrol = $user[3]; 
				$txtCodigoFacultad = $user[4];
				$persistencian = new Singleton( );
				$persistencian = $persistencian->unserializar( $user[ 5 ] );
				$persistencian->conectar( );
			}
			
			$metas = array( );
			$temp = array( );
			$inner='';
			$where = array();
			$params = array();
			
			if(  !empty($variables->cmbProyectoConsultar) ){
				
				$where[] = 'mipd.ProyectoPlanDesarrolloId = ?';
				$objParam = new stdClass();
				$objParam->value = $variables->cmbProyectoConsultar;
				$objParam->text = false;
				$count = count($where);
				if(empty($count)){
					$count=0;
				}else{
					$count--;
				}
				$params[$count] = $objParam; 
				unset($objParam);
			}
			
			 	if( (!empty($variables->cmbMetaConsultar) )and ($variables->cmbMetaConsultar<>-1))
			{
				$where[]= 'mipd.MetaIndicadorPlanDesarrolloId = ?';
				$objParam = new stdClass();
				$objParam->value = $variables->cmbMetaConsultar;
				$objParam->text = false;
				$count = count($where);
				if(empty($count)){
					$count=0;
				}else{
					$count--;
				}
				$params[$count] = $objParam; 
				unset($objParam);
			}
			
			$where[] = 'mipd.EstadoMeta=100';
			$sql = "SELECT mipd.MetaIndicadorPlanDesarrolloId,
						   mipd.IndicadorPlanDesarrolloId,
						   mipd.NombreMetaPlanDesarrollo,
						   mipd.AlcanceMeta,
						   mipd.VigenciaMeta,
						   mipd.EstadoMeta,
						   mipd.ObjetivoMeta,
						   mipd.FechaCreacion,
						   mipd.FechaUltimaModificacion,
						   mipd.UsuarioCreacion,
						   mipd.UsuarioModificacion,
						   mipd.AvanceMetaPlanDesarrollo
					  FROM MetaIndicadorPlanDesarrollo mipd ";
					  
			if(!empty($inner)){
				$sql .= $inner;
			}
			
			if(!empty($where)){
				$sql .= ' 
				     WHERE '.implode(' AND ',$where);
			}
			
			$this->persistencia->crearSentenciaSQL( $sql );
			
			if(!empty($params)){
				foreach($params as $k=>$v){
					$this->persistencia->setParametro( $k, $v->value, $v->text );
				}
			}
			$this->persistencia->ejecutarConsulta(  );
			while( $this->persistencia->getNext( ) ){
				$meta = new Meta( $this->persistencia );
				$meta->setMetaIndicadorPlanDesarrolloId( $this->persistencia->getParametro( "MetaIndicadorPlanDesarrolloId" ) );
				
				$indicador = new Indicador( $persistencian );
				$indicador = $indicador->consultarDetallesIndicador( $this->persistencia->getParametro( "IndicadorPlanDesarrolloId" ) );
				$indicador = $indicador[0];
				$meta->setIndicador( $indicador ); 
				 
				$meta->setNombreMetaPlanDesarrollo( $this->persistencia->getParametro( "NombreMetaPlanDesarrollo" ) ); 
				$meta->setAlcanceMeta( $this->persistencia->getParametro( "AlcanceMeta" ) ); 
				$meta->setVigenciaMeta( $this->persistencia->getParametro( "VigenciaMeta" ) ); 
				$meta->setEstadoMeta( $this->persistencia->getParametro( "EstadoMeta" ) ); 
				$meta->setObjetivoMeta( $this->persistencia->getParametro( "ObjetivoMeta" ) ); 
				
				$meta->setFechaCreacion( $this->persistencia->getParametro( "FechaCreacion" ) );
				$meta->setFechaUltimaModificacion( $this->persistencia->getParametro( "FechaUltimaModificacion" ) );
				$meta->setUsuarioCreacion( $this->persistencia->getParametro( "UsuarioCreacion" ) );
				$meta->setUsuarioModificacion( $this->persistencia->getParametro( "UsuarioModificacion" ) );
				$meta->setAvanceMetaPlanDesarrollo( $this->persistencia->getParametro( "AvanceMetaPlanDesarrollo" ));
				
				
				$metas[] = $meta;
			}
			$this->persistencia->freeResult( );/**/
			foreach($metas as $meta){
				$metasecundaria = null;
				$metasecundaria = new MetaSecundaria($this->persistencia);
				
				$meta->setMetasSecundarias($metasecundaria->consultarMetaSecundaria( $meta->getMetaIndicadorPlanDesarrolloId() ));
				$temp[] = $meta;
			}
			
			$metas = $temp;
			unset($temp);
			
			return 	$metas;
		}
	
		/**
		 * Crear Meta Principal del Indicador del Plan Desarrollo
		 * @access public
		 */
		public function crearMeta( $idPersona ){
			$sql = "INSERT INTO MetaIndicadorPlanDesarrollo (
					MetaIndicadorPlanDesarrolloId,
					IndicadorPlanDesarrolloId,
					NombreMetaPlanDesarrollo,
					AlcanceMeta,
					VigenciaMeta,
					EstadoMeta,
					ObjetivoMeta,
					AvanceMetaPlanDesarrollo,
					FechaCreacion,
					FechaUltimaModificacion,
					UsuarioCreacion,
					UsuarioModificacion,
					proyectoPlanDesarrolloId
				)
				VALUES
					(
						( SELECT IFNULL( MAX( M.MetaIndicadorPlanDesarrolloId ) +1, 1 ) 
							FROM MetaIndicadorPlanDesarrollo M
						 ),
						?,
						?,
						?,
						'2021-01-01',
						'100',
						NULL,
						NULL,
						NOW( ),
						NULL,
						?,
						NULL,
						?
					);";
						
			$this->persistencia->conectar( );
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $this->getIndicador( )->getIndicadorPlanDesarrolloId( ) , true );
			$this->persistencia->setParametro( 1 , $this->getNombreMetaPlanDesarrollo( ) , true );
			$this->persistencia->setParametro( 2 , $this->getAlcanceMeta( ) , true );
			$this->persistencia->setParametro( 3 , $idPersona , false );
			/*Modified Diego Rivera<riveradiego@unbosque.edu.co
			 *se añade parametro proyectoPlanDesarrolloId en consulta sql con el fin que almacene el id de la tabla proyecto plan desarrollo en la meta principal
			 * Since April 10,2017
			 */
			$this->persistencia->setParametro( 4 , $this->getProyectoPlanDesarrolloId(), false );
			$this->persistencia->ejecutarUpdate(  );
			return true;
		}
		
		/**
		 * Consultar Meta Id
		 * @access public
		 */
		 
		/*Modified Diego Rivera<riveradiego@unbosque.edu.co>
 		* se adiciona en consulta sql los campos PD.EmailResponsableProgramaPlanDesarrollo,P.EmailResponsableProyecto
 		* Since April 19 ,2017
 		*/
		 
		public function buscarMetaPlanDesarrollo( $txtIdMetaPrincipal ){
			$sql = "SELECT M.MetaIndicadorPlanDesarrolloId, I.IndicadorPlanDesarrolloId, I.NombreIndicador, P.ProyectoPlanDesarrolloId, P.NombreProyectoPlanDesarrollo,
                                        P.JustificacionProyecto, P.DescripcionProyectoPlanDesarrollo, P.ObjetivoProyectoPlanDesarrollo, P.AccionProyecto, P.ResponsableProyecto,
                                        PD.ProgramaPlanDesarrolloId, PD.NombrePrograma, PD.JustificacionProgramaPlanDesarrollo, PD.DescripcionProgramaPlanDesarrollo, PD.ResponsableProgramaPlanDesarrollo,
                                        L.LineaEstrategicaId, L.NombreLineaEstrategica, M.NombreMetaPlanDesarrollo, M.AlcanceMeta, M.VigenciaMeta, T.NombreTipoIndicador, T.TipoIndicadorId,PD.EmailResponsableProgramaPlanDesarrollo,
                                        P.EmailResponsableProyecto,PL.NombrePlanDesarrollo
				FROM MetaIndicadorPlanDesarrollo M
                                INNER JOIN IndicadorPlanDesarrollo I ON ( I.IndicadorPlanDesarrolloId = M.IndicadorPlanDesarrolloId )
                                INNER JOIN TipoIndicador T ON ( T.TipoIndicadorId = I.TipoIndicadorId )
                                INNER JOIN ProyectoPlanDesarrollo P ON ( P.ProyectoPlanDesarrolloId = I.ProyectoPlanDesarrolloId )
                                INNER JOIN ProgramaProyectoPlanDesarrollo PP ON ( PP.ProyectoPlanDesarrolloId = P.ProyectoPlanDesarrolloId )
                                INNER JOIN ProgramaPlanDesarrollo PD ON ( PD.ProgramaPlanDesarrolloId = PP.ProgramaPlanDesarrolloId )
                                INNER JOIN PlanDesarrolloProgramaLineaEstrategica PDPE ON ( PDPE.ProgramaPlanDesarrolloId = PD.ProgramaPlanDesarrolloId )
                                INNER JOIN LineaEstrategica L ON ( L.LineaEstrategicaId = PDPE.LineaEstrategicaId )
                                INNER JOIN PlanDesarrollo PL ON ( PL.PlanDesarrolloId = PDPE.PlanDesarrolloId )
                                WHERE M.MetaIndicadorPlanDesarrolloId = ?";
				
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $txtIdMetaPrincipal , false );
			$this->persistencia->ejecutarConsulta( );
			if( $this->persistencia->getNext( ) ){
				$this->setMetaIndicadorPlanDesarrolloId( $this->persistencia->getParametro( "MetaIndicadorPlanDesarrolloId" ) );
				$this->setNombreMetaPlanDesarrollo( $this->persistencia->getParametro( "NombreMetaPlanDesarrollo" ) );	
				$this->setAlcanceMeta( $this->persistencia->getParametro( "AlcanceMeta" ) );
				$this->setVigenciaMeta( $this->persistencia->getParametro( "VigenciaMeta" ) );
				
				$indicador = new Indicador( null );
				$indicador->setIndicadorPlanDesarrolloId( $this->persistencia->getParametro( "IndicadorPlanDesarrolloId" ) );
				$indicador->setNombreIndicador( $this->persistencia->getParametro( "NombreIndicador" ) );
				
				$tipoIndicador = new TipoIndicador( null );
				$tipoIndicador->setIdTipoIndicador( $this->persistencia->getParametro( "TipoIndicadorId" ) );
				$tipoIndicador->setNombreTipoIndicador( $this->persistencia->getParametro( "NombreTipoIndicador" ) );
				
				$indicador->setTipoIndicador( $tipoIndicador );
				
				$proyecto = new Proyecto( null );
				$proyecto->setProyectoPlanDesarrolloId( $this->persistencia->getParametro( "ProyectoPlanDesarrolloId" ) );
				$proyecto->setNombreProyectoPlanDesarrollo( $this->persistencia->getParametro( "NombreProyectoPlanDesarrollo" ) );
				$proyecto->setJustificacionProyecto( $this->persistencia->getParametro( "JustificacionProyecto" ) );
				$proyecto->setDescripcionProyecto( $this->persistencia->getParametro( "DescripcionProyectoPlanDesarrollo" ) );
				$proyecto->setObjetivoProyecto( $this->persistencia->getParametro( "ObjetivoProyectoPlanDesarrollo" ) );
				$proyecto->setAccionProyecto( $this->persistencia->getParametro( "AccionProyecto" ) );
				$proyecto->setResponsableProyecto( $this->persistencia->getParametro( "ResponsableProyecto" ) );
				$proyecto->setEmailResponsableProyecto( $this->persistencia->getParametro( "EmailResponsableProyecto" ) );
				$programa = new Programa( null );
				$programa->setIdProgramaPlanDesarrollo( $this->persistencia->getParametro( "ProgramaPlanDesarrolloId" ) );
				$programa->setNombrePrograma( $this->persistencia->getParametro( "NombrePrograma" ) );
				$programa->setJustificacionProgramaPlanDesarrollo( $this->persistencia->getParametro( "JustificacionProgramaPlanDesarrollo" ) );
				$programa->setDescripcionProgramaPlanDesarrollo( $this->persistencia->getParametro( "DescripcionProgramaPlanDesarrollo" ) );
				$programa->setResponsableProgramaPlanDesarrollo( $this->persistencia->getParametro( "ResponsableProgramaPlanDesarrollo" ) );
				$programa->setEmailResponsableProgramaPlanDesarrollo( $this->persistencia->getParametro( "EmailResponsableProgramaPlanDesarrollo" ) );
				
				$lineaEstrategica = new LineaEstrategica( null );
				$lineaEstrategica->setIdLineaEstrategica( $this->persistencia->getParametro( "LineaEstrategicaId" ) );
				$lineaEstrategica->setNombreLineaEstrategica( $this->persistencia->getParametro( "NombreLineaEstrategica" ) );
				
				$programa->setLineaEstrategica( $lineaEstrategica );
                                $planDesarrollo = new PlanDesarrollo( null );
                                $planDesarrollo->setNombrePlanDesarrollo($this->persistencia->getParametro( "NombrePlanDesarrollo" ));
				
				$programaProyecto = new ProgramaProyecto( null );
				$programaProyecto->setProyecto( $proyecto );
				$programaProyecto->setPrograma( $programa );
                                $programaProyecto->setIdProgramaProyecto( $planDesarrollo );
                                $this->setIndicador( $indicador );
				$this->setProgramaProyecto( $programaProyecto );
                                
			}
			
			$this->persistencia->freeResult( );
		}


		/**
		 * Actualizar Meta Plan Desarrollo
		 * @access public
		 */
		public function actualizarMeta( $txtMetaActualizaPrincipal, $txtValorMetaActualizaPrincipal, $txtVigenciaActualizaMetaPrincipal, $idPersona, $txtIdMetaPrincipal ){
			$sql = "UPDATE MetaIndicadorPlanDesarrollo
					SET 
					 NombreMetaPlanDesarrollo = ?,
					 AlcanceMeta = ?,
					 VigenciaMeta = ?,
					 FechaUltimaModificacion = NOW( ),
					 UsuarioModificacion = ?
					WHERE MetaIndicadorPlanDesarrolloId = ?";	
				
			
			$this->persistencia->crearSentenciaSQL( $sql );
		
			$this->persistencia->setParametro( 0 , $txtMetaActualizaPrincipal , true );
			$this->persistencia->setParametro( 1 , $txtValorMetaActualizaPrincipal , false );
			$this->persistencia->setParametro( 2 , $txtVigenciaActualizaMetaPrincipal , true );
			$this->persistencia->setParametro( 3 , $idPersona , false );
			$this->persistencia->setParametro( 4 , $txtIdMetaPrincipal , false );
			$estado = $this->persistencia->ejecutarUpdate( );
		
			if( $estado )
				$this->persistencia->confirmarTransaccion( );
			else	
				$this->persistencia->cancelarTransaccion( );
		 
		 	return $estado;
			
			
		} 
		
		/**
		 * diego rivera<riveradiego@unbosque.edu.co> 
		 * Actualizar avance Meta Plan Desarrollo
		 * @access public
		 */
		public function actualizarAvanceMeta ( $avanceMeta , $idMeta ){
				$sql="
					update 
						MetaIndicadorPlanDesarrollo 
					set 
						AvanceMetaPlanDesarrollo = ?
					
					where
						MetaIndicadorPlanDesarrolloId = ?
				";	
		
			$this->persistencia->crearSentenciaSQL( $sql );
		
			$this->persistencia->setParametro( 0 , $avanceMeta , false );
			$this->persistencia->setParametro( 1 , $idMeta , false );
			return  $this->persistencia->ejecutarUpdate( );	
		}
		
		
		/*Modified Diego Rivera<riveradiego@unbosque.edu.co>
		 *se crear insert de meta principla incluye campo proyectoplandesarrolloid 
		 */
		public function crearMetaPrincipal( $idPersona ){
			$sql = "INSERT INTO MetaIndicadorPlanDesarrollo (
					MetaIndicadorPlanDesarrolloId,
					IndicadorPlanDesarrolloId,
					NombreMetaPlanDesarrollo,
					AlcanceMeta,
					VigenciaMeta,
					EstadoMeta,
					ObjetivoMeta,
					AvanceMetaPlanDesarrollo,
					FechaCreacion,
					FechaUltimaModificacion,
					UsuarioCreacion,
					UsuarioModificacion,
					proyectoPlanDesarrolloId
					
				)
				VALUES
					(
						( SELECT IFNULL( MAX( M.MetaIndicadorPlanDesarrolloId ) +1, 1 ) 
							FROM MetaIndicadorPlanDesarrollo M
						 ),
						?,
						?,
						?,
						'2021-01-01',
						'100',
						NULL,
						NULL,
						NOW( ),
						NULL,
						?,
						NULL,
						?
					);";
					
			$this->persistencia->conectar( );
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $this->getIndicador( )->getIndicadorPlanDesarrolloId( ) , true );
			$this->persistencia->setParametro( 1 , $this->getNombreMetaPlanDesarrollo( ) , true );
			$this->persistencia->setParametro( 2 , $this->getAlcanceMeta( ) , true );
			$this->persistencia->setParametro( 3 , $idPersona , false );
			$this->persistencia->setParametro( 4 , $this->getProyectoPlanDesarrolloId( ) , false );
			$this->persistencia->ejecutarUpdate(  );
			return true;
		}
		
		public function verMetas ( $codigoFacultad , $codigoCarrera , $idProyecto , $idIndicador , $idLinea , $idPrograma ) {
		 	$metas = array( );
		
			 
			 $sql = "
			 SELECT
				mipd.MetaIndicadorPlanDesarrolloId,
				mipd.NombreMetaPlanDesarrollo,
				mipd.AlcanceMeta,
				mipd.AvanceMetaPlanDesarrollo,
				mipd.VigenciaMeta,
				mipd.IndicadorPlanDesarrolloId,
				(
					sum(
						mipd.AvanceMetaPlanDesarrollo
					) * 100 / sum(mipd.AlcanceMeta)
				) AS porcentaje,
				
				(
					select (100/count(*)) from MetaIndicadorPlanDesarrollo where  ProyectoPlanDesarrolloId=?
				)as porcentajeMeta
			FROM
				MetaIndicadorPlanDesarrollo mipd
			INNER JOIN ProyectoPlanDesarrollo ppd ON ppd.ProyectoPlanDesarrolloId = mipd.ProyectoPlanDesarrolloId
			INNER JOIN ProgramaProyectoPlanDesarrollo pppd ON pppd.ProyectoPlanDesarrolloId = ppd.ProyectoPlanDesarrolloId
			INNER JOIN ProgramaPlanDesarrollo ppde ON ppde.ProgramaPlanDesarrolloId = pppd.ProgramaPlanDesarrolloId
			INNER JOIN PlanDesarrolloProgramaLineaEstrategica pdple ON pdple.ProgramaPlanDesarrolloId = ppde.ProgramaPlanDesarrolloId
			INNER JOIN LineaEstrategica le ON le.LineaEstrategicaId = pdple.LineaEstrategicaId
			INNER JOIN PlanDesarrollo pd ON pd.PlanDesarrolloId = pdple.PlanDesarrolloId
			WHERE
				mipd.EstadoMeta=100 and 
				mipd.IndicadorPlanDesarrolloId = ? and 
				mipd.ProyectoPlanDesarrolloId = ?  
		
			GROUP BY
				mipd.MetaIndicadorPlanDesarrolloId,
				mipd.NombreMetaPlanDesarrollo,
				mipd.AlcanceMeta,
				mipd.AvanceMetaPlanDesarrollo,
				mipd.VigenciaMeta,
				mipd.IndicadorPlanDesarrolloId ";
			 
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $idProyecto , false );
			$this->persistencia->setParametro( 1 , $idIndicador , false );
			$this->persistencia->setParametro( 2 , $idProyecto , false );

			$this->persistencia->ejecutarConsulta(  );		
			//echo $this->persistencia->getSQLListo( ).'<br><br>';
				while( $this->persistencia->getNext( ) ){
				
					$meta = new Meta( $this->persistencia );
					$meta ->setNombreMetaPlanDesarrollo( $this->persistencia->getParametro( "NombreMetaPlanDesarrollo" ) );
					$meta ->setMetaIndicadorPlanDesarrolloId($this->persistencia->getParametro( "MetaIndicadorPlanDesarrolloId" ));
					$meta ->setAlcanceMeta($this->persistencia->getParametro( "AlcanceMeta" ));
					$meta ->setAvanceMetaPlanDesarrollo($this->persistencia->getParametro( "AvanceMetaPlanDesarrollo" ));
					$meta ->setPorcentaje($this->persistencia->getParametro( "porcentaje" ));
					$meta ->setVigenciaMeta($this->persistencia->getParametro( "VigenciaMeta" ));
					$meta ->setIndicador($this->persistencia->getParametro( "IndicadorPlanDesarrolloId"));
					$meta ->setPorcentajeMeta($this->persistencia->getParametro( "porcentajeMeta" ));
					
					$metas[] = $meta;
				}			
			return $metas;
		}
                
                public function verMetasAvance ( $codigoFacultad , $codigoCarrera , $idProyecto , $idIndicador , $idLinea , $idPrograma ,$periodo) {
		 	$metas = array( );
		
			 
			 $sql = "
			 SELECT
				mipd.MetaIndicadorPlanDesarrolloId,
				mipd.NombreMetaPlanDesarrollo,
				mipd.AlcanceMeta,
				mipd.AvanceMetaPlanDesarrollo,
				mipd.VigenciaMeta,
				mipd.IndicadorPlanDesarrolloId,
				(
					sum(
						mipd.AvanceMetaPlanDesarrollo
					) * 100 / sum(mipd.AlcanceMeta)
				) AS porcentaje,
				
				(
					select (100/count(*)) from MetaIndicadorPlanDesarrollo where  ProyectoPlanDesarrolloId=?
				)as porcentajeMeta
			FROM
			MetaIndicadorPlanDesarrollo mipd
			INNER JOIN ProyectoPlanDesarrollo ppd ON ppd.ProyectoPlanDesarrolloId = mipd.ProyectoPlanDesarrolloId
			INNER JOIN ProgramaProyectoPlanDesarrollo pppd ON pppd.ProyectoPlanDesarrolloId = ppd.ProyectoPlanDesarrolloId
			INNER JOIN ProgramaPlanDesarrollo ppde ON ppde.ProgramaPlanDesarrolloId = pppd.ProgramaPlanDesarrolloId
			INNER JOIN PlanDesarrolloProgramaLineaEstrategica pdple ON pdple.ProgramaPlanDesarrolloId = ppde.ProgramaPlanDesarrolloId
			INNER JOIN LineaEstrategica le ON le.LineaEstrategicaId = pdple.LineaEstrategicaId
			INNER JOIN PlanDesarrollo pd ON pd.PlanDesarrolloId = pdple.PlanDesarrolloId
                        INNER JOIN MetaSecundariaPlanDesarrollo mspd on (mipd.MetaIndicadorPlanDesarrolloId =mspd.MetaIndicadorPlanDesarrolloId) 
			WHERE
				mipd.EstadoMeta=100 and 
				mipd.IndicadorPlanDesarrolloId = ? and 
				mipd.ProyectoPlanDesarrolloId = ?  and
                                mspd.FechaFinMetaSecundaria like '%?%' and
                                ppd.EstadoProyectoPlanDesarrollo = 100 and
                                pppd.EstadoProgramaProyecto = 100 and
                                mspd.EstadoMetaSecundaria = 100 and
                                pdple.EstadoPlanDesarrolloLineaEstrategica = 100 
		
			GROUP BY
				mipd.MetaIndicadorPlanDesarrolloId,
				mipd.NombreMetaPlanDesarrollo,
				mipd.AlcanceMeta,
				mipd.AvanceMetaPlanDesarrollo,
				mipd.VigenciaMeta,
				mipd.IndicadorPlanDesarrolloId ";
			 
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $idProyecto , false );
			$this->persistencia->setParametro( 1 , $idIndicador , false );
			$this->persistencia->setParametro( 2 , $idProyecto , false );
                        $this->persistencia->setParametro( 3 , $periodo, false );

			$this->persistencia->ejecutarConsulta(  );		
			//echo $this->persistencia->getSQLListo( ).'<br><br>';
				while( $this->persistencia->getNext( ) ){
				
					$meta = new Meta( $this->persistencia );
					$meta ->setNombreMetaPlanDesarrollo( $this->persistencia->getParametro( "NombreMetaPlanDesarrollo" ) );
					$meta ->setMetaIndicadorPlanDesarrolloId($this->persistencia->getParametro( "MetaIndicadorPlanDesarrolloId" ));
					$meta ->setAlcanceMeta($this->persistencia->getParametro( "AlcanceMeta" ));
					$meta ->setAvanceMetaPlanDesarrollo($this->persistencia->getParametro( "AvanceMetaPlanDesarrollo" ));
					$meta ->setPorcentaje($this->persistencia->getParametro( "porcentaje" ));
					$meta ->setVigenciaMeta($this->persistencia->getParametro( "VigenciaMeta" ));
					$meta ->setIndicador($this->persistencia->getParametro( "IndicadorPlanDesarrolloId"));
					$meta ->setPorcentajeMeta($this->persistencia->getParametro( "porcentajeMeta" ));
					
					$metas[] = $meta;
				}			
			return $metas;
		}


	/*Modified Diego Rivera<riveradiego@unbosque.edu.co>
	 *Se crea funcion eliminaMetaPrincipal con el fin de inactivar metas principales 
	 *Since July 21 ,2017 
	 */

		public function eliminaMetaPrincipal ( $idPersona, $txtIdMeta ){
			$sql = "UPDATE MetaIndicadorPlanDesarrollo
					SET 
					 EstadoMeta = '200',
					 FechaUltimaModificacion = NOW( ),
					 UsuarioModificacion = ?
					WHERE
					MetaIndicadorPlanDesarrolloId = ?;";
					
			$this->persistencia->crearSentenciaSQL( $sql );
		
			$this->persistencia->setParametro( 0 , $idPersona , false );
			$this->persistencia->setParametro( 1 , $txtIdMeta , false );
			$estado = $this->persistencia->ejecutarUpdate( );
			
			if( $estado ) {
				$this->persistencia->confirmarTransaccion( );
			} else { 	
				$this->persistencia->cancelarTransaccion( );
			}
				return $estado;	
		}
		
	}
	
?>