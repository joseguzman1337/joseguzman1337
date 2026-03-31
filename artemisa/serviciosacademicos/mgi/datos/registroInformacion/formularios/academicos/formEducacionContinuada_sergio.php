
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
                
                $("#tabs").bind("tabsload",function(event,ui){
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
                $( "#tabs" ).tabs('load',2);    
                
	});
</script>

<div id="tabs" class="dontCalculate">
				<ul>
					<li><a href="#form_uno">Programas ofrecidos por la división</a></li>
					<li><a href="./formularios/academicos/_formEducacionProgramasOfrecidos.php">Número de programas ofrecidos por la división</a></li>
					<li><a href="./formularios/academicos/_formEducacionEstadoProgramas.php">Programas de Educación Continuada (abiertos o cerrados)</a></li>
					<li><a href="./formularios/academicos/_formEducacionUnidadAcademica.php?id=<?php echo $id; ?>">Programas de Educación Continuada por Unidad Académica</a></li>
				</ul>
<div id="form_uno">
	
	<form  method="post" id="program_edu" name="program_edu" action=" ">
	<input type="hidden" name="formulario_edu" value="programas" />
            
            <?php
            
				$query_papa = "select idclasificacion,clasificacion from infoEducacionContinuada where alias='program'";
                $papa= $db->Execute($query_papa);
                $totalRows_papa = $papa->RecordCount();
				$row_papa = $papa->FetchRow();
			?>
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Programas y asistentes ofertados por Educación Continuada</legend>
                
                              
                <div class="vacio"></div>
                
                <label for="nombre" class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
                <?php $utils->getMonthsSelect("mes");  ?>
                
                <label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  
                $utils->pintarBotonCargar("popup_cargarDocumento(14,1,$('#program_edu #mes').val()+'-'+$('#program_edu #anio').val())","popup_verDocumentos(14,1,$('#program_edu #mes').val()+'-'+$('#program_edu #anio').val())");
                    $sectores = $utils->getActives($db,"siq_sectores","idsiq_sectores");
                ?>
            <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo" />
                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="13"><span>Número programas y de asistentes ofertados por la División de Educación Continuada</span></th>                                    
                        </tr>
                         
                        <tr class="dataColumns category">
                            <th class="column borderR" rowspan="3" ><span>Tipos de Programas</span></th>
                    		<th class="column borderR" rowspan="3" ><span>Categoria</span></th>
                    		<th class="column borderR" colspan="5" ><span>Modalidad</span></th>
                    		<th class="column borderR" rowspan="3"><span>Número Asistentes</span></th>
                    		<th class="column borderR" colspan="4" ><span>Componente Internacional</span>
                    		</th>
                    	</tr>
                   		<tr >
                    		<th class="column borderR" colspan="1" rowspan="2" >ABI</th>
                    		<th class="column borderR " colspan="1" rowspan="2">CER</th>	
                    		<th class="column borderR" colspan="1" rowspan="2">PRE</th>
                    		<th class="column borderR"colspan="1" rowspan="2">VIR</th>
                    		<th class="column borderR"colspan="1" rowspan="2">SEMI</th>
                    		<th class="column borderR" colspan="2" >Participantes</th>
                    		<th class="column borderR " colspan="2">Conferencistas</th>
                    		
                    	</tr>
                    		<th class="column borderR" colspan="1" >Pais</th>
                    		<th class="column borderR " colspan="1">Cantidad</th>
                    		<th class="column borderR" colspan="1" >Pais</th>
                    		<th class="column borderR " colspan="1">Cantidad</th>
                    </thead> 
                    	
                    <tbody>              	 
                        <?php 
                     	$query_sectores = "select idclasificacion,clasificacion from infoEducacionContinuada where idpadreclasificacion ='".$row_papa['idclasificacion']."'";
                       	$sectores= $db->Execute($query_sectores);
                     	$totalRows_sectores = $sectores->RecordCount();
		      			$i=0;
		      			while($row_sectores=$sectores->FetchRow()){
							
								?> 
								<tr id="contentColumns" class="row">
								
										<td class="column borderR" ><?php echo $row_sectores['clasificacion']; ?>:<span class="mandatory">(*)</span></td>
					  					<td class="column borderR" >	<?PHP 
											if($row_sectores['idclasificacion']=='43'){
										
					  							 $sql = "select nombrecategorias,idCategorias from programasEducacionContinuada  ";
				                        		
				                        			  $rows = $db->Execute($sql);
				                        			  // idFactor es el nombre del select, el data es el que esta elegido de la lista,
				                        			  //primer false que no se deje una opci�n en blanco, segundo false que no deje elegir m�ltiples opciones
				                        			  //el 1 es si es un listbox o un select,
				                        			  echo $rows->GetMenu2('tipo_categoria[43]',1,false,false,1,'id="idCategorias" style="width:99px" class="required"');
				                        		?></medio" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="7" /></td>			  	      				
												<?php }	?>		
														<input type="hidden" name="tipo_programa[] "value="<?php echo $row_sectores['idclasificacion']; ?>">
														<td class="column borderR center" ><input type="text" class="required number" minlength="" name="num_abierto[]"  title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
														<td class="column borderR center" ><input type="text" class="required number" minlength="" name="num_cerrado[]"  title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
														<td class="column borderR center" ><input type="text" class="required number" minlength="" name="num_pres[]"  title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
														<td class="column borderR center" ><input type="text" class="required number" minlength="" name="num_vir[]"  title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
														<td class="column borderR center" ><input type="text" class="required number" minlength="" name="num_sem[]"  title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
														
														<td class="column borderR center" ><input type="text" class="required number" minlength="" name="cant_asistentes[]"  title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6"/></td> 														
														<td class="column borderR" >
																<?php $sql = "select nombrepais,idpais from pais  ";
								                        		
								                        			  $rows = $db->Execute($sql);
								                        			  // idFactor es el nombre del select, el data es el que esta elegido de la lista,
								                        			  //primer false que no se deje una opci�n en blanco, segundo false que no deje elegir m�ltiples opciones
								                        			  //el 1 es si es un listbox o un select,
								                        			  echo $rows->GetMenu2('pais_parti[]',1,false,false,1,'id="idpais" style="width:86px" class="required"');
								                        		?></medio" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="7" /></td>
														<td class="column borderR" ><input type="text" class="required number" minlength="" name="cant_participantes[]" id="<?php echo $row_sectores['idclasificacion']; ?>" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
														
														
														<td class="column borderR" >
																<?php $sql = "select nombrepais,idpais from pais  ";
								                        		
								                        			  $rows = $db->Execute($sql);
								                        			  // idFactor es el nombre del select, el data es el que esta elegido de la lista,
								                        			  //primer false que no se deje una opci�n en blanco, segundo false que no deje elegir m�ltiples opciones
								                        			  //el 1 es si es un listbox o un select,
								                        			  echo $rows->GetMenu2('pais_confe[]',1,false,false,1,'id="idpais" style="width:86px" class="required"');
								                        		?></medio" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="7" /></td>
														<td class="column borderR" ><input type="text" class="required number" minlength="" name="cant_conferencistas[]" id="<?php echo $row_sectores['idclasificacion']; ?>" title="Número" maxlength="60" tabindex="1" autocomplete="off" size="6" /></td>
														
												</tr>
												
										<?php  }/*while($row_sectores=$sectores->FetchRow())*/?>
                        
                    </tbody>    
                    
                </table>                   
                
               
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            <input type="submit" id="submit_fom_continuada"  name="guardar" value="Guardar datos" class="first" /> 
        </form>
       
