<script type="text/javascript">
	$(function() {
		$( "#tabs" ).tabs({    
                    cache: true,
                    select: function(event, ui) {       
                        //para que al cargarse vuelva a cargar en la que estaba
                        window.location.hash = ui.tab.hash;
                    },
                    beforeLoad: function( event, ui ) {
                            ui.jqXHR.error(function() {
                                    ui.panel.html(
                                    "Ocurrio un problema cargando el contenido." );
                                    });
                            }
		});
                //$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
                //$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
                
                $("#tabs").plusTabs({
   			className: "plusTabs", //classname for css scoping
   			seeMore: true,  //initiate "see more" behavior
   			seeMoreText: "Ver más formularios", //set see more text
   			showCount: true, //show drop down count
   			expandIcon: "&#9660; ", //icon/caret - if using image, specify image width
   			dropWidth: "auto", //width of dropdown
 			sizeTweak: 0 //adjust size of active tab to tweak "see more" layout
   		});
                
                /*$("#tabs").bind("tabsload",function(event,ui){
                    var total = $("#tabs").find('.ui-tabs-nav li').length;
                    if(ui.index<total){
                        try {
                            $(this).tabs( "load" , ui.index+1);
                        } catch (e) {
                        }
                    } else {
                        $(this).unbind('tabsload');
                    }
                });
                                
                //Para cargar todas las de ajax por debajo
                $( "#tabs" ).tabs('load',2);   */ 
                
	});
</script>

<div id="tabs" class="dontCalculate">
				<ul>
					<li><a href="#tabs-1">Proyectos realizados con diferentes grupos de interés</a></li>
					<li><a href="./formularios/academicos/_formUnidadesAcademicasParticipacionAcademicos.php?id=<?php echo $id; ?>" class="locationTab">Participación de los académicos</a></li>
					<li><a href="./formularios/academicos/_formUnidadesAcademicasProfesoresVisitantes.php?id=<?php echo $id; ?>" class="locationTab">Profesores visitantes recibidos en la Facultad</a></li>
					<li><a href="./formularios/academicos/_formUnidadesAcademicasReconocimientosProfesores.php?id=<?php echo $id; ?>" class="locationTab">Premios o reconocimientos a los académicos</a></li>
					<li><a href="./formularios/academicos/_formUnidadesAcademicasCapacitaciones.php?id=<?php echo $id; ?>" class="locationTab">Capacitación dada al talento Humano </a></li>
					<li><a href="./formularios/academicos/_formUnidadesAcademicasAulasVirtuales.php?id=<?php echo $id; ?>" class="locationTab">Uso de Aulas Virtuales en asignaturas</a></li>
					<li><a href="./formularios/academicos/MovilidadAcademica_html.php?id=<?php echo $id; ?>" class="locationTab">Movilidad académica estudiantil</a></li>
					<li><a href="./formularios/academicos/_formUnidadesAcademicasMovilidadProfesoral.php?id=<?php echo $id; ?>" class="locationTab">Movilidad académica Profesoral</a></li>
					<li><a href="./formularios/academicos/_formUnidadesAcademicasFormacionProfesional.php?id=<?php echo $id; ?>" class="locationTab">Académicos que participan en<br/>formación profesoral</a></li>
					<li><a href="./formularios/academicos/_formUnidadesAcademicasPlanEstudio.php?id=<?php echo $id; ?>" class="locationTab">Distribución del Plan de Estudios</a></li>
					<li><a href="./formularios/academicos/_formUnidadesAcademicasActividadesInvestigacion.php?id=<?php echo $id; ?>" class="locationTab">Actividades académicas de apoyo<br/>a la Investigación Formativa</a></li>
					<li><a href="./formularios/academicos/_formUnidadesAcademicasProductosInvestigacion.php?id=<?php echo $id; ?>" class="locationTab">Productos resultado de actividades<br/>de Investigación Formativa</a></li>
					<li><a href="./formularios/academicos/_formUnidadesAcademicasReconocimientosEstudiantes.php?id=<?php echo $id; ?>" class="locationTab">Reconocimientos a estudiantes<br/>(Investigación Formativa)</a></li>
					<li><a href="./formularios/academicos/_formUnidadesAcademicasEstudiantesInvestigacion.php?id=<?php echo $id; ?>" class="locationTab">Participación de estudiantes en la<br/>evaluación de la Investigación Formativa</a></li>
					<li><a href="./formularios/academicos/_formUnidadesAcademicasProyectosConsultoria.php?id=<?php echo $id; ?>" class="locationTab">Proyectos de consultoría</a></li>
					<li><a href="./formularios/academicos/_formUnidadesAcademicasActividadesAcademicos.php?id=<?php echo $id; ?>" class="locationTab">Dedicación de los Académicos por actividades</a></li>
					<!--<li><a href="./formularios/academicos/_formUnidadesAcademicasUnidadesBibliograficas.php?id=<?php //echo $id; ?>" class="locationTab">Descripción de Otras unidades Bibliográficas</a></li>-->
					<li><a href="./formularios/academicos/_formUnidadesAcademicasLaboratorios.php?id=<?php echo $id; ?>" class="locationTab">Laboratorios, Talleres, Museos, etc</a></li>
					<li><a href="./formularios/academicos/_formUnidadesAcademicasEquiposComputo.php?id=<?php echo $id; ?>" class="locationTab">Equipos de cómputo</a></li>
					<li><a href="./formularios/academicos/_formUnidadesAcademicasRedes.php?id=<?php echo $id; ?>" class="locationTab">Número de redes y asociaciones Institucionales</a></li>
					<li><a href="./formularios/academicos/_formUnidadesAcademicasAsignaturasBioetica.php?id=<?php echo $id; ?>&alias=apeirbyh" class="locationTab">Asignaturas que incorporan el referente<br/>de la bioética y las humanidades</a></li>
					<li><a href="./formularios/academicos/_formUnidadesAcademicasAsignaturasLenguaExtranjera.php?id=<?php echo $id; ?>&alias=auleaaecpupa" class="locationTab">Asignaturas que utilizan lengua extranjera</a></li>
					<li><a href="./formularios/academicos/_formUnidadesAcademicasAsignaturasInternacionalizacion.php?id=<?php echo $id; ?>&alias=aaiaaepu" class="locationTab">Asignaturas que articulan la internacionalización con<br/>las actividades de aprendizaje y evaluación</a></li>
					<li><a href="./formularios/academicos/_formUnidadesAcademicasAsignaturasTICs.php?id=<?php echo $id; ?>&alias=aihmtaeaaput" class="locationTab">Asignaturas que incluyen herramientas mediadas por las TICs</a></li>
				</ul>
