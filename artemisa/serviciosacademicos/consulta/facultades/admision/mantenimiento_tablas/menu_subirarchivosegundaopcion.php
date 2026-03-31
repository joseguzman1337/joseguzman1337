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
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");//
require_once('subirarchivosegundaopcion.php' ); 


if($_GET['depurar']=='si')
{
	$_SESSION['depurar']==true;
}
//echo $_GET['codigocarrera'];
if($_GET['codigocarrera']=='todos' or $_GET['codigocarrera']=="")
{
	echo '<script language="javascript">alert("Debe seleccionar solo una carrera para la carga")</script>';
	echo '<script language="javascript">window.location.reload("menu.php")</script>';
	exit();
}
if(isset($_POST["boton"])){
//$_FILES
//$HTTP_POST_FILES
	$archivo_cargado_ok=cargarArchivo($_FILES,$_POST);
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Subir archivos</title>
	<link rel="STYLESHEET" type="text/css" href="estilos_admin.css">
</head>
<body>
<h1 align="center">Carga Archivo Con Resultados de Segunda Opción en la Carrera <?php echo $datoscarrera["nombrecarrera"]?></h1>
<br>

	<form action="" method="post" enctype="multipart/form-data" name="form1"> 

	  <div align="center"> <input type="hidden" name="cadenatexto" size="20" maxlength="100">
		    <input type="hidden" name="codigocarrera" value="<?php echo $_GET['codigocarrera']?>">	  		
		    <br>
		    <br>
		    <b>Subir archivo examenadmision.txt: </b>
		    <br>
            <input name="userfile" type="file"  id="userfile">		
            <br>
		    <br>
<b>Formato del archivo: </b>
<table border='1'><TR><TD>DOCUMENTO</TD><TD>SALON</TD><TD>EDIFICIO</TD><TD>FECHA</TD><TD>HORA</TD></TR></table>

<br><br>
		    <input name="boton" type="submit" id="boton" value="Enviar">
&nbsp;<input type="button" value="Regresar" Onclick="window.location.href='menuadministracionresultados.php'">
		</div>
	</form>

<?php
if($archivo_cargado_ok)
{
?>
<h3 align="center">El archivo fue cargado con éxito</h3>
<?php
echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=listadosegundaopcionpdf.php'>";
}
?>
</body>
</html>

