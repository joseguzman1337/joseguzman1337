<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formTalentoHumanoApoyosEconomicosClass
 *
 * @author proyecto_mgi_cp
 */
class formTalentoHumanoApoyosEconomicosClass {
    
    var $idsiq_formTalentoHumanoApoyosEconomicos = null;
    var $codigoperiodo = null;
    var $valorNacionalCongreso = null;
    var $valorNacionalDiplomado = null;
    var $valorNacionalTaller = null;
    var $valorInternacionalCongreso = null;
    var $valorInternacionalDiplomado = null;
    var $valorInternacionalTaller = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_formTalentoHumanoApoyosEconomicos() {
        return $this->idsiq_formTalentoHumanoApoyosEconomicos;
    }

    public function setIdsiq_formTalentoHumanoApoyosEconomicos($idsiq_formTalentoHumanoApoyosEconomicos) {
        $this->idsiq_formTalentoHumanoApoyosEconomicos = $idsiq_formTalentoHumanoApoyosEconomicos;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function getValorNacionalCongreso() {
        return $this->valorNacionalCongreso;
    }

    public function setValorNacionalCongreso($valorNacionalCongreso) {
        $this->valorNacionalCongreso = $valorNacionalCongreso;
    }

    public function getValorNacionalDiplomado() {
        return $this->valorNacionalDiplomado;
    }

    public function setValorNacionalDiplomado($valorNacionalDiplomado) {
        $this->valorNacionalDiplomado = $valorNacionalDiplomado;
    }

    public function getValorNacionalTaller() {
        return $this->valorNacionalTaller;
    }

    public function setValorNacionalTaller($valorNacionalTaller) {
        $this->valorNacionalTaller = $valorNacionalTaller;
    }

    public function getValorInternacionalCongreso() {
        return $this->valorInternacionalCongreso;
    }

    public function setValorInternacionalCongreso($valorInternacionalCongreso) {
        $this->valorInternacionalCongreso = $valorInternacionalCongreso;
    }

    public function getValorInternacionalDiplomado() {
        return $this->valorInternacionalDiplomado;
    }

    public function setValorInternacionalDiplomado($valorInternacionalDiplomado) {
        $this->valorInternacionalDiplomado = $valorInternacionalDiplomado;
    }

    public function getValorInternacionalTaller() {
        return $this->valorInternacionalTaller;
    }

    public function setValorInternacionalTaller($valorInternacionalTaller) {
        $this->valorInternacionalTaller = $valorInternacionalTaller;
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
