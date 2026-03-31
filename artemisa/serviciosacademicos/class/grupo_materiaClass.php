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
class grupo_materiaClass {
    //put your code here
    
    
    var $idsiq_grupo_materia=null;
    var $codigo=null;
    var $nombre=null;
    var $codigoestado=null;
    
    
    function __construct() {
        
    }
    
     function getIdsiq_grupo_materia() {
        return $this->idsiq_grupo_materia;
    }
    
    function setIdsiq_grupo_materia($idsiq_grupo_materia) {
        $this->idsiq_grupo_materia = $idsiq_grupo_materia;
    }
    
    function getCodigo() {
        return $this->codigo;
    }
    
    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }
    
    function getNombre() {
        return $this->nombre;
    }
    
    function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    function getCodigoestado() {
        return $this->codigoestado;
    }

     function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

        
    function __destruct() {
        
    }
    
    
    
}
?>


 