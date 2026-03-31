<?php
/**
 * Caso 522.
 * Ajuste validación de Sesión
 * Se incluye el archivo adaptador para tener acceso a las funciones basicas de
 * del nuevo sala si la aplicacion se corre en un entorno local o de pruebas.
 * @modified Dario Gualteros Castro <castroluisd@unbosque.edu.co>.
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since 18 de Marzo 2019.
 */
require(realpath(dirname(__FILE__) . "/../../../sala/includes/adaptador.php"));
/**
 * El metodo Factory::validateSession($variables) hace una validacion de session activa en el sistema
 * dependiendo de los parametros que se le envíen, si determina que la session acabo redirige el sistema al login
 */
Factory::validateSession($variables);

include_once(realpath(dirname(__FILE__))."/../variables.php");
include($rutaTemplate."template.php");
    $db = writeHeader("Reporte Facultad para Cursos de Educacion Continuada",TRUE);
    
	$utils = Utils::getInstance();
	$fecha_inicio = $_REQUEST["fecha_inicio"];
	$fecha_fin = $_REQUEST["fecha_fin"];
	$idFacultad = $_REQUEST["idFacultad"];
	$tipo = $_REQUEST["tipo"];
	$actividad = $_REQUEST["actividad"];
	$queryActividad = "";
	
	$facultad = $utils->getDataEntity("facultad", $idFacultad, "codigofacultad");
	
	if($tipo===""){
            $querTipo = "";
	} else {
		$tipoData = $utils->getDataEntity("tipoEducacionContinuada", $tipo, "idtipoEducacionContinuada");  
		//si el curso es abierto
		if($tipo==="1"){
                     
                    $querTipo = "AND g.idgrupo NOT IN 
			(SELECT dg.idgrupo FROM detalleGrupoCursoEducacionContinuada dg WHERE dg.tipo='2') ";
			
			//echo $sql;
		} else {
			//el tipo es cerrado 
                    $querTipo = "AND g.idgrupo IN 
			(SELECT dg.idgrupo FROM detalleGrupoCursoEducacionContinuada dg WHERE dg.tipo='".$tipo."') ";
		}
	}
	
	if($actividad!=="" && $actividad!=null){
		$actividades = $utils->getAll($db,"nombre,idactividadEducacionContinuada","actividadEducacionContinuada","codigoestado=100 AND actividadPadre=".$actividad,"nombre");
		
		if($actividades->RecordCount()>0){
			$activities = "";
			foreach ($actividades as $row){
				if($activities!==""){
					$activities .= ",".$row["idactividadEducacionContinuada"];
				} else {
					$activities .= $row["idactividadEducacionContinuada"];
				}
			}
			$queryActividad = "INNER JOIN detalleCursoEducacionContinuada dc ON dc.codigocarrera=c.codigocarrera 
			AND dc.codigoestado=100 AND actividad IN ($activities) "; 
		} else {
			$queryActividad = "INNER JOIN detalleCursoEducacionContinuada dc ON dc.codigocarrera=c.codigocarrera 
			AND dc.codigoestado=100 AND actividad=".$actividad; 
		}
		$tipoActividad = $utils->getDataEntity("actividadEducacionContinuada", $actividad, "idactividadEducacionContinuada"); 
		
	}
	
	$sql = "SELECT c.codigocarrera, c.nombrecarrera, f.codigofacultad, f.nombrefacultad, m.codigomateria, g.idgrupo, g.fechainiciogrupo, g.fechafinalgrupo FROM carrera c 
			inner join facultad f ON f.codigofacultad=c.codigofacultad AND f.codigofacultad='".$idFacultad."' 
			inner join materia m ON m.codigocarrera=c.codigocarrera AND c.codigomodalidadacademicasic=400
			inner join grupo g ON g.codigomateria=m.codigomateria AND g.fechainiciogrupo!='0000-00-00' 
			AND g.fechainiciogrupo <= '".$fecha_fin."' AND g.fechainiciogrupo >= '".$fecha_inicio."' $querTipo
			$queryActividad 
			ORDER BY f.nombrefacultad ASC, g.fechainiciogrupo DESC";
	
	$rows = $db->GetAll($sql);
	
    $data = array();
	
	function countMatriculados($participantes){
		$numInternacional = 0;
		$numNacionales = 0;
		$numTotal = count($participantes);
		for($j = 0; $j < $numTotal; ++$j) { 
				if($participantes[$j]["idpais"] == 1) { 
					$numNacionales = $numNacionales + 1;
				} else {
					$numInternacional = $numInternacional+1;
				}
		} 
		return array($numNacionales,$numInternacional,$numTotal);
	}
	
	//echo "<pre>";print_r($rows);
?>
<script type="text/javascript" language="javascript" src="../js/functionsReportes.js"></script>    

