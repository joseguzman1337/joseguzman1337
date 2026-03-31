<?
  include_once "../inc/var.inc.php";
  include_once "../inc/"."conexion.inc.php";
  Conexion();
  	if ((isset($CkSesionId)) && ($CkSesionId))
	{
    include_once "../inc/"."sesion.inc";
	SesionDestruye();
	}

  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."fgentrad.php";
   global  $IdiomaSitio ; 
if ( !isset($IdiomaSeteado))
		$IdiomaSeteado="";


  if ($IdiomaSeteado!="")
 {
	  setcookie ("IdiomaSitio",$IdiomaSeteado,mktime(0,0,0,date("m"),date("d"),date("y")+10),"/");
	  $Recargar=1;
	  $IdiomaSitio=$IdiomaSeteado;

	}
	else
	  $IdiomaSitio = 1;
	
  $Mensajes = Comienzo ("logu",$IdiomaSitio);
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);


?>
<title><? echo Titulo_Sitio();?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="../desmd5.js"></script>
<script>
   window.parent.frames[0].document.getElementById('login').firstChild.nodeValue = '<? echo $Mensajes["st-2"]; ?>';
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
        <td bgcolor="#E4E4E4">
            <div align="center">
              <center>
            <table width="97%" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
             <tr><td><table><tr><td><a href="manual.pdf" target="_blanck"><img border="0" src="../images/adobe.gif"></a></td><td align="right" class="style30"><a href="manual.pdf" target="_blanck"><? echo $Mensajes['tt-01']; ?>  </a></td></tr></table></td></tr>
			  <tr><td><?    echo '<p align="left" style="margin-top:0; margin-bottom:0; font-family: verdana; font-size: 10px;"><font color="#006699"><b>'.$Mensajes["st-1"].'</b></font></p>';?>
</td></tr>
			  <tr>
                <td bgcolor="#E4E4E4" align=left>                  <blockquote class="style30">

                  		<?

		                  $result = mysql_query("SELECT Titulo,Comentario,Id FROM Sugerencias Order by Id");
                             while($row = mysql_fetch_array($result))
                       		   {
                                /*if ($row[2] == 2) //parche malll!!!! La primer sugerencia es la descipcion del servicio, luego vienen las sugerencias al usuario
                                  */
                		 ?>
                                 <p align="left" style="margin-top:0; margin-bottom:0; font-family: verdana; font-size: 10px;">&nbsp;</p>
                                 <p align="left" style="margin-top:0; margin-bottom:0; font-family: verdana; font-size: 10px;">
                                 <font color="#006699">
                                 <img border="0" src="../images/square-lb.gif" width="8" height="8"> <? echo $row[0];?> </font><?echo $row[1]; ?> </p>
                          <?
                                 }
                          ?>
                </blockquote>
                <p style="margin: 0 10; font-size: 10px;"></p></td>
              </tr>
            </table>
              </center>
            </div>
            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
        <form name='form1' method=POST onsubmit='return false' action="sitiousuariologed.php"]>
          <table width="100%" border="0" bgcolor="#EFEFEF">
            <tr>
              <td height="20" bgcolor="#006699" class="style28"><div align="center">
                <p style="margin-top: 0; margin-bottom: 0; color: #FFFFFF;"><? echo $Mensajes['st-2']; ?></div></td>
            </tr>
            <tr>
              <td bgcolor="#ECECEC"><table width="129" border="0" align="center" cellspacing="0">
                <tr>
                  <td width="27" class="style11"><div align="right">
                    <p style="margin-top: 0; margin-bottom: 0"><? echo $Mensajes['st-3']; ?></div></td>
                  <td width="98"><div align="left">
                      <p style="margin-top: 0; margin-bottom: 0">
                      <input name=Login id='Login' type=text class="style22" size="19"></div></td>
                </tr>
                <tr>
                  <td width="27" class="style11"><div align="right">
                    <p style="margin-top: 0; margin-bottom: 0"><? echo $Mensajes['st-4']; ?></div></td>
                  <td width="98"><div align="left">
                      <p style="margin-top: 0; margin-bottom: 0">
                      <input name="Password" id='Password' type=password class="style22" size="19"></div></td>
                </tr>
                <tr>
                  <td colspan="2" class="style11">
                      <div align="right">
                        <p style="margin-top: 0; margin-bottom: 0">
                        <input name="B1" type="submit" onClick="procesar()" class="style22" value="<? echo $Mensajes['bot-1']; ?>">
                        <input type="reset" class="style22" value="<? echo $Mensajes['bot-2']; ?>">
                      </div>
                   </td>
                  </tr>
              </table>
              <input type="hidden" name="comunidad_login" value="1">
              </form>
              </td>
            </tr>
            <tr>
              <td height="18" bgcolor="#CECECE" class="style28"><div align="center" class="style23 style30"><a href="olvidocontrasenia.php"><? echo $Mensajes['st-5']; ?></a>
              </div></td>
            </tr>
            <tr>
              <td height="18" bgcolor="#CECECE" class="style28"><div align="center" class="style26 style30 style32">
                <div align="center">
                  <p style="margin-top: 0; margin-bottom: 0"><a href="add_cand1.php"><? echo $Mensajes['st-6']; ?></a></div>
              </div></td>
            </tr>

          </table>
          </div></td>
        </tr>
    </table>    </center>
      </div>    </td>
  </tr>
  <?
  include_once "../inc/barrainferior.php";
     DibujarBarraInferior();
   ?>
   <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">      
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50"><div align="right" class="style33">
            <div align="center">logu</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>
