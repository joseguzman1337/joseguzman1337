<?
    
   include_once "../inc/"."var.inc.php";
   include_once "../inc/"."conexion.inc.php";  
   Conexion();	
   include_once "../inc/"."identif.php"; 
   Administracion();
   if (! isset($DiaDesde))		$DiaDesde ="";
   if (! isset($MesDesde ))		$MesDesde ="";
   if (! isset($AnioDesde ))	$AnioDesde ="";
 
   
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
.style58 {font-size: 9px}
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<? 
  include_once "../inc/fgenped.php";
  include_once "../inc/fgentrad.php";
  
  global $IdiomaSitio;
   $Mensajes = Comienzo ("adm-002",$IdiomaSitio);
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  
   
?>

<script language="JavaScript">

 function rutear_pedidos (TipoPed,Id)
 {

     switch (TipoPed)
	  {
	    case 1:
	      ventana=open("../pedidos/verped_col.php?Id="+Id+"&dedonde=2&Tabla=3","Colecciones","scrollbars=yes,width=700,height=450,alwaysLowered");   
	      break;
	    case 2:
	      ventana=open("../pedidos/verped_cap.php?Id="+Id+"&dedonde=2&Tabla=3","Capitulos","scrollbars=yes,width=700,height=450,alwaysLowered");
	      break;
	    case 3:           
          ventana=open("../pedidos/verped_pat.php?Id="+Id+"&dedonde=2&Tabla=3","Patentes","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
       case 4:           
          ventana=open("../pedidos/verped_tes.php?Id="+Id+"&dedonde=2&Tabla=3","Tesis","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
       case 5:           
          ventana=open("../pedidos/verped_con.php?Id="+Id+"&dedonde=2&Tabla=3","Congresos","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
                
	  }
	    
	 return null	
	
 }
 function Seteo_Modo()
 {
    document.forms.form2.action="conanueve.php";   
    document.forms.form2.submit();
 }
 function ver_evento(Id)
 {
  ventana=window.open("../pedidos/ver_evento.php?Id="+Id+"&Tabla=3","Evento", "dependent=yes,toolbar=no,width=530 height=350");
 }
 function vent_anula(Id)
{
   ventana=window.open("genanu.php?Id="+Id+"&dedonde=4", "Eventos", "dependent=yes,toolbar=no,width=530 height=380");
   
 }
 
</script>


<div align="left">
<?

  if ($DiaDesde=="")
  {
  	$DiaDesde=date("d");
  	$DiaHasta=date("d");

  }
  
  if ($MesDesde=="")
  {
   $MesDesde=date("m");
   $MesHasta=date("m");

  }
  
   if ($AnioDesde=="")
  {
   $AnioDesde=date("Y");
   $AnioHasta=date("Y");

  }

?>


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
                              <tr class="style22">
                                <td width="120" class="style22"><div align="right"><? echo $Mensajes["et-12"]; ?></div></td>
                                <td class="style33"><div align="left">
      <select size="1" name="DiaDesde" class="style43">
     		<option selected value="<? echo $DiaDesde?>"><? echo $DiaDesde; ?></option>  
     		<?
     		for ($i=1;$i<=31;$i++)
     		{
     		?>      
          <option><? echo $i; ?></option>
  			<? } ?>        
          </select> / <select size="1" name="MesDesde" class="style43">
          <option selected value="<? echo $MesDesde; ?>"><? echo $MesDesde; ?></option>                
          <?
     		for ($i=1;$i<=12;$i++)
     		{
     		?>      
          <option><? echo $i; ?></option>
          <? } ?>
          </select> / 
        <input type="text" name="AnioDesde" size="9" class="style43" value="<? echo $AnioDesde; ?>">
                                </div></td>
                              </tr>
                              <tr class="style22">
                                <td width="120" class="style22"><div align="right"><? echo $Mensajes["et-13"]; ?></div></td>
                                <td class="style33">
                                      <div align="left">
<select size="1" name="DiaHasta" class="style43">
     		<option selected value="<? echo $DiaHasta; ?>"><? echo $DiaHasta; ?></option>  
     		<?
     		for ($i=1;$i<=31;$i++)
     		{
     		?>      
          <option><? echo $i; ?></option>
  			<? } ?>        
          </select> / <select size="1" name="MesHasta" class="style43">
          <option selected value="<? echo $MesHasta; ?>"><? echo $MesHasta; ?></option>                
          	<? 
          	for ($i=1;$i<=12;$i++)
     		{
     		?>      
          <option><? echo $i; ?></option>
          <? } ?>
          </select> / 
        <input type="text" name="AnioHasta" size="9"  class="style43" value="<? echo $AnioHasta; ?>">                                    </div></td></tr>
                              <tr>
                                <td width="120" class="style49"><div align="right"></div></td>
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
<?
 
  $Fecha_Desde = $AnioDesde."-".$MesDesde."-".$DiaDesde;
  $Fecha_Hasta = $AnioHasta."-".$MesHasta."-".$DiaHasta;
  
   
   $expresion = "SELECT Fecha_Anulacion,Id_Pedido,Codigo_Evento,Operador_Anulacion,EvAnula.Id,Usuarios.Apellido,Usuarios.Nombres,Tipo_Material";
   $expresion.= " FROM EvAnula LEFT JOIN Usuarios ON Usuarios.Id=EvAnula.Operador_Anulacion";
   $expresion .= " WHERE Fecha_Anulacion>='".$Fecha_Desde."' AND Fecha_Anulacion<='".$Fecha_Hasta."'";
   $expresion .= " ORDER BY Fecha_Anulacion";
   
   $result = mysql_query($expresion);
   echo mysql_error();
 ?>  
   

                      <hr>                      <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#006699" class="style45">
                        <tr valign="top" bgcolor="#006699" class="style43">
                          <td class="style43"> <div align="left" class="style45"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["tf-9"]; ?></div>                            </td>
                          </tr>
                      </table>                      
                      <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                        <tr valign="top" class="style11">
                          <td colspan="2" align="center" valign="middle" class="style43"><div align="center"><span class="style57"><span class="style58"><span class="style58"></span></span></span></div></td>
                          <td class="style33"><div align="center" class="style61 style62"><? echo $Mensajes["tf-10"]; ?></div></td>
                          <td class="style33"><div align="center" class="style33"><? echo $Mensajes["tf-11"]; ?></div></td>
                          <td class="style33"><div align="center" class="style33"><? echo $Mensajes["tf-12"]; ?></div></td>
                          <td class="style33"><div align="center" class="style33"><? echo $Mensajes["et-2"]; ?></div></td>
                        </tr>

						 <?
 
 
     while($row = mysql_fetch_row($result))
     {
 
  ?> 

                        <tr valign="top" class="style11">
                          <td align="center" valign="middle" class="style43"><div align="center"></div>                            <div align="center"><span class="style57"><span class="style58"><span class="style60"></span></span></span></div></td>
                          <td align="center" valign="middle" class="style43"><span class="style57"><span class="style58"><span class="style33">    <form method="POST" >
     <input type="button" value="+" name="+" OnClick="ver_evento(<? echo $row[4]; ?>)">
	 <input type="button" value="A" name="A" OnClick="vent_anula (<? echo $row[4] ?>)">
	</form>
</span></span></span></td>
                          <td class="style43"> <div align="center"><? echo $row[0]; ?></div></td>
                          <td class="style43"><div align="center"><? 
	
    $condicion = ($row[2]!=Devuelve_Evento_entrega() && $row[2]!=Devuelve_Evento_cancela()) ;
	$mensaje = Devolver_Evento($row[2],$VectorIdioma); 
	if (!$condicion)
	{
	 $mensaje = "<b><font color='red'>".$mensaje."</font></b>";
	}
	echo $mensaje;
	
	?></div></td>
                          <td class="style43"><div align="center"><? echo $row[5].",".$row[6]; ?></div></td>
                          <td class="style43"><div align="center"><a href="../pedidos/manpedadmc.php?Codigo=<? echo $row[1]; ?>"><? echo $row[1];?></div></td>
                        </tr>
						<?
   } 
  
   mysql_free_result($result);     
   Desconectar();

   // de la comparacion por Codigo
?>
                      </table>                      
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
                  <span class="style33"><a href="../admin/indexadm.php"><? echo $Mensajes["h-1"];?></a></span> </div>                <div align="center" class="style55"></div></td>
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