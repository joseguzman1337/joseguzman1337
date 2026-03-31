<?
$pageName= "sugerencias";

require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName, $IdiomaSitio);

require "../layouts/top_layout_admin.php";

?>
<script language="JavaScript">
	function confirmar_borrado(id_sugerencia){
 		if (confirm("<?=$Mensajes["mensaje.confirmacion_eliminar_sugerencia"]?>")){
 			location.href='sugerencias_controller.php?id_sugerencia='+id_sugerencia+'&operacion=borrar';
 		}
	}
</script>

<table width="90%" class="table-list" align="center" cellpadding="4" cellspacing="1">
	<tr>
    	<td colspan="3" class="table-list-top">
    		<img src="../images/square-w.gif" width="8" height="8">
    		<?= $Mensajes["mensaje.listado_sugerencias"]?>
        </td>
    </tr>	
    <tr>
    	<th><?=$Mensajes["campo.titulo"]?></th>
    	<th><?=$Mensajes["campo.comentario"]?></th>
    	<th>&nbsp;</th>
    </tr>
	<?
	$sugerencias= $servicesFacade->getSugerencias();
	foreach ($sugerencias as $sugerencia){?>    
		<tr>
			<td><?= $sugerencia["Titulo"];?></td>
			<td><?= $sugerencia["Comentario"];?></td>
			<td>
				<input type="button" name="bModificar" value="<?=$Mensajes["boton.modificarSugerencia"]?>" onclick="location.href='agregarOModificarSugerencia.php?id_sugerencia=<?=$sugerencia["Id"]?>'"/>
				<input type="button" name="bEliminar" value="<?=$Mensajes["boton.eliminarSugerencia"]?>" onclick="return confirmar_borrado(<?=$sugerencia["Id"]?>);"/>
			</td>
		</tr>
	<?}?> 
</table>

 <?    require "../layouts/base_layout_admin.php";?>