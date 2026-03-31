<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of aspectoClass
 *
 * @author proyecto_mgi_cp
 */
class ApreguntaClass {
        
    var $idsiq_Apregunta = null;
    var $titulo = null;
    var $descripcion = null;
    var $ayuda = null;
    var $obligatoria = null;
    var $RequiereJustificacion = null;
    var $idsiq_Atipopregunta = null;
    var $categoriapregunta = null;
    var $verificada=null;
    var $codigoestado = null;
    var $usuariocreacion = null;
    var $usuariomodificaicon = null;
    var $fechacreacion = null;
    var $fechamodificacion = null;
    var $idsiq_session = null;
    var $ip = null;
    var $cat_ins=null;
    var $codigocarrera=null;
    
    
    
    public function __construct() {
        
    }
    
    public function getIdsiq_Apregunta() {
        return $this->idsiq_Apregunta;
    }

    public function setIdsiq_Apregunta($idsiq_Apregunta) {
        $this->idsiq_Apregunta = $idsiq_Apregunta;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getAyuda() {
        return $this->ayuda;
    }

    public function setAyuda($ayuda) {
        $this->ayuda = $ayuda;
    }

    public function getObligatoria() {
        return $this->obligatoria;
    }

    public function setObligatoria($obligatoria) {
        $this->obligatoria = $obligatoria;
    }

    public function getRequiereJustificacion() {
        return $this->RequiereJustificacion;
    }

    public function setRequiereJustificacion($RequiereJustificacion) {
        $this->RequiereJustificacion = $RequiereJustificacion;
    }

    public function getIdsiq_Atipopregunta() {
        return $this->idsiq_Atipopregunta;
    }

    public function setIdsiq_Atipopregunta($idsiq_Atipopregunta) {
        $this->idsiq_Atipopregunta = $idsiq_Atipopregunta;
    }

    public function getCategoriapregunta() {
        return $this->categoriapregunta;
    }

    public function setCategoriapregunta($categoriapregunta) {
        $this->categoriapregunta = $categoriapregunta;
    }

    public function getVerificada() {
        return $this->verificada;
    }

    public function setVerificada($verificada) {
        $this->verificada = $verificada;
    }

        
    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function getUsuariocreacion() {
        return $this->usuariocreacion;
    }

    public function setUsuariocreacion($usuariocreacion) {
        $this->usuariocreacion = $usuariocreacion;
    }

    public function getUsuariomodificaicon() {
        return $this->usuariomodificaicon;
    }

    public function setUsuariomodificaicon($usuariomodificaicon) {
        $this->usuariomodificaicon = $usuariomodificaicon;
    }

    public function getFechacreacion() {
        return $this->fechacreacion;
    }

    public function setFechacreacion($fechacreacion) {
        $this->fechacreacion = $fechacreacion;
    }

    public function getFechamodificacion() {
        return $this->fechamodificacion;
    }

    public function setFechamodificacion($fechamodificacion) {
        $this->fechamodificacion = $fechamodificacion;
    }

    public function getIdsiq_session() {
        return $this->idsiq_session;
    }

    public function setIdsiq_session($idsiq_session) {
        $this->idsiq_session = $idsiq_session;
    }

    public function getIp() {
        return $this->ip;
    }

    public function setIp($ip) {
        $this->ip = $ip;
    }
    
    public function getCat_ins() {
        return $this->cat_ins;
    }

    public function setCat_ins($cat_ins) {
        $this->cat_ins = $cat_ins;
    }

    public function getCodigocarrera() {
        return $this->codigocarrera;
    }

    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }

            
    public function __destruct() {
        
    }
}
?>
