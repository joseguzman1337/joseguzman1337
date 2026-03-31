<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    ini_set('memory_limit', '64M');
    ini_set('max_execution_time','90');
    $rutaado=("../../../../funciones/adodb/");
    require_once('../../../../Connections/salaado-pear.php');
    require_once('../../../../funciones/clases/motor/motor.php');
    require_once('../../../../funciones/clases/debug/SADebug.php');
    require_once('../../../../funciones/sala_genericas/Excel/reader.php');
    //require_once('../../../../funciones/clases/autenticacion/redirect.php' );
    require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
    require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
    require('funciones/ObtenerDatos.php');
    require('funciones/clasesegundoexamen.php');

$objetobase=new BaseDeDatosGeneral($sala);

$fechahoy=date("Y-m-d H:i:s");
unset($_SESSION['log_subir_examen']);

?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
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
<?php
//tomo el valor de un elemento de tipo texto del formulario
$HTTP_POST_FILES=$_FILES;
$cadenatexto = $_POST["cadenatexto"];
echo "Escribió en el campo de texto: " . $cadenatexto . "<br><br>";

//datos del arhivo
$nombre_archivo = $HTTP_POST_FILES['userfile']['name'];
$tipo_archivo = $HTTP_POST_FILES['userfile']['type'];
$tamano_archivo = $HTTP_POST_FILES['userfile']['size'];
echo "$nombre_archivo <br> Tipo: $tipo_archivo <br> $tamano_archivo";

//compruebo si las características del archivo son las que deseo
//if((ereg("gif",$tipo_archivo) || ereg("jpeg",$tipo_archivo) || ereg("text",$tipo_archivo)) && ($tamano_archivo < 200000))
$extension = explode(".",$nombre_archivo);

if("xls"!=$extension[1])
{
	echo '<script language="javascript">
	alert("El archivo debe ser de excel '.$tipo_archivo.' ");
	history.go(-1);
	</script>';
	exit();

}
else if($tamano_archivo > 2000000)
{
	echo '
	<script language="javascript">
	alert("El archivo sobrepasa el tamaño adecuado para ser subido, maximo de 2Mb");
	history.go(-1);
	</script>';
	exit();


}
else
{

	if(move_uploaded_file($HTTP_POST_FILES['userfile']['tmp_name'], "/var/tmp/examenadmision.xls"))
	{
		$archivo_cargado_ok=true;
		echo "<h1>Archivo Cargado</h1>";
	}
	else
	{
		$archivo_cargado_ok=false;
		echo "Ocurrió algún error al subir el fichero. No pudo guardarse.";
	}
}

?>
<br>
<br>
<!-- <a href="cargaarchivomatriculado.php">Volver</a> -->
<br>
</div>
</body>
</html>

<?php
$dataexcel = new Spreadsheet_Excel_Reader();
$dataexcel->setOutputEncoding('CP1251');


