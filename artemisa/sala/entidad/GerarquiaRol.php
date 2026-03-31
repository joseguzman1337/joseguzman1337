<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @since January 2, 2017
 * @package entidad
*/
defined('_EXEC') or die;
class GerarquiaRol implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type adodb Object
     * @access private
     */
    private $codigogerarquiarol;
    
    /**
     * @type adodb Object
     * @access private
     */
    private $nombregerarquiarol;
    
    public function __construct() {
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getCodigogerarquiarol() {
        return $this->codigogerarquiarol;
    }

    public function getNombregerarquiarol() {
        return $this->nombregerarquiarol;
    }

    public function setCodigogerarquiarol($codigogerarquiarol) {
        $this->codigogerarquiarol = $codigogerarquiarol;
    }

    public function setNombregerarquiarol($nombregerarquiarol) {
        $this->nombregerarquiarol = $nombregerarquiarol;
    }
    
    public function getByCodigo(){
        if(!empty($this->codigogerarquiarol)){
            $query = "SELECT * FROM gerarquiarol "
                    . "WHERE codigogerarquiarol = ".$this->db->qstr($this->codigogerarquiarol);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->nombregerarquiarol = $d['nombregerarquiarol']; 
            }
        }
    }
    
    public static function getListGerarquiaRol($order=null){
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM gerarquiarol ";
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $GerarquiaRol = new GerarquiaRol();
            $GerarquiaRol->codigogerarquiarol = $d['codigogerarquiarol'];
            $GerarquiaRol->nombregerarquiarol = $d['nombregerarquiarol'];
            $return[] = $GerarquiaRol;
            unset($GerarquiaRol);
        }
        return $return;
    }

    public function getById() {
        $this->getByCodigo();
    }

    public static function getList($where) {
        $arrayReturn = array();
        return $arrayReturn;
    }

}
/*/
codigogerarquiarol	char(2)
nombregerarquiarol	varchar(50)
/**/