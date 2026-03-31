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
<title>PrEBi </title>
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
   include_once "../inc/fgenped.php";
   include_once "../inc/fgentrad.php";
  
   global $IdiomaSitio;
   $Mensajes = Comienzo ("fca-002",$IdiomaSitio);
  
  if (isset($Requerido) && ($Requerido=="ON"))
   {
     $Requerido=1;
   }
   else
   {
     $Requerido=0;
   }
   
   if (isset($DescDet) &&($DescDet=="ON"))
   {
     $DescDet=1;
   }
   else
   {
     $DescDet=0;
   }
   
   if (isset($DescAbrev) &&($DescAbrev=="ON"))
   {
     $DescAbrev=1;
   }
   else
   {
     $DescAbrev=0;
   }

   
   if ($Operacion==1) {     
    $Instruccion = "INSERT INTO Campos (Tipo_Material,Numero_Campo,Codigo_Idioma,";
    $Instruccion = $Instruccion."Heading,Heading_Abrev,Incluye_Desc_Det,Incluye_Desc_Abr,";
    $Instruccion = $Instruccion."Campo_Necesario,ER_Validacion,Mensaje_Error,Texto_Ayuda) VALUES (";	
    $Instruccion = $Instruccion.$Tipo_Material.",".$Numero_Campo.",".$Codigo_Idioma.",'".$Heading."','".$Heading_Abrev."',";
    $Instruccion = $Instruccion.$DescDet.",".$DescAbrev.",".$Requerido.",'".$ER_Validacion."',";
    $Instruccion = $Instruccion."'".$Mensaje_Error."','".$Texto_Ayuda."')";

   }
   else
   {    
    $Instruccion = "UPDATE Campos SET Heading='".$Heading."',Heading_Abrev='".$Heading_Abrev."',";
    $Instruccion = $Instruccion."Incluye_Desc_Det=".$DescDet.",Incluye_Desc_Abr=".$DescAbrev.",Campo_Necesario=".$Requerido;
    $Instruccion = $Instruccion.",ER_Validacion='".$ER_Validacion."',Mensaje_Error='".$Mensaje_Error."'";
    $Instruccion = $Instruccion.",Texto_Ayuda='".$Texto_Ayuda."' WHERE Tipo_Material=".$Tipo_Material." AND Numero_Campo=".$Numero_Campo;	
    $Instruccion = $Instruccion." AND Codigo_Idioma=".$Codigo_Idioma;
   }

   $result = mysql_query($Instruccion); 
  
    echo mysql_error();
	?>
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
							<?
							if (mysql_affected_rows()>0) {?>


                        <tr>
                          <td valign="top"><div align="center">
                            <table width="95%"  border="0" cellpadding="1" cellspacing="1">
                              <tr>
                                <td width="50%" class="style49"><div align="right"><? echo $Mensajes["ele-1"]; ?></div></td>
                                <td width="50%" class="style43"><div align="left"><? echo        $Tipo_Material; ?></div></td>
                              </tr>
                              <tr>
                                <td width="50%" class="style49"><div align="right"><? echo $Mensajes["ele-2"]; ?> </div></td>
                                <td width="50%" class="style43"><div align="left"><? echo        $Numero_Campo; ?>
                                  </div></td>
                              </tr>

							  <tr>
                                <td width="50%" class="style49"><div align="right"><? echo $Mensajes["ele-3"]; ?> </div></td>
                                <td width="50%" class="style43"><div align="left"><? echo        $IdiomaNombre; ?>
                                  </div></td>
                              </tr>

							  <tr>
                                <td width="50%" class="style49"><div align="right"><? echo $Mensajes["ele-4"];?></div></td>
                                <td width="50%" class="style43"><div align="left"><? echo        $Heading; ?>
                                  </div></td>
                              </tr>

							  <tr>
                                <td width="50%" class="style49"><div align="right"><? echo $Mensajes["ele-5"];?></div></td>
                                <td width="50%" class="style43"><div align="left"><? echo        $Heading_Abrev; ?>
                                  </div></td>
                              </tr>

                              <tr>
                                <td colspan="2" class="style49"><div align="right"></div>                                  
                                    <div align="center">
									  <a href="elige_campos.php?Tipo_Material=<? echo $Tipo_Material; ?>&IdiomaPivot=<? echo $IdiomaPivot; ?>&IdiomaDestino=<? echo $Codigo_Idioma; ?>"><?echo $Mensajes["ele-6"];?></a>
									  
			                       </div></td>
                                </tr>
                           
				<?
	} else	{?>
					<tr>
					<td valign="top"><div align="center">
                            <table width="95%"  border="0" cellpadding="1" cellspacing="1">
								<tr>
								<td width="95%" class="style43"><? echo $Mensajes["ele-7"];?></td></tr><?
	}

?>


							 </table>
                            </div>                            
                            </td>
                          </tr>
                      </table>
                    </td>
                  </tr>
                </table>
				
				</td>
              </tr>
            </table>
              </center>
            </div>            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td class="style28"><div align="center"><img src="../images/image001.jpg" width="150" height="118"><br>
                  <span class="style33"><a href="../admin/indexadm.php" target="_self"><?echo $Mensajes["h-1"]?></a></span> </div>                <div align="center" class="style55"></div></td>
            </tr>
          </table>
          </div>
          </td>
        </tr>
    </table>    </center>
      </div>    </td>
  </tr>
  <?
   Desconectar();
?>

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
</body>
</html>