if($archivo_cargado_ok==true)
{
	$depurar=true;
	if ($_SESSION['depurar']==true)
	{
		$depurar=true;
	}

	$codigocarrera = $_POST['codigocarrera'];
	$codigoperiodo = $_SESSION['codigoperiodo_seleccionado'];

	if($codigocarrera=="")
	{
		echo "<h1>No hay carrera seleccionada para poder subir archivo</h1>";
		echo '<script language="javascript">alert("Proceso de carga abortado")</script>';
		exit();
	}

	$admisiones = new TablasAdmisiones($sala,$depurar);
	$segundoexamen = new clasesegundoexamen($objetobase,$depurar);

	$array_subperiodo=$admisiones->LeerCarreraPeriodoSubPeriodo($codigocarrera,$codigoperiodo);

	$idsubperiodo=$array_subperiodo['idsubperiodo'];    
	$idadmision=$admisiones->LeerIdadmision($codigocarrera,$idsubperiodo);

	//$archivo = file('/var/tmp/examenadmision.txt');
	$dataexcel->read('/var/tmp/examenadmision.xls');
	$longitud=sizeof($archivo);
	/**
	 * Se arma primero un array bidimensional con los datos del archivo
	 */
	//for($i=0; $i<sizeof($archivo); $i++)
	//{
	$datosdetalleadmision=$admisiones->LeerDetalleAdmision($codigocarrera,$idsubperiodo,1);
	//echo "<br>";
	for($i=0; $i<$dataexcel->sheets[0]['numRows']; $i++)
	{
		//$array_precarga=explode(chr(9),$archivo[$i]);
		if($dataexcel->sheets[0]['cells'][$i][2]>0&&$dataexcel->sheets[0]['cells'][$i][2]<51){
		/*echo "$i-";
		echo $dataexcel->sheets[0]['cells'][$i][1];
		echo "-";
		echo $dataexcel->sheets[0]['cells'][$i][2];
		echo "-";*/
		//echo $puntaje=round($dataexcel->sheets[0]['cells'][$i][2]/$datosdetalleadmision['totalpreguntasdetalleadmision']*$datosdetalleadmision['porcentajedetalleadmision'],2);
		//echo "<br>";
		$array_carga[]=array('numerodocumento'=>$dataexcel->sheets[0]['cells'][$i][1],'puntaje'=>$dataexcel->sheets[0]['cells'][$i][2]);
		}
	}
	//echo "<br>";
	//print_r($array_carga);
	//exit();
	$tabla = new Tabla();
	if($depurar==true)
	{
		$tabla->DibujarTabla($array_carga,"Array de datos cargados del archivo");
	}
	/**
	 * Se lee array bidimensional y se crea un array con los datos del estudiante que hay en la bd
	 */
	$TodosPuntajesValidos=false;
	foreach ($array_carga as $llave => $valor)
	{
		if($valor['puntaje']=="")
		{
			$TodosPuntajesValidos=false;
		}
		$array_datos_estudiante[]=$admisiones->ObtenerDatosEstudiantePartiendoDesdeDocumento($valor['numerodocumento'],$codigocarrera);
	}
	if($depurar==true)
	{
		$tabla->DibujarTabla($array_datos_estudiante,"Array Datos Cargados de la BD");
	}
	/**
	 * Se verifica si todos los codigoestudiantes pertenecen a esta admision
	 */
	foreach ($array_datos_estudiante as $llave => $valor)
	{
		$array_detalleestudianteadmision=$segundoexamen->LeerDatosExamen($valor['codigoestudiante'],$codigocarrera,$idsubperiodo);
		$array_segundoexamen=$segundoexamen->LeerDatosSegundoExamen($valor['codigoestudiante'],$codigocarrera,$idsubperiodo);
		$array_segundoexamen["idhorariodetallesitioadmision"]=$array_detalleestudianteadmision["idhorariodetallesitioadmision"];
		$array_admision[]=$array_segundoexamen;
	}
	if($depurar==true)
	{
		$tabla->DibujarTabla($array_admision,"Array Datos a actualizar de tablas estudianteadmision y detalleestudianteadmision");
	}
	/**
	 * Se actualizan los datos de la bd, datos provenientes del array_admision
	 */
	$array_datos_actualizados=$segundoexamen->ActualizarDatosPruebasSegundoExamen($array_admision,$array_carga);
	if($depurar==true)
	{
		$tabla->DibujarTabla($array_datos_actualizados,"Array Resultado Actualización Datos");
	}
}

$suma_A=$admisiones->SumaArreglosBidimensionalesDelMismoTamano($array_carga,$array_datos_estudiante);
$suma_B=$admisiones->SumaArreglosBidimensionalesDelMismoTamano($suma_A,$array_admision);
$suma_C=$admisiones->SumaArreglosBidimensionalesDelMismoTamano($suma_B,$array_datos_actualizados);


$todosValidos=true;
foreach ($suma_C as $llave => $valor)
{
	if($valor['actualizadoOK']==false)
	{
		$todosValidos=false;
	}
}

if($todosValidos==false)
{
	$_SESSION['log_subir_examen']=$suma_C;
	$tabla->DibujarTabla($suma_C);
	echo '<script language="javascript">alert("¡NO todos los datos subieron OK!, mire la tabla de LOG")</script>';
	if($TodosPuntajesValidos==false)
	{
		echo '<script language="javascript">alert("No todos los datos del archivo de carga, tienen puntaje")</script>';
	}
	echo'<meta http-equiv="REFRESH" content="0;URL=log_subir_segundo_examen.php"/>';
}
else
{
	$_SESSION['log_subir_examen']=$suma_C;
	$tabla->DibujarTabla($suma_C);
	echo '<script language="javascript">alert("¡Todos los datos subieron OK!, mire la tabla de LOG")</script>';
	if($TodosPuntajesValidos==false)
	{
		echo '<script language="javascript">alert("No todos los datos del archivo de carga, tienen puntaje")</script>';
	}
	echo'<meta http-equiv="REFRESH" content="0;URL=log_subir_segundo_examen.php"/>';
}
?>


<?php
class Tabla
{
	function EscribirCabeceras($matriz)
	{
		echo "<tr>\n";
		echo "<td>Conteo</a></td>\n";
		while($elemento = each($matriz))
		{
			echo "<td>$elemento[0]</a></td>\n";
		}
		echo "</tr>\n";
	}

	function DibujarTabla($matriz,$texto="")
	{
		error_reporting(0);
		if(is_array($matriz))
		{
			echo "<table border=1 cellpadding='2' cellspacing='1' align=center>\n";
			echo "<caption align=TOP><h1>$texto</h1></caption>";
			$this->EscribirCabeceras($matriz[0],$link);
			for($i=0; $i < count($matriz); $i++)
			{
				$MostrarConteo=$i+1;
				echo "<tr>\n";
				echo "<td nowrap>$MostrarConteo&nbsp;</td>\n";
				while($elemento=each($matriz[$i]))
				{
					echo "<td nowrap>$elemento[1]&nbsp;</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table>\n";
		}
		else
		{
			echo $texto." Matriz no valida<br>";
		}
		error_reporting(2047);
	}
}
?>
