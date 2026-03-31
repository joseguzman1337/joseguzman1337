<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package control
 * @since November 01, 2017
 */


require_once(PATH_ROOT.'/assets/lib/View.php');
class ControlRender{

    /**
     * Constructor 
     * @access public
     */
    public function ControlRender(  ){
    }

    /**
     * Carga la vista que se indique
     * @access public 
    */
    public function render( $path, $variables = array() ){
        $view = new View($path, PATH_ROOT."/serviciosacademicos/PIR",true); 
        foreach($variables as $k => $v){
            $view->assign($k, $v);
        }
        
        return $view->getResult();
    } 		
}
?>
