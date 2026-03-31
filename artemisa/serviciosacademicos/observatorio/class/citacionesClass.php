
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
class citacionesClass {
        
var $idobs_citaciones=null;
var $idobs_resgitro_riesgo=null;
var $fechacitacion=null;
var $mensaje=null;
var $enviado=null;
var $codigoperiodo=null;
var $codigoestado=null;
var $fechacreacion=null;
var $usuariocreacion=null;
var $fechamodificacion=null;
var $usuariomodificacion=null;
var $ip=null;


    public function __construct() {
        
    }
    
    
    public function getIdobs_citaciones() {
        return $this->idobs_citaciones;
    }
    public function setIdobs_citaciones($idobs_citaciones) {
        $this->idobs_citaciones= $idobs_citaciones;
    }
    
    public function getIdobs_resgitro_riesgo() {
        return $this->idobs_resgitro_riesgo;
    }
    public function setIdobs_resgitro_riesgo($idobs_resgitro_riesgo) {
        $this->idobs_resgitro_riesgo= $idobs_resgitro_riesgo;
    }
    
    public function getFechacitacion() {
        return $this->fechacitacion;
    }
    public function setFechacitacion($fechacitacion) {
        $this->fechacitacion = $fechacitacion;
    }
    
    public function getMensaje() {
        return $this->mensaje;
    }
    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }
    
    public function getEnviado() {
        return $this->enviado;
    }
    public function setEnviado($enviado) {
        $this->enviado = $enviado;
    }
    
    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }
    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
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
