<?
/**
 * Paso 5: se solicitan los parametros
 */
/**
 *  Hay que descomentar el TAG TODO de este archivo , para poder hacer la sincronizacion con
 *  el servidor . 
 *  Tambien hay dos validaciones en la funcion validar_datos que son dos campos 
 * 	otorgados por el directorio 
 */ 
 
 
$paso_numero = 5;
require "top_layout_install.php";
?>

<script language="JavaScript" type="text/javascript">
	function validar_datos(){
		var formulario = document.forms.form1;
		var errores = new Array();
		var errorFields = new Array();
		
		if (!formulario.url_completa.value){
			errores[errores.length] = "<?=PASO5_JS_URLCOMPLETA?>";
			errorFields[errorFields.length] = formulario.url_completa; 
		}
		if (!formulario.mail_contacto.value){
			errores[errores.length] = "<?=PASO5_JS_MAIL?>";
			errorFields[errorFields.length] = formulario.mail_contacto; 
		}
		if (!formulario.titulo_sitio.value){
			errores[errores.length] = "<?=PASO5_JS_TITULOSITIO?>";
			errorFields[errorFields.length] = formulario.titulo_sitio;
		}
		
		if (!formulario.directorio_upload.value){
			errores[errores.length] = "<?=PASO5_JS_DIRECTORIOUPLOAD?>";
			errorFields[errorFields.length] = formulario.directorio_upload;
		}
		if (!formulario.directorio_temporal.value){
			errores[errores.length] = "<?=PASO5_JS_DIRECTORIOTEMP?>";
			errorFields[errorFields.length] = formulario.directorio_temporal;
		}
		<? if (getCfgValue("tipo_instalacion") != "actualizacion"){ ?>
			if (!formulario.admin_password.value){
				errores[errores.length] = "<?=PASO5_JS_PASSWORDADMIN?>";
				errorFields[errorFields.length] = formulario.admin_password;
				formulario.admin_password2.value = "";
			}
			
			if (!formulario.admin_password2.value){
				errores[errores.length] = "<?=PASO5_JS_REPASSOWRD?>";
				errorFields[errorFields.length] = formulario.admin_password2;
				formulario.admin_password.value = "";
			}
			
			if (formulario.admin_password.value != formulario.admin_password2.value){
				errores[errores.length] = "<?=PASO5_JS_ERRORPASSWORD?>";
				errorFields[errorFields.length] = formulario.admin_password;
				formulario.admin_password.value = "";
				formulario.admin_password2.value = "";
			}
		<?}?>
		if (!formulario.id_celsius_local.value){
			errores[errores.length] = "<?=PASO5_JS_IDCELSIUSLOCAL?>";
			errorFields[errorFields.length] = formulario.id_celsius_local;
		}
		/*
		if (formulario.nt_enabled.checked){
			if (!formulario.password_directorio.value){
				errores[errores.length] = "<?=PASO5_JS_PASSWORDDIRECTORIO?>";
				errorFields[errorFields.length] = formulario.nt_enabled;
			}
			if (!formulario.url_directorio.value){
				errores[errores.length] = "<?=PASO5_JS_URLDIRECTORIO?>";
				errorFields[errorFields.length] = formulario.url_directorio;
			}
		}
		*/
		if (errores.length > 0){
			var errorMSG = "";
			for(i = 0; i < errores.length; i++)
				errorMSG = errorMSG + errores[i] + "\n"; 
			alert(errorMSG);
			errorFields[0].focus();
			return false;
		}
		
		formulario.submit();
	}
	
	function cambio_nt_enabled(isChecked){
		var formulario = document.forms.form1;
		if (isChecked){
			formulario.password_directorio.disabled=false;
			formulario.no_sincronizar_con_directorio.disabled=false;
		}else{
			formulario.password_directorio.disabled=true;
			formulario.no_sincronizar_con_directorio.disabled=true;
		}
	}
	
</script>
	
<form method="post" action="instalador_controller.php?paso_numero=5" name="form1">

