<?
    
include_once Obtener_Direccion()."conexion.inc.php";  
   Conexion();	
   include_once Obtener_Direccion()."identif.php"; 
   Administracion();
   
 ?>
<html>

<head>
<? 
  include_once Obtener_Direccion()."fgenhist.php";
  include_once Obtener_Direccion()."fgentrad.php";
 
   $Mensajes = Comienzo ("fma-001",$IdiomaSitio);


   
?>
<title><? echo $Mensajes["titulo"]?></title>
</head>


<P>

   
<div align="center">
  <center>


 <?
if ($Idmail=="")
{  
     // Primero reemplazo los <13> por chr(13)+chr(10)
	 $texto = str_replace ("<13>","\n",$texto);
     $row[0] = $asunto;
	 $row[1] = $texto;
	 
	 $expresion = "SELECT Apellido,Nombres,Usuarios.Id,MIN(Pedidos.Fecha_Recepcion)";
   	 $expresion .= ",COUNT(*),Usuarios.EMail FROM Usuarios";
   	 $expresion .= " LEFT JOIN Pedidos ON Pedidos.Codigo_Usuario=Usuarios.Id";
   	 $expresion .= " WHERE Pedidos.Estado=".Devolver_Estado_Recibido()." AND Pedidos.Codigo_Usuario=".$usuario;
     $expresion .= " GROUP BY Pedidos.Codigo_Usuario";
     
      $result = mysql_query($expresion);
	  $roww = mysql_fetch_row($result);
   	  echo mysql_error();
	  
	  // Aca reemplazo las variables correspondientes
	  
	  $numero_pedidos = $roww[4];
	  $minima_fecha = $roww[3];
	  $Nombre = $roww[0].",".$roww[1];
	  
	  $row[1]=reemplazar_variables ($row[1],"",$Nombre,0,"",$numero_pedidos,$minima_fecha,"","");
 }
 else
 {
    $expresion = "SELECT Usuarios.Apellido,Usuarios.Nombres,mail.Direccion,mail.Asunto,mail.Texto FROM mail ";
	$expresion .= "LEFT JOIN Usuarios ON mail.Codigo_usuario=Usuarios.Id ";
    $expresion .= "WHERE mail.Id=".$Idmail;
    $result = mysql_query($expresion);
	echo mysql_error();
	$fila = mysql_fetch_row($result);
	
	// Asigno esto por compatibilidad
	
	$roww[0] = $fila[0];
	$roww[1] = $fila[1];
	$roww[5] = $fila[2];
	$row[0] = $fila[3];
	$row[1] = $fila[4];
 }  
  ?>
  
  
<form method="POST" name="form1">

<table border="0" width="97%" height="1" cellspacing="0" bgcolor="#AFDDFE" cellpadding="3">
  <tr>
    <td width="30%" valign="top" height="21" bgcolor="#006699" align="right">
    <font face="MS Sans Serif" size="1" color="#FFFFCC">&nbsp;
    <b><? echo $Mensajes["tf-1"]; ?>&nbsp;</b></font>
    </td>
    <td width="70%" valign="top" height="21" bgcolor="#006699" colspan="2">
    <font face="MS Sans Serif" size="1" color="#FFFFCC">
    <?echo $roww[0].",".$roww[1] ; ?></font>    </td>
  </tr>
  <tr>
    <td width="30%" height="15" valign="top" align="right">
    <font face="MS Sans Serif" size="1">
    <? echo $Mensajes["ec-1"]; ?></font>
    </td>
  </center>

    <td width="70%" height="15" valign="top" align="left" colspan="2">
    <font face="MS Sans Serif" size="1">
    <input type="text" name="Direccion" size="51" value="<? echo $roww[5];  ?>">
    </font>
    </td>
  </tr>
  <center>
  
  
  <tr>
    <td width="30%" height="15" valign="top" align="right">
        <font face="MS Sans Serif" size="1">
        <? echo $Mensajes["ec-3"]; ?></font>
    </td>
    <td width="70%" height="15" valign="top" align="left" colspan="2">
    <font face="MS Sans Serif" size="1">
    <input type="text" name="Asunto" size="51" value="<? echo $row[0]; ?>" >
    </font>
    </td>
  </tr>
  <tr>
    <td width="30%" height="15" valign="top" align="right">
     <font face="MS Sans Serif" size="1">
     <? echo $Mensajes["ec-4"]; ?></font>
     </td>
    <td width="70%" height="15" valign="top" align="left" colspan="2">
     <font face="MS Sans Serif" size="1">
     <textarea rows="8" cols="44" name="Texto"><? echo $row[1]; ?></textarea>
     </font>
    </td>
  </tr>
  <tr>
    <td width="30%" height="15" valign="top" align="right">
   &nbsp;
    </td>
    <td width="70%" height="15" valign="top" align="left" colspan="2">
    <input type="reset" value="<? echo $Mensajes["bot-3"]; ?>" style="font-family: MS Sans Serif; font-size: 10 px; font-weight=bold" OnClick="javascript:self.close()">
   
    </td>
  </tr>
  <tr>
    <td width="30%" height="15" valign="top" align="right">
     &nbsp;
    </td>
    <td width="70%" height="15" valign="top" align="center" colspan="2">
     &nbsp;
    </td>
  </tr>
</table>

   
</form>
</div>

<P ALIGN="center"><FONT FACE="MS Sans Serif" SIZE="1"><FONT COLOR="#000080">cp:</FONT>
fma-001</FONT></P>

<? 
  
 Desconectar(); ?>
</body>


































































