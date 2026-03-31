<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detalle_convenioClass
 *
 * @author Administrador
 */
class detalle_participanteClass {
    //put your code here
    
    var $idsiq_detalle_participante=null;
    var $idsiq_detalle_convenio=null;
    var $idsiq_participante=null;
    var $codigoestado=null;
    var $fechacreacion=null;
    var $usuariocreacion=null;
    var $usuariomodificacion=null;
    var $fechamodificacion=null;
 
    
    
    function __construct() {
        
    }
    
    
    function getIdsiq_detalle_participante() {
        return $this->idsiq_detalle_participante;
    }

     function setIdsiq_detalle_participante($idsiq_detalle_participante) {
        $this->idsiq_detalle_participante = $idsiq_detalle_participante;
    }

    function getIdsiq_detalle_convenioo() {
        return $this->idsiq_detalle_convenio;
    }

     function setIdsiq_detalle_convenio($idsiq_detalle_convenio) {
        $this->idsiq_detalle_convenio = $idsiq_detalle_convenio;
    }

    
     function getIdsiq_participante() {
        return $this->idsiq_participante;
    }

     function setIdsiq_participante($idsiq_participante) {
        $this->idsiq_participante = $idsiq_participante;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function getFechacreacion() {
        return $this->fechacreacion;
    }

    public function setFechacreacion($fechacreacion) {
        $this->fechacreacion = $fechacreacion;
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

    public function getFechamodificacion() {
        return $this->fechamodificacion;
    }

    public function setFechamodificacion($fechamodificacion) {
        $this->fechamodificacion = $fechamodificacion;
    }

            
    function __destruct() {
        
    }
   

    
    
}


?>


