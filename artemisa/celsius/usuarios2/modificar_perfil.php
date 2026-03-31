<?
$pageName = "usuarios";
require_once "../common/includes.php";
SessionHandler::validar_nivel_acceso(ROL__USUARIO);
$usuario = SessionHandler::getUsuario();
$rol_usuario = SessionHandler::getRolUsuario();

global  $IdiomaSitio ; 
$Mensajes = Comienzo ($pageName,$IdiomaSitio);

$msg = "";
if (!empty($operacion) && $operacion == 1){
	//modificacion del perfil
	$usuarioUpd= array();
	if (!empty($EMail))
		$usuarioUpd["EMail"] = $EMail;
	if ($rol_usuario != ROL__BIBLIOTECARIO){
		if (empty($Codigo_Pais))
			$Codigo_Pais = 0;
		$usuarioUpd["Codigo_Pais"] = $Codigo_Pais;
		if (empty($Codigo_Institucion))
			$Codigo_Institucion = 0;
		$usuarioUpd["Codigo_Institucion"] = $Codigo_Institucion;
		if (empty($Codigo_Dependencia))
			$Codigo_Dependencia = 0;
		$usuarioUpd["Codigo_Dependencia"] = $Codigo_Dependencia;
		if (empty($Codigo_Unidad))
			$Codigo_Unidad = 0;
		$usuarioUpd["Codigo_Unidad"] = $Codigo_Unidad;
	}
	if (!empty($Telefonos))
		$usuarioUpd["Telefonos"] = $Telefonos;
	if (!empty($Direccion))
		$usuarioUpd["Direccion"] = $Direccion;
	if (empty($Codigo_Localidad))
		$Codigo_Localidad = 0;
	$usuarioUpd["Codigo_Localidad"] = $Codigo_Localidad;
	if (empty($Codigo_Categoria))
		$Codigo_Categoria = 0;
	$usuarioUpd["Codigo_Categoria"] = $Codigo_Categoria;
	$usuarioUpd["Id"] = $usuario["Id"];
	$res = $servicesFacade->modificarUsuario($usuarioUpd);
	
	//reviso si se produjeron errores
	if (is_a($res, "Celsius_Exception")){
		$msg = $Mensajes["warning.actualizacionPerfil"];
	}else{
		//actualizo el usuario en la session
		$usuario = $servicesFacade->getUsuario($usuario["Id"]);
		SessionHandler::guardarUsuario($usuario);
		
		$msg = $Mensajes["mensaje.perfilActualizado"];
	}
}elseif (!empty($operacion) && $operacion == 2){
	//modificacion de la contraseña
	if (empty($old_password) || $old_password!=$usuario["Password"])
		$msg= $Mensajes["warning.contraseniaError"];
	elseif (empty($new_password) || empty($new_password2) || $new_password != $new_password2)
		$msg= $Mensajes["warning.contraseniasNoCoinciden"];
	elseif (preg_match('/^\w{7,}$/', $new_password) ==  0)
		$msg= $Mensajes["warning.contraseniaMalFormada"];
	else{
		$usuarioUpd =  array();
		$usuarioUpd["Id"] = $usuario["Id"];
		$usuarioUpd["Password"] = $new_password;
		$res = $servicesFacade->modificarUsuario($usuarioUpd);
		
		//reviso si se produjeron errores
		if (is_a($res, "Celsius_Exception")){
			$mensaje_error = $msg = $Mensajes["warning.actualizacionPerfil"];
			$excepcion = $resModificacion;
			require "../common/mostrar_error.php";
		}
		else{
			//actualizo el usuario en la session
			$usuario = $servicesFacade->getUsuario($usuario["Id"]);
			SessionHandler::guardarUsuario($usuario);
			$msg = $Mensajes["mensaje.perfilActualizado"];
		}
	}
}

require "../layouts/top_layout_admin.php";
?>

<form name='form1' method="post" onsubmit="return false;">
	<input type="hidden" name="operacion" value="0" />
	
