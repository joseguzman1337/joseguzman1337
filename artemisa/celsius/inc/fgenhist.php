<?

/*if (__fgenhist_inc == 1)
		return;
	define ('__fgenhist_inc', 1);
*/
 
include_once "fgenped.php";
//include_once "funcarch.php";

function Pasa_Historico($Estado)
{
  if ($Estado==7 || $Estado==8)//  || $Estado==12 ) //El estado 12 es cuando el usuario se baja el PDF, con lo que el pedido estaría entregado
  {
    return 1;
  }
  else
  {
    return 0;
  }
}


function Bajar_Historico($Id)
{  	

  $expresion = "SELECT Pedidos.Id,Pedidos.Codigo_Usuario,Tipo_Pedido,Tipo_Material,Titulo_Libro,Autor_Libro,Editor_Libro"; 
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
  $expresion = $expresion.",Instituciones.Codigo_Pais,Usuarios.Codigo_Institucion,Usuarios.Codigo_Dependencia,Observado,Tipo_Usuario_Crea,Usuario_Creador,Archivos_Totales,Archivos_Bajados";

  $expresion = $expresion." FROM Pedidos";
  $expresion = $expresion." LEFT JOIN Usuarios ON Usuarios.Id=Pedidos.Codigo_usuario";
  $expresion = $expresion." LEFT JOIN Instituciones ON Usuarios.Codigo_Institucion=Instituciones.Codigo";
  $expresion = $expresion." WHERE Pedidos.Id='".$Id."'";


  
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

  // 19-7 Procesamiento de Slashes

  for ($i=0;$i<=61;$i++)
  {
	  if (strpos($row[$i],"'")>0)
	  {
		  $row[$i]=AddSlashes($row[$i]);
	  }
  }


  
  $Instruccion = "INSERT INTO PedHist (Id,Codigo_Usuario,Tipo_Pedido,Tipo_Material,Titulo_Libro,Autor_Libro,Editor_Libro"; // 0- 6
  $Instruccion = $Instruccion.",Anio_Libro,Desea_Indice,Capitulo_Libro,Numero_Patente,Codigo_Pais_Patente,Pais_Patente,Anio_Patente";//7-13
  $Instruccion = $Instruccion.",Autor_Detalle1,Autor_Detalle2,Autor_Detalle3,Codigo_Titulo_Revista";//14-17
  $Instruccion = $Instruccion.",Titulo_Revista,Titulo_Articulo,Volumen_Revista,Numero_Revista,Anio_Revista";//18-22
  $Instruccion = $Instruccion.",Pagina_Desde,Pagina_Hasta,TituloCongreso,Organizador,NumeroLugar,Anio_Congreso";//23-28
  $Instruccion = $Instruccion.",PaginaCapitulo,PonenciaActa,Codigo_Pais_Congreso,Otro_Pais_Congreso,TituloTesis";//29-33
  $Instruccion = $Instruccion.",AutorTesis,DirectorTesis,GradoAccede,Codigo_Pais_Tesis,Otro_Pais_Tesis,Codigo_Institucion_Tesis";//34-39
  $Instruccion = $Instruccion.",Otra_Institucion_Tesis,Codigo_Dependencia_Tesis,Otra_Dependencia_Tesis,Anio_Tesis,PagCapitulo";//40-44
  $Instruccion = $Instruccion.",Fecha_Alta_Pedido,Estado,Biblioteca_Sugerida,Observaciones,Ultimo_Pais_Solicitado,Ultima_Institucion_Solicitado,Ultima_Dependencia_Solicitado,Operador_Corriente";// 45-52
  $Instruccion = $Instruccion.",Fecha_Inicio_Busqueda,Fecha_Recepcion,Fecha_Solicitado,Fecha_Entrega"; //53-56
  $Instruccion = $Instruccion.",Tardanza_Atencion,Tardanza_Busqueda,Tardanza_Recepcion,Numero_Paginas,Observado,Tipo_Usuario_Crea,Usuario_Creador,Archivos_Totales,Archivos_Bajados) VALUES (";
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
  
  $Instruccion = $Instruccion."'".$row[45]."','".$row[46]."'";  
  $Instruccion = $Instruccion.",'".$row[47]."','".$row[48]."',".$row[49].",".$row[50].",".$row[51].",".$row[52];       	
  $Instruccion = $Instruccion.",'".$row[53]."','".$row[54]."','".$row[55]."','".$row[56]."',";
  $Instruccion = $Instruccion.$row[59].",".$row[60].",".$row[61].",".$row[57].",".$row[65].",".$row[66].",".$row[67].",".$row[68].",".$row[69].")";
    	
  $result = mysql_query($Instruccion);        
  echo mysql_error();  
  
  
 
  $Instruccion = "SELECT Id_Pedido,Codigo_Evento,Codigo_Pais,Codigo_Institucion,Codigo_Dependencia,Fecha,Observaciones,Operador,Es_Privado,Numero_Paginas,Id_Correo FROM Eventos WHERE Id_Pedido='".$row[0]."'";
  $result = mysql_query($Instruccion);
  echo mysql_error();
  while($row = mysql_fetch_row($result))
  {
     if ($row[10]=="")
     {
     	$row[10]=0;
     }
     $Instruccion = "INSERT INTO EvHist (Id_Pedido,Codigo_Evento,Codigo_Pais,Codigo_Institucion,Codigo_Dependencia,Fecha,Observaciones"; 
     $Instruccion .= ",Operador,Es_Privado,Numero_Paginas,Id_Correo) VALUES ('";
	 $Instruccion .= $row[0]."',".$row[1].",".$row[2].",".$row[3].",".$row[4].",'".$row[5];
     $Instruccion = $Instruccion."','".AddSlashes($row[6])."',".$row[7].",".$row[8].",".$row[9].",".$row[10].")";
     $result2 = mysql_query($Instruccion); 
     echo mysql_error();  
     
  }
   
      
  $Instruccion = "DELETE FROM Pedidos WHERE Id='".$Id."'";   
  $result = mysql_query($Instruccion);                  

  $Instruccion = "DELETE FROM Eventos WHERE Id_Pedido='".$Id."'";   
  $result = mysql_query($Instruccion);                  

  
}

