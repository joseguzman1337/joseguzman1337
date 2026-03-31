<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of funcionTipo2Class
 *
 * @author proyecto_mgi_cp
 */
class funcionTipo2Class {
    //put your code here
    
    var $idsiq_funcionTipo2= null;
    var $funcionIndicadores = null;
    var $idPeriodo = null;
    var $tipo= null;
    var $idtipo1valor1= null;
    var $idtipo1valor2= null;
    var $resultado= null;
    var $porcentaje= null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $usuario_modificacion = null;
    var $fecha_modificacion = null;
    var $ip_modificacion = null;
    
     public function __construct() {
        
    }
    
    public function getIdsiq_funcionTipo2() {
        return $this->idsiq_funcionTipo2;
    }

    public function setIdsiq_funcionTipo2($idsiq_funcionTipo2) {
        $this->idsiq_funcionTipo2 = $idsiq_funcionTipo2;
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

    public function getIdtipo1valor1() {
        return $this->idtipo1valor1;
    }

    public function setIdtipo1valor1($idtipo1valor1) {
        $this->idtipo1valor1 = $idtipo1valor1;
    }

    public function getIdtipo1valor2() {
        return $this->idtipo1valor2;
    }

    public function setIdtipo1valor2($idtipo1valor2) {
        $this->idtipo1valor2 = $idtipo1valor2;
    }

    public function getResultado() {
        return $this->resultado;
    }

    public function setResultado($resultado) {
        $this->resultado = $resultado;
    }

    public function getPorcentaje() {
        return $this->porcentaje;
    }

    public function setPorcentaje($porcentaje) {
        $this->porcentaje = $porcentaje;
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

    public function getUsuario_modificacion() {
        return $this->usuario_modificacion;
    }

    public function setUsuario_modificacion($usuario_modificacion) {
        $this->usuario_modificacion = $usuario_modificacion;
    }

    public function getFecha_modificacion() {
        return $this->fecha_modificacion;
    }

    public function setFecha_modificacion($fecha_modificacion) {
        $this->fecha_modificacion = $fecha_modificacion;
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
