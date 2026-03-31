<?

  include_once "../inc/var.inc.php";
  include_once "../inc/conexion.inc.php";  
  Conexion();	
  include_once "../inc/identif.php"; 
  Administracion();
  if (! isset($Id))		$Id="";
  if (! isset($operacion))		$operacion="";
 ?>
<html>

<head>
<title>PrEBi</title>
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
.style33 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
.style58 {font-size: 9px}
.style60 {font-family: Arial}
.style22 {
	color: #333333;
	font-family: verdana;
	font-size: 9px;
}
-->
</style>
</head>

<?
  	include_once "../inc/fgenped.php";
	include_once "../inc/fgentrad.php";
    global $IdiomaSitio;
   $Mensajes = Comienzo ("pma-001",$IdiomaSitio);
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
   
   if ($operacion==1)
  {
  	$Instruccion = "SELECT Denominacion,Cuando_Usa,Texto FROM Plantmail WHERE Id=".$Id;
  	$result = mysql_query($Instruccion);
  	$row = mysql_fetch_row($result);
  }
?>  	
   

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
        <td valign="top" bgcolor="#E4E4E4">          <div align="center">
              <center>
			  <form method="POST" name="form1" action="upd_pmail.php" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold">
				<input type="hidden" name="operacion" value=<? echo $operacion; ?>>
  				<input type="hidden" name="Id" value=<? echo $Id; ?>>
                <table width="97%" border="0" cellpadding="1" cellspacing="0">
                  
                  <tr>
                    <td height="20" colspan="2" align="right" valign="middle" bgcolor="#006699" class="style22"><div align="left" class="style45"><img src="../images/square-w.gif" width="8" height="8"> <? echo $Mensajes["tf-1"]; ?> </div></td>
                    </tr>
                  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"> <? echo $Mensajes["ec-1"]; ?></div></td>
                    <td width="*" height="20" align="left" valign="top" class="style33" >
                      <div align="left">
                        <input name="Denominacion" type="text" class="style22" size="41" value="<? if (isset($row))echo $row[0]; ?>"></div></td>
                  </tr>

				   <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-2"]; ?></div></td>
                    <td height="20" align="left" valign="top" class="style33">
                      <div align="left">
                        <select class="style22" size="1" name="Cuando_Usa">
						 
						  <?
								 $Vector=array_merge(Devolver_Todos_Eventos($VectorIdioma),Devolver_Todos_Eventos_Mails($VectorIdioma));
								 while (list($opcion,$valor)=each($Vector))
								 {              
									if (isset($row) &&($valor==$row[1]))
									{
									  echo "<option value='".$valor."' selected>".$opcion."</option>";
									} 
									else
									{
									  echo "<option value='".$valor."'>".$opcion."</option>";
									}
								 } 
							  ?>                           
                        </select></div></td>
                  </tr>
				   <tr>
                    <td width="30%" align="right" valign="top" bgcolor="#CCCCCC" class="style22"><div align="right"> <? echo $Mensajes["ec-3"]; ?></div></td>
                    <td height="20" align="left" valign="top" class="style33">
                      <div align="left"><textarea rows="7" name="Texto" class="style22" cols="35"><? if (isset($row))echo $row[2]; ?></textarea>
                        </div></td>
                  </tr>




				  <tr>
                    <td colspan="2" class="style22"><div align="right"></div>                      
                      <div align="center">
                        <input value="<? if ($operacion==1) { echo $Mensajes["botc-2"]; } else { echo $Mensajes["botc-1"]; } ?>" name="B1"  type="submit" class="style22" >
                        <input  class="style22" type="reset" value="<? echo $Mensajes["bot-3"]; ?>" name="B2">                    
                      </div></td>
                    </tr>
				<tr>
                    <td class="style22"><div align="right"></div>                      
                      <div align="center"></div></td>
                    </tr>
                </table>
              </center>
			  </form>

            </div>            </td>
        <td width="150" valign="top" bgcolor="#Ececec"><div align="center" class="style22">
          <div align="left">
            <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td><div align="center" valign="top">
                  <p><img src="../images/image001.jpg" width="150" height="118"><br>
                    <span class="style33"><a href="../admin/indexadm.php"> <? echo $Mensajes["h-3"]; ?></a></span></p>
                  </div>                  </td>
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
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50"><div align="right" class="style33">
            <div align="center">pma-001</div>
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








