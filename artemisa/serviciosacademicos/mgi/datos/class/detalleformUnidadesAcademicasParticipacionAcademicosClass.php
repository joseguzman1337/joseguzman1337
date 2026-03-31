<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detalleformUnidadesAcademicasParticipacionAcademicosClass
 *
 * @author proyecto_mgi_cp
 */
class detalleformUnidadesAcademicasParticipacionAcademicosClass {
    
    var $idsiq_detalleformUnidadesAcademicasParticipacionAcademicos = null;
    var $idData = null;
    var $idCategory = null;
    var $numSalud = null;
    var $numCalidad = null;
    var $numOtros = null;
    var $numNacional = null;
    var $numInternacional = null;
    var $usuario_creacion = null;
    var $fecha_creacion = null;
    var $codigoestado = null;
    var $usuario_modificacion = null;
    var $fecha_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_detalleformUnidadesAcademicasParticipacionAcademicos() {
        return $this->idsiq_detalleformUnidadesAcademicasParticipacionAcademicos;
    }

    public function setIdsiq_detalleformUnidadesAcademicasParticipacionAcademicos($idsiq_detalleformUnidadesAcademicasParticipacionAcademicos) {
        $this->idsiq_detalleformUnidadesAcademicasParticipacionAcademicos = $idsiq_detalleformUnidadesAcademicasParticipacionAcademicos;
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

    public function getNumSalud() {
        return $this->numSalud;
    }

    public function setNumSalud($numSalud) {
        $this->numSalud = $numSalud;
    }

    public function getNumCalidad() {
        return $this->numCalidad;
    }

    public function setNumCalidad($numCalidad) {
        $this->numCalidad = $numCalidad;
    }

    public function getNumOtros() {
        return $this->numOtros;
    }

    public function setNumOtros($numOtros) {
        $this->numOtros = $numOtros;
    }

    public function getNumNacional() {
        return $this->numNacional;
    }

    public function setNumNacional($numNacional) {
        $this->numNacional = $numNacional;
    }

    public function getNumInternacional() {
        return $this->numInternacional;
    }

    public function setNumInternacional($numInternacional) {
        $this->numInternacional = $numInternacional;
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
