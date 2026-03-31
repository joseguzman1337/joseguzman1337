<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of responsableIndicadorClass
 *
 * @author proyecto_mgi_cp
 */
class responsableIndicadorClass {

    var $idsiq_responsableIndicador = null;
    var $idIndicador = null;
    var $idUsuarioResponsable = null;
    var $idTipoResponsabilidad = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_responsableIndicador() {
        return $this->idsiq_responsableIndicador;
    }

    public function setIdsiq_responsableIndicador($idsiq_responsableIndicador) {
        $this->idsiq_responsableIndicador = $idsiq_responsableIndicador;
    }

    public function getIdIndicador() {
        return $this->idIndicador;
    }

    public function setIdIndicador($idIndicador) {
        $this->idIndicador = $idIndicador;
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

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
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

    public function __destruct() {
        
    }
}

?>
