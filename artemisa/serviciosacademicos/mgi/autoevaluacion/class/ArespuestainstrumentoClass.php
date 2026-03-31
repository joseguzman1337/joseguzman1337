<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of aspectoClass
 *
 * @author proyecto_mgi_cp
 */
class ArespuestainstrumentoClass {
        
var $idsiq_Arespuestainstrumento=null;
var $idsiq_Ainstrumentoconfiguracion=null;
var $idsiq_Apregunta=null;
var $idsiq_Apreguntarespuesta=null;
var $preg_abierta=null;
var $cedula=null;
var $nombre=null;
var $apellido=null;
var $correo=null;
var $codigoestado=null;
var $usuariocreacion=null;
var $usuariomodificacion=null;
var $fechacreacion=null;
var $fechamodificacion=null;
var $idgrupo=null;
var $ip=null;


    public function __construct() {
        
    }
    
    public function getIdsiq_Arespuestainstrumento() {
        return $this->idsiq_Arespuestainstrumento;
    }

    public function setIdsiq_Arespuestainstrumento($idsiq_Arespuestainstrumento) {
        $this->idsiq_Arespuestainstrumento = $idsiq_Arespuestainstrumento;
    }

    public function getIdsiq_Ainstrumentoconfiguracion() {
        return $this->idsiq_Ainstrumentoconfiguracion;
    }

    public function setIdsiq_Ainstrumentoconfiguracion($idsiq_Ainstrumentoconfiguracion) {
        $this->idsiq_Ainstrumentoconfiguracion = $idsiq_Ainstrumentoconfiguracion;
    }

    public function getIdsiq_Apregunta() {
        return $this->idsiq_Apregunta;
    }

    public function setIdsiq_Apregunta($idsiq_Apregunta) {
        $this->idsiq_Apregunta = $idsiq_Apregunta;
    }

    public function getIdsiq_Apreguntarespuesta() {
        return $this->idsiq_Apreguntarespuesta;
    }

    public function setIdsiq_Apreguntarespuesta($idsiq_Apreguntarespuesta) {
        $this->idsiq_Apreguntarespuesta = $idsiq_Apreguntarespuesta;
    }

    public function getPreg_abierta() {
        return $this->preg_abierta;
    }

    public function setPreg_abierta($preg_abierta) {
        $this->preg_abierta = $preg_abierta;
    }
    
    public function getCedula() {
        return $this->cedula;
    }

    public function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
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

    public function getUsuariomodificacion() {
        return $this->usuariomodificacion;
    }

    public function setUsuariomodificacion($usuariomodificacion) {
        $this->usuariomodificacion = $usuariomodificacion;
    }

    public function getFechacreacion() {
        return $this->fechacreacion;
    }

    public function setFechacreacion($fechacreacion) {
        $this->fechacreacion = $fechacreacion;
    }

    public function getFechamodificacion() {
        return $this->fechamodificacion;
    }

    public function setFechamodificacion($fechamodificacion) {
        $this->fechamodificacion = $fechamodificacion;
    }

    public function getIp() {
        return $this->ip;
    }

    public function setIp($ip) {
        $this->ip = $ip;
    }

	public function getIdgrupo() {
        return $this->idgrupo;
    }

    public function setIdgrupo($idgrupo) {
        $this->idgrupo = $idgrupo;
    }
                            
    public function __destruct() {
        
    }
}
?>
