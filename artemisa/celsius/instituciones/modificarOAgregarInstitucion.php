<?php
$pageName= "instituciones2";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName, $IdiomaSitio);

if (empty($popup))
	require "../layouts/top_layout_admin.php";
else
	require "../layouts/top_layout_popup.php";

if (!empty($idInstitucion)){
	$institucion = $servicesFacade->getInstitucion($idInstitucion);
  	$esCentralizado=$institucion["esCentralizado"];

}else{
 	$institucion = array("Nombre" => "","Abreviatura" => "","Participa_Proyecto" =>0, "tipo_pedido_nuevo" => TIPO_PEDIDO__PROVISION,
					"Telefono" =>"","Direccion" => "","Sitio_Web" => "","Codigo_Pedidos" =>"0" , "Comentarios"=>"" , "Codigo_Pais"=>0 , "Codigo_Localidad"=>0, "habilitado_crear_pedidos" => 1, "habilitado_crear_usuarios" => 1);
	if (!empty($Codigo_Pais))
		$institucion["Codigo_Pais"] = $Codigo_Pais;
 	$idInstitucion = 0;
 	$esCentralizado = 0;
}


$mostrar_elemento = array("localidades");
require "../utils/pidui.php";
?> 

<script type="text/javascript">
	function validar_form(){
		if (document.getElementsByName('nombre').item(0).value ==''){
			alert('<?=$Mensajes["warning.faltaNombreInstitucion"];?>');
			return false;
		}
		if(document.getElementsByName('abreviatura').item(0).value == ''){
			alert('<?=$Mensajes["warning.faltaAbreviaturaInstitucion"];?>');
			return false;
		}
		if(document.getElementsByName('Codigo_Pais').item(0).value == 0){
			alert('<?=$Mensajes["warning.faltaPaisDeInstitucion"];?>');
			return false;
		}
		document.getElementsByName('submitbtn').item(0).disabled= true;
		return true;
		
	}
	
	function limpiar(){
		document.forms[0].reset();
		generar_paises(0);
		generar_localidades(0);
	}
</script>

<form action="institucionController.php" method="POST" onsubmit="return validar_form();">
	<input type="hidden" name="esCentralizado" value="<?=$esCentralizado?>" />
	<input type="hidden" name="idInstitucion" value="<?= $idInstitucion;?>" />
	<? if (!empty($popup)){?>
		<input type="hidden" name="popup" value="<?= $popup?>" />
	<?}?>
	
