<?php
session_start();
?>
<link rel="stylesheet" type="text/css" href="../serviciosacademicos/sala.css">
<link rel="stylesheet" type="text/css" href="ajaxgrid.css">

<link rel="stylesheet" type="text/css" href="../serviciosacademicos/estilos/sala.css">
<script type="text/javascript" src="prototype.js"></script>
<script type="text/javascript" src="FuncionesCadenas.js"></script>
<script type="text/javascript" src="funcionesGridAjax.js"></script>

<script LANGUAGE="JavaScript">
function regresarGET()
{
	document.location.href="<?php echo 'menuinicialaportes.php';?>";
}
function reCarga(){
	document.location.href="<?php echo 'menuinicialaportes.php';?>";
}
function cambiaaction()
{
	location.href="<?php echo 'listadocierreaportes.php';?>";
}

/*nuevosLimites(5,30,5,0,1);
nuevosLimites(5,30,5,0,1);*/

//quitarFrame()
</script>


<?php
$rutaado=("../serviciosacademicos/funciones/adodb/");
require_once("../serviciosacademicos/Connections/salaado-pear.php");
require_once("../serviciosacademicos/funciones/validaciones/validaciongenerica.php");
require_once("../serviciosacademicos/funciones/sala_genericas/FuncionesCadena.php");
require_once("../serviciosacademicos/funciones/sala_genericas/FuncionesFecha.php");
require_once("../serviciosacademicos/funciones/sala_genericas/FuncionesMatriz.php");

require_once("../serviciosacademicos/funciones/clases/motorv2/motor.php");

$query="SELECT * FROM usuario LIMIT 50";
$operacion=$sala->query($query);
while ($row_operacion=$operacion->fetchRow())
{
	if(!empty($row_operacion))
	{
		$array_interno[]=$row_operacion;
	}
}
$motor = new matriz($array_interno,'CARRERA',$_SERVER['REQUEST_URI']."?Filtrar=Filtrar","si","","","listadocierreaportes.php?Filtrar=Filtrar","","");

//$motor->asignarLimitesDatosDinamicos('carrera',2,0,2,50,'actualizartexto');
//$motor->asignarLimitesDatosDinamicos('carrera','codigocarrera',3,0,3,50,'actualizartexto');

$motor->asignarColumnaDatosDinamicos('usuario','idusuario','usuario','usuario','actualizartexto','requerido');
$motor->asignarColumnaDatosDinamicos('usuario','idusuario','numerodocumento','numerodocumento','actualizartexto','requerido');

$motor->creaArrayParametrosAjax();
$motor->mostrar();
$motor->DibujarTablaNormal($motor->arrayLimitesDatosDinamicos);
?>
