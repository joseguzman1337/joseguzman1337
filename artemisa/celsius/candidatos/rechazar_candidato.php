<?php
/**
 * @param int $id_candidato
 */
$pageName= "candidatos2";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
require_once "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);
?>

<form method="POST" name="form1">
	<input type="hidden" name="id_candidato" value="<?= $id_candidato; ?>" />
	
<table width="80%" border="0" cellpadding="2" cellspacing="2" class="table-form" align="center">
	<tr>
		<td colspan="2" class="table-form-top-blue">
			<img src="../images/square-lb.gif" width="8" height="8" />
			<?= $Mensajes["tf-1"]; ?>
		</td>
	</tr>

	<?
	$candidato = $servicesFacade->getCandidato($id_candidato);
	if (isset($conMail) || isset($sinMail)){
		if (isset($conMail)){
			$usuarioSesion = SessionHandler::getUsuario();
			$envio_mail = $servicesFacade->enviar_mail($candidato["EMail"],$asunto,$cuerpo_mail, 0,$id_candidato,$usuarioSesion["Id"]);
			
			if($envio_mail===false){
				$mensaje_error = "Error enviando email / Failed sending email";
				$excepcion = new Celsius_Exception($mensaje_error);
				require "../common/mostrar_error.php";
			}
			
			$Leyenda = $Mensajes["tf-2"];
		}else
			$Leyenda = $Mensajes["tf-3"];
		$resModificacion = $servicesFacade->modificarCandidato(array("rechazados"=> 2,"Id"=> $id_candidato));
		if (is_a($resModificacion, "Celsius_Exception")){
			die ("error");
		}
		?>
		<tr>
			<td><? echo $Leyenda; ?><br/>
				<a href="../candidatos/listar_candidatos.php" >&nbsp;<? echo $Mensajes["h-2"]; ?></a>				
			</td>
		</tr>
	<?
	}else{
		//debe seleccionar la plantilla y cargar los datos para registrar el rechazo del candidato
		$conditionsPlantillas = array();
		if (empty ($id_plantilla))
			$conditionsPlantillas["Cuando_Usa"] = 101;
		else
			$conditionsPlantillas["Id"] = $id_plantilla;
		$plantilla = $servicesFacade->getPlantilla($conditionsPlantillas);
		$id_plantilla = $plantilla["Id"];
		$cuerpo_mail = $servicesFacade->reemplazar_variables_plantilla($plantilla["Texto"],$candidato);
		?>
	
		<tr>
			<th><? echo $Mensajes["et-1"]; ?></th>
			<td>	
				<select size="1" name="id_plantilla" OnChange="document.forms.form1.submit();">
					<?
					$plantillas = $servicesFacade->getPlantillas();
					foreach($plantillas as $plantI){?>
						<option value="<?= $plantI["Id"]; ?>" <? if ($plantI["Id"] == $id_plantilla) echo "selected"; ?>>
							<?= $plantI["Denominacion"]; ?>
						</option>
					<?}?>
				</select>
			</td>
		</tr>
		<tr>
			<th><?= $Mensajes["et-2"] ?></th>
			<td><?= $candidato["EMail"] ?></td>
		</tr>
		<tr>
			<th><?= $Mensajes["et-3"] ?></th>
			<td><input type="text" name="asunto" size="51" value="<?= $plantilla["Denominacion"]; ?>" /></td>
		</tr>
		<tr>
			<th><?= $Mensajes["et-4"] ?></th>
			<td><textarea rows="8" cols="48" name="cuerpo_mail"><?= $cuerpo_mail; ?></textarea></td>
		</tr>
		<tr>
			<th><?= $Mensajes["et-4"] ?></th>
			<td>
				<input type="submit" name="conMail" value="<?= $Mensajes["bot-2"]; ?>" />
				<input type="submit" name="sinMail" value="<?= $Mensajes["bot-3"]; ?>" />
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center">
				<a href="../candidatos/listar_candidatos.php">&nbsp;<?= $Mensajes["h-2"]; ?></a>
			</td>
		</tr>
		
	<? } ?>
</table>
</form>

<? require_once "../layouts/base_layout_admin.php" ?>