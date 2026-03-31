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
class grupoconvenioClass {
    //put your code here
    
    
    var $idsiq_grupoconvenio=null;
    var $codigogrupo=null;
    var $numeroparticipante=null;
    var $iddocente=null;
    var $idsiq_detalle_convenio=null;
    var $descripcion=null;
    var $codigoperiodo=null;
    var $codigoestado=null;
    var $fechacreacion=null;
    var $usuariocreacion=null;
    var $usuariomodificacion=null;
    var $fechamodificacion=null;
    
    
    function __construct() {
        
    }
    
     function getIdsiq_grupoconvenio() {
        return $this->idsiq_grupoconvenio;
    }
    
    function setIdsiq_grupoconvenio($idsiq_grupoconvenio) {
        $this->idsiq_grupoconvenio = $idsiq_grupoconvenio;
    }
    
    function getCodigogrupo() {
        return $this->codigogrupo;
    }
    
    function setCodigogrupo($codigogrupo) {
        $this->codigogrupo = $codigogrupo;
    }
    
    function getNumeroparticipante() {
        return $this->numeroparticipante;
    }
    
    function setNumeroparticipante($numeroparticipante) {
        $this->numeroparticipante = $numeroparticipante;
    }
    
    function getIdsiq_detalle_convenio() {
        return $this->idsiq_detalle_convenio;
    }

     function setIdsiq_detalle_convenio($idsiq_detalle_convenio) {
        $this->idsiq_detalle_convenio = $idsiq_detalle_convenio;
    }

    function getIddocente() {
        return $this->iddocente;
    }

     function setIddocente($iddocente) {
        $this->iddocente = $iddocente;
    }

     function getDescripcion() {
        return $this->descripcion;
    }

     function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function getCodigoperiodo() {
        return $this->codigoperiodo;
    }

     function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function getFechacreacion() {
        return $this->fechacreacion;
    }

    public function setFechacreacion($fechacreacion) {
        $this->fechacreacion = $fechacreacion;
    }

    public function getUsuariocreacion() {
        return $this->usuariocreacion;
    }

    public function setUsuariocreacion($usuariocreacion) {
        $this->usuariocreacion = $usuariocreacion;
    }

    public function getUsuariomodificacion() {
        return $this->usuariomodificacion;
    }

    public function setUsuariomodificacion($usuariomodificacion) {
        $this->usuariomodificacion = $usuariomodificacion;
    }

    public function getFechamodificacion() {
        return $this->fechamodificacion;
    }

    public function setFechamodificacion($fechamodificacion) {
        $this->fechamodificacion = $fechamodificacion;
    }

    
    
    function __destruct() {
        
    }
    
    
    
}
?>


 