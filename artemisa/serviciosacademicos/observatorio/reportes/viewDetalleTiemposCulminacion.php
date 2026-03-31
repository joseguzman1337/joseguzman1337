<?php
/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/
require_once("../../ReportesAuditoria/templates/mainjson.php");
require_once("../templates/templateObservatorio.php");
require_once('../../mgi/datos/class/Utils_datos.php');
        require_once('../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
require_once('../../mgi/datos/reportes/reportes/estudiantes/functionsGananciaAcademica.php');
require_once('../../mgi/datos/reportes/reportes/estudiantes/functionsTiemposCulminacion.php');
$Titulo = 'Tiempos Culminaci&oacute;n';
writeHeader($Titulo,false,"Tiempos de Culminacion",1,'',$db);
$utils = new Utils_datos();
	$codigocarrera=$_GET['c'];
	$periodo=$_REQUEST['p'];
        $arrayP = str_split($periodo, strlen($periodo)-1);
        $labelPeriodo = $arrayP[0]."-".$arrayP[1];
	$reporte = $utils->getDataEntity("reporte",$codigocarrera);
	$data = $utils->getDataEntity("carrera",$codigocarrera,"","codigocarrera");

$arraySituacion = explode(",", $_GET["situacion"]);

        $array_matnuevo=obtenerEstudiantes($db,$periodo,$codigocarrera);
		if(count($array_matnuevo)>0 && is_array($array_matnuevo)){
            $totalEstudiantesCohorte = count($array_matnuevo);			
			$estudiantes = discriminarEstudiantes($db,$array_matnuevo,$totalEstudiantesCohorte,$arraySituacion,$_REQUEST['grado']);
        }
?>
<style>
	tr,td,th{
		border: 1px solid #000;
	}
	th,td.center{
		text-align:center
	}
</style>
<div align="center">

<table id="estructuraReporte" class="previewReport formData" style="text-align:left;clear:both;margin: 10px auto;width:80%;">
		<thead>           
			<tr class="dataColumns">
				<th class="column" colspan="7"><span><?php echo $data["nombrecarrera"]; ?></span></th>
             </tr>
             <tr class="dataColumns">
                            <th class="column" colspan="7"><span>Cohorte del periodo <?php echo $labelPeriodo;?> </span></th>
             </tr>
             <tr class="dataColumns">
				<th class="column borderR"><span>No.</span></th>
				<th class="column borderR"><span>Nombre Estudiante</span></th>
				<th class="column borderR"><span>No. Documento</span></th>
				<th class="column borderR"><span>Correo</span></th>
				<th class="column borderR"><span>Teléfono</span></th>
				<th class="column borderR"><span>Celular</span></th>
				<th class="column borderR"><span>Último periodo cursado</span></th>
			</tr>			
		</thead>
		<tbody>
		<?php $contador=0; foreach ($estudiantes as $registro) {    $contador++;
              ?>
                 <tr class="contentColumns row">
                     <td class="column borderR center"><?php echo $contador; ?></td>
                     <td class="column borderR"><?php echo $registro["nombre"]; ?></td>
                     <td class="column borderR center" ><?PHP echo $registro["numerodocumento"];?></td>
                     <td class="column borderR" ><?PHP echo $registro["emailestudiantegeneral"];?></td>
                     <td class="column borderR center" ><?PHP echo $registro["telefonoresidenciaestudiantegeneral"];?></td>
                     <td class="column borderR center" ><?PHP echo $registro["celularestudiantegeneral"];?></td>
                     <td class="column borderR center" ><?PHP echo $registro["ultimo_periodo"];?></td>
                </tr>
        <?php   } ?>
		</tbody>
	</table>
	
	<button onclick="goBack()">Regresar</button>

	<script>
		function goBack() {
			window.history.go(-1);
		}
	</script>
</div>