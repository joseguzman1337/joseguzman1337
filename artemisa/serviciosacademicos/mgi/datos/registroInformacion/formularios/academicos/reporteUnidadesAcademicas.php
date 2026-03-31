<?php 
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
$rutaInc = "../funcionesTablasMaestras.php";
 if(!is_file($rutaInc)){
	$rutaInc = './formularios/funcionesTablasMaestras.php';
} 
include($rutaInc);
$rutaInc = "./";
if(isset($reporteEspecifico)){
	$rutaInc = "../registroInformacion/";
}
?>

<script type="text/javascript">
	$(function() {
            
		$( "#tabs" ).tabs({
                    beforeLoad: function( event, ui ) {
                            ui.jqXHR.error(function() {
                                    ui.panel.html(
                                    "Ocurrio un problema cargando el contenido." );
                                    });
                            } 
		});
                
                $("#tabs").plusTabs({
   			className: "plusTabs", //classname for css scoping
   			seeMore: true,  //initiate "see more" behavior
   			seeMoreText: "Ver más información", //set see more text
   			showCount: true, //show drop down count
   			expandIcon: "&#9660; ", //icon/caret - if using image, specify image width
   			dropWidth: "auto", //width of dropdown
 			sizeTweak: 0 //adjust size of active tab to tweak "see more" layout
   		});
                
	});
	
	function getDataDynamic(formName,entity,periodo,campoPeriodo,entityJoin,periodo2,tipo,formato,funcion,form,tab,order){
			if(typeof order== "undefined"){
				order = null;
			}
             var codigocarrera = $(formName + " .unidadAcademica").val();
             var modalidad = $(formName + " .modalidad").val();
             return  $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: '<?php echo $rutaInc;?>formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getDataDynamicConsolidada", entity: entity, campoPeriodo: campoPeriodo,entityJoin: 
							entityJoin,codigocarrera:codigocarrera, periodo2: periodo2, tipo: tipo, formato:formato,funcion:funcion,idFormulario:form,
							pestana:tab,order:order,modalidad:modalidad},     
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
         }
		 
	
         
         function getData(formName,entity,periodo,campoPeriodo,periodo2,tipo,formato,funcion,form,tab,order,planEstudio){
             var codigocarrera = $(formName + " .unidadAcademica").val();
             var modalidad = $(formName + " .modalidad").val();
             return  $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: '<?php echo $rutaInc;?>formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getDataConsolidada", entity: entity, campoPeriodo: campoPeriodo,codigocarrera:codigocarrera, 
							periodo2: periodo2, tipo: tipo, formato:formato,funcion:funcion,idFormulario:form,
							pestana:tab,order:order,modalidad:modalidad, planEstudio: planEstudio },     
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
         }
		 
		 
         
         function getDataByDate(formName,entity,periodo,campoFecha){
             var codigocarrera = $(formName + " .unidadAcademica").val();
             var modalidad = $(formName + " .modalidad").val();
             return  $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: '<?php echo $rutaInc;?>formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getDataByDate", entity: entity, campoFecha: campoFecha,codigocarrera:codigocarrera,modalidad:modalidad },     
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
         }
		 
	function pintarMensajesPeriodosFaltantes(name, periodosValores, periodosAdjuntos, formatoActual, formato){
		$(name + ' .mensajes').html('');

		if( (typeof periodosValores!= "undefined" && periodosValores!="") || (typeof periodosAdjuntos!= "undefined" && periodosAdjuntos!="")){			
		
			if( (typeof formatoActual!= "undefined" && formatoActual!="") && (typeof formato!= "undefined" && formato!="")){
				if(typeof periodosValores!= "undefined" && periodosValores!=""){
					periodosValores = cambiarFormato(periodosValores, formatoActual, formato);
				}
				if(typeof periodosAdjuntos!= "undefined" && periodosAdjuntos!=""){
					periodosAdjuntos = cambiarFormato(periodosAdjuntos, formatoActual, formato);
				}
			}
			
            $(name + ' .mensajes').append("<h4 style='margin-bottom:10px;'>Seguimiento registro de la información</h4>");
			
			if(typeof periodosValores!= "undefined" && periodosValores!=""){
				$(name + ' .mensajes').append("<p>Los siguientes periodos consultados no tienen información registrada:<br/><span style='font-size:0.8em;'>" + periodosValores+"</span></p>");	
			}		
			if(typeof periodosAdjuntos!= "undefined" && periodosAdjuntos!=""){
				$(name + ' .mensajes').append("<p>Los siguientes periodos consultados no tienen archivo(s) de soporte:<br/><span style='font-size:0.8em;'>" + periodosAdjuntos+"</span></p>");
			}
		}
	}
	
	<?php if(!isset($reporteEspecifico)){ ?>
	//es como el live() pero no descontinuado... para elementos añadidos dinamicamente
    $(document).on('change', "div .modalidad", function(){
		var idTab = "#"+$(this).closest("div.formsHuerfanos").attr('id');
		//console.log(idTab);
        getCarreras(idTab);
        changeFormModalidad(idTab,'<?php echo $rutaInc; ?>');
    });
                
    $(document).on('change', "div .unidadAcademica", function(){
		//console.log(idTab);
		var idTab = "#"+$(this).closest("div.formsHuerfanos").attr('id');
        changeFormModalidad(idTab,'<?php echo $rutaInc; ?>');
    });
	<?php } ?>
		 
	function pintarValoresConsultaConsolidado(idform, funcion, valores,campos,totalizar,periodosValores, periodosAdjuntos, formatoActual, formato, conCategoria,nombresCategoria){
			pintarValoresConsulta(idform, funcion, valores, campos, totalizar, conCategoria,nombresCategoria);
			pintarMensajesPeriodosFaltantes(idform, periodosValores, periodosAdjuntos, formatoActual, formato);
	
	}
	
	function validarPeriodos(formName){
		var valido = true;
		if($(formName + " .unidadAcademica").val()==""){
			valido = false;
			alert("Debe elegir un programa académico para consultar.");
		}
		return valido;
	}
