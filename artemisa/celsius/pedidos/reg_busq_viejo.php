<? 
   
  include_once "../inc/var.inc.php";
 include_once "../inc/"."conexion.inc.php";  
 Conexion();

 include_once "../inc/"."identif.php";
 Administracion();
 if (!isset($deDonde)){$deDonde=0;}

if ($deDonde==0)
{
    include_once "../inc/"."fgenped.php";
    include_once "../inc/"."fgentrad.php";
    global $IdiomaSitio;
	$Mensajes = Comienzo ("bus-002",$IdiomaSitio); 
	 	
	// Armo el select de la busqueda, si no existe el registro
	// implica que es un alta, cc es modificación de una búsqueda
   $Instruccion = "SELECT Fecha,Usuarios.Apellido,Usuarios.Nombres";
   $Instruccion .=",Resultado,Busquedas.Comentarios FROM Busquedas LEFT JOIN Usuarios ON Usuarios.Id=Busquedas.Id_Usuario";
   $Instruccion .=" WHERE Id_Pedido='$Id_Pedido'";
   $Instruccion .=" AND Id_Catalogo=$Id_Catalogo";


   $result = mysql_query($Instruccion);   
   echo mysql_error();
   if (mysql_num_rows($result)>0)
    {
		$row = mysql_fetch_row($result);
		$NombreUsuario = $row[1].",".$row[2];	
		$existe=1;
	}
	else
	{
	    $Dia = date ("d");
        $Mes = date ("m");
        $Anio = date ("Y");
		$row=array('','','','','');
        $row[0] =$Anio."-".$Mes."-".$Dia;
   		$NombreUsuario=$Usuario;
		$existe=0;
	}
?> 
<html>
<head>
<title><? echo Titulo_Sitio();?></title>
</head>
<script language="JavaScript">
	function cancelar()
	{
		form1.deDonde.value=3;
		form1.submit();
	}
</script>
<body>
<form action="reg_busq.php" method="post" name="form1">
<TABLE align=center bgColor=#c0c0c0 width="85%">
	<tr>
		<td width="100%" height="18" colspan="2" bgcolor="#006699" align="center"><font face="Ms Sans Serif" size="1" color="#ffff66"><? echo $Mensajes["tf-1"]." <b>".$Id_Pedido." -><br> ".$Nombre_Catalogo."</b>"; ?></font></td>
	</tr>
	<tr>
		<td width="100%" colspan="2">&nbsp;</td>
	</tr>	
	<tr>
		<td width="30%" height="18" align="right"><font face="Ms Sans Serif" size="1"><? echo $Mensajes["tf-2"];?></font></td>
		<td width="70%" height="18"><input type="text" name="Fecha" size="15" value="<? echo $row[0]; ?>"></td>
	</tr>
	<tr>
		<td width="100%" colspan="2">&nbsp;</td>
	</tr>	
	<tr>
		<td width="30%" height="18" align="right" valign="top"><font face="Ms Sans Serif" size="1"><? echo $Mensajes["tf-3"];?></font></td>
		<td width="70%" height="18">
			<input type="radio" name="Resultado" value="1" <? if ($row[3]==1) { echo " checked";} ?>><font face="Ms Sans Serif" size="1"><? echo $Mensajes["res-1"];?><br>
			<input type="radio" name="Resultado" value="2" <? if ($row[3]==2) { echo " checked";} ?>><? echo $Mensajes["res-2"]?><br>
			<input type="radio" name="Resultado" value="3" <? if ($row[3]==3) { echo " checked";} ?>><? echo $Mensajes["res-3"]?><br>
			<input type="radio" name="Resultado" value="0" <? if ($row[3]==0) { echo " checked";} ?>><? echo $Mensajes["res-4"]?></font>
		</td>
	</tr>
	<tr>
		<td width="100%" colspan="2">&nbsp;</td>
	</tr>	
	<tr>
		<td width="30%" height="18" align="right"><font face="Ms Sans Serif" size="1"><? echo $Mensajes["tf-4"];?></font></td>
		<td width="70%" height="18"><font face="Ms Sans Serif" size="1" color="#000080"><? echo "<b>".$NombreUsuario."</b>"; ?></font></td>
	</tr>
	<tr>
		<td width="30%" height="18" valign="top" align="right"><font face="Ms Sans Serif" size="1"><? echo $Mensajes["tf-5"];?></font></td>
		<td width="70%" height="18"><textarea rows="4" name="Comentarios" cols="38"><? echo $row[4];?></textarea></td>
	</tr>
	<tr>
		<td width="100%" colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td width="100%" height="18" colspan="2" align="center">
	      <input type="submit" value="<? echo $Mensajes["bot-1"]; ?>" name="B1" >
          <input type="button" value="<? echo $Mensajes["bot-2"]; ?>" name="B2"  OnClick="cancelar()">
		  <input type="hidden" name="deDonde" value="2">
		  <input type="hidden" name="existe" value="<? echo $existe; ?>">
		  <input type="hidden" name="Id_Pedido" value="<? echo $Id_Pedido; ?>">
		  <input type="hidden" name="Id_Catalogo" value="<? echo $Id_Catalogo; ?>">
  		  <input type="hidden" name="Id_Pedido" value="<? echo $Id_Pedido; ?>">
		</td>
	</tr>
	<tr>
		<td width="100%" colspan="2">&nbsp;</td>
	</tr>	
</TABLE>
</form>
<? } else {
// Operaciones de actualización
// si apreta cancelar es 3
if ($deDonde!=3)
{

  if ($Resultado==0)
  {
	$Fecha=""; 
  }

  if ($existe==1)
  {
	$Instruccion = "UPDATE Busquedas SET Fecha='$Fecha',Id_Usuario=$Id_usuario,Resultado=$Resultado,Comentarios='$Comentarios'";
	$Instruccion.= " WHERE Id_Pedido='$Id_Pedido' AND Id_Catalogo=$Id_Catalogo";
	mysql_query ($Instruccion);
	echo mysql_error();
  }
  else
  {
	$Instruccion = "INSERT INTO Busquedas (Id_Pedido,Id_Catalogo,Fecha,Id_Usuario,Resultado,Comentarios)";
	$Instruccion.= " VALUES ('$Id_Pedido',$Id_Catalogo,'$Fecha',$Id_usuario,$Resultado,'$Comentarios')";
	mysql_query ($Instruccion);
	echo mysql_error();
  }
}
// Del if de deDonde  

header ("Location: pres_busq.php?Id_Pedido=$Id_Pedido");

}  

   Desconectar();

?>
<p ALIGN="center">&nbsp;<FONT FACE="MS Sans Serif" SIZE="1"><FONT COLOR="#000080">cp:</FONT>bus-002</FONT>
</body>
</html>

