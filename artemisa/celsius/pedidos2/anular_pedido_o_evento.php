<?
/**
 * @param string tipoAnulacion
 * @param string id_pedido ? 
 * @param int id_evento ?
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
	
	switch ($tipoAnulacion) {
		case "pedido": 
			$res = $servicesFacade->anularPedido($id_pedido, $Fecha_Anulacion, $Causa_Anulacion, $usuario["Id"]);
			$mensaje = $Mensajes["mensaje.pedidoAnulado"];
		    break;
		case "eventoEntrega":
			$res = $servicesFacade->cancelarEventoEntrega($id_pedido, $Fecha_Anulacion, $Causa_Anulacion, $usuario["Id"]);
			$mensaje = $Mensajes["mensaje.eventoEntregaAnulado"];
		    break;
		case "eventoRecepcion":
			$eventoRecepcion = $servicesFacade->getEventos(array("vigente" => 1, "Codigo_Evento" => EVENTO__A_RECIBIDO, "Id_Pedido" => $id_pedido));
			if (empty($eventoRecepcion)){
				$eventoRecepcion = $servicesFacade->getEventos(array("vigente" => 1, "Codigo_Evento" => EVENTO__A_AUTORIZADO_A_BAJARSE_PDF, "Id_Pedido" => $id_pedido));
			}

			if(!empty($eventoRecepcion)){
				$eventoRecepcion = $eventoRecepcion[0];
				$res = $servicesFacade->cancelarEvento_OrigenLocal($eventoRecepcion, $Causa_Anulacion, $usuario["Id"]);
				$mensaje = $Mensajes["mensaje.eventoRecepcionCancelado"];
			}
			else
			    $res= "";
			break;
		case "eventoSolicitud":
		case "eventoReclamadoUsuario":
			$evento= $servicesFacade->getEvento($id_evento);
			$res = $servicesFacade->cancelarEvento_OrigenLocal($evento, $Causa_Anulacion, $usuario["Id"]);
			$mensaje = $Mensajes["mensaje.eventoCancelado"];
		    break;
		
		default:
			$mensaje_error = "<br>No existe la anulacion solicitada '".$tipoAnulacion."'<br>";
			$excepcion = $res;
			require "../common/mostrar_error.php";
	}
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
	
	<script language="JavaScript" type="text/javascript">
		
		function valida_entrada(){
			<?if ($tipoAnulacion != "eventoReclamadoUsuario"){?>
		 		if (document.forms.form1.elements.Causa_Anulacion.value==""){
			  		alert ("<? echo $Mensajes["me-2"]; ?>");
			  		return false;	  
				}
			<?}?>
			return true;
		}
	</script>    
	
	<form method="POST" name="form1" action="anular_pedido_o_evento.php" onsubmit="return valida_entrada();">
		<?if(!empty($id_pedido)){?>
			<input type="hidden" name="id_pedido" value="<?=$id_pedido?>">
		<?}
		if(!empty($id_evento)){?>
			<input type="hidden" name="id_evento" value="<?=$id_evento?>">
		<?}?>
		<input type="hidden" name="tipoAnulacion" value="<?=$tipoAnulacion?>">
		
	<table width="90%" border="0"  cellpadding="5" cellspacing="0" bordercolor="#111111" bgcolor="#E4E4E4" class="table-form">
		<tr>
    		<td colspan="2" class="table-form-top">
			<? echo $id_pedido; ?>
			</td>
    	</tr>
		<?if ($tipoAnulacion=="eventoReclamadoUsuario"){
			$evento= $servicesFacade->getEvento($id_evento);	
		?>
		<tr>
	    	<th><? echo $Mensajes["campo.observacionReclamo"]; ?>: </th>
	    	<td><?= $evento["Observaciones"] ?></td>
		</tr>			
		<?}?>
		<tr>
	    	<th><? echo $Mensajes["ec-1"]; ?>: </th>
	    	<td><?= $usuario["Apellido"].", ".$usuario["Nombres"] ?></td>
		</tr>
	  	<tr>
		   	<th><? echo $Mensajes["tf-2"]; ?>: </th>
	    	<td><textarea name="Causa_Anulacion" cols="30" rows="5"></textarea></td>
	   	</tr>
	   	<tr>
	   		<th>&nbsp;</th>
	   		<td align="center" colspan="2">
		   		<input type="submit" value="<? echo $Mensajes["bot-1"]; ?>" name="anular">
	     		<input type="button" value="<?=$Mensajes["boton.cerrar"];?>" name="B2" OnClick="javascript:self.close()">
	     	</td>
		</tr>
	</table>
	
	</form>

<?
}
require "../layouts/base_layout_popup.php";
?>