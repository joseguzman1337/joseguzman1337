<? 
include_once "../inc/var.inc.php";
 
include_once "../inc/"."conexion.inc.php";  
 Conexion();

 include_once "../inc/"."identif.php";
 Usuario();
 	
?> 

<html>

<head>
<title><? echo Titulo_Sitio();?></title>
</head>

<body background="../imagenes/banda.jpg">

<? 
  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."fgentrad.php";
    global $IdiomaSitio;
   $Mensajes = Comienzo ("adm-002",$IdiomaSitio);
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
   
?>
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
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 11px; }
.style23 {
	color: #000000;
	font-size: 11px;
	font-family: verdana;
}
.style28 {color: #FFFFFF}
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
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 11px; }
-->
</style>

<script language="JavaScript">

 function Confirma_Pedido(Id,Tipo)
{
   document.forms.form1.action="opera_ped.php";
   document.forms.form1.Resp.value=1;
   document.forms.form1.Id.value = Id;
   document.forms.form1.Tipo_Material.value=Tipo;
   document.forms.form1.submit();
   
 }  

 function Cancela_Pedido(Id,Tipo)
{
   document.forms.form1.action="opera_ped.php";
   document.forms.form1.Resp.value=0;
   document.forms.form1.Id.value= Id;
   document.forms.form1.Tipo_Material.value=Tipo;
   document.forms.form1.submit();
 }  
 
 function rutear_pedidos (TipoPed,Id)
 {

     switch (TipoPed)
	  {
	    case 1:
	      ventana=open("verped_col.php?Id="+Id+"&dedonde=2&Tabla=1","Colecciones","scrollbars=yes,width=550,height=450,alwaysLowered");
	      break;
	    case 2:
	      ventana=open("verped_cap.php?Id="+Id+"&dedonde=2&Tabla=1","Capitulos","scrollbars=yes,width=550,height=450,alwaysLowered");
	      break;
	    case 3:           
          ventana=open("verped_pat.php?Id="+Id+"&dedonde=2&Tabla=1","Patentes","scrollbars=yes,width=550,height=450,alwaysRaised");
          break;	
       case 4:           
          ventana=open("verped_tes.php?Id="+Id+"&dedonde=2&Tabla=1","Tesis","scrollbars=yes,width=550,height=450,alwaysRaised");
          break;	
       case 3:           
          ventana=open("verped_con.php?Id="+Id+"&dedonde=2&Tabla=1","Actas Congresos","scrollbars=yes,width=550,height=450,alwaysRaised");
          break;	
                
	  }
	    
	 return null	
	
 }

</script>

