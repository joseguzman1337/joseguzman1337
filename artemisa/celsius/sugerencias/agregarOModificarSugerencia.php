<?
$pageName= "sugerencias";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";
global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

if (empty($id_sugerencia)){
	$operacion = "creacion";
	$sugerencia = array("Titulo" => "","Comentario" =>"");
	
}else{
	$operacion = "modificacion";
	$sugerencia = $servicesFacade->getSugerencia($id_sugerencia);
}
?>  	

<script language="JavaScript" type="text/javascript">
	function validar_sugerencia(){
	
		if (document.getElementsByName("Titulo").item(0).value == ""){
			alert("<?= $Mensajes["error.campo_titulo_incompleto"]?>");
			return false;
		}
		if (document.getElementsByName("Comentario").item(0).value == ""){
			alert("<?= $Mensajes["error.campo_comentario_incompleto"]?>");
			return false;
		}
	
		return true;
	}
</script>
  
  
<? if ($operacion == "modificacion"){?>
	<script language="JavaScript" type="text/javascript">
		function confirmar_borrado() {
			if (confirm("<?= $Mensajes["mensaje.confirmacion_eliminar_sugerencia"];?>")){
				location.href='sugerencias_controller.php?id_sugerencia=<?=$id_sugerencia?>&operacion=borrar';
		 	}
			//	return;
		}
	</script>
<?}?>

<form method="POST" action="sugerencias_controller.php" onsubmit="return validar_sugerencia();">
	<input type="hidden" name="operacion" value="<? echo $operacion; ?>">
	<input type="hidden" name="id_sugerencia" value="<?if (!empty($id_sugerencia)) echo $id_sugerencia; ?>">
	
<table width="100%" class="table-form" cellpadding="1" cellspacing="1" align="center">
	<tr>
    	<td colspan="2" class="table-form-top-blue">
    		<img src="../images/square-w.gif" width="8" height="8">
    		<?= $Mensajes["formulario.guardar_sugerencia"]?>
        </td>
    </tr>	
	<tr>
		<th><? echo $Mensajes["campo.titulo"];?> </th>
		<td>
			<input type="text" name="Titulo"  size="41" value="<?=$sugerencia["Titulo"]; ?>" />
			<br/>
			<?=$Mensajes["mensaje.titulo_menor_100"]?>
		</td>
	</tr>
	<tr>
    	<th><? echo $Mensajes["campo.comentario"];?> </td>
        <td>
        	<textarea rows="7" name="Comentario" cols="35"><?= $sugerencia["Comentario"] ?></textarea>
        </td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<input type="submit" value="<? if ($operacion=="creacion") echo $Mensajes["boton.agregarSugerencia"]; else echo $Mensajes["boton.modificarSugerencia"]; ?>" />
			<? if ($operacion == "modificacion"){?>
				<input type="button" name="bEliminar" value="<?=$Mensajes["boton.eliminarSugerencia"]?>" onclick="return confirmar_borrado();"/>
			<?}?>
			<input type="reset" value="<? echo $Mensajes["boton.limpiarFormulario"];?>"/>
		</td>
	</tr>
</table>
				
</form>

<? require "../layouts/base_layout_admin.php";?>