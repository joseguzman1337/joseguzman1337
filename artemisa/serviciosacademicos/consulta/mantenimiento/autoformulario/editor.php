<?php
session_start();
if($_SESSION['usuario']<>"admintecnologia"  && $_SESSION['usuario'] <> "coordinadorsisinfo")
{

	echo "<h1>Usted no tiene permiso para ver esta página</h1>";
	exit();
}
?>
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<?php
class EditorArchivosPlanos
{
	var $ruta;
	var $nombrearchivo;

	function EditorArchivosPlanos($ruta,$nombrearchivo)
	{
		$this->ruta=$ruta;
		$this->nombrearchivo=$nombrearchivo;
	}

	function LeeArchivo()
	{
		if(file_exists($this->ruta.$this->nombrearchivo))
		{
			$apuntadorArchivo = fopen($this->ruta.$this->nombrearchivo,"rb");
			$contenido = fread($apuntadorArchivo, filesize($this->ruta.$this->nombrearchivo));
			fclose($apuntadorArchivo);
		}
		else
		{
			echo '<script language="javascript">alert("Archivo no existe")</script>';
		}
		return $contenido;
	}

	function EscribeArchivo($cadena)
	{
		if(!file_exists($this->ruta.$this->nombrearchivo))
		{
			$NuevoArchivo = fopen($this->ruta.$this->nombrearchivo, "x+");
			$exitoso=fwrite($NuevoArchivo,$cadena);
			fclose($NuevoArchivo);
		}
		else
		{
			echo $cadena;
			$NuevoArchivo = fopen($this->ruta.$this->nombrearchivo, "w");
			$exitoso=fwrite($NuevoArchivo,$cadena);
			fclose($NuevoArchivo);
		}
		if($exitoso)
		{
			echo '<script languaje="javascript">alert("Archivo Grabado correctamente")</script>';
		}
		else
		{
			if(!is_writable($this->ruta.$this->nombrearchivo))
			{
				echo '<script languaje="javascript">alert("No se tienen permisos de escritura")</script>';
			}
			echo '<script languaje="javascript">alert("Archivo No grabado correctamente")</script>';
		}
		return $exitoso;
	}
}

//error_reporting(0);
if($_GET['tabla']<>"" or isset($_GET['maestrodetalle']))
{
	$ruta="/var/tmp/";
	if(isset($_GET['maestrodetalle']))
	{
		$archivo="sala_maestrodetalle.txt";
	}
	else
	{
		$archivo=$_GET['tabla'].".txt";
	}

	echo $archivo;
	$editor = new EditorArchivosPlanos($ruta,$archivo);
	$contenido=$editor->LeeArchivo();
	echo '<form name="form1" action="" method="POST">'."\n";
	echo '<textarea name="editor" cols="140" rows="25">'.$contenido.'</textarea>'."\n";
	echo '<br><input type="submit" name="Enviar" value="Enviar">'."\n";
	if(isset($_GET['maestrodetalle']))
	{
		echo '<input type="button" name="Regresar" value="Regresar" onClick=reCarga("menu_maestrodetalle.php")>'."\n";
	}
	else
	{
		echo '<input type="button" name="Regresar" value="Regresar" onClick=reCarga("menu.php")>'."\n";
	}
	echo '</form>'."\n";
}
if(isset($_POST['Enviar']))
{
	if($_POST['editor']<>"")
	{
		$exito=$editor->EscribeArchivo($_POST['editor']);

		if($exito)
		{
			echo '<script languaje="javascript">window.location.reload("editor.php?tabla='.$_GET['tabla'].'");</script>';
		}
	}
}
?>

