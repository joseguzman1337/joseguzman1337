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
class AinstrumentoconfiguracionClass {
        
   
var $idsiq_Ainstrumentoconfiguracion=null;
var $nombre=null;
var $mostrar_bienvenida=null;
var $mostrar_despedida=null;
var $fecha_inicio=null;
var $fecha_fin=null;
var $estado=null;
var $secciones=null;
var $codigoestado=null;
var $usuariocreacion=null;
var $usuariomodificacion=null;
var $fechacreacion=null;
var $fechamodificacion=null;
var $ip=null;
var $aprobada=null;
var $idsiq_discriminacionIndicador=null;
var $codigocarrera=null;
var $idsiq_periodicidad=null;
var $codigomodalidadacademica=null;
var $cat_ins=null;

    
    
    
    public function __construct() {
        
    }
    
    public function getIdsiq_Ainstrumentoconfiguracion() {
        return $this->idsiq_Ainstrumentoconfiguracion;
    }

    public function setIdsiq_Ainstrumentoconfiguracion($idsiq_Ainstrumentoconfiguracion) {
        $this->idsiq_Ainstrumentoconfiguracion = $idsiq_Ainstrumentoconfiguracion;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getMostrar_bienvenida() {
        return $this->mostrar_bienvenida;
    }

    public function setMostrar_bienvenida($mostrar_bienvenida) {
        $this->mostrar_bienvenida = $mostrar_bienvenida;
    }

    public function getMostrar_despedida() {
        return $this->mostrar_despedida;
    }

    public function setMostrar_despedida($mostrar_despedida) {
        $this->mostrar_despedida = $mostrar_despedida;
    }

    public function getFecha_inicio() {
        return $this->fecha_inicio;
    }

    public function setFecha_inicio($fecha_inicio) {
        $this->fecha_inicio = $fecha_inicio;
    }

    public function getFecha_fin() {
        return $this->fecha_fin;
    }

    public function setFecha_fin($fecha_fin) {
        $this->fecha_fin = $fecha_fin;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function getSecciones() {
        return $this->secciones;
    }

    public function setSecciones($secciones) {
        $this->secciones = $secciones;
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

    public function getAprobada() {
        return $this->aprobada;
    }

    public function setAprobada($aprobada) {
        $this->aprobada = $aprobada;
    }
    
    public function getIdsiq_discriminacionIndicador() {
        return $this->idsiq_discriminacionIndicador;
    }

    public function setIdsiq_discriminacionIndicador($idsiq_discriminacionIndicador) {
        $this->idsiq_discriminacionIndicador = $idsiq_discriminacionIndicador;
    }

    public function getCodigocarrera() {
        return $this->codigocarrera;
    }
    
    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function setCodigocarrera($codigocarrera) {
       if (strval($codigocarrera)==0){
           $this->codigocarrera = "NULL";
       }else{
           $this->codigocarrera = $codigocarrera;
       }
        
    }

    public function getIdsiq_periodicidad() {
        return $this->idsiq_periodicidad;
    }

    public function setIdsiq_periodicidad($idsiq_periodicidad) {
        $this->idsiq_periodicidad = $idsiq_periodicidad;
    }

    public function getCodigomodalidadacademica() {
        return $this->codigomodalidadacademica;
    }

    public function setCodigomodalidadacademica($codigomodalidadacademica) {
        if (strval($codigomodalidadacademica)==0){
           $this->codigomodalidadacademica = "NULL";
       }else{
           $this->codigomodalidadacademica = $codigomodalidadacademica;
       }
        
    }

      public function getCat_ins() {
        return $this->cat_ins;
    }

    public function setCat_ins($cat_ins) {
        $this->cat_ins = $cat_ins;
    }   
    public function __destruct() {
        
    }
}
?>
