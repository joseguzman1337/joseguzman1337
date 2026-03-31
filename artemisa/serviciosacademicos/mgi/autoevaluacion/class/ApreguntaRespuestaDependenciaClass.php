<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ApreguntaRespuestaDependenciaClass
 *
 * @author proyecto_mgi_cp
 */
class ApreguntaRespuestaDependenciaClass {
    
    var $idsiq_ApreguntaRespuestaDependencia = null;
    var $idDependencia = null;
    var $tipo = null;
    var $idRespuesta = null;
    var $idInstrumento = null;
    var $codigoestado = null;
    var $usuariocreacion = null;
    var $usuariomodificacion = null;
    var $fechacreacion = null;
    var $fechamodificacion = null;
    var $ip = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_ApreguntaRespuestaDependencia() {
        return $this->idsiq_ApreguntaRespuestaDependencia;
    }

    public function setIdsiq_ApreguntaRespuestaDependencia($idsiq_ApreguntaRespuestaDependencia) {
        $this->idsiq_ApreguntaRespuestaDependencia = $idsiq_ApreguntaRespuestaDependencia;
    }

    public function getIdDependencia() {
        return $this->idDependencia;
    }

    public function setIdDependencia($idDependencia) {
        $this->idDependencia = $idDependencia;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getIdRespuesta() {
        return $this->idRespuesta;
    }

    public function setIdRespuesta($idRespuesta) {
        $this->idRespuesta = $idRespuesta;
    }

    public function getIdInstrumento() {
        return $this->idInstrumento;
    }

    public function setIdInstrumento($idInstrumento) {
        $this->idInstrumento = $idInstrumento;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
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

    public function getFechacreacion() {
        return $this->fechacreacion;
    }

    public function setFechacreacion($fechacreacion) {
        $this->fechacreacion = $fechacreacion;
    }

    public function getFechamodificacion() {
        return $this->fechamodificacion;
    }

    public function setFechamodificacion($fechamodificacion) {
        $this->fechamodificacion = $fechamodificacion;
    }

    public function getIp() {
        return $this->ip;
    }

    public function setIp($ip) {
        $this->ip = $ip;
    }
        
    public function __destruct() {
        
    }
}
?>
