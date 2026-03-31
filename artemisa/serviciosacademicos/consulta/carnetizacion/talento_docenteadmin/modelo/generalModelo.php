<?php
class generalModelo
{
    public function mdlTipoUsuario(){
        $db=Factory::createDbo();
        $sql="SELECT * 
              FROM tipousuarioadmdocen 
              WHERE codigoestado like '1%'";
        $consulta = $db->getAll($sql);
        return $consulta;
    }
    public function mdlInsertUsuario($arrayData){
        $db=Factory::createDbo();
        $query_insert = "INSERT INTO administrativosdocentes
				(
				nombresadministrativosdocentes,
				apellidosadministrativosdocentes,
				tipodocumento,
				numerodocumento,
				expedidodocumento,
				idtipogruposanguineo,
				codigogenero,
				celularadministrativosdocentes,
				emailadministrativosdocentes,
				direccionadministrativosdocentes,
				telefonoadministrativosdocentes,
				fechaterminancioncontratoadministrativosdocentes,
				cargoadministrativosdocentes,
				codigoestado,
				idtipousuarioadmdocen)
				VALUES
			   ('".$arrayData["nombres"]."',
				'".$arrayData["apellidos"]."',
				'".$arrayData["tipodocumento"]."',
				'".$arrayData["numerodocumento"]."',
				'".$arrayData["expedidodocumento"]."',
				'".$arrayData["tipogruposanguineo"]."',
				'".$arrayData["genero"]."',
				'".$arrayData["celular"]."',
				'".$arrayData["email"]."',
				'".$arrayData["direccion"]."',
				'".$arrayData["telefono"]."',
				'".$arrayData["fechavigencia"]."',
				'".$arrayData["cargo"]."',
				'100',
				'".$arrayData["tipousuarioadmdocen"]."'
				); ";
        $consulta = $db->Execute($query_insert);
        $recordCount  =  $consulta->recordCount();
        return $recordCount;
    }
    public function mdlActualizaUsuarioAdmnistrativoDocente($datosArray){
        $db=Factory::createDbo();
        $sql="UPDATE administrativosdocentes  SET
                     idtipousuarioadmdocen ='".$datosArray["tipousuarioadmdocen"]."',
                     cargoadministrativosdocentes ='".$datosArray["cargo"]."',
                     fechaterminancioncontratoadministrativosdocentes ='".$datosArray["fechavigencia"]."',
                     telefonoadministrativosdocentes ='".$datosArray["telefono"]."',
                     direccionadministrativosdocentes ='".$datosArray["direccion"]."',
                     emailadministrativosdocentes ='".$datosArray["email"]."',
                     celularadministrativosdocentes ='".$datosArray["celular"]."',
                     codigogenero ='".$datosArray["genero"]."',
                     idtipogruposanguineo ='".$datosArray["tipogruposanguineo"]."',
                     expedidodocumento ='".$datosArray["expedidodocumento"]."',
                     numerodocumento ='".$datosArray["numerodocumento"]."',
                     tipodocumento ='".$datosArray["tipodocumento"]."',
                     apellidosadministrativosdocentes ='".$datosArray["apellidos"]."',
                     nombresadministrativosdocentes ='".$datosArray["nombres"]."'  ,
                    fechaterminancioncontratoadministrativosdocentes = '".$datosArray["fechavigencia"]."'
            WHERE idadministrativosdocentes= '".$datosArray["idadministrativosdocentes"]."'";
        $db->Execute($sql);
        $filaAfectada =  $db->affected_rows();
        return $filaAfectada;
    }
    public function mdlTipoDocumento(){
        $db=Factory::createDbo();
        $sql= "SELECT * 
               FROM documento  
               WHERE tipodocumento not in (07, 08, 09, 10)";
        $consulta = $db->getAll($sql);
        return $consulta;
    }
    public function mdlGrupoSanguineo(){
        $db=Factory::createDbo();
        $sql= "SELECT *
               FROM tipogruposanguineo 
               WHERE codigoestado = '100'";
        $consulta = $db->getAll($sql);
        return $consulta;
    }
    public function mdlGeneroUsuario(){
        $db=Factory::createDbo();
        $sql= "SELECT codigogenero, nombregenero 
               FROM genero ";
        $consulta = $db->getAll($sql);
        return $consulta;
    }
    public function mdlConsultaUsuarioAdministrativoDocente($numerodocumento,$tipodocumento){
        $db=Factory::createDbo();
         $sql="SELECT  * 
              FROM administrativosdocentes
              WHERE numerodocumento = '".$numerodocumento."' 
                    and tipodocumento = '".$tipodocumento."' ";
        $consulta = $db->getAll($sql);
        return $consulta;
    }
    public function mdlConsultaUsuarios($complementoConsulta,$tipoUsuario){
        $db=Factory::createDbo();
        $sql = "SELECT idadministrativosdocentes, concat(nombresadministrativosdocentes,' ',apellidosadministrativosdocentes)
                    as nombre,date_format(fechaterminancioncontratoadministrativosdocentes, '%d-%m-%Y')as fechavencimiento,telefonoadministrativosdocentes,
                    emailadministrativosdocentes,celularadministrativosdocentes,codigogenero,idtipogruposanguineo,
                    numerodocumento,tipodocumento
                FROM administrativosdocentes
                WHERE idtipousuarioadmdocen='".$tipoUsuario."'
                    and codigoestado='100'
                    $complementoConsulta
                    order by nombresadministrativosdocentes";
        $consulta = $db->getAll($sql);
        return $consulta;
    }
    public function mdlConsultaUsuarioId($id){
        $db=Factory::createDbo();
        $sql = "SELECT *
                                FROM administrativosdocentes da
                                left JOIN tipogruposanguineo t ON da.idtipogruposanguineo = t.idtipogruposanguineo
                                INNER JOIN genero g ON da.codigogenero = g.codigogenero
                                INNER JOIN estado e ON da.codigoestado = e.codigoestado
                                INNER JOIN documento d ON da.tipodocumento = d.tipodocumento
                                INNER JOIN tipousuarioadmdocen td ON da.idtipousuarioadmdocen = td.idtipousuarioadmdocen
                                WHERE da.idadministrativosdocentes= '".$id."';
                                ";
        $consulta = $db->getAll($sql);
        return $consulta;
    }
}