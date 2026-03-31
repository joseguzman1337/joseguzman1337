<?
   $pageName= "catalogos";
   require_once "../common/includes.php";
   SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
   require "../layouts/top_layout_admin.php";
   global $IdiomaSitio;
   $Mensajes = Comienzo ($pageName,$IdiomaSitio);
   $catalogos = $servicesFacade->getCatalogos();
?>
<table width="70%" class="table-list" align="center" cellpadding="1" cellspacing="1">
	<tr>
		<td class="table-list-top" colspan="4">
			<img src="../images/square-w.gif" width="8" height="8"> 
			<?=$Mensajes["et-1"]; ?>
		</td>
	</tr>
	<tr>
  		<th><?=$Mensajes["ec-1"]; ?></th>
	   	<th><?="URL"; ?></th>
	   	<th>&nbsp;</th>
	</tr>
<?
 	foreach ($catalogos as $catalogo){?>
	<tr>
		<td  >
			<?=$catalogo['Nombre'];?>
		</td>
	    <td>
			<?= "<a href='' OnClick='javascript:window.open(\"".$catalogo['Link']."\")'>".$catalogo['Link']."</a>"; ?>
	    </td>
	    <td width="90px">
	    	<a href="agregarOModificarCatalogo.php?IdCatalogo=<?=$catalogo['Id']; ?>"><?=$Mensajes["h-4"]; ?></a>
	    </td>
	</tr>
	<?}?>
</table>
<? require "../layouts/base_layout_admin.php";?>