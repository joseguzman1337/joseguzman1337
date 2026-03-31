<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formTalentoHumanoAcademicosDocentesOtroIdiomaClass
 *
 * @author proyecto_mgi_cp
 */
class formTalentoHumanoAcademicosDocentesOtroIdiomaClass {
    
    var $idsiq_formTalentoHumanoAcademicosDocentesOtroIdioma = null;
    var $codigoperiodo = null;
    var $nombre = null;
    var $idioma = null;
    var $tipoCurso = null;
    var $nivel = null;
    var $horas = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_formTalentoHumanoAcademicosDocentesOtroIdioma() {
        return $this->idsiq_formTalentoHumanoAcademicosDocentesOtroIdioma;
    }

    public function setIdsiq_formTalentoHumanoAcademicosDocentesOtroIdioma($idsiq_formTalentoHumanoAcademicosDocentesOtroIdioma) {
        $this->idsiq_formTalentoHumanoAcademicosDocentesOtroIdioma = $idsiq_formTalentoHumanoAcademicosDocentesOtroIdioma;
    }

    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getIdioma() {
        return $this->idioma;
    }

    public function setIdioma($idioma) {
        $this->idioma = $idioma;
    }

    public function getTipoCurso() {
        return $this->tipoCurso;
    }

    public function setTipoCurso($tipoCurso) {
        $this->tipoCurso = $tipoCurso;
    }

    public function getNivel() {
        return $this->nivel;
    }

    public function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    public function getHoras() {
        return $this->horas;
    }

    public function setHoras($horas) {
        $this->horas = $horas;
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
