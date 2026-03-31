<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of anexoClass
 *
 * @author proyecto_mgi_cp
 */
class anexoClass {
    //put your code here
    var $idsiq_anexo=null;
    var $anio=null;
    var $observacion=null;
    var $nombrearchivo=null;
    var $rutadelarchivo=null;
    var $idsiq_convenio=null;
    var $idsiq_tipoanexo=null;
    var $codigoestado=null;
    var $fechacreacion=null;
    var $usuariocreacion=null;
    var $usuariomodificacion=null;
    var $fechamodificacion=null;
    var $idsiq_juridico=null;
    
    function __construct() {
    
    }

    function getIdsiq_anexo() {
        return $this->idsiq_anexo;
    }

    function setIdsiq_anexo($idsiq_anexo) {
        $this->idsiq_anexo = $idsiq_anexo;
    }

    function getAnio() {
        return $this->anio;
    }

    function setAnio($anio) {
        $this->anio = $anio;
    }

    function getObservacion() {
        return $this->observacion;
    }

    function setObservacion($observacion) {
        $this->observacion = $observacion;
    }

    function getNombrearchivo() {
        return $this->nombrearchivo;
    }

    function setNombrearchivo($nombrearchivo) {
        $this->nombrearchivo = $nombrearchivo;
    }

    function getRutadelarchivo() {
        return $this->rutadelarchivo;
    }

    function setRutadelarchivo($rutadelarchivo) {
        $this->rutadelarchivo = $rutadelarchivo;
    }

    function getIdsiq_convenio() {
        return $this->idsiq_convenio;
    }

    function setIdsiq_convenio($idsiq_convenio) {
        $this->idsiq_convenio = $idsiq_convenio;
    }

    function getIdsiq_tipoanexo() {
        return $this->idsiq_tipoanexo;
    }

    function setIdsiq_tipoanexo($idsiq_tipoanexo) {
        $this->idsiq_tipoanexo = $idsiq_tipoanexo;
    }

    function getCodigoestado() {
        return $this->codigoestado;
    }

    function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    function getFechacreacion() {
        return $this->fechacreacion;
    }

    function setFechacreacion($fechacreacion) {
        $this->fechacreacion = $fechacreacion;
    }

    function getUsuariocreacion() {
        return $this->usuariocreacion;
    }

    function setUsuariocreacion($usuariocreacion) {
        $this->usuariocreacion = $usuariocreacion;
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

    public function getIdsiq_juridico() {
        return $this->idsiq_juridico;
    }

    public function setIdsiq_juridico($idsiq_juridico) {
        $this->idsiq_juridico = $idsiq_juridico;
    }

    
    
    
    function __destruct() {
        
    }
}




?>


