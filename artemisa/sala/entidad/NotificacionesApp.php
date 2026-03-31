<?php
/**
 * @author vega Gabriel <vegagabriel@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
 
defined('_EXEC') or die;
class NotificacionesApp implements Entidad{
    
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
    private $texto;
   
    /**
     * @type datetime
     * @access private
     */
    private $fecha;    
    
    /**
     * @type varchar
     * @access private
     */
    private $codigoEstado;
    
    /**
     * @type enum
     * @access private
     */
    private $estado;
    
    /**
     * @type int
     * @access private
     */
    private $usuarioCreacion;
    
    /**
     * @type int
     * @access private
     */
    private $usuarioModificacion;
    
    /**
     * @type datetime
     * @access private
     */
    private $fechaCreacion;
    
    /**
     * @type datetime
     * @access private
     */
    private $fechaModificacion;
   
    
    public function __construct(){
    }
    
    function getDb() {
        return $this->db;
    }

    function getId() {
        return $this->id;
    }

    function getTexto() {
        return $this->texto;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getCodigoEstado() {
        return $this->codigoEstado;
    }

    function getEstado() {
        return $this->estado;
    }
    
    function getUsuarioCreacion() {
        return $this->usuarioCreacion;
    }
    
    function getUsuarioModificacion() {
        return $this->usuarioModificacion;
    }
    
    function getFechaCreacion() {
        return $this->fechaCreacion;
    }
    
    function getFechaModificacion() {
        return $this->fechaModificacion;
    }

    function setDb() {
        $this->db = Factory::createDbo();
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTexto($texto) {
        $this->texto = $texto;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setCodigoEstado($codigoEstado) {
        $this->codigoEstado = $codigoEstado;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }
    
    function setUsuarioCreacion($usuarioCreacion) {
        $this->usuarioCreacion = $usuarioCreacion;
    }
    
    function setUsuarioModificacion($usuarioModificacion) {
        $this->usuarioModificacion = $usuarioModificacion;
    }
    
    function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }
    
    function setFechaModificacion($fechaModificacion) {
        $this->fechaModificacion = $fechaModificacion;
    }

    
        
    public function getById(){
        if(!empty($this->id)){
            $query = "SELECT * FROM NotificacionesApp "
                    ." WHERE id = ".$this->db->qstr($this->id);
             
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            if(!empty($d)){
                $this->texto = $d['texto'];
                $this->fecha = $d['fecha'];
                $this->codigoEstado = $d['codigoEstado'];
                $this->estado = $d['estado'];
                $this->usuarioCreacion = $d['usuarioCreacion'];
                $this->usuarioModificacion = $d['usuarioModificacion'];
                $this->fechaCreacion = $d['fechaCreacion'];
                $this->fechaModificacion = $d['fechaModificacion'];
            }
        }
    }
    
    public static function getList($where=null, $orderBy = null){
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM NotificacionesApp "
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
            $NotificacionesApp = new NotificacionesApp();
            $NotificacionesApp->id = $d['id'];
            $NotificacionesApp->texto = $d['texto'];
            $NotificacionesApp->fecha = $d['fecha'];
            $NotificacionesApp->codigoEstado = $d['codigoEstado'];
            $NotificacionesApp->estado = $d['estado'];
            $NotificacionesApp->usuarioCreacion = $d['usuarioCreacion'];
            $NotificacionesApp->usuarioModificacion = $d['usuarioModificacion'];
            $NotificacionesApp->fechaCreacion = $d['fechaCreacion'];
            $NotificacionesApp->fechaModificacion = $d['fechaModificacion'];
            
            $return[] = $NotificacionesApp;
            unset($NotificacionesApp);
        }
        
        return $return;
    }
   
    public function saveNotificacionesApp(){
        $query = "";
        $where = array();
        
        if(empty($this->id)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " id = ".$this->db->qstr($this->id);
        }
        
        $query .= " NotificacionesApp SET ";
        $query .= " texto = ".$this->db->qstr($this->texto);
        $query .= " ,fecha = ".$this->db->qstr($this->fecha);
        $query .= " ,codigoEstado = ".$this->db->qstr($this->codigoEstado);
        $query .= " ,estado = ".$this->db->qstr($this->estado);
        if(empty($this->id)){
            $query .= " ,usuarioCreacion = ".$this->db->qstr($this->usuarioCreacion);
            $query .=" ,fechaCreacion = ".$this->db->qstr($this->fechaCreacion);
        }else{
            $query .= " ,usuarioModificacion = ".$this->db->qstr($this->usuarioModificacion);
            $query .= " ,fechaModificacion = ".$this->db->qstr($this->fechaModificacion);
        }
        
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
    
    function cmp($a, $b, $c){
        return strcmp($a["texto"], $c["fecha"]);
    }


}

