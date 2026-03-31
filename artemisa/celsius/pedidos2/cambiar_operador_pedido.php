<?php
/**
 * @param string id_pedido
 * 
 */
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
$pageName= "pedidos";
require "../layouts/top_layout_popup.php";
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);
if (!empty($nuevo_operador)){
	$resModificacion = $servicesFacade->modificarPedido($id_pedido, array("Operador_Corriente" => $nuevo_operador));
	if (is_a($resModificacion, "Celsius_Exception")){
		$mensaje_error = $Mensajes["error.cambioOperador"];
		$excepcion = $resModificacion;
		require "../common/mostrar_error.php";
	}
	?>
	<div align="center">
		<?=$Mensajes["mensaje.operadorCambiado"];?>
		<script language="JavaScript" type="text/javascript">
			window.opener.location.reload();
			setTimeout('self.close()',4000)
		</script>
		<input type="button" onclick="self.close()" value="<?=$Mensajes["boton.cerrar"];?>"/>
	</div>
<? }else{
	
	$usuario = SessionHandler::getUsuario();
	$id_usuario = $usuario["Id"];
	
	$pedidoCompleto = $servicesFacade->getPedidoCompleto($id_pedido);
	?>
	
	<form>
		<input type="hidden" name="id_pedido" value="<?=$id_pedido?>" />
		
	<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="0" class="table-form">
		<tr>
	    	<td colspan="2" class="table-form-top">
				<?= $Mensajes["titulo.operador"]; ?>: &nbsp;<? echo $id_pedido; ?>
			</td>
	    </tr>
	    <tr>
			<th><?=$Mensajes["campo.operador"];?></th>
			<td><?echo $pedidoCompleto["Apellido_Operador"].", ".$pedidoCompleto["Nombre_Operador"];?></td>
	    </tr>
	    
		<tr>
			<th><?=$Mensajes["campo.nuevoOperador"];?></th>
			<td>
				<select size="1" name="nuevo_operador">
					<?
					$operadores = $servicesFacade->getUsuarios(array("Personal"=> 1));
					foreach($operadores as $operador){?>
						<option value="<?= $operador["Id"]?>"<? if (isset($id_usuario)&&($id_usuario==$operador["Id"])) echo "selected" ?> > 
							<?echo $operador["Apellido"].", ".$operador["Nombres"];?>
						</option>
					<? } ?>
	      		</select>
			</td>
	    </tr>
	    <tr>
			<th>&nbsp;</th>
			<td>
		    	<input type="submit" value="<?=$Mensajes["boton.cambiar"];?>" name="B1" />
				<input type="button" value="<?=$Mensajes["boton.cancelar"];?>" name="B2"  OnClick="javascript:self.close()" />
			</td>
	    </tr>
	</table>
	</form>
<? } ?>


<? require "../layouts/base_layout_popup.php" ?>