<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../estilos/sala.css">
</head>
<body>
<?php

$fechahoy=date("Y-m-d H:i:s");
$rutaado=("../funciones/adodb/");
require_once('../Connections/salaado-pear.php');
require_once("../funciones/clases/motorv2/motor.php");
require_once("../funciones/clases/formulariov2/clase_formulario.php");
require_once("funciones/obtenerDatos.php");

if(isset($_GET['depurar']) and $_GET['depurar']=='si')
{
	$depurar=true;
}

$votacion = new Votaciones(&$sala,$codigocarrera,$depurar);
$array_datos_votacion=$votacion->retornaArrayDatosVotacion();
$array_tipos_plantillas_votacion=$votacion->retornaArrayTiposPlantillasVotacion();
$array_plantillas_votacion=$votacion->retornaArrayPlantillasVotacion();
$array_detalle_plantillas_votacion=$votacion->retornaArrayDetallePlantillasVotacion();

$idplantillavotacion=$_GET['idplantillavotacion'];
foreach ($_SESSION['array_plantillas_ampliado'] as $llave_tipo_plantillas => $valor_tipo_plantillas){
	if(is_array($valor_tipo_plantillas))
	foreach ($valor_tipo_plantillas as $llave_plantillas => $valor_plantillas){

		if($idplantillavotacion==$llave_plantillas){
			$codigocarrera=$_SESSION['array_plantillas_ampliado'][$llave_tipo_plantillas][$idplantillavotacion]['codigocarrera'];
			$array_plantilla_escogida=$_SESSION['array_plantillas_ampliado'][$llave_tipo_plantillas][$llave_plantillas];
			break;
		}
	}
}
/* echo "$idplantillavotacion<pre>";
print_r($array_plantilla_escogida);
echo "</pre>";
 */		
if($codigocarrera<>1)
{
	$query_carrera="SELECT nombrecarrera FROM carrera WHERE codigocarrera='$codigocarrera'";
	$operacion=$sala->query($query_carrera);
	$row_operacion=$operacion->fetchRow();
	$nombrecarrera=$row_operacion['nombrecarrera'];
}

?>

<?php
//print_r($_SESSION['array_plantillas'][$idplantillavotacion][0]);
 /*echo "<pre>";
print_r($array_plantilla_escogida);
echo "</pre>";*/
 ?>
<div align="center"><?php echo $array_plantilla_escogida['nombretipoplantillavotacion'];?>
<br>
<?php echo $array_plantilla_escogida['nombreplantillavotacion']," ",$nombrecarrera;?>
<br>
<?php echo $array_plantilla_escogida['resumenplantillavotacion'];?>
<br>
</div>
<table align="center" cellpadding="1" cellspacing="1" border="1">
<tr>
<?php
if(isset($array_plantilla_escogida["detalle"]))
foreach ($array_plantilla_escogida["detalle"] as $llave_detalle => $valor_detalle){
	
		$imgReal=$valor_detalle['rutaarchivofotocandidatovotacion'];
	?>
	<td>
		<table>
		<tr>
			<td width="100px" align="center"><?php echo $valor_detalle['numerotarjetoncandidatovotacion']?></td>
		</tr>
		<tr>
			<td width="100px" align="center"><img src="<?php echo $imgReal;?>" width="80" height="120" alt="<?php echo $valor_detalle['nombrecandidato']?>"></td>
		</tr>
		<tr>
			<td width="100px" align="center"><?php echo $valor_detalle['nombrecandidato']?></td>
		</tr>
		<tr>
			<td width="100px" align="center"><?php echo $valor_detalle['nombrecargo']?></td>
		</tr>
		</table>
	</td>
<?php
unset($imgReal); 
unset($imagenjpg);
unset($imagenJPG);
} 
?>
</tr>
</table>
</body>
</html>