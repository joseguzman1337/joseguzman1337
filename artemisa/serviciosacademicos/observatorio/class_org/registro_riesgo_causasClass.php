
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
class registro_riesgo_causasClass {
        
var $idobs_registro_riesgo_causas=null;
var $idobs_registro_riesgo=null;
var $idobs_causas=null;
var $codigoestado=null;
var $fechacreacion=null;
var $usuariocreacion=null;
var $fechamodificacion=null;
var $usuariomodificacion=null;
var $ip=null;


    public function __construct() {
        
    }
    
    
    public function getIdobs_registro_riesgo_causas() {
        return $this->idobs_registro_riesgo_causas;
    }
    public function setIdobs_registro_riesgo_causas($idobs_registro_riesgo_causas) {
        $this->idobs_registro_riesgo_causas= $idobs_registro_riesgo_causas;
    }
    
    public function getIdobs_registro_riesgo() {
        return $this->idobs_registro_riesgo;
    }
    public function setIdobs_registro_riesgo($idobs_registro_riesgo) {
        $this->idobs_registro_riesgo= $idobs_registro_riesgo;
    }
    
    public function getIdobs_causas() {
        return $this->idobs_causas;
    }
    public function setIdobs_causas($idobs_causas) {
        $this->idobs_causas = $idobs_causas;
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
