<?php
/**
 * @param array $pedidoCompleto
 * @param bool $mostarOperaciones
 */
$pageName = "eventos";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__USUARIO);

global $IdiomaSitio;
$MensajesEventos = Comienzo($pageName, $IdiomaSitio);
?>
<script language="JavaScript" type="text/javascript">
	function mostrar_evento(id_evento){
		ventana=window.open("mostrar_evento.php?id_evento="+id_evento, "MostrarEvento", "dependent=yes,toolbar=no, width=530 ,height=450,scrollbars=yes");
	}
</script>
<?
$conditionsEventos = array("Id_Pedido" => $pedidoCompleto["Id"]);

$eventosPedido = $servicesFacade->getEventosCompletosAgrupados($conditionsEventos,$tablaEventos);
//$eventosPedido = $servicesFacade->getEventosCompletos($conditionsEventos,$tablaEventos);
?>

<!-- Lista de Eventos -->
<br/>
<table border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC" width="100%">
<?	//si no hay eventos para el pedido 
if (count($eventosPedido) == 0){ ?>
		<tr align="center" bgcolor="#0099FF">
	    	<td height="20" colspan="8" class="style18" align="center">
	    		<?=$MensajesEventos["mensaje.pedidoSinEventos"];?>
	    	</td>
		</tr>
<? 
}else{ ?>
		<tr align="center" bgcolor="#0099FF">
	    	<td height="20" colspan="8" class="style18" align="center">
	    		<?=$MensajesEventos["mensaje.eventosDelPedido1"];?>
	    	</td>
		</tr>
	    <tr align="center" valign="middle" class="style23">
			<td height="20">&nbsp;</td>
			<td height="20">&nbsp;</td>
			<td class="style29" width="70"><?=  $MensajesEventos["tf-4"]; ?></td>
			<td class="style29" width="120"><?= $MensajesEventos["tf-5"]; ?></td>
			<td class="style29" width="120"><?= $MensajesEventos["tf-6"]; ?></td>
			<td class="style29" width="120"><?= $MensajesEventos["campo.descripcion"]; ?></td>
			<td class="style29" width="180">&nbsp;</td>
		</tr>
		
<?		//para cada uno de los eventos

		foreach ($eventosPedido as $key =>$arraySolicitudes){
			$first=true;
			$alt= count($arraySolicitudes);
				    	
			foreach ($arraySolicitudes as $eventoPedido){			
				
				if ($rol_usuario == ROL__USUARIO && $eventoPedido["Es_Privado"] == 1){
					//no muestro los eventos privados a los usuarios comunes
					$alt--;
					continue;
				}
				
				$style="font-size:10px;";
				if($eventoPedido["vigente"] == 0) 
					$style .= "background-color:#DDE7EE;color:#999999;"; 
				else 
					$style .= "background-color:#d8d8d8;color:#000000;";
				?>
				<tr align="center" valign="middle" class="style23" >
					<?if($first){
						$first=false;
						?>
						<td class="style18" bgcolor="#0099FF" rowspan="<?=$alt?>">
							<?	//$key=0 es un evento del pedido que no es solicitud. $key<>0 tiene el valor del id de un evento solicitud
								/*if($key==0)
									echo $MensajesEventos["mensaje.eventosDelPedido1"];
								else
									echo "Solicitud";*/
							?> 
						</td>
					<?}?>
					<td width="20" height="20">
						<a href="javascript:mostrar_evento(<? echo $eventoPedido["Id"]; ?>)">
							<img src="../images/mas.gif" border="0" width="9" height="9">
						</a>
					</td>
					<td height="20" style="<?=$style?>"><?= $eventoPedido["Fecha"]; ?></td>
					<td height="20" style="<?=$style?>"><?= TraduccionesUtils::Traducir_Evento($VectorIdioma,$eventoPedido["Codigo_Evento"]); ?></td>
					<td height="20" style="<?=$style?>">
						<? if((!empty($eventoPedido["Apellido_Operador"]))||(!empty($eventoPedido["Nombre_Operador"]))) 
							echo $eventoPedido["Apellido_Operador"].", ".$eventoPedido["Nombre_Operador"];
						else
							echo $MensajesEventos["valor.operadorRemoto"]; 
						?>
					</td>
					<td height="20" style="<?=$style?>">
						<?= PedidosUtils::describirEvento($eventoPedido);?>
					</td>
					<td align="right" class="buttons" style="<?=$style?>" >
						<?
						if ($mostarOperaciones && $eventoPedido["vigente"]==1 && $tablaEventos == "eventos"){
							switch ($eventoPedido["Codigo_Evento"]) {
								case EVENTO__A_SOLICITADO:
									//si es una solicitud local, puedo registrar la recepcion manualmente
									if($pedidoCompleto["Estado"]==ESTADO__SOLICITADO){
										if ($eventoPedido["destino_remoto"] == 0){?>
												<a  style="border-left: none; border-right: none;" href="javascript:registrar_recepcion(<?=$eventoPedido["Id"]?>,'<?=$eventoPedido["Id_Pedido"]?>')"><img src="../images/arrow_right.gif" ><?= $MensajesEventos["link.registrarRecepcion"];?></a>
										<?}else{?>
										 		<a  style="border-left: none; border-right: none;" href="javascript:revisar_solicitud('<?=$eventoPedido["Id_Instancia_Celsius"]?>','<?=$eventoPedido["Id_Pedido_Remoto"]?>')"><img src="../images/arrow_right.gif" ><?= $MensajesEventos["link.revisarSolicitud"];?></a>
										 		<a  style="border-left: none; border-right: none;" href="javascript:reclamar_solicitud(<?=$eventoPedido["Id"]?>,'<?=$eventoPedido["Id_Pedido"]?>')"><img src="../images/arrow_right.gif" ><?= $MensajesEventos["link.reclamarPedido"];?></a>
										<?}?>
										 		<a style="border:none;"  href="javascript:cancelar_solicitud(<?=$eventoPedido["Id"]?>)" ><img src="../images/arrow_right.gif" ><?= $MensajesEventos["link.cancelarSolicitud"];?></a>
									<?}
									break;
								case EVENTO__A_RECIBIDO:
								case EVENTO__A_AUTORIZADO_A_BAJARSE_PDF: ?>
									<a style="border:none;"  href="javascript:cancelar_recepcion('<?=$eventoPedido["Id_Pedido"]?>')"><img src="../images/arrow_right.gif" ><?= $MensajesEventos["link.cancelarRecepcion"];?></a>
									<? break;
								case EVENTO__A_INTERMEDIO_POR_NT: 
									if ($pedidoCompleto["Estado"]==ESTADO__PENDIENTE_LLEGADA_NT){
									?>
									<a style="border:none;" href="javascript:registrar_recepcion(<?=$eventoPedido["Id"]?>,'<?=$eventoPedido["Id_Pedido"]?>')"><img src="../images/arrow_right.gif" ><?= $MensajesEventos["link.registrarRecepcion"];?></a>
									<a style="border:none;" href="javascript:reclamar_solicitud(<?=$eventoPedido["id_evento_origen"]?>,'<?=$eventoPedido["Id_Pedido"]?>')"><img src="../images/arrow_right.gif" ><?= $MensajesEventos["link.rechazarRecepcion"];?></a>
									<?}
									break;
								case EVENTO__A_ESPERA_DE_CONF_OPERADOR: ?>
									<a  style="border:none;"  href="javascript:confirmar_operador(<?=$eventoPedido["Id"]?>,<?=EVENTO__CONFIRMADO_POR_OPERADOR?>,'<?=$eventoPedido["Id_Pedido"]?>')"><img src="../images/arrow_right.gif" ><?= $MensajesEventos["link.confirmacionOperador"];?></a>	
									<? break;
								case EVENTO__A_RECLAMADO_POR_USUARIO:
									?>
									<a  style="border:none;"  href="javascript:visar_reclamo(<?=$eventoPedido["Id"]?>)"><img src="../images/arrow_right.gif" ><?= $MensajesEventos["link.visarReclamo"];?></a>	
									<?
									break;
								default:
									break;
							}
						}?>
					</td>
				</tr>
			<? } 
		}
   } ?>
</table>