<?php
    require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
?>
<div id="tabs-13">
<form action="save.php" method="post" id="form_extranjerosPais">  
    <input type="hidden" name="entity" id="entity" value="formTalentoHumanoAcademicosExtranjerosPais" />
    <input type="hidden" name="action" value="academicoExtranjeros" id="action" />
    <input type="hidden" name="idsiq_formTalentoHumanoAcademicosExtranjerosPais" value="" id="idsiq_formTalentoHumanoAcademicosExtranjerosPais"/>
    <span class="mandatory">* Son campos obligatorios</span>
    <fieldset id="numPersonas">
        <legend>Académicos extranjeros por país de origen</legend>
        <label class="fixedLabel">Mes: <span class="mandatory">(*)</span></label>
        <?php $utils->getMonthsSelect(); ?>
        
        <label class="fixedLabel" style="clear:none;width:90px">Año: <span class="mandatory">(*)</span></label>
        <?php $utils->getYearsSelect("anio"); 
            //$categories = $utils->getActives($db,"pais","nombrepais");
             $categories = $db->Execute("SELECT nombrepais,idpais FROM pais ORDER BY nombrepais ASC"); 
            $selectPais = $categories->GetMenu2('idPais[]',null,true,false,1,'class="grid-11-12 required inputTable" style="float:none;margin:0 auto;"');
        /*$sql = "SELECT p.* FROM sala.pais p 
                INNER JOIN docente d ON d.idpaisnacimiento=p.idpais AND p.codigoestado=100 
                GROUP BY p.idpais ORDER BY nombrepais";
        $categories = $db->Execute($sql);*/
        ?>
       <input type="hidden" name="codigoperiodo" value="" id="codigoperiodo"/> 
       <div class="vacio"></div>
       <?php $utils->pintarBotonCargar("popup_cargarDocumento(5,9,$('#form_extranjerosPais #mes').val()+'-'+$('#form_extranjerosPais #anio').val())","popup_verDocumentos(5,9,$('#form_extranjerosPais #mes').val()+'-'+$('#form_extranjerosPais #anio').val())"); ?>
        <!--<label for="nombre" class="fixed">Información verificada: <span class="mandatory">(*)</span></label>
        &nbsp;&nbsp;<input type="radio" name="verificada" id="verificada_1" value="1"> <span style="font-size:0.8em">Si</span> &nbsp;
        <input type="radio" name="verificada" value="0" id="verificada_0" checked> <span style="font-size:0.8em">No</span><br/><br/>-->
        <table align="center" class="formData last" width="92%" >
            <thead>            
                <tr class="dataColumns">
                    <th class="column" colspan="3"><span>Académicos extranjeros por país de origen</span></th>                                   
                </tr>
                <tr class="dataColumns category">
                    <th class="column" ><span>País de Origen</span></th> 
                    <th class="column" ><span>Número de Académicos</span></th> 
                    <!--<th class="column" ><span>Dato verificado</span></th>  -->  
                </tr>
             </thead>
             <tbody>                         
                <tr class="dataColumns">
                    <td class="column borderR"> 
                        <?php
                        // idioma[] es el nombre del select, el null es el que esta elegido de la lista, 
                        //primer true que se deje una opción en blanco, segundo false que no deje elegir múltiples opciones
                        //el 1 es si es un listbox o un select, el último son atributos
                        echo $selectPais; ?>
						<input type="hidden" name="idsiq_detalleformTalentoHumanoAcademicosExtranjerosPais[]" value="" id="idsiq_detalleformTalentoHumanoAcademicosExtranjerosPais_<?php echo $row["idpais"]; ?>" />
                    </td>
                    <td class="column"> 
                        <input type="text" class="grid-5-12 required inputTable number" minlength="1" name="valor[]" title="Total de Docentes" maxlength="10" tabindex="1" autocomplete="off" value="" />
                    </td>
                </tr>
                 <?php /*while ($row = $categories->FetchRow()) { ?>
                <tr class="dataColumns">
                    <td class="column "><?php echo $row["nombrepais"]; ?> <span class="mandatory">(*)</span>
                        <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idCategory[]" id="idCategory_<?php echo $row["idpais"]; ?>" value="<?php echo $row["idpais"]; ?>" />
                         <input type="hidden" name="idsiq_detalleformTalentoHumanoAcademicosExtranjerosPais[]" value="" id="idsiq_detalleformTalentoHumanoAcademicosExtranjerosPais_<?php echo $row["idpais"]; ?>" />
                        </td>
                    <td class="column"> 
                        <input type="text" class="grid-5-12 required number" minlength="1" name="valor[]" id="valor_<?php echo $row["idpais"]; ?>" title="Total de Estudiantes Beneficiados" maxlength="10" tabindex="1" autocomplete="off" value="" />
                    </td>
                    <!--    <td class="column center"> 
                            <input type="checkbox" name="veri[]" class="verificarDato" value="1" id="veri_<?php echo $row["idpais"]; ?>" >
                            <input type="hidden" name="verificada[]" value="0" id="verificada_<?php echo $row["idpais"]; ?>" >
                        </td>-->
                </tr>
                <?php }*/ ?> 
            </tbody>
        </table> 
            <input type="button" class="first small" id="addMoreDocentesPais" value="Agregar otro" style="margin-top:10px;">
            <input type="button" class="first small" id="removeDocentesPais" value="Eliminar último" style="margin-top:10px;">
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los cambios han sido guardados de forma correcta.</p></div>
            </fieldset>
            <input type="submit" id="submitExtranjerosPais" value="Guardar datos" class="first" /> 
        </form>
