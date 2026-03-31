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
        
        function getDataDynamic(formName,entity,periodo,campoPeriodo,entityJoin){
             return  $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/docentes/saveTalentoHumano.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: entity, campoPeriodo: campoPeriodo,entityJoin: entityJoin },     
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
         }
         
         function getData(formName,entity,periodo,campoPeriodo){
             return  $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/docentes/saveTalentoHumano.php',
                            data: { periodo: periodo, action: "getData", entity: entity, campoPeriodo: campoPeriodo },     
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
         }
                
                
</script>
<div id="tabs" class="dontCalculate">
				<ul>
					<li class="tab0"><a href="#tabs-1">Grupos de investigación  </a></li>
					<li class="tab1"><a href="#tabs-2">Relación Grupos Universidad / nacional</a></li>
					<li class="tab3"><a href="#tabs-4">Proyectos de Investigación<br/>(convocatorias internas)</a></li>
					<li class="tab4"><a href="#tabs-5">Financiación de proyectos a<br/>través de entidades externas</a></li>
					<li class="tab5"><a href="#tabs-6">Proyectos presentados y aprobados en Colciencias</a></li>
				</ul>
				
<div id="tabs-1" class="formsHuerfanos">
         <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("codigoperiodo");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>
     <table align="center" class="formData viewData" width="100%" >         
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Grupos de investigación</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Grupos UEB reconocidos COLCIENCIAS</span></th> 
                            <th class="column" ><span>Grupos avalados por la<br/>UEB sin reconocimiento</span></th> 
                        </tr>
                    </thead>
                    <tbody>            
                    </tbody>
                </table>   
    
     <script type="text/javascript">
                $('#tabs-1 .consultar').bind('click', function(event) {
                    getData1("#tabs-1");
                });            
                
                function getData1(name){
                    html = "";                    
                        var periodo = $(name + ' #codigoperiodo').val();
                        var promise = getData(name,'formInvestigacionesGruposInvestigacion',periodo,"codigoperiodo");
                        promise.success(function (data) {
                            $(name + ' tbody').html('');
                            //console.log(data);
                            if (data.success == true){     

                                            html = '<tr class="dataColumns">';
                                            html = html + '<td class="column center borderR">'+data.data.numColciencias+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numUEB+'</td>';
                                            html = html + '</tr>';
                                            $(name + ' tbody').append(html);
                                }
                                else{  
                                    $(name + ' tbody').html('<tr><td colspan="2" class="center">No se encontraron datos.</td></tr>');
                                }                         
                        });
                }

            </script>
    
</div><!-- tab 1-->	

<div id="tabs-2" class="formsHuerfanos">
         <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("codigoperiodo");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>
     <table align="center" class="formData viewData" width="100%" >         
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Grupos de investigación</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Grupos Investigación UEB<br/>a nivel Nacional</span></th> 
                            <th class="column" ><span>Grupos de investigación de las <br> IES reconocidos por COLCIENCIAS</span></th> 
                        </tr>
                    </thead>
                    <tbody>            
                    </tbody>
                </table>   
    
     <script type="text/javascript">
                $('#tabs-2 .consultar').bind('click', function(event) {
                    getData2("#tabs-2");
                });            
                
                function getData2(name){
                    html = "";                    
                        var periodo = $(name + ' #codigoperiodo').val();
                        var promise = getData(name,'formInvestigacionesGruposInvestigacion',periodo,"codigoperiodo");
                        promise.success(function (data) {
                            $(name + ' tbody').html('');
                            //console.log(data);
                            if (data.success == true){     

                                            html = '<tr class="dataColumns">';
                                            html = html + '<td class="column center borderR">'+data.data.numUniversidadColciencias+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numTotalColciencias+'</td>';
                                            html = html + '</tr>';
                                            $(name + ' tbody').append(html);
                                }
                                else{  
                                    $(name + ' tbody').html('<tr><td colspan="2" class="center">No se encontraron datos.</td></tr>');
                                }                         
                        });
                }

            </script>
    
</div><!-- tab 2-->	

