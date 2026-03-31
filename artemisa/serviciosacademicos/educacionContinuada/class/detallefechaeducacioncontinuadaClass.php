<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detallefechaeducacioncontinuadaClass
 *
 * @author proyecto_mgi_cp
 */
class detallefechaeducacioncontinuadaClass {
    
    var $iddetallefechaeducacioncontinuada = null;
    var $idfechaeducacioncontinuada = null;
    var $numerodetallefechaeducacioncontinuada = null;
    var $nombredetallefechaeducacioncontinuada = null;
    var $fechadetallefechaeducacioncontinuada = null;
    var $porcentajedetallefechaeducacioncontinuada = null;
    
    public function __construct() {
        
    }
    
    public function getIddetallefechaeducacioncontinuada() {
        return $this->iddetallefechaeducacioncontinuada;
    }

    public function setIddetallefechaeducacioncontinuada($iddetallefechaeducacioncontinuada) {
        $this->iddetallefechaeducacioncontinuada = $iddetallefechaeducacioncontinuada;
    }

    public function getIdfechaeducacioncontinuada() {
        return $this->idfechaeducacioncontinuada;
    }

    public function setIdfechaeducacioncontinuada($idfechaeducacioncontinuada) {
        $this->idfechaeducacioncontinuada = $idfechaeducacioncontinuada;
    }

    public function getNumerodetallefechaeducacioncontinuada() {
        return $this->numerodetallefechaeducacioncontinuada;
    }

    public function setNumerodetallefechaeducacioncontinuada($numerodetallefechaeducacioncontinuada) {
        $this->numerodetallefechaeducacioncontinuada = $numerodetallefechaeducacioncontinuada;
    }

    public function getNombredetallefechaeducacioncontinuada() {
        return $this->nombredetallefechaeducacioncontinuada;
    }

    public function setNombredetallefechaeducacioncontinuada($nombredetallefechaeducacioncontinuada) {
        $this->nombredetallefechaeducacioncontinuada = $nombredetallefechaeducacioncontinuada;
    }

    public function getFechadetallefechaeducacioncontinuada() {
        return $this->fechadetallefechaeducacioncontinuada;
    }

    public function setFechadetallefechaeducacioncontinuada($fechadetallefechaeducacioncontinuada) {
        $this->fechadetallefechaeducacioncontinuada = $fechadetallefechaeducacioncontinuada;
    }

    public function getPorcentajedetallefechaeducacioncontinuada() {
        return $this->porcentajedetallefechaeducacioncontinuada;
    }

    public function setPorcentajedetallefechaeducacioncontinuada($porcentajedetallefechaeducacioncontinuada) {
        $this->porcentajedetallefechaeducacioncontinuada = $porcentajedetallefechaeducacioncontinuada;
    }
        
    public function __destruct() {
        
    }
}
?>
