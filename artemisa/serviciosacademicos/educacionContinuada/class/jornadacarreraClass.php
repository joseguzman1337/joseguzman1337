<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of jornadacarreraClass
 *
 * @author proyecto_mgi_cp
 */
class jornadacarreraClass {
    
    var $idjornadacarrera = null;
    var $nombrejornadacarrera = null;
    var $codigocarrera = null;
    var $codigojornada = null;
    var $numerominimocreditosjornadacarrera = null;
    var $numeromaximocreditosjornadacarrera = null;
    var $fechajornadacarrera = null;
    var $fechadesdejornadacarrera = null;
    var $fechahastajornadacarrera = null;
    
    public function __construct() {
        
    }
    
    public function getIdjornadacarrera() {
        return $this->idjornadacarrera;
    }

    public function setIdjornadacarrera($idjornadacarrera) {
        $this->idjornadacarrera = $idjornadacarrera;
    }

    public function getNombrejornadacarrera() {
        return $this->nombrejornadacarrera;
    }

    public function setNombrejornadacarrera($nombrejornadacarrera) {
        $this->nombrejornadacarrera = $nombrejornadacarrera;
    }

    public function getCodigocarrera() {
        return $this->codigocarrera;
    }

    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }

    public function getCodigojornada() {
        return $this->codigojornada;
    }

    public function setCodigojornada($codigojornada) {
        $this->codigojornada = $codigojornada;
    }

    public function getNumerominimocreditosjornadacarrera() {
        return $this->numerominimocreditosjornadacarrera;
    }

    public function setNumerominimocreditosjornadacarrera($numerominimocreditosjornadacarrera) {
        $this->numerominimocreditosjornadacarrera = $numerominimocreditosjornadacarrera;
    }

    public function getNumeromaximocreditosjornadacarrera() {
        return $this->numeromaximocreditosjornadacarrera;
    }

    public function setNumeromaximocreditosjornadacarrera($numeromaximocreditosjornadacarrera) {
        $this->numeromaximocreditosjornadacarrera = $numeromaximocreditosjornadacarrera;
    }

    public function getFechajornadacarrera() {
        return $this->fechajornadacarrera;
    }

    public function setFechajornadacarrera($fechajornadacarrera) {
        $this->fechajornadacarrera = $fechajornadacarrera;
    }

    public function getFechadesdejornadacarrera() {
        return $this->fechadesdejornadacarrera;
    }

    public function setFechadesdejornadacarrera($fechadesdejornadacarrera) {
        $this->fechadesdejornadacarrera = $fechadesdejornadacarrera;
    }

    public function getFechahastajornadacarrera() {
        return $this->fechahastajornadacarrera;
    }

    public function setFechahastajornadacarrera($fechahastajornadacarrera) {
        $this->fechahastajornadacarrera = $fechahastajornadacarrera;
    }
        
    public function __destruct() {
        
    }
}
?>
