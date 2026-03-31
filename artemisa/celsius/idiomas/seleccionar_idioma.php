<?
$pageName = "idiomas";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

$idiomas = $servicesFacade->getIdiomas();
?>
<table width="70%" class="table-list" align="center" cellpadding="1" cellspacing="1">
	<tr>
		<td class="table-list-top" colspan="4">
			<img src="../images/square-w.gif" width="8" height="8" /> 
			<?= $Mensajes["et-1"]; ?>
		</td>
	</tr>
<?foreach ($idiomas as $idioma) { ?>
	<tr>
		<th><?= $idioma["Nombre"];?></th>
		<td><? if ($idioma["Predeterminado"]==1) { echo "<img border='0' src='../images/marca.gif' width='30' height='31'>";} ?></td>
		<td><a href="agregarOModificarIdioma.php?Id=<?= $idioma["Id"];?>"><?= $Mensajes["ec-1"];?></a></td>
	</tr>					       
<?}?>
</table>
<?require "../layouts/base_layout_admin.php";?>