<script type="text/javascript">
	$(function() {
		$( "#tabs" ).tabs({
                    cache: true,
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
   			seeMoreText: "Ver más formularios", //set see more text
   			showCount: true, //show drop down count
   			expandIcon: "&#9660; ", //icon/caret - if using image, specify image width
   			dropWidth: "auto", //width of dropdown
 			sizeTweak: 0 //adjust size of active tab to tweak "see more" layout
   		});
	});
         
         function getDataDynamic2(formName,entity,periodo,campoPeriodo,entityJoin,campoJoin,actividad){
             return  $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: './formularios/docentes/saveTalentoHumano.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: entity, campoPeriodo: campoPeriodo,entityJoin: entityJoin,joinField:campoJoin,actividad:actividad },     
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        });  
         }
</script>


<div id="tabs" class="dontCalculate">
				<ul>
					<li><a href="./formularios/financieros/viewPresupuestoTodo.php?padre=PPROGDESPROF">Desarrollo Profesoral</a></li>
					<li><a href="./formularios/financieros/viewPresupuestoTodo.php?padre=P_INV_A_CON">Investigación, por Áreas del Conocimiento</a></li>
					<li><a href="./formularios/financieros/viewPresupuestoBienestar.php">Presupuesto Programas de Bienestar</a></li>
					<li><a href="./formularios/financieros/viewPresupuestoTodo.php?padre=P_BIBLIO">Biblioteca</a></li>
					<li><a href="./formularios/financieros/viewPresupuestoTodo.php?padre=P_FIN_INST">Financiamiento Institucional</a></li>
                    <li><a href="#tabs-1">Fuentes de los Recursos</a></li>
				</ul>


<div id="tabs-1" class="formsHuerfanos">
         <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>

                    <input type="button" value="Consultar" class="consultar buttonForm first small" style="padding: 3px 19px 4px;margin-left:5%;" />
                    
                    <div class="vacio"></div>
     <table align="center" class="formData viewData" width="100%" >         
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="3"><span>Fuentes de los Recursos</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column" ><span>Fuentes de financiamiento</span></th> 
                            <th class="column" ><span>Presupuestado</span></th> 
                            <th class="column" ><span>Ejecutado</span></th> 
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
                    var name = "#tabs-13";
						var periodo = $(name + ' #anio').val();
						var actividad = 1;
						if(periodo==""){
							$(name + ' tbody').html("");
						} else {
							html = "";                    
							 var promise = getDataDynamic2(name,'formPresupuestoRecursos',periodo,"codigoperiodo","siq_tipoRecursosPresupuesto","idsiq_tipoRecursosPresupuesto",
							 actividad);
							 promise.success(function (data) {
								console.log(data);
								 $(name + ' tbody').html('');
								 if (data.success == true){
										 for (var i=0;i<data.total;i++)
											{       
												html = '<tr class="dataColumns">';
												html = html + '<td class="column borderR">'+data.data[i].nombrefacultad+'</td>';
												html = html + '<td class="column center borderR">'+data.data[i].valor+'</td>';
												html = html + '</tr>';
												$(name + ' tbody').append(html);
											   
											}
									}
									else{  
										$(name + ' tbody').html('<tr><td colspan="2" class="center">No se encontraron datos.</td></tr>');
									}                         
							  });
							  
						}
                }

            </script>
    
</div><!-- tab 1-->
</div>
