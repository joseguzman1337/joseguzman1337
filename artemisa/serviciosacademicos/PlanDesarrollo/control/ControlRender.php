<?php
    /**
	 * @author Andres Ariza <arizaandres@unbosque.edu.do>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @package control
	 * @since November 10, 2016
	*/
	
	
	require_once('../control/View.php');
	class ControlRender{
		
		/**
		 * Constructor
		 * @param Singleton $persistencia
		 * @access public
		 */
		public function ControlRender(  ){
		}
				
		/**
		 * Carga la vista que se indique
		 * @access public
		 * @return Array<LineaEstrategica>
		*/
		public function render( $path, $variables = array() ){
			$view = new View($path); 
			foreach($variables as $k => $v){
				$view->assign($k, $v);
			} 
    		
		} 		
	}
?>
