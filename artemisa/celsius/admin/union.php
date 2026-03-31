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
.style56 {color: #00FFFF}
.style66 {color: #000000}
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<?
    include_once "../inc/"."fgenped.php";
    include_once "../inc/"."fgentrad.php";
	global $IdiomaSitio;
    $Mensajes = Comienzo ("uni-001",$IdiomaSitio);  
    $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
   
?>

<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">      <div align="center"><center>
        <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td bgcolor="#E4E4E4">            <div align="center">
              <center>
            <table width="95%" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td valign="top" bgcolor="#E4E4E4"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="style43">
                  <tr>
                    <td height="20" colspan="3" align="left" bgcolor="#0099CC" class="style45"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["tit-1"]; ?><span class="style56"></span></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left" class="style45"><blockquote>
                      <p class="style43 style66"> 
                        <img src="../images/square-lb.gif" width="8" height="8"><a href="publicac/union_pub.php?definido=0"><? echo $Mensajes["h-1"]; ?></a><br>
                          <img src="../images/square-lb.gif" width="8" height="8"> <a href="paises/union_pai.php"><? echo $Mensajes["h-2"]; ?></a><br>
                          <img src="../images/square-lb.gif" width="8" height="8"><a href="instituciones/union_inst.php"><? echo $Mensajes["h-3"]; ?></a><br>
                          <img src="../images/square-lb.gif" width="8" height="8"><a href="dependencias/union_depe.php"><? echo $Mensajes["h-4"]; ?></a><br>
                          <img src="../images/square-lb.gif" width="8" height="8"><a href="unidades/union_unid.php"><? echo $Mensajes["h-5"]; ?></a><br>
                          <img src="../images/square-lb.gif" width="8" height="8"><a href="usuarios/union_usu.php?definido=0"><? echo $Mensajes["h-6"]; ?></a><br>
                          <img src="../images/square-lb.gif" width="8" height="8"><a href="tiposusu/union_tusu.php?definido=0"><? echo $Mensajes["h-8"]; ?></a></p>
                    </blockquote></td>
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
              <td class="style28"><div align="center"></div>                <div align="center" class="style11"><img src="../images/image001.jpg" width="150" height="118"><br>
                 <a href="indexadm.php"><? echo $Mensajes["h-7"]; ?></a></div></td>
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
          <td width="50" class="style49"><div align="center" class="style11">uni-001</div></td>
        </tr>
      </table>
      </div></td>
  </tr>
</table>
</div>
</body>
</html>