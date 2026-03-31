<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of corteClass
 *
 * @author proyecto_mgi_cp
 */
class corteClass {
    //put your code here
    var $idsiq_corte= null;
    var $idsiq_grupoconvenio= null;
    var $numerocorte= null;
    var $fechainicio= null;
    var $fechafin= null;
    var $peso= null;
    var $usuariocreacion= null;
    var $usuariomodificacion= null;
    var $fechacreacion= null;
    var $fechamodificacion= null;
    var $codigoestado= null;
    
    function __construct() {
    
    }
    
    function getIdsiq_corte() {
        return $this->idsiq_corte;
    }

    function setIdsiq_corte($idsiq_corte) {
        $this->idsiq_corte = $idsiq_corte;
    }

    function getIdsiq_grupoconvenio() {
        return $this->idsiq_grupoconvenio;
    }

    function setIdsiq_grupoconvenio($idsiq_grupoconvenio) {
        $this->idsiq_grupoconvenio = $idsiq_grupoconvenio;
    }

    function getNumerocorte() {
        return $this->numerocorte;
    }

    function setNumerocorte($numerocorte) {
        $this->numerocorte = $numerocorte;
    }

    function getFechainicio() {
        return $this->fechainicio;
    }

    function setFechainicio($fechainicio) {
        $this->fechainicio = $fechainicio;
    }

    function getFechafin() {
        return $this->fechafin;
    }

    function setFechafin($fechafin) {
        $this->fechafin = $fechafin;
    }

    function getPeso() {
        return $this->peso;
    }

    function setPeso($peso) {
        $this->peso = $peso;
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

    function getCodigoestado() {
        return $this->codigoestado;
    }

    function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

        
    function __destruct() {
        
    }


    
}

?>
