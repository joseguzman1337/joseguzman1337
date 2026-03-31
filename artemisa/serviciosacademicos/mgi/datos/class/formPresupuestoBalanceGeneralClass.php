<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formPresupuestoBalanceGeneralClass
 *
 * @author proyecto_mgi_cp
 */
class formPresupuestoBalanceGeneralClass {
    var $idsiq_formPresupuestoBalanceGeneral = null;
    var $codigoperiodo = null;
    var $idtipoBalance = null;
    var $valor = null;    
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    public function __construct() {
        
    }
    
    public function getIdsiq_formPresupuestoBalanceGeneral() {
        return $this->idsiq_formPresupuestoBalanceGeneral;
    }

    public function setIdsiq_formPresupuestoBalanceGeneral($idsiq_formPresupuestoBalanceGeneral) {
        $this->idsiq_formPresupuestoBalanceGeneral = $idsiq_formPresupuestoBalanceGeneral;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function getIdTipoBalance() {
        return $this->idtipoBalance;
    }

    public function setIdTipoBalance($idtipoBalance) {
        $this->idtipoBalance = $idtipoBalance;
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
        
    public function __destruct() {
        
    }
}
?>
