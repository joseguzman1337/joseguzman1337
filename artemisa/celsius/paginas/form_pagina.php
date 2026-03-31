<?
	    
	 include_once "../inc/var.inc.php";
	 include_once "../inc/conexion.inc.php";  
	 Conexion();	
	 include_once "../inc/identif.php"; 
	 Administracion();
	 if (! isset($operacion) )	$operacion = 0;
	 if (! isset($Id) )			$Id = 0;
		
   if ($operacion==1)
	{
	
		$Instruccion = "SELECT Id FROM Pantalla WHERE Id='".$Id."'";
		$result=mysql_query ($Instruccion);
		$row = mysql_fetch_row($result);		
	}
 ?>

<html>

<head>
<title>PrEBi</title>
</head>
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
.style60 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
a.style60 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<? 
  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."fgentrad.php";
  global $IdiomaSitio;
  $Mensajes = Comienzo ("fpg-001",$IdiomaSitio);
?>



<body topmargin="0">
<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4" valign="top">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td valign="top" bgcolor="#E4E4E4">            <div align="center">
              <center>
			  <form method="POST" action="upd_pagina.php" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold">
				
						<input type="hidden" name="operacion" value="<? echo $operacion; ?>">
						<input type="hidden" name="Id" value=<? echo $Id; ?>>
                <table width="97%" border="0" cellpadding="1" cellspacing="0" >
                  
						  <tr>
							<td height="20" colspan="2" align="right" valign="middle" bgcolor="#006699" class="style22"><div align="left" class="style40"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["tit-1"]?></div></td>
						  </tr>
						  <tr><td valign="top"><div align="center"><table width="95%"  border="0" cellpadding="1" cellspacing="1">
                              <tr>

								<td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-1"]?></div></td>
								<td width="*" height="20" align="left" valign="top" bgcolor="#CCCCCC" >
								  <div align="left">
									<input type="text" class="style22" name="IdPagina" size="41" value=" <? if ( isset($row)) echo $row[0]; ?>">
								  </div></td>
							 </tr>
							 <tr>
								<td colspan="2" class="style22"><div align="right"></div><div align="center">
									<input type="submit" class="style22"  value="<? if ($operacion==0) {echo $Mensajes["bot-1"];} else { echo $Mensajes["bot-2"];} ?>" name="B1">
									<input type="reset" class="style22"value="<? echo $Mensajes["bot-3"];?>" name="B2"></div></td>
							</tr>
							 </table>
						</td></tr>

						 
				</table>
				</form>
				<br>
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
      </div><br>    </td>
  </tr>
 
  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">      
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50"><div align="right" class="style33">
            <div align="center">fpg-001</div>
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
	if ((isset($result)) && ($result))
	  mysql_free_result ($result);
   Desconectar();
?>