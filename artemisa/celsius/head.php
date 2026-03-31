<?
 include_once "inc/var.inc.php";
  include_once "inc/"."conexion.inc.php";
  Conexion();
//echo ini_get('include_path');
  include_once "inc/"."identif.php";
 include_once "inc/"."fgenped.php";
  include_once "inc/"."fgentrad.php";
  include_once "inc/"."parametros.inc.php";
 //echo   include_once "inc/"."parametros.inc.php";;
 /*if (isset($HTTP_GET_VARS['IdiomaSeteado']))
  $IdiomaSeteado = $HTTP_GET_VARS['IdiomaSeteado']; 
*/

global $IdiomaSitio;

if (isset($IdiomaSeteado))
 {
  setcookie ("IdiomaSitio",$IdiomaSeteado,mktime(0,0,0,date("m"),date("d"),date("y")+10),"/");

  $Recargar=1;
  $IdiomaSitio=$IdiomaSeteado;
 }
 if (!isset($IdiomaSitio) || ($IdiomaSitio == 0))
 {  
     $Instruccion = "SELECT Id FROM Idiomas WHERE Predeterminado=1";
	 $result = mysql_query($Instruccion);
     $row = mysql_fetch_row($result);
     $IdiomaSitio = $row[0];

	 setcookie ("IdiomaSitio",$IdiomaSitio,mktime(0,0,0,date("m"),date("d"),date("y")+10),"/"); 
  } 
    
   $Mensajes = Comienzo ("ini_001",$IdiomaSitio);
	//echo $IdiomaSitio;
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);

?>


<HTML>
<HEAD>
<title><? //echo Titulo_Sitio();?></title>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
<script language="JavaScript">
  
 function Recargar_Todo()
 {
	document.forms.form1.IdiomaSeteado.value=document.getElementById('idioma').value;
	document.forms.form1.submit();
 }
 
 function showAdministration()
 {

  var txt = document.getElementById('login_admin');
  if (txt.style.visibility == 'hidden')
    {
     txt.style.visibility = 'visible';
     txt.style.position = 'relative';
     }
     else
     {
     txt.style.visibility = 'hidden';
     txt.style.position = 'absolute';
      }
  }
</script>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana;
	font-size: 9px;
	color: #FFFFFF;
}
.style2 {
	font-family: Verdana;
	font-size: 9px;
	color: #2792F0;
}
.style3 {
	color: #006699;
	font-family: Verdana;
	font-size: 9px;
}
body {
	background-color: #006699;
	margin-left: 10px;
}
a:link {
	color: #006699;
}
a:visited {
	color: #006699;
}
a:hover {
	color: #FFFFFF;
}
a:active {
	color: #006699;
}
-->
</style>
</HEAD>

