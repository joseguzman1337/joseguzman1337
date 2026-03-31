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
                
                 //$( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
                //$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
	});
        
        
         
         function Eliminar(id, entity, metodo){
                 $.ajax({
                      dataType: 'json',
                      type: 'POST',
                      url: './formularios/academicos/saveUnidadesAcademicas.php',
                      data: { action: "inactivateEntity", id: id, entity: entity },     
                      success:function(data){
                            //todo bien :)
                            mainfunc(metodo);
                      },
                      error: function(data,error,errorThrown){alert(error + errorThrown);}
                });  
         }
         
         function getDataDynamic(formName,entity,periodo,campoPeriodo,entityJoin){
             var codigocarrera = $(formName + " .unidadAcademica").val();
             return  $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: entity, campoPeriodo: campoPeriodo,entityJoin: entityJoin,codigocarrera:codigocarrera },     
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
         }
         
         function getData(formName,entity,periodo,campoPeriodo){
             var codigocarrera = $(formName + " .unidadAcademica").val();
             return  $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getData", entity: entity, campoPeriodo: campoPeriodo,codigocarrera:codigocarrera },     
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
         }
         
         function getData2(formName,entity,periodo,campoPeriodo){
             var codigocarrera = $(formName + " .unidadAcademica").val();
             return  $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getData2", entity: entity, campoPeriodo: campoPeriodo,codigocarrera:codigocarrera },     
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
         }
         
         function getDataByDate(formName,entity,periodo,campoFecha){
             var codigocarrera = $(formName + " .unidadAcademica").val();
             return  $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getDataByDate", entity: entity, campoFecha: campoFecha,codigocarrera:codigocarrera },     
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
         }
         
         /*function getRecordsTable(formName,table,periodo,categories,nombreOrder){
                        var mod = $(formName + ' .unidadAcademica').val();
                           return $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url: '../searchs/lookForRecordsByCareer.php',
                                data: { carrera: mod,table:table,periodo:periodo,categories:categories,nombreOrder:nombreOrder },     
                                error: function(data,error,errorThrown){alert(error + errorThrown);}
                            });  
         }
         
         function getValueRecordsTable(formName,table,periodo,categories,nombreOrder,valorPeriodo,idCategory){
               var mod = $(formName + ' .unidadAcademica').val();
                           return $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                async: false,
                                url: '../searchs/lookForValueRecordsByCareer.php',
                                data: { carrera: mod,table:table,periodo:periodo,categories:categories,nombreOrder:nombreOrder,valorPeriodo:valorPeriodo,idCategory:idCategory },     
                                error: function(data,error,errorThrown){alert(error + errorThrown);}
                            });  
         }*/
          
                
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
            <!--<li><a href="#tabs-16">Descripción de Otras unidades Bibliográficas</a></li>-->
            <li><a href="#tabs-17">Laboratorios, Talleres, Museos, etc</a></li>
            <li><a href="#tabs-18">Equipos de cómputo</a></li>
            <li><a href="#tabs-22">Número de redes y asociaciones Institucionales</a></li>
            <li><a href="./formularios/academicos/viewFortalecimientoAcademico2.php?id=<?php echo $id; ?>&alias=apeirbyh" class="locationTab">Asignaturas que incorporan el referente<br/>de la bioética y las humanidades</a></li>
            <li><a href="./formularios/academicos/viewFortalecimientoAcademico2.php?id=<?php echo $id; ?>&alias=auleaaecpupa" class="locationTab">Asignaturas que utilizan lengua extranjera</a></li>
            <li><a href="./formularios/academicos/viewFortalecimientoAcademico2.php?id=<?php echo $id; ?>&alias=aaiaaepu" class="locationTab">Asignaturas que articulan la internacionalización con<br/>las actividades de aprendizaje y evaluación</a></li>
            <li><a href="./formularios/academicos/viewFortalecimientoAcademico2.php?id=<?php echo $id; ?>&alias=aihmtaeaaput" class="locationTab">Asignaturas que incluyen herramientas mediadas por las TICs</a></li>
	</ul>
    <div id="tabs-1" class="formsHuerfanos">
     
                <div class="formModalidad">
                     <?php $rutaModalidad = "./_elegirProgramaAcademico.php";
					 if(!is_file($rutaModalidad)){
						$rutaModalidad = './formularios/academicos/_elegirProgramaAcademico.php';
					 }
					include($rutaModalidad); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect();  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
                <div class="consultar" title="" onmouseover="botonconsultar(this)">
                <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    </div>
                
                <div class="vacio"></div>
                
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
        <script type="text/javascript">    
            //es como el live() pero no descontinuado... para elementos añadidos dinamicamente
                $(document).on('change', "#tabs-1 .modalidad", function(){
                    getCarreras("#tabs-1");
                    changeFormModalidad("#tabs-1");
                });
                
                $(document).on('change', "#tabs-1 .unidadAcademica", function(){
                    changeFormModalidad("#tabs-1");
                });
            
            
            $('#tabs-1 .consultar').bind('click', function(event) {
                    getData1("#tabs-1");
                });            
                
                function getData1(name){
                    html = "";                    
                    var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                     var promise = getDataDynamic(name,'formUnidadesAcademicasProyectosGruposInteres',periodo,"codigoperiodo","siq_sectores");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true){
                                var totalSalud = 0;
                                var totalCalidad = 0;
                                var totalOtras = 0;
                                 for (var i=0;i<data.total;i++)
                                    {     
                                        totalSalud = totalSalud + parseInt(data.data[i].numSalud);                                        
                                        totalCalidad = totalCalidad + parseInt(data.data[i].numCalidadVida);                                        
                                        totalOtras = totalOtras + parseInt(data.data[i].numOtrasDisciplinas);
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column borderR">'+data.data[i].nombre_sector+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numSalud+'</td>';
                                        html = html + '<td class="column borderR center">'+data.data[i].numCalidadVida+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numOtrasDisciplinas+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                    }
                                    
                                    html = '<tr class="dataColumns">';
                                    html = html + '<th class="column total right borderR"><span>Total</span></th>"';
                                    html = html + '<th class="column total center">'+totalSalud+'</th>"';    
                                    html = html + '<th class="column total center borderR">'+totalCalidad+'</th>"';        
                                    html = html + '<th class="column total center">'+totalOtras+'</th>"';                                    
                                    html = html + '</tr>';
                                    $(name + ' tbody').append(html);
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="5" class="center">No se encontraron datos.</td></tr>');
                            }                         
                      });
                }
        </script>
