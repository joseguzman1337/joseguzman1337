<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of subperiodoClass
 *
 * @author proyecto_mgi_cp
 */
class subperiodoClass {
    
    var $idsubperiodo = null;
    var $idcarreraperiodo = null;
    var $nombresubperiodo = null;
    var $fechasubperiodo = null;
    var $fechainicioacademicosubperiodo = null;
    var $fechafinalacademicosubperiodo = null;
    var $fechainiciofinancierosubperiodo = null;
    var $fechafinalfinancierosubperiodo = null;
    var $numerosubperiodo = null;
    var $idtiposubperiodo = null;
    var $codigoestadosubperiodo = null;
    var $idusuario = null;
    var $ip = null;
    
    public function __construct() {
        
    }
    
    public function getIdsubperiodo() {
        return $this->idsubperiodo;
    }

    public function setIdsubperiodo($idsubperiodo) {
        $this->idsubperiodo = $idsubperiodo;
    }

    public function getIdcarreraperiodo() {
        return $this->idcarreraperiodo;
    }

    public function setIdcarreraperiodo($idcarreraperiodo) {
        $this->idcarreraperiodo = $idcarreraperiodo;
    }

    public function getNombresubperiodo() {
        return $this->nombresubperiodo;
    }

    public function setNombresubperiodo($nombresubperiodo) {
        $this->nombresubperiodo = $nombresubperiodo;
    }

    public function getFechasubperiodo() {
        return $this->fechasubperiodo;
    }

    public function setFechasubperiodo($fechasubperiodo) {
        $this->fechasubperiodo = $fechasubperiodo;
    }

    public function getFechainicioacademicosubperiodo() {
        return $this->fechainicioacademicosubperiodo;
    }

    public function setFechainicioacademicosubperiodo($fechainicioacademicosubperiodo) {
        $this->fechainicioacademicosubperiodo = $fechainicioacademicosubperiodo;
    }

    public function getFechafinalacademicosubperiodo() {
        return $this->fechafinalacademicosubperiodo;
    }

    public function setFechafinalacademicosubperiodo($fechafinalacademicosubperiodo) {
        $this->fechafinalacademicosubperiodo = $fechafinalacademicosubperiodo;
    }

    public function getFechainiciofinancierosubperiodo() {
        return $this->fechainiciofinancierosubperiodo;
    }

    public function setFechainiciofinancierosubperiodo($fechainiciofinancierosubperiodo) {
        $this->fechainiciofinancierosubperiodo = $fechainiciofinancierosubperiodo;
    }

    public function getFechafinalfinancierosubperiodo() {
        return $this->fechafinalfinancierosubperiodo;
    }

    public function setFechafinalfinancierosubperiodo($fechafinalfinancierosubperiodo) {
        $this->fechafinalfinancierosubperiodo = $fechafinalfinancierosubperiodo;
    }

    public function getNumerosubperiodo() {
        return $this->numerosubperiodo;
    }

    public function setNumerosubperiodo($numerosubperiodo) {
        $this->numerosubperiodo = $numerosubperiodo;
    }

    public function getIdtiposubperiodo() {
        return $this->idtiposubperiodo;
    }

    public function setIdtiposubperiodo($idtiposubperiodo) {
        $this->idtiposubperiodo = $idtiposubperiodo;
    }

    public function getCodigoestadosubperiodo() {
        return $this->codigoestadosubperiodo;
    }

    public function setCodigoestadosubperiodo($codigoestadosubperiodo) {
        $this->codigoestadosubperiodo = $codigoestadosubperiodo;
    }

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    public function getIp() {
        return $this->ip;
    }

    public function setIp($ip) {
        $this->ip = $ip;
    }
        
    public function __destruct() {
        
    }
}
?>
