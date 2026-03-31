
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of aspectoClass
 *
 * @author proyecto_mgi_cp
 */
class formTalentoHumanoDedicacionSemanalCNAClass {
        
var $idsiq_formTalentoHumanoDedicacionSemanalCNA=null;
var $codigocarrera=null;
var $actividad=null;
var $codigoperiodo=null;
var $codigoestado=null;
var $mes=null;
var $anio=null;
var $fecha_creacion=null;
var $usuario_creacion=null;
var $fecha_modificacion=null;
var $usuario_modificacion=null;


    public function __construct() {
        
    }
    
    
    public function getIdsiq_formTalentoHumanoDedicacionSemanalCNA() {
        return $this->idsiq_formTalentoHumanoDedicacionSemanalCNA;
    }
    public function setIdsiq_formTalentoHumanoDedicacionSemanalCNA($idsiq_formTalentoHumanoDedicacionSemanalCNA) {
        $this->idsiq_formTalentoHumanoDedicacionSemanalCNA= $idsiq_formTalentoHumanoDedicacionSemanalCNA;
    }
    
    public function getCodigocarrera() {
        return $this->codigocarrera;
    }
    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }
    
    public function getActividad() {
        return $this->actividad;
    }
    public function setActividad($actividad) {
        $this->actividad = $actividad;
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
    
    public function getMes() {
        return $this->mes;
    }
    public function setMes($mes) {
        $this->mes = $mes;
    }
    
    public function getAnio() {
        return $this->anio;
    }
    public function setAnio($anio) {
        $this->anio = $anio;
    }
    
    public function getUsuario_creacion() {
        return $this->usuario_creacion;
    }
    public function setUsuario_creacion($usuario_creacion) {
        $this->usuario_creacion = $usuario_creacion;
    }

    public function getUsuario_modificacion() {
        return $this->usuario_modificacion;
    }
    public function setUsuario_modificacion($usuario_modificacion) {
        $this->usuario_modificacion = $usuario_modificacion;
    }

    public function getFecha_creacion() {
        return $this->fecha_creacion;
    }
    public function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    public function getFecha_modificacion() {
        return $this->fecha_modificacion;
    }
    public function setFecha_modificacion($fecha_modificacion) {
        $this->fecha_modificacion = $fecha_modificacion;
    }
    

            
                        
    public function __destruct() {
        
    }
}
?>
