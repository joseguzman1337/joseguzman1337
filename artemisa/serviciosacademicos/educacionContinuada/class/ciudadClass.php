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
class ciudadClass {
    
    var $idciudad = null;
    var $nombrecortociudad = null;
    var $nombreciudad = null;
    var $iddepartamento = null;
    var $codigosapciudad = null;
    var $codigoestado = null;
    
    public function __construct() {

    }
    
    public function getIdciudad() {
        return $this->idciudad;
    }

    public function setIdciudad($idciudad) {
        $this->idciudad = $idciudad;
    }

    public function getNombrecortociudad() {
        return $this->nombrecortociudad;
    }

    public function setNombrecortociudad($nombrecortociudad) {
        $this->nombrecortociudad = $nombrecortociudad;
    }

    public function getNombreciudad() {
        return $this->nombreciudad;
    }

    public function setNombreciudad($nombreciudad) {
        $this->nombreciudad = $nombreciudad;
    }

    public function getIddepartamento() {
        return $this->iddepartamento;
    }

    public function setIddepartamento($iddepartamento) {
        $this->iddepartamento = $iddepartamento;
    }

    public function getCodigosapciudad() {
        return $this->codigosapciudad;
    }

    public function setCodigosapciudad($codigosapciudad) {
        $this->codigosapciudad = $codigosapciudad;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }
        
    public function __destruct() {
        
    }
}
?>
