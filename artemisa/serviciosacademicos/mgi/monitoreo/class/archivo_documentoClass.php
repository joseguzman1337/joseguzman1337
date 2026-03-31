<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of archivo_documentoClass
 *
 * @author proyecto_mgi_cp
 */
class archivo_documentoClass {
    
    var $idsiq_archivodocumento = null;
    var $siq_documento_id = null;
    var $descripcion = null;
    var $file_size = null;
    var $nombre_archivo = null;
    var $tamano_unida = null;
    var $tipo_documento = null;
    var $fecha_carga = null;
    var $tipo = null;
    var $extencion = null;
    var $Ubicaicion_url = null;
    var $version_final = null;
    var $userid = null;
    var $entrydate = null;
    var $codigoestado = null;
    var $changedate = null;
    var $userid_estado = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_archivodocumento() {
        return $this->idsiq_archivodocumento;
    }

    public function setIdsiq_archivodocumento($idsiq_archivodocumento) {
        $this->idsiq_archivodocumento = $idsiq_archivodocumento;
    }

    public function getSiq_documento_id() {
        return $this->siq_documento_id;
    }

    public function setSiq_documento_id($siq_documento_id) {
        $this->siq_documento_id = $siq_documento_id;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getFile_size() {
        return $this->file_size;
    }

    public function setFile_size($file_size) {
        $this->file_size = $file_size;
    }

    public function getNombre_archivo() {
        return $this->nombre_archivo;
    }

    public function setNombre_archivo($nombre_archivo) {
        $this->nombre_archivo = $nombre_archivo;
    }

    public function getTamano_unida() {
        return $this->tamano_unida;
    }

    public function setTamano_unida($tamano_unida) {
        $this->tamano_unida = $tamano_unida;
    }

    public function getTipo_documento() {
        return $this->tipo_documento;
    }

    public function setTipo_documento($tipo_documento) {
        $this->tipo_documento = $tipo_documento;
    }

    public function getFecha_carga() {
        return $this->fecha_carga;
    }

    public function setFecha_carga($fecha_carga) {
        $this->fecha_carga = $fecha_carga;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getExtencion() {
        return $this->extencion;
    }

    public function setExtencion($extencion) {
        $this->extencion = $extencion;
    }

    public function getUbicaicion_url() {
        return $this->Ubicaicion_url;
    }

    public function setUbicaicion_url($Ubicaicion_url) {
        $this->Ubicaicion_url = $Ubicaicion_url;
    }

    public function getVersion_final() {
        return $this->version_final;
    }

    public function setVersion_final($version_final) {
        $this->version_final = $version_final;
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

    public function getChangedate() {
        return $this->changedate;
    }

    public function setChangedate($changedate) {
        $this->changedate = $changedate;
    }

    public function getUserid_estado() {
        return $this->userid_estado;
    }

    public function setUserid_estado($userid_estado) {
        $this->userid_estado = $userid_estado;
    }
        
    public function __destruct() {
        
    }
    
}

?>