<BODY LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
<!-- ImageReady Slices (head-celsius-4.psd) -->
<TABLE WIDTH=780 BORDER=0 CELLPADDING=0 CELLSPACING=0>
	<TR background="images/head_01.jpg">
		<TD height="25" COLSPAN=8><div align="right"><span class="style1">
              <font face="Arial" size="1">
              <a style="color: #FFFFFF" target="bottom" href="usuarios/sitiousuariologed.php"><span id='login' style='visibility:visible;'><? echo $Mensajes['st-006'];?></span></a> | 
              <a style="color: #FFFFFF" href="admin/indexadm.php" target="bottom"><span id='login_admin' style='visibility:visible;'><? echo $Mensajes['st-007'];?></span></a> |
              </font> 
              </span>
                <font face="Arial" size="1"><font size="1">
            <select name="Idioma" id='idioma' class="style2" OnChange="Recargar_Todo()">
             <?
  				$Instruccion = "SELECT Id,Nombre FROM Idiomas ORDER BY Nombre";
                $result = mysql_query($Instruccion);
                 while ($row=mysql_fetch_row($result))

				 { ?>
               	<option value="<?echo $row[0];?>" <? if ($row[0]==$IdiomaSitio) { echo " selected";} ?>><? echo $row[1]; ?></option>
              <? } ?>
            </select></font> </font>
            </div>			</TD>
  </TR>
	<TR>
		<TD COLSPAN=8>
			<IMG SRC="images/head_02.jpg" WIDTH=780 HEIGHT=12 ALT=""></TD>
	</TR>
	<TR>
		<TD ROWSPAN=2>
			<IMG SRC="images/head_03.jpg" WIDTH=151 HEIGHT=77 ALT=""></TD>
			<!--<IMG SRC="images/head_03.jpg" WIDTH=135 HEIGHT=68 ALT=""></TD>-->
		<TD COLSPAN=5>
			<IMG SRC="images/head_04.jpg" WIDTH=550 HEIGHT=67 ALT=""></TD>
		<TD>

			<A HREF="http://www.unlp.edu.ar" TARGET="_blank"
				ONMOUSEOVER="window.status='Sitio UNLP';  return true;"
				ONMOUSEOUT="window.status='';  return true;">
				<IMG SRC="images/head_05.jpg" WIDTH=69 HEIGHT=67 BORDER=0 ALT=""></A></TD>
		<TD>
			<IMG SRC="images/head_06.jpg" WIDTH=10 HEIGHT=67 ALT=""></TD>
	</TR>
	<TR>
		<TD COLSPAN=7>
			<IMG SRC="images/head_07.jpg" WIDTH=629 HEIGHT=10 ALT=""></TD>
	</TR>
	
	<TR>
		<TD COLSPAN=2 ROWSPAN=2>
			<IMG SRC="images/head_08.jpg" WIDTH=412 HEIGHT=26 ALT=""></TD>
		<TD width="90" height="26" align="center" valign="middle" class="style3" ROWSPAN=2 background="images/head_09.jpg">
			<a href="cuerpo.php" target="bottom"><? echo $Mensajes['st-001']; ?>	</a>		</TD>
		<TD width="90" height="26" align="center" valign="middle" class="style3" ROWSPAN=2 background="images/head_10.jpg">
			<a href="usuarios/descripcionservicio.php"  target="bottom"> <? echo $Mensajes['st-002']; ?></a></TD>
		<TD width="89" height="26" align="center" valign="middle" class="style3" ROWSPAN=2 background="images/head_11.jpg">
			<a href="usuarios/enlaces.php"  target="bottom"><? echo $Mensajes['st-003']; ?></a></TD>
		<TD height="26"  align="center" valign="middle" class="style3" COLSPAN=2 ROWSPAN=2 background="images/head_12.jpg">
			<a href="estadisticas/main-estadisticas.php" target="bottom"><? echo $Mensajes['st-005']; ?></a>			</TD>
		<TD>
			
			<IMG SRC="images/head_13.jpg" WIDTH=10 HEIGHT=4 ALT=""></a></TD>
	</TR>
	<TR>
		<TD>
			<IMG SRC="images/head_14.jpg" WIDTH=10 HEIGHT=22 ALT=""></TD>
	</TR>
	<TR>
		<TD>
			<IMG SRC="images/spacer.gif" WIDTH=151 HEIGHT=1 ALT=""></TD>
		<TD>
			<IMG SRC="images/spacer.gif" WIDTH=261 HEIGHT=1 ALT=""></TD>
		<TD>
			<IMG SRC="images/spacer.gif" WIDTH=90 HEIGHT=1 ALT=""></TD>
		<TD>
			<IMG SRC="images/spacer.gif" WIDTH=90 HEIGHT=1 ALT=""></TD>
		<TD>
			<IMG SRC="images/spacer.gif" WIDTH=89 HEIGHT=1 ALT=""></TD>
		<TD>
			<IMG SRC="images/spacer.gif" WIDTH=20 HEIGHT=1 ALT=""></TD>
		<TD>
			<IMG SRC="images/spacer.gif" WIDTH=69 HEIGHT=1 ALT=""></TD>
		<TD>
			<IMG SRC="images/spacer.gif" WIDTH=10 HEIGHT=1 ALT=""></TD>
	</TR>
</TABLE>

<!-- End ImageReady Slices -->
<span style='visibility:hidden;top:10;left:10;position:absolute'>
<form name='form1' method="get" action="head.php">
  <input type='hidden' name='IdiomaSeteado' value="1">
  <input type='hidden' name='cambiaIdioma' value="1"
</form>
</span>

  <?
    if (isset($cambiaIdioma))
	  if ($cambiaIdioma == 1) {

  ?>
  <script language="JavaScript">
   var aux = parent.frames.bottom.location.href;
	parent.frames.bottom.location.href = aux;
</script>
 <? } ?>

</BODY>
</HTML>