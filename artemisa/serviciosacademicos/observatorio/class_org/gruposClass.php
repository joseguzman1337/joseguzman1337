
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
class gruposClass {
        
var $idobs_grupos=null; 
var $nombregrupos=null; 
var $descripciongrupos=null; 
var $codigomodalidadacademica=null; 
var $codigocarrera=null; 
var $codigoperiodo=null; 
var $iddocente=null; 
var $codigoestudiante=null;
var $codigoestado=null; 
var $usuariocreacion=null; 
var $usuariomodificacion=null; 
var $fechacreacion=null; 
var $fechamodificacion=null; 
var $ip=null; 


    public function __construct() {
        
    }
    
   
    public function getIdobs_grupos() {
        return $this->idobs_grupos;
    }

    public function setIdobs_grupos($idobs_grupos) {
        $this->idobs_grupos = $idobs_grupos;
    }

    public function getNombregrupos() {
        return $this->nombregrupos;
    }

    public function setNombregrupos($nombregrupos) {
        $this->nombregrupos = $nombregrupos;
    }

    public function getDescripciongrupos() {
        return $this->descripciongrupos;
    }

    public function setDescripciongrupos($descripciongrupos) {
        $this->descripciongrupos = $descripciongrupos;
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
    
     public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }
    
   public function getIddocente() {
        return $this->iddocente;
    }

    public function setIddocente($iddocente) {
        $this->iddocente = $iddocente;
    }
    
    public function getCodigoestudiante() {
        return $this->codigoestudiante;
    }

    public function setCodigoestudiante($codigoestudiante) {
        $this->codigoestudiante = $codigoestudiante;
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