</div>

<script type="text/javascript">
	function getDataExtranjerosPais(formName){
		var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
		var entity = $(formName + " #entity").val();
		$.ajax({
			dataType: 'json',
			type: 'POST',
			url: './formularios/docentes/saveTalentoHumano.php',
			data: { periodo: periodo, action: "getDataDynamic2", entity: entity, 
                            campoPeriodo: "codigoperiodo", entityJoin: "pais",
                            joinField: "idpais",order:"nombrepais" },     
			success:function(data){
				if (data.success == true && data.data!=false){
					 //borro todas las filas
							$(formName + ' table').children('tbody').children('tr').remove(); 
						for (var i=0;i<data.total;i++)
						{                                 
							//pinto las nuevas filas
							var row = '<tr class="dataColumns">';
							row = row + '<td class="column borderR" id="pais">';
							row = row + '<?php echo str_replace("'",'"',preg_replace( "/\r|\n/", "", $selectPais)); ?>';
							row = row + '<input type="hidden" name="idsiq_detalleformTalentoHumanoAcademicosExtranjerosPais[]" autocomplete="off" value="'+data.data[i].idsiq_detalleformTalentoHumanoAcademicosExtranjerosPais+'" />';
                                        
							row = row + '</td><td class="column">';
							row = row + '<input type="text" class="grid-4-12 required number" minlength="1" name="valor[]" title="Total de docentes" maxlength="10" tabindex="1" autocomplete="off" value="'+data.data[i].valor+'" />';
							row = row + '</td></tr>';
							if($(formName + ' table').children('tbody').find('tr:last').length>0){
								$(formName + ' table').children('tbody').find('tr:last').after(row);  
							} else {
								$(formName + ' table').children('tbody').append(row); 
							}
								$(formName + ' table td#pais select').val(data.data[i].idCategory); 
								$('td#pais').removeAttr('id');
						}
						$(formName + " #action").val("updateAcademicoExtranjeros");
				}
				else{                        
					//no se encontraron datos
						$(formName + ' table input').each(function() {                                     
							$(this).val("");                                       
						});
						$(formName + ' table select').each(function() {                                     
							$(this).val("");   
						});
						$(formName + " #action").val("academicoExtranjeros");
				}
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		});  
	}
	
    getDataExtranjerosPais("#form_extranjerosPais");

    $('#addMoreDocentesPais').click(function(event) {
        addTableRowGeneric("#form_extranjerosPais");
        });
   
   $('#removeDocentesPais').click(function(event) {
       var formName = "#form_extranjerosPais";
       var inputName = "input[name='idsiq_detalleformTalentoHumanoAcademicosExtranjerosPais[]']";
      if($(formName + ' table').children('tbody').children('tr:last').find(inputName).val()!=""){
        var id = $(formName + ' table').children('tbody').children('tr:last').find(inputName).val();
        var entity = "detalle"+$(formName + ' #entity').val();
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: './formularios/academicos/saveUnidadesAcademicas.php',
            data: { action: "inactivate", idsiq_detalleformTalentoHumanoAcademicosExtranjerosPais:id,entity:entity },
            success:function(data){
                if (data.success == true){
                    removeTableRowGeneric(formName,inputName);
                }
                else{                        
                    alert("Ocurrio un error");
                }
            },
            error: function(data,error,errorThrown){alert(error + errorThrown);}
            });  
       } else {
            removeTableRowGeneric(formName,inputName);
       }
   });
    
    $('#submitExtranjerosPais').on('click',function(event){
        event.preventDefault();        
        var valido= validateForm("#form_extranjerosPais");
        if(valido){
            sendFormExtranjerosPais("#form_extranjerosPais");
        }
    });

                
    $('#form_extranjerosPais #mes').add($('#form_extranjerosPais #anio')).bind('change', function(event) {
        getDataExtranjerosPais("#form_extranjerosPais");
        });

    

    function sendFormExtranjerosPais(formName){
        var periodo = $(formName + ' #mes').val()+"-"+$(formName + ' #anio').val();
        $(formName + ' #codigoperiodo').val(periodo);
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: './formularios/academicos/saveUnidadesAcademicas.php',
                data: $(formName).serialize(),                
                success:function(data){
                    if (data.success == true){
                        var i = 0;
                                 $('input[name="idsiq_detalleformTalentoHumanoAcademicosExtranjerosPais[]"]').each(function() {
                                        $(this).val(data.data[i]);
                                        i = i + 1;
                                 }); 
                        $(formName + " #action").val("updateAcademicoExtranjeros");
                        $(formName + ' #msg-success').css('display','block');
                        $(formName + " #msg-success").delay(5500).fadeOut(800);
                    }
                    else{                        
                        $('#msg-error').html('<p>' + data.message + '</p>');
                        $('#msg-error').addClass('msg-error');
                    }
                },
                error: function(data,error,errorThrown){alert(error + errorThrown);}
        });            
    }
</script>
