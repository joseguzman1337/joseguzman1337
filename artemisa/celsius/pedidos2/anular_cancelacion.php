<?
/**
 * 
 * @param string id_pedido ? 
 * 
 */
$pageName="anulacion.pedidos_o_eventos";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_popup.php";
$usuario = SessionHandler::getUsuario();

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

if (!empty ($anular)) {
	$Fecha_Anulacion = date("Y-m-d H:i:s");
	
	$res = $servicesFacade->cancelarCancelacion($id_pedido, $Fecha_Anulacion, $Causa_Cancelacion, $usuario["Id"]);
	$mensaje = $Mensajes["mensaje.eventoEntregaAnulado"];
	if (is_a($res, "Celsius_Exception")){
		$mensaje_error = "No se puedo generar la anulacion por un error.";
		$excepcion = $res;
		require "../common/mostrar_error.php";
	}
	echo $mensaje;
	?>
	<div align="center">
		<script language="JavaScript" type="text/javascript">
			window.opener.location.reload();
  			setTimeout('self.close()',3000)
	  	</script>
		<input type="button" onclick="self.close()" value="<?=$Mensajes["boton.cerrar"];?>"/>
	</div>
	<?
}else{?>
	
	
	<form method="POST" name="form1" action="anular_cancelacion.php" >
		<?if(!empty($id_pedido)){?>
			<input type="hidden" name="id_pedido" value="<?=$id_pedido?>">
		<?}
		?>
		
	<table width="90%" border="0"  cellpadding="5" cellspacing="0" bordercolor="#111111" bgcolor="#E4E4E4" class="table-form">
		<tr>
    		<td colspan="2" class="table-form-top">
			<? echo $id_pedido; ?>
			</td>
    	</tr>
		<tr>
	    	<th><? echo $Mensajes["ec-1"]; ?>: </th>
	    	<td><?= $usuario["Apellido"].", ".$usuario["Nombres"] ?></td>
		</tr>
	  	<tr>
		   	<th><? echo $Mensajes["tf-2"]; ?>: </th>
	    	<td><textarea name="Causa_Cancelacion" cols="30" rows="5"></textarea></td>
	   	</tr>
	   	<tr>
	   		<th>&nbsp;</th>
	   		<td align="center" colspan="2">
		   		<input type="submit" value="<?=$Mensajes["bot-1"]; ?>" name="anular">
	     		<input type="button" value="<?=$Mensajes["boton.cerrar"];?>" name="B2" OnClick="javascript:self.close()">
	     	</td>
		</tr>
	</table>
	
	</form>

<?
}
require "../layouts/base_layout_popup.php";
?>