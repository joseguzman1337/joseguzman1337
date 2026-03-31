<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of categoriasExcluidasClass
 *
 * @author proyecto_mgi_cp
 */
class categoriasExcluidasClass {

    var $idsiq_categoriasExcluidas = null;
    var $idDetalleReporte = null;
    var $categoriasExcluidas = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_categoriasExcluidas() {
        return $this->idsiq_categoriasExcluidas;
    }

    public function setIdsiq_categoriasExcluidas($idsiq_categoriasExcluidas) {
        $this->idsiq_categoriasExcluidas = $idsiq_categoriasExcluidas;
    }

    public function getIdDetalleReporte() {
        return $this->idDetalleReporte;
    }

    public function setIdDetalleReporte($idDetalleReporte) {
        $this->idDetalleReporte = $idDetalleReporte;
    }

    public function getCategoriasExcluidas() {
        return $this->categoriasExcluidas;
    }

    public function setCategoriasExcluidas($categoriasExcluidas) {
        $this->categoriasExcluidas = $categoriasExcluidas;
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
