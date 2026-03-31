<?php
/**
 * @author Quintrero Ivan <quintreroivan@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package entidad
*/

defined('_EXEC') or die;
class SiqApublicoobjetivo implements Entidad{
    /**
     * @var adodb Object
     * @access private
     */
    private $db;
    
    private $idsiq_Apublicoobjetivo;
    
    private $idsiq_Ainstrumentoconfiguracion;
    
    private $estudiante;
    
    private $docente;
    
    private $admin;
    
    private $cvs;
    
    private $entrydate;
    
    private $codigoestado;
    
    private $userid_estado;
    
    private $changedate;
    
    private $obligar;
    
    private $userid;
    
    
    public function __construct(){
    }
    
    public function setDb(){
        $this->db = Factory::createDbo();
    }
    
    public function getIdsiq_Apublicoobjetivo() {
        return $this->idsiq_Apublicoobjetivo;
    }

    public function getIdsiq_Ainstrumentoconfiguracion() {
        return $this->idsiq_Ainstrumentoconfiguracion;
    }

    public function getEstudiante() {
        return $this->estudiante;
    }

    public function getDocente() {
        return $this->docente;
    }

    public function getAdmin() {
        return $this->admin;
    }

    public function getCvs() {
        return $this->cvs;
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
    
    public function getObligar(){
        return $this->obligar;
    }
    
    public function getUserid(){
        return $this->userid;
    }
    
    public function setIdsiq_Apublicoobjetivo($idsiq_Apublicoobjetivo) {
        $this->idsiq_Apublicoobjetivo = $idsiq_Apublicoobjetivo;
    }

    public function setIdsiq_Ainstrumentoconfiguracion($idsiq_Ainstrumentoconfiguracion) {
        $this->idsiq_Ainstrumentoconfiguracion = $idsiq_Ainstrumentoconfiguracion;
    }

    public function setEstudiante($estudiante) {
        $this->estudiante = $estudiante;
    }

    public function setDocente($docente) {
        $this->docente = $docente;
    }

    public function setAdmin($admin) {
        $this->admin = $admin;
    }

    public function setCvs($cvs) {
        $this->cvs = $cvs;
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
    
    public function setChangedate ($changedate){
        $this->changedate = $changedate;
    }

    public function setObligar($obligar){
        $this->obligar = $obligar;
    }

    public function setUserid($userid){
        $this->userid = $userid;
    }

    public function getById() {
        if(!empty($this->idsiq_Apublicoobjetivo)){
            $query = "SELECT * FROM siq_Apublicoobjetivo "
                    ." WHERE idsiq_Apublicoobjetivo = ".$this->db->qstr($this->idsiq_Apublicoobjetivo);            
            $datos = $this->db->Execute($query);
            $d = $datos->FetchRow();
            
            if(!empty($d)){
                $this->idsiq_Ainstrumentoconfiguracion = $d['idsiq_Ainstrumentoconfiguracion']; 
                $this->estudiante = $d['estudiante']; 
                $this->docente = $d['docente']; 
                $this->admin = $d['admin']; 
                $this->cvs = $d['cvs']; 
                $this->entrydate = $d['entrydate']; 
                $this->codigoestado = $d['codigoestado']; 
                $this->userid_estado = $d['userid_estado']; 
                $this->changedate = $d['changedate']; 
                $this->obligar = $d['obligar']; 
                $this->userid = $d['userid']; 
            }
        }
    }

    public static function getList($where=null, $orderBy = null) {
        $db = Factory::createDbo();
        $return = array();
        
        $query = "SELECT * "
                . " FROM siq_Apublicoobjetivo "
                . " WHERE 1";
        if(!empty($where)){
            $query .= " AND ".$where;
        }
        if(!empty($orderBy)){
            $query .= " ORDER BY ".$orderBy;
        }
        $datos = $db->Execute($query);
        while($d = $datos->FetchRow()){
            $SiqApublicoobjetivo = new SiqApublicoobjetivo(); 
            $SiqApublicoobjetivo->idsiq_Apublicoobjetivo = $d['idsiq_Apublicoobjetivo'];
            $SiqApublicoobjetivo->idsiq_Ainstrumentoconfiguracion = $d['idsiq_Ainstrumentoconfiguracion'];
            $SiqApublicoobjetivo->estudiante = $d['estudiante']; 
            $SiqApublicoobjetivo->docente = $d['docente']; 
            $SiqApublicoobjetivo->admin = $d['admin']; 
            $SiqApublicoobjetivo->cvs = $d['cvs']; 
            $SiqApublicoobjetivo->entrydate = $d['entrydate']; 
            $SiqApublicoobjetivo->codigoestado = $d['codigoestado']; 
            $SiqApublicoobjetivo->userid_estado = $d['userid_estado']; 
            $SiqApublicoobjetivo->changedate = $d['changedate']; 
            $SiqApublicoobjetivo->obligar = $d['obligar']; 
            $SiqApublicoobjetivo->userid = $d['userid']; 
            
            $return[] = $SiqApublicoobjetivo;
        }
        return $return;
    }
}