</div>
    
    <div id="tabs-2" class="formsHuerfanos">
     
                <div class="formModalidad">
                     <?php include($rutaModalidad); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect();  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
                <div class="consultar" title="" onmouseover="botonconsultar(this)">
                <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                </div>
                <div class="vacio"></div>
     
        <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="5"><span>Participación de los académicos como expositor en congresos, seminarios, simposios, talleres por núcleo estratégico</span></th>                                    
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
                
                <script type="text/javascript">
            $(document).on('change', "#tabs-2 .modalidad", function(){
                    getCarreras("#tabs-2");
                    changeFormModalidad("#tabs-2");
                });
                
                $(document).on('change', "#tabs-2 .unidadAcademica", function(){
                    changeFormModalidad("#tabs-2");
                });
            
            
            $('#tabs-2 .consultar').bind('click', function(event) {
                    getDataParticipacion("#tabs-2");
                });            
                
                function getDataParticipacion(name){
                    html = "";                    
                    var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                     var promise = getDataDynamic(name,'formUnidadesAcademicasParticipacionAcademicos',periodo,"codigoperiodo","siq_tipoEventoAcademico");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true){
                                var totalSalud = 0;
                                var totalCalidad = 0;
                                var totalOtras = 0;
                                 for (var i=0;i<data.total;i++)
                                    {     
                                        totalSalud = totalSalud + parseInt(data.data[i].numSalud);                                        
                                        totalCalidad = totalCalidad + parseInt(data.data[i].numCalidad);                                        
                                        totalOtras = totalOtras + parseInt(data.data[i].numOtros);
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column borderR">'+data.data[i].nombre+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numSalud+'</td>';
                                        html = html + '<td class="column borderR center">'+data.data[i].numCalidad+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numOtros+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                    }
                                    
                                    html = '<tr class="dataColumns">';
                                    html = html + '<th class="column total right borderR"><span>Total</span></th>"';
                                    html = html + '<th class="column total center">'+totalSalud+'</th>"';    
                                    html = html + '<th class="column total center borderR">'+totalCalidad+'</th>"';        
                                    html = html + '<th class="column total center">'+totalOtras+'</th>"';                                    
                                    html = html + '</tr>';
                                    $(name + ' tbody').append(html);
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="5" class="center">No se encontraron datos.</td></tr>');
                            }                         
                      });
                }
           
        </script>
</div>
    
    <div id="tabs-19" class="formsHuerfanos">
     
         <div class="formModalidad">
                     <?php include($rutaModalidad); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect();  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
                <div class="consultar" title="" onmouseover="botonconsultar(this)">
                <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                </div>
                <div class="vacio"></div>
     
        <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="5"><span>Participación de los académicos como expositor en congresos, seminarios, simposios, talleres nacionales e internacionales</span></th>                                    
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
                
                <script type="text/javascript">
                    
                    $(document).on('change', "#tabs-19 .modalidad", function(){
                    getCarreras("#tabs-19");
                    changeFormModalidad("#tabs-19");
                });
                
                $(document).on('change', "#tabs-19 .unidadAcademica", function(){
                    changeFormModalidad("#tabs-19");
                });
            
            
            $('#tabs-19 .consultar').bind('click', function(event) {
                    getData19("#tabs-19");
                });            
                
                function getData19(name){
                    html = "";                    
                    var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                     var promise = getDataDynamic(name,'formUnidadesAcademicasParticipacionAcademicos',periodo,"codigoperiodo","siq_tipoEventoAcademico");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true){
                                var totalNacional = 0;
                                var totalInternacional = 0;
                                 for (var i=0;i<data.total;i++)
                                    {     
                                        totalNacional = totalNacional + parseInt(data.data[i].numNacional);                                        
                                        totalInternacional = totalInternacional + parseInt(data.data[i].numInternacional);   
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column borderR">'+data.data[i].nombre+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numNacional+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numInternacional+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                    }
                                    
                                    html = '<tr class="dataColumns">';
                                    html = html + '<th class="column total right borderR"><span>Total</span></th>"';
                                    html = html + '<th class="column total center">'+totalNacional+'</th>"';    
                                    html = html + '<th class="column total center">'+totalInternacional+'</th>"';                                    
                                    html = html + '</tr>';
                                    $(name + ' tbody').append(html);
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="5" class="center">No se encontraron datos.</td></tr>');
                            }                         
                      });
                }
           
        </script>
</div>
    
    <div id="tabs-3" class="formsHuerfanos">
                <div class="formModalidad">
                     <?php include($rutaModalidad); ?>
                </div>
                
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
                            <th class="column" colspan="5"><span>Profesores visitantes recibidos en la Facultad</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Nombre del Académico</span></th> 
                            <th class="column" ><span>Fecha de la visita</span></th> 
                            <th class="column" ><span>Cuidad/ País de origen</span></th> 
                            <th class="column" ><span>Institución</span></th> 
                            <th class="column" ><span>Opciones</span></th> 
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
                                        html = html + '<td class="column center eliminarDato"><img width="16" onclick="Eliminar('+data.data[i].idsiq_formUnidadesAcademicasProfesoresVisitantes+', \'formUnidadesAcademicasProfesoresVisitantes\',\'updateDataVisitantes\')" title="Eliminar Dato" src="../../images/Close_Box_Red.png" style="cursor:pointer;"></td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                    }
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="5" class="center">No se encontraron datos.</td></tr>');
                            }                         
                      });
                }
        </script>
</div>
    
    <div id="tabs-4" class="formsHuerfanos">
                <div class="formModalidad">
                     <?php include($rutaModalidad); ?>
                </div>
                
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
                            <th class="column" colspan="6"><span>Premios o reconocimientos a los académicos</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Nombre del Académico</span></th> 
                            <th class="column" ><span>Tipo de Reconocimiento</span></th> 
                            <th class="column" ><span>Entidad o Institución</span></th> 
                            <th class="column" ><span>Ciudad y País</span></th> 
                            <th class="column" ><span>Fecha</span></th> 
                            <th class="column" ><span>Opciones</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
                </table>  
                
                <script type="text/javascript">
           
             $(document).on('change', "#tabs-4 .modalidad", function(){
                    getCarreras("#tabs-4");
                    changeFormModalidad("#tabs-4");
                });
                
                $(document).on('change', "#tabs-4 .unidadAcademica", function(){
                    changeFormModalidad("#tabs-4");
                });
            
            
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
                                        html = html + '<td class="column center eliminarDato"><img width="16" onclick="Eliminar('+data.data[i].idsiq_formUnidadesAcademicasReconocimientosProfesores+', \'formUnidadesAcademicasReconocimientosProfesores\',\'updateDataPremios\')" title="Eliminar Dato" src="../../images/Close_Box_Red.png" style="cursor:pointer;"></td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                       
                                    }
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="6" class="center">No se encontraron datos.</td></tr>');
                            }                         
                      });
                      
                }
            }
        </script>
