<?php 
/**
 * @author vega Gabriel <vegagabriel@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package modelo
*/
defined('_EXEC') or die;
require_once(PATH_SITE."/entidad/ActividadesBienestar.php");
class ModuloActividadesBienestar implements Model{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function getVariables($variables){
        $array = array();
        if(empty($variables->layout)){
            $array['test'] = "Actividades Bienestar";
            $ActividadesBienestar = ActividadesBienestar::getList();
            $array['ActividadesBienestar'] = $ActividadesBienestar;
//            $array['tmpl'] = @$variables->tmpl;
        }elseif($variables->layout=="createEdit"){
            $array["ActividadBienestar"] = new ActividadesBienestar();
            if(!empty($variables->id)){
                $array["ActividadBienestar"]->setDb();
                $array["ActividadBienestar"]->setId($variables->id);
                $array["ActividadBienestar"]->getById();
            }
        }
         
        return $array;
    }
}
