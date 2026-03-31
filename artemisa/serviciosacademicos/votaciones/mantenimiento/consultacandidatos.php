<?php
session_start();
$rutaado=("../../funciones/adodb/");
require_once("../../Connections/salaado-pear.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../funciones/sala_genericas/FuncionesSeguridad.php");
require_once("../../funciones/sala_genericas/FuncionesSeguridad.php");

function buscarDatosDocente($objetobase,$documento)
{
$condicion=" and d.iddocente=c.iddocente and now() between fechainiciocontratodocente and fechafinalcontratodocente";
$datosdocente=$objetobase->recuperar_datos_tabla("docente d, contratodocente c","d.numerodocumento",$documento,$condicion,"",0);
if(isset($datosdocente["nombredocente"])&&trim($datosdocente["nombredocente"])!='')
	echo "<verificacion>OK</verificacion>";
else
	echo "<verificacion>NOENCONTRADO</verificacion>";

echo "<nombre>".$datosdocente["nombredocente"]."</nombre>";
echo "<apellido>".$datosdocente["apellidodocente"]."</apellido>";
echo "<telefono>".$datosdocente["telefonoresidenciadocente"]."</telefono>";
echo "<celular>".$datosdocente["numerocelulardocente"]."</celular>";
echo "<direccion>".iconv("UTF-8","UTF-8",quitartilde(quitarsaltolinea(str_replace("&","&amp;",str_replace("<","",$datosdocente["direcciondocente"])))))."</direccion>";
//str_replace("-"," ",str_replace("º","o",


	$archivo1="../../../imagenes/estudiantes/".$datosdocente["numerodocumento"].".jpg";
	$archivo2="../../../imagenes/estudiantes/".$datosdocente["numerodocumento"].".JPG";

	if(is_file($archivo1)){
		echo "<imagen>".$archivo1."</imagen>";
		$archivoencontrado=1;
	}
	else if(is_file($archivo2)){
		echo "<imagen>".$archivo2."</imagen>";
		$archivoencontrado=1;
	}

	if(!$archivoencontrado){
			echo "<imagen>../../../imagenes/desconocido.jpg</imagen>";
	
	}


}
function buscarDatosEstudiante($objetobase,$documento)
{
$condicion =" and o.numeroordenpago=d.numeroordenpago
					and eg.idestudiantegeneral=e.idestudiantegeneral
						AND e.codigoestudiante=pr.codigoestudiante
						AND pr.codigoperiodo='".$_SESSION['codigoperiodosesion']."'
						AND e.codigoestudiante=o.codigoestudiante
						AND c.codigocarrera=e.codigocarrera
						AND d.codigoconcepto=co.codigoconcepto
						AND co.cuentaoperacionprincipal=151
						AND o.codigoperiodo='".$_SESSION['codigoperiodosesion']."'
						AND o.codigoestadoordenpago LIKE '4%'
						and c.codigomodalidadacademica in ('200','300')";				
$datosestudiante=$objetobase->recuperar_datos_tabla("ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr,estudiantegeneral eg","eg.numerodocumento",$documento,$condicion,'',0);

if(isset($datosestudiante['nombresestudiantegeneral'])&&trim($datosestudiante['nombresestudiantegeneral'])!='')
	echo "<verificacion>OK</verificacion>";
else
	echo "<verificacion>NOENCONTRADO</verificacion>";

echo "<nombre>".iconv("UTF-8","UTF-8",str_replace("&","&amp;",str_replace("<","",$datosestudiante["nombresestudiantegeneral"])))."</nombre>";
echo "<apellido>".iconv("UTF-8","UTF-8",str_replace("&","&amp;",str_replace("<","",$datosestudiante["apellidosestudiantegeneral"])))."</apellido>";
echo "<telefono>".$datosestudiante["telefonoresidenciaestudiantegeneral"]."</telefono>";
echo "<celular>".$datosestudiante["celularestudiantegeneral"]."</celular>";
echo "<direccion>".iconv("UTF-8","UTF-8",quitartilde(quitarsaltolinea(str_replace("&","&amp;",str_replace("<","",$datosestudiante["direccionresidenciaestudiantegeneral"])))))."</direccion>";

$resultado=$objetobase->recuperar_resultado_tabla("estudiantedocumento","idestudiantegeneral",$datosestudiante["idestudiantegeneral"],"","",0);

$archivoencontrado=0;
while($rowdocumento = $resultado->fetchRow()){
	$archivo1="../../../imagenes/estudiantes/".$rowdocumento["numerodocumento"].".jpg";
	$archivo2="../../../imagenes/estudiantes/".$rowdocumento["numerodocumento"].".JPG";

	if(is_file($archivo1)){
		echo "<imagen>".$archivo1."</imagen>";
		$archivoencontrado=1;
	}
	else if(is_file($archivo2)){
		echo "<imagen>".$archivo2."</imagen>";
		$archivoencontrado=1;
	}

}
if(!$archivoencontrado){
		echo "<imagen>../../../imagenes/desconocido.jpg</imagen>";

}

}
function buscarDatosEgresado($objetobase,$documento)
{

$condicion=" and e.idestudiantegeneral=eg.idestudiantegeneral
		and e.codigosituacioncarreraestudiante in ('400','104')";
$datosegresado=$objetobase->recuperar_datos_tabla("estudiante e, estudiantegeneral eg","eg.numerodocumento",$documento,$condicion,'',0);

if(isset($datosegresado['nombresestudiantegeneral'])&&trim($datosegresado['nombresestudiantegeneral'])!='')
	echo "<verificacion>OK</verificacion>";
else
	echo "<verificacion>NOENCONTRADO</verificacion>";

echo "<nombre>".$datosegresado["nombresestudiantegeneral"]."</nombre>";
echo "<apellido>".$datosegresado["apellidosestudiantegeneral"]."</apellido>";
echo "<telefono>".$datosegresado["telefonoresidenciaestudiantegeneral"]."</telefono>";
echo "<celular>".$datosegresado["celularestudiantegeneral"]."</celular>";
echo "<direccion>".iconv("UTF-8","UTF-8",quitartilde(quitarsaltolinea(str_replace("&","&amp;",str_replace("<","",$datosegresado["direccionresidenciaestudiantegeneral"])))))."</direccion>";


$resultado=$objetobase->recuperar_resultado_tabla("estudiantedocumento","idestudiantegeneral",$datosegresado["idestudiantegeneral"],"","",0);

$archivoencontrado=0;
while($rowdocumento = $resultado->fetchRow()){
	$archivo1="../../../imagenes/estudiantes/".$rowdocumento["numerodocumento"].".jpg";
	$archivo2="../../../imagenes/estudiantes/".$rowdocumento["numerodocumento"].".JPG";

	if(is_file($archivo1)){
		echo "<imagen>".$archivo1."</imagen>";
		$archivoencontrado=1;
	}
	else if(is_file($archivo2)){
		echo "<imagen>".$archivo2."</imagen>";
		$archivoencontrado=1;
	}

}
if(!$archivoencontrado){
		echo "<imagen>../../../imagenes/desconocido.jpg</imagen>";

}


}
	$objetobase=new BaseDeDatosGeneral($sala);
	

	header('Expires: Fri, 25 Dec 1980 00:00:00 GMT'); // time in the past
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
	header('Cache-Control: no-cache, must-revalidate');
	header('Pragma: no-cache');
	// generate the output in XML format
	header('Content-type: text/xml');
	echo '<?xml version="1.0" encoding="UTF-8"?>';
	echo '<data>';
	switch($_GET['tipocandidato']){
	case 1:
		buscarDatosDocente($objetobase,$_GET['documento']);
	break;
	case 2:
		buscarDatosEstudiante($objetobase,$_GET['documento']);
	break;
	case 3:
		buscarDatosEgresado($objetobase,$_GET['documento']);
	break;

	}
	echo '</data>';

	//echo "SESSION<br>";
	//print_r($_SERVER);
	//return 1;
