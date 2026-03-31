<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formDesarrolloFisicoUsoEspacioClass
 *
 * @author proyecto_mgi_cp
 */
class formDesarrolloFisicoUsoEspacioClass {
    
    var $idsiq_formDesarrolloFisicoUsoEspacio = null;
    var $codigoperiodo = null;
    var $usuario_creacion = null;
    var $fecha_creacion = null;
    var $codigoestado = null;
    var $usuario_modificacion = null;
    var $fecha_modificacion = null;
    var $Verificado=null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_formDesarrolloFisicoUsoEspacio() {
        return $this->idsiq_formDesarrolloFisicoUsoEspacio;
    }

    public function setIdsiq_formDesarrolloFisicoUsoEspacio($idsiq_formDesarrolloFisicoUsoEspacio) {
        $this->idsiq_formDesarrolloFisicoUsoEspacio = $idsiq_formDesarrolloFisicoUsoEspacio;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function getUsuario_creacion() {
        return $this->usuario_creacion;
    }

    public function setUsuario_creacion($usuario_creacion) {
        $this->usuario_creacion = $usuario_creacion;
    }

    public function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    public function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function getUsuario_modificacion() {
        return $this->usuario_modificacion;
    }

    public function setUsuario_modificacion($usuario_modificacion) {
        $this->usuario_modificacion = $usuario_modificacion;
    }

    public function getFecha_modificacion() {
        return $this->fecha_modificacion;
    }

    public function setFecha_modificacion($fecha_modificacion) {
        $this->fecha_modificacion = $fecha_modificacion;
    }
    
      public function getVerificado() {
        return $this->Verificado;
    }

    public function setVerificado($Verificado) {
        $this->Verificado = $Verificado;
    }
        
    public function __destruct() {
        
    }
}

?>
