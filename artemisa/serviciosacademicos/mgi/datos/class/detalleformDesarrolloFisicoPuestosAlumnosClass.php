<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detalleformDesarrolloFisicoPuestosAlumnosClass
 *
 * @author proyecto_mgi_cp
 */
class detalleformDesarrolloFisicoPuestosAlumnosClass {
    
    var $idsiq_detalleformDesarrolloFisicoPuestosAlumnos = null;
    var $idData = null;
    var $idCategory = null;
    var $metros = null;
    var $numUnidades = null;
    var $tenencia = null;
    var $observaciones = null;
    var $usuario_creacion = null;
    var $fecha_creacion = null;
    var $codigoestado = null;
    var $usuario_modificacion = null;
    var $fecha_modificacion = null;

    public function __construct() {
        
    }
    
    public function getIdsiq_detalleformDesarrolloFisicoPuestosAlumnos() {
        return $this->idsiq_detalleformDesarrolloFisicoPuestosAlumnos;
    }

    public function setIdsiq_detalleformDesarrolloFisicoPuestosAlumnos($idsiq_detalleformDesarrolloFisicoPuestosAlumnos) {
        $this->idsiq_detalleformDesarrolloFisicoPuestosAlumnos = $idsiq_detalleformDesarrolloFisicoPuestosAlumnos;
    }

    public function getIdData() {
        return $this->idData;
    }

    public function setIdData($idData) {
        $this->idData = $idData;
    }

    public function getIdCategory() {
        return $this->idCategory;
    }

    public function setIdCategory($idCategory) {
        $this->idCategory = $idCategory;
    }

    public function getMetros() {
        return $this->metros;
    }

    public function setMetros($metros) {
        $this->metros = $metros;
    }

    public function getNumUnidades() {
        return $this->numUnidades;
    }

    public function setNumUnidades($numUnidades) {
        $this->numUnidades = $numUnidades;
    }

    public function getTenencia() {
        return $this->tenencia;
    }

    public function setTenencia($tenencia) {
        $this->tenencia = $tenencia;
    }

    public function getObservaciones() {
        return $this->observaciones;
    }

    public function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    public function getUsuario_creacion() {
        return $this->usuario_creacion;
    }

    public function setUsuario_creacion($usuario_creacion) {
        $this->usuario_creacion = $usuario_creacion;
    }

    public function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    public function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function getUsuario_modificacion() {
        return $this->usuario_modificacion;
    }

    public function setUsuario_modificacion($usuario_modificacion) {
        $this->usuario_modificacion = $usuario_modificacion;
    }

    public function getFecha_modificacion() {
        return $this->fecha_modificacion;
    }

    public function setFecha_modificacion($fecha_modificacion) {
        $this->fecha_modificacion = $fecha_modificacion;
    }
        
    public function __destruct() {
        
    }
}
?>
