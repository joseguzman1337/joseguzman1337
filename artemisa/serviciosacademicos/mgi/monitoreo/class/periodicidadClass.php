<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of periodicidadClass
 *
 * @author proyecto_mgi_cp
 */
class periodicidadClass {    
    
    var $idsiq_periodicidad = null;
    var $periodicidad = null;
    var $valor = null;
    var $tipo_valor = null;
    var $aplica_monitoreo = null;
    var $aplica_alerta = null;
    var $aplica_autoevaluacion = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_periodicidad() {
        return $this->idsiq_periodicidad;
    }

    public function setIdsiq_periodicidad($idsiq_periodicidad) {
        $this->idsiq_periodicidad = $idsiq_periodicidad;
    }

    public function getPeriodicidad() {
        return $this->periodicidad;
    }

    public function setPeriodicidad($periodicidad) {
        $this->periodicidad = $periodicidad;
    }

    public function getValor() {
        return $this->valor;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function getTipo_valor() {
        return $this->tipo_valor;
    }

    public function setTipo_valor($tipo_valor) {
        $this->tipo_valor = $tipo_valor;
    }

    public function getAplica_monitoreo() {
        return $this->aplica_monitoreo;
    }

    public function setAplica_monitoreo($aplica_monitoreo) {
        $this->aplica_monitoreo = $aplica_monitoreo;
    }

    public function getAplica_alerta() {
        return $this->aplica_alerta;
    }

    public function setAplica_alerta($aplica_alerta) {
        $this->aplica_alerta = $aplica_alerta;
    }

    public function getAplica_autoevaluacion() {
        return $this->aplica_autoevaluacion;
    }

    public function setAplica_autoevaluacion($aplica_autoevaluacion) {
        $this->aplica_autoevaluacion = $aplica_autoevaluacion;
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