</script>
<?php if(!isset($reporteEspecifico)){ ?>
<div id="tabs" class="dontCalculate">
	<ul>
            <li><a href="#tabs-1">Proyectos realizados con diferentes grupos de interés</a></li>
            <li><a href="#tabs-2">Participación de los académicos por núcleo estratégico</a></li>
            <li><a href="#tabs-19">Participación de los académicos<br/>(talleres nacionales e internacionales)</a></li>
            <li><a href="#tabs-3">Profesores visitantes recibidos en la Facultad</a></li>
            <li><a href="#tabs-4">Premios o reconocimientos a los académicos</a></li>
            <li><a href="#tabs-5">Capacitación dada al talento Humano </a></li>
            <li><a href="#tabs-6">Uso de Aulas Virtuales en asignaturas</a></li>
            <li><a href="./formularios/academicos/MovilidadAcademica_html.php?actionID=ReporteDefault">Movilidad académica estudiantil</a></li>
            <li><a href="#tabs-8">Movilidad académica Profesoral<br/>(Académicos que viajan)</a></li>
            <li><a href="#tabs-20">Movilidad académica Profesoral<br/>(Académicos vienen de otras universidades)</a></li>
            <li><a href="#tabs-9">Académicos que participan en<br/>formación profesoral</a></li>
            <li><a href="#tabs-10">Distribución del Plan de Estudios</a></li>
            <li><a href="#tabs-11">Actividades académicas de apoyo<br/>a la Investigación Formativa</a></li>
            <li><a href="#tabs-12">Productos resultado de actividades<br/>de Investigación Formativa</a></li>
            <li><a href="#tabs-13">Reconocimientos a estudiantes<br/>(Investigación Formativa)</a></li>
            <li><a href="#tabs-21">Participación de estudiantes en la<br/>evaluación de la Investigación Formativa</a></li>
            <li><a href="#tabs-14">Proyectos de consultoría</a></li>
            <li><a href="#tabs-15">Dedicación de los Académicos por actividades</a></li>
            <li><a href="#tabs-17">Laboratorios, Talleres, Museos, etc</a></li>
            <li><a href="#tabs-18">Equipos de cómputo</a></li>
            <li><a href="#tabs-22">Número de redes y asociaciones Institucionales</a></li>
            <li><a href="./formularios/academicos/viewFortalecimientoAcademico2.php?id=<?php echo $id; ?>&alias=apeirbyh" class="locationTab">Asignaturas que incorporan el referente<br/>de la bioética y las humanidades</a></li>
            <li><a href="./formularios/academicos/viewFortalecimientoAcademico2.php?id=<?php echo $id; ?>&alias=auleaaecpupa" class="locationTab">Asignaturas que utilizan lengua extranjera</a></li>
            <li><a href="./formularios/academicos/viewFortalecimientoAcademico2.php?id=<?php echo $id; ?>&alias=aaiaaepu" class="locationTab">Asignaturas que articulan la internacionalización con<br/>las actividades de aprendizaje y evaluación</a></li>
            <li><a href="./formularios/academicos/viewFortalecimientoAcademico2.php?id=<?php echo $id; ?>&alias=aihmtaeaaput" class="locationTab">Asignaturas que incluyen herramientas mediadas por las TICs</a></li>
	</ul>
	<?php } if(!isset($reporteEspecifico) || $reporteEspecifico==1){ ?>
<div id="tabs-1" class="formsHuerfanos">
         <?php getPlantillaConsulta($db,"m"); 
		 
			if(isset($reporteEspecifico) && $reporteEspecifico==1){
				echo '<div id="tableDiv">';
			}
		 ?>
		  
         <table align="center" class="formData viewData previewReport" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="4"><span>Proyección social: Proyectos realizados con diferentes grupos de interés, según el núcleo estratégico</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2"><span>Sector</span></th> 
                            <th class="column borderR" colspan="2"><span>Núcleo estratégico</span></th> 
                            <th class="column" rowspan="2"><span>Otras Disciplinas</span></th> 
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Salud</span></th> 
                            <th class="column borderR" ><span>Calidad de Vida</span></th> 
                        </tr>
                    </thead>
                    <tbody>                     
                    </tbody>
                </table>   
				<?php if(isset($reporteEspecifico) && $reporteEspecifico==1){
					echo '</div>';
				} ?>
					
			<div class="mensajes"></div>
        <script type="text/javascript">                
            $('#tabs-1 .consultar').bind('click', function(event) {
					if(validarPeriodos("#tabs-1")){
						getData1("#tabs-1");
					}
                });            
                
                function getData1(name){
                    html = "";                    
                    var periodo1 = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                    var periodo2 = $(name + ' #mes2').val()+"-"+$(name + ' #anio2').val();
                     var promise = getDataDynamic(name,'formUnidadesAcademicasProyectosGruposInteres',periodo1,"codigoperiodo","siq_sectores",
					 periodo2,"mes","m-Y","sum",9,1);
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true && data.total>0){
								var campos = new Array();
								campos[0] = new Array("nombre_sector","texto"); 
								campos[1] = new Array("numSalud","int");
								campos[2] = new Array("numCalidadVida","int"); 
								campos[3] = new Array("numOtrasDisciplinas","int");
								pintarValoresConsultaConsolidado(name, "sum", data.data,campos,true,data.infoPeriodos, data.infoAdjuntos);	
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="5" class="center">No se encontraron datos.</td></tr>');
								pintarMensajesPeriodosFaltantes(name, data.infoPeriodos, data.infoAdjuntos);
                            }                         
                      });
                }
        </script>
</div><!--- tab 1 --->
<?php } if(!isset($reporteEspecifico) || $reporteEspecifico==2) { ?>
<div id="tabs-2" class="formsHuerfanos">
         <?php getPlantillaConsulta($db,"m"); 
		 
			if(isset($reporteEspecifico) && $reporteEspecifico==2){
				echo '<div id="tableDiv">';
			}
		 ?>
		  
         <table align="center" class="formData viewData previewReport" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="4"><span>Participación de los académicos como expositor en congresos, seminarios, simposios, talleres por núcleo estratégico</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2"><span>Programa</span></th> 
                            <th class="column borderR" colspan="2"><span>Núcleo estratégico</span></th> 
                            <th class="column" rowspan="2"><span>Otras Disciplinas</span></th> 
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Salud</span></th> 
                            <th class="column borderR" ><span>Calidad de Vida</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
                </table>   
				<?php if(isset($reporteEspecifico) && $reporteEspecifico==2){
					echo '</div>';
				} ?>
					
			<div class="mensajes"></div>
			
        <script type="text/javascript">                
            $('#tabs-2 .consultar').bind('click', function(event) {
					if(validarPeriodos("#tabs-2")){
						getData2("#tabs-2");
					}
                });            
                
                function getData2(name){
                    html = "";                    
                    var periodo1 = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                    var periodo2 = $(name + ' #mes2').val()+"-"+$(name + ' #anio2').val();
                     var promise = getDataDynamic(name,'formUnidadesAcademicasParticipacionAcademicos',periodo1,"codigoperiodo","siq_tipoEventoAcademico",
					 periodo2,"mes","m-Y","sum",9,2);
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true && data.total>0){
								var campos = new Array();
								campos[0] = new Array("nombre","texto"); 
								campos[1] = new Array("numSalud","int");
								campos[2] = new Array("numCalidad","int"); 
								campos[3] = new Array("numOtros","int");
								pintarValoresConsultaConsolidado(name, "sum", data.data,campos,true,data.infoPeriodos, data.infoAdjuntos);	
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="4" class="center">No se encontraron datos.</td></tr>');
								pintarMensajesPeriodosFaltantes(name, data.infoPeriodos, data.infoAdjuntos);
                            }                         
                      });
                }
        </script>
