<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of indicadorClass
 */
class indicadorClass {
    
    var $idsiq_indicador = null;
    var $nombre = null;
    var $ubicacion = null;
    var $fecha_ultima_actualizacion = null;
    var $fecha_proximo_vencimiento = null;
    var $idEstado = null;
    var $es_objeto_analisis = null;
    var $tiene_anexo = null;
    var $inexistente = null;
    var $idIndicadorGenerico = null;
    var $discriminacion = null;
    var $idFacultad = null;
    var $idCarrera = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
   
    public function __construct() {
        
    }
    
    public function getIdsiq_indicador() {
        return $this->idsiq_indicador;
    }

    public function setIdsiq_indicador($idsiq_indicador) {
        $this->idsiq_indicador = $idsiq_indicador;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getUbicacion() {
        return $this->ubicacion;
    }

    public function setUbicacion($ubicacion) {
        $this->ubicacion = $ubicacion;
    }

    public function getFecha_ultima_actualizacion() {
        return $this->fecha_ultima_actualizacion;
    }

    public function setFecha_ultima_actualizacion($fecha_ultima_actualizacion) {
        $this->fecha_ultima_actualizacion = $fecha_ultima_actualizacion;
    }

    public function getFecha_proximo_vencimiento() {
        return $this->fecha_proximo_vencimiento;
    }

    public function setFecha_proximo_vencimiento($fecha_proximo_vencimiento) {
        $this->fecha_proximo_vencimiento = $fecha_proximo_vencimiento;
    }

    public function getIdEstado() {
        return $this->idEstado;
    }

    public function setIdEstado($idEstado) {
        $this->idEstado = $idEstado;
    }

    public function getEs_objeto_analisis() {
        return $this->es_objeto_analisis;
    }

    public function setEs_objeto_analisis($es_objeto_analisis) {
        $this->es_objeto_analisis = $es_objeto_analisis;
    }

    public function getTiene_anexo() {
        return $this->tiene_anexo;
    }

    public function setTiene_anexo($tiene_anexo) {
        $this->tiene_anexo = $tiene_anexo;
    }

    public function getInexistente() {
        return $this->inexistente;
    }

    public function setInexistente($inexistente) {
        $this->inexistente = $inexistente;
    }

    public function getIdIndicadorGenerico() {
        return $this->idIndicadorGenerico;
    }

    public function setIdIndicadorGenerico($idIndicadorGenerico) {
        $this->idIndicadorGenerico = $idIndicadorGenerico;
    }

    public function getDiscriminacion() {
        return $this->discriminacion;
    }

    public function setDiscriminacion($discriminacion) {
        $this->discriminacion = $discriminacion;
    }

    public function getIdFacultad() {
        return $this->idFacultad;
    }

    public function setIdFacultad($idFacultad) {
        $this->idFacultad = $idFacultad;
    }

    public function getIdCarrera() {
        return $this->idCarrera;
    }

    public function setIdCarrera($idCarrera) {
        $this->idCarrera = $idCarrera;
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
