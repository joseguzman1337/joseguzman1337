<html>
<head> <title> Pruebas para uploads </title> </head>
<body>
Archivo upload.php <br>

<?
/* 
funciones para hacer uploads de archivos
*/

function subir_archivo($archivo,$destino) {
copy($archivo,$destino);
}
if ($_FILES['userfile']) {
echo "<ol>";
echo "<li>".$_FILES['userfile']['name'];
//El nombre original del fichero en la máquina cliente. 

echo "<li>".$_FILES['userfile']['type'];
//El tipo mime del fichero (si el navegador lo proporciona). Un ejemplo podría ser "image/gif". 

echo "<li>".$_FILES['userfile']['size'];
//El tamaño en bytes del fichero recibido. 

echo "<li>".$_FILES['userfile']['tmp_name'];
echo "</ol>"; }

if ($existe != 1) {
?>

<form enctype="multipart/form-data" action="upload.php" method="post">
<input type="hidden" name="MAX_FILE_SIZE" value="1000000"> <!-- max: 10 MB -->
Send this file: <input name="userfile" type="file">
<input type="hidden" name="existe" value=1>
<br>Destino: <input type="text" name="destino" value="/usr/local/Archivos">
<input type="submit" value="Send File">
</form>

<?
  }
  else
  {echo "Existe vale ".$existe."<br>";
   
   if (is_uploaded_file($_FILES['userfile']['tmp_name']))
   {
    if (is_dir($destino))
       echo "<h3> ".$destino." es directorio valido </h3>";
     else
       echo "<h3> ".$destino." no es un directorio válido </h3>";
    
    echo "El tamaño del archivo a subir es: <b> ".($_FILES['userfile']['size']/1024)." </b> Kbytes <br>";   
    $destino = $destino."/".$_FILES['userfile']['name'];
   // $destino = "/services/upload/";
    echo "<b> La ubicacion destino es: ".$destino." </b> <br>";
    if (!copy($_FILES['userfile']['tmp_name'],$destino))
       echo "<h4> Copiando con copy ha fallado </h4>";
     else
       echo "<h4> Copia de archivos con copy resultó satisfactorio </h4>";
    if (move_uploaded_file($_FILES['userfile']['tmp_name'],$destino))
      echo "<h4> Mov. OK </h4>";
    else
      echo "<h4> Movimiento de archivos con move_uploaded_file ha fallado </h4>"; 
   } 
   else
     echo "No se ha podido cargar el archivo seleccionado";
   echo "<br> <a href='upload.php'> Recargar pagina </a>";	  
  }
  echo phpinfo();
?>
</body>
</html>
