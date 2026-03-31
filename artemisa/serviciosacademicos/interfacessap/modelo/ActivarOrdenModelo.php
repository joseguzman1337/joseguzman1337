<?php
class ActivarOrdenModelo
{
    public function mdlOrdenPago($numOrdens){
        $db=Factory::createDbo();
        $sql = "SELECT distinct o.numeroordenpago, o.codigoperiodo, o.codigoestadoordenpago, e.codigocarrera,o.idprematricula,o.codigoestudiante
                FROM ordenpago o, estudiante e
                WHERE o.numeroordenpago = '".$numOrdens."' 
                AND e.codigoestudiante = o.codigoestudiante";
        $validaorden =  $db->getAll($sql);
        return $validaorden;
    }
    public function mdlActivaOrden($numOrdens){
        $db=Factory::createDbo();
        $sql = "UPDATE ordenpago
                SET codigoestadoordenpago = '10'
                WHERE numeroordenpago = '".$numOrdens."'";
        $validaorden =  $db->Execute($sql);
        return $validaorden;
    }
    public function mdlActivaPrematricula($codigoEstudiante,$idPrematricula,$numeroOrdenPago){
        $db=Factory::createDbo();
        $sql = "UPDATE prematricula
                SET codigoestadoprematricula = '10'
                WHERE codigoestudiante=".$codigoEstudiante." AND idprematricula=".$idPrematricula;
        $validaorden =  $db->Execute($sql);

            $sql="UPDATE detalleprematricula
                  SET codigoestadodetalleprematricula = '10'
                  WHERE idprematricula= ".$idPrematricula." and numeroordenpago=".$numeroOrdenPago;
            $validaorden =  $db->Execute($sql);

        return $validaorden;
    }
    public function mdlConsultaUsuario($sessionUsuario){
        $db=Factory::createDbo();
        $sql = "SELECT idusuario
                 FROM usuario
                 WHERE usuario = '".$sessionUsuario."'";
        $validUsuario =  $db->getRow($sql);
        return $validUsuario;
    }

    public function mdlInsertLogOrdenPago($idUsuario,$numeroordenpago,$observacionActivacion)
    {
        $db = Factory::createDbo();
        $sql = "INSERT INTO logordenpago(idlogordenpago, fechalogordenpago, observacionlogordenpago, numeroordenpago, idusuario, ip)
                VALUES(0, now(), '" . $observacionActivacion . " -- RE-ACTIVADA', '$numeroordenpago', '$idUsuario', '" . tomarip() . "')";
        $validausuario = $db->Execute($sql);
        return $validausuario;
    }

    public function mdlOrdenInscripcionFormula($numeroOrdenPago){
        $db = Factory::createDbo();
        $sql = "SELECT distinct numeroordenpago
                           FROM detalleordenpago d,concepto c
                           WHERE(c.cuentaoperacionprincipal = 152 or c.cuentaoperacionprincipal = 153)
                            and d.codigoconcepto = c.codigoconcepto
                            and numeroordenpago in($numeroOrdenPago)";
        $validUsuario =  $db->getAll($sql);
        return $validUsuario;
    }
    public function mdlOrdenMatricula($numeroOrdenPago){
        $db = Factory::createDbo();
        $sql = "SELECT numeroordenpago 
                FROM detalleordenpago
                WHERE codigoconcepto = 151 AND numeroordenpago=".$numeroOrdenPago;
        $validUsuario =  $db->getAll($sql);
        return $validUsuario;
    }




}