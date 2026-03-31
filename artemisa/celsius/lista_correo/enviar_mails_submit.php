<?
/**
 * @param array(int) ListaUsuarios (con mail)
 * @param string $asunto_mail
 * @param string $texto_mail
 * @param string $id_plantilla
 * @param int $numero_pedidos?
 */

$pageName="listaCorreo";

require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

$ListaUsuarios = $_REQUEST["ListaUsuarios"];
?>
<script language="JavaScript" type="text/javascript">
	function ver_mail(id_mail){
		alert(id_mail);
		ventana=window.open("../mail/mostrar_mail.php?popup=true&id_mail="+id_mail, "Mail Enviado", "dependent=yes,toolbar=no,width=530 ,height=380, scrollbars=yes");
	}
</script>
  
<table width="80%" border="0" cellpadding="0" cellspacing="1" align="center" class="table-form">
	<tr>
		<td class="table-form-top-blue"><?= $Mensajes["tf-9"]; ?></td>
	</tr>
	
	<?
	$campos = array();
	if (!empty($numero_pedidos))
		$campos["numero_pedidos"]= $numero_pedidos;
	
	$usuarios = $servicesFacade->getObjectsIn("usuarios", $ListaUsuarios);
	foreach ($usuarios as $usuario_mail){
		$usuarioSesion = SessionHandler::getUsuario();
		$texto_i = $servicesFacade->reemplazar_variables_plantilla($texto_mail, $usuario_mail,$campos);
		$envio_mail = $servicesFacade->enviar_mail($usuario_mail["EMail"], $asunto_mail,$texto_i,$usuario_mail["Id"],0,$usuarioSesion["Id"]);
		if($envio_mail===false){
				$mensaje_error = "Error enviando email / Failed sending email";
				$excepcion = new Celsius_Exception($mensaje_error);
				require "../common/mostrar_error.php";
			}
		?>
		<tr>
			<td>
				<a href="javascript:ver_mail(<? echo $envio_mail; ?>)"><? echo $usuario_mail["Apellido"].", ". $usuario_mail["Nombres"]; ?></a>
			</td>
		</tr>
	<?}?>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td><b><?= $Mensajes["tf-10"]; ?><b></td>
	</tr>
</table>

<? require "../layouts/base_layout_admin.php"; ?>