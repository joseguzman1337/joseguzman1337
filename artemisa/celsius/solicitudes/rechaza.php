<?

   include_once "../inc/var.inc.php";
   include_once "../inc/"."conexion.inc.php";  
   Conexion();	
   include_once "../inc/"."identif.php"; 
   include_once "../inc/"."fgenped.php";
   include_once "../inc/"."fgentrad.php"; 
   Administracion();
   global $IdiomaSitio;
   $Mensajes = Comienzo ("rus-001",$IdiomaSitio);  
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
	if (! isset($Pantilla) ) $Plantilla="";
   
 ?>

 <html>

<head>
<title>PrEBi</title>
<style type="text/css">
<!--
body {
	background-color: #006599;
	margin-left: 10px;
	margin-right:0px; margin-top:0px; margin-bottom:0px
}
body, td, th {
	color: #000000;
}
a:link {
	color: #006599;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #006599;
}
a:hover {
	text-decoration: underline;
	color: #0099FF;
}
a:active {
	text-decoration: none;
	color: #006599;
}
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 9px; }
.style28 {color: #FFFFFF; font-size: 11px; }
.style55 {
	font-size: 10px;
	color: #000000;
	font-family: Verdana;
}
.style60 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
.style1 {	color: #FFFFFF;
	font-family: Verdana;
	font-size: 10px;
}
.style61 {color: #000000}
.style33 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
.style34 {
	color: #FFFFFF;
	font-weight: normal;
	font-family: Verdana;
	font-size: 9px;
}
.style22 {
	color: #333333;
	font-family: verdana;
	font-size: 9px;
}
.style45 {
	font-family: Verdana;
	color: #FFFFFF;
	font-size: 10px;
}
-->
</style>
</head>
 <script language="JavaScript">
	function paso_siguiente()
	{
	   document.forms.form1.action="envio.php";
	   document.forms.form1.submit();
	}
	
	function cambiar_Plantilla()
	{
		document.forms.form1.action = "rechaza.php";
		
	    document.forms.form1.elements.Operacion.value = 0;
		document.forms.form1.submit();
	}
	
	function envio_mail()
	{
	  document.forms.form1.action = "rechaza.php";
	  document.forms.form1.elements.Operacion.value = 1;
	  document.forms.form1.submit();
	}
	
	function rechaza_solo()
	{
	  document.forms.form1.action = "rechaza.php";
	  document.forms.form1.elements.Operacion.value = 2;
	  document.forms.form1.submit();
	}
</script>


<base target="_self"> 

</head>
<body >
<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5" bgcolor="#EFEFEF" >
      <tr bgcolor="#EFEFEF">
        <td valign="top" bgcolor="#E4E4E4">
            <div align="center">
              <center>
			  <?
	        switch ($Operacion)
		   {
		      case 0:
		      ?>
                <table width="97%" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
					<tr align="left" valign="middle" bgcolor="#66CCFF">
						<td height="20" bgcolor="#006699"><div align="center" class="style28"><div align="left" class="style1"><img src="../images/square-lb.gif" width="8" height="8"><? echo $Mensajes["tf-1"]; ?></div></div></td>
                   </tr>
                   <tr align="left" valign="middle">
						<td>
							<form name="form1">
							<input type="hidden" name="Id" value="<? echo $Id; ?>">
							<input type="hidden" name="Operacion" >
							<?
								// Proviene con Id es decir el Id de la tabla de solicitudes
								// Los únicos datos que interesan son los relativos al usuario
								// y su dirección de correo
								
							   $expresion = "SELECT Apellido,Nombres,EMail ";
							   $expresion = $expresion."FROM Candidatos ";
							   $expresion = $expresion."WHERE Candidatos.Id = ".$Id;
							   $result = mysql_query($expresion);
							   $row = mysql_fetch_row($result);
							   $Nombre = $row[0].", ".$row[1];
							   $Direccion = $row[2];
							   
							  
								if (! isset($Pantilla) &&($Plantilla==""))
								{
								  $Instruccion = "SELECT Denominacion,Texto,Id FROM Plantmail WHERE Cuando_Usa=101" ;
								}
								else
								{  
								   $Instruccion = "SELECT Denominacion,Texto FROM Plantmail WHERE Id=".$Plantilla;
								 }  
								 $result = mysql_query($Instruccion);
								 echo mysql_error();    		   
								 $row = mysql_fetch_array($result);
								 $Texto = reemplazar_variables ($row[1],"",$Nombre,"","","","","","");
								
							  ?>
								<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ECECEC">
									<tr>
									  <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61">
										<?
										 // Ahora me ocupo de recuperar la plantilla adecuada de acuerdo 
										// al tipo de evento generado y reemplazar los caracteres variables
										// de la misma
										$Instruccion = "SELECT Id,Denominacion,Cuando_Usa FROM Plantmail";
										$result = mysql_query($Instruccion);
										echo mysql_error();    		   
										echo $Mensajes["et-1"]; ?></div>
										</td>
										<td height="18" bgcolor="#ECECEC" class="style55"><div align="left">
										
										 <select size="1" name="Plantilla" OnChange="cambiar_Plantilla()" class="style55">
											<?
												while ($roww = mysql_fetch_array($result))
												{
													if ($Plantilla=="" && $roww[2]==101)
													{
														$Plantilla=$roww[0];
													}
													
													if ($roww[0]==$Plantilla )
													{
												?>
													<option value="<? echo $roww[0]; ?>" selected><? echo $roww[1]; ?></option>
												<?      		    
													}
													else
													{
												 ?>
													<option value="<? echo $roww[0]; ?>"><? echo $roww[1]; ?></option>
												 <?   }	    	
												 }
											?>
										 </select></div></td>
										
									</tr>

									<tr>
									  <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["et-2"]; ?></div>
										</td>
										<td height="18" bgcolor="#ECECEC" class="style55"><div align="left">
										 <input type="text" name="Direccion" size="51" value="<?  if (isset($Direccion)) echo $Direccion; ?>" class="style55">
										</div></td>
										
									</tr>
									<tr>
									  <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["et-3"]; ?></div>
										</td>
										<td height="18" bgcolor="#ECECEC" class="style55"><div align="left">
										  <input type="text" name="Asunto" size="51" value="<? if (isset($row))echo $row[0]; ?>"  class="style55">
										</div></td>										
									</tr>
									<tr>
									  <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["et-4"]; ?></div>
										</td>
										<td height="18" bgcolor="#ECECEC" class="style55"><div align="left">
										  <textarea rows="8" cols="44" name="Texto" class="style55"><? if (isset($Texto)) echo $Texto; ?></textarea> 
										</div></td>										
									</tr>

									<tr>
									  <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["et-4"]; ?></div>
										</td>
										<td height="18" bgcolor="#ECECEC" class="style55"><div align="left">
										  <input type="button" value="<? echo $Mensajes["bot-2"]; ?>" OnClick="envio_mail()" class="style55"> 
										   <input type="button" class="style55" value="<? echo $Mensajes["bot-3"]; ?>" OnClick="rechaza_solo()">
										</div></td>
										
									</tr>

	
								</table>

							</form>
							
						</td>
					</tr>
					<tr><td colspan=2 align=center>&nbsp;</td>
					</tr>
					<tr>
						<td colspan=2 align=center><a href="administrar_usuarios.php"><span class="style33">&nbsp;<? echo $Mensajes["h-2"]; ?></span></a></td>
					</tr>
					<tr><td colspan=2 align=center>&nbsp;</td>
					</tr>

				<? 
			   mysql_free_result($result);
			   break;
			       
			  case 1:
			  

				mail ($Direccion,$Asunto,$Texto,"From:".Destino_Mail());
			    $Instruccion = "update Candidatos set rechazados=2  WHERE Id='".$Id."'";
				$result = mysql_query($Instruccion);
			    echo mysql_error();   
				$Leyenda = $Mensajes ["tf-2"];
				break;
				
			 case 2:
			 
			    $Instruccion = "update Candidatos set rechazados=2  WHERE Id='".$Id."'";
			    $result = mysql_query($Instruccion);
			    echo mysql_error();   
				$Leyenda = $Mensajes ["tf-3"];
				break;
			 
						   
			}
			
			if ($Operacion != 0){?>
				<table width="97%" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
					<tr align="left" valign="middle" bgcolor="#66CCFF">
						<td height="20" bgcolor="#006699"><div align="center" class="style28"><div align="left" class="style1"><img src="../images/square-lb.gif" width="8" height="8"><? echo $Mensajes["tf-1"]; ?></div></div></td>
                   </tr>
				   <tr align="left" valign="middle">
						<td>
						<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ECECEC">
									<tr>
										<td height="18" bgcolor="#ECECEC" class="style55"><div align="left">
										<? echo $Leyenda;  ?></div></td>
									 </tr>
									<tr>
										<td align=center><a href="administrar_usuarios.php"><span class="style33">&nbsp;<? echo $Mensajes["h-2"]; ?></span></a></td>
									</tr>
						</table>

					
				
			
			<?}?>

				</td>
				</tr>
				</table>
			  </center>
			  </div>
		</td>
		<td width="150"  bgcolor="#E4E4E4" valign="top"><div align="center" class="style11">
			 <table width="100%" bgcolor="#ececec">
				<tr>
				  <td class="style28"><span class="style55"><img src="../images/image001.jpg" width="150" height="118"></span></td>
				</tr>
				<tr><td align="center"><a href="../admin/indexadm.php"><span class="style33"><? echo $Mensajes["h-1"];?></span></a></td></tr>
			   <tr><td>&nbsp;</td></tr>
			  </table>
			  </td>
	 </tr>
	 </table>
    </center>
   </div>
 </td>
</tr>
 
  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">
      <hr>
       
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100"  border="0" lowsrc="../PrEBi%20:%20UNLP"></a></div></td>
          <td width="50"><div align="right" class="style33">rus-001</div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
<?  Desconectar();	?>
</body>
</html>
