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
<title>PrEBi </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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

a.style33 {
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
.style35 {color: #FFFFFF}
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<? 
  include_once "../inc/fgenped.php";
  include_once "../inc/fgentrad.php";
  include_once "../inc/tabla_ped_unnoba.inc";
  global $IdiomaSitio;
   $Mensajes = Comienzo ("adm-002",$IdiomaSitio);
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  
   
?>

<script language="JavaScript">
 function Seteo_Modo()
 {
    document.forms.form2.action="conanuped.php";   
    document.forms.form2.submit();
   
     
 }

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
 
 function vent_anula(Id)
{
   ventana=window.open("genanu.php?Id="+Id+"&dedonde=2", "Eventos", "dependent=yes,toolbar=no,width=530 height=380");
   
 }
 
</script>


<div align="center">
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
<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr>
        <td valign="top">            <div align="center">
              <center>
                <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                  <tr bgcolor="#006699">
                    <td height="20" class="style33"><span class="style34"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["tf-18"]; ?> </span></td>
                    </tr>
                  <tr align="left" valign="middle">
                    <td class="style22"><div align="center" class="style33">
                      <table width="90%"  border="0" align="center" cellpadding="1" cellspacing="1" class="style22">
                        <tr>
                          <td class="style22"><div align="right"><? echo $Mensajes["et-12"]; ?></div></td>
                          <td class="style33"><div align="left">
						  <select size="1" name="DiaDesde" class="style22">
     		<option selected value="<? echo $DiaDesde?>"><? echo $DiaDesde; ?></option>  
     		<?
     		for ($i=1;$i<=31;$i++)
     		{
     		?>      
          <option><? echo $i; ?></option>
  			<? } ?>        
          </select> / <select size="1" name="MesDesde" class="style22">
          <option selected value="<? echo $MesDesde; ?>"><? echo $MesDesde; ?></option>                
          <?
     		for ($i=1;$i<=12;$i++)
     		{
     		?>      
          <option><? echo $i; ?></option>
          <? } ?>
          </select> / 
        <input type="text" name="AnioDesde"  class="style22" size="9" value="<? echo $AnioDesde; ?>">
 </div>
						  
</td>
                        </tr>
                        <tr>
                          <td width="120" class="style22"><div align="right"><? echo $Mensajes["et-13"]; ?></div></td>
                          <td class="style33"><div align="left">
        <select size="1" name="DiaHasta" class="style22">
     		<option selected value="<? echo $DiaHasta; ?>"><? echo $DiaHasta; ?></option>  
     		<?
     		for ($i=1;$i<=31;$i++)
     		{
     		?>      
          <option><? echo $i; ?></option>
  			<? } ?>        
          </select> / <select size="1" name="MesHasta" class="style22">
          <option selected value="<? echo $MesHasta; ?>"><? echo $MesHasta; ?></option>                
          	<? 
          	for ($i=1;$i<=12;$i++)
     		{
     		?>      
          <option><? echo $i; ?></option>
          <? } ?>
          </select> / 
        <input type="text" name="AnioHasta" class="style22" size="9" value="<? echo $AnioHasta; ?>">
                          </div></td>
                        </tr>
                        <tr>
                          <td width="120" class="style22"><div align="right"></div></td>
                          <td><div align="left">                                  
						  <input type="button" value="<? echo $Mensajes["bot-1"]; ?>" name="B1" class="style22" OnClick="Seteo_Modo()">
                          </div></td>
                          </tr>
                      </table>
                      </div>                      </td>
                    </tr>
                </table>
<?
 
  $Fecha_Desde = $AnioDesde."-".$MesDesde."-".$DiaDesde;
  $Fecha_Hasta = $AnioHasta."-".$MesHasta."-".$DiaHasta;
  
   
   $expresion = armar_expresion_busqueda_anula();
   $expresion = $expresion."WHERE Fecha_Anulacion>='".$Fecha_Desde."' AND Fecha_Anulacion<='".$Fecha_Hasta."'";
   $expresion .= " ORDER BY Fecha_Anulacion";
   
   $result = mysql_query($expresion);
   echo mysql_error();
 ?>  

				
				<hr>
                <div align="left">
                  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#0099CC">
                    <tr>
                      <td height="20" class="style22"><img src="../images/square-w.gif" width="8" height="8">
					  <? echo $Mensajes["tf-8"];   ?>
<span class="style35"><? echo mysql_num_rows($result); ?></span></td>
                    </tr>
                  </table>
                  </div>
				  <?
  
    while($row = mysql_fetch_row($result))
     {
 	    Dibujar_Tabla_Comp_Cur_Pedidos ($VectorIdioma,$row,$Mensajes); 
 
   ?>    
 
 <form name="form3" method="POST"> 
  <input type="button" value="<? echo $Mensajes["bot-2"]; ?>" name="B3" class="style22" OnClick="rutear_pedidos(<? echo $row[4]; ?>,'<? echo $row[1]; ?>')">
  <input type="button" value="<? echo $Mensajes["bot-5"]; ?>" name="B3"  class="style22" OnClick="vent_anula('<? echo $row[1]; ?>')">
  </p>
  <input type="hidden" name="Modo">
 </form>
 <?
   }
   
   mysql_free_result($result);     
   Desconectar();

   // de la comparacion por Codigo
?>
             </td>
        <td width="150" valign="top"><div align="center" class="style22">
          <div align="left">
            <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td><div align="center">
                  <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td bgcolor="#ECECEC"><div align="center">
                          <p><img src="../images/image001.jpg" width="150" height="118"><br>
                              <span class="style33"> <a class="style33" href="../admin/indexadm.php"><? echo $Mensajes["h-1"];?></a></span></p>
                      </div></td>
                    </tr>
                  </table>
                  </div></td>
              </tr>
            </table>
            </div>
        </div></td>
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
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" height="43" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50"><div align="right" class="style33">
            <div align="center">adm-002</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>