</div>
    
       <div id="tabs-5" class="formsHuerfanos">
                <div class="formModalidad">
                     <?php include($rutaModalidad); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect();  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  
                ?>
                <div class="consultar" title="" onmouseover="botonconsultar(this)">
                <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                </div>
                <div class="vacio"></div>
     
        <table align="center" class="formData last" width="92%" >
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
                
                <script type="text/javascript">
           
            $(document).on('change', "#tabs-5 .modalidad", function(){
                    getCarreras("#tabs-5");
                    changeFormModalidad("#tabs-5");
                });
                
                $(document).on('change', "#tabs-5 .unidadAcademica", function(){
                    changeFormModalidad("#tabs-5");
                });
            
            
            $('#tabs-5 .consultar').bind('click', function(event) {
                    getData5();
                });   
                
                function getData5(){
                     var name = "#tabs-5";
                if($(name + ' .unidadAcademica').val()=="" || $(name + ' #mes').val()=="" || $(name + ' #anio').val()==""){
                    $(name + ' tbody').html("");
                } else {
                    html = "";                    
                    var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                     var promise = getData(name,'formUnidadesAcademicasCapacitaciones',periodo,"codigoperiodo");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true){   
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column borderR">Conferencia</td>';
                                        html = html + '<td class="column center">'+data.data.numConferencia+'</td>';
                                        html = html + '</tr>';
                                        html = html + '<tr class="dataColumns">';
                                        html = html + '<td class="column borderR">Taller</td>';
                                        html = html + '<td class="column center">'+data.data.numTaller+'</td>';
                                        html = html + '</tr>';
                                        html = html + '<tr class="dataColumns">';
                                        html = html + '<td class="column borderR">Curso</td>';
                                        html = html + '<td class="column center">'+data.data.numCurso+'</td>';
                                        html = html + '</tr>';
                                        html = html + '<tr class="dataColumns">';
                                        html = html + '<td class="column borderR">Otro</td>';
                                        html = html + '<td class="column center">'+data.data.numOtro+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                        
                                        var total = parseInt(data.data.numConferencia) + parseInt(data.data.numTaller)
                                            + parseInt(data.data.numCurso) + parseInt(data.data.numOtro);
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<th class="column total right borderR"><span>Total</span></th>"';
                                        html = html + '<th class="column total center">'+total+'</th>"';                                      
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="2" class="center">No se encontraron datos.</td></tr>');
                            }                         
                      });
                      
                    }
                }
            
        </script>
</div>
    
<div id="tabs-6" class="formsHuerfanos">
                <div class="formModalidad">
                     <?php include($rutaModalidad); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect();  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  
                ?>
                <div class="consultar" title="" onmouseover="botonconsultar(this)">
                <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                </div>
                <div class="vacio"></div>
     
        <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Uso de Aulas Virtuales en asignaturas</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Número total de Asignaturas</span></th> 
                            <th class="column" ><span>Número de Asignaturas con Aula Virtual</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
                </table>  
                
                <script type="text/javascript">
                    
                    $(document).on('change', "#tabs-6 .modalidad", function(){
                    getCarreras("#tabs-6");
                    changeFormModalidad("#tabs-6");
                });
                
                $(document).on('change', "#tabs-6 .unidadAcademica", function(){
                    changeFormModalidad("#tabs-6");
                });
            
            
            $('#tabs-6 .consultar').bind('click', function(event) {
                    getData6();
                });   
                
                function getData6(){
                    var name = "#tabs-6";
                if($(name + ' .unidadAcademica').val()=="" || $(name + ' #mes').val()=="" || $(name + ' #anio').val()==""){
                    $(name + ' tbody').html("");
                } else {
                    html = "";                    
                    var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                     var promise = getData(name,'formUnidadesAcademicasAulasVirtuales',periodo,"codigoperiodo");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true){   
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column center">'+data.data.numAsignaturas+'</td>';
                                        html = html + '<td class="column center">'+data.data.numAulasVirtuales+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                       
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="2" class="center">No se encontraron datos.</td></tr>');
                            }                         
                      });
                      
                }
                }
           
            
        </script>
</div>
    
<div id="tabs-8" class="formsHuerfanos">
     
                <div class="formModalidad">
                     <?php include($rutaModalidad); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect();  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
                <div class="consultar" title="" onmouseover="botonconsultar(this)">
                <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                </div>
                <div class="vacio"></div>
                
         <table align="center" class="formData viewData" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="6"><span>Movilidad académica Profesoral: Académicos de la Universidad que viajan</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2"><span>País al que viaja</span></th> 
                            <th class="column " colspan="5"><span>Tipo de movilidad</span></th> 
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Trabajo de cooperación</span></th> 
                            <th class="column " ><span>Presentación en seminario, congreso, etc.</span></th> 
                            <th class="column " ><span>Investigación</span></th> 
                            <th class="column " ><span>Pasantía</span></th> 
                            <th class="column " ><span>Docencia</span></th> 
                        </tr>
                     </thead>
                    <tbody>                     
                    </tbody>
                </table>   
        <script type="text/javascript">
            $(document).on('change', "#tabs-8 .modalidad", function(){
                    getCarreras("#tabs-8");
                    changeFormModalidad("#tabs-8");
                });
                
                $(document).on('change', "#tabs-8 .unidadAcademica", function(){
                    changeFormModalidad("#tabs-8");
                });
            
            
            $('#tabs-8 .consultar').bind('click', function(event) {
                    getData8();
                });   
                
                function getData8(){
                    var name = "#tabs-8";
                if($(name + ' .unidadAcademica').val()=="" || $(name + ' #anio').val()=="" || $(name + ' #mes').val()==""){
                    $(name + ' tbody').html("");
                } else {
                    html = "";                    
                    var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                     var promise = getDataDynamic(name,'formUnidadesAcademicasMovilidadProfesoral',periodo,"codigoperiodo","siq_categoriaPais");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true){
                                var total1 = 0;
                                var total2 = 0;
                                var total3 = 0;
                                var total4 = 0;
                                var total5 = 0;
                                 for (var i=0;i<data.total;i++)
                                    {     
                                        total1 = total1 + parseInt(data.data[i].numCooperacionIda);                                        
                                        total2 = total2 + parseInt(data.data[i].numPresentacionIda);                                        
                                        total3 = total3 + parseInt(data.data[i].numInvestigacionIda);                                  
                                        total4 = total4 + parseInt(data.data[i].numPasantiaIda);                                        
                                        total5 = total5 + parseInt(data.data[i].numDocenciaIda);
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column borderR">'+data.data[i].nombre+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numCooperacionIda+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numPresentacionIda+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numInvestigacionIda+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numPasantiaIda+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numDocenciaIda+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                    }
                                    html = '<tr class="dataColumns">';
                                    html = html + '<th class="column total right borderR"><span>Total</span></th>"';
                                    html = html + '<th class="column total center">'+total1+'</th>"';    
                                    html = html + '<th class="column total center">'+total2+'</th>"';        
                                    html = html + '<th class="column total center">'+total3+'</th>"';      
                                    html = html + '<th class="column total center">'+total4+'</th>"';      
                                    html = html + '<th class="column total center">'+total5+'</th>"';                                     
                                    html = html + '</tr>';
                                    $(name + ' tbody').append(html);
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="6" class="center">No se encontraron datos.</td></tr>');
                            }                         
                      });
                      
                }
                }
            
        </script>
