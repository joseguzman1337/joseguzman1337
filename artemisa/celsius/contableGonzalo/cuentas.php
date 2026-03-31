<?
   include "direccionador.inc.php";
   include "../inc/conexion.inc.php";
    Conexion();
//     require "/services/web/httpd/public_html/prebi/inc/fgenped.php";
//    require "/services/web/httpd/public_html/prebi/inc/fgentrad.php"; 
   
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
<b>
<div style="color:navy"> Nota: este script solo busca pedidos que hayan sido entregados, ya sea en papel o descargados desde el sitio. No se incluyen en este listado ni pedidos cancelados, ni anulados, ni pedidos que aun estén en circulación.</div><br>
<div style="color:red"> Importante: observar que las fechas a partir de las cuales se realizan las búsquedas varían de acuerdo a la forma de entrega del pedido </div> </b>
<br>
<form name="form1" action="cuentas.php" method="POST">
Fecha (YYYY/M/D): <input type="text" name="fecha" value="<? if (isset($fecha)) echo $fecha; else echo date("Y/m/d"); ?>">
<br>
Codigos de Usuarios: <br> <a href="buscaIdUsuario.php"> Buscar Codigos de Usuarios </a> <br>
Usuario 1:<input type="text" name="idUsuario1" value="<? echo $idUsuario1; ?>">
<br>
Usuario 2:<input type="text" name="idUsuario2" value="<? echo $idUsuario2; ?>">
<br>
Usuario 3:<input type="text" name="idUsuario3" value="<? echo $idUsuario3; ?>">
<br>
Usuario 4:<input type="text" name="idUsuario4" value="<? echo $idUsuario4; ?>">
<br>
Usuario 5:<input type="text" name="idUsuario5" value="<? echo $idUsuario5; ?>">
<br>
Usuario 6:<input type="text" name="idUsuario6" value="<? echo $idUsuario6; ?>">
<br>
Usuario 7:<input type="text" name="idUsuario7" value="<? echo $idUsuario7; ?>">
<br>
Usuario 8:<input type="text" name="idUsuario8" value="<? echo $idUsuario8; ?>">
<br>
Usuario 9:<input type="text" name="idUsuario9" value="<? echo $idUsuario9; ?>">
<br>
Usuario 10:<input type="text" name="idUsuario10" value="<? echo $idUsuario10; ?>">

<hr>

<input type="hidden" name="procesando" value=1>
<input type="submit" value="Buscar Deudores">
<input type="reset" value="Limpiar campos">

