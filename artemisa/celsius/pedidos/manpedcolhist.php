<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<?
include_once "../inc/var.inc.php";
 
include_once "../inc/"."conexion.inc.php";  
Conexion();
include_once "../inc/"."identif.php";
Usuario();
 	
?> 

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
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 9px; }
.style23 {
	color: #000000;
	font-size: 10px;
	font-family: verdana;
}
.style28 {color: #FFFFFF}
.style29 {
	color: #006599;
	font-family: Verdana;
	font-size: 9px;
}
.style30 {color: #FFFFFF; font-size: 9px; font-family: verdana; }
.style38 {
	font-size: 10px;
	color: #FFFFFF;
	font-family: Verdana;
}
.style39 {color: #CCCCCC}
.style40 {font-size: 10px}
.style41 {
	color: #006599;
	font-weight: bold;
}
-->
</style>
<? 
  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."fgentrad.php";
  include_once "../inc/"."tabla_ped_unnoba.inc";  
 global $IdiomaSitio; 
   $Mensajes = Comienzo ("adh-001",$IdiomaSitio);
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  
?><script language="JavaScript">
 function Seteo_Modo()
 {
   if (document.forms.form2.PedHist.value==1)
   {
    document.forms.form2.action="manpedcolhist.php";
    document.forms.form2.Modo.value=1;
    document.forms.form2.submit();
   }
   else if (document.forms.form2.PedHist.value==2)
   {
    document.forms.form2.action="manpedcolhist.php";
    document.forms.form2.elements.Modo.value=2;
    document.forms.form2.submit();
   }
   else{
     document.forms.form2.action="manpedcolhist.php";
     document.forms.form2.elements.Modo.value=3;
     document.forms.form2.submit();
   }
   
 }

  function rutear_PedHist (TipoPed,Id)
 {
    
	    
     switch (TipoPed)
	  {

		case '1':
	      
		  { ventana=window.open("verped_col.php?Id="+Id+"&dedonde=1&Tabla=2","Colecciones","scrollbars=yes,width=700,height=450,alwaysLowered");   
	      break;}
	    case '2':
		  { ventana=window.open("verped_cap.php?Id="+Id+"&dedonde=1&Tabla=2","Capitulos","scrollbars=yes,width=700,height=450,alwaysLowered");
	      break;}
	    case '3':           
		  { ventana=window.open("verped_pat.php?Id="+Id+"&dedonde=1&Tabla=2","Patentes","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	}
       case '4':           
		  { ventana=window.open("verped_tes.php?Id="+Id+"&dedonde=1&Tabla=2","Tesis","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	}
       case '5':       
		  {
          ventana=window.open("verped_con.php?Id="+Id+"&dedonde=1&Tabla=2","Actas Congresos","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
		  }     
	  }
	    
	 return null	
	
 }

</script>

<base target="_self">
</head>
<form name="form2">
<body topmargin="0">
<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
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
                  <tr>
                    <td height="20" colspan="2" bgcolor="#cecece" class="style30"><div align="left" class="style23"><? echo $Mensajes["tf-10"]; ?><? 
          echo $Coleccion;  ?></div></td>
                  </tr>
                  <tr>
                    <td colspan="2" class="style23">
                        <div align="left">                          
                          <table width="100%" height="100"  border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td align="center" valign="middle"><div align="left">
                                <table height="20" border="0" align="center" cellspacing="0">
                                  <tr>
                                    <td height="18">
                   <select size="1" name="PedHist" OnChange="Seteo_Modo()" style="font-family: MS Sans Serif; font-size: 10 px">
           
          <option <? if ($Modo==1) { echo "selected "; } ?>value=1><? echo $Mensajes["opc-1"]; ?></option>
          <option <? if ($Modo==2) { echo "selected "; } ?>value=2><? echo $Mensajes["opc-2"]; ?></option>
           &nbsp;
            
          </select>
                   </td>
                                  </tr>
                   <input type="hidden" name="Modo">  
        <input type="hidden" name="fila" value="0">
        <input type="hidden" name="Id_Colecc" value="<? echo $Id_Colecc; ?>">
        <input type="hidden" name="Coleccion" value="<? echo $Coleccion; ?>">

         </form>               </table>
                  <a href="../admin/elige_col.php?dedonde=2&Letra=A"> <? echo $Mensajes["h-3"]; ?></a>
							  </div>
                                <div align="center"></div></td>
                            </tr>
                          </table>
                        </div>                        
                        </td></tr>
                        

  <?   
   
    
   $expresion = "SELECT COUNT(*) FROM PedHist ";
   if ($Modo==1) {  
        $expresion = $expresion."WHERE (PedHist.Estado=".Devuelve_Evento_PDFEnviado() ." OR PedHist.Estado=".Devolver_Estado_Entregado()." )AND PedHist.Codigo_Titulo_Revista=".$Id_Colecc." ORDER BY PedHist.Fecha_Alta_Pedido DESC";}
        
   else {
        $expresion = $expresion."WHERE PedHist.Estado=".Devolver_Estado_Cancelado()." AND PedHist.Codigo_Titulo_Revista=".$Id_Colecc." ORDER BY PedHist.Fecha_Alta_Pedido DESC";}
        
  

   $result = mysql_query($expresion);

   $row = mysql_fetch_row($result);
   $numfilas = $row[0];
   
  $expresion = armar_expresion_busqueda_hist(); 
    
   if ($Modo==1) {  
        $expresion = $expresion."WHERE ( PedHist.Estado=".Devuelve_Evento_paraConfirmarPorRecursoWeb() ." or " ."PedHist.Estado=".Devuelve_Evento_PDFEnviado() ." OR PedHist.Estado=".Devolver_Estado_Entregado().") AND PedHist.Codigo_Titulo_Revista=".$Id_Colecc." ORDER BY PedHist.Fecha_Alta_Pedido DESC LIMIT ".$fila.",10";}
        
   else {
        $expresion = $expresion."WHERE PedHist.Estado=".Devolver_Estado_Cancelado()." AND PedHist.Codigo_Titulo_Revista=".$Id_Colecc." ORDER BY PedHist.Fecha_Alta_Pedido DESC LIMIT ".$fila.",10";}
   
   //echo $expresion; 
   $result = mysql_query($expresion);
   echo mysql_error();
?>

               <tr bgcolor="#006599" class="style38">
                    <td width="337" class="style23 style39"> <div align="center" class="style28"><? echo $Mensajes["st-002"];?></div></td>
                    <td width="230" class="style23"> <div align="right" class="style38 style28">
                          <?
                          $numerito=(int)($fila/10)+1;
                          //echo $numerito."</font>"." ".$Mensajes["tf-3"]." ".$filas." ".$Mensajes["tf-4"]." <div align='right'><b>".$Mensajes["tf-8"]."<font color=yellow>$numfilas</font></b></div>";


      	if ($fila>=10)
    	{
    	 $filita=$fila-10;
    	 //echo "<a href=".$PHP_Self."?fila=".$filita."&Modo=$Modo&Id_Alias=$Id_Alias&Alias_Comunidad=$Alias_Comunidad>".$Mensajes["tf-9"]."</a>";
    	}

    	$cociente = ($numfilas / 10);
    	if ($numfilas%10>0)
    	{
    	  $cociente+=1;
    	}

    	$filita=0;
    	for ($i=1;$i<=$cociente;$i++)
    	{
    	//	echo "<a href=".$PHP_Self."?fila=".$filita."&Modo=$Modo&Id_Alias=$Id_Alias&Alias_Comunidad=$Alias_Comunidad>$i</a>-";
    		$filita+=10;
    	}

     	if ($fila+10<=$numfilas)
    	{
    	 $filita=$fila+10;
    	 //echo "<a href=".$PHP_Self."?fila=".$filita."&Modo=$Modo&Id_Alias=$Id_Alias&Alias_Comunidad=$Alias_Comunidad>".$Mensajes["tf-7"]."</a>";
    	}


    ?>
                      <div align="center" class="style38"><? echo $Mensajes["st-003"]; ?> <? echo $numfilas; ?>  </div>
                    </div></td>
                  </tr>
                   <?  
                 while($row = mysql_fetch_row($result))
                 {
                 		Dibujar_Tabla_Comp_Hist ($VectorIdioma,$row,$Mensajes,1);
                 		echo "<br>";
                 }
                 ?>

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
                    <a href="../admin/indexadm.php"><? echo $Mensajes["h-1"]; ?></a></span></p>
                  </div>                  </td>
          </div></td>
		  <?
		  }	  
		  ?>
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
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a></div></td>
          <td width="50"><div align="center" class="style11">adh-001</div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>
