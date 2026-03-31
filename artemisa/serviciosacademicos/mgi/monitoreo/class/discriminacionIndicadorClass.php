<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of discriminacionIndicadorClass
 *
 * @author proyecto_mgi_cp
 */
class discriminacionIndicadorClass {
    
    var $idsiq_discriminacionIndicador = null;
    var $nombre= null;
    var $fecha_creacion= null;
    var $usuario_creacion= null;
    var $codigoestado= null;
    
    public function __construct() {
        
    }

    public function getIdsiq_discriminacionIndicador() {
        return $this->idsiq_discriminacionIndicador;
    }

    public function setIdsiq_discriminacionIndicador($idsiq_discriminacionIndicador) {
        $this->idsiq_discriminacionIndicador = $idsiq_discriminacionIndicador;
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
