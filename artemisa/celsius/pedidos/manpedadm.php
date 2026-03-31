 <? 
 include_once "../inc/var.inc.php";
 include_once "../inc/"."conexion.inc.php";  
 Conexion();
 include_once "../inc/"."identif.php";
 include_once "../inc/"."sesion.inc";
 Administracion();
if (!isset($Alias_Id)){$Alias_Id='';}


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
	font-size: 11px;
}
.style33 {
	font-family: verdana;
	font-size: 11px;
	color: #006699;
}
.style34 {
	color: #FFFFFF;
	font-weight: normal;
	font-family: Verdana;
	font-size: 11px;
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
 if ($Modo==1){$operador=0;}
 if ($Modo==4){$operador=0;}
 if (!isset($operador)){ $operador=SesionToma("Id_usuario");}

?>
<script language="JavaScript">
 function Seteo_Modo()
 {
    document.forms.form2.action="manpedadm.php";   
    document.forms.form2.submit();
 }
 function genera_evento(Id,Estado,Mail,Nombre,Rol,IdCreador)
  {  //ventana=window.open("gen_evento.php?Id="+Id+"&usuario=<? echo $Id_usuario; ?>&Modo=<? echo $Modo;?>&Estado="+Estado+"&Mail="+Mail+"&Nombre="+Nombre+"&RolCreador="+Rol+"&IdCreador="+IdCreador,"prueba","");
  ventana=window.open("gen_evento.php?Id="+Id+"&usuario=<? echo $Id_usuario; ?>&Modo=<? echo $Modo;?>&Estado="+Estado+"&Mail="+Mail+"&Nombre="+Nombre+"&RolCreador="+Rol+"&IdCreador="+IdCreador, "Eventos", "dependent=yes,toolbar=no,width=550,height=450,top=5,left=20");
 }  
 function rutear_pedidos (TipoPed,Id,Alias_Id)
 {
  switch (TipoPed)
  {
    case 1:
      ventana=open("verped_col.php?Alias_Id="+Alias_Id+"&Id="+Id+"&dedonde=2&Tabla=1","1","scrollbars=yes,width=700,height=450,alwaysLowered");   
      break;
    case 2:
      ventana=open("verped_cap.php?Alias_Id="+Alias_Id+"&Id="+Id+"&dedonde=2&Tabla=1","1","scrollbars=yes,width=700,height=450,alwaysLowered");
      break;
    case 3:           
      ventana=open("verped_pat.php?Alias_Id="+Alias_Id+"&Id="+Id+"&dedonde=2&Tabla=1","1","scrollbars=yes,width=700,height=450,alwaysRaised");
      break;	
    case 4:           
      ventana=open("verped_tes.php?Alias_Id="+Alias_Id+"&Id="+Id+"&dedonde=2&Tabla=1","1","scrollbars=yes,width=700,height=450,alwaysRaised");
      break;	
    case 5:           
      ventana=open("verped_con.php?Alias_Id="+Alias_Id+"&Id="+Id+"&dedonde=2&Tabla=1","1","scrollbars=yes,width=700,height=450,alwaysRaised");
      break;	
   }
	    
	 return null	
	
 }
 
 function busquedas(Id,Estado,Mail,Nombre,Rol,IdCreador)
{
   ventana=window.open("pres_busq.php?Id_Pedido="+Id+"&usuario=<? echo $Id_usuario; ?>&Modo=<? echo $Modo;?>&Estado="+Estado+"&Mail="+Mail+"&Nombre="+Nombre+"&RolCreador="+Rol+"&IdCreador="+IdCreador, "Eventos","scrollbars=yes,dependent=yes,toolbar=no,width=700, height=450");
   
 }  

</script>
<?   
  
   $expresion = "SELECT DISTINCT Clientes.Id,Clientes.Apellido,Clientes.Nombres ";
   $expresion = $expresion."FROM Pedidos LEFT JOIN Usuarios AS Clientes ON Codigo_Usuario = Clientes.Id ";
   if (isset($Modo))
     $expresion = $expresion."WHERE Pedidos.Estado=".$Modo;
   else  {
     $expresion = $expresion."WHERE Pedidos.Estado= 9"; //parche HORRIBLEEEE; ENCONTRAR SOLUCION
	 $Modo = 0;
   }
   
   $expresion = $expresion." ORDER BY Apellido,Nombres";
 	$result = mysql_query($expresion);

		echo mysql_error();
?>	

<div align="left">
<form name="form2">
<table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse"><!-- Primer Table -->
 <tr>
  <td bgcolor="#E4E4E4">
   <hr color="#E4E4E4" size="1">
   <div align="center">
   <center>
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5"> <!-- Segunda Table -->
      <tr>
        <td valign="top">
		  <div align="center">
          <center>
            <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
              <tr bgcolor="#006699">  <!-- Tercer Table -->
                <td height="20" class="style33"><span class="style34"><img src="../images/square-w.gif" width="8" height="8"></span>
				</td>
              </tr>
              <tr align="left" valign="middle">
                <td class="style22"><div align="center" class="style33">
                    <table width="90%"  border="0" align="center" cellpadding="1" cellspacing="1" class="style22"> <!-- Cuarta Table -->
                      <tr>
                       <td width="120" class="style22"><div align="right"><? echo $Mensajes["tf-1"]; ?></div>
					   </td>
                       <td colspan="2" class="style33"><? echo $Usuario; ?>
					   </td>
                      </tr>
                      <tr>
                       <td width="120" class="style22"><div align="right"><? echo $Mensajes["tf-2"]; ?></div>
					   </td>
                       <td width="160">
						  <select size="1" name="Modo" class="style22" OnChange="javascript:form2.User.length=0">
                           <? echo Opciones_select($Modo,$VectorIdioma); ?>
                          </select>
			  		   </td>
                       <td>
					     <select size="1" name="User" class="style22">
                          <?
                     		if (!isset($User)) {$User = 0; }
                            while($row = mysql_fetch_row($result))
                             {
                          ?> 
                            <option <? if ($User==$row[0]) { echo " selected "; } ?> value=<? echo $row[0]; ?>><? echo $row[1].",".$row[2]; ?></option>
                              <? } ?>
                             <option  <? if ($User==0) { echo " selected "; } ?> value=0><? echo $Mensajes["opc-1"]; ?></option>
                         </select>
                       </td>
                      </tr>
					  <? 
					  $expresion1 = "SELECT Usuarios.Id,Usuarios.Apellido,Usuarios.Nombres ";
                      $expresion1 = $expresion1."FROM Usuarios where Staff=1";
                      $expresion1 = $expresion1." ORDER BY Apellido,Nombres";
                      //echo $expresion1;
					  $result1 = mysql_query($expresion1); ?>
					  <tr><td width="120" class="style22"><div align="right">Operador</div>
					   </td><td> <div align="left"><select size="1" name="operador" class="style22">
                         <?
						  while($row1 = mysql_fetch_row($result1))
                             {
                          ?> 
                            <option <? if ($operador==$row1[0]) { echo " selected "; } ?> value=<? echo $row1[0]; ?>><? echo $row1[1].", ".$row1[2]; ?></option>
                              <? } ?>
                             <option  <? if ($operador==0) { echo " selected "; } ?> value=0><? echo $Mensajes["opc-1"]; ?></option>
                         </select></div></td><tr>
                      <tr>
                       <td width="120" class="style22"><div align="right"></div></td>
                       <td width="160">
                         <div align="left">
                          <input type="button" value="<? echo $Mensajes["bot-1"]; ?>" name="B1" class="style22" OnClick="Seteo_Modo()">
                       </div></td>
                       <td><input type="radio" class="style22" value="1" name="Lista" <? If (!isset($Lista)) {$Lista="";} If ($Lista==1) { echo " checked"; }?>><? echo $Mensajes["tf-3"]; ?>
                       <input type="radio" name="Lista" class="style22" value="2" <? If (!isset($Lista)) {$Lista="";} If ($Lista==2 || $Lista=="") { echo " checked";}?>><? echo $Mensajes["tf-4"]; ?></td>
                        </tr>
                      </table>  <!--Cierre de la Cuarta Tabla -->
                      </div>                      
				  </td>
                </tr>
           </table>  <!-- Cierre de la Tercer Table -->
				</form>
                <hr>
               <?
   $expresion = armar_expresion_busqueda();
   if ($Modo)
     $expresion = $expresion."WHERE Pedidos.Estado=".$Modo;
   else  
     $expresion = $expresion."WHERE Pedidos.Estado=9";
   
   if ($User!=0)
   {
     $expresion=$expresion." AND Clientes.Id=".$User;
   }
   if ($operador!=0)
     {
       $expresion=$expresion." AND Operador_Corriente=".$operador;
     }
   
   If (!isset($Lista)) {$Lista="";} If ($Lista==1)
   {
     $expresion = $expresion." ORDER BY Fecha_Solicitado,PaisSol.Id,InstSol.Codigo,DepSol.Id,Pedidos.Id";

   }
   else
   {
     $expresion = $expresion." ORDER BY Fecha_Alta_Pedido,Pedidos.Id";
   }  
  // echo $expresion;
   $result = mysql_query($expresion);
   echo mysql_error();
   
 If (!isset($Lista)) {$Lista="";} If ($Lista==2 || $Lista=="")
   {
 ?>  

	<div align="left">
    <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#0099CC">
    <tr>
     <td height="20" class="style22"><img src="../images/square-w.gif" width="8" height="8">
     <? echo Devolver_Estado ($VectorIdioma,$Modo,1); ?>

	 <span class="style35"><? echo mysql_num_rows($result); ?></span></td>
                    </tr>
                  </table>
				  </div>
<? } else { ?>

<div align="left">
    <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#0099CC">
    <tr>
     <td height="20" class="style22"><img src="../images/square-w.gif" width="8" height="8">
     <? echo Devolver_Estado ($VectorIdioma,$Modo,1); ?>

	 <span class="style35"><? echo mysql_num_rows($result); ?></span></td>
                    </tr>
                  </table>
				  </div>
<?
   }
 
  
    while($row = mysql_fetch_row($result))
     {
   ?>    


 <? If (!isset($Lista)) {$Lista="";} If ($Lista==2 || $Lista =="")
 {    
	  Dibujar_Tabla_Comp_Cur($VectorIdioma,$row,$Mensajes,'1');
	  if ($Modo==1)
	  {
	    echo mostrarIntersecion($row);	
	  }
 	  
	   echo devolverBusqueda($row[1],$Mensajes);
	  
?>
 <tr> <td align='center'>
<form name="form3" method="POST"> 
  <p align="center">
  <input type="button" value="<? echo $Mensajes["bot-2"]; ?>" name="B3" class="style22" OnClick="rutear_pedidos(<? echo $row[4]; ?>,'<? echo $row[1]; ?>','<? echo $row[50]; ?>')">
  <input type="button" value="<? echo $Mensajes["bot-3"]; ?>" name="B1" class="style22" OnClick="genera_evento('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'<? echo $row[46]; ?>','<? echo $row[2].",".$row[3]; ?>',<? echo $row[48];?>,<? echo $row[49];?>)"> 
  <? if (estado_busqueda($row[36]))
  {?>
  <input type="button" value="<? echo $Mensajes["bot-7"]; ?>" name="B1" class="style22" OnClick="busquedas('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'<? echo $row[46]; ?>','<? echo $row[2].",".$row[3]; ?>',<? echo $row[48];?>,<? echo $row[49];?>)"> 
  <?}?>
  </p>
  <input type="hidden" name="Modo">
  <input type="hidden" name="Lista">
 </form>
 
 <? echo "</td> </tr> </table> <br>";
 } 
   else
   {
     Dibujar_Tabla_Abrev_Cur ($VectorIdioma,$row,$Mensajes);
 //echo "dd";
 
 ?> 
    <!--<tr> <td align='center'>-->
   <form name="form4" method="POST">  
   <td width="5%" height="17" align="left">
   <input type="button" value="P" name="B3"  OnClick="rutear_pedidos(<? echo $row[4]; ?>,'<? echo $row[1]; ?>','<? echo $row[50]; ?>')">
   </td>
   <td width="5%" height="17" align="left">
   <input type="button" value="E" name="B1"  OnClick="genera_evento('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'<? echo $row[46]; ?>','<? echo $row[2].",".$row[3]; ?>',<? echo $row[48];?>,<? echo $row[49];?>)">
   </td>
   <td width="5%" height="17" align="left">
   <? if (estado_busqueda($row[36]))
   {?>
   <input type="button" value="B" name="B1"  OnClick="busquedas('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'<? echo $row[46]; ?>','<? echo $row[2].",".$row[3]; ?>',<? echo $row[48];?>,<? echo $row[49];?>)"> 
    <br>
   <?} else { echo "&nbsp;"; } ?>
   </td>
   </form></tr>
    <br>
   </table>

  </form>
  
   <? } 

  }
    ?>
<?
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