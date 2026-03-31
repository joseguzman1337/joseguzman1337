<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of convenioClass
 *
 * @author Administrador
 */
class convenioClass {
    //put your code here
    
    var $idsiq_convenio= null;
    var $nombreconvenio= null;
    var $idpais= null;
    var $codigoconvenio= null;
    var $idsiq_duracionconvenio= null;
    var $fechainicio= null;
    var $fechafin= null;
    var $valorcontraprestacion= null;
    var $portafolioservicio= null;
    var $idsiq_institucionconvenio= null;
    var $idsiq_tipoconvenio= null;
    var $idsiq_contraprestacion= null;
    var $codigoestado= null;
    var $renovacionautomatica=null;
    var $fechacreacion=null;
    var $usuariocreacion=null;
    var $usuariomodificacion=null;
    var $fechamodificacion=null;
    var $tienepoliza=null;
    var $afiliacionarp=null;
    var $afiliacionsss=null;
    var $objetogeneralconvenio=null;
    var $clausulaterminacion=null;
    
    function __construct() {
        
    }
    
    function getIdsiq_convenio() {
        return $this->idsiq_convenio;
    }

    function setIdsiq_convenio($idsiq_convenio) {
        $this->idsiq_convenio = $idsiq_convenio;
    }

    function getNombreconvenio() {
        return $this->nombreconvenio;
    }

    function setNombreconvenio($nombreconvenio) {
        $this->nombreconvenio = $nombreconvenio;
    }

    function getIdpais() {
        return $this->idpais;
    }

    function setIdpais($idpais) {
        $this->idpais = $idpais;
    }

    function getCodigoconvenio() {
        return $this->codigoconvenio;
    }

    function setCodigoconvenio($codigoconvenio) {
        $this->codigoconvenio = $codigoconvenio;
    }

    function getIdsiq_duracionconvenio() {
        return $this->idsiq_duracionconvenio;
    }

    function setIdsiq_duracionconvenio($idsiq_duracionconvenio) {
        $this->idsiq_duracionconvenio = $idsiq_duracionconvenio;
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

    function getValorcontraprestacion() {
        return $this->valorcontraprestacion;
    }

    function setValorcontraprestacion($valorcontraprestacion) {
        $this->valorcontraprestacion = $valorcontraprestacion;
    }

    function getPortafolioservicio() {
        return $this->portafolioservicio;
    }

    function setPortafolioservicio($portafolioservicio) {
        $this->portafolioservicio = $portafolioservicio;
    }


    function getIdsiq_institucionconvenio() {
        return $this->idsiq_institucionconvenio;
    }

    function setIdsiq_institucionconvenio($idsiq_institucionconvenio) {
        $this->idsiq_institucionconvenio = $idsiq_institucionconvenio;
    }

    function getIdsiq_tipoconvenio() {
        return $this->idsiq_tipoconvenio;
    }

    function setIdsiq_tipoconvenio($idsiq_tipoconvenio) {
        $this->idsiq_tipoconvenio = $idsiq_tipoconvenio;
    }

    function getIdsiq_contraprestacion() {
        return $this->idsiq_contraprestacion;
    }

    function setIdsiq_contraprestacion($idsiq_contraprestacion) {
        $this->idsiq_contraprestacion = $idsiq_contraprestacion;
    }
    
    function getCodigoestado() {
        return $this->codigoestado;
    }

    function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }
    
    function getRenovacionautomatica() {
        return $this->renovacionautomatica;
    }

    function setRenovacionautomatica($renovacionautomatica) {
        $this->renovacionautomatica = $renovacionautomatica;
    }
    
    function getFechacreacion() {
        return $this->fechacreacion;
    }

    function setFechacreacion($fechacreacion) {
        $this->fechacreacion = $fechacreacion;
    }
    
    function getFechamodificacion() {
        return $this->fechamodificacion;
    }

    function setFechamodificacion($fechamodificacion) {
        $this->fechamodificacion = $fechamodificacion;
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
    
    function getTienepoliza() {
        return $this->tienepoliza;
    }

    function setTienepoliza($tienepoliza) {
        $this->tienepoliza = $tienepoliza;
    }
    
    function getAfiliacionarp() {
        return $this->afiliacionarp;
    }

    function setAfiliacionarp($afiliacionarp) {
        $this->afiliacionarp = $afiliacionarp;
    }
    
    function getAfiliacionsss() {
        return $this->afiliacionsss;
    }

    function setAfiliacionsss($afiliacionsss) {
        $this->afiliacionsss = $afiliacionsss;
    }
    
    function getObjetogeneralconvenio() {
        return $this->objetogeneralconvenio;
    }

    function setObjetogeneralconvenio($objetogeneralconvenio) {
        $this->objetogeneralconvenio = $objetogeneralconvenio;
    }
    
    function getClausulaterminacion() {
        return $this->clausulaterminacion;
    }

    function setClausulaterminacion($clausulaterminacion) {
        $this->clausulaterminacion = $clausulaterminacion;
    }
    
    
    function __destruct() {
       
    }    
}


?>
