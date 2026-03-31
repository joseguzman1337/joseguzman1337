<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of valoreducacioncontinuadaClass
 *
 * @author proyecto_mgi_cp
 */
class valoreducacioncontinuadaClass {
    
    var $idvaloreducacioncontinuada = null;
    var $nombrevaloreducacioncontinuada = null;
    var $fechavaloreducacioncontinuada = null;
    var $codigocarrera = null;
    var $codigoconcepto = null;
    var $preciovaloreducacioncontinuada = null;
    var $fechainiciovaloreducacioncontinuada = null;
    var $fechafinalvaloreducacioncontinuada = null;
    
    public function __construct() {
        
    }
    
    public function getIdvaloreducacioncontinuada() {
        return $this->idvaloreducacioncontinuada;
    }

    public function setIdvaloreducacioncontinuada($idvaloreducacioncontinuada) {
        $this->idvaloreducacioncontinuada = $idvaloreducacioncontinuada;
    }

    public function getNombrevaloreducacioncontinuada() {
        return $this->nombrevaloreducacioncontinuada;
    }

    public function setNombrevaloreducacioncontinuada($nombrevaloreducacioncontinuada) {
        $this->nombrevaloreducacioncontinuada = $nombrevaloreducacioncontinuada;
    }

    public function getFechavaloreducacioncontinuada() {
        return $this->fechavaloreducacioncontinuada;
    }

    public function setFechavaloreducacioncontinuada($fechavaloreducacioncontinuada) {
        $this->fechavaloreducacioncontinuada = $fechavaloreducacioncontinuada;
    }

    public function getCodigocarrera() {
        return $this->codigocarrera;
    }

    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }

    public function getCodigoconcepto() {
        return $this->codigoconcepto;
    }

    public function setCodigoconcepto($codigoconcepto) {
        $this->codigoconcepto = $codigoconcepto;
    }

    public function getPreciovaloreducacioncontinuada() {
        return $this->preciovaloreducacioncontinuada;
    }

    public function setPreciovaloreducacioncontinuada($preciovaloreducacioncontinuada) {
        $this->preciovaloreducacioncontinuada = $preciovaloreducacioncontinuada;
    }

    public function getFechainiciovaloreducacioncontinuada() {
        return $this->fechainiciovaloreducacioncontinuada;
    }

    public function setFechainiciovaloreducacioncontinuada($fechainiciovaloreducacioncontinuada) {
        $this->fechainiciovaloreducacioncontinuada = $fechainiciovaloreducacioncontinuada;
    }

    public function getFechafinalvaloreducacioncontinuada() {
        return $this->fechafinalvaloreducacioncontinuada;
    }

    public function setFechafinalvaloreducacioncontinuada($fechafinalvaloreducacioncontinuada) {
        $this->fechafinalvaloreducacioncontinuada = $fechafinalvaloreducacioncontinuada;
    }
        
    public function __destruct() {
        
    }
}
?>
