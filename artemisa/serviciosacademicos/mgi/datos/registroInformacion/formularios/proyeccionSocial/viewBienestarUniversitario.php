<script type="text/javascript">
	$(function() {
		$( "#tabs" ).tabs({
                    cache: true,
			beforeLoad: function( event, ui ) {
				ui.jqXHR.error(function() {
					ui.panel.html("Ocurrio un problema cargando el contenido." );
				});
			}
		});
                
                $("#tabs").plusTabs({
   			className: "plusTabs", //classname for css scoping
   			seeMore: true,  //initiate "see more" behavior
   			seeMoreText: "Ver más formularios", //set see more text
   			showCount: true, //show drop down count
   			expandIcon: "&#9660; ", //icon/caret - if using image, specify image width
   			dropWidth: "auto", //width of dropdown
 			sizeTweak: 0 //adjust size of active tab to tweak "see more" layout
   		});
                
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
		<li><a href="formularios/proyeccionSocial/viewBienestarUniversitarioDeporteActividadFisica.php?alias=eadaf_ddbu">Estadísticas área de deportes y actividad física</a></li>
		<li><a href="formularios/proyeccionSocial/viewBienestarUniversitarioSalud.php?alias=eas_ddbu">Estadísticas área de la salud</a></li>
		<li><a href="formularios/proyeccionSocial/viewBienestarUniversitarioCulturaRecreacion.php?alias=eacr_ddbu">Estadísticas área de cultura y recreación</a></li>
		<li><a href="formularios/proyeccionSocial/viewBienestarUniversitarioVoluntariadoUniversitario.php?alias=evu_ddbu">Estadísticas voluntariado universitario</a></li>
		<li><a href="formularios/proyeccionSocial/viewBienestarUniversitarioUsoCuevaTerrazas.php?alias=euct_ddbu">Estadísticas uso de la cueva y las terrazas</a></li>
               <li><a href="#tabs-4">Eventos Masivos</a></li>
	</ul>
    
     <div id="tabs-4" class="formsHuerfanos">
                
                <label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect(); ?>
                
                <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />
                
                <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                
                <div class="vacio"></div>
     
        <table align="center" class="formData last" width="92%" >
                    <thead>            
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="4"><span>Eventos Masivos</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Servicio o actividad</span></th> 
                            <th class="column" ><span>Número de realizaciones mensuales</span></th> 
                            <th class="column" ><span>Participación Aproximada</span></th> 
                            <th class="column" ><span>Opciones</span></th> 
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
                var name = "#tabs-4";
                var periodo = $('#tabs-4 #mes').val()+"-"+$('#tabs-4 #anio').val();
                if(periodo==""){
                    $(name + ' tbody').html("");
                } else {
                    html = "";                    
                     var promise = getDataByDate(name,'formBienestarUniversitarioEventos',periodo,"codigoperiodo");
                     promise.success(function (data) {
                         $(name + ' tbody').html('');
                         //console.log(data);
                         if (data.success == true){
                                 for (var i=0;i<data.total;i++)
                                    {       
                                        html = '<tr class="dataColumns">';
                                        html = html + '<td class="column borderR">'+data.data[i].nombre+'</td>';
                                        html = html + '<td class="column center borderR">'+data.data[i].numRealizaciones+'</td>';
                                        html = html + '<td class="column center borderR">'+data.data[i].participacion+'</td>';
                                        html = html + '<td class="column center eliminarDato"><img width="16" onclick="Eliminar('+data.data[i].idsiq_formBienestarUniversitarioEventos+', \'formBienestarUniversitarioEventos\',\'updateDataIdiomas\')" title="Eliminar Dato" src="../../images/Close_Box_Red.png" style="cursor:pointer;"></td>';
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
    </div><!--- tabs 4 --->
</div>
