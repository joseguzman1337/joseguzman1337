<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tipoAlertaClass
 *
 * @author proyecto_mgi_cp
 */
class tipoAlertaClass {    
    
    var $idsiq_tipoAlerta = null;
    var $nombre = null;
    var $asunto_correo = null;
    var $plantilla_correo = null;
    var $idTipoResponsable = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_tipoAlerta() {
        return $this->idsiq_tipoAlerta;
    }

    public function setIdsiq_tipoAlerta($idsiq_tipoAlerta) {
        $this->idsiq_tipoAlerta = $idsiq_tipoAlerta;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getAsunto_correo() {
        return $this->asunto_correo;
    }

    public function setAsunto_correo($asunto_correo) {
        $this->asunto_correo = $asunto_correo;
    }

    public function getPlantilla_correo() {
        return $this->plantilla_correo;
    }

    public function setPlantilla_correo($plantilla_correo) {
        $this->plantilla_correo = $plantilla_correo;
    }

    public function getIdTipoResponsable() {
        return $this->idTipoResponsable;
    }

    public function setIdTipoResponsable($idTipoResponsable) {
        if(strval($idTipoResponsable) === '0'){
            $this->idTipoResponsable = "NULL";
        } else {
            $this->idTipoResponsable = $idTipoResponsable;
        }
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
