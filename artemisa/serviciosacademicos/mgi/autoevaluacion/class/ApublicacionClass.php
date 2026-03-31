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
class ApublicacionClass {
        
var $idsiq_Apublicacion=null;   
var $idsiq_Ainstrumentoconfiguracion=null;
var $publicar=null;
var $fechahorainicio=null;
var $fechahorafin=null;
var $codigoestado=null;
var $usuariocreacion=null;
var $usuariomodificacion=null;
var $fechacreacion=null;
var $fechamodificacion=null;
var $ip=null;


    public function __construct() {
        
    }
    
    public function getIdsiq_Apublicacion() {
        return $this->idsiq_Apublicacion;
    }

    public function setIdsiq_Apublicacion($idsiq_Apublicacion) {
        $this->idsiq_Apublicacion = $idsiq_Apublicacion;
    }

    public function getIdsiq_Ainstrumentoconfiguracion() {
        return $this->idsiq_Ainstrumentoconfiguracion;
    }

    public function setIdsiq_Ainstrumentoconfiguracion($idsiq_Ainstrumentoconfiguracion) {
        $this->idsiq_Ainstrumentoconfiguracion = $idsiq_Ainstrumentoconfiguracion;
    }

    public function getPublicar() {
        return $this->publicar;
    }

    public function setPublicar($publicar) {
        $this->publicar = $publicar;
    }

    public function getFechahorainicio() {
        return $this->fechahorainicio;
    }

    public function setFechahorainicio($fechahorainicio) {
        $this->fechahorainicio = $fechahorainicio;
    }

    public function getFechahorafin() {
        return $this->fechahorafin;
    }

    public function setFechahorafin($fechahorafin) {
        $this->fechahorafin = $fechahorafin;
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
