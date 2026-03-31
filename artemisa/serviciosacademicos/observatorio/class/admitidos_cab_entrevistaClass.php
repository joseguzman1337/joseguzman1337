
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
class admitidos_cab_entrevistaClass {
        
var $idobs_admitidos_cab_entrevista=null;
var $codigoperiodo=null;
var $codigoestudiante=null;
var $documentacion_requerida=null;
var $idobs_estadoadmision=null;
var $recomienda_admision_porque=null;
var $puntaje=null;
var $descripcion_general=null;
var $seguimiento=null;
var $recomienda_seguimiento=null;
var $fecha_admision=null;
var $admitido=null;
var $quien_admite=null;
var $codigoestado=null;
var $fechacreacion=null;
var $usuariocreacion=null;
var $fechamodificacion=null;
var $usuariomodificacion=null;
var $ip=null;
var $observaciones_segunda_ent=null;
var $documento_segunda_ent=null;


    public function __construct() {
        
    }
    
    
    public function getIdobs_admitidos_cab_entrevista() {
        return $this->idobs_admitidos_cab_entrevista;
    }
    public function setIdobs_admitidos_cab_entrevista($idobs_admitidos_cab_entrevista) {
        $this->idobs_admitidos_cab_entrevista= $idobs_admitidos_cab_entrevista;
    }
    
    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }
    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo = $codigoperiodo;
    }
    
    public function getCodigoestudiante() {
        return $this->codigoestudiante;
    }
    public function setCodigoestudiante($codigoestudiante) {
        $this->codigoestudiante = $codigoestudiante;
    }
    
    public function getDocumentacion_requerida() {
        return $this->documentacion_requerida;
    }
    public function setDocumentacion_requerida($documentacion_requerida) {
        $this->documentacion_requerida = $documentacion_requerida;
    }

    public function getIdobs_estadoadmision() {
        return $this->idobs_estadoadmision;
    }
    public function setIdobs_estadoadmision($idobs_estadoadmision) {
        $this->idobs_estadoadmision= $idobs_estadoadmision;
    }

    public function getRecomienda_admision_porque() {
        return $this->recomienda_admision_porque;
    }
    public function setRecomienda_admision_porque($recomienda_admision_porque) {
        $this->recomienda_admision_porque = $recomienda_admision_porque;
    }

    
    public function getPuntaje() {
        return $this->puntaje;
    }
    public function setPuntaje($puntaje) {
        $this->puntaje = $puntaje;
    }
	
	public function getDocumento_segunda_ent() {
        return $this->documento_segunda_ent;
    }
    public function setDocumento_segunda_ent($documento_segunda_ent) {
        $this->documento_segunda_ent = $documento_segunda_ent;
    }
    
     public function getDescripcion_general() {
        return $this->descripcion_general;
    }
	
	public function getObservaciones_segunda_ent() {
        return $this->observaciones_segunda_ent;
    }	
	
    public function setObservaciones_segunda_ent($observaciones_segunda_ent) {
        $this->observaciones_segunda_ent = $observaciones_segunda_ent;
    }
	
	public function setDescripcion_general($descripcion_general) {
        $this->descripcion_general = $descripcion_general;
    }
   
    
    public function getSeguimiento() {
        return $this->segumiento;
    }
    public function setSeguimiento($seguimiento) {
        $this->seguimiento = $seguimiento;
    }

    public function getRecomienda_seguimiento() {
        return $this->recomienda_segumiento;
    }
    public function setRecomienda_seguimiento($recomienda_seguimiento) {
        $this->recomienda_seguimiento = $recomienda_seguimiento;
    }

    public function getFecha_admision() {
        return $this->fecha_admision;
    }
    public function setFecha_admision($fecha_admision) {
        $this->fecha_admision = $fecha_admision;
    }

    public function getAdmitido() {
        return $this->admitido;
    }
    public function setAdmitido($admitido) {
        $this->admitido = $admitido;
    }
    
    public function getQuien_admite() {
        return $this->quien_admite;
    }
    public function setQuien_admite($quien_admite) {
        $this->quien_admite = $quien_admite;
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

            
                        
    public function __destruct() {
        
    }
}
?>
