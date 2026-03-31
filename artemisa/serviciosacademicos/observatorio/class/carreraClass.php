
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
class carreraClass {
        
var $codigocarrera=null;
var $codigocortocarrera=null;
var $nombrecortocarrera=null;
var $nombrecarrera=null;
var $codigofacultad=null;


    public function __construct() {
        
    }
    
    
    public function getCodigocarrera() {
        return $this->codigocarrera;
    }
    public function setCodigocarrera($codigocarrera) {
        $this->codigocarrera= $codigocarrera;
    }
    
    public function getCodigocortocarrera() {
        return $this->codigocortocarrera;
    }
    public function setCodigocortocarrera($codigocortocarrera) {
        $this->codigocortocarrera= $codigocortocarrera;
    }
    
    public function getNombrecortocarrera() {
        return $this->nombrecortocarrera;
    }
    public function setNombrecortocarrera($nombrecortocarrera) {
        $this->nombrecortocarrera= $nombrecortocarrera;
    }
    
    public function getNombrecarrera() {
        return $this->nombrecarrera;
    }
    public function setNombrecarrera($nombrecarrera) {
        $this->nombrecarrera= $nombrecarrera;
    }
    
    public function getCodigofacultad() {
        return $this->codigofacultad;
    }
    public function setCodigofacultad($codigofacultad) {
        $this->codigofacultad= $codigofacultad;
    }
     
            
                        
    public function __destruct() {
        
    }
}
?>
