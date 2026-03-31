<?php
class modeloCarrera{
    public function mdlCarreraSnies(){
        $db=Factory::createDbo();
        $sql="SELECT cr.*,c.nombrecarrera 
              FROM carreraregistro cr
              INNER JOIN carrera c on (cr.codigocarrera = c.codigocarrera) 
              ORDER BY idcarreraregistro desc";
        $consulta = $db->Execute($sql);
        return $consulta;
    }
    public function mdlProgramasUB(){
        $db=Factory::createDbo();
        $sql="SELECT * FROM carrera ORDER BY nombrecortocarrera desc";
        $consulta = $db->Execute($sql);
        return $consulta;
    }
    public function mdlCarreraUnica($idCarrera){
        $db=Factory::createDbo();
        $sql="SELECT * FROM carrera WHERE codigocarrera=".$idCarrera;
        $consulta = $db->getRow($sql);
        return $consulta;
    }
    public function mdlInsertaCarreraRegistro($codigoSnies,$codigoCarrera,$fechaInicio,$fechaFin){
       $db=Factory::createDbo();
       $sql="INSERT INTO carreraregistro ( 
                             codigosniescarreraregistro,
                             numeroregistrocarreraregistro,
                             codigocarrera,
                             fechainiciocarreraregistro,
                             fechafinalcarreraregistro
                             )
                            VALUES ('".$codigoSnies."', 
                                    '".$codigoSnies."', 
                                    '".$codigoCarrera."', 
                                    '".$fechaInicio."',
                                    '".$fechaFin."');";

       if(is_object($db->Execute($sql)))
       {
           return true;
       }
       return false;
    }
    public function mdlVerificaCarreraSnies($codigoCarrera,$codigoSnies){
        $db=Factory::createDbo();
        $sql="SELECT * 
              FROM  carreraregistro 
              WHERE codigocarrera =".$codigoCarrera." OR codigosniescarreraregistro=".$codigoSnies;
        $consulta = $db->getRow($sql);
        return $consulta;
    }
    public function mdlUpdateCarreraRegistro($idSnies,$codigoSnies,$idCarrera,$fechaFincarreraSnies){
        $db=Factory::createDbo();
        $sql="UPDATE carreraregistro
                SET codigosniescarreraregistro    = '".$codigoSnies."',
                    numeroregistrocarreraregistro = '".$codigoSnies."',
                    codigocarrera                 = ".$idCarrera.",
                    fechafinalcarreraregistro     = '".$fechaFincarreraSnies."'
                WHERE idcarreraregistro = ".$idSnies;
        $db->Execute($sql);
        $filasAfectadas = $db->affected_rows();
        return $filasAfectadas;
    }

}