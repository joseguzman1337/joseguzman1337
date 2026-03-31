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
class ApublicoobjetivoClass {
    
    
var $idsiq_Apublicoobjetivo=null; 
var $idsiq_Ainstrumentoconfiguracion=null; 
var $estudiantenuevo=null; 
var $estudiantegraduando=null; 
var $estudiantesemestre=null; 
var $idsiq_Ainstrumentover=null; 
var $egresadorecien=null; 
var $egresadoconsolidacion=null; 
var $egresadosenior=null; 
var $docenteactivos=null; 
var $docentenuevos=null; 
var $docenteretirado=null; 
var $docentecontinuada=null; 
var $idnivelacademicodocente=null; 
var $codigogenerodocente=null; 
var $edaddocente=null; 
var $decanos=null; 
var $csv=null;
var $directores=null; 
var $coordinadores=null; 
var $codigoestado=null; 
var $usuariocreacion=null; 
var $usuariomodificacion=null; 
var $fechacreacion=null; 
var $fechamodificacion=null; 
var $ip=null; 

    public function __construct() {
        
    }
    
    public function getIdsiq_Apublicoobjetivo() {
        return $this->idsiq_Apublicoobjetivo;
    }

    public function setIdsiq_Apublicoobjetivo($idsiq_Apublicoobjetivo) {
        $this->idsiq_Apublicoobjetivo = $idsiq_Apublicoobjetivo;
    }

    public function getIdsiq_Ainstrumentoconfiguracion() {
        return $this->idsiq_Ainstrumentoconfiguracion;
    }

    public function setIdsiq_Ainstrumentoconfiguracion($idsiq_Ainstrumentoconfiguracion) {
        $this->idsiq_Ainstrumentoconfiguracion = $idsiq_Ainstrumentoconfiguracion;
    }

    public function getEstudiantenuevo() {
        return $this->estudiantenuevo;
    }

    public function setEstudiantenuevo($estudiantenuevo) {
       if (strval($estudiantenuevo)==0){     
           $this->estudiantenuevo = "NULL";
       }else{
           $this->estudiantenuevo = $estudiantenuevo;
       }
    }

    public function getEstudiantegraduando() {
       return $this->estudiantegraduando;
    }

    public function setEstudiantegraduando($estudiantegraduando) {
        //if (empty($estudiantegraduando)){
       if (strval($estudiantegraduando)==0){     
           $this->estudiantegraduando = "NULL";
       }else{
           $this->estudiantegraduando = $estudiantegraduando;
       }
    }

    public function getEstudiantesemestre() {
        return $this->estudiantesemestre;
    }

    public function setEstudiantesemestre($estudiantesemestre) {
        $est=$estudiantesemestre;
            $estot="";
            $t=count($est)-1;
            for ($i=0;$i<count($est);$i++) { 
                if ($i<$t) $estot.=$est[$i].',';
                if ($i==$t) $estot.=$est[$i].'';
            }
           //$_POST['estudiantesemestre']=$estot;
        $this->estudiantesemestre = $estot;
       // echo $this->estudiantesemestre.'thid----';
    }

    public function getIdsiq_Ainstrumentover() {
        return $this->idsiq_Ainstrumentover;
    }

    public function setIdsiq_Ainstrumentover($idsiq_Ainstrumentover) {
        $this->idsiq_Ainstrumentover = $idsiq_Ainstrumentover;
    }

    public function getEgresadorecien() {
        return $this->egresadorecien;
    }

    public function setEgresadorecien($egresadorecien) {
        if (strval($egresadorecien)==0){     
           $this->egresadorecien = "NULL";
       }else{
           $this->egresadorecien = $egresadorecien;
       }
    }

    public function getEgresadoconsolidacion() {
        return $this->egresadoconsolidacion;
    }

    public function setEgresadoconsolidacion($egresadoconsolidacion) {
        if (strval($egresadoconsolidacion)==0){     
           $this->egresadoconsolidacion = "NULL";
       }else{
           $this->egresadoconsolidacion = $egresadoconsolidacion;
       }
    }

