<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of funcionIndicador
 *
 * @author proyecto_mgi_cp
 */
class funcionIndicadoresClass {
    //put your code here
    
    var $idsiq_funcionIndicadores = null;
    var $idsiq_funcion = null;
    var $idIndicador = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    var $ip_modificacion = null;
    
    public function __construct() {
        
    }
    public function getIdsiq_funcionIndicadores() {
        return $this->idsiq_funcionIndicadores;
    }

    public function setIdsiq_funcionIndicadores($idsiq_funcionIndicadores) {
        $this->idsiq_funcionIndicadores = $idsiq_funcionIndicadores;
    }

    public function getIdsiq_funcion() {
        return $this->idsiq_funcion;
    }

    public function setIdsiq_funcion($idsiq_funcion) {
        $this->idsiq_funcion = $idsiq_funcion;
    }

    public function getIdIndicador() {
        return $this->idIndicador;
    }

    public function setIdIndicador($idIndicador) {
        $this->idIndicador = $idIndicador;
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

    public function getIp_modificacion() {
        return $this->ip_modificacion;
    }

    public function setIp_modificacion($ip_modificacion) {
        $this->ip_modificacion = $ip_modificacion;
    }

           public function __destruct() {
        
    }
}

?>
