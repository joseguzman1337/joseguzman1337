<?php
/**
 * @author vega Gabriel <vegagabriel@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
 
defined('_EXEC') or die;
class ActividadesBienestar implements Entidad{
    
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
     * @type varchar
     * @access private
     */
    private $nombre;
    
    /**
     * @type varchar
     * @access private
     */
    private $descripcion;
    
    /**
     * @type datetime
     * @access private
     */
    private $fechaLimite;
    
    /**
     * @type varchar
     * @access private
     */
    private $cupo;
    
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
    
    /**
     * @type varchar
     * @access private
     */
    private $codigoEstado;
    
    /**
     * @type varchar
     * @access private
     */
    private $emailResponsable;
    
    /**
     * @type time
     * @access private
     */
    private $horaFin;
    
    /**
     * @type varchar
     * @access private
     */
    private $imagen;
    
    /**
     * @type int
     * @access private
     */
    private $flagUrl;
    
    /**
     * @type varchar
     * @access private
     */
    private $url;
   
    
    public function __construct(){
    }
    
    function getDb() {
        return $this->db;
    }

    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getFechaLimite() {
        return $this->fechaLimite;
    }

    function getCupo() {
        return $this->cupo;
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

    function getCodigoEstado() {
        return $this->codigoEstado;
    }

    function getEmailResponsable() {
        return $this->emailResponsable;
    }
    
    function getHoraFin() {
        return $this->horaFin;
    }
        
    function getUrl() {
        return $this->url;
    }
    
    function getImagen() {
        return $this->imagen;
    }

    function setDb() {
        $this->db = Factory::createDbo();
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setFechaLimite($fechaLimite) {
        $this->fechaLimite = $fechaLimite;
    }

    function setCupo($cupo) {
        $this->cupo = $cupo;
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

    function setCodigoEstado($codigoEstado) {
        $this->codigoEstado = $codigoEstado;
    }

    function setEmailResponsable($emailResponsable) {
        $this->emailResponsable = $emailResponsable;
    }
    
    function setHoraFin($horaFin) {
        $this->horaFin = $horaFin;
    }
    
    function setImagen($imagen) {
        $this->imagen = $imagen;
    }
    
    function setUrl($url) {
        $this->url = $url;
    }
    
    public function getById(){
        if(!empty($this->id)){
            $query = "SELECT * FROM ActividadesBienestar "
                    ." WHERE id = ".$this->db->qstr($this->id);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            if(!empty($d)){
                $this->nombre = $d['nombre'];
                $this->descripcion = $d['descripcion'];
                $this->fechaLimite = $d['fechaLimite'];
                $this->cupo = $d['cupo'];
                $this->usuarioCreacion = $d['usuarioCreacion'];
                $this->usuarioModificacion = $d['usuarioModificacion'];
                $this->fechaCreacion = $d['fechaCreacion'];
                $this->fechaModificacion = $d['fechaModificacion'];
                $this->codigoEstado = $d['codigoEstado'];
                $this->emailResponsable = $d['emailResponsable'];
                $this->horaFin = $d['horaFin'];
                $this->imagen = $d['imagen'];
                $this->url = $d['url'];
            }
        }
    }
    
    public static function getList($where=null, $orderBy = null){
        $return = array();
        $db = Factory::createDbo();
        $query = "SELECT * FROM ActividadesBienestar "
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
            $ActividadesBienestar = new ActividadesBienestar();
            $ActividadesBienestar->id = $d['id'];
            $ActividadesBienestar->nombre = $d['nombre'];
            $ActividadesBienestar->descripcion = $d['descripcion'];
            $ActividadesBienestar->fechaLimite = $d['fechaLimite'];
            $ActividadesBienestar->cupo = $d['cupo'];
            $ActividadesBienestar->usuarioCreacion = $d['usuarioCreacion'];
            $ActividadesBienestar->usuarioModificacion = $d['usuarioModificacion'];
            $ActividadesBienestar->fechaCreacion = $d['fechaCreacion'];
            $ActividadesBienestar->fechaModificacion = $d['fechaModificacion'];
            $ActividadesBienestar->codigoEstado = $d['codigoEstado'];
            $ActividadesBienestar->emailResponsable = $d['emailResponsable'];
            $ActividadesBienestar->horaFin = $d['horaFin'];
            $ActividadesBienestar->imagen = $d['imagen'];
            $ActividadesBienestar->url = $d['url'];
            
            $return[] = $ActividadesBienestar;
            unset($ActividadesBienestar);
        }
        
        return $return;
    }
    
     public function saveActividadesBienestar(){
        $query = "";
        $where = array();
        
        if(empty($this->id)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " id = ".$this->db->qstr($this->id);
        }
        
        $query .= " ActividadesBienestar SET ";
        $query .= " nombre = ".$this->db->qstr($this->nombre);
        $query .= " ,descripcion = ".$this->db->qstr($this->descripcion);
        $query .= " ,fechaLimite = ".$this->db->qstr($this->fechaLimite);
        $query .= " ,cupo = ".$this->db->qstr($this->cupo);
        $query .= " ,horaFin = ".$this->db->qstr($this->horaFin);
        $query .= " ,imagen = ".$this->db->qstr($this->imagen);
        $query .= " ,url = ".$this->db->qstr($this->url);
        if(empty($this->id)){
            $query .= " ,usuarioCreacion = ".$this->db->qstr($this->usuarioCreacion);
            $query .=" ,fechaCreacion = ".$this->db->qstr($this->fechaCreacion);
        }else{
            $query .= " ,usuarioModificacion = ".$this->db->qstr($this->usuarioModificacion);
            $query .= " ,fechaModificacion = ".$this->db->qstr($this->fechaModificacion);
        }
        $query .= " ,codigoEstado = ".$this->db->qstr($this->codigoEstado);
        $query .= " ,emailResponsable = ".$this->db->qstr($this->emailResponsable);
        
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
    
    
    function cmp($a, $b, $c, $d){
        return strcmp($a["nombre"], $b["descripcion"], $c["fechaLimite"], $d["cupo"]);
    }


}

