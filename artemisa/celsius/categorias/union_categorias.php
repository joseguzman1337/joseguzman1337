<?
/**
 * $IdCategoriaAEliminar
 * $IdCategoria
 */
$pageName = "uniones";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);

$usuario = SessionHandler::getUsuario();
$id_usuario = $usuario["Id"];

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

require "../layouts/top_layout_admin.php";

if (empty($IdCategoriaAEliminar)){
	$IdCategoriaAEliminar= 0;
	$NombreCategoriaAEliminar= "";
}else {
	$CategoriaAEliminar = $servicesFacade->getCategoria($IdCategoriaAEliminar);
	$NombreCategoriaAEliminar = $CategoriaAEliminar["Nombre"];
}

if (empty($IdCategoria)){
	$IdCategoria= 0;
	$NombreCategoria= "";
}else {
	$Categoria = $servicesFacade->getCategoria($IdCategoria);
	$NombreCategoria = $Categoria["Nombre"];
}	 
?>
<script language="JavaScript">
function buscarCategoriaAEliminar()
{
	document.forms.form1.IdCategoriaAEliminar.value=<? if (empty($IdCategoriaAEliminar)) { $IdCategoriaAEliminar=0; } echo $IdCategoriaAEliminar; ?>; 
	document.forms.form1.seleccionarCategoria.value=1;
	document.forms.form1.action = "seleccionar_categoria.php";
	document.forms.form1.submit();
}

function buscarCategoria()
{
	document.forms.form1.IdCategoria.value=<? if (empty($IdCategoria) || $IdCategoriaAEliminar==$IdCategoria) { $IdCategoria=0; } echo $IdCategoria; ?>; 
	document.forms.form1.seleccionarCategoria.value=2;
	document.forms.form1.action = "seleccionar_categoria.php";
	document.forms.form1.submit();
}

</script>


<?
if (empty($IdCategoriaAEliminar) || empty($IdCategoria)|| empty($B1)){?> 

<form method="POST" name="form1">
	<input type="hidden" name="IdCategoriaAEliminar" value="<?=$IdCategoriaAEliminar; ?>" />
	<input type="hidden" name="IdCategoria" value="<?=$IdCategoria; ?>" />
 	<input type="hidden" name="seleccionarCategoria" />
<table width="70%" class="table-form" align="center" cellpadding="1" cellspacing="1">
	<tr>
		<td colspan="2" class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8" />
			<?=$Mensajes["tf-14"]; ?>
		</td>
    </tr>
	<tr>
		<th><?=$Mensajes["ec-13"]; ?></th>
		<td>
			<input type="text" name="NombreCategoriaAEliminar" size="43" value="<?=$NombreCategoriaAEliminar;?>" />
			<input type="button" value="?" name="B3" OnClick="buscarCategoriaAEliminar();" />
		</td>
		<td><?=$IdCategoriaAEliminar; ?></td>
	</tr>
	<tr>
       	<th><?=$Mensajes["ec-14"]; ?></th>
        <td>
        	<input type="text"  name="NombreCategoria" value="<?=$NombreCategoria;?>" size="43" />
			<input type="button" value="?" name="B4" OnClick="buscarCategoria();" />
        </td>
        <td><?=$IdCategoria;?></td>
    </tr>
    <tr>
		<th>&nbsp;</th>
		<td>
			<input type="submit" value="<?=$Mensajes["bot-1"]; ?>" name="B1" />
			<input type="reset" value="<?= $Mensajes["bot-2"]; ?>" name="B2" />
		</td>
    </tr>
</table>
</form>
	

<?}else{
  	$res= $servicesFacade->unirCategoria($IdCategoriaAEliminar, $IdCategoria, $id_usuario); 
	if (is_a($res, "Celsius_Exception")){
		$mensaje_error= $Mensajes["error.unionCategoria"];
		$excepcion = $res;
		require "../common/mostrar_error.php";
	}
?>
	
	<table width="70%" class="table-form" align="center" cellpadding="1" cellspacing="1">
	<tr>
		<td colspan="2" class="table-form-top-blue">
		<img src="../images/square-w.gif" width="8" height="8" />
			<?=$Mensajes["tf-14"];?>
		</td>
	</tr>
	<tr>
    	<th><?=$Mensajes["ec-13"]; ?></th>
        <td><?=$NombreCategoriaAEliminar; ?></td>
    </tr>
    <tr>
    	<th><?=$Mensajes["ec-14"]; ?></th>
      	<td><?=$NombreCategoria; ?></td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    </tr>
    <tr>
    	<td>
        	<a href="../uniones/administracion_uniones.php"><?=$Mensajes["h-2"]; ?></a>
        </td>
    </tr>
	</table>
  
<?}
require "../layouts/base_layout_admin.php";?> 