function Bajar_Anulados($Id,$Fecha,$Causa,$Operador)
{  	

  $expresion = "SELECT Pedidos.Id,Pedidos.Codigo_Usuario,Tipo_Pedido,Tipo_Material,Titulo_Libro,Autor_Libro,Editor_Libro"; 
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
  $expresion = $expresion.",Instituciones.Codigo_Pais,Usuarios.Codigo_Institucion,Usuarios.Codigo_Dependencia,Observado,Tipo_Usuario_Crea,Usuario_Creador";

  $expresion = $expresion." FROM Pedidos";
  $expresion = $expresion." LEFT JOIN Usuarios ON Usuarios.Id=Pedidos.Codigo_usuario";
  $expresion = $expresion." LEFT JOIN Instituciones ON Usuarios.Codigo_Institucion=Instituciones.Codigo";
  $expresion = $expresion." WHERE Pedidos.Id='".$Id."'";

 // echo $expresion;
  
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
  
  // Numero de páginas
  // esta condicion no se da con los históricos porque para bajarlo exige
  // el número de páginas
  
   if ($row[57]=="")  
  {
    $row[57]=0;
  }
 
  
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

  // 19-7 Procesamiento de Slashes

  for ($i=0;$i<=61;$i++)
  {
	  if (strpos($row[$i],"'")>0)
	  {
		  $row[$i]=AddSlashes($row[$i]);
	  }
  }



  $Instruccion = "INSERT INTO PedAnula (Id,Codigo_Usuario,Tipo_Pedido,Tipo_Material,Titulo_Libro,Autor_Libro,Editor_Libro"; // 0- 6
  $Instruccion = $Instruccion.",Anio_Libro,Desea_Indice,Capitulo_Libro,Numero_Patente,Codigo_Pais_Patente,Pais_Patente,Anio_Patente";//7-13
  $Instruccion = $Instruccion.",Autor_Detalle1,Autor_Detalle2,Autor_Detalle3,Codigo_Titulo_Revista";//14-17
  $Instruccion = $Instruccion.",Titulo_Revista,Titulo_Articulo,Volumen_Revista,Numero_Revista,Anio_Revista";//18-22
  $Instruccion = $Instruccion.",Pagina_Desde,Pagina_Hasta,TituloCongreso,Organizador,NumeroLugar,Anio_Congreso";//23-28
  $Instruccion = $Instruccion.",PaginaCapitulo,PonenciaActa,Codigo_Pais_Congreso,Otro_Pais_Congreso,TituloTesis";//29-33
  $Instruccion = $Instruccion.",AutorTesis,DirectorTesis,GradoAccede,Codigo_Pais_Tesis,Otro_Pais_Tesis,Codigo_Institucion_Tesis";//34-39
  $Instruccion = $Instruccion.",Otra_Institucion_Tesis,Codigo_Dependencia_Tesis,Otra_Dependencia_Tesis,Anio_Tesis,PagCapitulo";//40-44
  $Instruccion = $Instruccion.",Fecha_Alta_Pedido,Estado,Biblioteca_Sugerida,Observaciones,Ultimo_Pais_Solicitado,Ultima_Institucion_Solicitado,Ultima_Dependencia_Solicitado,Operador_Corriente";// 45-52
  $Instruccion = $Instruccion.",Fecha_Inicio_Busqueda,Fecha_Recepcion,Fecha_Solicitado,Fecha_Entrega"; //53-56
  $Instruccion = $Instruccion.",Tardanza_Atencion,Tardanza_Busqueda,Tardanza_Recepcion,Numero_Paginas,Observado,Tipo_Usuario_Crea,Usuario_Creador ";
  $Instruccion.= ",Fecha_Anulacion,Causa_Anulacion,Operador_Anula) VALUES (";
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
  
  $Instruccion = $Instruccion."'".$row[45]."','".$row[46]."'";  
  $Instruccion = $Instruccion.",'".$row[47]."','".$row[48]."',".$row[49].",".$row[50].",".$row[51].",".$row[52];       	
  $Instruccion = $Instruccion.",'".$row[53]."','".$row[54]."','".$row[55]."','".$row[56]."',";
  $Instruccion = $Instruccion.$row[59].",".$row[60].",".$row[61].",".$row[57].",".$row[65].",".$row[66].",".$row[67];
  $Instruccion.= ",'".$Fecha."','".AddSlashes($Causa)."',".$Operador.")";
  // echo $Instruccion;
  $result = mysql_query($Instruccion); 
  echo mysql_error();  

 // Cuando se anula un evento las causas, fecha y operador se
 // replican para cada uno de los eventos.
   
  Baja_Eventos_Anulados ($Id,1,$Fecha,$Causa,$Operador);
  
      
  $Instruccion = "DELETE FROM Pedidos WHERE Id='".$Id."'";   
  $result = mysql_query($Instruccion);                  

  
}

