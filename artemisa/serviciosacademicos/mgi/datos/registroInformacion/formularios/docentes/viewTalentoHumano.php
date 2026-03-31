<?php         

    //$records = $utils->getDataForm($db,"siq_formTalentoHumanoNumeroPersonas","codigoperiodo");
    //$recordsPrestacion = $utils->getDataFormCategory($db,"siq_formTalentoHumanoPersonalPrestacionServicios","codigoperiodo","siq_actividadPrestacionServicios","idActividad");
    //$recordsPrestamos = $utils->getDataForm($db,"siq_formTalentoHumanoPrestamosCondonables","codigoperiodo");
    //$recordsApoyos = $utils->getDataForm($db,"siq_formTalentoHumanoApoyosEconomicos","codigoperiodo");
    //$recordsIndices = $utils->getDataFormCategory($db,"siq_formTalentoIndiceSelectividad","codigoperiodo","siq_dedicacionPersonal","idDedicacion");
    //$recordsDesvinculados = $utils->getDataForm($db,"siq_formTalentoHumanoAcademicosDesvinculados","codigoperiodo");
    //$recordsExtranjerosFacultad = $utils->getDataFormCategoryDynamic($db,"formTalentoHumanoAcademicosExtranjerosFacultad","codigoperiodo","facultad","nombrefacultad",false);
    //$recordsExtranjerosPais = $utils->getDataFormCategoryDynamic($db,"formTalentoHumanoAcademicosExtranjerosPais","codigoperiodo","pais","nombrepais");
    /*$pais = $db->GetAll("SELECT nombrepais as nombre,idpais as id FROM pais ORDER BY nombrepais ASC"); 
    $js_pais = json_encode($pais);
    //$facultades = $db->GetAll("SELECT nombrefacultad as nombre,codigofacultad as id FROM facultad ORDER BY nombrefacultad ASC"); 
	$facultades = $db->GetAll("SELECT nombre,idsiq_unidadAdministrativa as id FROM siq_unidadAdministrativa ORDER BY nombre ASC"); 
    $js_facultades = json_encode($facultades);*/
    $num = count($records);   
?>



