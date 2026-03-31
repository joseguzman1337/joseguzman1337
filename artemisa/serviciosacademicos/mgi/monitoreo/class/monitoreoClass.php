<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of monitoreoClass
 *
 * @author proyecto_mgi_cp
 */
class monitoreoClass {
    
    var $idsiq_monitoreo = null;
    var $idPeriodicidad = null;
    var $fecha_prox_monitoreo = null;
    var $fin_de_mes = null;
    var $dia_predefinido = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_monitoreo() {
        return $this->idsiq_monitoreo;
    }

    public function setIdsiq_monitoreo($idsiq_monitoreo) {
        $this->idsiq_monitoreo = $idsiq_monitoreo;
    }

    public function getIdPeriodicidad() {
        return $this->idPeriodicidad;
    }

    public function setIdPeriodicidad($idPeriodicidad) {        
        if(strval($idPeriodicidad) === '0'){
            $this->idPeriodicidad = "NULL";
        } else {
            $this->idPeriodicidad = $idPeriodicidad;
        }
    }

    public function getFecha_prox_monitoreo() {
        return $this->fecha_prox_monitoreo;
    }

    public function setFecha_prox_monitoreo($fecha_prox_monitoreo) {
        $this->fecha_prox_monitoreo = $fecha_prox_monitoreo;
    }
    
    public function getFin_de_mes() {
        return $this->fin_de_mes;
    }

    public function setFin_de_mes($fin_de_mes) {       
        $this->fin_de_mes = $fin_de_mes;
    }
    
    public function getDia_predefinido() {
        return $this->dia_predefinido;
    }

    public function setDia_predefinido($dia_predefinido) {        
        if(strval($dia_predefinido) === '0'){
            $this->dia_predefinido = "NULL";
        } else {
            $this->dia_predefinido = $dia_predefinido;
        }
    }

    public function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    public function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    public function getUsuario_creacion() {
        return $this->usuario_creacion;
    }

    public function setUsuario_creacion($usuario_creacion) {
        $this->usuario_creacion = $usuario_creacion;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function getFecha_modificacion() {
        return $this->fecha_modificacion;
    }

    public function setFecha_modificacion($fecha_modificacion) {
        $this->fecha_modificacion = $fecha_modificacion;
    }

    public function getUsuario_modificacion() {
        return $this->usuario_modificacion;
    }

    public function setUsuario_modificacion($usuario_modificacion) {
        $this->usuario_modificacion = $usuario_modificacion;
    }
        
    public function __destruct() {
        
    }
}
?>
