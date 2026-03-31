<?php
    /**
	 * @author Andres Ariza <arizaandres@unbosque.edu.do>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @package control
	 * @since November 8, 2016
	*/
	include_once ('../../../kint/Kint.class.php');
	class Indicador{
		
		 /**
		 * @type int
		 * @access private
		 */
		private $indicadorPlanDesarrolloId;
		
		 /**
		 * @type int
		 * @access private
		 */
		private $tipoIndicador;
		
		 /**
		 * @type int
		 * @access private
		 */
		private $proyecto;
		
		 /**
		 * @type int
		 * @access private
		 */
		private $escalaValor;
		
		 /**
		 * @type String
		 * @access private
		 */
		private $nombreIndicador;
		
		 /**
		 * @type String
		 * @access private
		 */
		private $puntajeIndicador;
		
		 /**
		 * @type String
		 * @access private
		 */
		private $estadoIndicadorPlanDesarrollo;
		
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
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		/**
		 * Constructor
		 * @param Singleton $persistencia
		 */
		public function Indicador( $persistencia ){ 
			$this->persistencia = $persistencia;
		}
		
		
		/**
		 * Modifica el id del Indicador
		 * @param int $indicadorPlanDesarrolloId
		 * @access public
		 * @return void
		 */
		public function setIndicadorPlanDesarrolloId( $indicadorPlanDesarrolloId ){
			$this->indicadorPlanDesarrolloId = $indicadorPlanDesarrolloId;
		}
		
		/**
		 * Retorna el id del Indicador
		 * @access public
		 * @return int
		 */
		public function getIndicadorPlanDesarrolloId( ){
			return $this->indicadorPlanDesarrolloId;
		}
		
		/**
		 * Modifica el tipo del Indicador
		 * @param int $tipoIndicador
		 * @access public
		 * @return void
		 */
		public function setTipoIndicador( $tipoIndicador ){
			$this->tipoIndicador = $tipoIndicador;
		}
		
		/**
		 * Retorna el tipo del Indicador
		 * @access public
		 * @return int
		 */
		public function getTipoIndicador( ){
			return $this->tipoIndicador;
		}
		
		/**
		 * Modifica el id de proyecto del Indicador
		 * @param int $proyectoPlanDesarrolloId
		 * @access public
		 * @return void
		 */
		public function setProyecto( $proyecto ){
			$this->proyecto= $proyecto;
		}
		
		/**
		 * Retorna el id del proyecto del Indicador
		 * @access public
		 * @return int
		 */
		public function getProyecto( ){
			return $this->proyecto;
		}
		
		/**
		 * Modifica el valor escala id del Indicador
		 * @param int $escalaValorId
		 * @access public
		 * @return void
		 */
		public function setEscalaValor( $escalaValor ){
			$this->escalaValor = $escalaValor ;
		}
		
		/**
		 * Retorna el valor escala id del Indicador
		 * @access public
		 * @return int
		 */
		public function getEscalaValor( ){
			return $this->escalaValor;
		}
		
		/**
		 * Modifica nombre del Indicador
		 * @param String $nombreIndicador
		 * @access public
		 * @return void
		 */
		public function setNombreIndicador( $nombreIndicador ){
			$this->nombreIndicador = $nombreIndicador;
		}
		
		/**
		 * Retorna el nombre del Indicador
		 * @access public
		 * @return String
		 */
		public function getNombreIndicador( ){
			return $this->nombreIndicador;
		}
		
		/**
		 * Modifica puntaje del Indicador
		 * @param int $puntajeIndicador
		 * @access public
		 * @return void
		 */
		public function setPuntajeIndicador( $puntajeIndicador ){
			$this->puntajeIndicador = $puntajeIndicador;
		}
		
		/**
		 * Retorna el puntaje del Indicador
		 * @access public
		 * @return Int
		 */
		public function getPuntajeIndicador( ){
			return $this->puntajeIndicador;
		}
		
		/**
		 * Modifica estado del Indicador
		 * @param int $estadoIndicadorPlanDesarrollo
		 * @access public
		 * @return void
		 */
		public function setEstadoIndicadorPlanDesarrollo( $estadoIndicadorPlanDesarrollo ){
			$this->estadoIndicadorPlanDesarrollo = $estadoIndicadorPlanDesarrollo;
		}
		
		/**
		 * Retorna el Estado del Indicador
		 * @access public
		 * @return Int
		 */
		public function getEstadoIndicadorPlanDesarrollo( ){
			return $this->estadoIndicadorPlanDesarrollo;
		}
		
		/**
		 * Modifica la fecha de creacion del proyecto
		 * @param datetime fechaCreacion
		 * @access public
		 * @return void
		 */
		public function setFechaCreacion( $fechaCreacion ){
			$this->fechaCreacion = $fechaCreacion;
		}
		
		/**
		 * Retorna la fecha de creacion del proyecto
		 * @access public
		 * @return datetime
		 */
		public function getFechaCreacion( ){
			return $this->fechaCreacion;
		}
		
		/**
		 * Modifica la fecha de modificacion del proyecto
		 * @param datetime fechaUltimaModificacion
		 * @access public
		 * @return void
		 */
		public function setFechaUltimaModificacion( $fechaUltimaModificacion ){
			$this->fechaUltimaModificacion = $fechaUltimaModificacion;
		}
		
		/**
		 * Retorna la fecha de modificacion del proyecto
		 * @access public
		 * @return datetime
		 */
		public function getFechaUltimaModificacion( ){
			return $this->fechaUltimaModificacion;
		}
		
		/**
		 * Modifica el usuario de creacion del proyecto
		 * @param int usuarioCreacion
		 * @access public
		 * @return void
		 */
		public function setUsuarioCreacion( $usuarioCreacion ){
			$this->usuarioCreacion = $usuarioCreacion;
		}
		
		/**
		 * Retorna usuario de creacion del proyecto
		 * @access public
		 * @return int
		 */
		public function getUsuarioCreacion( ){
			return $this->usuarioCreacion;
		}
		
		/**
		 * Modifica el usuario de modificacion del proyecto
		 * @param int usuarioModificacion
		 * @access public
		 * @return void
		 */
		public function setUsuarioModificacion( $usuarioModificacion ){
			$this->usuarioModificacion = $usuarioModificacion;
		}
		
		/**
		 * Retorna usuario de modificacion del proyecto
		 * @access public
		 * @return int
		 */
		public function getUsuarioModificacion( ){
			return $this->usuarioModificacion;
		}
		
		/**
		 * Consultar Detalles Indicador
		 * @access public
		 * @return void
		 */
		public function consultarDetallesIndicador( $indicadorPlanDesarrolloId ){
			
			$indicadores = array( );
			$inner='';
			$where = array();
			$params = array();
			
			if(  !empty($indicadorPlanDesarrolloId) ){
				//$inner = 'INNER JOIN ProgramaProyectoPlanDesarrollo pppd ON (ppd.ProyectoPlanDesarrolloId = pppd.ProyectoPlanDesarrolloId)';
				$where[] = 'ipd.IndicadorPlanDesarrolloId = ?';
				$objParam = new stdClass();
				$objParam->value = $indicadorPlanDesarrolloId;
				$objParam->text = false;
				$params[0] = $objParam; 
				unset($objParam);
			}
			
			$where[] = 'ipd.EstadoIndicadorPlanDesarrollo = 100';
			$sql = "SELECT ipd.IndicadorPlanDesarrolloId,
						   ipd.TipoIndicadorId,
						   ipd.ProyectoPlanDesarrolloId,
						   ipd.EscalaValorId,
						   ipd.NombreIndicador,
						   ipd.PuntajeIndicador,
						   ipd.FechaCreacion,
						   ipd.FechaUltimaModificacion,
						   ipd.UsuarioCreacion,
						   ipd.UsuarioModificacion
					  FROM IndicadorPlanDesarrollo ipd ";
					  
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
			
			//ddd($this->persistencia->getSQLListo( )); 
			$this->persistencia->ejecutarConsulta(  );
			while( $this->persistencia->getNext( ) ){
				$indicador = new Indicador( $this->persistencia );
				$indicador->setIndicadorPlanDesarrolloId( $this->persistencia->getParametro( "IndicadorPlanDesarrolloId" ) );
				
				$proyecto = new Proyecto( null );
				$proyecto->setProyectoPlanDesarrolloId( $this->persistencia->getParametro( "ProyectoPlanDesarrolloId" ) );
				
				$indicador->setProyecto( $proyecto );
				
				$escalaValor = new EscalaValor( null );
				$escalaValor->setIdEscalaValor( $this->persistencia->getParametro( "EscalaValorId" ) );
				
				$indicador->setEscalaValor( $escalaValor );
				
				$indicador->setNombreIndicador( $this->persistencia->getParametro( "NombreIndicador" ) );
				$indicador->setPuntajeIndicador( $this->persistencia->getParametro( "PuntajeIndicador" ) );
				
				$indicador->setFechaCreacion( $this->persistencia->getParametro( "FechaCreacion" ) );
				$indicador->setFechaUltimaModificacion( $this->persistencia->getParametro( "FechaUltimaModificacion" ) );
				$indicador->setUsuarioCreacion( $this->persistencia->getParametro( "UsuarioCreacion" ) );
				$indicador->setUsuarioModificacion( $this->persistencia->getParametro( "UsuarioModificacion" ) );
				
				$tipoIndicador = new TipoIndicador(  $this->persistencia );
				$tipoIndicador->setIdTipoIndicador($this->persistencia->getParametro( "TipoIndicadorId" ));
				$tipoIndicador->consultarNombreTipoIndicador($this->persistencia->getParametro( "TipoIndicadorId" ));
				$indicador->setTipoIndicador( $tipoIndicador );

				$indicadores[] = $indicador;
			}
			$this->persistencia->freeResult( );/**/
			
			return 	$indicadores;/**/
		}
		
		/**
		 * Consultar Indicadores
		 * @access public
		 */
		public function consultarIndicador( $proyectoConsulta, $meta ){
			
			$indicadores = array( );
			$inner='';
			$where = array();
			$params = array();
			
			if(  !empty($proyectoConsulta) ){
				/*
				* @Ivan quintero <quinteroivan@unbosque.edu.co>
				* Se modifica  a consulta ya que el campo esta relacionado dentra de la misma tabla
				//$inner = 'INNER JOIN ProgramaProyectoPlanDesarrollo pppd ON (ppd.ProyectoPlanDesarrolloId = pppd.ProyectoPlanDesarrolloId)';
				* END
				*/
				$where[] = 'ipd.ProyectoPlanDesarrolloId = ?';
				$objParam = new stdClass();
				$objParam->value = $proyectoConsulta;
				$objParam->text = false;
				$params[0] = $objParam; 
				unset($objParam);
			}
			/*
			* @Ivan quintero <quinteroivan@unbosque.edu.co>
			* Se crea la siguiente validacion para la consulta solo por la meta definida
			*/
			
			if(  !empty($meta) ){
				$inner = 'INNER JOIN MetaIndicadorPlanDesarrollo MI on MI.IndicadorPlanDesarrolloId = ipd.IndicadorPlanDesarrolloId';
				$where[] = 'MI.MetaIndicadorPlanDesarrolloId = ?';
				$objParam = new stdClass();
				$objParam->value = $meta;
				$objParam->text = false;
				$params[0] = $objParam; 
				unset($objParam);
			}
			/*
			*END
			*/
			
			$where[] = 'ipd.EstadoIndicadorPlanDesarrollo = 100';
			$sql = "SELECT ipd.IndicadorPlanDesarrolloId,
						   ipd.TipoIndicadorId,
						   ipd.ProyectoPlanDesarrolloId,
						   ipd.EscalaValorId,
						   ipd.NombreIndicador,
						   ipd.PuntajeIndicador,
						   ipd.FechaCreacion,
						   ipd.FechaUltimaModificacion,
						   ipd.UsuarioCreacion,
						   ipd.UsuarioModificacion
					  FROM IndicadorPlanDesarrollo ipd ";
					  
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
			
			//ddd($this->persistencia->getSQLListo( )); 
			$this->persistencia->ejecutarConsulta(  );
			while( $this->persistencia->getNext( ) ){
				$indicador = new Indicador( $this->persistencia );
				$indicador->setIndicadorPlanDesarrolloId( $this->persistencia->getParametro( "IndicadorPlanDesarrolloId" ) );
				
				$tipoIndicador = new TipoIndicador( null );
				$tipoIndicador->setIdTipoIndicador($this->persistencia->getParametro( "TipoIndicadorId" ));
				
				$indicador->setTipoIndicador( $tipoIndicador );
				
				$proyecto = new Proyecto( null );
				$proyecto->setProyectoPlanDesarrolloId( $this->persistencia->getParametro( "ProyectoPlanDesarrolloId" ) );
				
				$indicador->setProyecto( $proyecto );
				
				$escalaValor = new EscalaValor( null );
				$escalaValor->setIdEscalaValor( $this->persistencia->getParametro( "EscalaValorId" ) );
				
				$indicador->setEscalaValor( $escalaValor );
				
				$indicador->setNombreIndicador( $this->persistencia->getParametro( "NombreIndicador" ) );
				$indicador->setPuntajeIndicador( $this->persistencia->getParametro( "PuntajeIndicador" ) );
				
				$indicador->setFechaCreacion( $this->persistencia->getParametro( "FechaCreacion" ) );
				$indicador->setFechaUltimaModificacion( $this->persistencia->getParametro( "FechaUltimaModificacion" ) );
				$indicador->setUsuarioCreacion( $this->persistencia->getParametro( "UsuarioCreacion" ) );
				$indicador->setUsuarioModificacion( $this->persistencia->getParametro( "UsuarioModificacion" ) );
				
				$indicadores[] = $indicador;
			}
			$this->persistencia->freeResult( );/**/
			//ddd($indicadores);
			return 	$indicadores;/**/
		}
		
		
		/**
		 * Crear Indicador del Plan Desarrollo
		 * @access public
		 */
		public function crearIndicador( $idPersona ){
			$sql = "INSERT INTO IndicadorPlanDesarrollo (
						IndicadorPlanDesarrolloId,
						TipoIndicadorId,
						ProyectoPlanDesarrolloId,
						EscalaValorId,
						NombreIndicador,
						PuntajeIndicador,
						EstadoIndicadorPlanDesarrollo,
						FechaCreacion,
						FechaUltimaModificacion,
						UsuarioCreacion,
						UsuarioModificacion
					)
					VALUES
						(
							( SELECT IFNULL( MAX( I.IndicadorPlanDesarrolloId ) +1, 1 ) 
							FROM IndicadorPlanDesarrollo I
							 ),
							?,
							?,
							NULL,
							?,
							'0',
							'100',
							NOW( ),
							NULL,
							?,
							NULL
						);";
						
			$this->persistencia->conectar( );
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $this->getTipoIndicador( )->getIdTipoIndicador( ) , false );
			$this->persistencia->setParametro( 1 , $this->getProyecto( )->getProyectoPlanDesarrolloId( ) , false );
			$this->persistencia->setParametro( 2 , $this->getNombreIndicador( ) , true );
			$this->persistencia->setParametro( 3 , $idPersona , false );
			//echo $this->persistencia->getSQLListo( ); exit( );
			$this->persistencia->ejecutarUpdate(  );
			return true;
		}
		
		
		/**
		 * Actualizar el indicador del Plan Desarrollo
		 * @access public
		 */
		public function actualizarIndicador( $txtIdTipoIndicador, $txtActualizaIndicador, $idPersona, $txtIdIndicador ){
			$sql = "UPDATE IndicadorPlanDesarrollo
					SET 
					 TipoIndicadorId = ?,
					 NombreIndicador = ?,
					 FechaUltimaModificacion = NOW( ),
					 UsuarioModificacion = ?
					WHERE IndicadorPlanDesarrolloId = ?;";	
				
			
			$this->persistencia->crearSentenciaSQL( $sql );
		
			$this->persistencia->setParametro( 0 , $txtIdTipoIndicador , false );
			$this->persistencia->setParametro( 1 , $txtActualizaIndicador , true );
			$this->persistencia->setParametro( 2 , $idPersona , false );
			$this->persistencia->setParametro( 3 , $txtIdIndicador , false );
			//echo $this->persistencia->getSQLListo( );
			$estado = $this->persistencia->ejecutarUpdate( );
			
			if( $estado )
				$this->persistencia->confirmarTransaccion( );
			else	
				$this->persistencia->cancelarTransaccion( );
						
			//$this->persistencia->freeResult( );
			return $estado;
			
			
		}
                public function indicadorProyecto( $idProyecto , $nombreIndicador ){
                    /*Modified Diego Rivera<riveradiego@unbosque.edu.co>
                     *Se añade and EstadoIndicadorPlanDesarrollo = 100  esto afecta el autocompletar de la opcion crear nueva meta
                     *mostradon unicamente  indicadores activos (caso aranda 108292)  
                     *                      */
                    $indicadores = array( );
                    $sql = "select
                                             NombreIndicador,IndicadorPlanDesarrolloId,TipoIndicadorId
                                from 
                                    IndicadorPlanDesarrollo
                                 where
                                    ProyectoPlanDesarrolloId=? and NombreIndicador like '%?%' and EstadoIndicadorPlanDesarrollo = 100";
                    $this->persistencia->crearSentenciaSQL( $sql );
                    $this->persistencia->setParametro( 0 , $idProyecto , false );
                    $this->persistencia->setParametro( 1 , $nombreIndicador , false );
                    $this->persistencia->ejecutarConsulta( );

                    while( $this->persistencia->getNext( ) ){
                            $indicador = new Indicador( $this->persistencia );
                            $indicador->setNombreIndicador( $this->persistencia->getParametro( "NombreIndicador" ) );
                            $indicador->setIndicadorPlanDesarrolloId( $this->persistencia->getParametro( "IndicadorPlanDesarrolloId" ) );
                            $indicador->setTipoIndicador( $this->persistencia->getParametro( "TipoIndicadorId" ) );
                            $indicadores[]=$indicador;	
                    }

                    return $indicadores;

		}
		
		
	//*********************************
	
	public function verIndicadorId( $indicador , $idproyecto){
			
				$sql = "SELECT
					IndicadorPlanDesarrolloId
					FROM
						IndicadorPlanDesarrollo
					WHERE
					 ProyectoPlanDesarrolloId = 311 and NombreIndicador = 'Resultado de las encuestas de percepción aplicadas a los diferentes grupos de interés de la Comunidad Universitaria de la Facultad.' ";
				$this->persistencia->crearSentenciaSQL( $sql );
				/*$this->persistencia->setParametro( 0 , $idproyecto, false );
				$this->persistencia->setParametro( 1 , $indicador, true );
	*/
				echo $this->persistencia->getSQLListo( );
				$this->persistencia->ejecutarConsulta( );
			
			if( $this->persistencia->getNext( ) ){
				$indicador = new Indicador( $this->persistencia );
				 $indicador->setIndicadorPlanDesarrolloId( $this->persistencia->getParametro( "IndicadorPlanDesarrolloId" ) );
				//echo "<pre>";($indicador);echo "</pre>";
				return $indicador;
				
					
			}
	
		}
	
	
	public function verIndicadorMetaProyecto ( $idProyecto , $codigoPeriodo = null ){
            $indicadores = array( );
            $where = "";
        /*$sql = " SELECT
                                ipd.IndicadorPlanDesarrolloId,
                                ipd.NombreIndicador,
                                ipd.TipoIndicadorId

                        FROM 
                                IndicadorPlanDesarrollo ipd
                        WHERE
                                ipd.EstadoIndicadorPlanDesarrollo = 100 and
                                 ipd.ProyectoPlanDesarrolloId = ?";*/
            if( $codigoPeriodo ){
                $where.=" AND mspd.FechaFinMetaSecundaria LIKE '%?%' and mspd.EstadoMetaSecundaria=100 ";
            }                        
            $sql ="SELECT
                            ipd.NombreIndicador,
                            ipd.TipoIndicadorId,
                            ipd.IndicadorPlanDesarrolloId
                    FROM
                            LineaEstrategica lne
                            INNER JOIN PlanDesarrolloProgramaLineaEstrategica pdple ON pdple.LineaEstrategicaId = lne.LineaEstrategicaId
                            INNER JOIN PlanDesarrollo pd ON pd.PlanDesarrolloId = pdple.PlanDesarrolloId
                            INNER JOIN ProgramaPlanDesarrollo ppd ON ppd.ProgramaPlanDesarrolloId = pdple.ProgramaPlanDesarrolloId
                            INNER JOIN ProgramaProyectoPlanDesarrollo pppd ON pppd.ProgramaPlanDesarrolloId = ppd.ProgramaPlanDesarrolloId
                            INNER JOIN ProyectoPlanDesarrollo propd ON propd.ProyectoPlanDesarrolloId = pppd.ProyectoPlanDesarrolloId
                            INNER JOIN MetaIndicadorPlanDesarrollo mipd ON mipd.ProyectoPlanDesarrolloId = propd.ProyectoPlanDesarrolloId 
                            INNER JOIN IndicadorPlanDesarrollo ipd on mipd.IndicadorPlanDesarrolloId = ipd.IndicadorPlanDesarrolloId";
                            if( $codigoPeriodo ){
                               $sql.=" INNER JOIN MetaSecundariaPlanDesarrollo mspd on (mipd.MetaIndicadorPlanDesarrolloId = mspd.MetaIndicadorPlanDesarrolloId)"; 
                            }
             $sql.=" WHERE
                            propd.ProyectoPlanDesarrolloId =?
                            AND propd.EstadoProyectoPlanDesarrollo = 100 
                            AND pdple.EstadoPlanDesarrolloLineaEstrategica = 100 
                            AND ppd.EstadoProgramaPlanDesarrollo = 100 
                            AND pppd.EstadoProgramaProyecto = 100 
                            AND mipd.EstadoMeta = 100
                            ".$where."
                    GROUP BY ipd.IndicadorPlanDesarrolloId";                        

                    
                $this->persistencia->crearSentenciaSQL( $sql );
                $this->persistencia->setParametro( 0 , $idProyecto , false );
                if( $codigoPeriodo){
                     $this->persistencia->setParametro( 1 , $codigoPeriodo , false );
                }
                $this->persistencia->ejecutarConsulta(  );	
                //echo $this->persistencia->getSQLListo( );
                while( $this->persistencia->getNext( ) ){
                        $indicador = new Indicador( $this->persistencia );
                        $indicador->setNombreIndicador( $this->persistencia->getParametro( "NombreIndicador" ) );
                        $indicador->setTipoIndicador($this->persistencia->getParametro(  "TipoIndicadorId" ) );
                        $indicador->setIndicadorPlanDesarrolloId($this->persistencia->getParametro( "IndicadorPlanDesarrolloId" ));			
                        $indicadores[] = $indicador;
                        }

                return $indicadores;
	}	
    }
	
?>