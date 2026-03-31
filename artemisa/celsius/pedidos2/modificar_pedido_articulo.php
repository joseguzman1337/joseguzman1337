<?php
/**
 * @var array $Campos
 * @var array $pedidoCompleto
 */
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__USUARIO);
?>
<script language="JavaScript" type="text/javascript">
		
	function seleccionar_titulo_coleccion(){
		var titulo = document.getElementsByName("Titulo_Revista").item(0).value;
		 ventana=window.open("../colecciones/seleccionar_titulo_coleccion.php?input_id_coleccion=Codigo_Titulo_Revista&input_titulo_coleccion=Titulo_Revista&titulo_coleccion="+titulo+"&seleccion=seleccion", "Busqueda" ,"dependent=yes,toolbar=no,width="+(window.screen.width - 300)+",height="+(window.screen.height - 300)+",scrollbars=yes");
		//location.href="../colecciones/seleccionar_titulo_coleccion.php?popup=0&titulo_coleccion="+titulo+"&url_destino=<?=$_SERVER["REQUEST_URI"]	?>";
	}	
</script>

<tr>
	<?
	if (empty($id_coleccion)){
		$id_coleccion = $pedidoCompleto["Codigo_Titulo_Revista"];
		$titulo_coleccion = $pedidoCompleto["Titulo_Revista"];
	}
	?>
	<th>
		<?= $Campos["Titulo_Revista"]["texto"] ?>
		<? if (!empty($id_coleccion)) { ?>
       		<img border="0" src="../images/marca.gif" width="23" height="23">
		<? } ?>
	</th>
	<td>
		<input type="hidden" name="Codigo_Titulo_Revista" value="<? echo $id_coleccion; ?>" />
		<input type="text" name="Titulo_Revista" value="<?= stripslashes($titulo_coleccion); ?>" size="60" onkeypress="document.getElementsByName('Codigo_Titulo_Revista').item(0).value='';"/>
		<? if (!$soloLectura){?>
			<input type="button" value="+" OnClick="seleccionar_titulo_coleccion()" />
		<?}?>
	</td>
	<td><a href="javascript:ayuda(<?=$Campos["Titulo_Revista"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["Volumen_Revista"]["texto"] ?></th>
	<td><input type="text" name="Volumen_Revista" value="<? echo $pedidoCompleto["Volumen_Revista"]; ?>" size="40"/></td>
	<td><a href="javascript:ayuda(<?=$Campos["Volumen_Revista"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["Numero_Revista"]["texto"] ?></th>
	<td><input type="text" name="Numero_Revista" value="<? echo $pedidoCompleto["Numero_Revista"]; ?>" size="40"/></td>
	<td><a href="javascript:ayuda(<?=$Campos["Numero_Revista"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["Anio_Revista"]["texto"] ?></th>
	<td><input type="text" name="Anio_Revista" value="<? echo $pedidoCompleto["Anio_Revista"]; ?>" size="40"/></td>
	<td><a href="javascript:ayuda(<?=$Campos["Anio_Revista"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["Titulo_Articulo"]["texto"] ?></th>
	<td><input type="text" name="Titulo_Articulo" value="<? echo $pedidoCompleto["Titulo_Articulo"]; ?>" size="60"/></td>
	<td><a href="javascript:ayuda(<?=$Campos["Titulo_Articulo"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
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