<? 
 
include_once "../inc/var.inc.php";
include_once "../inc/"."conexion.inc.php";
Conexion();
include_once "../inc/"."identif.php";
Usuario();
if (! isset($dedonde))	$dedonde=0;
if (! isset($Id_Usuario))	$Id_Usuario=0;


?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><? echo Titulo_Sitio();?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../celsius.css" rel="stylesheet" type="text/css">
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
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 11px; }
.style28 {color: #FFFFFF}
.style30 {color: #FFFFFF; font-size: 11px; font-family: verdana; }
.style31 {
	color: #000000;
	font-family: Verdana;
	font-size: 11px;
}
.style35 {color: #FFFFFF}

.style34 {color: #006699; font-family: Verdana; font-size: 11px; }
.style41 {color: #666666}
.style23 {
	color: #000000;
	font-size: 11px;
	font-family: verdana;
}
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<? 
  include_once "../inc/fgenped.php";
  include_once "../inc/fgentrad.php";
  include_once "../inc/tabla_ped_unnoba.inc" ;
  
  	if (! isset($IdiomaSitio))
		{ $IdiomaSitio = 1;}
   global $Rol;
   $Mensajes = Comienzo ("adm-002",$IdiomaSitio);
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
   
   if (!isset($Usuario_C ))		$Usuario_C = "";
   $Modo=14;
   
   $expresion = "SELECT Apellido,Nombres,EMail,Codigo_Pais,Codigo_Institucion,Codigo_Dependencia";
   $expresion = $expresion.",Direccion,Codigo_Categoria,Telefonos,Codigo_Unidad,Codigo_Localidad,Login,Password,Comentarios,";
   $expresion = $expresion."Codigo_FormaPago,Personal,Bibliotecario,Staff,Orden_Staff,Cargo ";
   $expresion = $expresion."FROM Usuarios WHERE Usuarios.Id =".$Id_usuario;
   $result = mysql_query($expresion);
   echo mysql_error();
   $rowg = mysql_fetch_row($result);


?>

<script language="JavaScript">
 function Seteo_Modo()
 {
    document.forms.form2.action="manpedcoltl.php";   
    document.forms.form2.submit();
   
     
 }
 
 function genera_evento(Id,Estado,Mail,Nombre,Rol,IdCreador)
{
   ventana=window.open("gen_evento.php?Id="+Id+"&usuario=<? echo $Id_usuario; ?>&Modo=<? echo $Modo;?>&Estado="+Estado+"&Mail="+Mail+"&Nombre="+Nombre+"&RolCreador="+Rol+"&IdCreador="+IdCreador, "Eventos", "dependent=yes,toolbar=no,width=530 height=380");
   
 }  

 function rutear_pedidos (TipoPed,Id)
 {

     <?
     	if ($dedonde==1)
     	{
     		$cons = 1;
     	}
     	else
     	{
     		$cons = 2;
     	}
     ?>
     switch (TipoPed)
	  {
	    case 1:
	      ventana=open("verped_col.php?Id="+Id+"&dedonde=<? echo $cons; ?>&Tabla=1","1","scrollbars=yes,width=700,height=450,alwaysLowered");   
	      break;
	    case 2:
	      ventana=open("verped_cap.php?Id="+Id+"&dedonde=<? echo $cons; ?>&Tabla=1","1","scrollbars=yes,width=700,height=450,alwaysLowered");
	      break;
	    case 3:           
          ventana=open("verped_pat.php?Id="+Id+"&dedonde=<? echo $cons; ?>&Tabla=1","1","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
       case 4:           
          ventana=open("verped_tes.php?Id="+Id+"&dedonde=<? echo $cons; ?>&Tabla=1","1","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
       case 5:           
          ventana=open("verped_con.php?Id="+Id+"&dedonde=<? echo $cons; ?>&Tabla=1","1","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;	
                
	  }
	    
	 return null	
	
 }
</script>
<div align="left">

  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#E4E4E4" style="border-collapse: collapse"><!-- tabla 1 -->
  <tr>
    <td bgcolor="#E4E4E4" valign="top">
      <hr color="#E4E4E4" size="1">
      <div align="center" bgcolor="#E4E4E4">
        <center>
      <table width="600" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5"><!-- tabla 2 -->
      <tr>
        <td valign="top"> <div align="center">
              <center>
			  <!-- las siguientes tablas son las que contiene el form de los datos -->
                <table width="100%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC"><!-- tabla 3 -->
                  <tr bgcolor="#006699">
                    <td height="20" class="style33"><span class="style34"><img src="../images/square-w.gif" width="8" height="8"></span></td>
                    </tr>
                  <tr align="left" valign="middle">
                    <td class="style22"><div align="center" class="style33">
						
					  <form name="form2">
                      <table width="100%"  border="0" align="center" cellpadding="1" cellspacing="1" class="style22"><!-- tabla 4 -->

                        <tr>
                          
						  <td width="180" class="style22"><div align="right"><? echo $Mensajes["tc-9"]; ?></div></td>
                          
						  <td colspan="2" class="style33"><div align="left"><INPUT TYPE="text" class="style33" NAME="Texto" SIZE="27" value="<? if (isset($Texto)) echo $Texto; ?>"></div></td>

                        </tr>
                        <tr>
                          
						  <td width="120" class="style22"><div align="right"></div></td>

                          <td class="style22" colspan="2">
						  <!--<input type="radio" value="1" name="Lista" <? if  (  (isset($Lista) ) && ($Lista==1)) { echo " checked"; }?>><? echo $Mensajes["tf-3"]; ?>
						  <input type="radio" name="Lista" value="2" <? if ((! isset($Lista)  ) || $Lista==2  ) { echo " checked";}?>><? echo $Mensajes["tf-4"]; ?>-->
						  </td>

                        </tr>
                        <tr>
                          <td width="120" class="style22"><div align="right"></div></td>
                          <td width="160">
                            <div align="left"><input type="button" value="<? echo $Mensajes["bot-1"]; ?>" name="B1"  class="style22" OnClick="Seteo_Modo()">
							 </div></td>
                           <? if ($dedonde!=1)
						  { ?>	<!-- if 11 -->
						  <td class="style22"><a href="../admin/elige_usuario.php?Letra=A&dedonde=3"><? echo $Mensajes["h-2"]; ?></a></td>
					  <? }  
						else
						{
						?>
						  <td class="style22">&nbsp;</td>
                        <?
						}
						?>
						</tr>
                      </table> <!-- end tabla 4 -->


				    <input type="hidden" name="Id_Usuario" value="<? echo $Id_Usuario; ?>">
					<input type="hidden" name="Usuario_C" value="<? echo $Usuario_C; ?>">
					<input type="hidden" name="Modo" value=<? echo $Modo; ?>>
					<input type="hidden" name="dedonde" value=<? echo $dedonde; ?>>
				   </form></div>			   		   
				   </td>                 
				 </tr>				 
				</table><!-- end table 3 -->
			
   <hr>
<? if (isset($Texto) && ($Texto!=""))
   { ?>  
<br>
	<?
   
   $expresion = armar_expresion_busqueda();
   if ($Bibliotecario>=1)
   {
   	$expresion.="LEFT JOIN Usuarios AS Biblio ON Pedidos.Codigo_Usuario=Biblio.Id "; 
   }
   /*
	 $dedonde = 1 quiere decir que el llamador fue un usuario comun. Sino, es un administrador.

	 $Bibliotecario >=1 dice que tipo de bibliotecario es. Los bibliotecarios, dependiendo del tipo que sean, tienen diferentes visiones (de la universidad, de la facultad, del laboratorio,...)

   */

   $expresion .= "WHERE Titulo_Revista LIKE '%".$Texto."%' ";
   echo $dedonde;
   echo $Bibliotecario;
   if ($dedonde==1 && $Bibliotecario>=1)
   {		// if 8
   	   switch ($Bibliotecario)
    	{	//swicth 1
		 case 1:
			$expresion.=" AND Biblio.Codigo_Institucion=".$Instit_usuario;
			break;
		 case 2:
			$expresion.=" AND Biblio.Codigo_Dependencia=".$Dependencia;
			break;
		 case 3:
			$expresion.=" AND Biblio.Codigo_Unidad=".$Unidad;
			break;
	  }	//end swicth 1
   }  //en if 8
   elseif ($dedonde==1) //if 9
   {
   	 $expresion .= " AND Codigo_Usuario=".$Id_Usuario;
   } //end if 9
   $expresion = $expresion." ORDER BY Titulo_Revista";
 // echo $expresion;
   $result = mysql_query($expresion);
   echo mysql_error();
   
 //If (!isset($Lista)) {$Lista="";} If ($Lista==2 || $Lista=="")
   //  { // if 1  // Todo esto modificado por ARiel
 ?>  
		<div align="left"><table width="95%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#0099CC"><tr><td height="20" class="style22"><img src="../images/square-w.gif" width="8" height="8"><?echo $Mensajes["et-9"];?><span class="style35"><? echo mysql_num_rows($result);?> </span></td></tr></table></div>
   <? //}  // del if 1
	//else
	 // { ?>
                 
      <!--  <div align="left"><table width="95%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#0099CC"><tr><td height="20" class="style22"><img src="../images/square-w.gif" width="8" height="8"><?echo $Mensajes["et-9"]; ?><span class="style35"><? echo mysql_num_rows($result); ?></span></td></tr></table></div>--><?
//     } // else del if 1
 
  
    while($row = mysql_fetch_row($result))
     {		//while 1
	 ?>  
		 <center>

		 <? // If (!isset($Lista)) {$Lista="";} If ($Lista==2 || $Lista =="")
		 //{		//if 10
			  Dibujar_Tabla_Comp_Cur_Pedidos ($VectorIdioma,$row,$Mensajes); ?>

			<form name="form3" method="POST">	
				  <p align="center">
				  <input type="button" value="<? echo $Mensajes["bot-2"]; ?>" name="B3" class="style22"  OnClick="rutear_pedidos(<? echo $row[4]; ?>,'<? echo $row[1]; ?>')">
					 <? if ($dedonde!=1)
						  { ?>	<!-- if 11 -->
							  <input type="button" value="<? echo $Mensajes["bot-3"]; ?>" name="B1" class="style22" OnClick="genera_evento('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'<? echo $row[46]; ?>','<? echo $row[2].",".$row[3]; ?>',<? echo $row[48];?>,<? echo $row[49];?>)">
					  <? }  ?><!-- end if 11 -->
					</p>
					<input type="hidden" name="Modo">
					<input type="hidden" name="Lista">
		   </form>
			<br>
		<?// } //end if 10
		//else
		//{
		//	Dibujar_Tabla_Abrev_Cur ($VectorIdioma,$row,$Mensajes); ?>
		  <!-- <form name="form4" method="POST">  
			   <td width="7%" height="17" align="left">
			   <input type="button" value="P" name="B3" class="style22" OnClick="rutear_pedidos(<? echo $row[4]; ?>,'<? echo $row[1]; ?>')">-->
			   <? //if ($dedonde!=1)
			   //{ ?> <!-- if 12 -->
			   <!--<input type="button" value="E" name="B1" class="style22" OnClick="genera_evento('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'<? echo $row[46]; ?>','<? echo $row[2].",".$row[3]; ?>',<? echo $row[48];?>,<? echo $row[49];?>)">-->
			   <? //} ?> <!-- end if 12 -->
			  <!-- </td>
		  </form>
		</center>-->

	<? //} // end del else del if 10
  } // Del while 1 

   mysql_free_result($result);  
   
   }//del if si el texto esta seteado
   Desconectar();
   
	?>     	
		</td></tr>
		</table><!-- end de tabla 2 -->
		<br>
        </center></div></td>
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
                    <a href="../admin/indexadm.php"><? echo $Mensajes["cf-13"]; ?></a></span></p>
                  </div>                  </td>
          </div></td>
		  <?
		  }	  
		  ?>
		<!-- <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td valign="top" class="style28"><div align="center"><img src="../images/image001.jpg" width="150" height="118"><br>
                  <span class="style60"><a href="../admin/indexadm.php"><?echo $Mensajes["h-1"];?> </a></span></div>                <div align="center" class="style55"></div></td>
            </tr>
          </table>
          </div>
          </td>-->
		  <!-- 
		<td width="*" valign='top'  bgcolor="#E4E4E4"><br><div align="center" class="style11">d<? dibujar_menu_usuarios($rowg[0].', '.$rowg[1],1); ?></div></td> -->
		<!-- 
        <td width="*" valign="top" bgcolor="#E4E4E4"><div align="center" class="style22" >
          <div align="left">
            <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td><div align="center">
                  <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td bgcolor="#ECECEC"><div align="center">
                          <p><img src="../images/image001.jpg" width="150" height="118"><br>
                              <span class="style33"><a href="../admin/indexadm.php"> Volver a administraci&oacute;n</a></span></p>
                      </div></td>
                    </tr>
                  </table>
                  </div></td>
              </tr>
            </table>
        </div></td>

		 -->
        </tr>    

  <tr>
    <td height="44" bgcolor="#E4E4E4" colspan=2><div align="center">      
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" height="43" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50"><div align="right" class="style33">
            <div align="center">rus</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>