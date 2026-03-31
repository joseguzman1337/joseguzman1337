<?php
class validaciones_requeridas
{

	function validaciones_requeridas($conexion,$codigocarrera)
	{
		$this->conexion=$conexion;
		$this->codigocarrera=$codigocarrera;
		$this->codigoestudiante=$codigoestudiante;
	}

	function carga_datos_a_validar()
	{
		$query="SELECT idtipodetallepazysalvoegresado
		FROM
		pazysalvoegresado pe, detallepazysalvoegresado dpe
		WHERE
		pe.idpazysalvoegresado=dpe.idpazysalvoegresado
		AND pe.codigocarrera='$this->codigocarrera'
		";
		echo $query;
	}
}

$validaciones=new validaciones_requeridas($sala,10);
$validaciones->carga_datos_a_validar();
?>

