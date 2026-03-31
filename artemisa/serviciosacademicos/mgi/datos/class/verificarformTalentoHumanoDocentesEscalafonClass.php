<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of verificarformTalentoHumanoDocentesEscalafonClass
 *
 * @author proyecto_mgi_cp
 */
class verificarformTalentoHumanoDocentesEscalafonClass {
    
    var $idsiq_verificarformTalentoHumanoDocentesEscalafon = null;
    var $codigoperiodo = null;
    var $vnumAcademicosPTitular = "0";
    var $vnumAcademicosPAsociado = "0";
    var $vnumAcademicosPAsistente = "0";
    var $vnumAcademicosIAsociado = "0";
    var $vnumAcademicosIAsistente = "0";
    var $vnumAcademicosOtros = "0";
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_verificarformTalentoHumanoDocentesEscalafon() {
        return $this->idsiq_verificarformTalentoHumanoDocentesEscalafon;
    }

    public function setIdsiq_verificarformTalentoHumanoDocentesEscalafon($idsiq_verificarformTalentoHumanoDocentesEscalafon) {
        $this->idsiq_verificarformTalentoHumanoDocentesEscalafon = $idsiq_verificarformTalentoHumanoDocentesEscalafon;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function getVnumAcademicosPTitular() {
        return $this->vnumAcademicosPTitular;
    }

    public function setVnumAcademicosPTitular($vnumAcademicosPTitular) {
        $this->vnumAcademicosPTitular = $vnumAcademicosPTitular;
    }

    public function getVnumAcademicosPAsociado() {
        return $this->vnumAcademicosPAsociado;
    }

    public function setVnumAcademicosPAsociado($vnumAcademicosPAsociado) {
        $this->vnumAcademicosPAsociado = $vnumAcademicosPAsociado;
    }

    public function getVnumAcademicosPAsistente() {
        return $this->vnumAcademicosPAsistente;
    }

    public function setVnumAcademicosPAsistente($vnumAcademicosPAsistente) {
        $this->vnumAcademicosPAsistente = $vnumAcademicosPAsistente;
    }

    public function getVnumAcademicosIAsociado() {
        return $this->vnumAcademicosIAsociado;
    }

    public function setVnumAcademicosIAsociado($vnumAcademicosIAsociado) {
        $this->vnumAcademicosIAsociado = $vnumAcademicosIAsociado;
    }

    public function getVnumAcademicosIAsistente() {
        return $this->vnumAcademicosIAsistente;
    }

    public function setVnumAcademicosIAsistente($vnumAcademicosIAsistente) {
        $this->vnumAcademicosIAsistente = $vnumAcademicosIAsistente;
    }

    public function getVnumAcademicosOtros() {
        return $this->vnumAcademicosOtros;
    }

    public function setVnumAcademicosOtros($vnumAcademicosOtros) {
        $this->vnumAcademicosOtros = $vnumAcademicosOtros;
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
