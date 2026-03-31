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
class ApreguntaindicadorClass {
        
    var $idsiq_Apreguntaindicador=null;
    var $idsiq_Apregunta=null;
    var $disiq_indicador=null;
    var $codigoestado=null;
    var $usuariocreacion=null;
    var $usuariomodificacion=null;
    var $fechacreacion=null;
    var $fechamodificacion=null;
    var $ip=null;

    
    public function __construct() {
        
    }
    
    public function getIdsiq_Apreguntaindicador() {
        return $this->idsiq_Apreguntaindicador;
    }

    public function setIdsiq_Apreguntaindicador($idsiq_Apreguntaindicador) {
        $this->idsiq_Apreguntaindicador = $idsiq_Apreguntaindicador;
    }

    public function getIdsiq_Apregunta() {
        return $this->idsiq_Apregunta;
    }

    public function setIdsiq_Apregunta($idsiq_Apregunta) {
        $this->idsiq_Apregunta = $idsiq_Apregunta;
    }

    public function getDisiq_indicador() {
        return $this->disiq_indicador;
    }

    public function setDisiq_indicador($disiq_indicador) {
        $this->disiq_indicador = $disiq_indicador;
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
