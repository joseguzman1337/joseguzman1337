<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formInvestigacionesGruposInvestigacionClass
 *
 * @author proyecto_mgi_cp
 */
class formInvestigacionesGruposInvestigacionClass {
    
    var $idsiq_formInvestigacionesGruposInvestigacion = null;
    var $codigoperiodo = null;
    var $numColciencias = null;
    var $numUEB = null;
    var $numUniversidadColciencias = null;
    var $numTotalColciencias = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_formInvestigacionesGruposInvestigacion() {
        return $this->idsiq_formInvestigacionesGruposInvestigacion;
    }

    public function setIdsiq_formInvestigacionesGruposInvestigacion($idsiq_formInvestigacionesGruposInvestigacion) {
        $this->idsiq_formInvestigacionesGruposInvestigacion = $idsiq_formInvestigacionesGruposInvestigacion;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function getNumColciencias() {
        return $this->numColciencias;
    }

    public function setNumColciencias($numColciencias) {
        $this->numColciencias = $numColciencias;
    }

    public function getNumUEB() {
        return $this->numUEB;
    }

    public function setNumUEB($numUEB) {
        $this->numUEB = $numUEB;
    }

    public function getNumUniversidadColciencias() {
        return $this->numUniversidadColciencias;
    }

    public function setNumUniversidadColciencias($numUniversidadColciencias) {
        $this->numUniversidadColciencias = $numUniversidadColciencias;
    }

    public function getNumTotalColciencias() {
        return $this->numTotalColciencias;
    }

    public function setNumTotalColciencias($numTotalColciencias) {
        $this->numTotalColciencias = $numTotalColciencias;
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
