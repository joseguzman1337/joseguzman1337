
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
class tipoNivelFormacionClass {
        
var $idsiq_tipoNivelFormacion=null;
var $nombre=null;
var $actividad=null;
var $codigoestado=null;


    public function __construct() {
        
    }
    
    
    public function getIdsiq_tipoNivelFormacion() {
        return $this->idsiq_tipoNivelFormacion;
    }
    public function setIdsiq_tipoNivelFormacion($idsiq_tipoNivelFormacion) {
        $this->idsiq_tipoNivelFormacion= $idsiq_tipoNivelFormacion;
    }
    
    public function getNombre() {
        return $this->nombre;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    public function getActividad() {
        return $this->actividad;
    }
    public function setActividad($actividad) {
        $this->actividad = $actividad;
    }
    
    public function getCodigoestado() {
        return $this->codigoestado;
    }
    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }
           
                        
    public function __destruct() {
        
    }
}
?>
