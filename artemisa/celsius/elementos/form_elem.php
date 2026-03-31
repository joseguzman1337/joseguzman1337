<?
  
  include_once "../inc/var.inc.php";
  include_once "../inc/conexion.inc.php";
   Conexion();	
   include_once "../inc/identif.php";
    include_once "../inc/fgenped.php";
	include_once "../inc/fgentrad.php";
   Administracion();
   
   if (! isset($dedonde ))				$dedonde=0;
   if (! isset($Id ))					$Id=0;
   if (! isset($Codigo_Elemento ))		$Codigo_Elemento=0;
   if (! isset($Codigo_Pagina ))		$Codigo_Pagina=0;
   
    
   global $IdiomaSitio;
   $Mensajes = Comienzo ("fel-001",$IdiomaSitio);
    If ($dedonde==1)
	{	
	  $expresion = "SELECT Codigo_Pantalla,Codigo_Elemento,Tipo_Elemento FROM Elementos WHERE Codigo_Elemento='$Codigo_Elemento' AND Codigo_Pantalla='$Codigo_Pagina'";
	  $result = mysql_query($expresion);
	  
	  $rowg = mysql_fetch_array($result);
	  $Anterior = $Codigo_Elemento;
	  $PaginaAnterior = $Codigo_Pagina;
	  
	 } 	
 ?>


<html>

<head>
<title>PrEBi </title>

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
.style22 {
	color: #333333;
	font-family: verdana;
	font-size: 9px;
}
.style33 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
.style39 {color: #006699}
.style40 {
	color: #FFFFFF;
	font-family: Verdana;
	font-size: 9px;
}
.style41 {color: #006599}
-->
</style>
<base target="_self">
</head>


<body topmargin=0>

<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor=#111111 bgcolor=#EFEFEF style="border-collapse: collapse"><!-- 1 -->
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5"><!-- 2 -->
      <tr bgcolor="#EFEFEF">
        <td valign="top" bgcolor="#E4E4E4">            <div align="center">
              <center>
               <form name="form1" method="POST" action="upd_elemento.php" >
			    <input type="hidden" name="Desc_Loc" size="0">
			   <table width="97%"><!-- 3 -->
				   <tr>
						<td height="20" colspan="2" align="right" valign="middle" bgcolor="#006699" class="style22"><div align="left" class="style40"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["et-1"];?></div></td>
					</tr>
					<tr>
						<td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><?  echo $Mensajes["ec-1"];?></div></td>
						<td width="*" height="20" align="left" valign="top" >
						  <div align="left">
							 <select class="style22" size="1" name="Codigo_Pagina">
								  <?
							 
									  $Instruccion = "SELECT * FROM Pantalla ORDER BY Id";	
									  $result = mysql_query($Instruccion); 
									  
									  while ($row =mysql_fetch_row($result))
									  { 
										
											 if ($row[0]==$Codigo_Pagina || ((isset($rowg) )&& $row[0]==$rowg[0] ))
											 {?>
												<option value="<?echo $row[0];?>" selected><?echo $row[0];?></option>
											  <?  }else { ?>
											   <option value="<?echo $row[0];?>"><?echo $row[0];?></option>
											 <?
												}  
										 
										  } ?> 	       
							</select>
							
						   
						  </div></td>
					  </tr>
					 <tr>
						<td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-2"];?></div></td>
						<td width="*" height="20" align="left" valign="top" ><div align="left">				   <input type="text" class="style22" name="Codigo_Elemento" size="23" value="<? if (isset($rowg))echo $rowg[1]; ?>"> </div></td>
					</tr>


					<tr>
						<td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-3"];?></div></td>
						<td width="*" height="20" align="left" valign="top" ><div align="left">		
						<select size="1" name="Tipo_Elemento" class="style22">
							<? 
							  $vector = Devolver_Elementos();  
							  echo $rowg[2];     
							  
							  while (list($key,$val)=each($vector))
							  {
									if (isset($rowg)){
									if ($val==$rowg[2] || ($dedonde==0 && $val==$Codigo_Elemento))
									{
									?>
										<option value=<? echo $val; ?> selected><? echo $key; ?></option>
									<? 
									}}
									else
									{
									?>
									<option value=<? echo $val; ?>><? echo $key; ?></option>
									<?
									}
									
							  }
										  
							?>
							</select>
						</div></td>
					</tr>

					 <tr>
                    <td colspan="2" class="style22" align="center"><div align="right"></div>                      
                      <div align="center">
					   <input type="hidden" name="Anterior" value="<? echo $Anterior; ?>">
					   <input type="hidden" name="PaginaAnterior" value="<? echo $PaginaAnterior; ?>">
					   <input type="hidden" name="operacion" value="<? echo $dedonde; ?>">
					   <input type="hidden" name="Id" value="<? echo $Id; ?>">
					   

					    <input type="submit" class="style22" value="<? if ($dedonde==0) { echo $Mensajes["bot-1"];} else {echo $Mensajes["bot-2"];} ?>" name="B1">
						<input type="reset" class="style22" value="<? echo $Mensajes["bot-3"];?>" name="B2">                 
                      </div></td>
                    </tr>
				
     
			   
			   </table>	<!-- end tabla 3 -->

			   </form>
			   </center>
			</div>
		</td>

		 <td width="150" valign="top" bgcolor="#Ececec"><div align="center" class="style22">
          <div align="left">
            <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td><div align="center">
                  <p><img src="../images/image001.jpg" width="150" height="118"><br>
                    <span class="style33"><a href="../admin/indexadm.php"><? echo $Mensajes["h-1"];?></a></span></p>
                  </div>                  </td>
              </tr>
            </table>
            </div>
        </div></td>
	  </tr>
	 </table><!-- end tabla 2 -->
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
			  <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
			  <td width="50"><div align="right" class="style33">
				<div align="center">fel-001</div>
			  </div></td>
			</tr>
		  </table>
		</div></td>
	  </tr>
 </table><!-- end tabla 1 -->
</div>

<?
	if (isset($result))
		mysql_free_result($result);
	Desconectar();
?>
</body>
</html>
