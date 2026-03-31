
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
class admitidos_entrevistaClass {
        
var $idobs_admitidos_entrevista=null;
var $idobs_admitidos_campos_evaluar=null;
var $idobs_admitidos_cab_entrevista=null;
var $codigoestudiante=null;
var $puntaje=null;
var $descripcion=null;
var $codigoestado=null;
var $fechacreacion=null;
var $usuariocreacion=null;
var $fechamodificacion=null;
var $usuariomodificacion=null;
var $ip=null;


    public function __construct() {
        
    }
    
    
    public function getIdobs_admitidos_entrevista() {
        return $this->idobs_admitidos_entrevista;
    }
    public function setIdobs_admitidos_entrevista($idobs_admitidos_entrevista) {
        $this->idobs_admitidos_entrevista= $idobs_admitidos_entrevista;
    }
    
    public function getIdobs_admitidos_campos_evaluar() {
        return $this->idobs_admitidos_campos_evaluar;
    }
    public function setIdobs_admitidos_campos_evaluar($idobs_admitidos_campos_evaluar) {
        $this->idobs_admitidos_campos_evaluar = $idobs_admitidos_campos_evaluar;
    }
    
    public function getIdobs_admitidos_cab_entrevista() {
        return $this->idobs_admitidos_cab_entrevista;
    }
    public function setIdobs_admitidos_cab_entrevista($idobs_admitidos_cab_entrevista) {
        $this->idobs_admitidos_cab_entrevista = $idobs_admitidos_cab_entrevista;
    }
    
    public function getCodigoestudiante() {
        return $this->codigoestudiante;
    }
    public function setCodigoestudiante($codigoestudiante) {
        $this->codigoestudiante = $codigoestudiante;
    }
    
    public function getPuntaje() {
        return $this->puntaje;
    }
    public function setPuntaje($puntaje) {
        $this->puntaje = $puntaje;
    }
    
    public function getDescripcion() {
        return $this->descripcion;
    }
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
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
