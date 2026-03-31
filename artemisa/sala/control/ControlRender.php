<?php
defined('_EXEC') or die;
require_once(PATH_ROOT.'/assets/lib/View.php');
/**
 * Clase ControlRender encargada del proceso de render de todos los elementos
 * del sitio
 * 
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package control
 * @since November 01, 2017
 */
class ControlRender{

    /**
     * Constructor 
     * @author Andres Ariza <arizaandres@unbosque.edu.do>
     * @access public
     * @return void/String
     */
    public function __construct(  ){
    }

    /**
     * Carga la vista que se indique  a traves de las parametros
     * @param String $layout  - Template que se va a cargar
     * @param String $path  - Ruta física del template que va a renderizar
     * @param array $variables  - Array de las variables que se van a utilizar en el template
     * @param boolean $return  - Le indica al metodo si tiene que retornar el render en un String o si lo debe mostrar en pantalla
     * @author Andres Ariza <arizaandres@unbosque.edu.do>
     * @access public 
     * @return void/String
    */
    public function render( $layout, $path, $variables = array(), $return = true ){ 
        if(!empty($path)){
            $path = PATH_SITE.$path;
        }else{
            $path = PATH_SITE;
        }
        $view = new View($layout, $path, $return); 
        foreach($variables as $k => $v){
            $view->assign($k, $v);
        }
        return $view->getResult();
    } 		
}
?>
