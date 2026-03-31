<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of relacionEstudianteGrupoInscripcionClass
 *
 * @author proyecto_mgi_cp
 */
class relacionEstudianteGrupoInscripcionClass {
    
    var $idrelacionEstudianteGrupoInscripcion = null;
    var $idEstudianteGeneral = null;
    var $idInscripcion = null;
    var $idGrupo = null;
    var $idPaisResidenciaEstudiante = null;
    var $numeroFactura = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    
    public function __construct() {
        
    }
    
    public function getIdrelacionEstudianteGrupoInscripcion() {
        return $this->idrelacionEstudianteGrupoInscripcion;
    }

    public function setIdrelacionEstudianteGrupoInscripcion($idrelacionEstudianteGrupoInscripcion) {
        $this->idrelacionEstudianteGrupoInscripcion = $idrelacionEstudianteGrupoInscripcion;
    }

    public function getIdEstudianteGeneral() {
        return $this->idEstudianteGeneral;
    }

    public function setIdEstudianteGeneral($idEstudianteGeneral) {
        $this->idEstudianteGeneral = $idEstudianteGeneral;
    }

    public function getIdInscripcion() {
        return $this->idInscripcion;
    }

    public function setIdInscripcion($idInscripcion) {
        $this->idInscripcion = $idInscripcion;
    }

    public function getIdGrupo() {
        return $this->idGrupo;
    }

    public function setIdGrupo($idGrupo) {
        $this->idGrupo = $idGrupo;
    }

    public function getIdPaisResidenciaEstudiante() {
        return $this->idPaisResidenciaEstudiante;
    }

    public function setIdPaisResidenciaEstudiante($idPaisResidenciaEstudiante) {
        $this->idPaisResidenciaEstudiante = $idPaisResidenciaEstudiante;
    }

    public function getNumeroFactura() {
        return $this->numeroFactura;
    }

    public function setNumeroFactura($numeroFactura) {
        $this->numeroFactura = $numeroFactura;
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
        
    public function __destruct() {
        
    }
}
?>
