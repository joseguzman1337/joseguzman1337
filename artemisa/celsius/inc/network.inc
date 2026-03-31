<?

include_once "parametros.inc.php";

// Esta es la fcion ppal
function Generar_Pedido_Remoto ($Id_Pais,$Id_Institucion,$Id_Dependencia,$Id_Pedido,$link,$Request,$Biblioteca_Destino)
{
  
  $Mi_Binding=Obtener_Mi_Binding();
  echo $Mi_Binding;
  $Id_Binding=Obtener_Binding_Correcto($Id_Pais,$Id_Institucion,$Id_Dependencia);
  echo $Binding;
  
  if ($Id_Binding!=0)
  {
  	$link2 = Obtener_Algun_Directorio();
	if ($link2!="")
	{
		//Accedo a Directorio y obtengo IP's BDD, Port, etc del servidor
		//al cual redirijo el pedido
		
		mysql_select_db("Directorio",$link2);
		$expresion = "SELECT Server_BDD,Puerto_BDD,Nombre_BDD,User_BDD,Pass_BDD FROM Deploy WHERE Id=".$Id_Binding;
		$result = mysql_query($expresion,$link2);
		echo mysql_error();
		if (mysql_num_rows($result)>0)
		{
		  $row = mysql_fetch_row($result);
		  mysql_close($link2);
		  
		  // Este es el servidor objetivo
		  
		  $link2 =  mysql_connect ($row[0].":".$row[1],$row[3],$row[4]);
		  if ($link2!="")
		  { 
			// Lo primero es obtener el binding apropiado para mi
			// en la instalacion remota, esto me proveera el código de pais, de institucion, dependencia, etc
			
			mysql_select_db($row[2],$link2);
			$Instruccion = "SELECT Codigo_Pais,Codigo_Institucion,Codigo_Dependencia,Codigo_Usuario FROM Bindings WHERE Id_Entrada_Dir=$Mi_Binding";
			$result=mysql_query($Instruccion,$link2);
			echo mysql_error();
			$row = mysql_fetch_row($result);
						
			
			//Ahora es la parte final que es guardar el pedido en
			//el servidor remoto
			Guardar_Pedido_en_Remoto($Id_Pedido,$row[0],$row[1],$row[2],$row[3],$link,$link2,$Request,$Biblioteca_Destino);
			
			mysql_close($link2);
			
		  }
		}		
	}
	
  }
  
}

function Obtener_Binding_Correcto($Id_Pais,$Id_Institucion,$Id_Dependencia)
{
  $Instruccion = "SELECT Id_Entrada_Dir FROM Bindings WHERE Codigo_Pais=$Id_Pais AND Codigo_Institucion=$Id_Institucion AND Codigo_Dependencia=$Id_Dependencia";
  $result=mysql_query($Instruccion);
  echo mysql_error();
  if (mysql_num_rows($result)==0)
  {
  	$Instruccion = "SELECT Id_Entrada_Dir FROM Bindings WHERE Codigo_Pais=$Id_Pais AND Codigo_Institucion=$Id_Institucion";
	$result=mysql_query($Instruccion);
	if (mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
	}
	else
	{
	  return 0;
	}
  }
  else
  {
    $row=mysql_fetch_array($result);
  }
  return $row[0];
}

function Obtener_Algun_Directorio()
{
   $expresion = "SELECT IP_Mysql,Puerto_Mysql,Usuario_Mysql,Password_Mysql,Nombre FROM Directorios ORDER BY Orden";   
   $result = mysql_query($expresion);
   echo mysql_error();
    
   // Recorre todas las entradas de la tabla directorio
   // para intentar conectarse con alguna de ellas	 
   
    $salida=0;
	
    while ($row = mysql_fetch_array($result))
    {
	// echo $row[0]; 
	 $link2 = mysql_connect($row[0].":".$row[1],$row[2],$row[3]);
	 if ($link2=="")
	 {
	   continue;
	 }  
	 $salida=1;
	 break;	  	
	 }
	 
	if ($salida==1)
	{
	  return $link2;
    }
	else
	{
	  return "";
	}	

}

function Obtener_Mi_Binding()
{
	$Instruccion = "SELECT Id_Entrada_Dir FROM Bindings WHERE Es_Instalacion_Local=1";
	$result=mysql_query($Instruccion);
	$row=mysql_fetch_row($result);
	return $row[0];
}

