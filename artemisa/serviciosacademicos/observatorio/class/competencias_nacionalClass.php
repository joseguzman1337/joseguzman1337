
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of aspectoClass
 *
 * @author proyecto_obs Diana_Sandoval
 */
class competencias_nacionalClass {
        

var $idobs_competencias_nacional=null;
var $codigoperiodo=null;
var $puntaje=null;
var $idobs_competencias=null;
var $codigoestado=null;
var $fechacreacion=null;
var $usuariocreacion=null;
var $fechamodificacion=null;
var $usuariomodificacion=null;
var $ip=null;


    public function __construct() {
        
    }
    
    
    public function getIdobs_competencias_nacional() {
        return $this->idobs_competencias_nacional;
    }
    public function setIdobs_competencias_nacional($idobs_competencias_nacional) {
        $this->idobs_competencias_nacional= $idobs_competencias_nacional;
    }
    
    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }
    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }
    
    public function getIdobs_competencias() {
        return $this->idobs_competencias;
    }
    public function setIdobs_competencias($idobs_competencias) {
        $this->idobs_competencias= $idobs_competencias;
    }
    
    public function getPuntaje() {
        return $this->puntaje;
    }
    public function setPuntaje($puntaje) {
        $this->puntaje = $puntaje;
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
