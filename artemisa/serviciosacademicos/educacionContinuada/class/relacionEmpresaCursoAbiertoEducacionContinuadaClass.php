<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of relacionEmpresaCursoAbiertoEducacionContinuadaClass
 *
 * @author proyecto_mgi_cp
 */
class relacionEmpresaCursoAbiertoEducacionContinuadaClass {
    
    var $idrelacionEmpresaCursoAbiertoEducacionContinuada = null;
    var $idEmpresa = null;
    var $idCarrera = null;
    var $idEstudianteGeneral = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdrelacionEmpresaCursoAbiertoEducacionContinuada() {
        return $this->idrelacionEmpresaCursoAbiertoEducacionContinuada;
    }

    public function setIdrelacionEmpresaCursoAbiertoEducacionContinuada($idrelacionEmpresaCursoAbiertoEducacionContinuada) {
        $this->idrelacionEmpresaCursoAbiertoEducacionContinuada = $idrelacionEmpresaCursoAbiertoEducacionContinuada;
    }

    public function getIdEmpresa() {
        return $this->idEmpresa;
    }

    public function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    public function getIdCarrera() {
        return $this->idCarrera;
    }

    public function setIdCarrera($idCarrera) {
        $this->idCarrera = $idCarrera;
    }

    public function getIdEstudianteGeneral() {
        return $this->idEstudianteGeneral;
    }

    public function setIdEstudianteGeneral($idEstudianteGeneral) {
        $this->idEstudianteGeneral = $idEstudianteGeneral;
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
