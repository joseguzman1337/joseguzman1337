<?
/**
 * muestra una lista de pedidos
 * @param array $pedidosCompletos 
 * @param array $VectorIdioma
 * @param array $Mensajes
 * 
 */

set_time_limit(90);
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__USUARIO);
$rol_usuario = SessionHandler::getRolUsuario();
$ultIdUsuario= "";
if ($rol_usuario != ROL__ADMINISTADOR ){
	$usuario = SessionHandler::getUsuario();
	$id_usuario = $usuario["Id"];
}
if (empty($Lista))
	$Lista = 2;

if (empty($pedidosCompletos))
	return;
	
require_once "funciones_mostrar_pedido.php";

foreach ($pedidosCompletos as $pedidoCompleto) {
	$idPedido = $pedidoCompleto["Id"];
	$Codigo_Usuario= $pedidoCompleto["Codigo_Usuario"];
	if ($Lista == 2){?>
		<table width="90%" align="center" cellpadding="0" cellspacing="1" border="0">
			<tr bgcolor="#ECECEC">
				<td>
					<? mostrar_pedido_detallado($VectorIdioma,$pedidoCompleto,$Mensajes,$rol_usuario, false);?>
				</td>
			</tr>
			<? if ($rol_usuario == ROL__ADMINISTADOR)
				devolverBusqueda($idPedido, $Mensajes); 
			?>
			<tr>
				<td style="padding:7px; text-align:center;background-color:<?= PedidosUtils::Devolver_Color_Para_Tipo_Material($pedidoCompleto["Tipo_Material"]); ?>">
					<? if ($rol_usuario == ROL__ADMINISTADOR) { 
						if (!PedidosUtils::Pedido_Pasa_Historico($pedidoCompleto["Estado"])){?>							
							<input type="button" value="<?= $Mensajes["bot-2"]; ?>" name="B3" class="style22" OnClick="modificar_pedido('<?= $idPedido; ?>')" />
							<?if ($pedidoCompleto["Estado"] != ESTADO__PENDIENTE){ ?>
								<input type="button" value="<? echo $Mensajes["bot-7"]; ?>" name="B1" class="style22" OnClick="mostrar_busquedas('<?= $idPedido; ?>')">
							<?}
							if ($pedidoCompleto["Estado"] == ESTADO__RECIBIDO || $pedidoCompleto["Estado"] == ESTADO__LISTO_PARA_BAJARSE){ 
								if ($pedidoCompleto["Estado"] == ESTADO__RECIBIDO) 
									$eventoNuevo  =  EVENTO__A_ENTREGADO_IMPRESO;
								else
									$eventoNuevo  =  EVENTO__A_PDF_DESCARGADO;
								?>
								<input type="button" value="<?= $Mensajes["boton.registrarEntrega"];?>" name="B1" OnClick="generar_evento('<?=$eventoNuevo; ?>','<?=$idPedido; ?>')" />
								<input type="button" value="<?= $Mensajes["boton.registrarTodasEntregas"];?>" name="B7" OnClick="entregar_todo('<?=$eventoNuevo; ?>','<?=$Codigo_Usuario; ?>','<?=$pedidoCompleto["Estado"]; ?>')" />
							<?}
						}
					}else{
						//confirmar, descargar
						
					}?>
					<input type="button" value="<?= $Mensajes["boton.verPedido"];?>" name="B3" class="style22" OnClick="javascript: window.location.href='mostrar_pedido.php?id_pedido=<? echo $idPedido; ?>'">	
				</td>
			</tr>
		</table>
		
	<?}elseif ($Lista==1){
		mostrar_pedido_corto($VectorIdioma,$Mensajes,$pedidoCompleto,$rol_usuario);
		echo "<br/>";
	}else{
		if((empty($ultIdUsuario)) || ($pedidoCompleto["idUsuario"]!= $ultIdUsuario))
			$imprimeNombre= 1;
		else
			$imprimeNombre= 0;
			
		mostrar_pedido_usuario($VectorIdioma,$pedidoCompleto,$Mensajes,$rol_usuario, $imprimeNombre);
		$ultIdUsuario= $pedidoCompleto["idUsuario"];
	}
}

?>