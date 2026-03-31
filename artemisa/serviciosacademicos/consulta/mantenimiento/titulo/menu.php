<?php 
session_start();
 include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
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
<p>MANTENIMIENTO DE CARRERAS </p>
   <td><table width="50%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
      <tr>
        <td id="tdtitulogris" width="22%" bgcolor="#CCDADD" ><div align="center">Accion</div></td>
        <td width="78%" id="tdtitulogris" ><select name="accion" id="accion">
          <option value="0">Seleccionar</option>
          <option value="1"<?php if($_POST['accion']=='1'){echo "selected";}?>>Insertar Titulos</option>
		  <option value="2"<?php if($_POST['accion']=='2'){echo "selected";}?>>Consultar Titulos</option>
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
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=titulo.php?link_origen=menu.php'>";
			break;
		case 2:
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=titulo_listado.php?link_origen=menu.php'>";
			break;
	}
}
?> 