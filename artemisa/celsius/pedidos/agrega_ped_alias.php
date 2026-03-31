<? 
 
include_once "../inc/var.inc.php";
include_once "../inc/"."conexion.inc.php";  
 Conexion();

 include_once "../inc/"."identif.php";
 Bibliotecario();
 	//echo $Alias_Id;
?>  
<script language="JavaScript">
function ruteaPedido()
{
		
	Selector = document.forms.form1.Material.value;
	switch (Selector)
	{
		case "1":
			document.forms.form1.action = "agrega_col.php?CantAutor=1";
			break;
		case "2":
     		document.forms.form1.action = "agrega_cap.php?CantAutor=1";
     		break;
		case "3":
 			document.forms.form1.action = "agrega_pat.php";
 			break;
		case "4":
			document.forms.form1.action = "agrega_tes.php";
			break;
		case "5":
			document.forms.form1.action = "agrega_cong.php";
			break;
	}
	document.forms.form1.submit();

}
</script>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><? echo Titulo_Sitio(); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../celsius.css" rel="stylesheet" type="text/css">
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
	font-size: 11px;
}
.style33 {
	font-family: verdana;
	font-size: 11px;
	color: #006699;
}
.style34 {
	color: #FFFFFF;
	font-weight: normal;
	font-family: Verdana;
	font-size: 11px;
}

.style35 {color: #CCCCCC}
.style36 {color: #666666}
.style37 {font-size: 11px; font-family: verdana;}
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<? 
  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."fgentrad.php";
  global $Rol;
  global $IdiomaSitio;
  $Mensajes = Comienzo ("amp-001",$IdiomaSitio);
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  
   
?>

<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse"> <!--  Primer Table-->
  <tr>
    <td bgcolor="#E4E4E4">
       <hr color="#E4E4E4" size="1">
       <div align="center">
       <center>
       <form name="form1" method="POST">
	      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5"> <!-- Segunda Table-->
            <tr>
              <td valign="top"><div align="center">
                 <center>  <!-- Tercer Table-->
                 <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ECECEC">
                    <tr bgcolor="#006699">
                       <td height="20" class="style33"><span class="style34"><img src="../../PrEBi/UNNOBA/images/square-w.gif" width="8" height="8"> <? echo $Mensajes["tf-3"]; ?></span>
					   </td>
                       <td height="20" class="style34"><div align="right" class="style34 style35"><? echo $Mensajes["tf-1"]; ?><? echo $Usuario; ?>;</div>
					   </td>
                    </tr>
                    <tr align="left" valign="middle">
                       <td height="20" colspan="2" class="style22"><div align="center" class="style33"><? echo $Mensajes["tf-4"]; ?><? echo $Alias_Comunidad; ?></div>
					   </td>
                    </tr>
                    <tr valign="middle">
                       <td height="20" colspan="2" align="right" class="style22"><div align="center">
                         <select size="1" name="Material" class="style22">
                            <option selected value="1"><? echo Devolver_Tipo_Material($VectorIdioma,1); ?></option>
                            <option value="2"><? echo Devolver_Tipo_Material($VectorIdioma,2); ?></option>
                            <option value="3"><? echo Devolver_Tipo_Material($VectorIdioma,3); ?></option>
                            <option value="4"><? echo Devolver_Tipo_Material($VectorIdioma,4); ?></option>
                            <option value="5"><? echo Devolver_Tipo_Material($VectorIdioma,5); ?></option>
                          </select>
                          </div>
					    </td>
                    </tr>
                    <? if ($Bibliotecario==0)
		             { ?>
				    <tr valign="middle">
                       <td height="20" colspan="2" class="style22"><div align="center" class="style36">
                          <input type="checkbox" name="Bandeja" class="style37"><? echo $Mensajes["tf-5"]; ?>
			  		      </div>
					   </td>
                    </tr>
					 <? } ?>
                    <tr valign="middle">
                        <td height="20" colspan="2"><div align="center">
                          <input type="hidden" name="Alias_Id" value=<? echo $Alias_Id; ?>>
                          <input type="hidden" name="Alias_Comunidad" value="<? echo $Alias_Comunidad; ?>">
                          <input type="hidden" name="Instit_Alias" value=<? echo $Instit_Alias; ?>>
                          <input type="hidden" name="CantAutor" value=1>
                          <input type="submit" value="<? echo $Mensajes["bot-1"]; ?>" class="style22" name="B1" OnClick="ruteaPedido()">
					      </div>
						</td>
                     </tr>
                    </table><!-- Cierre de la tercera table-->
                 </center>
               </div>
			  </td>
			   </form>
              <? if ($Rol!=1)
		      {
		?>
		<td width="150" valign="top" bgcolor="#E4E4E4" class="style11"><div align="center" class="style11">
        <? dibujar_menu_usuarios($Usuario,1); ?>
          </div></td>
		  <?
		   }
		  else
		  {
		  ?>
            <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
                <p><img src="../images/image001.jpg" width="150" height="118"><br>
                    <? if ($Bibliotecario>=1) { $destino="../comunidad/indexcom2.php"; } else { $destino="../admin/indexadm.php"; } ?><a href="<? echo $destino; ?>">                    <? echo $Mensajes["h-1"]; ?></a></span></p>
                  </div>                  </td>
          </div></td>
		  <?
		  }	  
		  ?>
       <!--           </tr>
                  </table>
                  </div></td>
		 -->
	<!--	 </tr>
      </table>  <!-- Cierre de la segundo Table-->
  <!--  </div>
        </div></td>-->
        </tr>
    </table>    </center>
      </div>    </td>
  </tr>
 
  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">      
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0"><!-- Cuarta Table-->
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" height="43" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50"><div align="right" class="style33">
            <div align="center">amp-001</div>
          </div></td>
        </tr>
      </table> <!-- Cierre de Cuarta Tabla-->
     </div></td>
  </tr>
</table>
</div>
</body>
</html>
<?
 
	Desconectar();

?>