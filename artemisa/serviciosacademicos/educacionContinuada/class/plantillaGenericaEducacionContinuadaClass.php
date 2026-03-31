<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of plantillaGenericaEducacionContinuadaClass
 *
 * @author proyecto_mgi_cp
 */
class plantillaGenericaEducacionContinuadaClass {
    
    var $idplantillaGenericaEducacionContinuada = null;
    var $layout = null;
    var $plantilla = null;
    var $visible = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdplantillaGenericaEducacionContinuada() {
        return $this->idplantillaGenericaEducacionContinuada;
    }

    public function setIdplantillaGenericaEducacionContinuada($idplantillaGenericaEducacionContinuada) {
        $this->idplantillaGenericaEducacionContinuada = $idplantillaGenericaEducacionContinuada;
    }

    public function getLayout() {
        return $this->layout;
    }

    public function setLayout($layout) {
        $this->layout = $layout;
    }

    public function getPlantilla() {
        return $this->plantilla;
    }

    public function setPlantilla($plantilla) {
        $this->plantilla = $plantilla;
    }

    public function getVisible() {
        return $this->visible;
    }

    public function setVisible($visible) {
        $this->visible = $visible;
    }

    public function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    public function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    public function getUsuario_creacion() {
        return $this->usuario_creacion;
    }

    public function setUsuario_creacion($usuario_creacion) {
        $this->usuario_creacion = $usuario_creacion;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function getFecha_modificacion() {
        return $this->fecha_modificacion;
    }

    public function setFecha_modificacion($fecha_modificacion) {
        $this->fecha_modificacion = $fecha_modificacion;
    }

    public function getUsuario_modificacion() {
        return $this->usuario_modificacion;
    }

    public function setUsuario_modificacion($usuario_modificacion) {
        $this->usuario_modificacion = $usuario_modificacion;
    }
        
    public function __destruct() {
        
    }
}
?>