<P>
<?
 if ($Bibliotecario>0)
 {
 ?>
 
<form name="form2" action="manpedcon.php">
  <table border="0" width="75%" height="4" bgcolor="#0083AE" cellspacing="0" align="center">
    <tr>
      <td width="40%" height="1" align="center">
        <p align="right"><b><font face="MS Sans Serif" size="1" color="#FFFFCC">&nbsp;&nbsp;&nbsp;</font>
        </b>
      </td>
      <td width="108%" height="1" align="center" colspan="3">
        &nbsp;
      </td>
    </tr>
  <center>
    <tr>
      <td width="40%" height="1" align="center">
        <font face="MS Sans Serif" size="1" color="#FFFFCC"><? echo $Mensajes["tc-3"]; ?></font>
      </td>
	  </center>
      <td width="37%" height="1" align="center">
        
        <p align="left"><b>
        <font face="MS Sans Serif" size="1" color="#FFFFCC">
        <select size="1" name="Id_Entrega" style="font-family: MS Sans Serif; font-size: 10 px">
        <?   
		   
		   $expresion = "SELECT Usuarios.Id,Usuarios.Apellido,Usuarios.Nombres,COUNT(*) ";
   		   $expresion .= "FROM Pedidos ";
		   $expresion .= "LEFT JOIN Usuarios ON Pedidos.Codigo_Usuario = Usuarios.Id ";
     	   $expresion .= "WHERE Pedidos.Estado=4 ";
		     switch ($Bibliotecario)
			{
					case 1:
						$expresion.=" AND Usuarios.Codigo_Institucion=".$Instit_usuario;
						break;
					case 2:
						$expresion.=" AND Usuarios.Codigo_Dependencia=".$Dependencia;
						break;
					case 3:
						$expresion.=" AND Usuarios.Codigo_Unidad=".$Unidad;
						break;
			}	   			
		   $expresion .=" AND Tipo_Usuario_Crea=2 GROUP BY Pedidos.Codigo_Usuario ORDER BY Usuarios.Apellido,Usuarios.Nombres";
		   
         	$result = mysql_query($expresion);
   			echo mysql_error();

			while($row = mysql_fetch_row($result))
		   { 
			
			if ($Id_Entrega==$row[0])
			{
			 ?>
           <option selected value="<? echo $row[0]; ?>"><? echo $row[1].",".$row[2]." [".$row[3]."]"; ?></option>  
          <?
            } else { ?>
			<option value="<? echo $row[0]; ?>"><? echo $row[1].",".$row[2]." [".$row[3]."]"; ?></option>               
          <? }
           } ?> 
            </select></font></b></p>
                
      </td>
      <td width="18%" height="1" align="center">
        
        <p align="left"><font face="MS Sans Serif" size="1" color="#FFFFCC"><input type="submit" value="<? echo $Mensajes["bot-1"]; ?>" name="B1" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold"></font></p>
        
      </td>
      <td width="18%" height="1" align="center">
        
        &nbsp;
        
      </td>
    </tr>
    <tr>
      <td width="40%" height="1" align="center">
        &nbsp;<input type="hidden" name="dedonde" value="<? echo $dedonde; ?>">
      </td>
      <td width="19%" height="1" align="center" colspan="2">
        &nbsp;
      </td>
    </tr>
  </table>
 </form>  
    
 <?
 }
 
  if (($Bibliotecario>0 && $Id_Entrega!=0)||($Bibliotecario==0))
  {
  
   $expresion = armar_expresion_busqueda();
   
   if ($Bibliotecario>0)
   {
	 	$Id_us = $Id_Entrega;
		$completa=" AND Tipo_Usuario_Crea=2";
   }
   else
   {
	 	$Id_us = $Id_usuario;
		$completa="";
   } 
   
   $expresion .="WHERE Pedidos.Estado=4".$completa." AND Pedidos.Codigo_Usuario=".$Id_us;
   $expresion .=$completa." ORDER BY Fecha_Alta_Pedido";

   $result = mysql_query($expresion);
   echo mysql_error();

?>



  <table width="770" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
      <table width="700" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
        <tr bgcolor="#006599" class="style38">
         <td class="style23 style39" width="40%">
          <div align="center" class="style28" ><? echo $Mensajes["tf-20"]; ?> </div></td>
        <td class="style23" width="20%">
          <div align="right" class="style38 style28">
           <div align="center" class="style38"><? echo $Mensajes["tf-21"]; ?> <? echo mysql_num_rows($result); ?> </div>
          </div></td>
        </tr>
    <td width="1%" align="center" height="1">
      <p align="left">&nbsp;</p>
    </td>   
    <td width="95%" align="center" height="1">
      <p align="left"><b><font face="MS Sans Serif" size="1" color="#000080">&nbsp;</font></b>
    </td>   
  </tr>
  <center>

</table>
 
 <?
      while($row = mysql_fetch_row($result))
     {
   ?>    
   
   <table width="60%"  border="0" align="center" cellpadding="0" cellspacing="1">
    <tr bgcolor="#ECECEC">

      <td colspan="2" align="center" valign="middle">
      <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="1" >
    <tr>
      <td colspan="3" align=left><span class="style49"><strong class="style29 style40"> <? echo $Mensajes["tf-22"]; ?></strong> <?
      
      echo Devolver_Tipo_Solicitud($VectorIdioma,$row[0],0)."-";
      echo Devolver_Tipo_Material ($VectorIdioma,$row[4]);
    
      ?></span></td>
      </tr>
   <tr>
   <td colspan="3" align=left><span class="style49">
   <span class="style29"><strong><? echo $Mensajes["tf-23"]; ?> </strong>

   </span>
    
    <? 
 		
      echo Devolver_Descriptivo_Material($row[4],$row,0,1); 
      echo $renglon;
      ?>
    </span></td>
  </tr>
  <tr>
  <td align=left><span class="style49"><span class="style52"><? echo $Mensajes["et-5"]; ?></span><span class="style49"><?echo $row[35]; ?></span></td>
  <td align=left><span class="style52"><? echo $Mensajes["et-2"]; ?></span><span class="style49"><? echo $row[1]; ?></span></td>
</tr>

<tr>
  <td align=left><span class="style52"><? echo $Mensajes["et-6"]; ?></span><span class="style49"><? if (strlen($row[37])>0) {echo $row[37].",".$row[38];} ?></span></td>
  <td align=left><span class="style52"><? echo $Mensajes["et-7"]; ?></span><span class="style49"><? echo Devolver_Estado($VectorIdioma,$row[36],0); ?> </span></td>
</tr>

 <tr>
  
  <?
  
    $expresion = "SELECT Eventos.Observaciones FROM Eventos WHERE Codigo_Evento=4 AND Id_Pedido='".$row[1]."' ORDER BY Fecha DESC";
    $result2 = mysql_query($expresion);
    echo mysql_error();
    $rowg = mysql_fetch_row($result2)
    
  
  ?>
    <td align=left colspan=2><span class="style52"><? echo $Mensajes["et-8"]; ?>&nbsp;&nbsp;</span><span class="style49"><? echo $rowg[0]; ?></span></td>
  </tr>
  <tr>
    <td width="175" height="17" valign="middle" align="right">&nbsp;</td>
    <td width="354" height="17" valign="middle" align="left" colspan="2">&nbsp;</td>
  </tr>
</table>
 <tr bgcolor="<? echo Devolver_Color($row[4]); ?>">
  <td align='center'>

 <form name="form3"> 
  <p align="center">
  <input type="button" value="<? echo $Mensajes["botc-3"];  ?>" name="Confirma" class="style23" OnClick="Confirma_Pedido('<? echo $row[1]; ?>',<? echo $row[4]; ?>)">
  <input type="button" value="<? echo $Mensajes["botc-4"]; ?>" name="Cancela" class="style23" OnClick="Cancela_Pedido('<? echo $row[1]; ?>',<? echo $row[4]; ?>)">
  <input type="button" value="<? echo $Mensajes["bot-2"];  ?>" name="Revisa" class="style23" OnClick="rutear_pedidos(<? echo $row[4] ?>,'<? echo $row[1]; ?>')">
  </p>
 </form>

 </td> </tr> </table>


<br>
    <?
       }
    ?>
    </center>  
  </div>
</center>  

<form name="form1">
 <input type="hidden" name="dedonde" value=1>
 <input type="hidden" name="Resp" value=1>
 <input type="hidden" name="Id">
 <input type="hidden" name="Tipo_Material">

</form>
<?
  }
?>

  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank">
          <img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a></div></td>
          <td width="50"><div align="center" class="style11">adm-002</div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
   <!-- El menu lo pongo manualmente en esa posicion porque la página no fue hecha por Gisele, y por lo tanto
    no tiene la misma estructura q todas las anteriores. Gonzalo.-->
    <div style="position:absolute;top:48;left:630;width:150">
       <div align="center" class="style11">
           <? dibujar_menu_usuarios($Usuario,1); ?>
       </div>
    </div>



<?
   mysql_free_result($result);
   Desconectar();
?>
</body>