</div>
</div>
<script type="text/javascript">
 
$('#submit_fom_continuada').click(function(event) {
	event.preventDefault();
     var valido= validateForm("#program_edu");
     if(valido){
			var dataString = $('#program_edu').serialize();
    		    // alert('Datos serializados: '+dataString);
    	        $.ajax({
    	            type: "POST",
    	            url: "./formularios/academicos/procesarEducacionCon.php?procesID=registrar_formEducacion_Continuada",
    	            async: false,
    				dataType: 'json',
    	            data: dataString,
    	            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    	            success: function(data) {
        	            	
    	            	if(data.val=='FALSE'){
    	                		
    	            		$('#program_edu #msg-success').html('<p>' + data.descrip + '</p>');
    						$('#program_edu #msg-success').addClass('msg-error');
    						$('#program_edu #msg-success').css('display','block');
    	                                        $("#program_edu #msg-success").delay(5500).fadeOut(800);
    							return false;
    	                	}else{	
    	                		
										$('#program_edu #msg-success').html('<p>' + data.descrip + '</p>');
    									$('#program_edu #msg-success').removeClass('msg-error');
										$('#program_edu #msg-success').css('display','block');
                                        $("#program_edu #msg-success").delay(5500).fadeOut(800);
    								document.getElementById("program_edu").reset();
    							}
    	            	
    			     }//if(data.val=='FALSE')
   			     
    	        });//$.ajax
     	}//if(valido)
});//$('#submit_fom_continuada').click(function(event) 


    
</script>









