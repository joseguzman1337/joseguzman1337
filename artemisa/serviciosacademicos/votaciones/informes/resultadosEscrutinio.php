<?php
session_start();
ini_set("display_errors", "0");
error_reporting(0);
unset($_SESSION['datos_pie']);
?>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<?php
$fechahoy=date("Y-m-d H:i:s");
$rutaado=("../../funciones/adodb/");
require_once('../../Connections/salaado-pear.php');
require_once("../../funciones/clases/motorv2/motor.php");
require_once("../../funciones/clases/formulariov2/clase_formulario.php");
require_once("../funciones/obtenerDatos.php");
$escrutinio = new Votaciones(&$sala,false);
$formulario = new formulario(&$sala,'form1','get','',true,'resumenEscrutinioConsejoFacultad');
?>
<form name="form1" method="GET" action="">
<h4>Resultados Votaciones</h4>
<br>
<table>
<tr>
<td id="tdtitulogris"><?php $formulario->etiqueta('idvotacion',"Votacion","requerido");?></td>
<td><?php $formulario->combo('idvotacion','','get','votacion','idvotacion','nombrevotacion','codigoestado="100"','idvotacion','','requerido');?></td>
</tr>
</table>
<br>
<?php $formulario->Boton('Enviar','Enviar');?>
</form>
<?php
if(isset($_GET['Enviar'])){
	$valido=$formulario->valida_formulario();
	if($valido){
		$escrutinio->asignarEscrutinios($_GET['idvotacion']);
		$ganadores=$escrutinio->ordenaArrayParaCalculoGanadoresSegunConteo();
		$votos=$escrutinio->retornaArrayConteoVotos();
		$matriz = new matriz($votos,"Resultados de la votación","resultadosEscrutinio.php?idvotacion=".$_GET['idvotacion']."&Enviar","si","si","menu.php");
		$matriz->archivo_origen_con_get=true;
		$matriz->jsVarios();
		$matriz->mostrar();
		$escrutinio->DibujarTablaNormal($ganadores,"Mayor Votación");
	}
}
?>