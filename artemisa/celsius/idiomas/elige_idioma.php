<?
    
include_once "../inc/var.inc.php";
include_once "../inc/"."conexion.inc.php";
Conexion();	
include_once "../inc/"."identif.php";
include_once "../inc/"."fgenped.php"; 
include_once "../inc/fgentrad.php";
Administracion();
	
global $IdiomaSitio;
$Mensajes = Comienzo ("eid-001",$IdiomaSitio);
if (! isset($operacion))	$operacion = 0;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>PrEBi </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="JavaScript">
 function confirmar()
 {
 	if (confirm("Con esta operación eliminará el Idioma seleccionado. Confirma la Operación?"))
 	{
 		return true
 	}
 	else
 	{
 		return false
 	}
 	
 }
</script>

<style type="text/css">
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
.style33 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
a.style60 {
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
.style40 {
	color: #FFFFFF;
	font-family: Verdana;
	font-size: 9px;
}
.style41 {color: #000000}
.style42 {color: #000000; font-family: verdana; font-size: 9px; }
.style43 {font-size: 9px; font-family: verdana;}
.style60 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
-->
</style>
<base target="_self">

</head>

<body topmargin="0">
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
                    <td height="20" align="right" valign="middle" bgcolor="#006699" class="style22"><div align="left" class="style40"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["et-1"]?></td>
                    </tr>
                  <tr>
                    <td height="20" align="right" valign="middle" bgcolor="#ECECEC" class="style22"><div align="right">
                      <div align="right"><br>
                        <table width="400"  border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#E4E4E4">
				<?

						if ($operacion==2)
											{
												$expresion = "DELETE FROM Traducciones WHERE Codigo_Idioma=".$Idioma;
												$result = mysql_query($expresion);

												$expresion = "DELETE FROM Idiomas WHERE Id=".$Id;
											   $result = mysql_query($expresion);
											
											}
									   
										   $expresion = "SELECT Nombre,Id,Predeterminado FROM Idiomas ORDER BY Nombre";
									   
									   $result = mysql_query($expresion);
										 $contador=0; 
										 while($row = mysql_fetch_row($result))
										 {?>
											   
											  
												<tr>
												  <td colspan=2 height="15" bgcolor="#0099CC" class="style42">&nbsp;</td>
												  </tr>
												<tr>
												  <td width="20" class="style66"><div align="left" class="style67"><?echo $row[0];?></div></td>
												  <td class="style66" align="left"><? if ($row[2]==1) { echo "<img border=0 src='../images/marca.gif' width='30' height='31'>";} ?></td>
												</tr>
												<tr>
												  <td colspan="2"> <div align="right" class="style60"><a class="style60"  href="form_idioma.php?operacion=1&Id=<? echo $row[1]; ?>"><? echo $Mensajes["ec-1"];?></a>|<a class="style60" href="elige_idioma.php?operacion=2&Id=<? echo $row[1]; ?>" onClick="return confirmar()"><? echo $Mensajes["ec-2"];?></a></div></td>
												  </tr>
											 
									       
									   <? }?>                        
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
              <td valign="top" class="style28"><div align="center"><img src="../images/image001.jpg" width="150" height="118"><br>
                  <span class="style60"><a class="style60" href="../admin/indexadm.php"><? echo $Mensajes["h-1"];?> </a></span></div>                <div align="center" class="style55"></div></td>
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
          <td width="50"><div align="right" class="style33">
            <div align="center">eid-001</div>
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
	if (isset($result))
	  mysql_free_result ($result);
   Desconectar();
?>