<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of fechaeducacioncontinuadaClass
 *
 * @author proyecto_mgi_cp
 */
class fechaeducacioncontinuadaClass {
    
    var $idfechaeducacioncontinuada = null;
    var $idgrupo = null;
    var $codigoestado = null;
    
    public function __construct() {
        
    }
    
    public function getIdfechaeducacioncontinuada() {
        return $this->idfechaeducacioncontinuada;
    }

    public function setIdfechaeducacioncontinuada($idfechaeducacioncontinuada) {
        $this->idfechaeducacioncontinuada = $idfechaeducacioncontinuada;
    }

    public function getIdgrupo() {
        return $this->idgrupo;
    }

    public function setIdgrupo($idgrupo) {
        $this->idgrupo = $idgrupo;
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
