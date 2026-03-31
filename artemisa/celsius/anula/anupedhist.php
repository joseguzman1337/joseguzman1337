<? 
  
  include_once "../inc/"."var.inc.php";
 include_once "../inc/"."conexion.inc.php";  
 Conexion();

 include_once "../inc/"."identif.php";
 Administracion();
 if (! isset($Codigo))		$Codigo="";
 	
?>  
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>PrEBi </title>
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
.style58 {font-size: 9px}
.style60 {font-family: Arial}
.style22 {	color: #333333;
	font-family: verdana;
	font-size: 9px;
}
.style35 {color: #FFFFFF}
.style36 {color: #006699}
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<? 
  include_once "../inc/fgenped.php";
  include_once "../inc/fgentrad.php";
//  include_once Obtener_Direccion()."tabla_ped.inc";
    include_once "../inc/tabla_ped_unnoba.inc";
	
  global $IdiomaSitio;
   $Mensajes = Comienzo ("adm-002",$IdiomaSitio);
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  
   
?>

<script language="JavaScript">
 function Seteo_Modo()
 {
    document.forms.form2.action="anupedhist.php";   
    document.forms.form2.submit();
 }
 
 function vent_anula(Id,Estado,Mail,Nombre)
{
   ventana=window.open("genanu.php?Id_Pedido="+Id+"&dedonde=5&Estado="+Estado+"&Nombre="+Nombre, "Eventos", "dependent=yes,toolbar=no,width=530 height=380");
   
 }

  function rutear_PedHist (TipoPed,Id)
 {

     switch (TipoPed)
	  {
	    case 1:
	      ventana=open("../pedidos/verped_col.php?Id="+Id+"&dedonde=1&Tabla=2","Colecciones","scrollbars=yes,width=700,height=450,alwaysLowered");   
	      break;
	    case 2:
	      ventana=open("../pedidos/verped_cap.php?Id="+Id+"&dedonde=1&Tabla=2","Capitulos","scrollbars=yes,width=700,height=450,alwaysLowered");
	      break;
	    case 3:           
          ventana=open("../pedidos/verped_pat.php?Id="+Id+"&dedonde=1&Tabla=2","Patentes","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
       case 4:           
          ventana=open("../pedidos/verped_tes.php?Id="+Id+"&dedonde=1&Tabla=2","Tesis","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
       case 3:           
          ventana=open("../pedidos/verped_con.php?Id="+Id+"&dedonde=1&Tabla=2","Actas Congresos","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
                
	  }
	    
	 return null	
	
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
                      <hr>                      <div align="left">
                        <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#0099CC">
                          <tr>
                            <td height="20" class="style22"><img src="../images/square-w.gif" width="8" height="8"> <? echo $Mensajes["tc-2"]; ?><span class="style35"></span></td>
                          </tr>
                        </table>
                      </div>
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
   
  
   $expresion = armar_expresion_busqueda_hist();
   $expresion = $expresion."WHERE PedHist.Id='".$Codigo."'";
   //echo $expresion;
   $result = mysql_query($expresion);
   echo mysql_error();
  
    while($row = mysql_fetch_row($result))
     {
	  
	  Dibujar_Tabla_Comp_Hist_Ped ($VectorIdioma,$row,$Mensajes,false,1); 
  ?>    
<center><table>
<tr>
 <td><form name="form3" method="POST"> 
  <input type="button" value="<? echo $Mensajes["bot-6"]; ?>" name="B1" OnClick="vent_anula('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'<? echo $row[46]; ?>','<? echo $row[2].",".$row[3]; ?>')" class="style22">
  </p>
  <input type="hidden" name="Modo">
 </form>
</td>
</tr>
</table></center>
    <?
       }
    ?>
<?
   mysql_free_result($result);
   
   }   
   Desconectar();

   // de la comparacion por Codigo
?>


             <!--         <table width="95%" align="center" cellpadding="0" cellspacing="1" bgcolor="#ECECEC">
                        <tr>
                          <td width="162"></td>
                        </tr>
                        <tr class="style22">
                          <td height="18" align="right" valign="middle" class="style33"><div align="right"><strong>Tipo de Pedido:&nbsp; </strong></div></td>
                          <td width="367" height="18" colspan="3" align="left" valign="middle"><div align="left">Busqueda- <strong class="style33">Articulos de Revistas </strong></div></td>
                        </tr>
                        <tr class="style22">
                          <td height="18" align="right" valign="top" class="style33"><div align="right"><strong>Datos del Pedido:&nbsp; </strong></div></td>
                          <td width="367" height="18" colspan="3" align="left" valign="top"><div align="left">Titulo Revista: <a href="http://unnoba.prebi.unlp.edu.ar/pedidos/conshallados.php?Id_Col=4120&Vol=11&Numero=11&Anio=2001&Id=ARG-UNLP-0014193">A HORA VETERINARIA </a> / Vol-A&ntilde;o-Numero: 11-2001-11 / Paginas: 11- </div></td>
                        </tr>
                        <tr class="style22">
                          <td height="18" align="right" valign="middle" class="style33"><div align="right"><strong>Fecha de solicitud:&nbsp; </strong></div></td>
                          <td height="18" align="left" valign="middle"><div align="left">2004-08-23 </div></td>
                          <td align="left" valign="middle"><div align="left" class="style33">
                              <div align="right"><strong>Id Pedido:</strong></div>
                          </div></td>
                          <td height="18" align="left" valign="middle"><div align="left">ARG-UNLP-0014193</div></td>
                        </tr>
                        <tr class="style22">
                          <td height="18" align="right" valign="middle" class="style33"><div align="right"><strong>Recibido de:&nbsp; </strong></div></td>
                          <td height="18" colspan="3" align="left" valign="middle"><div align="left">ESPA&Ntilde;A-UNIVERSITARIA DE MALAGA-OTRA en:<span class="style36">0</span> dias.</div>
                              <div align="left"></div>
                              <div align="left"><strong></strong></div></td>
                        </tr>
                        <tr class="style22">
                          <td height="18" align="right" valign="middle" class="style33">&nbsp;</td>
                          <td height="18" colspan="3" align="left" valign="middle"><input name="Submit32" type="submit" class="style22" value="Anular evento de entrega">
                          </td>
                        </tr>
                        <tr>
                          <td valign="top" width="162"></td>
                        </tr>
                      </table>-->
                      </td>
                  </tr>
                </table>                  </td>
              </tr>
            </table>
              </center>
            </div>
            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td class="style28"><div align="center"><img src="../images/image001.jpg" width="150" height="118"><br>
                  <span class="style33"><a href="../admin/indexadm.php"><? echo $Mensajes["h-1"]; ?></a></span> </div>                <div align="center" class="style55"></div></td>
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