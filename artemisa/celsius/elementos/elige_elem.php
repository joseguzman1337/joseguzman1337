<?
    
   include_once "../inc/var.inc.php";
   include_once "../inc/"."conexion.inc.php";
   Conexion();	
   include_once "../inc/"."identif.php";
   
   include_once "../inc/fgentrad.php";
   Administracion();
   if (!isset($dedonde ))			$dedonde=1;
   if (!isset($Codigo_Pagina ))		$Codigo_Pagina="";
   global $IdiomaSitio;
   $Mensajes = Comienzo ("eel-001",$IdiomaSitio);

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
	color: #000000;
	font-weight: normal;
}
.style45 {
	font-family: Verdana;
	color: #FFFFFF;
	font-size: 9px;
}
.style49 {font-family: verdana; font-size: 10px; color: #006599; }
.style56 {color: #00FFFF}
.style66 {
	color: #006699;
	font-family: Verdana;
	font-size: 9px;
	font-weight: bold;
}
.style11Copy {
color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 9px;
}
.style67 {
	font-size: 9px;
	font-family: Verdana;
	font-weight: normal;
	color: #000000;
}
.style13 {
color: #006699; font-family: Verdana; font-size: 9px;
}
-->
</style>
<base target="_self">
<script language="JavaScript">
 function confirmar()
 {
 	if (confirm("Con esta operación eliminará el elemento seleccionado. Confirma la Operación?"))
 	{
 		return true
 	}
 	else
 	{
 		return false
 	}
 	
 }
</script>

</head>

<body topmargin="0">
<? include_once "../inc/"."fgenped.php"; ?>
<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">      <div align="center"><center>
        <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td bgcolor="#E4E4E4">            <div align="center">
              <center>
            <table width="95%" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td valign="top" bgcolor="#E4E4E4"><table width="100%"  border="0" cellpadding="1" cellspacing="0" class="style43">
                  <tr>
                    <td height="20" align="left" bgcolor="#006699" class="style45"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["et-1"]?></td> 
                  </tr>
				  <?
       if ($dedonde==2)
       {
       		   $expresion = "DELETE FROM Traducciones WHERE Codigo_Elemento='$Codigo_Elemento' AND Codigo_Pantalla='$Codigo_Pagina'";                 	   
      		      $result = mysql_query($expresion);
	
		   		   $expresion = "DELETE FROM Elementos WHERE Codigo_Elemento='$Codigo_Elemento' AND Codigo_Pantalla='$Codigo_Pagina'";                 	   
      		      $result = mysql_query($expresion);
		 }   
          
           	
     ?> 
     <form method="POST" action="elige_elem.php">
                  <tr>
                    <td align="left" class="style45"><table width="450" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#CCCCCC">
                      <tr class="style43">
                        <td width="40%" align="left" bgcolor="#0099CC" class="style45"><div align="right"><? echo $Mensajes["ec-1"]?> </div></td>
                        <td align="left" bgcolor="#0099CC" class="style45"><div align="left">
                          <select size="1" name="Codigo_Pagina" class="style43">             
              <?
              	   
     				   $expresion = "SELECT Id FROM Pantalla ORDER BY Id";                 	   
   				      $result = mysql_query($expresion);

     				   while ($row = mysql_fetch_array($result))
                    {
                       if ($row[0]==$Codigo_Pagina)
                       {?>
              <option value="<? echo $row[0]; ?>" selected><? echo $row[0] ?></option>	
                       <? } else { ?>
              <option value="<? echo $row[0]; ?>"><? echo $row[0] ?></option>	
         
              <?   }
              } ?>
              </select>
                        </div></td>
                      </tr>
                      <tr class="style43">
                        <td width="40%" align="left" bgcolor="#0099CC" class="style45">
                          <div align="right"></div></td>
                        <td align="left" bgcolor="#0099CC" class="style45"><div align="left">
                          <input type="submit" value="<?echo $Mensajes["bot-1"];?>" class="style11Copy" name="B1"><input class="style11Copy" type="reset" value="<?echo $Mensajes["bot-2"];?>" name="B2">
                        </div></td>
                      </tr>
                    </table>                      
                      <?
     
     if ($Codigo_Pagina!="")
     { 
      
   $expresion = "SELECT Codigo_Elemento,Tipo_Elemento FROM Elementos WHERE Codigo_Pantalla='".$Codigo_Pagina."' ORDER BY Codigo_Elemento";   
   $result = mysql_query($expresion);
     
   while ($row = mysql_fetch_array($result))
   {
  
?>
					  <hr align="center" width="450">

					  <table width="450" border="0" align="center" cellpadding="1" cellspacing="0">
                        <tr>
                          <td height="15" colspan="2" bgcolor="#006699">&nbsp;</td>
                          </tr>
                        <tr>
                          <td width="40%" class="style66"><div align="right" class="style67"><? echo $Mensajes["ec-2"];?> </div></td>
                          <td class="style66"><? echo $row[0]."  -".Devolver_Desc_Elem($row[1]); ?></td>
                        </tr>
                        <tr>
                          <td colspan="2"> <div align="right" class="style13"><a href="form_elem.php?dedonde=1&Codigo_Elemento=<?echo $row[0]; ?>&Codigo_Pagina=<? echo $Codigo_Pagina; ?>"><? echo $Mensajes["ec-3"];?></a>|<a href="elige_elem.php?dedonde=2&Codigo_Elemento=<? echo $row[0]; ?>&Codigo_Pagina=<? echo $Codigo_Pagina; ?>" onClick="return confirmar()"><? echo $Mensajes["ec-4"];?></a></div></td>
                          </tr>
                      </table>
              <?
             }
	    }
        Desconectar();
  ?>

</td>
                  </tr>
                </table>                  </td>
              </tr>
            </table>
              </center>
            </div>
            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td class="style28"><div align="center"></div>                <div align="center" class="style11"><img src="../images/image001.jpg" width="150" height="118"><br>
                <a href="../admin/indexadm.php"><? echo $Mensajes["h-1"];?></a></div></td>
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
          <td width="50" class="style49"><div align="center" class="style11">eel-001</div></td>
        </tr>
      </table>
      </div></td>
  </tr>
</table>
</div>
</body>
</html>