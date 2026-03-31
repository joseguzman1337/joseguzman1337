<?
   
   include_once "../inc/var.inc.php";

   include_once "../inc/conexion.inc.php";  
   Conexion();	
   include_once "../inc/identif.php"; 
   Administracion();
   
 ?>
 
<html>

<head>
<title>PrEBi</title>
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
.style7 {color: #2D6FAC; font-size: 10px; }
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 9px; }
.style14 {
	font-size: 10px;
	font-family: Verdana;
	color: #FFFFFF;
}
.style15 {color: #006599}
.style17 {
	font-size: 9px;
	font-family: Verdana;
	color: #000000;
}
.style18 {color: #006699}
.style20 {color: #E4E4E4}
.style23 {font-size: 10}
.style24 {
	color: #000000;
	font-size: 9px;
	font-family: verdana;
}
.style26 {color: #006699; font-weight: bold; }
.style28 {font-size: 11px}
-->
</style>

</head>
<script language="JavaScript">
function actualizar ()
{
   self.opener.form2.action='anupedhist.php'
   self.opener.form2.submit(); 
	return true;
}
</script>
<body>
<? 
function Subir_Historico($Id,$Fecha_Anulacion,$Causa_Anulacion,$Operador_Anulacion)
{  	
  // Esto inserta los eventos historicos nuevamente
  // en eventos, calcula el estado y deja el evento que 
  // lo pasó a histórico como anulado.
  
   
  $Instruccion = "SELECT Id_Pedido,Codigo_Evento,Codigo_Pais,Codigo_Institucion,Codigo_Dependencia,Fecha,Observaciones,Operador,Es_Privado,Numero_Paginas,Id_Correo,Id FROM EvHist WHERE Id_Pedido='".$Id."'";
  $Instruccion .= " ORDER BY Fecha,Id";
  $result = mysql_query($Instruccion);
  echo mysql_error();
  while($row = mysql_fetch_row($result))
  {  
     //  Inserto todos los eventos menos la entrega, cancelación, etc
	 
	 $condicion = (Determinar_Estado($row[1])!=Devolver_Estado_Cancelado() && Determinar_Estado($row[1])!=Devolver_Estado_Entregado());
	
	 
	 if ($row[1]!=Devuelve_Evento_Observado() && $condicion )
	 {
	   $Ultimo_Estado = Determinar_Estado ($row[1]);
	 }
     
     if ($condicion)
	 {
       if ($row[10]=="")
       {
     	$row[10]=0;
       }
       $Instruccion = "INSERT INTO Eventos (Id_Pedido,Codigo_Evento,Codigo_Pais,Codigo_Institucion,Codigo_Dependencia,Fecha,Observaciones"; 
       $Instruccion = $Instruccion.",Operador,Es_Privado,Numero_Paginas,Id_Correo) VALUES ('".$row[0]."',".$row[1].",".$row[2].",".$row[3].",".$row[4].",'".$row[5];
       $Instruccion = $Instruccion."','".$row[6]."',".$row[7].",".$row[8].",".$row[9].",".$row[10].")";
      // echo $Instruccion;
	   $result2 = mysql_query($Instruccion); 
	   echo mysql_error();  
     }
	 else
	 {
	   // La entrega la inserto como anulada con las causas, fecha y operador de baja
	    if ($row[10]=="")
       {
     	$row[10]=0;
       }
       $Instruccion = "INSERT INTO EvAnula (Id_Pedido,Codigo_Evento,Codigo_Pais,Codigo_Institucion,Codigo_Dependencia,Fecha,Observaciones"; 
       $Instruccion = $Instruccion.",Operador,Es_Privado,Numero_Paginas,Id_Correo,Fecha_Anulacion,Causa_Anulacion,Operador_Anulacion) VALUES ('".$row[0]."',".$row[1].",".$row[2].",".$row[3].",".$row[4].",'".$row[5];
       $Instruccion = $Instruccion."','".$row[6]."',".$row[7].",".$row[8].",".$row[9].",".$row[10].",'".$Fecha_Anulacion."','".$Causa_Anulacion."',".$Operador_Anulacion.")";
       $result2 = mysql_query($Instruccion); 
	   echo mysql_error();  
	 }
  }
  
  
  $expresion = "SELECT PedHist.Id,PedHist.Codigo_Usuario,Tipo_Pedido,Tipo_Material,Titulo_Libro,Autor_Libro,Editor_Libro"; 
  $expresion = $expresion.",Anio_Libro,Desea_Indice,Capitulo_Libro,Numero_Patente,Codigo_Pais_Patente,Pais_Patente,Anio_Patente";
  $expresion = $expresion.",Autor_Detalle1,Autor_Detalle2,Autor_Detalle3,Codigo_Titulo_Revista";
  $expresion = $expresion.",Titulo_Revista,Titulo_Articulo,Volumen_Revista,Numero_Revista,Anio_Revista";
  $expresion = $expresion.",Pagina_Desde,Pagina_Hasta,TituloCongreso,Organizador,NumeroLugar,Anio_Congreso";
  $expresion = $expresion.",PaginaCapitulo,PonenciaActa,Codigo_Pais_Congreso,Otro_Pais_Congreso,TituloTesis";
  $expresion = $expresion.",AutorTesis,DirectorTesis,GradoAccede,Codigo_Pais_Tesis,Otro_Pais_Tesis,Codigo_Institucion_Tesis";
  $expresion = $expresion.",Otra_Institucion_Tesis,Codigo_Dependencia_Tesis,Otra_Dependencia_Tesis,Anio_Tesis,PagCapitulo";
    // Era el 25 ahora es 45
  $expresion = $expresion.",Fecha_Alta_Pedido,Estado,Biblioteca_Sugerida,Observaciones,Ultimo_Pais_Solicitado,Ultima_Institucion_Solicitado,Ultima_Dependencia_Solicitado,Operador_Corriente";
  $expresion = $expresion.",Fecha_Inicio_Busqueda,Fecha_Recepcion,Fecha_Solicitado,Fecha_Entrega,Numero_Paginas";
  $expresion = $expresion.",Usuarios.Codigo_Categoria,Tardanza_Atencion,Tardanza_Busqueda,Tardanza_Recepcion";
  
    // La idea es obtener el origen de los pedidos
  $expresion = $expresion.",Instituciones.Codigo_Pais,Usuarios.Codigo_Institucion,Usuarios.Codigo_Dependencia,Observado,Archivos_Totales ";

  $expresion = $expresion." FROM PedHist";
  $expresion = $expresion." LEFT JOIN Usuarios ON Usuarios.Id=PedHist.Codigo_usuario";
  $expresion = $expresion." LEFT JOIN Instituciones ON Usuarios.Codigo_Institucion=Instituciones.Codigo";
  $expresion = $expresion." WHERE PedHist.Id='".$Id."'";


 /// echo $expresion;
  $result = mysql_query($expresion);
  $row = mysql_fetch_row($result);
  echo mysql_error();
  
  
 

 // Esto se agrega por cuestiones de compatibilidad en relación a los datos
 // Históricos entregados  
 
  $row[14]=strtr($row[14],"'","\'");
  $row[15]=strtr($row[15],"'","\'");
  $row[16]=strtr($row[16],"'","\'");
	
  $row[18]=strtr($row[18],"'","\'");
  $row[19]=strtr($row[19],"'","\'");
  
  if ($row[59]=="")  
  {
    $row[59]=0;
  }
  
  if ($row[60]=="")
  {
   $row[60]=0;
  }
  
  if ($row[61]=="")
  {
   $row[61]=0;
  }
 

  // El Estado debería cambiar al anterior antes de anular el evento de entrega
  // que lo dejó en Histórico
  
     
  $Instruccion = "INSERT INTO Pedidos (Id,Codigo_Usuario,Tipo_Pedido,Tipo_Material,Titulo_Libro,Autor_Libro,Editor_Libro"; 
  $Instruccion = $Instruccion.",Anio_Libro,Desea_Indice,Capitulo_Libro,Numero_Patente,Codigo_Pais_Patente,Pais_Patente,Anio_Patente";
  $Instruccion = $Instruccion.",Autor_Detalle1,Autor_Detalle2,Autor_Detalle3,Codigo_Titulo_Revista";
  $Instruccion = $Instruccion.",Titulo_Revista,Titulo_Articulo,Volumen_Revista,Numero_Revista,Anio_Revista";
  $Instruccion = $Instruccion.",Pagina_Desde,Pagina_Hasta,TituloCongreso,Organizador,NumeroLugar,Anio_Congreso";
  $Instruccion = $Instruccion.",PaginaCapitulo,PonenciaActa,Codigo_Pais_Congreso,Otro_Pais_Congreso,TituloTesis";
  $Instruccion = $Instruccion.",AutorTesis,DirectorTesis,GradoAccede,Codigo_Pais_Tesis,Otro_Pais_Tesis,Codigo_Institucion_Tesis";
  $Instruccion = $Instruccion.",Otra_Institucion_Tesis,Codigo_Dependencia_Tesis,Otra_Dependencia_Tesis,Anio_Tesis,PagCapitulo";
  $Instruccion = $Instruccion.",Fecha_Alta_Pedido,Estado,Biblioteca_Sugerida,Observaciones,Ultimo_Pais_Solicitado,Ultima_Institucion_Solicitado,Ultima_Dependencia_Solicitado,Operador_Corriente";
  $Instruccion = $Instruccion.",Fecha_Inicio_Busqueda,Fecha_Recepcion,Fecha_Solicitado";
  $Instruccion = $Instruccion.",Tardanza_Atencion,Tardanza_Busqueda,Tardanza_Recepcion,Numero_Paginas,Observado,Archivos_Totales) VALUES (";
  $Instruccion = $Instruccion."'".$row[0]."',".$row[1].",".$row[2].",".$row[3].",'".$row[4]."','".$row[5]."','".$row[6]."',";
  $Instruccion = $Instruccion."'".$row[7]."',".$row[8].",'".$row[9]."','".$row[10]."',".$row[11].",'".$row[12]."','".$row[13]."',";
  $Instruccion = $Instruccion."'".$row[14]."','".$row[15]."','".$row[16]."','".$row[17]."',";
  $Instruccion = $Instruccion."'".$row[18]."','".$row[19]."','".$row[20]."','".$row[21]."','".$row[22]."',";
  $Instruccion = $Instruccion."'".$row[23]."','".$row[24]."',";
  
  // Esto es Titulo Congreso y los agregados de los nuevos pedidos
  
  $Instruccion = $Instruccion."'".$row[25]."','".$row[26]."',";
  $Instruccion = $Instruccion."'".$row[27]."','".$row[28]."','".$row[29]."','".$row[30]."',".$row[31].",";
  $Instruccion = $Instruccion."'".$row[32]."','".$row[33]."','".$row[34]."','".$row[35]."','".$row[36]."',".$row[37].",";
  $Instruccion = $Instruccion."'".$row[38]."',".$row[39].",'".$row[40]."',".$row[41].",'".$row[42]."','".$row[43]."','".$row[44]."',";
  
  // Estas son las fechas de alta
  

    
  $Instruccion = $Instruccion."'".$row[45]."','".$Ultimo_Estado."'";  
  $Instruccion = $Instruccion.",'".$row[47]."','".$row[48]."',".$row[49].",".$row[50].",".$row[51].",".$row[52];       	
  $Instruccion = $Instruccion.",'".$row[53]."','".$row[54]."','".$row[55]."',";
$Instruccion = $Instruccion.$row[59].",".$row[60].",".$row[61].",".$row[57].",'".$row[65]."',".$row[66].")";
// echo $Instruccion;  	
  $result = mysql_query($Instruccion);        
  echo mysql_error();  
  $query = "UPDATE Archivos_Pedidos  SET Permitir_Download = 1 WHERE codigo_pedido = '".$Id."'";
	  $resu = mysql_query($query);
	  echo mysql_error();

  // Por ultimo elimina la info de los pedidos y eventos
  $Instruccion = "DELETE FROM Eventos WHERE Codigo_Evento=".Devolver_Estado_Download()." and Id_Pedido='".$Id."'";   
  $result = mysql_query($Instruccion); 

	  
  $Instruccion = "DELETE FROM PedHist WHERE Id='".$Id."'";   
  $result = mysql_query($Instruccion);                  

  $Instruccion = "DELETE FROM EvHist WHERE Id_Pedido='".$Id."'";   
  $result = mysql_query($Instruccion); 
}



  include_once "../inc/fgenhist.php";
  include_once "../inc/fgentrad.php";
  include_once "../inc/conexion.inc.php";  
  Conexion();
    global $IdiomaSitio;
   $Mensajes = Comienzo ("gen-anu",$IdiomaSitio);
   

   Subir_Historico($Id_Pedido,$Fecha_Anulacion,$Causa_Anulacion,$Id_usuario);
    		

?>
<div align="center">
  <center>
<table border="0" width="85%" bgcolor="#006699" height="25">
  <tr>
    <td width="100%" align="center"><font face="MS Sans Serif" size="1" color="#FFFF00">
              <b><? echo $Mensajes["tf-3"]." ".$Usuario." ".$Mensajes["tf-4"]." ".$Id_Pedido; ?></b></font>
        
    </td>  
  </tr>
</table>
  </center>
</div>
<P ALIGN="center">
<input type="button" value="<? echo $Mensajes["bot-3"]; ?>" name="B2" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold" OnClick="javascript:self.close()">

<? 
	Desconectar();
?>
<P ALIGN="center">
<FONT FACE="MS Sans Serif" SIZE="1"><FONT COLOR="#000080">cp:</FONT>gen-anu</FONT>

</body>

<script language="Javascript">
	actualizar()
</script>

</html>
















