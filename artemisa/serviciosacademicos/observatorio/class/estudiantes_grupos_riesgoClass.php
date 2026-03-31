
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
class estudiantes_grupos_riesgoClass {

var $id_estudiantes_grupos_riesgo =null;      
var $idobs_grupos=null;
var $idestudiantegeneral=null;
var $codigoperiodo=null;
var $codigoestado=null;
var $fechacreacion=null;
var $usuariocreacion=null;
var $fechamodificacion=null;
var $usuariomodificacion=null;
var $ip=null;


    public function __construct() {
        
    }
    
    
    public function getId_estudiantes_grupos_riesgo() {
        return $this->id_estudiantes_grupos_riesgo;
    }
    public function setId_estudiantes_grupos_riesgo($id_estudiantes_grupos_riesgo) {
        $this->id_estudiantes_grupos_riesgo= $id_estudiantes_grupos_riesgo;
    }
    
    public function getIdobs_grupos() {
        return $this->idobs_grupos;
    }
    public function setIdobs_grupos($idobs_grupos) {
        $this->idobs_grupos= $idobs_grupos;
    }
    
    public function getIdestudiantegeneral() {
        return $this->idestudiantegeneral;
    }
    public function setIdestudiantegeneral($idestudiantegeneral) {
        $this->idestudiantegeneral= $idestudiantegeneral;
    }
    
    public function getCodigoestado() {
        return $this->codigoestado;
    }
    public function setCodigoestado($codigoestado) {
        $this->codigoestado= $codigoestado;
    }
    
    public function getCodigoperiodo() {
        return $this->codigoperiodo;
    }
    public function setCodigoperiodo($codigoperiodo) {
        $this->codigoperiodo= $codigoperiodo;
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
