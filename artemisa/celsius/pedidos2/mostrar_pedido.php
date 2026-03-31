<?php
/**
 * @param String $id_pedido
 */

$pageName = "pedidos";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__USUARIO);
$rol_usuario = SessionHandler::getRolUsuario();

if (empty($popup))
	$popup = 0;

$mostarOperaciones = ($popup == 0) && ($rol_usuario == ROL__ADMINISTADOR);

if ($popup == 1)
	require "../layouts/top_layout_popup.php";
else
	require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);
?>
<script language="JavaScript" type="text/javascript">

	function anular_entrega(id_pedido){
		if(confirm ("<?= $Mensajes["confirm.anularEntrega"];?>"))
			ventana=window.open("anular_pedido_o_evento.php?id_pedido="+id_pedido+"&tipoAnulacion=eventoEntrega", "" , "dependent=yes,toolbar=no,width=530 ,height=380 , scrollbars=yes");
	}
	function anular_cancelacion(id_pedido){
		if(confirm ("<?= $Mensajes["confirm.anularEntrega"];?>"))
			ventana=window.open("anular_cancelacion.php?id_pedido="+id_pedido, "" , "dependent=yes,toolbar=no,width=530 ,height=380 , scrollbars=yes");
	}
	function anular_pedido(id_pedido){
		if(confirm ("<?= $Mensajes["confirm.anularPedido"];?> "+id_pedido+" ?"))
			ventana=window.open("anular_pedido_o_evento.php?id_pedido="+id_pedido+"&tipoAnulacion=pedido", "", "dependent=yes,toolbar=no,width=530 ,height=380, scrollbars=yes");
	}

	function cancelar_solicitud(id_evento){
		if(confirm ("<?= $Mensajes["confirm.anularEvento"];?>"))
			ventana=window.open("anular_pedido_o_evento.php?id_evento=" + id_evento +"&tipoAnulacion=eventoSolicitud", "", "dependent=yes,toolbar=no,width=530 ,height=380, scrollbars=yes");
	}
	
	function cancelar_recepcion(id_pedido){
		if(confirm ("<?= $Mensajes["confirm.cancelarRecepcion"]?>"+" ?"))
			ventana=window.open("anular_pedido_o_evento.php?id_pedido=" + id_pedido +"&tipoAnulacion=eventoRecepcion", "", "dependent=yes,toolbar=no,width=530 ,height=380,scrollbars=yes");
	}


	function registrar_recepcion(id_solicitud, id_pedido){
		ventana=window.open("generar_evento.php?id_evento_origen="+id_solicitud+"&codigo_evento=<?= EVENTO__A_RECIBIDO ?>&id_pedido=" + id_pedido, "", "dependent=yes,toolbar=no,width=530 ,height=380 , scrollbars=yes");
	}
	
	function reclamar_solicitud(id_solicitud, id_pedido){
		ventana=window.open("generar_evento.php?id_evento_origen="+id_solicitud+"&codigo_evento=<?=EVENTO__A_RECLAMADO_POR_OPERADOR?>&id_pedido=" + id_pedido, "Generacion", "dependent=yes,toolbar=no,width=530 ,height=380 , scrollbars=yes");
	}
								
	function confirmar_operador(id_espera_conf_operador, id_pedido){
		ventana=window.open("generar_evento.php?id_evento_origen="+id_espera_conf_operador+"&codigo_evento=<?= EVENTO__CONFIRMADO_POR_OPERADOR ?>&id_pedido=" + id_pedido, "Generacion", "dependent=yes,toolbar=no,width=530 ,height=380 , scrollbars=yes");
	}
	function pasar_a_busqueda(id_pedido){
		ventana=window.open("pasar_a_busqueda.php?id_pedido=" + id_pedido, "Pasar a Busqueda", "dependent=yes,toolbar=no,width=530 ,height=380 , scrollbars=yes");
	}
	function cambiar_operador(id_pedido){
		ventana=window.open("cambiar_operador_pedido.php?id_pedido="+id_pedido, "", "toolbar=no,width=530 ,height=200, scrollbars=yes");
	}
	
	function cambiar_tipo_material(id_pedido){
   		ventana=window.open("cambiar_tipo_material.php?id_pedido="+id_pedido, "", "dependent=yes,toolbar=no,width=530 ,height=250, scrollbars=yes");
	}
	
	function visar_reclamo(id_evento){
		ventana=window.open("anular_pedido_o_evento.php?id_evento=" + id_evento +"&tipoAnulacion=eventoReclamadoUsuario", "Visar Reclamo", "dependent=yes,toolbar=no,width=530 ,height=380,scrollbars=yes");
	}
	
	function mostrarElemento(mostrar, ocultar , mispan , operacion){
			
		document.getElementById(mostrar).style.position = 'relative';
		document.getElementById(mostrar).style.visibility = 'visible';
			
		document.getElementById(ocultar).style.position = 'absolute';
		document.getElementById(ocultar).style.visibility = 'hidden';
		
		if (operacion == 0){	
			document.getElementById(mispan).style.position = 'relative';
			document.getElementById(mispan).style.visibility = 'visible';
		}else{
			document.getElementById(mispan).style.position = 'absolute';
			document.getElementById(mispan).style.visibility = 'hidden';
		}
	}
	
	function mostrar(mostrar, ocultar , mispan , operacion){ 
			if(document.getElementById(mostrar)  != null) {
						mostrarElemento(mostrar, ocultar , mispan , operacion);
					
			}
	}

	function volver(){
		if (history.length > 1)
			history.back();
		else
			location.href="../index.php";
		}