</div>
    
<div id="tabs-20" class="formsHuerfanos">
     
                <div class="formModalidad">
                     <?php include($rutaModalidad); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect();  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
                <div class="consultar" title="" onmouseover="botonconsultar(this)">
                <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                </div>
                <div class="vacio"></div>
                
         <table align="center" class="formData viewData" width="100%" >
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
                            <th class="column" ><span>Presentación en seminario, congreso, etc.</span></th> 
                            <th class="column" ><span>Investigación</span></th> 
                            <th class="column" ><span>Pasantía</span></th> 
                            <th class="column" ><span>Docencia</span></th> 
                        </tr>
                     </thead>
                    <tbody>                     
                    </tbody>
                </table>   
        <script type="text/javascript">
            $(document).on('change', "#tabs-20 .modalidad", function(){
                    getCarreras("#tabs-20");
                    changeFormModalidad("#tabs-20");
                });
                
                $(document).on('change', "#tabs-20 .unidadAcademica", function(){
                    changeFormModalidad("#tabs-20");
                });
            
            
            $('#tabs-20 .consultar').bind('click', function(event) {
                    getData20();
                });   
                
                function getData20(){
                    var name = "#tabs-20";
                if($(name + ' .unidadAcademica').val()=="" || $(name + ' #anio').val()=="" || $(name + ' #mes').val()==""){
                    $(name + ' tbody').html("");
                } else {
                    html = "";                    
                    var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                     var promise = getDataDynamic(name,'formUnidadesAcademicasMovilidadProfesoral',periodo,"codigoperiodo","siq_categoriaPais");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true){
                                var total1 = 0;
                                var total2 = 0;
                                var total3 = 0;
                                var total4 = 0;
                                var total5 = 0;
                                 for (var i=0;i<data.total;i++)
                                    {     
                                        total1 = total1 + parseInt(data.data[i].numCooperacionLlegada);                                        
                                        total2 = total2 + parseInt(data.data[i].numPresentacionLlegada);                                        
                                        total3 = total3 + parseInt(data.data[i].numInvestigacionLlegada);                                     
                                        total4 = total4 + parseInt(data.data[i].numPasantiaLlegada);                                        
                                        total5 = total5 + parseInt(data.data[i].numDocenciaLlegada);
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column borderR">'+data.data[i].nombre+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numCooperacionLlegada+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numPresentacionLlegada+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numInvestigacionLlegada+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numPasantiaLlegada+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numDocenciaLlegada+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                    }
                                    
                                    html = '<tr class="dataColumns">';
                                    html = html + '<th class="column total right borderR"><span>Total</span></th>"';
                                    html = html + '<th class="column total center">'+total1+'</th>"';    
                                    html = html + '<th class="column total center">'+total2+'</th>"';        
                                    html = html + '<th class="column total center">'+total3+'</th>"';      
                                    html = html + '<th class="column total center">'+total4+'</th>"';      
                                    html = html + '<th class="column total center">'+total5+'</th>"';                                     
                                    html = html + '</tr>';
                                    $(name + ' tbody').append(html);
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="6" class="center">No se encontraron datos.</td></tr>');
                            }                         
                      });
                      
                }
                }
            
        </script>
</div>
    
<div id="tabs-9" class="formsHuerfanos">
     
        <div class="formModalidad">
                     <?php include($rutaModalidad); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db,"codigoperiodo");  
                      //$cat = $utils->getActives($db,"areaconocimiento","nombreareaconocimiento");
                ?>
                <div class="consultar" title="" onmouseover="botonconsultar(this)">
                <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                </div>
                <div class="vacio"></div>
                
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
        <script type="text/javascript">
            $(document).on('change', "#tabs-9 .modalidad", function(){
                    getCarreras("#tabs-9");
                    changeFormModalidad("#tabs-9");
                });
                
                $(document).on('change', "#tabs-9 .unidadAcademica", function(){
                    changeFormModalidad("#tabs-9");
                });
            
            
            $('#tabs-9 .consultar').bind('click', function(event) {
                    getData9();
                });   
                
                function getData9(){
                    var name = "#tabs-9";
                if($(name + ' .unidadAcademica').val()=="" || $(name + ' #codigoperiodo').val()=="" ){
                    $(name + ' tbody').html("");
                } else {
                    html = "";                    
                    var periodo = $(name + ' #codigoperiodo').val();
                     var promise = getDataDynamic(name,'formUnidadesAcademicasFormacionProfesional',periodo,"codigoperiodo","areaconocimiento");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true){
                                var total1 = 0;
                                var total2 = 0;
                                var total3 = 0;
                                var total4 = 0;
                                var total5 = 0;
                                var total6 = 0;
                                var total7 = 0;
                                var total8 = 0;
                                 for (var i=0;i<data.total;i++)
                                    {     
                                        total1 = total1 + parseInt(data.data[i].numEspecializacion1);                                        
                                        total2 = total2 + parseInt(data.data[i].numEspecializacion2);                                        
                                        total3 = total3 + parseInt(data.data[i].numEspecializacion4);                                     
                                        total4 = total4 + parseInt(data.data[i].numMaestria2);                                        
                                        total5 = total5 + parseInt(data.data[i].numMaestria3);                                   
                                        total6 = total6 + parseInt(data.data[i].numDoctorado2);                                   
                                        total7 = total7 + parseInt(data.data[i].numDoctorado3);                                   
                                        total8 = total8 + parseInt(data.data[i].numDoctorado4);       
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column borderR">'+data.data[i].nombre+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numEspecializacion1+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numEspecializacion2+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numEspecializacion4+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numMaestria2+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numMaestria3+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numDoctorado2+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numDoctorado3+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numDoctorado4+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                    }
                                    
                                    html = '<tr class="dataColumns">';
                                    html = html + '<th class="column total right borderR"><span>Total</span></th>"';
                                    html = html + '<th class="column total center">'+total1+'</th>"';    
                                    html = html + '<th class="column total center">'+total2+'</th>"';        
                                    html = html + '<th class="column total center">'+total3+'</th>"';      
                                    html = html + '<th class="column total center">'+total4+'</th>"';      
                                    html = html + '<th class="column total center">'+total5+'</th>"';      
                                    html = html + '<th class="column total center">'+total6+'</th>"';     
                                    html = html + '<th class="column total center">'+total7+'</th>"';     
                                    html = html + '<th class="column total center">'+total8+'</th>"';                                    
                                    html = html + '</tr>';
                                    $(name + ' tbody').append(html);
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="9" class="center">No se encontraron datos.</td></tr>');
                            }                         
                      });
                      
                }
                }
            
        </script>
