<?php
/** 
 * @author vega Gabriel <vegagabriel@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package modelo
*/
defined('_EXEC') or die;
require_once(PATH_SITE."/entidad/NotificacionesApp.php");
class ModuloNotificacionesApp implements Model{
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
            $array['test'] = "Administracion Notificaciones";
            $NotificacionesApp = NotificacionesApp::getList();
            $array['NotificacionesApp'] = $NotificacionesApp;
//            $array['tmpl'] = @$variables->tmpl;
        }elseif($variables->layout=="createEdit"){
            $array["NotificacionApp"] = new NotificacionesApp();
            if(!empty($variables->id)){
                $array["NotificacionApp"]->setDb();
                $array["NotificacionApp"]->setId($variables->id);
                $array["NotificacionApp"]->getById();
            }
        }
         
        return $array;
    }
}
