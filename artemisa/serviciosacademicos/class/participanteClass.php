<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of participanteClass
 *
 * @author Administrador
 */
class participanteClass {
    //put your code here
    
    var $idsiq_participante=null;
    var $codigoestado=null;
    var $apellidoparticipante=null;
    var $nombreparticipante=null;
    var $idtipodocumento=null;
    var $numerodocumento=null;
    var $emailparticipante=null;
    var $fechanacimiento=null;
    var $idpaisnacimiento=null;
    var $iddepartamentonacimiento=null;
    var $idciudadnacimiento=null;
    var $idestadocivil=null;
    var $direccionparticipante=null;
    var $idciudadrecidencia=null;
    var $telefonorecidenciaparticipante=null;
    var $codigogenero=null;
    var $profesion=null;
    var $cargo=null;
    var $fechacreacion=null;
    var $usuariocreacion=null;
    var $usuariomodificacion=null;
    var $fechamodificacion=null;
    
    
    function __construct() {
        
    }
    
    
     function getIdsiq_participante() {
        return $this->idsiq_participante;
    }

     function setIdsiq_participante($idsiq_participante) {
        $this->idsiq_participante = $idsiq_participante;
    }

     function getCodigoestado() {
        return $this->codigoestado;
    }

     function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

     function getIdsiq_convenio() {
        return $this->idsiq_convenio;
    }

     function setIdsiq_convenio($idsiq_convenio) {
        $this->idsiq_convenio = $idsiq_convenio;
    }

     function getApellidoparticipante() {
        return $this->apellidoparticipante;
    }

     function setApellidoparticipante($apellidoparticipante) {
        $this->apellidoparticipante = $apellidoparticipante;
    }

     function getNombreparticipante() {
        return $this->nombreparticipante;
    }

     function setNombreparticipante($nombreparticipante) {
        $this->nombreparticipante = $nombreparticipante;
    }

     function getIdtipodocumento() {
        return $this->idtipodocumento;
    }

     function setIdtipodocumento($idtipodocumento) {
        $this->idtipodocumento = $idtipodocumento;
    }

     function getNumerodocumento() {
        return $this->numerodocumento;
    }

     function setNumerodocumento($numerodocumento) {
        $this->numerodocumento = $numerodocumento;
    }

     function getEmailparticipante() {
        return $this->emailparticipante;
    }

     function setEmailparticipante($emailparticipante) {
        $this->emailparticipante = $emailparticipante;
    }

     function getFechanacimiento() {
        return $this->fechanacimiento;
    }

     function setFechanacimiento($fechanacimiento) {
        $this->fechanacimiento = $fechanacimiento;
    }

     function getIdpaisnacimiento() {
        return $this->idpaisnacimiento;
    }

     function setIdpaisnacimiento($idpaisnacimiento) {
        $this->idpaisnacimiento = $idpaisnacimiento;
    }

     function getIddepartamentonacimiento() {
        return $this->iddepartamentonacimiento;
    }

     function setIddepartamentonacimiento($iddepartamentonacimiento) {
        $this->iddepartamentonacimiento = $iddepartamentonacimiento;
    }

     function getIdciudadnacimiento() {
        return $this->idciudadnacimiento;
    }

     function setIdciudadnacimiento($idciudadnacimiento) {
        $this->idciudadnacimiento = $idciudadnacimiento;
    }

     function getIdestadocivil() {
        return $this->idestadocivil;
    }

     function setIdestadocivil($idestadocivil) {
        $this->idestadocivil = $idestadocivil;
    }

     function getDireccionpartipante() {
        return $this->direccionpartipante;
    }

     function setDireccionparticipante($direccionparticipante) {
        $this->direccionparticipante = $direccionparticipante;
    }

     function getIdciudadrecidencia() {
        return $this->idciudadrecidencia;
    }

     function setIdciudadrecidencia($idciudadrecidencia) {
        $this->idciudadrecidencia = $idciudadrecidencia;
    }

     function getTelefonorecidenciaparticipante() {
        return $this->telefonorecidenciaparticipante;
    }

     function setTelefonorecidenciaparticipante($telefonorecidenciaparticipante) {
        $this->telefonorecidenciaparticipante = $telefonorecidenciaparticipante;
    }

     function getCodigogenero() {
        return $this->codigogenero;
    }

     function setCodigogenero($codigogenero) {
        $this->codigogenero = $codigogenero;
    }

     function getProfesion() {
        return $this->profesion;
    }

     function setProfesion($profesion) {
        $this->profesion = $profesion;
    }
    
     function getCargo() {
        return $this->cargo;
    }

     function setCargo($cargo) {
        $this->cargo = $cargo;
    }
    
    public function getFechacreacion() {
        return $this->fechacreacion;
    }

    public function setFechacreacion($fechacreacion) {
        $this->fechacreacion = $fechacreacion;
    }

    public function getUsuariocreacion() {
        return $this->usuariocreacion;
    }

    public function setUsuariocreacion($usuariocreacion) {
        $this->usuariocreacion = $usuariocreacion;
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

    
    function __destruct() {
        
    }
    
    
    
}
?>


