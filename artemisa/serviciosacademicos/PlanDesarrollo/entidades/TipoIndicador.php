<?php
    /**
	 * @author Carlos Alberto Suárez Garrido <suarezcarlos@unbosque.edu.co>
	 * @copyright Dirección de Tecnología Universidad el Bosque
	 * @package entidades
	 */
	
	class TipoIndicador{
		
		/**
		 * @type int
		 * @access private
		 */
		private $idTipoIndicador;
		
		/**
		 * @type string
		 * @access private
		 */
		private $nombreTipoIndicador;
		
		/**
		 * @type int
		 * @access private
		 */
		private $valorTipoIndicador;
		
		/**
		 * @type int
		 * @access private
		 */
		private $estadoTipoIndicador;
		
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		/**
		 * Constructor
		 * @param Singleton $persistencia
		 */
		public function TipoIndicador( $persistencia ){
			$this->persistencia = $persistencia;
		}
		
		/**
		 * Modifica el identificador del tipo de indicador
		 * @param int $idTipoIndicador
		 * @access public
		 */
		public function setIdTipoIndicador( $idTipoIndicador ){
			$this->idTipoIndicador = $idTipoIndicador;
		}
		
		/**
		 * Retorna el identificador del tipo indicador
		 * @access pubic
		 * @return int
		 */
		public function getIdTipoIndicador( ){
			return $this->idTipoIndicador;
		}
		
		/**
		 * Modifica el nombre del tipo indicador
		 * @param string $nombreTipoIndicador
		 * @access public
		 */
		public function setNombreTipoIndicador( $nombreTipoIndicador ){
			$this->nombreTipoIndicador = $nombreTipoIndicador;
		}
		
		/**
		 * Retorna el nombre del Tipo Indicador
		 * @access public
		 * @return string
		 */
		public function getNombreTipoIndicador( ){
			return $this->nombreTipoIndicador;
		}
		
		/**
		 * Modifica el valor del Tipo Indicador
		 * @param string $valorTipoIndicador
		 * @access public
		 */
		public function setValorTipoIndicador( $valorTipoIndicador ){
			$this->valorTipoIndicador = $valorTipoIndicador;
		}
		
		/**
		 * Retorna el valor del Tipo Indicador
		 * @access public
		 * @return string
		 */
		public function getValorTipoIndicador( ){
			return $this->valorTipoIndicador;
		}
		
		/**
		 * Modifica el estado del Tipo Indicador
		 * @param int $estadoTipoIndicador
		 * @access public
		 */
		public function setEstadoTipoIndicador( $estadoTipoIndicador ){
			$this->estadoTipoIndicador = $estadoTipoIndicador;
		}
		
		/**
		 * Retorna el estado del Tipo Indicador
		 * @access public
		 * @return int 
		 */
		public function getEstadoTipoIndicador( ){
			return $this->estadoTipoIndicador;
		}
		
		/**
		 * Consultar Tipo Indicador
		 * @access public
		 */
		public function consultarTipoIndicador( ){
			$tipoIndicadores = array( );
			$sql = "SELECT
						TipoIndicadorId, NombreTipoIndicador
					FROM
						TipoIndicador
						WHERE EstadoTipoIndicador = 100";
			$this->persistencia->crearSentenciaSQL( $sql );
			//echo $this->persistencia->getSQLListo( );
			$this->persistencia->ejecutarConsulta(  );
			while( $this->persistencia->getNext( ) ){
				$tipoIndicador = new TipoIndicador( $this->persistencia );
				$tipoIndicador->setIdTipoIndicador( $this->persistencia->getParametro( "TipoIndicadorId" ) );
				$tipoIndicador->setNombreTipoIndicador( $this->persistencia ->getParametro( "NombreTipoIndicador" ) ); 
				
				$tipoIndicadores[ count( $tipoIndicadores ) ] = $tipoIndicador;
			}
			$this->persistencia->freeResult( );
			
			return 	$tipoIndicadores;
		}
		
		/**
		 * Consultar Tipo Indicador
		 * @access public
		 */
		public function consultarNombreTipoIndicador( $tipoIndicadorId ){
			$tipoIndicadores = array( );
			$sql = "SELECT
						 NombreTipoIndicador
					FROM
						TipoIndicador
						WHERE EstadoTipoIndicador = 100 
						AND TipoIndicadorId = ? ";
			$this->persistencia->crearSentenciaSQL( $sql );
			$this->persistencia->setParametro( 0, $tipoIndicadorId, false );
			//ddd($this->persistencia->getSQLListo( ));
			$this->persistencia->ejecutarConsulta(  );
			while( $this->persistencia->getNext( ) ){ 
				$this->setNombreTipoIndicador( $this->persistencia ->getParametro( "NombreTipoIndicador" ) );
			}
			//$this->persistencia->freeResult( ); 
		}
		
	}
?>