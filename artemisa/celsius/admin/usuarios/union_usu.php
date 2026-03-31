<?
include_once "../../inc/var.inc.php";
include_once "../../inc/"."conexion.inc.php";  
Conexion();	
include_once "../../inc/"."identif.php"; 
Administracion();
if (!isset($definido))	$definido=0; 
if (!isset($Id1))	$Id1=0; 
if (!isset($Id2))	$Id2=0; 

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
<?
   include_once "../../inc/"."fgenped.php";
   include_once "../../inc/"."fgentrad.php";
global  $IdiomaSitio;
   $Mensajes = Comienzo ("uni-002",$IdiomaSitio);
   
?>

<script language="JavaScript">
function buscolookup1()
{
	document.forms.form1.Id1.value=<? if ($Id1=="") { $Id1=0; } echo $Id1; ?>; 
	document.forms.form1.adonde.value=1;
	document.forms.form1.Letra.value="A";
	document.forms.form1.action = "elige_usu.php";
	document.forms.form1.submit();
}

function buscolookup2()
{
	document.forms.form1.Id2.value=<? if ($Id2=="" || $Id1==$Id2) { $Id2=0; } echo $Id2; ?>; 
	document.forms.form1.adonde.value=2;
	document.forms.form1.Letra.value="A";
	document.forms.form1.action = "elige_usu.php";
	document.forms.form1.submit();
}

</script>

<body topmargin="0">

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
                        <tr>
                          <td valign="top"><div align="center">
<?
  
  if ($definido==0 || $Id1==0 || $Id2==0)
  {
 ?> 
						<form method="POST" name="form1" action="union_usu.php?definido=1">
                            <table width="95%"  border="0" cellpadding="1" cellspacing="1">
                              <tr>
                                <td colspan="2" bgcolor="#006699" class="style45"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["tf-13"]; ?></td>
                                </tr>
                              <tr>
                                <td width="150" class="style49"><div align="right"><? echo $Mensajes["ec-9"]; ?></div></td>
                                <td class="style43"><div align="left">
                                  <input type="text" name="Nombre1" class="style43" size="43" value="<? if (isset($Nombre1)){echo $Nombre1;   }?>">
								  <input type="button" value="?" name="B3" class="style43" OnClick="buscolookup1();">
								  
                                </div></td>
								<td><? if (isset($Id1)) {echo $Id1;} ?></td>
                              </tr>
                              <tr>
                                <td width="150" class="style49"><div align="right"><? echo $Mensajes["ec-10"]; ?></div></td>
                                <td class="style43"><div align="left">
                                  <input type="text" class="style43" name="Nombre2" value="<? if (isset($Nombre2)){echo $Nombre2;} ?>"size="43">
								  <input type="button" value="?" name="B4" class="style43" OnClick="buscolookup2();">
                                </div></td><td><? if (isset($Id2)) {echo $Id2;} ?></td>
                              </tr>
                              <tr>

                                <td class="style49" colspan=3 align="center" valign="top">
								<input class="style43" type="submit" value="<? echo $Mensajes["bot-1"]; ?>" name="B1">&nbsp;<input type="reset" value="<? echo $Mensajes["bot-2"]; ?>" name="B2" class="style43">
						<input type="hidden" name="Id1" value="<? echo $Id1; ?>">
                        <input type="hidden" name="Id2" value="<? echo $Id2; ?>">
                        <input type="hidden" name="adonde">
                        <input type="hidden" name="Letra">
								</td>
                              </tr>
							  <tr>
							 
							  <td colspan=3 align="center"><a href="../union.php"><? echo $Mensajes["h-2"]; ?></a></td></tr>
                              </table>
							</form>
                            
                            
			
<? } else {
	

	$num1=0;
	$num2=0;
	$num3=0;
   
       
   $expresion = "UPDATE Pedidos SET Codigo_Usuario=".$Id2." WHERE Codigo_Usuario=".$Id1;
   $result = mysql_query($expresion);
   echo mysql_error();
   $num1 = mysql_affected_rows();
   
   $expresion = "UPDATE Pedidos SET Usuario_Creador=".$Id2." WHERE Usuario_Creador=".$Id1;
   $result = mysql_query($expresion);
   echo mysql_error();
   $num11 = mysql_affected_rows();

    
   $expresion = "UPDATE PedHist SET Codigo_Usuario=".$Id2." WHERE Codigo_Usuario=".$Id1;
   $result = mysql_query($expresion);
   echo mysql_error();
   $num2 = mysql_affected_rows();
   
   
   $expresion = "UPDATE mail SET Codigo_Usuario=".$Id2." WHERE Codigo_Usuario=".$Id1;
   $result = mysql_query($expresion);
   echo mysql_error();
   $num3 = mysql_affected_rows();
   
    
   $expresion = "DELETE FROM Usuarios WHERE Id=".$Id1;
   $result = mysql_query($expresion);
   echo mysql_error();
   
      //nuevo Log
   global $Id_usuario;
   $expresion = "INSERT INTO Log (idOperador,fecha,tipoEvento,idNuevo) VALUES(".$Id_usuario.",NOW(),7,".$Id2.")";
   $result = mysql_query($expresion);
   echo mysql_error();
   
   
 ?><br>
<div align="center">
  <center>
  <table border="1" width="88%" bgcolor="#5B97A4">
    <tr>
      <td width="31%" align="right" class="style49"><? echo $Mensajes["ec-9"]; ?>&nbsp;&nbsp; </td>
      <td width="56%" class="style49"><? echo $Nombre1; ?></td>
      <td width="13%">&nbsp;</td>
    </tr>
    <tr>
      <td width="31%" align="right" class="style49"><b><? echo $Mensajes["ec-10"]; ?>&nbsp;</b></td>
      <td width="56%" class="style49"><? echo $Nombre2; ?></td>
      <td width="13%">&nbsp;</td>
    </tr>
    <tr>
      <td width="100%" align="right" colspan="3" class="style49">
        <p align="center" ><b><? echo "Ped/PHist/Mail:".$num1."/".$num2."/".$num3; ?></b></td>
    </tr>
    <tr>
      <td width="100%" align="right" colspan="3" class="style49">
        <p align="center"><a href="../union.php"><? echo $Mensajes["h-2"]; ?>&nbsp;
        </a></td>
    </tr>
  </table>
  </center>
</div>
<?
   //mysql_free_result($result);
	Desconectar();
 } ?>


	           </div>                            
                            </td>
                          </tr>
                      </table>
	
                    </td>
                  </tr>
                </table>                  </td>
              </tr>
            </table>

	           </center>
            </div>            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td class="style28"><div align="center"><img src="../../images/image001.jpg" width="150" height="118"><br>
                  <span class="style33"><a href="../indexadm.php"><? echo $Mensajes["h-1"]; ?></a></span> </div>                <div align="center" class="style55"></div></td>
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
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50" class="style49"><div align="center" class="style11">uni-002</div></td>
        </tr>
      </table>
      </div></td>
  </tr>
</table>
</div>
</body>
</html>
</body>
</html>
