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
/**
 * Caso 278.
 * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
 * Ajuste de acceso por usuario por la opción de Gestion de Permisos.
 * @since 21 de Febrero 2019.
*/
    $db = writeHeader("Reporte Macro de Cursos de Educacion Continuada",TRUE);
    
	$utils = Utils::getInstance();
	
	if(isset($_REQUEST["fecha_inicio"])){
	$fecha_inicio = $_REQUEST["fecha_inicio"];
	$fecha_fin = $_REQUEST["fecha_fin"];
	$tipo = $_REQUEST["tipo"];
	$actividad = $_REQUEST["actividad"];
	$queryActividad = "";
        

			
	//son los cursos que se ofrecieron en esa fecha no los activos que es lo que tengo arriba
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
        
        
		$sql = "SELECT c.codigocarrera, c.nombrecarrera, f.codigofacultad, f.nombrefacultad, m.codigomateria, g.idgrupo, 
			g.fechainiciogrupo, g.fechafinalgrupo FROM carrera c 
			inner join facultad f ON f.codigofacultad=c.codigofacultad  
			inner join materia m ON m.codigocarrera=c.codigocarrera AND c.codigomodalidadacademicasic=400
			inner join grupo g ON g.codigomateria=m.codigomateria AND g.fechainiciogrupo!='0000-00-00' 
			AND g.fechainiciogrupo <= '".$fecha_fin."' AND g.fechainiciogrupo >= '".$fecha_inicio."' $querTipo 
			$queryActividad 
			ORDER BY f.nombrefacultad ASC, g.fechainiciogrupo DESC";
	$rows = $db->GetAll($sql);
	
    $data = array();
	
	function countFacultades($idFacultad,$arreglo,$indice,$tamArreglo){
		$sigue = true;
		$numFacultades = 0;
		for($j = $indice; $j < $tamArreglo&&$sigue; ++$j) { 
				if($idFacultad !== $arreglo[$j]["codigofacultad"]) { 
					$sigue = false;
				} else {
					$numFacultades = $numFacultades+1;
				}
		} 
		return $numFacultades;
	}
	
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
		<input id="inputInformeGestion" style="margin-bottom:20px;" type="submit" name="Submit"  value="Exportar a excel"/>
</form>

<table class="viewReport viewList persist-area tableWithFloatingHeader" id="tableInformeGestion">
	<thead class="persist-header">
		<tr class="dataColumns">
			<th colspan="8">Cursos ofrecidos en el periodo <?php echo $fecha_inicio; ?> a <?php echo $fecha_fin; if($tipo!==""){ ?> de tipo <?php echo $tipoData["nombre"]; } if($actividad!==""){ ?> (<?php echo $tipoActividad["nombre"].")"; } ?></th>
		</tr>
		<tr class="dataColumns category">
			<th rowspan="2">Facultad</th>
			<th rowspan="2">Cursos</th>
			<th rowspan="2">Tipo</th>
			<th colspan="3">Matriculados</th>
			<th rowspan="2">No. de Proyecto</th>
			<th rowspan="2">Ingresos</th>
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
			$numF = 0;
                        $total1 = 0;
                        $total2 = 0;
                        $total3 = 0;
                        $total1F = 0;
                        $total2F = 0;
                        $total3F = 0;
			for($i = 0; $i < $num; ++$i) { 
                            //para el total por facultad
                        if($facultadAnterior !== $rows[$i]["codigofacultad"] && $facultadAnterior!=-1) { ?>
                            <tr class="total">
                                <td>Total <?php echo $rows[$i-1]["nombrefacultad"]; ?></td>
                                <td><?php echo $numEnFacultad; ?></td>
                                <td></td>
                                <td><?php echo $total1F; ?></td>
                                <td><?php echo $total2F; ?></td>
                                <td><?php echo $total1F+$total2F; ?></td>
                                <td></td>
                                <td><?php echo "$ ".number_format($total3F); ?></td>
                            </tr>                                
                             <?php $total1F = 0; $total2F = 0;  $total3F = 0;} ?>
				<tr>
					<?php 
					$dataDetalle = $utils->getDataEntityActive("detalleGrupoCursoEducacionContinuada", $rows[$i]["idgrupo"], "idgrupo");
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
					
					if($facultadAnterior !== $rows[$i]["codigofacultad"]) { 
						$numF+=1;
						$facultadAnterior = $rows[$i]["codigofacultad"];
						$numEnFacultad = countFacultades($facultadAnterior,$rows,$i,$num); 
					?>
					<td rowspan="<?php echo $numEnFacultad; ?>"><span class="sendReport sendFacultad <?php echo $rows[$i]["codigofacultad"]; ?>"><?php echo $rows[$i]["nombrefacultad"]; ?></span></td>
					<?php } ?>
					<td <?php /*if($color){ ?>class="odd"<?php }*/ ?>><span class="sendReport sendCurso <?php echo $rows[$i]["idgrupo"]; ?>"><?php echo $rows[$i]["nombrecarrera"]." (".$rows[$i]["fechainiciogrupo"]." a ".$rows[$i]["fechafinalgrupo"].")"; ?></span></td>
					<td <?php /*if($color){ ?>class="odd"<?php }*/ ?>><?php echo $tipoData["nombre"]; ?></td>
					<td <?php /*if($color){ ?>class="odd"<?php }*/ ?>><?php echo $matriculados[0]; $total1 = $total1 + $matriculados[0]; $total1F = $total1F + $matriculados[0]; ?></td>
					<td <?php /*if($color){ ?>class="odd"<?php }*/ ?>><?php echo $matriculados[1]; $total2 = $total2 + $matriculados[1]; $total2F = $total2F + $matriculados[1]; ?></td>
					<td <?php /*if($color){ ?>class="odd"<?php }*/ ?>><?php echo $matriculados[2]; ?></td>
					<td <?php /*if($color){ ?>class="odd"<?php }*/ ?>><?php echo $proyecto['numeroordeninternasap']; ?></td>
					<td <?php /*if($color){ $color=false;?>class="odd"<?php } else{ $color=true;}*/?>><?php echo "$ ".number_format($ingresos); $total3 = $total3 + $ingresos; $total3F = $total3F + $ingresos; ?></td>
				</tr>
		<?php } if($num==0){ echo "<tr><td colspan='8' class='center'>No se encontraron cursos.</td></tr>";}
			else if($numF>1){ ?>
							<tr class="total">
                                <td>Total <?php echo $rows[$num-1]["nombrefacultad"]; ?></td>
                                <td><?php echo $numEnFacultad; ?></td>
                                <td></td>
                                <td><?php echo $total1F; ?></td>
                                <td><?php echo $total2F; ?></td>
                                <td><?php echo $total1F+$total2F; ?></td>
                                <td></td>
                                <td><?php echo "$ ".number_format($total3F); ?></td>
                            </tr>                               
			<?php } 
		?>
	</tbody>
        <tfoot>
            
                            <tr class="total">
                                <td>Total</td>
                                <td><?php echo number_format($num); ?></td>
                                <td></td>
                                <td><?php echo number_format($total1); ?></td>
                                <td><?php echo number_format($total2); ?></td>
                                <td><?php echo number_format($total1+$total2); ?></td>
                                <td></td>
                                <td><?php echo "$ ".number_format($total3); ?></td>
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

$('.sendFacultad').click(function(event) {
    var myClass = $(this).attr("class");
	var clases=myClass.split(" "); 
	window.location.href="reporteFacultad.php?fecha_inicio=<?php echo $fecha_inicio;?>&fecha_fin=<?php echo $fecha_fin; ?>&tipo=<?php echo $tipo; ?>&actividad=<?php echo $actividad; ?>&idFacultad="+clases[2];
});

$('.sendCurso').click(function(event) {
    var myClass = $(this).attr("class");
	var clases=myClass.split(" "); 
	window.location.href="reporteCurso.php?idgrupo="+clases[2]+"&fecha_inicio=<?php echo $fecha_inicio;?>&fecha_fin=<?php echo $fecha_fin; ?>&tipo=<?php echo $tipo; ?>&actividad=<?php echo $actividad; ?>";
});
</script>
<?php } else { 
	$utils = Utils::getInstance();
	$tipos = $utils->getAll($db,"nombre,idtipoEducacionContinuada","tipoEducacionContinuada","codigoestado=100","nombre");
        $actividades = $utils->getAll($db,"nombre,idactividadEducacionContinuada","actividadEducacionContinuada","codigoestado=100 AND actividadPadre=0","nombre");
		?>

	<div id="contenido">
        <h4>Reporte de Cursos Ofrecidos en un Rango de Tiempo</h4>
        <div id="form"> 
         <form action="reporteMacro.php" method="post" id="form_test" name="myform">
             <input type="hidden" name="action" value="getParticipantes" />
                <div class="campo">
                    <label for="nombre" class="grid-2-12">Fecha de Inicio: <span class="mandatory">(*)</span></label>
                    <input type="text" class="grid-2-12 required dateInput" id="fecha_inicio" minlength="1" name="fecha_inicio" maxlength="10" tabindex="1" autocomplete="off" value="" readonly />
                          
				
                    <label for="nombre" class="grid-2-12">Fecha Final: <span class="mandatory">(*)</span></label>
					<input type="text" class="grid-2-12 required dateInput" id="fecha_fin" minlength="1" name="fecha_fin" maxlength="10" tabindex="1" autocomplete="off" value="" readonly />
					
					<label for="tipo" class="grid-2-12">Tipo de Cursos: </label>
					<?php echo $tipos->GetMenu2('tipo',null,true,false,1,'id="tipo"'); ?>
                                        
                    <label for="actividad" class="grid-2-12">Tipo de Actividad: </label>
                    <?php echo $actividades->GetMenu2('actividad',null,true,false,1,'id="actividad"'); ?>
      
                </div>
				<div class="vacio"></div>
             
             <input type="submit" id="generarLista" value="Generar reporte" class="first" />
         </form>
        </div>
    </div>  
<script type="text/javascript">
                
                $(function() {
                    $( "#fecha_inicio" ).datepicker({
                            defaultDate: "0d",
                            changeMonth: true,
                            changeYear: true,
                            dateFormat: "yy-mm-dd",
                            maxDate: "+3M"
                        }
                    );
                    $( "#ui-datepicker-div" ).show();
                });
				
                $(function() {
                    $( "#fecha_fin" ).datepicker({
                            defaultDate: "0d",
                            changeMonth: true,
                            changeYear: true,
                            dateFormat: "yy-mm-dd",
                            maxDate: "+3M"
                        }
                    );
                    $( "#ui-datepicker-div" ).show();
                });
                
                $(document).ready(function() {
                    $('#ui-datepicker-div').hide();
                });
               

  </script>
<?php } writeFooter(); ?>