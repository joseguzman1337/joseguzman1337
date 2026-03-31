<?
$pageName= "catalogos";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

if (!empty($IdCatalogo)) {
	$catalogo = $servicesFacade->getCatalogo($IdCatalogo);
}else {
	$IdCatalogo = 0;
}

?>
<script language="JavaScript" type="text/javascript">
  function validar_form(){
  	if (document.getElementsByName('Nombre').item(0).value==''){
  		alert('<?=$Mensajes["warning.faltaNombreCatalogo"];?>');
		return false;
  	}
  	if (document.getElementsByName('Link').item(0).value==''){
  		alert('<?=$Mensajes["warning.faltaLinkCatalogo"];?>');
		return false;
  	}
  	return true;
  }
</script>
<form method="POST" action="actualizar_catalogo.php" onsubmit="return validar_form();">
		<input type="hidden" name="IdCatalogo" value="<?=$IdCatalogo?>" />

<table class="table-form" width="70%" align="center" cellpadding="1" cellspacing="1">
	<tr>
		<td colspan="2" class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8"><?= $Mensajes["et-1"]; ?>
		</td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-1"]; ?></th>
		<td><input type="text" name="Nombre" size="41" value="<? if (isset($catalogo)) echo $catalogo["Nombre"]; ?>" size="37" ></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-2"];?></th>
		<td><input type="text" name="Link"  size="41" value="<? if (isset($catalogo))echo $catalogo["Link"]; ?>" size="30"></td>
	</tr>

	<tr>
		<th><?= $Mensajes["campo.observaciones"]; ?></th>
		<td><TEXTAREA  NAME="observaciones" ROWS="4" COLS="38"><? if (isset($catalogo))echo $catalogo["observaciones"]; ?></TEXTAREA></td>
	</tr>
	<tr>
		<th><?= $Mensajes["campo.nroDeOrden"]; ?></th>
		<td><input type="text" name="numero"  size="41" value="<? if (isset($catalogo))echo $catalogo["numero"]; ?>" size="30"></td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td>
			<input type="submit"  value="<? if (empty($IdCatalogo)) { echo $Mensajes["botc-1"]; } else { echo $Mensajes["botc-2"]; } ?>" name="B1" />
			<input type="reset" value="<?= $Mensajes["bot-2"]; ?>" name="B1" />
		</td>
	</tr>
</table>
</form>

<? require "../layouts/base_layout_admin.php";?> 