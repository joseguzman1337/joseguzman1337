<?
   include_once "../inc/var.inc.php";
   include_once "../inc/"."conexion.inc.php";  
   Conexion();	
   include_once "../inc/"."identif.php"; 
   Administracion();
  
   
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>PrEBi</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
.style43 {
	font-family: verdana;
	font-size: 10px;
}
.style45 {
	font-family: Verdana;
	color: #FFFFFF;
	font-size: 9px;
}
.style49 {font-family: verdana; font-size: 10px; color: #006599; }
.style55 {
	font-size: 10px;
	color: #000000;
	font-family: Verdana;
}
.style33 {	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
.style58 {font-size: 9px}
.style60 {font-family: Arial}
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<? 
  include_once "../inc/fgentrad.php";	
  include_once "../inc/fgenped.php";
  global $IdiomaSitio;
 $Mensajes = Comienzo ("lco-001",$IdiomaSitio);  

	
?>	
<script language="JavaScript">
	function paso_siguiente()
	{
	   maximo = document.forms.form2.ListaUsuarios.length;
	   envio = "";
	   for (i=0;i<maximo;i++)
	   {
	     objeto = document.forms.form2.ListaUsuarios.options[i];
		 if (objeto.text.indexOf("--NM")<0)
		 {
		  envio=envio+"["+document.forms.form2.ListaUsuarios.options[i].value+"]";
		 } 
	   }
	   if (envio.length>0)
	   {
	     document.forms.form1.envio.value = envio;
	     document.forms.form1.action="asistente2.php";
	     document.forms.form1.submit();
		}
		else
		{
		 alert ("<? echo $Mensajes["me-1"]?>");
		} 
	}
	
	function elimino_opcion()
	{
	  for (i=0;i<document.forms.form2.ListaUsuarios.length;i++)
	   {
	     objeto = document.forms.form2.ListaUsuarios.options[i];
		 if (objeto.selected)
		 {
		 	document.forms.form2.ListaUsuarios.options[i]=null;
			
		 }
	   }
	   
	}
	
</script>
<div align="left">

  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">      <div align="center"><center>
        <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td align="center" valign="top" bgcolor="#E4E4E4">
            <div align="center">
              <center>
            <table width="576" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td valign="top" bgcolor="#E4E4E4"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="style43">
                  <tr>
                    <td colspan="3" align="left" class="style45">
                      <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td valign="top"><div align="center">
						    <form method="POST" name="form1" >
                            <table width="95%"  border="0" cellpadding="1" cellspacing="1">
                              <tr>
                                <td colspan="2" bgcolor="#006699" class="style45"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["tf-1"]; ?></td>
                                </tr>
                              <tr>
                                <td width="150" class="style49"><div align="right"><? echo $Mensajes["tf-2"]; ?></div></td>
                                <td class="style43"><div align="left">
								  <select name="Numero_Correos" id="Numero_Correos" class="style43">
									<option value="1" <? if ( isset($Numero_Correos) && $Numero_Correos==1) { echo "selected"; }?>>1+</option>
									<option value="2" <? if (isset($Numero_Correos) && $Numero_Correos==2) { echo "selected"; }?>>2+</option>
									<option value="3" <? if (isset($Numero_Correos) && $Numero_Correos==3) { echo "selected"; }?>>3+</option>
									<option value="4" <? if (isset($Numero_Correos) && $Numero_Correos==4) { echo "selected"; }?>>4+</option>
									<option value="5" <? if (isset($Numero_Correos) && $Numero_Correos==5) { echo "selected"; }?>>+4</option>
								 </select>
                                </div></td>
                              </tr>
							  <tr>
                                <td width="150" class="style49"><div align="right"><? echo $Mensajes["tf-3"]; ?></div></td>
                                <td class="style43"><div align="left">
								  <input type="text"  name="Numero_Dias" size="3" value="<? if (!isset($Numero_Dias) ||  ($Numero_Dias=="")) { echo "5"; } else { echo $Numero_Dias; }?>" class="style43">
                                </div></td>
                              </tr>
                              
                              <tr>
                                <td width="150" class="style49"><div align="right"></div><div align="center"></div></td>
                                <td class="style49">															    	<input type="submit" value="<? echo $Mensajes["bot-1"]?>" class="style43"></td>
                              </tr>
							  </table>
							  </form>

							  <?   
								  if ( isset($Numero_Correos) &&  $Numero_Correos!="")
								  {
								   $expresion = "SELECT Apellido,Nombres,Usuarios.Id,MIN(Pedidos.Fecha_Recepcion)";
								   $expresion .= ",COUNT(*),Usuarios.EMail FROM Usuarios";
								   $expresion .= " LEFT JOIN Pedidos ON Pedidos.Codigo_Usuario=Usuarios.Id";
								   $expresion .= " WHERE Pedidos.Estado=".Devolver_Estado_Recibido();
								   $expresion .= " GROUP BY Pedidos.Codigo_Usuario ORDER BY Usuarios.Apellido,Usuarios.Nombres";
								   
								   
								   $result = mysql_query($expresion);
								   echo mysql_error();
								   
								   
							 ?> 
							   <form name="form2">
								<table width="95%"  border="0" cellpadding="1" cellspacing="1">

								 
								<tr align="center">
									<td width="150" class="style22"><div align="right">&nbsp;</div></td>
									<td class="style33"><div align="left">
								  <select name="ListaUsuarios" size="15" class="style43">
								  <?  
									$Dia = date ("d");
									$Mes = date ("m");
									$Anio = date ("Y");
									$FechaHoy =$Anio."-".$Mes."-".$Dia;

								
									$contador = 0;
									$SinMail = 0;
									while($row = mysql_fetch_row($result))
									{ 
									  $Dias = calcular_dias($row[3],$FechaHoy);
									  if ($row[4]>=$Numero_Correos && $Dias>=$Numero_Dias)
									  {
										$Leyenda = $row[0].",".$row[1]." [".$row[4]."] - ".$row[3];
										if ($row[5]=="")
										{
											$Leyenda .= " --NM";
											$SinMail+=1;
										}
										?>
									   <option value="<? echo $row[2]; ?>"><? echo $Leyenda; ?></option>
									   <?
									   $contador++;
									  }	 
									}
									$MailsaEnv = $contador - $SinMail;
									if ($MailsaEnv<0)
									{
										$MailsaEnv=0;
									}
									?>	
								  </select>

								</div></td></tr>
								<tr align="center">
									<td width="150" class="style49"><div align="right"><? echo $Mensajes["tf-4"]; ?></div></td>
									<td class="style43" valign="top"><div align="left"><? echo $contador; ?></div></td>
								</tr>
								<tr align="center">
									<td width="150" class="style49"><div align="right"><? echo $Mensajes["tf-6"]; ?></div></td>
									<td class="style43" valign="top"><div align="left"><? echo $SinMail; ?></div></td>
								</tr>
								<tr align="center">
									<td width="150" class="style49"><div align="right"><? echo $Mensajes["tf-7"]; ?></div></td>
									<td class="style43" valign="top"><div align="left"><? echo $MailsaEnv; ?></div></td>
								</tr>
								<tr align="center">
									<td width="150" class="style22"><div align="right">&nbsp;</div></td>
									<td class="style33"><div align="left"><input type="button"  value="<? echo $Mensajes["bot-3"]?>" OnClick="elimino_opcion()" class="style43"><input type="button"  value="<? echo $Mensajes["bot-2"]?>" OnClick="paso_siguiente()" class="style43"></div></td>
								</tr>
							   

								
							  </table>
							  </form>
							  
  
							  <?
								   mysql_free_result($result);
								}?>
								
                            
                            </div>                            
                            </td>
                          </tr>
                      </table>
                    </td>
                  </tr>
                </table>                  </td>
              </tr>
            </table>
			<?
	Desconectar(); 
?>
              </center>
            </div>            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td class="style28"><div align="center"><img src="../images/image001.jpg" width="150" height="118"><br>
                  <span class="style33"><a href="../admin/indexadm.php"><? echo $Mensajes["h-1"];?></a></span> </div>                <div align="center" class="style55"></div></td>
            </tr>
          </table>
          </div>
          </td>
        </tr>
    </table>    </center>
      </div>    </td>
  </tr>

 
  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">      
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50" class="style49"><div align="center" class="style11">lco-001</div></td>
        </tr>
      </table>
      </div></td>
  </tr>
</table>
</div>
</body>
</html>