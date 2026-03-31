<? 
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

$usuario_con=$_SESSION['MM_Username'];
if($utils->UsuarioAprueba_FormHuerfana($db,$usuario_con)){
$aprobacion=true;
}

if($_REQUEST['alias']=='caas' && !$_REQUEST['semestre']) {
?>
	<script>         
		function Consultar(){
			$.ajax({
				dataType: 'json',
				type: 'POST',
				url: './formularios/academicos/saveFortalecimientoAcademico.php',
				data: { alias: "consultar" },     
				success:function(data){
					$('tbody').append(data.message);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
			});  
		}
		function Eliminar(id){
			$.ajax({
				dataType: 'json',
				type: 'POST',
				url: './formularios/academicos/saveFortalecimientoAcademico.php',
				data: { alias: "inactivar", id: id },     
				success:function(data){
					$('tbody').empty();
    					Consultar();
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
			});  
		}

		$().ready(function() {
    			Consultar();
		});

	</script>
		<table align="center" class="formData last" width="92%">
			<thead>
			<tr class="dataColumns">
				<th class="borderR">Evento</th>               
				<th class="borderR">Fecha terminación</th>
				<th class="borderR">Conferencista</th>
				<th class="borderR">Número de asistentes</th>
				<th class="borderR">Opciones</th>
			</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
<?
	exit;
} else {
	if($_REQUEST['semestre']) {
		if($_REQUEST['alias']=='scpscpefi') {
			$query="select   nombrecarrera
					,nromaterias
					,nrocontenidos
				from carrera
				join (
					select codigocarrera,count(*) as nromaterias from materia join carrera using(codigocarrera) group by codigocarrera
				) s1 using(codigocarrera)
				left join (
					select codigocarrera,count(*) as nrocontenidos from contenidoprogramatico cp join materia m using(codigomateria) where cp.codigoperiodo=".$_REQUEST['semestre']." group by codigocarrera
				) s2 using(codigocarrera)
				where codigomodalidadacademica=200
					and codigomodalidadacademicasic=200
					and fechavencimientocarrera>=curdate()
				order by nombrecarrera";
			$exec= $db->Execute($query);
			if($exec->RecordCount()==0) {
?>
				<div id="msg-success" class="msg-success msg-error" ><p>No existe información almacenada para el periodo <?=$_REQUEST['semestre']?></p></div>
<?
			} else {
?>
				<table align="center" class="formData last" width="92%">
					<tr class="dataColumns">
						<th class="borderR">Programas acad&eacute;micos</th>               
						<th class="borderR">total asignaturas del programa</th>
						<th class="borderR">Número de syllabus y Contenidos programáticos en sistema SALA</th>
					</tr>
<?
					$sum_nromaterias=0;
					$sum_nrocontenidos=0;
					while($row = $exec->FetchRow()) {
?>
						<tr id="contentColumns" class="row">
							<td class="column borderR"><?=$row['nombrecarrera']?></td>
							<td class="column borderR" align="center"><?=$row['nromaterias']?></td>
							<td class="column borderR" align="center"><?=$row['nrocontenidos']?></td>
						</tr>
<?
						$sum_nromaterias+=$row['nromaterias'];
						$sum_nrocontenidos+=$row['nrocontenidos'];
					} 
?>
					<tr>
						<th class="borderR">Total</th>
						<th class="borderR"><?=$sum_nromaterias?></th>
						<th class="borderR"><?=$sum_nrocontenidos?></th>
					</tr>
				</table>
<?
			}
		} else {
		
			if(isset($_REQUEST['codigocarrera'])){
			$concarrera="and codigocarrera='".$_REQUEST['codigocarrera']."'";
			}
			elseif(isset($_SESSION['programa'])){
			$concarrera="and codigocarrera='".$_SESSION['programa']."'";
			}
		
			$query="select   nombrecarrera, codigocarrera
					,total_asignaturas
					,porcentaje_utilizacion
					,Verificado
				from siq_fortalecimientoacademicoinfhuerfana
				join carrera using(codigocarrera)
				where alias='".$_REQUEST['alias']."'
					and periodicidad=".$_REQUEST['semestre']." 
				$concarrera
				order by nombrecarrera";
			$exec= $db->Execute($query);
			if($exec->RecordCount()==0) {
?>
				<div id="msg-success" class="msg-success msg-error" ><p>No existe información almacenada para el semestre <?=$_REQUEST['semestre']?></p></div>
<?
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

<script>       

 
                $(':checkbox').click(function() {
                //event.preventDefault();
			envioAprobado();
		
		});
	  
		
		function envioAprobado(){
		$.ajax({
				type: 'GET',
				url: '<?php echo $url; ?>formularios/academicos/saveApruebaFortalecimientoAcademico.php',
				async: false,
				data: $('#form<?=$_REQUEST['alias']?>').serialize(),                
				success:function(data){
					//$('#respuesta2_form<?=$_REQUEST['alias']?>').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
		
	</script>

				<table align="center" class="formData last" width="92%">
					<tr class="dataColumns">
						<th class="borderR">Programas acad&eacute;micos</th>               
						<th class="borderR"><?=$subtitulo?></th>
<?
						if($subtitulo2) {
?>
							<th class="borderR">% de utilización</th>
<?
						}
?>
						<?php if($aprobacion) { ?>
						<th class="column"><span>Aprobar</span></th> 
						<?php } ?>
					</tr>
<?
					$sum_total_asignaturas=0;
					$sum_porcentaje_utilizacion=0;
					while($row = $exec->FetchRow()) {
					$varverificado=$row['Verificado'];
?>
						<tr id="contentColumns" class="row">
						<input type="hidden" value="<?=$row['codigocarrera']?>" name="nacodigocarrera" />
							<td class="column borderR"><?=$row['nombrecarrera']?></td>
							<td class="column borderR" align="center"><?=$row['total_asignaturas']?></td>
<?
							if($subtitulo2) {
?>
								<td class="column borderR" align="center"><?=$row['porcentaje_utilizacion']?></td>
<?
								$sum_porcentaje_utilizacion+=$row['porcentaje_utilizacion'];
							}							
?>
							<?php if($aprobacion){ ?>
							<td class="column">							  
							  <input type="checkbox"  class="grid-4-12 required number" minlength="1" name="Verificado" id="Verificado" title="Verificado" maxlength="10" tabindex="1" autocomplete="off" value=""
							  <? if($row['Verificado']==1){
							  echo "checked";							  
							  }							  
							  ?>
							  />
							</td>
							<?php 
							}
							?>  
						</tr>
<?
						$sum_total_asignaturas+=$row['total_asignaturas'];
					} 
?>
					<tr>
						<th class="borderR">Total</th>
						<th class="borderR"><?=$sum_total_asignaturas?></th>
<?
						if($subtitulo2) {
?>
							<th class="borderR"><?=$sum_porcentaje_utilizacion?></th>
<?
						}
						?>
						<?php if($aprobacion){ ?>
							<th class="column">&nbsp;							  
							</th>
							<?php 
							}
							?>  
					</tr>
					<?
					if($varverificado==1 && !$aprobacion){					
					?>
					<tr>
						<th class="borderR" colspan="<?php if($subtitulo2) echo "3"; else echo "2";?>">Información Aprobada para el periodo <?=$_REQUEST['semestre']?></th>
						
					</tr>
					<?
					}
					?>
				</table>				
<?
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
<form action="" method="post" id="form<?=$_REQUEST['alias']?>">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend><?=$titulo?></legend>
		<div class="formModalidad">
                     <?php 
                     $rutaModalidad = "./_elegirProgramaAcademico.php";
                                        if(!is_file($rutaModalidad)){
                                               $rutaModalidad = './formularios/academicos/_elegirProgramaAcademico.php';
                                        }
                                       include($rutaModalidad);
                                       
                     //include("./formularios/academicos/_elegirProgramaAcademico.php"); ?>                     
                </div>
<?
		if($_REQUEST['alias']!='caas') {
?>
			<label for="semestre" class="grid-2-12">Semestre: <span class="mandatory">(*)</span></label>
<?		
			$utils->getSemestresSelect($db,"semestre");
		}
?>
		<input type="hidden" name="alias" value="<?=$_REQUEST['alias']?>" />
		<input type="submit" value="Consultar" class="first small" />
		<div id='respuesta_form<?=$_REQUEST['alias']?>'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form<?=$_REQUEST['alias']?>");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
		$.ajax({
				type: 'GET',
				url: '<?php echo $url; ?>formularios/academicos/viewFortalecimientoAcademico2.php',
				async: false,
				data: $('#form<?=$_REQUEST['alias']?>').serialize(),                
				success:function(data){
					$('#respuesta_form<?=$_REQUEST['alias']?>').html(data);
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
	
	$(document).on('change', "#form<?=$_REQUEST['alias']?> #modalidad", function(){
                    getCarreras("#form<?=$_REQUEST['alias']?>");
                    changeFormModalidad("#form<?=$_REQUEST['alias']?>");
                });
                
                $(document).on('change', "#form_test #unidadAcademica", function(){                    
                    changeFormModalidad("#form_test");
                });
                
                
          function changeFormModalidad(formName){
                    var mod = $(formName + ' #modalidad').val();
                    var carrera = $(formName + ' #unidadAcademica').val();
                    $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url: './formularios/academicos/_elegirProgramaAcademico.php',
                                data: { modalidad: mod, carrera: carrera, action: "setSession" },     
                                success:function(data){
                                     $(".formModalidad").load('./formularios/academicos/_elegirProgramaAcademico.php'); 
                                     //cuando acabe todos los load por ajax
                                     $(document).bind("ajaxStop", function() {
                                        $(this).unbind("ajaxStop"); //esto es porque sino queda en ciclo infinito por lo que vuelvo a llamar un ajax
                                        actualizarDataPrograma();
                                    });                         
                                },
                                error: function(data,error,errorThrown){alert(error + errorThrown);}
                     });  
                }
                
                
                function getCarreras(formName){
                    $(formName + " #unidadAcademica").html("");
                    $(formName + " #unidadAcademica").css("width","auto");   
                        
                    if($(formName + ' #modalidad').val()!=""){
                        var mod = $(formName + ' #modalidad').val();
                            $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url: '../searchs/lookForCareersByModalidadSIC.php',
                                data: { modalidad: mod },     
                                success:function(data){
                                     var html = '<option value="" selected></option>';
                                     var i = 0;
                                        while(data.length>i){
                                            html = html + '<option value="'+data[i]["value"]+'" >'+data[i]["label"]+'</option>';
                                            i = i + 1;
                                        }                                    
                            
                                        $(formName + " #unidadAcademica").html(html);
                                        $(formName + " #unidadAcademica").css("width","500px");     
                                        //$(".formProgramaAcademico").html($(formName + " .formProgramaAcademico").html());                                   
                                },
                                error: function(data,error,errorThrown){alert(error + errorThrown);}
                            });  
                    }
                }
                
               
</script>
