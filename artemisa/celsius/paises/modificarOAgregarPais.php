<?php
/**
 * Para modificacion o creacion de un pais:
 * @param int $idPais El id del pais que quiero modificar. Si no tiene valor, se considera un alta.
 * 
 */
 $pageName="paises";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

if (empty($popup))
	require "../layouts/top_layout_admin.php";
else
	require "../layouts/top_layout_popup.php";

if (!empty ($idPais)) {
	/*operacion de modificacion*/
	$pais = $servicesFacade->getPais($idPais);
	$esCentralizado = $pais["esCentralizado"];
} else {
	/*operacion de alta*/
	$pais = array("Nombre" => "","Abreviatura" => "","esCentralizado" => 0, "permite_revista" => 0,"permite_libro" => 0,"permite_tesis" => 0,"permite_patente" => 0,"permite_congreso" => 0);
}
$esCentralizado = ($pais["esCentralizado"] == 1);
?> 
<script type="text/javascript">
	function procesar(){
		if ((document.getElementsByName('Nombre').item(0).value!='')&&(document.getElementsByName('Abreviatura').item(0).value!='')){
			document.formUpAd.submit();
			document.getElementsByName('submitbt').item(0).disabled=true;
		}
		else
			alert('<?=$Mensajes["warning.faltanDatos"];?>');
	}
</script>

<form name="formUpAd" action="paisController.php" method="POST">
	<input type="hidden" name="esCentralizado" value="<?= $pais["esCentralizado"];?>" />
    <input type="hidden" name="idPais" value="<?if (isset($idPais)) echo $idPais;?>" />
    <? if (!empty($popup)){?>
		<input type="hidden" name="popup" value="<?= $popup?>" />
	<?}?>
    
<table class="table-form" align="center">
	<tr>
		<td colspan="2" class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8"><?=$Mensajes["et-1"]; ?>
		</td>
	</tr>  
	<tr>
		<th><?=$Mensajes["ec-1"];?></th>
	   	<td><input type="text" <?if ($esCentralizado)echo "readonly"; ?> name="Nombre" value="<?= $pais["Nombre"]?>"></td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-2"];?></td>
	   	<td><input type="text" <?if ($esCentralizado) echo "readonly"; ?> name="Abreviatura" value="<?= $pais["Abreviatura"]?>"></td>
	</tr>
	<tr>
		<th><?=$Mensajes["campo.permiteRevista"];?></th>
	   	<td><input type="checkbox" name="permite_revista" <?if ($pais["permite_revista"]==1) echo "checked";?> value="ON"/>
	   	</td>
	</tr>
	<tr>
		<th><?=$Mensajes["campo.permiteLibro"];?></th>
		<td><input type="checkbox" name="permite_libro" <?if ($pais["permite_libro"]==1) echo "checked";?> value="ON"/></td>
	</tr>
	<tr>
		<th><?=$Mensajes["campo.permiteTesis"];?></th>
	    <td><input type="checkbox" name="permite_tesis" <?if ($pais["permite_tesis"]==1) echo "checked";?> value="ON"/></td>
	</tr>
	<tr>
		<th><?=$Mensajes["campo.permitePatente"];?></th>
	   	<td><input type="checkbox" name="permite_patente" <?if ($pais["permite_patente"]==1) echo "checked";?> value="ON"/></td>
	</tr>
	<tr>
		<th><?=$Mensajes["campo.permiteCongreso"];?></th>
	   	<td><input type="checkbox" name="permite_congreso" <?if ($pais["permite_congreso"]==1) echo "checked";?> value="ON"/></td>
	</tr>
	
	<tr>
		<td colspan="2">
	    	<input type="button" name="submitbt" value="<?if (!empty($idPais)) echo $Mensajes['botc-2']; else echo $Mensajes['botc-1'];?>" onClick="procesar();" />
        	<input type="reset" value="<?= $Mensajes['bot-2'];?>" />
		</td>
	</tr>
</table>

</form>

<? 
if (empty($popup))
	require "../layouts/base_layout_admin.php";
else
	require "../layouts/base_layout_popup.php";
?>