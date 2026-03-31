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
    
    var $idsiq_institucionconvenio= null;
    var $nombreinstitucion= null;
    var $nit= null;
    var $direccion= null;
    var $telefono= null;
    var $telefonodos= null;
    var $email= null;
    var $nombreinstitucionsuscribe= null;
    var $representantelegal= null;
    var $identificacion= null;
    var $ciudadexpedicion= null;
    var $emailrpresentante= null;
    var $idsiq_tipoinstitucion= null;
    var $codigoestado= null;
    var $usuariocreacion= null;
    var $fechacreacion= null;
    var $usuariomodificacion= null;
    var $fechamodificacion= null;
    var $nombrecontacto= null;
    var $telefonocontacto= null;
    var $cargocontacto= null;
    var $emailcontactodos= null;
    var $nombrecontactobosque= null;
    var $telefonocontactobosque= null;
    var $cargocontactobosque= null;
    var $emailcontactobosque= null;
    var $emailcontactobosquedos= null;

    
    function __construct() {
        
    }    
    public function getIdsiq_institucionconvenio() {
        return $this->idsiq_institucionconvenio;
    }

    public function setIdsiq_institucionconvenio($idsiq_institucionconvenio) {
        $this->idsiq_institucionconvenio = $idsiq_institucionconvenio;
    }

    public function getNombreinstitucion() {
        return $this->nombreinstitucion;
    }

    public function setNombreinstitucion($nombreinstitucion) {
        $this->nombreinstitucion = $nombreinstitucion;
    }

    public function getNit() {
        return $this->nit;
    }

    public function setNit($nit) {
        $this->nit = $nit;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }
    
    public function getTelefonoDos() {
        return $this->telefonodos;
    }

    public function setTelefonoDos($telefonodos) {
        $this->telefonodos = $telefonodos;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getNombreinstitucionsuscribe() {
        return $this->nombreinstitucionsuscribe;
    }

    public function setNombreinstitucionsuscribe($nombreinstitucionsuscribe) {
        $this->nombreinstitucionsuscribe = $nombreinstitucionsuscribe;
    }

    public function getRepresentantelegal() {
        return $this->representantelegal;
    }

    public function setRepresentantelegal($representantelegal) {
        $this->representantelegal = $representantelegal;
    }

    public function getIdentificacion() {
        return $this->identificacion;
    }

    public function setIdentificacion($identificacion) {
        $this->identificacion = $identificacion;
    }
    
    public function getCiudadExpedicion() {
        return $this->ciudadexpedicion;
    }

    public function setCiudadExpedicion($ciudadexpedicion) {
        $this->ciudadexpedicion = $ciudadexpedicion;
    }

    public function getEmailrpresentante() {
        return $this->emailrpresentante;
    }

    public function setEmailrpresentante($emailrpresentante) {
        $this->emailrpresentante = $emailrpresentante;
    }

    public function getIdsiq_tipoinstitucion() {
        return $this->idsiq_tipoinstitucion;
    }

    public function setIdsiq_tipoinstitucion($idsiq_tipoinstitucion) {
        $this->idsiq_tipoinstitucion = $idsiq_tipoinstitucion;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function getUsuariocreacion() {
        return $this->usuariocreacion;
    }

    public function setUsuariocreacion($usuariocreacion) {
        $this->usuariocreacion = $usuariocreacion;
    }

    public function getFechacreacion() {
        return $this->fechacreacion;
    }

    public function setFechacreacion($fechacreacion) {
        $this->fechacreacion = $fechacreacion;
    }

    public function getUsuariomodificacion() {
        return $this->usuariomodificacion;
    }

    public function setUsuariomodificacion($usuariomodificacion) {
        $this->usuariomodificacion = $usuariomodificacion;
    }

    public function getFechamodificacion() {
        return $this->fechamodificacion;
    }

    public function setFechamodificacion($fechamodificacion) {
        $this->fechamodificacion = $fechamodificacion;
    }

    public function getNombrecontacto() {
        return $this->nombrecontacto;
    }

    public function setNombrecontacto($nombrecontacto) {
        $this->nombrecontacto = $nombrecontacto;
    }

    public function getTelefonocontacto() {
        return $this->telefonocontacto;
    }

    public function setTelefonocontacto($telefonocontacto) {
        $this->telefonocontacto = $telefonocontacto;
    }

    public function getCargocontacto() {
        return $this->cargocontacto;
    }

    public function setCargocontacto($cargocontacto) {
        $this->cargocontacto = $cargocontacto;
    }
    
    public function getEmailContactoDos() {
        return $this->emailcontactodos;
    }

    public function setEmailContactoDos($emailcontactodos) {
        $this->emailcontactodos= $emailcontactodos;
    }
    
    public function getNombrecontactobosque() {
        return $this->nombrecontactobosque;
    }

    public function setNombrecontactobosque($nombrecontactobosque) {
        $this->nombrecontactobosque= $nombrecontactobosque;
    }
    
    public function getTelefonocontactobosque() {
        return $this->telefonocontactobosque;
    }

    public function setTelefonocontactobosque($telefonocontactobosque) {
        $this->telefonocontactobosque= $telefonocontactobosque;
    }
    
    public function getCargocontactobosque() {
        return $this->cargocontactobosque;
    }

    public function setCargocontactobosque($cargocontactobosque) {
        $this->cargocontactobosque= $cargocontactobosque;
    }
    
    public function getEmailContactobosque() {
        return $this->emailcontactobosque;
    }

    public function setEmailContactobosque($emailcontactobosque) {
        $this->emailcontactobosque= $emailcontactobosque;
    }
    
    public function getEmailContactobosquedos() {
        return $this->emailcontactobosquedos;
    }

    public function setEmailContactobosquedos($emailcontactobosquedos) {
        $this->emailcontactobosquedos= $emailcontactobosquedos;
    }

            
    function __destruct() {
      
    }
}




?>
