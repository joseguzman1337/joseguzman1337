<?php 
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
function getPlantillaConsulta($db,$tipo){ ?>
	
                <div class="formModalidad">
                     <?php $rutaModalidad = "./_elegirProgramaAcademico.php";
					 if(!is_file($rutaModalidad)){
						$rutaModalidad = './formularios/academicos/_elegirProgramaAcademico.php';
					 }
					include($rutaModalidad);  ?>
                </div>
                
                <div class="vacio"></div>
                
				<?php if($tipo==="m") { ?>
					<label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
					<?php $utils->getMonthsSelect();  ?>
					
					<label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
					<?php $utils->getYearsSelect("anio");  ?>
					<div class="vacio"></div>
					<span style="margin-left:220px;position:relative;top:-10px;">a</span>
					<div class="vacio"></div>
					<label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
					<?php $utils->getMonthsSelect("mes2");  ?>
					
					<label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
					<?php $utils->getYearsSelect("anio2");    

				} else if($tipo==="s") {  ?>
					<label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
					<?php $utils->getSemestresSelect($db,"codigoperiodo");  
					?>
					<div class="vacio"></div>
					<span style="margin-left:220px;position:relative;top:-10px;">a</span>
					<div class="vacio"></div>
					
					<label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
					<?php $utils->getSemestresSelect($db,"codigoperiodo2");  
					?>
				<?php } ?>
                
                <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                
                <div class="vacio"></div>
	
<?php } ?>

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
             return  $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getDataDynamicConsolidada", entity: entity, campoPeriodo: campoPeriodo,entityJoin: 
							entityJoin,codigocarrera:codigocarrera, periodo2: periodo2, tipo: tipo, formato:formato,funcion:funcion,idFormulario:form,
							pestana:tab,order:order},     
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
         }
		 
	
         
         function getData(formName,entity,periodo,campoPeriodo,periodo2,tipo,formato,funcion,form,tab,order){
             var codigocarrera = $(formName + " .unidadAcademica").val();
             return  $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getDataConsolidada", entity: entity, campoPeriodo: campoPeriodo,codigocarrera:codigocarrera, 
							periodo2: periodo2, tipo: tipo, formato:formato,funcion:funcion,idFormulario:form,
							pestana:tab,order:order },     
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
         }
		 
	function pintarMensajesPeriodosFaltantes(name, periodosValores, periodosAdjuntos, formatoActual, formato){
		$(name + ' .mensajes').html('');

		if( (typeof periodosValores!= "undefined" && periodosValores!="") || (typeof periodosAdjuntos!= "undefined" && periodosAdjuntos!="")){			
		
			if( (typeof formatoActual!= "undefined" && formatoActual!="") && (typeof formato!= "undefined" && formato!="")){
				periodosValores = cambiarFormato(periodosValores, formatoActual, formato);
				periodosAdjuntos = cambiarFormato(periodosAdjuntos, formatoActual, formato);
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
	
	//es como el live() pero no descontinuado... para elementos añadidos dinamicamente
    $(document).on('change', "div .modalidad", function(){
		var idTab = "#"+$(this).closest("div.formsHuerfanos").attr('id');
		//console.log(idTab);
        getCarreras(idTab);
        changeFormModalidad(idTab);
    });
                
    $(document).on('change', "div .unidadAcademica", function(){
		//console.log(idTab);
		var idTab = "#"+$(this).closest("div.formsHuerfanos").attr('id');
        changeFormModalidad(idTab);
    });
		 
	function pintarValoresConsultaConsolidado(idform, funcion, valores,campos,totalizar,periodosValores, periodosAdjuntos, formatoActual, formato, conCategoria){
			pintarValoresConsulta(idform, funcion, valores, campos, totalizar, conCategoria);
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
            <li><a href="#tabs-16">Descripción de Otras unidades Bibliográficas</a></li>
            <li><a href="#tabs-17">Laboratorios, Talleres, Museos, etc</a></li>
            <li><a href="#tabs-18">Equipos de cómputo</a></li>
            <li><a href="#tabs-22">Número de redes y asociaciones Institucionales</a></li>
            <li><a href="./formularios/academicos/viewFortalecimientoAcademico2.php?id=<?php echo $id; ?>&alias=apeirbyh" class="locationTab">Asignaturas que incorporan el referente<br/>de la bioética y las humanidades</a></li>
            <li><a href="./formularios/academicos/viewFortalecimientoAcademico2.php?id=<?php echo $id; ?>&alias=auleaaecpupa" class="locationTab">Asignaturas que utilizan lengua extranjera</a></li>
            <li><a href="./formularios/academicos/viewFortalecimientoAcademico2.php?id=<?php echo $id; ?>&alias=aaiaaepu" class="locationTab">Asignaturas que articulan la internacionalización con<br/>las actividades de aprendizaje y evaluación</a></li>
            <li><a href="./formularios/academicos/viewFortalecimientoAcademico2.php?id=<?php echo $id; ?>&alias=aihmtaeaaput" class="locationTab">Asignaturas que incluyen herramientas mediadas por las TICs</a></li>
	</ul>
	
<div id="tabs-1" class="formsHuerfanos">
         <?php getPlantillaConsulta($db,"m"); ?>
		  
         <table align="center" class="formData viewData" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="5"><span>Proyección social: Proyectos realizados con diferentes grupos de interés, según el núcleo estratégico</span></th>                                    
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


<div id="tabs-11" class="formsHuerfanos">
	<?php getPlantillaConsulta($db, "s"); ?>
	
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
	  
	  <div class="mensajes"></div>
	  
	  <script type="text/javascript">
				$('#tabs-11 .consultar').bind('click', function(event) {
                    getData11();
                });   
                
                /*function getData11(){
                    var name = "#tabs-11";
					if($(name + ' .unidadAcademica').val()=="" || $(name + ' #codigoperiodo').val()=="" ){
						$(name + ' tbody').html("");
					} else {
						html = "";                    
						var periodo1 = $(name + ' #codigoperiodo').val();
						var periodo2 = $(name + ' #codigoperiodo2').val();
						
						 var promise = getDataDynamic(name,'formUnidadesAcademicasFormacionProfesional',periodo1,"codigoperiodo","areaconocimiento",periodo2,"semestral","Yp",
						 "sum",9,11,"nombreareaconocimiento ASC");
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
										$(name + ' tbody').html('<tr><td colspan="2" class="center">No se encontraron datos.</td></tr>');
										pintarMensajesPeriodosFaltantes(name, data.infoPeriodos, data.infoAdjuntos,"Yp","Y-p");
									}                         
							  });
							  
						}
                } */
	  </script>
</div><!--- tab 11 -->

<div id="tabs-12" class="formsHuerfanos">
	<?php getPlantillaConsulta($db, "s"); ?>
	
	    <table align="center" class="formData viewData" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Número productos resultado de actividades de investigación formativa</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR"><span>Tipo de Producto</span></th> 
                            <th class="column "><span>Cantidad</span></th> 
                        </tr>
                     </thead>
                    <tbody>                     
                    </tbody>
      </table>   
	  
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
										$(name + ' tbody').html('<tr><td colspan="3" class="center">No se encontraron datos.</td></tr>');
										pintarMensajesPeriodosFaltantes(name, data.infoPeriodos, data.infoAdjuntos,"Yp","Y-p");
									}                         
							  });
							  
						}
                } 
	  </script>
</div><!--- tab 12 -->

<div id="tabs-15" class="formsHuerfanos">
	<?php getPlantillaConsulta($db, "s"); ?>
	
	    <table align="center" class="formData viewData" width="100%" >
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

	
<div id="tabs-21" class="formsHuerfanos">
         <?php getPlantillaConsulta($db,"m"); ?>
		  
         <table align="center" class="formData viewData" width="100%" >
                    <thead>                
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Participación de estudiantes en la evaluación de la Investigación formativa</span></th>                                    
                        </tr>
                    </thead>
                    <tbody>                     
                    </tbody>
                </table>   
					
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
                                $(name + ' tbody').html('<tr><td colspan="5" class="center">No se encontraron datos.</td></tr>');
								pintarMensajesPeriodosFaltantes(name, data.infoPeriodos, data.infoAdjuntos);
                            }                         
                      });
                }
        </script>
</div><!--- tab 21 --->

</div> <!--- tabs -->
	