<?
/**
 * @param int $id_plantilla?
 * 
 * @param int $id_usuario
 * 
 * @param int $id_candidato?
 * @param int $id_creador?
 * @param string id_pedido? --> $Numero_Paginas, $cita_pedido
 * @param int $Id_Evento?
 * 
 * @param string $direccion_destino
 * @param string $enviar_mail_submit?
 * @param string $Texto?
 * 
 * @param string $url_origen?
 */

$pageName="enviar_mail";
$embebido = !empty($embebido);

if (!$embebido){
	require_once "../common/includes.php";
	require_once "../layouts/top_layout_admin.php";
}
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

if (empty($id_plantilla)){
	$id_plantilla=0;
}

if (!empty ($id_usuario)) {
	$usuario = $servicesFacade->getUsuario($id_usuario);
	$id_candidato = 0;
}elseif (!empty ($id_candidato)) {
	$id_usuario = 0;
	$usuario = $servicesFacade->getCandidato($id_candidato);
}

if (!empty($id_creador) && $id_creador != $id_usuario){
	$creador = $servicesFacade->getUsuario($id_creador);
}

if (isset($enviar_mail_submit) && !empty($direccion_destino)){
	
	$campos = array();
	if (isset($id_pedido)){
		if (!empty($Numero_Paginas))
			$campos["paginas"] = $Numero_Paginas;
		if (!empty($cita_pedido))
			$campos["cita"] = $cita_pedido;
		$campos["Id_Pedido"]=$id_pedido;
	}else{
		$id_pedido = 0;
	}
		
	$Texto = $servicesFacade->reemplazar_variables_plantilla($Texto, $usuario, $campos);
	
	$usuarioSesion = SessionHandler::getUsuario();
	$mail_enviado = $servicesFacade->enviar_mail($direccion_destino, $Asunto,$Texto,$id_usuario,$id_candidato,$usuarioSesion["Id"],$id_pedido);
	if($mail_enviado===false){
		$mensaje_error = "Error enviando email / Failed sending email";
		$excepcion = new Celsius_Exception($mensaje_error);
		require "../common/mostrar_error.php";
	}
	
	if (isset($Id_Evento))
  	  	$res = $servicesFacade->modificarEventos(array("Id_Correo" => $mail_enviado),array("Id" => $Id_Evento));
  	  		
	if (isset ($Corrige_Direccion) && $Corrige_Direccion == "ON") {
		$servicesFacade->modificarUsuario(array ("EMail" => $direccion_destino,"Id" => $id_usuario));
	}
	?>
	<table class="table-form" border="0" cellspacing="1" cellpadding="2">
		<tr>
	    	<td colspan="2" class="table-form-top-blue"><?=$Mensajes["titulo.mailsEnviados"];?></td>
	    </tr>
		<tr>
	    	<th><?=$Mensajes["ec-1"]; ?></th>
	    	<td><?= $direccion_destino ?></td>
	    </tr>
	 	<tr>
	    	<th><?=$Mensajes["ec-3"]; ?></th>
	    	<td><?= $Asunto ?></td>
	  	</tr>
	  	<tr>
	  		<th><?=$Mensajes["campo.texto"];?></th>
	   		<td><?=$Texto ?></td>
	  	</tr>
		<tr>
		   	<th>&nbsp;</th>
		   	<td>
		   	  	<?if (!empty($url_origen)){?>
					<input type="button" value="<?=$Mensajes["boton.volver"];?>" onclick="location.href='../<?= $url_origen?>';"/>
				<?}else{?>	
		   			<input type="button" value="<?=$Mensajes["boton.cerrar"];?>" onclick="self.close();" id="boton_close" style="visibility:hidden;"/>
		   		<?}?>
		   		
		   		<input type="button" onclick="location.href='../usuarios2/seleccionar_usuario.php?popup=0&url_destino=mail/enviar_mail2.php';" 
		   			value="<?=$Mensajes["h-2"];?>"/>
		   	</td>
		</tr>
	</table>
		<script language="JavaScript" type="text/javascript">
		    setTimeout("self.close();",6000);
		    if (window.opener)
		    	document.getElementById("boton_close").style.visibility = "visible";
		</script>
	<?
}else{
	$direccion_destino = $usuario['EMail'];
	if (!empty($creador))
		// se le manda el email al creador del pedido. Posiblemente un bibliotecario
		$direccion_destino .= "," .$creador['EMail'];
		
	$plantillasMail = $servicesFacade->getPlantillas();
	if (empty($id_plantilla)){
		$id_plantilla = 0;
		$plantillaSeleccionada = $plantillasMail[0];
	}else{
		$plantillaSeleccionada = $servicesFacade->getPlantilla(array("Id"=>$id_plantilla));
	} 
	?>
	<script language="JavaScript">
	
		tabla_plantillas = new Array;
		<?
		$i = 0;
		foreach ($plantillasMail as $plantilla) {?>
			var p = new Object();
			p.Id='<?=$plantilla["Id"]?>';
			p.Denominacion='<?=$plantilla["Denominacion"]?>';
			p.Texto = "<?= str_replace(array("\r\n", "\n", "\r"),'\n',addslashes($plantilla["Texto"]))?>";
			tabla_plantillas[<?=$i++?>]=p;
		<?}?>
		
		function generarPlantilla(id_plantilla_seleccionada){
			var listaPlantillas = document.getElementsByName("id_plantilla").item(0);
			listaPlantillas.length = 0;
		    for (i=0; i < tabla_plantillas.length; i++){             	
				plantilla=tabla_plantillas[i];
				listaPlantillas.options[listaPlantillas.length]=new Option(plantilla.Denominacion,plantilla.Id);
				if (id_plantilla_seleccionada == plantilla.Id)
					listaPlantillas.selectedIndex = i;
			}
			if (id_plantilla_seleccionada == 0)
				listaPlantillas.selectedIndex = 0;
		}
		
		function cambiar_Plantilla(){
			var listaPlantillas = document.getElementsByName("id_plantilla").item(0);
			plantilla = tabla_plantillas[listaPlantillas.selectedIndex];
			document.forms.form1.Texto.value = plantilla.Texto;
			document.forms.form1.Asunto.value = plantilla.Denominacion;
		}
	</script> 
	
	<form method="get" name="form1" action="../mail/enviar_mail2.php">
		<input type="hidden" name="id_usuario" value="<?= $id_usuario ?>" />
		<input type="hidden" name="id_creador" value="<?= $id_creador ?>" />
		
		<? if (!empty($id_candidato)){?>
			<input type="hidden" name="id_candidato" value="<?= $id_candidato ?>" />
		<?}?>
		<? if (!empty($id_pedido)){?>
			<input type="hidden" name="id_pedido" value="<?= $id_pedido ?>" />
			<? if (!empty($cita_pedido)){?>
				<input type="hidden" name="cita_pedido" value="<?= $cita_pedido?>" />
			<?}
			if (!empty($Numero_Paginas)){?>
				<input type="hidden" name="Numero_Paginas" value="<?= $Numero_Paginas ?>" />
			<?}
		}?>
		<input type="hidden" name="url_origen" value="<?= (empty($url_origen))?"":$url_origen ?>" />
		<? if (!empty($Id_Evento)){?>
			<input type="hidden" name="Id_Evento" value ="<? echo $Id_Evento; ?>">
		<?}?>
		
		
	<table class="table-form">
	    <tr>
	    	<td colspan="2" class="table-form-top-blue">&nbsp;</td>
	    </tr>
		<tr>
			<th><?= $Mensajes["tf-1"] ?></th> 
			<td><?= $usuario['Apellido'].",".$usuario['Nombres'] ?></td>
	    </tr>
		<tr>
			<th><?=$Mensajes["ec-1"]; ?></th>
	        <td><input type="text" name="direccion_destino" size="51" value="<?=$direccion_destino?>"></td>
	    </tr>
		<tr>
	    	<th>&nbsp;</th>
	    	<td><input type="checkbox" name="Corrige_Direccion" value="ON"><? echo $Mensajes["tf-3"]; ?></td>
	  	</tr>
		<tr>
	    	<th><?=$Mensajes["ec-2"]; ?></th>
	      	<td><select size="1" name="id_plantilla" OnChange="cambiar_Plantilla()"></select></td>
	  	</tr>
		<tr>
		    <th><? echo $Mensajes["ec-3"]; ?></th>
		    <td><input type="text" name="Asunto" size="51" value="<?=$plantillaSeleccionada['Denominacion'] ?>" ></td>
	    </tr>
	    <tr>
	    	<th><? echo $Mensajes["ec-4"]; ?></th>
	    	<td><textarea rows="10" cols="45" name="Texto"><?=$plantillaSeleccionada['Texto']?></textarea></td>
	    </tr>
	    <tr>
	    	<th>&nbsp;</th>
	    	<td><input type="submit" name="enviar_mail_submit" value="<? echo $Mensajes["bot-1"]; ?>"/></td>
	    </tr>
	</table>
	</form>
	<script language="JavaScript" type="text/javascript">
		generarPlantilla(<?=$id_plantilla ?>);
	</script>
<?
}
if (!$embebido){
	require_once "../layouts/base_layout_admin.php";
}
?>