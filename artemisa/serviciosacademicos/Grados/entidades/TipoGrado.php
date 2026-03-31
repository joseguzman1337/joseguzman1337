<?php
    /**
	 * @author Carlos Alberto Suarez Garrido <suarezcarlos@unbosque.edu.co>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @package entidades
	 */
	
	class TipoGrado{
		
		/**
		 * @type int
		 * @access private
		 */
		private $idTipoGrado;
		
		/**
		 * @type String
		 * @access private
		 */
		private $nombreTipoGrado;
		
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		/**
		 * Constructor
		 * @param Singleton
		 */
		public function TipoGrado( $persistencia ){
			$this->persistencia = $persistencia;
		}
		
		/**
		 * Modifica el identificador del tipo de grado
		 * @param int $idTipoGrado
		 * @access public
		 * @return void
		 */
		public function setIdTipoGrado( $idTipoGrado ){
			$this->idTipoGrado = $idTipoGrado;
		}
		
		/**
		 * Retorna el identificador del tipo de grado
		 * @access public
		 * @return int
		 */
		public function getIdTipoGrado( ){
			return $this->idTipoGrado;
		}
		
		/**
		 * Modifica el nombre del tipo de grado
		 * @param String $nombreTipoGrado
		 * @access public
		 * @return void
		 */
		public function setNombreTipoGrado( $nombreTipoGrado ){
			$this->nombreTipoGrado = $nombreTipoGrado;
		}
		
		/**
		 * Retorna el nombre del tipo de grado
		 * @access public
		 * @return string
		 */
		public function getNombreTipoGrado( ){
			return $this->nombreTipoGrado;
		}
		
		/**
		 * Consultar Tipo de Grado
		 * @access public
		 * @return Array
		 */
		public function consultar( ){
				
			$tipoGrados = array( );
			$sql = "SELECT idtipogrado, nombretipogrado 
					FROM tipogrado";
			
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->ejecutarConsulta( );
			while( $this->persistencia->getNext( ) ){
				$tipoGrado = new TipoGrado( null );
				$tipoGrado->setIdTipoGrado( $this->persistencia->getParametro( "idtipogrado" ) );
				$tipoGrado->setNombreTipoGrado( $this->persistencia->getParametro( "nombretipogrado" ) );
					
				
				$tipoGrados[ count( $tipoGrados ) ] = $tipoGrado;
			}
			return $tipoGrados;
			}
	}
?>