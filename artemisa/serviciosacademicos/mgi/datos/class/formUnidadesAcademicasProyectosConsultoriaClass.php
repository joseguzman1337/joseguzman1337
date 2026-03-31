<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formUnidadesAcademicasProyectosConsultoriaClass
 *
 * @author proyecto_mgi_cp
 */
class formUnidadesAcademicasProyectosConsultoriaClass {
    
    var $idsiq_formUnidadesAcademicasProyectosConsultoria = null;
    var $codigoperiodo = null;
    var $codigocarrera = null;
    var $numAprobadas = null;
    var $numEjecucion = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_formUnidadesAcademicasProyectosConsultoria() {
        return $this->idsiq_formUnidadesAcademicasProyectosConsultoria;
    }

    public function setIdsiq_formUnidadesAcademicasProyectosConsultoria($idsiq_formUnidadesAcademicasProyectosConsultoria) {
        $this->idsiq_formUnidadesAcademicasProyectosConsultoria = $idsiq_formUnidadesAcademicasProyectosConsultoria;
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

    public function getNumAprobadas() {
        return $this->numAprobadas;
    }

    public function setNumAprobadas($numAprobadas) {
        $this->numAprobadas = $numAprobadas;
    }

    public function getNumEjecucion() {
        return $this->numEjecucion;
    }

    public function setNumEjecucion($numEjecucion) {
        $this->numEjecucion = $numEjecucion;
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
