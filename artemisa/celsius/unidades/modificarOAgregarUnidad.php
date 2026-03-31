<?php
/**
 * $idUnidad?
 * 
 */
$pageName="unidades1";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName, $IdiomaSitio);

if (empty($popup))
	require "../layouts/top_layout_admin.php";
else
	require "../layouts/top_layout_popup.php";


if (!empty($idUnidad)){
	/*operacion de modificacion*/	
  	$unidad= $servicesFacade->getUnidad($idUnidad);
}else{
	$unidad = array("esCentralizado" => 0,"Nombre" => "","Direccion" => "", "Telefonos" => "", "Hipervinculo1" => "", "Hipervinculo2" => "","Hipervinculo3" => "", "Comentarios" => "", "Codigo_Pais"=>0, "Codigo_Institucion"=>0, "Codigo_Dependencia"=>0);
	if (!empty($Codigo_Dependencia))
		$unidad["Codigo_Dependencia"] = $Codigo_Dependencia;
	$idUnidad = 0;
	$esCentralizado = 0;
}

if (!empty($unidad["Codigo_Dependencia"])) {

	$dependencia= $servicesFacade->getDependencia($unidad["Codigo_Dependencia"]);
	$unidad["Codigo_Institucion"]= $dependencia["Codigo_Institucion"];

	$institucion= $servicesFacade->getInstitucion($unidad["Codigo_Institucion"]);
	$unidad["Codigo_Pais"]= $institucion["Codigo_Pais"];
}

$esCentralizado = ($unidad["esCentralizado"] == 1);

$mostrar_elemento = array("paises", "instituciones" , "dependencias");
require "../utils/pidui.php";	
?>
<script language="JavaScript" type="text/javascript">
	function validar_unidad(){
		if (document.getElementsByName("Codigo_Pais").item(0).value == 0){
			alert("<?=$Mensajes["error.campo_pais_incompleto"]?>");
			return false;
		}
		if (document.getElementsByName("Codigo_Institucion").item(0).value == 0){
			alert("<?=$Mensajes["error.campo_institucion_incompleto"]?>");
			return false;
		}
		if (document.getElementsByName("Codigo_Dependencia").item(0).value == 0){
			alert("<?=$Mensajes["error.campo_dependencia_incompleto"]?>");
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
		generar_dependencias(0);
	}
</script>
  
<form action="unidadController.php" method="POST" onsubmit="return validar_unidad();">
	<input type="hidden" name="idUnidad" value="<?=$idUnidad?>" />
	<? if (!empty($popup)){?>
		<input type="hidden" name="popup" value="<?= $popup?>" />
	<?}?>
	
<table width="70%" class="table-form" align="center" cellpadding="1" cellspacing="1">
	<tr>
		<td colspan="2" class="table-form-top-blue">
			<img src="../images/square-w.gif" width="8" height="8">
			<?= $Mensajes["tf-1"]; ?>
		</td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-1"];?></th>
	   	<td>
	   		<select  name="Codigo_Pais" <?if ($esCentralizado) echo "disabled"; ?> onChange="generar_instituciones(0)" size="1"  style="width:316px;">
	   		</select>
	   	</td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-2"];?></th>
		<td>
	   		<select  name="Codigo_Institucion" <?if ($esCentralizado) echo "disabled"; ?> onChange="generar_dependencias(0)"  style="width:316px;">
            </select>
        </td>
	</tr>
	<tr>
		<th><?= $Mensajes["et-3"];?></th>
	    <td>
	    	<select  name="Codigo_Dependencia" <?if ($esCentralizado) echo "disabled"; ?>  style="width:316px;" >
            </select>
	    </td>
	</tr>
	<tr>
		<th><?= $Mensajes["et-4"];?></th>
	    <td>
	    	<input size="36" type="text" name="nombre" <?if ($esCentralizado) echo "readonly"; ?> value="<?=$unidad["Nombre"]?>" />
	    </td>
	</tr>
	<tr>
		<th>
			<?= $Mensajes["et-5"];?>
		</th>
		<td>
			<input size="36" type="text" name="direccion" <?if ($esCentralizado) echo "readonly"; ?> value="<?=$unidad["Direccion"]?>" />
		</td>
	</tr>
	<tr>
		<th><?= $Mensajes["et-6"];?></th>
		<td>
			<input size="36" type="text" name="telefonos" <?if ($esCentralizado) echo "readonly"; ?> value="<?=$unidad["Telefonos"]?>" />
		</td>
	</tr>	
	<tr>
		<th><?= $Mensajes["et-8"];?></th>
		<td>
			<input size="36" type="text" name="sitio_web1" <?if ($esCentralizado) echo "readonly"; ?> value="<?=$unidad["Hipervinculo1"]?>" />
		</td>
	</tr>
	<tr>
		<th><?= $Mensajes["et-9"];?></th>
	   	<td>
	   		<input size="36" type="text" name="sitio_web2" <?if ($esCentralizado) echo "readonly"; ?> value="<?=$unidad["Hipervinculo2"]?>" />
	   	</td>
	</tr>
	<tr>
		<th><?= $Mensajes["et-10"];?></th>
		<td>
			<input size="36" type="text" name="sitio_web3" <?if ($esCentralizado) echo "readonly"; ?> value="<?if (isset($unidad)) echo $unidad["Hipervinculo3"]?>" />
		</td>
	</tr>
	<tr>
		<th><?= $Mensajes["et-11"];?></th>
	   	<td>
	   		<textarea  rows="4" cols="42" name="comentarios"><?=$unidad["Comentarios"]?></textarea>
	   	</td>
	</tr>
	<tr>
		<th>&nbsp;</th>
	   	<td>
	       <input type="submit" name="submitbtn"  value="<?if (!empty($idUnidad)) echo $Mensajes["boton.modificar_unidad"]; else echo $Mensajes["boton.crear_unidad"];?>" />
           <input type="button" value="<?= $Mensajes["boton.limpiar_campos"]?>" onClick="limpiar();"/>
		</td>
	</tr>	
</table>
</form>

<script language="JavaScript" type="text/javascript">
	listNames[0] = new Array();
	listNames[0]["paises"]="Codigo_Pais";
	listNames[0]["instituciones"]="Codigo_Institucion";
	listNames[0]["dependencias"]="Codigo_Dependencia";

	<?
	echo "generar_paises(".$unidad["Codigo_Pais"].");\n";
	echo "generar_instituciones(".$unidad["Codigo_Institucion"].");\n";
	echo "generar_dependencias(".$unidad["Codigo_Dependencia"].");\n";
	?>
</script>

<? 
if (empty($popup))
	require "../layouts/base_layout_admin.php";
else
	require "../layouts/base_layout_popup.php";
?>