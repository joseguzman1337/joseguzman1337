<?php 
    $idiomas = $db->GetAll("SELECT nombreidioma as nombre,ididioma as id FROM idioma ORDER BY nombreidioma ASC"); 
    $js_idiomas = json_encode($idiomas);
    $niveles = $db->GetAll("SELECT nombre,idsiq_nivelIdioma as id FROM siq_nivelIdioma WHERE codigoestado=100 ORDER BY nombre ASC"); 
    $js_niveles = json_encode($niveles);
    $tipos = $db->GetAll("SELECT nombre,idsiq_tipoCursoIdioma as id FROM siq_tipoCursoIdioma WHERE codigoestado=100 ORDER BY nombre ASC"); 
    $js_tipos = json_encode($tipos);
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
        
        function getDataByDate(formName,entity,periodo,campoFecha){
             return  $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getDataByDate", entity: entity, campoFecha: campoFecha, tipo: 1 },     
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
               <li><a href="#tabs-4">Profesores que cursan programas de idioma no materno</a></li>
	</ul>
    
    <div id="tabs-4" class="formsHuerfanos">
                <div class="formModalidad">
                     <?php include($rutaModalidad); ?>
                </div>
                
                <div class="vacio"></div>
                
                <label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect(); ?>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />
                
                <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                
                <div class="vacio"></div>
     
        <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="6"><span>Profesores que cursan programas de idioma no materno en el centro de lenguas</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" ><span>Nombre del profesor - estudiante</span></th> 
                            <th class="column borderR" ><span>Idioma</span></th> 
                            <th class="column borderR" ><span>Tipo de curso</span></th> 
                            <th class="column borderR" ><span>Nivel</span></th> 
                            <th class="column borderR" ><span>Número de horas<br/>semanales de<br/>vinculación del<br/>académico</span></th> 
                            <th class="column" ></th> 
                        </tr>
                     </thead>
                     <tbody>
                         
                     </tbody>
                </table>  
                
                <script type="text/javascript">            
            
            $('#tabs-4 .consultar').bind('click', function(event) {
                    updateDataIdiomas();
                });            
            
            function updateDataIdiomas(){
                <?php echo "var idiomas_array = ". $js_idiomas . ";\n"; 
                echo "var niveles_array = ". $js_niveles . ";\n"; 
                echo "var tipos_array = ". $js_tipos . ";\n"; ?>
                idiomas_array = convertArray(idiomas_array);
                niveles_array = convertArray(niveles_array);
                tipos_array = convertArray(tipos_array);
                        
                var name = "#tabs-4";
                var periodo = $('#tabs-4 #mes').val()+"-"+$('#tabs-4 #anio').val();
                if(periodo==""){
                    $(name + ' tbody').html("");
                } else {
                    html = "";                    
                     var promise = getDataByDate(name,'formTalentoHumanoAcademicosDocentesOtroIdioma',periodo,"codigoperiodo");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true){
                                 for (var i=0;i<data.total;i++)
                                    {       
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column borderR">'+data.data[i].nombre+'</td>';
                                        html = html + '<td class="column center borderR">'+idiomas_array[data.data[i].idioma]+'</td>';
                                        html = html + '<td class="column borderR">'+tipos_array[data.data[i].tipoCurso]+'</td>';
                                        html = html + '<td class="column center borderR">'+niveles_array[data.data[i].nivel]+'</td>';
                                        html = html + '<td class="column center borderR">'+data.data[i].horas+'</td>';
                                        html = html + '<td class="column center eliminarDato"><img width="16" onclick="Eliminar('+data.data[i].idsiq_formTalentoHumanoAcademicosDocentesOtroIdioma+', \'formTalentoHumanoAcademicosDocentesOtroIdioma\',\'updateDataIdiomas\')" title="Eliminar Dato" src="../../images/Close_Box_Red.png" style="cursor:pointer;"></td>';
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
</div> <!--- tabs -->