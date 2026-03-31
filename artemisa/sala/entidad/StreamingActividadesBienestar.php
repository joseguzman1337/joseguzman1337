<?php
/**
 * @author vega Gabriel <vegagabriel@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
 
defined('_EXEC') or die;
class StreamingActividadesBienestar implements Entidad{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type int
     * @access private
     */
    private $id;
    
    /**
     * @type text
     * @access private
     */
    private $url;
    
    /**
     * @type enum
     * @access private
     */
    private $tipo;
    
    /**
     * @type int
     * @access private
     */
    private $usuarioCreacion;
    
    /**
     * @type datetime
     * @access private
     */
    private $fechaCreacion;
    
    /**
     * @type int
     * @access private
     */
    private $usuarioModificacion;
    
    /**
     * @type datetime
     * @access private
     */
    private $fechaModificacion;
    
    /**
     * @type varchar
     * @access private
     */
    private $codigoEstado;
   
    
    public function __construct(){
    }
    
    function getDb() {
        return $this->db;
    }

    function getId() {
        return $this->id;
    }

    function getUrl() {
        return $this->url;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getUsuarioCreacion() {
        return $this->usuarioCreacion;
    }

    function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    function getUsuarioModificacion() {
        return $this->usuarioModificacion;
    }

    function getFechaModificacion() {
        return $this->fechaModificacion;
    }

    function getCodigoEstado() {
        return $this->codigoEstado;
    }

    function setDb() {
        $this->db = Factory::createDbo();
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUrl($url) {
        $this->url = $url;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setUsuarioCreacion($usuarioCreacion) {
        $this->usuarioCreacion = $usuarioCreacion;
    }

    function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }

    function setUsuarioModificacion($usuarioModificacion) {
        $this->usuarioModificacion = $usuarioModificacion;
    }

    function setFechaModificacion($fechaModificacion) {
        $this->fechaModificacion = $fechaModificacion;
    }

    function setCodigoEstado($codigoEstado) {
        $this->codigoEstado = $codigoEstado;
    }

    
        
    public function getById(){
        if(!empty($this->id)){
            $query = "SELECT * FROM StreamingActividadesBienestar "
                    ." WHERE id = ".$this->db->qstr($this->id);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            if(!empty($d)){
                $this->url = $d['url'];
                $this->tipo = $d['tipo'];
                $this->usuarioCreacion = $d['usuarioCreacion'];
                $this->fechaCreacion = $d['fechaCreacion'];
                $this->usuarioModificacion = $d['usuarioModificacion'];
                $this->fechaModificacion = $d['fechaModificacion'];
                $this->codigoEstado = $d['codigoEstado'];
            }
        }
    }
    
    public static function getList($where=null, $orderBy = null){
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM StreamingActividadesBienestar "
                    ." WHERE 1 ";
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        if(!empty($orderBy)){
            $query .= " ORDER BY ".$orderBy;
        }
        //d($query);
        $datos = $db->Execute($query);
        
        while( $d = $datos->FetchRow() ){
            $StreamingActividadesBienestar = new StreamingActividadesBienestar();
            $StreamingActividadesBienestar->id = $d['id'];
            $StreamingActividadesBienestar->url = $d['url'];
            $StreamingActividadesBienestar->tipo = $d['tipo'];
            $StreamingActividadesBienestar->usuarioCreacion = $d['usuarioCreacion'];
            $StreamingActividadesBienestar->fechaCreacion = $d['fechaCreacion'];
            $StreamingActividadesBienestar->usuarioModificacion = $d['usuarioModificacion'];
            $StreamingActividadesBienestar->fechaModificacion = $d['fechaModificacion'];
            $StreamingActividadesBienestar->codigoEstado = $d['codigoEstado'];
            
            $return[] = $StreamingActividadesBienestar;
            unset($StreamingActividadesBienestar);
        }
        
        return $return;
    }
    
     public function saveStreamingActividadesBienestar(){
        $query = "";
        $where = array();
        
        if(empty($this->id)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " id = ".$this->db->qstr($this->id);
        }
        
        $query .= " StreamingActividadesBienestar SET ";
        $query .= " url = ".$this->db->qstr($this->url);
        $query .= " ,tipo = ".$this->db->qstr($this->tipo);
        if(empty($this->id)){
            $query .= " ,usuarioCreacion = ".$this->db->qstr($this->usuarioCreacion);
            $query .=" ,fechaCreacion = ".$this->db->qstr($this->fechaCreacion);
        }else{
            $query .= " ,usuarioModificacion = ".$this->db->qstr($this->usuarioModificacion);
            $query .= " ,fechaModificacion = ".$this->db->qstr($this->fechaModificacion);
        }
        $query .= " ,codigoEstado = ".$this->db->qstr($this->codigoEstado);
        
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }
        //d($query);
        $rs = $this->db->Execute($query);
        
        if(empty($this->id)){
            $this->id = $this->db->insert_Id();
        }
        
        if(!$rs){
            return false;
        }else{
            return true;
        }
    }
    
    function cmp($a, $b){
        return strcmp($a["url"], $b["tipo"]);
    }


}

