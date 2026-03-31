<?  //pagina para actualizacion de los datos personales de los usuarios
 include_once "../inc/var.inc.php";
 include_once "../inc/"."conexion.inc.php";
 Conexion();
 include_once "../inc/"."cache.inc";
 include_once "../inc/"."identif.php";
 Usuario();
 include_once "../inc/"."fgenped.php";
 include_once "../inc/"."fgentrad.php";
 global $IdiomaSitio;
 $Mensajes = Comienzo ("ads-001",$IdiomaSitio);
 $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
?>
<html>
<head>
<style>
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
.style23 {
	color: #000000;
	font-size: 9px;
	font-family: verdana;
}
.style28 {color: #FFFFFF}
.style29 {color: #006599}
.style30 {color: #FFFFFF; font-size: 9px; font-family: verdana; }
.style31 {color: #000000}
.style32 {
	font-family: Verdana;
	font-size: 10;
	color: #000000;
}
.style33 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
.style40 {color: #006599; font-size: 9px; font-family: verdana; }
.style34 {color: #006699; font-family: Verdana; font-size: 9px; }
.style36 {
	font-size: 10;
	color: #000000;
}
-->
</style>
<base target="_self">
</head>

<script>

function versolicitud(codigo)
{

 document.forms.form1.action = "../solicitudes/aprueba_sol.php";
 document.forms.form1.Id.value = codigo;
 document.forms.form1.submit(); 
}
</script>
<body topmargin="0">
<div align="left">
  <form name="form1" method="post">
  <input type="hidden" name="Id">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  
  <tr>
		<td bgcolor="#E4E4E4">
		  <!--<hr color="#E4E4E4" size="1">-->
		  <div align="center">
		  <center>
		   <br>
		  <table width="600" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5" >
		  <tr>
		  <td>
			<table  width="600" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
			<tr valign="top">
			<td><span class="style40"><? echo $Mensajes["et-1"];?></span></td>
			  </tr>
			 <tr bgcolor="#EFEFEF">
			  <td valign="top" bgcolor="#E4E4E4" width="750">
				 <div align="center">
				  <center>
					<?
					   $instruccion="select * from Candidatos where rechazados=2 order by Fecha_Registro desc ";
					   $result=mysql_query($instruccion);
									
					?>
					<table width="100%"  border="0" cellspacing="0" cellpadding="0">
					  <tr bgcolor="#006599" class="style30">
						
						<td height="20" valign="top" align="center"><span class="style28"><? echo $Mensajes["tf-1"];?></span></td>
						<td height="14" valign="top" align="center"><span class="style28">Fecha Inscripcion</span></td>
						<td height="20" valign="top" align="center"><span class="style28"><? echo $Mensajes["ec-7"];?></span></td>
						
					  </tr>
					  <? while ($row=mysql_fetch_array($result))
						  {
					  ?>
						  <tr>
							
							<td width="200" valign="top" class="style34"><? echo $row["Apellido"].", ".$row["Nombres"]; ?></td>
							<td width="200" valign="top" class="style34"><? echo $row["Fecha_Registro"];?></td>
							<td valign="top" align="center" class="style23"><input name="boton" type="button" onclick="versolicitud(<? echo $row["Id"];?>);" class="style23" value="<? echo $Mensajes["bot-1"];?>"></td>
						  </tr> 
							<?
						  }
					  ?>
		   
						
		
					</table>
				  </center>
				</div>            </td>
			 
				</tr>
			  </table>
			  <p>&nbsp; </p>
			  </div>
			  </td>
	</td>
	<td width="150"  bgcolor="#E4E4E4" valign=top><div align="center" class="style11">
			 <table width="100%" bgcolor="#ececec">
				<tr>
				  <td class="style28"><span class="style55"><img src="../images/image001.jpg" width="150" height="118"></span></td>
				</tr>
				<tr><td align="center"><a href="../admin/indexadm.php"><span class="style40"><? echo $Mensajes["h-1"];?></span></a></td></tr>
			   <tr><td>&nbsp;</td></tr>
			  </table>
			  </td>
	</tr>
	</table>        
		</tr>
		
  
<tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">
      <hr>
       
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100"  border="0" lowsrc="../PrEBi%20:%20UNLP"></a></div></td>
          <td width="50"><div align="right" class="style33">ads-001</div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>

</div>
</body>
</html>
