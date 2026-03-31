
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
class admitidos_entrevista_conteClass {
        
var $idobs_admitidos_entrevista_conte=null;
var $idobs_admitidos_cab_entrevista=null;
var $codigoestudiante=null;
var $idobs_admitidos_contextoP=null;
var $idobs_admitidos_contexto=null;
var $idobs_tiporiesgo=null;
var $descripcion=null;
var $codigoestado=null;
var $fechacreacion=null;
var $usuariocreacion=null;
var $fechamodificacion=null;
var $usuariomodificacion=null;
var $ip=null;


    public function __construct() {
        
    }
    
    
    public function getIdobs_admitidos_entrevista_conte() {
        return $this->idobs_admitidos_entrevista_conte;
    }
    public function setIdobs_admitidos_entrevista_conte($idobs_admitidos_entrevista_conte) {
        $this->idobs_admitidos_entrevista_conte= $idobs_admitidos_entrevista_conte;
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
    
    public function getIdobs_admitidos_contextoP() {
        return $this->idobs_admitidos_contextoP;
    }
    public function setIdobs_admitidos_contextoP($idobs_admitidos_contextoP) {
        $this->idobs_admitidos_contextoP = $idobs_admitidos_contextoP;
    }

   
    public function getIdobs_admitidos_contexto() {
        return $this->idobs_admitidos_contexto;
    }
    public function setIdobs_admitidos_contexto($idobs_admitidos_contexto) {
        $this->idobs_admitidos_contexto = $idobs_admitidos_contexto;
    }
    
    public function getIdobs_tiporiesgo() {
        return $this->idobs_tiporiesgo;
    }
    public function setIdobs_tiporiesgo($idobs_tiporiesgo) {
        $this->idobs_tiporiesgo = $idobs_tiporiesgo;
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
