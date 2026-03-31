<?
include_once "../inc/var.inc.php";
include_once "../inc/"."conexion.inc.php";  
include_once "../inc/"."parametros.inc.php";  
Conexion();
include_once "../inc/"."identif.php";
Usuario();
include_once "../inc/"."fgentrad.php";	
include_once "../inc/"."fgenped.php";
global $IdiomaSitio;
$Mensajes = Comienzo ("dow-001",$IdiomaSitio);
$VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);

?>
<html>
<head>
       <title><? echo Titulo_Sitio();?></title>
   <style>
      a:link {  font-family: MS Sans Serif, helvetica, charter; font-size: 12px; color: #666699}
      a:hover {  font-family: MS Sans Serif, helvetica, charter; font-size: 12px; color: #FF0000}
      a:visited {  font-family: MS Sans Serif, helvetica, charter; font-size: 12px; color: #666699}
      A.imagen{ color: #666699 }
   </style>
</head>
<body background="../imagenes/banda.jpg" vlink="666699" alink="666699" link="666699">

<?php
   echo "<p> <font face='MS Sans Serif' size='3' color='#000080'> <b>".$Mensajes['et-004']." </b> </font> </p>";
   //echo "<p> Usuario: ".$Id_Usuario." </p>";
   echo "<a href='manpeddown.php?Id_Usuario=".$Id_Usuario."'> Reload page </a><br>";
   $query = "SELECT Archivos_Pedidos.codigo,Archivos_Pedidos.nombre_archivo,Archivos_Pedidos.codigo_pedido,
   Archivos_Pedidos.codigo_PedHist,Archivos_Pedidos.Fecha_Upload 
   FROM Archivos_Pedidos,Pedidos";
   $query .= " WHERE Pedidos.Estado = ".Devolver_Estado_SolicitarPDF()." and
   Archivos_Pedidos.codigo_pedido = Pedidos.id and Pedidos.Codigo_Usuario = ".$Id_Usuario."
   and Archivos_Pedidos.Permitir_Download = 1
   and Pedidos.Archivos_Totales > Pedidos.Archivos_Bajados";
   /*$query .= " UNION ";
   $query .="SELECT Archivos_Pedidos.codigo,Archivos_Pedidos.nombre_archivo,Archivos_Pedidos.codigo_pedido,
   Archivos_Pedidos.codigo_PedHist,Archivos_Pedidos.Fecha_Upload 
   FROM Archivos_Pedidos,Pedidos";
   $query .= " WHERE Archivos_Pedidos.codigo_pedido = Pedidos.id 
   and Archivos_Pedidos.Permitir_Download = 1 and Pedidos.Codigo_Usuario = ".$Id_Usuario; */
   
   $resu = mysql_query($query);
      echo mysql_error();
    
    echo "<table align='center' bgcolor='#0099CC' width='410'>
	      <tr> <td width='100%' align='center' bgcolor='#0099CC' height='1'>
	      <font face='MS Sans Serif' size='1' color='#000080'>".$Mensajes['et-001']."
		  <font face='MS Sans Serif' size='1' color='yellow'> ".mysql_num_rows($resu)."
		  </font> </font> </td> </tr>
		  <tr> <td>";
    
    
    while ($row = mysql_fetch_row($resu))
    { echo "<table border='0' cellspacing='0' cellpadding='0' align='center'>
	         <tr height='50'> <td width='400' bgcolor='#666699' align='center' colspan='3'>
	         <p>";
	?>
	  <a href='farchivos/download.php?Id_Usuario=<?echo $Id_Usuario?>&Id_Archivo=<?echo $row[0]?>&Id_Pedido=
	      <? if ($row[2] != null)
		       echo $row[2];
			 else 
			   echo $row[3];
	         ?>' >
      <img src='../imagenes/adobe.gif' alt="<? echo $Mensajes['et-005'] ?>"> </a>
	         <font face='MS Sans Serif' size='1'><b>
			 <font color='#FFFF99'> <?echo $Mensajes['et-002'] ?> </font>
		     </font> 
		      <?
			 echo " <font face='MS Sans Serif' size='1'>
	         <a href='./farchivos/download.php?Id_Usuario=".$Id_Usuario."&Id_Archivo=".$row[0]."&Id_Pedido=";
			 if ($row[2] != null)
      			 echo $row[2]."' >";
			 else
				 echo $row[3]."'>";  
	         echo "<font color='#000000'>".$row[1]." </font> </a>
	   
			 </font> </p> </td> </tr>";
	  echo "<tr height='35'> <td height='35' bgcolor='#79A7C8' valign='middle' width='200''>
	        <font face='MS Sans Serif' size='1'><b><font color='#FFFF99'> &nbsp; &nbsp; ".$Mensajes['et-003']."
			</font> <font face='MS Sans Serif' size='1' color='#000080'> </td>
			<td height='35' bgcolor='#79A7C8' valign='middle' width='200'> ";
      if ($row[2] != null)
         echo $row[2]."</td>";
      else
         echo $row[3]."</td>";
      echo "</tr>";
      echo "</table> <br>";
    }
    
    echo "</td> </tr> </table>";
?>

<P ALIGN="center"><FONT FACE="MS Sans Serif" SIZE="1"><FONT COLOR="#000080">cp:</FONT>down-001</FONT>
</P>
<?
  Desconectar();

?>
