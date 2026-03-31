<?
/**
 * @param int $permite_revista
 * @param int $permite_libro
 * @param int $permite_tesis
 * @param int $permite_patente
 * @param int $permite_congreso
 * @param int $idPais
 * @param int $esCentralizado
 * @param string $Nombre
 * @param string $Abreviatura
 * 
 */
$pageName="paises";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);
global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

if (isset ($permite_revista) && $permite_revista == "ON")
	$permite_revista = 1; /*permite_revista se encuentra tildado*/
else
	$permite_revista = 0; /*por defecto no se permite revista*/

if (isset ($permite_libro) && $permite_libro == "ON")
	$permite_libro = 1;
else
	$permite_libro = 0;

if (isset ($permite_tesis) && $permite_tesis == "ON")
	$permite_tesis = 1;
else
	$permite_tesis = 0;

if (isset ($permite_patente) && $permite_patente == "ON")
	$permite_patente = 1;
else
	$permite_patente = 0;

if (isset ($permite_congreso) && $permite_congreso == "ON")
	$permite_congreso = 1;
else
	$permite_congreso = 0;

$pais = array (
			"permite_revista" => $permite_revista,
			"permite_libro" => $permite_libro,
			"permite_tesis" => $permite_tesis,
			"permite_patente" => $permite_patente,
			"permite_congreso" => $permite_congreso
		);
if (!empty($idPais)) {
	$pais["Id"] = $idPais;
	if ($esCentralizado == 0){
		$pais["Nombre"] = $Nombre;
		$pais["Abreviatura"] = $Abreviatura;
	}
	$res = $servicesFacade->modificarPais($pais);

} else {
	$pais["Nombre"] = $Nombre;
	$pais["Abreviatura"] = $Abreviatura;
	$res = $idPais =$servicesFacade->agregarPais($pais);
}
if (is_a($res, "Celsius_Exception")){
	$mensaje_error = $Mensajes["error.accesoBBDD"];
	$excepcion = $res;
	require "../common/mostrar_error.php";
}

if (empty($popup))
	header('Location:mostrarPais.php?idPais=' . $idPais);
else {
	require "../layouts/top_layout_popup.php";
	?>
	<div align="center">
		'<?=$Mensajes["mensaje.paisGuardado1"]." ".$Nombre." ".$Mensajes["mensaje.paisGuardado2"];?>'
		<script language="JavaScript" type="text/javascript">
			window.opener.location.reload();
			setTimeout('self.close()',4000);
	  	</script>
		<input type="button" onclick="self.close()" value="<?= $Mensajes["boton.cerrar"];?>"/>
	</div>
	<?
	require "../layouts/base_layout_popup.php";
}?>