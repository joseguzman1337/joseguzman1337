
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of aspectoClass
 *
 * @author proyecto_mgi_cp
 */
class causasClass {
        
var $idobs_causas=null;
var $idobs_tipocausas=null;
var $nombrecausas=null;
var $descripcioncausas=null;
var $codigoestado=null;
var $usuariocreacion=null;
var $usuariomodificacion=null;
var $fechacreacion=null;
var $fechamodificacion=null;
var $ip=null;


    public function __construct() {
        
    }
    
    public function getIdobs_causas() {
        return $this->idobs_causas;
    }

    public function setIdobs_causas($idobs_causas) {
        $this->idobs_causas = $idobs_causas;
    }
    
    public function getIdobs_tipocausas() {
        return $this->idobs_tipocausas;
    }

    public function setIdobs_tipocausas($idobs_tipocausas) {
        $this->idobs_tipocausas = $idobs_tipocausas;
    }
    
    public function getNombrecausas() {
        return $this->nombrecausas;
    }

    public function setNombrecausas($nombrecausas) {
        $this->nombrecausas = $nombrecausas;
    }

    public function getDescripcioncausas() {
        return $this->descripcioncausas;
    }

    public function setDescripcioncausas($descripcioncausas) {
        $this->descripcioncausas = $descripcioncausas;
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
