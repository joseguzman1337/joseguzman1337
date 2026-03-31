<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formCreditoYCarteraBecasClass
 *
 * @author proyecto_mgi_cp
 */
class formCreditoYCarteraBecasClass {
    
    var $idsiq_formCreditoYCarteraBecas = null;
    var $codigoperiodo = null;
    var $numBecadosExcelenciaAcademica = null;
    var $numBecadosPoblacionesEspeciales = null;
    var $numBecadosGradoHonor = null;
    var $numBecadosGraduandosECAES = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_formCreditoYCarteraBecas() {
        return $this->idsiq_formCreditoYCarteraBecas;
    }

    public function setIdsiq_formCreditoYCarteraBecas($idsiq_formCreditoYCarteraBecas) {
        $this->idsiq_formCreditoYCarteraBecas = $idsiq_formCreditoYCarteraBecas;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function getNumBecadosExcelenciaAcademica() {
        return $this->numBecadosExcelenciaAcademica;
    }

    public function setNumBecadosExcelenciaAcademica($numBecadosExcelenciaAcademica) {
        $this->numBecadosExcelenciaAcademica = $numBecadosExcelenciaAcademica;
    }

    public function getNumBecadosPoblacionesEspeciales() {
        return $this->numBecadosPoblacionesEspeciales;
    }

    public function setNumBecadosPoblacionesEspeciales($numBecadosPoblacionesEspeciales) {
        $this->numBecadosPoblacionesEspeciales = $numBecadosPoblacionesEspeciales;
    }

    public function getNumBecadosGradoHonor() {
        return $this->numBecadosGradoHonor;
    }

    public function setNumBecadosGradoHonor($numBecadosGradoHonor) {
        $this->numBecadosGradoHonor = $numBecadosGradoHonor;
    }

    public function getNumBecadosGraduandosECAES() {
        return $this->numBecadosGraduandosECAES;
    }

    public function setNumBecadosGraduandosECAES($numBecadosGraduandosECAES) {
        $this->numBecadosGraduandosECAES = $numBecadosGraduandosECAES;
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
