<?php
/**
 * $IdCategoria   int
 */
$pageName= "categorias";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName, $IdiomaSitio);

require "../layouts/top_layout_admin.php";
$categoria= $servicesFacade->getCategoria($IdCategoria);
?>
<table width="70%" class="table-form" align="center" cellpadding="3" cellspacing="1">
	<tr>
		<td colspan="2" class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8" />
			<?=$Mensajes["titulo.categoria"];?>
		</td>
	</tr>
	<tr>
		<th><?=$Mensajes["tf-1"];?></th>
		<td><?=$categoria["Nombre"];?></td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td>
		 	<input type="button" onclick="location.href='modificarOAgregarCategoria.php?operacion=0';" value="<?=$Mensajes["h-1"]; ?>" />
		 	<input type="button" onclick="location.href='seleccionar_categoria.php';" value="<?=$Mensajes["h-2"]; ?>" />
        </td>
	</tr>	
</table>
<? require "../layouts/base_layout_admin.php";?>
