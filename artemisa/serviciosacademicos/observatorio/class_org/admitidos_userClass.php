
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
class admitidos_userClass {
        
var $idobs_admitidos_user=null;
var $idobs_admitidos_cab_entrevista=null;
var $idusuario=null;
var $codigotipousuario=null;
var $codigoestado=null;
var $fechacreacion=null;
var $usuariocreacion=null;
var $fechamodificacion=null;
var $usuariomodificacion=null;
var $ip=null;


    public function __construct() {
        
    }
    
    
    public function getIdobs_admitidos_user() {
        return $this->idobs_admitidos_user;
    }
    public function setIdobs_admitidos_user($idobs_admitidos_user) {
        $this->idobs_admitidos_user= $idobs_admitidos_user;
    }
     
    public function getIdobs_admitidos_cab_entrevista() {
        return $this->idobs_admitidos_cab_entrevista;
    }
    public function setIdobs_admitidos_cab_entrevista($idobs_admitidos_cab_entrevista) {
        $this->idobs_admitidos_cab_entrevista = $idobs_admitidos_cab_entrevista;
    }
    
    public function getIdusuario() {
        return $this->idusuario;
    }
    public function setIdusuario($idusuario) {
        $this->idusuario = $idusuario;
    }
    
    public function getCodigotipousuario() {
        return $this->codigotipousuario;
    }
    public function setCodigotipousuario($codigotipousuario) {
        $this->codigotipousuario = $codigotipousuario;
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
