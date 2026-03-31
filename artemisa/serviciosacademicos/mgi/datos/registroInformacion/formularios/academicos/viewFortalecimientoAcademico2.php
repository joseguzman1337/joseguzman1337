<?PHP 
session_start();
$ruta = "../";
while(!file_exists($ruta."templates/template.php")){
    $ruta = $ruta."../";
}
require_once($ruta."templates/template.php");
$url = "";
if($db==NULL){
    $db = getBD();
    $utils = new Utils_datos();
} else {
    $url="../registroInformacion/";
}

if($_REQUEST['alias']=='caas' && !$_REQUEST['semestre']) {
?>

<script type="text/javascript">

     function getDataByDate(formName,entity,periodo,campoFecha){
             //var codigocarrera = null;
             return  $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getDataByDate", entity: entity, campoFecha: campoFecha },     
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
         }

</script>
	<div id="tabs-3" class="formsHuerfanos">
                <!--<div class="formModalidad">
                      /*$rutaModalidad = "./_elegirProgramaAcademico.php";
					 if(!is_file($rutaModalidad)){
						$rutaModalidad = './formularios/academicos/_elegirProgramaAcademico.php';
					 }
					include($rutaModalidad); */?>
                </div>-->
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db,"codigoperiodo");  
                ?>
                <div class="consultar" title="" onmouseover="botonconsultar(this)">
                <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                </div>
                <div class="vacio"></div>
     
        <table align="center" class="formData last" width="92%" >
                    <thead>            
                         <tr class="dataColumns">
                            <th class="column" colspan="4"><span>Capacitación a los académicos - Aprendizaje significativo</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Evento</span></th> 
                            <th class="column" ><span>Fecha terminación</span></th> 
                            <th class="column" ><span>Conferencista</span></th> 
                            <th class="column" ><span>Número de asistentes</span></th>                             
                        </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
                </table>  
                
                <script type="text/javascript">
                     $(document).on('change', "#tabs-3 .modalidad", function(){
                    getCarreras("#tabs-3");
                    changeFormModalidad("#tabs-3");
                });
                
                $(document).on('change', "#tabs-3 .unidadAcademica", function(){
                    changeFormModalidad("#tabs-3");
                });
            
            
            $('#tabs-3 .consultar').bind('click', function(event) {
                    getData3("#tabs-3");
                });            
                
                function getData3(name){
                    html = "";                    
                    var periodo = $(name + ' #codigoperiodo').val();
                     var promise = getDataByDate(name,'fortalecimientoacademicoprofesoresinfhuerfana',periodo,"fechaterminacion");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         console.log(data);
                         if (data.success == true){
                                 for (var i=0;i<data.total;i++)
                                    {       
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column">'+data.data[i].evento+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].fechaterminacion+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].conferencista+'</td>';
                                        html = html + '<td class="column">'+data.data[i].numeroasistentes+'</td>';
                                        //html = html + '<td class="column center eliminarDato"><img width="16" onclick="Eliminar('+data.data[i].idsiq_formUnidadesAcademicasProfesoresVisitantes+', \'formUnidadesAcademicasProfesoresVisitantes\',\'updateDataVisitantes\')" title="Eliminar Dato" src="../../images/Close_Box_Red.png" style="cursor:pointer;"></td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                    }
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="4" class="center">No se encontraron datos.</td></tr>');
                            }                         
                      });
                }
                
           
        </script>
