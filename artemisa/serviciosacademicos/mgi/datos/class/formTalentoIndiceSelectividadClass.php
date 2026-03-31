<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formTalentoIndiceSelectividadClass
 *
 * @author proyecto_mgi_cp
 */
class formTalentoIndiceSelectividadClass {

    var $idsiq_formTalentoIndiceSelectividad = null;
    var $codigoperiodo = null;
    var $idDedicacion = null;
    var $numProcesosSeleccion = null;
    var $numAspirantes = null;
    var $numSeleccionados = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_formTalentoIndiceSelectividad() {
        return $this->idsiq_formTalentoIndiceSelectividad;
    }

    public function setIdsiq_formTalentoIndiceSelectividad($idsiq_formTalentoIndiceSelectividad) {
        $this->idsiq_formTalentoIndiceSelectividad = $idsiq_formTalentoIndiceSelectividad;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function getIdDedicacion() {
        return $this->idDedicacion;
    }

    public function setIdDedicacion($idDedicacion) {
        $this->idDedicacion = $idDedicacion;
    }

    public function getNumProcesosSeleccion() {
        return $this->numProcesosSeleccion;
    }

    public function setNumProcesosSeleccion($numProcesosSeleccion) {
        $this->numProcesosSeleccion = $numProcesosSeleccion;
    }

    public function getNumAspirantes() {
        return $this->numAspirantes;
    }

    public function setNumAspirantes($numAspirantes) {
        $this->numAspirantes = $numAspirantes;
    }

    public function getNumSeleccionados() {
        return $this->numSeleccionados;
    }

    public function setNumSeleccionados($numSeleccionados) {
        $this->numSeleccionados = $numSeleccionados;
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
