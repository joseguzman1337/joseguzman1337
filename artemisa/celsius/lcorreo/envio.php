<?
    
   include_once Obtener_Direccion()."conexion.inc.php";  
   Conexion();	
   include_once Obtener_Direccion()."identif.php"; 
   Administracion();
   
 ?>
<html>
<script language="JavaScript">
function ver_Aplicado(IdMail)
	{   ventana=window.open("ver_aplica.php?Idmail="+IdMail, "Eventos", "dependent=yes,toolbar=no,width=530 height=340");
	}
</script>
<head>
<title>Pagina nueva 1</title>
</head>
<?
include_once Obtener_Direccion()."fgenhist.php";
include_once Obtener_Direccion()."fgentrad.php";
 	  
	  $Mensajes = Comienzo ("lco-001",$IdiomaSitio);  
      $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);

?>
<body>
 <div align="center">
   <table align="center" width="55%" bgcolor="#424880" cellspacing="0">
		<tr bgcolor="#FFFF93">
			<td align="center" width="100%" colspan="4"><b>
		     <font face="MS Sans Serif" size="1+" color="#6060B0">
				<? echo $Mensajes["tf-9"]; ?>
			 </b></font>	
			</td>
		</tr>		
		<tr>	
			<td colspan="2" align="center">
			 <font face="MS Sans Serif" size="1+" color="#66ffff">
				<? echo $Mensajes["tf-10"]; ?>
			 </font>	
			</td>
		</tr>
		<tr>
			<td align="center" width="100%" align="center" colspan="2">
			 <a href="../admin/indexadm.php"><font face="MS Sans Serif" size="1+" color="#FFFF80"><? echo $Mensajes["h-1"]; ?></font></a>
			</td>
		</tr>
	</table>
</div>		
<?
function Envio_Mail($Id_usuario,$fecha,$hora,$Direccion,$Asunto,$TextoR,$Nombre,$numero_pedidos,$minima_fecha)
{

		
		$TextoR = reemplazar_variables ($TextoR,"",$Nombre,0,"",$numero_pedidos,$minima_fecha,"","");
   		
  	  	$Instruccion = "INSERT INTO mail (Codigo_usuario,Fecha,Hora,Direccion,Asunto,Texto,Codigo_Pedido)";
  	  	$Instruccion = $Instruccion." VALUES ($Id_usuario,'$fecha','$hora','$Direccion','$Asunto','$TextoR','0')";
		$result = mysql_query($Instruccion);
		$codigo_mail = mysql_insert_id();
  	  	echo mysql_error();
  	  
  	  	mail ($Direccion,$Asunto,$TextoR,"From:".Destino_Mail());
		return $codigo_mail;
		
}
?>

 <div align="center">
 <table border="0" width="55%" cellspacing="0" cellpadding="0" height="155">
  <tr>
    <td width="80%" height="21" valign="middle" align="center" bgcolor="#CDDEFE">
	 &nbsp;
    </td>
  </tr>
 
<?
 if ($envio!="")
  {
	     
   	 $expresion = "SELECT Apellido,Nombres,Usuarios.Id,MIN(Pedidos.Fecha_Recepcion)";
   	 $expresion .= ",COUNT(*),Usuarios.EMail FROM Usuarios";
     $expresion .= " LEFT JOIN Pedidos ON Pedidos.Codigo_Usuario=Usuarios.Id";
     $expresion .= " WHERE Pedidos.Estado=".Devolver_Estado_Recibido();
     $expresion .= " GROUP BY Pedidos.Codigo_Usuario ORDER BY Usuarios.Apellido,Usuarios.Nombres";
	
    $result = mysql_query($expresion);
    echo mysql_error();
   
	  $Dia = date ("d");
      $Mes = date ("m");
      $Anio = date ("Y");
      $fecha =$Anio."-".$Mes."-".$Dia;
     
      $hora = strftime ("%H:%M:%S"); 
	  
	  $contador = 0;
      while($row = mysql_fetch_row($result))
      { 
			  if (!(strpos($envio,"[".$row[2]."]")===false))
			  {
			    $Nombre = $row[0].",".$row[1];
				$codigo =  Envio_Mail($row[2],$fecha,$hora,$row[5],$Asunto,$Texto,$Nombre,$row[4],$row[3]);
				?>
				

  <tr>
    <td width="80%" height="21" valign="middle" align="center" bgcolor="#CDDEFE">
	<font face="MS Sans Serif" size="1" color="#000080">
	<a href="javascript:ver_Aplicado(<? echo $codigo; ?>)"><? echo $Nombre; ?></a>
	</font></td>
    </td>
  </tr>

				
				
			<?
			  }
	  }

  mysql_free_result($result);

  	  
}	  	  
Desconectar();	 
  	 
  	  
?>
  <tr>
    <td width="80%" height="21" valign="middle" align="center" bgcolor="#CDDEFE">
	 &nbsp;
    </td>
  </tr>
</table>

<P ALIGN="center"><FONT FACE="MS Sans Serif" SIZE="1"><FONT COLOR="#000080">cp:</FONT>lco-001</FONT></P>

</body>

</html>

