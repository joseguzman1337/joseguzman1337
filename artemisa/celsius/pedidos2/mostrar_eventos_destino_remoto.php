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
<?
$conditions = array("Id_Pedido" => $id_pedido,"Id_Instancia_Celsius"=>$id_instancia_remota);
$eventosDestinoRemoto = $servicesFacade->getEventosDestinoRemoto($conditions);

?>
<!-- Lista de eventos -->
<br/>
<table border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC" width="98%">
	<? if (count($eventosDestinoRemoto) == 0){ ?>
		<tr align="center" bgcolor="#0099FF">
	    	<td height="20" colspan="8" class="style18" align="center">
	    		<?= $MensajesEventos["mensaje.pedidoSinEventos"];?>
	    	</td>
		</tr>
	<? }else{ ?>
		<tr align="center" bgcolor="#0099FF">
	    	<td height="20" colspan="8" class="style18" align="center">
	    		<?= $MensajesEventos["campos.eventosRemotos"];?>
	    	</td>
		</tr>
	    <tr align="center" valign="middle" class="style23">
			<td class="style29" width="70px"><? echo $MensajesEventos["tf-4"]; ?></td>
			<td class="style29" width="120px"><? echo $MensajesEventos["tf-5"]; ?></td>
			<td class="style29" width="120px"><? echo $MensajesEventos["tf-6"]; ?></td>
			<td class="style29" ><? echo $MensajesEventos["tf-7"]; ?>-<? echo $MensajesEventos["tf-8"]; ?>-<? echo $MensajesEventos["tf-9"]; ?></td>
		</tr>
	    <?
		foreach ($eventosDestinoRemoto as $evento){?>
			<tr align="center" valign="top" class="style23">
				<td height="20"><?=$evento["Fecha"]; ?></td>
				<td height="20"><?=TraduccionesUtils::Traducir_Evento($VectorIdioma,$evento["Codigo_Evento"]); ?></td>
				<td height="20"><?=$evento["Apellido_Operador"].",".$evento["Nombre_Operador"]; ?></td>
				<td height="20"><?=$evento["Nombre_Pais"]; ?> - <?=$evento["Nombre_Institucion"]; ?> - <?=$evento["Nombre_Dependencia"]; ?></td>
				
			</tr>
		<? } ?>
   <? } ?>
</table>