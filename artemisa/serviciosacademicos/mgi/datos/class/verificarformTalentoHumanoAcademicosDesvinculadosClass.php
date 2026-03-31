<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of verificarformTalentoHumanoAcademicosDesvinculadosClass
 *
 * @author proyecto_mgi_cp
 */
class verificarformTalentoHumanoAcademicosDesvinculadosClass {
    
    var $idsiq_verificarformTalentoHumanoAcademicosDesvinculados = null;
    var $codigoperiodo = null;
    var $vnumTerminacionContrato = "0";
    var $vnumRenunciaOportunidad = "0";
    var $vnumRenunciaMotivosPersonales = "0";
    var $vnumRenunciaCondicionesLaborales = "0";
    var $vnumRenunciaViaje = "0";
    var $vnumDespido = "0";
    var $vnumOtro = "0";
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_verificarformTalentoHumanoAcademicosDesvinculados() {
        return $this->idsiq_verificarformTalentoHumanoAcademicosDesvinculados;
    }

    public function setIdsiq_verificarformTalentoHumanoAcademicosDesvinculados($idsiq_verificarformTalentoHumanoAcademicosDesvinculados) {
        $this->idsiq_verificarformTalentoHumanoAcademicosDesvinculados = $idsiq_verificarformTalentoHumanoAcademicosDesvinculados;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function getVnumTerminacionContrato() {
        return $this->vnumTerminacionContrato;
    }

    public function setVnumTerminacionContrato($vnumTerminacionContrato) {
        $this->vnumTerminacionContrato = $vnumTerminacionContrato;
    }

    public function getVnumRenunciaOportunidad() {
        return $this->vnumRenunciaOportunidad;
    }

    public function setVnumRenunciaOportunidad($vnumRenunciaOportunidad) {
        $this->vnumRenunciaOportunidad = $vnumRenunciaOportunidad;
    }

    public function getVnumRenunciaMotivosPersonales() {
        return $this->vnumRenunciaMotivosPersonales;
    }

    public function setVnumRenunciaMotivosPersonales($vnumRenunciaMotivosPersonales) {
        $this->vnumRenunciaMotivosPersonales = $vnumRenunciaMotivosPersonales;
    }

    public function getVnumRenunciaCondicionesLaborales() {
        return $this->vnumRenunciaCondicionesLaborales;
    }

    public function setVnumRenunciaCondicionesLaborales($vnumRenunciaCondicionesLaborales) {
        $this->vnumRenunciaCondicionesLaborales = $vnumRenunciaCondicionesLaborales;
    }

    public function getVnumRenunciaViaje() {
        return $this->vnumRenunciaViaje;
    }

    public function setVnumRenunciaViaje($vnumRenunciaViaje) {
        $this->vnumRenunciaViaje = $vnumRenunciaViaje;
    }

    public function getVnumDespido() {
        return $this->vnumDespido;
    }

    public function setVnumDespido($vnumDespido) {
        $this->vnumDespido = $vnumDespido;
    }

    public function getVnumOtro() {
        return $this->vnumOtro;
    }

    public function setVnumOtro($vnumOtro) {
        $this->vnumOtro = $vnumOtro;
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