</script>

<?
$id_pedido = $_REQUEST["id_pedido"];

if (empty($id_pedido)){
	echo $Mensajes["warning.faltaIdPedido"];
	exit;
}

$tablaPedido = "pedidos";
$tablaEventos = "eventos";
$pedidoCompleto = $servicesFacade->getPedidoCompleto($id_pedido, $tablaPedido);
if (empty($pedidoCompleto)){
	$tablaPedido = "pedhist";
	$tablaEventos = "evhist";
	$pedidoCompleto = $servicesFacade->getPedidoCompleto($id_pedido, $tablaPedido);
	if (empty($pedidoCompleto)){
		$tablaPedido = "pedanula";
		$tablaEventos = "evanula";
		$pedidoCompleto = $servicesFacade->getPedidoCompleto($id_pedido, $tablaPedido);
	}
}
if (empty($pedidoCompleto)){
	echo $Mensajes["warning.pedidoInexistente"]." : ".$id_pedido;
	exit;
}

require_once "funciones_mostrar_pedido.php";

function pedidoContieneEvento($id_pedido,$tablaEventos,$codigo_evento){
	global $servicesFacade;
	$cantEventos = $servicesFacade->getCount($tablaEventos,array("Codigo_Evento" => $codigo_evento, "Id_Pedido" => $id_pedido, "vigente" => 1));
	return ($cantEventos != 0);
}
?>
<table width="100%" border="0" >
<tr valign="top">
	<td width="75%">
		<table align="left" cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr> 
				<td class="style18" bgcolor="#0099CC"  height="20" >
					<b><?=$Mensajes["tablaDePedido.$tablaPedido"];?></b>
				</td>
			</tr>
			<tr bgcolor="#ECECEC">
				<td><? mostrar_pedido_detallado($VectorIdioma,$pedidoCompleto,$Mensajes,$rol_usuario,true);?></td>
			</tr>
			<? devolverBusqueda($id_pedido, $Mensajes); ?>
		</table>
	</td>

