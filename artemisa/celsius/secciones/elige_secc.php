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
	font-size: 11px;
}
.style33 {
	font-family: verdana;
	font-size: 11px;
	color: #006699;
}
.style34 {
	color: #FFFFFF;
	font-weight: normal;
	font-family: Verdana;
	font-size: 11px;
}
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<?
  	include_once "../inc/fgenped.php";
	include_once "../inc/fgentrad.php";
	if (!isset($dedonde))	$dedonde=1;
	if (!isset($Idioma))	$Idioma=0;

 
   global $IdiomaSitio;
   $Mensajes = Comienzo ("ese-001",$IdiomaSitio);
   
?>
<script language="JavaScript">
 function confirmar()
 {
 	if (confirm("<? echo $Mensajes["me-1"]; ?>"))
 	{
 		return true
 	}
 	else
 	{
 		return false
 	}
 	
 }
</script>


<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr>
        <td valign="top">            <div align="center">
              <center>
                <?
      
      if ($dedonde==2)
      {
      	  $expresion = "SELECT COUNT(*) FROM Contenidos WHERE Id_Seccion=".$Id;                 	   
   	      $result = mysql_query($expresion);
   	      $rowg = mysql_fetch_array($result);
   	      
		   if ($rowg[0]==0)
		   {
		   		   $expresion = "DELETE FROM Secciones WHERE Id=".$Id;                 	   
      		      $result = mysql_query($expresion);
      		      echo mysql_error();
		   }	   	      	
        
      }
             
      if ($Idioma==0)
      {      	
     ?> 
     <form method="POST" action="elige_secc.php">
    
				
				<table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                  <tr bgcolor="#006699">
                    <td height="20" class="style33"><span class="style34"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["ec-1"]; ?></span></td>
                    </tr>
                  <tr align="left" valign="middle">
                    <td class="style22"><div align="center" class="style33">
                      <table width="90%"  border="0" align="center" cellpadding="1" cellspacing="1" class="style22">
                        <tr>
                          <td width="150" class="style22"><div align="right"><? echo $Mensajes["et-1"]; ?></div></td>
                          <td>
                            <div align="left">
                              <select size="1" class="style22" name="Idioma">             
              <?
              	   
     				   $expresion = "SELECT Nombre,Id FROM Idiomas ORDER BY Nombre";                 	   
   				      $result = mysql_query($expresion);

     				   while ($row = mysql_fetch_array($result))
                    {
              ?>
              <option value="<? echo $row[1]; ?>"><? echo $row[0] ?></option>	
              <? } ?>
              </select>
                          </div></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td><input type="submit" class="style22" value="<? echo $Mensajes["bot-1"]; ?>" name="B1">                            </td>
                        </tr>
                      </table>
    </form>
   
					  </div>                      </td>
                    </tr>
                </table>
				 <?
      }
     else
     { 
     ?>    

<table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                  <tr bgcolor="#006699">
                    <td height="20" class="style33"><span class="style34"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["ec-1"]?></span></td>
                    </tr>
                  <tr align="left" valign="middle">
                    <td class="style22"><div align="center" class="style33">
<?   
  
   $expresion = "SELECT Nombre,Id FROM Secciones WHERE Codigo_Idioma=".$Idioma." ORDER BY Orden";   
   $result = mysql_query($expresion);
     
   while ($row = mysql_fetch_array($result))
   {
  
?>
<br>
    
    <div align="center">
      <center>
         <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" class="style22">
                <tr>
                   <td width="200" class="style22"><div align="right"><? echo $Mensajes["ec-2"]; ?></div></td>
                          <td class="style33"><? echo $row[0]; ?></td>
                        </tr>
                        <tr>
                          <td><div align="right"></div></td>
                          <td><div align="right" class="style33"><a href="form_secc.php?dedonde=1&Id=<?echo $row[1]; ?>"><? echo $Mensajes["h-2"]; ?></a>|<a href="elige_secc.php?dedonde=2&Id=<? echo $row[1]; ?>&Idioma=<? echo $Idioma; ?>" onClick="return confirmar()"><? echo $Mensajes["h-3"]; ?> </a></div></td>
                        </tr>
                      </table>

      </center>
    </div>

<?
 }
 ?>
 </td>
 </tr>
 </table>
 <?
  mysql_free_result ($result);
  
 }

 Desconectar();
  
?>
                </center>
            </div>            </td>
        <td width="150" valign="top"><div align="center" class="style22">
          <div align="left">
            <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td><div align="center">
                  <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td bgcolor="#ECECEC"><div align="center">
                          <p><img src="../images/image001.jpg" width="150" height="118"><br>
                              <span class="style33"><a href="../admin/indexadm.php"> <? echo $Mensajes["h-1"];?></a></span></p>
                      </div></td>
                    </tr>
                  </table>
                  </div></td>
              </tr>
            </table>
            </div>
        </div></td>
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
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" height="43" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50"><div align="right" class="style33">
            <div align="center">ese-001</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>