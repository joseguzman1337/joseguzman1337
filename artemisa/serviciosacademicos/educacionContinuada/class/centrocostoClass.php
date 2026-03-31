<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of carreraClass
 *
 * @author proyecto_mgi_cp
 */
class centrocostoClass {

    var $idcentrocosto = null;
    var $codigocentrocosto = null;
    var $nombrecentrocosto = null;
    var $unidadcentrocosto = null;
    var $codigotipocentrocosto = null;
    var $fechacentrocosto = null;
    var $fechainiciocentrocosto = null;
    var $fechafinalcentrocosto = null;
    var $responsablecentrocosto = null;
    var $codigoestado = null;
    
    public function __construct() {
        
    }
    
    public function getIdcentrocosto() {
        return $this->idcentrocosto;
    }

    public function setIdcentrocosto($idcentrocosto) {
        $this->idcentrocosto = $idcentrocosto;
    }

    public function getCodigocentrocosto() {
        return $this->codigocentrocosto;
    }

    public function setCodigocentrocosto($codigocentrocosto) {
        $this->codigocentrocosto = $codigocentrocosto;
    }

    public function getNombrecentrocosto() {
        return $this->nombrecentrocosto;
    }

    public function setNombrecentrocosto($nombrecentrocosto) {
        $this->nombrecentrocosto = $nombrecentrocosto;
    }

    public function getUnidadcentrocosto() {
        return $this->unidadcentrocosto;
    }

    public function setUnidadcentrocosto($unidadcentrocosto) {
        $this->unidadcentrocosto = $unidadcentrocosto;
    }

    public function getCodigotipocentrocosto() {
        return $this->codigotipocentrocosto;
    }

    public function setCodigotipocentrocosto($codigotipocentrocosto) {
        $this->codigotipocentrocosto = $codigotipocentrocosto;
    }

    public function getFechacentrocosto() {
        return $this->fechacentrocosto;
    }

    public function setFechacentrocosto($fechacentrocosto) {
        $this->fechacentrocosto = $fechacentrocosto;
    }

    public function getFechainiciocentrocosto() {
        return $this->fechainiciocentrocosto;
    }

    public function setFechainiciocentrocosto($fechainiciocentrocosto) {
        $this->fechainiciocentrocosto = $fechainiciocentrocosto;
    }

    public function getFechafinalcentrocosto() {
        return $this->fechafinalcentrocosto;
    }

    public function setFechafinalcentrocosto($fechafinalcentrocosto) {
        $this->fechafinalcentrocosto = $fechafinalcentrocosto;
    }

    public function getResponsablecentrocosto() {
        return $this->responsablecentrocosto;
    }

    public function setResponsablecentrocosto($responsablecentrocosto) {
        $this->responsablecentrocosto = $responsablecentrocosto;
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