</div>
    
    
    
<div id="tabs-10" class="formsHuerfanos">
      <div class="formModalidad">
                     <?php include($rutaModalidad); ?>
                </div>
                
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
                
                <script type="text/javascript">
                    
                    $(document).on('change', "#tabs-10 .modalidad", function(){
                    getCarreras("#tabs-10");
                    changeFormModalidad("#tabs-10");
                });
                
                $(document).on('change', "#tabs-10 .unidadAcademica", function(){
                    changeFormModalidad("#tabs-10");
                });
            
            
            $('#tabs-10 .consultar').bind('click', function(event) {
                    getData10();
                });   
                
                function getData10(){
                    var name = "#tabs-10";
                if($(name + ' .unidadAcademica').val()=="" || $(name + ' #codigoperiodo').val()==""){
                    $(name + ' tbody').html("");
                } else {
                    html = "";                    
                    var periodo = $(name + ' #codigoperiodo').val();
                     var promise = getData(name,'formUnidadesAcademicasPlanEstudio',periodo,"codigoperiodo");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true){   
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column">Formación Fundamental</td>';
                                        html = html + '<td class="column center">'+data.data.numAsignaturasFundamental+'</td>';
                                        html = html + '<td class="column center">'+data.data.numCreditosFundamental+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column">Formación Diversificada</td>';
                                        html = html + '<td class="column center">'+data.data.numAsignaturasDiversificada+'</td>';
                                        html = html + '<td class="column center">'+data.data.numCreditosDiversificada+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);                                        
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column">Electivos complementarios</td>';
                                        html = html + '<td class="column center">'+data.data.numAsignaturasElectivas+'</td>';
                                        html = html + '<td class="column center">'+data.data.numCreditosElectivas+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                        
                                    total1 = parseInt(data.data.numAsignaturasFundamental)+parseInt(data.data.numAsignaturasDiversificada)
                                            +parseInt(data.data.numAsignaturasElectivas);   
                                    total2 = parseInt(data.data.numCreditosFundamental)+parseInt(data.data.numCreditosDiversificada)
                                            +parseInt(data.data.numCreditosElectivas); 
                                        
                                    html = '<tr class="dataColumns">';
                                    html = html + '<th class="column total right"><span>Total</span></th>"';
                                    html = html + '<th class="column total center">'+total1+'</th>"';    
                                    html = html + '<th class="column total center">'+total2+'</th>"';                                        
                                    html = html + '</tr>';
                                    $(name + ' tbody').append(html);
                                       
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="3" class="center">No se encontraron datos.</td></tr>');
                            }                         
                      });
                      
                }
                }
           
        </script>
</div>
    
<div id="tabs-11" class="formsHuerfanos">
      <div class="formModalidad">
                     <?php include($rutaModalidad); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect();  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  
                ?>
                <div class="consultar" title="" onmouseover="botonconsultar(this)">
                <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                </div>
                <div class="vacio"></div>
     
        <table align="center" class="formData last" width="92%" >
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
                
                <script type="text/javascript">
                    $(document).on('change', "#tabs-11 .modalidad", function(){
                    getCarreras("#tabs-11");
                    changeFormModalidad("#tabs-11");
                });
                
                $(document).on('change', "#tabs-11 .unidadAcademica", function(){
                    changeFormModalidad("#tabs-11");
                });
            
            
            $('#tabs-11 .consultar').bind('click', function(event) {
                    getData11();
                });   
                
                function getData11(){
                    var name = "#tabs-11";
                if($(name + ' .unidadAcademica').val()=="" || $(name + ' #mes').val()=="" || $(name + ' #anio').val()==""){
                    $(name + ' tbody').html("");
                } else {
                    html = "";                    
                    var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                     var promise = getData(name,'formUnidadesAcademicasActividadesInvestigacion',periodo,"codigoperiodo");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true){   
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column">Seminarios</td>';
                                        html = html + '<td class="column center">'+data.data.numSeminarios+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column">Foros</td>';
                                        html = html + '<td class="column center">'+data.data.numForos+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column">Estudios de caso</td>';
                                        html = html + '<td class="column center">'+data.data.numEstudiosCaso+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column">Otros</td>';
                                        html = html + '<td class="column center">'+data.data.numOtros+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                        
                                        
                                    total1 = parseInt(data.data.numSeminarios)+parseInt(data.data.numForos)
                                            +parseInt(data.data.numEstudiosCaso)+parseInt(data.data.numOtros);   
                                        
                                    html = '<tr class="dataColumns">';
                                    html = html + '<th class="column total right"><span>Total</span></th>"';
                                    html = html + '<th class="column total center">'+total1+'</th>"';                                       
                                    html = html + '</tr>';
                                    $(name + ' tbody').append(html);
                                       
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="2" class="center">No se encontraron datos.</td></tr>');
                            }                         
                      });
                      
                }
                }
                    
        </script>
</div>
    
