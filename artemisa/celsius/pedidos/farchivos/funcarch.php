<?   
  
 include_once "../../inc/"."conexion.inc.php";  
 Conexion();
 include_once "../../inc/"."identif.php";
 //Usuario();
 include_once "../../inc/"."fgenped.php";
 include_once "../../inc/"."fgentrad.php";
 

/**********************************
  Este archivo posee funciones "generales" para trabajar con archivos pdf y arv

***********************************/
function devolverDirectorioArchivos()
//retorna el directorio donde se almacenaran los arhivos pdf y arb. Si no se encuentra, retorna null
{
 $resu = mysql_query("SELECT directorio FROM Parametros");
 echo mysql_error();
 if ($row = mysql_fetch_row($resu))
  {return $row[0];
  }
  else
    return null;
}


define("DIRECTORIO", devolverDirectorioArchivos()); //esta constante contiene el directorio donde se almacenan los archivos
if (!is_dir(DIRECTORIO))
  echo DIRECTORIO." no es un directorio válido";

 //Estas variables GLOBALES almacenan el nombre y la extension del archivo con el que se estï¿½ trabajando. Las uso para poder usar las funciones que descomponen el nombre del archivo...
$nombre = '';  //solo el nombre del archivo
$extension = '';  // solo la extensiï¿½n del archivo


function upload_File($filename,$tmp_name)
//recibe del vector _FILES el nombre del archivo y el temporal , y "manda" el archivo
//que se quiere subir al directorio correspondiente (DIRECTORIO)
{ $destino = DIRECTORIO;
    if (!is_dir($destino))
    {
      echo "<p> <font color='FF0000'> ".$destino." </font> no es un directorio válido  </p>";
      return false;
    }
    if (is_uploaded_file($tmp_name)) {
      //chmod($destino,777);
	  if (!move_uploaded_file($tmp_name,$destino."/".$filename)) { 
        echo "<p> Archivo: <font color='FF0000'>".$filename." </font>. No se pudo mover </p>";
	return false;
         }
       else {
//        echo "<p> Archivo: <font color='FF0000'>".$filename." </font>. Upload              realizado satisfactoriamente </p>";
	return true;
       }
    }	
     else {
      echo "<p> Archivo: <font color='FF0000'>".$filename." </font>. No es un archivo válido </p>";
      return false;
     } 
}


function devolverValorPorHoja()
//Retorna el valor por hoja de la base de datos
{$resu = mysql_query("SELECT valor_hoja FROM Parametros");
	echo mysql_error();
 if ($row = mysql_fetch_row($resu))
    return $row[0];
 else
    return 0;
}

function obtenerDetalleArchivo($nombreArchivo)
/* Toma el nombre de un archivo -- nombreArchivo -- y retorna el nombre y la extension. En caso que no posea extension, retorna vacío*/
{ global $nombre, $extension;

  $inicio_extension = strpos($nombreArchivo,'.');

  if ($inicio_extension)
    { $extension = substr($nombreArchivo,$inicio_extension + 1,strlen($nombreArchivo)-1);
      $nombre = substr($nombreArchivo,0,$inicio_extension);
    }
    else
      {
       $nombre = $nombreArchivo;
       $extension = '';
      }
  return 1;

}

function verificarCuentaCorriente($pedido)
{
  return 1;
}

function puedeBajarse($unArchivo,$pedido)
/*Esta funcion dice si un usuario puede bajarse o no un archivo, con el siguiente criterio:
retorna 1 si puede bajarse el archivo (no había problemas)
retorna 0 si el archivo no permite ser bajado (Permitir_Download = 0). En tal caso, el usuario no podrá ver que el archivo está disponible
retorna -1 si el archivo permite bajarse, pero existen otros problemas por los cuales no puede ser bajado (cuenta corriente inexistente, o en rojo, etc...) 
*/
{ //proximamente se deberá verificar que el usuario cumpla más condiciones
if ($unArchivo['Permitir_Download'])
  if (verificarCuentaCorriente($pedido))
    return 1;
   else
    return -1;
else
  return 0;

}

