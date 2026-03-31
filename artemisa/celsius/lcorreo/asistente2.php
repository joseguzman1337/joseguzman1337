<?
      
   include_once Obtener_Direccion()."conexion.inc.php";  
   Conexion();	
   include_once Obtener_Direccion()."identif.php"; 
   Administracion();
   
 ?>
<html>

<head>
<title>Pagina nueva 1</title>
</head>

<?
    
  include_once Obtener_Direccion()."fgenhist.php";
  include_once Obtener_Direccion()."fgentrad.php";


    $Mensajes = Comienzo ("lco-001",$IdiomaSitio);  
    $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
   
?>

<script language="JavaScript">
	function paso_siguiente()
	{
	   document.form1.action="envio.php";
	   document.form1.submit();
	}
	
	function cambiar_Plantilla()
	{
		document.form1.action = "asistente2.php";
		document.form1.submit();
	}
	
	function ver_Aplicado()
	{
		if (document.form2.ListaUsuarios.selectedIndex>=0)
		{
		   objeto = document.form2.ListaUsuarios.options[document.form2.ListaUsuarios.selectedIndex];
		   usuario = objeto.value;
		   texto = document.form1.Texto.value;
		   textomando="";
		   
		   for (i=0;i<=texto.length-1;i++)
		   {
		   	if (texto.charCodeAt(i)!=13 && texto.charCodeAt(i)!=10)
			{
			  textomando=textomando+texto.charAt(i);
			}
			else
			{ if (texto.charCodeAt(i)==13)
			  {
			    textomando = textomando + "<13>";
			  }
			}
		   }
		   asunto = document.form1.Asunto.value;
		   ventana=window.open("ver_aplica.php?usuario="+usuario+"&texto="+textomando+"&asunto="+asunto, "Eventos", "dependent=yes,toolbar=no,width=530 height=340");
   		}
		else
		{
			alert ("<? echo $Mensajes["me-2"]?>");
		}
	}
	function envio_mail()
	{
	  document.form1.action = "envio.php";
	  document.form1.submit();
	}
</script>

