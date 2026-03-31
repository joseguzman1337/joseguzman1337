<?php
class modeloResetClave{
    public function mdlCnsusuario($nombreUsuario,$condicion){
        $db=Factory::createDbo();
         $sql=" SELECT max(c.idclaveusuario) maxidclaveusuario, 
                      u.idusuario,
                      u.usuario,
                      ua.emailadministrativosdocentes,
                      ua.EmailInstitucional,
                      ua.idadministrativosdocentes,
                      u.numerodocumento,
                      u.nombres,
                      u.apellidos
                FROM claveusuario c,
                     usuario u,
                     administrativosdocentes ua
                WHERE u.idusuario = c.idusuario AND
                      u.numerodocumento = ua.numerodocumento AND
                      u.usuario = '".$nombreUsuario."' AND
                      u.codigoestadousuario = 100 AND 
                       ".$condicion."
                group by u.idusuario,u.usuario,
                         ua.emailadministrativosdocentes,
                         ua.EmailInstitucional,
                         u.numerodocumento,
                         u.nombres,
                         u.apellidos;";
        $consulta = $db->getRow($sql);
        return $consulta;
    }
    public function mdlUpdateClaveusuario($idClaveUsuario,$idUsuario,$parametros){
        $db=Factory::createDbo();
        $sql="UPDATE claveusuario
            SET ".$parametros."              
            WHERE idclaveusuario='".$idClaveUsuario."' and idusuario=".$idUsuario;
        $db->Execute($sql);
        $filaAfectada =  $db->affected_rows();
        return $filaAfectada;
    }

    public function mdlResetIntentosAccesoUsuario($idUsuario){
        $db=Factory::createDbo();
        $sql="UPDATE logintentosaccesousuario
                SET  contadorlogintentosaccesousuario = 0
                WHERE idusuario = ".$idUsuario;
        $db->Execute($sql);
        $filaAfectada =  $db->affected_rows();
        return $filaAfectada;
    }
    public function mdlInsertClaveusuario($idUsuario,$claveTemporal){
        $db=Factory::createDbo();
        $sql="INSERT INTO claveusuario (idusuario,
                          fechaclaveusuario,
                          fechainicioclaveusuario,
                          fechavenceclaveusuario,
                          claveusuario,
                          codigoestado,
                          codigoindicadorclaveusuario,
                          codigotipoclaveusuario)
            VALUES ('".$idUsuario."', now(), now(), '2099-12-31','".$claveTemporal."', '100', '100', 2);";
        $consulta = $db->Execute($sql);
        $recordCount  =  $consulta->recordCount();
        return $recordCount;
    }
    public function mdlActualizaCorreo($idAdministrativoDocente,$condicion){
        $db=Factory::createDbo();
        $sql="UPDATE administrativosdocentes
                SET  ".$condicion." 
                WHERE idadministrativosdocentes = ".$idAdministrativoDocente;
        $db->Execute($sql);
        $filaAfectada =  $db->affected_rows();
        return $filaAfectada;
    }

}