function buscarArchivoFisico($nombreArchivo)
{ 
  global $nombre,$extension;


	/*
Busca el archivo $nombreArchivo en el directorio donde se guardan
los archivos en el servidor, definido en la constante DIRECTORIO. El $nombreArchivo puede incluir la extensiï¿½n del archivo, pero no es necesario
Retorna 
  1 si el archivo existe y es pdf
  2 si existe y es arb
  3 si existe ese nombre pero no es formato (no deberï¿½a suceder)
  0 en caso contrario
    */

obtenerDetalleArchivo($nombreArchivo);

//echo '<br> <u> <li>Nombre: '.$nombre.' <li> Extension: '.$extension.' <li> Completo: '.$nombreArchivo;
$retorno = 0;

if ($extension == '') //solo se ingresï¿½ el nombre del archivo
	{
	 $existe_pdf = file_exists(DIRECTORIO."/".$nombre.'.pdf');
	 $existe_arb = file_exists(DIRECTORIO."/".$nombre.'.arv');
	 
	 if ($existe_pdf)
		 $retorno = 1;
	 else if ($existe_arb)
		 $retorno = 2;
	 else $retorno = 0;
	}
 else //se ingresï¿½ un nombre de archivo completo (con extension)
	{
	 if (file_exists(DIRECTORIO."/".$nombreArchivo))
	  { 
		if ((strcmp($extension,'pdf') == 0) || (strcmp($extension,'PDF') == 0))
		   $retorno = 1;
        else 
			if ((strcmp($extension,'arv') == 0) || (strcmp($extension,'ARV') == 0))
		  	   $retorno = 2; 
		    else     
               $retorno = 3;
	  }
	 else //ese archivo no existï¿½a 
		$retorno = 0;

	}
	return $retorno;
 }
 
function devolverArchivosDePedido($pedido,$esAdmin)
/* 
Recibe un pedido (codigo) y retorna todos los archivos que posee asociado dicho pedido de la forma:
codigo (Archivos_Pedidos)
nombre_archivo
Permitir_Download
en un vector asociativo.
 En caso de no existir ningún archivo para ese pedido, retorna null.
*/
{  $archivos = array();
   $query = "SELECT codigo,nombre_archivo,Permitir_Download
           FROM Archivos_Pedidos
	   WHERE codigo_pedido = '".$pedido."' or codigo_pedHist = '".$pedido."'";
 $resu=mysql_query($query);
   echo mysql_error();
   while ($row = mysql_fetch_row($resu))
   {  if (!$esAdmin) //los usuarios comunes solo verán archivos pdf
	   {
 	   obtenerDetalleArchivo($row[1]);
           global $extension;
           if ($extension == 'pdf') //habría que encontrar una mejor forma de decir cuales son las extensiones válidas	   
	          array_push($archivos,array('Codigo' => $row[0],'Nombre' => $row[1],'Permitir_Download' => $row[2]));
           }
       else { //si es admin, va cualquier archivo
		array_push($archivos,array('Codigo' => $row[0],'Nombre' => $row[1],'Permitir_Download' => $row[2]));    
	    }	    
   }
  
   return $archivos;
}

