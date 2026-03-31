<?php
/**
 * paso 2: ingreso de datos para el mysql
 */
$paso_numero = 2;

require "top_layout_install.php";

?>
<?=PASO2_TITULO?>

<script language="JavaScript" type="text/javascript">
	function validar_datos(){
		var formulario = document.forms.form1;
		
		if (!formulario.hostMySQL.value){
			alert("<?=PASO2_JS_HOSTMYSQL?>");
			return false;
		}
		if (!formulario.userRootMySQL.value){
			alert("<?=PASO2_JS_USUARIOMYSQL?>");
			return false;
		}
		if (!formulario.passwordRootMySQL.value){
			alert("<?=PASO2_JS_PASSWORDMYSQL?>");
			return false;
		}
		if (!formulario.dbnameNT.value){
			alert("<?=PASO2_JS_NOMBREBASE?>");
			return false;
		}
		
		formulario.submit();
	}
	
	function cambio_tipo_instalacion(radio){
		//TODO hbilitar/deshabilitar los campos segun el tipo de instalacion
	}
</script>
  
  
<form method="post" action="instalador_controller.php?paso_numero=2" name="form1" onsubmit="return false;">

<table class="table-form" width="95%">
	<tr>
		<td colspan="2" class="table-form-top">
			<?=PASO2_SUBTITULO?>
		</td>
	</tr>
	<tr>
		<th><?=PASO2_LABEL_TIPOINSTALACION?>: </th>
		<td>
			<input type="radio" name="tipo_instalacion" value="instalacion" onclick="cambio_tipo_instalacion(this)" <? if (getCfgValue("tipo_instalacion") != "actualizacion") echo "checked"?>/><?=PASO2_RADIO_TIPOINSTALACION_INSTALACION?>  
			<input type="radio" name="tipo_instalacion" value="actualizacion" onclick="cambio_tipo_instalacion(this)" <? if (getCfgValue("tipo_instalacion") == "actualizacion") echo "checked"?>/><?=PASO2_RADIO_TIPOINSTALACION_ACTUALIZACION?> 
  		</td>
	</tr>
	<tr>
		<th><?=PASO2_LABEL_HOSTMYSQL?></th>
		<td><input type="text" name="hostMySQL" value="<?=getCfgValue("hostMySQL")?>" size="50" /></td>
	</tr>
	<tr>
		<th><?=PASO2_LABEL_USUARIOMYSQL?></th>
		<td><input type="text" name="userRootMySQL" value="<?=getCfgValue("userRootMySQL")?>" size="50" /></td>
	</tr>
	<tr>
		<th><?=PASO2_LABEL_PASSWORDMYSQL?></th>
		<td><input type="text" name="passwordRootMySQL" value="<?=getCfgValue("passwordRootMySQL")?>" size="50" /></td>
	</tr>
	<tr>
		<th><?=PASO2_LABEL_NOMBREBASE?></th>
		<td><input type="text" name="dbnameNT" value="<?=getCfgValue("dbnameNT")?>" size="50" /></td>
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