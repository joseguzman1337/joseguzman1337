<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formTalentoHumanoPersonalPrestacionServiciosClass
 *
 * @author proyecto_mgi_cp
 */
class formTalentoHumanoPersonalPrestacionServiciosClass {

    var $idsiq_formTalentoHumanoPersonalPrestacionServicios = null;
    var $idsubperiodo = null;
    var $idActividad = null;
    var $numPersonas = null;
    var $valorServicios = null;
    var $verificada = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_formTalentoHumanoPersonalPrestacionServicios() {
        return $this->idsiq_formTalentoHumanoPersonalPrestacionServicios;
    }

    public function setIdsiq_formTalentoHumanoPersonalPrestacionServicios($idsiq_formTalentoHumanoPersonalPrestacionServicios) {
        $this->idsiq_formTalentoHumanoPersonalPrestacionServicios = $idsiq_formTalentoHumanoPersonalPrestacionServicios;
    }

    public function getIdSubperiodo() {
        return $this->idsubperiodo;
    }

    public function setIdSubperiodo($idsubperiodo) {
        $this->idsubperiodo = $idsubperiodo;
    }

    public function getIdActividad() {
        return $this->idActividad;
    }

    public function setIdActividad($idActividad) {
        $this->idActividad = $idActividad;
    }

    public function getNumPersonas() {
        return $this->numPersonas;
    }

    public function setNumPersonas($numPersonas) {
        $this->numPersonas = $numPersonas;
    }

    public function getValorServicios() {
        return $this->valorServicios;
    }

    public function setValorServicios($valorServicios) {
        $this->valorServicios = $valorServicios;
    }

    public function getVerificada() {
        return $this->verificada;
    }

    public function setVerificada($verificada) {
        $this->verificada = $verificada;
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
