
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
class tiporiesgoClass {
        
var $idobs_tiporiesgo=null;
var $nombretiporiesgo=null;
var $codigoestado=null;


    public function __construct() {
        
    }
    
    public function getIdobs_tiporiesgo() {
        return $this->idobs_tiporiesgo;
    }
    public function setIdobs_tiporiesgo($idobs_tiporiesgo) {
        $this->idobs_tiporiesgo = $idobs_tiporiesgo;
    }
    
    public function getNombretiporiesgo() {
        return $this->nombretiporiesgo;
    }
    public function setNombretiporiesgo($nombretiporiesgo) {
        $this->nombretiporiesgo = $nombretiporiesgo;
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
