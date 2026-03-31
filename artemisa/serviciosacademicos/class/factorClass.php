<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of factorClass
 *
 * @author proyecto_mgi_cp
 */
class factorClass {
    //put your code here
    var $idsiq_factor = null;
    var $nombre= null;
    var $fecha_creacion= null;
    var $usuario_creacion= null;
    var $fecha_modificacion= null;
    var $usuario_modificacion= null;
    var $cod_estado= null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_factor() {
        return $this->idsiq_factor;
    }

    public function setIdsiq_factor($idsiq_factor) {
        $this->idsiq_factor = $idsiq_factor;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
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
    
    public function getCod_estado() {
        return $this->cod_estado;
    }

    public function setCod_estado($cod_estado) {
        $this->cod_estado = $cod_estado;
    }

        public function __destruct() {
        
    }
    
}
?>
