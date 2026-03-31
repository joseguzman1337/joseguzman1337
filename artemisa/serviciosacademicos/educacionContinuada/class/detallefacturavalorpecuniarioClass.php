<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ciudadClass
 *
 * @author proyecto_mgi_cp
 */
class detallefacturavalorpecuniarioClass {
    var $iddetallefacturavalorpecuniario = null;
    var $idfacturavalorpecuniario = null;
    var $idvalorpecuniario = null;
    var $codigotipoestudiante = null;
    var $codigoestado = null;
    
    public function __construct() {

    }
	
	public function getIddetallefacturavalorpecuniario() {
        return $this->iddetallefacturavalorpecuniario;
    }

    public function setIddetallefacturavalorpecuniario($iddetallefacturavalorpecuniario) {
        $this->iddetallefacturavalorpecuniario = $iddetallefacturavalorpecuniario;
    }
    
    public function getIdfacturavalorpecuniario() {
        return $this->idfacturavalorpecuniario;
    }

    public function setIdfacturavalorpecuniario($idfacturavalorpecuniario) {
        $this->idfacturavalorpecuniario = $idfacturavalorpecuniario;
    }

    public function getIdvalorpecuniario() {
        return $this->idvalorpecuniario;
    }

    public function setIdvalorpecuniario($idvalorpecuniario) {
        $this->idvalorpecuniario = $idvalorpecuniario;
    }

    public function getCodigotipoestudiante() {
        return $this->codigotipoestudiante;
    }

    public function setCodigotipoestudiante($codigotipoestudiante) {
        $this->codigotipoestudiante = $codigotipoestudiante;
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
