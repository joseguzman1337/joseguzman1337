<?php

/* 
 * Archivo validaciones
 * 
 * Este archivo es el punto de control antes del ingreso a votaciones, se encarga
 * de orquestar la validacion de las votaciones segun el tipo de usuario que 
 * esta ingresando
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque 
 * @since 18 de septiembre de 2018.
 */

$Configuration = Configuration::getInstance();
/**
 * Se incluye la libreria Factory para tener acceso a todas sus metodos estaticos
 */
require_once (PATH_SITE.'/lib/Factory.php');

class Validaciones{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    public function __construct() {
        $this->db = Factory::createDbo();
    }
    
    public static function validarTipoVotacionesDisponibles(){
        $return = false;
        $db = Factory::createDbo();
        
        $query = " SELECT v.idtipocandidatodetalleplantillavotacion "
                . " FROM votacion v "
                . " WHERE  NOW() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion "
                . " AND v.codigoestado=100 ";
        $datos = $db->Execute($query);
        $d = $datos->GetArray();
        if(!empty($d)){
            foreach($d as $dato){
                $return[] = $dato["idtipocandidatodetalleplantillavotacion"];
            }
        }
        
        return $return;
    }
    
    public static function validarVotacionesDisponibles($idtipovotante){
        $return = false;
        $db = Factory::createDbo();
        $idtipocandidatodetalleplantillavotacion = self::getHomologacionUsuario($idtipovotante);
        $query = " SELECT idvotacion "
                . " FROM votacion v "
                . " WHERE  NOW() BETWEEN v.fechainiciovotacion AND v.fechafinalvotacion "
                . " AND v.codigoestado=100 "
                . " AND v.idtipocandidatodetalleplantillavotacion= ".$idtipocandidatodetalleplantillavotacion;
        $datos = $db->Execute($query);
        $d = $datos->FetchRow();
        if(!empty($d)){
            $return = $d["idvotacion"];
        }
        
        return $return;
    }
    
    public static function validarUsuarioExisteVotacion($numerodocumento, $idvotacion){
        $return = 0;
        $db = Factory::createDbo();
        
        $query = "SELECT COUNT(vv.numerodocumentovotantesvotacion) as votos  "
                . " FROM votacion v "
                . " INNER JOIN votantesvotacion vv ON ( v.idvotacion=vv.idvotacion) "
                . " WHERE v.codigoestado = '100' "
                . "     AND vv.codigoestado = '100' "
                . "     AND v.idvotacion = ". $idvotacion
                . "     AND vv.numerodocumentovotantesvotacion = ".$numerodocumento;
        $datos = $db->Execute($query);
        $d = $datos->FetchRow();
        
        if(!empty($d)){
            $return = $d["votos"];
        }
        
        return $return;
        
    }
    
    public static function getHomologacionUsuario($idtipovotante){
        $return = null;
        switch($idtipovotante){
            case 1:
                $return = 3;
                break;
            case 2:
            case 4:
            case 5:
                $return = 1;
                break;
            case 3:
            case 6:
                $return = 4;
                break;
        }
        return $return;
    }

}