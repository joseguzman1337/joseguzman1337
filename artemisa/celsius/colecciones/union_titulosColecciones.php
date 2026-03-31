<?
/**
 * Pagina encargada de realizar la union entre dos titulos coleccion
 */
$pageName = "uniones";

require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

if (empty($IdTituloAEliminar)){
	$IdTituloAEliminar = 0;
	$TituloAEliminar = "";
}
if (empty ($IdTitulo)){
	$IdTitulo = 0;
	$Titulo = "";
}
$usuario = SessionHandler :: getUsuario();
$id_usuario = $usuario["Id"];
?>

<script language="JavaScript">
	function seleccionar_titulo_coleccion_a_eliminar(){
		var TituloAEliminar = document.getElementsByName("TituloAEliminar").item(0).value;
		ventana=window.open("seleccionar_titulo_coleccion.php?input_id_coleccion=IdTituloAEliminar&input_titulo_coleccion=TituloAEliminar&titulo_coleccion=" + TituloAEliminar, "Busqueda" ,"dependent=yes,toolbar=no,width="+(window.screen.width - 300)+",height="+(window.screen.height - 300)+",scrollbars=yes");
	}
	function seleccionar_titulo_coleccion(){
		var Titulo = document.getElementsByName("Titulo").item(0).value;
		ventana=window.open("seleccionar_titulo_coleccion.php?input_id_coleccion=IdTitulo&input_titulo_coleccion=Titulo&titulo_coleccion=" + Titulo, "Busqueda" ,"dependent=yes,toolbar=no,width="+(window.screen.width - 300)+",height="+(window.screen.height - 300)+",scrollbars=yes");
	}
	
	function validar_union (){
		var IdTituloAEliminar = document.getElementsByName("IdTituloAEliminar").item(0).value;
		var TituloAEliminar = document.getElementsByName("TituloAEliminar").item(0).value;
		var IdTitulo = document.getElementsByName("IdTitulo").item(0).value;
		var Titulo = document.getElementsByName("Titulo").item(0).value;
		
		if (IdTitulo == 0 || IdTituloAEliminar == 0){
			alert("<? echo $Mensajes["warning.seleccion"]; ?>");
			return false;
		}
		if (confirm("<?echo $Mensajes["confirmation.sustitucion1"];?> '" + TituloAEliminar + "' <?echo $Mensajes["confirmation.sustitucion2"];?> '" + Titulo + "' "))
			return true;
		return false;
	}
</script>

<?
if (empty($submit)) {?>	
	<form method="POST" name="form1" action="union_titulosColecciones.php" onsubmit="return validar_union();">  
	<table width="70%" class="table-form" align="center" cellpadding="1" cellspacing="1">
		<tr>
			<td colspan="2" class="table-form-top-blue">
				<img src="../images/square-w.gif" width="8" height="8"><?=$Mensajes["tf-14"]; ?>
			</td>
		</tr>
		<tr>
			<th><?=$Mensajes["ec-11"]; ?></th>
			<td>
				<input type="hidden" name="IdTituloAEliminar" value="<?=$IdTituloAEliminar?>" />
				<input type="text" name="TituloAEliminar" size="43" value="<?= $TituloAEliminar ?>" readonly/>
				<input type="button" value="?" name="B3" OnClick="seleccionar_titulo_coleccion_a_eliminar();" />
			</td>
			
		</tr>
		<tr>
           	<th><?=$Mensajes["ec-12"]; ?></th>
            <td>
    			<input type="hidden" name="IdTitulo" value="<?=$IdTitulo ?>" />
                <input type="text" name="Titulo" value="<?= $Titulo ?>" size="43" readonly/>
				<input type="button" value="?" name="B4" OnClick="seleccionar_titulo_coleccion();" />
			</td>
		</tr>
        <tr>
        	<th>&nbsp;</th>
			<td>
				<input type="submit" value="<?=$Mensajes["bot-1"]; ?>" name="submit" />
				<input type="reset" value="<?=$Mensajes["bot-2"]; ?>" name="B2" />
			</td>
		</tr>
	</table>
	</form>
<?} else {
	$servicesFacade->unirTitulosColecciones($IdTituloAEliminar, $IdTitulo, $id_usuario);
	?>
	<table width="100%" class="table-form">
		<tr>
			<td colspan="2" class="table-form-top-blue">
				<img src="../images/square-w.gif" width="8" height="8"><?=$Mensajes["tf-14"]; ?>
			</td>
		</tr>
		<tr>
			<th><?=$Mensajes["ec-11"]; ?></th>
			<td><?=$TituloAEliminar; ?></td>
		</tr>
		<tr>
			<th><?=$Mensajes["ec-12"]; ?></th>
			<td><?=$Titulo; ?></td>
		</tr>
		<tr>
			<td>
				<a href="../uniones/administracion_uniones.php"><? echo $Mensajes["h-2"]; ?></a>
			</td>
		</tr>
	</table>
<?}?>

<? require "../layouts/base_layout_admin.php";?> 