<?php
defined('_EXEC') or die;
require_once(PATH_SITE."/entidad/ModulosMenu.php");
/**
 * Clase Defecto es elModelo general del sitio, utilizado para la carga del 
 * template y de variables de entorno general al sitio
 * Implementación de la Interface Model
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package model
 */
class Defecto implements Model{
    
    /**
     * $db es una variable privada, es la contenedora de la instancia singleton 
     * del objeto adodb de conexion a base de datos de sala
     * 
     * @var adodb Object
     * @access private
     */
    private $db;
    
    /**
     * Constructor de la clase Defecto,
     * @param adodb Object $db
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @return void
     */  
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Consulta las y retorna el un array de variables que se utilizan en el render de los componentes
     * @access public
     * @param stdClass $variables
     * @return array
     * @author Andres Ariza <arizaandres@unbosque.edu.do>
     */
    public function getVariables($variables){
        $array = array();
        $renderModulos = $this->getRenderModulos($variables);
        if(!empty($renderModulos)){
            $array = array_merge($array,$renderModulos);
        }
        return $array;
    }
    
    /**
     * Consulta las y retorna un String con el titulo de la seccion
     * @access public
     * @param stdClass $variables
     * @return String
     * @author Andres Ariza <arizaandres@unbosque.edu.do>
     */
    public function getTituloSeccion($option){
        if($option=="dashBoard"){
            return "Sistema de gestión académica en línea - SALA";
        }
    }
    
    /**
     * Consulta las y retorna un arraycon el render de los mosulos asociados
     * al template en el menu seleccionado
     * @access public
     * @param stdClass $variables
     * @return array
     * @author Andres Ariza <arizaandres@unbosque.edu.do>
     */
    public function getRenderModulos($variables){
        //d($variables);
        $option = @$variables->option;
        $task = @$variables->task;
        $tmpl = @$variables->tmpl;
        $itemId = empty($variables->itemId)?0:$variables->itemId;
        $arrayTemplate = array();
        if($option!="login" && $tmpl!="json"){
            $array = array();
            $array['variables'] = $variables;

            $array['task'] = $task;
            $array['option'] = $option;

            $modeloRender = Factory::getRenderInstance();

            $ModulosMenu = ModulosMenu::getListModulosMenu($itemId);
            if(!empty($ModulosMenu)){
                foreach($ModulosMenu as $m){
                    //d($m);
                    $moduloName = $m->getModulo();
                    $modeloClass = ucfirst($moduloName);
                    if(!is_file(PATH_SITE.'/components/'.$moduloName.'/modelo/'.$modeloClass.'.php')){
                        $modeloClass = "Defecto";
                    }
                    require_once (PATH_SITE.'/components/'.$moduloName.'/modelo/'.$modeloClass.'.php');

                    $Modelo = new $modeloClass($this->db);
                    $variablesModelo = $Modelo->getVariables($variables);
                    $array1 = array_merge($array,$variablesModelo);

                    $arrayTemplate[$moduloName] = $modeloRender->render('default',"/components/".$moduloName,$array1, true);
                    unset($array1,$variablesModelo,$Modelo);/**/
                }
            }
        }
        //d($arrayTemplate);
        return $arrayTemplate;
    }
}