<script type="text/javascript">
	$(function() {
            
		$( "#tabs" ).tabs({
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
        
        function getDataDynamic(formName,entity,periodo,campoPeriodo,entityJoin,campoJoin,order){
             return  $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/docentes/saveTalentoHumano.php',
                            data: { periodo: periodo, action: "getDataDynamic", entity: entity, campoPeriodo: campoPeriodo,entityJoin: entityJoin,campoJoin:campoJoin,order:order },     
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
         }
         
         function getDataDynamic2(formName,entity,periodo,campoPeriodo,entityJoin,campoJoin,campoOrdenar){
             return  $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/docentes/saveTalentoHumano.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: entity, campoPeriodo: campoPeriodo,entityJoin: entityJoin,joinField:campoJoin, order: campoOrdenar },     
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
                
         function getDataForm2(formName,entity,periodo,campoPeriodo){
             return  $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getData2", entity: entity, campoPeriodo: campoPeriodo },     
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
         } 
         
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
</script>
<div id="tabs" class="dontCalculate">
				<ul>
					<li class="tab0"><a href="#tabs-1">Número de Personas</a></li>
					<li class="tab1"><a href="#tabs-8">Docentes por Vinculación</a></li>
					<li class="tab2"><a href="#tabs-9">Docentes por dedicación de tiempo</a></li>
					<li class="tab3"><a href="#tabs-10">Docentes por escalafón docente</a></li>
					<li class="tab4"><a href="#tabs-2">Docentes por nivel de Formación  </a></li>
					<li class="tab5"><a href="#tabs-11">Docentes por nivel de Formación<br/>(especializaciones médico – quirúrgicas)</a></li>
					<li class="tab6"><a href="#tabs-12">Docentes en Formación</a></li>
					<li class="tab7"><a href="#tabs-3">Personal por prestación de servicios</a></li>
					<li class="tab8"><a href="#tabs-4">Préstamos Condonables</a></li>
					<!--<li class="tab9"><a href="#tabs-5">Apoyos económicos </a></li>-->
                    <li class="tab10"><a href="#tabs-16">Índice de selectividad de los académicos</a></li>
					<li class="tab11"><a href="#tabs-15">Académicos Desvinculados</a></li>     
					<li class="tab12"><a href="#tabs-13">Académicos extranjeros por Programa Académico</a></li>      
					<li class="tab13"><a href="#tabs-14">Académicos extranjeros por país de origen</a></li>
					<li class="tab14"><a href="./formularios/docentes/viewTalentoHumanoEscalafonBosque.php">Dedicación Semanal Docentes<br>(Según Categorización Universidad El Bosque), por Escalafón</a></li>
					<li class="tab15"><a href="./formularios/docentes/viewTalentoHumanoEscalafonCNA.php">Dedicación Semanal Docentes<br>(Según Categorización CNA), por Escalafón</a></li>
					<!--<li><a href="#tabs-20">Profesores que cursan programas de idioma no materno</a></li>-->
                                        <li><a href="../reportes/reportes/docentes/viewReporteDedicacionBosquePorNivelFormacion.php">Dedicación Semanal Docentes<br>(Según categorización Universidad El Bosque), por Mayor Nivel de Formación</a></li>
                                        <li><a href="../reportes/reportes/docentes/viewReporteNumeroAcademicosBosquePorEstudio.php">Dedicación Semanal Docentes<br>(Según categorización Universidad El Bosque), por Estudios en Curso</a></li>
                                        <li><a href="../reportes/reportes/docentes/viewReporteDedicacionCNAPorNivelFormacion.php">Dedicación Semanal Docentes<br>(Según categorización del CNA), por Mayor Nivel de Formación</a></li>
                                        <li><a href="../reportes/reportes/docentes/viewReporteNumeroAcademicosCNAPorEstudio.php">Dedicación Semanal Docentes<br>(Según categorización del CNA), por Estudios en Curso</a></li>
                                        <li><a href="#tabs-17">Dedicación de los Académicos por Actividades</a></li>
					
				</ul>
<div id="tabs-1" class="formsHuerfanos">
         <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                    <?php $utils->getMonthsSelect(); ?>

                    <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                    <?php $utils->getYearsSelect("anio");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>
     <table align="center" class="formData viewData" width="100%" >         
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Número de Personas</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Académicos</span></th> 
                            <th class="column" ><span>Administrativos</span></th> 
                            <th class="column" ><span>Total</span></th> 
                        </tr>
                    </thead>
                    <tbody>                        
                        <?php /*for ($i = 0; $i < $num; $i++) { ?>
                            <tr class="dataColumns">
                                <td class="column center"><?php echo $records[$i]["codigoperiodo"]; ?></td>
                                <td class="column center"><?php echo $records[$i]["numAcademicos"]; ?></td>
                                <td class="column center"><?php echo $records[$i]["numAdministrativos"]; ?></td>
                                <td class="column center"><?php echo ($records[$i]["numAdministrativos"]+$records[$i]["numAcademicos"]); ?></td>
                            </tr>
                        <?php }*/ ?>
                    </tbody>
                </table>   
    
     <script type="text/javascript">
                $('#tabs-1 .consultar').bind('click', function(event) {
                    getData1("#tabs-1");
                });            
                
                function getData1(name){
                    html = "";                    
                        var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                        var promise = getData(name,'formTalentoHumanoNumeroPersonas',periodo,"codigoperiodo");
                        promise.success(function (data) {
                            $(name + ' tbody').html('');
                            //console.log(data);
                            if (data.success == true){ 
                                            totalSalud = parseInt(data.data.numAcademicos);                                        
                                            totalCalidad = parseInt(data.data.numAdministrativos);       

                                            html = '<tr class="dataColumns">';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicos+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAdministrativos+'</td>';
                                            html = html + '<td class="column center">'+(totalSalud+totalCalidad)+'</td>';
                                            html = html + '</tr>';
                                            $(name + ' tbody').append(html);
                                }
                                else{  
                                    $(name + ' tbody').html('<tr><td colspan="3" class="center">No se encontraron datos.</td></tr>');
                                }                         
                        });
                }

            </script>
    
</div><!-- tab 1-->
    
    <div id="tabs-8" class="formsHuerfanos">
         <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                    <?php $utils->getMonthsSelect(); ?>

                    <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                    <?php $utils->getYearsSelect("anio");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>
                  
               <table align="center" class="formData viewData" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="4"><span>Docentes por Vinculación</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Académicos Adjuntos (semestral)</span></th> 
                            <th class="column" ><span>Académicos (11 meses)</span></th> 
                            <th class="column" ><span>Núcleo Académico (núcleo profesoral)</span></th> 
                            <th class="column" ><span>Total</span></th> 
                        </tr>
                     </thead>
                     <tbody>        
                    </tbody>
                </table> 
              <script type="text/javascript">
                $('#tabs-8 .consultar').bind('click', function(event) {
                    getData8("#tabs-8");
                });            
                
                function getData8(name){
                    html = "";                    
                        var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                        var promise = getData(name,'formTalentoHumanoNumeroPersonas',periodo,"codigoperiodo");
                        promise.success(function (data) {
                            $(name + ' tbody').html('');
                            //console.log(data);
                            if (data.success == true){ 
                                            totalSalud = parseInt(data.data.numAcademicosSemestral);                                        
                                            totalSalud += parseInt(data.data.numAcademicosAnual);                                   
                                            totalSalud += parseInt(data.data.numAcademicosNucleoProfesoral);      

                                            html = '<tr class="dataColumns">';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosSemestral+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosAnual+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosNucleoProfesoral+'</td>';
                                            html = html + '<td class="column center">'+(totalSalud)+'</td>';
                                            html = html + '</tr>';
                                            $(name + ' tbody').append(html);
                                }
                                else{  
                                    $(name + ' tbody').html('<tr><td colspan="4" class="center">No se encontraron datos.</td></tr>');
                                }                         
                        });
                }

            </script> 
</div><!-- tabs 8 -->
    
    <div id="tabs-9" class="formsHuerfanos">
         <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                    <?php $utils->getMonthsSelect(); ?>

                    <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                    <?php $utils->getYearsSelect("anio");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>
     
                
                <table align="center" class="formData viewData last" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="5"><span>Docentes por dedicación de tiempo</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Tiempo Completo</span></th> 
                            <th class="column" ><span>3/4 de Tiempo</span></th> 
                            <th class="column" ><span>1/2 Tiempo</span></th> 
                            <th class="column" ><span>1/4 de Tiempo</span></th> 
                            <th class="column" ><span>Total</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                    </tbody>
                </table>
                    
              <script type="text/javascript">
                $('#tabs-9 .consultar').bind('click', function(event) {
                    getData9("#tabs-9");
                });            
                
                function getData9(name){
                    html = "";                    
                        var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                        var promise = getData(name,'formTalentoHumanoNumeroPersonas',periodo,"codigoperiodo");
                        promise.success(function (data) {
                            $(name + ' tbody').html('');
                            //console.log(data);
                            if (data.success == true){ 
                                            totalSalud = parseInt(data.data.numAcademicosTC);                                        
                                            totalSalud += parseInt(data.data.numAcademicos34T);                                   
                                            totalSalud += parseInt(data.data.numAcademicosMT);                                    
                                            totalSalud += parseInt(data.data.numAcademicos14T);     

                                            html = '<tr class="dataColumns">';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosTC+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicos34T+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosMT+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicos14T+'</td>';
                                            html = html + '<td class="column center">'+(totalSalud)+'</td>';
                                            html = html + '</tr>';
                                            $(name + ' tbody').append(html);
                                }
                                else{  
                                    $(name + ' tbody').html('<tr><td colspan="5" class="center">No se encontraron datos.</td></tr>');
                                }                         
                        });
                }

            </script> 
                    
</div><!-- tabs 9 -->
    
    <div id="tabs-10" class="formsHuerfanos">
         <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                    <?php $utils->getMonthsSelect(); ?>

                    <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                    <?php $utils->getYearsSelect("anio");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>
     
                
                <table align="center" class="formData viewData last" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="7"><span>Docentes por escalafón docente</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Instructor asistente</span></th> 
                            <th class="column" ><span>Instructor Asociado</span></th> 
                            <th class="column" ><span>Profesor Asistente</span></th> 
                            <th class="column" ><span>Profesor Asociado</span></th> 
                            <th class="column" ><span>Profesor Titular</span></th> 
                            <th class="column" ><span>Otros</span></th> 
                            <th class="column" ><span>Total</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                    </tbody>
                </table>
                    
                     <script type="text/javascript">
                $('#tabs-10 .consultar').bind('click', function(event) {
                    getData10("#tabs-10");
                });            
                
                function getData10(name){
                    html = "";                    
                        var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                        var promise = getData(name,'formTalentoHumanoDocentesEscalafon',periodo,"codigoperiodo");
                        promise.success(function (data) {
                            $(name + ' tbody').html('');
                            //console.log(data);
                            if (data.success == true){ 
                                            totalSalud = parseInt(data.data.numAcademicosIAsistente);                                        
                                            totalSalud += parseInt(data.data.numAcademicosIAsociado);                                   
                                            totalSalud += parseInt(data.data.numAcademicosPAsistente);                                    
                                            totalSalud += parseInt(data.data.numAcademicosPAsociado);                                 
                                            totalSalud += parseInt(data.data.numAcademicosPTitular);                                  
                                            totalSalud += parseInt(data.data.numAcademicosOtros);      

                                            html = '<tr class="dataColumns">';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosIAsistente+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosIAsociado+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosPAsistente+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosPAsociado+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosPTitular+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosOtros+'</td>';
                                            html = html + '<td class="column center">'+(totalSalud)+'</td>';
                                            html = html + '</tr>';
                                            $(name + ' tbody').append(html);
                                }
                                else{  
                                    $(name + ' tbody').html('<tr><td colspan="7" class="center">No se encontraron datos.</td></tr>');
                                }                         
                        });
                }

            </script> 
</div><!--- tabs 10 -->
    
    <div id="tabs-2" class="formsHuerfanos">
         <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                    <?php $utils->getMonthsSelect(); ?>

                    <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                    <?php $utils->getYearsSelect("anio");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>
     
                
                <table align="center" class="formData viewData last" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="8"><span>Docentes por nivel de Formación</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>T. Doctorado</span></th> 
                            <th class="column" ><span>T. Maestría</span></th> 
                            <th class="column" ><span>T. Especialización</span></th> 
                            <th class="column" ><span>T. Profesional</span></th>                             
                            <th class="column" ><span>T. Licenciado</span></th> 
                            <th class="column" ><span>T. Técnico/ Tecnólogo</span></th> 
                            <th class="column" ><span>Sin Titulo</span></th> 
                            <th class="column" ><span>Total</span></th> 
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
                        var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                        var promise = getData(name,'formTalentoHumanoDocentesFormacion',periodo,"codigoperiodo");
                        promise.success(function (data) {
                            $(name + ' tbody').html('');
                            //console.log(data);
                            if (data.success == true){ 
                                            totalSalud = parseInt(data.data.numAcademicosDoctorado);                                        
                                            totalSalud += parseInt(data.data.numAcademicosMaestria);                                   
                                            totalSalud += parseInt(data.data.numAcademicosEspecializacion);                                    
                                            totalSalud += parseInt(data.data.numAcademicosProfesional);                                 
                                            totalSalud += parseInt(data.data.numAcademicosTecnico);                                  
                                            totalSalud += parseInt(data.data.numAcademicosLicenciado);                              
                                            totalSalud += parseInt(data.data.numAcademicosNoTitulo);        

                                            html = '<tr class="dataColumns">';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosDoctorado+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosMaestria+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosEspecializacion+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosProfesional+'</td>';                                            
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosLicenciado+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosTecnico+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosNoTitulo+'</td>';
                                            html = html + '<td class="column center">'+(totalSalud)+'</td>';
                                            html = html + '</tr>';
                                            $(name + ' tbody').append(html);
                                }
                                else{  
                                    $(name + ' tbody').html('<tr><td colspan="8" class="center">No se encontraron datos.</td></tr>');
                                }                         
                        });
                }

            </script> 
</div><!-- tabs 2 -->
    
    <div id="tabs-11" class="formsHuerfanos">
         <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                    <?php $utils->getMonthsSelect(); ?>

                    <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                    <?php $utils->getYearsSelect("anio");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>
     
                
                <table align="center" class="formData viewData last" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="8"><span>Docentes por nivel de formación <br/>(especializaciones médico – quirúrgicas)</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>T. Doctorado</span></th> 
                            <th class="column" ><span>T. Maestría</span></th> 
                            <th class="column" ><span>T. Especialización</span></th> 
                            <th class="column" ><span>T. Profesional</span></th>                             
                            <th class="column" ><span>T. Licenciado</span></th> 
                            <th class="column" ><span>T. Técnico/ Tecnólogo</span></th> 
                            <th class="column" ><span>Sin Titulo</span></th> 
                            <th class="column" ><span>Total</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                    </tbody>
                </table>
         <script type="text/javascript">                
                $('#tabs-11 .consultar').bind('click', function(event) {
                    getData11("#tabs-11");
                });            
                
                function getData11(name){
                    html = "";                    
                        var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                        var promise = getData(name,'formTalentoHumanoDocentesFormacion',periodo,"codigoperiodo");
                        promise.success(function (data) {
                            $(name + ' tbody').html('');
                            //console.log(data);
                            if (data.success == true){ 
                                            totalSalud = parseInt(data.data.numAcademicosDoctoradoMedico);                                        
                                            totalSalud += parseInt(data.data.numAcademicosMaestriaMedico);                                   
                                            totalSalud += parseInt(data.data.numAcademicosEspecializacionMedico);                                    
                                            totalSalud += parseInt(data.data.numAcademicosProfesionalMedico);
                                            totalSalud += parseInt(data.data.numAcademicosLicenciadoMedico);
                                            totalSalud += parseInt(data.data.numAcademicosTecnicoMedico);                                  
                                            totalSalud += parseInt(data.data.numAcademicosNoTituloMedico);        

                                            html = '<tr class="dataColumns">';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosDoctoradoMedico+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosMaestriaMedico+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosEspecializacionMedico+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosProfesionalMedico+'</td>';                                            
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosLicenciadoMedico+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosTecnicoMedico+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosNoTituloMedico+'</td>';
                                            html = html + '<td class="column center">'+(totalSalud)+'</td>';
                                            html = html + '</tr>';
                                            $(name + ' tbody').append(html);
                                }
                                else{  
                                    $(name + ' tbody').html('<tr><td colspan="8" class="center">No se encontraron datos.</td></tr>');
                                }                         
                        });
                }

            </script>            
                    
</div><!-- tabs 11 -->
    
    <div id="tabs-12" class="formsHuerfanos">
         <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                    <?php $utils->getMonthsSelect(); ?>

                    <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                    <?php $utils->getYearsSelect("anio");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>
     
                
                <table align="center" class="formData viewData last" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="4"><span>Docentes en formación</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Doctorado</span></th> 
                            <th class="column" ><span>Maestría</span></th> 
                            <th class="column" ><span>Especialización</span></th> 
                            <th class="column" ><span>Total</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                    </tbody>
                </table>
                    
                     <script type="text/javascript">                
                $('#tabs-12 .consultar').bind('click', function(event) {
                    getData12("#tabs-12");
                });            
                
                function getData12(name){
                    html = "";                    
                        var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                        var promise = getData(name,'formTalentoHumanoDocentesFormacion',periodo,"codigoperiodo");
                        promise.success(function (data) {
                            $(name + ' tbody').html('');
                            //console.log(data);
                            if (data.success == true){ 
                                            totalSalud = parseInt(data.data.numAcademicosEnDoctorado);                                        
                                            totalSalud += parseInt(data.data.numAcademicosEnMaestria);                                   
                                            totalSalud += parseInt(data.data.numAcademicosEnEspecializacion);        

                                            html = '<tr class="dataColumns">';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosEnDoctorado+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosEnMaestria+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAcademicosEnEspecializacion+'</td>';
                                            html = html + '<td class="column center">'+(totalSalud)+'</td>';
                                            html = html + '</tr>';
                                            $(name + ' tbody').append(html);
                                }
                                else{  
                                    $(name + ' tbody').html('<tr><td colspan="4" class="center">No se encontraron datos.</td></tr>');
                                }                         
                        });
                }

            </script>  
</div><!-- tabs 12 -->
    
    
        <div id="tabs-3" class="longTable formsHuerfanos">
         <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                    <?php $utils->getMonthsSelect(); ?>

                    <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                    <?php $utils->getYearsSelect("anio");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>
                <table align="center" class="formData viewData last" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Personal por prestación de servicios</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" ><span>Actividad</span></th> 
                            <th class="column" ><span>Número de Personas</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                    </tbody>
                </table>
                    
                        <script type="text/javascript">                
                $('#tabs-3 .consultar').bind('click', function(event) {
                    getData3("#tabs-3");
                });            
                
                function getData3(name){
                    html = "";     
					var periodo		= null;			
                        $.ajax({
                        dataType: 'json',
						async: false,
                        type: 'POST',
                        url: './formularios/docentes/buscarSubperiodo.php',
                        data: { anio: $(name + ' #anio').val(), mes: $(name + ' #mes').val() },     
                        success:function(data){
                            if (data!=null && data.success == true){
                                 periodo = data.idSub;
                            } else {
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
							}
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });            
                    
                        var promise = getDataDynamic(name,'formTalentoHumanoPersonalPrestacionServicios',periodo,"idsubperiodo","siq_actividadPrestacionServicios","idActividad","ORDER BY nombre ASC");                      
                        promise.success(function (data) {
                            $(name + ' tbody').html('');
                            if (data.success == true){ 
							var totalSalud = 0;
							var total2 = 0;
                                           for (var i=0;i<data.total;i++)
                                            {     
                                                totalSalud = totalSalud + parseInt(data.data[i].numPersonas);     
                                                total2 = total2 + parseInt(data.data[i].valorServicios);         

                                                html = '<tr class="dataColumns">';
                                                html = html + '<td class="column borderR">'+data.data[i].nombre+'</td>';
                                                html = html + '<td class="column center">'+data.data[i].numPersonas+'</td>';
                                                html = html + '</tr>';
                                                $(name + ' tbody').append(html);
                                            }

                                            html = '<tr class="dataColumns">';
                                            html = html + '<th class="column total right borderR"><span>Total</span></th>"';
                                            html = html + '<th class="column total center">'+totalSalud+'</th>"';    
                                            html = html + '</tr>';
                                            $(name + ' tbody').append(html);											
											
											var promise2 = getData(name,'formTalentoHumanoPersonalPrestacionServiciosCostoServicios',periodo,"idsubperiodo");
											promise2.success(function (data) {
												//console.log(data);
												if (data.success == true){ 
																html = '<tr class="dataColumns">';
																html = html + '<th class="column center borderR"><span>Costo Total Mensual de los Servicios</span></th>';
																html = html + '<th class="column center borderR">'+FormatNumberBy3(data.data.costoServicios)+'</th>';
																html = html + '</tr>';
																$(name + ' tbody').append(html);
													}                        
											});
                                }
                                else{  
                                    $(name + ' tbody').html('<tr><td colspan="2" class="center">No se encontraron datos.</td></tr>');
                                }                         
                        });
                }

            </script>  
</div><!-- tabs 3 -->
    
     <div id="tabs-4" class="formsHuerfanos">
         <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                    <?php $utils->getMonthsSelect(); ?>

                    <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                    <?php $utils->getYearsSelect("anio");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>
     
                
                <table align="center" class="formData viewData last" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="5"><span>Préstamos Condonables (Aprobados por Consejo Directivo)</span></th>                                    
                        </tr>
                        <tr class="dataColumns category"> 
                            <th class="column borderR" rowspan="2"><span>Ámbito</span></th>   
                            <th class="column borderR" colspan="3"><span>Nivel de Formación</span></th>  
                            <th class="column" rowspan="2"><span>Valor</span></th>                                   
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Especialización</span></th> 
                            <th class="column" ><span>Maestría</span></th> 
                            <th class="column borderR" ><span>Doctorado</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <?php /*$num = count($recordsPrestamos);
                        for ($i = 0; $i < $num; $i++) { ?>
                            <tr class="dataColumns">
                                <td class="column center borderR" rowspan="3"><?php echo $recordsPrestamos[$i]["codigoperiodo"]; ?></td>
                                <td class="column center borderR">Nacional</td>
                                <td class="column center"><?php echo number_format($recordsPrestamos[$i]["valorNacionalEspecializacion"]); ?></td>
                                <td class="column center"><?php echo number_format($recordsPrestamos[$i]["valorNacionalMaestria"]); ?></td>
                                <td class="column center borderR"><?php echo number_format($recordsPrestamos[$i]["valorNacionalDoctorado"]); ?></td>
                                <td class="column center"><?php $total[$i]["nacional"] = ($recordsPrestamos[$i]["valorNacionalEspecializacion"]+
                                        $recordsPrestamos[$i]["valorNacionalMaestria"]+$recordsPrestamos[$i]["valorNacionalDoctorado"]);
                                        echo number_format($total[$i]["nacional"]); ?></td>
                            </tr>
                            <tr class="dataColumns">
                                <td class="column center borderR">Internacional</td>
                                <td class="column center"><?php echo $recordsPrestamos[$i]["valorInternacionalEspecializacion"]; ?></td>
                                <td class="column center"><?php echo $recordsPrestamos[$i]["valorInternacionalMaestria"]; ?></td>
                                <td class="column center borderR"><?php echo $recordsPrestamos[$i]["valorInternacionalDoctorado"]; ?></td>
                                <td class="column center"><?php $total[$i]["internacional"] = ($recordsPrestamos[$i]["valorInternacionalEspecializacion"]+
                                        $recordsPrestamos[$i]["valorInternacionalMaestria"]+$recordsPrestamos[$i]["valorInternacionalDoctorado"]);
                                    echo number_format($total[$i]["internacional"]); ?></td>
                            </tr>
                            <tr class="dataColumns">
                                <th class="column center borderR"><span>Total</span></th>
                                <th class="column center"><?php echo number_format($recordsPrestamos[$i]["valorNacionalEspecializacion"]+
                                        $recordsPrestamos[$i]["valorInternacionalEspecializacion"]); ?></th>
                                <th class="column center"><?php echo number_format($recordsPrestamos[$i]["valorNacionalMaestria"]+
                                        $recordsPrestamos[$i]["valorInternacionalMaestria"]); ?></th>
                                <th class="column center borderR"><?php echo number_format($recordsPrestamos[$i]["valorNacionalDoctorado"]+
                                        $recordsPrestamos[$i]["valorInternacionalDoctorado"]); ?></th>
                                <th class="column center"><?php echo number_format($total[$i]["internacional"]+
                                        $total[$i]["nacional"]); ?></th>
                            </tr>
                        <?php }*/ ?>
                    </tbody>
                </table>
        
                        <script type="text/javascript">                
                $('#tabs-4 .consultar').bind('click', function(event) {
                    getData40("#tabs-4");
                });            
                
                function getData40(name){
                    html = "";                    
                        var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                        var promise = getData(name,'formTalentoHumanoPrestamosCondonables',periodo,"codigoperiodo");
                        promise.success(function (data) {
                            $(name + ' tbody').html('');
                            //console.log(data);
							var total1 = 0;
							var total2 = 0;
							var total3 = 0;
							var total4 = 0;
                            if (data.success == true){      
                                            total1 = parseInt(data.data.valorNacionalEspecializacion) + parseInt(data.data.valorInternacionalEspecializacion);
											total2 = parseInt(data.data.valorNacionalMaestria) + parseInt(data.data.valorInternacionalMaestria);
											total3 = parseInt(data.data.valorNacionalDoctorado) + parseInt(data.data.valorInternacionalDoctorado);
											total4 = parseInt(data.data.valorTotalNacional) + parseInt(data.data.valorTotalInternacional);
                                            html = '<tr class="dataColumns">';
                                            html = html + '<td class="column center borderR">Nacional</td>';
                                            html = html + '<td class="column center borderR">'+data.data.valorNacionalEspecializacion+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.valorNacionalMaestria+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.valorNacionalDoctorado+'</td>';
                                            html = html + '<td class="column center borderR">$ '+FormatNumberBy3(data.data.valorTotalNacional,".",",")+'</td>';
                                            html = html + '</tr>';
                                            html = html + '<tr class="dataColumns">';
                                            html = html + '<td class="column center borderR">Internacional</td>';
                                            html = html + '<td class="column center borderR">'+data.data.valorInternacionalEspecializacion+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.valorInternacionalMaestria+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.valorInternacionalDoctorado+'</td>';
                                            html = html + '<td class="column center borderR">$ '+FormatNumberBy3(data.data.valorTotalInternacional,".",",")+'</td>';
                                            html = html + '</tr>';
											
                                            html = html + '<tr class="dataColumns">';
                                            html = html + '<th class="column total right borderR"><span>Total</span></th>"';
                                            html = html + '<th class="column total center borderR">'+total1+'</th>"';    
                                            html = html + '<th class="column total center borderR">'+total2+'</th>"';    
                                            html = html + '<th class="column total center borderR">'+total3+'</th>"';    
                                            html = html + '<th class="column total center">$ '+FormatNumberBy3(total4)+'</th>"';    
                                            html = html + '</tr>';
											
                                            $(name + ' tbody').append(html);
                                }
                                else{  
                                    $(name + ' tbody').html('<tr><td colspan="5" class="center">No se encontraron datos.</td></tr>');
                                }                         
                        });
                }

            </script>  
</div><!-- tabs 4 -->
    
     <!--<div id="tabs-5" >
     
                
                <table align="center" class="formData viewData last" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="6"><span>Apoyos económicos (Aprobados por Consejo Directivo)</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="2"><span>Período</span></th>  
                            <th class="column borderR" rowspan="2"><span>�?mbito</span></th>   
                            <th class="column borderR" colspan="3"><span>Tipo de evento</span></th>  
                            <th class="column" rowspan="2"><span>Valor</span></th>                                   
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Congreso</span></th> 
                            <th class="column" ><span>Diplomado</span></th> 
                            <th class="column borderR" ><span>Taller</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                        <?php /*$num = count($recordsApoyos);
                        for ($i = 0; $i < $num; $i++) { ?>
                            <tr class="dataColumns">
                                <td class="column center borderR" rowspan="3"><?php echo $recordsApoyos[$i]["codigoperiodo"]; ?></td>
                                <td class="column center borderR">Nacional</td>
                                <td class="column center"><?php echo number_format($recordsApoyos[$i]["valorNacionalCongreso"]); ?></td>
                                <td class="column center"><?php echo number_format($recordsApoyos[$i]["valorNacionalDiplomado"]); ?></td>
                                <td class="column center borderR"><?php echo number_format($recordsApoyos[$i]["valorNacionalTaller"]); ?></td>
                                <td class="column center"><?php $total[$i]["nacional"] = ($recordsApoyos[$i]["valorNacionalCongreso"]+
                                        $recordsApoyos[$i]["valorNacionalDiplomado"]+$recordsApoyos[$i]["valorNacionalTaller"]);
                                        echo number_format($total[$i]["nacional"]); ?></td>
                            </tr>
                            <tr class="dataColumns">
                                <td class="column center borderR">Internacional</td>
                                <td class="column center"><?php echo $recordsApoyos[$i]["valorInternacionalCongreso"]; ?></td>
                                <td class="column center"><?php echo $recordsApoyos[$i]["valorInternacionalDiplomado"]; ?></td>
                                <td class="column center borderR"><?php echo $recordsApoyos[$i]["valorInternacionalTaller"]; ?></td>
                                <td class="column center"><?php $total[$i]["internacional"] = ($recordsApoyos[$i]["valorInternacionalCongreso"]+
                                        $recordsApoyos[$i]["valorInternacionalDiplomado"]+$recordsApoyos[$i]["valorInternacionalTaller"]);
                                    echo number_format($total[$i]["internacional"]); ?></td>
                            </tr>
                            <tr class="dataColumns">
                                <th class="column center borderR"><span>Total</span></th>
                                <th class="column center"><?php echo number_format($recordsApoyos[$i]["valorNacionalCongreso"]+
                                        $recordsApoyos[$i]["valorInternacionalCongreso"]); ?></th>
                                <th class="column center"><?php echo number_format($recordsApoyos[$i]["valorInternacionalDiplomado"]+
                                        $recordsApoyos[$i]["valorNacionalDiplomado"]); ?></th>
                                <th class="column center borderR"><?php echo number_format($recordsApoyos[$i]["valorNacionalTaller"]+
                                        $recordsApoyos[$i]["valorInternacionalTaller"]); ?></th>
                                <th class="column center"><?php echo number_format($total[$i]["internacional"]+
                                        $total[$i]["nacional"]); ?></th>
                            </tr>
                        <?php }*/ ?>
                    </tbody>
                </table>
</div>-->
    
   <div id="tabs-16" class="formsHuerfanos">
         <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                    <?php $utils->getMonthsSelect(); ?>

                    <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                    <?php $utils->getYearsSelect("anio");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>
                <table align="center" class="formData viewData last" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="5"><span>Índice de selectividad de los académicos</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR"   ><span>Dedicación</span></th>    
                                        <th class="column borderR" ><span>Número procesos de selección</span></th> 
                                        <th class="column borderR" ><span>Número de Aspirantes</span></th> 
                                        <th class="column borderR" ><span>Número de seleccionados</span></th> 
                                        <th class="column borderR" ><span>índice de selectividad</span></th>                               
                           
                        </tr>
                     </thead>
                     <tbody>
                        
                    </tbody>
                </table>
				
			<script type="text/javascript">
                $('#tabs-16 .consultar').bind('click', function(event) {
                    getData16("#tabs-16");
                });            
                
                function getData16(name){
                    html = "";                    
                        var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();         
						 var promise = getDataDynamic(name,'formTalentoIndiceSelectividad',periodo,"codigoperiodo","siq_dedicacionPersonal","idDedicacion");
						 promise.success(function (data) {
							 $(name + ' tbody').html('');
							 var indice = 0;
							 var total1=0;
							 var total2=0;
							 var total3=0;
							 if (data.success == true){
									 for (var i=0;i<data.total;i++)
										{       
											total1 = total1 + parseInt(data.data[i].numProcesosSeleccion);
											total2 = total2 + parseInt(data.data[i].numAspirantes);
											total3 = total3 + parseInt(data.data[i].numSeleccionados);
											indice = 0;
											if(data.data[i].numAspirantes!=0){
												indice = parseInt(data.data[i].numSeleccionados)/parseInt(data.data[i].numAspirantes);
											}
											html = '<tr class="dataColumns">';
											html = html + '<td class="column borderR">'+data.data[i].nombre+'</td>';
											html = html + '<td class="column center borderR">'+data.data[i].numProcesosSeleccion+'</td>';
											html = html + '<td class="column center borderR">'+data.data[i].numAspirantes+'</td>';
											html = html + '<td class="column center borderR">'+data.data[i].numSeleccionados+'</td>';
											html = html + '<td class="column center borderR">'+indice.toFixed(2)+'</td>';
											html = html + '</tr>';
											
											$(name + ' tbody').append(html);
										   
										}											
											indice = 0;
											if(total2!=0){
												indice = parseInt(total3)/parseInt(total2);
											}
                                            html = html + '<tr class="dataColumns">';
                                            html = html + '<th class="column total right borderR"><span>Total</span></th>"';
                                            html = html + '<th class="column total center borderR">'+total1+'</th>"';    
                                            html = html + '<th class="column total center borderR">'+total2+'</th>"';    
                                            html = html + '<th class="column total center borderR">'+total3+'</th>"';    
                                            html = html + '<th class="column total center">'+indice.toFixed(2)+'</th>"';    
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
    
  <!--  <div id="tabs-7" class="formsHuerfanos">
         <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                    <?php /*$utils->getMonthsSelect(); ?>

                    <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                    <?php $utils->getYearsSelect("anio");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>
     
                
                <table align="center" class="formData viewData last" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Académicos desvinculados</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" ><span>Período</span></th>  
                            <th class="column borderR" ><span>Motivo del retiro</span></th>   
                            <th class="column borderR" ><span>Número de Académicos</span></th>                                 
                        </tr>
                     </thead>
                     <tbody>
                        <?php $num = count($recordsDesvinculados);
                        for ($i = 0; $i < $num; $i++) { ?>
                            <tr class="dataColumns">
                                <td class="column center borderR" rowspan="7"><?php echo $recordsDesvinculados[$i]["codigoperiodo"]; ?></td>
                                <td class="column borderR">Terminación de Contrato</td>
                                <td class="column center"><?php echo ($recordsDesvinculados[$i]["numTerminacionContrato"]); 
                                $total = $recordsDesvinculados[$i]["numTerminacionContrato"]; ?></td>
                            </tr>
                            <tr class="dataColumns">
                                <td class="column borderR">Renuncia por nueva oportunidad laboral</td>
                                <td class="column center"><?php echo ($recordsDesvinculados[$i]["numRenunciaOportunidad"]); 
                                $total += $recordsDesvinculados[$i]["numRenunciaOportunidad"]; ?></td>
                            </tr>
                            <tr class="dataColumns">
                                <td class="column borderR">Renuncia por motivos personales</td>
                                <td class="column center"><?php echo ($recordsDesvinculados[$i]["numRenunciaMotivosPersonales"]); 
                                $total += $recordsDesvinculados[$i]["numRenunciaMotivosPersonales"]; ?></td>
                            </tr>
                            <tr class="dataColumns">
                                <td class="column borderR">Renuncia  por mejores condiciones laborales</td>
                                <td class="column center"><?php echo ($recordsDesvinculados[$i]["numRenunciaCondicionesLaborales"]); 
                                $total += $recordsDesvinculados[$i]["numRenunciaCondicionesLaborales"]; ?></td>
                            </tr>
                            <tr class="dataColumns">
                                <td class="column borderR">Renuncia por viaje</td>
                                <td class="column center"><?php echo ($recordsDesvinculados[$i]["numRenunciaViaje"]); 
                                $total += $recordsDesvinculados[$i]["numRenunciaViaje"]; ?></td>
                            </tr>
                            <tr class="dataColumns">
                                <td class="column borderR">Despido</td>
                                <td class="column center"><?php echo ($recordsDesvinculados[$i]["numDespido"]); 
                                $total += $recordsDesvinculados[$i]["numDespido"]; ?></td>
                            </tr>
                            <tr class="dataColumns">
                                <td class="column borderR">Otro</td>
                                <td class="column center"><?php echo ($recordsDesvinculados[$i]["numOtro"]); 
                                $total += $recordsDesvinculados[$i]["numOtro"]; ?></td>
                            </tr>
                            <tr class="dataColumns">
                                <th class="column center borderR"><span>Total</span></th>
                                <th class="column center borderR"></th>
                                <th class="column center"><?php echo number_format($total); ?></th>
                            </tr>
                        <?php } */?>
                    </tbody>
                </table>
</div>-->
    
     <div id="tabs-13" class="formsHuerfanos">
         <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                    <?php $utils->getMonthsSelect(); ?>

                    <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                    <?php $utils->getYearsSelect("anio");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>
     
        <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="2"><span>Académicos extranjeros por Programa Académico</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Programa Académico</span></th> 
                            <th class="column" ><span>Número de Académicos</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                     </tbody>
                </table>   
</div>
<script type="text/javascript">         
 $('#tabs-13 .consultar').bind('click', function(event) {
                    getDataDocentesFacultad();
                });            
            
            function getDataDocentesFacultad(){
                <?php //echo "var facultad_array = ". $js_facultades . ";\n"; ?>
                //facultad_array = convertArray(facultad_array);
                        
                var name = "#tabs-13";
                var periodo = $('#tabs-13 #mes').val()+"-"+$('#tabs-13 #anio').val();
                if(periodo==""){
                    $(name + ' tbody').html("");
                } else {
                    html = "";                
                     var promise = getDataDynamic2(name,'formTalentoHumanoAcademicosExtranjerosFacultad',periodo,"codigoperiodo","siq_unidadAdministrativa","idsiq_unidadAdministrativa","nombre");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
						 var total1 = 0;
                         if (data.success == true){
                                 for (var i=0;i<data.total;i++)
                                    {       
										total1 = total1 + parseInt(data.data[i].valor);
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column borderR">'+data.data[i].nombre+'</td>';
                                        html = html + '<td class="column center borderR">'+data.data[i].valor+'</td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                       
                                    }
                                            html = '<tr class="dataColumns">';
                                            html = html + '<th class="column total right borderR"><span>Total</span></th>"';
                                            html = html + '<th class="column total center borderR">'+total1+'</th>"';       
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
     <div id="tabs-14" class="formsHuerfanos">
         <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                    <?php $utils->getMonthsSelect(); ?>

                    <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                    <?php $utils->getYearsSelect("anio");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>
     
        <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Académicos extranjeros por país de origen</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>País de Origen</span></th> 
                            <th class="column" ><span>Número de Académicos</span></th>                             
                        </tr>
                     </thead>
                     <tbody> 
                     </tbody>
                </table>   
                    
<script type="text/javascript">     
            $('#tabs-14 .consultar').bind('click', function(event) {
                    updateDataDocentesPais();
                });            
            
            function updateDataDocentesPais(){
                <?php //echo "var paises_array = ". $js_pais . ";\n"; ?>
                //paises_array = convertArray(paises_array);
                        
                var name = "#tabs-14";
                var periodo = $('#tabs-14 #mes').val()+"-"+$('#tabs-14 #anio').val();
                if(periodo==""){
                    $(name + ' tbody').html("");
                } else {
                    html = "";                    
                     var promise = getDataDynamic2(name,'formTalentoHumanoAcademicosExtranjerosPais',periodo,"codigoperiodo","pais","idPais","nombrepais");
                     promise.success(function (data) {
						var total1=0;
                         $(name + ' tbody').html('');
                         if (data.success == true){
                                 for (var i=0;i<data.total;i++)
                                    {       
										total1 = total1 + parseInt(data.data[i].valor);
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column center borderR">'+data.data[i].nombrepais+'</td>';
                                        html = html + '<td class="column center borderR">'+data.data[i].valor+'</td>';
                                        //html = html + '<td class="column center eliminarDato"><img width="16" onclick="Eliminar('+data.data[i].idsiq_formTalentoHumanoAcademicosExtranjerosPais+', \'formTalentoHumanoAcademicosExtranjerosPais\',\'updateDataDocentesPais\')" title="Eliminar Dato" src="../../images/Close_Box_Red.png" style="cursor:pointer;"></td>';
                                        html = html + '</tr>';
                                        $(name + ' tbody').append(html);
                                       
                                    }
                                            html = '<tr class="dataColumns">';
                                            html = html + '<th class="column total right borderR"><span>Total</span></th>"';
                                            html = html + '<th class="column total center borderR">'+total1+'</th>"';       
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



<div id="tabs-15" class="formsHuerfanos">
         <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                    <?php $utils->getMonthsSelect(); ?>

                    <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                    <?php $utils->getYearsSelect("anio");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>
     
                
                <table align="center" class="formData viewData last" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                 
								<th class="column" colspan="2"><span>Académicos Desvinculados</span></th>                    
						 </tr>
						 <tr class="dataColumns">		
								<th class="column" style="text-align:center;">Motivo del retiro</span></th>
								<th class="column" style="text-align:center;">Número de Académicos</span></th>                    
						 </tr>	
                     </thead>
                     <tbody>
                    </tbody>
                </table>
        
                        <script type="text/javascript">                
                $('#tabs-15 .consultar').bind('click', function(event) {
                    getData15("#tabs-15");
                });            
                
                function getData15(name){
                    html = "";                    
                        var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                        var promise = getData(name,'formTalentoHumanoAcademicosDesvinculados',periodo,"codigoperiodo");
                        promise.success(function (data) {
                            $(name + ' tbody').html('');
                            //console.log(data);
							var total1=0;
                            if (data.success == true){      
                                            
											total1 = parseInt(data.data.numAbandono) + parseInt(data.data.numDespido) + parseInt(data.data.numEstudios) + parseInt(data.data.numPension);
											total1 = total1 + parseInt(data.data.numRenunciaMotivosPersonales) + parseInt(data.data.numRenunciaOportunidad) + parseInt(data.data.numRenunciaViaje);
											total1 = total1 + parseInt(data.data.numTerminacionContrato) + parseInt(data.data.numOtro);
                                            html = '<tr class="dataColumns">';
                                            html = html + '<td class="column borderR">Abandono de cargo</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numAbandono+'</td>';
                                            html = html + '</tr>';
                                            html = html + '<tr class="dataColumns">';
                                            html = html + '<td class="column borderR">Despido</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numDespido+'</td>';
                                            html = html + '</tr>';
                                            html = html + '<tr class="dataColumns">';
                                            html = html + '<td class="column borderR">Realización de Estudios</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numEstudios+'</td>';
                                            html = html + '</tr>';
                                            html = html + '<tr class="dataColumns">';
                                            html = html + '<td class="column borderR">Reconocimiento de pensión</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numPension+'</td>';
                                            html = html + '</tr>';
                                            html = html + '<tr class="dataColumns">';
                                            html = html + '<td class="column borderR">Renuncia por motivos personales</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numRenunciaMotivosPersonales+'</td>';
                                            html = html + '</tr>';
                                            html = html + '<tr class="dataColumns">';
                                            html = html + '<td class="column borderR">Renuncia por nueva oportunidad laboral</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numRenunciaOportunidad+'</td>';
                                            html = html + '</tr>';
                                            html = html + '<tr class="dataColumns">';
                                            html = html + '<td class="column borderR">Renuncia por viaje</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numRenunciaViaje+'</td>';
                                            html = html + '</tr>';
                                            html = html + '<tr class="dataColumns">';
                                            html = html + '<td class="column borderR">Terminación de Contrato a término fijo</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numTerminacionContrato+'</td>';
                                            html = html + '</tr>';
                                            html = html + '<tr class="dataColumns">';
                                            html = html + '<td class="column borderR">Otros</td>';
                                            html = html + '<td class="column center borderR">'+data.data.numOtro+'</td>';
                                            html = html + '</tr>';
											
                                            html = html + '<tr class="dataColumns">';
                                            html = html + '<th class="column total right borderR"><span>Total</span></th>"';
                                            html = html + '<th class="column total center borderR">'+total1+'</th>"';       
                                            html = html + '</tr>';
                                            $(name + ' tbody').append(html);
                                }
                                else{  
                                    $(name + ' tbody').html('<tr><td colspan="2" class="center">No se encontraron datos.</td></tr>');
                                }                         
                        });
                }

            </script>  
</div><!-- tabs 15 -->

     <div id="tabs-17" class="formsHuerfanos">
         <label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
                    <?php $utils->getSemestresSelect($db,"codigoperiodo"); 
                    $categoriasPadres = $db->GetAll("SELECT nombre,idsiq_tipoActividadAcademicos as id FROM siq_tipoActividadAcademicos WHERE actividadPadre=0 AND codigoestado=100 ORDER BY nombre ASC"); 
					$js_categorias = json_encode($categoriasPadres);
					?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>
     
        <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="7"><span>Dedicación de los Académicos por actividades</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" colspan="2"><span>Clase De Actividades</span></th> 
                            <th class="column borderR"><span>Horas Semanales</span></th> 
                            <th class="column borderR"><span>Tiempos completos equivalentes</span></th>
                            <th class="column borderR"><span>%</span></th>
                            <th class="column borderR"><span>Total</span></th>
                            <th class="column borderR"><span>Índice</span></th>
                        </tr>
                     </thead>
                     <tbody>
                     </tbody>
                </table>   

<script type="text/javascript">         
 $('#tabs-17 .consultar').bind('click', function(event) {
                    getData17();
});            
            
            function getData17(){
                <?php echo "var categorias_array = ". $js_categorias . ";\n"; ?>
                //var categorias_arrayID = convertArray(categorias_array);
                     var totalCategorias = categorias_array.length;
                var name = "#tabs-17";
                var periodo = $('#tabs-17 #codigoperiodo').val();
                if(periodo==""){
                    $(name + ' tbody').html("");
                } else {
                    html = "";      
						$.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: "formUnidadesAcademicasActividadesAcademicos", joinField: "", actividad:"2", campoPeriodo: "codigoperiodo",
                                    entityJoin: "siq_tipoActividadAcademicos", codigocarrera:0 },     
                            success:function(data){
                                if (data.success == true){   
									$(name + ' tbody').html('');								
									var total1 = 0;          
									var total2 = 0;
									var z = 0;
									var html2 = "";
									var html3 = "";
									var totalTCE = 0;
									for (var i=0;i<data.total;i++){
										total1 = total1 + parseInt(data.data[i].numHoras);
										total2 = total2 + parseInt(data.data[i].numAcademicosTCE);
									}
									for (var j=0;j<totalCategorias;j++)
									{  
										z = 0;
										 for (var i=0;i<data.total;i++)
											{       
												if(data.data[i].actividadPadre==categorias_array[j].id){
													z = z + 1;
													totalTCE += parseInt(data.data[i].numAcademicosTCE);
													if(z!=1){
														html += '<tr class="dataColumns">';
														html = html + '<td class="column borderR">'+data.data[i].nombre+'</td>';
														html = html + '<td class="column center borderR">'+data.data[i].numHoras+'</td>';
														html = html + '<td class="column center borderR">'+data.data[i].numAcademicosTCE+'</td>';
														html = html + '<td class="column center borderR">'+(parseInt(data.data[i].numAcademicosTCE)/parseInt(total2)*100).toFixed(2)+'</td>';
														html = html + '</tr>';
													} else {
														//html = html + '<td class="column borderR">'+categorias_array[data.data[i].actividadPadre]+'</td>';
														html3 = html3 + '<td class="column borderR">'+data.data[i].nombre+'</td>';
														html3 = html3 + '<td class="column center borderR">'+data.data[i].numHoras+'</td>';
														html3 = html3 + '<td class="column center borderR">'+data.data[i].numAcademicosTCE+'</td>';
														html3 = html3 + '<td class="column center borderR">'+(parseInt(data.data[i].numAcademicosTCE)/parseInt(total2)*100).toFixed(2)+'</td>';
													}
												}
											   
											}
											if(z!=0){
												html2 = '<tr class="dataColumns">';
												html2 = html2 + '<td class="column borderR" rowspan="'+z+'">'+categorias_array[j].nombre+'</td>';
												html2 = html2 + html3;
												html2 = html2 + '<td class="column borderR center" rowspan="'+z+'">'+totalTCE+'</td>';
												html2 = html2 + '<td class="column borderR center" rowspan="'+z+'">'+(totalTCE/parseInt(total2)*100).toFixed(2)+'</td>';
												html2 = html2 + '</tr>';
												html2 = html2 + html;
												$(name + ' tbody').append(html2);
												html = "";
												html3 = "";
												totalTCE = 0;
											}
									}
                                            html = '<tr class="dataColumns">';
                                            html = html + '<th class="column total right borderR" colspan="2"><span>Total</span></th>"';
                                            html = html + '<th class="column total center borderR">'+total1+'</th>"';    
                                            html = html + '<th class="column total center borderR">'+total2+'</th>"';    
                                            html = html + '<th class="column total center borderR">'+100+'</th>"';     
                                            html = html + '<th class="column total center borderR">'+total2+'</th>"';      
                                            html = html + '<th class="column total center borderR"></th>"';     
                                            html = html + '</tr>';
                                            $(name + ' tbody').append(html);
                                }
                                else{                        
                                    //no se encontraron datos
                                    $(name + ' tbody').html('<tr><td colspan="7" class="center">No se encontraron datos.</td></tr>');
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        }); 					
                     
                      
                }
            }      
</script>
</div> <!--- tabs 17 --->
     </div> <!--- tabs -->
