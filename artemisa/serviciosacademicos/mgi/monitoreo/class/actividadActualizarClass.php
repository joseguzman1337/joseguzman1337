<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of actividadActualizarClass
 *
 * @author proyecto_mgi_cp
 */
class actividadActualizarClass {
    
    var $idsiq_actividadActualizar = null;
    var $idMonitoreo = null;
    var $fecha_limite = null;
    var $fecha_actualizacion = null;
    var $usuario_actualizacion = null;
    var $idEstado = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_actividadActualizar() {
        return $this->idsiq_actividadActualizar;
    }

    public function setIdsiq_actividadActualizar($idsiq_actividadActualizar) {
        $this->idsiq_actividadActualizar = $idsiq_actividadActualizar;
    }

    public function getIdMonitoreo() {
        return $this->idMonitoreo;
    }

    public function setIdMonitoreo($idMonitoreo) {
        $this->idMonitoreo = $idMonitoreo;
    }

    public function getFecha_limite() {
        return $this->fecha_limite;
    }

    public function setFecha_limite($fecha_limite) {
        $this->fecha_limite = $fecha_limite;
    }

    public function getFecha_actualizacion() {
        return $this->fecha_actualizacion;
    }

    public function setFecha_actualizacion($fecha_actualizacion) {
        $this->fecha_actualizacion = $fecha_actualizacion;
    }

    public function getUsuario_actualizacion() {
        return $this->usuario_actualizacion;
    }

    public function setUsuario_actualizacion($usuario_actualizacion) {
        $this->usuario_actualizacion = $usuario_actualizacion;
    }

    public function getIdEstado() {
        return $this->idEstado;
    }

    public function setIdEstado($idEstado) {
        $this->idEstado = $idEstado;
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
