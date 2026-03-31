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
class AinstrumentovaloracionClass {
        
    var $idsiq_Ainstrumentovaloracion=null;
    var $idsiq_Ainstrumentoconfiguracion=null;
    var $valoracion=null;
    var $comentario=null;
    var $codigoestado=null;
    var $usuariocreacion=null;
    var $usuariomodificacion=null;
    var $fechacreacion=null;
    var $fechamodificacion=null;
    var $ip=null;

    
    public function __construct() {
        
    }
    
    public function getIdsiq_Ainstrumentovaloracion() {
        return $this->idsiq_Ainstrumentovaloracion;
    }

    public function setIdsiq_Ainstrumentovaloracion($idsiq_Ainstrumentovaloracion) {
        $this->idsiq_Ainstrumentovaloracion = $idsiq_Ainstrumentovaloracion;
    }

    public function getIdsiq_Ainstrumentoconfiguracion() {
        return $this->idsiq_Ainstrumentoconfiguracion;
    }

    public function setIdsiq_Ainstrumentoconfiguracion($idsiq_Ainstrumentoconfiguracion) {
        $this->idsiq_Ainstrumentoconfiguracion = $idsiq_Ainstrumentoconfiguracion;
    }

    public function getValoracion() {
        return $this->valoracion;
    }

    public function setValoracion($valoracion) {
        $this->valoracion = $valoracion;
    }

    public function getComentario() {
        return $this->comentario;
    }

    public function setComentario($comentario) {
        $this->comentario = $comentario;
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
