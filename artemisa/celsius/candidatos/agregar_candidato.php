<?php
/**
 *	Alta o modificación de candidatos
 *  
 * 	@ param int $id_candidato
 * 
 */
require "../layouts/top_layout_admin.php";
global $IdiomaSitio;
$pageName="candidatos1";
$Mensajes = Comienzo ($pageName,$IdiomaSitio);  

$es_creacion= empty($id_candidato);

if (!$es_creacion){
	$candidato = $servicesFacade->getCandidato($id_candidato);}
else{
	$candidato = array("Id" => "", "Apellido" => "", "Nombres" => "", "Codigo_Pais" => 0, "Codigo_Institucion" => 0,
	"Codigo_Dependencia" => 0, "Codigo_Unidad" => 0,"Direccion" => "", "Codigo_Localidad" => 0, "EMail" => "", "Telefonos" => "", 
	"Codigo_Categoria" => 0, "Comentarios" => "", "Otro_Pais" => "","Otra_Institucion" => "","Otra_Dependencia" => "",
	"Otra_Unidad" => "","Otra_Localidad" => "","Otra_Categoria" => "");
}

$conditionsInstituciones = array("habilitado_crear_usuarios"=>1);
$mostrar_elemento = array("instituciones","dependencias","unidades","localidades");
require "../utils/pidui.php";
?>
<script language="JavaScript" type="text/javascript">
	function verificar_email(campoName){
		var campo = document.getElementsByName(campoName).item(0);
		if ((campo.value.indexOf('@',0)== -1) || (campo.value.indexOf('.',0)== -1)){
			campo.value = "<? echo $Mensajes["me-17"];?>";
			return false;
		}else{
			return true;
		}
	}
	function verificar_obligatorio(campoName){
		var campo = document.getElementsByName(campoName).item(0);
		if ((!campo.value) || campo.value.substring(0,3)=="***"){
			campo.value = "<? echo $Mensajes["me-1"];?>";
			return false;
		}else{
			return true;
		}
	}
	function verificar_edit_o_lista(campoEditName, campoListaName, msgErrorBlancos, msgErrorAmbos, obligatorio){
		var campoLista = document.getElementsByName(campoListaName).item(0);
		var campoEdit = document.getElementsByName(campoEditName).item(0);
		
		if (campoLista.value!=0 && campoEdit.value){
			alert (msgErrorAmbos)
            return false;
		}else if (obligatorio && (campoLista.value==0) && (!campoEdit.value)){
			alert (msgErrorBlancos);
			return false;
		} else 
			return true;		
	}
	function validar_campos(){
		valor1 = verificar_obligatorio("Apellido") && verificar_obligatorio("Nombres") && verificar_obligatorio("EMail")
			&& verificar_obligatorio("Telefonos") && verificar_email("EMail");
		valor1 = valor1 && verificar_edit_o_lista("Otro_Pais", "Codigo_Pais","<?= $Mensajes["me-3"]?>","<?= $Mensajes["me-4"]?>",true);
		valor1 = valor1 && verificar_edit_o_lista("Otra_Institucion", "Codigo_Institucion","<?= $Mensajes["me-5"]?>","<?= $Mensajes["me-6"]?>",true);
		valor1 = valor1 && verificar_edit_o_lista("Otra_Dependencia", "Codigo_Dependencia","<?= $Mensajes["me-7"]?>","<?= $Mensajes["me-8"]?>",true);
		valor1 = valor1 && verificar_edit_o_lista("Otra_Unidad", "Codigo_Unidad","<?= $Mensajes["me-9"]?>","<?= $Mensajes["me-10"]?>",false);
		valor1 = valor1 && verificar_edit_o_lista("Otra_Localidad", "Codigo_Localidad","<?= $Mensajes["me-15"]?>","<?= $Mensajes["me-16"]?>",false);
		valor1 = valor1 && verificar_edit_o_lista("Otra_Categoria", "Codigo_Categoria","<?= $Mensajes["me-11"]?>","<?= $Mensajes["me-12"]?>",true);
		
		if (valor1){
			document.getElementsByName("bAgregar").item(0).disabled = true;
			return true;
		}else
			return false;
	}
	
	function limpiar(){
		document.forms[0].reset();
		generar_paises(0);
		generar_instituciones(0);
		generar_dependencias(0);
		generar_unidades(0);
		generar_localidades(0);
	}
		function abrir_popup(url){
		ventana=window.open(url, "", "dependent=yes, toolbar=no, width=530, height=380, scrollbars=yes");
	}
	function agregar_pais(){
		abrir_popup('../paises/modificarOAgregarPais.php?popup=1', "");
	}
	function agregar_institucion(){
		if (document.getElementsByName('Codigo_Pais').item(0).value == 0 ){
			alert('<?=$Mensajes["warning.faltaPais"];?>')
			return false;
		}
		abrir_popup('../instituciones/modificarOAgregarInstitucion.php?popup=1&Codigo_Pais=' + document.getElementsByName('Codigo_Pais').item(0).value, "");
	}
	function agregar_dependencia(){
		if (document.getElementsByName('Codigo_Institucion').item(0).value == 0 ){
			alert('<?=$Mensajes["warning.faltaInstitucion"];?>')
			return false;
		}
		abrir_popup('../dependencias/modificarOAgregarDependencia.php?popup=1&Codigo_Institucion=' + document.getElementsByName('Codigo_Institucion').item(0).value, "");
	}
	function agregar_unidad(){
		if (document.getElementsByName('Codigo_Dependencia').item(0).value == 0 ){
			alert('<?=$Mensajes["warning.faltaDependencia"];?>')
			return false;
		}
		abrir_popup('../unidades/modificarOAgregarUnidad.php?popup=1&Codigo_Dependencia=' + document.getElementsByName('Codigo_Dependencia').item(0).value, "");
	}
