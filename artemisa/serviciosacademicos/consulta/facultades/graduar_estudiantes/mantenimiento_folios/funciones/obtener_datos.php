<?php
class folio
{
	var $conexion;
	
	function folio($conexion)
	{
		$this->conexion=$conexion;
	}
	
	function obtener_registrograduado()
	{
		$query_operacion=
		"
		SELECT rg.*
		FROM
		registrograduado rg
		";
		$operacion=$this->conexion->query($query_operacion);
		$row_operacion=$operacion->fetchRow();
		do
		{
			$array_interno[]=$row_operacion;
		}
		while($row_operacion=$operacion->fetchRow());
		return $array_interno;
	}
}
?>