<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detalle_convenioClass
 *
 * @author Administrador
 */
class detalle_convenioClass {
    //put your code here
    
    var $idsiq_detalle_convenio=null;
    var $numeroconvenio=null;    
    var $fechainicio=null;
    var $fechafin=null;    
    var $codigosnies=null;    
    var $numeroregcalificado=null;
    var $numeroregcalificadodos=null;    
    var $maximoparticipantes=null;
    var $idciudad=null;    
    var $idsiq_convenio=null;
    var $duracion_resolucion=null;
    var $codigo_programa=null;
    var $dato_carrera=null;
    var $codigoestado=null;
    var $usuariocreacion=null;
    var $fechacreacion=null;
    var $usuariomodificacion=null;
    var $fechamodificacion=null;
    var $idsiq_especialidad=null;
    var $codigomodalidadacademica=null;
    var $codigofacultad=null;
    var $codigocarrera=null;
    
    
    
    
    
    
    function __construct() {
        
    }
    
    function getIdsiq_detalle_convenio() {
        return $this->idsiq_detalle_convenio;
    }

    function setIdsiq_detalle_convenio($idsiq_detalle_convenio) {
        $this->idsiq_detalle_convenio = $idsiq_detalle_convenio;
    }

    function getNumeroconvenio() {
        return $this->numeroconvenio;
    }

    function setNumeroconvenio($numeroconvenio) {
        $this->numeroconvenio = $numeroconvenio;
    }    

    function getFechainicio() {
        return $this->fechainicio;
    }

    function setFechainicio($fechainicio) {
        $this->fechainicio = $fechainicio;
    }

    function getFechafin() {
        return $this->fechafin;
    }

    function setFechafin($fechafin) {
        $this->fechafin = $fechafin;
    }
    

    function getCodigosnies() {
        return $this->codigosnies;
    }

    function setCodigosnies($codigosnies) {
        $this->codigosnies = $codigosnies;
    }
    

    function getNumeroregcalificado() {
        return $this->numeroregcalificado;
    }

    function setNumeroregcalificado($numeroregcalificado) {
        $this->numeroregcalificado = $numeroregcalificado;
    }
    
    function getNumeroregcalificadodos() {
        return $this->numeroregcalificadodos;
    }

    function setNumeroregcalificadodos($numeroregcalificadodos) {
        $this->numeroregcalificadodos = $numeroregcalificadodos;
    }
    

    function getMaximoparticipantes() {
        return $this->maximoparticipantes;
    }

    function setMaximoparticipantes($maximoparticipantes) {
        $this->maximoparticipantes = $maximoparticipantes;
    }

    function getIdciudad() {
        return $this->idciudad;
    }

    function setIdciudad($idciudad) {
        $this->idciudad = $idciudad;
    }
    

    function getIdsiq_convenio() {
        return $this->idsiq_convenio;
    }

    function setIdsiq_convenio($idsiq_convenio) {
        $this->idsiq_convenio = $idsiq_convenio;
    }

    function getCodigoestado() {
        return $this->codigoestado;
    }

    public function getDuracion_resolucion() {
        return $this->duracion_resolucion;
    }

    public function setDuracion_resolucion($duracion_resolucion) {
        $this->duracion_resolucion = $duracion_resolucion;
    }

    public function getCodigo_programa() {
        return $this->codigo_programa;
    }

    public function setCodigo_programa($codigo_programa) {
        $this->codigo_programa = $codigo_programa;
    }

    public function getDato_carrera() {
        return $this->dato_carrera;
    }

    public function setDato_carrera($dato_carrera) {
        $this->dato_carrera = $dato_carrera;
    }

        
    function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    function getUsuariocreacion() {
        return $this->usuariocreacion;
    }

    function setUsuariocreacion($usuariocreacion) {
        $this->usuariocreacion = $usuariocreacion;
    }

    function getFechacreacion() {
        return $this->fechacreacion;
    }

    function setFechacreacion($fechacreacion) {
        $this->fechacreacion = $fechacreacion;
    }

    function getUsuariomodificacion() {
        return $this->usuariomodificacion;
    }

    function setUsuariomodificacion($usuariomodificacion) {
        $this->usuariomodificacion = $usuariomodificacion;
    }

    function getFechamodificacion() {
        return $this->fechamodificacion;
    }

    function setFechamodificacion($fechamodificacion) {
        $this->fechamodificacion = $fechamodificacion;
    }

    function getIdsiq_especialidad() {
        return $this->idsiq_especialidad;
    }

    function setIdsiq_especialidad($idsiq_especialidad) {
        $this->idsiq_especialidad = $idsiq_especialidad;
    }

    public function getCodigomodalidadacademica() {
        return $this->codigomodalidadacademica;
    }

    public function setCodigomodalidadacademica($codigomodalidadacademica) {
        $this->codigomodalidadacademica = $codigomodalidadacademica;
    }

    public function getCodigofacultad() {
        return $this->codigofacultad;
    }

    public function setCodigofacultad($codigofacultad) {
        $this->codigofacultad = $codigofacultad;
    }

    public function getCodigocarrera() {
        return $this->codigocarrera;
    }

    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }

    
            
    function __destruct() {
        
    }
    
    
    
}



?>


