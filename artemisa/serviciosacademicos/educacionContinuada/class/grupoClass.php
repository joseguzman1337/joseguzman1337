<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of grupoClass
 *
 * @author proyecto_mgi_cp
 */
class grupoClass {
    
    var $idgrupo = null;
    var $codigogrupo = null;
    var $nombregrupo = null;
    var $codigomateria = null;
    var $codigoperiodo = null;
    var $numerodocumento = null;
    var $maximogrupo = null;
    var $matriculadosgrupo = null;
    var $maximogrupoelectiva = null;
    var $matriculadosgrupoelectiva = null;
    var $codigoestadogrupo = null;
    var $codigoindicadorhorario = null;
    var $fechainiciogrupo = null;
    var $fechafinalgrupo = null;
    var $numerodiasconservagrupo = null;
    
    public function __construct() {
        
    }
    
    public function getIdgrupo() {
        return $this->idgrupo;
    }

    public function setIdgrupo($idgrupo) {
        $this->idgrupo = $idgrupo;
    }

    public function getCodigogrupo() {
        return $this->codigogrupo;
    }

    public function setCodigogrupo($codigogrupo) {
        $this->codigogrupo = $codigogrupo;
    }

    public function getNombregrupo() {
        return $this->nombregrupo;
    }

    public function setNombregrupo($nombregrupo) {
        $this->nombregrupo = $nombregrupo;
    }

    public function getCodigomateria() {
        return $this->codigomateria;
    }

    public function setCodigomateria($codigomateria) {
        $this->codigomateria = $codigomateria;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function getNumerodocumento() {
        return $this->numerodocumento;
    }

    public function setNumerodocumento($numerodocumento) {
        $this->numerodocumento = $numerodocumento;
    }

    public function getMaximogrupo() {
        return $this->maximogrupo;
    }

    public function setMaximogrupo($maximogrupo) {
        $this->maximogrupo = $maximogrupo;
    }

    public function getMatriculadosgrupo() {
        return $this->matriculadosgrupo;
    }

    public function setMatriculadosgrupo($matriculadosgrupo) {
        $this->matriculadosgrupo = $matriculadosgrupo;
    }

    public function getMaximogrupoelectiva() {
        return $this->maximogrupoelectiva;
    }

    public function setMaximogrupoelectiva($maximogrupoelectiva) {
        $this->maximogrupoelectiva = $maximogrupoelectiva;
    }

    public function getMatriculadosgrupoelectiva() {
        return $this->matriculadosgrupoelectiva;
    }

    public function setMatriculadosgrupoelectiva($matriculadosgrupoelectiva) {
        $this->matriculadosgrupoelectiva = $matriculadosgrupoelectiva;
    }

    public function getCodigoestadogrupo() {
        return $this->codigoestadogrupo;
    }

    public function setCodigoestadogrupo($codigoestadogrupo) {
        $this->codigoestadogrupo = $codigoestadogrupo;
    }

    public function getCodigoindicadorhorario() {
        return $this->codigoindicadorhorario;
    }

    public function setCodigoindicadorhorario($codigoindicadorhorario) {
        $this->codigoindicadorhorario = $codigoindicadorhorario;
    }

    public function getFechainiciogrupo() {
        return $this->fechainiciogrupo;
    }

    public function setFechainiciogrupo($fechainiciogrupo) {
        $this->fechainiciogrupo = $fechainiciogrupo;
    }

    public function getFechafinalgrupo() {
        return $this->fechafinalgrupo;
    }

    public function setFechafinalgrupo($fechafinalgrupo) {
        $this->fechafinalgrupo = $fechafinalgrupo;
    }

    public function getNumerodiasconservagrupo() {
        return $this->numerodiasconservagrupo;
    }

    public function setNumerodiasconservagrupo($numerodiasconservagrupo) {
        $this->numerodiasconservagrupo = $numerodiasconservagrupo;
    }
        
    public function __destruct() {
        
    }
}
?>
