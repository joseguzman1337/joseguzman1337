<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of moodle_aulaVirtualClass
 *
 * @author proyecto_mgi_cp
 */
class moodle_aulaVirtualClass {
    var $idsiq_moodle_aulaVirtual = null;
    var $idmoodle = null;
    var $asignatura = null;
    var $asignatura_short = null;
    var $categorias = null;
    var $fecha_inicio = null;
    var $codigomateria = null;
    var $codigomodalidadacademica = null;
    var $bdMoodle = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_moodle_aulaVirtual() {
        return $this->idsiq_moodle_aulaVirtual;
    }

    public function setIdsiq_moodle_aulaVirtual($idsiq_moodle_aulaVirtual) {
        $this->idsiq_moodle_aulaVirtual = $idsiq_moodle_aulaVirtual;
    }

    public function getIdmoodle() {
        return $this->idmoodle;
    }

    public function setIdmoodle($idmoodle) {
        $this->idmoodle = $idmoodle;
    }

    public function getAsignatura() {
        return $this->asignatura;
    }

    public function setAsignatura($asignatura) {
        $this->asignatura = $asignatura;
    }

    public function getAsignatura_short() {
        return $this->asignatura_short;
    }

    public function setAsignatura_short($asignatura_short) {
        $this->asignatura_short = $asignatura_short;
    }

    public function getCategorias() {
        return $this->categorias;
    }

    public function setCategorias($categorias) {
        $this->categorias = $categorias;
    }

    public function getFecha_inicio() {
        return $this->fecha_inicio;
    }

    public function setFecha_inicio($fecha_inicio) {
        $this->fecha_inicio = $fecha_inicio;
    }

    public function getCodigomateria() {
        return $this->codigomateria;
    }

    public function setCodigomateria($codigomateria) {
        $this->codigomateria = $codigomateria;
    }

    public function getCodigomodalidadacademica() {
        return $this->codigomodalidadacademica;
    }

    public function setCodigomodalidadacademica($codigomodalidadacademica) {
        $this->codigomodalidadacademica = $codigomodalidadacademica;
    }
    
    public function getBdMoodle() {
        return $this->bdMoodle;
    }

    public function setBdMoodle($bdMoodle) {
        $this->bdMoodle = $bdMoodle;
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
