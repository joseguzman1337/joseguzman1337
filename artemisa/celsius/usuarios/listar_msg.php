<?
   include_once "../inc/var.inc.php";
   include_once "../inc/conexion.inc.php";  
   Conexion();	
   include_once "../inc/identif.php"; 
   Administracion();
   include_once "../inc/fgenped.php";
   include_once "../inc/fgentrad.php";
   global  $IdiomaSitio ; 
   $Mensajes = Comienzo ("msg-001",$IdiomaSitio);  
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  
 ?>

<html>
<head>
<style>
<!--
body {
	margin:0px;
	background-color: #006599;
	margin-left: 10px;;
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
.style11  {font-family: verdana; font-size: 11px; }

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
<body background="../imagenes/banda.jpg">
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
				<tr> <td class='style17' align=left> <blockquote> <p class='style17 style23'><span class='style28'><span class='style26'><? echo $usuario; ?></span> </span></p> </font> </td> </tr>
				<tr> <td class='style17' align=left> <blockquote> <p class='style17 style23'><span class='style28'><span class='style26'>
				<form name='miform'>
                <input type='radio' name='cual' value='1' <? if (isset($cual) && $cual == '1') echo "checked";?>><? echo $Mensajes['li-1']; ?>
				<input type='radio' name='cual' value='2' <? if (isset($cual) && $cual == '2') echo "checked";?>><? echo $Mensajes['li-2']; ?>
				<input type='radio' name='cual' value='3' <? if (isset($cual) && $cual == '3') echo "checked";?>><? echo $Mensajes['li-3']; ?>
				<br>
				<input type='hidden' name='buscando' value='1'> 
				<input type='hidden' name='idUsuario' value='<? echo $idUsuario; ?>'>
				<input type='hidden' name='usuario' value='<? echo $usuario; ?>'> 
				<input type='submit' value='Enviar' class='style11'>
				</form> </td> </tr>
              </table>
             <table width="97%" border="0" style="margin-bottom: 0; border-collapse:collapse" bordercolor="#111111" cellpadding="0"   
 <?
   if (!isset($buscando))
      $buscando=0;

    if ($buscando == 1) {

	$query = 'SELECT * from Mensajes_Usuarios WHERE idUsuario='.$idUsuario;
	
    if ($cual==1) {
       $query .= ' and leido=1';
	   echo "<tr height=18> <td bgcolor='#3161AF' valign='middle' align='center'> <font face='MS Sans Serif' size='1' color='#FFFFCC'> <b> (".$Mensajes['txt-1'].") </b> </font> </td> </tr>";
	     }
	else
		if ($cual ==2) {
		 $query .= ' and leido =0';
		 echo "<tr height=18> <td bgcolor='#3161AF' valign='middle' align='center'> <font face='MS Sans Serif' size='1' color='#FFFFCC'> <b> (".$Mensajes['txt-2'].") </b> </font> </td> </tr>";
	    }
		else
		{ 
			echo "<tr height=18> <td bgcolor='#3161AF' valign='middle' align='center'> <font face='MS Sans Serif' size='1' color='#FFFFCC'> <b> (".$Mensajes['txt-3'].") </b> </font> </td> </tr>";
		}
    
   $query .= ' ORDER BY leido DESC';
	$resu = mysql_query($query);
	echo mysql_error();
    echo "<tr> <td class='style17' align=left> <blockquote>";

	while ($row = mysql_fetch_row($resu))
	{
	
    echo "
	           <tr>  <td bgcolor='#B7CFE1' valign='middle' align='center'> <br> 
				        <table bgcolor='#B7CFE1' align='center' width='90%' cellspacing=0 border=1 bordercolor='#3161AF' borderdarkcolor='#0200AB'> 
				          <tr height=20>  <td bgcolor='#B7CFE1' valign='middle' align='center' width='20%'>  <font face='MS Sans Serif' size='1' color='#333399'>".$Mensajes['et-003']." </font> </td> 
							   <td width='80%' bgcolor='#79A7C8' valign='middle' align='center'> <font face='MS Sans Serif' size='1' color='#000000'><b>".$row[0]."</b> </td>
						   </tr>";
	echo "               <tr height=20>  <td bgcolor='#B7CFE1' valign='middle' align='center' width='20%'>  <font face='MS Sans Serif' 									size='1' color='#333399'>".$Mensajes['et-004']." </font> </td> 
	                                   <td width='80%' bgcolor='#79A7C8' valign='middle' align='center'> <font face='MS Sans Serif' size='1' color='#000000'><b>".$row[2]."</b> </td> 
						</tr>";
	echo "				<tr height=20> 
						<td bgcolor='#B7CFE1' valign='middle' align='center' width='20%'>  <font face='MS Sans Serif' size='1' color='#333399'>".$Mensajes['et-005']." </font> </td> <td width='80%' bgcolor='#79A7C8' valign='middle' align='center'> <font face='MS Sans Serif' size='1' color='#000000'><b>".$row[4]."</b>
						</td> </tr>";
	if ($row[5]==1) //si ya fue leido
		{	echo " <tr height=20>  <td bgcolor='#B7CFE1' valign='middle' align='center' width='20%'>  <font face='MS Sans Serif' size='1' color='#333399'>".$Mensajes['et-007']."</font> </td> <td width='80%' bgcolor='#79A7C8' valign='middle' align='center'>   <font face='MS Sans Serif' size='1' color='#333399'>".$row[3]." </font> </td> </tr>";
	     }
		 else
		{ echo " <tr height=20> <td bgcolor='#B7CFE1' valign='middle' align='center' width='20%'>  <font face='MS Sans Serif' size='1' color='#333399'>".$Mensajes['et-006']." </font> </td>  <td width='70%' bgcolor='#79A7C8' valign='middle' align='center' colspan=2>   <font face='MS Sans Serif' size='1' color='#333399'></font> </td> </tr>";
	     }
  echo "</table>";
       } //fin del while
  echo "</td> </tr>  ";
	}  // fin del if buscando
        
?>  
<br>
</table> </center>      </span>    </td> 
    </div>
          </td>
          <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
            <table width="100%" bgcolor="#ececec">
            <tr> <td class="style28"><span class="style55"><img src="../images/image001.jpg" width="150" height="118"></span><br> <a href="../admin/indexadm.php"><span class="style33"> <? echo $Mensajes['h-001']; ?> </span></a></td>
            </tr>
			
          </table>
          </div>
          </td>

        </tr>
    </table>    </center>    </td>
    

  </tr>
 <tr> <td> <br> </td> </tr>
 
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