<div id="tabs-12" class="formsHuerfanos">
     
         <div class="formModalidad">
                     <?php include($rutaModalidad); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db,"codigoperiodo");  
                      //$sectores = $utils->getActives($db,"siq_tipoActividadAcademicos","nombre");
                    //$categoriasPadres = $utils->getAll($db,"siq_tipoProductoInvestigacion","productoPadre=0 AND codigoestado=100","nombre"); 
                ?>
                <div class="consultar" title="" onmouseover="botonconsultar(this)">
                <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                </div>
                <div class="vacio"></div>
                
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
        <script type="text/javascript">
            $(document).on('change', "#tabs-12 .modalidad", function(){
                    getCarreras("#tabs-12");
                    changeFormModalidad("#tabs-12");
                });
                
                $(document).on('change', "#tabs-12 .unidadAcademica", function(){
                    changeFormModalidad("#tabs-12");
                });
            
            
            $('#tabs-12 .consultar').bind('click', function(event) {
                    getData12();
                });   
                
                function getData12(){
                    var name = "#tabs-12";
                if($(name + ' .unidadAcademica').val()=="" || $(name + ' #codigoperiodo').val()=="" ){
                    $(name + ' tbody').html("");
                } else {
                    html = "";                    
                    var periodo = $(name + ' #codigoperiodo').val();
                     var promise = getDataDynamic(name,'formUnidadesAcademicasProductosInvestigacion',periodo,"codigoperiodo","siq_tipoProductoInvestigacion");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true){
                                var total1 = 0;
                                 for (var i=0;i<data.total;i++)
                                    {     
                                        total1 = total1 + parseInt(data.data[i].cantidad);           
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column borderR">'+data.data[i].nombre+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].cantidad+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                    }
                                    
                                    html = '<tr class="dataColumns">';
                                    html = html + '<th class="column total right borderR"><span>Total</span></th>"';
                                    html = html + '<th class="column total center">'+total1+'</th>"';                                      
                                    html = html + '</tr>';
                                    $(name + ' tbody').append(html);
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="3" class="center">No se encontraron datos.</td></tr>');
                            }                         
                      });
                      
                }
                }
            
        </script>
</div>
    
<div id="tabs-13" class="formsHuerfanos">
      <div class="formModalidad">
                     <?php include($rutaModalidad); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect();  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  
                ?>
                <div class="consultar" title="" onmouseover="botonconsultar(this)">
                <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                </div>
                <div class="vacio"></div>
     
        <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Reconocimientos a estudiantes que participaron en actividades de Investigación Formativa</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Reconocimientos a estudiantes</span></th> 
                            <th class="column" ><span>Número de estudiantes</span></th> 
                            <th class="column" ><span>Opciones</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
                </table>  
                
                <script type="text/javascript">
                    
                    $(document).on('change', "#tabs-13 .modalidad", function(){
                    getCarreras("#tabs-13");
                    changeFormModalidad("#tabs-13");
                });
                
                $(document).on('change', "#tabs-13 .unidadAcademica", function(){
                    changeFormModalidad("#tabs-13");
                });
            
            
            $('#tabs-13 .consultar').bind('click', function(event) {
                    updateDataReconocimientos();
                });   
                
            
            function updateDataReconocimientos(){
                var name = "#tabs-13";
                if($(name + ' .unidadAcademica').val()=="" || $(name + ' #mes').val()=="" || $(name + ' #anio').val()==""){
                    $(name + ' tbody').html("");
                } else {
                    html = "";                    
                    var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                     var promise = getData2(name,'formUnidadesAcademicasReconocimientosEstudiantes',periodo,"codigoperiodo");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true){
                                 for (var i=0;i<data.total;i++)
                                    {       
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column">'+data.data[i].nombre+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numEstudiantes+'</td>';
                                        html = html + '<td class="column center eliminarDato"><img width="16" onclick="Eliminar('+data.data[i].idsiq_formUnidadesAcademicasReconocimientosEstudiantes+', \'formUnidadesAcademicasReconocimientosEstudiantes\',\'updateDataReconocimientos\')" title="Eliminar Dato" src="../../images/Close_Box_Red.png" style="cursor:pointer;"></td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                    }
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="3" class="center">No se encontraron datos.</td></tr>');
                            }                         
                      });
                      
                }
            }
        </script>
</div>
    
<div id="tabs-21" class="formsHuerfanos">
      <div class="formModalidad">
                     <?php include($rutaModalidad); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect();  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  
                ?>
                <div class="consultar" title="" onmouseover="botonconsultar(this)">
                <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                </div>
                <div class="vacio"></div>
     
        <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Participación de estudiantes en la evaluación de la Investigación formativa</span></th>                                    
                        </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
                </table>  
                
                <script type="text/javascript">
                    
                    $(document).on('change', "#tabs-21 .modalidad", function(){
                    getCarreras("#tabs-21");
                    changeFormModalidad("#tabs-21");
                });
                
                $(document).on('change', "#tabs-21 .unidadAcademica", function(){
                    changeFormModalidad("#tabs-21");
                });
            
            
            $('#tabs-21 .consultar').bind('click', function(event) {
                    getData21();
                });   
                
                function getData21(){
                    var name = "#tabs-21";
                if($(name + ' .unidadAcademica').val()=="" || $(name + ' #mes').val()=="" || $(name + ' #anio').val()==""){
                    $(name + ' tbody').html("");
                } else {
                    html = "";                    
                    var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                     var promise = getData(name,'formUnidadesAcademicasEstudiantesInvestigacion',periodo,"codigoperiodo");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true){   
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column borderR">Estudiantes que realizaron evaluación de la Investigación formativa</td>';
                                        html = html + '<td class="column center">'+data.data.numEstudiantes+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                       
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="2" class="center">No se encontraron datos.</td></tr>');
                            }                         
                      });
                      
                }
                }
           
            
        </script>
</div>
    
