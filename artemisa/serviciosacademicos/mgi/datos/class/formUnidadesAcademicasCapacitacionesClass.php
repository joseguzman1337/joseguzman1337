<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formUnidadesAcademicasCapacitacionesClass
 *
 * @author proyecto_mgi_cp
 */
class formUnidadesAcademicasCapacitacionesClass {
    
    var $idsiq_formUnidadesAcademicasCapacitaciones = null;
    var $codigoperiodo = null;
    var $codigocarrera = null;
    var $numConferencia = null;
    var $numTaller = null;
    var $numCurso = null;
    var $numOtro = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_formUnidadesAcademicasCapacitaciones() {
        return $this->idsiq_formUnidadesAcademicasCapacitaciones;
    }

    public function setIdsiq_formUnidadesAcademicasCapacitaciones($idsiq_formUnidadesAcademicasCapacitaciones) {
        $this->idsiq_formUnidadesAcademicasCapacitaciones = $idsiq_formUnidadesAcademicasCapacitaciones;
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

    public function getNumConferencia() {
        return $this->numConferencia;
    }

    public function setNumConferencia($numConferencia) {
        $this->numConferencia = $numConferencia;
    }

    public function getNumTaller() {
        return $this->numTaller;
    }

    public function setNumTaller($numTaller) {
        $this->numTaller = $numTaller;
    }

    public function getNumCurso() {
        return $this->numCurso;
    }

    public function setNumCurso($numCurso) {
        $this->numCurso = $numCurso;
    }

    public function getNumOtro() {
        return $this->numOtro;
    }

    public function setNumOtro($numOtro) {
        $this->numOtro = $numOtro;
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
