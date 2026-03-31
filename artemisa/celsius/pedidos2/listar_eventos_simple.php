<?php
/**
 * @param string $id_pedido
 * @param int $codigo_evento
 * @param string $tablaEventos?
 */
$pageName= "eventos";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);

global $IdiomaSitio;
$MensajesEventos = Comienzo($pageName, $IdiomaSitio);

require_once "../layouts/top_layout_popup.php";
//TODO agregar esta pantalla a las traducciones
?>

<script language="JavaScript" type="text/javascript">
	function mostrar_evento(id_evento){
		ventana=window.open("mostrar_evento.php?id_evento="+id_evento, "Evento" + id_evento, "dependent=yes,toolbar=no, width=530 ,height=450,scrollbars=yes");
	}
</script>

<?
if (empty($tablaEventos))
	$tablaEventos = "eventos";
	
$conditionsEventos = array("Id_Pedido" => $id_pedido, "Codigo_Evento" => $codigo_evento);
$eventosPedido = $servicesFacade->getEventosCompletos($conditionsEventos,$tablaEventos);

?>
<!-- Lista de eventos -->

<table class="table-list" border="0" align="center" cellpadding="1" cellspacing="1" width="100%">
	<? if (count($eventosPedido) == 0){ ?>
		<tr>
	    	<td colspan="4" class="table-list-top">
	    		<?=$MensajesEventos["mensaje.pedidoSinEventos"];?>
	    	</td>
		</tr>
	<? }else{ ?>
		<tr>
	    	<td colspan="4" class="table-list-top">
	    		<?= $MensajesEventos["mensaje.eventosDelPedido1"]." ".TraduccionesUtils::Traducir_Evento($VectorIdioma,$codigo_evento)." ".$MensajesEventos["mensaje.eventosDelPedido2"]." ".$id_pedido;?>
	    	</td>
		</tr>
		<tr align="center" valign="middle" class="style23">
			<th>&nbsp;</th>
			<th><?= $MensajesEventos["tf-4"]; ?></th>
			<th><?= $MensajesEventos["tf-6"]; ?></th>
			<th><?= $MensajesEventos["cf-12"]; ?></th>
		</tr>
	    <?
		foreach ($eventosPedido as $eventoPedido){?>
			<tr>
				<td>
					<a href="javascript:mostrar_evento(<? echo $eventoPedido["Id"]; ?>)">
						<img src="../images/mas.gif" border="0" width="9" height="9">
					</a>
				</td>
				<td><? echo $eventoPedido["Fecha"]; ?></td>
				<td><? echo $eventoPedido["Apellido_Operador"].",".$eventoPedido["Nombre_Operador"]; ?></td>
				<td><? echo $eventoPedido["Observaciones"]; ?></td>
			</tr>
		<? } ?>
   <? } ?>
</table>
<?require_once "../layouts/base_layout_popup.php";?>