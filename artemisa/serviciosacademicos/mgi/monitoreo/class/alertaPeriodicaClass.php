<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of alertaPeriodicaClass
 *
 * @author proyecto_mgi_cp
 */
class alertaPeriodicaClass {

    var $idsiq_alertaPeriodica = null;
    var $idMonitoreo = null;
    var $tipo = null;
    var $idTipoAlerta = null;
    var $idPeriodicidad = null;
    var $fecha_prox_alerta = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_alertaPeriodica() {
        return $this->idsiq_alertaPeriodica;
    }

    public function setIdsiq_alertaPeriodica($idsiq_alertaPeriodica) {
        $this->idsiq_alertaPeriodica = $idsiq_alertaPeriodica;
    }

    public function getIdMonitoreo() {
        return $this->idMonitoreo;
    }

    public function setIdMonitoreo($idMonitoreo) {
        $this->idMonitoreo = $idMonitoreo;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getIdTipoAlerta() {
        return $this->idTipoAlerta;
    }

    public function setIdTipoAlerta($idTipoAlerta) {
        $this->idTipoAlerta = $idTipoAlerta;
    }

    public function getIdPeriodicidad() {
        return $this->idPeriodicidad;
    }

    public function setIdPeriodicidad($idPeriodicidad) {
        $this->idPeriodicidad = $idPeriodicidad;
    }

    public function getFecha_prox_alerta() {
        return $this->fecha_prox_alerta;
    }

    public function setFecha_prox_alerta($fecha_prox_alerta) {
        $this->fecha_prox_alerta = $fecha_prox_alerta;
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
