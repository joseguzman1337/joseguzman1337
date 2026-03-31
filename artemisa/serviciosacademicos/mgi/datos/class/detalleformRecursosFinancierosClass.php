<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of detalleformDato1RecursosClass
 *
 * @author proyecto_mgi_cp
 */
class detalleformRecursosFinancierosClass {
    
    var $idsiq_detalleformRecursosFinancieros = null;
    var $idData=null;
    var $idCategory=null;
    var $dato1=null;
    var $dato2=null;
    var $dato3=null;
    var $fecha_creacion = null;
    var $usuario_creacion = null;
    var $codigoestado = null;
    var $fecha_modificacion = null;
    var $usuario_modificacion = null;
    
    public function __construct() {
        
    }
    
    public function getIdsiq_detalleformRecursosFinancieros() {
        return $this->idsiq_detalleformRecursosFinancieros;
    }
    public function setIdsiq_detalleformRecursosFinancieros($idsiq_detalleformRecursosFinancieros) {
        $this->idsiq_detalleformRecursosFinancieros = $idsiq_detalleformRecursosFinancieros;
    }

    public function getIdData() {
        return $this->idData;
    }
    public function setIdData($idData) {
        $this->idData = $idData;
    }
    
    public function getIdCategory() {
        return $this->idCategory;
    }
    public function setIdCategory($idCategory) {
        $this->idCategory = $idCategory;
    }
    
    public function getDato1() {
        return $this->dato1;
    }
    public function setDato1($dato1) {
        $this->dato1 = $dato1;
    }
    
    public function getDato2() {
        return $this->dato2;
    }
    public function setDato2($dato2) {
        $this->dato2 = $dato2;
    }
    
    public function getDato3() {
        return $this->dato3;
    }
    public function setDato3($dato3) {
        $this->dato3 = $dato3;
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
