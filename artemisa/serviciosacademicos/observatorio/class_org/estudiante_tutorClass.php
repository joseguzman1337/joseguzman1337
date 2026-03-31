
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
class estudiante_tutorClass {
        
var $idobs_estudiante_tutor=null;
var $codigoperiodo=null;
var $codigoestudiante=null;
var $codigomodalidadacademica=null;
var $codigocarrera=null;
var $codigomateria=null;
var $codigoestado=null;
var $fechacreacion=null;
var $usuariocreacion=null;
var $fechamodificacion=null;
var $usuariomodificacion=null;
var $ip=null;


    public function __construct() {
        
    }
    
    
    public function getIdobs_estudiante_tutor() {
        return $this->idobs_estudiante_tutor;
    }
    public function setIdobs_estudiante_tutor($idobs_estudiante_tutor) {
        $this->idobs_estudiante_tutor= $idobs_estudiante_tutor;
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
    
    public function getCodigomodalidadacademica() {
        return $this->codigomodalidadacademica;
    }
    public function setCodigomodalidadacademica($codigomodalidadacademica) {
        $this->codigomodalidadacademica = $codigomodalidadacademica;
    }
    
    public function getCodigocarrera() {
        return $this->codigocarrera;
    }
    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }
    
    public function getCodigomateria() {
        return $this->codigomateria;
    }
    public function setCodigomateria($codigomateria) {
        $this->codigomateria = $codigomateria;
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
