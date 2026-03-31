<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of documentoClass
 *
 * @author proyecto_mgi_cp
 */
class documentoClass {
    
    var $idsiq_documento = null;
    var $siqfactor_id = null;
    var $siqcaracteristica_id = null;
    var $siqaspecto_id = null;
    var $siqindicador_id = null;
    var $periodo = null;
    var $estado = null;
    var $fecha_ingreso = null;
    var $userid = null;
    var $entrydate = null;
    var $codigoestado = null;
    var $userid_estado = null;
    var $changedate = null;
    
    function __construct() {
        
    }
    
    public function getIdsiq_documento() {
        return $this->idsiq_documento;
    }

    public function setIdsiq_documento($idsiq_documento) {
        $this->idsiq_documento = $idsiq_documento;
    }

    public function getSiqfactor_id() {
        return $this->siqfactor_id;
    }

    public function setSiqfactor_id($siqfactor_id) {
        $this->siqfactor_id = $siqfactor_id;
    }

    public function getSiqcaracteristica_id() {
        return $this->siqcaracteristica_id;
    }

    public function setSiqcaracteristica_id($siqcaracteristica_id) {
        $this->siqcaracteristica_id = $siqcaracteristica_id;
    }

    public function getSiqaspecto_id() {
        return $this->siqaspecto_id;
    }

    public function setSiqaspecto_id($siqaspecto_id) {
        $this->siqaspecto_id = $siqaspecto_id;
    }

    public function getSiqindicador_id() {
        return $this->siqindicador_id;
    }

    public function setSiqindicador_id($siqindicador_id) {
        $this->siqindicador_id = $siqindicador_id;
    }

    public function getPeriodo() {
        return $this->periodo;
    }

    public function setPeriodo($periodo) {
        $this->periodo = $periodo;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function getFecha_ingreso() {
        return $this->fecha_ingreso;
    }

    public function setFecha_ingreso($fecha_ingreso) {
        $this->fecha_ingreso = $fecha_ingreso;
    }

    public function getUserid() {
        return $this->userid;
    }

    public function setUserid($userid) {
        $this->userid = $userid;
    }

    public function getEntrydate() {
        return $this->entrydate;
    }

    public function setEntrydate($entrydate) {
        $this->entrydate = $entrydate;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function getUserid_estado() {
        return $this->userid_estado;
    }

    public function setUserid_estado($userid_estado) {
        $this->userid_estado = $userid_estado;
    }

    public function getChangedate() {
        return $this->changedate;
    }

    public function setChangedate($changedate) {
        $this->changedate = $changedate;
    }
    
    public function __destruct() {
        
    }
}
?>
