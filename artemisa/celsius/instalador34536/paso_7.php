<?php
/**
 * paso 7: solicita los datos del pidu de la instancia que se esta creando. nt_enabled = false
 */
$paso_numero = 7;
require "top_layout_install.php";

$servicesFacade = ServicesFacade::getInstance();
array("instituciones","dependencias","unidades");
require "../utils/pidui.php";

?>
<script language="JavaScript" type="text/javascript">
	function validar_datos(){
		if (! parseInt(document.forms.form1.id_pais.value)){
			alert ("<?=PASO7_JS_PAIS?>");
			return false;
		}
		if (! parseInt(document.forms.form1.id_institucion.value)){
			alert ("<?=PASO7_JS_INSTITUCION?>");
			return false;
		}
		//dep?
		//unidad?
		document.forms.form1.submit();
	}
</script>
  
<form method="post" action="instalador_controller.php?paso_numero=7" name="form1">

<table class="table-form" width="95%">
	<tr>
		<td colspan="2" class="table-form-top">
			<?=PASO7_SUBTITULO?>
		</td>
	</tr>
	<tr>
		<th><?=PASO7_LABEL_PAIS?></th>
		<td><select name="id_pais" size="1" onchange="generar_instituciones(0)" /></td>		
	</tr>
	<tr>
		<th><?=PASO7_LABEL_INSTITUCION?>  </th>
		<td><select name="id_institucion" size="1" onchange="generar_dependencias(0)" /></td>		
	</tr>
	<tr>
		<th> <?=PASO7_LABEL_DEPENDENCIA?> </th>
		<td><select name="id_dependencia" size="1" onchange="generar_unidades(0)" /></td>		
	</tr>
	<tr>
		<th> <?=PASO7_LABEL_UNIDAD?></th>
		<td><select name="id_unidad" size="1" /></td>		
	</tr>
</table>
<br/>

<table class="table-form" width="95%">
	<tr>
		<td style="text-align: center; background-color:white">
			<input type="button" name="siguiente" value="Siguiente" onclick="validar_datos();"/>
		</td>
	</tr>
</table>

</form>


<script language="JavaScript" type="text/javascript">
	listNames[0] = new Array();
	listNames[0]["paises"]="id_pais";
	listNames[0]["instituciones"]="id_institucion";
	listNames[0]["dependencias"]="id_dependencia";
	listNames[0]["unidades"]="id_unidad";
	generar_paises(<?=getCfgValue("id_pais") ?>);
	
	<?
	if (getCfgValue("id_institucion") != 0)
		echo "generar_instituciones(".getCfgValue("id_institucion").");";
	if (getCfgValue("id_dependencia") != 0)
		echo "generar_dependencias(".getCfgValue("id_dependencia").");";
	if (getCfgValue("id_unidad") != 0)
		echo "generar_unidades(".getCfgValue("id_unidad").");";
	?>
	
</script>

<?
require "base_layout_install.php";
?>