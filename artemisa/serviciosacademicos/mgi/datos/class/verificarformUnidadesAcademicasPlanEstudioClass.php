<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of verificarformUnidadesAcademicasPlanEstudioClass
 *
 * @author proyecto_mgi_cp
 */
class verificarformUnidadesAcademicasPlanEstudioClass {    
    
    var $idsiq_verificarformUnidadesAcademicasPlanEstudio = null;
    var $codigoperiodo = null;
    var $codigocarrera = null;
    var $planEstudio = null;
    var $vnumAsignaturasFundamental = "0";
    var $vnumAsignaturasDiversificada = "0";
    var $vnumAsignaturasElectivas = "0";
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_verificarformUnidadesAcademicasPlanEstudio() {
        return $this->idsiq_verificarformUnidadesAcademicasPlanEstudio;
    }

    public function setIdsiq_verificarformUnidadesAcademicasPlanEstudio($idsiq_verificarformUnidadesAcademicasPlanEstudio) {
        $this->idsiq_verificarformUnidadesAcademicasPlanEstudio = $idsiq_verificarformUnidadesAcademicasPlanEstudio;
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

    public function getPlanEstudio() {
        return $this->planEstudio;
    }

    public function setPlanEstudio($planEstudio) {
        $this->planEstudio = $planEstudio;
    }

    public function getVnumAsignaturasFundamental() {
        return $this->vnumAsignaturasFundamental;
    }

    public function setVnumAsignaturasFundamental($vnumAsignaturasFundamental) {
        $this->vnumAsignaturasFundamental = $vnumAsignaturasFundamental;
    }

    public function getVnumAsignaturasDiversificada() {
        return $this->vnumAsignaturasDiversificada;
    }

    public function setVnumAsignaturasDiversificada($vnumAsignaturasDiversificada) {
        $this->vnumAsignaturasDiversificada = $vnumAsignaturasDiversificada;
    }

    public function getVnumAsignaturasElectivas() {
        return $this->vnumAsignaturasElectivas;
    }

    public function setVnumAsignaturasElectivas($vnumAsignaturasElectivas) {
        $this->vnumAsignaturasElectivas = $vnumAsignaturasElectivas;
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
