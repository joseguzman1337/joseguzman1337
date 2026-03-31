<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class Estado implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    
    /**
     * @type char
     * @access private
     */
    private $codigoestado;
    
    /**
     * @type varchar
     * @access private
     */
    private $nombreestado;
    
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    function getCodigoestado() {
        return $this->codigoestado;
    }

    function getNombreestado() {
        return $this->nombreestado;
    }

    function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    function setNombreestado($nombreestado) {
        $this->nombreestado = $nombreestado;
    }
    
    public function getById() {
        if(!empty($this->codigoestado)){
            $query = "SELECT * FROM estado"
                    ." WHERE codigoestado = ".$this->db->qstr($this->codigoestado);
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->nombreestado = $d['nombreestado'];
            }  
        }
    }

    public static function getList( $where = null){
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM estado ";
        if(!empty($where)){
            $query .= " WHERE ".$where;
         }
        $datos = $db->Execute($query);
        
        while($d = $datos->FetchRow()){
            $Estado = new Estado();
            
            $Estado->codigoestado = $d["codigoestado"];
            $Estado->nombreestado = $d["nombreestado"];
            
            $return[] = $Estado;
            unset($MenuOpcion);
        }
        return $return;
    }

}
/*/

`codigoestado` char(3) NOT NULL DEFAULT '',
  `nombreestado` varchar(50) NOT NULL DEFAULT '',
/**/