<?
/**
 * $id_forma_entrega   int
 */
$pageName = "formas_entrega";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
  
global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

require "../layouts/top_layout_admin.php";
$formaDeEntrega= $servicesFacade->getFormaDeEntrega($id_forma_entrega);
?>
<table width="70%" class="table-form" align="center" cellpadding="3" cellspacing="1">	
	<tr>
		<td colspan="2" class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8" />
			<?=$Mensajes["titulo.formasDeEntrega"];?>
		</td>
	</tr>
	<tr>
		<th><?= $Mensajes["campo.nombreFormaEntrega"];?></th>
		<td><?= $formaDeEntrega["nombre"];?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["campo.permiteRecibo"];?></th>
		<td><? if ($formaDeEntrega["recibo"] == 1) echo $Mensajes["mensaje.afirmacion"]; else echo $Mensajes["mensaje.negacion"];?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["campo.descripcion"];?></th>
		<td><?= $formaDeEntrega["descripcion"];?></td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td>
			<input type="button" onclick="location.href='agregarOModificarForma_Entrega.php'" value="<?=$Mensajes["boton.agregar"];?>" />
		 	<input type="button" onclick="location.href='seleccionar_forma_entrega.php';" value="<?=$Mensajes["link.listadoFormasEntrega"];?>" />
		</td>
	</tr>
</table>
<? require "../layouts/base_layout_admin.php";?> 