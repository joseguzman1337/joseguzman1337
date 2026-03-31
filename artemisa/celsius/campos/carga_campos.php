<?
   include_once "../inc/var.inc.php";
   include_once "../inc/conexion.inc.php";  
   Conexion();	
   include_once "../inc/identif.php"; 
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
    include_once "../inc/"."fgenped.php";
    include_once "../inc/"."fgentrad.php";
	global $IdiomaSitio;
    $Mensajes = Comienzo ("fca-002",$IdiomaSitio);  
    $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  

  if ($Operacion==2)
  {
    $Instruccion = "SELECT Heading,Heading_Abrev,Texto_Ayuda,Mensaje_Error,Campo_Necesario";
    $Instruccion = $Instruccion.",ER_Validacion,Incluye_Desc_Det,Incluye_Desc_Abr FROM Campos";
    $Instruccion = $Instruccion." WHERE Tipo_Material=".$Tipo_Material." AND Numero_Campo=".$NumeroCampo." AND Codigo_Idioma=".$Idioma;
    $result = mysql_query($Instruccion);
    $row=mysql_fetch_row($result);

  }
 ?> 
<div align="left">
<form name="form1" method="post" action="upd_campos.php">
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
                                <td colspan="2" bgcolor="#006699" class="style45"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["tit-1"];?></td>
                                </tr>
                              <tr>
                                <td width="150" class="style49"><div align="right"><?echo $Mensajes["ele-1"];?></div></td>
                                <td class="style43"><div align="left"><?
                                  if ($Tipo_Material<100)
								   {
									 echo Devolver_Tipo_Material($VectorIdioma,$Tipo_Material);
									}
									else
									{
									 echo "*";  
									 }?>
								  
                                </div></td>
                              </tr>
                              <tr>
                                <td width="150" class="style49"><div align="right"><? echo $Mensajes["ele-2"];?></div></td>
                                <td class="style43"><div align="left"><? echo $NumeroCampo; ?>
                                </div></td>
                              </tr>
							   <tr>
                                <td width="150" class="style49"><div align="right"><? echo $Mensajes["ele-11"];?></div></td>
                                <td class="style43"><div align="left"><? echo $IdiomaNombre; ?>
                                </div></td>
                              </tr>

							   <tr>
                                <td width="150" class="style49"><div align="right"><?echo $Mensajes["ele-4"];?>&nbsp;&nbsp;</div></td>
                                <td class="style43"><div align="left">
								  <input type="text" name="Heading" size="37" value="<?  if (isset ($row))echo $row[0]; ?>" class="style43">                                 
                                </div></td>
                              </tr>

							  <tr>
                                <td width="150" class="style49"><div align="right"><?echo $Mensajes["ele-5"];?>&nbsp;&nbsp;</div></td>
                                <td class="style43"><div align="left">
								  <input type="text" name="Heading_Abrev" size="37" value="<? if (isset ($row))echo $row[0]; ?>" class="style43">                              
                                </div></td>
                              </tr>

							  <tr>
                                <td width="150" class="style49"><div align="right"><? echo $Mensajes["ele-10"];?>&nbsp;&nbsp;</div></td>
                                <td class="style43"><div align="left">
								  <textarea rows="8" name="Texto_Ayuda" cols="43" class="style43"><? if (isset ($row))echo $row[2]; ?></textarea>                     
                                </div></td>
                              </tr>

							  <tr>
                                <td width="150" class="style49"><div align="right"><?echo $Mensajes["ele-9"];?>&nbsp;&nbsp;</div></td>
                                <td class="style43"><div align="left">
								  <textarea rows="8" name="Mensaje_Error" cols="43" class="style43" ><? if (isset ($row)) echo $row[3]; ?>
								  </textarea>                     
                                </div></td>
                              </tr>


							  <tr>
                                <td width="150" class="style49"><div align="right"><? echo $Mensajes["ele-8"];?>&nbsp;&nbsp;</div></td>
                                <td class="style43"><div align="left">
								  <input type="text" name="ER_Validacion" size="20" value="<?  if (isset ($row)) echo $row[5]; ?>" class="style43">
                                </div></td>
                              </tr>

                              <tr>
                                <td width="150" class="style49"><div align="right"></div><div align="center"></div></td>
                                <td class="style49">
								<input type="hidden" name="Tipo_Material" value="<? echo $Tipo_Material; ?>">
								<input type="hidden" name="Numero_Campo" value="<? echo $NumeroCampo; ?>">
								<input type="hidden" name="Codigo_Idioma" value="<? echo $Idioma; ?>">
								<input type="hidden" name="IdiomaNombre" value="<? echo $IdiomaNombre; ?>">
								<input type="hidden" name="IdiomaPivot" value="<? echo $IdiomaPivot; ?>">
								<input type="hidden" name="Operacion" value="<? echo $Operacion; ?>">

								<input type="submit" value="Enviar" name="B1" class="style43"><input type="reset" value="Restablecer" name="B2" class="style43">
								</td>
                              </tr>
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
                  <span class="style33"><a href="../admin/indexadm.php"><?echo $Mensajes["h-1"]?></a></span> </div>                <div align="center" class="style55"></div></td>
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
          <td width="50" class="style49"><div align="center" class="style11">fca-002</div></td>
        </tr>
      </table>
      </div></td>
  </tr>
</table>
</div>
<?
	if (isset($result))
		mysql_free_result($result);
	Desconectar();

?>
</body>
</html>








