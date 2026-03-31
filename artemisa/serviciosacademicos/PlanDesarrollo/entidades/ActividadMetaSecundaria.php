<?php
    /**
	 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
	 * @copyright Dirección de Tecnología - Universidad el Bosque
	 * @package entidades
	 */
	
	class ActividadMetaSecundaria{
		
		/**
		 * @type int
		 * @access private
		 */
		private $idActividadMetaSecundaria;
		
		/**
		 * @type MetaSecundaria
		 * @access private
		 */
		private $metaSecundaria;
		
		/**
		 * @type String
		 * @access private
		 */
		private $nombreActividadMetaSecundaria;
		
		/**
		 * @type date
		 * @access private
		 */
		private $fechaActividadMetaSecundaria;
		
		/**
		 * @type string
		 * @access private
		 */
		private $observacionActividad;
		
		/**
		 * @type int
		 * @access private
		 */
		private $estadoActividadMetaSecundaria;
		
		/**
		 * @type date
		 * @access private
		 */
		private $fechaCreacionActividad;
		
		/**
		 * @type date
		 * @access private
		 */
		private $fechaModificacionActividad;
		
		/**
		 * @type int
		 * @access private
		 */
		private $usuarioCreacionActividad;
		
		/**
		 * @type int
		 * @access private
		 */
		private $usuarioModificacionActividad;
		
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		
		/**
		 * Constructor
		 * @param Singleton $persistencia
		 */
		public function ActividadMetaSecundaria( $persistencia ){
			$this->persistencia = $persistencia;
		}
		
		/**
		 * Modifica el identificador de la actividad de la meta secundaria
		 * @param int $idActividadMetaSecundaria
		 * @access public
		 */
		public function setIdActividadMetaSecundaria( $idActividadMetaSecundaria ){
			$this->idActividadMetaSecundaria = $idActividadMetaSecundaria;
		}
		
		/**
		 * Retorna el identificador de la actividad de la meta secundaria
		 * @access public
		 * @return int
		 */
		public function getIdActividadMetaSecundaria( ){
			return $this->idActividadMetaSecundaria;
		}
		
		/**
		 * Modifica la meta secundaria de la actividad
		 * @param MetaSecundaria $metaSecundaria
		 * @access public
		 */
		public function setMetaSecundaria( $metaSecundaria ){
			$this->metaSecundaria = $metaSecundaria;
		}
		
		/**
		 * Retorna la meta secundaria de la actividad
		 * @access public
		 * @return MetaSecundaria
		 */
		public function getMetaSecundaria( ){
			return $this->metaSecundaria;
		}
		
		/**
		 * Modifica el nombre de la actividad
		 * @param string $nombreActividadMetaSecundaria
		 * @access public
		 */
		public function setNombreActividadMetaSecundaria( $nombreActividadMetaSecundaria ){
			$this->nombreActividadMetaSecundaria = $nombreActividadMetaSecundaria;
		}
		
		/**
		 * Retorna el nombre de la actividad
		 * @access public
		 * @return string
		 */
		public function getNombreActividadMetaSecundaria( ){
			return $this->nombreActividadMetaSecundaria;
		}
		
		/**
		 * Modifica la fecha de realización de la actividad
		 * @param date $fechaActividadMetaSecundaria
		 * @access public
		 */
		public function setFechaActividadMetaSecundaria( $fechaActividadMetaSecundaria ){
			$this->fechaActividadMetaSecundaria = $fechaActividadMetaSecundaria;
		}
		
		/**
		 * Retorna la fecha de realización de la actividad
		 * @access public
		 * @return date
		 */
		public function getFechaActividadMetaSecundaria( ){
			return $this->fechaActividadMetaSecundaria;
		}
		
		/**
		 * Modifica la observacion de la actividad
		 * @param date $observacionActividad
		 * @access public
		 */
		public function setObservacionActividad( $observacionActividad ){
			$this->observacionActividad = $observacionActividad;
		}
		
		/**
		 * Retorna la observacion de la actividad
		 * @access public
		 * @return date
		 */
		public function getObservacionActividad( ){
			return $this->observacionActividad;
		} 
		
		/**
		 * Modifica el estado de la actividad de la meta secundaria
		 * @param int $estadoActividadMetaSecundaria
		 * @access public
		 */
		public function setEstadoActividadMetaSecundaria( $estadoActividadMetaSecundaria ){
			$this->estadoActividadMetaSecundaria = $estadoActividadMetaSecundaria;
		}
		
		/**
		 * Retorna el estado de la actividad de la meta secundaria
		 * @access public
		 * @return int
		 */
		public function getEstadoActividadMetaSecundaria( ){
			return $this->estadoActividadMetaSecundaria;
		}
		
		
		/**
		 * Modifica la fecha de creacion de la actividad de la meta secundaria
		 * @param date $fechaCreacionActividad
		 * @access public
		 */
		public function setFechaCreacionActividad( $fechaCreacionActividad ){
			$this->fechaCreacionActividad = $fechaCreacionActividad;
		}
		
		/**
		 * Retorna la fecha de creacion de la actividad de la meta secundaria
		 * @access public
		 * @return date
		 */
		public function getFechaCreacionActividad( ){
			return $this->fechaCreacionActividad;
		}
		
		/**
		 * Modifica la fecha de modificacion de la actividad de la meta secundaria
		 * @param date $fechaModificacionActividad
		 * @access public
		 */
		public function setFechaModificacionActividad( $fechaModificacionActividad ){
			$this->fechaModificacionActividad = $fechaModificacionActividad;
		}
		
		/**
		 * Retorna la fecha de modificacion de la actividad de la meta secundaria
		 * @access public
		 * @return date 
		 */
		public function getFechaModificacionActividad( ){
			return $this->fechaModificacionActividad;
		}
		
		
		/**
		 * Modifica el usuario de creacion de la actividad de la meta secundaria
		 * @param int $usuarioCreacionActividad
		 * @access public
		 */
		public function setUsuarioCreacionActividad( $usuarioCreacionActividad ){
			$this->usuarioCreacionActividad = $usuarioCreacionActividad;
		}
		
		/**
		 * Retorna el usuario de creacion de la actividad de la meta secundaria
		 * @access public
		 * @return int
		 */
		public function getUsuarioCreacionActividad( ){
			return $this->usuarioCreacionActividad;
		}
		
		/**
		 * Modifica el usuario de modificacion de la actividad de la meta secundaria
		 * @param int $usuarioModificacionActividad
		 * @access public
		 */
		public function setUsuarioModificacionActividad( $usuarioModificacionActividad ){
			$this->usuarioModificacionActividad = $usuarioModificacionActividad;
		}
		
		/**
		 * Retorna el usuario de modificación de la actividad de la meta secundaria
		 * @access public
		 * @return int
		 */
		public function getUsuarioModificacionActividad( ){
			return $this->usuarioModificacionActividad;
		}
		
		/**
		 * Registrar Actividad
		 * @access public
		 */
		public function registrarActividad( $idPersona ){
			
			$sql = "INSERT INTO ActividadMetaSecundaria (
						ActividadMetaSecundariaId,
						MetaSecundariaPlanDesarrolloId,
						NombreActividadMetaSecundaria,
						FechaActividadMetaSecundaria,
						EstadoActividadMetaSecundaria,
						FechaCreacion,
						FechaModificacion,
						UsuarioCreacion,
						UsuarioModificacion
					)
					VALUES
						(
							( SELECT IFNULL( MAX( AM.ActividadMetaSecundariaId ) +1, 1 ) 
								FROM ActividadMetaSecundaria AM
							 ),
							?,
							?,
							?,
							'100',
							NOW(),
							NULL,
							?,
							NULL
						);";
			$this->persistencia->conectar( );
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $this->getMetaSecundaria( )->getMetaSecundariaPlanDesarrolloId( ) , false );
			$this->persistencia->setParametro( 1 , $this->getNombreActividadMetaSecundaria( ) , true );
			$this->persistencia->setParametro( 2 , $this->getFechaActividadMetaSecundaria( ) , true );
			$this->persistencia->setParametro( 3 , $idPersona , false );
			//echo $this->persistencia->getSQLListo( ); exit( );
			$this->persistencia->ejecutarUpdate(  );
			return true;
						
		}
		
		/**
		 * Existe Actividad Meta Secundaria
		 * @access public
		 */
		public function existeActividad( $txtIdMetaSecundaria ){
			
			$sql = "SELECT COUNT(A.ActividadMetaSecundariaId) AS cantidad_actividad
					FROM ActividadMetaSecundaria A
					WHERE A.MetaSecundariaPlanDesarrolloId = ?
					AND A.EstadoActividadMetaSecundaria = 100";
		
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $txtIdMetaSecundaria , true );
	
			$this->persistencia->ejecutarConsulta(  );
			$cantidad = 0;
			
			if( $this->persistencia->getNext( ) )
				$cantidad = $this->persistencia->getParametro( "cantidad_actividad" );
			
			$this->persistencia->freeResult( );
			
			return $cantidad;
		}
		
		/**
		 * Actualizar Actividad Meta Secundaria 
		 * @access public
		 */
		public function actualizarActividadMetaSecundaria( $txtNombreActividad, $txtFechaActividad, $idPersona, $txtIdMetaSecundaria ){
			$sql = "UPDATE ActividadMetaSecundaria
					SET 
					 NombreActividadMetaSecundaria = ?,
					 FechaActividadMetaSecundaria = ?,
					 FechaModificacion = NOW( ),
					 UsuarioModificacion = ?
					WHERE MetaSecundariaPlanDesarrolloId = ?";
						
			$this->persistencia->conectar( );
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $txtNombreActividad, true );
			$this->persistencia->setParametro( 1 , $txtFechaActividad, true );
			$this->persistencia->setParametro( 2 , $idPersona, false );
			$this->persistencia->setParametro( 3 , $txtIdMetaSecundaria, false );
			//echo $this->persistencia->getSQLListo( ); exit( );
			$this->persistencia->ejecutarUpdate(  );
			return true;
		}
		
		
		/**
		 * Buscar Actividad Meta Secundaria Id
		 * @access public
		 */
		public function buscarActividadMetaSecundariaId( $txtIdMetaSecundaria ){
			$sql = "SELECT
					A.ActividadMetaSecundariaId, A.NombreActividadMetaSecundaria, A.FechaActividadMetaSecundaria, M.AvanceResponsableMetaSecundaria,
					A.ObservacionSupervisor
				FROM
					ActividadMetaSecundaria A
				INNER JOIN MetaSecundariaPlanDesarrollo M ON ( M.MetaSecundariaPlanDesarrolloId = A.MetaSecundariaPlanDesarrolloId )
				WHERE A.MetaSecundariaPlanDesarrolloId = ?
				AND A.EstadoActividadMetaSecundaria = 100 ";
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $txtIdMetaSecundaria , false );
			//echo $this->persistencia->getSQLListo( ); exit( );
			$this->persistencia->ejecutarConsulta( );
			if( $this->persistencia->getNext( ) ){
				$this->setIdActividadMetaSecundaria( $this->persistencia->getParametro( "ActividadMetaSecundariaId") );
				$this->setNombreActividadMetaSecundaria( $this->persistencia->getParametro( "NombreActividadMetaSecundaria" ) );
				$this->setFechaActividadMetaSecundaria( $this->persistencia->getParametro( "FechaActividadMetaSecundaria" ) );
				$this->setObservacionActividad( $this->persistencia->getParametro( "ObservacionSupervisor" ) );
				
				
				$metaSecundaria = new MetaSecundaria( null );
				$metaSecundaria->setAvanceResponsableMetaSecundaria( $this->persistencia->getParametro( "AvanceResponsableMetaSecundaria" ) ); 
				
				$this->setMetaSecundaria( $metaSecundaria );
 				
				
			}
			
			$this->persistencia->freeResult( );	
			
		}
		
		/**
		 * Actualizar Observacion Actividad 
		 * @access public
		 */
		public function actualizarObservacionActividadMetaSecundaria( $txtObservacionSupervisor, $idPersona, $txtIdActividadMetaSecundaria ){
			$sql = "UPDATE ActividadMetaSecundaria
					SET 
					 ObservacionSupervisor = ?,
					 FechaModificacion = NOW( ),
					 UsuarioModificacion = ?
					WHERE ActividadMetaSecundariaId = ?
					";
						
			$this->persistencia->conectar( );
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $txtObservacionSupervisor, true );
			$this->persistencia->setParametro( 1 , $idPersona, true );
			$this->persistencia->setParametro( 2 , $txtIdActividadMetaSecundaria, false );
			//echo $this->persistencia->getSQLListo( ); exit( );
			$this->persistencia->ejecutarUpdate(  );
			return true;
		}
		
		
	}

?>