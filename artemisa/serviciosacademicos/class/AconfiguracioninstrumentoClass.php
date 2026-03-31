<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of convenioClass
 *
 * @author Administrador
 */
class AconfiguracioninstrumentoClass {
    //put your code here
    var $idsiq_configuracioninstrumento= null;
    var $mostrar_bienvenida= null;
    var $mostrar_despedida= null;
    var $codigoestado= null;
    var $usuariocreacion= null;
    var $usuariomodificacion= null;
    var $fechacreacion= null;
    var $fechamodificacion= null;
    var $ip= null;

    function __construct() {
        
    }
    
    public function getIdsiq_configuracioninstrumento() {
        return $this->idsiq_configuracioninstrumento;
    }

    public function setIdsiq_configuracioninstrumento($idsiq_configuracioninstrumento) {
        $this->idsiq_configuracioninstrumento = $idsiq_configuracioninstrumento;
    }

    public function getMostrar_bienvenida() {
        return $this->mostrar_bienvenida;
    }

    public function setMostrar_bienvenida($mostrar_bienvenida) {
        $this->mostrar_bienvenida = $mostrar_bienvenida;
    }

    public function getMostrar_despedida() {
        return $this->mostrar_despedida;
    }

    public function setMostrar_despedida($mostrar_despedida) {
        $this->mostrar_despedida = $mostrar_despedida;
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

    
    
    function __destruct() {
       
    }    
}


?>