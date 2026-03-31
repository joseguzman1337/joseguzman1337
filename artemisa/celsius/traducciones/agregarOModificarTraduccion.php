<?
$pageName = "traducciones";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);
require "../layouts/top_layout_popup.php";

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

$idioma = $servicesFacade->getIdioma($Codigo_Idioma,"Nombre");
$traduccion = $servicesFacade->getTraduccion($Codigo_Pantalla, $Codigo_Elemento, $Codigo_Idioma);

if (empty($traduccion)){
	$traduccion=array("Texto" => "", "Codigo_Pantalla" => $Codigo_Pantalla,"Codigo_Elemento" => $Codigo_Elemento,"Codigo_Idioma" => $Codigo_Idioma,"traduccion_completa" => 1);
	$esCreacion= 1;
}
else{
	$esCreacion= 0;
}
	

?>
<form name="form1" method="POST" action="guardar_traduccion.php"  >
	<input type="hidden" name="Codigo_Pantalla" value="<?= $Codigo_Pantalla; ?>" />
	<input type="hidden" name="Codigo_Elemento" value="<?= $Codigo_Elemento; ?>" />
	<input type="hidden" name="Codigo_Idioma" value="<?= $Codigo_Idioma; ?>" />
	<input type="hidden" name="es_creacion" value="<?= $esCreacion ?>" /> 
	

<table width="95%" align="center" cellpadding="2" cellspacing="1" class="table-form" >
	<tr>
    	<td colspan="2" class="table-form-top-blue">
    		<img src="../images/square-w.gif" width="8" height="8" />
    		<?=$Mensajes["et-1"];?>as
        </td>
    </tr>	
	<tr>
		<th><?= $Mensajes["ec-1"];?></th>
		<td><?= $Codigo_Pantalla; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-2"];?></th>
		<td><?= $Codigo_Elemento; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-3"];?></th>
		<td><?= $idioma["Nombre"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-4"];?></th>
		<td><textarea rows="4" name="Texto" cols="42"><?= $traduccion["Texto"]; ?></textarea></td>
	</tr>
	<tr>
		<th><?= $Mensajes["campo.traduccionCompleta"];?>?</th>
		<td>
			<input type="radio" name="traduccion_completa" value="1" <?if ($traduccion["traduccion_completa"] == 1) echo "checked";?>>
			<?= $Mensajes["mensaje.afirmacion"];?>
			
			<input type="radio" name="traduccion_completa" value="0" <?if ($traduccion["traduccion_completa"] == 0) echo "checked";?>>
			<?= $Mensajes["mensaje.negacion"];?>
		</td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td>
			<input type="submit" value="<? if (empty($traduccion)) echo $Mensajes["bot-1"]; else echo $Mensajes["bot-2"]; ?>" name="B1">
			<input type="reset" value="<?= $Mensajes["bot-3"];?>" name="B2"/>
		</td>
	</tr>
</table>
</form>
<script language="JavaScript" type="text/javascript">
	document.forms.form1.Texto.focus();
</script>

<? require "../layouts/base_layout_popup.php";?> 