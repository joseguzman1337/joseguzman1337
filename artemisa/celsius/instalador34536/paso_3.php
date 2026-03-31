<?php
/**
 * paso 3: solo para actualizacion. Debe ingresar los datos de la BDD existente
 * 
 */
$paso_numero = 3;
require "top_layout_install.php";
$configuracion = getCfg();

?>

<script language="JavaScript" type="text/javascript">
	function validar_datos(){
		var formulario = document.forms.form1;
		
		<?if ($configuracion["tipo_instalacion"] == "actualizacion"){?>
			if (!formulario.dbname16.value){
				alert("<?=PASO3_JS_NOMBREBD?>");
				return false;
			}
		<?}?>
		if (!formulario.userCelsiusMySQL.value){
			alert("<?=PASO3_JS_NOMBREUSUARIOMYSQL?>");
			return false;
		}
		if (!formulario.passwordCelsiusMySQL.value){
			alert("<?=PASO3_JS_PASSWORDUSUARIOMYSQL?>");
			return false;
		}
		
		formulario.submit();
	}
	
	
</script>
  
  
<form method="post" action="instalador_controller.php?paso_numero=3" name="form1">

<? if ($configuracion["tipo_instalacion"] == "actualizacion"){?>
	<table class="table-form" width="95%">
		<tr>
			<td colspan="2" class="table-form-top">
				<?=PASO3_SUBTITULO_ACTUALIZACION?> 
			</td>
		</tr>
		<tr>
			<th><?=PASO3_LABEL_ACTUALIZACION_BDNAME?>: </th>
			<td><input type="text" name="dbname16" value="<?=getCfgValue("dbname16") ?>" size="50" /></td>
		</tr>
	</table>
	
	<br/>
<?}?>

<table class="table-form" width="95%">
	<tr>
		<td colspan="2" class="table-form-top">
			<?=PASO3_SUBTITULO_USUARIOCELSIUS?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?=PASO3_TEXT_INFORMACION?>.
  		</td>
	</tr>
	
	<tr>
		<th><?=PASO3_LABEL_USUARIOCELSIUSMYSQL?></th>
		<td><input type="text" name="userCelsiusMySQL" value="<?=getCfgValue("userCelsiusMySQL") ?>" size="50" /></td>
	</tr>
	<tr>
		<th><?=PASO3_LABEL_PASSWORDCELSIUSMYSQL?></th>
		<td><input type="text" name="passwordCelsiusMySQL" value="<?=getCfgValue("passwordCelsiusMySQL") ?>" size="50" /></td>
	</tr>
</table>
<br/>

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