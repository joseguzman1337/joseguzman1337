<?
/**
 * @param int id_mail
 */
$pageName = "mails";
require "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);

if ($popup)
	require "../layouts/top_layout_popup.php";
else
	require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

$mail = $servicesFacade->getMail($id_mail);

$popup = (!empty($popup));

?>
  
<table class="table-form" width="90%">
	<tr>
		<td colspan="2" class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8">
		</td>
	</tr>

	<tr>
		<th><?=$Mensajes["campo.destinatario"];?></th>
		<td><?=$mail['Apellido_Usuario'].", ".$mail['Nombre_Usuario']?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-1"];?></th>
		<td><?=$mail['Direccion']?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-2"];?></th>
		<td><?=$mail['Asunto']?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-3"];?></th>
		<td><?=$mail['Fecha']?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-4"];?></th>
		<td><?=$mail['Hora']?></td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td><textarea name="textarea" rows="6" style="width:99%"><?=$mail['Texto'];?></textarea></td>
	</tr>
</table>
<br/>

<? if ($popup){?>
	<input type="button" name="name" value="<?=$Mensajes["boton.cerrar"];?>" onclick="self.close();"/>
<? } 

if ($popup)
	require "../layouts/base_layout_popup.php";
else
	require "../layouts/base_layout_admin.php";
?>