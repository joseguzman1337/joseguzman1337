<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of seguimientoIndicadorClass
 *
 * @author proyecto_mgi_cp
 */
class seguimientoIndicadorClass {

    var $idsiq_seguimientoIndicador = null;
    var $idActualizacion = null;
    var $comentario = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_seguimientoIndicador() {
        return $this->idsiq_seguimientoIndicador;
    }

    public function setIdsiq_seguimientoIndicador($idsiq_seguimientoIndicador) {
        $this->idsiq_seguimientoIndicador = $idsiq_seguimientoIndicador;
    }

    public function getIdActualizacion() {
        return $this->idActualizacion;
    }

    public function setIdActualizacion($idActualizacion) {
        $this->idActualizacion = $idActualizacion;
    }

    public function getComentario() {
        return $this->comentario;
    }

    public function setComentario($comentario) {
        $this->comentario = $comentario;
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
