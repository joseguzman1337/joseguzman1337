<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of carreraperiodoClass
 *
 * @author proyecto_mgi_cp
 */
class carreraperiodoClass {
    
    var $idcarreraperiodo = null;
    var $codigocarrera = null;
    var $codigoperiodo = null;
    var $codigoestado = null;
    
    public function __construct() {
        
    }
    
    public function getIdcarreraperiodo() {
        return $this->idcarreraperiodo;
    }

    public function setIdcarreraperiodo($idcarreraperiodo) {
        $this->idcarreraperiodo = $idcarreraperiodo;
    }

    public function getCodigocarrera() {
        return $this->codigocarrera;
    }

    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
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
