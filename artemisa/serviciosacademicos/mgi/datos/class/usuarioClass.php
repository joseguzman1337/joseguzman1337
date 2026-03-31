<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of userClass
 *
 * @author proyecto_mgi_cp
 */
class usuarioClass {
    
    var $idusuario = null;
    var $usuario = null;
    var $numerodocumento = null;
    var $tipodocumento = null;
    var $apellidos = null;
    var $nombres = null;
    var $codigousuario = null;
    var $semestre = null;
    var $codigorol = null;
    var $fechainiciousuario = null;
    var $fechavencimientousuario = null;
    var $fecharegistrousuario = null;
    var $codigotipousuario = null;
    var $idusuariopadre = null;
    var $ipaccesousuario = null;
    var $codigoestadousuario = null;
    
    public function __construct() {
        
    }
    
    public function __destruct() {
        
    }
    
    public function getIdusuario() {
        return $this->idusuario;
    }

    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function getNumerodocumento() {
        return $this->numerodocumento;
    }

    public function setNumerodocumento($numerodocumento) {
        $this->numerodocumento = $numerodocumento;
    }

    public function getTipodocumento() {
        return $this->tipodocumento;
    }

    public function setTipodocumento($tipodocumento) {
        $this->tipodocumento = $tipodocumento;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    public function getNombres() {
        return $this->nombres;
    }

    public function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    public function getCodigousuario() {
        return $this->codigousuario;
    }

    public function setCodigousuario($codigousuario) {
        $this->codigousuario = $codigousuario;
    }

    public function getSemestre() {
        return $this->semestre;
    }

    public function setSemestre($semestre) {
        $this->semestre = $semestre;
    }

    public function getCodigorol() {
        return $this->codigorol;
    }

    public function setCodigorol($codigorol) {
        $this->codigorol = $codigorol;
    }

    public function getFechainiciousuario() {
        return $this->fechainiciousuario;
    }

    public function setFechainiciousuario($fechainiciousuario) {
        $this->fechainiciousuario = $fechainiciousuario;
    }

    public function getFechavencimientousuario() {
        return $this->fechavencimientousuario;
    }

    public function setFechavencimientousuario($fechavencimientousuario) {
        $this->fechavencimientousuario = $fechavencimientousuario;
    }

    public function getFecharegistrousuario() {
        return $this->fecharegistrousuario;
    }

    public function setFecharegistrousuario($fecharegistrousuario) {
        $this->fecharegistrousuario = $fecharegistrousuario;
    }

    public function getCodigotipousuario() {
        return $this->codigotipousuario;
    }

    public function setCodigotipousuario($codigotipousuario) {
        $this->codigotipousuario = $codigotipousuario;
    }

    public function getIdusuariopadre() {
        return $this->idusuariopadre;
    }

    public function setIdusuariopadre($idusuariopadre) {
        $this->idusuariopadre = $idusuariopadre;
    }

    public function getIpaccesousuario() {
        return $this->ipaccesousuario;
    }

    public function setIpaccesousuario($ipaccesousuario) {
        $this->ipaccesousuario = $ipaccesousuario;
    }

    public function getCodigoestadousuario() {
        return $this->codigoestadousuario;
    }

    public function setCodigoestadousuario($codigoestadousuario) {
        $this->codigoestadousuario = $codigoestadousuario;
    }

}

?>