<form  action="imprimirInformeGestion.php" method="post" id="formInformeCamapania" style="z-index: -1;  width:100%">

		<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
                <input type="button" id="volver" value="Volver" style="margin-right:10px;" />
<input id="inputInformeGestion" style="margin-bottom:20px;" type="submit" name="Submit"  value="Exportar a excel"/>
</form>

<table id="tableInformeGestion" name="tableInformeGestion" class="viewReport viewList persist-area tableWithFloatingHeader" width="100%">
	<thead class="persist-header">
		<tr class="dataColumns">
			<th colspan="8"><?php echo $facultad["nombrefacultad"]; ?></th>
		</tr>
		<tr class="dataColumns category">
			<th colspan="8">Cursos ofrecidos en el periodo <?php echo $fecha_inicio; ?> a <?php echo $fecha_fin; if($tipo!==""){ ?> de tipo <?php echo $tipoData["nombre"]; } if($actividad!==""){ ?> (<?php echo $tipoActividad["nombre"].")"; } ?></th>
		</tr>
		<tr class="dataColumns category">
			<th rowspan="2">Cursos</th>
			<th rowspan="2">Tipo</th>
			<th colspan="3">Matriculados</th>
			<th rowspan="2">No. de Proyecto</th>
			<th rowspan="2">Ingresos</th>
			<th rowspan="2">Fecha del Curso</th>
		</tr>
		<tr class="categories dataColumns category">
			<th>Nacional</th>
			<th>Internacional</th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
		<?php $num = count($rows); 
			$facultadAnterior = -1;
			$total1= 0;
			$total2=0;
			$total3=0;
			for($i = 0; $i < $num; ++$i) { ?>
				<tr <?php if($color){ $color=false;?> class="odd" <?php } else{ $color=true;}?>>
					<?php 
					$dataDetalle = $utils->getDataEntity("detalleGrupoCursoEducacionContinuada", $rows[$i]["idgrupo"], "idgrupo");
					if($dataDetalle==NULL || count($dataDetalle)==0){
						$tipoData["nombre"] = "Abierto";
					} else {
						$tipoData = $utils->getDataEntity("tipoEducacionContinuada", $dataDetalle["tipo"], "idtipoEducacionContinuada"); 
					}
					$proyecto = $utils->getDataEntity("numeroordeninternasap", $rows[$i]["idgrupo"], "idgrupo");
					$participantes = $utils->getParticipantesGrupoCursoEducacionContinuada($db,$rows[$i]["idgrupo"]);  
					$matriculados = countMatriculados($participantes);
					//echo "<pre>";print_r($matriculados);
					
					$ingresos = $utils->getIngresosGrupo($db,$rows[$i]["idgrupo"]);
					?>
					<td><span class="sendReport sendCurso <?php echo $rows[$i]["idgrupo"]; ?>"><?php echo $rows[$i]["nombrecarrera"]; ?></span></td>
					<td><?php echo $tipoData["nombre"]; ?></td>
					<td class="center"><?php echo $matriculados[0]; $total1 = $total1 + $matriculados[0]; ?></td>
					<td class="center" ><?php echo $matriculados[1]; $total2 = $total2 + $matriculados[1];  ?></td>
					<td class="center" ><?php echo $matriculados[2]; ?></td>
					<td><?php echo $proyecto['numeroordeninternasap']; ?></td>
					<td><?php echo "$ ".number_format($ingresos); $total3 = $total3 + $ingresos;  ?></td>
					<td class="center" ><?php echo $rows[$i]["fechainiciogrupo"]." a ".$rows[$i]["fechafinalgrupo"]; ?></td>
				</tr>
		<?php } ?>
	</tbody>
	<tfoot>
		<tr class="total">
			<td>Total</td>
			<td></td>
			<td class="center" ><?php echo number_format($total1); ?></td>
			<td class="center"><?php echo number_format($total2); ?></td>
			<td class="center"><?php echo number_format($total1+$total2); ?></td>
			<td></td>
			<td><?php echo "$ ".number_format($total3); ?></td>
			<td></td>
		</tr>
	</tfoot>
</table>

<script type="text/javascript">
/*
*	Funciona para imprimir el reporte a excel
*/
$(":submit").click(function(event) {
   
    event.preventDefault();
     $("#datos_a_enviar").val( $("<div>").append( $("#tableInformeGestion").eq(0).clone()).html());
     $("#formInformeCamapania").submit();
});

$('.sendCurso').click(function(event) {
    var myClass = $(this).attr("class");
	var clases=myClass.split(" "); 
	window.location.href="reporteCurso.php?idgrupo="+clases[2];
});

$("#volver").click(function(event) {
   window.location.href="reporteMacro.php?fecha_inicio=<?php echo $fecha_inicio;?>&fecha_fin=<?php echo $fecha_fin; ?>&tipo=<?php echo $tipo; ?>&actividad=<?php echo $actividad; ?>";
});
</script>
<?php  writeFooter(); ?>