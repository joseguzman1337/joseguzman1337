<?php
    /**
	 * @author Carlos Alberto Suarez Garrido
	 * @copyright Dirección de Tecnología Universidad el Bosque
	 * @package entidades
	 */
	
	class EscalaValor{
		
		/**
		 * @type int
		 * @access private
		 */
		private $idEscalaValor;
		
		/**
		 * @type string
		 * @access private
		 */
		private $rango;
		
		/**
		 * @type string
		 * @access private
		 */
		private $descripcionEscala;
		
		/**
		 * @type string
		 * @access private
		 */
		private $imagenEscala;
		
		/**
		 * @type int
		 * @access private
		 */
		private $estadoEscala;
		
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		/**
		 * Constructor
		 * @param Singleton $persistencia 
		 */
		public function EscalaValor( $persistencia ){
			$this->persistencia = $persistencia;
		}
		
		/**
		 * Modifica el identificador de la escala valor
		 * @param int $idEscalaValor
		 * @access public
		 */
		public function setIdEscalaValor( $idEscalaValor ){
			$this->idEscalaValor = $idEscalaValor;
		}
		
		/**
		 * Retorna el identificador de la escala valor
		 * @access public
		 * @return int
		 */
		public function getIdEscalaValor( ){
			return $this->idEscalaValor;
		}
		
		/**
		 * Modifica el rango de la escala valor
		 * @param string $rango
		 * @access public
		 */
		public function setRango( $rango ){
			$this->rango = $rango;
		}
		
		/**
		 * Retorna el rango de la escala valor
		 * @access public
		 * @return string
		 */
		public function getRango( ){
			return $this->rango;
		}
		
		/**
		 * Modifica la descripcion de la escala valor
		 * @param string $descripcionEscala
		 * @access public
		 */
		public function setDescripcionEscala( $descripcionEscala ){
			$this->descripcionEscala = $descripcionEscala;
		}
		
		/**
		 * Retorna la descripcion de la escala valor
		 * @access public
		 * @return string
		 */
		public function getDescripcionEscala( ){
			return $this->descripcionEscala;
		}
		
		/**
		 * Modifica la imagen de la escala valor
		 * @param string $imagenEscala
		 * @access public
		 */
		public function setImagenEscala( $imagenEscala ){
			$this->imagenEscala = $imagenEscala;
		}
		
		/**
		 * Retorna la imagen de la escala valor
		 * @access public
		 * @return string
		 */
		public function getImagenEscala( ){
			return $this->imagenEscala;
		}
		
		/**
		 * Modifica el estado de la escala valor
		 * @param int $estadoEscala
		 * @access public
		 */
		public function setEstadoEscala( $estadoEscala ){
			$this->estadoEscala = $estadoEscala;
		}
		
		/**
		 * Retorna el estado de la escala valor
		 * @access public
		 */
		public function getEstadoEscala( ){
			return $this->estadoEscala;
		}
		
	}
?>