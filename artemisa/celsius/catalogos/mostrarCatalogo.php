<?
/**
 * $IdCatalogo   int
 */
$pageName= "catalogos";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

require "../layouts/top_layout_admin.php";
$catalogo= $servicesFacade->getCatalogo($IdCatalogo);
?>

<table class="table-form" width="70%" align="center" cellspacing="1" cellpadding="3">
	<tr>
		<td colspan="2" class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8"> 
			<?= $Mensajes["titulo.mostrarTitulo"];  ?>
		</td>
	</tr>	
	<tr>
		<th><?= $Mensajes["ec-1"]; ?></th>
		<td><?= $catalogo["Nombre"];?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-2"]; ?></th>
		<td><?= $catalogo["Link"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["campo.observaciones"]; ?></th>
		<td><?= $catalogo["observaciones"]; ?></td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td align="right !important">  
			<input type="button" name="bModificar" value="<?= $Mensajes["h-1"]; ?>" onclick="location.href='agregarOModificarCatalogo.php'" />
        	<input type="button" name="bListar" value="<?= $Mensajes["h-2"]; ?>" onclick="location.href='seleccionar_catalogo.php'" />
		</td>
	</tr>
	</table>
<? require "../layouts/base_layout_admin.php";?>