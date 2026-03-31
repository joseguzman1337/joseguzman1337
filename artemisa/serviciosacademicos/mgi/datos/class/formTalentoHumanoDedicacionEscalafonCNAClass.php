<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formTalentoHumanoDedicacionEscalafonCNAClass
 *
 * @author proyecto_mgi_cp
 */
class formTalentoHumanoDedicacionEscalafonCNAClass {
    var $idsiq_formTalentoHumanoDedicacionEscalafonCNA = null;
    var $codigoperiodo = null;
    var $idTalentoEscalafon = null;
    var $catedraTiempo = null;
    var $medioTiempo = null;    
    var $completoTiempo = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    public function __construct() {
        
    }
    
    public function getIdsiq_formTalentoHumanoDedicacionEscalafonCNA() {
        return $this->idsiq_formTalentoHumanoDedicacionEscalafonCNA;
    }

    public function setIdsiq_formTalentoHumanoDedicacionEscalafonCNA($idsiq_formTalentoHumanoDedicacionEscalafonCNA) {
        $this->idsiq_formTalentoHumanoDedicacionEscalafonCNA = $idsiq_formTalentoHumanoDedicacionEscalafonCNA;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function getIdTalentoEscalafon() {
        return $this->idTalentoEscalafon;
    }

    public function setIdTalentoEscalafon($idTalentoEscalafon) {
        $this->idTalentoEscalafon = $idTalentoEscalafon;
    }

    public function getCatedraTiempo() {
        return $this->catedraTiempo;
    }

    public function setCatedraTiempo($catedraTiempo) {
        $this->catedraTiempo = $catedraTiempo;
    }

    public function getMedioTiempo() {
        return $this->medioTiempo;
    }

    public function setMedioTiempo($medioTiempo) {
        $this->medioTiempo = $medioTiempo;
    }

    public function getCompletoTiempo() {
        return $this->completoTiempo;
    }

    public function setCompletoTiempo($completoTiempo) {
        $this->completoTiempo = $completoTiempo;
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
