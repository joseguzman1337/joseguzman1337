<?php
/**
 * @param array(int) $ListaUsuarios
 * @param int id_plantilla?
 * @param int $numero_pedidos?
 */
$pageName="listaCorreo";
require_once "../common/includes.php";
require_once "../utils/StringUtils.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);
   
require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

$ListaUsuarios = $_REQUEST["ListaUsuarios"];
$plantillasMail = $servicesFacade->getPlantillas();
if (empty($id_plantilla)){
	$id_plantilla = 5;
}
$plantillaSeleccionada = $servicesFacade->getPlantilla(array("Id"=>$id_plantilla));

?>
<script language="JavaScript">
	
	tabla_plantillas = new Array;
	<?
	$i = 0;
	foreach ($plantillasMail as $plantilla) {?>
		var p = new Object();
		p.Id='<?=$plantilla["Id"]?>';
		p.Denominacion='<?=StringUtils::getSafeString($plantilla["Denominacion"])?>';
		p.Texto = "<?= StringUtils::getSafeString($plantilla["Texto"])?>";
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
		else
			cambiar_Plantilla();
	}
	
	function cambiar_Plantilla(){
		var listaPlantillas = document.getElementsByName("id_plantilla").item(0);
		plantilla = tabla_plantillas[listaPlantillas.selectedIndex];
		document.forms.form1.texto_mail.value = plantilla.Texto;
		document.forms.form1.asunto_mail.value = plantilla.Denominacion;
	}
		
	function envial_mails(){
		var lista_usuarios = document.forms.form1.ListaUsuarios;
		for (i=0; i<lista_usuarios.length; i++){
			lista_usuarios.options[i].selected = true;
		}
		lista_usuarios.name="ListaUsuarios[]";
		document.forms.form1.submit();
	}
		
	</script>
<form name="form1" action="enviar_mails_submit.php">
	<? if (!empty($numero_pedidos)){?>
		<input type="hidden" name="numero_pedidos" value="<?=$numero_pedidos;?>" />
	<?}?>
	
<table  border="0" cellpadding="1" cellspacing="1" align="center" class="table-form">
	<tr>
    	<td class="table-form-top-blue" colspan="2">
			<img src="../images/square-w.gif" width="8" height="8"> 
			<? echo $Mensajes["tf-1"]; ?>
		</td>
	</tr>
	<tr>
	    	<th><?=$Mensajes["tf-8"]; ?></th>
	      	<td>
	      		<select name="ListaUsuarios" size="15" multiple style="width:98%">
		      		<?
		      		
		      		$usuarios = $servicesFacade->getObjectsIn("usuarios", $ListaUsuarios);
		      		foreach ($usuarios as $usuario_mail){?>
		      			<option value="<? echo $usuario_mail["Id"]; ?>"><?= $usuario_mail["Apellido"].", ". $usuario_mail["Nombres"]; ?></option>
		      		<?}?>
	      		</select>
	      	</td>
	  	</tr>
	  	<tr>
	    	<th><?=$Mensajes["tf-4"]; ?></th>
	      	<td><?= count($ListaUsuarios);?></td>
	  	</tr>
	  	
		<tr>
	    	<th><?=$Mensajes["et-1"]; ?></th>
	      	<td><select size="1" name="id_plantilla" OnChange="cambiar_Plantilla()" style="width:98%"></select></td>
	  	</tr>
		
		
		<tr>
		    <th><? echo $Mensajes["et-2"]; ?></th>
		    <td><input type="text" name="asunto_mail" size="48" value="" ></td>
	    </tr>
	    <tr>
	    	<th><? echo $Mensajes["et-3"]; ?></th>
	    	<td><textarea rows="10" cols="45" name="texto_mail"></textarea></td>
	    </tr>
	    <tr>
	    	<th>&nbsp;</th>
	    	<td><input type="button" value="<?= $Mensajes["bot-2"]; ?>" onclick="envial_mails();"></td>
	    </tr>
</table>
</form>
	    
<script language="JavaScript" type="text/javascript">
	generarPlantilla(<?=$id_plantilla;?>);
</script>

<? require "../layouts/base_layout_admin.php" ?>