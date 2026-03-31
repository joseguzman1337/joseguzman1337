<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?

  include_once "../inc/var.inc.php";
  include_once "../inc/"."conexion.inc.php";
  Conexion();
  global $IdiomaSitio;
  include_once "../inc/fgentrad.php";
  $Mensajes = Comienzo ("cou-001",$IdiomaSitio);
?>
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
.style7 {color: #2D6FAC; font-size: 10px; }
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 9px; }
.style14 {
	font-size: 10px;
	font-family: Verdana;
	color: #FFFFFF;
}
.style15 {color: #006599}
.style17 {
	font-size: 9px;
	font-family: Verdana;
	color: #000000;
}
.style18 {color: #006699}
.style20 {color: #E4E4E4}
.style23 {font-size: 10}
.style24 {
	color: #000000;
	font-size: 9px;
	font-family: verdana;
}
.style26 {color: #006699; font-weight: bold; }
.style28 {font-size: 11px}
-->
</style>
<script>

function verifyEmail(checkEmail) {

if ((checkEmail.indexOf('@') < 0) || ((checkEmail.charAt(checkEmail.length-4) != '.') && (checkEmail.charAt(checkEmail.length-3) != '.')))
{ alert('La direccion de email es inválida');
  return false;
}

else {
  return true;
}

}


function evaluarcampo(c)
{
 if (c.value == '')
   {
     c.value = ' *** Debe completar este campo';
     c.focus();
     return false;
   }
   return true;
}
function verificar()
{
    if ((evaluarcampo(document.forms.form1.nombre))
      &&  (evaluarcampo(document.forms.form1.email))
      &&  (verifyEmail(document.forms.form1.email.value))
      &&  (evaluarcampo(document.forms.form1.subject))
      &&  (evaluarcampo(document.forms.form1.texto)))
             document.forms.form1.submit();


}

</script>
<base target="_self">
</head>

<body topmargin="0">
<div align="left">

  <table width="780" border="0" align="left" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#E4E4E4" style="border-collapse: collapse">
  <tr>
    <td valign="top" bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <span align="center">
        <center>
          <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#E4E4E4">
        <td valign="top" bgcolor="#E4E4E4">
            <span align="center">
              <center>
                <table width="97%" border="0" style="margin-bottom: 0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td class="style17" align=left><blockquote>
                <? if (!isset($enviando)) {
                    ?>
                  <p class="style17 style23"><span class="style28"><? echo $Mensajes["ec-1"];?> <span class="style26"> PrEBi </span> </span></p>
                          <p class="style17 style28">
                         <? echo $Mensajes["ec-2"];?> <a href="mailto:<? echo Destino_Mail(); ?>"><? echo Destino_Mail();?></a> <? echo $Mensajes["ec-3"]?>
                          <form name="form1" action="contactus.php">
                          <input type=hidden name=enviando value=1>
                          <table valign="top">
                            <tr>
                             <td width=20% align=left valign="top">
                               <? echo $Mensajes["ec-4"]?> </td> <td align=left> <input class="style24" type=text name=nombre>
                             </td>
                             <td align=left valign="top">
                                <? echo $Mensajes["ec-5"]?> </td> <td align=left><input class="style24" type=text name=email>
                             </td>
                            </tr>
                            <tr>
                            <td valign="top"> <? echo $Mensajes["ec-6"]?>  </td> <td align=left><input class="style24" type=text name=subject> </td>
                            </tr>
                            <tr> <td valign="top"><? echo $Mensajes["ec-7"]?> 
                            </td> <td align=left>
                            <textarea name=texto cols=30 rows=5 class="style24"></textarea>
                            </td>
                            </tr>
                            <tr td align=center><td> &nbsp;</td> <td colspan>
                            <input class="style24" type=button value="<?echo $Mensajes["bot-1"]?>" onclick="verificar()">							
                            <input class="style24" type=reset value="<?echo $Mensajes["bot-2"]?>">
                            </td> </tr> </table>
                          </form> </p>
                           <br>
                            </span><br>
                            </p>
                       <?
                       }
                       else
                       {   $fecha = getDate();
                           $fechaFormateada = " ".$fecha['month']." ".$fecha['mday'].", ".$fecha['year'];
                           //mail(Destino_Mail(),$subject,$texto,'From:'.$email);
                           $text = $nombre.' escribio el '.$fechaFormateada.': '.$texto;
                           $dest = Destino_Mail();
                           mail($dest,$subject,$text,'From:'.$email);
                         echo '<p class="style17 style28">'.$Mensajes["ec-8"].' </p>';
                       }
                       ?>
                  </blockquote></td>
              </tr>
            </table>
              </center>
            </span>            </td>

        </div>
          </td>
          <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
            <table width="100%" bgcolor="#ececec">
            <tr>
              <td class="style28"><span class="style55"><img src="../images/image001.jpg" width="150" height="118"></span></td>
            </tr>
          </table>
          </div>
          </td>
        </tr>
    </table>    </center>    </td>
    

  </tr>
 
  <tr>
    <td height="44" bgcolor="#E4E4E4">
     <font face="Arial">
      <center>
        <hr>
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50">&nbsp;</td>
            <td><div align="center"><font face="Arial"><a href='http://www.unlp.istec.org/prebi' target=_BLANK border=0><img border="0" src="../images/logo-prebi.jpg"></a></font></div></td>
            <td width="50"><div align="center" class="style17">
              <div align="right" class="style18">
                <div align="center">cou-001</div>
              </div>
            </div></td>
          </tr>
        </table>
        <a href='http://www.unlp.istec.org/prebi' target=_BLANK border=0>
        </a>
      </center>
     </font>
    </td>
  </tr>
</table>
</div>
</body>
</html>
