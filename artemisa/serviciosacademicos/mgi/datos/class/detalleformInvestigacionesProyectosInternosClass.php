<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detalleformInvestigacionesProyectosInternosClass
 *
 * @author proyecto_mgi_cp
 */
class detalleformInvestigacionesProyectosInternosClass {
    
    var $idsiq_detalleformInvestigacionesProyectosInternos = null;
    var $idData = null;
    var $idCategory = null;
    var $numPresentados = null;
    var $numAprobados = null;
    var $numFinalizados = null;
    var $valor = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_detalleformInvestigacionesProyectosInternos() {
        return $this->idsiq_detalleformInvestigacionesProyectosInternos;
    }

    public function setIdsiq_detalleformInvestigacionesProyectosInternos($idsiq_detalleformInvestigacionesProyectosInternos) {
        $this->idsiq_detalleformInvestigacionesProyectosInternos = $idsiq_detalleformInvestigacionesProyectosInternos;
    }

    public function getIdData() {
        return $this->idData;
    }

    public function setIdData($idData) {
        $this->idData = $idData;
    }

    public function getIdCategory() {
        return $this->idCategory;
    }

    public function setIdCategory($idCategory) {
        $this->idCategory = $idCategory;
    }

    public function getNumPresentados() {
        return $this->numPresentados;
    }

    public function setNumPresentados($numPresentados) {
        $this->numPresentados = $numPresentados;
    }

    public function getNumAprobados() {
        return $this->numAprobados;
    }

    public function setNumAprobados($numAprobados) {
        $this->numAprobados = $numAprobados;
    }

    public function getNumFinalizados() {
        return $this->numFinalizados;
    }

    public function setNumFinalizados($numFinalizados) {
        $this->numFinalizados = $numFinalizados;
    }

    public function getValor() {
        return $this->valor;
    }

    public function setValor($valor) {
        $this->valor = $valor;
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
