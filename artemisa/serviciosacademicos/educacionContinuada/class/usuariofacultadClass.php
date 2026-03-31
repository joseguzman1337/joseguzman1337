<?php

class usuariofacultadClass {
	 var $idusuario = null;
	 var $usuario = null;
	 var $codigofacultad = null;
	 var $codigotipousuariofacultad = null;
	 var $emailusuariofacultad = null;
	 var $codigoestado = null;
	 
	public function __construct() {
        
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
    
    public function getCodigofacultad() {
        return $this->codigofacultad;
    }

    public function setCodigofacultad($codigofacultad) {
        $this->codigofacultad = $codigofacultad;
    }
    
    public function getCodigotipousuariofacultad() {
        return $this->codigotipousuariofacultad;
    }

    public function setCodigotipousuariofacultad($codigotipousuariofacultad) {
        $this->codigotipousuariofacultad = $codigotipousuariofacultad;
    }
    
    public function getEmailusuariofacultad() {
        return $this->emailusuariofacultad;
    }

    public function setEmailusuariofacultad($emailusuariofacultad) {
        $this->emailusuariofacultad = $emailusuariofacultad;
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