function asociarPedidoAArchivo($idPedido,$nombreArchivo, $downloadPermitido,$esHistorico)
/* Busca el archivo nombreArchivo en el directorio DIRECTORIO.
Si $nombreArchivo solo posee el nombre sin la extensiï¿½n, busca primero pdfs y luego arv (con ese orden de prioridad), sino directamente ese archivo.
En caso de encontrarlo, genera una nueva tupla con:
   Fecha_Upload con las fecha y hora actual;
   Permitir_Download con el valor de la variable parï¿½metro $downloadPermitido
   codigo_pedHist con null
   Si $esHistorico entonces 
      codigo_pedHist con el valor del parï¿½metro $idPedido
      codigo_pedido null
   sino
      codigo_pedHist null
      codigo_pedido con el valor del parï¿½metro $idPedido
nombre_archivo con $nombreArchivo
Una vez que se ha cargado la tabla Archivos_Pedidos, se incrementa en la tabla pedidos
la cantidad de archivos que tiene ese pedido
Al finalizar, la funcion retorna el codigo generado, o 0 si no se generï¿½ ningï¿½n registro.

*/
{ global $nombre,$extension;
  $tipoArchi = buscarArchivoFisico($nombreArchivo);
   if ($tipoArchi)
	{ $squery = "SELECT codigo,codigo_pedido,codigo_pedHist,nombre_archivo from Archivos_Pedidos where";
	  $query = "INSERT into Archivos_Pedidos (Fecha_Upload,nombre_archivo,codigo_pedido,codigo_pedHist,Permitir_Download) VALUES (NOW()";
	 
	  $squery .= " nombre_archivo='".$nombre.".".$extension."'";
	  $query .= ",'".$nombre.".".$extension."'";

      if (!$esHistorico) {
		 $query .= ",'".$idPedido."', null";
	        }
        else {
		 $query .= ",null,'".$idPedido."'";
	       }
        $squery .= " and (codigo_pedHist = '".$idPedido."' or codigo_pedido = '".$idPedido."')";

	 if ($downloadPermitido)
		 $query .= ",1";
	 else
		 $query .= ",0";

	 $query .= ")";

	 $resu = mysql_query($squery);
	 echo mysql_error();

	 //echo "Affected rows: ".mysql_num_rows($resu);
	 if (mysql_num_rows($resu)  == 0)
	 { $result = mysql_query($query);
	   echo mysql_error();
	   $last = mysql_insert_id();
     // echo "La extension es: ".$extension;
     if (($extension=='pdf') || ($entension=='PDF')) //solo los pdfs suman archivos
		 {     $query2 = "UPDATE Pedidos
	            SET Archivos_Totales = Archivos_Totales + 1
				WHERE Id = '".$idPedido."'";
       //      echo "Actualizando";
        	 $resultado = mysql_query($query2);
        	 echo mysql_error();
		 }


	    return $last;
      }
       else  
	   /*El pedido (sin importar si es actual o historial) ya estaba cargado para ese archivo. */
          return 0;
	}//if $tipoArch
	else
	 { //el archivo no fue encontrado
	  echo "<b> El archivo no ".$nombreArchivo." fue encontrado </b>";
	  return 0;
	  
	 }

}


function autorizarDownload($archivo,$usuario,$operador,$causaAutorizacion,$causaSolicitud,$autorizado)
/* Donde:
$archivo es el codigo del archivo
$usuario, $operador son id de la tabla Usuarios
Precondicion: tanto el archivo como los usuarios existen en la base de datos. No sea hacen comprobaciones 
de existencia en ésta función.
$autorizado indica si el usuario es autorizado o no
$causaAutorizacion, $causaSolicitud son las causas por los que se lo autoriza, y el motivo por el que el 
usuario solicito autorizacion.
Crea una nueva tupla en autorizaciones. También accede a Archivos_Pedidos, para modificar el $archivo el
campo Permitir_Download (de acuerdo a lo que indique el parametro $autorizado)
*/
{ /*
  $qinsert = "INSERT INTO Autorizaciones(codigo_archivo,fecha,codigo_usuario,codigo_operador,motivo_solicitud,Motivo_Aceptado_Rechazado,aceptado_rechazado) VALUES (";
  $qinsert .= $archivo.",NOW(),".$usuario.",".$operador.",'".$causaSolicitud."','".$causaAutorizacion."',";
  
  $qupdate = "UPDATE Archivos_Pedidos SET Permitir_Download = ";
  if ($autorizado)
   { $qinsert .= "1";
     $qupdate .= "1";	   
   }
   else //se desautoriza explícitamente el download
      { $qinsert .= "0";
	$qupdate .= "0";      
      }
   
   $qinsert .= ")";
   $qupdate .= " WHERE codigo = ".$archivo;
   
   
  
  $resu_insert = mysql_query($qinsert);
     echo mysql_error();
  $resu_update = mysql_query($qupdate);
     echo mysql_error();
*/
     
}


