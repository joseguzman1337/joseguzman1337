<?php
    /**
	 * @author Andres Ariza <arizaandres@unbosque.edu.do>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @package control
	 * @since November 2, 2016
	*/
	
	
	require_once('../entidades/GraficaIndicador.php');
	require_once('../entidades/Facultad.php');
	class ControlGraficaIndicador{
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
		public function ControlGraficaIndicador( $persistencia ){
			$this->persistencia = $persistencia;
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