<div id="tabs-4" class="formsHuerfanos">
         <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("codigoperiodo");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>
     <table align="center" class="formData viewData" width="100%" >         
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="5"><span>Proyectos de Investigación aprobados en las CONVOCATORIAS INTERNAS</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2" ><span>Carácter</span></th> 
                            <th class="column borderR" colspan="3"><span>Número de proyectos</span></th> 
                            <th class="column borderR" rowspan="2"><span>Valor ($)</span></th> 
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" ><span>Presentados</span></th> 
                            <th class="column borderR" ><span>Aprobados</span></th> 
                            <th class="column borderR"><span>Finalizados</span></th> 
                        </tr>
                    </thead>
                    <tbody>            
                    </tbody>
                </table>   
    
     <script type="text/javascript">
                $('#tabs-4 .consultar').bind('click', function(event) {
                    getData4("#tabs-4");
                });            
                
                function getData4(name){
                    html = "";                    
                        var periodo = $(name + ' #codigoperiodo').val();
                        var promise = getDataDynamic(name,'formInvestigacionesProyectosInternos',periodo,"codigoperiodo",
						"siq_caracteresConvocatorias");
                        promise.success(function (data) {
                            $(name + ' tbody').html('');
                            //console.log(data);
                            if (data.success == true){     
									for (var i=0;i<data.total;i++)
									{                     
                                            html = '<tr class="dataColumns">';
                                            html = html + '<td class="column center borderR">'+data.data[i].nombre+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data[i].numPresentados+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data[i].numAprobados+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data[i].numFinalizados+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data[i].valor+'</td>';
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
    
</div><!-- tab 4-->	

<div id="tabs-5" class="formsHuerfanos">
         <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("codigoperiodo");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>
     <table align="center" class="formData viewData" width="100%" >         
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="5"><span>Financiación de proyectos a través de ENTIDADES EXTERNAS</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2" ><span>Carácter</span></th> 
                            <th class="column borderR" colspan="3"><span>Número de proyectos</span></th> 
                            <th class="column borderR" rowspan="2"><span>Valor ($)</span></th> 
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" ><span>Presentados</span></th> 
                            <th class="column borderR" ><span>Aprobados</span></th> 
                            <th class="column borderR"><span>Finalizados</span></th> 
                        </tr>
                    </thead>
                    <tbody>            
                    </tbody>
                </table>   
    
     <script type="text/javascript">
                $('#tabs-5 .consultar').bind('click', function(event) {
                    getData5("#tabs-5");
                });            
                
                function getData5(name){
                    html = "";                    
                        var periodo = $(name + ' #codigoperiodo').val();
                        var promise = getDataDynamic(name,'formInvestigacionesProyectosExternos',periodo,"codigoperiodo",
						"siq_caracteresConvocatorias");
                        promise.success(function (data) {
                            $(name + ' tbody').html('');
                            //console.log(data);
                            if (data.success == true){     
									for (var i=0;i<data.total;i++)
									{                     
                                            html = '<tr class="dataColumns">';
                                            html = html + '<td class="column center borderR">'+data.data[i].nombre+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data[i].numPresentados+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data[i].numAprobados+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data[i].numFinalizados+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data[i].valor+'</td>';
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
    
</div><!-- tab 5-->	

<div id="tabs-6" class="formsHuerfanos">
         <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("codigoperiodo");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>
     <table align="center" class="formData viewData" width="100%" >         
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Proyectos presentados y aprobados en Colciencias</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Tipo de proyectos</span></th> 
                            <th class="column" ><span>No. de Proyectos</span></th> 
                        </tr>
                    </thead>
                    <tbody>            
                    </tbody>
                </table>   
    
     <script type="text/javascript">
                $('#tabs-6 .consultar').bind('click', function(event) {
                    getData6("#tabs-6");
                });            
                
                function getData6(name){
                    html = "";                    
                        var periodo = $(name + ' #codigoperiodo').val();
                        var promise = getData(name,'formInvestigacionesProyectosColciencias',periodo,"codigoperiodo");
                        promise.success(function (data) {
                            $(name + ' tbody').html('');
                            //console.log(data);
                            if (data.success == true){     

                                            html = '<tr class="dataColumns">';
                                            html = html + '<td class="column center borderR">Número de proyectos presentados por la Institución a COLCIENCIAS</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numProyectosPresentados+'</td>';
                                            html = html + '</tr>';
                                            $(name + ' tbody').append(html);
											
                                            html = '<tr class="dataColumns">';
                                            html = html + '<td class="column center borderR">Número de proyectos presentados a COLCIENCIAS a nivel Nacional</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numProyectosPresentadosColciencias+'</td>';
                                            html = html + '</tr>';
                                            $(name + ' tbody').append(html);
                                            html = '<tr class="dataColumns">';
                                            html = html + '<td class="column center borderR">Número de proyectos aprobados por COLCIENCIAS de la Institución</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numProyectosAprobados+'</td>';
                                            html = html + '</tr>';
                                            $(name + ' tbody').append(html);
                                            html = '<tr class="dataColumns">';
                                            html = html + '<td class="column center borderR">Número de proyectos aprobados por COLCIENCIAS a nivel Nacional</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numProyectosAprobadosColciencias+'</td>';
                                            html = html + '</tr>';
                                            $(name + ' tbody').append(html);
                                }
                                else{  
                                    $(name + ' tbody').html('<tr><td colspan="2" class="center">No se encontraron datos.</td></tr>');
                                }                         
                        });
                }

            </script>
    
</div><!-- tab 6-->	
				
</div>