<?php
@session_start();
//print_r($_SESSION);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<form name="form1" method="post" action="">
<?php
$array_nombre=$_SESSION["nombre"];
$array_codigoestudiante=$_SESSION["codigoestudiante"];
$array_numerodocumento=$_SESSION["numerodocumento"];
$array_nombrecarrera=$_SESSION["nombrecarrera"];
//print_r($_SESSION);
echo '<table border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td align="center" bgcolor="#FFFFFF" class="Estilo2"><div align="center">ID&nbsp; </div></td>
	<td align="center" bgcolor="#FFFFFF" class="Estilo2"><div align="center">Nombre&nbsp; </div></td>
    <td align="center" bgcolor="#FFFFFF" class="Estilo2"><div align="center">Documento&nbsp;</div></td>
    <td align="center" bgcolor="#FFFFFF" class="Estilo2">Facultad&nbsp;
      <div align="center"></div></td>
    <td align="center" bgcolor="#FFFFFF" class="Estilo2">No imprimir&nbsp;
      <div align="center"></div></td>';

if($_SESSION["nombre"]!="")
{
	foreach ($array_nombre as $nombre => $valnombre){
}
if(isset($_GET['cartas'])){
$ID=$nombre+1;
echo '<tr>
<td align="center" bgcolor="#FFFFFF" class="Estilo1">'.$ID.'&nbsp;</td>
<td align="center" bgcolor="#FFFFFF" class="Estilo1"><a href="../cartas/cartagraduandos/cartagraduandos.php?codigoestudiante='.$array_codigoestudiante[$nombre].'">'.$valnombre.'</a>&nbsp;</td>
<td align="center" bgcolor="#FFFFFF" class="Estilo1">'.$array_numerodocumento[$nombre].'&nbsp;</td>
<td align="center" bgcolor="#FFFFFF" class="Estilo1">'.$array_nombrecarrera[$nombre].'&nbsp;</td>
<td><div align="center"><input type="checkbox" title="imprimir" name="sel'.$array_codigoestudiante[$nombre].'" '.$chequear.' value='.$array_codigoestudiante[$nombre].'>&nbsp;</div></td>
	 </tr>
	  ';
	}
elseif(isset($_GET['datos'])){
$ID=$nombre+1;
echo '<tr>
<td align="center" bgcolor="#FFFFFF" class="Estilo1">'.$ID.'&nbsp;</td>
<td align="center" bgcolor="#FFFFFF" class="Estilo1"><a href="graduar_estudiantes_ingreso.php?listado&estudiante='.$array_codigoestudiante[$nombre].'">'.$valnombre.'</a>&nbsp;</td>
<td align="center" bgcolor="#FFFFFF" class="Estilo1">'.$array_numerodocumento[$nombre].'&nbsp;</td>
<td align="center" bgcolor="#FFFFFF" class="Estilo1">'.$array_nombrecarrera[$nombre].'&nbsp;</td>
<td><div align="center"><input type="checkbox" title="imprimir" name="sel'.$array_codigoestudiante[$nombre].'" '.$chequear.' value='.$array_codigoestudiante[$nombre].'>&nbsp;</div></td>
	 </tr>
	  ';
}
}
 echo '
  <tr>
    <td height="25" colspan="6" align="center" bgcolor="#FFFFFF" class="Estilo2"><input type="submit" name="Enviar" value="Enviar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="submit" name="Regresar" value="Regresar">
	</td>
    </table>';
	  
?>

</form>
</body>
</html>
<?php
if(isset($_POST['Regresar']))
{
	echo '<script language="javascript">window.location.reload("sel_facultad_listado_elegibles.php?facultad='.$_POST['facultad'].'");</script>';
}
?>