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
class especialidadClass {
    //put your code here
    
    var $idsiq_especialidad=null;
    var $nombreespecialidad=null;
    var $codigoestado=null;
    var $fechacreacion=null;
    var $usuariocreacion=null;
    var $usuariomodificacion=null;
    var $fechamodificacion=null;
    
    
    function __construct() {
        
    }
    
    public function getIdsiq_especialidad() {
        return $this->idsiq_especialidad;
    }

    public function setIdsiq_especialidad($idsiq_especialidad) {
        $this->idsiq_especialidad = $idsiq_especialidad;
    }

    public function getNombreespecialidad() {
        return $this->nombreespecialidad;
    }

    public function setNombreespecialidad($nombreespecialidad) {
        $this->nombreespecialidad = $nombreespecialidad;
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



