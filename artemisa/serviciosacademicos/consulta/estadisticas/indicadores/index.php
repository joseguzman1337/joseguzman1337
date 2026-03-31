<?php
session_start();
$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/phpmailer/class.phpmailer.php");
require_once("../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/FuncionesSeguridad.php");
require_once("../../../funciones/sala_genericas/FuncionesMatematica.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/tabla.php");
require_once("../../../funciones/sala_genericas/dibujaformulario.php");
$rutaPHP="../../sic/librerias/php/";
if(!isset($_SESSION['sissic_iditemsic'])||trim($_SESSION['sissic_iditemsic'])=='')
$_SESSION['sissic_iditemsic']=$_REQUEST['iditemsic'];
else
	if(isset($_REQUEST['iditemsic'])&&$_SESSION['sissic_iditemsic']!=$_REQUEST['iditemsic'])
		$_SESSION['sissic_iditemsic']=$_REQUEST['iditemsic'];

$objetobase=new BaseDeDatosGeneral($sala);
$db=$objetobase->conexion;
require_once( '../../sic/aplicaciones/textogeneral/modelo/textogeneral.php');
$itemsic = new textogeneral($_SESSION['sissic_iditemsic']);

if($_GET["iditemsic"]>0)
$_SESSION['sissic_iditemsic']=$_GET["iditemsic"];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo1 {
	font-size: 18px;
	font-weight: bold;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<script LANGUAGE="JavaScript">
function cambiaestado(mensaje,iditemsic){

var imagen = window.parent.document.getElementById("img" + iditemsic);

    if(mensaje == 'insertado')
    {
       // alert("El valor fue insertado satisfactoriamente");
        //if(imagen.src == "imagenes/noiniciado.gif")
            imagen.src="imagenes/poraprobar.gif";
    }
    else if(mensaje == 'actualizado')
    {
       // alert("El valor fue actualizado satisfactoriamente");
        if(imagen.src == "imagenes/aprobado.gif")
            alert("ADVERTENCIA: El item ha quedado por aprobar debido a la modificación hecha");
       imagen.src= "imagenes/poraprobar.gif";
    }
    else if(mensaje != '')
    {
        alert("ERROR:" + mensaje);
    }

}
</script>
</head>

<body >
<table width="200" border="1" align="center" >
  <tr>
    <td ><div align="center" class="Estilo1">CUADRO DE MANDO INTEGRAL</div></td>
  </tr>
  <tr>
<!-- width="130" height="70"-->
    <td><!--<a href="menuindicadores.php?opciontipoindicador=cliente">-->
<div align="center"><a href="definiciones.html"><img src="../../../../imagenes/definiciones.png" ></a></div>
</td>
 </tr>

  <tr>
    <td><!--<a href="menuindicadores.php?opciontipoindicador=cliente"></a>-->
<div align="center"><img src="../../../../imagenes/perspectivaresponsabilidad.png" ></div>
</td>
 </tr>
  <tr>
<!-- <a href="menuindicadores.php?opciontipoindicador=cliente">-->
    <td><div align="center"><img src="../../../../imagenes/perspectivafinanciera.png">
</a></div></td>
 </tr>
  <tr>
    <td><div align="center"><a href="menuindicadores.php?opciontipoindicador=cliente"><img src="../../../../imagenes/perspectivausuario.png" >
</a></div></td>
 </tr>
  <tr>
    <td><div align="center"><a href="menuindicadores.php?opciontipoindicador=procesos"><img src="../../../../imagenes/perspectivaprocesos.png" >
</a></div></td>
 </tr>
  <tr>
    <td><div align="center"><a href="menuindicadores.php?opciontipoindicador=capital"><img src="../../../../imagenes/perspectivacapital.png">
</a></div></td>
 </tr>

</table>
<?php
$codigocarrera = $_SESSION['codigofacultad'];
$mensaje = $itemsic->insertarItemsiccarrera();
echo "<script type='text/javascript'>
		cambiaestado('".$mensaje."',".$_SESSION['sissic_iditemsic'].");
</script>";
?>
</body>
</html>