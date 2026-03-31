<?
  
   include_once "../inc/"."var.inc.php";
   include_once "../inc/"."conexion.inc.php";
   include_once "../inc/"."parametros.inc.php";
  
   Conexion();	
   include_once "../inc/"."identif.php";
   Administracion();
   if (! isset($Codigo))	$Codigo="";
   
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
	background-color: #006599;
	margin-left: 10px;
	margin-right:0px; margin-top:0px; margin-bottom:0px
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
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 9px; }
.style28 {color: #FFFFFF; font-size: 11px; }
.style43 {
	font-family: verdana;
	font-size: 10px;
}
.style45 {
	font-family: Verdana;
	color: #FFFFFF;
	font-size: 9px;
}
.style49 {font-family: verdana; font-size: 10px; color: #006599; }
.style55 {
	font-size: 10px;
	color: #000000;
	font-family: Verdana;
}
.style33 {	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
a.style33 {	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
.style58 {font-size: 9px}
.style60 {font-family: Arial}
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<? 
  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."fgentrad.php";
  global $IdiomaSitio;
   $Mensajes = Comienzo ("adm-002",$IdiomaSitio);
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  
   
?>

<script language="JavaScript">
 function ver_evento(Id)
 {
  ventana=window.open("../pedidos/ver_evento.php?Tabla=1&Id="+Id,"Evento", "dependent=yes,toolbar=no,width=530 height=350");
 }
 function anula_evento(Id,Id_Pedido,Estado,Mail,Nombre)
 {
  ventana=window.open("genanu.php?Id_Evento="+Id+"&Id_Pedido="+Id_Pedido+"&dedonde=3","Evento", "dependent=yes,toolbar=no,width=550, height=300");
 } 
 function Seteo_Modo()
 {
    document.forms.form2.action="anulaeve.php";   
    document.forms.form2.submit();
 }
 


</script>


<div align="left">
 <form name="form2">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">      <div align="center"><center>
        <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td bgcolor="#E4E4E4">
            <div align="center">
              <center>
            <table width="576" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td valign="top" bgcolor="#E4E4E4"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="style43">
                  <tr>
                    <td colspan="3" align="left" class="style45">
                      <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td valign="top"><div align="center">
                            <table width="95%"  border="0" cellpadding="1" cellspacing="1">
                              <tr>
                                <td width="200" class="style49"><div align="right"><? echo $Mensajes["tf-1"]; ?></div></td>
                                <td class="style43"><div align="left"><? echo $Usuario; ?></div></td>
                              </tr>
                              <tr>
                                <td width="200" class="style49"><div align="right"><? echo $Mensajes["tc-1"]; ?></div></td>
                                <td class="style43"><div align="left">
                                  <input type="text" name="Codigo" size="20" value="<? if ($Codigo=="") { echo Devolver_Abreviatura_Pais_Predeterminada()."-".Devolver_Abreviatura_Institucion_Predeterminada()."-"; } else { echo $Codigo; } ?>" class="style43">
                             <input type="hidden" name="Modo" value=11>
                                </div></td>
                              </tr>
                              <tr>
                                <td width="200" class="style49"><div align="right"></div></td>
                                <td class="style43"><div align="left">
                                          <input type="button" value="<? echo $Mensajes["bot-1"]; ?>" name="B1" class="style43" OnClick="Seteo_Modo()">
                                </div></td>
                              </tr>
                            </table>
                            </div>                            
                            </td>
                          </tr>
                      </table>
					  </form>  
                      <hr>                      <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#006699" class="style45">
                        <tr valign="top" bgcolor="#006699" class="style43">
                          <td class="style43"> <div align="left" class="style45"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["tf-9"]; ?> </div>                            </td>
                          </tr>
                      </table>                      
                      <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                        <tr valign="top" class="style33">
                          <td colspan="2" align="center" valign="middle" class="style43"><div align="center"><span class="style57"><span class="style58"><span class="style58"></span></span></span></div></td>
                          <td class="style49"><div align="center" class="style61 style62"><? echo $Mensajes["tf-10"]; ?></div></td>
                          <td class="style49"><div align="center" class="style33"><? echo $Mensajes["tf-11"]; ?></div></td>
                          <td class="style49"><div align="center" class="style33"><? echo $Mensajes["tf-12"]; ?></div></td>
                          <td class="style49"><div align="center" class="style33"><? echo $Mensajes["tf-13"]; ?></div></td>
                        </tr>
						<?
 
  if ($Codigo!="")
  {
  
   //Posicion de numeros.
   
   		$PrimerLugar=strpos($Codigo,'-',0);
   		$SegundoLugar=strpos($Codigo,'-',$PrimerLugar+1);
   		$Numero = substr($Codigo,$SegundoLugar+1,(strlen($Codigo)-$SegundoLugar-1));
   		
   		$Counter= 7 - (strlen($Codigo)-$SegundoLugar);
   		for ($i=0;$i<=$Counter;$i++)
   		{
   			$Numero="0".$Numero;
   		}
   		$Codigo = substr($Codigo,0,$SegundoLugar+1).$Numero;
   
     $Instruccion = Armar_select_eventos(1,$Codigo,1); 
     $result = mysql_query($Instruccion);
	
	 $Contador = 1;  
     $Estado_Pedido = 1;
     echo mysql_error();
     while($row = mysql_fetch_row($result))
     {
 
  ?> 
                        <tr align="top" class="style11">
                          <td align="center" valign="middle" class="style43"><input type="button" value="+" name="+" OnClick="ver_evento(<? echo $row[7]; ?>)"></td>
                          <td align="center" valign="middle" class="style43">
						  <form method="POST" >
                           
                           <? if ($Contador==mysql_num_rows($result))
                  	       { ?>
                        	 <input type="button" value="A" name="A" OnClick="anula_evento(<? echo $row[7].",'".$Codigo."'"; ?>)">
                     	<? } ?>	 
                          </form>
						  </td>
                          <td class="style43"> <div align="center"><? echo $row[1]; ?></div></td>
                          <td class="style43"><div align="center"><? echo Devolver_Evento($row[0],$VectorIdioma); ?> </div></td>
                          <td class="style43"><div align="center"><? echo $row[5].",".$row[6]; ?></div></td>
                          <td class="style43"><div align="center"><? echo Devolver_Estado ($VectorIdioma,$Estado_Pedido,0);?></div></td>
                        </tr>
                     	  <?
    $Contador++;
	$Estado_Pedido = $row[0];
   } ?>
   			  <?
   mysql_free_result($result);
   
   }   
   Desconectar();

   // de la comparacion por Codigo
?>
					  </table>                      
				
  



                      </td>
	
				  </tr>

                </table>
											
</td>

              </tr>
            </table>

              </center>
            </div>
            </td>

        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td class="style28"><div align="center"><img src="../images/image001.jpg" width="150" height="118"><br>
                  <span class="style33"><a href="../admin/indexadm.php" class="style33"><? echo $Mensajes["h-1"]; ?></a></span> </div>                <div align="center" class="style55"></div></td>
            </tr>
          </table>
          </div>
          </td>
        </tr>
    </table>    </center>
      </div>    </td>
  </tr>
   <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">      
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50" class="style49"><div align="center" class="style11">adm-002</div></td>
        </tr>
      </table>
      </div></td>
  </tr>
</table>
</div>
</body>
</html>