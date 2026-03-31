<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detalleformPresupuestoRecursosClass
 *
 * @author proyecto_mgi_cp
 */
class detalleformPresupuestoRecursosClass {
    
    var $idsiq_detalleformPresupuestoRecursos = null;
    var $idData=null;
    var $idCategory=null;
    var $presupuesto=null;
    var $ejecucion=null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_detalleformPresupuestoRecursos() {
        return $this->idsiq_detalleformPresupuestoRecursos;
    }
    public function setIdsiq_detalleformPresupuestoRecursos($idsiq_detalleformPresupuestoRecursos) {
        $this->idsiq_detalleformPresupuestoRecursos = $idsiq_detalleformPresupuestoRecursos;
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
    
    public function getPresupuesto() {
        return $this->presupuesto;
    }
    public function setPresupuesto($presupuesto) {
        $this->presupuesto = $presupuesto;
    }
    
    public function getEjecucion() {
        return $this->ejecucion;
    }
    public function setEjecucion($ejecucion) {
        $this->ejecucion = $ejecucion;
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
