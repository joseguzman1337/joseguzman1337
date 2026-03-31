<?php
/** 
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad 
*/
defined('_EXEC') or die;
class EstadoPeriodo implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type char
     * @access private
     */
    private $codigoestadoperiodo;
    
    /**
     * @type char
     * @access private
     */
    private $nombreestadoperiodo;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getCodigoestadoperiodo() {
        return $this->codigoestadoperiodo;
    }

    public function getNombreestadoperiodo() {
        return $this->nombreestadoperiodo;
    }

    public function setCodigoestadoperiodo($codigoestadoperiodo) {
        $this->codigoestadoperiodo = $codigoestadoperiodo;
    }

    public function setNombreestadoperiodo($nombreestadoperiodo) {
        $this->nombreestadoperiodo = $nombreestadoperiodo;
    }
    
    public function getById(){
        if(!empty($this->codigoestadoperiodo)){
            $query = "SELECT * FROM estadoperiodo "
                    ." WHERE codigoestadoperiodo = ".$this->db->qstr($this->codigoestadoperiodo);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->nombreestadoperiodo = $d['nombreestadoperiodo']; 
            }
        }
    }
    
    public static function getList($where) {
        $db = Factory::createDbo();
        $return = array();
        $query = "SELECT * "
                . " FROM estadoperiodo  "
                . " WHERE 1";

        if (!empty($where)) {
            $query .= " AND " . $where;
        }

        $datos = $db->Execute($query);
        while ($d = $datos->FetchRow()) {
            $estadoperiodo = new EstadoPeriodo();
            $estadoperiodo->codigoestadoperiodo= $d['codigoestadoperiodo'];
            $estadoperiodo->nombreestadoperiodo= $d['nombreestadoperiodo'];
            
            $return[] = $estadoperiodo; 
            unset($estadoperiodo);
        }
        
        return $return;
    }
}
    
/*/
codigoestadoperiodo	char(2)
nombreestadoperiodo	varchar(25)
/**/