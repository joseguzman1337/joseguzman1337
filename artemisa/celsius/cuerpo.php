<?
 include_once "inc/var.inc.php";
 include_once "inc/"."conexion.inc.php";
 Conexion();
 include_once "inc/"."fgentrad.php";
 include_once "inc/"."parametros.inc.php";
 //echo ini_get('include_path');
 global $IdiomaSitio;

 $Mensajes = Comienzo ("ini_002",$IdiomaSitio);
 $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
?>

<html>

<head>
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Prebi</title>
<style type="text/css">
<!--
body {
	background-color: #90a623;
	margin-left: 10px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
/*.style8 {

	font-family: Verdana;
	font-size: 9px;
	font-weight: normal;
	color: #333333;
}*/
-->
</style>
<link href="celsius.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="780" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="780" border="0" align="left" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#E4E4E4" style="border-collapse: collapse">
      <tr>
        <td valign="top" bgcolor="#E4E4E4">
          <hr color="#E4E4E4" size="1">
          <span align="center">
          <center>
            <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="2" cellspacing="0">
              <tr bgcolor="#E4E4E4">
                <td valign="top" bgcolor="#E4E4E4"> <span align="center">
                  <center>
                    <table width="580" border="0" align="center" cellpadding="2" cellspacing="4" bgcolor="#F3F3F1">
                      <tr>
                        <td width="120" align="left" valign="top" background="images/teclado.jpg">&nbsp;</td>
                        <td align="left" valign="top"><p><span class="style2"><? echo $Mensajes["st-002"]; ?></span> </p>
                            <blockquote>
                              <p align="center" class="style4"><? echo $Mensajes["st-003"]; ?></p>
                          </blockquote>
						
                              <p align="center" class="style4"><a href="usuarios/manual.pdf" target="_blanck"><img border="0" width="20" height="20" src="images/adobe.gif"></a>&nbsp;<a class='style15' href="usuarios/manual.pdf" target="_blanck"><? echo $Mensajes["st-004"]; ?></a></p>
                         
						  </td>
                      </tr>
                    </table>
                    <hr align="center" width="580" size="1" class="style3">
                    <table width="580" border="0" align="center" cellpadding="3" cellspacing="2" bgcolor="#F3F3F1">
                      <tr bgcolor="#09B6E1">
                        <td height="20" bgcolor="#0099CC"><div align="left">
                            <p align="left" class="style1" style="margin-top: 0; margin-bottom: 0; color: #FFFFFF;"><img src="images/b1owhite.gif" width="8" height="8"> <span class="style5"><? echo $Mensajes["st-001"]; ?></span>     
                        </div></td>
                      </tr>
<?
                 if (!isset($IdiomaSitio))
				 {
				 $Instruccion = "SELECT Id FROM Idiomas WHERE Predeterminado=1";
             	 $result = mysql_query($Instruccion);
                 $row = mysql_fetch_row($result);
                 $IdiomaSitio = $row[0];
				 }
         		 $result = mysql_query("SELECT Titulo,Texto_Noticia,Fecha,Id FROM Noticias WHERE Codigo_Idioma='".$IdiomaSitio."' ORDER BY Fecha DESC LIMIT 3");
                 
		         while($row = mysql_fetch_row($result))
        		   {
		       ?>
					  
				
                      <tr bgcolor="#F3F3F1">
                        <td><div align="left" class="style15">
                      <span class="style3"><p style="margin-left: 3; margin-top: 0; margin-bottom: 0; font-size: 12px;; font-family: Arial, Helvetica, sans-serif;; font-family: Arial, Helvetica, sans-serif;"><span  style="font-size: 10px"><?
                                    if (strlen($row[0])>100)
                                    {
                                		$titulo = substr($row[0],0,100)."...";
                                	}	else {
                                		$titulo = $row[0];
                                	}
                                    echo  strtoupper($titulo);
                                    ?>
                     .</span><span class="style4"><br>
                              </span><span class="style2"><p style="margin-left: 3; margin-top: 0; margin-bottom: 0; font-size: 12px;; font-family: Arial, Helvetica, sans-serif;; font-family: Arial, Helvetica, sans-serif;"><span style="font-size: 10px">
                      <font face="Arial"><?echo substr($row[1],0,270)."...";?></span><br>
                              </p>
                        </div></td>
                      </tr>
                      <tr class="style7">
                        <td align="right" valign="middle" bgcolor="#E4E4E4"><font size="1" face="Arial" class="style15"><?
                        $tiempo = getdate();
                        $Fin = $tiempo["year"]."-".$tiempo["mon"]."-".$tiempo["mday"];
                        $Inicio = "2000-01-01";
						echo substr($row[2],0,10)."|";
                        echo "<a class='style15' href='noticias/todas_not.php?Inicio=".$Inicio."&Fin=".$Fin."&fila_actual=1'>Leer m&aacute;s &gt;&gt;</a>";
                   ?>  </font></td>
                      </tr>
                      
                      <?
                 }
                ?>
                    </table>
                  </center>
                </span> </td>
                <td width="154" valign="top"><div align="center">
                    <table width="100%" height="20" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#0099CC">
                      <tr>
                        <td class="style5"><div align="center" class="style18"><? echo $Mensajes["st-005"]; ?></div></td>
                      </tr>
                    </table>
                    <table width="100%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#E4E4E4">
                      <tr>
                        <td width="13"><div align="center"><img src="images/square-lb.gif" width="8" height="8"></div></td>
                        <td bgcolor="#F3F3F1" class="style2"><a href="usuarios/add_cand1.php" class="style15" ><? echo $Mensajes["st-006"]; ?></a> </td>
                      </tr>
                      <tr>
                        <td width="13"><div align="center"><img src="images/square-lb.gif" width="8" height="8"></div></td>
                        <td bgcolor="#F3F3F1" class="style2"><a  href="usuarios/sitiousuariologed.php" class="style15"><? echo $Mensajes["st-007"]; ?></a></td>
                      </tr>
                      <tr>
                        <td width="13"><div align="center"><img src="images/square-lb.gif" width="8" height="8"></div></td>
                        <td bgcolor="#F3F3F1" class="style2"><a  href="admin/indexadm.php" class="style15" ><? echo $Mensajes["st-008"]; ?></a> </td>
                      </tr>
                    </table>
                    <table width="100%" height="60" border="0" align="center" cellpadding="0" cellspacing="2" bgcolor="#E4E4E4">
                      <tr>
                        <td height="20" bgcolor="#0080C0" class="style5"><div align="center">
                            <table border="0" align="left" cellpadding="0" cellspacing="2">
                              <tr>
                                <td><img src="images/m_1_s.gif" width="14" height="11"></td>
                                <td class="style5"><a href="mail/contactus.php" class="style5"><? echo $Mensajes["st-009"]; ?></a> </td>
                              </tr>
                            </table>
                        </div></td>
                      </tr>
                      <tr>
                        <td height="20" bgcolor="#006699" class="style5">
                          <table border="0" align="left" cellpadding="0" cellspacing="2">
                            <tr>
                              <td><img src="images/home_s.gif" width="15" height="15"></td>
                              <td class="style5"><? echo $Mensajes["st-010"]; ?></td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td height="150" valign="middle" bgcolor="#F3F3F1" class="style5"><p align="center"><a href="http://www.unlp.istec.org" target="_blanck"><img border="0" src="images/banner-istec.jpg" width="88" height="31"></a></p>
                            <p align="center"><a href="http://sedici.unlp.edu.ar" target="_blanck" ><img border="0" src="images/webservices03.gif" width="88" height="31"></a></p>
                            <p align="center"><a href="http://www.unlp.istec.org/prebi/" target="_blanck" ><img border="0" src="images/banner-prebi.jpg" width="88" height="31"></a></p></td>
                      </tr>
                    </table>
                </div></td>
              </tr>
            </table>
          </center>
        </span></td>
      </tr>
	  <tr><td>&nbsp;</td></tr>
 <!--     <tr>
        <td height="25" background="images/head_01.jpg" bgcolor="#E4E4E4"><div align="center"></div></td>
      </tr>-->
      <tr>
        <td height="44" bgcolor="#E4E4E4"> <font face="Arial">
          <center>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="50">&nbsp;</td>
                <td><div align="center"><font face="Arial"><a href='http://www.unlp.istec.org/prebi' target=_BLANK border=0><img border="0" src="images/logo-prebi.jpg"></a></font></div></td>
                <td width="50"><div align="center" class="style17">
                    <div align="right" class="style18">
                      <div align="center" class="style7">ini_002</div>
                    </div>
                </div></td>
              </tr>
            </table>
            <a href='http://www.unlp.istec.org/prebi' target=_BLANK border=0> </a>
          </center>
        </font> </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>

</html>
