<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of campoParametrizadoPlantillaEducacionContinuadaClass
 *
 * @author proyecto_mgi_cp
 */
class campoParametrizadoPlantillaEducacionContinuadaClass {
    
    var $idcampoParametrizadoPlantillaEducacionContinuada = null;
    var $nombre = null;
    var $etiqueta = null;
    var $visible = null;
    var $valorDefecto = null;
    var $codigoestado = null;
    
    public function __construct() {
        
    }
    
    public function getIdcampoParametrizadoPlantillaEducacionContinuada() {
        return $this->idcampoParametrizadoPlantillaEducacionContinuada;
    }

    public function setIdcampoParametrizadoPlantillaEducacionContinuada($idcampoParametrizadoPlantillaEducacionContinuada) {
        $this->idcampoParametrizadoPlantillaEducacionContinuada = $idcampoParametrizadoPlantillaEducacionContinuada;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    public function getEtiqueta() {
        return $this->etiqueta;
    }

    public function setEtiqueta($etiqueta) {
        $this->etiqueta = $etiqueta;
    }
    
    public function getVisible() {
        return $this->visible;
    }

    public function setVisible($visible) {
        $this->visible = $visible;
    }
    
    public function getValorDefecto() {
        return $this->valorDefecto;
    }

    public function setValorDefecto($valorDefecto) {
        $this->valorDefecto = $valorDefecto;
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
