<?
/**
 * $CodElemento   int
 * $CodPantalla   int
 */
$pageName= "elementos2";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
	
global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

require "../layouts/top_layout_admin.php";

$elemento = $servicesFacade->getElemento($CodPantalla, $CodElemento);
?>
<table width="70%" class="table-form" align="center" cellpadding="3" cellspacing="1">
	<tr>
		<td colspan="2" class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8"> 
			<?= $Mensajes["titulo.elemento"];?>
		</td>
	</tr>					
	<tr>
		<th><?= $Mensajes["ec-1"]; ?></td>
		<td><?= $elemento["Codigo_Pantalla"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-2"]; ?></td>
		<td><?= $elemento["Codigo_Elemento"]; ?></td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td align="right !important"> 
			<input type="button" onclick="location.href='agregarOModificarElemento.php';" value="<?=$Mensajes["ec-4"];?>" />
			<input type="button" onclick="location.href='seleccionar_elemento.php';" value="<?=$Mensajes["ec-5"];?>" />
		</td>
	</tr>
</table>
<? require "../layouts/base_layout_admin.php";?>