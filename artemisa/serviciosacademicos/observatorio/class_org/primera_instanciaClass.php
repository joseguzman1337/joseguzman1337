
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
class primera_instanciaClass {
        
var $idobs_primera_instancia=null;    
var $idobs_registro_riesgo=null;
var $aspectosprimera_instancia=null;
var $codigoperiodo=null;
var $codigoestado=null;
var $fechacreacion=null;
var $usuariocreacion=null;
var $fechamodificacion=null;
var $usuariomodificacion=null;
var $ip=null;


    public function __construct() {
        
    }
    
    
    public function getIdobs_primera_instancia() {
        return $this->idobs_primera_instancia;
    }
    public function setIdobs_primera_instancia($idobs_primera_instancia) {
        $this->idobs_primera_instancia= $idobs_primera_instancia;
    }
    
    public function getIdobs_registro_riesgo() {
        return $this->idobs_resgitro_riesgo;
    }
    public function setIdobs_registro_riesgo($idobs_registro_riesgo) {
        $this->idobs_registro_riesgo= $idobs_registro_riesgo;
    }
    
    public function getAspectosprimera_instancia() {
        return $this->aspectosprimera_instancia;
    }
    public function setAspectosprimera_instancia($aspectosprimera_instancia) {
        $this->aspectosprimera_instancia = $aspectosprimera_instancia;
    }
    
    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }
    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
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
