<?php
/** 
 * @author vega Gabriel <vegagabriel@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package modelo
*/
defined('_EXEC') or die;
require_once(PATH_SITE."/entidad/StreamingActividadesBienestar.php");
class moduloStreamingActividadesBienestar implements Model{
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
            $array['test'] = "Url's Actividades Bienestar";
            $StreamingActividadesBienestar = StreamingActividadesBienestar::getList();
            $array['StreamingActividadesBienestar'] = $StreamingActividadesBienestar;
//            $array['tmpl'] = @$variables->tmpl;
        }elseif($variables->layout=="createEdit"){
            $array["StreamingActividadBienestar"] = new StreamingActividadesBienestar();
            if(!empty($variables->id)){
                $array["StreamingActividadBienestar"]->setDb();
                $array["StreamingActividadBienestar"]->setId($variables->id);
                $array["StreamingActividadBienestar"]->getById();
            }
        }
         
        return $array;
    }
}
