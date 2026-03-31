<? 
 include_once "../inc/var.inc.php";
 include_once "../inc/"."conexion.inc.php";  
include_once "../inc/"."parametros.inc.php";  
 Conexion();
 
 include_once "../inc/"."identif.php";
 Usuario();
 	
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><? echo Titulo_Sitio();?></title>
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
.style29 {color: #006599}
.style40 {color: #006699}
.style49 {font-size: 11px; font-family: verdana; }
.style50 {font-size: 11px}
.style52 {
	color: #006599;
	font-weight: bold;
	font-family: Verdana;
	font-size: 11px;
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
   global $IdiomaSitio;
  $Mensajes = Comienzo ("adm-002",$IdiomaSitio);
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  $Modo=12;
   
?>

<script language="JavaScript">
 function Seteo_Modo()
 {
    document.forms.form2.action="manpedustodos.php";   
    document.forms.form2.submit();
   
     
 }
 function genera_evento(Id,Estado)
{
   ventana=window.open("gen_evento.php?Id="+Id+"&usuario=<? echo $usuario; ?>&Modo=<? echo $Modo;?>&Estado="+Estado+"&IdCreador=<?echo $Alias_Id; ?>", "Eventos", "dependent=yes,toolbar=no,width=530,height=500,top=20,left=5");
   
 }  

 function rutear_pedidos (TipoPed,Id)
 {

     switch (TipoPed)
	  {
	    case 1:
	      ventana=open("verped_col.php?Id="+Id+"&dedonde=2&Tabla=1&Alias_Id=<? echo $Alias_Id;?>","1","scrollbars=yes,width=700,height=450,alwaysLowered");   
	      break;
	    case 2:
	      ventana=open("verped_cap.php?Id="+Id+"&dedonde=2&Tabla=1&Alias_Id=<? echo $Alias_Id;?>","1","scrollbars=yes,width=700,height=450,alwaysLowered");
	      break;
	    case 3:           
          ventana=open("verped_pat.php?Id="+Id+"&dedonde=2&Tabla=1&Alias_Id=<? echo $Alias_Id;?>","1","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
       case 4:           
          ventana=open("verped_tes.php?Id="+Id+"&dedonde=2&Tabla=1&Alias_Id=<? echo $Alias_Id;?>","1","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
       case 5:           
          ventana=open("verped_con.php?Id="+Id+"&dedonde=2&Tabla=1&Alias_Id=<? echo $Alias_Id;?>","1","scrollbars=yes,width=700,height=450,alwaysRaised");
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
                <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                  <tr bgcolor="#006699">
                    <td height="20" class="style33"><span class="style34"><img src="../images/square-w.gif" width="8" height="8">Pedidos Pendiente</span></td>
                    </tr>
                  <tr align="left" valign="middle">
                    <td class="style22"><div align="center" class="style33">
                      <table width="90%"  border="0" align="center" cellpadding="1" cellspacing="1" class="style22">
                        <tr>
                          <td width="180" class="style22"><div align="right"><? echo $Mensajes["tc-8"]; ?></div></td>
                          <td colspan="2" class="style33"><div align="left"><? echo $Usuario_C; ?></div></td>
                        </tr>
                        <tr>
                          <td width="120" class="style22"><div align="right"></div>
</td>
                          <td class="style22" colspan="2"><input type="radio" class="style22" value="1" name="Lista" <? If (!isset($Lista)) {$Lista="";} If ($Lista==1) { echo " checked"; }?>><? echo $Mensajes["tf-3"]; ?>
                              <input type="radio" name="Lista" class="style22" value="2" <? If (!isset($Lista)) {$Lista="";} If ($Lista==2 || $Lista=="") { echo " checked";}?>><? echo $Mensajes["tf-4"]; ?> </td>

                        </tr>
                        <tr>
                          <td width="120" class="style22"><div align="right"></div></td>
                          <td width="160">
                            <div align="left">
                  <input type="button" value="<? echo $Mensajes["bot-1"]; ?>" name="B1" class="style22" OnClick="Seteo_Modo();">
							 </div></td>
                          <td class="style22"><a href="../admin/elige_usuario.php?Letra=A&dedonde=3"><? echo $Mensajes["h-2"]; ?></a></td>
                        </tr>
                      </table>
                      </div>                      </td>
                    </tr>
                </table>
				<input type="hidden" name="Alias_Id" value="<? echo $Alias_Id; ?>">
  <input type="hidden" name="Usuario_C" value="<? echo $Usuario_C; ?>">
  <input type="hidden" name="Modo" value=<? echo $Modo; ?>>
  <input type="hidden" name="usuario" value=<? echo $usuario; ?>>
  </form>  
                <hr>
<?
  
   $expresion = armar_expresion_busqueda();
   $expresion = $expresion."WHERE Pedidos.Codigo_Usuario=".$Alias_Id;
   $expresion = $expresion." ORDER BY Fecha_Alta_Pedido,Pedidos.Id";
//   echo $expresion;
   $result = mysql_query($expresion);
   echo mysql_error();
   
 If (!isset($Lista)) {$Lista="";} If ($Lista==2 || $Lista=="")
   {
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
				  <? } else { ?>


                  </div>
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
   }
 
  
    while($row = mysql_fetch_row($result))
     {
   ?>    


 <? If (!isset($Lista)) {$Lista="";} If ($Lista==2 || $Lista =="")
 {
      Dibujar_Tabla_Comp_Cur($VectorIdioma,$row,$Mensajes);
	 // echo "</td></tr><tr><td align='center'>";
 ?>

<form name="form3" method="POST"> 
  <p align="center">
  <form name="form3" method="POST"> 
  <p align="center">
  <input type="button" value="<? echo $Mensajes["bot-2"]; ?>" class="style22" name="B3"  OnClick="rutear_pedidos(<? echo $row[4]; ?>,'<? echo $row[1]; ?>')">
  <input class="style22" type="button" value="<? echo $Mensajes["bot-3"]; ?>" name="B1"  OnClick="genera_evento('<? echo $row[1]; ?>',<? echo $row[36]; ?>)">
  </p>
  <!--<input type="hidden" name="Alias_Id" value="<? echo $Alias_Id;?>">-->
  <input type="hidden" name="Modo">
  <input type="hidden" name="Lista">
 </form>
 </td>
 </tr>
 </table>
<br>
<? } 
   else
   {
         Dibujar_Tabla_Abrev_Cur ($VectorIdioma,$row,$Mensajes); 
 ?>
   <form name="form4" method="POST">  
   <td width="5%" height="17" align="left">
   <input type="button" value="P" name="B3" OnClick="rutear_pedidos(<? echo $row[4]; ?>,'<? echo $row[1]; ?>')">
   </td>
   <td width="5%" height="17" align="left">
   <input type="button" value="E" name="B1"  OnClick="genera_evento('<? echo $row[1]; ?>',<? echo $row[36]; ?>)">
   </td>
   </form>
  </tr>
  </table>
  <table border="0" height="3" background="../imagenes/banda.jpg">
  <tr>
   <td width="100%">
   </td>
  </tr>
  </table>
 </form>

</center>  
</center>  


		 <?
	 }
	 }
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