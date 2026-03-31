<?
 include_once "../inc/var.inc.php";
 include_once "../inc/conexion.inc.php";
 Conexion();
  include_once "../inc/"."identif.php";
  include_once "../inc/"."fgenped.php";
  Administracion();
  include_once "../inc/fgentrad.php";
  global $IdiomaSitio;
  $Mensajes = Comienzo ("ads-001",$IdiomaSitio);
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  
?>
<html>
<head>
<title>PrEBi </title>
<script language="JavaScript">
function rutea_apr(codigo)
{ 
  document.forms.form1.action = "aprueba_sol.php";
  document.forms.form1.Id.value = codigo;
  document.forms.form1.submit(); 
}
</script>   
<style type="text/css">
<!--
body {
	margin:0px;
	background-color: #006599;
	margin-left: 10px;
	background-image: url();
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

.style22 {
	color: #333333;
	font-family: verdana;
	font-size: 9px;
}
.style33 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
.style34 {
	color: #FFFFFF;
	font-weight: normal;
	font-family: Verdana;
	font-size: 9px;
}

.style42 {color: #FFFFFF; font-family: verdana; font-size: 9px; }
.style43 {
	font-family: verdana;
	font-size: 10px;
}
.style40 {color: #006599; font-size: 9px; font-family: verdana; }
-->
</style>
 <base target="_self"> 
</head>



<body topmargin="0">
<?   
   $expresion = "SELECT Apellido,Nombres,Instituciones.Nombre,Dependencias.Nombre,";
   $expresion = $expresion."Unidades.Nombre,Tab_Categ_usuarios.Nombre,";
   $expresion = $expresion."Otra_Institucion,Otra_Dependencia,Otra_Unidad,Otra_Categoria,Candidatos.Telefonos,";
   $expresion = $expresion."Fecha_Registro,Candidatos.Id FROM Candidatos ";
   $expresion = $expresion."LEFT JOIN Instituciones ON  Candidatos.Codigo_Institucion = Instituciones.Codigo ";
   $expresion = $expresion."LEFT JOIN Dependencias ON Candidatos.Codigo_Dependencia = Dependencias.Id ";
   $expresion = $expresion."LEFT JOIN Unidades ON Candidatos.Codigo_Unidad = Unidades.Id ";
   $expresion = $expresion."LEFT JOIN Tab_Categ_usuarios ON Candidatos.Codigo_Categoria = Tab_Categ_usuarios.Id";
   
   $result = mysql_query($expresion);
   $numero = mysql_num_rows($result);
?>
<div align="left">
  <form name="form1" method="post">
  <input type="hidden" name="Id">
  </form>
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
			
			 <tr bgcolor="#EFEFEF">
			  <td valign="top" bgcolor="#E4E4E4" width="750">
				 <div align="center">
				  <center>
					
					<table width="100%"  border="0" cellspacing="0" cellpadding="0">
					  <tr  class="style30">

						<td height="20" valign="top" align="center" bgcolor="#006699" class="style34" ><img src="../images/square-w.gif" width="8" height="8"><span class="style28">&nbsp; <? echo $Mensajes["et-1"]." : ".$numero; ?></span></td>
						
					  </tr>
					  <tr><td  valign="top" class="style34" colspan=2>&nbsp;</td></tr>

					  <tr>
							
							<td  valign="top" class="style34" colspan=2>
					  <? while ($row=mysql_fetch_array($result))
						  {?>

						<div align=center>
						  <table bgcolor="#ECECEC" width="80%">
							   <tr>
								<td width="30%" valign="middle"  class="style22"><div align="right"><? echo $Mensajes["ec-1"]; ?></div></td>
								<td  valign="top" align=left class="style22" > <? echo $row[0]; ?>
								</td>
							  </tr>
							  <tr>
								<td width="30%" valign="middle"  class="style22"><div align="right"><? echo $Mensajes["ec-2"]; ?></div></td>
								<td  valign="top" align=left class="style22" > <? $row[1]; ?>
								</td>
							  </tr>
							   <tr>
								<td width="30%" valign="middle"  class="style22"><div align="right"><? echo $Mensajes["ec-3"]; ?></div></td>
								<td  valign="top" align=left class="style22" > 
									<? 
									   $renglon = "";
									   if (strlen($row[2])==0){
											 $renglon = $Mensajes["ofe-1"]."-".$row[6];
									   }      
									   else
									   {
										   $renglon = $row[2];
									   }
									   
									   if (strlen($row[3])==0){
											 $renglon = $renglon." / ".$Mensajes["ofe-1"]."-".$row[7];
									   }      
									   else
									   {
										   $renglon = $renglon." / ".$row[3];
									   }
									   
									   if (strlen($row[4])==0){
											 $renglon = $renglon." / ".$Mensajes["ofe-1"]."-".$row[8];
									   }      
									   else
									   {
										   $renglon = $renglon." / ".$row[4];
									   }
									   echo $renglon;
									  ?>
								</td>
							  </tr>
							   <tr>
								<td width="30%" valign="middle"  class="style22"><div align="right"><? echo $Mensajes["ec-4"]; ?></div></td>
								<td  valign="top" align=left class="style22" >
									<? 
								   $renglon = "";
								   if (strlen($row[5])==0){
										 $renglon = $Mensajes["ofe-1"]."-".$row[9];
								   }      
								   else
								   {
									   $renglon = $row[5];
								   }
								   echo $renglon;	?>
								</td>
							  </tr>
							   <tr>
								<td width="30%" valign="middle"  class="style22"><div align="right"><? echo $Mensajes["ec-5"]; ?></div></td>
								<td  valign="top" align=left class="style22" > <? echo $row[10]; ?>
								</td>
							  </tr>

							   <tr>
								<td width="30%" valign="middle"  class="style22"><div align="right"><? echo $Mensajes["ec-6"]; ?></div></td>
								<td  valign="top" align=left class="style22" > <? echo $row[11]; ?>
								</td>
							  </tr>
							   <tr>
								<td width="30%" valign="middle"  class="style22"><div align="right">&nbsp;</div></td>
								<td  valign="top" align=left class="style43" > <input type="button" value="<? echo $Mensajes["bot-1"]; ?>" name="B3"  OnClick="rutea_apr(<? echo $row[12]; ?>)" class="style43">
								</td>
							  </tr>

							 
						  </table>
						  </div>
						  <br>
							<?
						  }
						
					  ?>
					  </td></tr>
		   
						
		
					</table>
				  </center>
				</div>            </td>
			 
				</tr>
			  </table>
			  <p>&nbsp; </p>
			  </div>
			  </td>
	</td>
	<td width="150"  bgcolor="#E4E4E4" valign=top><div align="center" class="style11" valign=top>
			 <table width="100%" bgcolor="#ececec" valign=top>
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
<?
   mysql_free_result($result);
   Desconectar();
?>
</body>
</html>