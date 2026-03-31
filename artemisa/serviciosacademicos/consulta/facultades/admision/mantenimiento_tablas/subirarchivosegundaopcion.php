<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
function cargarArchivo($HTTP_POST_FILES,$_POST){
	//tomo el valor de un elemento de tipo texto del formulario
	//
	/*echo "HTTP_POST_FILES<pre>";
	print_r($HTTP_POST_FILES);	
	echo "</pre>";*/
$archivo_cargado_ok=0;
	$cadenatexto = $_POST["cadenatexto"];
	//echo "Escribió en el campo de texto: " . $cadenatexto . "<br><br>";
	//datos del arhivo
	$nombre_archivo = $HTTP_POST_FILES['userfile']['name'];
	$tipo_archivo = $HTTP_POST_FILES['userfile']['type'];
	$tamano_archivo = $HTTP_POST_FILES['userfile']['size'];
	//echo "$nombre_archivo <br> Tipo: $tipo_archivo <br> $tamano_archivo";
	
	//compruebo si las características del archivo son las que deseo
	//if((ereg("gif",$tipo_archivo) || ereg("jpeg",$tipo_archivo) || ereg("text",$tipo_archivo)) && ($tamano_archivo < 200000))
	$extension = explode(".",$nombre_archivo);
	
	if("xls"!=$extension[1])
	{
		alerta_javascript("El archivo debe ser de excel");
		//exit();
	
	}
	else if($tamano_archivo > 2000000)
	{

		alerta_javascript("El archivo sobrepasa el tamaño adecuado para ser subido, maximo de 2Mb");
		//exit();
	
	
	}
	else
	{
	
		if(copy($HTTP_POST_FILES['userfile']['tmp_name'], "/tmp/segundaoopcionadmisiones.xls"))
		{
			$archivo_cargado_ok=1;
			//echo "<h1>Archivo Cargado</h1>";
			alerta_javascript("Archivo Cargado");
		}
		else
		{
			$archivo_cargado_ok=0;
			alerta_javascript("Ocurrió algún error al subir el fichero. No pudo guardarse.");
		}
	}
return $archivo_cargado_ok;
	}
?>

