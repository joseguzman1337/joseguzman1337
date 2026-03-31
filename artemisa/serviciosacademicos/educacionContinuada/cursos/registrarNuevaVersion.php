<?php
    session_start;
	/*include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
	
	include_once(realpath(dirname(__FILE__))."/../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Registrar Nueva Fecha",TRUE);

    include("./menu.php");
    writeMenu(0);
    
    $data = array();
    $utils = Utils::getInstance();
	$edit = false;
        $editGrupo=false;
    if(isset($_REQUEST["id"])){  
        $edit = true;
       $id = str_replace('row_','',$_REQUEST["id"]);
       $data = $utils->getDataEntity("carrera", $id, "codigocarrera");   
       $facultad = $utils->getDataEntity("facultad", $data["codigofacultad"], "codigofacultad");   
       $detalleCurso = $utils->getDataEntity("detalleCursoEducacionContinuada", $data["codigocarrera"], "codigocarrera"); 
	$materia = $utils->getDataEntity("materia", $data["codigocarrera"], "codigocarrera");  
		$hayDetalle = false;	   
	   if(count($detalleCurso)>0){
		$hayDetalle = true;	
                $actividad = $utils->getDataEntity("actividadEducacionContinuada", $detalleCurso["actividad"], "idactividadEducacionContinuada"); 
        $categoria = $utils->getDataEntity("categoriaCursoEducacionContinuada", $detalleCurso["categoria"], "idcategoriaCursoEducacionContinuada"); 
        $ciudad = $utils->getDataEntity("ciudad", $detalleCurso["ciudad"], "idciudad"); 
        $nucleo = $utils->getDataEntity("nucleoEstrategico", $detalleCurso["nucleoEstrategico"], "idnucleoEstrategico"); 
        $modalidad = $utils->getDataEntity("modalidadCertificacionEducacionContinuada", $detalleCurso["modalidadCertificacion"], "idmodalidadCertificacionEducacionContinuada"); 
        $tipo = $utils->getDataEntity("tipoCertificacionEducacionContinuada", $detalleCurso["tipoCertificacion"], "idtipoCertificacionEducacionContinuada"); 
	   }
   }
   
   if(isset($_REQUEST["idGrupo"])){  
        $editGrupo = true;
       $grupo = $utils->getDataEntity("grupo", $_REQUEST["idGrupo"], "idgrupo");   
       $dataDetalleGrupo = $utils->getDataEntity("detalleGrupoCursoEducacionContinuada", $grupo["idgrupo"], "idgrupo");
       $tipoGrupo = $utils->getDataEntity("tipoEducacionContinuada", $dataDetalleGrupo["tipo"], "idtipoEducacionContinuada");
	$fecha = $utils->getFechaMatricula($db, $grupo["idgrupo"]);
         $docentes = $utils->getDocentesGrupoCursoEducacionContinuada($db,$grupo["idgrupo"]); 
         $empresas = $utils->getEmpresasGrupoCursoEducacionContinuada($db,$grupo["idgrupo"]); 
           $valorM = $utils->getValorMatriculaCurso($db, $id);     
           $fechasInscripcion = $utils->getFechasInscripcionCurso($db, $id);   
		   $empresas = $utils->getEmpresasGrupoCursoEducacionContinuada($db,$grupo["idgrupo"]); 
   }
?>

    <div id="contenido">
        <h4>Registrar Nuevo Fecha para un Programa</h4>
           <div id="form"> 
                <form action="save.php" method="post" id="form_test">
                        <input type="hidden" name="action" value="saveGroup" />
                        <input type="hidden" name="entity" value="grupo" />
                        <input type="hidden" name="codigocarrera" value="<?php echo $data["codigocarrera"]; ?>">
                        <input type="hidden" name="codigomateria" value="<?php echo $materia["codigomateria"]; ?>">
                        <input type="hidden" name="nombre" value="<?php echo $data["nombrecarrera"]; ?>">
                         <?php
                            if($hayDetalle){
                                echo '<input type="hidden" name="iddetalleCursoEducacionContinuada" value="'.$detalleCurso["iddetalleCursoEducacionContinuada"].'">';
                            }
                            if($editGrupo){
                                echo '<input type="hidden" name="idgrupo" value="'.$grupo["idgrupo"].'">';
                            }
                        ?>
                        <span class="mandatory">* Son campos obligatorios</span>
                        <fieldset>   
                            <legend>Información Básica</legend>
                            <label for="nombre" class="fixed">Nombre del Programa: </label>
                            <span class="campoValor"><?php echo $data["nombrecarrera"]; ?></span><div class="vacio"></div>

                            <label for="facultad" class="fixed">Facultad:</label>
                            <span class="campoValor"><?php echo $facultad["nombrefacultad"]; ?></span><div class="vacio"></div>
                            
                            <label for="actividad" class="fixed">Tipo de Actividad: <?php if(!$hayDetalle) { ?><span class="mandatory">(*)</span><?php } ?></label>
							<?php if($hayDetalle) { ?>
							<span class="campoValor"><?php echo $actividad["nombre"]; ?></span><div class="vacio"></div>
							<?php } else { $actividades = $utils->getAll($db,"nombre,idactividadEducacionContinuada","actividadEducacionContinuada","codigoestado=100 AND actividadPadre=0","nombre");
							// nucleoEstrategico es el nombre del select, el null es el que esta elegido de la lista, 
							//primer true que se deje una opción en blanco, segundo false que no deje elegir múltiples opciones
							//el 1 es si es un listbox o un select, 
							echo $actividades->GetMenu2('actividadPadre',null,true,false,1,'id="actividad" class="grid-3-12 required"');
							
			 } ?>
                                                        
                            <label for="intensidad" class="fixed">Intensidad (en horas): <?php if(!$hayDetalle) { ?><span class="mandatory">(*)</span><?php } ?></label>
				<?php if($hayDetalle) { ?>
                                    <span class="campoValor"><?php echo $detalleCurso["intensidad"]; ?></span><div class="vacio"></div>
                                <?php } else { ?>                                
                                    <input type="text" class="grid-1-12 required number" name="intensidad" id="intensidad" title="Duración en horas" maxlength="10" tabindex="1" autocomplete="off" value="" />
                                <?php } ?>

                            <label for="nucleo" class="fixed">Núcleo Estratégico: <?php if(!$hayDetalle) { ?><span class="mandatory">(*)</span><?php } ?></label>
							<?php if($hayDetalle) { ?>
							<span class="campoValor"><?php echo $nucleo["nombre"]; ?></span><div class="vacio"></div>
							<?php } else { $nucleos = $utils->getAll($db,"nombre,idnucleoEstrategico","nucleoEstrategico","codigoestado=100","nombre");
							// nucleoEstrategico es el nombre del select, el null es el que esta elegido de la lista, 
							//primer true que se deje una opción en blanco, segundo false que no deje elegir múltiples opciones
							//el 1 es si es un listbox o un select, 
							echo $nucleos->GetMenu2('nucleoEstrategico',null,true,false,1,'id="nucleoEstrategico" class="grid-3-12 required"');
							
							} ?>
                            <label for="categoria" class="fixed">Categoría: <?php if(!$hayDetalle) { ?><span class="mandatory">(*)</span><?php } ?></label>
                            <?php if($hayDetalle) { ?>
							<span class="campoValor"><?php echo $categoria["nombre"]; ?></span><div class="vacio"></div>
                                                        <input type="hidden" name="categoria" value="<?php echo $detalleCurso["categoria"]; ?>" />
							<?php } else { $cats = $utils->getAll($db,"nombre,idcategoriaCursoEducacionContinuada","categoriaCursoEducacionContinuada","codigoestado=100","nombre"); 
							echo $cats->GetMenu2('categoria',null,true,false,1,'id="categoriaCurso" class="grid-3-12 required"');
							} ?>
                            
                            <div id="ciudadContent" <?php if($hayDetalle && $detalleCurso["categoria"]==1) { ?> style="display:block;" <?php  } else { ?> style="display:none;" <?php } ?>>
				<label for="ciudad" class="fixed">Ciudad: <span class="mandatory">(*)</span></label>
				<input type="text"  class="grid-3-12" minlength="2" name="ciudad" id="ciudad" title="ciudad" maxlength="150" tabindex="1" autocomplete="off" value="<?php echo $ciudad['nombreciudad']; ?>" />
				<input type="hidden"  class="grid-3-12" minlength="2" name="idciudad" id="idciudad" maxlength="12" tabindex="1" autocomplete="off" value="<?php echo $detalleCurso['ciudad']; ?>" />
                                <input type="hidden"  class="grid-3-12" minlength="2" name="tmp_ciudad" id="tmp_ciudad" value="<?php echo $ciudad['nombreciudad']; ?>" />
                            </div>
							
                            <label for="descripcion" class="fixed">Tipo de Programa: <span class="mandatory">(*)</span></label>
                            <?php $tipos = $utils->getAll($db,"nombre,idtipoEducacionContinuada","tipoEducacionContinuada","codigoestado=100","nombre"); 
								echo $tipos->GetMenu2('tipo',$tipoGrupo["idtipoEducacionContinuada"],true,false,1,'id="tipo" class="grid-3-12 required"');
                            ?>       
                            
          	<div id="inscripciones" <?php $required="required"; ?> style="display:block;">
                    <label for="fechaInicioInscripcion" class="fixed">Fecha de inicio de inscripciones: <span class="mandatory">(*)</span></label>
                    <input type="text" class="grid-2-12 <?php echo $required; ?>" name="fechaInicioInscripcion" id="fechaInicioInscripcion" title="Fecha de inicio de inscripción" maxlength="100" tabindex="1" autocomplete="off" value="<?php echo $fechasInscripcion["inicio"]; ?>" readonly="readonly" />

                    <label for="fechaFinalInscripcion" class="fixed">Fecha final para inscripciones: <span class="mandatory">(*)</span></label>
                    <input type="text" class="grid-2-12 <?php echo $required; ?>" name="fechaFinalInscripcion" id="fechaFinalInscripcion" title="Fecha final de inscripción" maxlength="100" tabindex="1" autocomplete="off" value="<?php echo $fechasInscripcion["final"]; ?>" readonly="readonly" />

                    <label for="valorMatricula" class="fixed">Valor matrícula: <span class="mandatory">(*)</span></label>
                    <input type="text" class="grid-3-12 number <?php echo $required; ?>" name="valorMatricula" id="valorMatricula" title="Valor de la matricula" maxlength="30" tabindex="1" autocomplete="off" value="<?php echo $valorM; ?>" />
                    
                    <label for="fechaFinalMatriculas" class="fixed">Fecha final para pago matrícula: <span class="mandatory">(*)</span></label>
                    <input type="text" class="grid-2-12 <?php echo $required; ?>" name="fechaFinalMatriculas" id="fechaFinalMatriculas" title="Fecha final de inscripción" maxlength="100" tabindex="1" autocomplete="off" value="<?php echo $fecha; ?>" readonly="readonly" />

                    <label for="cupoEstudiantes" class="fixed">Cupo de estudiantes: <span class="mandatory">(*)</span></label>
                    <input type="text" class="grid-1-12 <?php echo $required; ?>" name="cupoEstudiantes" id="cupoEstudiantes" title="Cupo de estudiantes permitido" maxlength="10" tabindex="1" autocomplete="off" value="<?php echo $grupo["maximogrupo"]; ?>" />

                </div>              
                                                        
							<div class="vacio"></div>
                                                        
							<label for="descripcion" class="fixed">Modalidad de Certificación: <?php if(!$hayDetalle) { ?><span class="mandatory">(*)</span><?php } ?></label>
                            <?php if($hayDetalle) { ?>
							<span class="campoValor"><?php echo $modalidad["nombre"]; ?></span><div class="vacio"></div>
							<?php } else { $tipos = $utils->getAll($db,"nombre,idmodalidadCertificacionEducacionContinuada","modalidadCertificacionEducacionContinuada","codigoestado=100","nombre"); 
								echo $tipos->GetMenu2('modalidadCertificacion',null,true,false,1,'id="modalidadCertificacion" class="grid-3-12 required"');
                                                        } ?> 
							
							<label for="descripcion" class="fixed">Tipo de Certificación: <?php if(!$hayDetalle) { ?><span class="mandatory">(*)</span><?php } ?></label>
                            <?php if($hayDetalle) { ?>
							<span class="campoValor"><?php echo $tipo["nombre"]; ?></span><div class="vacio"></div>
							<?php } else { $tipos = $utils->getAll($db,"nombre,idtipoCertificacionEducacionContinuada","tipoCertificacionEducacionContinuada","codigoestado=100","nombre"); 
								echo $tipos->GetMenu2('tipoCertificacion',null,true,false,1,'id="tipoCertificacion" class="grid-3-12 required"');
                                                        }  ?> 
							<div class="vacio"></div>
							<div id="numCreditos" <?php if($hayDetalle && $detalleCurso["tipoCertificacion"]==3) { ?> style="display:block;" <?php  } else { ?>style="display:none"<?php } ?>>
							<label for="numCreditos" class="fixed" >Número de Créditos: <?php if(!$hayDetalle) { ?><span class="mandatory">(*)</span><?php } ?></label>
				<?php if($hayDetalle) { ?>
                                    <span class="campoValor"><?php echo $materia["numerocreditos"]; ?></span><div class="vacio"></div>
                                <?php } else { ?>                                
                                    <input type="text" class="grid-1-12 number" name="numerocreditos" id="numerocreditos" title="Número de créditos" maxlength="10" tabindex="1" autocomplete="off" value="" />
                                <?php } ?>	
							</div>
							
							<div class="vacio"></div>
							<label for="procentaje" class="fixed">Porcentaje de Fallas: <?php if(!$hayDetalle) { ?><span class="mandatory">(*)</span><?php } ?></label>
								<?php if($hayDetalle) { ?>
                                    <span class="campoValor"><?php echo $detalleCurso["porcentajeFallasPermitidas"]; ?></span><div class="vacio"></div>
                                <?php } else {                                
                                    $utils->pintarCampoPublico($db,"Porcentaje de Faltas"); 
                                 } ?>
								 
							<div class="vacio"></div>
								 
                            <label for="estado" class="fixed">Estado: <span class="mandatory">(*)</span></label>
                            <?php $tipos = $utils->getAll($db,"nombreestadogrupo,codigoestadogrupo","estadogrupo","","nombreestadogrupo"); 
								echo $tipos->GetMenu2('codigoestadogrupo',$grupo["codigoestadogrupo"],true,false,1,'id="codigoestadogrupo" class="grid-3-12 required"');
                            ?>   
                        </fieldset>
                        <fieldset id="containerAutoComplete">   
                            <legend>Información Detallada</legend>
                            
                            <label for="nombre" class="fixed">Fecha de Inicio: <span class="mandatory">(*)</span></label>
                            <input type="text"  class="grid-2-12 required" name="fechainiciogrupo" id="fechainiciogrupo" title="Fecha de Inicio del Curso" maxlength="20" tabindex="1" autocomplete="off" readonly="readonly" value="<?php if($edit){ echo $grupo['fechainiciogrupo']; } ?>" />

                            <label for="nombre" class="fixed">Fecha de Finalización: <span class="mandatory">(*)</span></label>
                            <input type="text"  class="grid-2-12 required" name="fechafinalgrupo" id="fechafinalgrupo" title="Fecha Final del Curso" maxlength="20" tabindex="1" autocomplete="off" readonly="readonly" value="<?php if($edit){ echo $grupo['fechafinalgrupo']; } ?>" />
	
                            <div class="vacio"></div>
                            
                            <div id="empresas" <?php if($tipoGrupo["idtipoEducacionContinuada"]==2 || $tipoGrupo["idtipoEducacionContinuada"]=="2"){ ?> 
                    style="display:block;" <?php $required = "";} else { $required="required"; ?> style="display:none;" <?php } ?>>
                                <div class="empresa">
								<?php $i=1; if(!$editGrupo){ ?>
										<label for="nombre" class="fixed">Empresa: <span class="mandatory">(*)</span></label>
										<input type="text"  class="grid-5-12 empresaName" minlength="2" name="empresa[]" id="empresa_1" title="Empresa" maxlength="200" tabindex="1" autocomplete="off" value="" />
										<input type="hidden"  class="grid-5-12" minlength="2" name="idempresa[]" id="idempresa_1" maxlength="12" tabindex="1" autocomplete="off" value="" />
										<input type="hidden"  class="grid-5-12" minlength="2" name="tmp_empresa[]" id="tmp_empresa_1" value="" />
									<?php } else { foreach($empresas as $row) { ?>
										<label for="nombre" class="fixed">Empresa: <span class="mandatory">(*)</span></label>
										<input type="text"  class="grid-5-12 empresaName" minlength="2" name="empresa[]" id="empresa_<?php echo $i; ?>" title="Empresa" maxlength="200" tabindex="1" autocomplete="off" value="<?php  echo $row['nombreempresa']; ?>" />
										<input type="hidden"  class="grid-5-12" minlength="2" name="idempresa[]" id="idempresa_<?php echo $i; ?>" maxlength="12" tabindex="1" autocomplete="off" value="<?php  echo $row['idempresa']; ?>" />
										<input type="hidden"  class="grid-5-12" minlength="2" name="tmp_empresa[]" id="tmp_empresa_<?php echo $i; ?>" value="<?php  echo $row['nombreempresa']; ?>" />
									<?php $i++; } } ?>
								</div>
                                
                                <button class="soft addBtn" type="button" id="btnEmpresas">Agregar otra empresa</button>
                                <input type="hidden"  class="grid-3-12" name="numEmpresas" id="numEmpresas" value="<?php echo $i; ?>" />
                            </div>
							
							<div class="vacio"></div>
							
							<div id="profesores">
                                <div class="profesor">
                                    <?php $i=1; if(!$editGrupo){ ?>
                                    <label for="nombre" class="fixed">Profesor: <span class="mandatory">(*)</span></label>
                                    <input type="text"  class="grid-5-12 required profesorName" minlength="2" name="profesor[]" id="profesor_1" title="Profesor" maxlength="200" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['codigo']; } ?>" />
                                    <input type="hidden"  class="grid-5-12 idprofesor" minlength="2" name="idprofesor[]" id="idprofesor_1" maxlength="12" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['codigo']; } ?>" />
                                    <?php } else { foreach($docentes as $row) { ?>
                                    <label for="nombre" class="fixed">Profesor: <span class="mandatory">(*)</span></label>
                                    <input type="text"  class="grid-5-12 <?php if($i==1){echo "required";} ?> profesorName" minlength="2" name="profesor[]" id="profesor_<?php echo $i; ?>" title="Profesor" maxlength="200" tabindex="1" autocomplete="off" value="<?php echo $row["nombredocente"]." ".$row["apellidodocente"]; ?>" />
                                    <input type="hidden"  class="grid-5-12 idprofesor" minlength="2" name="idprofesor[]" id="idprofesor_<?php echo $i; ?>" maxlength="12" tabindex="1" autocomplete="off" value="<?php echo $row["numerodocumento"]; ?>" />
                                    <?php $i++; } } ?>
                                </div>
                                
                                <button class="soft addBtn" type="button" id="btnProfesores">Agregar otro docente</button>
                                <input type="hidden"  class="grid-3-12" name="numProfesores" id="numProfesores" value="<?php echo $i; ?>" />
                            </div>
                        </fieldset>

                        <?php if($edit){ ?><input type="submit" value="Guardar cambios" class="first" />
                        <?php } else { ?><input type="submit" value="Registrar curso" class="first" /> <?php } ?>
                        <img src="../images/ajax-loader2.gif" style="display:none;clear:both;margin-bottom:15px;margin-left: 16.4%;" id="loading"/>
                    </form>
            </div> 
    </div>  
<script type="text/javascript" language="javascript" src="../js/functionsCursos.js?v=1"></script>  
<script type="text/javascript">
                $(':submit').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_test");   
                    if(valido){
                        //validar que la fecha de inicio no sea mayor que la fecha final de inscripcion
                        valido = validarCursosGrupo();
                        //console.log(valido);
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
                                <?php if($edit) { ?>
                                 window.location.href="detalle.php?id="+data.id+"#ui-tabs-1";
                                 <?php  } else { ?>
                                     window.location.href="detalle.php?id="+data.id;
                                 <?php  } ?>
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
                                }); */
			} else {
                              /*  $("#inscripciones").css("display","block");
                                $('#inscripciones input').each(function() {
                                    $(this).addClass("required");
                                }); */
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
                
                
  </script>

<?php  writeFooter(); ?>