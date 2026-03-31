
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
class primera_instancia_causasClass {
        
var $idobs_primera_instancia_causas=null;
var $idobs_primera_instancia=null;
var $idobs_causas=null;
var $idobs_herramientas_deteccion=null;
var $idobs_tiporiesgo=null;
var $codigoestado=null;
var $usuariocreacion=null;
var $fechacreacion=null;
var $usuariomodificacion=null;
var $fechamodificacion=null;

var $ip=null;


    public function __construct() {
        
    }
    
    
    public function getIdobs_primera_instancia_causas() {
        return $this->idobs_primera_instancia_causas;
    }
    public function setIdobs_primera_instancia_causas($idobs_primera_instancia_causas) {
        $this->idobs_primera_instancia_causas= $idobs_primera_instancia_causas;
    }
    
    public function getIdobs_primera_instancia() {
        return $this->idobs_primera_instancia;
    }
    public function setIdobs_primera_instancia($idobs_primera_instancia) {
        $this->idobs_primera_instancia= $idobs_primera_instancia;
    }
    
    public function getIdobs_causas() {
        return $this->idobs_causas;
    }
    public function setIdobs_causas($idobs_causas) {
        $this->idobs_causas = $idobs_causas;
    }
    
    public function getIdobs_herramientas_deteccion() {
        return $this->idobs_resgitro_riesgo;
    }
    public function setIdobs_herramientas_deteccion($idobs_herramientas_deteccion) {
        $this->idobs_herramientas_deteccion= $idobs_herramientas_deteccion;
    }
    
    public function getIdobs_tiporiesgo() {
        return $this->idobs_tiporiesgo;
    }
    public function setIdobs_tiporiesgo($idobs_tiporiesgo) {
        $this->idobs_tiporiesgo = $idobs_tiporiesgo;
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
    
    public function getFechacreacion() {
        return $this->fechacreacion;
    }
    public function setFechacreacion($fechacreacion) {
        $this->fechacreacion = $fechacreacion;
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
