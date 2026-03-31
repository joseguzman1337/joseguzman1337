<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of estudiantegrupoClass
 *
 * @author proyecto_mgi_cp
 */
class estudiantegrupoClass {
    //put your code here
    var $idsiq_estudiantegrupo=null;
    var $codigoestado=null;
    var $codigoestudiante=null;
    var $idsiq_grupoconvenio=null;
    var $idgrupo=null;
    var $codigocarrera=null;
    var $codigomodalidadacademica=null;
    var $idestudiantegeneral=null;
    var $fechamodificacion=null;
    var $usuariomodificacion=null;
    var $fechacreacion=null;
    var $usuariocreacion=null;
     function __construct() {
        
    }

     function getIdsiq_estudiantegrupo() {
        return $this->idsiq_estudiantegrupo;
    }

     function setIdsiq_estudiantegrupo($idsiq_estudiantegrupo) {
        $this->idsiq_estudiantegrupo = $idsiq_estudiantegrupo;
    }

     function getCodigoestado() {
        return $this->codigoestado;
    }

     function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

     function getcodigoestudiante() {
        return $this->codigoestudiante;
    }

     function setcodigoestudiante($codigoestudiante) {
        $this->codigoestudiante = $codigoestudiante;
    }

    public function getCodigocarrera() {
        return $this->codigocarrera;
    }

    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera = $codigocarrera;
    }
    
    public function getIdestudiantegeneral() {
        return $this->idestudiantegeneral;
    }

    public function setIdestudiantegeneral($idestudiantegeneral) {
        $this->idestudiantegeneral = $idestudiantegeneral;
    }

        
    public function getCodigomodalidadacademica() {
        return $this->codigomodalidadacademica;
    }

    public function setCodigomodalidadacademica($codigomodalidadacademica) {
        $this->codigomodalidadacademica = $codigomodalidadacademica;
    }

         function getIdsiq_grupoconvenio() {
        return $this->idsiq_grupoconvenio;
    }

     function setIdsiq_grupoconvenio($idsiq_grupoconvenio) {
        $this->idsiq_grupoconvenio = $idsiq_grupoconvenio;
    }

     function getIdgrupo() {
        return $this->idgrupo;
    }

     function setIdgrupo($idgrupo) {
        $this->idgrupo = $idgrupo;
    }

     function getFechamodificacion() {
        return $this->fechamodificacion;
    }

     function setFechamodificacion($fechamodificacion) {
        $this->fechamodificacion = $fechamodificacion;
    }

     function getUsuariomodificacion() {
        return $this->usuariomodificacion;
    }

     function setUsuariomodificacion($usuariomodificacion) {
        $this->usuariomodificacion = $usuariomodificacion;
    }

     function getFechacreacion() {
        return $this->fechacreacion;
    }

     function setFechacreacion($fechacreacion) {
        $this->fechacreacion = $fechacreacion;
    }

     function getUsuariocreacion() {
        return $this->usuariocreacion;
    }

     function setUsuariocreacion($usuariocreacion) {
        $this->usuariocreacion = $usuariocreacion;
    }

        
    function __destruct() {
    
    }
}


?>
