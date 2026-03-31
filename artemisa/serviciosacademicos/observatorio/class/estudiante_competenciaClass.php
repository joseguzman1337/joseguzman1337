
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of aspectoClass
 *
 * @author proyecto_obs Diana Sandoval
 */
class estudiante_competenciaClass {
        
var $idobs_estudiante_competencia=null;
var $codigoperiodo=null;
var $codigoestudiante=null;
var $idobs_competencias=null;
var $puntaje=null;
var $nivel=null;
var $quintil=null;
var $codigocarrera=null;
var $codigoestado=null;
var $fechacreacion=null;
var $usuariocreacion=null;
var $fechamodificacion=null;
var $usuariomodificacion=null;
var $ip=null;


    public function __construct() {
        
    }
    
    
    public function getIdobs_estudiante_competencia() {
        return $this->idobs_estudiante_competencia;
    }
    public function setIdobs_estudiante_competencia($idobs_estudiante_competencia) {
        $this->idobs_estudiante_competencia= $idobs_estudiante_competencia;
    }
    
    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }
    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }
    
    public function getCodigoestudiante() {
        return $this->codigoestudiante;
    }
    public function setCodigoestudiante($codigoestudiante) {
        $this->codigoestudiante= $codigoestudiante;
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
    
    public function getNivel() {
        return $this->nivel;
    }
    public function setNivel($nivel) {
        $this->nivel= $nivel;
    }
    
    public function getQuintil() {
        return $this->quintil;
    }
    public function setQuintil($quintil) {
        $this->quintil = $quintil;
    }
    
    public function getCodigocarrera() {
        return $this->codigocarrera;
    }
    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
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
