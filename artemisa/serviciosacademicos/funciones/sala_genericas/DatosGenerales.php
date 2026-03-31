<?php
function LeerCarreraPeriodoSubperiodoActivoRecibePeriodo(&$conexion,$codigocarrera,$codigoperiodo,$codigoestadosubperiodo)
{
	$query="SELECT sp.idsubperiodo
		FROM subperiodo sp, carreraperiodo cp
		WHERE
		cp.codigoperiodo='".$codigoperiodo."'
		AND sp.codigoestadosubperiodo like '1%'
		AND sp.idcarreraperiodo=cp.idcarreraperiodo
		AND cp.codigocarrera='".$codigocarrera."'
		";
	$operacion=$conexion->query($query);
	$row_operacion=$operacion->fetchRow();
	return $row_operacion;

}

function LeerCarreraPeriodoSubperiodoCodigoestadoperiodo(&$conexion,$codigocarrera,$codigoestadoperiodo)
{
	$query="SELECT cp.codigocarrera,p.codigoperiodo,cp.idcarreraperiodo,sp.idsubperiodo
		FROM periodo p, carreraperiodo cp, subperiodo sp
		WHERE
		p.codigoestadoperiodo='$codigoestadoperiodo'
		AND p.codigoperiodo=cp.codigoperiodo
		AND cp.codigocarrera='$codigocarrera'
		AND cp.idcarreraperiodo=sp.idcarreraperiodo
		AND sp.codigoestadosubperiodo=100
		";
	$operacion=$conexion->query($query);
	$row_operacion=$operacion->fetchRow();
	return $row_operacion;
}



function LeerCarreras(&$conexion,$codigomodalidadacademica="",$codigocarrera="")
{
	if($codigomodalidadacademica=="todos" and $codigocarrera=="todos")
	{
		$query_obtener_carreras="SELECT c.codigocarrera,c.nombrecarrera,c.codigomodalidadacademica
			FROM
			carrera c
			WHERE
			c.fechainiciocarrera <= '".$this->fechahoy."' and c.fechavencimientocarrera >= '".$this->fechahoy."'
			ORDER BY c.codigocarrera
			";
	}
	elseif($codigomodalidadacademica=="todos" and $codigocarrera<>"todos")
	{
		$query_obtener_carreras="SELECT c.codigocarrera,c.nombrecarrera,c.codigomodalidadacademica
			FROM
			carrera c
			WHERE
			c.codigocarrera='".$codigocarrera."'
			AND c.fechainiciocarrera <= '".$this->fechahoy."' and c.fechavencimientocarrera >= '".$this->fechahoy."'
			ORDER BY c.codigocarrera
			";
	}
	elseif($codigomodalidadacademica<>"todos" and $codigocarrera=="todos")
	{
		$query_obtener_carreras="SELECT c.codigocarrera,c.nombrecarrera,c.codigomodalidadacademica
			FROM
			carrera c
			WHERE
			c.codigomodalidadacademica='$codigomodalidadacademica'
			AND c.fechainiciocarrera <= '".$this->fechahoy."' and c.fechavencimientocarrera >= '".$this->fechahoy."'
			ORDER BY c.codigocarrera
			";
	}
	elseif($codigomodalidadacademica<>"todos" and $codigocarrera<>"todos")
	{
		$query_obtener_carreras="SELECT c.codigocarrera,c.nombrecarrera,c.codigomodalidadacademica
			FROM
			carrera c
			WHERE
			c.codigocarrera='$codigocarrera'
			AND c.fechainiciocarrera <= '".$this->fechahoy."' and c.fechavencimientocarrera >= '".$this->fechahoy."'
			ORDER BY c.codigocarrera
			";
	}

	$obtener_carreras=$conexion->query($query_obtener_carreras);
	$row_obtener_carreras=$obtener_carreras->fetchRow();
	do
	{
		$array_obtener_carreras[]=$row_obtener_carreras;
	}
	while($row_obtener_carreras=$obtener_carreras->fetchRow());
	return $array_obtener_carreras;
}
function LeerUniversidad($iduniversidad,$conexionadodb)
{
	$queryuniversidad="select * from universidad where iduniversidad=$iduniversidad";
	$array_obtener_universidad=$conexionadodb->query($queryuniversidad);
	return $array_obtener_universidad;
}
function ListaUsuarioFacultad($idusuario,$usuario,$objetobase,$imprimir=0)
{
	$operacion=$objetobase->recuperar_resultado_tabla("usuariofacultad","usuario",$usuario,"",'',$imprimir);
	while($row = $operacion->fetchRow())
	{
		$codigosfacultad[]=$row["codigofacultad"];
	}
	return $codigosfacultad;
}
function ListaFacultades($objetobase,$imprimir=0)
{
	$operacion=$objetobase->recuperar_resultado_tabla("carrera","codigocarrera","codigocarrera","",'',$imprimir);
	while($row = $operacion->fetchRow())
	{
		$codigosfacultad[]=$row["codigocarrera"];
	}
	return $codigosfacultad;
}


?>