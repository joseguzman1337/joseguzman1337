<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formInvestigacionesProyectosColcienciasClass
 *
 * @author proyecto_mgi_cp
 */
class formInvestigacionesProyectosColcienciasClass {
    
    var $idsiq_formInvestigacionesProyectosColciencias = null;
    var $codigoperiodo = null;
    var $numProyectosPresentados = null;
    var $numProyectosPresentadosColciencias = null;
    var $numProyectosAprobados = null;
    var $numProyectosAprobadosColciencias = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_formInvestigacionesProyectosColciencias() {
        return $this->idsiq_formInvestigacionesProyectosColciencias;
    }

    public function setIdsiq_formInvestigacionesProyectosColciencias($idsiq_formInvestigacionesProyectosColciencias) {
        $this->idsiq_formInvestigacionesProyectosColciencias = $idsiq_formInvestigacionesProyectosColciencias;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function getNumProyectosPresentados() {
        return $this->numProyectosPresentados;
    }

    public function setNumProyectosPresentados($numProyectosPresentados) {
        $this->numProyectosPresentados = $numProyectosPresentados;
    }

    public function getNumProyectosPresentadosColciencias() {
        return $this->numProyectosPresentadosColciencias;
    }

    public function setNumProyectosPresentadosColciencias($numProyectosPresentadosColciencias) {
        $this->numProyectosPresentadosColciencias = $numProyectosPresentadosColciencias;
    }

    public function getNumProyectosAprobados() {
        return $this->numProyectosAprobados;
    }

    public function setNumProyectosAprobados($numProyectosAprobados) {
        $this->numProyectosAprobados = $numProyectosAprobados;
    }

    public function getNumProyectosAprobadosColciencias() {
        return $this->numProyectosAprobadosColciencias;
    }

    public function setNumProyectosAprobadosColciencias($numProyectosAprobadosColciencias) {
        $this->numProyectosAprobadosColciencias = $numProyectosAprobadosColciencias;
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
