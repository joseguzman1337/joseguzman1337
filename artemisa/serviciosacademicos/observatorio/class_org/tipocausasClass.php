
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
class tipocausasClass {
        
var $idobs_tipocausas=null;
var $nombretipocausas=null;
var $descripciontipocausas=null;
var $codigoestado=null;
var $usuariocreacion=null;
var $usuariomodificacion=null;
var $fechacreacion=null;
var $fechamodificacion=null;
var $ip=null;


    public function __construct() {
        
    }
    
    public function getIdobs_tipocausas() {
        return $this->idobs_tipocausas;
    }

    public function setIdobs_tipocausas($idobs_tipocausas) {
        $this->idobs_tipocausas = $idobs_tipocausas;
    }
    
    public function getNombretipocausas() {
        return $this->nombretipocausas;
    }

    public function setNombretipocausas($nombretipocausas) {
        $this->nombretipocausas = $nombretipocausas;
    }

    public function getDescripciontipocausas() {
        return $this->descripciontipocausas;
    }

    public function setDescripciontipocausas($descripciontipocausas) {
        $this->descripciontipocausas = $descripciontipocausas;
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
