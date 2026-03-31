<?php
    /**
	 * @author Carlos Alberto Suárez Garrido
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @package entidades
	 */
	
	class LineaEstrategica{
		
		/**
		 * @type int
		 * @access private
		 */
		private $idLineaEstrategica;
		
		/**
		 * @type String
		 * @access private
		 */
		private $nombreLineaEstrategica;
		
		/**
		 * @type String
		 * @access private
		 */
		private $descripcionLineaEstrategica;
		
		/**
		 * @type int
		 * @access private
		 */
		private $estadoLineaEstrategica;
		
		/**
		 * @type AspectoClave
		 * @access private
		 */
		private $aspectoClave;
		
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		/**
		 * Constructor
		 * @param Singleton $persistencia
		 */
		public function LineaEstrategica( $persistencia ){
			$this->persistencia = $persistencia;
		}
		
		/**
		 * Modifica el id de la Linea Estrategica
		 * @param int $idLineaEstrategica
		 * @access public
		 */
		public function setIdLineaEstrategica( $idLineaEstrategica ){
			$this->idLineaEstrategica = $idLineaEstrategica;
		}
		
		/**
		 * Retorna el id de la Linea Estrategica
		 * @access public
		 * @return int
		 */
		public function getIdLineaEstrategica( ){
			return $this->idLineaEstrategica;
		}
		
		/**
		 * Modifica el nombre de la linea estrategica
		 * @param String $nombreLineaEstrategica
		 * @access public
		 */
		public function setNombreLineaEstrategica( $nombreLineaEstrategica ){
			$this->nombreLineaEstrategica = $nombreLineaEstrategica;
		}
		
		/**
		 * Retorna el nombre de la Linea Estrategica
		 * @access public
		 * @return string
		 */
		public function getNombreLineaEstrategica( ){
			return $this->nombreLineaEstrategica;
		}
		
		/**
		 * Modifica la descripcion de la linea estrategica
		 * @param String $descripcionLineaEstrategica
		 * @access public
		 */
		public function setDescripcionLineaEstrategica( $descripcionLineaEstrategica ){
			$this->descripcionLineaEstrategica = $descripcionLineaEstrategica;
		}
		
		/**
		 * Retorna la descripcion de la linea estrategica
		 * @access public
		 * @return string
		 */
		public function getDescripcionLineaEstrategica( ){
			return $this->descripcionLineaEstrategica;
		}
		
		/**
		 * Modifica el estado de la linea estrategica
		 * @param int $estadoLineaEstrategica
		 * @access public
		 */
		public function setEstadoLineaEstrategica( $estadoLineaEstrategica ){
			$this->estadoLineaEstrategica = $estadoLineaEstrategica;
		}
		
		/**
		 * Retorna el estado de la linea estrategica
		 * @access pubic
		 * @return int
		 */
		public function getEstadoLineaEstrategica( ){
			return $this->estadoLineaEstrategica;
		}
		
		/**
		 * Modifica el Aspecto Clave de la Linea Estrategica
		 * @param AspectoClave $aspectoClave
		 * @access public
		 */
		public function setAspectoClave( $aspectoClave ){
			$this->aspectoClave = $aspectoClave;
		}
		
		/**
		 * Retorna el Aspecto Clave de la Linea Estrategica
		 * @access public
		 * @return AspectoClave
		 */
		public function getAspectoClave( ){
			return $this->aspectoClave;
		}
		
		/**
		 * Consultar Linea Estrategica
		 * @access public
		 */
		public function consultarLineaEstrategica( ){
			$lineaEstrategicas = array( );
			$sql = "SELECT
						LineaEstrategicaId,
						NombreLineaEstrategica,
						DescripcionLineaEstrategica,
						EstadoLineaEstrategica
					FROM
						LineaEstrategica
						WHERE EstadoLineaEstrategica = 100";
			$this->persistencia->crearSentenciaSQL( $sql );
			//echo $this->persistencia->getSQLListo( );
			$this->persistencia->ejecutarConsulta( );
			while( $this->persistencia->getNext( ) ){
				$lineaEstrategica = new LineaEstrategica( $this->persistencia );
				$lineaEstrategica->setIdLineaEstrategica( $this->persistencia->getParametro( "LineaEstrategicaId" ) );
				$lineaEstrategica->setNombreLineaEstrategica( $this->persistencia->getParametro( "NombreLineaEstrategica" ) );
				$lineaEstrategica->setDescripcionLineaEstrategica( $this->persistencia->getParametro( "DescripcionLineaEstrategica" ) );
				$lineaEstrategica->setEstadoLineaEstrategica( $this->persistencia->getParametro( "EstadoLineaEstrategica" ) );
				
				$lineaEstrategicas[count( $lineaEstrategicas )] = $lineaEstrategica;
			}
			$this->persistencia->freeResult( );
			
			return 	$lineaEstrategicas;
		}
		
		
		
	}
?>