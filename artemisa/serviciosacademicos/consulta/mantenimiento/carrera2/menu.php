<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script language="javascript">
function enviar()
{
	document.form1.submit();
}
</script>

<?php
$fechahoy=date("Y-m-d H:i:s");

?>
<form name="form1" method="post" action="">
<TABLE width="50%" cellpadding="1" cellspacing="0" align="center">
<TR>
<td bgcolor="#8AB200" colspan="3" valign="center"><img src="../../../../imagenes/noticias_logo.gif" height="71"></td>
</TR>
<TR >
        <TD align="center"><label id="labelresaltado">MANTENIMIENTO DE CARRERAS</label></TD>
    </TR>
</TABLE>

   <table width="50%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" align="center">
      <tr>
        <td id="tdtitulogris" width="22%" bgcolor="#CCDADD" ><div align="center">Accion</div></td>
        <td width="78%" id="tdtitulogris" ><select name="accion" id="accion">
          <option value="0">Seleccionar</option>
          <option value="1"<?php if($_POST['accion']=='1'){echo "selected";}?>>Insertar Carreras</option>
		  <option value="2"<?php if($_POST['accion']=='2'){echo "selected";}?>>Consultar Carreras</option>
        </select></td>
      </tr>
      <tr>
        <td  colspan="2"><div align="center">
            <input name="Enviar" type="submit" id="Enviar" value="Enviar">
        </div></td>
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
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=insertar2.php?link_origen=menu.php'>";
			break;
		case 2:
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=consultarcarrera.php?link_origen=menu.php'>";
			break;
	}
}
?>