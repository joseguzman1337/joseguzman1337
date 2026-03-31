<?php
/**
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/
defined('_EXEC') or die;
class SiqFactoresEstructuradocumento implements Entidad{
    /**
     * @var adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @var int
     * @access private
     */
    private $idsiq_factoresestructuradocumento;
    
    /**
     * @var int
     * @access private
     */
    private $idsiq_estructuradocumento;
    
    /**
     * @var int
     * @access private
     */
    private $factor_id;
    
    /**
     * @var int
     * @access private
     */
    private $Orden;
    
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
     * @var Date
     * @access private
     */
    private $changedate;
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getIdsiq_factoresestructuradocumento() {
        return $this->idsiq_factoresestructuradocumento;
    }

    public function getIdsiq_estructuradocumento() {
        return $this->idsiq_estructuradocumento;
    }

    public function getFactor_id() {
        return $this->factor_id;
    }

    public function getOrden() {
        return $this->Orden;
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

    public function setIdsiq_factoresestructuradocumento($idsiq_factoresestructuradocumento) {
        $this->idsiq_factoresestructuradocumento = $idsiq_factoresestructuradocumento;
    }

    public function setIdsiq_estructuradocumento($idsiq_estructuradocumento) {
        $this->idsiq_estructuradocumento = $idsiq_estructuradocumento;
    }

    public function setFactor_id($factor_id) {
        $this->factor_id = $factor_id;
    }

    public function setOrden($Orden) {
        $this->Orden = $Orden;
    }

    public function setUserid($userid) {
        $this->userid = $userid;
    }

    public function setEntrydate($entrydate) {
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
        if(!empty($this->idsiq_factoresestructuradocumento)){
            $query = "SELECT * FROM siq_factoresestructuradocumento "
                    ." WHERE idsiq_factoresestructuradocumento = ".$this->db->qstr($this->idsiq_factoresestructuradocumento);
            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->idsiq_estructuradocumento = $d['idsiq_estructuradocumento']; 
                $this->factor_id = $d['factor_id']; 
                $this->Orden = $d['Orden']; 
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
                . " FROM siq_factoresestructuradocumento "
                . " WHERE 1";
        
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $SiqFactoresEstructuradocumento = new SiqFactoresEstructuradocumento();
            $SiqFactoresEstructuradocumento->idsiq_factoresestructuradocumento = $d['idsiq_factoresestructuradocumento'];
            $SiqFactoresEstructuradocumento->idsiq_estructuradocumento = $d['idsiq_estructuradocumento']; 
            $SiqFactoresEstructuradocumento->factor_id = $d['factor_id']; 
            $SiqFactoresEstructuradocumento->Orden = $d['Orden']; 
            $SiqFactoresEstructuradocumento->userid = $d['userid']; 
            $SiqFactoresEstructuradocumento->entrydate = $d['entrydate']; 
            $SiqFactoresEstructuradocumento->codigoestado = $d['codigoestado']; 
            $SiqFactoresEstructuradocumento->userid_estado = $d['userid_estado']; 
            $SiqFactoresEstructuradocumento->changedate = $d['changedate'];
            
            $return[] = $SiqFactoresEstructuradocumento;
        }
        return $return;
    }
}
