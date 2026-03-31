<?php
/**
 * @var array $Campos
 * @var array $pedidoCompleto
 */
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__USUARIO);
?>

<tr>
	<th><?= $Campos["Titulo_Libro"]["texto"] ?></th>
	<td><input type="text" name="Titulo_Libro" value="<? echo $pedidoCompleto["Titulo_Libro"]; ?>" size="75"/></td>
	<td><a href="javascript:ayuda(<?=$Campos["Titulo_Libro"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>

<tr>
	<th><?= $Campos["Autor_Libro"]["texto"] ?></th>
	<td><input type="text" name="Autor_Libro" value="<? echo $pedidoCompleto["Autor_Libro"]; ?>" size="60" /></td>
	<td><a href="javascript:ayuda(<?=$Campos["Autor_Libro"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>

<tr>
	<th><?= $Campos["Editor_Libro"]["texto"] ?></th>
	<td><input type="text" name="Editor_Libro" value="<? echo $pedidoCompleto["Editor_Libro"]; ?>" size="60"/></td>
	<td><a href="javascript:ayuda(<?=$Campos["Editor_Libro"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
	
<tr>
	<th><?= $Campos["Anio_Libro"]["texto"] ?></th>
	<td><input type="text" name="Anio_Libro" value="<? echo $pedidoCompleto["Anio_Libro"]; ?>" size="25"/></td>
	<td><a href="javascript:ayuda(<?=$Campos["Anio_Libro"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
    
<tr>
	<th><?= $Campos["Desea_Indice"]["texto"] ?></th>
	<td><input type="checkbox" name="Desea_Indice" value="true" <? if ($pedidoCompleto["Desea_Indice"]) { echo "checked"; } ?> /></td>
	<td><a href="javascript:ayuda(<?=$Campos["Desea_Indice"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>

<tr>
	<th><?= $Campos["Capitulo_Libro"]["texto"] ?></th>
	<td><input type="text" name="Capitulo_Libro" value = "<? echo $pedidoCompleto["Capitulo_Libro"]; ?>" size="60"/></td>
	<td><a href="javascript:ayuda(<?=$Campos["Capitulo_Libro"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
	
<tr>
	<th><?= $Campos["Autor_Detalle1"]["texto"] ?></th>
	<td><input type="text" name="Autor_Detalle1" value = "<? echo $pedidoCompleto["Autor_Detalle1"]; ?>" size="60"/></td>
	<td><a href="javascript:ayuda(<?=$Campos["Autor_Detalle1"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
    
<tr>
	<th><?= $Campos["Autor_Detalle2"]["texto"] ?></th>
	<td><input type="text" name="Autor_Detalle2" value = "<? echo $pedidoCompleto["Autor_Detalle2"]; ?>" size="60"/></td>
	<td><a href="javascript:ayuda(<?=$Campos["Autor_Detalle2"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
	
<tr>
	<th><?= $Campos["Autor_Detalle3"]["texto"] ?></th>
	<td><input type="text" name="Autor_Detalle3" value = "<? echo $pedidoCompleto["Autor_Detalle3"]; ?>" size="60" /></td>
	<td><a href="javascript:ayuda(<?=$Campos["Autor_Detalle3"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
	
<tr>
	<th><?= $Campos["Pagina_Desde"]["texto"] ?></th>
	<td><input type="text" name="Pagina_Desde" size="12" value="<? echo $pedidoCompleto["Pagina_Desde"]; ?>" /></td>
	<td><a href="javascript:ayuda(<?=$Campos["Pagina_Desde"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
	
<tr>
	<th><?= $Campos["Pagina_Hasta"]["texto"] ?></th>
	<td><input type="text" name="Pagina_Hasta" value="<? echo $pedidoCompleto["Pagina_Hasta"]; ?>" size="12"/></td>
	<td><a href="javascript:ayuda(<?=$Campos["Pagina_Hasta"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>