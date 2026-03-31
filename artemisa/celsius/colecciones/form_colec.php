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
a:active {
	text-decoration: none;
	color: #000000;
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
.style34 {
	color: #FFFFFF;
	font-weight: normal;
	font-family: Verdana;
	font-size: 9px;
}
.style35 {color: #CCCCCC}
.style36 {color: #666666}
.style37 {font-size: 9px; font-family: verdana;}
-->
</style>
<base target="_self">
</head>
<script language="JavaScript">
	function enviar_campos()
	{
		form1.NombreIdioma.value=form1.Codigo_Idioma.options[form1.Codigo_Idioma.selectedIndex].text;
		return null;
	}
</script>

<body topmargin="0">
<? 

   include_once "../inc/"."fgenped.php";
   include_once "../inc/"."fgentrad.php";
   
    global $IdiomaSitio;
   $Mensajes = Comienzo ("fct-001",$IdiomaSitio);  

  
	If ($dedonde==1)
	{	
	  $expresion = "SELECT Id,Nombre,Abreviado,ISSN,Responsable";
	  $expresion = $expresion. " FROM Titulos_Colecciones WHERE Id=".$Id;
	  $result = mysql_query($expresion);
	  
	  $row = mysql_fetch_array($result);
	 } 
	  
?>

<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
            <form method="POST" action="update_col.php">
	  <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr>
        <td valign="top">            <div align="center">
              <center>
                <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ECECEC">
                  <tr bgcolor="#006699">
                    <td height="20" class="style33"><span class="style34"><img src="../../PrEBi/UNNOBA/images/square-w.gif" width="8" height="8"><? echo $Mensajes["tf-1"]; ?></span></td>
                    </tr>
                  <tr align="left" valign="middle">
                    <td class="style22"><div align="center" class="style33">
                      <table width="90%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
                        <tr>
                          <td width="150" height="20" valign="top"><div align="right"><? echo $Mensajes["tf-2"]; ?></div></td>
                          <td height="20" valign="top" bgcolor="#ECECEC">
                              <div align="left">
                                <input class="style22" type="text" name="Coleccion" size="41" value="<? if (isset($row[1])){echo $row[1];} ?>">
                              </div></td>
                        </tr>
                        <tr>
                          <td width="150" height="20" valign="top"><div align="right"><? echo $Mensajes["tf-3"]; ?></div></td>
                          <td height="20" valign="top" bgcolor="#ECECEC">
                            <div align="left">
                             <input type="text" name="Abrev" class="style22" size="38" value="<? if (isset($row[2])){echo $row[2];} ?>">
                            </div></td>
                        </tr>
                        <tr>
                          <td width="150" height="20" valign="top"><div align="right"><? echo $Mensajes["tf-4"]; ?></div></td>
                          <td height="20" valign="top" bgcolor="#ECECEC">
                            <div align="left">
                              <input type="text" class="style22"  name="ISSN" size="20" value="<? if (isset($row[3])){echo $row[3];} ?>">
                            </div></td>
                        </tr>
                        <tr>
                          <td width="150" height="20" valign="top"><div align="right"><? echo $Mensajes["tf-5"]; ?></div></td>
                          <td height="20" valign="top" bgcolor="#ECECEC">
                            <div align="left">
                              <input type="text" name="Responsable" class="style22"  size="41" value="<? if (isset($row[4])){echo $row[4];} ?>">
                            </div></td>
                        </tr>
                        <tr>
                          <td width="150" height="20"><div align="right"></div></td>
                          <td height="20"><div align="left">
                              <input type="submit" class="style22" value="<? if ($dedonde==0) { echo $Mensajes["botc-1"];} else { echo $Mensajes["botc-2"]; } ?>" name="B1">
                              <b><input type="reset" class="style22" value="<? echo $Mensajes["bot-3"]; ?>" name="B2">
                          </div></td>
						  <input type="hidden" name="NumeroPedidos" size="13" value="0"> 
						  <input type="hidden" name="dedonde" value="<? echo $dedonde; ?>">
						  <input type="hidden" name="Id" value="<? echo $Id; ?>">
						  </form>
                        </tr>
                      </table>
                    </div>                      </td>
                    </tr>
                </table>
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
                              <span class="style33"><a href="../admin/indexadm.php"> <? echo $Mensajes["h-3"]; ?></a></span></p>
                      </div></td>
                    </tr>
                  </table>
                  <p>&nbsp;</p>
                  </div>                  </td>
              </tr>
            </table>
            </div>
        </div></td>
        </tr>
		<?

  Desconectar(); 
  
?>
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
            <div align="center">fct-001</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>
