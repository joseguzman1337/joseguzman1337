<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of docenteEducacionContinuadaClass
 *
 * @author proyecto_mgi_cp
 */
class docenteEducacionContinuadaClass {
    
    var $iddocenteEducacionContinuada = null;
    var $apellidodocente = null;
    var $nombredocente = null;
    var $tipodocumento = null;
    var $numerodocumento = null;
    var $emaildocente = null;
    var $codigogenero = null;
    var $direcciondocente = null;
    var $profesion = null;
    var $especialidad = null;
    var $idciudadresidencia = null;
    var $telefonoresidenciadocente = null;
    var $numerocelulardocente = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIddocenteEducacionContinuada() {
        return $this->iddocenteEducacionContinuada;
    }

    public function setIddocenteEducacionContinuada($iddocenteEducacionContinuada) {
        $this->iddocenteEducacionContinuada = $iddocenteEducacionContinuada;
    }

    public function getApellidodocente() {
        return $this->apellidodocente;
    }

    public function setApellidodocente($apellidodocente) {
        $this->apellidodocente = $apellidodocente;
    }

    public function getNombredocente() {
        return $this->nombredocente;
    }

    public function setNombredocente($nombredocente) {
        $this->nombredocente = $nombredocente;
    }

    public function getTipodocumento() {
        return $this->tipodocumento;
    }

    public function setTipodocumento($tipodocumento) {
        $this->tipodocumento = $tipodocumento;
    }

    public function getNumerodocumento() {
        return $this->numerodocumento;
    }

    public function setNumerodocumento($numerodocumento) {
        $this->numerodocumento = $numerodocumento;
    }

    public function getEmaildocente() {
        return $this->emaildocente;
    }

    public function setEmaildocente($emaildocente) {
        $this->emaildocente = $emaildocente;
    }

    public function getCodigogenero() {
        return $this->codigogenero;
    }

    public function setCodigogenero($codigogenero) {
        $this->codigogenero = $codigogenero;
    }

    public function getDirecciondocente() {
        return $this->direcciondocente;
    }

    public function setDirecciondocente($direcciondocente) {
        $this->direcciondocente = $direcciondocente;
    }

    public function getProfesion() {
        return $this->profesion;
    }

    public function setProfesion($profesion) {
        $this->profesion = $profesion;
    }

    public function getEspecialidad() {
        return $this->especialidad;
    }

    public function setEspecialidad($especialidad) {
        $this->especialidad = $especialidad;
    }

    public function getIdciudadresidencia() {
        return $this->idciudadresidencia;
    }

    public function setIdciudadresidencia($idciudadresidencia) {
        $this->idciudadresidencia = $idciudadresidencia;
    }

    public function getTelefonoresidenciadocente() {
        return $this->telefonoresidenciadocente;
    }

    public function setTelefonoresidenciadocente($telefonoresidenciadocente) {
        $this->telefonoresidenciadocente = $telefonoresidenciadocente;
    }

    public function getNumerocelulardocente() {
        return $this->numerocelulardocente;
    }

    public function setNumerocelulardocente($numerocelulardocente) {
        $this->numerocelulardocente = $numerocelulardocente;
    }

    public function getFecha_creacion() {
        return $this->fecha_creacion;
    }

    public function setFecha_creacion($fecha_creacion) {
        $this->fecha_creacion = $fecha_creacion;
    }

    public function getUsuario_creacion() {
        return $this->usuario_creacion;
    }

    public function setUsuario_creacion($usuario_creacion) {
        $this->usuario_creacion = $usuario_creacion;
    }

    public function getCodigoestado() {
        return $this->codigoestado;
    }

    public function setCodigoestado($codigoestado) {
        $this->codigoestado = $codigoestado;
    }

    public function getFecha_modificacion() {
        return $this->fecha_modificacion;
    }

    public function setFecha_modificacion($fecha_modificacion) {
        $this->fecha_modificacion = $fecha_modificacion;
    }

    public function getUsuario_modificacion() {
        return $this->usuario_modificacion;
    }

    public function setUsuario_modificacion($usuario_modificacion) {
        $this->usuario_modificacion = $usuario_modificacion;
    }
        
    public function __destruct() {
        
    }
}
?>
