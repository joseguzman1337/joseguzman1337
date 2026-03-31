<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of plantillaCursoEducacionContinuadaClass
 *
 * @author proyecto_mgi_cp
 */
class plantillaCursoEducacionContinuadaClass {
    
    var $idplantillaCursoEducacionContinuada = null;
    var $codigocarrera = null;
    var $plantilla = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdplantillaCursoEducacionContinuada() {
        return $this->idplantillaCursoEducacionContinuada;
    }

    public function setIdplantillaCursoEducacionContinuada($idplantillaCursoEducacionContinuada) {
        $this->idplantillaCursoEducacionContinuada = $idplantillaCursoEducacionContinuada;
    }

    public function getCodigocarrera() {
        return $this->codigocarrera;
    }

    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }

    public function getPlantilla() {
        return $this->plantilla;
    }

    public function setPlantilla($plantilla) {
        $this->plantilla = $plantilla;
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
