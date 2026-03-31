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
                $("#tabs").tabs({ cache:true });
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
	});
</script>
<style>
	.td_Class{border:#FFF 1px solid;}
</style>
<div id="tabs" class="dontCalculate">
				<ul>
					<li><a href="./formularios/investigacion/_formInvestigacionesGruposInvestigacion.php?id=<?php echo $id; ?>">Grupos de investigación </a></li>
                                        <li><a href="#tabs-10">Grupos de investigación<br/>por Áreas de Conocimiento</a></li>
					<li><a href="./formularios/investigacion/_formInvestigacionesProyectosInternos.php?id=<?php echo $id; ?>">Proyectos de Investigación<br/>(convocatorias internas) </a></li>
					<li><a href="./formularios/investigacion/_formInvestigacionesProyectosExternos.php?id=<?php echo $id; ?>">Financiación de proyectos a<br/>través de entidades externas</a></li>
					<li><a href="./formularios/investigacion/_formInvestigacionesProyectosColciencias.php?id=<?php echo $id; ?>">Proyectos presentados y aprobados en Colciencias</a></li>
                    <li><a href="#tabs-6">Publicaciones periódicas de la Universidad </a></li>
                    <li><a href="#tabs-7">Número de Semilleros </a></li>
				</ul>


<div id="tabs-6">
    <?php $year = date("Y");
           $sql = 'SELECT * FROM publicacionesperiodicas WHERE periosidaanual = "'.$year.'" AND codigoestado=100';
           $resultRow = $db->GetRow($sql); 
           
           $sql = 'SELECT * FROM verificar_publicacionesperiodicas WHERE codigoperiodo = "'.$year.'" AND codigoestado=100';
           $resultRowVerificar = $db->GetRow($sql); 
           
           ?>
	<span class="mandatory">* Son campos obligatorios</span>
    <form id="DatosFormularioPublicaciones" name="DatosFormulario">
        <fieldset>   
            <legend>Publicaciones periódicas de la Universidad</legend>
			<label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
            	 <table border="0" width="92%" align="center" class="formData" >
                 	<thead>
                        <tr>
                            <th>Clasificación de publicaciones Colciencias</th>
                            <th>Número de Revistas</th>
                            <th>Dato validado</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?PHP //Campo('Categoria_A1','Indexada Categoría A1 de Colciencias')?>
                       <?PHP //Campo('Categoria_A2','Indexada Categoría A2 de Colciencias')?>
                       <?PHP //Campo('Categoria_B','Indexada Categoría B de Colciencias')?>
                       <?PHP //Campo('Categoria_C','Indexada Categoría C de Colciencias (vigentes)')?>
                       <?PHP //Campo('Indexacion','En proceso de Indexación')?>
                       <?php CampoValidar('Indexada','Indexada','','',$resultRow["indexadas"],$resultRowVerificar["vIndexadas"])?>
                       <?php CampoValidar('No_Indexada','No indexada','','',$resultRow["no_indexada"],$resultRowVerificar["vNo_indexada"])?>
                    </tbody>
                 </table>
        </fieldset>
        <input type="button" id="Guardar" value="Guardar datos" class="submit first" onclick="ValidaClasificaciones()" />
   </form>         
</div>
<div id="tabs-7">
	<span class="mandatory">* Son campos obligatorios</span>
    <form id="DatosFormularioSemilleros" name="DatosFormularioSemilleros">
	<input type="hidden" name="action" value="Semilleros" />
        <fieldset>   
            <legend>Número de Semilleros</legend>
			<label for="nombre" class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
                <?php $utils->getYearsSelect("anio");  ?>
			
            	 <table border="0" width="92%" align="center" class="formData" >
                 	<thead>
                        <tr>
                        	<th>N&deg;</th>
                            <th>Programas</th>
                            <th>Número de Semilleros</th>
                            <th>Dato validado</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?PHP Carrera(200);//Pregrado?>
                    </tbody>
                 </table>
        </fieldset>
        <input type="button" id="Guardar" value="Guardar datos" class="submit first" onclick="ValidaSemilleros()" />
   </form>         
</div>
    
    <div id="tabs-10">
            
            <span class="mandatory">* Son campos obligatorios</span>
            <form id="DatosFormulario" name="DatosFormulario">
                <fieldset>   
                    <legend>Grupos de investigación</legend>
                    
                    <?PHP Tabla_2('Grupos de Investigación de la Universidad El Bosque por Áreas del Conocimiento','Área del Conocimiento','N&deg; de Grupos',$db)?>
                      
                </fieldset>
                <input type="button" id="Save" value="Guardar datos" class="submit first" onclick="GuardarTablesAreas()" />
            </form>    
            
            
</div><!--- tab 10 -->
</div>
<?PHP 
function Carrera($dato){
		
		include("../../../templates/template.php");
		global $userid,$db;
	    
                $currentdate  = date("Y-m-d H:i:s");
		
		 $SQL_Carrera='SELECT 
						
						codigocarrera as id,
						nombrecarrera 
						
						FROM 
						
						carrera
						
						WHERE
						
						codigomodalidadacademicasic="'.$dato.'"
						AND
						codigocarrera  NOT IN (1, 2) AND fechavencimientocarrera>"'.$currentdate.'"';
						
				if($D_Carrera=&$db->Execute($SQL_Carrera)===false){
						echo 'Error en el SQL de Completar Carrera...<br>'.$SQL_Carrera;
						die;
					}	
			$j=1;
			while(!$D_Carrera->EOF){
                            $year = date("Y");
                            $sql = 'SELECT * FROM semillerosinvestigacion WHERE carrera_id ='.$D_Carrera->fields['id'].' AND periosidaanual = "'.$year.'" AND codigoestado=100';
                            $resultRow = $db->GetRow($sql);
                            
                            $sql = 'SELECT * FROM verificar_semillerosinvestigacion WHERE codigocarrera ='.$D_Carrera->fields['id'].' AND codigoperiodo = "'.$year.'" AND codigoestado=100';
                            $resultRowVerificar = $db->GetRow($sql);
                            //var_dump($sql); echo "<br/><br/>";
                            /*******************************************/
				CampoNewValidar('Semillero_num_',$D_Carrera->fields['nombrecarrera'],$j,$D_Carrera->fields['id'],$resultRow["num_semillero"],$resultRowVerificar["vnum_semillero"],"");
				/*******************************************/
				$D_Carrera->MoveNext();
				$j++;
				}
			
			?>
            <input type="hidden" id="Index" value="<?PHP echo $j?>" />
            <input type="hidden" id="Cadena" />
  	<?PHP          		
	}
function CampoNew($Name,$Label_1,$i,$CodigoCarrera){
	
	?>
    <tr class="dataColumns">
    	<td class="column" style="border:#000000 solid 1px" ><?PHP echo $i?></td>
        <td class="column" ><?PHP echo $Label_1?><input type="hidden" id="CodigoCarrera_<?PHP echo $i?>" value="<?PHP echo $CodigoCarrera?>" /></td>
        <td class="column center" ><input type="text" class="required number" id="<?PHP echo $Name?><?PHP echo $i?>" name="<?PHP echo $Name?><?PHP echo $i?>" onkeypress="return isNumberKey(event)" value="0"  style="text-align:center" onclick="FormatCampo('<?PHP echo $Name?><?PHP echo $i?>')" /></td>
    </tr>
    
    <?PHP
	}
        
function CampoNewValidar($Name,$Label_1,$i,$CodigoCarrera,$value,$checked,$disable="disable"){
	
	?>
    <tr class="dataColumns">
    	<td class="column" style="border:#000000 solid 1px" ><?PHP echo $i?></td>
        <td class="column" ><?PHP echo $Label_1?><input type="hidden" id="CodigoCarrera_<?PHP echo $i?>" name="carrera[]" value="<?php echo $CodigoCarrera; ?>" /></td>
        <td class="column center" ><input type="text" class="required number <?php echo $disable; ?>" id="<?PHP echo $Name.$CodigoCarrera ?>" name="<?php echo $Name.$CodigoCarrera; ?>" onkeypress="return isNumberKey(event)" value="<?php echo $value; ?>"  style="text-align:center" <?php if($disable!=""){ echo "readonly"; }?> /></td>
        <td class="column center" ><input type="checkbox" name="v<?php echo $Name.$CodigoCarrera; ?>" value="1" id="v<?PHP echo $Name.$CodigoCarrera; ?>" <?php if($checked) { echo "checked"; } ?>></td>
    </tr>
    
    <?PHP
	}
        
function CampoDisable($Name,$Label_1){
	?>
    <tr class="dataColumns">
        <th class="column" >&nbsp;&nbsp;&nbsp;&nbsp;<strong><?PHP echo $Label_1?></strong></td>
        <td class="column center" ><input type="text" class="required number" id="<?PHP echo $Name?>" name="<?PHP echo $Name?>" onkeypress="return isNumberKey(event)" style="text-align:center" readonly="readonly" /></td>
    </tr>
   <?php 
}
function Campo($Name,$Label_1,$F='',$v=''){
	if($F==0){
			$Funcion = 'onchange="Divide('.$v.')"';
		}else{
			$Funcion = '';
			}
	?>
    <tr class="dataColumns">
        <td class="column" >&nbsp;&nbsp;&nbsp;&nbsp;* <?PHP echo $Label_1?>&nbsp;&nbsp;<span style="color:#FF0000; font-size:8px">*</span></td>
        <td class="column center" ><input type="text" class="required number" id="<?PHP echo $Name?>" name="<?PHP echo $Name?>" onkeypress="return isNumberKey(event)" value="0"  <?PHP echo $Funcion?>  style="text-align:center" onclick="FormatCampo('<?PHP echo $Name?>')" /></td>
    </tr>
    
    <?PHP
	}
        
function CampoValidar($Name,$Label_1,$F='',$v='',$value='',$checked=0){
	if($F==0){
			$Funcion = 'onchange="Divide('.$v.')"';
		}else{
			$Funcion = '';
			}
	?>
    <tr class="dataColumns">
        <td class="column" >&nbsp;&nbsp;&nbsp;&nbsp;* <?PHP echo $Label_1?>&nbsp;&nbsp;<span style="color:#FF0000; font-size:8px">*</span></td>
        <td class="column center" ><input type="text" class="required number disable" id="<?PHP echo $Name?>" name="<?PHP echo $Name?>" onkeypress="return isNumberKey(event)" value="<?php echo $value; ?>"  <?PHP echo $Funcion; ?>  style="text-align:center" readonly /></td>
        <td class="column center" ><input type="checkbox" name="<?php echo 'v'.$Name; ?>" value="1" id="<?php echo 'v'.$Name; ?>" <?php if($checked){ echo "checked"; } ?>></td>
    </tr>
    
    <?PHP
	}	
        function Tabla_2($Titulo,$Sub_Titulo,$Sub_Titulo2,$db=null){
	?>
    <?php $year = date("Y");
           $sql = 'SELECT * FROM areasconocimientocolciencias WHERE periosidaanual = "'.$year.'" AND codigoestado=100';
           $resultRow = $db->GetRow($sql); 
           
           $sql = 'SELECT * FROM verificar_areasconocimientocolciencias WHERE codigoperiodo = "'.$year.'" AND codigoestado=100';
           $resultRowVerificar = $db->GetRow($sql); 
           
           ?>
    <table border="0" width="92%" align="center" class="formData" >
        <thead>   
            <tr class="dataColumns">
                <th class="column" colspan="3"><span><?PHP echo $Titulo?></span></th>                                    
            </tr>
            <tr class="dataColumns category">
                <th class="column" ><span><?PHP echo $Sub_Titulo?></span></th>
                <th class="column center" ><span><?PHP echo $Sub_Titulo2?></span></th>
                <th>Dato validado</th>
            </tr>
        </thead>
        <tbody>
            <?PHP CampoValidar('CienciaSalud','Ciencias Naturales y de la Salud','','',$resultRow["CienciasSalud"],$resultRowVerificar["vCienciasSalud"])?>
            <?PHP CampoValidar('CienciasSociales','Ciencias Sociales y Humanidades','','',$resultRow["CienciasSociales"],$resultRowVerificar["vCienciasSociales"])?>
            <?PHP CampoValidar('Ingenierias','Ingeniería y Administración','','',$resultRow["Ingenierias"],$resultRowVerificar["vIngenierias"])?>
            <?PHP CampoValidar('letrasArtes','Arte y Diseño','','',$resultRow["letrasArtes"],$resultRowVerificar["vLetrasArtes"])?>
        </tbody>
    </table>
    <?PHP
	}
function CampoDinamico($num,$Op){
if($Op==0){	
	?>
    <tr>
        <th><strong><?PHP echo $num?><input type="hidden" id="DatosInter_<?PHP echo $num?>"  /></strong></th>
        <td class="column center"><input type="text" class="required number" id="presentados_inter_<?PHP echo $num?>" name="presentados_inter_<?PHP echo $num?>" onkeypress="return isNumberKey(event)" placeholder="Presentados <?PHP echo $num?>" style="text-align:center" /></td>
        <td class="column center"><input type="text" class="required number" id="aprobados_inter_<?PHP echo $num?>" name="aprobados_inter_<?PHP echo $num?>" onkeypress="return isNumberKey(event)" placeholder="Aprobados <?PHP echo $num?>" style="text-align:center" /></td>
        <td class="column center"><input type="text" class="required number" id="finalizados_inter_<?PHP echo $num?>" name="finalizados_inter_<?PHP echo $num?>" onkeypress="return isNumberKey(event)" placeholder="Finalizados <?PHP echo $num?>" style="text-align:center" /></td>
    </tr>
    <?PHP
}else{
		?>
         <tr>
            <th><strong><?PHP echo $num?><input type="hidden" id="DatosNal_<?PHP echo $num?>"  /></strong></th>
            <td class="column center"><input type="text" class="required number" id="presentados_<?PHP echo $num?>" name="presentados_<?PHP echo $num?>" onkeypress="return isNumberKey(event)" placeholder="Presentados <?PHP echo $num?>" style="text-align:center" /></td>
            <td class="column center"><input type="text" class="required number" id="aprobados_<?PHP echo $num?>" name="aprobados_<?PHP echo $num?>" onkeypress="return isNumberKey(event)" placeholder="Aprobados <?PHP echo $num?>" style="text-align:center" /></td>
            <td class="column center"><input type="text" class="required number" id="finalizados_<?PHP echo $num?>" name="finalizados_<?PHP echo $num?>" onkeypress="return isNumberKey(event)" placeholder="Finalizados <?PHP echo $num?>" style="text-align:center" /></td>
        </tr>
        <?PHP
		}
	}
function Dinamico($num,$Op){
	if($Op==0){
		?>
        <tr>
            <th>&nbsp;<strong><?PHP echo $num?><input type="hidden" id="D_Nacional_<?PHP echo $num?>"  /></strong>&nbsp;</th>
            <td class="column center">
                <table border="0" align="center" width="100%" style="border:#FFF solid 1px">
                    <tr>
                        <td style="border:#FFF solid 1px" align="center">
                            <table border="0" align="center" width="100%" style="border:#FFF solid 1px">
                                <tr>
                                    <td  class="column center" style="border:#FFF solid 1px"><input type="text" class="required number" id="Presentado_<?PHP echo $num?>" name="Presentado_<?PHP echo $num?>" onkeypress="return isNumberKey(event)" placeholder="" style="text-align:center" /></td>
                                    <td class="column center" style="border:#FFF solid 1px"><input type="text" class="required number" id="Aprobados_<?PHP echo $num?>" name="Aprobados_<?PHP echo $num?>" onkeypress="return isNumberKey(event)" placeholder="" style="text-align:center" /></td>
                                    <td class="column center" style="border:#FFF solid 1px"><input type="text" class="required number" id="Finalizados_<?PHP echo $num?>" name="Finalizados_<?PHP echo $num?>" onkeypress="return isNumberKey(event)" placeholder="" style="text-align:center" /></td>
                                    <td class="column center" style="border:#FFF solid 1px"><input type="text" class="required number" id="Valor_<?PHP echo $num?>" name="Valor_<?PHP echo $num?>" onkeypress="return isNumberKey(event)" placeholder="" style="text-align:center" /></td>
                                </tr>
                            </table>	
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <?PHP
		}else{
		?>
        <tr>
            <th>&nbsp;<strong><?PHP echo $num; ?></strong>&nbsp;<input type="hidden" id="D_Inter_<?PHP echo $num?>"  /></th>
            <td class="column center">
                <table border="0" align="center" width="100%" style="border:#FFF solid 1px">
                    <tr>
                        <td style="border:#FFF solid 1px" align="center">
                            <table border="0" align="center" width="100%" style="border:#FFF solid 1px">
                                <tr>
                                    <td  class="column center" style="border:#FFF solid 1px"><input type="text" class="required number" id="Presentado_Inter_<?PHP echo $num?>" name="Presentado_Inter_<?PHP echo $num?>" onkeypress="return isNumberKey(event)" placeholder="" style="text-align:center" /></td>
                                    <td class="column center" style="border:#FFF solid 1px"><input type="text" class="required number" id="Aprobados_Inter_<?PHP echo $num?>" name="Aprobados_Inter_<?PHP echo $num?>" onkeypress="return isNumberKey(event)" placeholder="" style="text-align:center" /></td>
                                    <td class="column center" style="border:#FFF solid 1px"><input type="text" class="required number" id="Finalizados_Inter_<?PHP echo $num?>" name="Finalizados_Inter_<?PHP echo $num?>" onkeypress="return isNumberKey(event)" placeholder="" style="text-align:center" /></td>
                                    <td class="column center" style="border:#FFF solid 1px"><input type="text" class="required number" id="Valor_Inter_<?PHP echo $num?>" name="Valor_Inter_<?PHP echo $num?>" onkeypress="return isNumberKey(event)" placeholder="" style="text-align:center" /></td>
                                </tr>
                            </table>	
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <?PHP	
			}
	}		
function Dinamico_2($num,$Op){
	if($Op==0){
		?>
        <tr>
            <th>&nbsp;<strong><?PHP echo $num; ?><input type="hidden" id="D_Nal_<?PHP echo $num?>"  /></strong>&nbsp;</th>
            <td class="column center">
                <table border="0" align="center" width="100%" style="border:#FFF solid 1px">
                    <tr>
                        <td style="border:#FFF solid 1px" align="center">
                            <table border="0" align="center" width="100%" style="border:#FFF solid 1px">
                                <tr>
                                    <td  class="column center" style="border:#FFF solid 1px"><input type="text" class="required number" id="Present_<?PHP echo $num?>" name="Present_<?PHP echo $num?>" onkeypress="return isNumberKey(event)" placeholder="" style="text-align:center" /></td>
                                    <td class="column center" style="border:#FFF solid 1px"><input type="text" class="required number" id="Aproba_<?PHP echo $num?>" name="Aproba_<?PHP echo $num?>" onkeypress="return isNumberKey(event)" placeholder="" style="text-align:center" /></td>
                                    <td class="column center" style="border:#FFF solid 1px"><input type="text" class="required number" id="Final_<?PHP echo $num?>" name="Final_<?PHP echo $num?>" onkeypress="return isNumberKey(event)" placeholder="" style="text-align:center" /></td>
                                    <td class="column center" style="border:#FFF solid 1px"><input type="text" class="required number" id="ValorTotal_<?PHP echo $num?>" name="ValorTotal_<?PHP echo $num?>" onkeypress="return isNumberKey(event)" placeholder="" style="text-align:center" /></td>
                                </tr>
                            </table>	
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <?PHP
		}else{
		?>
        <tr>
            <th>&nbsp;<strong><?php echo $num; ?></strong>&nbsp;<input type="hidden" id="D_Int_<?PHP echo $num?>"  /></th>
            <td class="column center">
                <table border="0" align="center" width="100%" style="border:#FFF solid 1px">
                    <tr>
                        <td style="border:#FFF solid 1px" align="center">
                            <table border="0" align="center" width="100%" style="border:#FFF solid 1px">
                                <tr>
                                    <td  class="column center" style="border:#FFF solid 1px"><input type="text" class="required number" id="Present_Inter_<?PHP echo $num?>" name="Present_Inter_<?PHP echo $num?>" onkeypress="return isNumberKey(event)" placeholder="" style="text-align:center" /></td>
                                    <td class="column center" style="border:#FFF solid 1px"><input type="text" class="required number" id="AprobaInter_<?PHP echo $num?>" name="AprobaInter_<?PHP echo $num?>" onkeypress="return isNumberKey(event)" placeholder="" style="text-align:center" /></td>
                                    <td class="column center" style="border:#FFF solid 1px"><input type="text" class="required number" id="Final_Inter_<?PHP echo $num?>" name="Final_Inter_<?PHP echo $num?>" onkeypress="return isNumberKey(event)" placeholder="" style="text-align:center" /></td>
                                    <td class="column center" style="border:#FFF solid 1px"><input type="text" class="required number" id="ValorTotal_Inter_<?PHP echo $num?>" name="ValorTotal_Inter_<?PHP echo $num?>" onkeypress="return isNumberKey(event)" placeholder="" style="text-align:center" /></td>
                                </tr>
                            </table>	
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <?PHP	
			}
	}		
	
?>
<script type="text/javascript">
                /*$(':submit').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_test");
                    if(valido){
                        sendForm();
                    }
                });

                function sendForm(){
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process.php',
                        data: $('#form_test').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                 window.location.href="index.php";
                            }
                            else{                        
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });            
                }*/
				
	/*****************************************************************************************/			
	
        function GuardarTablesAreas(){
            /*********************************************************************/
			/**************************Tabla Dos**********************************/	
			/*********************************************************************/
			
			if(!$.trim($('#CienciaSalud').val())){
					
					var msn = 'Ingrese el Numero de Grupos de Area del Conocimiento Ciencias de la Salud';
					alert(msn);
					$('#CienciaSalud').css('border-color','#F00');
					$('#CienciaSalud').effect("pulsate", {times:3}, 500);
					return false;
					
				}	
				
			
			/*********************************************************************/	
			
			if(!$.trim($('#CienciasSociales').val())){
					
					var msn = 'Ingrese el Numero de Grupos de Area del Conocimiento Ciencias Sociales';
					alert(msn);
					$('#CienciasSociales').css('border-color','#F00');
					$('#CienciasSociales').effect("pulsate", {times:3}, 500);
					return false;
					
				}	
				
			/*********************************************************************/	
			
			if(!$.trim($('#Ingenierias').val())){
					
					var msn = 'Ingrese el Numero de Grupos de Area del Conocimiento Ingenierias';
					alert(msn);
					$('#Ingenierias').css('border-color','#F00');
					$('#Ingenierias').effect("pulsate", {times:3}, 500);
					return false;
					
				}	
				
			/*********************************************************************/	
			
			if(!$.trim($('#letrasArtes').val())){
					
					var msn = 'Ingrese el Numero de Grupos de Area del Conocimiento Linguistica, letras y artes';
					alert(msn);
					$('#letrasArtes').css('border-color','#F00');
					$('#letrasArtes').effect("pulsate", {times:3}, 500);
					return false;
					
				}	
				
			/*********************************************************************/		
			
                        var Salud = $('#CienciaSalud').val();
			var Sociales = $('#CienciasSociales').val();
			var Ingenierias = $('#Ingenierias').val();
			var Letras = $('#letrasArtes').val();
                        
                        var Salud	= $('#vCienciaSalud').is(':checked') ? 1: 0;
                        var Sociales	= $('#vCienciasSociales').is(':checked') ? 1: 0;
                        var Ingenierias	= $('#vIngenierias').is(':checked') ? 1: 0;
                        var Letras	= $('#vletrasArtes').is(':checked') ? 1: 0;
                        
                        $.ajax({//Ajax
					  type: 'GET',
					  url: 'formularios/investigacion/viewInvestigaciones.php',
					  async: false,
					  dataType: 'json',
					  data:({actionID:'Save',Salud:Salud,
											 Sociales:Sociales,
											 Ingenierias:Ingenierias,
											 Letras:Letras}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
						 	if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else if(data.val=='TRUE'){
										alert(data.descrip);
										location.href="index.php";
										
									}else if(data.val=='EXISTE'){
										alert(data.descrip);
										location.href="index.php";
										}
					  
				   }
		   		}); //AJAX
        }
        
	function GuardarTables(){
			
		
			
			if(!$.trim($('#campo_seis').val()) || $('#campo_seis').val()==0){
					
					var msn = 'Ingrese el Numero Grupos Reconocidos COLCIENCIAS y diferente de Cero ';
					alert(msn);
					$('#campo_seis').css('border-color','#F00');
					$('#campo_seis').effect("pulsate", {times:3}, 500);
					return false;
					
				}	
				
			/*********************************************************************/		
			/*********************************************************************/	
			
			if(!$.trim($('#campo_siete').val()) || $('#campo_siete').val()==0){
					
					var msn = 'Ingrese el Numero Grupos avalados por la UEB sin reconocimiento y diferente de Cero';
					alert(msn);
					$('#campo_siete').css('border-color','#F00');
					$('#campo_siete').effect("pulsate", {times:3}, 500);
					return false;
					
				}	
				
			/*********************************************************************/	
			
			if(!$.trim($('#Grupo_r').val()) || $('#Grupo_r').val()==0){
					
					var msn = 'Ingrese el Numero de Grupos de Investigación de la Universidad reconocidos por Colciencias y diferente de Cero';
					alert(msn);
					$('#Grupo_r').css('border-color','#F00');
					$('#Grupo_r').effect("pulsate", {times:3}, 500);
					return false;
					
				}	
				
			/*********************************************************************/		
			/*********************************************************************/	
			
			if(!$.trim($('#Num_Total').val()) || $('#Num_Total').val()==0){
					
					var msn = 'Ingrese el Número total de grupos reconocidos por Colciencias y diferente de Cero';
					alert(msn);
					$('#Num_Total').css('border-color','#F00');
					$('#Num_Total').effect("pulsate", {times:3}, 500);
					return false;
					
				}	
			
			var C_Seis = $('#campo_seis').val();
			var C_siete = $('#campo_siete').val();
			
			var Grupo_r		= $('#Grupo_r').val();
			var Num_Total	= $('#Num_Total').val();
			
			   $.ajax({//Ajax
					  type: 'GET',
					  url: 'formularios/investigacion/viewInvestigaciones.php',
					  async: false,
					  dataType: 'json',
					  data:({actionID:'Save',C_Seis:C_Seis,
											 C_siete:C_siete,
											 Grupo_r:Grupo_r,
											 Num_Total:Num_Total}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
						 	if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else if(data.val=='TRUE'){
										alert(data.descrip);
										location.href="index.php";
										
									}else if(data.val=='EXISTE'){
										alert(data.descrip);
										location.href="index.php";
										}
					  
				   }
		   		}); //AJAX
						
		}   
	function isNumberKey(evt){
			var e = evt; 
			var charCode = (e.which) ? e.which : e.keyCode
				console.log(charCode);
				
				//el comentado me acepta negativos
			//if ( (charCode > 31 && (charCode < 48 || charCode > 57)) ||  charCode == 109 || charCode == 173 )
				if( charCode > 31 && (charCode < 48 || charCode > 57) ){
					//si no es - ni borrar
					if((charCode!=8 && charCode!=45)){
						return false;
					}
				}
		
			return true;
		
	}
	function ValidaFinanciero(){
		/****************************************************************/
			var year = $('#year_actual').val();
			
			var num = parseInt(year)-3;
			
			for(num;num<=year;num++){
				/************************************************************/
					if(!$.trim($('#presentados_'+num).val()) && !$.trim($('#aprobados_'+num).val()) && !$.trim($('#finalizados_'+num).val())){
							alert('Digite un dato con referencia al a\u00f1o  Car\u00e1cter Nacional '+num);
							$('#presentados_'+num).css('border-color','#F00');
							$('#presentados_'+num).effect("pulsate", {times:3}, 500);
							$('#aprobados_'+num).css('border-color','#F00');
							$('#aprobados_'+num).effect("pulsate", {times:3}, 500);
							$('#finalizados_'+num).css('border-color','#F00');
							$('#finalizados_'+num).effect("pulsate", {times:3}, 500);
							return false;
						}
					
				/************************************************************/
				}
				
			var year2 = $('#year_actual').val();
			
			var num2 = parseInt(year2)-3;	
			for(num2;num2<=year;num2++){
				/************************************************************/
					if(!$.trim($('#presentados_inter_'+num2).val()) && !$.trim($('#aprobados_inter_'+num2).val()) && !$.trim($('#finalizados_inter_'+num2).val())){
							alert('Digite un dato con referencia al a\u00f1o Car\u00e1cter Internacional '+num2);
							$('#presentados_inter_'+num2).css('border-color','#F00');
							$('#presentados_inter_'+num2).effect("pulsate", {times:3}, 500);
							$('#aprobados_inter_'+num2).css('border-color','#F00');
							$('#aprobados_inter_'+num2).effect("pulsate", {times:3}, 500);
							$('#finalizados_inter_'+num2).css('border-color','#F00');
							$('#finalizados_inter_'+num2).effect("pulsate", {times:3}, 500);
							return false;
						}
					
				/************************************************************/
				}	
				
			SaveFinaciero();	
		/****************************************************************/
		}
	function SaveFinaciero(){
			
			var year = $('#year_actual').val();
			
			var num = parseInt(year)-3;
			
			for(num;num<=year;num++){
				/************************************************************/
					if($.trim($('#presentados_'+num).val())){
						/**********************************************/
							$('#DatosNal_'+num).val($('#DatosNal_'+num).val()+'-Presentados-'+num+'-'+$('#presentados_'+num).val());
						/**********************************************/
						}
					if($.trim($('#aprobados_'+num).val())){
						/**********************************************/
							$('#DatosNal_'+num).val($('#DatosNal_'+num).val()+'-Aprobados-'+num+'-'+$('#aprobados_'+num).val());
						/**********************************************/
						}
					if($.trim($('#finalizados_'+num).val())){
						/**********************************************/
							$('#DatosNal_'+num).val($('#DatosNal_'+num).val()+'-Finalizados-'+num+'-'+$('#finalizados_'+num).val());
						/**********************************************/	
						}
					
				/************************************************************/
				}
				
			/*##############################################################################################*/	
			
			var year2 = $('#year_actual').val();
			
			var num2 = parseInt(year2)-3;	
			for(num2;num2<=year;num2++){
				/************************************************************/
					
					if($.trim($('#presentados_inter_'+num2).val())){
						/**********************************************/
							$('#DatosInter_'+num2).val($('#DatosInter_'+num2).val()+'-PresentadosInternacional-'+num2+'-'+$('#presentados_inter_'+num2).val());
						/**********************************************/
						}
					if($.trim($('#aprobados_inter_'+num2).val())){
						/**********************************************/
							$('#DatosInter_'+num2).val($('#DatosInter_'+num2).val()+'-AprobadosInternacional-'+num2+'-'+$('#aprobados_inter_'+num2).val());
						/**********************************************/
						}
					if($.trim($('#finalizados_inter_'+num2).val())){
						/**********************************************/
							$('#DatosInter_'+num2).val($('#DatosInter_'+num2).val()+'-FinalizadosInternacional-'+num2+'-'+$('#finalizados_inter_'+num2).val());
						/**********************************************/	
						}	
					
				/************************************************************/
				}	
			/*##############################################################################################*/	
			var year = $('#year_actual').val();
			
			var num = parseInt(year)-3;
			
			for(num;num<=year;num++){
				
					if($.trim($('#DatosNal_'+num).val())){
						
							 $('#Cadena_nacional').val( $('#Cadena_nacional').val()+'::'+$('#DatosNal_'+num).val());
						
						}
				
				}
				
			var year2 = $('#year_actual').val();
			
			var num2 = parseInt(year2)-3;	
			for(num2;num2<=year;num2++){
				
					if($.trim($('#DatosInter_'+num2).val())){
							
							$('#Cadena_internacional').val($('#Cadena_internacional').val()+'::'+$('#DatosInter_'+num2).val());
							
						}
				
				}	
			/*##############################################################################################*/
			/*******************************************/	
			var Cadena_nacional 	 = $('#Cadena_nacional').val();
			var Cadena_internacional = $('#Cadena_internacional').val();
			/*******************************************/
			
			/****************************Ajax***********************************/	
			 $.ajax({//Ajax
					  type: 'GET',
					  url: 'formularios/investigacion/viewInvestigaciones.php',
					  async: false,
					  dataType: 'json',
					  data:({actionID:'FinaciacionSave',Cadena_nacional:Cadena_nacional,
													    Cadena_internacional:Cadena_internacional,
														year:year,
														year2:year2}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
						 	if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else if(data.val=='TRUE'){
										alert(data.descrip);
										location.href="index.php";
										
									}else if(data.val=='EXISTE'){
										alert(data.descrip);
										location.href="index.php";
										}
					  
				   }
		   		}); //AJAX
			/****************************Fin Ajax*******************************/
			
		}	
	function ValidaConvocatorias(){
		/****************************************************************/
			var year = $('#year_actual').val();
			
			var num = parseInt(year)-3;
			
			for(num;num<=year;num++){
				/************************************************************/
					if(!$.trim($('#Presentado_'+num).val()) && !$.trim($('#Aprobados_'+num).val()) && !$.trim($('#Finalizados_'+num).val())){
							alert('Digite un dato con referencia al a\u00f1o  Car\u00e1cter Nacional '+num);
							$('#Presentado_'+num).css('border-color','#F00');
							$('#Presentado_'+num).effect("pulsate", {times:3}, 500);
							$('#Aprobados_'+num).css('border-color','#F00');
							$('#Aprobados_'+num).effect("pulsate", {times:3}, 500);
							$('#Finalizados_'+num).css('border-color','#F00');
							$('#Finalizados_'+num).effect("pulsate", {times:3}, 500);
							
							return false;
						}
					
					if(!$.trim($('#Valor_'+num).val())){
						alert('Digite el Valor para el a\u00f1o Nacional '+num);
							$('#Valor_'+num).css('border-color','#F00');
							$('#Valor_'+num).effect("pulsate", {times:3}, 500);
							return false;
						}		
					
				/************************************************************/
				}
				
			var year2 = $('#year_actual').val();
			
			var num2 = parseInt(year2)-3;	
			for(num2;num2<=year;num2++){
				/************************************************************/
					if(!$.trim($('#Presentado_Inter_'+num2).val()) && !$.trim($('#Aprobados_Inter_'+num2).val()) && !$.trim($('#Finalizados_Inter_'+nnum2um).val())){
							alert('Digite un dato con referencia al a\u00f1o Car\u00e1cter Internacional '+num2);
							$('#Presentado_Inter_'+num2).css('border-color','#F00');
							$('#Presentado_Inter_'+num2).effect("pulsate", {times:3}, 500);
							$('#Aprobados_Inter_'+num2).css('border-color','#F00');
							$('#Aprobados_Inter_'+num2).effect("pulsate", {times:3}, 500);
							$('#Finalizados_Inter_'+num2).css('border-color','#F00');
							$('#Finalizados_Inter_'+num2).effect("pulsate", {times:3}, 500);
							
							return false;
						}
					
					if(!$.trim($('#Valor_Inter_'+num2).val())){
							alert('Digite el Valor para el a\u00f1o Internacional '+num2);
							$('#Valor_Inter_'+num2).css('border-color','#F00');
							$('#Valor_Inter_'+num2).effect("pulsate", {times:3}, 500);
							return false;
						}	
					
				/************************************************************/
				}	
				
			SaveConvocatorias();	
		/****************************************************************/
		}	
		
		
	function SaveConvocatorias(){
		var year = $('#year_actual').val();
			
			var num = parseInt(year)-3;
			
			for(num;num<=year;num++){
				/************************************************************/
					if($.trim($('#Presentado_'+num).val())){
						/**********************************************/
							$('#D_Nacional_'+num).val($('#D_Nacional_'+num).val()+'-Presentados-'+num+'-'+$('#Presentado_'+num).val());
						/**********************************************/
						}
					if($.trim($('#Aprobados_'+num).val())){
						/**********************************************/
							$('#D_Nacional_'+num).val($('#D_Nacional_'+num).val()+'-Aprobados-'+num+'-'+$('#Aprobados_'+num).val());
						/**********************************************/
						}
					if($.trim($('#Finalizados_'+num).val())){
						/**********************************************/
							$('#D_Nacional_'+num).val($('#D_Nacional_'+num).val()+'-Finalizados-'+num+'-'+$('#Finalizados_'+num).val());
						/**********************************************/	
						}
					if($.trim($('#Valor_'+num).val())){
						/**********************************************/
							$('#D_Nacional_'+num).val($('#D_Nacional_'+num).val()+'-Valor-'+num+'-'+$('#Valor_'+num).val());
						/**********************************************/	
						}	
					
				/************************************************************/
				}
				
			/*##############################################################################################*/	
			
			var year2 = $('#year_actual').val();
			
			var num2 = parseInt(year2)-3;	
			for(num2;num2<=year;num2++){
				/************************************************************/
					
					if($.trim($('#Presentado_Inter_'+num2).val())){
						/**********************************************/
							$('#D_Inter_'+num2).val($('#D_Inter_'+num2).val()+'-PresentadosInternacional-'+num2+'-'+$('#Presentado_Inter_'+num2).val());
						/**********************************************/
						}
					if($.trim($('#Aprobados_Inter_'+num2).val())){
						/**********************************************/
							$('#D_Inter_'+num2).val($('#D_Inter_'+num2).val()+'-AprobadosInternacional-'+num2+'-'+$('#Aprobados_Inter_'+num2).val());
						/**********************************************/
						}
					if($.trim($('#Finalizados_Inter_'+num2).val())){
						/**********************************************/
							$('#D_Inter_'+num2).val($('#D_Inter_'+num2).val()+'-FinalizadosInternacional-'+num2+'-'+$('#Finalizados_Inter_'+num2).val());
						/**********************************************/	
						}
					if($.trim($('#Valor_Inter_'+num2).val())){
						/**********************************************/
							$('#D_Inter_'+num2).val($('#D_Inter_'+num2).val()+'-ValorInternacional-'+num2+'-'+$('#Valor_Inter_'+num2).val());
						/**********************************************/	
						}		
					
				/************************************************************/
				}	
			/*##############################################################################################*/	
			var year = $('#year_actual').val();
			
			var num = parseInt(year)-3;
			
			for(num;num<=year;num++){
				
					if($.trim($('#D_Nacional_'+num).val())){
						
							 $('#C_Nacional').val( $('#C_Nacional').val()+'::'+$('#D_Nacional_'+num).val());
						
						}
				
				}
				
			var year2 = $('#year_actual').val();
			
			var num2 = parseInt(year2)-3;	
			for(num2;num2<=year;num2++){
				
					if($.trim($('#D_Inter_'+num2).val())){
							
							$('#C_InterNacional').val($('#C_InterNacional').val()+'::'+$('#D_Inter_'+num2).val());
							
						}
				
				}	
			/*##############################################################################################*/
			/*******************************************/	
			var Cadena_nacional 	 = $('#C_Nacional').val();
			var Cadena_internacional = $('#C_InterNacional').val();
			/*******************************************/
			
			/****************************Ajax***********************************/	
			 $.ajax({//Ajax
					  type: 'GET',
					  url: 'formularios/investigacion/viewInvestigaciones.php',
					  async: false,
					  dataType: 'json',
					  data:({actionID:'ConvocatoriasSave',Cadena_nacional:Cadena_nacional,
													    Cadena_internacional:Cadena_internacional,
														year:year,
														year2:year2}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
						 	if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else if(data.val=='TRUE'){
										alert(data.descrip);
										location.href="index.php";
										
									}else if(data.val=='EXISTE'){
										alert(data.descrip);
										location.href="index.php";
										}
					  
				   }
		   		}); //AJAX
			/****************************Fin Ajax*******************************/
		}
		
	function ValidaExterna(){
		/****************************************************************/
			var year = $('#year_actual').val();
			
			var num = parseInt(year)-3;
			
			for(num;num<=year;num++){
				/************************************************************/
					if(!$.trim($('#Present_'+num).val()) && !$.trim($('#Aproba_'+num).val()) && !$.trim($('#Final_'+num).val())){
							alert('Digite un dato con referencia al a\u00f1o  Car\u00e1cter Nacional '+num);
							$('#Present_'+num).css('border-color','#F00');
							$('#Present_'+num).effect("pulsate", {times:3}, 500);
							$('#Aproba_'+num).css('border-color','#F00');
							$('#Aproba_'+num).effect("pulsate", {times:3}, 500);
							$('#Final_'+num).css('border-color','#F00');
							$('#Final_'+num).effect("pulsate", {times:3}, 500);
							
							return false;
						}
					
					if(!$.trim($('#ValorTotal_'+num).val())){
						alert('Digite el Valor para el a\u00f1o Nacional '+num);
							$('#ValorTotal_'+num).css('border-color','#F00');
							$('#ValorTotal_'+num).effect("pulsate", {times:3}, 500);
							return false;
						}		
					
				/************************************************************/
				}
				
			var year2 = $('#year_actual').val();
			
			var num2 = parseInt(year2)-3;	
			
			for(num2;num2<=year;num2++){
				/************************************************************/
					if(!$.trim($('#Present_Inter_'+num2).val()) && !$.trim($('#AprobaInter_'+num2).val()) && !$.trim($('#Final_Inter_'+nnum2um).val())){
							alert('Digite un dato con referencia al a\u00f1o Car\u00e1cter Internacional '+num2);
							$('#Present_Inter_'+num2).css('border-color','#F00');
							$('#Present_Inter_'+num2).effect("pulsate", {times:3}, 500);
							$('#AprobaInter_'+num2).css('border-color','#F00');
							$('#AprobaInter_'+num2).effect("pulsate", {times:3}, 500);
							$('#Final_Inter_'+num2).css('border-color','#F00');
							$('#Final_Inter_'+num2).effect("pulsate", {times:3}, 500);
							
							return false;
						}
					
					if(!$.trim($('#ValorTotal_Inter_'+num2).val())){
							alert('Digite el Valor para el a\u00f1o Internacional '+num2);
							$('#ValorTotal_Inter_'+num2).css('border-color','#F00');
							$('#ValorTotal_Inter_'+num2).effect("pulsate", {times:3}, 500);
							return false;
						}	
					
				/************************************************************/
				}	
				
			SaveExternas();	
		/****************************************************************/
		}		
	
	function SaveExternas(){
		/**************************************************************************************************/
		
		var year = $('#year_actual').val();
			
			var num = parseInt(year)-3;
			
			for(num;num<=year;num++){
				/************************************************************/
					if($.trim($('#Present_'+num).val())){
						/**********************************************/
							$('#D_Nal_'+num).val($('#D_Nal_'+num).val()+'-Presentados-'+num+'-'+$('#Present_'+num).val());
						/**********************************************/
						}
					if($.trim($('#Aproba_'+num).val())){
						/**********************************************/
							$('#D_Nal_'+num).val($('#D_Nal_'+num).val()+'-Aprobados-'+num+'-'+$('#Aproba_'+num).val());
						/**********************************************/
						}
					if($.trim($('#Final_'+num).val())){
						/**********************************************/
							$('#D_Nal_'+num).val($('#D_Nal_'+num).val()+'-Finalizados-'+num+'-'+$('#Final_'+num).val());
						/**********************************************/	
						}
					if($.trim($('#ValorTotal_'+num).val())){
						/**********************************************/
							$('#D_Nal_'+num).val($('#D_Nal_'+num).val()+'-Valor-'+num+'-'+$('#ValorTotal_'+num).val());
						/**********************************************/	
						}	
					
				/************************************************************/
				}
				
			/*##############################################################################################*/	
			
			var year2 = $('#year_actual').val();
			
			var num2 = parseInt(year2)-3;	
			for(num2;num2<=year;num2++){
				/************************************************************/
					
					if($.trim($('#Present_Inter_'+num2).val())){
						/**********************************************/
							$('#D_Int_'+num2).val($('#D_Int_'+num2).val()+'-PresentadosInternacional-'+num2+'-'+$('#Present_Inter_'+num2).val());
						/**********************************************/
						}
					if($.trim($('#AprobaInter_'+num2).val())){
						/**********************************************/
							$('#D_Int_'+num2).val($('#D_Int_'+num2).val()+'-AprobadosInternacional-'+num2+'-'+$('#AprobaInter_'+num2).val());
						/**********************************************/
						}
					if($.trim($('#Final_Inter_'+num2).val())){
						/**********************************************/
							$('#D_Int_'+num2).val($('#D_Int_'+num2).val()+'-FinalizadosInternacional-'+num2+'-'+$('#Final_Inter_'+num2).val());
						/**********************************************/	
						}
					if($.trim($('#ValorTotal_Inter_'+num2).val())){
						/**********************************************/
							$('#D_Int_'+num2).val($('#D_Int_'+num2).val()+'-ValorInternacional-'+num2+'-'+$('#ValorTotal_Inter_'+num2).val());
						/**********************************************/	
						}		
					
				/************************************************************/
				}	
			/*##############################################################################################*/	
			var year = $('#year_actual').val();
			
			var num = parseInt(year)-3;
			
			for(num;num<=year;num++){
				
					if($.trim($('#D_Nal_'+num).val())){
						
							 $('#C_Nal').val( $('#C_Nal').val()+'::'+$('#D_Nal_'+num).val());
						
						}
				
				}
				
			var year2 = $('#year_actual').val();
			
			var num2 = parseInt(year2)-3;	
			for(num2;num2<=year;num2++){
				
					if($.trim($('#D_Int_'+num2).val())){
							
							$('#C_Inter').val($('#C_Inter').val()+'::'+$('#D_Int_'+num2).val());
							
						}
				
				}	
			/*##############################################################################################*/
			/*******************************************/	
			var Cadena_nacional 	 = $('#C_Nal').val();
			var Cadena_internacional = $('#C_Inter').val();
			/*******************************************/
			
			/****************************Ajax***********************************/	
			 $.ajax({//Ajax
					  type: 'GET',
					  url: 'formularios/investigacion/viewInvestigaciones.php',
					  async: false,
					  dataType: 'json',
					  data:({actionID:'ExternasSave',Cadena_nacional:Cadena_nacional,
													    Cadena_internacional:Cadena_internacional,
														year:year,
														year2:year2}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
						 	if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else if(data.val=='TRUE'){
										alert(data.descrip);
										location.href="index.php";
										
									}else if(data.val=='EXISTE'){
										alert(data.descrip);
										location.href="index.php";
										}
					  
				   }
		   		}); //AJAX
			/****************************Fin Ajax*******************************/
		
		/***************************************************************************************************/
		}	
	
	function FormatCampo(id){
		
			$('#'+id).val('');
		
		}
	
	function Divide(S){
		if(S==1){
			/********************************************************/

				var num		= parseInt($('#Colciencias').val())/parseInt($('#Nivel_Nal').val());
				
				var dato	= parseFloat(Math.round(num * 100) / 100).toFixed(2);
				
				var Porcentaje	= ((parseInt(dato)*100)/100);
				
				$('#Institu_Present').val(Porcentaje+'%');   
			
			/*********************************************************/
			}
		if(S==2){
			/********************************************************/
			
				var num	= parseInt($('#Aprobado_col').val())/parseInt($('#Aprobados_Nal').val());
				
				var Rersult	= parseFloat(Math.round(num * 100) / 100).toFixed(2);
				
				var Porcentaje	= ((parseInt(Rersult)*100)/100);
				
				$('#T_Aprobado').val(Porcentaje+'%');
			
			/*********************************************************/
			}	
		
		}	
function ValidarProyectosAprobados(){
	/*********************************************************************************************************/
		var Colciencias		= $('#Colciencias').val();
		var Nivel_Nal		= $('#Nivel_Nal').val();
		var Aprobado_col	= $('#Aprobado_col').val();
		var Aprobados_Nal	= $('#Aprobados_Nal').val();
		
		if(!$.trim(Colciencias) || Colciencias==0){
				var msn	= 'Digite el Numero de proyectos presentados por la Institucion a COLCIENCIAS o diferente de Cero';
				alert(msn);
				$('#Colciencias').css('border-color','#F00');
				$('#Colciencias').effect("pulsate", {times:3}, 500);
				return false;
			}
			
		if(!$.trim(Nivel_Nal) || Nivel_Nal==0){
				var msn	= 'Digite el Numero de proyectos presentados COLCIENCIAS a nivel Nacional o diferente de Cero';
				alert(msn);
				$('#Nivel_Nal').css('border-color','#F00');
				$('#Nivel_Nal').effect("pulsate", {times:3}, 500);
				return false;
			}	
			
		if(!$.trim(Aprobado_col) || Aprobado_col==0){
				var msn	= 'Digite el Numero de proyectos Aprobados por la Institución a COLCIENCIAS o diferente de Cero';
				alert(msn);
				$('#Aprobado_col').css('border-color','#F00');
				$('#Aprobado_col').effect("pulsate", {times:3}, 500);
				return false;
			}	
			
		if(!$.trim(Aprobados_Nal) || Aprobados_Nal==0){
				var msn	= 'Digite el Numero de proyectos Aprobados COLCIENCIAS a nivel Nacional o diferente de Cero';
				alert(msn);
				$('#Aprobados_Nal').css('border-color','#F00');
				$('#Aprobados_Nal').effect("pulsate", {times:3}, 500);
				return false;
			}	
			
		  /****************************Ajax***********************************/	
			 $.ajax({//Ajax
					  type: 'GET',
					  url: 'formularios/investigacion/viewInvestigaciones.php',
					  async: false,
					  dataType: 'json',
					  data:({actionID:'AprobadoPresentados',Colciencias:Colciencias,
													    	Nivel_Nal:Nivel_Nal,
															Aprobado_col:Aprobado_col,
															Aprobados_Nal:Aprobados_Nal}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
						 	if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else if(data.val=='TRUE'){
										alert(data.descrip);
										location.href="index.php";
										
									}else if(data.val=='EXISTE'){
										alert(data.descrip);
										location.href="index.php";
										}
					  
				   }
		   		}); //AJAX
			/****************************Fin Ajax*******************************/			
	/*********************************************************************************************************/
	}	

function ValidaClasificaciones(){
	/*****************************************************************************************************/
		
		//var Categoria_A1		= $('#Categoria_A1').val();
		//var Categoria_A2		= $('#Categoria_A2').val();
		//var Categoria_B			= $('#Categoria_B').val();
		//var Categoria_C			= $('#Categoria_C').val();
		var Indexacion			= $('#Indexada').val();
		var No_Indexada			= $('#No_Indexada').val();
		
		if(!$.trim(Indexacion) && !$.trim(No_Indexada)){
				
				var msn		= 'Digite un dato relacionado con el Formulario ';
				alert(msn);
				
				/*$('#Categoria_A1').css('border-color','#F00');
				$('#Categoria_A1').effect("pulsate", {times:3}, 500);
				/******************************************/
				/*$('#Categoria_A2').css('border-color','#F00');
				$('#Categoria_A2').effect("pulsate", {times:3}, 500);
				/******************************************/
				/*$('#Categoria_B').css('border-color','#F00');
				$('#Categoria_B').effect("pulsate", {times:3}, 500);
				/******************************************/
				/*$('#Categoria_C').css('border-color','#F00');
				$('#Categoria_C').effect("pulsate", {times:3}, 500);
				/******************************************/
				$('#Indexada').css('border-color','#F00');
				$('#Indexada').effect("pulsate", {times:3}, 500);
				/******************************************/
				$('#No_Indexada').css('border-color','#F00');
				$('#No_Indexada').effect("pulsate", {times:3}, 500);
				/******************************************/
				return false;
				
			}
                        
                        var Indexacion	= $('#vIndexada').is(':checked') ? 1: 0;
                        var No_Indexada	= $('#vNo_Indexada').is(':checked') ? 1: 0;
                        
		/****************************Ajax***********************************/	
			 $.ajax({//Ajax
					  type: 'GET',
					  url: 'formularios/investigacion/viewInvestigaciones.php',
					  async: false,
					  dataType: 'json',
					  data:({actionID:'Clasificaciones',Indexada:Indexacion,No_Indexada:No_Indexada}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
						 	if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else if(data.val=='TRUE'){
										alert(data.descrip);
										location.href="index.php";
										
									}else if(data.val=='EXISTE'){
										alert(data.descrip);
										location.href="index.php";
										}
					  
				   }
		   		}); //AJAX
			/****************************Fin Ajax*******************************/	
	/*****************************************************************************************************/
	}
function ValidaSemilleros(){
	/*******************************************************************************************************/
		var Index	= $('#Index').val();
		var formName = '#DatosFormularioSemilleros';
		var valido = true;
		$(formName + ' input[name="carrera[]"]').each(function() {                                     
			var currentId = $(this).val(); 
			var	i = 	currentId;							 
			var Semillero_num	= $('#Semillero_num_'+i).val();
				
				if(!$.trim(Semillero_num)){
						alert('Digite el dato en el sigiente Campo...');
						$('#Semillero_num_'+i).css('border-color','#F00');
						$('#Semillero_num_'+i).effect("pulsate", {times:3}, 500);
						valido= false;
					}									 
		});
			
			if(valido){
		/****************************Ajax***********************************/	
			 $.ajax({//Ajax
					  type: 'GET',
					  url: 'formularios/docentes/saveTalentoHumano.php',
					  async: false,
					  dataType: 'json',
					  data:$("#DatosFormularioSemilleros").serialize(),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
						 	if(data.success==false){
									alert(data.message);
									return false;
								}else if(data.success==true){
										alert(data.message);
										//location.href="index.php";
										
									}else if(data.val=='EXISTE'){
										alert(data.message);
										//location.href="index.php";
										}
					  
				   }
		   		}); //AJAX
			/****************************Fin Ajax*******************************/	
				} else {
					return valido;
				}
	/*******************************************************************************************************/
	}

	$('#DatosFormularioPublicaciones #anio').bind('change', function(event) {
		var periodo = $('#DatosFormularioPublicaciones #anio').val();
		var formName = '#DatosFormularioPublicaciones';
            $.ajax({//Ajax
					  type: 'GET',
					  url: 'formularios/docentes/saveTalentoHumano.php',
					  async: false,
					  dataType: 'json',
					  data:{ periodo: periodo, action: "getDataInvestigaciones", entity: "publicacionesperiodicas", campoPeriodo: "periosidaanual",
						entityVerificar: "verificar_publicacionesperiodicas"}, 
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
						 	if(data.success==false){		
									 $('#Indexada').val("");	
									 $('#No_Indexada').val("");		
									 $('#vIndexada').attr('checked', false);
									 $('#vNo_Indexada').attr('checked', false);
								}else if(data.success==true){
										if(data.total>0){
											//Pintar la data
											console.log(data);
											for (var i=0;i<data.total;i++)
											{        
												$('#Indexada').val(data.dataNum[i].indexadas);	
												$('#No_Indexada').val(data.dataNum[i].no_indexada);	
												if(typeof(data.dataVerificar[i]) != "undefined" && data.dataVerificar[i].vIndexadas==1){
													$('#vIndexada').attr('checked', true);
												} else if(typeof(data.dataVerificar[i]) != "undefined") {
													$('#vIndexada').attr('checked', false);
												}
												
												if(typeof(data.dataVerificar[i]) != "undefined" && data.dataVerificar[i].vNo_indexada==1){
													$('#vNo_indexada').attr('checked', true);
												} else if(typeof(data.dataVerificar[i]) != "undefined") {
													$('#vNo_indexada').attr('checked', false);
												}
											}
										} else {
											 $('#Indexada').val("");	
											 $('#No_Indexada').val("");		
											 $('#vIndexada').attr('checked', false);
											 $('#vNo_Indexada').attr('checked', false);
										}
								}
					  
				   }
			});
    });	
	
	
	$('#DatosFormularioSemilleros #anio').bind('change', function(event) {
		var periodo = $('#DatosFormularioSemilleros #anio').val();
		var formName = '#DatosFormularioSemilleros';
            $.ajax({//Ajax
					  type: 'GET',
					  url: 'formularios/docentes/saveTalentoHumano.php',
					  async: false,
					  dataType: 'json',
					  data:{ periodo: periodo, action: "getDataInvestigaciones", entity: "semillerosinvestigacion", campoPeriodo: "periosidaanual",
						entityVerificar: "verificar_semillerosinvestigacion"}, 
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
						 	if(data.success==false){									
									$(formName + ' input[name="carrera[]"]').each(function() {                                     
											 var currentId = $(this).val(); 
											 var	i = 	currentId;							 
											 //var i = currentId.replace("CodigoCarrera_",""); 	
											 $('#Semillero_num_'+i).val("");		
											 $('#vSemillero_num_'+i).attr('checked', false);										 
									});
								}else if(data.success==true){
										if(data.total>0){
											//Pintar la data
											//console.log(data);
											for (var i=0;i<data.total;i++)
											{        
												$('#Semillero_num_'+data.dataNum[i].carrera_id).val(data.dataNum[i].num_semillero);	
												if(typeof(data.dataVerificar[i]) != "undefined" && data.dataVerificar[i].vnum_semillero==1){
													$('#vSemillero_num_'+data.dataVerificar[i].codigocarrera).attr('checked', true);
												} else if(typeof(data.dataVerificar[i]) != "undefined") {
													$('#vSemillero_num_'+data.dataVerificar[i].codigocarrera).attr('checked', false);
												}
											}
										} else {
											$(formName + ' input[name="carrera[]"]').each(function() {                                      
											 var currentId = $(this).val(); 
											 var	i = 	currentId;							 
											 //var i = currentId.replace("CodigoCarrera_",""); 	
												 $('#Semillero_num_'+i).val("");		
												 $('#vSemillero_num_'+i).attr('checked', false);										 
											});	
										}
								}
					  
				   }
			});
    });	
</script>