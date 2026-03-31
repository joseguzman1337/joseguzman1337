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
class AinstrumentoanalisisClass {
        
var $idsiq_Ainstrumentoanalisis=null;
var $idsiq_Ainstrumentoconfiguracion=null;
var $idsiq_Apregunta=null;
var $analisis=null;
var $codigoestado=null;
var $usuariocreacion=null;
var $usuariomodificacion=null;
var $fechacreacion=null;
var $fechamodificacion=null;
var $ip=null;


    public function __construct() {
        
    }
    
    public function getIdsiq_Ainstrumentoanalisis() {
        return $this->idsiq_Ainstrumentoanalisis;
    }

    public function setIdsiq_Ainstrumentoanalisis($idsiq_Ainstrumentoanalisis) {
        $this->idsiq_Ainstrumentoanalisis = $idsiq_Ainstrumentoanalisis;
    }

    public function getIdsiq_Ainstrumentoconfiguracion() {
        return $this->idsiq_Ainstrumentoconfiguracion;
    }

    public function setIdsiq_Ainstrumentoconfiguracion($idsiq_Ainstrumentoconfiguracion) {
        $this->idsiq_Ainstrumentoconfiguracion = $idsiq_Ainstrumentoconfiguracion;
    }

    public function getIdsiq_Apregunta() {
        return $this->idsiq_Apregunta;
    }

    public function setIdsiq_Apregunta($idsiq_Apregunta) {
        $this->idsiq_Apregunta = $idsiq_Apregunta;
    }
    
    public function getAnalisis() {
        return $this->analisis;
    }

    public function setAnalisis($analisis) {
        $this->analisis = $analisis;
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

    public function getUsuariomodificacion() {
        return $this->usuariomodificacion;
    }

    public function setUsuariomodificacion($usuariomodificacion) {
        $this->usuariomodificacion = $usuariomodificacion;
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

    public function getIp() {
        return $this->ip;
    }

    public function setIp($ip) {
        $this->ip = $ip;
    }

        
    
                        
    public function __destruct() {
        
    }
}
?>
