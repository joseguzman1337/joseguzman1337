<?php
    /**
	 * @author Andres Ariza <arizaandres@unbosque.edu.do>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @package control
	 * @since November 2, 2016
	*/
	
	class Programa{
		
		/**
		 * @type int
		 * @access private
		 */
		private $idProgramaPlanDesarrollo;
		
		/**
		 * @type String
		 * @access private
		 */
		private $nombrePrograma;
		
		/**
		 * @type Text
		 * @access private
		 */
		private $justificacionProgramaPlanDesarrollo;
		
		/**
		 * @type Text
		 * @access private
		 */
		private $descripcionProgramaPlanDesarrollo;
		
		/**
		 * @type int
		 * @access private
		 */
		private $estadoProgramaPlanDesarrollo;
		
		
		/**
		 * @type Text
		 * @access private
		 */
		private $responsableProgramaPlanDesarrollo;
		
		/**
		 * @type LineaEstrategica
		 * @access private
		 */
		private $lineaEstrategica;
		
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
		 * @type int
		 * @access private
		 */
		private $usuarioModificacion;
		
		
		/*Modified Diego Rivera<riveradiego@unbosque.edu.co>
		 *Se añada emailResponsableProgramaPlanDesarrollo campo nuevo en bd 
		 *Since April 18
		 * */
		private $emailResponsableProgramaPlanDesarrollo;
		
		
		 
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		/**
		 * Constructor
		 * @param Singleton $persistencia
		 */
		public function Programa( $persistencia ){
			$this->persistencia = $persistencia;
		}
		
		
		/**
		 * Modifica el id del programa
		 * @param int $idProgramaPlanDesarrollo
		 * @access public
		 */
		public function setIdProgramaPlanDesarrollo( $idProgramaPlanDesarrollo ){
			$this->idProgramaPlanDesarrollo = $idProgramaPlanDesarrollo;
		}
		
		/**
		 * Retorna el id del programa
		 * @access public
		 * @return int
		 */
		public function getIdProgramaPlanDesarrollo( ){
			return $this->idProgramaPlanDesarrollo;
		}
		
		/**
		 * Modifica el nombre del programa
		 * @param string nombrePrograma
		 * @access public
		 */
		public function setNombrePrograma( $nombrePrograma ){
			$this->nombrePrograma = $nombrePrograma;
		}
		
		/**
		 * Retorna el nombre del programa
		 * @access public
		 * @return string
		 */
		public function getNombrePrograma( ){
			return $this->nombrePrograma;
		}
		
		/**
		 * Modifica la justificacion del programa
		 * @param string justificacionProgramaPlanDesarrollo
		 * @access public
		 */
		public function setJustificacionProgramaPlanDesarrollo( $justificacionProgramaPlanDesarrollo ){
			$this->justificacionProgramaPlanDesarrollo = $justificacionProgramaPlanDesarrollo;
		}
		
		/**
		 * Retorna la justificacion del programa
		 * @access public
		 * @return string
		 */
		public function getJustificacionProgramaPlanDesarrollo( ){
			return $this->justificacionProgramaPlanDesarrollo;
		}
		
		/**
		 * Modifica la descripcion del programa
		 * @param string $descripcionProgramaPlanDesarrollo
		 * @access public
		 */
		public function setDescripcionProgramaPlanDesarrollo( $descripcionProgramaPlanDesarrollo ){
			$this->descripcionProgramaPlanDesarrollo = $descripcionProgramaPlanDesarrollo;
		}
		
		/**
		 * Retorna la descripcion del programa
		 * @access public
		 * @return string
		 */
		public function getDescripcionProgramaPlanDesarrollo( ){
			return $this->descripcionProgramaPlanDesarrollo;
		}
		
		/**
		 * Modifica el estado del programa
		 * @param string estadoProgramaPlanDesarrollo
		 * @access public
		 */
		public function setEstadoProgramaPlanDesarrollo( $estadoProgramaPlanDesarrollo ){
			$this->estadoProgramaPlanDesarrollo = $estadoProgramaPlanDesarrollo;
		}
		
		/**
		 * Retorna el estado del programa
		 * @access public
		 * @return string
		 */
		public function getEstadoProgramaPlanDesarrollo( ){
			return $this->estadoProgramaPlanDesarrollo;
		}
		
		/**
		 * Modifica el responsable del programa
		 * @param string $responsableProgramaPlanDesarrollo
		 * @access public
		 */
		public function setResponsableProgramaPlanDesarrollo( $responsableProgramaPlanDesarrollo ){
			$this->responsableProgramaPlanDesarrollo = $responsableProgramaPlanDesarrollo;
		}
		
		/**
		 * Retorna el responsable del programa
		 * @access public
		 * @return string
		 */
		public function getResponsableProgramaPlanDesarrollo( ){
			return $this->responsableProgramaPlanDesarrollo;
		}
		
		/**
		 * Modifica Linea Estrategica
		 * @param string $lineaEstrategica
		 * @access public
		 */
		public function setLineaEstrategica( $lineaEstrategica ){
			$this->lineaEstrategica = $lineaEstrategica;
		}
		
		/**
		 * Retorna Linea Estrategica
		 * @access public
		 * @return string
		 */
		public function getLineaEstrategica( ){
			return $this->lineaEstrategica;
		}
		
		/**
		 * Modifica la fecha de creacion del programa
		 * @param datetime fechaCreacion
		 * @access public
		 */
		public function setFechaCreacion( $fechaCreacion ){
			$this->fechaCreacion = $fechaCreacion;
		}
		
		/**
		 * Retorna la fecha de creacion del programa
		 * @access public
		 * @return datetime
		 */
		public function getFechaCreacion( ){
			return $this->fechaCreacion;
		}
		
		/**
		 * Modifica la fecha de modificacion del programa
		 * @param datetime fechaUltimaModificacion
		 * @access public
		 */
		public function setFechaUltimaModificacion( $fechaUltimaModificacion ){
			$this->fechaUltimaModificacion = $fechaUltimaModificacion;
		}
		
		/**
		 * Retorna la fecha de modificacion del programa
		 * @access public
		 * @return datetime
		 */
		public function getFechaUltimaModificacion( ){
			return $this->fechaUltimaModificacion;
		}
		
		/**
		 * Modifica el usuario de creacion del programa
		 * @param int usuarioCreacion
		 * @access public
		 */
		public function setUsuarioCreacion( $usuarioCreacion ){
			$this->usuarioCreacion = $usuarioCreacion;
		}
		
		/**
		 * Retorna usuario de creacion del programa
		 * @access public
		 * @return int
		 */
		public function getUsuarioCreacion( ){
			return $this->usuarioCreacion;
		}
		
		/**
		 * Modifica el usuario de modificacion del programa
		 * @param int usuarioModificacion
		 * @access public
		 */
		public function setUsuarioModificacion( $usuarioModificacion ){
			$this->usuarioModificacion = $usuarioModificacion;
		}
		
		/**
		 * Retorna usuario de modificacion del programa
		 * @access public
		 * @return int
		 */
		public function getUsuarioModificacion( ){
			return $this->usuarioModificacion;
		}
		
		
		/*Modified Diego Rivera<riveradiego@unbosque.edu.co>
		 *Se añaden  get y set  EmailResponsableProgramaPlanDesarrollo
		 *Since April 18
		 * */
		
		
		public function setEmailResponsableProgramaPlanDesarrollo( $emailResponsableProgramaPlanDesarrollo ) {
			
			$this->emailResponsableProgramaPlanDesarrollo = $emailResponsableProgramaPlanDesarrollo;
		}
		
		public function getEmailResponsableProgramaPlanDesarrollo( ) {
			
			return $this->emailResponsableProgramaPlanDesarrollo;
		}
		
		//fin modificacion
		
		/**
		 * Consultar Linea Estrategica
		 * @access public
		 */
		public function consultarProgramas( $variables ){
			$programas = array( );
			$inner='';
			$where = array();
			$params = array();
			//ddd($variables);
			if(!empty($variables->cbmLineaConsulta)){
				//$inner = 'INNER JOIN LineaEstrategicaPrograma lep ON (lep.ProgramaPlanDesarrolloId = pd.ProgramaPlanDesarrolloId)';
				$inner = 'INNER JOIN PlanDesarrolloProgramaLineaEstrategica pdle ON ( pdle.ProgramaPlanDesarrolloId = pd.ProgramaPlanDesarrolloId )';
				$where[] = 'pdle.LineaEstrategicaId = ?';
				$objParam = new stdClass();
				$objParam->value = $variables->cbmLineaConsulta;
				$objParam->text = false;
				$params[0] = $objParam; 
				unset($objParam);
			}
			if(!empty($variables->txtCodigoFacultad)){
				//$inner = 'INNER JOIN LineaEstrategicaPrograma lep ON (lep.ProgramaPlanDesarrolloId = pd.ProgramaPlanDesarrolloId)';
				$inner .= 'INNER JOIN PlanDesarrollo p ON (pdle.PlanDesarrolloId = p.PlanDesarrolloId)';
				$where[] = 'p.CodigoFacultad = ?';
				
				$objParam = new stdClass();
				$objParam->value = $variables->txtCodigoFacultad;
				$objParam->text = false;
				/*if( !empty($variables->cmbCarrera) ){
					$where[] .= ' AND p.CodigoCarrera = ?';
					$objParam->value = $variables->cmbCarrera;
					$objParam->text = false;
				}*/
				$params[1] = $objParam;
				unset($objParam);
				}
				
					/*
					 * @modified Diego Rivera <riveradiego@unbosque.edu.co>
					 * se agrega  opcion de filtro de carrera e where esto afecta  la pagina templates/inicioSeguimientoPlanDesarrollo.php el combo programa
					 * @since  March 08, 2017
					*/
				
				if( !empty($variables->cmbCarrera) && $variables->cmbCarrera != -1 ){
					$where[] .= 'p.CodigoCarrera = ?';
                                        
                                        $objParam = new stdClass();
					$objParam->value = $variables->cmbCarrera;
					$objParam->text = false;
					$params[2] = $objParam;
					unset($objParam);
					
					//fin modificacion
				}else{
					if(!empty($variables->cmbCarrera) && $variables->cmbCarrera == -1){
						//$inner .= 'INNER JOIN PlanDesarrollo p ON (pdle.PlanDesarrolloId = p.PlanDesarrolloId)';
						$where[] = 'p.CodigoCarrera IS NULL';
						
						$objParam = new stdClass();
						$objParam->value = $variables->txtCodigoFacultad;
						$objParam->text = false;
						/*if( !empty($variables->cmbCarrera) ){
							$where[] .= ' AND p.CodigoCarrera = ?';
							$objParam->value = $variables->cmbCarrera;
							$objParam->text = false;
						}*/
						$params[1] = $objParam;
						unset($objParam);
					}
				}
				
			
			
			$where[] = 'pd.EstadoProgramaPlanDesarrollo = 100';
			$sql = "SELECT pd.ProgramaPlanDesarrolloId,
						   pd.NombrePrograma,
						   pd.JustificacionProgramaPlanDesarrollo,
						   pd.EstadoProgramaPlanDesarrollo,
						   pd.FechaCreacion,
						   pd.FechaUltimaModificacion,
						   pd.UsuarioCreacion,
						   pd.UsuarioModificacion,
						   pd.ResponsableProgramaPlanDesarrollo,
						   pd.EmailResponsableProgramaPlanDesarrollo
					  FROM ProgramaPlanDesarrollo pd ";
					  
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
			
			//echo $this->persistencia->getSQLListo( );
			$this->persistencia->ejecutarConsulta(  );
			
			while( $this->persistencia->getNext( ) ){
				$programa = new Programa( $this->persistencia );
				$programa->setIdProgramaPlanDesarrollo( $this->persistencia->getParametro( "ProgramaPlanDesarrolloId" ) );
				$programa->setNombrePrograma( $this->persistencia->getParametro( "NombrePrograma" ) );
				$programa->setJustificacionProgramaPlanDesarrollo( $this->persistencia->getParametro( "JustificacionProgramaPlanDesarrollo" ) );
				$programa->setEstadoProgramaPlanDesarrollo( $this->persistencia->getParametro( "EstadoProgramaPlanDesarrollo" ) );
				$programa->setFechaCreacion( $this->persistencia->getParametro( "FechaCreacion" ) );
				$programa->setFechaUltimaModificacion( $this->persistencia->getParametro( "FechaUltimaModificacion" ) );
				$programa->setUsuarioCreacion( $this->persistencia->getParametro( "UsuarioCreacion" ) );
				$programa->setUsuarioModificacion( $this->persistencia->getParametro( "UsuarioModificacion" ) );
				$programa->setResponsableProgramaPlanDesarrollo( $this->persistencia->getParametro( "ResponsableProgramaPlanDesarrollo" ));
				$programa->setEmailResponsableProgramaPlanDesarrollo($this->persistencia->getParametro( "EmailResponsableProgramaPlanDesarrollo" ));
				
				$programas[] = $programa;
			}
			//d($programas);
			$this->persistencia->freeResult( );
			
			return 	$programas;
		}

		/**
		 * Crear Programa Plan Desarrollo
		 * @access public
		 */
		public function crearPrograma( $idPersona ){
			$sql = "INSERT INTO ProgramaPlanDesarrollo (
						ProgramaPlanDesarrolloId,
						NombrePrograma,
						JustificacionProgramaPlanDesarrollo,
						DescripcionProgramaPlanDesarrollo,
						EstadoProgramaPlanDesarrollo,
						ResponsableProgramaPlanDesarrollo,
						FechaCreacion,
						FechaUltimaModificacion,
						UsuarioCreacion,
						UsuarioModificacion,
						EmailResponsableProgramaPlanDesarrollo
						
					)
					VALUES
						(
							( SELECT IFNULL( MAX( P.ProgramaPlanDesarrolloId ) +1, 1 ) 
							FROM ProgramaPlanDesarrollo P
							 ),
							?,
							?,
							?,
							'100',
							?,
							NOW( ),
							NULL,
							?,
							NULL,
							?
						);";
						
			$this->persistencia->conectar( );
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $this->getNombrePrograma( ) , true );
			$this->persistencia->setParametro( 1 , $this->getJustificacionProgramaPlanDesarrollo( ) , true );
			$this->persistencia->setParametro( 2 , $this->getDescripcionProgramaPlanDesarrollo( ) , true );
			$this->persistencia->setParametro( 3 , $this->getResponsableProgramaPlanDesarrollo( ) , true );
			$this->persistencia->setParametro( 4 , $idPersona , false );
			$this->persistencia->setParametro( 5 , $this->getEmailResponsableProgramaPlanDesarrollo( ),true);
			//echo $this->persistencia->getSQLListo( ); exit( );
			$this->persistencia->ejecutarUpdate(  );
			return true;
		}
		
		/**
		 * Actualizar el programa del Plan Desarrollo
		 * @access public
		 */
		 /*Modified Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
		  *Se adiciona variable $txtEmailPrograma con el fin de actualizar el email del responsable
		  * Since April 19,2017
		  */
		 
		 
		public function actualizarPrograma( $txtActualizaPrograma, $txtActualizaJustificacionPrograma, $txtActualizaDescripcionPrograma, $txtActualizaResponsablePrograma, $idPersona, $txtIdPrograma , $txtEmailPrograma ){
			$sql = "UPDATE ProgramaPlanDesarrollo
					SET 
					 NombrePrograma = ?,
					 JustificacionProgramaPlanDesarrollo = ?,
					 DescripcionProgramaPlanDesarrollo = ?,
					 ResponsableProgramaPlanDesarrollo = ?,
					 FechaUltimaModificacion = NOW( ),
					 UsuarioModificacion = ?,
					 EmailResponsableProgramaPlanDesarrollo = ?
					WHERE ProgramaPlanDesarrolloId = ?;";	
				
			
			$this->persistencia->crearSentenciaSQL( $sql );
		
			$this->persistencia->setParametro( 0 , $txtActualizaPrograma , true );
			$this->persistencia->setParametro( 1 , $txtActualizaJustificacionPrograma , true );
			$this->persistencia->setParametro( 2 , $txtActualizaDescripcionPrograma , true );
			$this->persistencia->setParametro( 3 , $txtActualizaResponsablePrograma , true );
			$this->persistencia->setParametro( 4 , $idPersona , false );
			$this->persistencia->setParametro( 5 , $txtEmailPrograma , true );
			$this->persistencia->setParametro( 6 , $txtIdPrograma , false );
			//echo $this->persistencia->getSQLListo( );
			$estado = $this->persistencia->ejecutarUpdate( );
			
			if( $estado )
				$this->persistencia->confirmarTransaccion( );
			else	
				$this->persistencia->cancelarTransaccion( );
						
			//$this->persistencia->freeResult( );
			return $estado;
			
			
		}
		
	}	
?>