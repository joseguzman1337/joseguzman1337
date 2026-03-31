<?php
    /**
	 * @author Carlos Alberto suárez Garrido
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @package entidades
	 */
	
	class AspectoClave{
		
		/**
		 * @type int
		 * @access private
		 */
		private $idAspectoClave;
		
		/**
		 * @type String
		 * @access private
		 */
		private $nombreAspectoClave;
		
		/**
		 * @type String
		 * @access private
		 */
		private $descripcionAspectoClave;
		
		/**
		 * @type int
		 * @access private
		 */
		private $estadoAspectoClave;
		
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		
		/**
		 * Constructor
		 * @param $persistencia Singleton
		 */
		public function AspectoClave( $persistencia ){
			$this->persistencia = $persistencia;
		}
		
		/**
		 * Modifica el id del Aspecto Clave
		 * @param int $idAspectoClave
		 * @access public
		 * @return void
		 */
		public function setIdAspectoClave( $idAspectoClave ){
			$this->idAspectoClave = $idAspectoClave;
		}
		
		/**
		 * Retorna el id del Aspecto Clave
		 * @access public
		 * @return int
		 */
		public function getIdAspectoClave( ){
			return $this->idAspectoClave;
		}
		
		/**
		 * Modifica el nombre del aspecto clave
		 * @param String $nombreAspectoClave
		 * @access public
		 * @return void 
		 */
		public function setNombreAspectoClave( $nombreAspectoClave ){
			$this->nombreAspectoClave = $nombreAspectoClave;
		}
		
		/**
		 * Retorna el nombre del aspecto clave
		 * @access public
		 * @return String
		 */
		public function getNombreAspectoClave( ){
			return $this->nombreAspectoClave;
		}
		
		/**
		 * Modifica la descripción del aspecto clave
		 * @param String $descripcionAspectoClave
		 * @access public
		 * @return void
		 */
		public function setDescripcionAspectoClave( $descripcionAspectoClave ){
			$this->descripcionAspectoClave = $descripcionAspectoClave;
		}
		
		/**
		 * Retorna la descripcion del aspecto clave
		 * @access oublic
		 * @return String
		 */
		public function getDescripcionAspectoClave( ){
			return $this->descripcionAspectoClave;
		}
		
		/**
		 * Modifica el estado del aspecto clave
		 * @param int $estadoAspectoClave
		 * @access public
		 * @return void
		 */
		public function setEstadoAspectoClave( $estadoAspectoClave ){
			$this->estadoAspectoClave = $estadoAspectoClave;
		}
		
		/**
		 * Retorna el estado del aspecto clave
		 * @access public
		 * @return int
		 */
		public function getEstadoAspectoClave( ){
			return $this->estadoAspectoClave;
		}
		
		
		
	}
?>