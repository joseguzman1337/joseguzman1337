<?php
$pageName= "dependencias";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__ADMINISTADOR);

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName, $IdiomaSitio);

if (empty($popup))
	require "../layouts/top_layout_admin.php";
else
	require "../layouts/top_layout_popup.php";

if (!empty($idDependencia)) {
	$dependencia = $servicesFacade->getDependencia($idDependencia);
	$esCentralizado = $dependencia["esCentralizado"];
	
} else {
	$dependencia=array("Nombre" =>"","Abreviatura" =>"","Direccion" =>"","Es_LibLink" =>0,"Hipervinculo1" =>"","Hipervinculo2" =>"","Hipervinculo3" =>"",
					"Telefonos" =>"","Comentarios" =>"","Codigo_Pais"=>0, "Codigo_Institucion"=>0);
	if (!empty($Codigo_Institucion))
		$dependencia["Codigo_Institucion"] = $Codigo_Institucion;
	$idDependencia = 0;
	$esCentralizado = 0;
}

if (!empty($dependencia["Codigo_Institucion"])) {
	$institucion= $servicesFacade->getInstitucion($dependencia["Codigo_Institucion"]);
	$dependencia["Codigo_Pais"]= $institucion["Codigo_Pais"];
}

$mostrar_elemento = array("paises","instituciones");
require "../utils/pidui.php";

?> 

<script language="JavaScript" type="text/javascript">
	function validar_dependencia(){
		if (document.getElementsByName("Codigo_Pais").item(0).value == 0){
			alert("<?=$Mensajes["error.campo_pais_incompleto"]?>");
			return false;
		}
		
		if (document.getElementsByName("Codigo_Institucion").item(0).value == 0){
			alert("<?=$Mensajes["error.campo_institucion_incompleto"]?>");
			return false;
		}
		if (!document.getElementsByName("nombre").item(0).value){
			alert("<?=$Mensajes["error.campo_nombre_incompleto"]?>");
			return false;
		}
		document.getElementsByName('submitbtn').item(0).disabled= true;
		return true;
	}
	
	function limpiar(){
		document.forms[0].reset();
		generar_paises(0);
		generar_instituciones(0);
	}
	
	
</script>

<form action="dependenciaController.php" method="POST" onsubmit="return validar_dependencia();" >
  	<input type="hidden" name="esCentralizado" value="<?= $dependencia["esCentralizado"];?>" /> 
  	<input type="hidden" name="idDependencia" value="<?= $idDependencia;?>" />
	<? if (!empty($popup)){?>
		<input type="hidden" name="popup" value="<?= $popup?>" />
	<?}?>

<table width="70%" class="table-form" align="center" cellpadding="1" cellspacing="1">
	<tr>
		<td colspan="2" class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8"><?=$Mensajes["ec-1"]; ?>
		</td>
	</tr>

	<tr>
		<th><?= $Mensajes["tf-1"];?></th>
		<td>
			<select size="1" name="Codigo_Pais" <?if ($esCentralizado) echo "disabled"; ?> OnChange="generar_instituciones(0);" style="width:316px;">
			</select>
	   	</td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-2"];?></th>
	   	<td>
	   		<select size="1" name="Codigo_Institucion" <?if ($esCentralizado) echo "disabled"; ?>  style="width:316px;"></select>
		</td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-3"];?></th>
	   	<td>
	   		<input size="36" type="text" name="nombre" <?if ($esCentralizado) echo "readonly"; ?> value="<?= $dependencia["Nombre"]?>" />
	   	</td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-12"];?></th>
	   	<td>
	   		<input size="36" type="text" name="abreviatura" <?if ($esCentralizado) echo "readonly"; ?> value="<?= $dependencia["Abreviatura"]?>" />
	   	</td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-4"];?></th>
	   	<td>
	   		<input size="36" type="text" name="direccion" <?if ($esCentralizado) echo "readonly"; ?> value="<?= $dependencia["Direccion"]?>" />
	   	</td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-11"];?></th>
	   	<td>
	   		<input type="checkbox" name="Es_LibLink" <?if ($esCentralizado) echo "disabled"; ?>	<? if ($dependencia["Es_LibLink"]) echo "checked"?> />
	   	</td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-6"];?></th>
	   	<td>
	   		<input size="36" type="text" name="sitio_web1" <?if ($esCentralizado) echo "readonly"; ?> value="<?= $dependencia["Hipervinculo1"]?>" />
	   	</td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-7"];?></th>
	   	<td>
	   		<input size="36" type="text" name="sitio_web2" <?if ($esCentralizado) echo "readonly"; ?> value="<?= $dependencia["Hipervinculo2"]?>" />
	   	</td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-8"];?></th>
	   	<td>
	   		<input size="36" type="text" name="sitio_web3" <?if ($esCentralizado) echo "readonly"; ?> value="<?= $dependencia["Hipervinculo3"]?>" />
	   	</td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-9"];?></th>
	   	<td>
	   		<input size="36" type="text" name="telefonos" <?if ($esCentralizado) echo "readonly"; ?> value="<?= $dependencia["Telefonos"]?>" />
	   	</td>
	</tr>
	<tr>
		<th><?= $Mensajes["tf-10"];?></th>
		<td>
			<textarea rows="4" cols="42" name="comentarios"><?= $dependencia["Comentarios"]?></textarea>
		</td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td>
			<input type="submit" name="submitbtn" value="<?if (!empty($idDependencia)) echo $Mensajes["bot-2"]; else echo $Mensajes["bot-1"]?>" />
			<input type="button" value="<?= $Mensajes["bot-3"]?>" onclick="limpiar();"/>
		</td>
	</tr>	

</table>
</form>

<script language="JavaScript" type="text/javascript">
	listNames[0] = new Array();
	listNames[0]["paises"]="Codigo_Pais";
	listNames[0]["instituciones"]="Codigo_Institucion";

	<?
	echo "generar_paises(".$dependencia["Codigo_Pais"].");\n";
	echo "generar_instituciones(".$dependencia["Codigo_Institucion"].");\n";
	?>
</script>
<? 
if (empty($popup))
	require "../layouts/base_layout_admin.php";
else
	require "../layouts/base_layout_popup.php";
?>