    public function getEgresadosenior() {
        return $this->egresadosenior;
    }

    public function setEgresadosenior($egresadosenior) {
        if (strval($egresadosenior)==0){     
           $this->egresadosenior  = "NULL";
       }else{
           $this->egresadosenior  = $egresadosenior ;
       }
       // $this->egresadosenior = $egresadosenior;
    }

    public function getDocenteactivos() {
        return $this->docenteactivos;
    }

    public function setDocenteactivos($docenteactivos) {
        if (strval($docenteactivos)==0){     
           $this->docenteactivos  = "NULL";
       }else{
           $this->docenteactivos  = $docenteactivos ;
       }
        //$this->docenteactivos = $docenteactivos;
    }

    public function getDocentenuevos() {
        return $this->docentenuevos;
    }

    public function setDocentenuevos($docentenuevos) {
        if (strval($docentenuevos)==0){     
           $this->docentenuevos  = "NULL";
       }else{
           $this->docentenuevos  = $docentenuevos ;
       }
      //  $this->docentenuevos = $docentenuevos;
    }

    public function getDocenteretirado() {
        return $this->docenteretirado;
    }

    public function setDocenteretirado($docenteretirado) {
         if (strval($docenteretirado)==0){     
           $this->docenteretirado  = "NULL";
       }else{
           $this->docenteretirado  = $docenteretirado ;
       }
        //$this->docenteretirado = $docenteretirado;
    }

    public function getDocentecontinuada() {
        return $this->docentecontinuada;
    }

    public function setDocentecontinuada($docentecontinuada) {
        if (strval($docentecontinuada)==0){     
           $this->docentecontinuada  = "NULL";
       }else{
           $this->docentecontinuada  = $docentecontinuada ;
       }
       // $this->docentecontinuada = $docentecontinuada;
    }

    public function getIdnivelacademicodocente() {
        return $this->idnivelacademicodocente;
    }

    public function setIdnivelacademicodocente($idnivelacademicodocente) {
        $this->idnivelacademicodocente = $idnivelacademicodocente;
    }

    public function getCodigogenerodocente() {
        return $this->codigogenerodocente;
    }

    public function setCodigogenerodocente($codigogenerodocente) {
        $this->codigogenerodocente = $codigogenerodocente;
    }

    public function getEdaddocente() {
        return $this->edaddocente;
    }

    public function setEdaddocente($edaddocente) {
           $estd=$edaddocente;
            $doctot="";
            $t=count($estd)-1;
            for ($i=0;$i<count($estd);$i++) { 
                if ($i<$t) $doctot.=$estd[$i].',';
                if ($i==$t) $doctot.=$estd[$i].'';
            }
        //echo $doctot;
        $this->edaddocente = $doctot;
    }

    public function getDecanos() {
        return $this->decanos;
    }

    public function setDecanos($decanos) {
         if (strval($decanos)==0){     
           $this->decanos  = "NULL";
       }else{
           $this->decanos = $decanos ;
       }
       // $this->decanos = $decanos;
    }

    public function getDirectores() {
        return $this->directores;
    }

    public function setDirectores($directores) {
        if (strval($directores)==0){     
           $this->directores  = "NULL";
       }else{
           $this->directores = $directores ;
       }
       // $this->directores = $directores;
    }

    public function getCoordinadores() {
        return $this->coordinadores;
    }

    public function setCoordinadores($coordinadores) {
        if (strval($coordinadores)==0){     
           $this->coordinadores  = "NULL";
       }else{
           $this->coordinadores = $coordinadores ;
       }
        //$this->coordinadores = $coordinadores;
    }

    public function getCsv() {
        return $this->csv;
    }

    public function setCsv($csv) {
        if (strval($csv)==0){     
           $this->csv  = "NULL";
       }else{
           $this->csv = $csv ;
       }
       // $this->csv = $csv;
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
