<?
   include_once "../../inc/var.inc.php";
  include_once "../../inc/"."conexion.inc.php";  
  Conexion();	
  include_once "../../inc/"."identif.php"; 
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
	margin:0px;
	background-color: #006599;
	margin-left: 10px;
}
body, td, th {
	color: #000000;
}
a:link {
	color: #000000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000000;
}
a:hover {
	text-decoration: underline;
	color: #0099FF;
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
a.style33 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
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
-->
</style>
<base target="_self">
</head>

<body topmargin="0">

<?
 include_once "../../inc/"."fgenped.php";
 include_once "../../inc/"."fgentrad.php";
 global  $IdiomaSitio;
 $Mensajes = Comienzo ("eca-001",$IdiomaSitio);
   
?>

<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td valign="top" bgcolor="#E4E4E4">            <div align="center">
              <center>
                <table width="97%" border="0" cellpadding="1" cellspacing="0">
                  <tr>
                    <td height="20" align="right" valign="middle" bgcolor="#006699" class="style22"><div align="left" class="style34"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["ec-1"]; ?></td>

					<tr>
                    <td height="20" align="right" valign="middle" bgcolor="#ECECEC" class="style22"><div align="right">
                      <div align="right"><br>
                        <table width="400"  border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#E4E4E4"><!-- resultados -->
						<?
						     $expresion = "SELECT Nombre,Id FROM Tab_Categ_usuarios ORDER BY Nombre";
							 $result = mysql_query($expresion);
							 
								 
							 while ($row = mysql_fetch_array($result))
							 
						   {?>
						   <tr align="center"><td>
								  <center>
									 <table width="100%"  border="0" align="center" cellpadding="1" cellspacing="1" class="style22">
											<tr>
											   
												<td class="style33"><div align="left"><? echo $row[0]; ?></div></td>
													</tr>
												<tr>
												  
												  <td width="200"><div align="right" class="style33">
												  <a class="style33" href="union_tusu.php?<? if ($adonde==1) { echo "Id1=".$row[1]."&Nombre1=".$row[0]."&Id2=$Id2&Nombre2=$Nombre2"; } 
														  else { echo "Id2=".$row[1]."&Nombre2=".$row[0]."&Id1=$Id1&Nombre1=$Nombre1"; } ?>">
														   <? echo $Mensajes["h-4"]; ?></a>
														   </div></td>
													</tr>
									</table>

								  </center>
								</td></tr>

						 <?}?>
  
						</table>
						<br>
                      </div>                    </td>
                    </tr>
                
                </table>
              </center>
            </div>            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td valign="top" class="style28"><div align="center"><img src="../../images/image001.jpg" width="150" height="118"><br>
                  <span class="style60"><a class="style33" href="../indexadm.php"><? echo $Mensajes["h-1"]; ?> </a></span></div>                <div align="center" class="style55"></div></td>
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
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50"><div align="right" class="style33">
            <div align="center">eca-001</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>


<?
	
   Desconectar();
?>
