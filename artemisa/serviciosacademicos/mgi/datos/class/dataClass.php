<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dataClass
 *
 * @author proyecto_mgi_cp
 */
class dataClass {

    var $idsiq_data = null;
    var $nombre = null;
    var $alias = null;
    var $categoria = null;
    var $tipo_data = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;

    public function __construct() {
        
    }
    
    public function getIdsiq_data() {
        return $this->idsiq_data;
    }

    public function setIdsiq_data($idsiq_data) {
        $this->idsiq_data = $idsiq_data;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getAlias() {
        return $this->alias;
    }

    public function setAlias($alias) {
        $this->alias = $alias;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    public function getTipo_data() {
        return $this->tipo_data;
    }

    public function setTipo_data($tipo_data) {
        $this->tipo_data = $tipo_data;
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
 
    public function __destruct() {
        
    }
}

?>
