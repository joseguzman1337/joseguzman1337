<? 
 include_once "../inc/conexion.inc.php";
 include_once "../inc/"."identif.php";
 Conexion();
 Bibliotecario();	
?>  
<html>

<head>
<title>Proceso de Aprobación de Usuario</title>
</head>
<body background="../imagenes/banda.jpg">
<? 
include_once "../inc/"."fgenped.php";
  include_once "../inc/fgentrad.php"; 
 
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
   
  if ($traba==0 && $operacion==0)
  { 
?>   

<form method="POST" action="upd_us_bib.php">
<table border="0" width="55%" height="1" cellspacing="0" align="center">
 <tr>
  <td bgcolor="#0099cc">
  
  <table border="0" width="100%" height="1" cellspacing="0" align="center"> 
  <tr>
    <td width="100%" height="15" valign="top" align="center" colspan="2">
    <font face="MS Sans Serif" size="1" color="#99ffff"><b>
    <? echo $Mensajes["tf-18"]; ?></b></font>
    </td>
  </tr>
  <tr>
    <td width="20%" height="15" valign="top" align="right">
	 <font face="MS Sans Serif" size="1" color="#99ffff"><? echo $Mensajes["tf-19"]; ?></font>
    </td>
    <td width="80%" height="15" valign="top" align="left">
    <input type="text" name="Direccion" size="35" value="<?  echo $Mail; ?>">
    </td>
  </tr>  
  <tr>
    <td width="20%" height="15" valign="top" align="right">
	 <font face="MS Sans Serif" size="1" color="#99ffff"><? echo $Mensajes["tf-21"]; ?></font>
    </td>
    <td width="80%" height="15" valign="top" align="left">
    <input type="text" name="Asunto" size="35" value="<?  echo $roww[0];  ?>" >
    </td>
  </tr>
  <tr>
    <td width="20%" height="15" valign="top" align="right">
	 <font face="MS Sans Serif" size="1" color="#99ffff"><? echo $Mensajes["tf-22"]; ?></font>
    </td>
    <td width="80%" height="15" valign="top" align="left">
     <font face="MS Sans Serif" size="1">
     <textarea rows="8" cols="35" name="Texto"><? echo $roww[1]; ?></textarea>
     </font>
     </td>
  </tr>
   <tr>
    <td width="100%" height="15" valign="top" align="center" colspan="2">
	 &nbsp;
    </td>
  </tr>
  </table>
   </td>
  </tr>
</table>

  <input type="hidden" name="dedonde" value="1">
  <input type="hidden" name="usuario" value="<? echo $CodigoUsuario; ?>">
  <input type="hidden" name="Id" value="0">
  <input type="hidden" name="Modo" value="<? echo $Modo; ?>">
  
   <p align="center">
   <input type="submit" value="<? echo $Mensajes["bot-1"]; ?>" name="B3" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold"></p>
</form>
<br>
<? } 
// Lo que sigue lo presento incondicionalmente sea por un alta o por una 
// actualización.

?>
<table border="0" width="65%" cellspacing="0" align="center">
 <? if ($Bibliotecario==1)
 	{?>
  <tr>
    <td width="10%" bgcolor="#669999" align="left" height="22">&nbsp;</td>
    <td width="80%" bgcolor="#669999" align="left" height="22"><font face="MS Sans Serif" size="1" color="#FFFFFF"><b><? echo $Mensajes["tf-12"]; ?></b></font></td>
    <td width="10%" bgcolor="#669999" align="left" height="22">&nbsp;</td>
  </tr>
  <tr>
    <td width="10%" bgcolor="#FFFFCC" align="left" height="22">&nbsp;</td>
    <td width="80%" bgcolor="#FFFFCC" align="left" height="22"><font face="MS Sans Serif" size="1" color="#000080"><? echo $MensajeDependencia; ?></font></td>
    <td width="10%" bgcolor="#FFFFCC" align="left" height="22">&nbsp;</td>
  </tr>
  <? } 
   
   if ($Bibliotecario==2)
   {?>
  <tr>
    <td width="10%" bgcolor="#669999" align="left" height="22">&nbsp;</td>
    <td width="80%" bgcolor="#669999" align="left" height="22"><font face="MS Sans Serif" size="1" color="#FFFFFF"><b><? echo $Mensajes["tf-13"]; ?></b></font></td>
    <td width="10%" bgcolor="#669999" align="left" height="22">&nbsp;</td>
  </tr>
  <tr>
    <td width="10%" bgcolor="#FFFFCC" align="left" height="22">&nbsp;</td>
    <td width="80%" bgcolor="#FFFFCC" align="left" height="22"><font face="MS Sans Serif" size="1" color="#000080"><? echo $MensajeUnidad; ?></font></td>
    <td width="10%" bgcolor="#FFFFCC" align="left" height="22">&nbsp;</td>
  </tr>
  <?
   }
  ?>
  <tr>
    <td width="10%" bgcolor="#669999" align="left" height="22">&nbsp;</td>
    <td width="80%" bgcolor="#669999" align="left" height="22"><font face="MS Sans Serif" size="1" color="#FFFFFF"><b><? echo $Mensajes["tf-15"]; ?></b></font></td>
    <td width="10%" bgcolor="#669999" align="left" height="22">&nbsp;</td>
  </tr>
  <tr>
    <td width="10%" bgcolor="#FFFFCC" align="left" height="21">&nbsp;</td>
    <td width="80%" bgcolor="#FFFFCC" align="left" height="21"><font face="MS Sans Serif" size="1" color="#000080"><? echo $MensajeUsuario; ?></font></td>
    <td width="10%" bgcolor="#FFFFCC" align="left" height="21">&nbsp;</td>
  </tr>
</table>
<?
} // de dedonde
// Acá llega después de aprobar el formulario de correo
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
  	
	  mail ($Direccion,$Asunto,$Texto,"From:".Destino_Mail());
  	  
	 	
?>
<table border="0" width="65%" cellspacing="0" align="center">
  <tr>
    <td width="10%" bgcolor="#669999" align="left">&nbsp;</td>
    <td width="80%" bgcolor="#669999" align="left"><font face="MS Sans Serif" size="1" color="#FFFFFF"><b><? echo $Mensajes["tf-23"]; ?></b></font></td>
    <td width="10%" bgcolor="#669999" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td width="10%" bgcolor="#FFFFCC" align="left">&nbsp;</td>
    <td width="80%" bgcolor="#FFFFCC" align="left"><font face="MS Sans Serif" size="1" color="#000080"><? echo $Mensajes["tf-24"]; ?></font></td>
	<td width="10%" bgcolor="#FFFFCC" align="left">&nbsp;</td>
  </tr>
</table>  

<? 
    } 
	
} 
?>

<br>
<table border="0" width="65%" height="25" cellspacing="0" align="center">
  <tr>
    <td width="100%" align="center" bgcolor="#336699" height="15"><a href="../comunidad/indexcom2.php"><font face="MS Sans Serif" size="1" color="#FFFFCC"><? echo $Mensajes["h-1"]; ?></font></a></td>
  </tr>
</table>

<?	
  
  Desconectar();
?>
<P ALIGN="center"><FONT FACE="MS Sans Serif" SIZE="1"><FONT COLOR="#000080">cp:</FONT>mso-001</FONT></P>
</body>

</html>