function devolver_autorizaciones($usuario)
/* Esta función retorna todas las autorizaciones que posee un usuario, en un vector donde
cada posición es un vector con:
codigo del archivo (Codigo)
nombre del archivo (Nombre)
indicacion si el archivo se puede bajar (Permitido)
indicacion si la autorizacion es para aceptar o para rechazar (Autorizacion)
*/
{$unArchivo = array();
 $archivos = array();	
/*	
 $query = "SELECT Archivos_Pedidos.codigo, nombre_archivo, Permitir_Download, aceptado_rechazado
          FROM Autorizaciones, Archivos_Pedidos
	  WHERE Autorizaciones.codigo_usuario = ".$usuario." 
	  and Autorizaciones.codigo_archivo = Archivos_Pedidos.codigo";
	  
 $result = mysql_query($query);
    echo mysql_error();
 
  while ($row = mysql_fetch_row($result))
  {
   array_push($archivos,array('Codigo' =>$row[0],'Nombre'=>$row[1],'Permitido' => $row[2], 'Autorizacion' => $row[3]));
   echo $unArchivo['Codigo'];
   echo $unArchivo['Nombre'];
   echo $unArchivo['Permitido'];
   echo $unArchivo['Autorizacion'];
  }
  
  return $archivos;  
*/
 }


function generar_listado_downloads($usuario)
{ /*
  $archivos = devolver_autorizaciones($usuario);
  echo "<table border=1>";
  for($i=0;$i<count($archivos);$i++) {
	  $unArchivo = $archivos[$i];
	  echo "<tr> <td>";
  	  if ($unArchivo['Permitido']) 
	       echo "<a href='download.php?archivo=".$unArchivo['Codigo']."&usuario=".$usuario."'>".$unArchivo['Nombre']."</a>";
	  else
	       echo "<p>".$unArchivo['Nombre']."</p>"; 
	    echo "</td> </tr>"; 
	  } 
  echo "</table>"; 
  return 0; */
}


 
 /* Sector de pruebas de las funciones arriba definidas. Esta secciï¿½n deberï¿½ ser eliminada de este archivo*/



/*
//el usuario 1202 soy yo (Gonzalo)
//Primero autorizo a Gonzalo a bajarse el archivo 1
autorizarDownload(1,1202,1202,"Se portó bien","porfis",1);
//Luego desautorizo a Gonzalo a bajarse el archivo 2
autorizarDownload(2,1202,1202,"Se portó mal","autorizame ahora!!!",0);
*/

/*
generar_listado_downloads(1202);
$unArchivo = array();
$list = array();
$list=devolverArchivosDePedido('ARG-UNLP-0011615');
echo "<br> <b> Pedido ARG-UNLP-0011615. </b>Archivos:<br>";
if ($list) {
  echo "Cantidad de archivos encontrados: ".count($list).". ";
  for ($i=0;$i<count($list);$i++) {
    $unArchivo = $list[$i];	  
    echo $unArchivo['Codigo']." - ".$unArchivo['Nombre'];
    if ($unArchivo['Permitir_Download'])
      echo " <b>Permite download</b><br>";
    else 
      echo " <b>No permite download</b><br>";
  }
}
else
  echo "el pedido ARG-UNLP-0011615 no posee archivos"; 
  
$list = devolverArchivosDePedido('ARG-UNLP-0011134');
 echo "<br> <b> Pedido ARG-UNLP-0011134. </b>Archivos:<br>";
if ($list) {
	echo "Cantidad de archivos encontrados: ".count($list).". ";
  for ($i=0;$i<count($list);$i++) {
    $unArchivo = $list[$i];	  
    echo $unArchivo['Codigo']." - ".$unArchivo['Nombre'];
    if ($unArchivo['Permitir_Download'])
      echo " <b>Permite download</b><br>";
    else 
      echo " <b>No permite download</b><br>";
  }  
}
else
  echo "el pedido ARG-UNLP-0011134 no posee archivos";


$list = devolverArchivosDePedido('ARG-UNLP-1');
 echo "<br> <b> Pedido ARG-UNLP-1. </b>Archivos:<br>";
if ($list) {
	echo "Cantidad de archivos encontrados: ".count($list).". ";
  for ($i=0;$i<count($list);$i++) {
    $unArchivo = $list[$i];	  
    echo $unArchivo['Codigo']." - ".$unArchivo['Nombre'];
    if ($unArchivo['Permitir_Download'])
      echo " <b>Permite download</b><br>";
    else 
      echo " <b>No permite download</b><br>";
  } 
}
else
  echo "el pedido ARG-UNLP-1 no posee archivos";
 */ 
?>
