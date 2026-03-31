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
$formulario = new formulario(&$sala,'form1','get','',true,'resumenEscrutinioConsejoFacultad');

?>
<form name="form1" method="GET" action="">
<h4>Resumen Votaciones</h4>
<br>
<table>
<tr>
<td id="tdtitulogris"><?php $formulario->etiqueta('idvotacion',"Votacion","requerido");?></td>
<td><?php $formulario->combo('idvotacion','','get','votacion','idvotacion','nombrevotacion','codigoestado="100"','idvotacion','','requerido');?></td>
</tr>
<tr>
<td id="tdtitulogris"><?php $formulario->etiqueta('codigocarrera',"Carrera","");?></td>
<td><?php $formulario->combo('codigocarrera','','get','carrera','codigocarrera','nombrecarrera','codigomodalidadacademica="200" and NOW() between fechainiciocarrera AND fechavencimientocarrera','nombrecarrera');?></td>
</tr>
</table>
<br>
<?php $formulario->Boton('Enviar','Enviar');?>
</form>
<?php
if(isset($_GET['Enviar'])){
	$valido=$formulario->valida_formulario();
	if($valido){
		$escrutinio = new Votaciones(&$sala,false);
		$escrutinio->asignarEscrutinios($_GET['idvotacion']);
		$escrutinio->ordenaArrayParaCalculoGanadoresSegunConteo();
		$escrutinio->ordenaArrayParaCalculoGanadores_x_Consejo_Facultad();

		$array_tipos_plantillas_votacion=$escrutinio->retornaArrayTiposPlantillasVotacion();
		$array_ranking=$escrutinio->retornaArrayRanking_x_votos();
		$array_ranking_consejo_facultad=$escrutinio->retorna_array_ranking_x_votos_consejo_facultad();
		$array_carreras=$escrutinio->retornaArrayCarreras();

		foreach ($array_tipos_plantillas_votacion as $llave_t => $valor_t){
			if($valor_t['idtipoplantillavotacion']<>3){
				$escrutinio->DibujarTablaNormal($array_ranking[$valor_t['idtipoplantillavotacion']],"Escrutinio x cantidad de votos ".$valor_t['nombretipoplantillavotacion']);
				echo "<br>";
			}

		}

		if(empty($_GET['codigocarrera'])){

			foreach ($array_carreras as $llave_c => $valor_c){
				if(is_array($array_ranking_consejo_facultad[$llave_c])){
					echo "<br>";
					$escrutinio->DibujarTablaNormal($array_ranking_consejo_facultad[$llave_c],"Escrutinio x cantidad de votos ".$valor_t['nombretipoplantillavotacion']." ".$valor_c['nombrecarrera']);
					echo "<br>";
				}
			}
		}
		else{
			$escrutinio->DibujarTablaNormal($array_ranking_consejo_facultad[$_GET['codigocarrera']],"Escrutinio x cantidad de votos ".$array_tipos_plantillas_votacion[3]['nombretiplantillavotacion']." ".$array_carreras[$_GET['codigocarrera']]['nombrecarrera']);
			echo "<br>";
		}
	}
}

?>