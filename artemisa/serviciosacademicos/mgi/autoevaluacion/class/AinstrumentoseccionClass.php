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
class AinstrumentoseccionClass {
        
    var $idsiq_Ainstrumentoseccion=null;
    var $idsiq_Ainstrumentoconfiguracion=null;
    var $idsiq_Aseccion=null;
    var $codigoestado=null;
    var $usuariocreacion=null;
    var $usuariomodificacion=null;
    var $fechacreacion=null;
    var $fechamodificacion=null;
    var $ip=null;

    
    public function __construct() {
        
    }
    
    public function getIdsiq_Ainstrumentoseccion() {
        return $this->idsiq_Ainstrumentoseccion;
    }

    public function setIdsiq_Ainstrumentoseccion($idsiq_Ainstrumentoseccion) {
        $this->idsiq_Ainstrumentoseccion = $idsiq_Ainstrumentoseccion;
    }

    public function getIdsiq_Ainstrumentoconfiguracion() {
        return $this->idsiq_Ainstrumentoconfiguracion;
    }

    public function setIdsiq_Ainstrumentoconfiguracion($idsiq_Ainstrumentoconfiguracion) {
        $this->idsiq_Ainstrumentoconfiguracion = $idsiq_Ainstrumentoconfiguracion;
    }

    
    public function getIdsiq_Aseccion() {
        return $this->idsiq_Aseccion;
    }

    public function setIdsiq_Aseccion($idsiq_Aseccion) {
        $this->idsiq_Aseccion = $idsiq_Aseccion;
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