</div><!--- tabs 2 --->
<?php } if(!isset($reporteEspecifico) || $reporteEspecifico==3){ ?>
 <div id="tabs-3" class="formsHuerfanos">
                <?php getPlantillaConsultaSimple($db,"s"); 
		 
			if(isset($reporteEspecifico) && $reporteEspecifico==3){
				echo '<div id="tableDiv">';
			}
		 ?>
     
        <table align="center" class="formData last previewReport" width="92%" >
                    <thead>            
                         <tr class="dataColumns">
                            <th class="column" colspan="4"><span>Profesores visitantes recibidos en la Facultad</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Nombre del Académico</span></th> 
                            <th class="column" ><span>Fecha de la visita</span></th> 
                            <th class="column" ><span>Ciudad/ País de origen</span></th> 
                            <th class="column" ><span>Institución</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
                </table>  
                
				<?php if(isset($reporteEspecifico) && $reporteEspecifico==3){
					echo '</div>';
				} ?>
                <script type="text/javascript">            
            
            $('#tabs-3 .consultar').bind('click', function(event) {
                    getData3("#tabs-3");
                });            
                
                function getData3(name){
                    html = "";                    
                    var periodo = $(name + ' #codigoperiodo').val();
                     var promise = getDataByDate(name,'formUnidadesAcademicasProfesoresVisitantes',periodo,"fechaVisita");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true){
                                 for (var i=0;i<data.total;i++)
                                    {       
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column">'+data.data[i].nombre+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].fechaVisita+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].ciudad+'</td>';
                                        html = html + '<td class="column">'+data.data[i].institucion+'</td>';
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
</div><!--- tabs 3 --->
<?php } if(!isset($reporteEspecifico) || $reporteEspecifico==4){ ?>
<div id="tabs-4" class="formsHuerfanos">
                <?php getPlantillaConsultaSimple($db,"s"); 
		 
			if(isset($reporteEspecifico) && $reporteEspecifico==4){
				echo '<div id="tableDiv">';
			}
		 ?>
     
        <table align="center" class="formData last previewReport" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="5"><span>Premios o reconocimientos a los académicos</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Nombre del Académico</span></th> 
                            <th class="column" ><span>Tipo de Reconocimiento</span></th> 
                            <th class="column" ><span>Entidad o Institución</span></th> 
                            <th class="column" ><span>Ciudad y País</span></th> 
                            <th class="column" ><span>Fecha</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
                </table>  
				<?php if(isset($reporteEspecifico) && $reporteEspecifico==4){
					echo '</div>';
				} ?>
                
                <script type="text/javascript">            
            
            $('#tabs-4 .consultar').bind('click', function(event) {
                    updateDataPremios();
                });            
            
            function updateDataPremios(){                
                var name = "#tabs-4";
                if($(name + ' .unidadAcademica').val()=="" || $(name + ' #codigoperiodo').val()==""){
                    $(name + ' tbody').html("");
                } else {
                    html = "";                    
                    var periodo = $(name + ' #codigoperiodo').val();
                     var promise = getDataByDate(name,'formUnidadesAcademicasReconocimientosProfesores',periodo,"fechaReconocimiento");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true){
                                 for (var i=0;i<data.total;i++)
                                    {       
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column">'+data.data[i].nombre+'</td>';
                                        html = html + '<td class="column">'+data.data[i].tipoReconocimiento+'</td>';
                                        html = html + '<td class="column">'+data.data[i].institucion+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].ciudad+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].fechaReconocimiento+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                       
                                    }
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="5" class="center">No se encontraron datos.</td></tr>');
                            }                         
                      });
                      
                }
            }
        </script>
</div>
<?php } if(!isset($reporteEspecifico)) { ?>
<div id="tabs-5" class="formsHuerfanos">
         <?php getPlantillaConsulta($db,"m"); ?>
		  
         <table align="center" class="formData viewData previewReport" width="100%" >
                   <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Capacitación dada al talento humano de la Unidad Académica</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Tipo de capacitación</span></th> 
                            <th class="column" ><span>Número de académicos participantes</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
                </table>   
					
			<div class="mensajes"></div>
        <script type="text/javascript">                
            $('#tabs-5 .consultar').bind('click', function(event) {
					if(validarPeriodos("#tabs-5")){
						getData5("#tabs-5");
					}
                });            
                
                function getData5(name){
                    html = "";                    
                    var periodo1 = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                    var periodo2 = $(name + ' #mes2').val()+"-"+$(name + ' #anio2').val();
                     var promise = getData(name,'formUnidadesAcademicasCapacitaciones',periodo1,"codigoperiodo",
					 periodo2,"mes","m-Y","sum",9,5);
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true && data.total>0){
								var campos = new Array();
								campos[0] = new Array("Conferencia","textoFijo");
								campos[1] = new Array("numConferencia","int");
								campos[2] = new Array("Taller","textoFijo");
								campos[3] = new Array("numTaller","int");
								campos[4] = new Array("Curso","textoFijo");
								campos[5] = new Array("numCurso","int");
								campos[6] = new Array("Otro","textoFijo");
								campos[7] = new Array("numOtro","int");
								pintarValoresConsultaConsolidado(name, "sum", data.data,campos,true,data.infoPeriodos, data.infoAdjuntos, "", "", false);	
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="5" class="center">No se encontraron datos.</td></tr>');
								pintarMensajesPeriodosFaltantes(name, data.infoPeriodos, data.infoAdjuntos);
                            }                         
                      });
                }
        </script>
</div><!--- tab 5 --->

<div id="tabs-6" class="formsHuerfanos">
         <?php getPlantillaConsulta($db,"m"); ?>
     
        <table align="center" class="formData viewData previewReport" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Uso de Aulas Virtuales en asignaturas</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ></th> 
                            <th class="column borderR" ><span>Asignaturas</span></th> 
                            <th class="column" ><span>Asignaturas con Aula Virtual</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
                </table>  
			<div class="mensajes"></div>
                
                <script type="text/javascript">            
            
            $('#tabs-6 .consultar').bind('click', function(event) {
					if(validarPeriodos("#tabs-6")){
						getData6("#tabs-6");
					}
                });            
                
                function getData6(name){
                    html = "";       
                    var periodo1 = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                    var periodo2 = $(name + ' #mes2').val()+"-"+$(name + ' #anio2').val();
                     var promise = getData(name,'formUnidadesAcademicasAulasVirtuales',periodo1,"codigoperiodo",
					 periodo2,"mes","m-Y","sum",9,19);
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true && data.total>0){
								var campos = new Array();
								campos[0] = new Array("Cantidad Total","textoFijo");
								campos[1] = new Array("numAsignaturas","int");
								campos[2] = new Array("numAulasVirtuales","int");							
								pintarValoresConsultaConsolidado(name, "sum", data.data,campos,true,data.infoPeriodos, data.infoAdjuntos, "", "", false);	
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="3" class="center">No se encontraron datos.</td></tr>');
								pintarMensajesPeriodosFaltantes(name, data.infoPeriodos, data.infoAdjuntos);
                            }                         
                      });
                
                }
           
            
        </script>