<!-- INICIO DEL FORM DEL MODIFICAR PERFIL-->
<?
$conditionsInstituciones = array("habilitado_crear_usuarios"=>1);
$mostrar_elemento = array("instituciones","dependencias","unidades","localidades");
require "../utils/pidui.php";
?>
<script language="JavaScript" type="text/javascript">

	function validar_email(emailField) {
		
		var emailValue = emailField.value;
		if (window.RegExp) {
			var reg1str = "(@.*@)|(\\.\\.)|(@\\.)|(\\.@)|(^\\.)";
			var reg2str = "^.+\\@(\\[?)[a-zA-Z0-9\\-\\.]+\\.([a-zA-Z]{2,3}|[0-9]{1,3})(\\]?)$";
			var reg1 = new RegExp(reg1str);
			var reg2 = new RegExp(reg2str);
			if (!reg1.test(emailValue) && reg2.test(emailValue))
				return true;
		} else {
			if(str.indexOf("@") >= 0)
	      		return true;
		}
		emailField.value="<?= $Mensajes["err-2"];?>";
	    return false;
	}

	function verifica_campos(){
		var valorCampo;
		
		CamposRequeridos = Array("Apellido", "Nombres", "EMail");
		for (campoName in CamposRequeridos){
			campo = document.forms.form1.elements[campoName];
			if (CamposRequeridos[campoName] && !campo.value){	
					campo.value = "<?= $Mensajes["err-1"]; ?>";
					campo.focus();
    				campo.select();	
					return false;
			}
		}
		var campoEMail = document.forms.form1.EMail;
		if (!validar_email(campoEMail)){
			campoEMail.value = "<?= $Mensajes["err-2"]; ?>";
			campoEMail.focus();
    		campoEMail.select();	
			return false;
		}
		
		if (document.forms.form1.Codigo_Institucion.value == 0){
			alert("<?= $Mensajes["warning.faltaInstitucion"];?>");
			return false;
		}
		document.forms.form1.operacion.value = 1;
		document.forms.form1.submit();
		return true;
	}
	
	function validar_password_nuevo(){
		var pass1 = document.forms.form1.new_password;
		var pass2 = document.forms.form1.new_password2;
		if (pass1.value != pass2.value){
			alert ("<? echo $Mensajes['err-6']; ?>");
		}else{
			// 	Pruebo el uso de expresiones regulares
			expresion = /^\w{7,}$/; //matchea con cualquier sequencia de 7 o mas caracteres alfanumericos
			if (expresion.test(pass1.value)){
				document.forms.form1.operacion.value = 2;
				document.forms.form1.submit();
				return true;
			}else
				alert ("<? echo $Mensajes['err-7']; ?>");
		}
		pass1.focus();
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
</script>

<table border="0" cellpadding="2" cellspacing="1" class="table-form" align="center" width="85%">
	<?if (!empty($msg)){?>
		<tr><td colspan="2" style="text-align:center"><b><?=$msg?></b></td></tr>
	<?}?>
	<tr>
		<td colspan="2" class="table-form-top-blue"><?= $Mensajes['txt-1']; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes['txt-2']; ?></th>
		<td><?= $usuario["Apellido"];?></td>
	</tr>
	<tr>
		<th><?= $Mensajes['txt-3']; ?></th>
		<td><?= $usuario["Nombres"];?></td>
	</tr>
	<tr>
		<th><?= $Mensajes['txt-4']; ?></th>
		<td><input name="EMail" value="<?= $usuario["EMail"];?>" type="text" size="50"></td>
	</tr>
	<?
	if ($rol_usuario == ROL__BIBLIOTECARIO)
		$pidu_habilitado = "disabled";
	else
		$pidu_habilitado = "";
	?>
	<tr>
		<th><?= $Mensajes['txt-5']; ?></th>
		<td><select name="Codigo_Pais" size="1" onChange="generar_instituciones();generar_localidades(0);" style="width:316px;" <?= $pidu_habilitado ?>></select></td>
	</tr>
	<tr>
		<th><?= $Mensajes['txt-6']; ?></th>
		<td><select name="Codigo_Institucion" size="1" OnChange="generar_dependencias();" style="width:316px;" <?= $pidu_habilitado ?>></select></td>
	</tr>
	<tr>
		<th><?= $Mensajes['txt-7']; ?></th>
		<td><select name="Codigo_Dependencia" size="1" onChange="generar_unidades();" style="width:316px;" <?= $pidu_habilitado ?>></select></td>
	</tr>
	<tr>
		<th><?= $Mensajes['txt-8']; ?></th>
		<td><select name="Codigo_Unidad" size="1" style="width:316px;" <?= $pidu_habilitado ?>></select></td>
	</tr>
	<tr>
		<th><?= $Mensajes['txt-9']; ?></th>
		<td><input name="Direccion" type="text" size="50" value='<?echo $usuario["Direccion"];?>'></td>
	</tr>
	<tr>
		<th><?= $Mensajes["campo.localidad"];?></th>
		<td>
			<select size="1" name="Codigo_Localidad" style="width:316px;">
	      	</select>
		</td>
	</tr>
	<tr>
		<th><?= $Mensajes['txt-10']; ?></th>
		<td><input name="Telefonos" type="text" size="50" value='<?echo $usuario["Telefonos"];?>'></td>
	</tr>
	<tr>
		<th><?= $Mensajes['txt-11']; ?></th>
		<td>
			<?
			$categorias = $servicesFacade->getAllObjects("tab_categ_usuarios");
			?>
			<select size="1" name="Codigo_Categoria" style="width:316px;">
				<? foreach ($categorias as $categoria){ ?>
					<option value="<?=$categoria["Id"];?>" <? if ($categoria["Id"] == $usuario["Codigo_Categoria"]) echo "selected";?>>
						<?=$categoria["Nombre"];?>
					</option>
				<? } ?>
	      	</select>
		</td>
	</tr>                
	<tr>
		<th>&nbsp;</th>
		<td>
			<input name="actualizar_perfil" type="submit" value="<? echo $Mensajes['bot-1']; ?>" onclick="verifica_campos()"/>
			<input name="resetButton" type="button" value="<? echo $Mensajes['bot-2']; ?>" onClick="limpiar();"/>
		</td>
	</tr>
	<!-- FIN DEL FORM DEL MODIFICAR PERFIL -->
	
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>

	<!-- INICIO FORMULARIO DE CAMBIAR PASSWORD -->
	<tr>
		<td colspan="2" class="table-form-top-blue"><?= $Mensajes['txt-12']; ?></td>
	</tr>
	<tr>
		<th><?= $Mensajes["campo.contrasenia"];?></th>
		<td><input name="old_password" type="password" size="8" value=""/></td>
	</tr>
	<tr>
		<th><?= $Mensajes['txt-14']; ?></th>
		<td><input name="new_password" type="password" size="8" value=""/></td>
	</tr>
	<tr>
		<th><?= $Mensajes['txt-15']; ?></th>
		<td><input name="new_password2" type="password" size="8" value=""/></td>
	</tr>
	<tr>
		<th></th>
		<td>
			<input name="actualizar_contrasenia" type="button" value="<? echo $Mensajes['bot-1']; ?>" onclick="validar_password_nuevo();"/>
			<input name="resetButton" type="button" value="<? echo $Mensajes['bot-2']; ?>" onClick="limpiar();"/>
		</td>
	</tr>
	<!-- FIN FORMULARIO DE CAMBIAR PASSWORD -->
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
	echo "generar_paises(".$usuario["Codigo_Pais"].");\n";
	echo "generar_instituciones(".$usuario["Codigo_Institucion"].");\n";
	echo "generar_dependencias(".$usuario["Codigo_Dependencia"].");\n";
	echo "generar_unidades(".$usuario["Codigo_Unidad"].");\n";
	echo "generar_localidades(".$usuario["Codigo_Localidad"].");\n";
	?>
</script>
<?

require "../layouts/base_layout_admin.php";
?>