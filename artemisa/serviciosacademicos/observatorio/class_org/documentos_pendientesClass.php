
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
class documentos_pendientesClass { 
var $idobs_documentos_pendientes=null;
var $codigoestudiante=null;
var $idobs_admitidos_cab_entrevista=null;
var $iddocumentos=null;
var $codigoestado=null;
var $usuariocreacion=null;
var $usuariomodificacion=null;
var $fechacreacion=null;
var $fechamodificacion=null;
var $ip=null;


    public function __construct() {
        
    }
    
    public function getIdobs_documentos_pendientes() {
        return $this->idobs_documentos_pendientes;
    }

    public function setIdobs_documentos_pendientes($idobs_documentos_pendientes) {
        $this->idobs_documentos_pendientes = $idobs_documentos_pendientes;
    }
    
    public function getCodigoestudiante() {
        return $this->codigoestudiante;
    }
    public function setCodigoestudiante($codigoestudiante) {
        $this->codigoestudiante = $codigoestudiante;
    }
    
    public function getIdobs_admitidos_cab_entrevista() {
        return $this->idobs_admitidos_cab_entrevista;
    }
    public function setIdobs_admitidos_cab_entrevista($idobs_admitidos_cab_entrevista) {
        $this->idobs_admitidos_cab_entrevista= $idobs_admitidos_cab_entrevista;
    }
    
    public function getIddocumentos() {
        return $this->iddocumentos;
    }

    public function setIddocumentos($iddocumentos) {
        $this->iddocumentos = $iddocumentos;
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
