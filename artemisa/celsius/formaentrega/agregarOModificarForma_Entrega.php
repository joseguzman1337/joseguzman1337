<?
$pageName ="formas_entrega";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

if (!empty($id_forma_entrega))
	$formaDeEntrega= $servicesFacade->getFormaDeEntrega($id_forma_entrega);
else{
	$id_forma_entrega =0;
	$formaDeEntrega = array("nombre" => "", "recibo" => 0, "descripcion" => "");
}
?>
<script language="JavaScript" type="text/javascript">
	function validar_forma_entrega(){
		var nombre = document.getElementsByName("nombre").item(0);
		if (nombre.value == ""){
			alert ("<?= $Mensajes["warning.faltanDatos"];?>");
			nombre.focus();
			return false;
		}
		return true;
	}
</script>
  
<form method="POST" action="guardar_forma_entrega.php" onsubmit="return validar_forma_entrega();">
	<input type="hidden" name="id_forma_entrega" value="<?=$id_forma_entrega?>" />

<table class="table-form" width="70%" align="center" cellpadding="1" cellspacing="1">
	<tr>
		<td colspan="2" class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8"><?= $Mensajes["titulo.formasDeEntrega"];?>
		</td>
	</tr>
	<tr>
    	<th><?= $Mensajes["campo.nombreFormaEntrega"];?></th>
        <td><input type="text" name="nombre" value="<?= $formaDeEntrega["nombre"] ?>" size="40" ></td>
	</tr>
	<tr>
    	<th><?= $Mensajes["campo.permiteRecibo"];?></th>
        <td><input type="checkbox" name="recibo" <? if ($formaDeEntrega["recibo"]==1) echo 'checked'?> value="ON" /></td>
	</tr>
	<tr>
    	<th><?= $Mensajes["campo.descripcion"];?></th>
        <td><textarea name="descripcion" rows="3" cols="37"><?= $formaDeEntrega["descripcion"]; ?></textarea></td>
	</tr>
	<tr>
    	<th>&nbsp;</th>
        <td>
        	<input type="submit" name="submit" value="<? if (empty($id_forma_entrega))  echo $Mensajes["boton.agregar"];  else  echo $Mensajes["boton.modificar"]; ?>"  />
        	<input type="reset" name="reset" value="<?= $Mensajes["boton.limpiar"]?>"  />
		</td>
	</tr>

</table>
</form>

<? require "../layouts/base_layout_admin.php";?> 