<?php
/**
 * @param int $id_candidato
 */
$pageName="candidatos1";
require "../layouts/top_layout_admin.php";
SessionHandler::validar_nivel_acceso(ROL__ADMINISTADOR);

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

if(empty($id_candidato)){
	$mensaje_error= "Candidate id is missing";
	$excepcion = new Application_Exception($mensaje_error);
	require "../common/mostrar_error.php";
}

$candidato = $servicesFacade->getCandidatoCompleto($id_candidato);
?>
<script language="JavaScript" type="text/javascript" src="../js/passwords.js"></script>
<script language="JavaScript">
	function corregir_candidato(id_candidato){
		location.href="agregar_candidato.php?id_candidato=" + id_candidato;
	}

	function rechazar_candidato(id_candidato){
		location.href="rechazar_candidato.php?id_candidato=" + id_candidato;
	}
	
	function validar_datos(){
		<?
		$aptoGuardado = ($candidato["Codigo_Pais"] != 0) && ($candidato["Codigo_Institucion"] != 0) &&($candidato["Codigo_Dependencia"] != 0)
						&& empty($candidato["Otra_Unidad"]) && ($candidato["Codigo_Categoria"] != 0) && empty($candidato["Otra_Localidad"]);
		if (!$aptoGuardado){?>
			alert("<?echo $Mensajes["mensaje.normalizacion"];?>");
			return false;
		<?}else{?>
			return true;
		<?}?>
	}

</script>
<? //La variable $error se setea en aceptar_candidato.php si es que ya existe ese "login" para el nuevo candidato 
   if (!empty($error)){?>
		<div align="center" class="mensaje-error">
			<?= $Mensajes["warning.usuarioExistente"];?>
		</div>
<?}?>
<form method="POST" name="form1" onsubmit="return validar_datos();" action="aceptar_candidato.php">
	<input type="hidden" name="id_candidato" value="<?= $id_candidato ?>"/>
	
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="table-form">
	<tr>
		<td class="table-form-top" colspan="2" > 
			<img src="../images/square-lb.gif" width="8" height="8"/>
			<?= $Mensajes["et-2"] ?>
		</td>
	</tr>
    <tr>
		<th><?= $Mensajes["ec-1"] ?></th>
		<td><?= $candidato["Apellido"] ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-2"] ?></th>
		<td><?= $candidato["Nombres"] ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-3"] ?></th>
		<td><?= $candidato["EMail"] ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-4"] ?></th>
		<td><? if ($candidato["Codigo_Pais"]==0){echo $Mensajes["oma-1"];} else {echo $candidato["Nombre_Pais"];} ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-5"] ?></th>
		<td><?= $candidato["Otro_Pais"] ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-6"] ?></th>
		<td><? if ($candidato["Codigo_Institucion"]==0){echo $Mensajes["ofe-1"];} else {echo $candidato["Nombre_Institucion"];} ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-7"] ?></th>
		<td><?= $candidato["Otra_Institucion"] ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-8"] ?></th>
		<td><? if ($candidato["Codigo_Dependencia"]==0){echo $Mensajes["ofe-1"];} else {echo $candidato["Nombre_Dependencia"];} ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-9"] ?></th>
		<td><?echo $candidato["Otra_Dependencia"] ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-10"] ?></th>
		<td><? if ($candidato["Codigo_Unidad"]==0){echo $Mensajes["ofe-1"];} else {echo $candidato["Nombre_Unidad"];} ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-11"] ?></th>
		<td><?= $candidato["Otra_Unidad"] ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-12"] ?></th>
		<td><? if ($candidato["Codigo_Categoria"]==0){echo $Mensajes["ofe-1"];} else {echo $candidato["Nombre_Categoria"];} ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-13"] ?></th>
		<td><?= $candidato["Otra_Categoria"] ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-14"] ?></th>
		<td><?= $candidato["Direccion"] ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-15"] ?></th>
		<td><? if ($candidato["Codigo_Localidad"]==0){echo $Mensajes["ofe-1"] ;} else {echo $candidato["Nombre_Localidad"];} ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-16"] ?></th>
		<td><?= $candidato["Otra_Localidad"] ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-17"] ?></th>
		<td><?= $candidato["Telefonos"] ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-18"] ?></th>
		<td><?= $candidato["Comentarios"] ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-21"] ?></th>
		<td>
			<?
			$formasEntrega = $servicesFacade->getAllObjects("forma_entrega");
			?>
			<select size="1" name="Codigo_FormaEntrega" style="width:316px;">
				<? foreach ($formasEntrega as $fe){ ?>
					<option value="<?=$fe["id"]?>">
						<?=$fe["nombre"]?>
					</option>
				<? } ?>
	      	</select>
		</td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-22"]?></th>
		<td><input type="text" name="Login" size="30" value="" /></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-23"]?></th>
		<td><input type="text" name="Password" size="30" value="" /></td>
	</tr>
	<tr>
		<th><?= $Mensajes["ec-26"]?></th>
		<td>
			<select name="Bibliotecario">
				<option value="0"><? echo $Mensajes["opcion.ninguno"];      ?></option>
				<option value="1"><? echo $VectorIdioma["Perfil_Biblio_1"]; ?></option>
				<option value="2"><? echo $VectorIdioma["Perfil_Biblio_2"]; ?></option>
				<option value="3"><? echo $VectorIdioma["Perfil_Biblio_3"]; ?></option>
			</select>
		</td>
	</tr>
	<tr >
		<td colspan="2" style="text-align:center">
			<input type="submit" value="<?= $Mensajes["bot-5"]?>" name="aprobar" />
			<input type="button" value="<?= $Mensajes["bot-6"]?>" name="coregir" OnClick="corregir_candidato(<?= $id_candidato ?>)" />
			<input type="button" value="<?= $Mensajes["bot-7"]?>" name="rechazar" OnClick="rechazar_candidato(<?= $id_candidato ?>)" />
		</td>
	</tr>

</table>

</form>
<script language="JavaScript" type="text/javascript">
	generar_password_con('<?= $candidato["Nombres"] ?>','<?= $candidato["Apellido"] ?>', 'Login', 'Password');
</script>
  
<? require "../layouts/base_layout_admin.php"; ?>