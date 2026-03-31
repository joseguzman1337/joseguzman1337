<?
 
include_once "../inc/var.inc.php";
include_once "../inc/"."conexion.inc.php";  
include_once "../inc/"."parametros.inc.php";  
Conexion();

?>
<html>
  <head> 
    <title><? echo Titulo_Sitio();?></title>
  </head>

<body background="../imagenes/banda.jpg">

<?
 

/* include_once "../inc/"."identif.php";
 Usuario();
*/

$query = "SELECT  Pedidos.id, Titulo_Articulo, Usuarios.Apellido, Usuarios.Nombres FROM Pedidos, Usuarios where Titulo_Articulo like '%$Texto%'  and Usuarios.id = Pedidos.Codigo_Usuario";

$resultado = mysql_query($query);
   echo mysql_error();

?>

<table border="1">
<tr>
  <td>  Id Pedido </td>
  <td> Título del articulo </td>
  <td> Apellido </td>
  <td> Nombres </td>
</tr>
<?
   while($fila = mysql_fetch_row($resultado))
     {echo "<tr> <td> $fila[0] </td>";
	  echo "<td> $fila[1] </td> ";
	  echo "<td> $fila[2] </td> ";
	  echo "<td> $fila[3] </td> </tr>";
	 }

?>

<?
  mysql_free_result($result);
   
 Desconectar();
    
?>

</table>
</body>
</html>