</div> 
<?php } if(!isset($reporteEspecifico) || $reporteEspecifico==8){ ?>
<div id="tabs-8" class="formsHuerfanos">
         <?php getPlantillaConsulta($db,"m"); 
		 
			if(isset($reporteEspecifico) && $reporteEspecifico==8){
				echo '<div id="tableDiv">';
			}
		 ?>
		  
        <table align="center" class="formData viewData previewReport" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="6"><span>Movilidad académica Profesoral: Académicos de la Universidad que viajan</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2"><span>País al que viaja</span></th> 
                            <th class="column" colspan="5"><span>Tipo de movilidad</span></th> 
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Trabajo de cooperación</span></th> 
                            <th class="column" ><span>Presentación en seminario,<br/>congreso, etc.</span></th> 
                            <th class="column" ><span>Investigación</span></th> 
                            <th class="column" ><span>Pasantía</span></th> 
                            <th class="column" ><span>Docencia</span></th> 
                        </tr>
                     </thead>
                    <tbody>                     
                    </tbody>
                </table>  
				<?php if(isset($reporteEspecifico) && $reporteEspecifico==8){
					echo '</div>';
				} ?> 
					
			<div class="mensajes"></div>
			
        <script type="text/javascript">                
            $('#tabs-8 .consultar').bind('click', function(event) {
					if(validarPeriodos("#tabs-8")){
						getData8("#tabs-8");
					}
                });            
                
                function getData8(name){
                    html = "";                    
                    var periodo1 = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                    var periodo2 = $(name + ' #mes2').val()+"-"+$(name + ' #anio2').val();
                     var promise = getDataDynamic(name,'formUnidadesAcademicasMovilidadProfesoral',periodo1,"codigoperiodo","siq_categoriaPais",
					 periodo2,"mes","m-Y","sum",9,8);
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true && data.total>0){
								var campos = new Array();
								campos[0] = new Array("nombre","texto"); 
								campos[1] = new Array("numCooperacionIda","int");
								campos[2] = new Array("numPresentacionIda","int"); 
								campos[3] = new Array("numInvestigacionIda","int");
								campos[4] = new Array("numPasantiaIda","int");
								campos[5] = new Array("numDocenciaIda","int");
								pintarValoresConsultaConsolidado(name, "sum", data.data,campos,true,data.infoPeriodos, data.infoAdjuntos);	
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="6" class="center">No se encontraron datos.</td></tr>');
								pintarMensajesPeriodosFaltantes(name, data.infoPeriodos, data.infoAdjuntos);
                            }                         
                      });
                }
        </script>
</div><!--- tabs 8 --->
<?php } if(!isset($reporteEspecifico)) { ?>
<div id="tabs-9" class="formsHuerfanos">
	<?php getPlantillaConsulta($db, "s"); ?>
	
	    <table align="center" class="formData viewData" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="9"><span>Número de académicos que participan en formación profesoral</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2"><span>Área de formación</span></th> 
                            <th class="column borderR" colspan="3"><span>Especialización</span></th> 
                            <th class="column borderR" colspan="2"><span>Maestría </span></th> 
                            <th class="column borderR" colspan="3"><span>Doctorado</span></th> 
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>1 año</span></th> 
                            <th class="column" ><span>2 - 3 años</span></th> 
                            <th class="column borderR" ><span>4 - 5 años</span></th> 
                            <th class="column" ><span>2 años</span></th> 
                            <th class="column borderR" ><span>3 años</span></th> 
                            <th class="column" ><span>2 años</span></th> 
                            <th class="column" ><span>3 años</span></th> 
                            <th class="column" ><span>4 años</span></th> 
                        </tr>
                     </thead>
                    <tbody>                     
                    </tbody>
      </table>   
	  
	  <div class="mensajes"></div>
	  
	  <script type="text/javascript">
				$('#tabs-9 .consultar').bind('click', function(event) {
                    getData9();
                });   
                
                function getData9(){
                    var name = "#tabs-9";
					if($(name + ' .unidadAcademica').val()=="" || $(name + ' #codigoperiodo').val()=="" ){
						$(name + ' tbody').html("");
					} else {
						html = "";                    
						var periodo1 = $(name + ' #codigoperiodo').val();
						var periodo2 = $(name + ' #codigoperiodo2').val();
						
						 var promise = getDataDynamic(name,'formUnidadesAcademicasFormacionProfesional',periodo1,"codigoperiodo","areaconocimiento",periodo2,"semestral","Yp",
						 "sum",9,9,"nombreareaconocimiento ASC");
						 promise.success(function (data) {
							 $(name + ' tbody').html('');
								 //console.log(data);
								 if (data.success == true && data.total>0){
										var campos = new Array();
										campos[0] = new Array("nombreareaconocimiento","texto"); 
										campos[1] = new Array("numEspecializacion1","int");
										campos[2] = new Array("numEspecializacion2","int"); 
										campos[3] = new Array("numEspecializacion4","int");
										campos[4] = new Array("numMaestria2","int");
										campos[5] = new Array("numMaestria3","int");
										campos[6] = new Array("numDoctorado2","int");
										campos[7] = new Array("numDoctorado3","int");
										campos[8] = new Array("numDoctorado4","int");
										pintarValoresConsultaConsolidado(name, "sum", data.data,campos,true,data.infoPeriodos, data.infoAdjuntos,"Yp","Y-p");	
											
									}
									else{  
										$(name + ' tbody').html('<tr><td colspan="9" class="center">No se encontraron datos.</td></tr>');
										pintarMensajesPeriodosFaltantes(name, data.infoPeriodos, data.infoAdjuntos,"Yp","Y-p");
									}                         
							  });
							  
						}
                }
	  </script>
</div><!--- tab 9 -->
<div id="tabs-10" class="formsHuerfanos">
<?php
	  getPlantillaConsulta($db, "s"); 
		 ?>
                
                <label for="planEstudio" class="fixedLabel">Plan de Estudios: <span class="mandatory">(*)</span></label>
                <select name="planEstudio" id="planEstudio" class="required" style='font-size:0.8em;width:auto'>
                    <option value="" selected></option>
                </select>
                <div class="vacio"></div>
     
	        <table align="center" class="formData viewData previewReport" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Distribución del Plan de Estudios</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Tipo de Asignaturas</span></th> 
                            <th class="column" ><span>Número de Asignaturas</span></th> 
                            <th class="column" ><span>Número de Créditos</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
                </table>  
	  
	  <div class="mensajes"></div>
                
                <script type="text/javascript">           
            $(document).ready(function() {
        getPlanesEstudio("#tabs-10");
    });
	
	$(document).on('change', "#tabs-10 .unidadAcademica", function(){
                    getPlanesEstudio("#tabs-10");
                });
	
	function getPlanesEstudio(formName){
                    $(formName + " #planEstudio").html("");
                    $(formName + " #planEstudio").css("width","auto");   
                    if($(formName + ' #unidadAcademica').val()!=""){
                        var mod = $(formName + ' #unidadAcademica').val();
                            $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url: '../searchs/lookForPlanesEstudios.php',
                                data: { carrera: mod },     
                                success:function(data){
                                     var html = '<option value="" selected></option>';
                                     var i = 0;
                                        while(data.length>i){
                                            html = html + '<option value="'+data[i]["value"]+'" >'+data[i]["label"]+'</option>';
                                            i = i + 1;
                                        }                                    
                            
                                        $(formName + " #planEstudio").html(html);
                                        $(formName + " #planEstudio").css("width","500px");                                        
                                },
                                error: function(data,error,errorThrown){alert(error + errorThrown);}
                            });  
                    }
                }
				
            $('#tabs-10 .consultar').bind('click', function(event) {
                    getData10();
                });   
                
            function getData10(){

                var name = "#tabs-10";
						var periodo1 = $(name + ' #codigoperiodo').val();
						var periodo2 = $(name + ' #codigoperiodo2').val();
                    var planEstudio = $(name + " #planEstudio").val();
					var promise = getData(name,'formUnidadesAcademicasPlanEstudio',periodo1,"codigoperiodo",
					 periodo2,"semestral","Yp", "sum",9,"",null,planEstudio);
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true && data.total>0){
								var campos = new Array();
								campos[0] = new Array("Formación Fundamental ","textoFijo"); 
								campos[1] = new Array("numAsignaturasFundamental","int");
								campos[2] = new Array("numCreditosFundamental","int");
								campos[3] = new Array("Formación Diversificada ","textoFijo"); 
								campos[4] = new Array("numAsignaturasDiversificada","int");
								campos[5] = new Array("numCreditosDiversificada","int");
								campos[6] = new Array("Electivas complementarias ","textoFijo"); 
								campos[7] = new Array("numAsignaturasElectivas","int");
								campos[8] = new Array("numCreditosElectivas","int");
								pintarValoresConsultaConsolidado(name, "sum", data.data,campos,true,data.infoPeriodos, data.infoAdjuntos,"Yp","Y-p",false);	
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="3" class="center">No se encontraron datos.</td></tr>');
								pintarMensajesPeriodosFaltantes(name, data.infoPeriodos, data.infoAdjuntos,"Yp","Y-p");
                            }                         
                      });
            }
        </script>
