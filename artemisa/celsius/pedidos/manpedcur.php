<? 
include_once "../inc/var.inc.php";
include_once "../inc/"."parametros.inc.php";
if (!isset( $Id_Entrega)){ $Id_Entrega=0;}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><? echo Titulo_Sitio();?></title>
<link href="../celsius.css" rel="stylesheet" type="text/css">
<?

 include_once "../inc/"."conexion.inc.php";
 Conexion();

 include_once "../inc/"."identif.php";
 Usuario();

?>
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
<base target="_self">
</head>

<body topmargin="0">
<?
  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."fgentrad.php";
  include_once "../inc/"."tabla_ped_unnoba.inc";
  global $IdiomaSitio;
  $Mensajes = Comienzo ("cur-001",$IdiomaSitio);
  $MensajesTabla = Comienzo("adm-002",$IdiomaSitio); //levanto los mensajes de las tablas
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
?>
<script language="JavaScript">
 function Confirma_Pedido(Id)
{
   document.forms.form1.action="opera_ped.php";
   document.forms.form1.Resp.value=1;
   document.forms.form1.Id.value = Id;
   document.forms.form1.submit();
 }
 function Cancela_Pedido(Id)
{
   document.forms.form1.action="opera_ped.php";
   document.forms.form1.Resp.value=0;
   document.forms.form1.Id.value= Id;
   document.forms.form1.submit();
 }

 function rutear_pedidos (TipoPed,Id,Alias_Id)
 {
  switch (TipoPed)
  {
  case 1: 
      ventana=window.open("verped_col.php?Alias_Id="+Alias_Id+"&Id="+Id+"&dedonde=1&Tabla=1","Colecciones","scrollbars=yes,width=550,height=450");
	  break;
  case 2:
      ventana=window.open("verped_cap.php?Alias_Id="+Alias_Id+"&Id="+Id+"&dedonde=1&Tabla=1","Libros","scrollbars=yes,width=550,height=450");
      break;
  case 3:
      ventana=window.open("verped_pat.php?Alias_Id="+Alias_Id+"&Id="+Id+"&dedonde=1&Tabla=1","Patentes","scrollbars=yes,width=550,height=450");
      break;
  case 4:
      ventana=window.open("verped_tes.php?Alias_Id="+Alias_Id+"&Id="+Id+"&dedonde=1&Tabla=1","Tesis","scrollbars=yes,width=550,height=450");
      break;
  case 5:
      ventana=window.open("verped_con.php?Alias_Id="+Alias_Id+"&Id="+Id+"&dedonde=1&Tabla=1","Congresos","scrollbars=yes,width=550,height=450");
      break;
  }
return null

 }
</script>

