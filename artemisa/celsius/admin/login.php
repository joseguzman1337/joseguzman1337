<?
  include_once "../inc/var.inc.php";
  global $IdiomaSitio;
  include_once "../inc/"."conexion.inc.php";
  Conexion();
  include_once "../inc/"."sesion.inc";
  include_once "../inc/"."fgentrad.php";
  if (isset($CkSesionId))
    if ($CkSesionId) { 
 	SesionDestruye();
   }
   $Mensajes = Comienzo ("log-adm",$IdiomaSitio);  
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><? echo Titulo_Sitio();?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script>
 window.parent.frames[0].document.getElementById('login_admin').firstChild.nodeValue = "<? echo $Mensajes["txt-1"]; ?>";
 window.parent.frames[0].document.getElementById('login_admin').style.visibility = "visible";
// window.parent.frames[0].document.getElementById('login_admin').style.position = "absolute";
</script>
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
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 9px; }
.style22 {
	color: #333333;
	font-family: verdana;
	font-size: 9px;
}
.style23 {
	color: #FFFFFF;
	font-size: 10px;
}
.style26 {color: #FFFFFF; font-size: 10; }
.style28 {color: #FFFFFF; font-size: 11px; }
.style30 {
	font-size: 10px;
	color: #000000;
	font-family: Verdana;
}
.style32 {font-size: 10px}
.style33 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
.style36 {font-family: verdana; font-size: 9px; color: #006699; font-weight: bold; }
-->
</style>
<base target="_self">
<script type="text/javascript" src="../desmd5.js"></script>
</head>

<body topmargin="0">
<div align="left">
<form name="form1" method="POST" action="indexadm.php">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td valign="top" bgcolor="#E4E4E4">
            <div align="center">
              <center>
                <table width="97%" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td bgcolor="#E4E4E4">                  <blockquote class="style30">
                  <p align="left" style="margin-top:0; margin-bottom:0; font-family: verdana; font-size: 10px;"><? echo $Mensajes["tf-3"]; ?></p>
                  </blockquote>                  
                <p style="margin: 0 10; font-size: 10px;"></p></td>
              </tr>
            </table>
              </center>
            </div>            </td>
        <td width="170" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" border="0" bgcolor="#EFEFEF">
            <tr>
              <td height="20" bgcolor="#006699" class="style28"><div align="center">
                <p style="margin-top: 0; margin-bottom: 0; color: #FFFFFF;"><? echo $Mensajes["txt-1"]; ?>
              </div></td>
            </tr>
            <tr>
              <td bgcolor="#ECECEC"><table width="129" border="0" align="center" cellspacing="0">
                <tr>
                  <td width="20" class="style11"><div align="right">
                    <p style="margin-top: 0; margin-bottom: 0"><? echo $Mensajes["tf-1"]; ?></div></td>
                  <td width="98"><div align="left">
                      <p style="margin-top: 0; margin-bottom: 0">
                      <input name=Login type=text class="style22" size="19"></div></td>
					  <script>
					    document.forms["form1"].Login.focus();
					  </script>
                </tr>
                <tr>
                  <td width="27" class="style11"><div align="right">
                    <p style="margin-top: 0; margin-bottom: 0"><? echo $Mensajes["tf-2"]; ?></div></td>
                  <td width="98"><div align="left">
                      <p style="margin-top: 0; margin-bottom: 0">
                      <input id="Password" name="Password" type= password class="style22" size="19"></div></td>
                </tr>
                <tr>
                  <td colspan="2" class="style11">
                      <div align="right">
                        <p style="margin-top: 0; margin-bottom: 0">
                        <input name="B1" type="submit" class="style22" onClick="procesar()"  value="<? echo $Mensajes["bot-1"]; ?>">
                        <input name="B2" type="reset" class="style22" value="<? echo $Mensajes["bot-2"]; ?>">
                      </div>
                  </td>
                  </tr>
              </table>
              </td>
            </tr>
            <tr>
              <td height="18" bgcolor="#CECECE" class="style28"><div align="center" class="style23 style30">
              </div></td>
            </tr>
          </table>

		  </div></td>
        </tr>
    </table>    </center>
      </div>    </td>
  </tr>
          <input type="hidden" name="estado_login" value="1">
		  </form>
 
  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">      
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50"><div align="right" class="style33">
            <div align="center">log-adm</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
<? Desconectar();?>
</body>
</html>