function Baja_Eventos_Anulados($Id,$dedonde,$Fecha,$Causa,$Usuario)
{
  // El selector de dedonde sirve para saber si hay que bajar todos los
  // pedidos o solo el ultimo. Tambien sirce para identificar si $Id
  // es el Id del pedido o el Id del evento. Es llamado desde arriba y
  // desde el proceso de anulación de un evento
  
  if ($dedonde==1)
  {  
  	$Instruccion = "SELECT Id_Pedido,Codigo_Evento,Codigo_Pais,Codigo_Institucion,Codigo_Dependencia,Fecha,Observaciones,Operador,Es_Privado,Numero_Paginas,Id_Correo FROM Eventos WHERE Id_Pedido='".$Id."'";  
  }
  else
  {
    // Esta instruccion le va a producir solo una fila de resultado
  	$Instruccion = "SELECT Id_Pedido,Codigo_Evento,Codigo_Pais,Codigo_Institucion,Codigo_Dependencia,Fecha,Observaciones,Operador,Es_Privado,Numero_Paginas,Id_Correo FROM Eventos WHERE Id=".$Id;  
  }	
  
  //echo $Instruccion;
  $result = mysql_query($Instruccion);
  echo mysql_error();
  while($row = mysql_fetch_row($result))
  {
     if ($row[10]=="")
     {
     	$row[10]=0;
     }
     $Instruccion = "INSERT INTO EvAnula (Id_Pedido,Codigo_Evento,Codigo_Pais,Codigo_Institucion,Codigo_Dependencia,Fecha,Observaciones"; 
     $Instruccion = $Instruccion.",Operador,Es_Privado,Numero_Paginas,Id_Correo,Fecha_Anulacion,Causa_Anulacion,Operador_Anulacion) VALUES ('".$row[0]."',".$row[1].",".$row[2].",".$row[3].",".$row[4].",'".$row[5];
     $Instruccion = $Instruccion."','".AddSlashes($row[6])."',".$row[7].",".$row[8].",".$row[9].",".$row[10].",'".$Fecha."','".AddSlashes($Causa)."',".$Usuario.")";
     $result2 = mysql_query($Instruccion); 
	  echo mysql_error();  
     
	 if ($row[1]==Devuelve_Evento_Download())
	  {
	     $i="select * from Archivos_Pedidos where codigo_pedido='".$row[0]."'";
	     
		 $r=mysql_query($i);
         $in="update Pedidos set Archivos_Totales=0 where Id='".$row[0]."'";
         $re=mysql_query($in);
		 
		 
		 define("DIRECTORIO", devolverDirectorioArchivos()); //esta constante contiene el directorio donde se almacenan los archivos
         //if (!is_dir(DIRECTORIO))
         //echo DIRECTORIO." no es un directorio válido 22";
		 $destino=DIRECTORIO;
		 echo "Destino".$destino;
		 while ($fila=mysql_fetch_array($r))
		  {
		   // Elimino del Servidor todos aquellos archivos del Pedido
           unlink($destino."/".$fila["nombre_archivo"]);
		  }
         $ins="delete from Archivos_Pedidos where codigo_pedido='".$row[0]."'";
		 $rel=mysql_query($ins);
      }
  }

  if ($dedonde==1)
  {  
    $Instruccion = "DELETE FROM Eventos WHERE Id_Pedido='".$Id."'";   
  }
  else
  {
    $Instruccion = "DELETE FROM Eventos WHERE Id=".$Id;   
  }
  	
  $result = mysql_query($Instruccion);                  

   
}

?>
