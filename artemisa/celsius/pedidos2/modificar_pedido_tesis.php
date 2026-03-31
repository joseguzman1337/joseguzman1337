<?php
/**
 * @var array $Campos
 * @var array $pedidoCompleto
 */
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__USUARIO);
?>
<? 
$mostrar_elemento = array("instituciones","dependencias");
require "../utils/pidui.php";
?>
<script language="JavaScript" type="text/javascript">
	listNames[0] = new Array();
	listNames[0]["paises"]="Codigo_Pais_Tesis";
	listNames[0]["instituciones"]="Codigo_Institucion_Tesis";
	listNames[0]["dependencias"]="Codigo_Dependencia_Tesis";
</script>

<tr>
	<th><?= $Campos["TituloTesis"]["texto"] ?></th>
	<td><input type="text" name="TituloTesis" value="<? echo $pedidoCompleto["TituloTesis"]; ?>" size="80"/></td>
	<td><a href="javascript:ayuda(<?=$Campos["TituloTesis"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["AutorTesis"]["texto"] ?></th>
	<td><input type="text" name="AutorTesis" size="60" value="<? echo $pedidoCompleto["AutorTesis"]; ?>"></td>
	<td><a href="javascript:ayuda(<?=$Campos["AutorTesis"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["DirectorTesis"]["texto"] ?></th>
	<td><input type="text" name="DirectorTesis" value="<? echo $pedidoCompleto["DirectorTesis"]; ?>" size="60"></td>
	<td><a href="javascript:ayuda(<?=$Campos["DirectorTesis"]["id_campo"]?>)"> <img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["GradoAccede"]["texto"] ?></th>
	<td><input type="text" name="GradoAccede" value="<? echo $pedidoCompleto["GradoAccede"]; ?>" size="60"></td>
	<td><a href="javascript:ayuda(<?=$Campos["GradoAccede"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["Anio_Tesis"]["texto"] ?></th>
	<td><input type="text" name="Anio_Tesis" value="<? echo	$pedidoCompleto["Anio_Tesis"]; ?>" size="40"></td>
	<td><a href="javascript:ayuda(<?=$Campos["Anio_Tesis"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["PagCapitulo"]["texto"] ?></th>
	<td><input type="text" name="PagCapitulo" value="<? echo $pedidoCompleto["PagCapitulo"]; ?>" size="12"></td>
	<td><a href="javascript:ayuda(<?=$Campos["PagCapitulo"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["Codigo_Pais_Tesis"]["texto"] ?></th>
	<td><select name="Codigo_Pais_Tesis" onchange="generar_instituciones(0)" size="1"/>
		</select></td>
	<td><a href="javascript:ayuda(<?=$Campos["Codigo_Pais_Tesis"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["Otro_Pais_Tesis"]["texto"] ?></th>
	<td><input type="text" name="Otro_Pais_Tesis" value="<? echo	$pedidoCompleto["Otro_Pais_Tesis"]; ?>" size="60"></td>
	<td><a href="javascript:ayuda(<?=$Campos["Otro_Pais_Tesis"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["Codigo_Institucion_Tesis"]["texto"] ?></th>
	<td><select name="Codigo_Institucion_Tesis" onchange="generar_dependencias(0)" size="1"/>
		</select></td>
	<td><a href="javascript:ayuda(<?=$Campos["Codigo_Institucion_Tesis"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["Otra_Institucion_Tesis"]["texto"] ?></th>
	<td><input type="text" name="Otra_Institucion_Tesis" value="<? echo $pedidoCompleto["Otra_Institucion_Tesis"]; ?>" size="60"></td>
	<td><a href="javascript:ayuda(<?=$Campos["Otra_Institucion_Tesis"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["Codigo_Dependencia_Tesis"]["texto"] ?></th>
	<td><select name="Codigo_Dependencia_Tesis" size="1"/>
		</select></td>
	<td><a href="javascript:ayuda(<?=$Campos["Codigo_Dependencia_Tesis"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>
<tr>
	<th><?= $Campos["Otra_Dependencia_Tesis"]["texto"] ?></th>
	<td><input type="text" name="Otra_Dependencia_Tesis" value="<? echo $pedidoCompleto["Otra_Dependencia_Tesis"]; ?>" size="60"></td>
	<td><a href="javascript:ayuda(<?=$Campos["OtraDependenciaTesis"]["id_campo"]?>)"><img src="../images/help.gif" border="0" width="22" height="22"></a></td>
</tr>

<script language="JavaScript">
	generar_paises(<? echo $pedidoCompleto["Codigo_Pais_Tesis"] ?>);
	<? if (!empty($pedidoCompleto["Codigo_Institucion_Tesis"])){?>
		generar_instituciones(<? echo $pedidoCompleto["Codigo_Institucion_Tesis"] ?>);
	<? }
	if (!empty($pedidoCompleto["Codigo_Dependencia_Tesis"])){?>
		generar_dependencias(<? echo $pedidoCompleto["Codigo_Dependencia_Tesis"] ?>);
	<? } ?>
</script>