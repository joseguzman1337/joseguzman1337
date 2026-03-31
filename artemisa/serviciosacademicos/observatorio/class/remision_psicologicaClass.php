
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
class remision_psicologicaClass {
        
var $idobs_remision_psicologica=null;
var $idobs_registro_riesgo=null;
var $codigoestudiante=null;
var $descripcion1remision_psicologica=null;
var $descripcion2remision_psicologica=null;
var $calificacion=null;
var $codigoperiodo=null;
var $codigoestado=null;
var $fechacreacion=null;
var $usuariocreacion=null;
var $fechamodificacion=null;
var $usuariomodificacion=null;
var $ip=null;


    public function __construct() {
        
    }
    
    
    public function getIdobs_remision_psicologica() {
        return $this->idobs_remision_psicologica;
    }
    public function setIdobs_remision_psicologica($idobs_remision_psicologica) {
        $this->idobs_remision_psicologica= $idobs_remision_psicologica;
    }
    
    public function getIdobs_registro_riesgo() {
        return $this->idobs_registro_riesgo;
    }
    public function setIdobs_registro_riesgo($idobs_registro_riesgo) {
        $this->idobs_registro_riesgo= $idobs_registro_riesgo;
    }

    public function getCodigoestudiante() {
        return $this->codigoestudiante;
    }
    public function setCodigoestudiante($codigoestudiante) {
        $this->codigoestudiante = $codigoestudiante;
    }
    
    public function getDescripcion1remision_psicologica() {
        return $this->descripcion1remision_psicologica;
    }
    public function setDescripcion1remision_psicologica($descripcion1remision_psicologica) {
        $this->descripcion1remision_psicologica = $descripcion1remision_psicologica;
    }
    
    public function getDescripcion2remision_psicologica() {
        return $this->descripcion2remision_psicologica;
    }
    public function setDescripcion2remision_psicologica($descripcion2remision_psicologica) {
        $this->descripcion2remision_psicologica = $descripcion2remision_psicologica;
    }
    
    public function getCalificacion() {
        return $this->calificacion;
    }
    public function setCalificacion($calificacion) {
        $this->calificacion = $calificacion;
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
