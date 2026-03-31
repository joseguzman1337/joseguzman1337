<?php

class modeloCarnetizacionGeneral
{
    public function mdlAdministrativoDocenteDocumento($documento){
        $db=Factory::createDbo();
        $sql=" SELECT concat(nombresadministrativosdocentes, ' ', apellidosadministrativosdocentes)
                           as nombre,
                       fechaterminancioncontratoadministrativosdocentes,
                       telefonoadministrativosdocentes,
                       emailadministrativosdocentes,
                       celularadministrativosdocentes,
                       codigogenero,
                       idtipogruposanguineo,
                       numerodocumento,
                       tipodocumento
                FROM administrativosdocentes
                where numerodocumento = '$documento'
                  and codigoestado = '100'";
        $consulta = $db->getAll($sql);
        return $consulta;
    }
    public function mdlAdministrativoDocenteTarjeta($tajeta){
        $db=Factory::createDbo();
        $sql="SELECT concat(a.nombresadministrativosdocentes, ' ', a.apellidosadministrativosdocentes) as nombre,
                   numerodocumento,
                   tr.codigotarjetainteligenteadmindocen
              FROM administrativosdocentes a,
                 tarjetainteligenteadmindocen tr
              WHERE tr.idadministrativosdocentes = a.idadministrativosdocentes
              AND  codigotarjetainteligenteadmindocen = '".$tajeta."'";
        $consulta = $db->getAll($sql);
        return $consulta;
    }
}