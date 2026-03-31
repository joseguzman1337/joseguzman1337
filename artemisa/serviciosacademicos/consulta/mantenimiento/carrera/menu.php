<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script language="javascript">
function enviar()
{
	document.form1.submit();
}
</script>
<script language="javascript">
function Confirmacion()
{
	if(confirm('La autorización de grado no es reversible. ¿Desea continuar?'))
	{
		document.form1.submit();
		window.location.reload('creacion_folios_automaticos.php?link_origen=menu.php');
	}
}
</script>
<?php
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../funciones/clases/autenticacion/redirect.php');
?>
<form name="form1" method="post" action="">
<p>MANTENIMIENTO DE CARRERAS </p>
   <td><table width="50%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
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
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=insertar_carrera.php?link_origen=menu.php'>";
			break;
		case 2:
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=consultar_carrera.php?link_origen=menu.php'>";
			break;
	}
}
?> 