<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of reporteClass
 *
 * @author proyecto_mgi_cp
 */
class reporteClass {

    var $idsiq_reporte = null;
    var $nombre = null;
    var $descripcion = null;
    var $categoria = null;
    var $alias = null;
    var $tiene_detalle = null;
    var $analisis = null;
    var $periodoFecha = null;
    var $fecha_inicial = null;
    var $fecha_final = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_reporte() {
        return $this->idsiq_reporte;
    }

    public function setIdsiq_reporte($idsiq_reporte) {
        $this->idsiq_reporte = $idsiq_reporte;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    public function getAlias() {
        return $this->alias;
    }

    public function setAlias($alias) {
        $this->alias = $alias;
    }

    public function getTiene_detalle() {
        return $this->tiene_detalle;
    }

    public function setTiene_detalle($tiene_detalle) {
        $this->tiene_detalle = $tiene_detalle;
    }

    public function getAnalisis() {
        return $this->analisis;
    }

    public function setAnalisis($analisis) {
        $this->analisis = $analisis;
    }

    public function getPeriodoFecha() {
        return $this->periodoFecha;
    }

    public function setPeriodoFecha($periodoFecha) {
        $this->periodoFecha = $periodoFecha;
    }

    public function getFecha_inicial() {
        return $this->fecha_inicial;
    }

    public function setFecha_inicial($fecha_inicial) {
        $this->fecha_inicial = $fecha_inicial;
    }

    public function getFecha_final() {
        return $this->fecha_final;
    }

    public function setFecha_final($fecha_final) {
        $this->fecha_final = $fecha_final;
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
