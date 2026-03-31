<?
$pageName = "traducciones";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_popup.php";

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);


$traduccion = array (
	"Codigo_Pantalla" => $Codigo_Pantalla,
	"Codigo_Elemento" => $Codigo_Elemento,
	"Codigo_Idioma" => $Codigo_Idioma,
	"Texto" => $Texto,
	"traduccion_completa" => $traduccion_completa
);

if (empty($es_creacion)){
	$res = $servicesFacade->modificarTraduccion($traduccion);	
} else {
	$res = $servicesFacade->agregarTraduccion($traduccion);
}
if (is_a($res, "Celsius_Exception")) {
	$mensaje_error = $Mensajes["error.accesoBBDD"];
	$excepcion = $res;
	require "../common/mostrar_error.php";
}
//header (mostrar_traduccion.php);

?>
<div align="center">
	<?= $Mensajes["mensaje.traduccionGuardada"];?>
	<script language="JavaScript" type="text/javascript">
		setTimeout('self.close()',4000);
		window.opener.location.reload();
  	</script>
	<input type="button" onclick="self.close()" value="<?= $Mensajes["boton.cerrar"];?>"/>
</div>

<?require "../layouts/base_layout_popup.php";?>