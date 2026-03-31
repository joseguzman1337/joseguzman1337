<?
  include "direccionador.inc.php";
  include "../inc/conexion.inc.php";
  Conexion();

?>
<script>

function cambiarColor(element)
{ 
  if (element.style.background == "")
      element.style.background = "#00CC99";
    else
     element.style.background = "";
}
</script>
Buscar codigos de usuarios:
<form name="form1" action="buscaIdUsuario.php" method="POST"><br>
Apellido:<input type="text" name="Apellido" value="<? echo $Apellido; ?>"><br>
Nombre:<input type="text" name="Nombre" value="<? echo $Nombre; ?>">
<input type="submit" value="Enviar">
<input type="hidden" name="procesando" value=1>
</form>

<?
if (isset($procesando) && ($procesando==1))
{
	  $query = " SELECT  `Id` ,  `Apellido` ,  `Nombres` FROM Usuarios WHERE `Apellido` like '".$Apellido."%' and  `Nombres` like '".$Nombre."%'";
	  $resu = mysql_query($query);
      echo mysql_error();
    echo "<table border=1 align=center width=100%>";
    echo "<tr> <td> Codigo Usuario </td> <td width=20%> Apellido  </td> <td width=7%> Nombres </td> <td> Usuario encontrado <td> </tr>";
	  while ($row = mysql_fetch_row($resu))
		{
		   echo "<tr onclick=cambiarColor(this);> </td> <td> ".$row[0]." </td> <td> ".$row[1]." </td> <td> ".$row[2]." </td> <td> <a href='cuentas.php?idUsuario1=".$row[0]."'> Encontré el usuario <img src='happy.gif' width=15% border=0></a> </td> </tr>";
		   $sum += $row[4];
		}
}
?>
</table>
<a href="cuentas.php"> Volver a la pagina anterior </a>