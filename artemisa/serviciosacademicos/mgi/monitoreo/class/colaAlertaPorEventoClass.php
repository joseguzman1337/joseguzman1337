<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of colaAlertaPorEventoClass
 *
 * @author proyecto_mgi_cp
 */
class colaAlertaPorEventoClass {

    var $idsiq_colaAlertaPorEvento = null;
    var $idAlerta = null;
    var $asunto = null;
    var $mensaje = null;
    var $fecha_envio = null;
    var $destinatarios = null;
    var $resultado = null;
    var $enviado = null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_colaAlertaPorEvento() {
        return $this->idsiq_colaAlertaPorEvento;
    }

    public function setIdsiq_colaAlertaPorEvento($idsiq_colaAlertaPorEvento) {
        $this->idsiq_colaAlertaPorEvento = $idsiq_colaAlertaPorEvento;
    }

    public function getIdAlerta() {
        return $this->idAlerta;
    }

    public function setIdAlerta($idAlerta) {
        $this->idAlerta = $idAlerta;
    }

    public function getAsunto() {
        return $this->asunto;
    }

    public function setAsunto($asunto) {
        $this->asunto = $asunto;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function getFecha_envio() {
        return $this->fecha_envio;
    }

    public function setFecha_envio($fecha_envio) {
        $this->fecha_envio = $fecha_envio;
    }

    public function getDestinatarios() {
        return $this->destinatarios;
    }

    public function setDestinatarios($destinatarios) {
        $this->destinatarios = $destinatarios;
    }

    public function getResultado() {
        return $this->resultado;
    }

    public function setResultado($resultado) {
        $this->resultado = $resultado;
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

    public function getEnviado() {
        return $this->enviado;
    }

    public function setEnviado($enviado) {
        $this->enviado = $enviado;
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
