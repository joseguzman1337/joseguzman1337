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
class AseccionClass {
        
   
var $idsiq_Aseccion=null;
var $nombre=null;
var $descripcion=null;
var $sin_seccion=null;
var $codigoestado=null;
var $usuariocreacion=null;
var $usuariomodificacion=null;
var $fechacreacion=null;
var $fechamodificacion=null;
var $ip=null;
var $cat_ins=null;
    var $codigocarrera=null;

    
    
    
    public function __construct() {
        
    }
    
    public function getIdsiq_Aseccion() {
        return $this->idsiq_Aseccion;
    }

    public function setIdsiq_Aseccion($idsiq_Aseccion) {
        $this->idsiq_Aseccion = $idsiq_Aseccion;
    }

    
    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    
    public function getSin_seccion() {
        return $this->sin_seccion;
    }

    public function setSin_seccion($sin_seccion) {
        $this->sin_seccion = $sin_seccion;
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

    public function getCat_ins() {
        return $this->cat_ins;
    }

    public function setCat_ins($cat_ins) {
        $this->cat_ins = $cat_ins;
    }

    public function getCodigocarrera() {
        return $this->codigocarrera;
    }

    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }
         
    public function __destruct() {
        
    }
}
?>
