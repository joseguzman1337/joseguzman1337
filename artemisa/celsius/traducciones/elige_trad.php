<?
   include_once "../inc/var.inc.php";
   include_once "../inc/conexion.inc.php";  
   Conexion();	
   include_once "../inc/identif.php"; 
   Administracion();
  
   if (! isset($IdiomaPivot))		$IdiomaPivot="";
    include_once "../inc/"."fgenped.php";
    include_once "../inc/"."fgentrad.php";
	global $IdiomaSitio; 
    $Mensajes = Comienzo ("fie-001",$IdiomaSitio);  
    $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);

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
a:javascript{
	text-decoration: underline;
	color: #33FFCC;

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
a.style33 {
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
.style58 {font-size: 9px}
.style60 {font-family: Arial}
-->
</style>
<base target="_self">
</head>

<script language="JavaScript">
 function confirmar(Elemento)
 {
   	if (confirm("Con esta operación eliminará la Traduccion seleccionada. Confirma la Operación?"))
 	{
 	  document.forms.form1.operacion.value=2;
 	  document.forms.form1.Elemento.value=Elemento;
 	  document.forms.form1.action="elige_trad.php";
 	  document.forms.form1.submit();
 	  
 	}
 	
 	
 }
 
 function agrega_trad(Elemento,donde)
 { 
 // var str= "form_trad.php?dedonde="+donde+"&Pantalla="+document.forms.form1.Pantalla.value+"&Elemento="+Elemento+"&Idioma_Desc="+document.forms.form1.IdiomaSeleccionado.options[document.forms.form1.IdiomaSeleccionado.selectedIndex].text+"&Codigo_Idioma="+document.forms.form1.IdiomaSeleccionado.value;
   
ventana=window.open("form_trad.php?dedonde="+donde+"&Pantalla="+document.forms.form1.Pantalla.value+"&Elemento="+Elemento+"&Idioma_Desc="+document.forms.form1.IdiomaSeleccionado.options[document.forms.form1.IdiomaSeleccionado.selectedIndex].text+"&Codigo_Idioma="+document.forms.form1.IdiomaSeleccionado.value,"Traducciones","dependent=yes,toolbar=no,width=630, height=280, top=5, left=20");


 }  
 


</script>

<body topmargin="0">
<?
   

	if (isset ($operacion) &&($operacion==2))
	{
		$expresion = "DELETE FROM Traducciones WHERE Codigo_Pantalla='$Pantalla' AND Codigo_Idioma=$IdiomaSeleccionado AND Codigo_Elemento='$Elemento'";
	  $result=mysql_query($expresion);
	}
?>
<div align="left">
<form method="POST" name="form1" action="elige_trad.php">
   <input type="hidden" name="operacion" value=0>
  <input type="hidden" name="Elemento">
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
                            <table width="95%"  border="0" cellpadding="1" cellspacing="1">
                              <tr>
                                <td colspan="2" bgcolor="#006699" class="style45"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes['txt-14']; ?></td>
                                </tr>
                              <tr>
                                <td width="150" class="style49"><div align="right"><? echo $Mensajes['txt-12']; ?>&nbsp;&nbsp;</div></td>
                                <td class="style43"><div align="left"><select size="1" name="Pantalla" class="style43">
									  <?
									  $Instruccion = "SELECT * FROM Pantalla ORDER BY Id";	
									  $result = mysql_query($Instruccion); 
								  
									  while ($row =mysql_fetch_row($result))
									 { 
									   if (isset($Pantalla) &&($row[0]==$Pantalla))
									   {?>
										<option value="<?echo $row[0];?>" selected><?echo $row[0];?></option>
									  <? } else { ?>
									   <option value="<?echo $row[0];?>"><?echo $row[0];?></option>
									 <?
										}  
									  } ?> 
									  </select>
								  
                                </div></td>
                              </tr>

							  <tr>
                                <td width="150" class="style49"><div align="right"><? echo $Mensajes['txt-13']; ?>&nbsp;&nbsp;</div></td>
                                <td class="style43"><div align="left">
									  <select size="1" name="IdiomaPivot"  class="style43">
									  <?
										$Instruccion = "SELECT Id,Nombre FROM Idiomas ORDER BY Nombre";	
										$result = mysql_query($Instruccion); 
							  
										while ($row =mysql_fetch_row($result))
										{ 
										if (isset($IdiomaPivot) &&($row[0]==$IdiomaPivot))
										{?>
											<option value="<?echo $row[0];?>" selected><? echo $row[1]; ?></option>
										<? } else { ?>
										<option value="<?echo $row[0];?>"><? echo $row[1]; ?></option>
										<?
											}  
									} ?>   
									  </select>
								  
                                </div></td>
                              </tr>

							  <tr>
                                <td width="150" class="style49"><div align="right"><? echo $Mensajes['txt-1']; ?>&nbsp;&nbsp;</div></td>
                                <td class="style43"><div align="left">
									   <select size="1" name="IdiomaSeleccionado" class="style43">
										  <?
											 mysql_data_seek ($result,0);
												while ($row =mysql_fetch_row($result))
												{ 
												if (isset($IdiomaSeleccionado) && ($row[0]==$IdiomaSeleccionado))
												{?>
													<option value="<?echo $row[0];?>" selected><? echo $row[1]; ?></option>
												<? } else { ?>
												<option value="<?echo $row[0]; ?>"> <? echo $row[1]; ?></option>
												<?
													}  
											} ?>    
									  </select>
								  
                                </div></td>
                              </tr>
                            
                              <tr>
                                <td width="150" class="style49"><div align="right"></div><div align="center"></div></td>
                                <td class="style49">
							
								<input type="submit" value="Enviar" name="B1" class="style43"><input type="reset" value="Restablecer" name="B2" class="style43">
								</td>
                              </tr>
                            </table>
							<table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0">
								<tr><td>
									<div align="left">
									<?   
								   if ($IdiomaPivot!="" && $IdiomaSeleccionado!="")
								   {  
								   // Obtengo una consulta con los elementos de pantalla 
								   // tipo de material
								   
								   $expresion = "SELECT Elementos.Codigo_Elemento,Elementos.Tipo_Elemento,Traducciones.Texto,Traducciones.Nombre_Archivo,"; 
								   $expresion = $expresion."TradDest.Texto,TradDest.Nombre_Archivo";
								   $expresion = $expresion." FROM Elementos"; 
								   $expresion = $expresion." LEFT JOIN Traducciones ON Elementos.Codigo_Pantalla=Traducciones.Codigo_Pantalla";
								   $expresion = $expresion." AND Elementos.Codigo_Elemento=Traducciones.Codigo_Elemento";
								   $expresion = $expresion." AND Traducciones.Codigo_Idioma=".$IdiomaPivot;
								   $expresion = $expresion." LEFT JOIN Traducciones AS TradDest";
								   $expresion = $expresion." ON Elementos.Codigo_Pantalla=TradDest.Codigo_Pantalla";
								   $expresion = $expresion." AND Elementos.Codigo_Elemento=TradDest.Codigo_Elemento";
								   $expresion = $expresion." AND TradDest.Codigo_Idioma=".$IdiomaSeleccionado;
								   $expresion = $expresion." WHERE Elementos.Codigo_Pantalla='".$Pantalla."'";
								   $expresion = $expresion." ORDER BY Codigo_Elemento";   
								   $result = mysql_query($expresion);
								   
								   echo mysql_error();
									  
								   // El que regula el desplazamiento es el vector de campos que
								   // debería tener
								   //pepe
								   
								  while ($row=mysql_fetch_row($result))
								  {?>
									<br>
									<table width="100%"  border="0" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
									<tr>
										<td height="20"  colspan=2 bgcolor="#0099CC" class="style34" ><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes['txt-2']; ?> <? echo "$row[0] - ".Devolver_Desc_Elem($row[1]); ?></td>
									</tr>
													
									<tr>
										<td class="style22" width="65%" ><div align="left"><? echo $Mensajes['txt-3']; ?></div></td>
										<td class="style22" width="*"><div align="left"> <? echo $row[2]; ?></div></td>
									</tr>
									<tr>
										<td class="style22"><div align="left"><? echo $Mensajes['txt-4']; ?></div></td>
										<td class="style22"><div align="left"> <? echo $row[3]; ?></div></td>
									</tr>

									<tr>
										<td class="style22"><div align="left"><? echo $Mensajes['txt-5']; ?></div></td>
										<td class="style22"><div align="left"> <? echo $row[4]; ?> </div></td>
									</tr>

									<tr>
										<td class="style22"><div align="left"><? echo $Mensajes['txt-6']; ?></div></td>
										<td class="style22"><div align="left"> <? echo $row[5]; ?></div></td>
									</tr>

									<tr>
										<td class="style22"><div align="left"><? echo $Mensajes['txt-7']; ?></div></td>
										<td class="style22"><div align="left"> <? echo $row[5]; ?></div></td>
									</tr>

									<tr class="style33">
										
										<td colspan=2><div align="center" class="style33">
										 <?	   if ($row[4]=="" && $row[5]=="")				  { ?>
													   <a  href="javascript:agrega_trad('<? echo $row[0]; ?>',0)" name="B3" ><? echo $Mensajes['txt-8']; ?> </a> 
													   

												<? } else { ?> 

												     <a  href="javascript:agrega_trad('<? echo $row[0]; ?>',1)"  name="B1" ><? echo $Mensajes['txt-9']; ?> </a> |
													 <a name="B2" href="javascript:confirmar('<? echo $row[0]; ?>')" ><? echo $Mensajes['txt-10']; ?></a>



													 
											 <? } ?> 
											 </div></td>
									</tr>
									<tr><td colspan=2>&nbsp;</td></tr>
								</table>
									<br>
								<?  }  //while 
								  ?>
							 <?  } //if ($IdiomaPivot!="" && $IdiomaSeleccionado!="")
								  ?>
								</div></td></tr>
							
							 </table>
                            </div>                            
                            </td>
                          </tr>
                      </table>
					  </form>
                    </td>
                  </tr>
                </table>                  </td>
              </tr>
            </table>
	
              </center>
            </div>            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td class="style28"><div align="center"><img src="../images/image001.jpg" width="150" height="118"><br>
                  <span class="style33"><a href="../admin/indexadm.php"><? echo $Mensajes['txt-11']; ?></a></span> </div>                <div align="center" class="style55"></div></td>
            </tr>
          </table>
          </div>
          </td>
        </tr>
    </table>    </center>
      </div><br>    </td>
  </tr>
  <?
   include_once "../inc/barrainferior.php";
   DibujarBarraInferior($IdiomaSitio)

  ?>
  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">      
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50" class="style49"><div align="center" class="style11">fie-a01</div></td>
        </tr>
      </table>
      </div></td>
  </tr>
</table>
</div>

</body>
</html>








