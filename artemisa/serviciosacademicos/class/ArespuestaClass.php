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
class ArespuestaClass {
    //put your code here
    
    var $idsiq_respuesta= null;
    var $idsiq_pregunta= null;
    var $respuesta= null;
    var $valor= null;
    var $correcta= null;
    var $codigoestado= null;
    var $usuariocreacion= null;
    var $usuariomodificacion= null;
    var $fechacreacion= null;
    var $fechamodificacion= null;
    var $ip= null;
    
    function __construct() {
        
    }
    
    public function getIdsiq_respuesta() {
        return $this->idsiq_respuesta;
    }

    public function setIdsiq_respuesta($idsiq_respuesta) {
        $this->idsiq_respuesta = $idsiq_respuesta;
    }

    public function getIdsiq_pregunta() {
        return $this->idsiq_pregunta;
    }

    public function setIdsiq_pregunta($idsiq_pregunta) {
        $this->idsiq_pregunta = $idsiq_pregunta;
    }

    public function getRespuesta() {
        return $this->respuesta;
    }

    public function setRespuesta($respuesta) {
        $this->respuesta = $respuesta;
    }

    public function getValor() {
        return $this->valor;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function getCorrecta() {
        return $this->correcta;
    }

    public function setCorrecta($correcta) {
        $this->correcta = $correcta;
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

    

    
    function __destruct() {
       
    }    
}


?>