</form>
<?
if (isset($procesando) && ($procesando==1))
{
	if ($idUsuario1 ==0) $idUsuario1 = -1;
	if ($idUsuario2 ==0) $idUsuario2 = -1;
	if ($idUsuario3 ==0) $idUsuario3 = -1;
	if ($idUsuario4 ==0) $idUsuario4 = -1;
	if ($idUsuario5 ==0) $idUsuario5 = -1;
	if ($idUsuario6 ==0) $idUsuario6 = -1;
	if ($idUsuario7 ==0) $idUsuario7 = -1;
	if ($idUsuario8 ==0) $idUsuario8 = -1;
	if ($idUsuario9 ==0) $idUsuario9 = -1;
	if ($idUsuario10 ==0) $idUsuario10 = -1;


  $query = " SELECT  `Id` ,  `Codigo_Usuario` ,  `Fecha_Alta_Pedido` ,`Fecha_Recepcion`,  `Numero_Paginas` ,`Fecha_Entrega` FROM  `PedHist`  
             WHERE (`Codigo_Usuario`  = '".$idUsuario1."' 
                 OR `Codigo_Usuario`  = '".$idUsuario2."'
OR `Codigo_Usuario`  = '".$idUsuario3."' 
OR `Codigo_Usuario`  = '".$idUsuario4."' 
OR `Codigo_Usuario`  = '".$idUsuario5."' 
OR `Codigo_Usuario`  = '".$idUsuario6."' 
OR `Codigo_Usuario`  = '".$idUsuario7."' 
OR `Codigo_Usuario`  = '".$idUsuario8."' 
OR `Codigo_Usuario`  = '".$idUsuario9."'
OR `Codigo_Usuario`  = '".$idUsuario10."'   ) AND  `Fecha_Entrega`  >=  '".$fecha."' AND `Estado` = 7 
	ORDER BY `Fecha_Entrega` ASC";



$resu = mysql_query($query);
echo mysql_error();
echo "<h2> Detalle de deuda desde el ".$fecha.". <br> Pedidos entregados EN PAPEL (se busca por la fecha de ENTREGA): </h2>";
echo "<table border=1 align=center width=100%>";
echo "<tr> <td> visto </td> <td width=20%> Id pedido </td> <td width=7%> Usuario </td> <td width=10%> Fecha Alta Pedido </td> <td width=10%> Fecha Recepcion </td> <td width=20%> Numero de paginas </td><td width=10%> Fecha Entrega </td>";
$sum = 0;
while ($row = mysql_fetch_row($resu))
{
   echo "<tr onclick=cambiarColor(this);> <td> <input type='checkbox'> </td> <td> ".$row[0]." </td> <td> ".$row[1]." </td> <td> ".$row[2]." </td> <td> ".$row[3]." </td> <td> ".$row[4]." </td> <td> ".$row[5]." </td>";
   $sum += $row[4];
}
echo "</table> <h2> Subtotal: ".$sum." paginas. Monto: ".$sum*0.4." pesos </h2>";



  $query = " SELECT  `Id` ,  `Codigo_Usuario` ,  `Fecha_Alta_Pedido` ,`Fecha_Recepcion`,  `Numero_Paginas` ,`Fecha_Entrega` FROM  `PedHist`
             WHERE (`Codigo_Usuario`  = '".$idUsuario1."' 
                 OR `Codigo_Usuario`  = '".$idUsuario2."'
OR `Codigo_Usuario`  = '".$idUsuario3."' 
OR `Codigo_Usuario`  = '".$idUsuario4."' 
OR `Codigo_Usuario`  = '".$idUsuario5."' 
OR `Codigo_Usuario`  = '".$idUsuario6."' 
OR `Codigo_Usuario`  = '".$idUsuario7."' 
OR `Codigo_Usuario`  = '".$idUsuario8."' 
OR `Codigo_Usuario`  = '".$idUsuario9."'
OR `Codigo_Usuario`  = '".$idUsuario10."'   ) AND  `Fecha_Recepcion`  >=  '".$fecha."' AND `Estado` = 12 
	ORDER BY `Fecha_Entrega` ASC";



$resu = mysql_query($query);
echo mysql_error();
echo "<h2> Pedidos descargados desde el sitio ((se busca por la fecha de recepción): </h2>";
echo "<table border=1 align=center width=100%>";
echo "<tr> <td> visto </td> <td width=20%> Id pedido </td> <td width=7%> Usuario </td> <td width=10%> Fecha Alta Pedido </td> <td width=10%> Fecha Recepcion </td> <td width=20%> Numero de paginas </td><td width=10%> Fecha Entrega </td>";
$sum2 = 0;
while ($row = mysql_fetch_row($resu))
{
   echo "<tr onclick=cambiarColor(this);> <td> <input type='checkbox'> </td> <td> ".$row[0]." </td> <td> ".$row[1]." </td> <td> ".$row[2]." </td> <td> ".$row[3]." </td> <td> ".$row[4]." </td> <td> ".$row[5]." </td>";
   $sum2 += $row[4];
}
echo "</table> <h2> Subtotal: ".$sum2." paginas. Monto: ".$sum2*0.4." pesos </h2>";
$suma = ($sum + $sum2);
echo "<hr> <h2 style='color:blue'> Cantidad de paginas: <U><b style='color:navy'>".$suma."</b></u>. Monto adeudado: <U><b  style='color:red;font-size:40'>".$suma*0.4."</b></u> </h2>";
}
?>
