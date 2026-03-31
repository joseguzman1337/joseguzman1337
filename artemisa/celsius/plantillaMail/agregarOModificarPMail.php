<?
$pageName = "mail.plantilla2";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);

require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

if (!empty($plantilla)){
	if (empty($id_plantilla))
		$id_plantilla = 0;
}elseif (empty($id_plantilla)){
	$id_plantilla = 0;
	$plantilla = array('Denominacion' => "", 'Cuando_Usa' => 0,'Texto' => "");
}else{
	$plantilla = $servicesFacade->getPlantilla(array ('Id' => $id_plantilla));	
}
?>
<script language="JavaScript" type="text/javascript">
	function validar_plantilla(){
		if (!document.getElementsByName("Denominacion").item(0).value){
			alert("<?=$Mensajes["error.campo_denominacion_incompleto"]?>");
			return false;
		}
		if (!document.getElementsByName("Texto").item(0).value){
			alert("<?=$Mensajes["error.campo_texto_incompleto"]?>");
			return false;
		}
		
		return true;
	}
</script>
  
<form method="POST" name="form1" action="guardarPlantillaMail.php" onsubmit="return validar_plantilla();" >
	<input type="hidden" name="id_plantilla" value="<?=$id_plantilla;?>">
	
<table width="70%" class="table-form" align="center" cellpadding="3" cellspacing="1">
	<tr>
		<td colspan="2" class="table-form-top-blue"><?=$Mensajes["tf-1"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["campo.denominacion"];?></th>
		<td><input name="Denominacion" type="text" size="58" value="<?=$plantilla['Denominacion']; ?>"></td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-2"]; ?></th>
		<td>
			<select size="1" name="Cuando_Usa" style="width:365px">
				<?
				$traducciones_eventos = TraduccionesUtils::Traducir_Eventos($VectorIdioma) + TraduccionesUtils::Traducir__Eventos_Mails($VectorIdioma);
				$traducciones_eventos[0]=$Mensajes["campo.cuando_usa.ninguno"];
				foreach($traducciones_eventos as $codigo_evento => $traduccion){?>
					<option value="<?=$codigo_evento?>" <?if ($codigo_evento == $plantilla['Cuando_Usa']) echo "selected";?>>
						<?=$traduccion?>
					</option>
				<?}?>                           
            </select>	
		</td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-3"]; ?></th>
		<td><textarea rows="8" name="Texto" cols="55"><?=$plantilla['Texto']; ?></textarea></td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td>
			<input value="<? if (!empty($id_plantilla))  echo $Mensajes["botc-2"]; else echo $Mensajes["botc-1"]; ?>" type="submit" >
        	<input type="reset" value="<?=$Mensajes["bot-3"]; ?>" >
		</td>
	</tr>
</table>

</form>
<? 
require "../layouts/base_layout_admin.php";?>