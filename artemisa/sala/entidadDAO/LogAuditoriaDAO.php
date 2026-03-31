<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sala\entidadDAO;

/**
 * Description of LogAuditoria
 *
 * @author arizaandres
 */
require_once(PATH_SITE."/lib/AdministracionPeriodos/api/clases/utiles/ValidacionesComunes.php");
class LogAuditoriaDAO implements  \Sala\interfaces\EntidadDAO {
    public function logAuditoria( $e, $query) {
        self::setLogAuditoria($e, $query);
    }

    public function save() {}

    public function setDb() {}
    
    public static function setLogAuditoria( $e, $query, $usuario){
        $db = \Factory::createDbo();
        $accion = "INSERT";
        $type = gettype($e);
        if($type==="object"){
            $tabla = get_class($e);
        }else{
            $tabla = $e;
        }
        
        $idUsuario = \Factory::getSessionVar("idusuario");
        if(!empty($idUsuario)&&($idUsuario!=$usuario)){
            $usuario .= ".idUsuario:".$idUsuario;
        }
        
        $posInsert = strpos(mb_strtoupper($query, "UTF-8"), "INSERT");
        if ($posInsert === false) {
            $accion = "UPDATE";
        }
        $ip = \Sala\utiles\GetIp\GetRealIp::getRealIP();
        
        $queryInsert = "INSERT INTO logAuditoria SET "
                . " accion = ".$db->qstr($accion).", "
                . " tabla = ".$db->qstr($tabla).", "
                . " usuario = ".$db->qstr($usuario).", "
                . " query = ".$db->qstr($query).", "
                . " ip = ".$db->qstr($ip).", "
                . " fecha = NOW() ";
        $db->Execute($queryInsert); 
    }
}
