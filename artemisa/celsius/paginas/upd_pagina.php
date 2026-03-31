<?
 
	include_once "../inc/var.inc.php";
	include_once "../inc/conexion.inc.php";  
    Conexion();	
    include_once "../inc/identif.php"; 
    Administracion();
	include_once "../inc/"."fgentrad.php";
	global $IdiomaSitio;
	$Mensajes = Comienzo ("fpg-001",$IdiomaSitio);
?>
<html>
<head>
<title>PrEBi </title>
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
.style23 {
	color: #000000;
	font-size: 9px;
	font-family: verdana;
}
.style42 {color: #FFFFFF; font-family: verdana; font-size: 9px; }
a.style60 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
-->
</style>

<!-- <base target="_self"> -->

</head>


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
			  
                <table width="97%" border="0" cellpadding="1" cellspacing="0" >
                  
						  <tr class="style23"><td><div align="center" class="style60">
<?
								if ( isset ($operacion)) {
									$Instruccion="";
									if ($IdPagina != "")
										if ($operacion==0)
										   {
											 $Instruccion = "INSERT INTO Pantalla (Id) VALUES('".$IdPagina."')";	
										   }
										   else
										   {
											 
												$Instruccion = "UPDATE Pantalla SET Id='".$IdPagina."' WHERE Id='".$Id."'";	
										   }  
									
								    if ($Instruccion != ""){									
											$result = mysql_query($Instruccion); 
											echo mysql_error(); 
											if (mysql_affected_rows()>0) 
													{ echo $Mensajes["ec-1"].$IdPagina;
													 
													}
												else
													{echo $Mensajes["ec-2"];}
											}
									
												else
													{echo $Mensajes["ec-2"];}
										 	
										 
									}
									else{
										echo $Mensajes["ec-2"];}
										?>

				
								</div>
								
							</td>
						  </tr>

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
      </div> <BR>   </td>
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

   Desconectar();
?>