<div id="tabs-1">
<form action="save.php" method="post" id="form_test">

<?php 
$usuario_con=$_SESSION['MM_Username'];
if($utils->UsuarioAprueba_FormHuerfana($db,$usuario_con)){
$aprobacion=true;
}
?>

            <input type="hidden" name="entity" id="entity" value="formUnidadesAcademicasProyectosGruposInteres" />
            <input type="hidden" name="action" value="saveDynamic2" id="action" />
            <input type="hidden" name="idsiq_formUnidadesAcademicasProyectosGruposInteres" value="" id="idsiq_formUnidadesAcademicasProyectosGruposInteres" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Proyectos realizados con diferentes grupos de interés</legend>
                
                <div class="formModalidad">
                     <?php include("./formularios/academicos/_elegirProgramaAcademico.php"); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect();  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  
                    $sectores = $utils->getActives($db,"siq_sectores","idsiq_sectores");
                ?>
				
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />
            
            <?php $utils->pintarBotonCargar("popup_cargarDocumento(9,1,$('#form_test #mes').val()+'-'+$('#form_test #anio').val(),$('#form_test #unidadAcademica').val())","popup_verDocumentos(9,1,$('#form_test #mes').val()+'-'+$('#form_test #anio').val(),$('#form_test #unidadAcademica').val())"); ?>
             
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns" >
                            <th class="column" colspan="<?php if($aprobacion) echo "5"; else echo "4";?>" style="border-width: 1px 0 0px;"><span>Proyección social: Proyectos realizados con diferentes grupos de interés, según el núcleo estratégico</span></th>                                 
					   </tr>
					    <tr class="dataColumns">                                
							<th class="column" colspan="<?php if($aprobacion) echo "5"; else echo "4";?>" style="font-size:0.8em;border-width: 0px 0 1px;"><span>(Diligenciar solo la fecha de inicio de cada proyecto)</span></th>      
                        </tr>
						<tr class="dataColumns category">
                            <th class="column borderR" rowspan="2"><span>Sector</span></th> 
                            <th class="column borderR" colspan="2"><span>Núcleo estratégico</span></th> 
                            <th class="column" rowspan="2"><span>Otras Disciplinas</span></th> 
                            <?php if($aprobacion) { ?>
                            <th class="column" rowspan="2"><span>Aprobar</span></th> 
                            <?php } ?>
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Salud</span></th> 
                            <th class="column borderR" ><span>Calidad de Vida</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         <?php while ($row = $sectores->FetchRow()) { ?>
                        <tr class="dataColumns">
                            <td class="column borderR"><?php echo $row["nombre_sector"]; ?> <span class="mandatory">(*)</span>
                                    <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idCategory[]" id="idCategory_<?php echo $row["idsiq_sectores"]; ?>" value="<?php echo $row["idsiq_sectores"]; ?>" />
                                 <input type="hidden" name="idsiq_detalleformUnidadesAcademicasProyectosGruposInteres[]" value="" id="idsiq_detalleformUnidadesAcademicasProyectosGruposInteres_<?php echo $row["idsiq_sectores"]; ?>" />
                               
                            </td>
                            <td class="column"> 
                                <input type="text"  class="grid-4-12 required number" minlength="1" name="numSalud[]" id="numSalud_<?php echo $row["idsiq_sectores"]; ?>" title="Proyectos de Salud" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <td class="column borderR"> 
                                <input type="text"  class="grid-4-12 required number" minlength="1" name="numCalidadVida[]" id="numCalidadVida_<?php echo $row["idsiq_sectores"]; ?>" title="Proyectos de Calidad de Vida" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <td class="column"> 
                                <input type="text"  class="grid-4-12 required number" minlength="1" name="numOtrasDisciplinas[]" id="numOtrasDisciplinas_<?php echo $row["idsiq_sectores"]; ?>" title="Otros" maxlength="10" tabindex="1" autocomplete="off" value="0" />
                            </td>
                            <?php if($aprobacion){ ?>
                            <td class="column">
				<input type="hidden" value="0" name="Verificado[]" id="VerEscondido_<?php echo $row["idsiq_sectores"]; ?>" />
                                <input type="checkbox"  class="grid-4-12 required number" minlength="1" name="Verificado[]" id="Verificado_<?php echo $row["idsiq_sectores"]; ?>" title="Verificado" maxlength="10" tabindex="1" autocomplete="off" value="1" />
                            </td>
                            <?php 
                            }
                            ?>                         
                        </tr>
                        <?php } ?>        
                    </tbody>
                </table>                   
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submitProyectos" value="Guardar datos" class="first" /> 
        </form>
