<script language="javascript">
	function enviar()
		{
			document.form1.submit();
		}
</script>
<style type="text/css">@import url(../../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 11px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
.Estilo5 {font-family: Tahoma; font-size: 12px}
-->
</style>
<?php
//error_reporting(2047);
require_once("../../../../funciones/conexion/conexionpear.php");
require_once("../../../../funciones/gui/campotexto_valida_post.php");
require_once("../../../../funciones/gui/combo_valida_post.php");
$validaciongeneral=true;	
$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados\n';
?>
<?php
$fechahoy=date("Y-m-d H:i:s");
?>
<form name="form1" method="post" action="">
<p align="center" class="Estilo2">GRADUAR ESTUDIANTES - IMPRESION DE FOLIOS </p>
<table width="50%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><table width="100%"  border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td width="22%" bgcolor="#CCDADD" class="Estilo2">Fecha inicial</td>
        <td width="78%" bgcolor="#FEF7ED" class="verde"><?php $validacion['fechainicial']=campotexto_valida_post("fechainicial","fecha","Fecha inicial","7");?>
            <button id="btfechainicial">...</button></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2">Fecha final </td>
        <td bgcolor="#FEF7ED" class="verde"><?php $validacion['fechafinal']=campotexto_valida_post("fechafinal","fecha","Fecha final","7");?><button id="btfechafinal">...</button></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2">N&uacute;mero de folio desde </td>
        <td bgcolor="#FEF7ED" class="verde"><?php $validacion['numerofolio']=campotexto_valida_post("numerofolio","numero","Número de folio","7");?></td>
      </tr>
      <tr bgcolor="#CCDADD">
        <td colspan="2" class="Estilo2"><div align="center">
            <input name="Enviar" type="submit" id="Enviar" value="Enviar">
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<script type="text/javascript">
Calendar.setup(
{
inputField : "fechainicial", // ID of the input field
ifFormat : "%Y-%m-%d", // the date format
button : "btfechainicial" // ID of the button
}
);
</script>
<script type="text/javascript">
Calendar.setup(
{
inputField : "fechafinal", // ID of the input field
ifFormat : "%Y-%m-%d", // the date format
button : "btfechafinal" // ID of the button
}
);
</script>

<?php
if(isset($_POST['Enviar']))
{
	//print_r($validacion['codigobanco']);
	foreach ($validacion as $key => $valor){if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}
	if($validaciongeneral==true)
	{
		echo "<script language='javascript'>window.location.reload('folio.php?fechainicial=".$_POST['fechainicial']."&fechafinal=".$_POST['fechafinal']."&numerofolio=".$_POST['numerofolio']."');</script>";
	}
	else
	{
		echo "<script language='javascript'>alert('".$mensajegeneral."');</script>";
	}
}
?>