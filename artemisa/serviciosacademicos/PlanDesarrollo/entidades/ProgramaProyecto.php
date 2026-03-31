<?php
    /**
	 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
	 * @copyright Dirección de Tecnología Universidad el Bosque
	 * @package entidades 
	 */
	
	class ProgramaProyecto{
		
		/**
		 * @type int
		 * @access private
		 */
		private $idProgramaProyecto;
		
		/**
		 * @type Programa
		 * @access private
		 */
		private $programa;
		
		/**
		 * @type Proyecto
		 * @access private
		 */
		private $proyecto;
		
		/**
		 * @type int
		 * @access private
		 */
		private $estadoProgramaProyecto;
		
		/**
		 * @type date
		 * @access private
		 */
		private $fechaCreacionProgramaProyecto;
		
		/**
		 * @type date
		 * @access private
		 */
		private $fechaModificacionProgramaProyecto;
		
		/**
		 * @type int
		 * @access private
		 */
		private $usuarioCreacionProgramaProyecto;
		
		/**
		 * @type int
		 * @access private
		 */
		private $usuarioModificacionProgramaProyecto;
		
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		/**
		 * Constructor
		 * @param Singleton $persistencia
		 */
		public function ProgramaProyecto( $persistencia ){
			$this->persistencia = $persistencia;
		}
		
		/**
		 * Modifica el identificador del Programa Proyecto
		 * @param int $idProgramaProyecto
		 * @access public
		 */
		public function setIdProgramaProyecto( $idProgramaProyecto ){
			$this->idProgramaProyecto = $idProgramaProyecto;
		}
		
		/**
		 * Retorna el identificador del Programa Proyecto
		 * @access public
		 * @return int
		 */
		public function getIdProgramaProyecto( ){
			return $this->idProgramaProyecto;
		}
		
		
		/**
		 * Modifica el programa del Programa Proyecto
		 * @param Programa $programa
		 * @access public
		 */
		public function setPrograma( $programa ){
			$this->programa = $programa;
		}
		
		/**
		 * Retorna el programa del Programa Proyecto
		 * @access public
		 * @return Programa
		 */
		public function getPrograma( ){
			return $this->programa;
		}
		
		/**
		 * Modifica el proyecto del Programa Proyecto
		 * @param Proyecto $proyecto
		 * @access public
		 */
		public function setProyecto( $proyecto ){
			$this->proyecto = $proyecto;
		}
		
		/**
		 * Retorna el proyecto del Programa Proyecto
		 * @access public
		 * @return Proyecto
		 */
		public function getProyecto( ){
			return $this->proyecto;
		}
		
		/**
		 * Modifica el estado del Programa Proyecto
		 * @param int $estadoProgramaProyecto
		 * @access public
		 */
		public function setEstadoProgramaProyecto( $estadoProgramaProyecto ){
			$this->estadoProgramaProyecto = $estadoProgramaProyecto;
		}
		
		/**
		 * Retorna el estado del Programa Proyecto
		 * @access public
		 * @return int
		 */
		public function getEstadoProgramaProyecto( ){
			return $this->estadoProgramaProyecto;
		}
		
		/**
		 * Modifica la fecha de creacion Programa Proyecto
		 * @param date $fechaCreacionProgramaProyecto
		 * @access public
		 */
		public function setFechaCreacionProgramaProyecto( $fechaCreacionProgramaProyecto ){
			$this->fechaCreacionProgramaProyecto = $fechaCreacionProgramaProyecto;
		}
		
		/**
		 * Retorna la fecha de creacion Programa Proyecto
		 * @access public
		 * @return date
		 */
		public function getFechaCreacionProgramaProyecto( ){
			return $this->fechaCreacionProgramaProyecto;
		}
		
		/**
		 * Modifica la fecha de modificacion Programa Proyecto
		 * @param date $fechaModificacionProgramaProyecto
		 * @access public
		 */
		public function setFechaModificacionProgramaProyecto( $fechaModificacionProgramaProyecto ){
			$this->fechaModificacionProgramaProyecto = $fechaModificacionProgramaProyecto;
		}
		
		/**
		 * Retorna la fecha de modificacion Programa Proyecto
		 * @access public
		 * return date
		 */
		public function getFechaModificacionProgramaProyecto( ){
			return $this->fechaModificacionProgramaProyecto;
		}
		
		/**
		 * Modifica el usuario de creacion del Programa Proyecto
		 * @param int $usuarioCreacionProgramaProyecto
		 * @access public
		 */
		public function setUsuarioCreacionProgramaProyecto( $usuarioCreacionProgramaProyecto ){
			$this->usuarioCreacionProgramaProyecto = $usuarioCreacionProgramaProyecto;
		}
		
		/**
		 * Retorna el usuario de creacion del Programa Proyecto
		 * @access public
		 * @return int
		 */
		public function getUsuarioCreacionProgramaProyecto( ){
			return $this->usuarioCreacionProgramaProyecto;
		}
		
		/**
		 * Modifica el usuario de modificacion del Programa Proyecto
		 * @param int $usuarioModificacionProgramaProyecto
		 * @access public
		 */
		public function setUsuarioModificacionProgramaProyecto( $usuarioModificacionProgramaProyecto ){
			$this->usuarioModificacionProgramaProyecto = $usuarioModificacionProgramaProyecto;
		}
		
		/**
		 * Retorna el usuario de modificacion del Programa Proyecto
		 * @access public
		 * @return int
		 */
		public function getUsuarioModificacionProgramaProyecto( ){
			return $this->usuarioModificacionProgramaProyecto;
		}
		
		/**
		 * Crear Programa Proyecto
		 * @access public
		 */
		public function crearProgramaProyecto( $idPersona ){
			
			$sql = "INSERT INTO ProgramaProyectoPlanDesarrollo (
						ProgramaProyectoPlanDesarrolloId,
						ProgramaPlanDesarrolloId,
						ProyectoPlanDesarrolloId,
						EstadoProgramaProyecto,
						FechaCreacion,
						FechaUltimaModificacion,
						UsuarioCreacion,
						UsuarioModificacion
					)
					VALUES
						(
							( SELECT IFNULL( MAX( PPR.ProgramaProyectoPlanDesarrolloId ) +1, 1 ) 
							FROM ProgramaProyectoPlanDesarrollo PPR
							 ),
							?,
							?,
							'100',
							NOW( ),
							NULL,
							?,
							NULL
						);";
			
			$this->persistencia->conectar( );
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0 , $this->getPrograma( )->getIdProgramaPlanDesarrollo( ) , false );
			$this->persistencia->setParametro( 1 , $this->getProyecto( )->getProyectoPlanDesarrolloId( ) , false );
			$this->persistencia->setParametro( 2 , $idPersona , false );
			//echo $this->persistencia->getSQLListo( );
			$this->persistencia->ejecutarUpdate(  );
			return true;
			
			
		}
		
		
	}
?>