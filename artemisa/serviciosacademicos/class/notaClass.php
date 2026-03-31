<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of notaClass
 *
 * @author proyecto_mgi_cp
 */
class notaClass {
    //put your code here
    var $idsiq_nota=null;
    var $idsiq_corte=null;
    var $codigoestudiante=null;
    var $nota=null;
    var $numerofallaspractica=null;
    var $numerofallasteorica=null;
    var $codigoestado=null;
    var $usuariocreacion=null;
    var $usuariomodificacion=null;
    var $fechacreacion=null;
    var $fechamodificacion=null;   
    
    function __construct() {
        
    }

    function getIdsiq_nota() {
        return $this->idsiq_nota;
    }

    function setIdsiq_nota($idsiq_nota) {
        $this->idsiq_nota = $idsiq_nota;
    }

    function getIdsiq_corte() {
        return $this->idsiq_corte;
    }

    function setIdsiq_corte($idsiq_corte) {
        $this->idsiq_corte = $idsiq_corte;
    }

    function getCodigoestudiante() {
        return $this->codigoestudiante;
    }

    function setCodigoestudiante($codigoestudiante) {
        $this->codigoestudiante = $codigoestudiante;
    }

    function getNota() {
        return $this->nota;
    }

    function setNota($nota) {
        $this->nota = $nota;
    }

    function getNumerofallaspractica() {
        return $this->numerofallaspractica;
    }

    function setNumerofallaspractica($numerofallaspractica) {
        $this->numerofallaspractica = $numerofallaspractica;
    }

    function getNumerofallasteorica() {
        return $this->numerofallasteorica;
    }

    function setNumerofallasteorica($numerofallasteorica) {
        $this->numerofallasteorica = $numerofallasteorica;
    }

    function getCodigoestado() {
        return $this->codigoestado;
    }

    function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    function getUsuariocreacion() {
        return $this->usuariocreacion;
    }

    function setUsuariocreacion($usuariocreacion) {
        $this->usuariocreacion = $usuariocreacion;
    }

    function getUsuariomodificacion() {
        return $this->usuariomodificacion;
    }

    function setUsuariomodificacion($usuariomodificacion) {
        $this->usuariomodificacion = $usuariomodificacion;
    }

    function getFechacreacion() {
        return $this->fechacreacion;
    }

    function setFechacreacion($fechacreacion) {
        $this->fechacreacion = $fechacreacion;
    }

    function getFechamodificacion() {
        return $this->fechamodificacion;
    }

    function setFechamodificacion($fechamodificacion) {
        $this->fechamodificacion = $fechamodificacion;
    }

        
    function __destruct() {
        
    }

}


?>