</div><!--- tab 10 --->
<?php } if(!isset($reporteEspecifico) || $reporteEspecifico==11){ ?>
<div id="tabs-11" class="formsHuerfanos">
	<?php getPlantillaConsulta($db, "m"); 
		 
			if(isset($reporteEspecifico) && $reporteEspecifico==11){
				echo '<div id="tableDiv">';
			}
		 ?>
	
	    <table align="center" class="formData viewData" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Actividades académicas de apoyo a la Investigación Formativa</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Actividades académicas</span></th> 
                            <th class="column" ><span>Número de eventos</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
      </table>   
				<?php if(isset($reporteEspecifico) && $reporteEspecifico==11){
					echo '</div>';
				} ?>
	  
	  <div class="mensajes"></div>
	  
	  <script type="text/javascript">
				$('#tabs-11 .consultar').bind('click', function(event) {
                    getData11("#tabs-11");
                });           
				
                function getData11(name){
                    html = "";                    
                    var periodo1 = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                    var periodo2 = $(name + ' #mes2').val()+"-"+$(name + ' #anio2').val();
                     var promise = getData(name,'formUnidadesAcademicasActividadesInvestigacion',periodo1,"codigoperiodo",
					 periodo2,"mes","m-Y","sum",9,11);
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true && data.total>0){
								var campos = new Array();
								campos[0] = new Array("Seminarios","textoFijo");
								campos[1] = new Array("numSeminarios","int");
								campos[2] = new Array("Foros","textoFijo");
								campos[3] = new Array("numForos","int");
								campos[4] = new Array("Estudios de caso","textoFijo");
								campos[5] = new Array("numEstudiosCaso","int");
								campos[6] = new Array("Otros","textoFijo");
								campos[7] = new Array("numOtros","int");
								pintarValoresConsultaConsolidado(name, "sum", data.data,campos,true,data.infoPeriodos, data.infoAdjuntos, "", "", false);	
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="2" class="center">No se encontraron datos.</td></tr>');
								pintarMensajesPeriodosFaltantes(name, data.infoPeriodos, data.infoAdjuntos);
                            }                         
                      });
                }
                
	  </script>
</div><!--- tab 11 -->
	<?php } if(!isset($reporteEspecifico) || $reporteEspecifico==12){ ?>
<div id="tabs-12" class="formsHuerfanos">
	<?php getPlantillaConsulta($db, "s"); 
		 
			if(isset($reporteEspecifico) && $reporteEspecifico==12){
				echo '<div id="tableDiv">';
			}
		 ?>
	
	    <table align="center" class="formData viewData previewReport" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Número de productos resultado de actividades de investigación formativa</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR"><span>Tipo de Producto</span></th> 
                            <th class="column "><span>Cantidad</span></th> 
                        </tr>
                     </thead>
                    <tbody>                     
                    </tbody>
      </table>   
	  
				<?php if(isset($reporteEspecifico) && $reporteEspecifico==12){
					echo '</div>';
				} ?>
	  
	  <div class="mensajes"></div>
	  
	  <script type="text/javascript">
				$('#tabs-12 .consultar').bind('click', function(event) {
                    getData12();
                });   
                
                function getData12(){
                    var name = "#tabs-12";
					if($(name + ' .unidadAcademica').val()=="" || $(name + ' #codigoperiodo').val()=="" ){
						$(name + ' tbody').html("");
					} else {
						html = "";                    
						var periodo1 = $(name + ' #codigoperiodo').val();
						var periodo2 = $(name + ' #codigoperiodo2').val();
						
						 var promise = getDataDynamic(name,'formUnidadesAcademicasProductosInvestigacion',periodo1,"codigoperiodo","siq_tipoProductoInvestigacion",periodo2,"semestral","Yp",
						 "sum",9,12);
						 promise.success(function (data) {
							 $(name + ' tbody').html('');
								 //console.log(data);
								 if (data.success == true && data.total>0){
										var campos = new Array();
										campos[0] = new Array("nombre","texto"); 
										campos[1] = new Array("cantidad","int");
										pintarValoresConsultaConsolidado(name, "sum", data.data,campos,true,data.infoPeriodos, data.infoAdjuntos,"Yp","Y-p");	
											
									}
									else{  
										$(name + ' tbody').html('<tr><td colspan="2" class="center">No se encontraron datos.</td></tr>');
										pintarMensajesPeriodosFaltantes(name, data.infoPeriodos, data.infoAdjuntos,"Yp","Y-p");
									}                         
							  });
							  
						}
                } 
	  </script>
</div><!--- tab 12 -->
	<?php } if(!isset($reporteEspecifico) || $reporteEspecifico==13){ ?>
<div id="tabs-13" class="formsHuerfanos">
      <?php getPlantillaConsulta($db, "m");  
		 
			if(isset($reporteEspecifico) && $reporteEspecifico==13){
				echo '<div id="tableDiv">';
			}
		 ?>
     
        <table align="center" class="formData viewData previewReport" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Reconocimientos a estudiantes que participaron en actividades de Investigación Formativa</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Reconocimientos a estudiantes</span></th> 
                            <th class="column" ><span>Número de estudiantes</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
                </table>  
				<?php if(isset($reporteEspecifico) && $reporteEspecifico==13){
					echo '</div>';
				} ?>
			<div class="mensajes"></div>
                
                <script type="text/javascript">       
				
            $('#tabs-13 .consultar').bind('click', function(event) {
                    updateDataReconocimientos();
                });   
            
            function updateDataReconocimientos(){
                var name = "#tabs-13";
                    var periodo1 = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                    var periodo2 = $(name + ' #mes2').val()+"-"+$(name + ' #anio2').val();
					var promise = getData(name,'formUnidadesAcademicasReconocimientosEstudiantes',periodo1,"codigoperiodo",
					 periodo2,"mes","m-Y","sum",9,13);
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true && data.total>0){
								var campos = new Array();
								campos[0] = new Array("nombre","texto"); 
								campos[1] = new Array("numEstudiantes","int");
								pintarValoresConsultaConsolidado(name, "sum", data.data,campos,true,data.infoPeriodos, data.infoAdjuntos,"","",true);	
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="2" class="center">No se encontraron datos.</td></tr>');
								pintarMensajesPeriodosFaltantes(name, data.infoPeriodos, data.infoAdjuntos);
                            }                         
                      });
            }
        </script>
