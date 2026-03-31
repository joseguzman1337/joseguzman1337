<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ciudadClass
 *
 * @author proyecto_mgi_cp
 */
class facturavalorpecuniarioClass {
    
    var $idfacturavalorpecuniario = null;
    var $nombrefacturavalorpecuniario = null;
    var $fechafacturavalorpecuniario = null;
    var $codigoperiodo = null;
    var $codigocarrera = null;
    
    public function __construct() {

    }
    
    public function getIdfacturavalorpecuniario() {
        return $this->idfacturavalorpecuniario;
    }

    public function setIdfacturavalorpecuniario($idfacturavalorpecuniario) {
        $this->idfacturavalorpecuniario = $idfacturavalorpecuniario;
    }

    public function getNombrefacturavalorpecuniario() {
        return $this->nombrefacturavalorpecuniario;
    }

    public function setNombrefacturavalorpecuniario($nombrefacturavalorpecuniario) {
        $this->nombrefacturavalorpecuniario = $nombrefacturavalorpecuniario;
    }

    public function getFechafacturavalorpecuniario() {
        return $this->fechafacturavalorpecuniario;
    }

    public function setFechafacturavalorpecuniario($fechafacturavalorpecuniario) {
        $this->fechafacturavalorpecuniario = $fechafacturavalorpecuniario;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function getCodigocarrera() {
        return $this->codigocarrera;
    }

    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }
        
    public function __destruct() {
        
    }
}
?>
