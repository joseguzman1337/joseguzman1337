
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
class remisionClass {
        
var $idobs_remision=null;
var $idobs_tiporemision=null;
var $codigoperiodo=null;
var $codigoestudiante=null;
var $idobs_registro_riesgo=null;
var $codigoestado=null;
var $fechacreacion=null;
var $usuariocreacion=null;
var $fechamodificacion=null;
var $usuariomodificacion=null;
var $ip=null;


    public function __construct() {
        
    }
    
    
    public function getIdobs_remision() {
        return $this->idobs_remision;
    }
    public function setIdobs_remision($idobs_remision) {
        $this->idobs_remision= $idobs_remision;
    }
    
    public function getIdobs_tiporemision() {
        return $this->idobs_tiporemision;
    }
    public function setIdobs_tiporemision($idobs_tiporemision) {
        $this->idobs_tiporemision= $idobs_tiporemision;
    }
      
    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }
    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }
    
    
    public function getCodigoestudiante() {
        return $this->codigoestudiante;
    }
    public function setCodigoestudiante($codigoestudiante) {
        $this->codigoestudiante = $codigoestudiante;
    }
    
    public function getIdobs_registro_riesgo() {
        return $this->idobs_registro_riesgo;
    }
    public function setIdobs_registro_riesgo($idobs_registro_riesgo) {
        $this->idobs_registro_riesgo = $idobs_registro_riesgo;
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