</script>
  
<form method="post" action="candidatoController.php" onsubmit="return validar_campos();">
	<input type="hidden" name="id_candidato" value="<?= $candidato["Id"]?>"/>
	
<table width="75%"  border="0" align="center" cellpadding="2" cellspacing="1" class="table-form">
	<tr>
		<td colspan="2" class="table-form-top-blue"><?= $Mensajes["et-3"]; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-1"]; ?></th>
		<td><input type="text" name="Apellido" value="<?=$candidato["Apellido"]?>" size="50" /></td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-2"]?></th>
		<td><input type="text" name="Nombres" value="<?=$candidato["Nombres"]?>" size="50" /></td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-4"]?></th>
		<td>
			<select size="1" name="Codigo_Pais" OnChange="generar_instituciones(0);generar_localidades(0);" style="width:316px;">
	    	</select>
	    	<input type="button" onclick="agregar_pais();" value="<?=$Mensajes["boton.agregarPais"];?>" />
		</td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-5"]?></th>
		<td><input type="text" name="Otro_Pais" value="<?=$candidato["Otro_Pais"]?>" size="50" /></td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-6"]?></th>
		<td>
			<select size="1" name="Codigo_Institucion" OnChange="generar_dependencias(0)" style="width:316px;">
	       	</select>
	       	<input type="button" onclick="agregar_institucion();" value="<?=$Mensajes["boton.agregarInstitucion"];?>" />
		</td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-7"]?></th>
		<td><input type="text" name="Otra_Institucion" value="<?=$candidato["Otra_Institucion"]?>" size="50" /></td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-8"]?></th>
		<td>
			<select size="1" name="Codigo_Dependencia" OnChange="generar_unidades(0)" style="width:316px;">
	      	</select>
	      	<input type="button" onclick="agregar_dependencia();" value="<?=$Mensajes["boton.agregarDependencia"];?>" />
		</td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-9"]?></th>
		<td><input type="text" name="Otra_Dependencia" value="<?=$candidato["Otra_Dependencia"]?>" size="50" /></td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-10"]?></th>
		<td>
			<select name="Codigo_Unidad" style="width:316px;">
			</select>
			<input type="button" onclick="agregar_unidad();" value="<?=$Mensajes["boton.agregarUnidad"];?>" />
		</td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-11"]?></th>
		<td><input type="text" name="Otra_Unidad" value="<?=$candidato["Otra_Unidad"]?>" size="50" /></td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-14"]?></th>
		<td><input type="text" name="Direccion" value="<?=$candidato["Direccion"]?>" size="50" /></td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-15"]?></th>
		<td>
			<select size="1" name="Codigo_Localidad" style="width:316px;">
	      	</select>
		</td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-16"]?></th>
		<td><input type="text" name="Otra_Localidad" value="<?=$candidato["Otra_Localidad"]?>" size="50" /></td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-3"]?></th>
		<td><input type="text" name="EMail" value="<?=$candidato["EMail"]?>" size="50" /></td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-17"]?></th>
		<td><input type="text" name="Telefonos" value="<?=$candidato["Telefonos"]?>" size="50" /></td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-12"]?></th>
		<td>
			<?
			$categorias = $servicesFacade->getAllObjects("tab_categ_usuarios");
			?>
			<select size="1" name="Codigo_Categoria" style="width:316px;">
				<? foreach ($categorias as $categoria){ ?>
					<option value="<?=$categoria["Id"]?>" <? if ($categoria["Id"] == $candidato["Codigo_Categoria"]) echo "selected"?>>
						<?=$categoria["Nombre"]?>
					</option>
				<? } ?>
	      	</select>
		</td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-13"]?></th>
		<td><input type="text" name="Otra_Categoria" value="<?=$candidato["Otra_Categoria"]?>" size="50" /></td>
	</tr>
	<tr>
		<th><?=$Mensajes["ec-18"]?></th>
		<td><textarea name="Comentarios" rows="5" cols="47"><?=$candidato["Comentarios"]?></textarea></td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td>
			<input type="submit" name="bAgregar" value="<?= $Mensajes["bot-1"]?>"/>
			<input type="button" value="<?= $Mensajes["bot-2"]?>" onClick="limpiar();"/>
		</td>
	</tr>
</table>

</form>

<script language="JavaScript" type="text/javascript">
	listNames[0] = new Array();
	listNames[0]["paises"]="Codigo_Pais";
	listNames[0]["instituciones"]="Codigo_Institucion";
	listNames[0]["dependencias"]="Codigo_Dependencia";
	listNames[0]["unidades"]="Codigo_Unidad";
	listNames[0]["localidades"]="Codigo_Localidad";

	<?
	echo "generar_paises(".$candidato["Codigo_Pais"].");\n";
	echo "generar_instituciones(".$candidato["Codigo_Institucion"].");\n";
	echo "generar_dependencias(".$candidato["Codigo_Dependencia"].");\n";
	echo "generar_unidades(".$candidato["Codigo_Unidad"].");\n";
	echo "generar_localidades(".$candidato["Codigo_Localidad"].");\n";
	?>
</script>

<? require "../layouts/base_layout_admin.php" ?>