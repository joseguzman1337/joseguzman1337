<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once('../../../../funciones/clases/autenticacion/redirect.php' ); 


if($_GET['depurar']=='si')
{
	$_SESSION['depurar']==true;
}
//echo $_GET['codigocarrera'];
if($_GET['codigocarrera']=='todos' or $_GET['codigocarrera']=="")
{
	echo '<script language="javascript">alert("Debe seleccionar solo una carrera para la carga")</script>';
	echo '<script language="javascript">document.location.href="menu.php";</script>';
	exit();
}
//echo $codigocarrera;
/*
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');

$db->debug = true;*/
$objetobase=new BaseDeDatosGeneral($sala);
$datoscarrera=$objetobase->recuperar_datos_tabla("carrera c","c.codigocarrera",$_GET['codigocarrera'],"");

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>Subir archivos</title>
	<link rel="STYLESHEET" type="text/css" href="estilos_admin.css">
</head>
<body>
<h1 align="center">Carga Archivo Con Resultados del Examen de la Carrera <?php echo $datoscarrera["nombrecarrera"]?></h1>
<br>
	<form action="subirarchivoexamen.php" method="post" enctype="multipart/form-data">
	  <div align="center"> <input type="hidden" name="cadenatexto" size="20" maxlength="100">
		    <input type="hidden" name="codigocarrera" value="<?php echo $_GET['codigocarrera']?>">
	  		<input type="hidden" name="MAX_FILE_SIZE" value="100000">
		    <br>
		    <br>
		    <b>Subir archivo examenadmision.txt: </b>
		    <br>
            <input name="userfile" type="file">		
            <br>
		    <br><br><br>
		    <input type="submit" value="Cargar Nuevo Archivo">&nbsp;<input type="button" value="Regresar" Onclick="window.location.href='menuadministracionresultados.php'">
		</div>
	</form>
<?php
if(isset($_GET['cargado']))
{
?>
<h3 align="center">El archivo fue cargado con éxito</h3>
<?php
}
?>
</body>
</html>