<div id="tabs-14" class="formsHuerfanos">
      <div class="formModalidad">
                     <?php include($rutaModalidad); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect();  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  
                ?>
                <div class="consultar" title="" onmouseover="botonconsultar(this)">
                <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                </div>
                <div class="vacio"></div>
     
        <table align="center" class="formData last" width="92%" >
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
                
                <script type="text/javascript">
                    $(document).on('change', "#tabs-14 .modalidad", function(){
                    getCarreras("#tabs-14");
                    changeFormModalidad("#tabs-14");
                });
                
                $(document).on('change', "#tabs-14 .unidadAcademica", function(){
                    changeFormModalidad("#tabs-14");
                });
            
            
            $('#tabs-14 .consultar').bind('click', function(event) {
                    getData14();
                });   
                
                function getData14(){
                    var name = "#tabs-14";
                if($(name + ' .unidadAcademica').val()=="" || $(name + ' #mes').val()=="" || $(name + ' #anio').val()==""){
                    $(name + ' tbody').html("");
                } else {
                    html = "";                    
                    var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                     var promise = getData(name,'formUnidadesAcademicasProyectosConsultoria',periodo,"codigoperiodo");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true){   
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column">Consultorías aprobados</td>';
                                        html = html + '<td class="column center">'+data.data.numAprobadas+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column">Consultorías en ejecución</td>';
                                        html = html + '<td class="column center">'+data.data.numEjecucion+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                       
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="2" class="center">No se encontraron datos.</td></tr>');
                            }                         
                      });
                      
                }
                }
                    
        </script>
</div>
    
    <div id="tabs-15" class="formsHuerfanos">
     
         <div class="formModalidad">
                     <?php include($rutaModalidad); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db,"codigoperiodo");  
                      //$sectores = $utils->getActives($db,"siq_tipoActividadAcademicos","nombre");
                    //$categoriasPadres = $utils->getAll($db,"siq_tipoProductoInvestigacion","productoPadre=0 AND codigoestado=100","nombre"); 
                ?>
                <div class="consultar" title="" onmouseover="botonconsultar(this)">
                <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                </div>
                <div class="vacio"></div>
                
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
        <script type="text/javascript">
            $(document).on('change', "#tabs-15 .modalidad", function(){
                    getCarreras("#tabs-15");
                    changeFormModalidad("#tabs-15");
                });
                
                $(document).on('change', "#tabs-15 .unidadAcademica", function(){
                    changeFormModalidad("#tabs-15");
                });
            
            
            $('#tabs-15 .consultar').bind('click', function(event) {
                    getData15();
                });   
                
                function getData15(){
                    var name = "#tabs-15";
                if($(name + ' .unidadAcademica').val()=="" || $(name + ' #codigoperiodo').val()=="" ){
                    $(name + ' tbody').html("");
                } else {
                    html = "";                    
                    var periodo = $(name + ' #codigoperiodo').val();
                     var promise = getDataDynamic(name,'formUnidadesAcademicasActividadesAcademicos',periodo,"codigoperiodo","siq_tipoActividadAcademicos");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true){
                                var total1 = 0;
                                var total2 = 0;
                                 for (var i=0;i<data.total;i++)
                                    {     
                                        total1 = total1 + parseInt(data.data[i].numHoras);   
                                        total2 = total2 + parseInt(data.data[i].numAcademicosTCE);          
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column borderR">'+data.data[i].nombre+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numHoras+'</td>';
                                        html = html + '<td class="column center">'+data.data[i].numAcademicosTCE+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                    }
                                    
                                    html = '<tr class="dataColumns">';
                                    html = html + '<th class="column total right borderR"><span>Total</span></th>"';
                                    html = html + '<th class="column total center">'+total1+'</th>"';         
                                    html = html + '<th class="column total center">'+total2+'</th>"';                                 
                                    html = html + '</tr>';
                                    $(name + ' tbody').append(html);
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="3" class="center">No se encontraron datos.</td></tr>');
                            }                         
                      });
                      
                }
                }
            
        </script>
</div>
   <?php /* 
<div id="tabs-16" class="formsHuerfanos">
      <div class="formModalidad">
                     <?php 
					 include($rutaModalidad); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect();  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  
                ?>
                <div class="consultar" title="" onmouseover="botonconsultar(this)">
                <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                </div>
                <div class="vacio"></div>
     
        <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Descripción de Otras unidades Bibliográficas y de información de las Unidades Académicas</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" ><span>Unidad de Bibliografía y de Información </span></th> 
                            <th class="column borderR" ><span>Descripción</span></th> 
                            <th class="column" ><span>Opciones</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
                </table>  
                
                <script type="text/javascript">
                    
                    $(document).on('change', "#tabs-16 .modalidad", function(){
                    getCarreras("#tabs-16");
                    changeFormModalidad("#tabs-16");
                });
                
                $(document).on('change', "#tabs-16 .unidadAcademica", function(){
                    changeFormModalidad("#tabs-16");
                });
            
            
            $('#tabs-16 .consultar').bind('click', function(event) {
                    //alert("hola 1");
                    updateDataBibliografias();
                });   
            
        function updateDataBibliografias(){
                var name = "#tabs-16";
                //alert("hola");
                if($(name + ' .unidadAcademica').val()=="" || $(name + ' #mes').val()=="" || $(name + ' #anio').val()==""){
                    $(name + ' tbody').html("");
                } else {
                    html = "";                    
                    var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                     var promise = getData2(name,'formUnidadesAcademicasUnidadesBibliograficas',periodo,"codigoperiodo");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true){
                                 for (var i=0;i<data.total;i++)
                                    {       
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column borderR">'+data.data[i].nombre+'</td>';
                                        html = html + '<td class="column borderR">'+data.data[i].descripcion+'</td>';
                                        html = html + '<td class="column center eliminarDato"><img width="16" onclick="Eliminar('+data.data[i].idsiq_formUnidadesAcademicasUnidadesBibliograficas+', \'formUnidadesAcademicasUnidadesBibliograficas\',\'updateDataBibliografias\')" title="Eliminar Dato" src="../../images/Close_Box_Red.png" style="cursor:pointer;"></td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                    }
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="3" class="center">No se encontraron datos.</td></tr>');
                            }                         
                      });
                      
                }
            }
            
        </script>
</div>
    */ ?>
<div id="tabs-17" class="formsHuerfanos">
<?php
      $tipoUsoLab = $db->GetAll("select nombre,idsiq_tipoUsoLaboratorio as id from siq_tipoUsoLaboratorio WHERE codigoestado=100 ORDER BY nombre ASC");
      $js_tipoUsoLab = json_encode($tipoUsoLab);