<div align="left">
  <table width="770" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
  	     <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
           <?

    if ($Bibliotecario>=1)
 {
 ?>
	
	  <tr>
	  <td>
	   <form name="form2" action="manpedcur.php">
  <table border="0" width="75%" height="4" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="0" align="center">
    <tr>
      <td width="40%" height="1" align="center">
        <p align="right"><b>&nbsp;&nbsp;&nbsp;
        </b>
      </td>
      <td width="108%" height="1" align="center" colspan="3">
        &nbsp;
      </td>
    </tr>
  <center>
    <tr>
      <td width="40%" height="1" align="center" class="style52" >
        <? echo $MensajesTabla["tc-3"]; ?>
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
		   if ($dedonde==0)
   		   {
     			$expresion = $expresion."WHERE (Pedidos.Estado<=3 OR Pedidos.Estado=5)";
				
    	   }
   		   else
   		   {
     			$expresion = $expresion."WHERE (Pedidos.Estado=6 OR Pedidos.Estado = ".Devolver_Estado_SolicitarPDF().")";
			}  
			
			// Con la modificación del 25-4 solo ve los pedidos
			// creados por el
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
        
        <p align="left"><font face="MS Sans Serif" size="1" color="#FFFFCC"><input type="submit" value="<? echo $MensajesTabla["bot-1"]; ?>" name="B1" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold"></font></p>
        
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
	  </td>
	  </tr>
	  <?
 }?>
	  <tr bgcolor="#EFEFEF">
        <td valign="top" width="75%" bgcolor="#E4E4E4">
            <div align="center">
              <center>
                <table width="93%" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td bgcolor="#E4E4E4">
                <table  border="0">
                 <!-- <tr>
                    <td width="500" colspan=2 height="20" bgcolor="#cecece" class="style23"> <center> <? echo $Mensajes['txt-1']; ?> </center> </td>
                  </tr> -->
                  <tr>
                    <td class="style23">
                        <div align="left">
                        <?
                         
						  if (($Bibliotecario>=1 && $Id_Entrega!=0)||($Bibliotecario==0))
                         {

                           $expresion = armar_expresion_busqueda();

                          if ($Bibliotecario>=1)
                            {
                    		// Si es bibliotecario solo va a ver lo creado por el mismo
                    	 	$Id_us = $Id_Entrega;
                    		$expresion = $expresion."LEFT JOIN Usuarios AS Bibliotecario ON ".$Id_usuario."=Bibliotecario.Id ";
							
							$completa=" AND Pedidos.Tipo_Usuario_Crea=2 ";
                            						
							
						   }
                              else
                                 {
                                 	 	$Id_us = $Id_usuario;
                                 		$completa="";
                                    }

                            if ($dedonde==0)
                             {
                          $expresion = $expresion."WHERE (Pedidos.Estado<=3 OR Pedidos.Estado=5) AND Pedidos.Codigo_Usuario=".$Id_us;
                               }
                            else
                            {
                          $expresion = $expresion."WHERE (Pedidos.Estado=6 OR Pedidos.Estado = ".Devolver_Estado_SolicitarPDF().") AND Pedidos.Codigo_Usuario=".$Id_us;
                          }

                    if ($Bibliotecario>=1)
                      {
                       $expresion1=$expresion;
					   $expresion1.=$completa."and Bibliotecario.bibliotecario_permite_download =1 ORDER BY Pedidos.Fecha_Alta_Pedido";
                       $expresion.=$completa." ORDER BY Pedidos.Fecha_Alta_Pedido";
					   $result = mysql_query($expresion);
                       $result1 = mysql_query($expresion1);
					   if (mysql_num_rows($result1)>0)
						  {
					       $adm=2;
					      }
						  else 
						  {
						   $adm=3;
						  }
					  }
                      else
					  {
                       $expresion.=$completa." ORDER BY Pedidos.Fecha_Alta_Pedido";
                      // echo $expresion;
                       $result = mysql_query($expresion);
					  }
                   echo mysql_error();
                ?>

                              </div>
                              </td>
                            </tr>
                           <tr bgcolor="#006599" class="style38">
                              <td class="style23 style39" width="30%">
                                <div align="center" class="style28" ><? echo $Mensajes['txt-1'].' '.$Mensajes['txt-2']; ?></div></td>
                              <td class="style23" width="20%">
                                <div align="right" class="style38 style28">
                                  <div align="center" class="style38"><? echo $Mensajes['txt-3']." ".mysql_num_rows($result)?></div>
                              </div></td>
                            </tr>
                            <tr> <td class="style23" align="center" colspan=2> <center>
                              <?
                               while($row = mysql_fetch_row($result))
                                  {//echo $adm;
                                   if (!isset($adm))
									  {$adm = 1;}
                           		  //echo "<div bgcolor='#E4E4E4'>";

                                   Dibujar_Tabla_Comp_Cur ($VectorIdioma,$row,$MensajesTabla,$adm);

                                    ?>
                                    <tr> <td align='center'>
                                <form name="form3">
                                  <p align="center">&nbsp;
                                 <input type="button" value="<? echo $Mensajes["bot-2"]; ?>" name="Revisa" class="style23" OnClick="rutear_pedidos(<? echo $row[4] ?>,'<? echo $row[1]; ?>','<? echo $Id_us; ?>')">
                                  </p>
                                </form>

                                  <?
                                  echo "</td> </tr> </table> <br>";

                                  }
                                 ?>

                            </center>
							</td>
                                						  <?
 
 
 
 mysql_free_result($result);
   Desconectar(); 
 }
  
?>
							</tr>
                          
						  </table>
  
                        </div>                        
                        </td></tr>
                </table>                  

			</td>
	         <td width="200" valign="top" bgcolor="#E4E4E4">
                <div align="center" class="style11"> 
				<?  								
							dibujar_menu_usuarios($Usuario,1); ?></div>
          </table>
          </div>
          </td>
              </tr>
         
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
              </center>
            </div>            </td>
        
        </tr>

      </div>    </td>
			
  </tr>


 </center>
</table>
</div>

<br> <br>
</body>
</html>
