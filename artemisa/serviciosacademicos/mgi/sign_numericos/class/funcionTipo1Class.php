<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of funcionTipo1Class
 *
 * @author proyecto_mgi_cp
 */
class funcionTipo1Class {
    
    var $idsiq_funcionTipo1= null;
    var $funcionIndicadores = null;
    var $idPeriodo = null;
    var $tipo= null;
    var $valor = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    var $ip_modificacion = null;
    
    //put your code here
    
    
     public function __construct() {
        
    }
    
    public function getIdsiq_funcionTipo1() {
        return $this->idsiq_funcionTipo1;
    }

    public function setIdsiq_funcionTipo1($idsiq_funcionTipo1) {
        $this->idsiq_funcionTipo1 = $idsiq_funcionTipo1;
    }

    public function getFuncionIndicadores() {
        return $this->funcionIndicadores;
    }

    public function setFuncionIndicadores($funcionIndicadores) {
        $this->funcionIndicadores = $funcionIndicadores;
    }

    public function getIdPeriodo() {
        return $this->idPeriodo;
    }

    public function setIdPeriodo($idPeriodo) {
        $this->idPeriodo = $idPeriodo;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getValor() {
        return $this->valor;
    }

    public function setValor($valor) {
        $this->valor = $valor;
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
