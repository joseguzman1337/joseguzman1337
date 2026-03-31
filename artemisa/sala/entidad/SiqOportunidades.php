<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class SiqOportunidades  implements Entidad{
    /**
     * @var adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @var int
     * @access private
     */
    private $idsiq_oportunidad;
    
    /**
     * @var int
     * @access private
     */
    private $idsiq_tipooportunidad;
    
    /**
     * @var int
     * @access private
     */
    private $idsiq_factorestructuradocumento;
    
    /**
     * @var String
     * @access private
     */
    private $nombre;
    
    /**
     * @var String
     * @access private
     */
    private $descripcion;
    
    /**
     * @var int
     * @access private
     */
    private $usuariocreacion;
    
    /**
     * @var Date
     * @access private
     */
    private $fechacreacion;
    
    /**
     * @var int
     * @access private
     */
    private $usuariomodificacion;
    
    /**
     * @var Date
     * @access private
     */
    private $fechamodificacion;
    
    /**
     * @var String
     * @access private
     */
    private $codigoestado;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getIdsiq_oportunidad() {
        return $this->idsiq_oportunidad;
    }

    public function getIdsiq_tipooportunidad() {
        return $this->idsiq_tipooportunidad;
    }

    public function getIdsiq_factorestructuradocumento() {
        return $this->idsiq_factorestructuradocumento;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getUsuariocreacion() {
        return $this->usuariocreacion;
    }

    public function getFechacreacion() {
        return $this->fechacreacion;
    }

    public function getUsuariomodificacion() {
        return $this->usuariomodificacion;
    }

    public function getFechamodificacion() {
        return $this->fechamodificacion;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function setIdsiq_oportunidad($idsiq_oportunidad) {
        $this->idsiq_oportunidad = $idsiq_oportunidad;
    }

    public function setIdsiq_tipooportunidad($idsiq_tipooportunidad) {
        $this->idsiq_tipooportunidad = $idsiq_tipooportunidad;
    }

    public function setIdsiq_factorestructuradocumento($idsiq_factorestructuradocumento) {
        $this->idsiq_factorestructuradocumento = $idsiq_factorestructuradocumento;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setUsuariocreacion($usuariocreacion) {
        $this->usuariocreacion = $usuariocreacion;
    }

    public function setFechacreacion($fechacreacion) {
        $this->fechacreacion = $fechacreacion;
    }

    public function setUsuariomodificacion($usuariomodificacion) {
        $this->usuariomodificacion = $usuariomodificacion;
    }

    public function setFechamodificacion($fechamodificacion) {
        $this->fechamodificacion = $fechamodificacion;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

        
    public function getById() {
        if(!empty($this->idsiq_oportunidad)){
            $query = "SELECT * FROM siq_oportunidades "
                    ." WHERE idsiq_oportunidad = ".$this->db->qstr($this->idsiq_oportunidad);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->idsiq_tipooportunidad = $d['idsiq_tipooportunidad']; 
                $this->idsiq_factorestructuradocumento = $d['idsiq_factorestructuradocumento'];
                $this->nombre = $d['nombre'];
                $this->descripcion = $d['descripcion'];
                $this->usuariocreacion = $d['usuariocreacion'];
                $this->fechacreacion = $d['fechacreacion'];
                $this->usuariomodificacion = $d['usuariomodificacion'];
                $this->fechamodificacion = $d['fechamodificacion'];
                $this->codigoestado = $d['codigoestado'];
            }
        }
    }

    public static function getList($where=null) {
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM siq_oportunidades "
                . " WHERE 1";
        
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $SiqOportunidades = new SiqOportunidades();
            $SiqOportunidades->idsiq_oportunidad = $d['idsiq_oportunidad'];
            $SiqOportunidades->idsiq_tipooportunidad = $d['idsiq_tipooportunidad']; 
            $SiqOportunidades->idsiq_factorestructuradocumento = $d['idsiq_factorestructuradocumento'];
            $SiqOportunidades->nombre = $d['nombre'];
            $SiqOportunidades->descripcion = $d['descripcion'];
            $SiqOportunidades->usuariocreacion = $d['usuariocreacion'];
            $SiqOportunidades->fechacreacion = $d['fechacreacion'];
            $SiqOportunidades->usuariomodificacion = $d['usuariomodificacion'];
            $SiqOportunidades->fechamodificacion = $d['fechamodificacion'];
            $SiqOportunidades->codigoestado = $d['codigoestado'];
            $return[] = $SiqOportunidades;
        }
        return $return;
    }
    
    public function save(){
        $query = "";
        $where = array();
        
        if(empty($this->idsiq_oportunidad)){
            $query .= "INSERT INTO ";
        }else{
            $query .= "UPDATE ";
            $where[] = " idsiq_oportunidad = ".$this->db->qstr($this->idsiq_oportunidad);
        }
        
        $query .= " siq_oportunidades SET "
               . " idsiq_tipooportunidad = ".$this->db->qstr($this->idsiq_tipooportunidad).", "
               . " idsiq_factorestructuradocumento = ".$this->db->qstr($this->idsiq_factorestructuradocumento).", "
               . " nombre = ".$this->db->qstr($this->nombre).", "
               . " descripcion = ".$this->db->qstr($this->descripcion).", "
               . " usuariocreacion = ".$this->db->qstr($this->usuariocreacion).", "
               . " fechacreacion = ".$this->db->qstr($this->fechacreacion).", "
               . " usuariomodificacion = ".$this->db->qstr($this->usuariomodificacion).", "
               . " fechamodificacion = ".$this->db->qstr($this->fechamodificacion).", "
               . " codigoestado = ".$this->db->qstr($this->codigoestado);
        
        if(!empty($where)){
            $query .= " WHERE ".implode(" AND ",$where);
        }
        //ddd($query);
        $rs = $this->db->Execute($query);
        
        if(empty($this->idsiq_oportunidad)){
            $this->idsiq_oportunidad = $this->db->insert_Id();
        }
        
        if(!$rs){
            return false;
        }else{
            return true;
        }
    }
}