<table class="table-form" width="95%">
	<tr>
		<td colspan="2" class="table-form-top">
			<?=PASO5_SUBTITULO?>
		</td>
	</tr>
	<tr>
		<th><?=PASO5_LABEL_URLCOMPLETA?></th>
		<td><input type="text" name="url_completa" value="<?=getCfgValue("url_completa") ?>" size="50" /></td>
	</tr>
	<tr>
		<th><?=PASO5_LABEL_MAILCONTACTO?></th>
		<td><input type="text" name="mail_contacto" value="<?=getCfgValue("mail_contacto") ?>" size="50" /></td>
	</tr>
	<tr>
		<th><?=PASO5_LABEL_TITULOSITIO?></th>
		<td><input type="text" name="titulo_sitio" value="<?=getCfgValue("titulo_sitio") ?>" size="50" /></td>
	</tr>
	<tr>
		<th><?=PASO5_LABEL_DIRECTORIOUPLOAD?></th>
		<td><input type="text" name="directorio_upload" value="<?=getCfgValue("directorio_upload") ?>" size="50" /></td>
	</tr>
	<tr>
		<th><?=PASO5_LABEL_DIRECTORIOUPLOADTEMP?></th>
		<td><input type="text" name="directorio_temporal" value="<?=getCfgValue("directorio_temporal") ?>" size="50" /></td>
	</tr>
</table>
<br/>

<? if (getCfgValue("tipo_instalacion") != "actualizacion"){ ?>
	<table class="table-form" width="95%">
		<tr>
			<td colspan="2" class="table-form-top">
				<?=PASO5_LABEL_DATOSADMIN?>
			</td>
		</tr>
		<tr>
			<th><?=PASO5_LABEL_DATOSADMINPASSWORD?></th>
			<td><input type="text" name="admin_password" value="<?=getCfgValue("admin_password") ?>" size="50" /></td>
		</tr>
		<tr>
			<th><?=PASO5_LABEL_REDATOSADMINPASSWORD?></th>
			<td><input type="text" name="admin_password2" value="<?=getCfgValue("admin_password") ?>" size="50" /></td>
		</tr>
	</table>
	<br/>
<?}?>

<table class="table-form" width="95%">
	<tr>
		<td colspan="2" class="table-form-top">
			<?=PASO5_SUBTITULO_DIRECTORIO?>
		</td>
	</tr>
	<tr>
		<th><?=PASO5_LABEL_IDCELSIUSLOCAL?></th>
		<td><input type="text" name="id_celsius_local" value="<?=getCfgValue("id_celsius_local") ?>" size="50" /></td>
	</tr>
	<?
	/**
	 * TODO
	 * Parametros del Directorio.
	 * 
	 */ 
	 
	?>
	<!--
	<tr>
		<td colspan="2">
			<input type="checkbox" name="nt_enabled" value="ON" onclick="cambio_nt_enabled(this.checked);" <? if (getCfgValue("nt_enabled")) echo "checked" ?>/>
			<?=PASO5_LABEL_NTENABLED?>
		</td>
	</tr>
	<tr>
		<th><?=PASO5_LABEL_PASSWORDDIRECTORIO?></th>
		<td><input type="text" name="password_directorio" value="<?=getCfgValue("password_directorio") ?>" size="50" /></td>
	</tr>
	<tr>
		<th><?=PASO5_LABEL_URLDIRECTORIO?> </th>
		<td><input type="text" name="url_directorio" value="<?=getCfgValue("url_directorio") ?>" size="50" /></td>
	</tr>
	<tr>
		<td colspan="2">
			<input type="checkbox" name="no_sincronizar_con_directorio" value="ON" <? if (getCfgValue("no_sincronizar_con_directorio")) echo "checked" ?> />
			<?=PASO5_TEXT_INFORMACION?>
			
		</td>
	</tr>
	-->
</table>


<table class="table-form" width="95%">
	<tr>
		<td style="text-align: center; background-color:white">
			<input type="button" name="siguiente" value="<?=COMMON_BUTTON_SIGUIENTE?>" onclick="validar_datos();"/>
		</td>
	</tr>
</table>
</form>
<?
require "base_layout_install.php";
?>