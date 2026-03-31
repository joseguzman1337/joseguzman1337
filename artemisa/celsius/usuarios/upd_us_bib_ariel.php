<?
   include_once "../inc/var.inc.php";
   include_once "../inc/conexion.inc.php";
   Conexion();	
   include_once "../inc/identif.php";
   Bibliotecario();	
   if (! isset($Administracion )) $Administracion="";
   if (! isset($Staff )) $Staff ="";
   if (! isset($FormaPago  )) $FormaPago  ="";
   if (! isset($Nombre  )) $Nombre="";
   if (! isset($Modo )) $Modo="";
  global  $IdiomaSitio ; 
   

   
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
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<? 
   include_once "../inc/fgenhist.php";
   include_once "../inc/fgentrad.php";
  
     $Mensajes = Comienzo ("pau-003",$IdiomaSitio);
   $Mensajes = Comienzo ("mso-001",$IdiomaSitio);

// Aca se llama con tres parámetros, dedonde marca si
// se está llamando para enviar el correo o para hacer actualizaciones
// operacion en 0 es alta y puede enviar correo y en 1
// es actualización que no envía correo

if ($dedonde==0)
{
   $MensajeDependencia = "0 ".$Mensajes["tf-4"];	
   $MensajeUnidad = "0 ".$Mensajes["tf-5"];
   $MensajeUsuario = "0 ".$Mensajes["tf-7"];
   $traba = 0;
   
   // Aca voy a averiguar el país
   // del usuario bibliotecario
   
   $Instruccion = "SELECT Codigo_Pais FROM Usuarios WHERE Id=".$Id_usuario; 
   $result = mysql_query($Instruccion); 
   $row = mysql_fetch_row($result);  
   mysql_free_result($result);  
   
   
   if ($Bibliotecario==1 && strlen($OtraDependencia)>0)
   {    
       $Instruccion = "INSERT INTO Dependencias (Codigo_Institucion,Nombre,Direccion,Telefonos,Figura_Portada,Hipervinculo1,Hipervinculo2,Hipervinculo3,Comentarios) VALUES(".$Instit_usuario.",'".strtoupper($OtraDependencia)."','','',0,'','','','')";	
       $result = mysql_query($Instruccion); 
       $Dependencias = mysql_insert_id();     
       if ($Dependencias!=0)
       {
       	$MensajeDependencia = "1 ".$Mensajes["tf-4"].": ".$OtraDependencia;	
       }
       else
       {
			$traba = 1;
			$MensajeDependencia = $Mensajes["me-4"];       	
       }
   }

   
 
   if ($Bibliotecario<3 && strlen($OtraUnidad)>0)
   {    
       $Instruccion = "INSERT INTO Unidades (Codigo_Institucion,Codigo_Dependencia,Nombre,Direccion,Telefonos,Figura_Portada,Hipervinculo1,Hipervinculo2,Hipervinculo3,Comentarios) VALUES('".$Instit_usuario."',".$Dependencias.",'".strtoupper($OtraUnidad)."','','',0,'','','','')";	
       $result = mysql_query($Instruccion); 
       $Unidades = mysql_insert_id();     
       if ($Unidades!=0)
       {
       	$MensajeUnidad = "1 ".$Mensajes["tf-5"].": ".$OtraUnidad;	
       }
       else
       {
			$traba = 1;
			$MensajeUnidad = $Mensajes["me-5"];       	
       }
   }

    // Ahora llega la parte crucial que es la de agregar el Usuario

   if ($traba==0)
   {    
     if ($operacion==0)
	 {
   	   $Dia = date ("d");
       $Mes = date ("m");
       $Anio = date ("Y");
       $FechaHoy =$Anio."-".$Mes."-".$Dia;
       list($Loginv,$Passwordv) = LoginyPassword($Nombres,$Apellido);
	   $Personal = 0;
	      
       $Instruccion = "INSERT INTO Usuarios (Apellido,Nombres,EMail,Codigo_Institucion,";
       $Instruccion .= "Codigo_Dependencia,Codigo_Unidad,Direccion,";
       $Instruccion .= "Codigo_pais,Codigo_Localidad,Codigo_Categoria,";
       $Instruccion .= "Telefonos,Fecha_Solicitud,Fecha_Alta,";
       $Instruccion .= "Login,Password,Codigo_FormaPago,Personal,Bibliotecario,Comentarios,Delay_Atencion) VALUES (";
       $Instruccion .= "'".strtoupper($Apellido)."','".$Nombres."','".$Mail."','".$Instit_usuario."','".$Dependencias;
       $Instruccion .= "','".$Unidades."','".$Direccion."','".$row[0]."','".$Localidad;
       $Instruccion .= "','".$Categoria."','".$Telefono."','".$FechaHoy."','".$FechaHoy;
       $Instruccion .= "','".$Loginv."','".$Passwordv."','".$FormaPago."',0,0,'".$Comentarios."',0)";
      }
	  else
	  {
	  	$Instruccion = "UPDATE Usuarios SET Apellido='".strtoupper($Apellido)."',Nombres='".$Nombres."',EMail='".$Mail."',Codigo_Dependencia=".$Dependencias;
		$Instruccion .= ",Codigo_Unidad=".$Unidades.",Direccion='".$Direccion."',Codigo_Localidad=".$Localidad.",Codigo_Categoria=".$Categoria;
		$Instruccion .= ",Telefonos='".$Telefonos."',Comentarios='".$Comentarios."' WHERE Id=".$Id;
		$Nombre = $Apellido.",".$Nombres;
		$MensajeUsuario = "1 ".$Mensajes["tf-25"].": ".$Nombre;
	  } 
      
	    $result = mysql_query($Instruccion); 
	   echo mysql_error();
  
  
  	   // Si es alta de usuario busco las variables y la plantilla
	   // de correo así genero el formulario
	   	
       if ($operacion==0)
	   {
         $CodigoUsuario =mysql_insert_id();
         if ($CodigoUsuario!=0)
         {
    	
		  $Instruccion = "SELECT Denominacion,Texto FROM Plantmail WHERE Cuando_Usa=100";
          $result = mysql_query($Instruccion);
		  echo mysql_error();    		   
    	  $roww = mysql_fetch_array($result);
		  mysql_free_result($result);
    	  $cita = "";
		  $Nombre = $Apellido.",".$Nombres;
          $roww[1] = reemplazar_variables ($roww[1],"",$Nombre,0,$cita,0,"",$Loginv,$Passwordv); 
	      $MensajeUsuario = "1 ".$Mensajes["tf-7"].": ".$Nombre;	
		 } 
		 else
       	 {
			$traba = 1;
			$MensajeUsuario = $Mensajes["me-7"];       	
       	 }         	
       }
       

   }

  // Si anduvo todo bien y la operacion es un alta
  // va a presentar el form con el correo, lo único que
  // diferencia es que dedonde=1 con lo que no va a repetir 
  // todas las operaciones de alta
   

?>   

<div align="left">
<form method="POST" action="upd_us_bib.php">
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
   <?
     if ($traba==0 && $operacion==0)
       { ?>        
                <table width="450" height="90%"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ECECEC">
                  <tr bgcolor="#006699">
                    <td height="20" colspan="3" class="style33"><span class="style34"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["tf-18"]; ?></span></td>
                  </tr>
                  <tr>
                    <td width="100" height="20" align="right" valign="middle" class="style22"><div align="right"><? echo $Mensajes["tf-19"]; ?></div></td>
                    <td height="20">
					<input type="text" name="Direccion" class="style22" size="35" value="<?  echo $Mail; ?>">	
</td>
                    <td height="20" valign="middle" class="style33"><input type="checkbox" name="Corrige_Direccion" value="ON">  <? echo $Mensajes["tf-20"]; ?></td>
                  </tr>
                  <tr>
                    <td width="100" height="20" align="right" valign="middle" class="style22"><div align="right"><? echo $Mensajes["tf-21"]; ?></div></td>
                    <td height="20" colspan="2"><input class="style22" type="text" name="Asunto" size="35" value="<?  if (isset ($roww))  echo $roww[0];  ?>" ></td>
                  </tr>
                  <tr>
                    <td width="100" height="20" valign="top" class="style22"><div align="right"><? echo $Mensajes["tf-22"]; ?></div></td>
                    <td height="20" colspan="2"><textarea class="style22" rows="8" cols="35" name="Texto"><? if (isset ($roww)) echo $roww[1]; ?></textarea></td>
                  </tr>
                  <tr>
                    <td width="100" height="20">&nbsp;</td>
                    <td height="20" colspan="2">
  <input type="hidden" name="dedonde" value="1">
  <input type="hidden" name="usuario" value="<? echo $CodigoUsuario; ?>">
  <input type="hidden" name="Id" value="0">
  <input type="hidden" name="Modo" value="<? echo $Modo; ?>">

   <input type="submit" value="<? echo $Mensajes["bot-1"]; ?>" name="B3" class="style22"></p>
</form></td>
                  </tr>
                </table>
            
   
   <?
  }
   
   if ($operacion==0 || $operacion==1)
 { 
 
   if (mysql_affected_rows()>0)
   {
 
   ?>
   <hr>
   <input type="hidden" name="Desc_Loc"><input type="hidden" name="Desc_Inst">  
   <table width="450"  border="0" cellpadding="0" cellspacing="1" bgcolor="#ECECEC">
                  <tr>
                    <td width="200" height="18" valign="top" class="style22"><div align="right"><? echo $Mensajes["et-1"]; ?><br>
                        </div></td>
                    <td width="250" height="18" valign="top" class="style33"><div align="left"><span class="style33"><? echo stripslashes($Apellido); ?></span></div></td>
                  </tr>
                  <tr>
                    <td width="200" height="18" valign="top" class="style22"><div align="right"><? echo $Mensajes["et-2"]; ?></div></td>
                    <td width="250" height="18" valign="top" class="style33"><div align="left"><? echo stripslashes($Nombres); ?></div></td>
                  </tr>
                  <tr>
                    <td width="200" height="18" valign="top" class="style22"><div align="right"><? echo $Mensajes["et-3"]; ?></div></td>
                    <td width="250" height="18" valign="top" class="style33"><div align="left"><? echo $InstDesc; ?></div></td>
                  </tr>
                  <tr>
                    <td width="200" height="18" valign="top" class="style22"><div align="right"><? echo $Mensajes["et-4"]; ?></div></td>
                    <td width="250" height="18" valign="top" class="style33"><div align="left"><? echo $DepDesc; ?></div></td>
                  </tr>
                  <tr>
                    <td width="200" height="18" valign="top" class="style22"><div align="right"><? echo $Mensajes["et-5"]; ?></div></td>
                    <td width="250" height="18" valign="top" class="style33"><div align="left"><? echo $UnidadDesc; ?></div></td>
                  </tr>
                  <tr>
                    <td width="200" height="18" valign="top" class="style22"><div align="right"><? echo $Mensajes["et-6"]; ?></div></td>
                    <td width="250" height="18" valign="top" class="style33"><div align="left"><? echo $LocalidadDesc; ?></div></td>
                  </tr>
                  <tr>
                    <td width="200" height="18" valign="top" class="style22"><div align="right"><? echo $Mensajes["et-7"]; ?></div></td>
                    <td width="250" height="18" valign="top" class="style33"><div align="left"><? echo $Mensaje; ?></div></td>
                  </tr>
                  <tr>
                    <td width="200" height="18" valign="top" class="style22"><div align="right"><? echo $Mensajes["et-10"]; ?></div></td>
                    <td width="250" height="18" valign="top" class="style33"><div align="left"><? echo $Mensaje2; ?></div></td>
                  </tr>
                  <tr>
                    <td width="200" height="18" valign="top" class="style22"><div align="right"><? echo $Mensajes["et-8"]; ?></div></td>
                    <td width="250" height="18" valign="top" class="style33"><div align="left"><? echo $Login; ?></div></td>
                  </tr>
                  <tr>
	              <? if ($operacion==0)
                    { ?>
                    <td width="200" height="18" valign="top" class="style22"><div align="right"><span class="style22"><? echo $Mensajes["et-9"]; ?></span></div></td>
                    <td width="250" height="18" valign="top" class="style33"><div align="left"><? if ($Contabilizar=="ON") { echo $Mensajes["afg-1"];  } else { echo $Mensajes["afg-2"]; } ?></div></td>
                  <? } ?>
					</tr>
                </table>
                
               <? }
          	else
	         {	
               ?>
                
                <table width="450" height="40"  border="0" cellpadding="0" cellspacing="1" bgcolor="#ECECEC">
                  <tr>
                    <td width="500" align="center" valign="middle" class="style22"><div align="center"><span class="style33"><? echo $Mensajes["me-1"]; ?>
                      </span><strong></strong>
                      </div></td>
                    </tr>
                </table>
       <?
      }
      }
	  ?>
				
				
				
				
				</center>
            </div>            </td>
        <td width="150" valign="top"><div align="center" class="style22">
          <div align="left">
            <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td bgcolor="#ECECEC"><div align="center">
                  <p><img src="../images/image001.jpg" width="150" height="118"><br>
                    <span class="style33"><a href="../admin/indexadm.php"><? echo $Mensajes["h-1"]; ?></a></span></p>
                  </div>                  </td>
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
            <div align="center">pau-003</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>
