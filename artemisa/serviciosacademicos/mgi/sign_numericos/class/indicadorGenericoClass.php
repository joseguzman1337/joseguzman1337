<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of indicadorGenericoClass
 */
class indicadorGenericoClass {
    
    var $idsiq_indicadorGenerico = null;
    var $idAspecto = null;
    var $nombre = null;
    var $descripcion = null;
    var $idTipo = null;
    var $area = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
   
    public function __construct() {
        
    }
    
    public function getIdsiq_indicadorGenerico() {
        return $this->idsiq_indicadorGenerico;
    }

    public function setIdsiq_indicadorGenerico($idsiq_indicadorGenerico) {
        $this->idsiq_indicadorGenerico = $idsiq_indicadorGenerico;
    }

    public function getIdAspecto() {
        return $this->idAspecto;
    }

    public function setIdAspecto($idAspecto) {
        $this->idAspecto = $idAspecto;
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

    public function getIdTipo() {
        return $this->idTipo;
    }

    public function setIdTipo($idTipo) {
        $this->idTipo = $idTipo;
    }

    public function getArea() {
        return $this->area;
    }

    public function setArea($area) {
        $this->area = $area;
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
