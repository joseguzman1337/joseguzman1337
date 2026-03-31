<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detalleCursoEducacionContinuadaClass
 *
 * @author proyecto_mgi_cp
 */
class detalleCursoEducacionContinuadaClass {
    
    var $iddetalleCursoEducacionContinuada = null;
    var $codigocarrera = null;
    var $actividad = null;
    var $categoria = null;
    var $ciudad = null;
    var $autorizacion = null;
    var $nucleoEstrategico = null;
    var $intensidad = null;
    var $modalidadCertificacion = null;
    var $tipoCertificacion = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    var $porcentajeFallasPermitidas = null;
    var $generaOrdenAutomatica = null;
    
    public function __construct() {
        
    }
    
    public function getIddetalleCursoEducacionContinuada() {
        return $this->iddetalleCursoEducacionContinuada;
    }

    public function setIddetalleCursoEducacionContinuada($iddetalleCursoEducacionContinuada) {
        $this->iddetalleCursoEducacionContinuada = $iddetalleCursoEducacionContinuada;
    }

    public function getCodigocarrera() {
        return $this->codigocarrera;
    }

    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }

    public function getActividad() {
        return $this->actividad;
    }

    public function setActividad($actividad) {
        $this->actividad = $actividad;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    public function getCiudad() {
        return $this->ciudad;
    }

    public function setCiudad($ciudad) {
        $this->ciudad = $ciudad;
    }

    public function getNucleoEstrategico() {
        return $this->nucleoEstrategico;
    }

    public function setNucleoEstrategico($nucleoEstrategico) {
        $this->nucleoEstrategico = $nucleoEstrategico;
    }

    public function getIntensidad() {
        return $this->intensidad;
    }

    public function setIntensidad($intensidad) {
        $this->intensidad = $intensidad;
    }

    public function getModalidadCertificacion() {
        return $this->modalidadCertificacion;
    }

    public function setModalidadCertificacion($modalidadCertificacion) {
        $this->modalidadCertificacion = $modalidadCertificacion;
    }

    public function getTipoCertificacion() {
        return $this->tipoCertificacion;
    }

    public function setTipoCertificacion($tipoCertificacion) {
        $this->tipoCertificacion = $tipoCertificacion;
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
    
    public function getPorcentajeFallasPermitidas() {
        return $this->porcentajeFallasPermitidas;
    }

    public function setPorcentajeFallasPermitidas($porcentajeFallasPermitidas) {
        $this->porcentajeFallasPermitidas = $porcentajeFallasPermitidas;
    }
    
    public function getAutorizacion() {
        return $this->autorizacion;
    }

    public function setAutorizacion($autorizacion) {
        $this->autorizacion = $autorizacion;
    }
    
    public function getGeneraOrdenAutomatica() {
        return $this->generaOrdenAutomatica;
    }

    public function setGeneraOrdenAutomatica($generaOrdenAutomatica) {
        $this->generaOrdenAutomatica = $generaOrdenAutomatica;
    }
                
    public function __destruct() {
        
    }
}
?>