?>

      <div class="formModalidad">
                     <?php include($rutaModalidad); ?>
                </div>
                
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
                            <th class="column" colspan="6"><span>Laboratorios, Talleres, Museos, etc</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" ><span>Nombre del (Laboratorio, taller, Museo, etc)</span></th> 
                            <th class="column borderR" ><span>Cantidad</span></th> 
                            <th class="column borderR" ><span>Capacidad <br/>(número de puestos para estudiantes)</span></th> 
                            <th class="column borderR" ><span>Observaciones</span></th> 
                            <th class="column borderR" ><span>Tipo de Utilización</span></th> 
                            <th class="column" ><span>Opciones</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
                </table>  
                
                <script type="text/javascript">
                    
                    $(document).on('change', "#tabs-17 .modalidad", function(){
                    getCarreras("#tabs-17");
                    changeFormModalidad("#tabs-17");
                });
                
                $(document).on('change', "#tabs-17 .unidadAcademica", function(){
                    changeFormModalidad("#tabs-17");
                });
            
            
            $('#tabs-17 .consultar').bind('click', function(event) {
                    updateDataLaboratorios();
                });   
                
                
            function updateDataLaboratorios(){
                <?php echo "var tipoUsoLab_array = ". $js_tipoUsoLab .";\n" ?>
                tipoUsoLab_array = convertArray(tipoUsoLab_array);

                var name = "#tabs-17";
                if($(name + ' .unidadAcademica').val()=="" || $(name + ' #codigoperiodo').val()==""){
                    $(name + ' tbody').html("");
                } else {
                    html = "";                    
                    var periodo = $(name + ' #codigoperiodo').val();
                     var promise = getData2(name,'formUnidadesAcademicasLaboratorios',periodo,"codigoperiodo");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true){
                                 for (var i=0;i<data.total;i++)
                                    {       
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column borderR">'+data.data[i].nombre+'</td>';
                                        html = html + '<td class="column center borderR">'+data.data[i].numLaboratorios+'</td>';
                                        html = html + '<td class="column center borderR">'+data.data[i].capacidad+'</td>';
                                        html = html + '<td class="column borderR">'+data.data[i].observaciones+'</td>';
										if(data.data[i].idsiq_tipoUsoLaboratorio==null){
											html = html + '<td class="column borderR"></td>';
										} else {
											html = html + '<td class="column borderR">'+tipoUsoLab_array[data.data[i].idsiq_tipoUsoLaboratorio]+'</td>';
										}
                                        html = html + '<td class="column center eliminarDato"><img width="16" onclick="Eliminar('+data.data[i].idsiq_formUnidadesAcademicasLaboratorios+', \'formUnidadesAcademicasLaboratorios\',\'updateDataLaboratorios\')" title="Eliminar Dato" src="../../images/Close_Box_Red.png" style="cursor:pointer;"></td>';
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
   
<div id="tabs-18" class="formsHuerfanos">
      <div class="formModalidad">
                     <?php include($rutaModalidad); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect();  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  
                ?>
                <div class="consultar" title="" onmouseover="botonconsultar(this)">
                <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                </div>
                <div class="vacio"></div>
     
        <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Equipos de cómputo disponibles para los académicos</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Dedicación</span></th> 
                            <th class="column" ><span>Equipos de computo</span></th> 
                            <th class="column" ><span>Total académicos con dedicación</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
                </table>  
                
                <script type="text/javascript">
                    
                    $(document).on('change', "#tabs-18 .modalidad", function(){
                    getCarreras("#tabs-18");
                    changeFormModalidad("#tabs-18");
                });
                
                $(document).on('change', "#tabs-18 .unidadAcademica", function(){
                    changeFormModalidad("#tabs-18");
                });
            
            
            $('#tabs-18 .consultar').bind('click', function(event) {
                    getData18();
                });   
                
                function getData18(){
                    var name = "#tabs-18";
                if($(name + ' .unidadAcademica').val()=="" || $(name + ' #mes').val()=="" || $(name + ' #anio').val()==""){
                    $(name + ' tbody').html("");
                } else {
                    html = "";                    
                    var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                     var promise = getData(name,'formUnidadesAcademicasEquiposComputo',periodo,"codigoperiodo");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true){   
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column">Tiempo completo</td>';
                                        html = html + '<td class="column center">'+data.data.numEquiposTC+'</td>';
                                        html = html + '<td class="column center">'+data.data.numAcademicosTC+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column">Medio tiempo</td>';
                                        html = html + '<td class="column center">'+data.data.numEquiposMT+'</td>';
                                        html = html + '<td class="column center">'+data.data.numAcademicosMT+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                       
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="3" class="center">No se encontraron datos.</td></tr>');
                            }                         
                      });
                      
                }
                }
        </script>
</div>
    
<div id="tabs-22" class="formsHuerfanos">
      <div class="formModalidad">
                     <?php include($rutaModalidad); ?>
                </div>
                
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
                            <th class="column" colspan="4"><span>Número de redes y asociaciones Institucionales</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2" ><span>Redes y Asociaciones</span></th> 
                            <th class="column borderR" colspan="2"><span>Ámbito</span></th> 
                            <th class="column" rowspan="2" ><span>Opciones</span></th> 
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" ><span>Nacional</span></th> 
                            <th class="column borderR"><span>Internacional</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
                </table>  
                
                <script type="text/javascript">
                    
                    $(document).on('change', "#tabs-22 .modalidad", function(){
                    getCarreras("#tabs-22");
                    changeFormModalidad("#tabs-22");
                });
                
                $(document).on('change', "#tabs-22 .unidadAcademica", function(){
                    changeFormModalidad("#tabs-22");
                });
            
            
            $('#tabs-22 .consultar').bind('click', function(event) {
                    updateDataRedes();
                });   
            
            function updateDataRedes(){
                var name = "#tabs-22";
                if($(name + ' .unidadAcademica').val()=="" || $(name + ' #codigoperiodo').val()==""){
                    $(name + ' tbody').html("");
                } else {
                    html = "";                    
                    var periodo = $(name + ' #codigoperiodo').val();
                     var promise = getData2(name,'formUnidadesAcademicasRedes',periodo,"codigoperiodo");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true){
                                 for (var i=0;i<data.total;i++)
                                    {       
                                        
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column borderR">'+data.data[i].nombre+'</td>';
                                        html = html + '<td class="column center borderR">'+data.data[i].numNacional+'</td>';
                                        html = html + '<td class="column center borderR">'+data.data[i].numInternacional+'</td>';
                                        html = html + '<td class="column center eliminarDato"><img width="16" onclick="Eliminar('+data.data[i].idsiq_formUnidadesAcademicasRedes+', \'formUnidadesAcademicasRedes\',\'updateDataRedes\')" title="Eliminar Dato" src="../../images/Close_Box_Red.png" style="cursor:pointer;"></td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                    }
                            }
                            else{  
                                $(name + ' tbody').html('<tr><td colspan="4" class="center">No se encontraron datos.</td></tr>');
                            }                         
                      });
                      
                }
            }
        </script>
</div>
    
</div> <!--- tabs -->
