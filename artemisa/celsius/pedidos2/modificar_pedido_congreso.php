<?php
/**
 * @var array $Campos
 * @var array $pedidoCompleto
 */
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__USUARIO);
?>
<tr>
	<th><?= $Campos["TituloCongreso"]["texto"] ?></th>
	<td><input type="text" name="TituloCongreso" value="<? echo $pedidoCompleto["TituloCongreso"]; ?>" size="80"/></td>
    <td><a href="javascript:ayuda(<?= $Campos["TituloCongreso"]["id_campo"] ?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["Organizador"]["texto"] ?></th>
	<td><input type="text" name="Organizador" value="<? echo $pedidoCompleto["Organizador"]; ?>" size="80"></td>
    <td><a href="javascript:ayuda(<?= $Campos["Organizador"]["id_campo"] ?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["AutorPonencia"]["texto"] ?></th>
	<td><input type="text" name="AutorPonencia" value="<? echo $pedidoCompleto["Autor_Detalle1"]; ?>" size="80"></td>
    <td><a href="javascript:ayuda(<?= $Campos["AutorPonencia"]["id_campo"] ?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["NumeroLugar"]["texto"] ?></th>
	<td><input type="text" name="NumeroLugar" value="<? echo $pedidoCompleto["NumeroLugar"]; ?>" size="80"/></td>
	<td><a href="javascript:ayuda(<?= $Campos["NumeroLugar"]["id_campo"] ?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["Anio_Congreso"]["texto"] ?></th>
    <td><input type="text" name="Anio_Congreso" value="<? echo $pedidoCompleto["Anio_Congreso"]; ?>" size="40"/></td>
	<td><a href="javascript:ayuda(<?= $Campos["Anio_Congreso"]["id_campo"] ?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["PaginaCapitulo"]["texto"] ?></th>
	<td><input type="text" name="PaginaCapitulo" size="30" value="<? echo $pedidoCompleto["PaginaCapitulo"]; ?>"/></td>
	<td><a href="javascript:ayuda(<?= $Campos["PaginaCapitulo"]["id_campo"] ?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["PonenciaActa"]["texto"] ?></th>
	<td><input type="text" name="PonenciaActa" value = "<? echo $pedidoCompleto["PonenciaActa"]; ?>" size="80"></td>
	<td><a href="javascript:ayuda(<?= $Campos["PonenciaActa"]["id_campo"] ?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["Codigo_Pais_Congreso"]["texto"] ?></th>
	<td><select size="1" name="Codigo_Pais_Congreso">
			<?
			$paises = $servicesFacade->getPaises();
			foreach ($paises as $pais) {?>
				<option value='<?=$pais["Id"];?>' <? if ($pais["Id"] == $pedidoCompleto["Codigo_Pais_Congreso"]){ echo "selected";}?>><?=$pais["Nombre"]?></option> 
			<?} ?>
			<option value='0' <? if ($pedidoCompleto["Codigo_Pais_Congreso"] == 0) echo "selected" ?>>
				<? $Mensajes["opc-1"] ?>
			</option>
		</select></td>
	<td><a href="javascript:ayuda(<?= $Campos["Codigo_Pais_Congreso"]["id_campo"] ?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["Otro_Pais_Congreso"]["texto"] ?></th>
	<td><input type="text" name="Otro_Pais_Congreso" value = "<? echo $pedidoCompleto["Otro_Pais_Congreso"]; ?>" size="80"/></td>
	<td><a href="javascript:ayuda(<?= $Campos["Otro_Pais_Congreso"]["id_campo"] ?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>