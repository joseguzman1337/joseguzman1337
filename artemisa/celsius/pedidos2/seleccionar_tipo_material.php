<?php
/**
 * @param int id_usuario
 * @param string datos_usuario
 */
$pageName = "seleccionar_material";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__BIBLIOTECARIO);
require "../layouts/top_layout_admin.php";
$usuario = SessionHandler::getUsuario();

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

$datos_creador = $usuario["Apellido"].", ".$usuario["Nombres"];
?>
<form action="modificar_pedido.php" method="get">

	<input type="hidden" name="id_usuario" value="<?=$id_usuario?>">
    
    
<table width="80%"  border="0" align="center" cellpadding="3" cellspacing="0" class="table-form">
	<tr>
		<td class="table-form-top-blue" width="50%"><img src="../images/square-w.gif" width="8" height="8"/> <?=$Mensajes["mensaje.agregando"] ?></td>
		<td class="table-form-top-blue" width="50%" style="text-align:right !important;"><? echo $Mensajes["mensaje.operador_actual"]; ?> <?= $datos_creador ?></td>
	</tr>
    <tr>
		<th><?=$Mensajes["campo.usuario"] ?></th>
		<td class="style33">
			<?
			if (empty($datos_usuario)){
				$user = $servicesFacade->getUsuario($id_usuario);
				$datos_usuario = $user["Apellido"].", ".$user["Nombres"];
			}
			echo $datos_usuario;
			?>
		</td>
	</tr>
    <tr>
    	<th><?= $Mensajes["campo.tipo_material"];?></th>
		<td>
			<select size="1" name="tipo_material">
            	<? $tipos_material = TraduccionesUtils::Traducir_Tipos_Material($VectorIdioma); 
            	foreach($tipos_material as $codigo_material => $texto_tipo_material){?>
            		<option value="<?=$codigo_material?>"><?= $texto_tipo_material ?></option>
            	<?}?>
			</select>
		</td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td><input type="submit" value="<?=$Mensajes["accion.crear_pedido"] ?>"></td>
	</tr>
</table>

</form>
<?
require "../layouts/base_layout_admin.php";
?>