<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class SiqEstructuraDocumento implements Entidad{
    /**
     * @var adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @var int
     * @access private
     */
    private $idsiq_estructuradocumento;
    
    /**
     * @var String
     * @access private
     */
    private $nombre_documento;
    
    /**
     * @var String
     * @access private
     */
    private $nombre_entidad;
    
    /**
     * @var int
     * @access private
     */
    private $tipo_documento;
    
    /**
     * @var int
     * @access private
     */
    private $id_carrera;
    
    /**
     * @var Date
     * @access private
     */
    private $fechainicial;
    
    /**
     * @var Date
     * @access private
     */
    private $fechafinal;
    
    /**
     * @var int
     * @access private
     */
    private $userid;
    
    /**
     * @var Date
     * @access private
     */
    private $entrydate;
    
    /**
     * @var int
     * @access private
     */
    private $codigoestado;
    
    /**
     * @var int
     * @access private
     */
    private $userid_estado;
    
    /**
     * @var date
     * @access private
     */
    private $changedate;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getIdsiq_estructuradocumento() {
        return $this->idsiq_estructuradocumento;
    }

    public function getNombre_documento() {
        return $this->nombre_documento;
    }

    public function getNombre_entidad() {
        return $this->nombre_entidad;
    }

    public function getTipo_documento() {
        return $this->tipo_documento;
    }

    public function getId_carrera() {
        return $this->id_carrera;
    }

    public function getFechainicial() {
        return $this->fechainicial;
    }

    public function getFechafinal() {
        return $this->fechafinal;
    }

    public function getUserid() {
        return $this->userid;
    }

    public function getEntrydate() {
        return $this->entrydate;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function getUserid_estado() {
        return $this->userid_estado;
    }

    public function getChangedate() {
        return $this->changedate;
    }

    public function setIdsiq_estructuradocumento($idsiq_estructuradocumento) {
        $this->idsiq_estructuradocumento = $idsiq_estructuradocumento;
    }

    public function setNombre_documento($nombre_documento) {
        $this->nombre_documento = $nombre_documento;
    }

    public function setNombre_entidad($nombre_entidad) {
        $this->nombre_entidad = $nombre_entidad;
    }

    public function setTipo_documento($tipo_documento) {
        $this->tipo_documento = $tipo_documento;
    }

    public function setId_carrera($id_carrera) {
        $this->id_carrera = $id_carrera;
    }

    public function setFechainicial($fechainicial) {
        $this->fechainicial = $fechainicial;
    }

    public function setFechafinal($fechafinal) {
        $this->fechafinal = $fechafinal;
    }

    public function setUserid($userid) {
        $this->userid = $userid;
    }

    public function setEntrydate(Date $entrydate) {
        $this->entrydate = $entrydate;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function setUserid_estado($userid_estado) {
        $this->userid_estado = $userid_estado;
    }

    public function setChangedate($changedate) {
        $this->changedate = $changedate;
    }
    
    public function getById() {
        if(!empty($this->idsiq_estructuradocumento)){
            $query = "SELECT * FROM siq_estructuradocumento "
                    ." WHERE idsiq_estructuradocumento = ".$this->db->qstr($this->idsiq_estructuradocumento);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->nombre_documento = $d['nombre_documento']; 
                $this->nombre_entidad = $d['nombre_entidad']; 
                $this->tipo_documento = $d['tipo_documento']; 
                $this->id_carrera = $d['id_carrera']; 
                $this->fechainicial = $d['fechainicial']; 
                $this->fechafinal = $d['fechafinal']; 
                $this->userid = $d['userid']; 
                $this->entrydate = $d['entrydate']; 
                $this->codigoestado = $d['codigoestado']; 
                $this->userid_estado = $d['userid_estado']; 
                $this->changedate = $d['changedate']; 
            }
        }
    }

    public static function getList($where=null) {
        $db = Factory::createDbo();
        
        $return = array();
        
        $query = "SELECT * "
                . " FROM siq_estructuradocumento "
                . " WHERE 1";
        
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $SiqEstructuraDocumento = new SiqEstructuraDocumento();
                $SiqEstructuraDocumento->idsiq_estructuradocumento = $d['idsiq_estructuradocumento']; 
                $SiqEstructuraDocumento->nombre_documento = $d['nombre_documento']; 
                $SiqEstructuraDocumento->nombre_entidad = $d['nombre_entidad']; 
                $SiqEstructuraDocumento->tipo_documento = $d['tipo_documento']; 
                $SiqEstructuraDocumento->id_carrera = $d['id_carrera']; 
                $SiqEstructuraDocumento->fechainicial = $d['fechainicial']; 
                $SiqEstructuraDocumento->fechafinal = $d['fechafinal']; 
                $SiqEstructuraDocumento->userid = $d['userid']; 
                $SiqEstructuraDocumento->entrydate = $d['entrydate']; 
                $SiqEstructuraDocumento->codigoestado = $d['codigoestado']; 
                $SiqEstructuraDocumento->userid_estado = $d['userid_estado']; 
                $SiqEstructuraDocumento->changedate = $d['changedate']; 
            
            $return[] = $SiqEstructuraDocumento;
        }
        return $return;
    }
}