</div>
<?PHP
	exit;
} else {
	if($_REQUEST['semestre']) {
		if($_REQUEST['alias']=='scpscpefi') {
			$query="select   nombrecarrera
					,nromaterias
					,nrocontenidos
				from carrera
				join (
                        SELECT codigocarrera,count(distinct(codigomateria)) as nromaterias
                        FROM materia m
                        join grupo g using(codigomateria)
                        join carrera c using(codigocarrera)
                        WHERE g.codigoperiodo = ".$_REQUEST['semestre']."                        
                        AND g.codigoestadogrupo = '10'
                        AND m.codigoestadomateria = '01'
                        group by codigocarrera
				) s1 using(codigocarrera)
				left join (
                        select codigocarrera,count(distinct(c.idcontenidoprogramatico)) as nrocontenidos from contenidoprogramatico c
                        join detallecontenidoprogramatico d using(idcontenidoprogramatico)
                        join materia ma using(codigomateria)
                        join carrera ca using(codigocarrera)
                        where c.codigoperiodo=".$_REQUEST['semestre']."
                        and c.codigoestado like '1%'
                        
                        group by codigocarrera
				) s2 using(codigocarrera)
				where codigomodalidadacademica=200
					and codigomodalidadacademicasic=200
					and fechavencimientocarrera>=curdate()
				order by nombrecarrera";
			$exec= $db->Execute($query);
			if($exec->RecordCount()==0) {
?>
				<div id="msg-success" class="msg-success msg-error" ><p>No existe información almacenada para el periodo <?PHP echo $_REQUEST['semestre']?></p></div>
<?PHP
			} else {
?>
				<table align="center" class="formData last" width="92%">
					<tr class="dataColumns">
						<th class="borderR">Programas acad&eacute;micos</th>               
						<th class="borderR">total asignaturas del programa</th>
						<th class="borderR">Número de syllabus y Contenidos programáticos en sistema SALA</th>
					</tr>
<?PHP
					$sum_nromaterias=0;
					$sum_nrocontenidos=0;
					while($row = $exec->FetchRow()) {
?>
						<tr id="contentColumns" class="row">
							<td class="column borderR"><?PHP echo $row['nombrecarrera']?></td>
							<td class="column borderR" align="center"><?PHP echo $row['nromaterias']?></td>
							<td class="column borderR" align="center"><?PHP echo $row['nrocontenidos']?></td>
						</tr>
<?PHP
						$sum_nromaterias+=$row['nromaterias'];
						$sum_nrocontenidos+=$row['nrocontenidos'];
					} 
?>
					<tr>
						<th class="borderR">Total</th>
						<th class="borderR"><?PHP echo $sum_nromaterias?></th>
						<th class="borderR"><?PHP echo $sum_nrocontenidos?></th>
					</tr>
				</table>
<?PHP
			}
		} else {
			$query="select   nombrecarrera
					,total_asignaturas
					,porcentaje_utilizacion
				from siq_fortalecimientoacademicoinfhuerfana
				join carrera using(codigocarrera)
				where alias='".$_REQUEST['alias']."'
					and periodicidad=".$_REQUEST['semestre']."
				order by nombrecarrera";
			$exec= $db->Execute($query);
			if($exec->RecordCount()==0) {
?>
				<div id="msg-success" class="msg-success msg-error" ><p>No existe información almacenada para el semestre <?PHP echo $_REQUEST['semestre']?></p></div>
<?PHP
			} else {
				if($_REQUEST['alias']=='apeirbyh') {
					$subtitulo="Total de asignaturas con referente bioética y humanidades";
					$subtitulo2=false;
				} elseif($_REQUEST['alias']=='auleaaecpupa') {
					$subtitulo="Total de asignaturas que utilizan lengua extranjera";
					$subtitulo2=true;
				} elseif($_REQUEST['alias']=='aaiaaepu') {
					$subtitulo="Total de asignaturas que articulan la internacionalización";
					$subtitulo2=true;
				} else {
					$subtitulo="Total de asignaturas que utilizan TICs";
					$subtitulo2=true;
				}
?>
				<table align="center" class="formData last" width="92%">
					<tr class="dataColumns">
						<th class="borderR">Programas acad&eacute;micos</th>               
						<th class="borderR"><?PHP echo $subtitulo?></th>
<?PHP
						if($subtitulo2) {
?>
							<th class="borderR">% de utilización</th>
<?PHP
						}
?>
					</tr>
<?PHP
					$sum_total_asignaturas=0;
					$sum_porcentaje_utilizacion=0;
					while($row = $exec->FetchRow()) {
?>
						<tr id="contentColumns" class="row">
							<td class="column borderR"><?PHP echo $row['nombrecarrera']?></td>
							<td class="column borderR" align="center"><?PHP echo $row['total_asignaturas']?></td>
<?PHP
							if($subtitulo2) {
?>
								<td class="column borderR" align="center"><?PHP echo $row['porcentaje_utilizacion']?></td>
<?PHP
								$sum_porcentaje_utilizacion+=$row['porcentaje_utilizacion'];
							}
?>
						</tr>
<?PHP
						$sum_total_asignaturas+=$row['total_asignaturas'];
					} 
?>
					<tr>
						<th class="borderR">Total</th>
						<th class="borderR"><?PHP echo $sum_total_asignaturas?></th>
<?PHP
						if($subtitulo2) {
?>
							<th class="borderR"><?PHP echo $sum_porcentaje_utilizacion?></th>
<?PHP
						}
?>
					</tr>
				</table>
<?PHP
			}
		}
		exit;
	}
}
if($_REQUEST['alias']=='caas')
	$titulo="Capacitación a los académicos – Aprendizaje significativo";
elseif($_REQUEST['alias']=='apeirbyh')
	$titulo="Asignaturas del plan de estudios que incorporan el referente de la bioética y las humanidades";
elseif($_REQUEST['alias']=='auleaaecpupa')
	$titulo="Asignaturas que utilizan lengua extranjera en las actividades de aprendizaje y evaluación del curso y porcentaje de utilización en el programa académico";
elseif($_REQUEST['alias']=='aaiaaepu')
	$titulo="Asignaturas que articulan la internacionalización  con las actividades de aprendizaje y evaluación y porcentaje de utilización";
else 
	$titulo="Asignaturas que incluyen herramientas mediadas por las TIC en las actividades de evaluación y actividades de aprendizaje y porcentaje de utilización en total";
?>
<form action="" method="post" id="form<?PHP echo $_REQUEST['alias']?>">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend><?PHP echo $titulo?></legend>
<?PHP
		if($_REQUEST['alias']!='caas') {
?>
			<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
<?PHP		
			if($_REQUEST['alias']!='scpscpefi') {
			$utils->getSemestresSelect($db,"semestre");
			}
			elseif($_REQUEST['alias']=='scpscpefi'){
			  $utils->getSemestresSelect($db,"semestre",false,null,"","20112");
			}
		}
?>
		<input type="hidden" name="alias" value="<?PHP echo $_REQUEST['alias']?>" />
		<div class="consultar" title="" onmouseover="botonconsultar(this)">
			<input type="submit" value="Consultar" class="first small" />
		</div>
		<div id='respuesta_form<?PHP echo $_REQUEST['alias']?>'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form<?PHP echo $_REQUEST['alias']?>");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
		$.ajax({
				type: 'GET',
				url: '<?php echo $url; ?>formularios/academicos/viewFortalecimientoAcademico2.php',
				async: false,
				data: $('#form<?PHP echo $_REQUEST['alias']?>').serialize(),                
				success:function(data){
					$('#respuesta_form<?PHP echo $_REQUEST['alias']?>').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
</script>
