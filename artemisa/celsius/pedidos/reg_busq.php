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

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><? echo Titulo_Sitio();?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
body {
	margin:0px;
	background-color: #006599;
	margin-left: 10px;
}
body, td, th {
	color: #000000;
}
a:link {
	color: #000000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000000;
}
a:hover {
	text-decoration: underline;
	color: #0099FF;
}
a:active {
	text-decoration: none;
	color: #000000;
}
.style23 {
	color: #000000;
	font-size: 9px;
	font-family: verdana;
}
.style42 {color: #FFFFFF; font-size: 9px; font-family: verdana; }
.style44 {color: #00FFFF}
.style45 {color: #006699}
-->
</style>
<base target="_self">
</head>
<script language="JavaScript">
	function cancelar()
	{
		form1.deDonde.value=3;
		form1.submit();
	}
</script>

<body topmargin="0">
<br>
<br>
<br>
<br>
<br>
<div align="left">
<form action="reg_busq.php" method="post" name="form1">
  <table width="500"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ececec">
    <tr align="center" bgcolor="#0099FF">
      <td height="20" colspan="2" class="style42">
        <? echo $Mensajes["tf-1"]." <span class='style44'>".$Id_Pedido." -></span> ".$Nombre_Catalogo."</b>"; ?>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" height="20" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-2"];?></div></td>
      <td height="20" align="left" valign="middle" bgcolor="#ececec">
	  <input type="text" name="Fecha" class="style23" size="15" value="<? echo $row[0]; ?>">
</td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" height="20" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-3"];?></div></td>
      <td height="20" align="left" valign="middle" bgcolor="#ececec" class="style23">
	  <input type="radio" name="Resultado" class="style23" value="1" <? if ($row[3]==1) { echo " checked";} ?>><? echo $Mensajes["res-1"];?></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" height="20" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"></div></td>
      <td height="20" align="left" valign="middle" bgcolor="#ececec" class="style23"><input type="radio" name="Resultado" class="style23" value="2"  <? if ($row[3]==2) { echo " checked";} ?>><? echo $Mensajes["res-2"]?></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" height="20" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"></div></td>
      <td height="20" align="left" valign="middle" bgcolor="#ececec" class="style23"><input type="radio" name="Resultado" class="style23" value="3" <? if ($row[3]==3) { echo " checked";} ?>><? echo $Mensajes["res-3"]?></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" height="20" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"></div></td>
      <td height="20" align="left" valign="middle" bgcolor="#ececec" class="style23"><input type="radio" name="Resultado" class="style23" value="0" <? if ($row[3]==0) { echo " checked";} ?>><? echo $Mensajes["res-4"]?></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" height="20" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"></div></td>
      <td height="20" align="left" valign="middle" bgcolor="#ececec">&nbsp;</td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" height="20" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-4"];?></div></td>
      <td height="20" align="left" valign="middle" bgcolor="#ececec" class="style23 style45"><? echo "<b>".$NombreUsuario."</b>"; ?></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" height="20" align="right" valign="top" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-5"];?></div></td>
      <td height="20" align="left" valign="middle" bgcolor="#ececec"><textarea rows="4" class="style23" name="Comentarios" cols="38"><? echo $row[4];?></textarea></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td height="20" align="center" bgcolor="#ECECEC" class="style23">
        <div align="center"> </div></td>
      <td height="20" align="center" bgcolor="#ECECEC" class="style23"><div align="left">
      <input type="submit" class="style23" value="<? echo $Mensajes["bot-1"]; ?>" name="B1" >
          <input type="button" class="style23" value="<? echo $Mensajes["bot-2"]; ?>" name="B2"  OnClick="cancelar()">
		  <input type="hidden" name="deDonde" value="2">
		  <input type="hidden" name="existe" value="<? echo $existe; ?>">
		  <input type="hidden" name="Id_Pedido" value="<? echo $Id_Pedido; ?>">
		  <input type="hidden" name="Id_Catalogo" value="<? echo $Id_Catalogo; ?>">
  		  <input type="hidden" name="Id_Pedido" value="<? echo $Id_Pedido; ?>">
</form>  
      </div></td>
    </tr>
  </table>
</div>
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
</body>
</html>
