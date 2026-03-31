<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of firmaEscaneadaEducacionContinuadaClass
 *
 * @author proyecto_mgi_cp
 */
class firmaEscaneadaEducacionContinuadaClass {
    
    var $idfirmaEscaneadaEducacionContinuada = null;
    var $nombre = null;
    var $cargo = null;
    var $unidad = null;
    var $ubicacionFirmaEscaneada = null;
    var $file_size = null;
    var $unidadTamano = null;
    var $tipoArchivo = null;
    var $extensionArchivo = null;
    var $usuario_creacion = null;
    var $fecha_creacion = null;
    var $codigoestado = null;
    var $usuario_modificacion = null;
    var $fecha_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdfirmaEscaneadaEducacionContinuada() {
        return $this->idfirmaEscaneadaEducacionContinuada;
    }

    public function setIdfirmaEscaneadaEducacionContinuada($idfirmaEscaneadaEducacionContinuada) {
        $this->idfirmaEscaneadaEducacionContinuada = $idfirmaEscaneadaEducacionContinuada;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getCargo() {
        return $this->cargo;
    }

    public function setCargo($cargo) {
        $this->cargo = $cargo;
    }

    public function getUnidad() {
        return $this->unidad;
    }

    public function setUnidad($unidad) {
        $this->unidad = $unidad;
    }

    public function getUbicacionFirmaEscaneada() {
        return $this->ubicacionFirmaEscaneada;
    }

    public function setUbicacionFirmaEscaneada($ubicacionFirmaEscaneada) {
        $this->ubicacionFirmaEscaneada = $ubicacionFirmaEscaneada;
    }

    public function getFile_size() {
        return $this->file_size;
    }

    public function setFile_size($file_size) {
        $this->file_size = $file_size;
    }

    public function getUnidadTamano() {
        return $this->unidadTamano;
    }

    public function setUnidadTamano($unidadTamano) {
        $this->unidadTamano = $unidadTamano;
    }

    public function getTipoArchivo() {
        return $this->tipoArchivo;
    }

    public function setTipoArchivo($tipoArchivo) {
        $this->tipoArchivo = $tipoArchivo;
    }

    public function getExtensionArchivo() {
        return $this->extensionArchivo;
    }

    public function setExtensionArchivo($extensionArchivo) {
        $this->extensionArchivo = $extensionArchivo;
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
        
    public function __destruct() {
        
    }
}
?>
