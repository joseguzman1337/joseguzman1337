<?php


class DiplomaModelo
{
    public function mdlDiplomasActivos($idDiploma=0){
        if ($idDiploma==0){ $parametro = ""; }else{ $parametro = 'WHERE iddiploma='.$idDiploma; }
        $db = Factory::createDbo();
        $sql = "SELECT * FROM diploma {$parametro} AND codigoestado=100";
        $consulta = $db->getAll($sql);
        return $consulta;
    }
    public function mdlFirmasDiplomaActivas($idDiploma=0){
        $db = Factory::createDbo();
        $sql = "SELECT * FROM firmadiploma WHERE iddiploma={$idDiploma} and codigoEstado=100";
        $consulta = $db->getAll($sql);
        return $consulta;
    }
}