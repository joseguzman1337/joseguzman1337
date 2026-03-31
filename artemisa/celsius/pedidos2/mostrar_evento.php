<?php
/**
 * @param string id_evento
 */
$pageName = "eventos1";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__USUARIO);
require "../layouts/top_layout_popup.php";

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);


$tablaEventos = "eventos";
$eventoCompleto = $servicesFacade->getEventoCompleto($id_evento, $tablaEventos);
if (empty($eventoCompleto)){
	$tablaEventos = "evhist";
	$eventoCompleto = $servicesFacade->getEventoCompleto($id_evento, $tablaEventos);
	if (empty($eventoCompleto)){
		$tablaEventos = "evanula";
		$eventoCompleto = $servicesFacade->getEventoCompleto($id_evento, $tablaEventos);
	}
}
if (empty($eventoCompleto)){
	die($Mensajes["warning.eventoNoExiste1"]." ".$id_evento." ".$Mensajes["warning.eventoNoExiste2"]);
}

?>
<table width="90%" align="center" cellpadding="3" cellspacing="1" border="0"  class="table-form">
	<tr>
		<td class="table-form-top" colspan="2">
			<?= $Mensajes["ec-1"]; ?>: <?= $eventoCompleto["Id_Pedido"]; ?>	
		</td>
	</tr>
	<tr>
		<th width="120"><?= $Mensajes["tf-1"]; ?></th>
		<td><?= TraduccionesUtils::Traducir_Evento($VectorIdioma,$eventoCompleto["Codigo_Evento"]); ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-5"]; ?></th>
		<td><?= $eventoCompleto["Apellido_Operador"]. ", " . $eventoCompleto["Nombre_Operador"] ?></td>
	</tr>
	
	<? if ($eventoCompleto["Codigo_Evento"] == EVENTO__A_SOLICITADO || $eventoCompleto["Codigo_Evento"] == EVENTO__A_RECIBIDO){?>
		<tr>
			<th><?= $Mensajes["tf-2"]; ?></th>
			<td><?= $eventoCompleto["Nombre_Pais"]; ?></td>
		</tr>
		<tr>
			<th><?= $Mensajes["tf-3"]; ?></th>
			<td><?= $eventoCompleto["Nombre_Institucion"]; ?></td>
		</tr>
		<tr>
			<th><?= $Mensajes["tf-4"]; ?></th>
			<td><?= $eventoCompleto["Nombre_Dependencia"]; ?></td>
		</tr>
		<tr>
			<th><?= $Mensajes["campo.unidad"]; ?></th>
			<td><?= (!empty($eventoCompleto["Nombre_Unidad"]))?$eventoCompleto["Nombre_Unidad"]:""; ?></td>
		</tr>
		<tr>
			<th><?= $Mensajes["campo.instanciaCelsius"]; ?></th>
			<td><?= (!empty($eventoCompleto["Id_Instancia_Celsius"]))?$eventoCompleto["Id_Instancia_Celsius"]:""; ?></td>
		</tr>
	<? } ?>
	<tr>
		<th><?= $Mensajes["tf-6"]; ?></th>
		<td><input type="checkbox" disabled <? if($eventoCompleto["Es_Privado"]==1) { echo "checked"; } ?> ></td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-7"]; ?></th>
		<td><?= $eventoCompleto["Fecha"] ?></td>
	</tr>
	<? if ($eventoCompleto["Codigo_Evento"] == EVENTO__A_SOLICITADO){?> 
		<tr>
			<th><?= $Mensajes["tf-8"]; ?></th>
			<td><?= $eventoCompleto["Numero_Paginas"] ?></td>
		</tr>
	<? }
	
	$rol_usuario = SessionHandler::getRolUsuario();
	$usuario = SessionHandler::getUsuario();
	if ($rol_usuario == ROL__ADMINISTADOR || $usuario["Id"] == $eventoCompleto["Operador"]){?>
		<tr>
			<th><?= $Mensajes["tf-11"]; ?></th>
			<td><?= $eventoCompleto["Observaciones"] ?></td>
		</tr>
	<? } ?>
	
	<tr>
		<th><?= $Mensajes["campo.eventoNT"];?></th>
		<td><input type="checkbox" disabled <? if($eventoCompleto["destino_remoto"]==1) { echo "checked"; } ?> /></td>
	</tr>
	<? if($eventoCompleto["destino_remoto"]==1){?>
		<tr>
			<th><?= $Mensajes["campo.idPedidoRemoto"];?></th>
			<td><?= $eventoCompleto["Id_Pedido_Remoto"] ?></td>
		</tr>
	<? } ?>
	<tr>
		<th><?= $Mensajes["campo.vigente"];?></th>
		<td><input type="checkbox" disabled <? if($eventoCompleto["vigente"]==1) { echo "checked"; } ?> ></td>
	</tr>

	<? if (!empty($eventoCompleto["motivo_anulacion"])){?>
		<tr>	
			<th><?= $Mensajes["campo.motivoAnulacion"];?></th>
			<td><?= $eventoCompleto["motivo_anulacion"] ?></td>
		</tr>
		<tr>
			<th><?= $Mensajes["campo.operadorAnulacion"];?></th>
			<td><?= $eventoCompleto["operador_anulacion"] ?></td>
		</tr>
		<tr>
			<th><?= $Mensajes["campo.fechaAnulacion"];?></th>
			<td><?= $eventoCompleto["fecha_anulacion"] ?></td>
		</tr>
	<? } ?>
	
	<? if (!empty($eventoCompleto["Id_Correo"])){?>
		<tr>
			<th><?= $Mensajes["campo.correo"];?></th>
			<td>
				<b><?= $Mensajes["campo.correo.asunto"];?>:</b> <?= $eventoCompleto["Asunto_Mail"] ?><br/>
				<b><?= $Mensajes["campo.correo.direccion"];?>:</b> <?= $eventoCompleto["Direccion_Mail"] ?><br/>
				<b><?= $Mensajes["campo.correo.texto"];?>:</b> <?= $eventoCompleto["Texto_Mail"] ?>
			</td>
		</tr>
	<? } ?>
	<tr>
		<td colspan="2" style="text-align:center">
			<input type="button" value="<?= $Mensajes["boton.cerrar"];?>" name="B2" OnClick="javascript:self.close()" />
	   	</td>
	</tr>
</table>

<? require "../layouts/base_layout_popup.php"; ?>