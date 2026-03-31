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
class convenio_grupoClass {
    //put your code here
    
    
    var $idsiq_convenio_grupo=null;
    var $idsiq_detalle_participante=null;
    var $idsiq_detalle_convenio=null;
    var $codigomateria=null;
    var $descripcion=null;
    
    
    function __construct() {
        
    }
    
     function getIdsiq_convenio_grupo() {
        return $this->idsiq_convenio_grupo;
    }
    
    function setIdsiq_convenio_grupo($idsiq_convenio_grupo) {
        $this->idsiq_convenio_grupo = $idsiq_convenio_grupo;
    }
    
    function getIdsiq_detalle_convenio() {
        return $this->idsiq_detalle_convenio;
    }

     function setIdsiq_detalle_convenio($idsiq_detalle_convenio) {
        $this->idsiq_detalle_convenio = $idsiq_detalle_convenio;
    }

    function getIdsiq_detalle_participante() {
        return $this->idsiq_detalle_participante;
    }

     function setIdsiq_detalle_participante($idsiq_detalle_participante) {
        $this->idsiq_detalle_participante = $idsiq_detalle_participante;
    }
    
    
    function getCodigomateria() {
        return $this->codigomateria;
    }

     function setCodigomateria($codigomateria) {
        $this->codigomateria = $codigomateria;
    }

     function getDescripcion() {
        return $this->descripcion;
    }

     function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }


        
    function __destruct() {
        
    }
    
    
    
}
?>


 