<?php
    /**
	 * @author Carlos Alberto Suárez Garrido
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @package control
	 */
	
	include '../entidades/LineaEstrategica.php';
	require_once('../entidades/Facultad.php');
	class ControlLineaEstrategica{
		
		
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		/**
		 * Constructor
		 * @param Singleton $persistencia
		 * @access public
		 */
		public function ControlLineaEstrategica( $persistencia ){
			$this->persistencia = $persistencia;
		}
		
		/**
		 * Consulta las Lineas Estrategicas
		 * @access public
		 * @return Array<LineaEstrategica>
		 */
		public function consultarLineaEstrategica( ){
			$lineaEstrategica = new LineaEstrategica( $this->persistencia );
			return $lineaEstrategica->consultarLineaEstrategica( );
		}
		
		
		/**
		 * Consulta las Facultades
		 * @access public
		 * @return Array<LineaEstrategica>
		 */
		public function consultarFacultades(  ){
			$facultad = new Facultad( $this->persistencia );
			return $facultad->consultar(  );
		}
		
		
	}
?>