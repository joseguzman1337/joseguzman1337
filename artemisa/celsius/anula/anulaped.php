<?
   include_once "../inc/var.inc.php";
   include_once "../inc/"."conexion.inc.php";  
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
.style46 {
	color: #006599;
	font-family: verdana;
	font-size: 10px;
	font-style: normal;
	font-weight: bold;
}
.style49 {font-family: verdana; font-size: 10px; color: #006599; }
.style55 {
	font-size: 10px;
	color: #000000;
	font-family: Verdana;
}
.style56 {color: #00FFFF}
.style33 {	font-family: verdana;
	font-size: 9px;
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
//include_once Obtener_Direccion()."tabla_ped.inc";
  include_once "../inc/"."tabla_ped_unnoba.inc";
  Conexion(); 
  global $IdiomaSitio;
  $Mensajes = Comienzo ("adm-002",$IdiomaSitio);
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  
   
?>

<script language="JavaScript">
 function Seteo_Modo()
 {
    document.forms.form2.action="anulaped.php";   
    document.forms.form2.submit();
 }
 
 function vent_anula(Id,Estado,Mail,Nombre)
{
   ventana=window.open("genanu.php?Id_Pedido="+Id+"&dedonde=1&Estado="+Estado+"&Nombre="+Nombre, "Eventos", "dependent=yes,toolbar=no,width=530 ,height=380");
   
 }

 function rutear_pedidos (TipoPed,Id)
 {

     switch (TipoPed)
	  {
	    case 1:
	      ventana=open("../pedidos/verped_col.php?Id="+Id+"&dedonde=1&Tabla=1","Colecciones","scrollbars=yes,width=700,height=450,alwaysLowered");   
	      break;
	    case 2:
	      ventana=open("../pedidos/verped_cap.php?Id="+Id+"&dedonde=1&Tabla=1","Capitulos","scrollbars=yes,width=700,height=450,alwaysLowered");
	      break;
	    case 3:           
          ventana=open("../pedidos/verped_pat.php?Id="+Id+"&dedonde=1&Tabla=1","Patentes","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
       case 4:           
          ventana=open("../pedidos/verped_tes.php?Id="+Id+"&dedonde=1&Tabla=1","Tesis","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
       case 5:           
          ventana=open("../pedidos/verped_con.php?Id="+Id+"&dedonde=1&Tabla=1","Congresos","scrollbars=yes,width=700,height=450,alwaysRaised");
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
                                <td class="style43" ><div align="left"><? echo $Usuario; ?></div></td>
                              </tr>
                              <tr>
                                <td width="200" class="style49"><div align="right"><? echo $Mensajes["tc-1"]; ?></div></td>
                                <td class="style43"><div align="left">
								<input type="text" name="Codigo" size="20" value="<? if ($Codigo=="") { echo Devolver_Abreviatura_Pais_Predeterminada()."-".Devolver_Abreviatura_Institucion_Predeterminada()."-"; } else { echo $Codigo; } ?>" class="style43"><input type="hidden" name="Modo" value=11></div>
								
								</td>
                              </tr>
                              <tr>
                                <td width="200" class="style49"><div align="right"></div></td>
                                <td class="style43">
								<div align="left">
								<input type="button" value="<? echo $Mensajes["bot-1"]; ?>" name="B1"  class="style43" OnClick="Seteo_Modo()"></div>
								</td>
                              </tr>
                            </table>
                            </div>                            
                            </td>
                          </tr>
                      </table>
                      <hr>                      <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#006699" class="style45">
                        <tr valign="top" bgcolor="#006699" class="style43">
                          <td class="style43"> <div align="left" class="style45"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["tc-2"]; ?></div>                            </td>
                          </tr>
                      </table>      
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
   
  
   $expresion = armar_expresion_busqueda();
   $expresion = $expresion."WHERE Pedidos.Id='".$Codigo."'";

   $result = mysql_query($expresion);
   echo mysql_error();
  
    while($row = mysql_fetch_row($result))
     {
	 
	  //Dibujar_Tabla_Comp_Cur_Pedidos($VectorIdioma,$row,$Mensajes); 
	  Dibujar_Tabla_Comp_Cur($VectorIdioma,$row,$Mensajes); 
  ?>    
<form name="form3" method="POST">
&nbsp;<table width="530" border="0" cellpadding="2" cellspacing="3" >
<tr>
<td>
<div align="right">
<input type="button" value="<? echo $Mensajes["bot-2"]; ?>" name="B3" OnClick="rutear_pedidos(<? echo $row[4]; ?>,'<? echo $row[1]; ?>')" class="style43">
 </div></td>
 <td><div align="left"><input type="button" value="<? echo $Mensajes["bot-4"]; ?>" name="B1"  OnClick="vent_anula('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'<? echo $row[46]; ?>','<? echo $row[2].",".$row[3]; ?>')" class="style43"></div>
  </td>
  </tr>
  </table>
  <input type="hidden" name="Modo">
 </form>
		<?
       }
    ?>			  
	<?
   mysql_free_result($result);
   
   }   
   Desconectar();

   // de la comparacion por Codigo
?>		     </td>
              </tr>
             </table>  </td>
              </tr>
            </table>
              </center>
            </div>
            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td class="style28"><div align="center"><img src="../images/image001.jpg" width="150" height="118"><br>
                  <span class="style33">
				  <a href="../admin/indexadm.php"><? echo $Mensajes["h-1"]; ?></a>
				  </span> </div>  <div align="center" class="style55"></div></td>
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