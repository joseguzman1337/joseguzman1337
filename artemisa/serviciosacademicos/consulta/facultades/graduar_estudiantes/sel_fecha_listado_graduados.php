<script language="JavaScript" src="calendario/javascripts.js"></script>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>

<script language="javascript">
function enviar()
{
	document.form1.submit()
}
</script>
<?php
require('../../../Connections/sala2.php');
require('calendario/calendario.php');
?>
<style type="text/css">
<!--
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
-->
</style>
<form name="form1" method="get" action="informe_graduadosxfecha.php">

<p align="center"><span class="Estilo3">INFORME DE ESTUDIANTES GRADUADOS POR FECHA </span></p>
<table width="58%"  border="2" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td width="51%" bordercolor="#FFFFFF" bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha:(aaaa-mm-dd)</div></td>
    <td width="49%" bordercolor="#FFFFFF" bgcolor='#FEF7ED'><p align="center" class="style2">
      <input name="fecha" type="text" id="fecha" size="10">
</p></td>
  </tr>
  <tr>
    <td colspan="2" bordercolor="#FFFFFF" bgcolor="#CCDADD" class="Estilo2"><div align="center">
      <input name="Enviar" type="submit" id="Enviar" value="Enviar">
    </div></td>
    </tr>
</table>
</form>


<?php
if(isset($_POST['Enviar']))
{
echo '<script language="javascript">window.location.reload("listado_elegibles_grado_facultades.php?facultad='.$_POST['facultad'].'");</script>';
}
if(isset($_POST['Regresar']))
{
echo '<script language="javascript">window.close();</script>';
}

?>