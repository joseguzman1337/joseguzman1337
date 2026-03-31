<?php
    /**
	 * @author Andres Ariza <arizaandres@unbosque.edu.do>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @package control
	 * @since November 2, 2016
	*/
	
	class GraficaIndicador{ 
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		/**
		 * Constructor
		 * @param Singleton $persistencia
		 */
		public function GraficaIndicador( $persistencia ){
			$this->persistencia = $persistencia;
		}
	}
?>