<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of responsableFactorClass
 *
 * @author proyecto_mgi_cp
 */
class responsableFactorClass {
    
    var $idsiq_responsableFactor = null;
    var $idFactor = null;
    var $idUsuarioResponsable = null;
    var $idTipoResponsabilidad = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $cod_estado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function __destruct() {
        
    }
    
    public function getIdsiq_responsableFactor() {
        return $this->idsiq_responsableFactor;
    }

    public function setIdsiq_responsableFactor($idsiq_responsableFactor) {
        $this->idsiq_responsableFactor = $idsiq_responsableFactor;
    }

    public function getIdFactor() {
        return $this->idFactor;
    }

    public function setIdFactor($idFactor) {
        $this->idFactor = $idFactor;
    }

    public function getIdUsuarioResponsable() {
        return $this->idUsuarioResponsable;
    }

    public function setIdUsuarioResponsable($idUsuarioResponsable) {
        $this->idUsuarioResponsable = $idUsuarioResponsable;
    }

    public function getIdTipoResponsabilidad() {
        return $this->idTipoResponsabilidad;
    }

    public function setIdTipoResponsabilidad($idTipoResponsabilidad) {
        $this->idTipoResponsabilidad = $idTipoResponsabilidad;
    }

    public function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    public function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    public function getUsuario_creacion() {
        return $this->usuario_creacion;
    }

    public function setUsuario_creacion($usuario_creacion) {
        $this->usuario_creacion = $usuario_creacion;
    }

    public function getCod_estado() {
        return $this->cod_estado;
    }

    public function setCod_estado($cod_estado) {
        $this->cod_estado = $cod_estado;
    }

    public function getFecha_modificacion() {
        return $this->fecha_modificacion;
    }

    public function setFecha_modificacion($fecha_modificacion) {
        $this->fecha_modificacion = $fecha_modificacion;
    }

    public function getUsuario_modificacion() {
        return $this->usuario_modificacion;
    }

    public function setUsuario_modificacion($usuario_modificacion) {
        $this->usuario_modificacion = $usuario_modificacion;
    }
    
}

?>
