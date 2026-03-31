<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VistaController
 *
 * @author proyecto_mgi_cp
 */
class VistaController {
    private static $instance = NULL;
    
    private $contentPages = array(
        'index' => array('name'=>'./factores/index.php', 'controller'=>'Factores'),
        'factores' => array('name'=>'./factores/index.php', 'controller'=>'Factores'),
        'caracteristicas' => array('name'=>'./factores/caracteristicas.php', 'controller'=>'Factores'),
        'indicadores' => array('name'=>'./factores/indicadores.php', 'controller'=>'Factores'),
        'encuestas' => array('name'=>'./encuestas/index.php', 'controller'=>'Encuestas'),
        'detalleEncuesta' => array('name'=>'./encuestas/detalleEncuesta.php', 'controller'=>'Encuestas'),
        'tablas_maestras' => array('name'=>'./tablas/index.php', 'controller'=>'Tablas')        
    );
    
    private function __construct() {
        
    }
	
    public static function getInstance() {
	if(!isset(self::$instance)) {
	  self::$instance = new VistaController();
	}
	return self::$instance;
    }
    
    public function render($page) {  
        $name = $this->contentPages[$page]['controller'];
        VistaController::load_controller($name);
        $name = $name."Controller";
        $controller = new $name;
        $title = $controller->title;
        
        $html = file_get_contents('./templates/layout.php');
        $result = str_replace('{PAGE_TITLE}', $title, $html);
        
        //Este es para que me interprete el php porque con el otro metodo no lo hace
         ob_start();
            include $this->contentPages[$page]['name'];
            $html_content = ob_get_contents();
        ob_end_clean(); 
        $result = str_replace('{PAGE_CONTENT}', $html_content, $result);
        echo $result;
    }
    
    public function renderPartial($page) {  
        $name = $this->contentPages[$page]['controller'];
        VistaController::load_controller($name);
        $name = $name."Controller";
        $controller = new $name;
        
        //Este es para que me interprete el php porque con el otro metodo no lo hace
         ob_start();
            include $this->contentPages[$page]['name'];
            $html_content = ob_get_contents();
        ob_end_clean(); 
        echo $html_content;
    }
    
    public static function load_controller($name) {
    $controller_path = APP_PATH . $name . 'Controller.php';
    if( file_exists($controller_path) )
      include_once $controller_path;
    else
      die('The file <strong>' . $name . 'Controller.php</strong> could not be found at <pre>' . $controller_path . '</pre>');
  }
    
    
    function __destruct() {
        
    }
}

?>