</div>
	<?php } if(!isset($reporteEspecifico) || $reporteEspecifico==14){ ?>
<div id="tabs-14" class="formsHuerfanos">
      <?php getPlantillaConsulta($db, "m");  
		 
			if(isset($reporteEspecifico) && $reporteEspecifico==14){
				echo '<div id="tableDiv">';
			}
		 ?>
     
        <table align="center" class="formData viewData previewReport" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Proyectos de consultoría</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Proyectos de Consultoría</span></th> 
                            <th class="column" ><span>Números de proyectos</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
                </table>  
					<?php if(isset($reporteEspecifico) && $reporteEspecifico==14){
					echo '</div>';
				} ?>
			<div class="mensajes"></div>
                
                <script type="text/javascript">
				   $('#tabs-14 .consultar').bind('click', function(event) {
                    getData14();
                });   
                            
                function getData14(){
                    var name = "#tabs-14";
                    html = "";                    
                    var periodo1 = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                    var periodo2 = $(name + ' #mes2').val()+"-"+$(name + ' #anio2').val();
                     var promise = getData(name,'formUnidadesAcademicasProyectosConsultoria',periodo1,"codigoperiodo",
					 periodo2,"mes","m-Y","sum",9,15); 
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
							if (data.success == true && data.total>0){
								var campos = new Array();
                                        campos[0] = new Array("Consultorías aprobados","textoFijo"); 
										campos[1] = new Array("numAprobadas","int");
										campos[2] = new Array("Consultorías en ejecución","textoFijo");
										campos[3] = new Array("numEjecucion","int");
                                       pintarValoresConsultaConsolidado(name, "sum", data.data,campos,true,data.infoPeriodos, data.infoAdjuntos,"","",false);	
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="2" class="center">No se encontraron datos.</td></tr>');
								pintarMensajesPeriodosFaltantes(name, data.infoPeriodos, data.infoAdjuntos);
                            }                         
                      });
                      
                }
                    
        </script>
</div>

<?php } if(!isset($reporteEspecifico) || $reporteEspecifico==15) { ?>
<div id="tabs-15" class="formsHuerfanos">
	<?php getPlantillaConsulta($db, "s"); 
			if(isset($reporteEspecifico) && $reporteEspecifico==15){
				echo '<div id="tableDiv">';
			}
		 ?>
	
	    <table align="center" class="formData viewData previewReport" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Dedicación de los Académicos por actividades</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR"><span>Clase De Actividades</span></th> 
                            <th class="column "><span>Horas Semanales</span></th> 
                            <th class="column "><span>Tiempos completos equivalentes</span></th> 
                        </tr>
                     </thead>
                    <tbody>                     
                    </tbody>
      </table>   
				<?php if(isset($reporteEspecifico) && $reporteEspecifico==15){
					echo '</div>';
				} ?>
	  
	  <div class="mensajes"></div>
	  
	  <script type="text/javascript">
				$('#tabs-15 .consultar').bind('click', function(event) {
                    getData15();
                });   
                
                function getData15(){
                    var name = "#tabs-15";
					if($(name + ' .unidadAcademica').val()=="" || $(name + ' #codigoperiodo').val()=="" ){
						$(name + ' tbody').html("");
					} else {
						html = "";                    
						var periodo1 = $(name + ' #codigoperiodo').val();
						var periodo2 = $(name + ' #codigoperiodo2').val();
						
						 var promise = getDataDynamic(name,'formUnidadesAcademicasActividadesAcademicos',periodo1,"codigoperiodo","siq_tipoActividadAcademicos",periodo2,"semestral","Yp",
						 "sum",9,16);
						 promise.success(function (data) {
							 $(name + ' tbody').html('');
								 //console.log(data);
								 if (data.success == true && data.total>0){
										var campos = new Array();
										campos[0] = new Array("nombre","texto"); 
										campos[1] = new Array("numHoras","int");
										campos[2] = new Array("numAcademicosTCE","int"); 
										pintarValoresConsultaConsolidado(name, "sum", data.data,campos,true,data.infoPeriodos, data.infoAdjuntos,"Yp","Y-p");	
											
									}
									else{  
										$(name + ' tbody').html('<tr><td colspan="3" class="center">No se encontraron datos.</td></tr>');
										pintarMensajesPeriodosFaltantes(name, data.infoPeriodos, data.infoAdjuntos,"Yp","Y-p");
									}                         
							  });
							  
						}
                } 
	  </script>
</div><!--- tab 15 -->
<?php } if(!isset($reporteEspecifico) || $reporteEspecifico==17) { ?>
<div id="tabs-17" class="formsHuerfanos">
<?php
      $tipoUsoLab = $db->GetAll("select nombre,idsiq_tipoUsoLaboratorio as id from siq_tipoUsoLaboratorio WHERE codigoestado=100 ORDER BY nombre ASC");
      $js_tipoUsoLab = json_encode($tipoUsoLab);

	  getPlantillaConsulta($db, "s"); 
			if(isset($reporteEspecifico) && $reporteEspecifico==17){
				echo '<div id="tableDiv">';
			}
		 ?>
     
	        <table align="center" class="formData viewData previewReport" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="5"><span>Laboratorios, Talleres, Museos, etc</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" ><span>Nombre del (Laboratorio, taller, Museo, etc)</span></th> 
                            <th class="column borderR" ><span>Cantidad</span></th> 
                            <th class="column borderR" ><span>Capacidad <br/>(número de puestos<br/>para estudiantes)</span></th> 
                            <th class="column borderR" ><span>Observaciones</span></th> 
                            <th class="column borderR" ><span>Tipo de Utilización</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
                </table>  
				<?php if(isset($reporteEspecifico) && $reporteEspecifico==17){
					echo '</div>';
				} ?>
	  
	  <div class="mensajes"></div>
                
                <script type="text/javascript">           
            
            $('#tabs-17 .consultar').bind('click', function(event) {
                    updateDataLaboratorios();
                });   
                
            function updateDataLaboratorios(){
                <?php echo "var tipoUsoLab_array = ". $js_tipoUsoLab .";\n" ?>
                tipoUsoLab_array = convertArray(tipoUsoLab_array);

                var name = "#tabs-17";
						var periodo1 = $(name + ' #codigoperiodo').val();
						var periodo2 = $(name + ' #codigoperiodo2').val();
					var promise = getData(name,'formUnidadesAcademicasLaboratorios',periodo1,"codigoperiodo",
					 periodo2,"semestral","Yp", "sum",9,17);
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true && data.total>0){
								var campos = new Array();
								campos[0] = new Array("nombre","texto"); 
								campos[1] = new Array("numLaboratorios","int");
								campos[2] = new Array("capacidad","int");
								campos[3] = new Array("observaciones","texto");
								campos[4] = new Array("idsiq_tipoUsoLaboratorio","categoria");
								pintarValoresConsultaConsolidado(name, "sum", data.data,campos,true,data.infoPeriodos, data.infoAdjuntos,"Yp","Y-p",true,tipoUsoLab_array);	
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="5" class="center">No se encontraron datos.</td></tr>');
								pintarMensajesPeriodosFaltantes(name, data.infoPeriodos, data.infoAdjuntos,"Yp","Y-p");
                            }                         
                      });
            }
        </script>
