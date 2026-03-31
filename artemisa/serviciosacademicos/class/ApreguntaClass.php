<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of convenioClass
 *
 * @author Administrador
 */
class ApreguntaClass {
    //put your code here
    
    var $idsiq_Apregunta= null;
    var $titulo= null;
    var $descripcion= null;
    var $ayuda= null;
    var $obligatoria= null;
    var $tipopregunta= null;
    var $categoriapregunta= null;
    var $idsiq_incador= null;
    var $codigoestado= null;
    var $usuariocreacion= null;
    var $usuariomodificaicon= null;
    var $fechacreacion= null;
    var $fechamodificacion= null;
    var $idsiq_session= null;
    var $ip= null;
    
    function __construct() {
        
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

    public function getTipopregunta() {
        return $this->tipopregunta;
    }

    public function setTipopregunta($tipopregunta) {
        $this->tipopregunta = $tipopregunta;
    }

    public function getCategoriapregunta() {
        return $this->categoriapregunta;
    }

    public function setCategoriapregunta($categoriapregunta) {
        $this->categoriapregunta = $categoriapregunta;
    }

    public function getIdsiq_incador() {
        return $this->idsiq_incador;
    }

    public function setIdsiq_incador($idsiq_incador) {
        $this->idsiq_incador = $idsiq_incador;
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

    
    function __destruct() {
       
    }    
}


?>
