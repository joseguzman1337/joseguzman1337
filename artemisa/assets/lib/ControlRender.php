<?php
    /**
	 * @author Andres Ariza <arizaandres@unbosque.edu.do>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @package control
	 * @since marzo 03, 2016
	*/
	
	//echo dirname(__FILE__);
	require_once(dirname(__FILE__).'/View.php');
	class ControlRender{
		private $root ; 
		/**
		 * Constructor
		 * @access public
		 */
		public function ControlRender( $root=null ){
			$this->root = $root;
		}
				
		/**
		 * Carga la vista que se indique
		 * @access public 
		*/
		public function render( $path, $variables = array() ){
			$view = new View($path, $this->root); 
			foreach($variables as $k => $v){
				$view->assign($k, $v);
			} 
    		
		} 		
	}
?>