function Guardar_Pedido_en_remoto($Id_Pedido_Local,$Pais,$Institucion,$Dependencia,$Usuario,$link,$link2,$Request,$Biblioteca)
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
  $expresion = $expresion." WHERE Pedidos.Id='".$Id_Pedido_Local."'";


  
  $result = mysql_query($expresion,$link);
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

  $Id_Remoto = Obtener_Id_Remoto($link2,$Institucion);  
  echo $Id_Remoto;

  $Instruccion = "INSERT INTO Pedidos (Id,Codigo_Usuario,Tipo_Pedido,Tipo_Material,Titulo_Libro,Autor_Libro,Editor_Libro"; // 0- 6
  $Instruccion = $Instruccion.",Anio_Libro,Desea_Indice,Capitulo_Libro,Numero_Patente,Codigo_Pais_Patente,Pais_Patente,Anio_Patente";//7-13
  $Instruccion = $Instruccion.",Autor_Detalle1,Autor_Detalle2,Autor_Detalle3,Codigo_Titulo_Revista";//14-17
  $Instruccion = $Instruccion.",Titulo_Revista,Titulo_Articulo,Volumen_Revista,Numero_Revista,Anio_Revista";//18-22
  $Instruccion = $Instruccion.",Pagina_Desde,Pagina_Hasta,TituloCongreso,Organizador,NumeroLugar,Anio_Congreso";//23-28
  $Instruccion = $Instruccion.",PaginaCapitulo,PonenciaActa,Codigo_Pais_Congreso,Otro_Pais_Congreso,TituloTesis";//29-33
  $Instruccion = $Instruccion.",AutorTesis,DirectorTesis,GradoAccede,Codigo_Pais_Tesis,Otro_Pais_Tesis,Codigo_Institucion_Tesis";//34-39
  $Instruccion = $Instruccion.",Otra_Institucion_Tesis,Codigo_Dependencia_Tesis,Otra_Dependencia_Tesis,Anio_Tesis,PagCapitulo";//40-44
  $Instruccion = $Instruccion.",Fecha_Alta_Pedido,Estado,Biblioteca_Sugerida,Observaciones,Ultimo_Pais_Solicitado,Ultima_Institucion_Solicitado,Ultima_Dependencia_Solicitado,Operador_Corriente";// 45-52
  $Instruccion = $Instruccion.",Fecha_Inicio_Busqueda,Fecha_Recepcion,Fecha_Solicitado,Fecha_Entrega"; //53-56
  $Instruccion = $Instruccion.",Tardanza_Atencion,Tardanza_Busqueda,Tardanza_Recepcion,Numero_Paginas,Observado,Tipo_Usuario_Crea,Usuario_Creador) ";
  $Instruccion.= " VALUES (";
  $Instruccion = $Instruccion."'".$Id_Remoto."',".$Usuario.",2,".$row[3].",'".$row[4]."','".$row[5]."','".$row[6]."',";
  $Instruccion = $Instruccion."'".$row[7]."',".$row[8].",'".$row[9]."','".$row[10]."',".$row[11].",'".$row[12]."','".$row[13]."',";
  $Instruccion = $Instruccion."'".$row[14]."','".$row[15]."','".$row[16]."','0',";
  $Instruccion = $Instruccion."'".$row[18]."','".$row[19]."','".$row[20]."','".$row[21]."','".$row[22]."',";
  $Instruccion = $Instruccion."'".$row[23]."','".$row[24]."',";
  
  // Esto es Titulo Congreso y los agregados de los nuevos pedidos
  
  $Instruccion = $Instruccion."'".$row[25]."','".$row[26]."',";
  $Instruccion = $Instruccion."'".$row[27]."','".$row[28]."','".$row[29]."','".$row[30]."',".$row[31].",";
  $Instruccion = $Instruccion."'".$row[32]."','".$row[33]."','".$row[34]."','".$row[35]."','".$row[36]."',".$row[37].",";
  $Instruccion = $Instruccion."'".$row[38]."',".$row[39].",'".$row[40]."',".$row[41].",'".$row[42]."','".$row[43]."','".$row[44]."',";
  
  // Estas son las fechas de alta
  
  $Instruccion = $Instruccion."'".$row[45]."',1";  
  $Instruccion = $Instruccion.",'".$Biblioteca."','#Req:".$Request." ".$row[47]."',".$row[49].",".$row[50].",".$row[51].",0";       	
  $Instruccion = $Instruccion.",'".$row[53]."','".$row[54]."','".$row[55]."','".$row[56]."',";
  $Instruccion = $Instruccion.$row[59].",".$row[60].",".$row[61].",".$row[57].",".$row[65].",".$row[66].",".$Usuario;
  $Instruccion.= ")";

  $result = mysql_query($Instruccion); 
  echo mysql_error();  

  
   }			
   
   function Obtener_Id_Remoto($link2,$Institucion)
   {
//       $Instruccion = "LOCK TABLES Instituciones WRITE, Paises READ"; 
//       $result = mysql_query($Instruccion); 
       
       $Instruccion = "SELECT Instituciones.Abreviatura,Paises.Abreviatura,Instituciones.Codigo_Pedidos ";
       $Instruccion = $Instruccion."FROM Instituciones LEFT JOIN Paises ON Paises.Id=Instituciones.Codigo_Pais ";
       $Instruccion = $Instruccion."WHERE Codigo=".$Institucion;
       $result = mysql_query($Instruccion,$link2); 
	   echo mysql_error();
       $rowg = mysql_fetch_row($result);
	   
       $NumeroX = $rowg[2]+1;
       $Codigo_Pedido = $rowg[1]."-".$rowg[0]."-".sprintf("%07d",$NumeroX);
	   mysql_free_result($result);
       
       $Instruccion = "UPDATE Instituciones SET Codigo_Pedidos =".$NumeroX." WHERE Codigo=".$Institucion;
       $result = mysql_query($Instruccion,$link2);    		  
	   return $Codigo_Pedido;
	   
//       $result = mysql_query($Instruccion);    		  
//       echo mysql_error();
    	
   }

?>
