<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package control
 * @since November 01, 2017
 */
defined('_EXEC') or die;
require_once(PATH_ROOT.'/assets/lib/View.php');
class ControlRenderGestionOportunidades{

    /**
     * Constructor 
     * @access public
     */
    public function ControlRenderGestionOportunidades(  ){
    }

    /**
     * Carga la vista que se indique
     * @access public 
    */
    public function render( $layout, $path, $variables = array(), $return = true ){
        $path = PATH_GESTION;
        $view = new View($layout, $path, $return); 
        foreach($variables as $k => $v){
            $view->assign($k, $v);
        }
        return $view->getResult();
    } 		
}
?>