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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
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
.style26 {color: #006699; font-weight: bold; }
.style28 {font-size: 11px}
-->
</style>
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
                         <p class="style17 style28"><? echo $Mensajes['st-002']; ?></p>
                          <p align="center" class="style17 style23"><span class="style28"><span class="style18"><? echo $Mensajes['st_003']?></span> <br>
                            </span><br>
                            </p>
                  </blockquote></td>
              </tr>
            </table>
              </center>
            </span>            </td>
        <td width="150" valign="top"><div align="center">
              <table width="150" border="0" align="center">
                <tr bgcolor="#006699">
                  <td height="20" colspan="2"><div align="left">
                      <p align="center" style="margin-top: 0; margin-bottom: 0; color: #FFFFFF;">
                      
                       <span class="style14"><? echo $Mensajes['st-001'];?></span>          
                  </div></td>
                </tr>
                <?
                 
         		 $result = mysql_query("SELECT Titulo,Texto_Noticia,Fecha,Id FROM Noticias WHERE Codigo_Idioma='".$IdiomaSitio."' ORDER BY Fecha DESC LIMIT 3");

		         while($row = mysql_fetch_row($result))
        		   {
		       ?>

                <tr>
                  <td bgcolor="#CFDCE4" colspan="2"><div align="left" class="style15">
                      <p style="margin-left: 3; margin-top: 0; margin-bottom: 0; font-size: 10px; ; font-family: Arial, Helvetica, sans-serif; font-weight: bold;; font-family: Arial, Helvetica, sans-serif;">
                      <font face="Arial"> <?
                                    if (strlen($row[0])>100)
                                    {
                                		$titulo = substr($row[0],0,100)."...";
                                	}	else {
                                		$titulo = $row[0];
                                	}
                                    echo  strtoupper($titulo);
                                    ?>
                     .</font></p>
                      <p style="margin-left: 3; margin-top: 0; margin-bottom: 0; font-size: 12px;; font-family: Arial, Helvetica, sans-serif;; font-family: Arial, Helvetica, sans-serif;"><span style="font-size: 10px">
                      <font face="Arial"><?echo substr($row[1],0,270)."...";?></font></span></p>
                  </div></td>
                </tr>
                
                <tr class="style7">
                  <td>
                    <p style="margin-top: 0; margin-bottom: 0" align="center"><span class="style11">
                    <font face="Arial" size="1"><?echo substr($row[2],0,10);?></font></span></td>
                  <td>
                    <p style="margin-top: 0; margin-bottom: 0" align="center"><span class="style11">
                    <font face="Arial" size="1">
                    <?
                        $tiempo = getdate();
                        $Fin = $tiempo["year"]."-".$tiempo["mon"]."-".$tiempo["mday"];
                        $Inicio = "2000-01-01";
                        echo "<a href='noticias/todas_not.php?Inicio=".$Inicio."&Fin=".$Fin."&fila_actual=1'> >> </a>";
                   ?>
           </font></span></td>
                </tr>
                <?
                 }
                ?>
              </table>
        </div>
          </td>
        </tr>
    </table>    </center>    </td>
  </tr>
  <?
  include_once "inc/barrainferior.php";
  DibujarBarraInferior($IdiomaSitio);
  ?>

  <tr>
    <td height="44" bgcolor="#E4E4E4">
     <font face="Arial">
      <center> 
        <hr>
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50">&nbsp;</td>
            <td><div align="center"><font face="Arial"><a href='http://www.unlp.istec.org/prebi' target=_BLANK border=0><img border="0" src="images/logo-prebi.jpg"></a></font></div></td>
            <td width="50"><div align="center" class="style17">
              <div align="right" class="style18">
                <div align="center">ini_002</div>
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
