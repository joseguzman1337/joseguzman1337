<?php         

    //$records = $utils->getDataForm($db,"siq_formTalentoHumanoNumeroPersonas","codigoperiodo");
    //$recordsPrestacion = $utils->getDataFormCategory($db,"siq_formTalentoHumanoPersonalPrestacionServicios","codigoperiodo","siq_actividadPrestacionServicios","idActividad");
    //$recordsPrestamos = $utils->getDataForm($db,"siq_formTalentoHumanoPrestamosCondonables","codigoperiodo");
    //$recordsApoyos = $utils->getDataForm($db,"siq_formTalentoHumanoApoyosEconomicos","codigoperiodo");
    //$recordsIndices = $utils->getDataFormCategory($db,"siq_formTalentoIndiceSelectividad","codigoperiodo","siq_dedicacionPersonal","idDedicacion");
    //$recordsDesvinculados = $utils->getDataForm($db,"siq_formTalentoHumanoAcademicosDesvinculados","codigoperiodo");
    $recordsExtranjerosFacultad = $utils->getDataFormCategoryDynamic($db,"formTalentoHumanoAcademicosExtranjerosFacultad","codigoperiodo","facultad","nombrefacultad",false);
    $recordsExtranjerosPais = $utils->getDataFormCategoryDynamic($db,"formTalentoHumanoAcademicosExtranjerosPais","codigoperiodo","pais","nombrepais");
    $pais = $db->GetAll("SELECT nombrepais as nombre,idpais as id FROM pais ORDER BY nombrepais ASC"); 
    $js_pais = json_encode($pais);
    $num = count($records);    
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
         
         function getDataDynamic2(formName,entity,periodo,campoPeriodo,entityJoin,campoJoin){
             return  $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/docentes/saveTalentoHumano.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: entity, campoPeriodo: campoPeriodo,entityJoin: entityJoin,campoJoin:campoJoin },     
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
                                        <li class="tab10"><a href="./formularios/docentes/viewIndiceSelectividad.php">Índice de selectividad de los académicos</a></li>
					<li class="tab11"><a href="./formularios/docentes/viewAcademicosDesvinculados.php">Académicos Desvinculados</a></li>     
					<li class="tab12"><a href="#tabs-13">Académicos extranjeros por Unidad Académica</a></li>      
					<li class="tab13"><a href="#tabs-14">Académicos extranjeros por país de origen</a></li>
					<li class="tab14"><a href="./formularios/docentes/viewTalentoHumanoEscalafonBosque.php">Dedicación Semanal Docentes<br>(Según Categorización Universidad El Bosque), por Escalafón</a></li>
					<li class="tab15"><a href="./formularios/docentes/viewTalentoHumanoEscalafonCNA.php">Dedicación Semanal Docentes<br>(Según Categorización CNA), por Escalafón</a></li>
					<!--<li><a href="#tabs-20">Profesores que cursan programas de idioma no materno</a></li>-->
                                        <li><a href="../reportes/reportes/docentes/viewReporteDedicacionBosquePorNivelFormacion.php">Dedicación Semanal Docentes<br>(Según categorización Universidad El Bosque), por Mayor Nivel de Formación</a></li>
                                        <li><a href="../reportes/reportes/docentes/viewReporteNumeroAcademicosBosquePorEstudio.php">Dedicación Semanal Docentes<br>(Según categorización Universidad El Bosque), por Estudios en Curso</a></li>
                                        <li><a href="../reportes/reportes/docentes/viewReporteDedicacionCNAPorNivelFormacion.php">Dedicación Semanal Docentes<br>(Según categorización del CNA), por Mayor Nivel de Formación</a></li>
                                        <li><a href="../reportes/reportes/docentes/viewReporteNumeroAcademicosCNAPorEstudio.php">Dedicación Semanal Docentes<br>(Según categorización del CNA), por Estudios en Curso</a></li>
                                        <li><a href="../reportes/reportes/docentes/viewReporteActividadesAcademicas.php">Dedicación de los Académicos por Actividades</a></li>
					
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
                            <th class="column" colspan="3"><span>Personal por prestación de servicios</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" ><span>Actividad</span></th> 
                                        <th class="column" ><span>Número de Personas</span></th> 
                                        <th class="column borderR" ><span>Valor Total de los Servicios</span></th>  
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
                        var periodo = $(name + ' #mes').val()+"-"+$(name + ' #anio').val();
                        var promise = getDataDynamic(name,'formTalentoHumanoPersonalPrestacionServicios',periodo,"codigoperiodo","siq_actividadPrestacionServicios","idActividad","ORDER BY orden");                      
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
                                                html = html + '<td class="column borderR center">'+data.data[i].valorServicios+'</td>';
                                                html = html + '</tr>';
                                                $(name + ' tbody').append(html);
                                            }

                                            html = '<tr class="dataColumns">';
                                            html = html + '<th class="column total right borderR"><span>Total</span></th>"';
                                            html = html + '<th class="column total center">'+totalSalud+'</th>"';    
                                            html = html + '<th class="column total center borderR">'+total2+'</th>"';                                 
                                            html = html + '</tr>';
                                            $(name + ' tbody').append(html);
                                }
                                else{  
                                    $(name + ' tbody').html('<tr><td colspan="3" class="center">No se encontraron datos.</td></tr>');
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
                            if (data.success == true){      
                                            
                                            html = '<tr class="dataColumns">';
                                            html = html + '<td class="column center borderR">Nacional</td>';
                                            html = html + '<td class="column center borderR">'+data.data.valorNacionalEspecializacion+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.valorNacionalMaestria+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.valorNacionalDoctorado+'</td>';
                                            html = html + '<td class="column center borderR">'+FormatNumberBy3(data.data.valorTotalNacional,".",",")+'</td>';
                                            html = html + '</tr>';
                                            html = html + '<tr class="dataColumns">';
                                            html = html + '<td class="column center borderR">Internacional</td>';
                                            html = html + '<td class="column center borderR">'+data.data.valorInternacionalEspecializacion+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.valorInternacionalMaestria+'</td>';
                                            html = html + '<td class="column center borderR">'+data.data.valorInternacionalDoctorado+'</td>';
                                            html = html + '<td class="column center borderR">'+FormatNumberBy3(data.data.valorTotalInternacional,".",",")+'</td>';
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
    
  <!--  <div id="tabs-6" class="longTable formsHuerfanos">
         <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                    <?php /*$utils->getMonthsSelect(); ?>

                    <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                    <?php $utils->getYearsSelect("anio");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>
                <table align="center" class="formData viewData last" width="100%" >
                    <thead>            
                        <tr class="dataColumns">
                             <?php $numP = count($recordsIndices["dataPeriodos"]);
                                $colspan = 2 + $numP*4; ?>
                            <th class="column" colspan="<?php echo $colspan; ?>"><span>�?ndice de selectividad de los académicos</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR"  rowspan="2" ><span>Dedicación</span></th>                             
                            <?php                             
                            for ($i = 0; $i < $numP; $i++) { ?>
                                <th class="column borderR" colspan="4"><span><?php echo $recordsIndices["dataPeriodos"][$i]["periodo"]; ?></span></th>
                            <?php } ?>
                        </tr>
                        <tr class="dataColumns category">                            
                            <?php for ($i = 0; $i < $numP; $i++) { ?>                                    
                                        <th class="column "  ><span>Número procesos de selección</span></th> 
                                        <th class="column "  ><span>Número de Aspirantes</span></th> 
                                        <th class="column "  ><span>Número de seleccionados</span></th> 
                                        <th class="column borderR"  ><span>�?ndice de selectividad</span></th>                                
                                <?php }  ?>     
                        </tr>
                     </thead>
                     <tbody>
                        <?php $num = count($recordsIndices["data"])/count($recordsIndices["dataPeriodos"]);    
                        $totales = array();
                        for ($i = 0; $i < $num; $i++) { ?>
                            <tr class="dataColumns">
                                <td class="column borderR"><?php echo $recordsIndices["data"][$i]["nombre"]; ?></td>
                                <?php for ($j = 1; $j <= $numP; $j++) { ?>  
                                <td class="column center"><?php echo $recordsIndices["data"][$i*$j]["numProcesosSeleccion"]; 
                                    $totales["numProcesosSeleccion"][$j] = $totales["numProcesosSeleccion"][$j] + $recordsIndices["data"][$i*$j]["numProcesosSeleccion"]; ?></td>
                                <td class="column center "><?php echo ($recordsIndices["data"][$i*$j]["numAspirantes"]);
                                 $totales["numAspirantes"][$j] = $totales["numAspirantes"][$j] + $recordsIndices["data"][$i*$j]["numAspirantes"]; ?></td>
                                <td class="column center "><?php echo ($recordsIndices["data"][$i*$j]["numSeleccionados"]);
                                 $totales["numSeleccionados"][$j] = $totales["numSeleccionados"][$j] + $recordsIndices["data"][$i*$j]["numSeleccionados"]; ?></td>
                                <td class="column center borderR"><?php $index=$recordsIndices["data"][$i*$j]["numSeleccionados"]/$recordsIndices["data"][$i*$j]["numAspirantes"];
                                    if($index == intval($index)){
                                        echo $index;
                                    } else {
                                        echo number_format($index,3);
                                    }
                                 $totales["indice"][$j] = $totales["indice"][$j] + $index;
                                 $totales["contador"][$j] = $totales["contador"][$j] + 1; ?></td>
                                <?php }  ?> 
                            </tr>   
                          <?php }  ?>                               
                            <tr class="dataColumns">
                                <th class="column total center borderR"><span>Total</span></th>
                                <?php for ($j = 1; $j <= $numP; $j++) { ?>  
                                <th class="column total center"><?php echo $totales["numProcesosSeleccion"][$j]; ?></th>
                                <th class="column total center "><?php echo ($totales["numAspirantes"][$j]); ?></th>
                                <th class="column total center"><?php echo $totales["numSeleccionados"][$j]; ?></th>
                                <th class="column total center borderR"><?php echo number_format($totales["indice"][$j]/$totales["contador"][$j],3); ?></th>
                                <?php } */ ?> 
                            </tr>  
                    </tbody>
                </table>
</div>-->
    
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
                            <th class="column" colspan="3"><span>Académicos extranjeros por Unidad Académica</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Período</span></th> 
                            <th class="column" ><span>Facultad</span></th> 
                            <th class="column" ><span>Número de Académicos</span></th> 
                        </tr>
                     </thead>
                     <tbody>
                         <?php $num = count($recordsExtranjerosFacultad["actividades"]);    
                         $numP = count($recordsExtranjerosFacultad["dataPeriodos"]);
                        $totales = array();$periodoAnterior = "";
                        for ($i = 0; $i < $numP; $i++) { ?>
                         <?php for ($j = 0; $j < $num; $j++) {  ?>  
                            <tr class="dataColumns">
                              <?php if($periodoAnterior!=$recordsExtranjerosFacultad["dataPeriodos"][$i]["periodo"]) { $periodoAnterior =$recordsExtranjerosFacultad["dataPeriodos"][$i]["periodo"]; ?>
                                <td class="column borderR center" rowspan="<?php echo $num; ?>"><?php echo $recordsExtranjerosFacultad["dataPeriodos"][$i]["periodo"]; ?></td>
                               <?php } ?>
                                <td class="column borderR"><?php echo $recordsExtranjerosFacultad["actividades"][$j]["nombrefacultad"]; 
                                $data = $utils->getValorDynamic($db,"formTalentoHumanoAcademicosExtranjerosFacultad","codigoperiodo","facultad",$recordsExtranjerosFacultad["dataPeriodos"][$i]["periodo"],$recordsExtranjerosFacultad["actividades"][$j]["codigofacultad"],"codigofacultad","nombrefacultad");
                                    $totales["numAcademicos"][$i] = $totales["numAcademicos"][$i] + $data["valor"]; ?></td>
                                <td class="column center borderR"><?php echo number_format($data["valor"]); ?></td>
                            </tr>    
                            <?php }  ?> 
                            <tr class="dataColumns">
                                <th class="column total "></th>
                                <th class="column total right borderR"><span>Total</span></th>
                                <th class="column total center borderR"><?php echo $totales["numAcademicos"][$i]; ?></th>
                                
                            </tr>  
                            <?php }  ?> 
                     </tbody>
                </table>   
</div>
     
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
                <?php echo "var paises_array = ". $js_pais . ";\n"; ?>
                paises_array = convertArray(paises_array);
                        
                var name = "#tabs-14";
                var periodo = $('#tabs-14 #mes').val()+"-"+$('#tabs-14 #anio').val();
                if(periodo==""){
                    $(name + ' tbody').html("");
                } else {
                    html = "";                    
                     var promise = getDataDynamic2(name,'formTalentoHumanoAcademicosExtranjerosPais',periodo,"codigoperiodo","pais","idPais");
                     promise.success(function (data) {
                     console.log(data.data);
                         $(name + ' tbody').html('');
                         if (data.success == true){
                                 for (var i=0;i<data.total;i++)
                                    {       
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column center borderR">'+data.data[i].nombrepais+'</td>';
                                        html = html + '<td class="column center borderR">'+data.data[i].valor+'</td>';
                                        //html = html + '<td class="column center eliminarDato"><img width="16" onclick="Eliminar('+data.data[i].idsiq_formTalentoHumanoAcademicosExtranjerosPais+', \'formTalentoHumanoAcademicosExtranjerosPais\',\'updateDataDocentesPais\')" title="Eliminar Dato" src="../../images/Close_Box_Red.png" style="cursor:pointer;"></td>';
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
     </div> <!--- tabs -->
