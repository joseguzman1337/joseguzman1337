<?
$pageName = "uniones";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";
$usuario = SessionHandler::getUsuario();
$id_usuario = $usuario["Id"];	 
if (!isset($IdUsuarioAEliminar))	$IdUsuarioAEliminar=0; 
if (!isset($IdUsuario))	$IdUsuario=0;

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);
?>
<script language="JavaScript">
function buscarUsuarioAEliminar()
{
	document.forms.form1.IdUsuarioAEliminar.value=<? if (empty($IdUsuarioAEliminar)) { $IdUsuarioAEliminar=0; } echo $IdUsuarioAEliminar; ?>; 
	document.forms.form1.seleccionarUsuario.value=1;
	document.forms.form1.action = "seleccionar_usuario.php";
	document.forms.form1.submit();
}

function buscarUsuario()
{
	document.forms.form1.IdUsuario.value=<? if (empty($IdUsuario) || $IdUsuarioAEliminar==$IdUsuario) { $IdUsuario=0; } echo $IdUsuario; ?>; 
	document.forms.form1.seleccionarUsuario.value=2;
	document.forms.form1.action = "seleccionar_usuario.php";
	document.forms.form1.submit();
}
function seleccionar_usuario_a_eliminar(){
	    ventana=window.open("seleccionar_usuario.php?input_id_usuario=IdUsuarioAEliminar&input_datos_usuario=NombreUsuarioAEliminar", "Busqueda" ,"dependent=yes,toolbar=no,width="+(window.screen.width - 300)+",height="+(window.screen.height - 300)+",scrollbars=yes");
}
function seleccionar_usuario(){
	    ventana=window.open("seleccionar_usuario.php?input_id_usuario=IdUsuario&input_datos_usuario=NombreUsuario", "Busqueda" ,"dependent=yes,toolbar=no,width="+(window.screen.width - 300)+",height="+(window.screen.height - 300)+",scrollbars=yes");
}


</script>

<?
if (empty($IdUsuarioAEliminar) || empty($IdUsuario)|| empty($B1)){?> 
<table width="70%" class="table-form" align="center" cellpadding="1" cellspacing="1">
	<tr>
		<td class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8"><?=$Mensajes["tf-13"]; ?>
		</td>
	</tr>
	<tr>
		<td>
		<form method="POST" name="form1" action="union_usuarios.php">
			<table width="100%" class="table-form">
				<tr>
					<th><?=$Mensajes["ec-9"]; ?></th>
					<td>
						<input type="text" name="NombreUsuarioAEliminar" size="43" value="<? if (isset($NombreUsuarioAEliminar)){echo $NombreUsuarioAEliminar;}?>">
						<input type="hidden" name="IdUsuarioAEliminar" id="IdUsuarioAEliminar" value="<? if (isset($IdUsuarioAEliminar)){echo $IdUsuarioAEliminar;}?>">
						<input type="button" value="?" name="B3" OnClick="seleccionar_usuario_a_eliminar();">
					</td>
					<td><? if (isset($IdUsuarioAEliminar)) {echo $IdUsuarioAEliminar;} ?></td>
				</tr>
				<tr>
                	<th><?=$Mensajes["ec-10"]; ?></th>
                    <td>
                    	<input type="text"  name="NombreUsuario" value="<? if (isset($NombreUsuario)){echo $NombreUsuario;} ?>"size="43">
						<input type="hidden" name="IdUsuario" id="IdUsuario" value="<? if (isset($IdUsuario)){echo $IdUsuario;} ?>">
						<input type="button" value="?" name="B4" OnClick="seleccionar_usuario();">
                    </td>
                    <td><? if (isset($IdUsuario)) {echo $IdUsuario;} ?></td>
                </tr>
                <tr>
					<th>&nbsp;</th>
					<td colspan="3" align="center" valign="top">
						<input type="submit" value="<?=$Mensajes["bot-1"]; ?>" name="B1">
						<input type="reset" value="<?=$Mensajes["bot-2"]; ?>" name="B2">
						<input type="hidden" name="seleccionarUsuario">
                    </td>
                </tr>
			</table>
		</form>
		</td>
	</tr>
</table>
<?}else{
  $servicesFacade->unirUsuarios($IdUsuarioAEliminar,$IdUsuario,$id_usuario);   
?>
<table width="100%" class="table-form">
	<tr>
		<td colspan="2" class="table-form-top-blue"><?=$Mensajes["tf-13"]; ?></td>
	</tr>
	<tr>
    	<th><?=$Mensajes["ec-9"]; ?></th>
        <td><?=$NombreUsuarioAEliminar; ?></td>
        
    </tr>
    <tr>
    	<th><?=$Mensajes["ec-10"]; ?>&nbsp;</th>
      	<td><?=$NombreUsuario; ?></td>
      	
    </tr>
    <tr>
    	<td>
        	<a href="../uniones/administracion_uniones.php"><?=$Mensajes["h-2"]; ?>&nbsp;</a></td>
    </tr>
</table>
  
<?}?>
<? require "../layouts/base_layout_admin.php";?>
