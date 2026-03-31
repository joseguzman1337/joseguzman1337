
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
class registro_riesgoClass {
        
var $idobs_registro_riesgo=null;
var $codigoperiodo=null;
var $codigoestudiante=null;
var $idobs_tiporiesgo=null;
var $observacionesregistro_riesgo=null;
var $intervencionregistro_riesgo=null;
var $idobs_herramientas_deteccion=null;
var $matriz=null;
var $codigoestado=null;
var $fechacreacion=null;
var $usuariocreacion=null;
var $fechamodificacion=null;
var $usuariomodificacion=null;
var $ip=null;


    public function __construct() {
        
    }
    
    
    public function getIdobs_registro_riesgo() {
        return $this->idobs_registro_riesgo;
    }
    public function setIdobs_registro_riesgo($idobs_registro_riesgo) {
        $this->idobs_registro_riesgo= $idobs_registro_riesgo;
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
    
    public function getIdobs_tiporiesgo() {
        return $this->idobs_tiporiesgo;
    }
    public function setIdobs_tiporiesgo($idobs_tiporiesgo) {
        $this->idobs_tiporiesgo = $idobs_tiporiesgo;
    }
    
    public function getIdobs_herramientas_deteccion() {
        return $this->idobs_herramientas_deteccion;
    }
    public function setIdobs_herramientas_deteccion($idobs_herramientas_deteccion) {
        $this->idobs_herramientas_deteccion = $idobs_herramientas_deteccion;
    }
    
    public function getMatriz() {
        return $this->matriz;
    }
    public function setMatriz($matriz) {
        $this->matriz = $matriz;
    }
    
    public function getObservacionesregistro_riesgo() {
        return $this->observacionesregistro_riesgo;
    }
    public function setObservacionesregistro_riesgo($observacionesregistro_riesgo) {
        $this->observacionesregistro_riesgo = $observacionesregistro_riesgo;
    }
    
    public function getIntervencionregistro_riesgo() {
        return $this->intervencionregistro_riesgo;
    }
    public function setIntervencionregistro_riesgo($intervencionregistro_riesgo) {
        $this->intervencionregistro_riesgo = $intervencionregistro_riesgo;
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