<? if ($mostarOperaciones){ ?>
	<td valign="top">
		<!-- INICIO OPCIONES 1 -->
		<table width="178" border="0" align="center" cellpadding="0" cellspacing="0" class="buttons">
			<tr>
				<td colspan="2" width="180">
					<table width="178" border="0" cellpadding="0" cellspacing="0" background="../images/opc_02.gif">
					<tr>
						<td width="24"><img src="../images/opc_01.gif" width="24" height="26"/></td>
						<td class="style18"><?= $Mensajes["titulo.opciones"];?></td>
						<td width="12" align="right"><img src="../images/opc_03.gif" width="12" height="26" hspace="0" vspace="0" align="right"/></td>
					</tr>
					</table>
				</td>
			</tr>
			
			<? if($tablaPedido == "pedhist" && ($pedidoCompleto["Estado"] == ESTADO__DESCAGADO_POR_EL_USUARIO ||
					$pedidoCompleto["Estado"] == ESTADO__ENTREGADO_IMPRESO)){?>
				<tr>
					<td>
						<a href="javascript:anular_entrega('<?=$id_pedido?>')">
						<img src="../images/arrow_right.gif" /><?= $Mensajes["link.anularEntrega"];?></a>
					</td>
				</tr>
				
			<?}?>
			<? if(($tablaPedido == "pedhist") && ($pedidoCompleto["Estado"] == ESTADO__CANCELADO)){?>
				<tr>
					<td>
						<a href="javascript:anular_cancelacion('<?=$id_pedido?>')">
						<img src="../images/arrow_right.gif" /><?=$Mensajes["link.anularCancelacion"];?></a>
					</td>
				</tr>
			<?}
	
			
			if ($tablaPedido!="pedidos"){?>
				<tr>
					<td>
						<a href="javascript:volver();">
							<img src="../images/arrow_right.gif" /><?= $Mensajes["link.volver"];?>
						</a>
					</td>
				</tr>
			<?}else{?>
		   		<tr>
			   		<td>
					 	<a href="javascript:modificar_pedido('<?= $id_pedido ?>')">
				 		<img src="../images/arrow_right.gif" /><? echo $Mensajes["bot-2"]; ?></a>
					</td>
			   </tr>
			
			   <?if($pedidoCompleto["Estado"] != ESTADO__PENDIENTE){ ?>
				   <tr>
					    <td>
							<a href="javascript:mostrar_busquedas('<?= $id_pedido ?>')">
							<img src="../images/arrow_right.gif" /><? echo $Mensajes["bot-7"]; ?></a>
						</td>
				   </tr>
				<?}else{ 
			   		//ESTADO__PENDIENTE 
				?>
					<tr>
						<td>
							<a href="javascript:generar_evento(<?= EVENTO__A_BUSQUEDA ?>,'<?=$id_pedido?>')" >
							<img src="../images/arrow_right.gif" /><?= $Mensajes["link.pasarABusqueda"];?></a>
						</td>
					</tr>
				<?}
				
				//El pedido se puede solicitar
				if (($pedidoCompleto["Estado"] == ESTADO__BUSQUEDA) || ($pedidoCompleto["Estado"] == ESTADO__SOLICITADO)){?>
					<tr>
						<td>
							<a href="javascript:generar_evento(<?=EVENTO__A_SOLICITADO?>,'<?=$id_pedido?>')">
							<img src="../images/arrow_right.gif" /><?= $Mensajes["link.solicitarPedido"];?></a>
						</td>
					</tr>
				<?}
			
				//El pedido esta listo. Se puede entregar
				if (($pedidoCompleto["Estado"] == ESTADO__RECIBIDO) || ($pedidoCompleto["Estado"] == ESTADO__LISTO_PARA_BAJARSE)){
					if ($pedidoCompleto["Estado"] == ESTADO__RECIBIDO)
						$eventoEntrega = EVENTO__A_ENTREGADO_IMPRESO;
					else //ESTADO__LISTO_PARA_BAJARSE
						$eventoEntrega = EVENTO__A_PDF_DESCARGADO;
					?>
					<tr>
						<td>
							<a href="javascript:generar_evento(<?= $eventoEntrega ?>,'<?=$id_pedido?>')">
							<img src="../images/arrow_right.gif" /><?= $Mensajes["link.registrarEntrega"];?></a>
						</td>
					</tr>
				<?}?>
			
				<tr>
					<td>
						<a href="javascript:generar_evento(<?= EVENTO__A_OBSERVACION ?>,'<?=$id_pedido?>')" >
						<img src="../images/arrow_right.gif" /><?= $Mensajes["link.registrarObservaciones"];?></a>
					</td>
				</tr>
				
				<?if (pedidoContieneEvento($id_pedido, $tablaEventos, EVENTO__A_ESPERA_DE_CONF_USUARIO)){?>
					<tr>
						<td>
							<a href="javascript:generar_evento(<?= EVENTO__CONFIRMADO_POR_USUARIO ?>,'<?=$id_pedido?>')" >
							<img src="../images/arrow_right.gif" /><?= $Mensajes["link.confirmarPorUsuario"];?></a>
						</td>
					</tr>
				<?}?>
				
				<tr>
					<td>
						<a href="javascript:volver();">
							<img src="../images/arrow_right.gif" /><?= $Mensajes["link.volver"];?>
						</a>
					</td>
				</tr>
			
			</table>
		<!-- FIN OPCIONES 1-->
		
		<!-- INICIO OPCIONES 2 -->
		<br>
		<table width="178" border="0" align="center" cellpadding="0" cellspacing="0" class="buttons" background="../images/opc_02.gif">
			<tr>
				<td width="24">
					<img width="15" height="15" class="img-menu" src="../images/boton-menos.jpg" id='buttonMenos6' onclick="mostrar('buttonMas6' ,'buttonMenos6', 'tabla_opc2' , 1);" style='visibility:hidden;position:absolute;'>
					<img width="15" height="15" class="img-menu" src="../images/boton-mas.jpg" id='buttonMas6' onclick="mostrar('buttonMenos6' , 'buttonMas6' , 'tabla_opc2' , 0);" >
				</td>
				<td class="style18"><?= $Mensajes["titulo.masOpciones"];?></td>
				<td width="12" align="right"><img src="../images/opc_03.gif" width="12" height="26" hspace="0" vspace="0" align="right"/></td>
			</tr>
		</table>
		
		<table width="178" border="0" align="center" cellpadding="0" cellspacing="0"  class="buttons" id='tabla_opc2' style='visibility:hidden;position:absolute;'>
			<?//Pedido listo para bajarse, le muestro el link para descarga
			if ($pedidoCompleto["Estado"] == ESTADO__LISTO_PARA_BAJARSE){?>
			<tr>
				<td>
					<a href="javascript: window.location.href='../files/download_archivos_aszip.php?id_pedido=<? echo $id_pedido; ?>'">
					<img src="../images/arrow_right.gif" /><?= $Mensajes["link.bajarPedidoZip"];?></a>
				</td>
			</tr>
			<?}
				
			//Solicita la confirmacion del usuario	
			if(!pedidoContieneEvento($id_pedido, $tablaEventos, EVENTO__A_ESPERA_DE_CONF_USUARIO)){?>
			<tr>
				<td>
					<a href="javascript:generar_evento(<?= EVENTO__A_ESPERA_DE_CONF_USUARIO ?>,'<?=$id_pedido?>')" >
					<img src="../images/arrow_right.gif" /><?= $Mensajes["link.esperarConfirmacionUsuario"];?></a>
				</td>
			</tr>
			<?}?>
			
		    <tr>
				<td>
					<a href="javascript:cambiar_operador('<?=$id_pedido?>');">
					<img src="../images/arrow_right.gif" /><?= $Mensajes["link.cambiarOperador"];?></a>
				</td>
			</tr>
			<?
			if (!($pedidoCompleto["Estado"] == ESTADO__RECIBIDO) && !($pedidoCompleto["Estado"] == ESTADO__LISTO_PARA_BAJARSE)){
			
			?>
			<tr>
				<td>
					<a href="javascript:pasar_a_busqueda('<?=$id_pedido?>');">
					<img src="../images/arrow_right.gif" /><?= $Mensajes["link.pasarBusqueda"];?></a>
				</td>
			</tr>
			<?}?>
			<tr>
				<td>
					<a href="javascript:generar_evento(<?= EVENTO__A_CANCELADO_POR_OPERADOR ?>,'<?=$id_pedido?>')" >
					<img src="../images/arrow_right.gif" /><?= $Mensajes["link.cancelarPedido"];?></a>
				</td>
			</tr>
			<tr>
				<td>
					<a href="javascript:anular_pedido('<?= $id_pedido; ?>');">
					<img src="../images/arrow_right.gif" /> <?= $Mensajes["link.anularPedido"];?></a>
				</td>
			</tr>
				
			<tr>
				<td>
					<a href="javascript:cambiar_tipo_material('<?= $id_pedido ?>');">
					<img src="../images/arrow_right.gif" /><?= $Mensajes["link.cambiarTipoMaterial"];?></a>
				</td>
			</tr>
		
		<!-- FIN OPCIONES 2-->
	
	<?}?>
	<!-- END if ($tablaPedido == "Pedido")-->
	</table>
	</td>
<?}else{ //del mostrar Operaciones ?>
	</tr>
	<tr bgcolor="#FFFFBF">
		<td  align="center">
			<?
			//muestra el menu de opciones para un operador/bibliotecario
			if ($rol_usuario < ROL__ADMINISTADOR){?>
				<input type="button" onclick="javascript:history.back();" value="<?= $Mensajes["link.volver"];?>" />
				<?if (($pedidoCompleto["Estado"] == ESTADO__LISTO_PARA_BAJARSE) && ($pedidoCompleto["Archivos_Totales"]!=$pedidoCompleto["Archivos_Bajados"])){?>
					<input type="button" onclick="window.location.href='../files/download_archivos_aszip.php?id_pedido=<? echo $id_pedido; ?>'" value="<?= $Mensajes["link.bajarPedidoZip"];?>" />
			   	<?}
				if (pedidoContieneEvento($id_pedido, $tablaEventos, EVENTO__A_ESPERA_DE_CONF_USUARIO)){?>
					<input type="button" onclick="generar_evento(<?= EVENTO__CONFIRMADO_POR_USUARIO ?>,'<?=$id_pedido?>');" value="<?= $Mensajes["link.confirmarPorUsuario"];?>" />
				<?}
			}?>
		</td>
	
<?}?>
	</tr>
	<tr>
		<td colspan="2">
			<? require "listar_eventos.php"; ?>
		</td>
	</tr>
</table>
<? if ($popup == 1){?>
	<center>
		<input type="button" onclick="javascript:self.close();" value="<?= $Mensajes["boton.cerrar"];?>"/>
	</center>
	<?
	require "../layouts/base_layout_popup.php";
}else
	require "../layouts/base_layout_admin.php";
?>