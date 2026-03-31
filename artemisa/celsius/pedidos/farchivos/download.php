<?
 include_once "../../inc/var.inc.php";
 include_once "../../inc/conexion.inc.php";
 Conexion(); 
 include_once "../../inc/identif.php";
 Usuario(); 
 include_once "../../inc/fgenhist.php";
 include_once "../../inc/funcarch.php";
// include_once "../inc/"."agregar_mov.php";


/* Esta pagina permitirá hacer el download de los archivos. Los administradores podrán bajarse cualquier archivo,
sin restricción alguna.
Para los usuarios comunes, descontará de la cuenta corriente el monto corresopondiente por el download.
Los parámetros que se reciben en esta pagina son:
$esAdmin: indica si el download lo hace un administrador o un usuario comun
$archivo: el nombre del archivo que se va a bajar
$id: el id del archivo que se va a bajar
*/
   $query = "SELECT Archivos_Pedidos.nombre_archivo,Archivos_Pedidos.Permitir_Download
	     FROM Archivos_Pedidos
             WHERE Archivos_Pedidos.codigo = ".$Id_Archivo;
  $resu = mysql_query($query);
 
echo mysql_error();
    $tupla = mysql_fetch_row($resu);



   if ($tupla) {
// Cuando hace el download, se deberá registrar el pedido como entregado 
   if (isset($adm) || ($tupla[1] == 1))  //para que se pueda bajar un archivo, el usuario tiene que tener permiso o ser un administrador
   {$size = filesize(devolverDirectorioArchivos()."/".$tupla[0]);
    $filename = $tupla[0];
   //echo $filename;
   header("Content-type: application/pdf");
   header("Content-Disposition:attachment; filename= $filename");
   header("Accept-Ranges: bytes");
   header("Content-Length:$size");
   //echo devolverDirectorioArchivos()."/".$tupla[0]." - ".$size;
   @readfile(devolverDirectorioArchivos()."/$filename");
   //bloqueo el archivo, para que no se lo pueda volver a bajar
     
     if (!isset($adm) or ($adm==0) or ($rol == 2))
      //si es usuario comun o bibliotecario(rol = 2), deberá registrarse el download, verificar si va al historico (y en tal caso, enviarlo).
      //Si es un usuario administrador el que realiza el download, no debería incrementar en uno la cantidad de downloads,
      //ni enviar el pedido al historico
      
      {$query = "UPDATE Archivos_Pedidos
             SET Permitir_Download = 0
			 WHERE codigo = ".$Id_Archivo;
	  $resu = mysql_query($query);
	  echo mysql_error();
         //sumo uno a la cantidad de archivos bajados
         $query2 = "UPDATE Pedidos
              SET Archivos_Bajados = Archivos_Bajados + 1
			  WHERE Id = '".$Id_Pedido."'";
          $resu = mysql_query($query2);
	  echo mysql_error();
   //me fijo si tiene que pasar al historico
	$query3 = "SELECT Archivos_Totales, Archivos_Bajados
	           From Pedidos
			   WHERE Id = '".$Id_Pedido."'";
  	$resu = mysql_query($query3);
	 echo mysql_error();
	 $row = mysql_fetch_row($resu);
    
	// Comienzo Esto estoy probando Ariel
	
     
	 // Fin 

	 if ($row[0] == $row[1]) //ya se han bajado todos los archivos del pedido. El mismo deberá pasar al historial
	 {
	
	 if (!isset($Paises))
    	 {
       	$Paises = 0;       
    	  }
    
    	 if (!isset($Instituciones))
    	 {
      		$Instituciones = 0;
    	 }
    
    	 if (!isset($Dependencias))
    	 {
      		$Dependencias = 0;
    	  }
    
    	 if (!isset($Numero_Paginas))
    	 {
      		$Numero_Paginas = 0;
    	 }

		 if (!isset($Observaciones))
    	 {
      		$Observaciones ='';
    	 }
      
    	 if (isset($Es_Privado))
    	 {
      		$Es_Privado = 1;
    	  }
    	 else
    	 {
      		$Es_Privado = 0; 
    	 }
 
	  
	  $Dia = date ("d");
   	  $Mes = date ("m");
   	  $Anio = date ("Y");
   	  $FechaHoy =$Anio."-".$Mes."-".$Dia;
      if(!isset($Operador)){$Operador=0;}
  
		$Instruccion = "INSERT INTO Eventos (Id_Pedido,Codigo_Evento,Codigo_Pais,Codigo_Institucion,Codigo_Dependencia,Fecha,Observaciones"; 
     		$Instruccion = $Instruccion.",Operador,Es_Privado,Numero_Paginas) VALUES ('".$Id_Pedido."',".Devuelve_Evento_Download().",".$Paises.",".$Instituciones.",".$Dependencias;
     		$Instruccion = $Instruccion.",'".$FechaHoy."','".AddSlashes($Observaciones)."',".$Operador.",".$Es_Privado.",".$Numero_Paginas.")";
            
     		//$result = mysql_query($Instruccion);

	
	
	//echo $Instruccion;
	  
  
	  $query4 = "UPDATE Pedidos SET Estado = ".Devolver_Estado_Download()."	  WHERE Id = '".$Id_Pedido."'";
	  //$query4 = "UPDATE Pedidos SET Estado =40 WHERE Id = '".$Id_Pedido."'";
	  $resu = mysql_query($query4);
	  echo mysql_error();
     
	   Bajar_Historico($Id_Pedido);
	  // devolverIdCuenta($Id_Usuario);
     //  insertarMovimiento($ultimo_id_recibo,$User,$total_a_pagar,1);
	 
	 }
	 //registro el Download que se acaba de realizar
	 $query4 = "INSERT INTO Downloads (codigo_archivo,codigo_usuario,Fecha,IP_usuario) VALUES (".$Id_Archivo.",".$Id_Usuario.",NOW(),'".$_SERVER['REMOTE_ADDR']."')";
	 $resu = mysql_query($query4);
	  echo mysql_error();
    }
   }
   }
  else 
      /* el pedido no estaba en la tabla pedidos. Si es un usuario administrador, 
       se busca en PEdidos Historicos, sino se le comunica al usuario que el pedido 
	ya ha sido bajado */
	{ $query = "SELECT Archivos_Pedidos.nombre_archivo
	            FROM Archivos_Pedidos
                    WHERE Archivos_Pedidos.Permitir_Download = 1
			  and Archivos_Pedidos.codigo = ".$Id_Archivo;
         $resu = mysql_query($query);
		echo mysql_error();
         $tupla = mysql_fetch_row($resu);

		
		
	include_once "../../inc/fgenped.php";
        include_once "../../inc/fgentrad.php";
        $Mensajes = Comienzo ("dow-001",$IdiomaSitio);
        $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
		 echo "<body background='../../imagenes/banda.jpg'>";

           echo "<table bgcolor='#B7CFE1' align='center' width='70%' cellspacing=0>
		          <tr height=40>
				     <td bgcolor='#B7CFE1' valign='middle' align='center' colspan='2'>
					 <font face='MS Sans Serif' size='1' color='#333399'>".$Mensajes['err-1']." </font> </td> </tr>";
		   echo " <tr height='40'> <td width='50%' bgcolor='#79A7C8' valign='middle' align='center'>
		           <font face='MS Sans Serif' size='1' color='#000000'>
				   <b> <a href='../../comunidad/indexcom2.php'>".$Mensajes['err-02']."</a> </td>
				   <td width='50%' align='center' bgcolor='#79A7C8' valign='middle'>
				   <font face='MS Sans Serif' size='1' color='#000000'>
				   <b> <a href='../manpedcur.php?dedonde=1&adm=0'>".$Mensajes['err-03']."</a>
				    </td> </tr></table> </body>";

		}


?>

