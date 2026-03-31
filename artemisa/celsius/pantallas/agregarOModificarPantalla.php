<?
/*
 * $id_pantalla? int
 * 
 * */

$pageName = "pantallas";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

if (!empty($id_pantalla))
	$pantalla = $servicesFacade->getPantalla($id_pantalla);
else{
	$id_pantalla="";
	$pantalla="";
}
 	
	
?>
<script language="JavaScript" type="text/javascript">
	function validar_pantalla(){
		if (document.getElementById('Id').value==""){
			alert("<?=$Mensajes["error.campo_id_incompleto"]?>");
			return false;
		}
		return true;
	}
</script>

<form method="get" action="pantallas_controller.php" onsubmit="return validar_pantalla();" >
	<input type="hidden" name="id_pantalla" value="<?=$id_pantalla;?>" />
<table width="40%" align="center" class="table-form" cellpadding="1" cellspacing="1">
	<tr>
    	<td colspan="2" class="table-form-top-blue">
    		<img src="../images/square-w.gif" width="8" height="8" />
    		<?=$Mensajes["tit-1"];?>
        </td>
    </tr>	
	<tr>
		<th><?= $Mensajes["ec-1"]?></th>
		<td><input type="text"  id="Id" name="Id" size="41" value="<? if(!empty($pantalla["Id"])) echo $pantalla["Id"];?>"/></td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td>
			<input type="submit"  value="<? if (empty($id_pantalla)) echo $Mensajes["bot-1"]; else echo $Mensajes["bot-2"]; ?>" name="B1" />
			<input type="reset" value="<?= $Mensajes["bot-3"];?>" name="B2" />
		</td>
	</tr>
</table>
</form>
<? require "../layouts/base_layout_admin.php";?>