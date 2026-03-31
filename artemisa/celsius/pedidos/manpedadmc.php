<? 
 include_once "../inc/var.inc.php";
 include_once "../inc/"."conexion.inc.php";
 include_once "../inc/"."parametros.inc.php";
 Conexion();
 include_once "../inc/"."identif.php";
 Administracion();
if (!isset($Modo)){$Modo=0;} 	
 
?> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><? echo Titulo_Sitio(); ?></title>
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
.style28 {color: #FFFFFF; font-size: 12px; }
.style43 {
	font-family: verdana;
	font-size: 12px;
}
.style45 {
	font-family: Verdana;
	color: #FFFFFF;
	font-size: 11px;
}
.style46 {
	color: #006599;
	font-family: verdana;
	font-size: 12px;
	font-style: normal;
	font-weight: bold;
}
.style49 {font-family: verdana; font-size: 11px; color: #006599; }
.style55 {
	font-size: 12px;
	color: #000000;
	font-family: Verdana;
}
.style33 {	font-family: verdana;
	font-size: 12px;
	color: #006699;
}
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<? 
  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."fgentrad.php";
  include_once "../inc/"."tabla_ped_unnoba.inc";
  
  Conexion(); 
  global $IdiomaSitio;
   $Mensajes = Comienzo ("adm-002",$IdiomaSitio);
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  
   
?>

<script language="JavaScript">
 function Seteo_Modo()
 {
    document.forms.form2.action="manpedadmc.php";   
    document.forms.form2.submit();
   
     
 }
  function genera_evento(Id,Estado,Mail,Nombre,Rol,IdCreador)
{
   ventana=window.open("gen_evento.php?Id="+Id+"&usuario=<? echo $Id_usuario; ?>&Modo=<? echo $Modo;?>&Estado="+Estado+"&Mail="+Mail+"&Nombre="+Nombre+"&RolCreador="+Rol+"&IdCreador="+IdCreador, "Eventos", "dependent=yes,toolbar=no,width=530,height=500,top=5,left=20");
   
 }  
 
 function busquedas(Id,Estado,Mail,Nombre,Rol,IdCreador)
{
    
   
   ventana=window.open("pres_busq.php?Id_Pedido="+Id+"&usuario=<? echo $Id_usuario; ?>&Modo=<? echo $Modo;?>&Estado="+Estado+"&Mail="+Mail+"&Nombre="+Nombre+"&RolCreador="+Rol+"&IdCreador="+IdCreador, "Eventos", "scrollbars=yes,dependent=yes,toolbar=no,width=700, height=500");
   
 }  

 
 function rutear_pedidos (TipoPed,Id,Tabla)
 {
     dedonde=1;
     if (Tabla==1)
	 {
	  dedonde=2;
	 }
     switch (TipoPed)
	  {
	    case 1:
	      ventana=open("verped_col.php?Id="+Id+"&dedonde="+dedonde+"&Tabla="+Tabla,"Colecciones","scrollbars=yes,width=700,height=450,alwaysLowered");   
	      break;
	    case 2:
	      ventana=open("verped_cap.php?Id="+Id+"&dedonde="+dedonde+"&Tabla="+Tabla,"Capitulos","scrollbars=yes,width=700,height=450,alwaysLowered");
	      break;
	    case 3:           
          ventana=open("verped_pat.php?Id="+Id+"&dedonde="+dedonde+"&Tabla="+Tabla,"Patentes","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
       case 4:           
          ventana=open("verped_tes.php?Id="+Id+"&dedonde="+dedonde+"&Tabla="+Tabla,"Tesis","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
       case 5:           
          ventana=open("verped_con.php?Id="+Id+"&dedonde="+dedonde+"&Tabla="+Tabla,"Congresos","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
                
	  }
	    
	 return null	
	
 }
  function vent_anula(Id)
{
   ventana=window.open("../anula/genanu.php?Id="+Id+"&dedonde=2", "Eventos", "dependent=yes,toolbar=no,width=530 height=380");
   
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
                                <td width="200" valign="top" class="style49"><div align="right"><? echo $Mensajes["tc-1"]; ?></div></td>
                                <td class="style43"><div align="left">
								<? $valor = '';
								if (!isset($Codigo)) 
								{ $valor= Devolver_Abreviatura_Pais_Predeterminada()."-".Devolver_Abreviatura_Institucion_Predeterminada()."-"; 
								 } 
								else { $valor =  $Codigo; } 
								?>
                                  <input type="text" class="style43" name="Codigo" size="20" value="<? echo $valor ?>"></p>
            <input type="hidden" name="Modo" value=11>
            <input type="hidden" name="caja" value=<? echo $caja;?>>
                                </div></td>
                              </tr>
                              <tr>
                                <td width="200" class="style49"><div align="right"></div></td>
                                <td class="style43"><div align="left">
                                  <input type="button" value="<? echo $Mensajes["bot-1"]; ?>" name="B1" class="style43"  OnClick="Seteo_Modo()">
                                </div></td>
                              </tr>
                            </table>
                            </div>                            
                            </td>
                          </tr>
                      </table>
					  
						<hr>
						<table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#006699" class="style45">
                        <tr valign="top" bgcolor="#006699" class="style43">
                          <td class="style43"> <div align="left" class="style45"><img src="../images/square-w.gif" width="8" height="8"><?

	 if (!isset($caja))
	    $caja = 1;
	  switch ($caja){
	   case 1:
	   		echo $Mensajes["tf-14"];
			break;
	   case 2:
	   		echo $Mensajes["tf-15"];	   
			break;
	   case 3:
	   		echo $Mensajes["tf-16"];	   
	  }

	  ?>
	  
 
</div>                            </td>
                          </tr>
                      </table>                      
						
						<?
 
  if (isset($Codigo))
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
   
  
   // Esto sirve para marcar donde lo halló si en los
   // pedidos corrientes, si en los históricos o en los 
   // anulados.
   
   $caja = 1;
   $expresion = armar_expresion_busqueda();
   $expresion = $expresion."WHERE Pedidos.Id='".$Codigo."'";
   $result = mysql_query($expresion);   
   // 
   if (mysql_num_rows($result)==0)
   {
   	 // Implica que no lo encontró dentro de los pedidos
	 // corrientes, con lo que lo busco en anulados y sino en históricos
	 $caja = 3;
	 $expresion = armar_expresion_busqueda_anula();
	 $expresion .= "WHERE PedAnula.Id='".$Codigo."'";
     $result = mysql_query($expresion);
	 
	 if (mysql_num_rows($result)==0)
	 {
	     $caja = 2;
		 $expresion = armar_expresion_busqueda_hist();
	 	 $expresion .= "WHERE PedHist.Id='".$Codigo."'";
	    // echo $expresion;
		 $result = mysql_query($expresion);
		 if (mysql_num_rows($result)==0)
		 {
		 	$caja=1;
		 }
	
	 }
	 
   }
  // echo $expresion;
   echo mysql_error();
   $color = Determinar_Color_Encabezado($caja);
  
 ?>
 					
						
				
<?
  
    while($row = mysql_fetch_row($result))
     {
	 
	   switch ($caja)
	   {
	     case 1:
	 	     Dibujar_Tabla_Comp_Cur($VectorIdioma,$row,$Mensajes);
			 break;
		 case 2:
		 	 Dibujar_Tabla_Comp_Hist_Ped ($VectorIdioma,$row,$Mensajes,0);
			 break;
		 case 3:	 
		 	Dibujar_Tabla_Comp_Cur($VectorIdioma,$row,$Mensajes);
		}
		 
echo devolverBusqueda($row[1],$Mensajes);
		

?>
	<tr> <td align='center'>
 <form name="form3" method="POST"> 
  <p align="center">
  <input type="button" class="style43" value="<? echo $Mensajes["bot-2"]; ?>" name="B3" OnClick="rutear_pedidos(<? echo $row[4]; ?>,'<? echo $row[1]; ?>',<? echo $caja; ?>)">
  <?
    if ($caja==1)
  {?>
  <input type="button" class="style43" value="<? echo $Mensajes["bot-3"]; ?>" name="B1"  OnClick="genera_evento('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'<? echo $row[46]; ?>','<? echo $row[2].",".$row[3]; ?>',<? echo $row[48];?>,<? echo $row[49];?>)"> 
  <input type="button" class="style43" value="<? echo $Mensajes["bot-7"]; ?>" name="B1"  OnClick="busquedas('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'<? echo $row[46]; ?>','<? echo $row[2].",".$row[3]; ?>',<? echo $row[48];?>,<? echo $row[49];?>)"> 
  <?
  }
    if ($caja==3)
	{
  ?>	
     <input type="button" class="style43" value="<? echo $Mensajes["bot-5"]; ?>" name="B1" OnClick="vent_anula('<? echo $row[1]; ?>')">
  <?
    }
  if ($caja==2)
  { ?>
     <input type="button" class="style43" value="<? echo $Mensajes["bot-7"]; ?>" name="B1" OnClick="busquedas('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'nada','<? echo $row[2].",".$row[3]; ?>',0)">
  <?
  }
  ?>

  <input type="hidden" name="Modo">
 
 <? }
  
    ?>
 <input type="hidden" name="caja" value="<? echo $caja;?>">
 </form>
<? echo "</td> </tr> </table> <br>";?>
<?
   mysql_free_result($result);
   
   }   
   Desconectar();

   // de la comparacion por Codigo
?>

					  
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
	    </form>  
  </tr>
</table>
</div>
</body>
</html>