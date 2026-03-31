<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detalleReporteClass
 *
 * @author proyecto_mgi_cp
 */
class detalleReporteClass {

    var $idsiq_detalleReporte = null;
    var $idReporte = null;
    var $idDato = null;
    var $etiqueta_columna = null;
    var $filtro = null;
    var $numero_columna = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_detalleReporte() {
        return $this->idsiq_detalleReporte;
    }

    public function setIdsiq_detalleReporte($idsiq_detalleReporte) {
        $this->idsiq_detalleReporte = $idsiq_detalleReporte;
    }

    public function getIdReporte() {
        return $this->idReporte;
    }

    public function setIdReporte($idReporte) {
        $this->idReporte = $idReporte;
    }

    public function getIdDato() {
        return $this->idDato;
    }

    public function setIdDato($idDato) {
        $this->idDato = $idDato;
    }

    public function getEtiqueta_columna() {
        return $this->etiqueta_columna;
    }

    public function setEtiqueta_columna($etiqueta_columna) {
        $this->etiqueta_columna = $etiqueta_columna;
    }

    public function getFiltro() {
        return $this->filtro;
    }

    public function setFiltro($filtro) {
        $this->filtro = $filtro;
    }

    public function getNumero_columna() {
        return $this->numero_columna;
    }

    public function setNumero_columna($numero_columna) {
        $this->numero_columna = $numero_columna;
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
