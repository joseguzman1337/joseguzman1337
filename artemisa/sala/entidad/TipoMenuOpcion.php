<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class TipoMenuOpcion implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $codigotipomenuopcion;
    
    /**
     * @type varchar
     * @access private
     */
    private $nombretipomenuopcion;
    
    /**
     * @type char
     * @access private
     */
    private $codigoestado;
    
    public function __construct(){
        $this->db = Factory::createDbo();
    }
    
    public function setDb() {
        $this->db = Factory::createDbo();
    }
    
    public function getCodigotipomenuopcion() {
        return $this->codigotipomenuopcion;
    }

    public function getNombretipomenuopcion() {
        return $this->nombretipomenuopcion;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function setCodigotipomenuopcion($codigotipomenuopcion) {
        $this->codigotipomenuopcion = $codigotipomenuopcion;
    }

    public function setNombretipomenuopcion($nombretipomenuopcion) {
        $this->nombretipomenuopcion = $nombretipomenuopcion;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function getTipoMenuOpcionByCodigo(){
        if(!empty($this->codigotipomenuopcion)){
            $query = "SELECT * FROM tipomenuopcion "
                    . "WHERE codigotipomenuopcion = ".$this->db->qstr($this->codigotipomenuopcion);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->nombretipomenuopcion = $d['nombretipomenuopcion'];
                $this->codigoestado = $d['codigoestado'];
            }
        }
    }
    
    public function saveTipoMenuOpcion(){
        $query = "";
        $where = array();
        
        if(empty($this->codigotipomenuopcion)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " codigotipomenuopcion = ".$this->db->qstr($this->codigotipomenuopcion);
        }
        
        $query .= " tipomenuopcion SET "
               . " nombretipomenuopcion = ".$this->db->qstr($this->nombretipomenuopcion).", "
               . " codigoestado = ".$this->db->qstr($this->codigoestado);
        
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }
        
        $this->db->Execute($query);
        
        if(empty($this->codigotipomenuopcion)){
            $this->codigotipomenuopcion = $this->db->insert_Id();
        }
    }
    
    public static function getListTipoMenuOpcion($order=null){
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM tipomenuopcion "
                . " ORDER BY nombretipomenuopcion ";
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $TipoMenuOpcion = new TipoMenuOpcion(); 
            $TipoMenuOpcion->nombretipomenuopcion = $d['nombretipomenuopcion'];
            $TipoMenuOpcion->codigoestado = $d['codigoestado'];
            $TipoMenuOpcion->codigotipomenuopcion = $d['codigotipomenuopcion']; 
            $return[] = $TipoMenuOpcion;
            unset($TipoMenuOpcion);
        }
        return $return;
    }
    
    public function getById() {
        $this->getTipoMenuOpcionByCodigo();
    }

    public static function getList($where) {
        return self::getListTipoMenuOpcion();
    }

}

/*/
codigotipomenuopcion	int(11)
nombretipomenuopcion	varchar(100)
codigoestado	char(3)
/**/
