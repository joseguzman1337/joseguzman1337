<?php
/**
 * @param int id_usuario
 */
 $pageName="usuarios2";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__BIBLIOTECARIO);
require "../layouts/top_layout_admin.php";

$rol_usuario = SessionHandler::getRolUsuario();

$usuarioSession = SessionHandler::getUsuario();

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);  

if (!empty($id_usuario)){
	//es la primera vez q se entra, es una modificacion
	$usuario = $servicesFacade->getUsuario($id_usuario);
}else{
	//es la primera vez q se entra, es una creacion
	$usuario = array("Id" => "","Apellido" => "", "Nombres" => "", "Login" => "", "Password" => "", "Codigo_Pais" => 0, "Codigo_Institucion" => 0,
	"Codigo_Dependencia" => 0, "Codigo_Unidad" => 0,"Direccion" => "", "Codigo_Localidad" => 0, "EMail" => "", "Telefonos" => "", 
	"Codigo_Categoria" => 0, "Codigo_FormaEntrega" => 0, "Personal" => 0, "Staff" => 0, "Orden_Staff"=> 0, "Cargo" => "", 
	"Bibliotecario" => 0, "Comentarios" => "");
}
$conditionsInstituciones = array("habilitado_crear_usuarios"=>1);
$mostrar_elemento = array("instituciones","dependencias","unidades","localidades");
require "../utils/pidui.php";
?>
<script language="JavaScript" type="text/javascript" src="../js/passwords.js"></script>
<script language="JavaScript" type="text/javascript">
	function validar(){
		var apellido= document.getElementsByName('Apellido').item(0).value;
		var nombres= document.getElementsByName('Nombres').item(0).value;
		var login= document.getElementsByName('Login').item(0).value;
		var password= document.getElementsByName('Password').item(0).value;
		var codigo_pais= document.getElementsByName('Codigo_Pais').item(0).value;
		var codigo_institucion= document.getElementsByName('Codigo_Institucion').item(0).value;
		
		if (apellido==''){
			alert('<?= $Mensajes["warning.faltaApellido"];?>');
			return false;
		}
		if (nombres==''){
			alert('<?= $Mensajes["warning.faltaNombres"];?>');
			return false;
		}
		if (login==''){
			alert('<?= $Mensajes["warning.faltaLogin"];?>');
			return false;
		}
		if (password==''){
			alert('<?= $Mensajes["warning.faltaPassword"];?>');
			return false;
		}
		if (codigo_pais==0){
			alert('<?= $Mensajes["warning.faltaPais"];?>');
			return false;
		}
		if (codigo_institucion==0){
			alert('<?= $Mensajes["warning.faltaInstitucion"];?>');
			return false;
		}
	
	    document.getElementsByName('submitbtn').item(0).disabled= true;			
		document.forms.form1.submit();
	}
</script>

    
<form method="post" name="form1" action="guardar_usuario.php">
	<input type="hidden" name="id_usuario" value="<?= $usuario["Id"]?>"/>
	
