<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package control
 */
defined('_EXEC') or die;
class ControlUserMenu{ 
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type stdObject
     * @access private
     */
    private $variables;
    
    public function __construct($variables) {
        $this->db = Factory::createDbo();
        $this->variables = $variables; 
    }
    
    public function desactivarMenuPulsante(){
        $idUsuario = Factory::getSessionVar('idusuario');
        
        Factory::setCookieVar("disablePulsar_".$idUsuario, true, time() + (86400 * 30 * 5), "/");
        
        echo json_encode(array("s"=>true, "mensaje" => "Pulsar Deshabilitado"));
        exit();
    }
    
}