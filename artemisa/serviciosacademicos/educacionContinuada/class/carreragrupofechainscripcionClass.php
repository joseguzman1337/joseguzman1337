<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of carreragrupofechainscripcionClass
 *
 * @author proyecto_mgi_cp
 */
class carreragrupofechainscripcionClass {
    
    var $idcarreragrupofechainscripcion = null;
    var $codigocarrera = null;
    var $idgrupo = null;
    var $fechacarreragrupofechainscripcion = null;
    var $idsubperiodo = null;
    var $fechadesdecarreragrupofechainscripcion = null;
    var $fechahastacarreragrupofechainscripcion = null;
    var $fechahastacarreragrupofechainformacion = null;
    var $idusuario = null;
    var $ip = null;
    
    public function __construct() {
        
    }
    
    public function getIdcarreragrupofechainscripcion() {
        return $this->idcarreragrupofechainscripcion;
    }

    public function setIdcarreragrupofechainscripcion($idcarreragrupofechainscripcion) {
        $this->idcarreragrupofechainscripcion = $idcarreragrupofechainscripcion;
    }

    public function getCodigocarrera() {
        return $this->codigocarrera;
    }

    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }

    public function getIdgrupo() {
        return $this->idgrupo;
    }

    public function setIdgrupo($idgrupo) {
        $this->idgrupo = $idgrupo;
    }

    public function getFechacarreragrupofechainscripcion() {
        return $this->fechacarreragrupofechainscripcion;
    }

    public function setFechacarreragrupofechainscripcion($fechacarreragrupofechainscripcion) {
        $this->fechacarreragrupofechainscripcion = $fechacarreragrupofechainscripcion;
    }

    public function getIdsubperiodo() {
        return $this->idsubperiodo;
    }

    public function setIdsubperiodo($idsubperiodo) {
        $this->idsubperiodo = $idsubperiodo;
    }

    public function getFechadesdecarreragrupofechainscripcion() {
        return $this->fechadesdecarreragrupofechainscripcion;
    }

    public function setFechadesdecarreragrupofechainscripcion($fechadesdecarreragrupofechainscripcion) {
        $this->fechadesdecarreragrupofechainscripcion = $fechadesdecarreragrupofechainscripcion;
    }

    public function getFechahastacarreragrupofechainscripcion() {
        return $this->fechahastacarreragrupofechainscripcion;
    }

    public function setFechahastacarreragrupofechainscripcion($fechahastacarreragrupofechainscripcion) {
        $this->fechahastacarreragrupofechainscripcion = $fechahastacarreragrupofechainscripcion;
    }

    public function getFechahastacarreragrupofechainformacion() {
        return $this->fechahastacarreragrupofechainformacion;
    }

    public function setFechahastacarreragrupofechainformacion($fechahastacarreragrupofechainformacion) {
        $this->fechahastacarreragrupofechainformacion = $fechahastacarreragrupofechainformacion;
    }

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
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
