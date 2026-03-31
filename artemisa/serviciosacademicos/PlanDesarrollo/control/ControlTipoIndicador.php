<?php
   /**
    * @author Carlos Alberto Suárez Garrido <suarezcarlos@unbosque.edu.co>
    * @copyright Dirección de Tecnología Universidad el Bosque
    * @package control
    */
   include '../entidades/TipoIndicador.php';
   
   class ControlTipoIndicador{
   	
		/**
		 * @type Singleton
		 * @access private
		 */
		private $persistencia;
		
		/**
		 * Constructor
		 * @param Singleton $persistencia 
		 */
		public function ControlTipoIndicador( $persistencia ){
			$this->persistencia = $persistencia;
		}
		
		/**
		 * Consulta los Tipos de Indicadores
		 * @access public
		 * @return Array<TipoIndicador>
		 */
		public function consultarTipoIndicadores( ){
			$tipoIndicador = new TipoIndicador( $this->persistencia );
			return $tipoIndicador->consultarTipoIndicador( );ca( );
		}
	
	
   }
?>