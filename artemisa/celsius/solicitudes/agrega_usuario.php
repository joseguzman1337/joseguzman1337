<?
   include_once "../inc/var.inc.php";
   include_once "../inc/"."conexion.inc.php";  
   Conexion();	
   include_once "../inc/"."identif.php"; 
   include_once "../inc/"."fgentrad.php";
    include_once "../inc/"."fgenhist.php";  
   Administracion();
   global $IdiomaSitio;
   $Mensajes = Comienzo ("mso-001",$IdiomaSitio);
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
   
 ?>
<html>

<head>
<title>PrEBi</title>
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
.style55 {
	font-size: 10px;
	color: #000000;
	font-family: Verdana;
}
.style60 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
.style1 {	color: #FFFFFF;
	font-family: Verdana;
	font-size: 10px;
}
.style61 {color: #000000}
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
.style22 {
	color: #333333;
	font-family: verdana;
	font-size: 9px;
}
.style45 {
	font-family: Verdana;
	color: #FFFFFF;
	font-size: 10px;
}
-->
</style>
</head>


<base target="_self"> 

</head>
<body >
<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5" bgcolor="#EFEFEF" >
      <tr bgcolor="#EFEFEF">
        <td valign="top" bgcolor="#E4E4E4">
            <div align="center">
              <center>
                <table width="97%" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
<?
if ($Operacion==0)
{ 

   $MensajePais = "0 ".$Mensajes["tf-1"];
   $MensajeLocalidad = "0 ".$Mensajes["tf-2"];
   $MensajeInstitucion = "0 ".$Mensajes["tf-3"];
   $MensajeDependencia = "0 ".$Mensajes["tf-4"];
   $MensajeUnidad = "0 ".$Mensajes["tf-5"];
   $MensajeCategoria = "0 ".$Mensajes["tf-6"];
   $MensajeUsuario = "0 ".$Mensajes["tf-7"];
   $traba = 0;
   
   
   if (strlen($OtroPais)>0)
   {
		   $Instruccion = "INSERT INTO Paises (Nombre,Abreviatura) VALUES('".$OtroPais."','".$AbrPais."')";	
		   $result = mysql_query($Instruccion); 
		   
		   // Tiene que haber llegado con 0 es decir Otro
		   
		   $CodigoPais =mysql_insert_id();                
				   if ($CodigoPais!=0)
				   {
					$MensajePais = "1 ".$Mensajes["tf-1"].": ".$OtroPais;	
				   }
				   else
				   {
						$traba = 1;
						$MensajePais = $Mensajes["me-1"];       	
				   }
   }
   else
   {
			$Instruccion = "SELECT Abreviatura FROM Paises WHERE Id=$CodigoPais";
			$result = mysql_query($Instruccion); 
			$xrow = mysql_fetch_row($result);
			if ($xrow[0]=="")
			{
				$Instruccion = "UPDATE Paises SET Abreviatura='$AbrPais' WHERE Id=$CodigoPais";
				$result = mysql_query($Instruccion); 
			}
       
   }
   
   if (strlen($OtraLocalidad)>0 && $traba==0)
   {   
		   $Instruccion = "INSERT INTO Localidades (Nombre,Codigo_Pais) VALUES('".$OtraLocalidad."','".$CodigoPais."')";	
		   $result = mysql_query($Instruccion); 
		   $CodigoLocalidad =mysql_insert_id();  
		   if ($CodigoLocalidad!=0)
					   {
						$MensajeLocalidad = "1 ".$Mensajes["tf-2"].": ".$OtraLocalidad;	
					   }
					   else
					   {
							$traba = 1;
							$MensajeLocalidad = $Mensajes["me-2"];       	
					   }

   }
   
   if (strlen($OtraInstitucion)>0 && $traba==0)
   {   
			$Instruccion = "INSERT INTO Instituciones (Nombre,Codigo_Pais,Codigo_Localidad,Direccion,Telefono,Participa_Proyecto,Figura_Portal,Figura_Home,Orden_Portal,Sitio_Web,Comentarios,Abreviatura,Codigo_Pedidos) VALUES('".$OtraInstitucion."','".$CodigoPais."','".$CodigoLocalidad."','','',0,0,0,0,'','','".$AbrInstit."',1)";	
		   $result = mysql_query($Instruccion); 
		   $CodigoInstitucion =mysql_insert_id();
		   if ($CodigoInstitucion!=0)
					   {
						$MensajeInstitucion = "1 ".$Mensajes["tf-3"].": ".$OtraInstitucion;	
					   }
					   else
					   {
							$traba = 1;
							$MensajeInstitucion = $Mensajes["me-3"];       	
					   }

   }
    else
   {
			$Instruccion = "SELECT Abreviatura FROM Instituciones WHERE Codigo=$CodigoInstitucion";
			$result = mysql_query($Instruccion); 
			$xrow = mysql_fetch_row($result);
			if ($xrow[0]=="")
				{
					$Instruccion = "UPDATE Instituciones SET Abreviatura='$AbrInstit' WHERE Codigo=$CodigoInstitucion";
					$result = mysql_query($Instruccion); 
				}
       
   }
   
   if (strlen($OtraDependencia)>0 && $traba==0)
   {    
		   $Instruccion = "INSERT INTO Dependencias (Codigo_Institucion,Nombre,Direccion,Telefonos,Figura_Portada,Hipervinculo1,Hipervinculo2,Hipervinculo3,Comentarios) VALUES('".$CodigoInstitucion."','".$OtraDependencia."','','',0,'','','','')";	
		   $result = mysql_query($Instruccion); 
		   $CodigoDependencia = mysql_insert_id();   
		   if ($CodigoDependencia!=0)
			   {
				$MensajeDependencia = "1 ".$Mensajes["tf-4"].": ".$OtraDependencia;	
			   }
			   else
			   {
					$traba = 1;
					$MensajeDependencia = $Mensajes["me-4"];       	
			   }
   }

   if (strlen($OtraUnidad)>0 && $traba==0)
   {    
			$Instruccion = "INSERT INTO Unidades (Codigo_Institucion,Codigo_Dependencia,Nombre,Direccion,Telefonos,Figura_Portada,Hipervinculo1,Hipervinculo2,Hipervinculo3,Comentarios) VALUES('".$CodigoInstitucion."','".$CodigoDependencia."','".$OtraUnidad."','','',0,'','','','')";	
			
		   $result = mysql_query($Instruccion); 
		   $CodigoUnidad = mysql_insert_id();     
			if ($CodigoUnidad!=0)
			   {
				$MensajeUnidad = "1 ".$Mensajes["tf-5"].": ".$OtraUnidad;	
			   }
			   else
			   {
					$traba = 1;
					$MensajeUnidad = $Mensajes["me-5"];       	
			   }
   }

   if (strlen($OtraCategoria)>0 && $traba==0)
   {    
	

		   $Instruccion = "INSERT INTO Tab_Categ_usuarios (Nombre) VALUES('".$OtraCategoria."')";	
		   $result = mysql_query($Instruccion); 
		   echo mysql_error();	
		   $CodigoCategoria =mysql_insert_id();
		   if ($CodigoCategoria!=0)
			   {
				$MensajeCategoria = "1 ".$Mensajes["tf-6"].": ".$OtraCategoria;	
			   }
			   else
			   {
					$traba = 1;
					$MensajeCategoria = $Mensajes["me-6"];       	
			   }

   }
   
   // Ahora llega la parte crucial que es la de agregar el Usuario

   if ($traba==0)
   {    
			$Dia = date ("d");
		   $Mes = date ("m");
		   $Anio = date ("Y");
		   $FechaHoy =$Anio."-".$Mes."-".$Dia;
		   $Delay = Calcular_Dias($FechaSolicitud,$FechaHoy);  
		   
		   global $Id_usuario;
		   $Instruccion = "INSERT INTO Usuarios (Apellido,Nombres,EMail,Codigo_Institucion,";
		   $Instruccion = $Instruccion. "Codigo_Dependencia,Codigo_Unidad,Direccion,";
		   $Instruccion = $Instruccion. "Codigo_pais,Codigo_Localidad,Codigo_Categoria,";
		   $Instruccion = $Instruccion. "Telefonos,Fecha_Solicitud,Fecha_Alta,";
		   $Instruccion = $Instruccion. "Login,Password,Codigo_FormaPago,Bibliotecario,Comentarios,Delay_Atencion,Codigo_UsuarioAprueba) VALUES (";
		   $Instruccion = $Instruccion. "'".$Apellido."','".$Nombre."','".$Mail."','".$CodigoInstitucion."','".$CodigoDependencia;
		   $Instruccion = $Instruccion. "','".$CodigoUnidad."','".$Direccion."','".$CodigoPais."','".$CodigoLocalidad;
		   $Instruccion = $Instruccion. "','".$CodigoCategoria."','".$Telefono."','".$FechaSolicitud."','".$FechaHoy;
		   $Instruccion = $Instruccion. "','".$Login."','".$Password."','".$FormaPago."',".$Bibliotecario.",'".$Comentarios."',".$Delay.",".$Id_usuario.")";
		   
		  // echo $Instruccion;
		   $result = mysql_query($Instruccion); 
		   
		   
		   $CodigoUsuario =mysql_insert_id();
		   if ($CodigoUsuario!=0)
			   {
				$MensajeUsuario = "1 ".$Mensajes["tf-7"].": ".$Apellido.",".$Nombre;	
				//$Instruccion = "DELETE FROM Candidatos WHERE Id='".$Id."'";
				//$result = mysql_query($Instruccion); 
				$Instruccion = "update Candidatos set rechazados=1  WHERE Id='".$Id."'";
				$result = mysql_query($Instruccion); 
				$Instruccion = "SELECT Denominacion,Texto FROM Plantmail WHERE Cuando_Usa=100";
				$result = mysql_query($Instruccion);
				echo mysql_error();    		   
				$roww = mysql_fetch_array($result);
				$cita = "";
				$Nombre = $Apellido.",".$Nombre;
				$roww[1] = reemplazar_variables ($roww[1],"",$Nombre,0,$cita,0,"",$Login,$Password); 
					
			   }
			   else
			   {
					$traba = 1;
					if (isset ($Mensajes["me-7"]))
						$MensajeUsuario = $Mensajes["me-7"];       	
						else
						$MensajeUsuario ="";
			   }

?>
             
              <tr>
                <td bgcolor="#E4E4E4">
				<form method="POST" action="agrega_usuario.php">

					<input type="hidden" name="Operacion" value="1">
					<input type="hidden" name="usuario" value="<? echo $CodigoUsuario; ?>">
					<input type="hidden" name="Id" value="0">
					<input type="hidden" name="Modo" value="<? echo $Modo; ?>">

				 <table width="100%"  border="0">
                  <tr>
					<td width="100%" height="15" valign="top" align="center" colspan="2"><div align="center" class="style60"><? echo $Mensajes["tf-18"]; ?></div>
					</td>
				  </tr>
				  <tr>
					<td width="20%" height="15" valign="top" align="right">
					 <div align="center" class="style60"><? echo $Mensajes["tf-19"]; ?></div>
					</td>
					<td width="80%" height="15" valign="top" align="left">
					<input class="style55" type="text" name="Direccion" size="35" value="<?  echo $Mail; ?>">
					</td>
				  </tr>
				  <tr>
					<td width="20%" height="15" valign="top" align="right">
					 <font face="MS Sans Serif" size="1" color="#99ffff">&nbsp;</font>
					</td>
					<td width="80%" height="15" valign="top" align="left">
					
					<input type="checkbox" name="Corrige_Direccion" value="ON"><div class="style60">  <? echo $Mensajes["tf-20"]; ?></div>
					</td>
				  </tr>
				  <tr>
					<td width="20%" height="15" valign="top" align="right">
					 <div class="style60"><? echo $Mensajes["tf-21"]; ?></div>
					</td>
					<td width="80%" height="15" valign="top" align="left">
					<input type="text" class="style55" name="Asunto" size="35" value="<?  echo $roww[0];  ?>" >
					</td>
				  </tr>
				  <tr>
					<td width="20%" height="15" valign="top" align="right">
					 <div class="style60"><? echo $Mensajes["tf-22"]; ?></div>
					</td>
					<td width="80%" height="15" valign="top" align="left">
					 
					 <textarea rows="8" cols="35" class="style55" name="Texto"><? echo $roww[1]; ?></textarea>
					 </font>
					 </td>
				  </tr>
				  <tr>
					<td width="20%" height="15" valign="top" align="right">
					 &nbsp;
					</td>
					<td width="80%" height="15" valign="top" align="left">
					 <input type="submit" value="<? echo $Mensajes["bot-1"]; ?>" name="B3"  class="style55">
					</td>
				  </tr>

				 
				   <tr>
					<td width="100%" height="15" valign="top" align="center" colspan="2">
					 &nbsp;
					</td>
				  </tr>
                </table>                  
				</form>

                  </td>
              </tr>

			  <?
   
  }
	else
	{
	?>
		 <tr>
           <td bgcolor="#E4E4E4">
			<table border="0" width="75%" cellspacing="0" align="center">
			  <tr>
				<td width="100%" height="15" valign="top" align="center" ><div align="center" class="style60">
				<? echo $Mensajes["tf-23"]; ?></div></td>
			  </tr>
			  <tr>				
				<td width="100%" height="15" valign="top" align="center"><div align="center" class="style60"><? echo $Mensajes["tf-24"]; ?></div></td>
			  </tr>
			</table>  
			</td>
         </tr>
	<?
	}
		?>
		<tr>
           <td bgcolor="#E4E4E4" align="center" class="style33"><a href="manejcand.php"><? echo $Mensajes["h-2"]; ?></a></td>
		<tr>
		

	
			
            </table>
              </center>
            </div>

			<?

}		//Operacion
	else
	{
		
		  if ($Direccion!="")
				{
				  $Dia = date ("d");
				  $Mes = date ("m");
				  $Anio = date ("Y");
				  $fecha =$Anio."-".$Mes."-".$Dia;
				 
				  $hora = strftime ("%H:%M:%S"); 

				  $Instruccion = "INSERT INTO mail (Codigo_usuario,Fecha,Hora,Direccion,Asunto,Texto,Codigo_Pedido)";
				  $Instruccion = $Instruccion." VALUES ($usuario,'$fecha','$hora','$Direccion','$Asunto','$Texto','$Id')";
				  $result = mysql_query($Instruccion);
				  echo mysql_error();
				
				  $mail =mail ($Direccion,$Asunto,$Texto,"From:".Destino_Mail());
				  
				  if (isset($Corrige_Direccion) && ($Corrige_Direccion=="ON"))
				  {
					$Instruccion = "UPDATE Usuarios SET EMail='".$Direccion."' WHERE Id=".$usuario;
				   $result = mysql_query($Instruccion);
					echo mysql_error(); 
				  }
				}
		
	?>
	 <tr>
                <td bgcolor="#E4E4E4">
				&nbsp;<?
	}?>
				<hr>
	 <table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" >

	  <tr>
		<td width="10%" bgcolor="#0099CC">&nbsp;</td>
		<td width="90%" bgcolor="#0099CC" class="style34" colspan=2 ><? echo $Mensajes["tf-9"]; ?></td>
	  
	  </tr>
	  <tr>
		<td width="10%" bgcolor="#E4E4E4" class="style22" height="21">&nbsp;</td>
		<td width="90%" bgcolor="#E4E4E4" class="style22" height="21" colspan=2  ><? if (isset($MensajePais))echo $MensajePais; else echo "0"; ?></td>
	   
	  </tr>
	  <tr>
		<td width="10%" bgcolor="#0099CC">&nbsp;</td>
		<td width="90%" bgcolor="#0099CC" class="style34" colspan=2 ><? echo $Mensajes["tf-10"]; ?></td>   
	  </tr>
	  <tr>
		<td width="10%" bgcolor="#E4E4E4" class="style22" height="21">&nbsp;</td>
		<td width="90%" bgcolor="#E4E4E4" class="style22" height="21" colspan=2  ><?if (isset($MensajeLocalidad)) echo $MensajeLocalidad; else echo "0"; ?></td>
		
	  </tr>
	  <tr>
		<td width="10%" bgcolor="#0099CC">&nbsp;</td>
		<td width="90%" bgcolor="#0099CC" class="style34" colspan=2 ><? echo $Mensajes["tf-11"]; ?></td>
	  </tr>
	  <tr>
		<td width="10%" bgcolor="#E4E4E4">&nbsp;</td>
		<td width="90%" bgcolor="#E4E4E4" class="style22" colspan=2 ><? if (isset($MensajeInstitucion)) echo $MensajeInstitucion;  else echo "0";?></td>
	  </tr>
	  <tr>
		<td width="10%" bgcolor="#0099CC">&nbsp;</td>
		<td width="90%" bgcolor="#0099CC" class="style34" colspan=2 ><? echo $Mensajes["tf-12"]; ?></td>
	  </tr>
	  <tr>
		<td width="10%" bgcolor="#E4E4E4">&nbsp;</td>
		<td width="90%" bgcolor="#E4E4E4" class="style22" colspan=2 ><? if (isset($MensajeDependencia)) echo $MensajeDependencia;  else echo "0";?></td>
	  </tr>
	  <tr>
		<td width="10%" bgcolor="#0099CC">&nbsp;</td>
		<td width="90%" bgcolor="#0099CC" class="style34" colspan=2 ><? echo $Mensajes["tf-13"]; ?></td>
	  </tr>
	  <tr>
		<td width="10%" bgcolor="#E4E4E4">&nbsp;</td>
		<td width="90%" bgcolor="#E4E4E4" class="style22" colspan=2 ><? if (isset($MensajeUnidad)) echo $MensajeUnidad;  else echo "0"; ?></td>
	  </tr>
	  <tr>
		<td width="10%" bgcolor="#0099CC">&nbsp;</td>
		<td width="90%" bgcolor="#0099CC" class="style34" colspan=2 ><? echo $Mensajes["tf-14"]; ?></td>
	  </tr>
	  <tr>
		<td width="10%" bgcolor="#E4E4E4">&nbsp;</td>
		<td width="90%" bgcolor="#E4E4E4" class="style22" colspan=2 ><?if (isset($MensajeCategoria)) echo $MensajeCategoria;  else echo "0";?></td>
	  </tr>
	  <tr>
		<td width="10%" bgcolor="#0099CC">&nbsp;</td>
		<td width="90%" bgcolor="#0099CC" class="style34" colspan=2 ><? echo $Mensajes["tf-15"]; ?></td>
	  </tr>
	  <tr>
		<td width="10%" bgcolor="#E4E4E4">&nbsp;</td>
		<td width="90%" bgcolor="#E4E4E4" class="style22" colspan=2 ><? if (isset($MensajeUsuario))  echo $MensajeUsuario; else echo "0"; ?></td>
	  </tr>
	  <tr>
		<td width="10%" bgcolor="#006699" class="style45" align="left" >&nbsp;</td>
		<td width="90%" bgcolor="#006699" class="style45" align="left" class="style22"  colspan=2><? echo $Mensajes["tf-16"]; ?> <? if (isset($Delay)) echo $Delay;  else echo "0"; ?> Dias. </td>
	  </tr>
	</table>	
	<br>
			</td>
		 <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style22">
          <div align="left">
            <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td bgcolor="#ECECEC"><div align="center">
                  <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td bgcolor="#ECECEC"><div align="center">
                          <p><img src="../images/image001.jpg" width="150" height="118"><br>
                              <span class="style33"><a href="../admin/indexadm.php"><? echo $Mensajes["h-1"];?></a></span></p>
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
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100"  border="0" lowsrc="../PrEBi%20:%20UNLP"></a></div></td>
          <td width="50"><div align="right" class="style33">mso-001</div></td>
        </tr>
      </table>
    </div></td>
  </tr>

</table>

  
</div>
</body>
</html>
