<?php
/**
 * @var array $Campos
 * @var array $pedidoCompleto
 */
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__USUARIO);
?>

<tr>
	<th><?= $Campos["AutorPatente"]["texto"] ?></td>
	<td><input type="text" name="Autor_Patente" value="<? echo $pedidoCompleto["Autor_Detalle1"]; ?>" size="40"/></td>
	<td><a href="javascript:ayuda(<?=$Campos["AutorPatente"]["id_campo"]?>)"> <img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["Numero_Patente"]["texto"] ?></td>
	<td><input type="text" name="Numero_Patente" value="<? echo $pedidoCompleto["Numero_Patente"]; ?>" size="40"/></td>
	<td><a href="javascript:ayuda(<?=$Campos["Numero_Patente"]["id_campo"]?>)"> <img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["Codigo_Pais_Patente"]["texto"] ?></th>
	<td><select size="1" name="Codigo_Pais_Patente">
        	<?
			$paises = $servicesFacade->getPaises();
			flush();
			foreach ($paises as $pais) {?>
				<option <? if ($pais["Id"] == $pedidoCompleto["Codigo_Pais_Patente"]) echo "selected"?> 
					value='<? echo $pais["Id"]?>'>
					<? echo $pais["Nombre"]?>
				</option> 
			<?} ?>
			<option value="0" <?if ($pedidoCompleto["Codigo_Pais_Patente"] == 0) echo "selected"?>>
				 <?$Mensajes["opc-1"] ?>
			</option>
		</select></td>
	<td><a href="javascript:ayuda(<?=$Campos["Codigo_Pais_Patente"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["Otro_Pais_Patente"]["texto"] ?></th	>
	<td><input type="text" name="Pais_Patente" value="<? echo $pedidoCompleto["Pais_Patente"]; ?>" size="40"/></td>
	<td><a href="javascript:ayuda(<?=$Campos["Pais_Patente"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["Anio_Patente"]["texto"] ?></th>
	<td><input type="text" name="Anio_Patente" value="<? echo $pedidoCompleto["Anio_Patente"]; ?>" size="40"/></td>
	<td><a href="javascript:ayuda(<?=$Campos["Anio_Patente"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>