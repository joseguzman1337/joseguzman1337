<?
/**
 * @param int id_sugerencia El id e la sugerencia que se dessea mostrar
 */
$pageName= "sugerencias";

require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_admin.php";  

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

$sugerencia = $servicesFacade->getSugerencia($id_sugerencia);
?>
<script language="JavaScript" type="text/javascript">
	function confirmar_borrado() {
		if (confirm("<?= $Mensajes["mensaje.confirmacion_eliminar_sugerencia"];?>")){
			location.href='sugerencias_controller.php?id_sugerencia=<?=$id_sugerencia?>&operacion=borrar';
	 	}
		return;
	}
</script>
  
<table width="100%" class="table-form" align="center" cellpadding="1" cellspacing="1">	
	<tr>
		<td class="table-form-top-blue" colspan="2">
			<img src="../images/square-w.gif" width="8" height="8"/>
			
		</td>
	</tr>
	<tr>
		<th><?=$Mensajes["campo.titulo"]?></th>
		<td><?= $sugerencia["Titulo"];?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["campo.comentario"]?></th>
		<td><?= $sugerencia["Comentario"];?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			
			<input type="button" name="bModificar" value="<?=$Mensajes["boton.modificarSugerencia"]?>" onclick="location.href='agregarOModificarSugerencia.php?id_sugerencia=<?=$id_sugerencia?>'"/>
			<input type="button" name="bEliminar" value="<?=$Mensajes["boton.eliminarSugerencia"]?>" onclick="return confirmar_borrado();"/>
			<input type="button" name="bListar" value="<?=$Mensajes["boton.listarSugerencias"]?>" onclick="location.href='listar_sugerencias.php'"/>
		</td>
	</tr>
</table>
<? require "../layouts/base_layout_admin.php";?>





