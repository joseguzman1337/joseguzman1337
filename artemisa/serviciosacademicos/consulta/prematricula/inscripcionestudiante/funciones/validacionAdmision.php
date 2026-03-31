<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
	function validarIdAdmision($codigocarrera,$idsubperiodo,&$conexion)
	{
		$query_idadmision="SELECT a.* FROM
		admision a WHERE
		a.codigocarrera='$codigocarrera'
		AND a.idsubperiodo='$idsubperiodo'
		AND a.codigoestado='100'";
		$operacion_idadmision=$conexion->query($query_idadmision);
		$row_idadmision=$operacion_idadmision->fetchRow();
		$idadmision=$row_idadmision['idadmision'];
		$array_admision=$row_idadmision;
		if(empty($idadmision)){
			return 0;
		}
		$query="SELECT p.* FROM periodo p WHERE p.codigoestadoperiodo='4'";
		$array_periodo=$conexion->query($query);
		$row_periodo=$array_periodo->fetchRow();
		if(!is_array($row_periodo)){
			return 0;
		}
		return 1;

}
?>