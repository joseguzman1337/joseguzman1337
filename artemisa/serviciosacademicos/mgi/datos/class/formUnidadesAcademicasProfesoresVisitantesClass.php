<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formUnidadesAcademicasProfesoresVisitantesClass
 *
 * @author proyecto_mgi_cp
 */
class formUnidadesAcademicasProfesoresVisitantesClass {
    
    var $idsiq_formUnidadesAcademicasProfesoresVisitantes = null;
    var $codigocarrera = null;
    var $nombre = null;
    var $fechaVisita = null;
    var $ciudad = null;
    var $institucion = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_formUnidadesAcademicasProfesoresVisitantes() {
        return $this->idsiq_formUnidadesAcademicasProfesoresVisitantes;
    }

    public function setIdsiq_formUnidadesAcademicasProfesoresVisitantes($idsiq_formUnidadesAcademicasProfesoresVisitantes) {
        $this->idsiq_formUnidadesAcademicasProfesoresVisitantes = $idsiq_formUnidadesAcademicasProfesoresVisitantes;
    }

    public function getCodigocarrera() {
        return $this->codigocarrera;
    }

    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getFechaVisita() {
        return $this->fechaVisita;
    }

    public function setFechaVisita($fechaVisita) {
        $this->fechaVisita = $fechaVisita;
    }

    public function getCiudad() {
        return $this->ciudad;
    }

    public function setCiudad($ciudad) {
        $this->ciudad = $ciudad;
    }

    public function getInstitucion() {
        return $this->institucion;
    }

    public function setInstitucion($institucion) {
        $this->institucion = $institucion;
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
