<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of moodle_modalidadAcademicaClass
 *
 * @author proyecto_mgi_cp
 */
class moodle_modalidadAcademicaClass { 
    
    var $idsiq_moodle_modalidadAcademica = null;
    var $idmoodle = null;
    var $idmoodle2 = null;
    var $nombre = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_moodle_modalidadAcademica() {
        return $this->idsiq_moodle_modalidadAcademica;
    }

    public function setIdsiq_moodle_modalidadAcademica($idsiq_moodle_modalidadAcademica) {
        $this->idsiq_moodle_modalidadAcademica = $idsiq_moodle_modalidadAcademica;
    }
    
    public function getIdmoodle() {
        return $this->idmoodle;
    }

    public function setIdmoodle($idmoodle) {
        $this->idmoodle = $idmoodle;
    }
    
    public function getIdmoodle2() {
        return $this->idmoodle2;
    }

    public function setIdmoodle2($idmoodle2) {
        $this->idmoodle2 = $idmoodle2;
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
