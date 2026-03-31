<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
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
		$query="SELECT dpe.idtipodetallepazysalvoegresado, tdpe.nombretipodetallepazysalvoegresado as validacion,dpe.ubicacionpaginadetallepazysalvoegresado as orden_ubicacion_carta,dpe.textodetallepazysalvoegresado as texto,
		tdpe.codigotiporegistro
		FROM
		pazysalvoegresado pe, detallepazysalvoegresado dpe, tipodetallepazysalvoegresado tdpe
		WHERE
		pe.idpazysalvoegresado=dpe.idpazysalvoegresado
		AND dpe.codigoestado=100
		AND NOW() BETWEEN pe.fechadesdepazysalvoegresado AND pe.fechahastapazysalvoegresado
		AND pe.codigocarrera='$this->codigocarrera'
		AND dpe.idtipodetallepazysalvoegresado=tdpe.idtipodetallepazysalvoegresado
		ORDER BY dpe.ubicacionpaginadetallepazysalvoegresado
		";
		echo $query;
	}
}

$validaciones=new validaciones_requeridas($sala,10);
$validaciones->carga_datos_a_validar();
?>