</div><!--- tab 17 --->
   
<?php } if(!isset($reporteEspecifico) || $reporteEspecifico==18){ ?>
		 
			
<div id="tabs-18" class="formsHuerfanos">
         <?php getPlantillaConsulta($db,"m"); 
		 if(isset($reporteEspecifico) && $reporteEspecifico==18){
				echo '<div id="tableDiv">';
			} ?>
		  
         <table align="center" class="formData viewData previewReport" width="100%" >
                    <thead>                
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Equipos de cómputo disponibles para los académicos</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" ><span>Dedicación (según CNA)</span></th> 
                            <th class="column borderR" ><span>Equipos de computo</span></th> 
                            <th class="column" ><span>Total académicos</span></th> 
                        </tr>
                    </thead>
                    <tbody>                     
                    </tbody>
                </table>   
					<?php if(isset($reporteEspecifico) && $reporteEspecifico==18){
					echo '</div>';
				} ?>
			<div class="mensajes"></div>
        <script type="text/javascript">                
            $('#tabs-18 .consultar').bind('click', function(event) {
					if(validarPeriodos("#tabs-18")){
						getData18("#tabs-18");
					}
                });            
                
                function getData18(name){
                    html = "";                    
                    var periodo1 = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                    var periodo2 = $(name + ' #mes2').val()+"-"+$(name + ' #anio2').val();
                     var promise = getData(name,'formUnidadesAcademicasEquiposComputo',periodo1,"codigoperiodo",
					 periodo2,"mes","m-Y","sum",9,19);
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true && data.total>0){
								var campos = new Array();
								campos[0] = new Array("Tiempo completo (29 - 40h)","textoFijo");
								campos[1] = new Array("numEquiposTC","int");
								campos[2] = new Array("numAcademicosTC","int");
								campos[3] = new Array("Medio tiempo (15 - 28h)","textoFijo");
								campos[4] = new Array("numEquiposMT","int");
								campos[5] = new Array("numAcademicosMT","int");
								pintarValoresConsultaConsolidado(name, "sum", data.data,campos,true,data.infoPeriodos, data.infoAdjuntos, "", "", false);	
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="3" class="center">No se encontraron datos.</td></tr>');
								pintarMensajesPeriodosFaltantes(name, data.infoPeriodos, data.infoAdjuntos);
                            }                         
                      });
                }
        </script>
</div><!--- tab 18 --->
<?php } if(!isset($reporteEspecifico) || $reporteEspecifico==19) {  ?>

  <div id="tabs-19" class="formsHuerfanos">     
         <?php getPlantillaConsulta($db,"m"); 
		 if(isset($reporteEspecifico) && $reporteEspecifico==19){
				echo '<div id="tableDiv">';
			} ?>
     
        <table align="center" class="formData viewData previewReport" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Participación de los académicos como expositor en congresos, seminarios, simposios, talleres nacionales e internacionales</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2"><span>Programa</span></th> 
                            <th class="column borderR" colspan="2"><span>Ámbito</span></th> 
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Nacional</span></th> 
                            <th class="column borderR" ><span>Internacional</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
                </table>   
					<?php if(isset($reporteEspecifico) && $reporteEspecifico==19){
					echo '</div>';
				} ?> 
			<div class="mensajes"></div>
                
                <script type="text/javascript">            
            
            $('#tabs-19 .consultar').bind('click', function(event) {
                    getData19("#tabs-19");
                });          		
                
                function getData19(name){
                    html = "";                            
                    var periodo1 = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                    var periodo2 = $(name + ' #mes2').val()+"-"+$(name + ' #anio2').val();
                     var promise = getDataDynamic(name,'formUnidadesAcademicasParticipacionAcademicos',periodo1,"codigoperiodo","siq_tipoEventoAcademico",
					 periodo2,"mes","m-Y","sum",9,2);
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true && data.total>0){
								var campos = new Array();
								campos[0] = new Array("nombre","texto"); 
								campos[1] = new Array("numNacional","int");
								campos[2] = new Array("numInternacional","int"); 
								pintarValoresConsultaConsolidado(name, "sum", data.data,campos,true,data.infoPeriodos, data.infoAdjuntos);	
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="3" class="center">No se encontraron datos.</td></tr>');
								pintarMensajesPeriodosFaltantes(name, data.infoPeriodos, data.infoAdjuntos);
                            }                         
                      });        
                }
           
        </script>
