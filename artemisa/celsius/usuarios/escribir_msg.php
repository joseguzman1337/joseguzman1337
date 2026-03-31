<?
   include_once "../inc/var.inc.php";
   include_once "../inc/conexion.inc.php"; 
   Conexion();	
   include_once "../inc/identif.php"; 
   Administracion();
   global  $IdiomaSitio ; 
 ?>

<html>
<head>
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
.style7 {color: #FFFFFF; font-size: 11px; }
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 11px; }
.style14 {
	font-size: 11px;
	font-family: Verdana;
	color: #FFFFFF;
}
.style15 {color: #006599}
.style17 {
	font-size: 11px;
	font-family: Verdana;
	color: #000000;
}
.style18 {color: #006699}
.style20 {color: #E4E4E4}
.style23 {font-size: 11}
.style24 {
	color: #000000;
	font-size: 11px;
	font-family: verdana;
}
.style26{font-family: verdana; font-size: 11px; color: #006599; }
.style28 {font-size: 11px}
.style30 {
	font-size: 11px;
	color: #000000;
	font-family: Verdana;
}
.style47 {font-family: verdana; font-size: 11px; color: #666666; }
-->
</style>
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

 <?
    include_once "../inc/fgenped.php";
    include_once "../inc/fgentrad.php";
    $Mensajes = Comienzo ("msg-001",$IdiomaSitio);  
    $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);

	if (!isset($enviado)) {
      echo "<tr> <td class='style17' align=left> <blockquote> <p class='style17 style23'><span class='style28'>".$Mensajes['et-001']." <span class='style26'>".$usuario.":</span> </span></p> </font> </td> </tr>";

	  echo "<tr> <td class='style17' align=left> <blockquote> <p class='style17 style23'><form name='form1'> <TEXTAREA class='style24'  NAME='texto' ROWS='5' COLS='30'></TEXTAREA></td> </tr> 
	  <tr> <td class='style17' align=left> <blockquote> <p class='style17 style23'> <input type='hidden' name='idUsuario' value='".$idUsuario."'> <input type='hidden' name='enviado' value='1'> <input class='style24' type='submit' value=".$Mensajes['bot-1']."> </form> </td> </tr>";
 }
  
  else
		{$query = "INSERT INTO Mensajes_Usuarios (idUsuario,fecha_creado,texto)	           VALUES('".$idUsuario."',NOW(),'".$texto."')";
		  $resu = mysql_query($query);
		  echo mysql_error();
           echo "<tr > <td class='style17 style30' align=center > <blockquote> <p class='style17 style23'><span class='style28'><span class='style26'>".$Mensajes['et-002']."</span></p> </blockquote><br> </td> </tr>";
		   echo " <tr >        
		   <td class='style17 style47' align=center width='50%'> <blockquote> <p class='style17 style23'><span class='style28'><span class='style26'> <a href='../admin/indexadm.php'>  <a href='mensajes.php?operacion=1'>".$Mensajes['h-002']."</a> </span></p> </blockquote> </td> </tr>";
		}

	?>
	</table>
	  </center>
            </span>            </td>
        
        </div>
          </td>
          <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">

            <table width="100%" bgcolor="#ececec">
            <tr>
              <td class="style28"><span class="style55"><img src="../images/image001.jpg" width="150" height="118"></span><br>
                    <a href="../admin/indexadm.php"><span class="style33"><? echo $Mensajes['h-001']; ?></span></a></td>
            </tr>
			
          </table>
          </div>
          </td>

        </tr>
    </table>    </center>    </td>
    

  </tr>
 
 
  <?
  include_once "../inc/"."barrainferior.php";
  DibujarBarraInferior(); ?>
	
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
                <div align="center">msg-001</div>
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