<body>
 <div align="center">
   <table align="center" width="55%" bgcolor="#424880" cellspacing="0">
		<tr bgcolor="#FFFF93">
			<td align="center" width="100%" colspan="4"><b>
		     <font face="MS Sans Serif" size="1+" color="#6060B0">
				<? echo $Mensajes["tf-5"]; ?>
			 </b></font>	
			</td>
		</tr>
		<tr>	
			<td colspan="2">
				&nbsp;
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
  // Al no admitir un SELECT INTO, filtro por el string
  // envio recibe un string con los Id empaquetados entre corchetes
 
  if ($envio!="")
  {
    
   $expresion = "SELECT Apellido,Nombres,Usuarios.Id,MIN(Pedidos.Fecha_Recepcion)";
   $expresion .= ",COUNT(*),Usuarios.EMail FROM Usuarios";
   $expresion .= " LEFT JOIN Pedidos ON Pedidos.Codigo_Usuario=Usuarios.Id";
   $expresion .= " WHERE Pedidos.Estado=".Devolver_Estado_Recibido();
   $expresion .= " GROUP BY Pedidos.Codigo_Usuario ORDER BY Usuarios.Apellido,Usuarios.Nombres";
   
   $result = mysql_query($expresion);
   echo mysql_error();
   
   
?></p>
<div align="center">
  <center>

<form name="form2">
<table border="0" width="55%" cellspacing="0">   
  <tr>
   <td align="center" bgcolor="#1C74A4">
     <font face="MS Sans Serif" size="1+" color="#FFFF80">
   		<b><? echo $Mensajes["tf-8"]." ".$contador; ?></b>
	 </font>	
   </td>
  </tr>
  <tr>
     <td bgcolor="#1C74A4" valign="middle" align="center">
	 	<select name="ListaUsuarios" size="8" multiple style="font-family: MS Sans Serif; font-size: 10 px">
		<?  $contador = 0;
		    while($row = mysql_fetch_row($result))
     		{ 
			  
			  if (!(strpos($envio,"[".$row[2]."]")===false))
			  {
			    $Leyenda = $row[0].",".$row[1]." [".$row[4]."] - ".$row[3];
				
				?>
			   <option value="<? echo $row[2]; ?>"><? echo $Leyenda; ?></option>
			   
		<?	   $contador++;
			  }	 
			}
			
			?>	
		</select>
     </td>
  </tr>  
   <tr>
   <td align="center" bgcolor="#1C74A4">
     <font face="MS Sans Serif" size="1+" color="#FFFF80">
   		<b><? echo $Mensajes["tf-4"]." ".$contador; ?></b>
	 </font>	
   </td>
  </tr>
  
</table>
 </form>

  </center>
</div>

   
<div align="center">
  <center>
  
  <?
    if ($Plantilla=="")
    {
      $Instruccion = "SELECT Denominacion,Texto,Id FROM Plantmail" ;
    }
    else
    {  
	   $Instruccion = "SELECT Denominacion,Texto FROM Plantmail WHERE Id=".$Plantilla;
	 }  
   	 $result = mysql_query($Instruccion);
	 echo mysql_error();    		   
	 $row = mysql_fetch_array($result);
	 if ($Plantilla == "")
	 {
	 	$Plantilla = $row[3];
	 }
    
  ?>
  
<form method="POST" name="form1">

<table border="0" width="65%" height="1" cellspacing="0" bgcolor="#AFDDFE" cellpadding="3">
  
  <center>
  
  <tr>
    <td width="20%" height="15" valign="top" align="right">
    <font face="MS Sans Serif" size="1">
    
    <?
	 // Ahora me ocupo de recuperar la plantilla adecuada de acuerdo 
    // al tipo de evento generado y reemplazar los caracteres variables
    // de la misma
    $Instruccion = "SELECT Id,Denominacion FROM Plantmail";
   	 $result = mysql_query($Instruccion);
	 echo mysql_error();    		   
   	 
    		
    echo $Mensajes["et-1"]; ?></font>
    </td>
  </center>

    <td width="80%" height="15" valign="top" colspan="2" align="left">
    <font face="MS Sans Serif" size="1">

    <select size="1" name="Plantilla" OnChange="cambiar_Plantilla()">
        <?
    		while ($roww = mysql_fetch_array($result))
    		{
    			if ($roww[0]==$Plantilla)
    			{
    		?>
    			<option value=<? echo $roww[0]; ?> selected><? echo $roww[1]; ?></option>
    		<?      		    
    		    }
    		    else
    		    {
    		 ?>
    			<option value=<? echo $roww[0]; ?>><? echo $roww[1]; ?></option>
    	     <?   }	    	
    		 }
    	?>
    </select>
    </font>
    </td>
  </tr> 
  <tr>
    <td width="20%" height="15" valign="top" align="right">
        <font face="MS Sans Serif" size="1">
        <? echo $Mensajes["et-2"]; ?></font>
    </td>
    <td width="80%" height="15" valign="top" colspan="2" align="left">
    <font face="MS Sans Serif" size="1">
    <input type="text" name="Asunto" size="51" value="<? echo $row[0]; ?>" >
    </font>
    </td>
  </tr>
  <tr>
    <td width="20%" height="15" valign="top" align="right">
     <font face="MS Sans Serif" size="1">
     <? echo $Mensajes["et-3"]; ?></font>
     </td>
    <td width="80%" height="15" valign="top" colspan="2" align="center">
     <font face="MS Sans Serif" size="1">
     <textarea rows="8" cols="44" name="Texto"><? echo $row[1]; ?></textarea>
     </font>
    </td>
  </tr>
  <tr>
    <td width="20%" height="15" valign="top" align="right">
   &nbsp;
    </td>
    <td width="80%" height="15" valign="top" align="center" colspan="2">
	<input type="button" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold" value="<? echo $Mensajes["bot-4"]; ?>" OnClick="ver_Aplicado()">
	<input type="button" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold" value="<? echo $Mensajes["bot-2"]; ?>" OnClick="envio_mail()">
   
    </td>
  </tr>
  <tr>
    <td width="25%" height="15" valign="top" align="right">
     &nbsp;
    </td>
    <td width="75%" height="15" valign="top" align="center" colspan="2">
     &nbsp;
    </td>
  </tr>
</table>

 <input type="hidden" name="envio" value="<? echo $envio; ?>">
    
</form>
</div>
<?
 
   mysql_free_result($result);
   Desconectar();	
 }  
?>
<P ALIGN="center"><FONT FACE="MS Sans Serif" SIZE="1"><FONT COLOR="#000080">cp:</FONT>lco-001</FONT></P>

</body>

</html>



































