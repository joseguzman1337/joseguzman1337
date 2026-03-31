<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formUnidadesAcademicasPlanEstudioClass
 *
 * @author proyecto_mgi_cp
 */
class formUnidadesAcademicasPlanEstudioClass {

    var $idsiq_formUnidadesAcademicasPlanEstudio = null;
    var $codigoperiodo = null;
    var $codigocarrera = null;
    var $planEstudio = null;
    var $numAsignaturasFundamental = null;
    var $numCreditosFundamental = null;
    var $numAsignaturasDiversificada = null;
    var $numCreditosDiversificada = null;
    var $numAsignaturasElectivas = null;
    var $numCreditosElectivas = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_formUnidadesAcademicasPlanEstudio() {
        return $this->idsiq_formUnidadesAcademicasPlanEstudio;
    }

    public function setIdsiq_formUnidadesAcademicasPlanEstudio($idsiq_formUnidadesAcademicasPlanEstudio) {
        $this->idsiq_formUnidadesAcademicasPlanEstudio = $idsiq_formUnidadesAcademicasPlanEstudio;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }
    
    public function getPlanEstudio() {
        return $this->planEstudio;
    }

    public function setPlanEstudio($planEstudio) {
        $this->planEstudio = $planEstudio;
    }
    
    public function getCodigocarrera() {
        return $this->codigocarrera;
    }

    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }

    public function getNumAsignaturasFundamental() {
        return $this->numAsignaturasFundamental;
    }

    public function setNumAsignaturasFundamental($numAsignaturasFundamental) {
        $this->numAsignaturasFundamental = $numAsignaturasFundamental;
    }

    public function getNumCreditosFundamental() {
        return $this->numCreditosFundamental;
    }

    public function setNumCreditosFundamental($numCreditosFundamental) {
        $this->numCreditosFundamental = $numCreditosFundamental;
    }

    public function getNumAsignaturasDiversificada() {
        return $this->numAsignaturasDiversificada;
    }

    public function setNumAsignaturasDiversificada($numAsignaturasDiversificada) {
        $this->numAsignaturasDiversificada = $numAsignaturasDiversificada;
    }

    public function getNumCreditosDiversificada() {
        return $this->numCreditosDiversificada;
    }

    public function setNumCreditosDiversificada($numCreditosDiversificada) {
        $this->numCreditosDiversificada = $numCreditosDiversificada;
    }

    public function getNumAsignaturasElectivas() {
        return $this->numAsignaturasElectivas;
    }

    public function setNumAsignaturasElectivas($numAsignaturasElectivas) {
        $this->numAsignaturasElectivas = $numAsignaturasElectivas;
    }

    public function getNumCreditosElectivas() {
        return $this->numCreditosElectivas;
    }

    public function setNumCreditosElectivas($numCreditosElectivas) {
        $this->numCreditosElectivas = $numCreditosElectivas;
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
