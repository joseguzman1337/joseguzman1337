<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formUnidadesAcademicasActividadesInvestigacionClass
 *
 * @author proyecto_mgi_cp
 */
class formUnidadesAcademicasActividadesInvestigacionClass {
    
    var $idsiq_formUnidadesAcademicasActividadesInvestigacion = null;
    var $codigoperiodo = null;
    var $codigocarrera = null;
    var $numSeminarios = null;
    var $numForos = null;
    var $numEstudiosCaso = null;
    var $numOtros = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_formUnidadesAcademicasActividadesInvestigacion() {
        return $this->idsiq_formUnidadesAcademicasActividadesInvestigacion;
    }

    public function setIdsiq_formUnidadesAcademicasActividadesInvestigacion($idsiq_formUnidadesAcademicasActividadesInvestigacion) {
        $this->idsiq_formUnidadesAcademicasActividadesInvestigacion = $idsiq_formUnidadesAcademicasActividadesInvestigacion;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function getCodigocarrera() {
        return $this->codigocarrera;
    }

    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }

    public function getNumSeminarios() {
        return $this->numSeminarios;
    }

    public function setNumSeminarios($numSeminarios) {
        $this->numSeminarios = $numSeminarios;
    }

    public function getNumForos() {
        return $this->numForos;
    }

    public function setNumForos($numForos) {
        $this->numForos = $numForos;
    }

    public function getNumEstudiosCaso() {
        return $this->numEstudiosCaso;
    }

    public function setNumEstudiosCaso($numEstudiosCaso) {
        $this->numEstudiosCaso = $numEstudiosCaso;
    }

    public function getNumOtros() {
        return $this->numOtros;
    }

    public function setNumOtros($numOtros) {
        $this->numOtros = $numOtros;
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
