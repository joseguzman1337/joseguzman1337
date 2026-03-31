<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>Subiendo Archivo Matriculados</title>
	<link rel="STYLESHEET" type="text/css" href="estilos_admin.css">
</head>
<body>
<!-- <h1 align="center">Subiendo un archivo</h1> -->
<br> 
<div align="center">
<?
//tomo el valor de un elemento de tipo texto del formulario
$cadenatexto = $_POST["cadenatexto"];
echo "Escribió en el campo de texto: " . $cadenatexto . "<br><br>";
//datos del arhivo
$nombre_archivo = $HTTP_POST_FILES['userfile']['name'];
$tipo_archivo = $HTTP_POST_FILES['userfile']['type'];
$tamano_archivo = $HTTP_POST_FILES['userfile']['size'];
echo "$nombre_archivo <br> $tipo_archivo <br> $tamano_archivo";
//compruebo si las características del archivo son las que deseo
if((ereg("gif",$tipo_archivo) || ereg("jpeg",$tipo_archivo) || ereg("text",$tipo_archivo)) && ($tamano_archivo < 200000)) 
{ 
  ///if(move_uploaded_file($HTTP_POST_FILES['userfile']['tmp_name'], "/home/calidad/html/tmp/$nombre_archivo"))
	if(move_uploaded_file($HTTP_POST_FILES['userfile']['tmp_name'], "/var/tmp/$nombre_archivo"))  
	{
  	 echo "El archivo ha sido cargado correctamente.";
     echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=cargaarchivomatriculados.php'>";
	}
	else
	{
		echo "Ocurrió algún error al subir el fichero. No pudo guardarse.";
	}
}
else
{
	echo "La extensión o el tamaño de los archivos no es correcta. <br><br><table><tr><td><li>Se permiten archivos .gif o .jpg o .txt<br><li>se permiten archivos de 100 Kb máximo.</td></tr></table>";
}
?>
<br>
<br>
<!-- <a href="cargaarchivomatriculado.php">Volver</a> -->
<br>
</div>
</body>
</html>