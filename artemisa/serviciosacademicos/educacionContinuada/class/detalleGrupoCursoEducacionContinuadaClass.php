<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detalleGrupoCursoEducacionContinuadaClass
 *
 * @author proyecto_mgi_cp
 */
class detalleGrupoCursoEducacionContinuadaClass {
    
    var $iddetalleGrupoCursoEducacionContinuada = null;
    var $idgrupo = null;
    var $ciudad = null;
    var $tipo = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIddetalleGrupoCursoEducacionContinuada() {
        return $this->iddetalleGrupoCursoEducacionContinuada;
    }

    public function setIddetalleGrupoCursoEducacionContinuada($iddetalleGrupoCursoEducacionContinuada) {
        $this->iddetalleGrupoCursoEducacionContinuada = $iddetalleGrupoCursoEducacionContinuada;
    }

    public function getIdgrupo() {
        return $this->idgrupo;
    }

    public function setIdgrupo($idgrupo) {
        $this->idgrupo = $idgrupo;
    }

    public function getCiudad() {
        return $this->ciudad;
    }

    public function setCiudad($ciudad) {
        $this->ciudad = $ciudad;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
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