<table class="table-form" width="70%" align="center" cellpadding="1" cellspacing="1">
	<tr>
		<td colspan="2" class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8">
			&nbsp;
			<?=$Mensajes["ec-1"]; ?>
		</td>
	</tr>	
  	<tr>
		<th><?=$Mensajes["et-1"];?></th>
	   	<td>
	   		<select name="Codigo_Pais" <? if ($esCentralizado) echo "disabled"; ?> onChange="generar_localidades(0)" size="1">
	   		</select>
	   	</td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-2"];?></th>
	   	<td><select name="Codigo_Localidad" size="1"></select></td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-3"];?></th>
	   	<td>
	   		<input type="text" name="nombre" <? if ($esCentralizado)echo "readonly"; ?> value="<?= $institucion["Nombre"]?>" />
	   	</td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-4"];?></th>
	   	<td>
	   		<input type="text" name="abreviatura" <? if ($esCentralizado) echo "readonly"; ?> value="<?= $institucion["Abreviatura"]?>" />
	   	</td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-5"];?></th>
	   	<td>
	   		<input type="checkbox" name="Participa_Proyecto" <? if ($esCentralizado) echo "disabled"; ?> <?if ($institucion["Participa_Proyecto"]) echo "checked";?> />
	   	</td>
	</tr>
	<tr>
		<th><?=$Mensajes["campo.tipo_pedido_nuevo"];?></th>
		<td>
			<select name="tipo_pedido_nuevo" size="1">
				<option value='<?=TIPO_PEDIDO__BUSQUEDA?>' <? if ((isset($institucion["tipo_pedido_nuevo"]))&&($institucion["tipo_pedido_nuevo"]==TIPO_PEDIDO__BUSQUEDA)) echo "selected"; ?>>
					<?= TraduccionesUtils::Traducir_Tipo_Pedido($VectorIdioma,TIPO_PEDIDO__BUSQUEDA) ?>
				</option>
				<option value='<?=TIPO_PEDIDO__PROVISION?>' <? if ((isset($institucion["tipo_pedido_nuevo"]))&&($institucion["tipo_pedido_nuevo"]==TIPO_PEDIDO__PROVISION)) echo "selected"; ?>>
					<?= TraduccionesUtils::Traducir_Tipo_Pedido($VectorIdioma,TIPO_PEDIDO__PROVISION) ?>
				</option>
	   		</select>
	   	</td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-9"];?></th>
	   	<td>
	   		<input type="text" name="direccion" <?if ($esCentralizado) echo "readonly"; ?> value="<?= $institucion["Direccion"]?>" />
	   	</td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-10"];?></th>
	   	<td>
	   		<input type="text" name="telefono" <?if ($esCentralizado) echo "readonly"; ?> value="<?= $institucion["Telefono"]?>" />
	   	</td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-11"];?></th>
	   	<td>
	   		<input type="text" name="sitio_web" <?if ($esCentralizado) echo "readonly"; ?> value="<?= $institucion["Sitio_Web"]?>" />
	   	</td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-12"];?></th>
	   	<td>
	   		<input type="text" name="codigo_pedidos" value="<?= $institucion["Codigo_Pedidos"]?>" readonly/>
	   	</td>
	</tr>
	<tr>
		<th><?=$Mensajes["campo.creacionPedidosHabilitada"];?></th>
	   	<td>
	   		<input type="radio" name="habilitado_crear_pedidos" value="1" <? if ($institucion["habilitado_crear_pedidos"] == 1) echo "checked"?>/>
	   		<?=$Mensajes["mensaje.afirmacion"];?>
	   		&nbsp;
	   		<input type="radio" name="habilitado_crear_pedidos" value="0" <? if ($institucion["habilitado_crear_pedidos"] == 0) echo "checked"?>/>
	   		<?=$Mensajes["mensaje.negacion"];?>
	   	</td>
	</tr>
	<tr>
		<th><?=$Mensajes["campo.creacionUsuariosHabilitada"];?></th>
	   	<td>
	   		<input type="radio" name="habilitado_crear_usuarios" value="1" <? if ($institucion["habilitado_crear_usuarios"] == 1) echo "checked"?>/>
	   		<?=$Mensajes["mensaje.afirmacion"];?>
	   		&nbsp;
	   		<input type="radio" name="habilitado_crear_usuarios" value="0" <? if ($institucion["habilitado_crear_usuarios"] == 0) echo "checked"?>/>
	   		<?=$Mensajes["mensaje.negacion"];?>
	   	</td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-13"];?></th>
	    <td>
	    	<textarea rows="4" cols="42" name="comentarios"><?= $institucion["Comentarios"]?></textarea>
	    </td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td>
	    	<input type="submit" name="submitbtn" value="<?if (!empty($idInstitucion)) echo $Mensajes["botc-2"]; else echo $Mensajes["botc-1"]?>" />
        	<input type="button" value="<?= $Mensajes["bot-2"]; ?>" onClick="limpiar();"/>
        </td>
	</tr>	
</table>
</form>
  

<script language="JavaScript" type="text/javascript">
	listNames[0] = new Array();
	listNames[0]["paises"]="Codigo_Pais";
	listNames[0]["localidades"]="Codigo_Localidad";

	<?
	echo "generar_paises(".$institucion["Codigo_Pais"].");\n";
	echo "generar_localidades(".$institucion["Codigo_Localidad"].");\n";
	?>
</script>

<? 
if (empty($popup))
	require "../layouts/base_layout_admin.php";
else
	require "../layouts/base_layout_popup.php";
?>