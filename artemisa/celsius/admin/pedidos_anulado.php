<? 
 include_once "../inc/var.inc.php";
 include_once "../inc/"."conexion.inc.php";  
 include_once "../inc/"."parametros.inc.php";  
 Conexion();
 include_once "../inc/"."identif.php";
 Usuario();
 $Dia = date ("d");
 $Mes = date ("m");
 $Anio = date ("Y");
 $FechaHoy =$Anio."-".$Mes."-".$Dia;
 if (!isset($Inicio))
  {
   $Inicio=$FechaHoy;
  }
 if (!isset($Fin))
  {
   $Fin=$FechaHoy;
  }
?> 
<html>
<head>
<title><? echo Titulo_Sitio();?></title>
<SCRIPT language=JavaScript src="ts_picker.js"></SCRIPT>
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
  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."fgentrad.php";
  include_once "../inc/"."tabla_ped_unnoba.inc";
   global $IdiomaSitio;
  $Mensajes = Comienzo ("adm-002",$IdiomaSitio);
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  $Modo=12;
   
?>

<script language="JavaScript">
 function Seteo_Modo()
 {
    document.forms.form2.action="pedidos_anulado.php";   
    document.forms.form2.submit();
   
     
 }
 function genera_evento(Id,Estado)
{
   ventana=window.open("../pedidos/gen_evento.php?Id="+Id+"&usuario=<? echo $Alias_Id; ?>&Modo=<? echo $Modo;?>&Estado="+Estado, "Eventos", "dependent=yes,toolbar=no,width=530,height=500,top=20,left=5");
   
 }  

 function rutear_pedidos (TipoPed,Id)
 {

	 switch (TipoPed)
	  {
	    case 1:
	      ventana=open("../pedidos/verped_col.php?Id="+Id+"&dedonde=2&Tabla=2&Alias_Id=<? echo $Alias_Id;?>","1","scrollbars=yes,width=700,height=450,alwaysLowered");   
	      break;
	    case 2:
	      ventana=open("../pedidos/verped_cap.php?Id="+Id+"&dedonde=2&Tabla=2&Alias_Id=<? echo $Alias_Id;?>","1","scrollbars=yes,width=700,height=450,alwaysLowered");
	      break;
	    case 3:           
          ventana=open("../pedidos/verped_pat.php?Id="+Id+"&dedonde=2&Tabla=2&Alias_Id=<? echo $Alias_Id;?>","1","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
       case 4:           
          ventana=open("../pedidos/verped_tes.php?Id="+Id+"&dedonde=2&Tabla=2&Alias_Id=<? echo $Alias_Id;?>","1","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
       case 5:           
          ventana=open("../pedidos/verped_con.php?Id="+Id+"&dedonde=2&Tabla=2&Alias_Id=<? echo $Alias_Id;?>","1","scrollbars=yes,width=700,height=450,alwaysRaised");
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
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
      
	  <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr>
        <td valign="top">            <div align="center">
              <center>
                <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ECECEC">
                  <tr bgcolor="#006699">
                    <td height="20" colspan="2" class="style33"><span class="style34"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["tit-1"]?> </span><div align="right" class="style34 style35"></div></td>
                    </tr>
                  <tr align="left" valign="middle">
                    <td height="20" colspan="2" class="style22"><div align="center" class="style33"><? echo $Mensajes["tf-1"]; ?></div></td>
                    </tr>
                  <tr align="left" valign="middle">
                    <td width="250" height="20" class="style22">                      
                      <div align="right"><? echo $Mensajes["tf-2"]; ?>
                      </div></td>
                    <td class="style22"><div align="left">
                      <input type="text" name="Inicio" style='width:70' class="style22" size="10" <? if ($Inicio!="") 
		                     echo "value='".$Inicio."'";?>
							 ><a href="javascript:show_calendar('document.form2.Inicio',document.form2.Inicio.value);">
					  <img border="0" src="../images/calendar.gif" width="16" height="16"></a></div></td>
                  </tr>
                  <tr align="left" valign="middle">
                    <td width="250" height="20" class="style22"><div align="right"><? echo $Mensajes["tf-3"]; ?>
                          
                    </div></td>
                    <td height="20" class="style22"><div align="left">
                      <input type="text" class="style22" name="Fin" style='width:70' size="10" <? if ($Fin!="") 
		                     echo "value='".$Fin."'";?>
							 ><a href="javascript:show_calendar('document.form2.Fin',document.form2.Fin.value);">
					  <img src="../images/calendar.gif" width="16" height="16" border="0"></a></div></td>
                  </tr>
                  
                  <tr valign="middle">
                    <td width="250" height="20"><div align="center">
                    </div></td>
                    <td height="20">
					<input type="button" onClick="Seteo_Modo();" class="style22"  value="<? echo $Mensajes["bot-1"]; ?>" name="B1">
					</td>
                  </tr>
                </table>
	  		<input type="hidden" name="Alias_Id" value="<? echo $Alias_Id; ?>">
  <input type="hidden" name="Usuario_C" value="<? echo $Usuario_C; ?>">
  <input type="hidden" name="Modo" value=<? echo $Modo; ?>>

  </form>  
                <hr>
<?
  
  $expresion = armar_expresion_busqueda_hist();
  $expresion = $expresion."LEFT JOIN EvHist AS EvHist ON  PedHist.Id=EvHist.Id_Pedido ";
  $expresion = $expresion."WHERE EvHist.Codigo_Evento='".Devolver_Estado_Cancelado()."' and EvHist.Fecha<='".$Fin."'  and EvHist.Fecha>='".$Inicio."' ORDER BY EvHist.Fecha";

   


   //echo $expresion;
   $result = mysql_query($expresion);
   echo mysql_error();
   
 ?>  
	<div align="left">
    <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#0099CC">
    <tr>
     <td height="20" class="style22"><img src="../images/square-w.gif" width="8" height="8">
	 <?
        echo $Mensajes["et-9"];
      ?>
	 <span class="style35"><? echo mysql_num_rows($result); ?></span></td>
                    </tr>
                  </table>
	<?
  
 
  
    while($row = mysql_fetch_row($result))
     {
       Dibujar_Tabla_Comp_Cur_Pedidos($VectorIdioma,$row,$Mensajes); 
 ?>

<form name="form3" method="POST"> 
  <p align="center">
  <form name="form3" method="POST"> 
  <p align="center">
  <input type="button" value="<? echo $Mensajes["bot-2"]; ?>" class="style22" name="B3"  OnClick="rutear_pedidos(<? echo $row[4]; ?>,'<? echo $row[1]; ?>')">
  <!--<input class="style22" type="button" value="<? echo $Mensajes["bot-3"]; ?>" name="B1"  OnClick="genera_evento('<? echo $row[1]; ?>',<? echo $row[36]; ?>)">-->
  </p>
 </form>
<br>

<?	 }
		mysql_free_result($result);
   Desconectar();
?>              
              </center>
            </div>            </td>

        <td width="150" valign="top"><div align="center" class="style22">
          <div align="left">
            <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td><div align="center">
                  <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td bgcolor="#ECECEC"><div align="center">
                          <p><img src="../images/image001.jpg" width="150" height="118"><br>
                              <span class="style33"><a href="../admin/indexadm.php"><? echo $Mensajes["h-1"]; ?></a></span></p>
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
      </div>
	 
	  </td>
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