<?
   include_once "../../inc/var.inc.php";
   include_once "../../inc/"."conexion.inc.php";  
   Conexion();	
   include_once "../../inc/"."identif.php"; 
   Administracion();
   if (! isset($adonde))	$adonde=0;
   if (! isset($Id1))		$Id1="";
   if (! isset($Id2))		$Id2="";
   if (! isset($Nombre1))	$Nombre1="";
   if (! isset($Nombre2))	$Nombre2="";

   

 ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><? echo Titulo_Sitio();?></title>
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
.style45 {font-family: Verdana; color: #FFFFFF;}
.style46 {
	color: #006599;
	font-family: verdana;
	font-size: 10px;
	font-style: normal;
	font-weight: bold;
}
.style55 {
	font-size: 10px;
	color: #000000;
	font-family: Verdana;
}
.style58 {color: #66FFFF}
.style60 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
-->
</style>
<base target="_self">
</head>
<script language="JavaScript">
function recargo(Letra)
{
	document.forms.form1.action = "elige_usu.php?Letra="+Letra;
	document.forms.form1.submit();
}

function retornaSin()
{
	document.forms.form1.action = "../indexadm.php";
	document.forms.form1.submit();
}


</script>    


<body topmargin="0">
<?
    include_once "../../inc/"."fgenped.php";
    include_once "../../inc/"."fgentrad.php";
	global  $IdiomaSitio;
    $Mensajes = Comienzo ("sus-001",$IdiomaSitio);  
    $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
   
?>
<form method="POST" name="form1" OnSubmit="recargo(form1.Busca.value)">
<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">      <div align="center"><center>
        <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td bgcolor="#E4E4E4">
            <div align="center">
              <center>
            <table width="576" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td valign="top" bgcolor="#E4E4E4"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="style43">
                  <tr>
                    <td height="20" colspan="3" align="left" bgcolor="#006599" class="style45"><img src="../images/square-lb.gif" width="8" height="8"><? echo $Mensajes["tc-1"]." ".$Letra; ?></span></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left" class="style45">
                      <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="50%" valign="top"><br>                            <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="0">
                              <tr valign="top">
                                <td><div align="right"><span class="style46"><? echo $Mensajes["tf-2"]; ?></span></div></td>
                                <td align="left">
                                  <input type="text" name="Busca" size="20"  class="style49">
                                  <br>

                                  <input class="style43" type="button" value="<? echo $Mensajes["bot-2"]; ?>" name="Enviar" OnClick="recargo(form1.Busca.value)"></td>
                              </tr>
                            </table>                            </td>
                          <td valign="top">
                          <div align="center">
                            <center>
                            <br>
                            <table width="260"  border="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111">
                            <tr class="style43">
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('A')">A</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('B')">B</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('C')">C</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('D')">D</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('E')">E</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('F')">F</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('G')">G</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('H')">H</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('I')">I</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('J')">J</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('K')">K</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('L')">L</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('M')">M</a></div></td>
                            </tr>
                            <tr class="style43">
                            <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('N')">N</a></div></td>
                            <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('O')">O</a></div></td>
                            <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('P')">P</a></div></td>
                            <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('Q')">Q</a></div></td>
                            <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('R')">R</a></div></td>
                            <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('S')">S</a></div></td>
                            <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('T')">T</a></div></td>
                            <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('U')">U</a></div></td>
                            <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('V')">V</a></div></td>
                            <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('W')">W</a></div></td>
                            <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('X')">X</a></div></td>
                            <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('Y')">Y</a></div></td>
                            <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('Z')">Z</a></div></td>
                            </tr>
                          </table>
                            <input class="style43" type="button" value="<? echo $Mensajes["bot-1"]; ?>" name="Boton" OnClick="retornaSin()">
                                <br>
                                  </center>
                          </div>
                            <div align="center"></div></td>
                        </tr>
                      </table>
     <input type="hidden" name="adonde" value="<? echo $adonde; ?>">
	 <input type="hidden" name="Id1" value="<? echo $Id1; ?>">
	 <input type="hidden" name="Nombre1" value="<? echo $Nombre1; ?>">
	 <input type="hidden" name="Id2" value="<? echo $Id2; ?>">
	 <input type="hidden" name="Nombre2" value="<? echo $Nombre2; ?>">

</form>

          <hr>
            <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
            <tr>
            <td>
            <?
   $expresion = "SELECT Apellido,Nombres,Instituciones.Nombre,Dependencias.Nombre";
   $expresion = $expresion.",Unidades.Nombre,Usuarios.Login,Usuarios.Password,Usuarios.Id,Personal,Bibliotecario FROM Usuarios";
   $expresion = $expresion." LEFT JOIN Instituciones ON Instituciones.Codigo=Usuarios.Codigo_Institucion";
   $expresion = $expresion." LEFT JOIN Dependencias ON Dependencias.Id=Usuarios.Codigo_Dependencia";
   $expresion = $expresion." LEFT JOIN Unidades ON Unidades.Id=Usuarios.Codigo_Unidad";
   $expresion = $expresion." WHERE Usuarios.Apellido LIKE '".$Letra."%' ORDER BY Apellido,Usuarios.Nombres";
   $result = mysql_query($expresion);
   echo mysql_error();

    while($row = mysql_fetch_row($result))
     {
?>
  <?
	$color = "#1C74A4";
	if ($row[8]==1)
	{
		$color = "#993333";
	}
	elseif ($row[9]==1)
	{
		$color = "#669999";
	}


?>
             <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                 <tr>
                 <td class="style49"><strong><?echo $row[0].",".$row[1] ; ?></strong></td>
                 <td class="style43"> <? echo $row[2]."-".$row[3]."-".$row[4]; ?> </td>
                 <td class="style49"><? echo $row[5]."-".$row[6]; ?></td>
                </tr>
                <tr>

                      <td colspan="3"> <? if ($adonde==1)
    {
    ?>
    <a href="union_usu.php?Id1=<? echo $row[7]; ?>&Nombre1=<?echo $row[0].",".$row[1] ; ?>">
    <? } else { ?>
    <a href="union_usu.php?Id1=<? echo $Id1 ?>&Nombre1=<? echo $Nombre1; ?>&Id2=<? echo $row[7]; ?>&Nombre2=<?echo $row[0].",".$row[1] ; ?>">
    <? } 
	 echo $Mensajes["h-4"]; ?></a></div></td>
                </tr>
             </table>
            <?}?>
            </td>
            </tr>
         </table>
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
              <td valign="top" class="style28"><div align="center"><img src="../../images/image001.jpg" width="150" height="118"><br>
                  <span class="style60"><a href="../indexadm.php"><? echo $Mensajes["cf-13"]; ?></a></span></div>                <div align="center" class="style55"></div></td>
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
          <td width="50" class="style49"><div align="center" class="style11">sus-001</div></td>
        </tr>
      </table>
      </div></td>
  </tr>
</table>
</div>
</body>
</html>

