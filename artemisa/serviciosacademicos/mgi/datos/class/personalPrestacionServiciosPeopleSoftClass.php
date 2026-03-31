<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of personalPrestacionServiciosPeopleSoftClass
 *
 * @author proyecto_mgi_cp
 */
class personalPrestacionServiciosPeopleSoftClass {

    var $idpersonalPrestacionServiciosPeopleSoft = null;
    var $codigoperiodo = null;
    var $acuerdoCompra = null;
    var $idProveedor = null;
    var $nombreProveedor = null;
    var $tipoDocumento = null;
    var $numeroDocumento = null;
    var $valorBruto = null;
    var $fechaInicio = null;
    var $fechaVencimiento = null;
    var $comentarios = null;
    var $centroCosto = null;
    var $numeroProyecto = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdpersonalPrestacionServiciosPeopleSoft() {
        return $this->idpersonalPrestacionServiciosPeopleSoft;
    }

    public function setIdpersonalPrestacionServiciosPeopleSoft($idpersonalPrestacionServiciosPeopleSoft) {
        $this->idpersonalPrestacionServiciosPeopleSoft = $idpersonalPrestacionServiciosPeopleSoft;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function getAcuerdoCompra() {
        return $this->acuerdoCompra;
    }

    public function setAcuerdoCompra($acuerdoCompra) {
        $this->acuerdoCompra = $acuerdoCompra;
    }

    public function getIdProveedor() {
        return $this->idProveedor;
    }

    public function setIdProveedor($idProveedor) {
        $this->idProveedor = $idProveedor;
    }

    public function getNombreProveedor() {
        return $this->nombreProveedor;
    }

    public function setNombreProveedor($nombreProveedor) {
        $this->nombreProveedor = $nombreProveedor;
    }

    public function getTipoDocumento() {
        return $this->tipoDocumento;
    }

    public function setTipoDocumento($tipoDocumento) {
        $this->tipoDocumento = $tipoDocumento;
    }

    public function getNumeroDocumento() {
        return $this->numeroDocumento;
    }

    public function setNumeroDocumento($numeroDocumento) {
        $this->numeroDocumento = $numeroDocumento;
    }

    public function getValorBruto() {
        return $this->valorBruto;
    }

    public function setValorBruto($valorBruto) {
        $this->valorBruto = $valorBruto;
    }

    public function getFechaInicio() {
        return $this->fechaInicio;
    }

    public function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

    public function getFechaVencimiento() {
        return $this->fechaVencimiento;
    }

    public function setFechaVencimiento($fechaVencimiento) {
        $this->fechaVencimiento = $fechaVencimiento;
    }

    public function getComentarios() {
        return $this->comentarios;
    }

    public function setComentarios($comentarios) {
        $this->comentarios = $comentarios;
    }

    public function getCentroCosto() {
        return $this->centroCosto;
    }

    public function setCentroCosto($centroCosto) {
        $this->centroCosto = $centroCosto;
    }

    public function getNumeroProyecto() {
        return $this->numeroProyecto;
    }

    public function setNumeroProyecto($numeroProyecto) {
        $this->numeroProyecto = $numeroProyecto;
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
