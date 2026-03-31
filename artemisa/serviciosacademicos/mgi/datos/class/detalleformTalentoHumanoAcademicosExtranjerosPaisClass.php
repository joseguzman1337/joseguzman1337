<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detalleformTalentoHumanoAcademicosExtranjerosPaisClassClass
 *
 * @author proyecto_mgi_cp
 */
class detalleformTalentoHumanoAcademicosExtranjerosPaisClass {
    
    var $idsiq_detalleformTalentoHumanoAcademicosExtranjerosPais = null;
    var $idData = null;
    var $idCategory = null;
    var $valor = null;
    var $verificada = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_detalleformTalentoHumanoAcademicosExtranjerosPais() {
        return $this->idsiq_detalleformTalentoHumanoAcademicosExtranjerosPais;
    }

    public function setIdsiq_detalleformTalentoHumanoAcademicosExtranjerosPais($idsiq_detalleformTalentoHumanoAcademicosExtranjerosPais) {
        $this->idsiq_detalleformTalentoHumanoAcademicosExtranjerosPais = $idsiq_detalleformTalentoHumanoAcademicosExtranjerosPais;
    }

    public function getIdData() {
        return $this->idData;
    }

    public function setIdData($idData) {
        $this->idData = $idData;
    }

    public function getIdCategory() {
        return $this->idCategory;
    }

    public function setIdCategory($idCategory) {
        $this->idCategory = $idCategory;
    }

    public function getValor() {
        return $this->valor;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }
    
    public function getVerificada() {
        return $this->verificada;
    }

    public function setVerificada($verificada) {
        $this->verificada = $verificada;
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