<table width="85%"  border="0" align="center" cellpadding="2" cellspacing="1" class="table-form">
	<tr>
		<td colspan="2" class="table-form-top-blue">&nbsp;<?= $Mensajes["titulo.agregarUsuario"];?></td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-1"]?></th>
		<td><input type="text" name="Apellido" value="<?=$usuario["Apellido"]?>" size="50" /></td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-2"]?></th>
		<td><input type="text" name="Nombres" value="<?=$usuario["Nombres"]?>" size="50" /></td>
	</tr>
	<tr>
		<th><?= $Mensajes["campo.login"];?></th>
		<td>
			<input type="text" name="Login" value="<?=$usuario["Login"]?>" size="20" />
			<input type="button" value="<?= $Mensajes["boton.generarLoginYPass"];?>" onclick="generar_password('Nombres','Apellido', 'Login', 'Password');"/>
		</td>
	</tr>
		<tr>
		<th><?= $Mensajes["campo.password"];?></th>
		<td><input type="text" name="Password" value="<?=$usuario["Password"]?>" size="20" /></td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-4"]?></th>
		<td>
		<? if ($rol_usuario==ROL__ADMINISTADOR){?>
			<select size="1" name="Codigo_Pais"  OnChange="generar_instituciones(0);generar_localidades(0);" style="width:316px;">
	    	</select>
	    	<?}else{?>
	     		<select size="1" name="Codigo_Pais" disabled OnChange="generar_instituciones(0);generar_localidades(0);" style="width:316px;">
	    	</select>
	     	<?}?>
		</td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-5"]?></th>
		<td>
		<? if ($rol_usuario==ROL__ADMINISTADOR){?>
			<select size="1" name="Codigo_Institucion"   OnChange="generar_dependencias(0)" style="width:316px;">
	       	</select>
	     	<?}else{?>
	     		<select size="1" name="Codigo_Institucion"  disabled OnChange="generar_dependencias(0)" style="width:316px;">
	       	</select>
	     	<?}?>
		</td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-6"]?></th>
		<td>
			<select size="1" name="Codigo_Dependencia" <? if (($usuarioSession['Bibliotecario']>TIPO__BIBLIOTECARIO_INSTITUCION)&& (($rol_usuario!=ROL__ADMINISTADOR))){echo "disabled";}?>  OnChange="generar_unidades(0)" style="width:316px;">
			</select>
		</td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-11"]?></th>
		<td>
		
			<select name="Codigo_Unidad" <? if (($usuarioSession['Bibliotecario']>TIPO__BIBLIOTECARIO_DEPENDENCIA)&&($rol_usuario!=ROL__ADMINISTADOR)){echo "disabled";}?> style="width:316px;">
			</select>
		
		</td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-7"]?></th>
		<td><input type="text" name="Direccion" value="<?=$usuario["Direccion"]?>" size="50" /></td>
	</tr>
	<tr>
		<th><?= $Mensajes["campo.localidad"];?></th>
		<td>
			<select size="1" name="Codigo_Localidad" style="width:316px;">
	      	</select>
		</td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-3"]?></th>
		<td><input type="text" name="EMail" value="<?=$usuario["EMail"]?>" size="50" /></td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-8"]?></th>
		<td><input type="text" name="Telefonos" value="<?=$usuario["Telefonos"]?>" size="50" /></td>
	</tr>
	<tr>
		<th><?=$Mensajes["et-9"]?></th>
		<td>
			<?
			$categorias = $servicesFacade->getAllObjects("tab_categ_usuarios");
			?>
			<select size="1" name="Codigo_Categoria" style="width:316px;">
				<? foreach ($categorias as $categoria){ ?>
					<option value="<?=$categoria["Id"]?>" <? if ($categoria["Id"] == $usuario["Codigo_Categoria"]) echo "selected"?>>
						<?=$categoria["Nombre"]?>
					</option>
				<? } ?>
	      	</select>
		</td>
	</tr>
	<tr>
		<th><?= $Mensajes["campo.formaDeEntrega"];?></th>
		<td>
			<?
			$formasEntrega = $servicesFacade->getAllObjects("forma_entrega");
			?>
			<select size="1" name="Codigo_FormaEntrega" style="width:316px;">
				<? foreach ($formasEntrega as $fp){ ?>
					<option value="<?=$fp["id"]?>" <? if ($fp["id"] == $usuario["Codigo_FormaEntrega"]) echo "selected"?>>
						<?=$fp["nombre"]?>
					</option>
				<? } ?>
	      	</select>
		</td>
	</tr>
	<tr>
		<th><?= $Mensajes["campo.comentarios"];?></th>
		<td><textarea name="Comentarios" rows="5" cols="47"><?=$usuario["Comentarios"]?></textarea></td>
	</tr>
	<tr>
		<th>&nbsp;</th>
		<td><input type="button" name="submitbtn" value="<?= $Mensajes["boton.guardar"];?>" onClick="validar();" /></td>
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
	echo "generar_paises(".$usuarioSession["Codigo_Pais"].");\n";
	echo "generar_instituciones(".$usuarioSession["Codigo_Institucion"].");\n";
	echo "generar_dependencias(".$usuarioSession["Codigo_Dependencia"].");\n";
	echo "generar_unidades(".$usuarioSession["Codigo_Unidad"].");\n";
	echo "generar_localidades(".$usuarioSession["Codigo_Localidad"].");\n";
	?>
</script>
<? require "../layouts/base_layout_admin.php" ?>