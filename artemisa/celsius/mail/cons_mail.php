<?
  
   include_once "../inc/var.inc.php";
   include_once "../inc/"."conexion.inc.php";  
   Conexion();	
   include_once "../inc/"."identif.php"; 
   Usuario();
   if ( ! isset($dedonde))	$dedonde =0;
   
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>PrEBi </title>
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
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 11px; }
.style28 {color: #FFFFFF}
.style30 {color: #FFFFFF; font-size: 11px; font-family: verdana; }
.style31 {
	color: #000000;
	font-family: Verdana;
	font-size: 11px;
}
.style35 {
	color: #00FFFF;
	font-family: Verdana;
	font-size: 11px;
}
.style23 {
	color: #000000;
	font-size: 11px;
	font-family: verdana;
}
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<?

  	include_once "../inc/"."fgenped.php";
	include_once "../inc/"."fgentrad.php";
  
   global $IdiomaSitio;
   $Mensajes = Comienzo ("cma-001",$IdiomaSitio);
   $Campos = ObtenerVectorCampos ($IdiomaSitio,2);
   $CamposFijos = ObtenerVectorCampos ($IdiomaSitio,0);
   global $Rol;
   $expresion = "SELECT Apellido,Nombres,EMail,Codigo_Pais,Codigo_Institucion,Codigo_Dependencia";
   $expresion.= ",Direccion,Codigo_Categoria,Telefonos,Codigo_Unidad,Codigo_Localidad,Login,Password,Comentarios,";
   $expresion.= "Codigo_FormaPago,Personal,Bibliotecario,Staff,Orden_Staff,Cargo ";
   $expresion.= "FROM Usuarios WHERE Usuarios.Id =".$Id_usuario;
   $result = mysql_query($expresion);

   $rowg = mysql_fetch_row($result);

  
   $expresion = "SELECT COUNT(*) FROM mail ";
   $expresion = $expresion."WHERE Codigo_Usuario=".$Id_Usuario." ORDER BY Fecha,Hora DESC";
   $result = mysql_query($expresion);

   $row = mysql_fetch_row($result);
   $numfilas = $row[0];
   
  
   $expresion = "SELECT Id,Codigo_Usuario,Codigo_Pedido,Fecha,Hora,Direccion,Asunto,Texto FROM mail ";
   $expresion = $expresion."WHERE Codigo_Usuario=".$Id_Usuario." ORDER BY Fecha,Hora DESC";
   $result = mysql_query($expresion);
?>

<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4" >
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td valign="top" bgcolor="#E4E4E4">
            <div align="center">
              <center>
            <table width="97%" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td bgcolor="#E4E4E4"><table width="100%"  border="0">
                  <tr align="center">
                    <td width="287" height="20" bgcolor="#006599" class="style30"><?echo $Mensajes["tf-3"];?> <span class="style35">
								<?		if (isset($fila))
										$numerito=(int)($fila/10)+1;
										else
										$numerito = 0;
										echo $numfilas; ?></span> <?echo $Mensajes["tf-4"];?>
                      <div align="left" class="style28"><div align="center"></div>
                    </div></td>
                    <td width="287" bgcolor="#006599" class="style30"><?echo $Mensajes["tf-5"];?> <span class="style35"><? echo $numfilas ?></span> </td>
                  </tr>
                  <tr>
                    <td colspan="2" class="style30"><div align="center" class="style31"><br>
                    <table><tr><td>
                    <?
						
                    	if (isset($fila) &&($fila>=10))
                        	{
                        	 $filita=$fila-10;
                        	 echo "<a href=".$PHP_SELF."?fila=".$filita."&Id_Usuario=$Id_Usuario&Nom_Usu=$Nom_Usu&dedonde=$dedonde>".$Mensajes["tf-6"]."-</a>";
                        	}

                        	$cociente = ($numfilas / 10);
                        	if ($numfilas%10>0)
                        	{
                        	  $cociente+=1;
                        	}

                        	$filita=0;
                        	for ($i=1;$i<=$cociente;$i++)
                        	{
                        		echo "<a href=".$PHP_SELF."?fila=".$filita."&Id_Usuario=$Id_Usuario&Nom_Usu=$Nom_Usu&dedonde=$dedonde>$i</a>-";
                        		$filita+=10;
                        	}

                        	if (isset($fila )&& ($fila+10<=$numfilas))
                        	{
                        	 $filita=$fila+10;
                        	 echo "<a href=".$PHP_SELF."?fila=".$filita."&Id_Usuario=$Id_Usuario&Nom_Usu=$Nom_Usu&dedonde=$dedonde>".$Mensajes["tf-7"]."</a>";
                        	}
                     ?>
                         </td>
                        </tr>
                    </table>
                    
                    <?
                    
                    
                    
					while($row = mysql_fetch_row($result))
					{
					?>
					  <table width="97%"  border="0" cellpadding="1" cellspacing="0" bgcolor="#ECECEC">
                        <tr class="style31">
                          <td width="100" align="right" bgcolor="#CCCCCC"><?echo $Mensajes["ec-1"];?></td>
                          <td width="453" align="left" bgcolor="#ECECEC"><? echo $row[5];?></td>
                          </tr>
                        <tr class="style31">
                          <td width="100" align="right" bgcolor="#CCCCCC"><?echo $Mensajes["ec-2"];?></td>
                          <td width="453" align="left" bgcolor="#ECECEC"><? echo $row[6];?></td>
                          </tr>
                        <tr class="style31">
                          <td width="100" align="right" bgcolor="#CCCCCC"><?echo $Mensajes["ec-3"];?></td>
                          <td width="453" align="left" bgcolor="#ECECEC"><? echo $row[3];?></td>
                          </tr>
                        <tr class="style31">
                          <td width="100" align="right" bgcolor="#CCCCCC"><?echo $Mensajes["ec-4"];?></td>
                          <td width="453" align="left" bgcolor="#ECECEC"><? echo $row[4];?></td>
                          </tr>
                        <tr align="center" bgcolor="#CCCCCC">
                          <td colspan="2"><textarea name="textarea" cols="90" rows="6" class="style31" ><? echo $row[7];?></textarea>
                          </td>
                          </tr>
                      </table>
                      
					  <hr>
				<?	}?>


                      </div></td>
                  </tr>
                </table>                  
                </td>
              </tr>
            </table>
              </center>
            </div>            </td>
		<? if ($Rol!=1)
		   {
		?>
		<td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
        <? dibujar_menu_usuarios($Usuario,1); ?>
          </div></td>
		  <?
		   }
		  else
		  {
		  ?>
            <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
                <p><img src="../images/image001.jpg" width="150" height="118"><br>
                    <a href="../admin/indexadm.php"><?echo $Mensajes["h-3"];?></a></span></p>
                  </div>                  </td>
          </div></td>
		  <?
		  }	  
		  ?>
	</tr>
	</table>
	</div></td></tr>
	
	<tr>
       <td height="44" bgcolor="#E4E4E4"><div align="center">
       <hr>
       <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100"  border="0" lowsrc="../PrEBi%20:%20UNLP"></a></div></td>
          <td width="50"><div align="center" class="style11">cma-001</div></td>
        </tr>
		</table>
		</div></td>
	  </tr>

</table>
</div>
</body>
</html>
