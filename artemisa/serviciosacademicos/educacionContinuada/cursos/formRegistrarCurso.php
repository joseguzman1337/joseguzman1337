<?php 
/*	session_start;
	include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
	
function writeForm($edit, $db, $id="") { 
    $data = array();
    $action = "save";
    $utils = Utils::getInstance();
	$edit = false;
	$centroCosto = $utils->getValorDefectoCampo($db,"Centro de Costo");
	$centroCosto = $utils->getDataEntity("centrocosto", $centroCosto, "idcentrocosto"); 
	$centroBeneficio = $centroCosto["codigocentrocosto"];
	if($id!=""){
		$edit = true;
	}
        $actividades = $utils->getAll($db,"nombre,idactividadEducacionContinuada","actividadEducacionContinuada","codigoestado=100 AND actividadPadre=0","nombre");
        $nucleos = $utils->getAll($db,"nombre,idnucleoEstrategico","nucleoEstrategico","codigoestado=100","nombre");
        $cats = $utils->getAll($db,"nombre,idcategoriaCursoEducacionContinuada","categoriaCursoEducacionContinuada","codigoestado=100","nombre"); 
        $tipos = $utils->getAll($db,"nombre,idtipoEducacionContinuada","tipoEducacionContinuada","codigoestado=100","nombre");
		$modalidad = $utils->getAll($db,"nombre,idmodalidadCertificacionEducacionContinuada","modalidadCertificacionEducacionContinuada","codigoestado=100","nombre"); 
		$tiposC = $utils->getAll($db,"nombre,idtipoCertificacionEducacionContinuada","tipoCertificacionEducacionContinuada","codigoestado=100","nombre"); 
	$valorM = "";
        $fechasInscripcion = array();
    if($edit){ 
       $data = $utils->getDataEntity("carrera", $id, "codigocarrera");   
	   $centroBeneficio = $data["codigocentrobeneficio"];
       $facultad = $utils->getDataEntity("facultad", $data["codigofacultad"], "codigofacultad");   
       $detalleCurso = $utils->getDataEntity("detalleCursoEducacionContinuada", $data["codigocarrera"], "codigocarrera"); 
       $actividad = $utils->getDataEntity("actividadEducacionContinuada", $detalleCurso["actividad"], "idactividadEducacionContinuada"); 
       if($actividad["actividadPadre"]==0){
            $actividadPadre = $detalleCurso["actividad"];
       } else {
           $actividadPadre = $actividad["actividadPadre"];
       }
       $materia = $utils->getDataEntity("materia", $data["codigocarrera"], "codigocarrera");  
		$hayDetalle = false;	   
	   if(count($detalleCurso)>0){
		$hayDetalle = true;	
        $categoria = $utils->getDataEntity("categoriaCursoEducacionContinuada", $detalleCurso["categoria"], "idcategoriaCursoEducacionContinuada"); 
        $ciudad = $utils->getDataEntity("ciudad", $detalleCurso["ciudad"], "idciudad"); 
	   }
	   $action = "update";
           
           $valorM = $utils->getValorMatriculaCurso($db, $id);     
           $fechasInscripcion = $utils->getFechasInscripcionCurso($db, $id); 
    }
    
    ?>
<div id="form"> 
    <form action="save.php" method="post" id="form_test">
            <input type="hidden" name="entity" value="carrera" />
            <input type="hidden" name="action" value="<?php echo $action; ?>" />
            <?php
            if($edit&&$id!=""){
                echo '<input type="hidden" name="codigocarrera" value="'.$id.'">';
                echo '<input type="hidden" name="codigomateria" value="'.$materia["codigomateria"].'">';
            }
            if($hayDetalle){
                echo '<input type="hidden" name="iddetalleCursoEducacionContinuada" value="'.$detalleCurso["iddetalleCursoEducacionContinuada"].'">';
            }
            ?>
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset>   
                <legend>Información Básica</legend>
                <label for="nombre" class="fixed">Nombre del Programa: <span class="mandatory">(*)</span></label>
                <input type="text" title="Nombre del Curso" id="nombre" name="nombre" class="grid-9-12 required" maxlength="120" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['nombrecarrera']; } ?>" />
		<span id="mensajeBloque" style="font-size:0.7em;display:none;clear:both;position: relative;top: -18px;margin-left:207px">Ya existe un curso con ese nombre. <br/>¿Estás seguro(a) que no deseas <a  href="#" style="text-decoration: underline;">agregar una nueva fecha/versión del curso</a>?</span>
				
                <label for="codigo" class="fixed">Facultad:</label>
                <?php $utils->pintarCampoPublico($db,"Facultad",$facultad["codigofacultad"]); ?> 
				
				<label for="codigo" class="fixed">Centro de Beneficio: <span class="mandatory">(*)</span></label>
				<input type="text" class="grid-3-12 required" name="codigocentrobeneficio" id="codigocentrobeneficio" title="Centro de Beneficio" maxlength="150" tabindex="1" autocomplete="off" value="<?php echo $centroBeneficio; ?>" />                    
                
                <label for="descripcion" class="fixed">Tipo de Actividad: <span class="mandatory">(*)</span></label>
                <?php // actividad es el nombre del select, el null es el que esta elegido de la lista, 
                        //primer true que se deje una opción en blanco, segundo false que no deje elegir múltiples opciones
			//el 1 es si es un listbox o un select, 
			echo $actividades->GetMenu2('actividadPadre',$actividadPadre,true,false,1,'id="actividad" class="grid-3-12 required"'); ?>
                
		<label for="intensidad" class="fixed">Intensidad (en horas): <span class="mandatory">(*)</span></label>
                <input type="text" class="grid-1-12 required number" name="intensidad" id="intensidad" title="Duración en horas" maxlength="10" tabindex="1" autocomplete="off" value="<?php echo $detalleCurso["intensidad"]; ?>" />
				
                <label for="nucleo" class="fixed">Núcleo Estratégico: <span class="mandatory">(*)</span></label>
                <?php echo $nucleos->GetMenu2('nucleoEstrategico',$detalleCurso["nucleoEstrategico"],true,false,1,'id="nucleoEstrategico" class="grid-3-12 required"'); ?>
                 <div class="vacio"></div>	            
                <label for="categoria" class="fixed">Categoría: <?php if(!$hayDetalle) { ?>	<span class="mandatory">(*)</span><?php } ?></label>
                <?php if(!$hayDetalle) { ?>	
                <?php echo $cats->GetMenu2('categoria',$detalleCurso["categoria"],true,false,1,'id="categoriaCurso" class="grid-3-12 required"'); ?>
                <?php } else { ?>
					
                    <span class="campoValor" style="font-size:0.9em"><?php echo $categoria["nombre"]; ?></span><div class="vacio"></div>
					<input type="hidden" name="categoria" value="<?php echo $detalleCurso["categoria"]; ?>" />
                <?php } ?>
							
                <div id="ciudadContent" <?php if($hayDetalle && $detalleCurso["categoria"]==1) { ?> style="display:block;" <?php  } else { ?> style="display:none;" <?php } ?>>
				<label for="ciudad" class="fixed">Ciudad: <span class="mandatory">(*)</span></label>
				<input type="text"  class="grid-3-12" minlength="2" name="ciudad" id="ciudad" title="ciudad" maxlength="150" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $ciudad['nombreciudad']; } ?>" />
				<input type="hidden"  class="grid-3-12" minlength="2" name="idciudad" id="idciudad" maxlength="12" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $detalleCurso['ciudad']; } ?>" />
                <input type="hidden"  class="grid-3-12" minlength="2" name="tmp_ciudad" id="tmp_ciudad" value="<?php if($edit){ echo $ciudad['nombreciudad']; } ?>" />
                </div>             
				<?php if(!$edit) { ?>	
				
                <label for="descripcion" class="fixed">Tipo de Programa: <span class="mandatory">(*)</span></label>
                <?php 	echo $tipos->GetMenu2('tipo',null,true,false,1,'id="tipo" class="grid-3-12 required"'); ?>
               	
				<div id="inscripciones" style="display:block;" >
                    <label for="fechaInicioInscripcion" class="fixed">Fecha de inicio de inscripciones: <span class="mandatory">(*)</span></label>
                    <input type="text" class="grid-2-12 required" name="fechaInicioInscripcion" id="fechaInicioInscripcion" title="Fecha de inicio de inscripción" maxlength="100" tabindex="1" autocomplete="off" value="<?php echo $fechasInscripcion["inicio"]; ?>" readonly="readonly" />

                    <label for="fechaFinalInscripcion" class="fixed">Fecha final para inscripciones: <span class="mandatory">(*)</span></label>
                    <input type="text" class="grid-2-12 required" name="fechaFinalInscripcion" id="fechaFinalInscripcion" title="Fecha final de inscripción" maxlength="100" tabindex="1" autocomplete="off" value="<?php echo $fechasInscripcion["final"]; ?>" readonly="readonly" />

                    <label for="valorMatricula" class="fixed">Valor matrícula: <span class="mandatory">(*)</span></label>
                    <input type="text" class="grid-3-12 required number" name="valorMatricula" id="valorMatricula" title="Valor de la matricula" maxlength="30" tabindex="1" autocomplete="off" value="<?php echo $valorM; ?>" />
                    
                    <label for="fechaFinalMatriculas" class="fixed">Fecha final para pago matrícula: <span class="mandatory">(*)</span></label>
                    <input type="text" class="grid-2-12" name="fechaFinalMatriculas" id="fechaFinalMatriculas" title="Fecha final de inscripción" maxlength="100" tabindex="1" autocomplete="off" value="" readonly="readonly" />
				
					<label for="cupoEstudiantes" class="fixed">Cupo de estudiantes: <span class="mandatory">(*)</span></label>
                    <input type="text" class="grid-1-12 number <?php echo $required; ?>" name="cupoEstudiantes" id="cupoEstudiantes" title="Cupo de estudiantes permitido" maxlength="10" tabindex="1" autocomplete="off" value="" />
				</div>

                <?php } ?>   
							
				<label for="descripcion" class="fixed">Modalidad de Certificación: <span class="mandatory">(*)</span></label>
                <?php 
					echo $modalidad->GetMenu2('modalidadCertificacion',$detalleCurso["modalidadCertificacion"],true,false,1,'id="modalidadCertificacion" class="grid-3-12 required"');
                ?> 
							
				<label for="descripcion" class="fixed">Tipo de Certificación: <span class="mandatory">(*)</span></label>
                <?php 
					echo $tiposC->GetMenu2('tipoCertificacion',$detalleCurso["tipoCertificacion"],true,false,1,'id="tipoCertificacion" class="grid-3-12 required"');
                ?> 
							
				<div id="numCreditos" <?php if($hayDetalle && $detalleCurso["tipoCertificacion"]==3) { ?> style="display:block;" <?php  } else { ?>style="display:none"<?php } ?>>
					<label for="numCreditos" class="fixed" >Número de Créditos: <?php if(!$hayDetalle) { ?><span class="mandatory">(*)</span><?php } ?></label>
					<input type="text" class="grid-1-12 number" name="numerocreditos" id="numerocreditos" title="Número de créditos" maxlength="10" tabindex="1" autocomplete="off" value="<?php echo $materia["numerocreditos"]; ?>" />
				</div>
				
				<div class="vacio"></div>
                <label for="procentaje" class="fixed">Porcentaje de Fallas: <span class="mandatory">(*)</span></label>
				<?php if($hayDetalle) { ?>
				<input type="text"  class="grid-2-12 required number" name="porcentajeFallasPermitidas" id="porcentajeFallasPermitidas" title="Porcentaje de fallas" maxlength="20" tabindex="1" autocomplete="off" readonly="readonly" value="<?php echo $detalleCurso["porcentajeFallasPermitidas"]; ?>" />
                <?php } else { 
                 $utils->pintarCampoPublico($db,"Porcentaje de Faltas"); 
				 } ?> 
                                
                                <?php if(!$edit) { ?>	
                                <label for="autorizacion" class="fixed">Autorizado por: <span class="mandatory">(*)</span></label>
                                <textarea name="autorizacion" class="grid-9-12 required" style="height:60px;"></textarea>
                                <?php } ?>
								
				<label for="orden" class="fixed">¿Permite generar orden automática?: <span class="mandatory">(*)</span></label>
				<select class="grid-3-12 required" id="generaOrdenAutomatica" size="1" name="generaOrdenAutomatica">
				<option value="0" <?php if ($detalleCurso["generaOrdenAutomatica"]==null || $detalleCurso["generaOrdenAutomatica"]==0){ ?>selected="selected"<?php } ?>>No</option>
				<option value="1" <?php if ($detalleCurso["generaOrdenAutomatica"]==1){ ?>selected="selected"<?php } ?>>Si</option>
				</select>
            </fieldset>
			<?php if(!$edit) { ?>
            <fieldset id="containerAutoComplete">   
                <legend>Información Detallada</legend>
                
				<label for="nombre" class="fixed">Fecha de Inicio: <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-2-12 required" name="fechainiciogrupo" id="fechainiciogrupo" title="Fecha de Inicio del Curso" maxlength="20" tabindex="1" autocomplete="off" readonly="readonly" value="<?php if($edit){ echo $data['fecha_prox_monitoreo']; } ?>" />

                <label for="nombre" class="fixed">Fecha de Finalización: <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-2-12 required" name="fechafinalgrupo" id="fechafinalgrupo" title="Fecha Final del Curso" maxlength="20" tabindex="1" autocomplete="off" readonly="readonly" value="<?php if($edit){ echo $data['fecha_prox_monitoreo']; } ?>" />
				
                <div class="vacio"></div>
                            
                <div id="empresas" style="display:none;">
                    <div class="empresa">
                        <label for="nombre" class="fixed">Empresa: <span class="mandatory">(*)</span></label>
                        <input type="text"  class="grid-5-12 empresaName" minlength="2" name="empresa[]" id="empresa_1" title="Empresa" maxlength="200" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['codigo']; } ?>" />
                        <input type="hidden"  class="grid-5-12" minlength="2" name="idempresa[]" id="idempresa_1" maxlength="12" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['codigo']; } ?>" />
                        <input type="hidden"  class="grid-5-12" minlength="2" name="tmp_empresa[]" id="tmp_empresa_1" value="<?php if($edit){ echo $data['codigo']; } ?>" />
                    </div>
                                
                    <button class="soft addBtn" type="button" id="btnEmpresas">Agregar otra empresa</button>
                    <input type="hidden"  class="grid-3-12" name="numEmpresas" id="numEmpresas" value="1" />
                </div>
							
				<div class="vacio"></div>
							
				<div id="profesores">
                    <div class="profesor">
                        <label for="nombre" class="fixed">Profesor: <span class="mandatory">(*)</span></label>
                        <input type="text"  class="grid-5-12 required profesorName" minlength="2" name="profesor[]" id="profesor_1" title="Profesor" maxlength="200" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['codigo']; } ?>" />
                        <input type="hidden"  class="grid-5-12 idprofesor" minlength="2" name="idprofesor[]" id="idprofesor_1" maxlength="12" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['codigo']; } ?>" />
                    </div>
                                
                    <button class="soft addBtn" type="button" id="btnProfesores">Agregar otro docente</button>
                    <input type="hidden"  class="grid-3-12" name="numProfesores" id="numProfesores" value="1" />
                </div>
            </fieldset>
            <?php } ?>
			
            <?php if($edit){ ?><input type="submit" value="Guardar cambios" class="first" />
            <?php } else { ?><input type="submit" value="Registrar curso" class="first" /> <?php } ?>
            <img src="../images/ajax-loader2.gif" style="display:none;clear:both;margin-bottom:15px;margin-left: 16.4%;" id="loading"/>
        </form>
</div>
<script type="text/javascript" language="javascript" src="../js/functionsCursos.js?v=1"></script>  
<script type="text/javascript">
                $(':submit').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_test");
		if(valido){
                    <?php if(!$edit){ ?>
                        //validar que la fecha de inicio no sea mayor que la fecha final de inscripcion
                        valido = validarCursosGrupo();
                    
                        <?php } ?>  
                            
                        if(( ($('#categoriaCurso').val()==1 || $('#categoriaCurso').val()==3) && $('#ciudad').val()=="")){
                            $( "#ciudad" ).addClass('error');
                            $( "#ciudad" ).effect("pulsate", { times:3 }, 500);
                            valido = false;
                        }
		
                    }
                    if(valido){
                        sendForm();
                    }
                });		
	

                function sendForm(){
                    $(':submit').css("display","none");
                    $("#loading").css("display","block");
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process.php',
                        data: $('#form_test').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 window.location.href="detalle.php?id="+data.id;
                            }
                            else{ 
                                alert(data.message);
                                //$('#msg-error').html('<p>' + data.message + '</p>');
                                //$('#msg-error').addClass('msg-error');
                            }
                            $(':submit').css("display","block");
                            $("#loading").css("display","none");
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });            
                }
                
                $('#nombre').change(function() {
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: '../searches/existeCurso.php',
                        data: { nombre: $('#nombre').val() },                
                        success:function(data){
                            if (data.result == true){
                                $('#mensajeBloque').css('display', 'block');
                                $('#mensajeBloque a').attr("href","registrarNuevaVersion.php?id="+data.id);
                            }
                            else{                                       
                                $('#mensajeBloque a').attr("href","#");
                                $('#mensajeBloque').hide();
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    }); 
                });
                
                $('#categoriaCurso').change(function(event) {
					if($('#categoriaCurso').val()==1 || $('#categoriaCurso').val()==3){
						$('#ciudadContent').css("display","block");
					} else {
						$('#ciudadContent').css("display","none");
						$('#ciudad').val("");
						$('#idciudad').val("");                                                
					}
                }); 
				
				$('#tipoCertificacion').change(function(event) {
					if($('#tipoCertificacion').val()==3){
						$('#numCreditos').css("display","block");
					} else {
						$('#numCreditos').css("display","none");
						$('#numerocreditos').val("");                                         
					}
                }); 
				
                
                 $('#tipo').change(function(event) {
                     //si es cerrado entonces tiene que haber empresas patrocinadoras
			if($('#tipo').val()==2){
				$('#empresas').css("display","block");
                 /*$('#inscripciones').css("display","none");
                                $('#inscripciones input').each(function() {
                                    $(this).removeClass("required");
                                    $(this).removeClass("error");
                                    $(this).val("");
									if($(this).hasClass("number")){
										$(this).val(0);
									}
                                }); */
			} else {
                   /* $("#inscripciones").css("display","block");
                                $('#inscripciones input').each(function() {
                                    $(this).addClass("required");
									if($(this).hasClass("number")){
										$(this).val("");
									}
                                });  */
				$('#empresas').css("display","none");
                                var i = 1;
                                $('.empresa').each(function() {
                                        if(i == 1){
                                              $('#empresa_1').val("");
                                              $('#idempresa_1').val("");
                                              $('#tmp_empresa_1').val("");
                                              i = 2;
                                        } else {
                                              $(this).remove();
                                        }
                                }); 
                                $("#btnEmpresas").removeClass("disable");
                                $( "#numEmpresas" ).val("1");
			}
                }); 
                
                $(document).ready(function(){
                    $('#ciudad').autocomplete({
                        source: function( request, response ) {
                            $.ajax({
                                url: "../searches/lookForCiudades.php",
                                dataType: "json",
                                data: {
                                    term: request.term
                                },
                                success: function( data ) {
                                    response( $.map( data, function( item ) {
                                        return {
                                            label: item.label,
                                            value: item.value,
                                            id: item.id
                                        }
                                    }));
                                }
                            });
                        },
                        minLength: 2,
                        selectFirst: false,
                        open: function(event, ui) {
                            var maxWidth = $('#form_test').width()-400;  
                            var width = $(this).autocomplete("widget").width();
                            if(width>maxWidth){
                                $(".ui-autocomplete.ui-menu").width(maxWidth);                                 
                            }
                            $('#tmp_ciudad').val($('#ciudad').val());
                        },
                        select: function( event, ui ) {
                            //alert(ui.item.id);
                            if(ui.item.value=="null"){
                                event.preventDefault();
                                $('#ciudad').val($('#tmp_ciudad').val());
                            }
                            $('#idciudad').val(ui.item.id);
                        }                
                    });
                });
				
	$(document).on("keyup",".empresaName",function(event){
                    var idNumber = $(this).attr("id");
                    idNumber = idNumber.split("_");
                    idNumber = idNumber[idNumber.length-1];
                    
                    $(this).autocomplete({
                        source: function( request, response ) {
                            $.ajax({
                                url: "../searches/lookForEmpresas.php",
                                dataType: "json",
                                data: {
                                    term: request.term
                                },
                                success: function( data ) {
                                    response( $.map( data, function( item ) {
                                        return {
                                            label: item.label,
                                            value: item.value,
                                            id: item.id
                                        }
                                    }));
                                }
                            });
                        },
                        minLength: 2,
                        selectFirst: false,
                        open: function(event, ui) {
                            var maxWidth = $('#form_test').width()-400;  
                            var width = $(this).autocomplete("widget").width();
                            if(width>maxWidth){
                                $(".ui-autocomplete.ui-menu").width(maxWidth);                                 
                            }
                            $('#tmp_empresa_'+idNumber).val($('#empresa_'+idNumber).val());
                        },
                        select: function( event, ui ) {
                            //alert(ui.item.id);
                            if(ui.item.value=="null"){
                                event.preventDefault();
                                $('#empresa_'+idNumber).val($('#tmp_empresa_'+idNumber).val());
                            }
                            $('#idempresa_'+idNumber).val(ui.item.id);
                        }                
                    });
    
                });
                
                $(document).ready(function() {                    
                    //para que si es editando traiga las actividades hijas
                    getActividadesHijas(<?php echo $actividad["idactividadEducacionContinuada"]; ?>);
                });
                
  </script>
  <?php } ?>