<?
   
   include_once "../inc/conexion.inc.php";  
   include_once "../inc/var.inc.php";
   Conexion();	
   include_once "../inc/identif.php"; 
   Administracion();
   
 ?>

<html>

<head>
<title>PrEBi</title>
<style>
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
.style43 {
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
.style49 {font-family: verdana; font-size: 11px; color: #006599; }
-->

</style>
<base target="_self">
</head>
<body topmargin="0">
<?
   include_once "../inc/fgenped.php";
   include_once "../inc/fgentrad.php";
 
   global $IdiomaSitio;
   $Mensajes = Comienzo ("fco-001",$IdiomaSitio);
  
   $Dia = date ("d");
   $Mes = date ("m");
   $Anio = date ("Y");
   $FechaHoy =$Anio."-".$Mes."-".$Dia;

   $Instruccion ="UPDATE Secciones SET Ultima_Actualizacion='".$FechaHoy."' WHERE Id=".$Secciones;
   $result = mysql_query($Instruccion); 
   
   echo mysql_error();
   If ($dedonde==0)
   {
	   $Instruccion = "INSERT INTO Contenidos (Id_Seccion,Titulo,Orden,Texto) VALUES(".$Secciones.",'".$Titulo."',".$Orden.",'".$Texto."')";	
	}   
	Else
	{
		$Instruccion = "UPDATE Contenidos SET Id_Seccion=".$Secciones.", Titulo='".$Titulo."',Orden=".$Orden.",Texto='".$Texto."' WHERE Id=".$Id;	
	}   
	
   $result = mysql_query($Instruccion); 
   echo mysql_error();

   ?>
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
              <center><table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
				  <?
				   if (mysql_affected_rows()>0)
				   { ?>
				   <tr>
				  <td valign="top" align="center"><div align="center">
					 <table width="95%"  border="0" cellpadding="1" cellspacing="1" align="center">
					  <tr bgcolor="#006699">
						<td height="20" class="style33" bgcolor="#ECECEC"><? echo $Mensajes["ec-4"]; ?></td>
						<td height="20" class="style33"><span class="style34"><? echo $DescIdioma; ?></span></td>
						</tr>
					  <tr bgcolor="#006699">
						<td height="20" class="style33" bgcolor="#ECECEC"><? echo $Mensajes["ec-1"]; ?></span></td>
						<td height="20" class="style33"><span class="style34"><? echo $DescSeccion; ?></span></td>
						</tr>
					  <tr bgcolor="#006699">
						<td height="20" class="style33" bgcolor="#ECECEC"><? echo $Mensajes["ec-2"]; ?></span></td>
						<td height="20" class="style33"><span class="style34"><? echo $Titulo; ?></span></td>
						</tr>
					  <tr bgcolor="#006699">
						<td height="20" class="style33" bgcolor="#ECECEC"><? echo $Mensajes["ec-5"]; ?></span></td>
						<td height="20" class="style33"><span class="style34"><? echo $Texto; ?></span></td>
						</tr>
					  </table>
				</div></td></tr>
		 

					<?
						} else	{?>
						<tr>
					<td valign="top" align="center"><div align="center">
                            <table width="95%"  border="0" cellpadding="1" cellspacing="1" align="center">
								<tr>
								<td width="95%" class="style43" align="center"><? echo $Mensajes["me-2"]; ?></td>
								</tr></table>
							</div></td></tr>
					<? }

					?>


  <tr>
   <td height="20" class="style33" align="center">
       <? if ($dedonde==0)
      { ?>
       <a href="form_cont.php?dedonde=0"><? echo $Mensajes["h-1"]; ?></a>
      <?
      } else { ?>
       <a href="elige_cont.php"><? echo $Mensajes["h-2"]; ?></a>
      <? } ?>      
      
    </td>
  </tr>
</table>
  </center>
</div>
<br>
<?
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
                              <span class="style33"><a href="../admin/indexadm.php"> <? echo $Mensajes["h-3"];?></a></span></p>
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
            <div align="center">fco-001</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>




