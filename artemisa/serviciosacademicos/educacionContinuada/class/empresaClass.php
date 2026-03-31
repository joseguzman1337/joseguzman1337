<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of empresaClass
 *
 * @author proyecto_mgi_cp
 */
class empresaClass {
    
    var $idempresa = null;
    var $nombreempresa = null;
    var $representantelegalempresa = null;
    var $direccionempresa = null;
    var $ciudadempresa = null;
    var $telefonoempresa = null;
    var $faxempresa = null;
    var $emailempresa = null;
    var $paginawebempresa = null;
    var $nitempresa = null;
    var $personeriaempresa = null;
    var $codigoestado = null;
    var $contactoempresa = null;
    var $emailcontactoempresa = null;
    var $telefonocontactoempresa = null;
    var $idcategoriaempresa = null;
    
    public function __construct() {
        
    }
    
    public function getIdempresa() {
        return $this->idempresa;
    }

    public function setIdempresa($idempresa) {
        $this->idempresa = $idempresa;
    }

    public function getNombreempresa() {
        return $this->nombreempresa;
    }

    public function setNombreempresa($nombreempresa) {
        $this->nombreempresa = $nombreempresa;
    }

    public function getRepresentantelegalempresa() {
        return $this->representantelegalempresa;
    }

    public function setRepresentantelegalempresa($representantelegalempresa) {
        $this->representantelegalempresa = $representantelegalempresa;
    }

    public function getDireccionempresa() {
        return $this->direccionempresa;
    }

    public function setDireccionempresa($direccionempresa) {
        $this->direccionempresa = $direccionempresa;
    }

    public function getCiudadempresa() {
        return $this->ciudadempresa;
    }

    public function setCiudadempresa($ciudadempresa) {
        $this->ciudadempresa = $ciudadempresa;
    }

    public function getTelefonoempresa() {
        return $this->telefonoempresa;
    }

    public function setTelefonoempresa($telefonoempresa) {
        $this->telefonoempresa = $telefonoempresa;
    }

    public function getFaxempresa() {
        return $this->faxempresa;
    }

    public function setFaxempresa($faxempresa) {
        $this->faxempresa = $faxempresa;
    }

    public function getEmailempresa() {
        return $this->emailempresa;
    }

    public function setEmailempresa($emailempresa) {
        $this->emailempresa = $emailempresa;
    }

    public function getPaginawebempresa() {
        return $this->paginawebempresa;
    }

    public function setPaginawebempresa($paginawebempresa) {
        $this->paginawebempresa = $paginawebempresa;
    }

    public function getNitempresa() {
        return $this->nitempresa;
    }

    public function setNitempresa($nitempresa) {
        $this->nitempresa = $nitempresa;
    }

    public function getPersoneriaempresa() {
        return $this->personeriaempresa;
    }

    public function setPersoneriaempresa($personeriaempresa) {
        $this->personeriaempresa = $personeriaempresa;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function getContactoempresa() {
        return $this->contactoempresa;
    }

    public function setContactoempresa($contactoempresa) {
        $this->contactoempresa = $contactoempresa;
    }

    public function getEmailcontactoempresa() {
        return $this->emailcontactoempresa;
    }

    public function setEmailcontactoempresa($emailcontactoempresa) {
        $this->emailcontactoempresa = $emailcontactoempresa;
    }

    public function getTelefonocontactoempresa() {
        return $this->telefonocontactoempresa;
    }

    public function setTelefonocontactoempresa($telefonocontactoempresa) {
        $this->telefonocontactoempresa = $telefonocontactoempresa;
    }

    public function getIdcategoriaempresa() {
        return $this->idcategoriaempresa;
    }

    public function setIdcategoriaempresa($idcategoriaempresa) {
        $this->idcategoriaempresa = $idcategoriaempresa;
    }
        
    public function __destruct() {
        
    }
}
?>
