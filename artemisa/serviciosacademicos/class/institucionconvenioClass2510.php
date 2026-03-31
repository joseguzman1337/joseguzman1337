<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of institucionconvenioClass
 *
 * @author Administrador
 */

Class institucionconvenioClass {
    //put your code here
    
    var $idsiq_institucionconvenio = null;
    var $nombreinstitucion = null;
    var $nit = null;
    var $direccion = null;
    var $telefono= null;
    var $email = null;
    var $nombreinstitucionsuscribe = null;
    var $representantelegal = null;
    var $identificacion = null;
    var $emailrpresentante = null;
    var $idsiq_tipoinstitucion = null;
    var $codigoestado = null;
    
    function __construct() {
        
    }    
    
    function getIdsiq_institucionconvenio() {
        return $this->idsiq_institucionconvenio;
    }

    function setIdsiq_institucionconvenio($idsiq_institucionconvenio) {
        $this->idsiq_institucionconvenio = $idsiq_institucionconvenio;
    }

    function getNombreinstitucion() {
        return $this->nombreinstitucion;
    }

    function setNombreinstitucion($nombreinstitucion) {
        $this->nombreinstitucion = $nombreinstitucion;
    }

    function getNit() {
        return $this->nit;
    }

    function setNit($nit) {
        $this->nit = $nit;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function getNombreinstitucionsuscribe() {
        return $this->nombreinstitucionsuscribe;
    }

    function setNombreinstitucionsuscribe($nombreinstitucionsuscribe) {
        $this->nombreinstitucionsuscribe = $nombreinstitucionsuscribe;
    }

    function getRepresentantelegal() {
        return $this->representantelegal;
    }

    function setRepresentantelegal($representantelegal) {
        $this->representantelegal = $representantelegal;
    }

    function getIdentificacion() {
        return $this->identificacion;
    }

    function setIdentificacion($identificacion) {
        $this->identificacion = $identificacion;
    }

    function getEmailrpresentante() {
        return $this->emailrpresentante;
    }

    function setEmailrpresentante($emailrpresentante) {
        $this->emailrpresentante = $emailrpresentante;
    }

    function getIdsiq_tipoinstitucion() {
        return $this->idsiq_tipoinstitucion;
    }

    function setIdsiq_tipoinstitucion($idsiq_tipoinstitucion) {
        $this->idsiq_tipoinstitucion = $idsiq_tipoinstitucion;
    }        

    function getCodigoestado() {
        return $this->Codigoestado;
    }

    function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }  
    
    function __destruct() {
      
    }
}

?>
