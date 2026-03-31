<?php
    /**
	 * @author Andres Ariza <arizaandres@unbosque.edu.do>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @package control
	 * @since November 8, 2016
	*/
	
	class Proyecto{
		
		 /**
		 * @type int
		 * @access private
		 */
		private $proyectoPlanDesarrolloId;
		
		 /**
		 * @type string
		 * @access private
		 */
		private $nombreProyectoPlanDesarrollo;
		
		 /**
		 * @type Int
		 * @access private
		 */
		private $estadoProyectoPlanDesarrollo;
		
		 /**
		 * @type string
		 * @access private
		 */
		private $justificacionProyecto;
		
		/**
		 * @type string
		 * @access private
		 */
		private $descripcionProyecto;
		
		/**
		 * @type string
		 * @access private
		 */
		private $objetivoProyecto;
		
		 /**
		 * @type string
		 * @access private
		 */
		private $accionProyecto;
		
		/**
		 * @type string
		 * @access private
		 */
		private $responsableProyecto;
		
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
		
		private $EmailResponsableProyecto;
		 
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		/**
		 * Constructor
		 * @param Singleton $persistencia
		 */
		public function Proyecto( $persistencia ){ 
			$this->persistencia = $persistencia;
		}
		
		
		/**
		 * Modifica el id del proyecto
		 * @param int $proyectoPlanDesarrolloId
		 * @access public
		 * @return void
		 */
		public function setProyectoPlanDesarrolloId( $proyectoPlanDesarrolloId ){
			$this->proyectoPlanDesarrolloId = $proyectoPlanDesarrolloId;
		}
		
		/**
		 * Retorna el id del proyecto
		 * @access public
		 * @return int
		 */
		public function getProyectoPlanDesarrolloId( ){
			return $this->proyectoPlanDesarrolloId;
		}
		
		/**
		 * Modifica el nombre del proyecto
		 * @param string $nombreProyectoPlanDesarrollo
		 * @access public
		 * @return void
		 */
		public function setNombreProyectoPlanDesarrollo( $nombreProyectoPlanDesarrollo ){
			$this->nombreProyectoPlanDesarrollo = $nombreProyectoPlanDesarrollo;
		}
		
		/**
		 * Retorna el nombre del proyecto
		 * @access public
		 * @return string
		 */
		public function getNombreProyectoPlanDesarrollo( ){
			return $this->nombreProyectoPlanDesarrollo;
		}
		
		/**
		 * Modifica el estado del proyecto
		 * @param int $estadoProyectoPlanDesarrollo
		 * @access public
		 * @return void
		 */
		public function setEstadoProyectoPlanDesarrollo( $estadoProyectoPlanDesarrollo ){
			$this->estadoProyectoPlanDesarrollo = $estadoProyectoPlanDesarrollo;
		}
		
		/**
		 * Retorna el estado del proyecto
		 * @access public
		 * @return int
		 */
		public function getEstadoProyectoPlanDesarrollo( ){
			return $this->estadoProyectoPlanDesarrollo;
		}
		
		/**
		 * Modifica la justificacion del proyecto
		 * @param string $justificacionProyecto
		 * @access public
		 * @return void
		 */
		public function setJustificacionProyecto( $justificacionProyecto ){
			$this->justificacionProyecto = $justificacionProyecto;
		}
		
		/**
		 * Retorna la justificacion del proyecto
		 * @access public
		 * @return string
		 */
		public function getJustificacionProyecto( ){
			return $this->justificacionProyecto;
		}
		
		/**
		 * Modifica la descripcion del proyecto
		 * @param string $descripcionProyecto
		 * @access public
		 * @return void
		 */
		public function setDescripcionProyecto( $descripcionProyecto ){
			$this->descripcionProyecto = $descripcionProyecto;
		}
		
		/**
		 * Retorna la descripcion del proyecto
		 * @access public
		 * @return string
		 */
		public function getDescripcionProyecto( ){
			return $this->descripcionProyecto;
		}
		
		/**
		 * Modifica el objetivo del proyecto
		 * @param string $objetivoProyecto
		 * @access public
		 * @return void
		 */
		public function setObjetivoProyecto( $objetivoProyecto ){
			$this->objetivoProyecto = $objetivoProyecto;
		}
		
		/**
		 * Retorna el objetivo del proyecto
		 * @access public
		 * @return string
		 */
		public function getObjetivoProyecto( ){
			return $this->objetivoProyecto;
		}
		
		/**
		 * Modifica la accion del proyecto
		 * @param string $accionProyecto
		 * @access public
		 * @return void
		 */
		public function setAccionProyecto( $accionProyecto ){
			$this->accionProyecto = $accionProyecto;
		}
		
		/**
		 * Retorna la accion del proyecto
		 * @access public
		 * @return strin
		 */
		public function getAccionProyecto( ){
			return $this->accionProyecto;
		}
		
		/**
		 * Modifica el responsable del proyecto
		 * @param string $responsableProyecto
		 * @access public
		 */
		public function setResponsableProyecto( $responsableProyecto ){
			$this->responsableProyecto = $responsableProyecto;
		}
		
		/**
		 * Retorna el responsable del proyecto
		 * @access public
		 * @return string
		 */
		public function getResponsableProyecto( ){
			return $this->responsableProyecto;
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
		
		
		public function setEmailResponsableProyecto( $emailResponsableProyecto ) {
			$this->EmailResponsableProyecto = $emailResponsableProyecto;
		}
		
		public function getEmailResponsableProyecto( ) {
			
			return $this->EmailResponsableProyecto;
		}
		
		
		/**
		 * Consultar Proyectos
		 * @access public
		 */
		public function consultarProyectos( $programaConsulta, $proyectoPlanDesarrolloId ){
			
			$proyectos = array( );
			$inner='';
			$where = array();
			$params = array();
			
			if(  !empty($programaConsulta) ){
				$inner = 'INNER JOIN ProgramaProyectoPlanDesarrollo pppd ON (ppd.ProyectoPlanDesarrolloId = pppd.ProyectoPlanDesarrolloId)';
				$where[] = 'pppd.ProgramaPlanDesarrolloId = ?';
				$objParam = new stdClass();
				$objParam->value = $programaConsulta;
				$objParam->text = false;
				$params[0] = $objParam; 
				unset($objParam);
			}
			
			if(  !empty($proyectoPlanDesarrolloId) ){
				//$inner = 'INNER JOIN ProgramaProyectoPlanDesarrollo pppd ON (ppd.ProyectoPlanDesarrolloId = pppd.ProyectoPlanDesarrolloId)';
				$where[] = 'ppd.ProyectoPlanDesarrolloId = ?';
				$objParam = new stdClass();
				$objParam->value = $proyectoPlanDesarrolloId;
				$objParam->text = false; 
				$params[count($where)-1] = $objParam; 
				unset($objParam);
			}
			
			$where[] = 'ppd.EstadoProyectoPlanDesarrollo = 100';
			$sql = "SELECT ppd.ProyectoPlanDesarrolloId,
						   ppd.NombreProyectoPlanDesarrollo,
						   ppd.EstadoProyectoPlanDesarrollo,
						   ppd.JustificacionProyecto,
						   ppd.AccionProyecto,
						   ppd.ResponsableProyecto,
						   ppd.FechaCreacion,
						   ppd.FechaUltimaModificacion,
						   ppd.UsuarioCreacion,
						   ppd.UsuarioModificacion,
						   ppd.EmailResponsableProyecto
					  FROM ProyectoPlanDesarrollo ppd ";
					  
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
				$proyecto = new Proyecto( $this->persistencia );
				$proyecto->setProyectoPlanDesarrolloId( $this->persistencia->getParametro( "ProyectoPlanDesarrolloId" ) );
				$proyecto->setNombreProyectoPlanDesarrollo( $this->persistencia->getParametro( "NombreProyectoPlanDesarrollo" ) );
				$proyecto->setEstadoProyectoPlanDesarrollo( $this->persistencia->getParametro( "EstadoProyectoPlanDesarrollo" ) );
				$proyecto->setJustificacionProyecto( $this->persistencia->getParametro( "JustificacionProyecto" ) );
				$proyecto->setAccionProyecto( $this->persistencia->getParametro( "AccionProyecto" ) );
				$proyecto->setResponsableProyecto( $this->persistencia->getParametro( "ResponsableProyecto" ) );
				$proyecto->setFechaCreacion( $this->persistencia->getParametro( "FechaCreacion" ) );
				$proyecto->setFechaUltimaModificacion( $this->persistencia->getParametro( "FechaUltimaModificacion" ) );
				$proyecto->setUsuarioCreacion( $this->persistencia->getParametro( "UsuarioCreacion" ) );
				$proyecto->setUsuarioModificacion( $this->persistencia->getParametro( "UsuarioModificacion" ) );
				$proyecto->setEmailResponsableProyecto( $this->persistencia->getParametro( "EmailResponsableProyecto" ) );
				
				
				$proyectos[] = $proyecto;
			}
			$this->persistencia->freeResult( );
			
			return 	$proyectos;/**/
		}


		/**
		 * Crear Proyecto Plan Desarrollo
		 * @access public
		 */
		public function crearProyecto( $idPersona ){
			$sql = "INSERT INTO ProyectoPlanDesarrollo (
						ProyectoPlanDesarrolloId,
						NombreProyectoPlanDesarrollo,
						EstadoProyectoPlanDesarrollo,
						JustificacionProyecto,
						DescripcionProyectoPlanDesarrollo,
						ObjetivoProyectoPlanDesarrollo,
						AccionProyecto,
						ResponsableProyecto,
						FechaCreacion,
						FechaUltimaModificacion,
						UsuarioCreacion,
						UsuarioModificacion,
						EmailResponsableProyecto
					)
					VALUES
						(	( SELECT IFNULL( MAX( PR.ProyectoPlanDesarrolloId ) +1, 1 ) 
							FROM ProyectoPlanDesarrollo PR
							 ),
							?,
							'100',
							?,
							?,
							?,
							?,
							?,
							NOW( ),
							NULL,
							?,
							NULL,
							?
						);";
						
			$this->persistencia->conectar( );
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $this->getNombreProyectoPlanDesarrollo( ) , true );
			$this->persistencia->setParametro( 1 , $this->getJustificacionProyecto( ) , true );
			$this->persistencia->setParametro( 2 , $this->getDescripcionProyecto( ) , true );
			$this->persistencia->setParametro( 3 , $this->getObjetivoProyecto( ) , true );
			$this->persistencia->setParametro( 4 , $this->getAccionProyecto( ) , true );
			$this->persistencia->setParametro( 5 , $this->getResponsableProyecto( ) , true );
			$this->persistencia->setParametro( 6 , $idPersona , false );
			$this->persistencia->setParametro( 7 , $this->getEmailResponsableProyecto( ) , true );
			//echo $this->persistencia->getSQLListo( );
			$this->persistencia->ejecutarUpdate(  );
			return true;
		}
		
		
		/**
		 * Actualizar el proyecto del Plan Desarrollo
		 * @access public
		 */
		 
		 /*Modified Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
		  *Se adiciona variable $emailProyecto  con el fin de actualizar el email del responsable
		  * Since April 19,2017
		  */
		 
		public function actualizarProyecto( $txtActualizaProyecto, $txtActualizaJustificacionProyecto, $txtActualizaDescripcionProyecto, $txtActualizaObjetivoProyecto, $txtActualizaAccionProyecto, $txtActualizaResponsableProyecto, $idPersona, $txtIdProyecto , $emailProyecto ){
			$sql = "UPDATE ProyectoPlanDesarrollo
					SET 
					 NombreProyectoPlanDesarrollo = ?,
					 JustificacionProyecto = ?,
					 DescripcionProyectoPlanDesarrollo = ?,
					 ObjetivoProyectoPlanDesarrollo = ?,
					 AccionProyecto = ?,
					 ResponsableProyecto = ?,
					 FechaUltimaModificacion = NOW(),
					 UsuarioModificacion = ?,
					 EmailResponsableProyecto = ?
					WHERE
					ProyectoPlanDesarrolloId = ?;";	
				
			
			$this->persistencia->crearSentenciaSQL( $sql );
		
			$this->persistencia->setParametro( 0 , $txtActualizaProyecto , true );
			$this->persistencia->setParametro( 1 , $txtActualizaJustificacionProyecto , true );
			$this->persistencia->setParametro( 2 , $txtActualizaDescripcionProyecto , true );
			$this->persistencia->setParametro( 3 , $txtActualizaObjetivoProyecto , true );
			$this->persistencia->setParametro( 4 , $txtActualizaAccionProyecto , true );
			$this->persistencia->setParametro( 5 , $txtActualizaResponsableProyecto , true );
			$this->persistencia->setParametro( 6 , $idPersona , false );
			$this->persistencia->setParametro( 7 , $emailProyecto , true );
			$this->persistencia->setParametro( 8 , $txtIdProyecto , false );
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