</div>
</div>
<script type="text/javascript">

var aprobacion = '<?php echo $aprobacion; ?>';

    getDataProyectos("#form_test");
    
                $('#submitProyectos').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_test");
                    if(valido){
                        sendFormProyectos("#form_test");
                    }
                });
                
                //es como el live() pero no descontinuado... para elementos añadidos dinamicamente
                $(document).on('change', "#form_test #modalidad", function(){
                    getCarreras("#form_test");
                    changeFormModalidad("#form_test");
                });
                
                $(document).on('change', "#form_test #unidadAcademica", function(){
                    getDataProyectos("#form_test");
                    changeFormModalidad("#form_test");
                });
                
                $('#form_test #mes').add($('#form_test #anio')).bind('change', function(event) {
                    getDataProyectos("#form_test");
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
                
                function actualizarDataPrograma(){
                 var typeoffunction = 'function';
                    if(typeof getPlanesEstudio == typeoffunction){
                         getPlanesEstudio("#form_planEstudio");
                         getDataPlanEstudio("#form_planEstudio");
                    }
                    if(typeof getDataProyectos == typeoffunction){
                         getDataProyectos("#form_test");
                    }
                    if(typeof getDataActividadesAcademicos == typeoffunction){
                        getDataActividadesAcademicos("#form_actividadesAcademicos");
                    }  
                    if(typeof getDataInvestigacion == typeoffunction){
                        getDataInvestigacion("#form_investigacion");
                    }   
                    if(typeof getDataAulas == typeoffunction){
                        getDataAulas("#form_aulas");
                    }   
                    if(typeof getDataCapacitaciones == typeoffunction){
                        getDataCapacitaciones("#form_capacitaciones");
                    }   
                    if(typeof getDataEquipos == typeoffunction){
                        getDataEquipos("#form_equipos");
                    }   
                    if(typeof getDataInvEstudiantes == typeoffunction){
                        getDataInvEstudiantes("#form_invEstudiantes");
                    }   
                    if(typeof getDataFormacionProfesional == typeoffunction){
                        getDataFormacionProfesional("#form_formacionProfesional");
                    }   
                    if(typeof getDataLaboratorios == typeoffunction){
                        getDataLaboratorios("#form_laboratorios");
                    }   
                    if(typeof getDataMovilidadProfesoral == typeoffunction){
                        getDataMovilidadProfesoral("#form_movilidadProfesoral");
                    }   
                    if(typeof getDataParticipacion == typeoffunction){
                        getDataParticipacion("#form_participacion");
                    }   
                    if(typeof getDataProductosInvestigacion == typeoffunction){
                        getDataProductosInvestigacion("#form_productosInvestigacion");
                    }   
                    if(typeof getDataConsultoria == typeoffunction){
                        getDataConsultoria("#form_consultoria");
                    }   
                    if(typeof getDataReconocimientos == typeoffunction){
                        getDataReconocimientos("#form_reconocimientos");
                    }   
                    if(typeof getDataRedes == typeoffunction){
                        getDataRedes("#form_redes");
                    }   
                    if(typeof getDataBibliograficas == typeoffunction){
                        getDataBibliograficas("#form_bibliograficas");
                    }                      
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
                
                
    
    function addTableRow(formName) {
         var row = $(formName + ' table').children('tbody').children('tr:last').clone(true);
         row.find( 'input' ).each( function(){
            $( this ).val( '' );
            $(this).removeAttr("id");
            $(this).removeClass("hasDatepicker");       
        });
         $(formName + ' table').children('tbody').find('tr:last').after(row);  
         return true;
   }
   
   function removeTableRow(formName,inputName,action) {
       action = typeof action !== 'undefined' ? action : 'save2';
       
        if($(formName + ' table > tbody > tr').length>1){
         $(formName + ' table').children('tbody').children('tr:last').remove(); 
        } else if ($(formName + ' table').children('tbody').children('tr:last').find(inputName).val()=="") {
            alert("No puede eliminar la única fila. Debe por lo menos ingresar 1 dato.");
        } else {
            $(formName + ' table tbody input').each(function() {                                     
                   $(this).val("");                                       
             });
             $(formName + ' #action').val(action);
        }
         return true;
   }
                
                function getDataProyectos(formName){
                    var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                    var entity = $(formName + " #entity").val();
                    var codigocarrera = $(formName + " #unidadAcademica").val();
                    if(codigocarrera==""){
                        //no hay datos xq no hay carrera
                        if($("#idsiq_formUnidadesAcademicasProyectosGruposInteres").val()!=""){
                             var modalidad = $(formName + ' #modalidad').val();
                             var unidadAcademica = $(formName + ' #unidadAcademica').val();
                             var mes = $(formName + ' #mes').val();
                             var anio = $(formName + ' #anio').val();
                             document.forms[formName.replace("#","")].reset();
                             $(formName + ' #modalidad').val(modalidad);
                             $(formName + ' #unidadAcademica').val(unidadAcademica);
                             $(formName + ' #mes').val(mes);
                             $(formName + ' #anio').val(anio);
                             $(formName + " #action").val("saveDynamic2");
                             $("#idsiq_formUnidadesAcademicasProyectosGruposInteres").val("");
                        }
                    } else {
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: entity, campoPeriodo: "codigoperiodo",entityJoin: "siq_sectores",codigocarrera:codigocarrera },     
                            success:function(data){
                                if (data.success == true){
                                    $("#idsiq_formUnidadesAcademicasProyectosGruposInteres").val(data.message);
                                    for (var i=0;i<data.total;i++)
                                    {                                
                                        $(formName + " #idCategory_"+data.data[i].idCategory).val(data.data[i].idCategory);
                                        $("#idsiq_detalleformUnidadesAcademicasProyectosGruposInteres_"+data.data[i].idCategory).val(data.data[i].idsiq_detalleformUnidadesAcademicasProyectosGruposInteres);
                                        $(formName + " #numSalud_"+data.data[i].idCategory).val(data.data[i].numSalud);
                                        $(formName + " #numCalidadVida_"+data.data[i].idCategory).val(data.data[i].numCalidadVida);
                                        $(formName + " #numOtrasDisciplinas_"+data.data[i].idCategory).val(data.data[i].numOtrasDisciplinas);
                                        
                                        //console.log(aprobacion);
                                        if(data.data[i].Verificado=="1"){
                                           $("#Verificado_"+data.data[i].idCategory).attr("checked", true);
                                           if(aprobacion==""){
					      $("#numSalud_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
					      $("#numCalidadVida_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
					      $("#numOtrasDisciplinas_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
                                           }
                                        }
                                        else{
					  $("#Verificado_"+data.data[i].idCategory).attr("checked", false); 
					  if(aprobacion==""){
					      $("#numSalud_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
					      $("#numCalidadVida_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
					      $("#numOtrasDisciplinas_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
                                           }
                                        }
                                    }
                                    $(formName + " #action").val("updateDynamic2");
                                }
                                else{              
                                    //no se encontraron datos
                                        if($("#idsiq_formUnidadesAcademicasProyectosGruposInteres").val()!=""){
                                            
                                            $(formName + ' input[name="idsiq_detalleformUnidadesAcademicasProyectosGruposInteres[]"]').each(function() {                                     
                                                $(this).val("");                                       
                                            });
                                            var modalidad = $(formName + ' #modalidad').val();
                                            var unidadAcademica = $(formName + ' #unidadAcademica').val();
                                            var mes = $(formName + ' #mes').val();
                                            var anio = $(formName + ' #anio').val();
                                            document.forms[formName.replace("#","")].reset();
                                            $(formName + ' #modalidad').val(modalidad);
                                            $(formName + ' #unidadAcademica').val(unidadAcademica);
                                            $(formName + ' #mes').val(mes);
                                            $(formName + ' #anio').val(anio);
                                            $(formName + " #action").val("saveDynamic2");
                                            $("#idsiq_formUnidadesAcademicasProyectosGruposInteres").val("");
                                            $( formName + " input[type=checkbox]" ).each(function() {					      
					      $( this).attr("checked", false);
					    });
					    $( formName + " input[type=text]" ).each(function() {					      
					      $( this).attr("readonly", false).removeClass("disable");
					    });
                                        }
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
                    }
                }

                function sendFormProyectos(formName){
                $(formName + " input[type=checkbox]:checked" ).each(function() {
		  var id= $( this ).attr( "id" );
		  var n = id.split("_");
		  $( "#VerEscondido_"+n[1]).attr("disabled","disabled");
		});
		
		$(formName + " input[type=checkbox]:not(:checked)" ).each(function() {
		  var id= $( this ).attr( "id" );
		  var n = id.split("_");
		  $( "#VerEscondido_"+n[1]).removeAttr("disabled");
		});		
		
                var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
                activarModalidades(formName);
                $(formName + ' #codigoperiodo').val(periodo);
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: './formularios/academicos/saveUnidadesAcademicas.php',
                        data: $(formName).serialize(),                
                        success:function(data){
							<?php if($permisos["rol"][0]!=1) { ?>
								desactivarModalidades(formName);
							<?php } ?>
                            if (data.success == true){
                                 //window.location.href="./viewData.php?id=row_<?php //echo $formulario["idsiq_formulario"]; ?>";  
                                 $("#idsiq_formUnidadesAcademicasProyectosGruposInteres").val(data.message);
                                 for (var i=0;i<data.total;i++)
                                 {                                  
                                    $("#idsiq_detalleformUnidadesAcademicasProyectosGruposInteres_"+data.dataCat[i]).val(data.data[i]);
                                 }
								 $('#msg-success').removeClass('msg-error');
                                 $('#msg-success').html('<p>Los datos han sido guardados de forma correcta.</p>');
                                 $(formName + " #action").val("updateDynamic2");
                                 $(formName + ' #msg-success').css('display','block');
                                 $(formName + " #msg-success").delay(5500).fadeOut(800);
                            }
                            else{         
                                $('#msg-success').addClass('msg-error');
                                $('#msg-success').html('<p>' + data.message + '</p>');
                                 $(formName + ' #msg-success').css('display','block');
                                 $(formName + " #msg-success").delay(5500).fadeOut(800);
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });            
                }
                
                function activarModalidades(formName){
                    $(formName + ' #modalidad').prop('disabled', false);
                    $(formName + ' #unidadAcademica').prop('disabled', false);
                }
                
                function desactivarModalidades(formName){
					//console.log("<?php echo $permisos["rol"][0]; ?>");
                    $(formName + ' #modalidad').prop('disabled', true);
                    $(formName + ' #unidadAcademica').prop('disabled', true);                    
                }
</script>