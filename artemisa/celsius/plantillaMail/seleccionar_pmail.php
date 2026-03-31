<?
$pageName = "mail.plantilla";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);
?>

<table width="70%" class="table-list" align="center" cellpadding="1" cellspacing="1">
	<tr>
		<td class="table-list-top" colspan="4">
			<img src="../images/square-w.gif" width="8" height="8" /> 
			<?=$Mensajes["et-1"];?>
		</td>
	</tr>
	<?
	$plantillas=$servicesFacade->getPlantillas();
	foreach ($plantillas as $plantilla){?>
		<tr>
			<td><?=$plantilla['Denominacion'];?></td>
			<td>
				<a href="agregarOModificarPMail.php?id_plantilla=<?= $plantilla['Id']; ?>">
					<?=$Mensajes["h-2"]; ?>
				</a> | 
				<a href="mostrar_plantilla.php?id_plantilla=<?= $plantilla['Id']; ?>">
					<?=$Mensajes["boton.mostrar_plantilla"]; ?> 
				</a>
			</td>
		</tr>
	<?}?>
</table>

<? require "../layouts/base_layout_admin.php";?>