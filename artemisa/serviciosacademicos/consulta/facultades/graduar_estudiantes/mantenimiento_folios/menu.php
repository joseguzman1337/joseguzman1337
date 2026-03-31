<link rel="stylesheet" type="text/css" href="../estilos/sala.css">
<script language="javascript">
function enviar()
{
	document.form1.submit();
}
</script>
<script language="javascript">
function Confirmacion()
{
	if(confirm('La foliación de los registros de grado no es reversible. ¿Desea continuar?'))
	{
		document.form1.submit();
		window.location.href='creacion_folios_automaticos.php?link_origen=menu.php';
	}
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
$fechahoy=date("Y-m-d H:i:s");
?>
<form name="form1" method="post" action="">
<p align="center" class="Estilo2">GRADUAR ESTUDIANTES - GENERACION DE FOLIOS </p>
<table width="50%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><table width="100%"  border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td width="22%" bgcolor="#CCDADD" class="Estilo2"><div align="center">Accion</div></td>
        <td width="78%" bgcolor="#FEF7ED" class="verde"><select name="accion" id="accion">
          <option value="0" selected>Seleccionar</option>
          <option value="1">Generación e impresión automática de folios</option>
		  <option value="2">Impresión de copias de folios previamente generados/impresos</option>
        </select></td>
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
<?php
if(isset($_POST['Enviar']))
{
	switch ($_POST['accion'])
	{
		case 0:
			echo '<script language="javascript">alert("No ha seleccionado ninguna opcion")</script>';
			break;
		case 1:
			echo "<script language='javascript'>Confirmacion()</script>";
			break;
		case 2:
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=reimpresion_folios.php?link_origen=menu.php'>";
			break;
	}
}
?>
