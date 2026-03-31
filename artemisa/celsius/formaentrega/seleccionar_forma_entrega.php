<?
$pageName = "formas_entrega";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);
?>
<table width="70%" class="table-list" align="center" cellpadding="1" cellspacing="1">
	<tr>
		<td class="table-list-top" colspan="4">
			<img src="../images/square-w.gif" width="8" height="8" /> 
			<?=$Mensajes["titulo.formasDeEntrega"];?>
		</td>
	</tr>
	<tr>
  		<th><?= $Mensajes["campo.nombreFormaEntrega"];?></th>
	   	<th>&nbsp;</th>
	</tr>
	<?
	$formasdeentrega = $servicesFacade->getFormasDeEntrega();
	foreach ($formasdeentrega as $formadeentrega) { ?>
	<tr>
		<td><?=$formadeentrega["nombre"]; ?></td>						
		<td>
			<a href="agregarOModificarForma_Entrega.php?id_forma_entrega=<?echo $formadeentrega["id"]; ?>"><?= $Mensajes["boton.modificar"]; ?></a>
		</td>
	</tr>
	<?}?>
</table>
<? require "../layouts/base_layout_admin.php";?>