</div>	
<?php } if(!isset($reporteEspecifico) || $reporteEspecifico==20) {  ?>
<div id="tabs-20" class="formsHuerfanos">
	<?php getPlantillaConsulta($db,"m"); 
			if(isset($reporteEspecifico) && $reporteEspecifico==20){
				echo '<div id="tableDiv">';
			} ?>
	
	    <table align="center" class="formData viewData previewReport" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="6"><span>Movilidad académica Profesoral: Académicos de Otras Universidades que vienen a la Universidad</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2"><span>País de procedencia</span></th> 
                            <th class="column borderR" colspan="5"><span>Tipo de movilidad</span></th> 
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Trabajo de cooperación</span></th> 
                            <th class="column" ><span>Presentación en seminario,<br/>congreso, etc.</span></th> 
                            <th class="column" ><span>Investigación</span></th> 
                            <th class="column" ><span>Pasantía</span></th> 
                            <th class="column" ><span>Docencia</span></th> 
                        </tr>
                     </thead>
                    <tbody>                     
                    </tbody>
      </table>   
					<?php if(isset($reporteEspecifico) && $reporteEspecifico==20){
					echo '</div>';
				} ?> 
	  
	  <div class="mensajes"></div>
	  
	  <script type="text/javascript">
				$('#tabs-20 .consultar').bind('click', function(event) {
                    getData20();
                });   
                
                function getData20(){
                    var name = "#tabs-20";
					if($(name + ' .unidadAcademica').val()=="" || $(name + ' #codigoperiodo').val()=="" ){
						$(name + ' tbody').html("");
					} else {
						html = "";                    
						var periodo1 = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                    var periodo2 = $(name + ' #mes2').val()+"-"+$(name + ' #anio2').val();
						
						 var promise = getDataDynamic(name,'formUnidadesAcademicasMovilidadProfesoral',periodo1,"codigoperiodo","siq_categoriaPais",
					 periodo2,"mes","m-Y","sum",9,8);
						 promise.success(function (data) {
							 $(name + ' tbody').html('');
								 //console.log(data);
								 if (data.success == true && data.total>0){
										var campos = new Array();
										campos[0] = new Array("nombre","texto"); 
										campos[1] = new Array("numCooperacionLlegada","int");
										campos[2] = new Array("numPresentacionLlegada","int"); 
										campos[3] = new Array("numInvestigacionLlegada","int"); 
										campos[4] = new Array("numPasantiaLlegada","int"); 
										campos[5] = new Array("numDocenciaLlegada","int"); 
										pintarValoresConsultaConsolidado(name, "sum", data.data,campos,true,data.infoPeriodos, data.infoAdjuntos);	
											
									}
									else{  
										$(name + ' tbody').html('<tr><td colspan="6" class="center">No se encontraron datos.</td></tr>');
										pintarMensajesPeriodosFaltantes(name, data.infoPeriodos, data.infoAdjuntos);
									}                         
							  });
							  
						}
                } 
	  </script>
</div><!--- tab 20 -->
		<?php } if(!isset($reporteEspecifico) || $reporteEspecifico==21){ ?>
<div id="tabs-21" class="formsHuerfanos">
         <?php getPlantillaConsulta($db,"m"); 
		 
			if(isset($reporteEspecifico) && $reporteEspecifico==21){
				echo '<div id="tableDiv">';
			}
		 ?>
		  
         <table align="center" class="formData viewData previewReport" width="100%" >
                    <thead>                
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Participación de estudiantes en la evaluación de la Investigación formativa</span></th>                                    
                        </tr>
                    </thead>
                    <tbody>                     
                    </tbody>
                </table>   
					<?php if(isset($reporteEspecifico) && $reporteEspecifico==21){
					echo '</div>';
				} ?>
					
			<div class="mensajes"></div>
        <script type="text/javascript">                
            $('#tabs-21 .consultar').bind('click', function(event) {
					if(validarPeriodos("#tabs-21")){
						getData21("#tabs-21");
					}
                });            
                
                function getData21(name){
                    html = "";                    
                    var periodo1 = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                    var periodo2 = $(name + ' #mes2').val()+"-"+$(name + ' #anio2').val();
                     var promise = getData(name,'formUnidadesAcademicasEstudiantesInvestigacion',periodo1,"codigoperiodo",
					 periodo2,"mes","m-Y","sum",9,14);
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true && data.total>0){
								var campos = new Array();
								campos[0] = new Array("Estudiantes que realizaron evaluación de la Investigación formativa","textoFijo");
								campos[1] = new Array("numEstudiantes","int");
								pintarValoresConsultaConsolidado(name, "sum", data.data,campos,true,data.infoPeriodos, data.infoAdjuntos, "", "", false);	
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="2" class="center">No se encontraron datos.</td></tr>');
								pintarMensajesPeriodosFaltantes(name, data.infoPeriodos, data.infoAdjuntos);
                            }                         
                      });
                }
        </script>
</div><!--- tab 21 --->
		<?php } if(!isset($reporteEspecifico) || $reporteEspecifico==22){ ?>
<div id="tabs-22" class="formsHuerfanos">
         <?php getPlantillaConsulta($db, "s"); 
		 
			if(isset($reporteEspecifico) && $reporteEspecifico==22){
				echo '<div id="tableDiv">';
			}
		 ?>
		  
         <table align="center" class="formData viewData previewReport" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Número de redes y asociaciones Institucionales</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2" ><span>Redes y Asociaciones</span></th> 
                            <th class="column borderR" colspan="2"><span>Ámbito</span></th> 
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" ><span>Nacional</span></th> 
                            <th class="column borderR"><span>Internacional</span></th> 
                        </tr>
                     </thead>
                    <tbody>                     
                    </tbody>
                </table>   
					<?php if(isset($reporteEspecifico) && $reporteEspecifico==22){
					echo '</div>';
				} ?>
					
			<div class="mensajes"></div>
        <script type="text/javascript">                
            $('#tabs-22 .consultar').bind('click', function(event) {
						getData22("#tabs-22");
                });            
                
                function getData22(name){
                    html = "";                    
						var periodo1 = $(name + ' #codigoperiodo').val();
						var periodo2 = $(name + ' #codigoperiodo2').val();
                     var promise = getData(name,'formUnidadesAcademicasRedes',periodo1,"codigoperiodo", periodo2,"semestral","Yp", "sum",9,20);
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true && data.total>0){
								var campos = new Array();
								campos[0] = new Array("nombre","texto"); 
								campos[1] = new Array("numNacional","int");
								campos[2] = new Array("numInternacional","int");
								pintarValoresConsultaConsolidado(name, "sum", data.data,campos,true,data.infoPeriodos, data.infoAdjuntos,"Yp","Y-p");	
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="3" class="center">No se encontraron datos.</td></tr>');
								pintarMensajesPeriodosFaltantes(name, data.infoPeriodos, data.infoAdjuntos,"Yp","Y-p");
                            }                         
                      });
                }
        </script>
</div><!--- tab 22 --->
<?php } if(!isset($reporteEspecifico)) { ?>
</div> <!--- tabs -->
<?php } ?>