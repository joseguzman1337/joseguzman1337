/**** JAVASCRIPT ****/
/* FUNCIONES GLOBALES */
$(document).ready(function() {
	$('#tabs_resumen_boton').click(function() {
		var iddocente = $('#DocenteId').val();
		var codigoperiodo = $('#Periodo').val();
		$('#tabla_resumen').html('<span style="color: white;"><b>Cargando informaci&oacute;n</b></span>');
		$.ajax({
            type: 'POST',
            url: 'peticiones_ajax.php',
            async: false,
            dataType: 'json',
            data:({actionID: 'cargar_resumen',
                iddocente:iddocente,
                codigoperiodo:codigoperiodo
            }),
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success: function(data){
				$('#tabla_resumen').html(data.tabla);
			}
		});
		$.ajax({
            type: 'POST',
            url: 'peticiones_ajax.php',
            async: false,
            dataType: 'json',
            data:({actionID: 'cargar_resumenSS',
                iddocente:iddocente,
                codigoperiodo:codigoperiodo
            }),
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success: function(data){
				$('#tabla_resumenSobresueldo').html(data.tablaSobresueldo);
				
			}
		});
	});
	$(".plus_pestana").on({
		mouseenter: function() {
			$(this).attr('src', 'images/plus_hover.png');
		},
		mouseleave: function() {
			$(this).attr('src', 'images/plus.png');
		}
	});
	
	$(".less_pestana").on({
		mouseenter: function() {
			$(this).attr('src', 'images/less_hover.png');
		},
		mouseleave: function() {
			$(this).attr('src', 'images/less.png');
		}
	});
    $("#facultad").change(function (){
        var facultad_id;
        var documento_docente;
        var periodo;
        facultad_id = $(this).val();
        documento_docente = $('#NumDocumento').val();
        periodo = $('#Periodo').val();
		var modalidad = $('#modalidad').val();
        if(facultad_id == 0){
            alert('seleccione una facultad antes de continuar');
            $('#contenedores').fadeOut(1000);
            $('#programa').attr('disabled', 'disabled');
        }else{
            cargar_programa_academico(facultad_id, documento_docente, periodo, modalidad);
            $('#programa').removeAttr('disabled');
        }
    });
    
    $("#programa").change(function (){
        var programa = $(this).val();
        var periodo = $('#Periodo').val();
        var documento_docente = $('#NumDocumento').val();
		var id_docente = $('#Docente_id').val();
		$('#HorasSemana_').val('');
		$('#H_Preparacio_').val('');
		$('#H_Evaluacion_').val('');
		$('#H_Asesoria_').val('');
		$('#T_horas').val('');
		$('#expense_table').html('<thead>\
                                        					<tr>\
                                        						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
                                        						<th>&nbsp;</th>\
                                        					</tr>\
                                        				</thead>\
                                        				<tbody>\
                                        					<tr>\
                                        						<td><input class="actividad" type="text" id="e0" name="subjects[]" maxlength="800" />\
                                                                <input type="hidden" value="0" id="oculto_e0" /></td>\
                                        						<td>&nbsp;</td>\
                                        					</tr>\
                                        				</tbody>');
		$('#HorasTaller_').val('');
		$('#expense_table_laboratorios').html('<thead>\
                                        					<tr>\
                                        						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
                                        						<th>&nbsp;</th>\
                                        					</tr>\
                                        				</thead>\
                                        				<tbody>\
                                        					<tr>\
                                        						<td><input class="actividad" type="text" id="l0" name="laboratorios[]" maxlength="800" />\
                                                                <input type="hidden" value="0" id="oculto_l0" /></td>\
                                        						<td>&nbsp;</td>\
                                        					</tr>\
                                        				</tbody>');
		$('#HorasPAE_').val('');
		$('#expense_table_pae').html('<thead>\
                                        					<tr>\
                                        						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
                                        						<th>&nbsp;</th>\
                                        					</tr>\
                                        				</thead>\
                                        				<tbody>\
                                        					<tr>\
                                        						<td><input class="actividad" type="text" id="p0" name="pae[]" maxlength="800" />\
                                                                <input type="hidden" value="0" id="oculto_p0" /></td>\
                                        						<td>&nbsp;</td>\
                                        					</tr>\
                                        				</tbody>');
		$('#HorasTIC_').val('');
		$('#expense_table_tic').html('<thead>\
                                        					<tr>\
                                        						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
                                        						<th>&nbsp;</th>\
                                        					</tr>\
                                        				</thead>\
                                        				<tbody>\
                                        					<tr>\
                                        						<td><input class="actividad" type="text" id="t0" name="tic[]" maxlength="800" />\
                                                                <input type="hidden" value="0" id="oculto_t0" /></td>\
                                        						<td>&nbsp;</td>\
                                        					</tr>\
                                        				</tbody>');
        $('#HorasInnovar_').val('');
		$('#expense_table_Innovar').html('<thead>\
                                        					<tr>\
                                        						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
                                        						<th>&nbsp;</th>\
                                        					</tr>\
                                        				</thead>\
                                        				<tbody>\
                                        					<tr>\
                                        						<td><input class="actividad" type="text" id="t0" name="Innovar[]" maxlength="800" />\
                                                                <input type="hidden" value="0" id="oculto_t0" /></td>\
                                        						<td>&nbsp;</td>\
                                        					</tr>\
                                        				</tbody>');
		$('#nombre_descubrimiento').val('');
		$('#horas_descubrimiento').val('');
		$('#expense_table_descubrimiento').html('<thead>\
                                        					<tr>\
                                        						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
                                        						<th>&nbsp;</th>\
                                        					</tr>\
                                        				</thead>\
                                        				<tbody>\
                                        					<tr>\
                                        						<td><input class="actividad" type="text" id="d0" name="descubrimiento[]" maxlength="800" />\
                                                                <input type="hidden" value="0" id="oculto_d0" /></td>\
                                        						<td>&nbsp;</td>\
                                        					</tr>\
                                        				</tbody>');
		$('#nombre_compromiso').val('');
		$('#horas_compromiso').val('');
		$('#expense_table_orientacion').html('<thead>\
                                        					<tr>\
                                        						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
                                        						<th>&nbsp;</th>\
                                        					</tr>\
                                        				</thead>\
                                        				<tbody>\
                                        					<tr>\
                                        						<td><input class="actividad" type="text" id="o0" name="compromiso[]" maxlength="800" />\
                                                                <input type="hidden" value="0" id="oculto_o0" /></td>\
                                        						<td>&nbsp;</td>\
                                        					</tr>\
                                        				</tbody>');
		$('#nombre_gestion').val('');
		$('#horas_gestion').val('');
		$('#expense_table_gestion').html('<thead>\
                                        					<tr>\
                                        						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
                                        						<th>&nbsp;</th>\
                                        					</tr>\
                                        				</thead>\
                                        				<tbody>\
                                        					<tr>\
                                        						<td><input class="actividad" type="text" id="g0" name="gestion[]" maxlength="800" />\
                                                                <input type="hidden" value="0" id="oculto_g0" /></td>\
                                        						<td>&nbsp;</td>\
                                        					</tr>\
                                        				</tbody>');
        if(programa == 0){
            alert('seleccione una programa antes de continuar');
            $('#contenedores').fadeOut(1000);
        }else{
			$('#cuadro1').css('display', 'block');
            cargar_materia(documento_docente, periodo, programa, id_docente);
			if( $('#modalidad').val() != 100 && $('#modalidad').val() != 503 && $('#modalidad').val() != 200 && $('#modalidad').val() != 300 && $('#modalidad').val() != 400 && $('#modalidad').val() != 502 && $('#modalidad').val() != 507 && $('#modalidad').val() != 500 && $('#modalidad').val() != 501){
				$('#cuadro1').css('display', 'none');
			}
            $('#materia').removeAttr('disabled');
            $('#contenedores').fadeIn(2000);
            fechaActualD();
        }
        $('#contenedorPortafolio').css('display', 'none');
        $('#contenedorAutoevaluacion').css('display', 'none');
        $("#contenedorPlanMejora").css('display', 'none');
    });
    $("#materia").change(function (){
        var facultad = $('#facultad').val();
        var programa = $('#programa').val();        
        var asignatura = $(this).val();
        var documento_docente = $('#DocenteId').val();
        var periodo = $('#Periodo').val();
        var TipoHorasEnsenanza = $("#cmbTipoHorasEnsenanza option:selected").val();
        $('#expense_table').html('<thead>\
                                        					<tr>\
                                        						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
                                        						<th>&nbsp;</th>\
                                        					</tr>\
                                        				</thead>\
                                        				<tbody>\
                                        					<tr>\
                                        						<td><input class="actividad" type="text" id="e0" name="subjects[]" maxlength="800" />\
                                                                <input type="hidden" value="0" id="oculto_e0" /></td>\
                                        						<td>&nbsp;</td>\
                                        					</tr>\
                                        				</tbody>');
        if(asignatura == 0){
            alert('seleccione una materia antes de continuar');
            $('#contenedores').fadeOut(1000);
        }else{
        	consulta_antiguos(facultad, programa, asignatura, documento_docente, periodo, TipoHorasEnsenanza);
        	$("#cmbTipoHorasEnsenanza").change(function (){
		    	var facultad = $('#facultad').val();
		        var programa = $('#programa').val();        
		        var asignatura = $('#materia').val();
		        var documento_docente = $('#DocenteId').val();
		        var periodo = $('#Periodo').val();
		        var TipoHorasEnsenanza = $(this).val();
		    	consulta_antiguos(facultad, programa, asignatura, documento_docente, periodo, TipoHorasEnsenanza);
		    });
        }
    });
    $('#modalidad').change(function (){
        var modalidad = $(this).val();
        if(modalidad == 0){
            alert('seleccione una modalidad antes de continuar');
            $('#contenedores').fadeOut(1000);
        }else{
            cargar_facultad(modalidad);
            if(modalidad == 200 ){
                $('#facultad').removeAttr('disabled');
                $('#programa').attr('disabled', 'true');
                $('#Div_Facultad').removeAttr('style');
				$('#tipo_ensenanza').html('<option value="0" selected="selected">Seleccione</option><option value="1">Asignatura</option><option value="2">Atenci&oacute;n en laboratorios, talleres o preclinicas</option><option value="3">Atenci&oacute;n - tutorias PAE</option><option value="4">Horas dedicadas a TIC</option><option value="5">Horas dedicadas a la Innovación</option>');            }
            else if(modalidad == 300 || modalidad==400){
                $('#Div_Facultad').css('display', 'none');
                $('#programa').removeAttr('disabled');
				$('#tipo_ensenanza').html('<option value="0" selected="selected">Seleccione</option><option value="1">Asignatura</option><option value="2">Atenci&oacute;n en laboratorios, talleres o preclinicas</option><option value="3">Atenci&oacute;n - tutorias PAE</option><option value="4">Horas dedicadas a TIC</option><option value="5">Horas dedicadas a la Innovación</option>');
            } else if( modalidad == 100  || modalidad==503 || modalidad==507 || modalidad==502){
                $('#Div_Facultad').css('display', 'none');
                $('#programa').removeAttr('disabled');
				$('#tipo_ensenanza').html('<option value="0" selected="selected">Seleccione</option><option value="1">Asignatura</option><option value="2">Atenci&oacute;n en laboratorios, talleres o preclinicas</option><option value="3">Atenci&oacute;n - tutorias PAE</option><option value="4">Horas dedicadas a TIC</option><option value="5">Horas dedicadas a la Innovación</option>');
            }else{
            	$('#Div_Facultad').css('display', 'none');
                $('#programa').removeAttr('disabled');
				$('#tipo_ensenanza').html('<option value="0" selected="selected">Seleccione</option><option value="2">Atenci&oacute;n en laboratorios, talleres o preclinicas</option><option value="3">Atenci&oacute;n - tutorias PAE</option><option value="4">Horas dedicadas a TIC</option><option value="5">Horas dedicadas a la Innovación</option>');
            }
        }
    });
    $("#tipo_ensenanza").change(function(){
        var tipo_ensenanza = $(this).val();
        var programa = $('#programa').val();
        var periodo = $('#Periodo').val();
        var id_docente = $('#Docente_id').val();
        var TipoHorasEnsenanza = $('#cmbTipoHorasEnsenanza').val();
        $('#table_asignatura').css('display', 'none');
        $('#table_laboratorios').css('display', 'none');
        $('#table_pae').css('display', 'none');
        $('#table_tic').css('display', 'none');
        $('#table_Innovar').css('display', 'none');
        if(tipo_ensenanza == '1'){
            $('#table_asignatura').slideDown();
            $('#table_materia').slideDown();
            $('#table_tipoHorasEnsenanza').slideDown();
        }
        if(tipo_ensenanza == '2'){

        	$('#table_laboratorios').slideDown();
            $('#table_asignatura').slideUp();
            $('#table_materia').slideUp();
            $('#table_tipoHorasEnsenanza').slideDown();
        	var tipo_Actividad = '2';
			
			$("#cmbTipoHorasEnsenanza").change(function (){
		        var tipo_Actividad = $("#tipo_ensenanza").val();
		    });
     	}

        if(tipo_ensenanza == '3'){
            $('#table_pae').slideDown();
            $('#table_asignatura').slideUp();
            $('#table_materia').slideUp();
            $('#table_Innovar').slideUp();
            $('#table_tipoHorasEnsenanza').slideDown();
        	var tipo_Actividad = '3';
			$("#cmbTipoHorasEnsenanza").change(function (){
		        var tipo_Actividad = $("#tipo_ensenanza").val();
		    });
        }
        if(tipo_ensenanza == '4'){
            $('#table_tic').slideDown();
            $('#table_Innovar').slideUp();
            $('#table_asignatura').slideUp();
            $('#table_materia').slideUp();
            $('#table_tipoHorasEnsenanza').slideDown();
        	var tipo_Actividad = '4';
			$("#cmbTipoHorasEnsenanza").change(function (){
		        var tipo_Actividad = $("#tipo_ensenanza").val();
		    });
        }
             if(tipo_ensenanza == '5'){
            $('#table_Innovar').slideDown();
            $('#table_tic').slideUp();     
            $('#table_asignatura').slideUp();
            $('#table_materia').slideUp();
            $('#table_tipoHorasEnsenanza').slideDown();
        	var tipo_Actividad = '5';
			$("#cmbTipoHorasEnsenanza").change(function (){
		        var tipo_Actividad = $("#tipo_ensenanza").val();
		    });
        }
        consultar_antiguos_EO(programa, periodo, id_docente, TipoHorasEnsenanza, tipo_Actividad);
    });
    
    $('#plus-ensenanza').click(function(){
         $('#ensenanza').slideDown();
         $('#plus-ensenanza').css('display', 'none');
    });
    
    $('#plus-descubrimiento').click(function(){
         $('#descubrimiento').slideDown();
         $('#plus-descubrimiento').css('display', 'none');
    });
    
    $('#plus-compromiso').click(function(){
         $('#compromiso').slideDown();
         $('#plus-compromiso').css('display', 'none');
    });
    
    $('#plus-gestion').click(function(){
         $('#gestion').slideDown();
         $('#plus-gestion').css('display', 'none');
    });
});

function oculta_vocacion(vocacion){
	$('#'+vocacion).slideUp();
	$('#plus-'+vocacion).css('display', 'block');
}

function cargar_plan(id, vocacion, tipoHorasO){
	$.ajax({
            type: 'POST',
            url: 'peticiones_ajax.php',
            async: false,
            dataType: 'json',
            data:({actionID: 'cargar_plan',
                id:id,
                vocacion:vocacion,
                tipoHorasO:tipoHorasO
                
            }),
            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success: function(data){
            if(data.val=='FALSE'){
                alert(data.descrip);
                return false;
            }else{				
                if(vocacion == 2){
                	if(data.imp == ""){
                		$('#horas_descubrimiento').val(data.h_proyecto);
						$('#nombre_descubrimiento').val(data.n_proyecto);
						$('#tipo_descubrimiento option[value="'+data.t_proyecto+'"]').attr("selected", "selected");
						$('#oculto_descubrimiento').val(id);
						$('#cmbTipoHorasDescubrimiento').val(tipoHorasO);
                		$('#expense_table_descubrimiento').html('<thead>\
                                        					<tr>\
                                        						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
                                        						<th>&nbsp;</th>\
                                        					</tr>\
                                        				</thead>\
                                        				<tbody>\
                                        					<tr>\
                                        						<td><input class="actividad" type="text" id="d0" name="descubrimiento[]" maxlength="800" />\
                                                                <input type="hidden" value="0" id="oculto_d0" /></td>\
                                        						<td>&nbsp;</td>\
                                        					</tr>\
                                        				</tbody>');
                   }else{
						$('#horas_descubrimiento').val(data.h_proyecto);
						$('#nombre_descubrimiento').val(data.n_proyecto);
						$('#tipo_descubrimiento option[value="'+data.t_proyecto+'"]').attr("selected", "selected");
						$('#expense_table_descubrimiento').html(data.imp);
						$('#oculto_descubrimiento').val(id);
						$('#cmbTipoHorasDescubrimiento').val(tipoHorasO);
					}
					
				}
				if(vocacion == 3){
					
					if(data.imp == ""){
						$('#horas_compromiso').val(data.h_proyecto);
						$('#nombre_compromiso').val(data.n_proyecto);
						$('#tipo_compromiso option[value="'+data.t_proyecto+'"]').attr("selected", "selected");
						$('#oculto_compromiso').val(id);
						$('#cmbTipoHorasCompromiso').val(tipoHorasO);
						$('#expense_table_orientacion').html('<thead>\
                                        					<tr>\
                                        						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
                                        						<th>&nbsp;</th>\
                                        					</tr>\
                                        				</thead>\
                                        				<tbody>\
                                        					<tr>\
                                        						<td><input class="actividad" type="text" id="o0" name="compromiso[]" maxlength="800" />\
                                                                <input type="hidden" value="0" id="oculto_o0" /></td>\
                                        						<td>&nbsp;</td>\
                                        					</tr>\
                                        				</tbody>');
					
					}else{
						$('#horas_compromiso').val(data.h_proyecto);
						$('#nombre_compromiso').val(data.n_proyecto);
						$('#tipo_compromiso option[value="'+data.t_proyecto+'"]').attr("selected", "selected");
						$('#expense_table_orientacion').html(data.imp);
						$('#oculto_compromiso').val(id);
						$('#cmbTipoHorasCompromiso').val(tipoHorasO);
					}
				}
				if(vocacion == 4){
					if(data.imp == ""){
						$('#horas_gestion').val(data.h_proyecto);
						$('#nombre_gestion').val(data.n_proyecto);
						$('#oculto_gestion').val(id);
						$('#cmbTipoHorasGestion').val(tipoHorasO);
						$('#expense_table_gestion').html('<thead>\
                                        					<tr>\
                                        						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
                                        						<th>&nbsp;</th>\
                                        					</tr>\
                                        				</thead>\
                                        				<tbody>\
                                        					<tr>\
                                        						<td><input class="actividad" type="text" id="g0" name="gestion[]" maxlength="800" />\
                                                                <input type="hidden" value="0" id="oculto_g0" /></td>\
                                        						<td>&nbsp;</td>\
                                        					</tr>\
                                        				</tbody>');
					}else{
						$('#horas_gestion').val(data.h_proyecto);
						$('#nombre_gestion').val(data.n_proyecto);
						$('#expense_table_gestion').html(data.imp);
						$('#oculto_gestion').val(id);
						$('#cmbTipoHorasGestion').val(tipoHorasO);
					}
				}
            }                
        }
    });
}
function ensenanza(modalidad){
    var actividades= new Array();
    var actividades_id = new Array();
    var ocultos_actividades = new Array();
    ////datos generales para guardar
    docente_id=$('#DocenteId').val();
    programaAcademicoId=$('#programa').val();
    asignatura_id=$('#materia').val();
    periodo=$('#Periodo').val();
    var TipoHorasEnsenanza = $('#cmbTipoHorasEnsenanza').val();
    ////horas de ense�anza
    horasSemana=$('#HorasSemana_').val();
    horasPreparacion=$('#H_Preparacio_').val();
    horasEvaluacion=$('#H_Evaluacion_').val();
    horasAsesoria=$('#H_Asesoria_').val();
    horasTaller=$('#HorasTaller_').val();
    horasPae=$('#HorasPAE_').val();
    horasTic = $('#HorasTIC_').val();
    horasInnovar = $('#HorasInnovar_').val();    
    tipo_ensenanza = $('#tipo_ensenanza').val();
    oculto_ensenanza = $('#oculto_ensenanza').val();
    
    if(asignatura_id == 0)
        asignatura_id = 'NULL';
    
    if(horasSemana == '')
        horasSemana = 0;
        
    if(horasPreparacion == '')
        horasPreparacion = 0;
        
    if(horasEvaluacion == '')
        horasEvaluacion = 0;
        
    if(horasAsesoria == '')
        horasAsesoria = 0;
        
    if(horasTaller == '')
        horasTaller = 0;
        
    if(horasPae == '')
        horasPae = 0;
        
    if(horasTic == '')
        horasTic = 0;
    
    if(horasInnovar == '')
        horasInnovar = 0;
         
	if(oculto_ensenanza == '')
		oculto_ensenanza = 0;
		
    var i=0;
    
    if(modalidad == 'asignatura'){
    	
		horasTic = 0;
        horasInnovar = 0;
		horasTaller = 0;
		horasPae = 0;
        $('input[name="subjects[]"]').each(function(i) {
            actividades[i]=$(this).val();
            actividades_id[i]=$(this).attr('id');
            ocultos_actividades[i] = $('#oculto_'+actividades_id[i]).val();
            tipo_actividad = 1;
            i++;
        });
    }
    
    if(modalidad == 'laboratorios'){
		asignatura_id = 1;
        $('input[name="laboratorios[]"]').each(function(i) {
            actividades[i]=$(this).val();
            actividades_id[i]=$(this).attr('id');
            ocultos_actividades[i] = $('#oculto_'+actividades_id[i]).val();
            tipo_actividad = 2;
            i++;
        });
    }
    if(modalidad == 'pae'){
		asignatura_id = 1;
        $('input[name="pae[]"]').each(function(i) {
            actividades[i]=$(this).val();
            actividades_id[i]=$(this).attr('id');
            ocultos_actividades[i] = $('#oculto_'+actividades_id[i]).val();
            tipo_actividad = 3;
            i++;
        });
    }
    if(modalidad == 'tic'){
		asignatura_id = 1;
        $('input[name="tic[]"]').each(function(i) {
            actividades[i]=$(this).val();
            actividades_id[i]=$(this).attr('id');
			ocultos_actividades[i] = $('#oculto_'+actividades_id[i]).val();
            tipo_actividad = 4;
            i++;
        });
    }
    if(modalidad == 'Innovar'){
		asignatura_id = 1;
        $('input[name="Innovar[]"]').each(function(i) {
            actividades[i]=$(this).val();
            actividades_id[i]=$(this).attr('id');
			ocultos_actividades[i] = $('#oculto_'+actividades_id[i]).val();
            tipo_actividad = 5;
            i++;
        });
    }
    var cadena=programaAcademicoId+','+asignatura_id+','+docente_id+','+periodo+','+horasSemana+','+horasPreparacion+','+horasEvaluacion+','+horasAsesoria+','+horasTic+','+horasTaller+','+horasPae+', '+tipo_ensenanza+','+oculto_ensenanza+','+tipo_actividad+','+modalidad+','+TipoHorasEnsenanza+','+horasInnovar;
    if(actividades[0] == ''){
        alert("Favor ingresar al menos una actividad antes de guardar");
        return false;
    }else{	
		if(modalidad == 'asignatura'){
			$.ajax({
				type: 'POST',
				url: 'peticiones_ajax.php',
				async: false,
				dataType: 'json',
				data:({actionID: 'guarda_ensenanzayapredizaje',
					cadena:cadena,
					actividades:actividades,
					ocultos_actividades: ocultos_actividades
				}),
				error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				success: function(data){
					
					if(data.val=='FALSE'){
						alert(data.descrip);
						return false;
					}else{
						$('#oculto_ensenanza').val(data.plan_ensenanza);
						var str = data.arr_id_actividades
						var otr = String(str).split(',');
						$.each( otr, function( i ){
							$('#oculto_'+actividades_id[i]).val(otr[i]);
							$('#delete_'+actividades_id[i]).val(otr[i]);
						});
						if(data.update == 'no'){
						alert('Guardado exitoso.');
						$("#programa").trigger( "change" );
						$("#tipo_ensenanza").val(0).trigger("change");	
						}else{
						alert('Guardado exitoso.');
						$("#programa").trigger( "change" );
						}
						
					}                
				}
			});
		}else{
			$.ajax({
				type: 'POST',
				url: 'peticiones_ajax.php',
				async: false,
				dataType: 'json',
				data:({actionID: 'guarda_ensenanzayapredizaje_varios',
					cadena:cadena,
					actividades:actividades,
					ocultos_actividades: ocultos_actividades
				}),
				error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
				success: function(data){
					
					if(data.val=='FALSE'){
						alert(data.descrip);
						return false;
					}else{
						$('#oculto_ensenanza').val(data.plan_ensenanza);
						var str = data.arr_id_actividades
						var otr = String(str).split(',');
						$.each( otr, function( i ){
							$('#oculto_'+actividades_id[i]).val(otr[i]);
							$('#delete_'+actividades_id[i]).val(otr[i]);
						});
						alert('Guardado exitoso.');
						$("#programa").trigger( "change" );
						
					}                
				}
			});
		}
    }
}
function guarda_descubrimiento(){
    docente_id=$('#DocenteId').val();
    programaAcademicoId=$('#programa').val();
    periodo=$('#Periodo').val();
    var TipoHorasOtros = $('#cmbTipoHorasDescubrimiento').val();
    var actividades= new Array();
	var actividades_id = new Array();
	var ocultos_actividades = new Array();
    var nombre_descubrimiento = $('#nombre_descubrimiento').val();
	nombre_descubrimiento = nombre_descubrimiento.replace(',', '');
	nombre_descubrimiento = nombre_descubrimiento.replace("'", '');
	nombre_descubrimiento = nombre_descubrimiento.replace('"', '');
	nombre_descubrimiento = nombre_descubrimiento.replace('(', '');
	nombre_descubrimiento = nombre_descubrimiento.replace(')', '');
    var tipo_descubrimiento = $('#tipo_descubrimiento').val();
    var horas_descubrimiento = $('#horas_descubrimiento').val();
    var vocacion_descubrimiento = $('#vocacion_descubrimiento').val();
	var oculto_descubrimiento = $('#oculto_descubrimiento').val();
    var i = 0;
	$('input[name="descubrimiento[]"]').each(function(i) {
        actividades[i]=$(this).val();
        actividades_id[i]=$(this).attr('id');
		ocultos_actividades[i] = $('#oculto_'+actividades_id[i]).val();
        i++;
    });
    if(actividades[0] == ''){
        alert("Favor ingresar al menos una actividad antes de guardar");
        return false;
    }
    
    if(nombre_descubrimiento == ''){
        alert("Favor ingresar un nombre de proyecto antes de guardar");
        return false;
    }
    
    if(tipo_descubrimiento == 0){
        alert("Favor seleccione un tipo de proyecto antes de guardar");
        return false;
    }
    
    if(horas_descubrimiento == 0){
        alert("Favor ingresar horas antes de guardar");
        return false;
    }
    
    var cadena = programaAcademicoId+','+docente_id+','+periodo+','+horas_descubrimiento+','+tipo_descubrimiento+','+nombre_descubrimiento+','+vocacion_descubrimiento+','+oculto_descubrimiento+','+TipoHorasOtros;
    
    $.ajax({
        type: 'POST',
        url: 'peticiones_ajax.php',
        async: false,
        dataType: 'json',
        data:({actionID: 'guarda_otros',
            cadena:cadena,
            actividades:actividades,
            ocultos_actividades: ocultos_actividades
        }),
        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        success: function(data){
        	
            if(data.val=='FALSE'){
                alert(data.descrip);
                return false;
            }else{
				$('#nombre_descubrimiento').val('');
				$('#horas_descubrimiento').val('');
				$('#tipo_descubrimiento').val(0);
				$('#expense_table_descubrimiento').html('<thead>\
                                        					<tr>\
                                        						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
                                        						<th>&nbsp;</th>\
                                        					</tr>\
                                        				</thead>\
                                        				<tbody>\
                                        					<tr>\
                                        						<td><input class="actividad" type="text" id="d0" name="descubrimiento[]" maxlength="800" />\
                                                                <input type="hidden" value="0" id="oculto_d0" /></td>\
                                        						<td>&nbsp;</td>\
                                        					</tr>\
                                        				</tbody>');
               
				if(data.update == 'no'){
					var anteriores = $('#anteriores_descubrimiento').html();
					$('#anteriores_descubrimiento').html(anteriores+'<div id="O_'+data.plan_ensenanza+'" class="div_anteriores"><a class="cargar_otros" onclick="cargar_plan('+data.plan_ensenanza+', '+data.tipo_vocacion+')">'+data.nombre+'</a> &nbsp; <img title="Eliminar" onclick="deletex('+data.plan_ensenanza+', \''+data.nombre+'\')" class="deletex" src="images/deletex.png" /></div>');
                }else{
                	$('#oculto_descubrimiento').val(0);
					$('#O_'+data.plan_ensenanza).html('<div id="O_'+data.plan_ensenanza+'" class="div_anteriores"><a class="cargar_otros" onclick="cargar_plan('+data.plan_ensenanza+', '+data.tipo_vocacion+')">'+data.nombre+'</a> &nbsp; <img title="Eliminar" onclick="deletex('+data.plan_ensenanza+', \''+data.nombre+'\')" class="deletex" src="images/deletex.png" /></div>');
				}
				alert('Guardado exitoso.');
				$("#programa").trigger( "change" );
            }
        }
    });
}
function guarda_compromiso(){
    docente_id=$('#DocenteId').val();
    programaAcademicoId=$('#programa').val();
    periodo=$('#Periodo').val();
    var TipoHorasOtros = $('#cmbTipoHorasCompromiso').val();
    var actividades= new Array();
	var actividades_id = new Array();
	var ocultos_actividades = new Array();
    var nombre_descubrimiento = $('#nombre_compromiso').val();
	nombre_descubrimiento = nombre_descubrimiento.replace(',', '');
	nombre_descubrimiento = nombre_descubrimiento.replace("'", '');
	nombre_descubrimiento = nombre_descubrimiento.replace('"', '');
	nombre_descubrimiento = nombre_descubrimiento.replace('(', '');
	nombre_descubrimiento = nombre_descubrimiento.replace(')', '');
    var tipo_descubrimiento = $('#tipo_compromiso').val();
    var horas_descubrimiento = $('#horas_compromiso').val();
    var vocacion_descubrimiento = $('#vocacion_compromiso').val();
	var oculto_descubrimiento = $('#oculto_compromiso').val();
    var i = 0;
	
    $('input[name="compromiso[]"]').each(function(i) {
        actividades[i]=$(this).val();
        actividades_id[i]=$(this).attr('id');
		ocultos_actividades[i] = $('#oculto_'+actividades_id[i]).val();
        i++;
    });
	
    if(actividades[0] == ''){
        alert("Favor ingresar al menos una actividad antes de guardar");
        return false;
    }
    
    if(nombre_descubrimiento == ''){
        alert("Favor ingresar un nombre de proyecto antes de guardar");
        return false;
    }
    
    if(tipo_descubrimiento == 0){
        alert("Favor seleccione un tipo de proyecto antes de guardar");
        return false;
    }
    
    if(horas_descubrimiento == 0){
        alert("Favor ingresar horas antes de guardar");
        return false;
    }
    
    var cadena = programaAcademicoId+','+docente_id+','+periodo+','+horas_descubrimiento+','+tipo_descubrimiento+','+nombre_descubrimiento+','+vocacion_descubrimiento+','+oculto_descubrimiento+','+TipoHorasOtros;
    
    $.ajax({
        type: 'POST',
        url: 'peticiones_ajax.php',
        async: false,
        dataType: 'json',
        data:({actionID: 'guarda_otros',
            cadena:cadena,
            actividades:actividades,
            ocultos_actividades: ocultos_actividades
        }),
        error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
        success: function(data){
            if(data.val=='FALSE'){
                alert(data.descrip);
                return false;
            }else{
				$('#nombre_compromiso').val('');
				$('#horas_compromiso').val('');
				$('#tipo_compromiso').val(0);
				$('#expense_table_orientacion').html('<thead>\
                                        					<tr>\
                                        						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
                                        						<th>&nbsp;</th>\
                                        					</tr>\
                                        				</thead>\
                                        				<tbody>\
                                        					<tr>\
                                        						<td><input class="actividad" type="text" id="o0" name="compromiso[]" maxlength="800" />\
                                                                <input type="hidden" value="0" id="oculto_o0" /></td>\
                                        						<td>&nbsp;</td>\
                                        					</tr>\
                                        				</tbody>');
				if(data.update == 'no'){
					var anteriores = $('#anteriores_compromiso').html();
					$('#anteriores_compromiso').html(anteriores+'<div id="O_'+data.plan_ensenanza+'" class="div_anteriores"><a class="cargar_otros" onclick="cargar_plan('+data.plan_ensenanza+', '+data.tipo_vocacion+')">'+data.nombre+'</a> &nbsp; <img title="Eliminar" onclick="deletex('+data.plan_ensenanza+', \''+data.nombre+'\')" class="deletex" src="images/deletex.png" /></div>');
                }else{
                	$('#oculto_compromiso').val(0);
					$('#O_'+data.plan_ensenanza).html('<div id="O_'+data.plan_ensenanza+'" class="div_anteriores"><a class="cargar_otros" onclick="cargar_plan('+data.plan_ensenanza+', '+data.tipo_vocacion+')">'+data.nombre+'</a> &nbsp; <img title="Eliminar" onclick="deletex('+data.plan_ensenanza+', \''+data.nombre+'\')" class="deletex" src="images/deletex.png" /></div>');
				}
				alert('Guardado exitoso.');
				$("#programa").trigger( "change" );
				
            }
        }
    });
}
function guarda_gestion(){
    docente_id=$('#DocenteId').val();
    programaAcademicoId=$('#programa').val();
    periodo=$('#Periodo').val();
    var TipoHorasOtros = $('#cmbTipoHorasGestion').val();
    var actividades= new Array();
	var actividades_id = new Array();
	var ocultos_actividades = new Array();
    var nombre_descubrimiento = $('#nombre_gestion').val();
	nombre_descubrimiento = nombre_descubrimiento.replace(',', '');
	nombre_descubrimiento = nombre_descubrimiento.replace("'", '');
	nombre_descubrimiento = nombre_descubrimiento.replace('"', '');
	nombre_descubrimiento = nombre_descubrimiento.replace('(', '');
	nombre_descubrimiento = nombre_descubrimiento.replace(')', '');
    var tipo_descubrimiento = 6;
    var horas_descubrimiento = $('#horas_gestion').val();
    var vocacion_descubrimiento = $('#vocacion_gestion').val();
	var oculto_descubrimiento = $('#oculto_gestion').val();
    var i = 0;
	
    $('input[name="gestion[]"]').each(function(i) {
        actividades[i]=$(this).val();
        actividades_id[i]=$(this).attr('id');
		ocultos_actividades[i] = $('#oculto_'+actividades_id[i]).val();
        i++;
    });
    if(actividades[0] == ''){
        alert("Favor ingresar al menos una actividad antes de guardar");
        return false;
    }
    if(nombre_descubrimiento == ''){
        alert("Favor ingresar un nombre de proyecto antes de guardar");
        return false;
    }
    if(tipo_descubrimiento == 0){
        alert("Favor seleccione un tipo de proyecto antes de guardar");
        return false;
    }
    if(horas_descubrimiento == 0){
        alert("Favor ingresar horas antes de guardar");
        return false;
    }
    var cadena = programaAcademicoId+','+docente_id+','+periodo+','+horas_descubrimiento+','+tipo_descubrimiento+','+nombre_descubrimiento+','+vocacion_descubrimiento+','+oculto_descubrimiento+','+TipoHorasOtros;
    $.ajax({
        type: 'POST',
        url: 'peticiones_ajax.php',
        async: false,
        dataType: 'json',
        data:({actionID: 'guarda_otros',
            cadena:cadena,
            actividades:actividades,
            ocultos_actividades: ocultos_actividades
        }),
        error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
        success: function(data){
            if(data.val=='FALSE'){
                alert(data.descrip);
                return false;
            }else{
				$('#nombre_gestion').val('');
				$('#horas_gestion').val('');
				$('#expense_table_gestion').html('<thead>\
                                        					<tr>\
                                        						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
                                        						<th>&nbsp;</th>\
                                        					</tr>\
                                        				</thead>\
                                        				<tbody>\
                                        					<tr>\
                                        						<td><input class="actividad" type="text" id="g0" name="gestion[]" maxlength="800" />\
                                                                <input type="hidden" value="0" id="oculto_g0" /></td>\
                                        						<td>&nbsp;</td>\
                                        					</tr>\
                                        				</tbody>');
				if(data.update == 'no'){
					var anteriores = $('#anteriores_gestion').html();
					$('#anteriores_gestion').html(anteriores+'<div id="O_'+data.plan_ensenanza+'" class="div_anteriores"><a class="cargar_otros" onclick="cargar_plan('+data.plan_ensenanza+', '+data.tipo_vocacion+')">'+data.nombre+'</a> &nbsp; <img title="Eliminar" onclick="deletex('+data.plan_ensenanza+', \''+data.nombre+'\')" class="deletex" src="images/deletex.png" /></div>');
                }else{
                	$('#oculto_gestion').val(0);
					$('#O_'+data.plan_ensenanza).html('<div id="O_'+data.plan_ensenanza+'" class="div_anteriores"><a class="cargar_otros" onclick="cargar_plan('+data.plan_ensenanza+', '+data.tipo_vocacion+')">'+data.nombre+'</a> &nbsp; <img title="Eliminar" onclick="deletex('+data.plan_ensenanza+', \''+data.nombre+'\')" class="deletex" src="images/deletex.png" /></div>');
				}
				alert('Guardado exitoso.');
				$("#programa").trigger( "change" );
				
            }
        }
    });
}
function deletex_ensenanza(id, nombre, tipoHorasE){
	
	var r = confirm(String.fromCharCode(191)+"Esta seguro que quiere eliminar las horas ingresadas en la materia "+nombre+"?");
	if (r == true) {
		$.ajax({
			type: 'POST',
			url: 'peticiones_ajax.php',
			async: false,
			dataType: 'json',
			data:({actionID: 'delete_ensenanza',
				id:id,
				tipoHorasE:tipoHorasE
			}),
			error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
			success: function(data){
				if(data.val=='FALSE'){
					alert(data.descrip);
					return false;
				}else{
					$('#E_'+id).slideUp();
					$("#programa").trigger( "change" );
				}
			}
		});
	}
}
function deletex_ensenanza_otros(id, identificador, tipoHorasE){
	if(identificador == 'T'){nombre = 'Horas Talleres'}
	if(identificador == 'P'){nombre = 'Horas PAE'}
	if(identificador == 'I'){nombre = 'Horas TIC'}
    if(identificador == 'N'){nombre = 'Horas Innovar'}
	var r = confirm(String.fromCharCode(191)+"Esta seguro que quiere eliminar el proyecto "+nombre+"?");
	if (r == true) {
        $.ajax({
			type: 'POST',
			url: 'peticiones_ajax.php',
			async: false,
			dataType: 'json',
			data:({actionID: 'delete_ensenanza_otros',
				id:id, 
				identificador:identificador,
				tipoHorasE:tipoHorasE
			}),
			error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
			success: function(data){
				if(data.val=='FALSE'){
					alert(data.descrip);
					return false;
				}else{
					if(identificador == 'T'){
						$('#EOT_'+id).slideUp();
						$("#tipo_ensenanza").trigger( "change" );
						//$("#programa").trigger( "change" );
						/*$('#HorasTaller_').val('');
						$('#expense_table_laboratorios').html('<thead>\
																			<tr>\
																				<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
																				<th>&nbsp;</th>\
																			</tr>\
																		</thead>\
																		<tbody>\
																			<tr>\
																				<td><input class="actividad" type="text" id="l0" name="laboratorios[]" maxlength="800" />\
																				<input type="hidden" value="0" id="oculto_l0" /></td>\
																				<td>&nbsp;</td>\
																			</tr>\
																		</tbody>');*/
					}
					if(identificador == 'P'){
						$('#EOP_'+id).slideUp();
						$("#tipo_ensenanza").trigger( "change" );
						/*$('#HorasPAE_').val('');
						$('#expense_table_pae').html('<thead>\
																			<tr>\
																				<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
																				<th>&nbsp;</th>\
																			</tr>\
																		</thead>\
																		<tbody>\
																			<tr>\
																				<td><input class="actividad" type="text" id="p0" name="pae[]" maxlength="800" />\
																				<input type="hidden" value="0" id="oculto_p0" /></td>\
																				<td>&nbsp;</td>\
																			</tr>\
																		</tbody>');*/
					}
					if(identificador == 'I'){
						$('#EOI_'+id).slideUp();
						$("#tipo_ensenanza").trigger( "change" );
						/*$('#HorasTIC_').val('');
						$('#expense_table_tic').html('<thead>\
																			<tr>\
																				<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
																				<th>&nbsp;</th>\
																			</tr>\
																		</thead>\
																		<tbody>\
																			<tr>\
																				<td><input class="actividad" type="text" id="t0" name="tic[]" maxlength="800" />\
																				<input type="hidden" value="0" id="oculto_t0" /></td>\
																				<td>&nbsp;</td>\
																			</tr>\
																		</tbody>');*/
					}	
                    
                    if(identificador == 'N'){
					$('#EON_'+id).slideUp();
					$("#tipo_ensenanza").trigger( "change" );
					/*$('#HorasTIC_').val('');
					$('#expense_table_tic').html('<thead>\
																			<tr>\
																				<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
																				<th>&nbsp;</th>\
																			</tr>\
																		</thead>\
																		<tbody>\
																			<tr>\
																				<td><input class="actividad" type="text" id="t0" name="tic[]" maxlength="800" />\
																				<input type="hidden" value="0" id="oculto_t0" /></td>\
																				<td>&nbsp;</td>\
																			</tr>\
																		</tbody>');*/
					}	
				}
			}
		});
    }
}
function deletex(id_proyecto, nombre){
	/**/ 
    var r = confirm(String.fromCharCode(191)+"Esta seguro que quiere eliminar el proyecto "+nombre+"?");
    if (r == true) {
        $.ajax({
			type: 'POST',
			url: 'peticiones_ajax.php',
			async: false,
			dataType: 'json',
			data:({actionID: 'delete_otros',
				id_proyecto:id_proyecto
			}),
			error:function(objeto, quepaso, otroobj){alert('Error de Conexin , Favor Vuelva a Intentar');},
			success: function(data){
				if(data.val=='FALSE'){
					alert(data.descrip);
					return false;
				}else{
					$('#O_'+id_proyecto).slideUp();
				}
			}
		});
    }    
}
function cargar_facultad(modalidad){
    $.ajax({
        type: 'POST',
        url: 'peticiones_ajax.php',
        async: false,
        dataType: 'json',
        data:({actionID: 'carga_facultad',
            modalidad:modalidad
        }),
        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        success: function(data){
            if(data.val=='FALSE'){
                alert(data.descrip);
                return false;
            }else{
                if(data.modalidad == 200){
					$('#facultad').html(data.option);
				}else{
					$('#programa').html(data.option);
				}
            }
        }
    });
}
function cargar_programa_academico(facultad_id, documento_docente, periodo_id, modalidad){
    $.ajax({
	       type: 'POST',
		   url: 'peticiones_ajax.php',
           data:({actionID:'cargar_programa_academico',facultad_id:facultad_id, documento_docente:documento_docente, periodo_id:periodo_id, modalidad: modalidad}),
		   error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
		   success:function(data){
                $('#programa').html('');
                $('#programa').html(data);
	       }
    });
}
function cargar_materia(documento_docente, periodo, programa, id_docente){
	
    $.ajax({
	    type: 'POST',
		url: 'peticiones_ajax.php',
		dataType: 'json',
        data:({actionID:'cargar_materia',documento_docente:documento_docente, programa:programa, periodo:periodo, id_docente:id_docente}),
		error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		success:function(data){
			
			$('#materia').html(data.option);
			$('#oculto_ensenanza').val(data.ensenanza_id);
			var plan_nombres = data.plan_nombres;
			var plan_otros = data.plan_otros;
			var plan_vocaciones = data.plan_vocaciones;
			var id_plan_ensenanza = data.id_plan_ensenanza;
			var nombre_plan_ensenanza = data.nombre_plan_ensenanza;
			var codigomateria = data.id_codigomateria;
			var vocacion = 2;
			var tipoHorasE = data.plan_tipoHoras;
			
			var tipoHorasO = data.plan_tipoHorasOtros;
			//alert(tipoHorasO);
			var imprimir = '<h2>Borrar anteriores</h2><br />';
			
			var ensenanza_otros_id = data.ensenanza_otros_id;
			
			var existeDocente = $('#txtExisteDocente').val();
			$.each(id_plan_ensenanza, function(index, value){
				//alert(tipoHorasE[index]);
				if( existeDocente != 0 ){
				imprimir = imprimir + '<div id="E_'+id_plan_ensenanza[index]+'" class="div_anteriores"><a class="cargar_otros" onclick="cargar_plan_ensenanza('+id_plan_ensenanza[index]+','+codigomateria[index]+',\''+tipoHorasE[index]+'\')">'+nombre_plan_ensenanza[index]+' - '+tipoHorasE[index]+'</a> &nbsp; <img title="Eliminar" onclick="deletex_ensenanza('+id_plan_ensenanza[index]+', \''+nombre_plan_ensenanza[index]+'\',\''+tipoHorasE[index]+'\')" class="deletex" src="images/deletex.png" /></div>';
				}else{
				imprimir = imprimir + '<div id="E_'+id_plan_ensenanza[index]+'" class="div_anteriores"><a class="cargar_otros" onclick="cargar_plan_ensenanza('+id_plan_ensenanza[index]+','+codigomateria[index]+',\''+tipoHorasE[index]+'\')">'+nombre_plan_ensenanza[index]+'</a> &nbsp; <img title="Eliminar" onclick="deletex_ensenanza('+id_plan_ensenanza[index]+', \''+nombre_plan_ensenanza[index]+'\',\''+tipoHorasE[index]+'\')" class="deletex" src="images/deletex.png" /></div>';	
				}
			});
			$.each(ensenanza_otros_id, function(index, value){
				if( existeDocente != 0 ){
					var tipoHorasE = data.ensenanza_otros_TipoHora;
					
					if(data.ensenanza_otros_taller[index] !== undefined && data.ensenanza_otros_taller[index] != 0){
						
						imprimir = imprimir + '<div id="EOT_'+ensenanza_otros_id[index]+'" class="div_anteriores"><a class="cargar_otros" onclick="cargar_plan_ensenanzaEO('+ensenanza_otros_id[index]+',\'T\',\''+tipoHorasE[index]+'\')">Horas Talleres - '+tipoHorasE[index]+' </a> &nbsp; <img title="Eliminar" onclick="deletex_ensenanza_otros('+ensenanza_otros_id[index]+', \'T\',\''+tipoHorasE[index]+'\')" class="deletex" src="images/deletex.png" /></div>';
					}
					if(data.ensenanza_otros_pae[index] !== undefined && data.ensenanza_otros_pae[index] != 0){
						
						imprimir = imprimir + '<div id="EOP_'+ensenanza_otros_id[index]+'" class="div_anteriores"><a class="cargar_otros" onclick="cargar_plan_ensenanzaEO('+ensenanza_otros_id[index]+',\'P\',\''+tipoHorasE[index]+'\')">Horas PAE - '+tipoHorasE[index]+' </a> &nbsp; <img title="Eliminar" onclick="deletex_ensenanza_otros('+ensenanza_otros_id[index]+', \'P\',\''+tipoHorasE[index]+'\')" class="deletex" src="images/deletex.png" /></div>';
					}
					if(data.ensenanza_otros_tic[index] !== undefined && data.ensenanza_otros_tic[index] != 0){
						
						imprimir = imprimir + '<div id="EOI_'+ensenanza_otros_id[index]+'" class="div_anteriores"><a class="cargar_otros" onclick="cargar_plan_ensenanzaEO('+ensenanza_otros_id[index]+',\'I\',\''+tipoHorasE[index]+'\')">Horas TIC - '+tipoHorasE[index]+' </a> &nbsp; <img title="Eliminar" onclick="deletex_ensenanza_otros('+ensenanza_otros_id[index]+', \'I\',\''+tipoHorasE[index]+'\')" class="deletex" src="images/deletex.png" /></div>';
					}
                    if(data.ensenanza_otros_Innovar[index] !== undefined && data.ensenanza_otros_Innovar[index] != 0){
						
						imprimir = imprimir + '<div id="EON_'+ensenanza_otros_id[index]+'" class="div_anteriores"><a class="cargar_otros" onclick="cargar_plan_ensenanzaEO('+ensenanza_otros_id[index]+',\'N\',\''+tipoHorasE[index]+'\')">Horas Innovación - '+tipoHorasE[index]+' </a> &nbsp; <img title="Eliminar" onclick="deletex_ensenanza_otros('+ensenanza_otros_id[index]+', \'N\',\''+tipoHorasE[index]+'\')" class="deletex" src="images/deletex.png" /></div>';
					}
				}else{
					var tipoHorasE = data.ensenanza_otros_TipoHora;
					if(data.ensenanza_otros_taller[index] !== undefined && data.ensenanza_otros_taller[index] != 0){
						
						imprimir = imprimir + '<div id="EOT_'+ensenanza_otros_id[index]+'" class="div_anteriores"><a class="cargar_otros" onclick="cargar_plan_ensenanzaEO('+ensenanza_otros_id[index]+',\'T\',\''+tipoHorasE[index]+'\')">Horas Talleres</a> &nbsp; <img title="Eliminar" onclick="deletex_ensenanza_otros('+ensenanza_otros_id[index]+', \'T\',\''+tipoHorasE[index]+'\')" class="deletex" src="images/deletex.png" /></div>';
					}
					if(data.ensenanza_otros_pae[index] !== undefined && data.ensenanza_otros_pae[index] != 0){
						
						imprimir = imprimir + '<div id="EOP_'+ensenanza_otros_id[index]+'" class="div_anteriores"><a class="cargar_otros" onclick="cargar_plan_ensenanzaEO('+ensenanza_otros_id[index]+',\'P\',\''+tipoHorasE[index]+'\')">Horas PAE</a> &nbsp; <img title="Eliminar" onclick="deletex_ensenanza_otros('+ensenanza_otros_id[index]+', \'P\',\''+tipoHorasE[index]+'\')" class="deletex" src="images/deletex.png" /></div>';
					}
					if(data.ensenanza_otros_tic[index] !== undefined && data.ensenanza_otros_tic[index] != 0){
						
						imprimir = imprimir + '<div id="EOI_'+ensenanza_otros_id[index]+'" class="div_anteriores"><a class="cargar_otros" onclick="cargar_plan_ensenanzaEO('+ensenanza_otros_id[index]+',\'I\',\''+tipoHorasE[index]+'\')">Horas TIC</a> &nbsp; <img title="Eliminar" onclick="deletex_ensenanza_otros('+ensenanza_otros_id[index]+', \'I\',\''+tipoHorasE[index]+'\')" class="deletex" src="images/deletex.png" /></div>';
					}
                    if(data.ensenanza_otros_Innovar[index] !== undefined && data.ensenanza_otros_Innovar[index] != 0){
						
						imprimir = imprimir + '<div id="EON_'+ensenanza_otros_id[index]+'" class="div_anteriores"><a class="cargar_otros" onclick="cargar_plan_ensenanzaEO('+ensenanza_otros_id[index]+',\'N\',\''+tipoHorasE[index]+'\')">Horas Innovación</a> &nbsp; <img title="Eliminar" onclick="deletex_ensenanza_otros('+ensenanza_otros_id[index]+', \'N\',\''+tipoHorasE[index]+'\')" class="deletex" src="images/deletex.png" /></div>';
					}
				}
			});
			$('#anteriores_ensenanza').html(imprimir);
			/*** OTROS ***/
			var imprimir = '<h2>Cargar anteriores</h2>';
			$.each(plan_otros, function( index, value ) {
				
				if(plan_vocaciones[index] == vocacion){
					imprimir = imprimir + '<div id="O_'+plan_otros[index]+'" class="div_anteriores"><a class="cargar_otros" onclick="cargar_plan('+plan_otros[index]+','+plan_vocaciones[index]+',\''+tipoHorasO[index]+'\')">'+plan_nombres[index]+'</a> &nbsp; <img title="Eliminar" onclick="deletex('+plan_otros[index]+',\''+plan_nombres[index]+'\')" class="deletex" src="images/deletex.png" /></div><br />';					
				}else{
					if(vocacion == 2){					
						$('#anteriores_descubrimiento').html(imprimir);
					}
					if(vocacion == 3){
						$('#anteriores_compromiso').html(imprimir);
					}
					if(vocacion == 4){
						$('#anteriores_gestion').html(imprimir);
					}
					imprimir = '<h2>Cargar anteriores</h2>';
					imprimir = imprimir + '<div id="O_'+plan_otros[index]+'" class="div_anteriores"><a class="cargar_otros" onclick="cargar_plan('+plan_otros[index]+','+plan_vocaciones[index]+',\''+tipoHorasO[index]+'\')">'+plan_nombres[index]+'</a> &nbsp; <img title="Eliminar" onclick="deletex('+plan_otros[index]+',\''+plan_nombres[index]+'\')" class="deletex" src="images/deletex.png" /></div><br />';
					vocacion = plan_vocaciones[index];
				}
			});
			if(vocacion == 2){					
				$('#anteriores_descubrimiento').html(imprimir);						
			}
			if(vocacion == 3){
				$('#anteriores_compromiso').html(imprimir);
				}
			if(vocacion == 4){
				$('#anteriores_gestion').html(imprimir);
			}
		}
    });
}
/* CONSULTAR DATOS ANTIGUOS */
function consulta_antiguos(facultad, programa, asignatura, documento_docente, periodo, TipoHorasEnsenanza){
    $.ajax({
	    type: 'POST',
		url: 'peticiones_ajax.php',
        data:({actionID:'consulta_antiguos',facultad:facultad, programa:programa, asignatura:asignatura, documento_docente:documento_docente, periodo:periodo, TipoHorasEnsenanza:TipoHorasEnsenanza}),
		error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
		dataType: 'JSON',
        success:function(data){
				$('#oculto_ensenanza').val(data.PlanTrabajoDocenteEnsenanzaId);
                $('#HorasSemana_').val(data.horas_presenciales);
                $('#H_Preparacio_').val(data.horas_preparacion);
                $('#H_Evaluacion_').val(data.horas_evaluacion);
                $('#H_Asesoria_').val(data.horas_asesoria);
				var total = parseInt(data.horas_presenciales) + parseInt(data.horas_preparacion) + parseInt(data.horas_evaluacion) + parseInt(data.horas_asesoria);
				$('#T_horas').val(total);
			if( data.plan_ensenanza != 0 && data.plan_ensenanza !== undefined ){
				var plan_ensenanza = data.plan_ensenanza;
				var tipo = '';
				var tabla = '';
				var indicador = '';
				var imprimir = '<thead><tr><th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th><th>&nbsp;</th></tr></thead><tbody>';
				$.each(plan_ensenanza, function( index, value ) {
					
					tabla = 'subjects';
					indicador = 'e';
					imprimir = imprimir + '<tr><td><input class="actividad" type="text" name="'+tabla+'[]" maxlength="800" id="'+indicador+index+'" value="'+data.plan_ensenanza_nombre[index]+'" /><input type="hidden" id="oculto_'+indicador+index+'" value="'+data.plan_ensenanza[index]+'" /></td><td><input type="button" value="Delete" class="del_ExpenseRow_'+tabla+'" onclick="deleteActividad('+data.plan_ensenanza[index]+')" /></td></tr>';					

				});
				imprimir = imprimir + '</tbody></table>';
				$('#expense_table').html(imprimir);
				
				}else{
				$('#expense_table').html('<thead>\
                                        					<tr>\
                                        						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
                                        						<th>&nbsp;</th>\
                                        					</tr>\
                                        				</thead>\
                                        				<tbody>\
                                        					<tr>\
                                        						<td><input class="actividad" type="text" id="e0" name="subjects[]" maxlength="255" />\
                                                                <input type="hidden" value="0" id="oculto_e0" /></td>\
                                        						<td>&nbsp;</td>\
                                        					</tr>\
                                        				</tbody>');
			}
	    }
    });
}
function cargar_plan_ensenanza(id_plan_ensenanza, codigomateria, tipoHorasE){
	
	$('#table_asignatura').css('display', 'none');
        $('#table_laboratorios').css('display', 'none');
        $('#table_pae').css('display', 'none');
        $('#table_tic').css('display', 'none');
        $('#table_Innovar').css('display', 'none');
	if(codigomateria != 'T' && codigomateria != 'P' && codigomateria != 'I' && codigomateria != 'N'){
		var facultad = $('#facultad').val();
        var programa = $('#programa').val();        
        var asignatura = codigomateria;
        var documento_docente = $('#DocenteId').val();
        var periodo = $('#Periodo').val();
        var TipoHorasEnsenanza = tipoHorasE;
		$('#tipo_ensenanza').val(1);
		$('#materia').val(codigomateria);
		$('#cmbTipoHorasEnsenanza').val(TipoHorasEnsenanza);
		$('#table_asignatura').slideDown();
        $('#table_materia').slideDown();
        $('#table_tipoHorasEnsenanza').slideDown();
		consulta_antiguos(facultad, programa, asignatura, documento_docente, periodo, TipoHorasEnsenanza);
	}
}
function Suma(){
	var semana = '';
    var preparacion = '';
    var evaluacion = '';
    var asesoria = '';
	if($('#HorasSemana_').val() == ''){semana = 0}else{semana = parseInt($('#HorasSemana_').val())}
	if($('#H_Preparacio_').val() == ''){preparacion = 0}else{preparacion = parseInt($('#H_Preparacio_').val())}
	if($('#H_Evaluacion_').val() == ''){evaluacion = 0}else{evaluacion = parseInt($('#H_Evaluacion_').val())}
	if($('#H_Asesoria_').val() == ''){asesoria = 0}else{asesoria = parseInt($('#H_Asesoria_').val())}
	var total = semana + preparacion + evaluacion + asesoria;
	$('#T_horas').val(total);
}
function consultar_antiguos_EO(programa, periodo, id_docente, TipoHorasEnsenanza, tipo_Actividad){
	
    $.ajax({
            type: 'POST',
            url: 'peticiones_ajax.php',
            async: false,
            dataType: 'json',
            data:({actionID: 'consultar_antiguos_EO',
                programa:programa,
                periodo:periodo,
                id_docente:id_docente,
                TipoHorasEnsenanza:TipoHorasEnsenanza,
                tipo_Actividad:tipo_Actividad
           		}),
           	error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
            success: function(data){
          
           if(data.ensenanza_id !== undefined ){
				$('#HorasTaller_').val(data.ensenanza_horas_tal);
				$('#HorasPAE_').val(data.ensenanza_horas_pae);
				$('#HorasTIC_').val(data.ensenanza_horas_tic);
                $('#HorasInnovar_').val(data.ensenanza_horas_Innovar);
				
			if(data.ensenanza_horas_tal == 0){
				$('#btnActualizar').css("display", "none");
				$('#btnGuardar').css("display", "block");
				
				$('#expense_table_laboratorios').html('<thead>\
	                        					<tr>\
	                        						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
	                        						<th>&nbsp;</th>\
	                        					</tr>\
	                        				</thead>\
	                        				<tbody>\
	                        					<tr>\
	                        						<td><input class="actividad" type="text" id="l0" name="laboratorios[]" maxlength="255" />\
	                                                <input type="hidden" value="0" id="oculto_l0" /></td>\
	                        						<td>&nbsp;</td>\
	                        					</tr>\
	                        				</tbody>');	
				}else{
					$('#btnActualizar').css("display", "block");
					$('#btnGuardar').css("display", "none");
				}
							
				if(data.ensenanza_horas_pae == 0){
					
					$('#btnActualizarPAE').css("display", "none");
					$('#btnGuardarPAE').css("display", "block");
					
					$('#expense_table_pae').html('<thead>\
                                					<tr>\
                                						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
                                						<th>&nbsp;</th>\
                                					</tr>\
                                				</thead>\
                                				<tbody>\
                                					<tr>\
                                						<td><input class="actividad" type="text" id="p0" name="pae[]" maxlength="255" />\
                                                        <input type="hidden" value="0" id="oculto_p0" /></td>\
                                						<td>&nbsp;</td>\
                                					</tr>\
                                				</tbody>');
             	}else{
             		$('#btnActualizarPAE').css("display", "block");
					$('#btnGuardarPAE').css("display", "none");	
             	}
				if(data.ensenanza_horas_tic == 0){
					$('#btnActualizarTIC').css("display", "none");
					$('#btnGuardarTIC').css("display", "block");	
                    
                    $('#expense_table_tic').html('<thead>\
                                					<tr>\
                                						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
                                						<th>&nbsp;</th>\
                                					</tr>\
                                				</thead>\
                                				<tbody>\
                                					<tr>\
                                						<td><input class="actividad" type="text" id="t0" name="tic[]" maxlength="255" />\
                                                        <input type="hidden" value="0" id="oculto_t0" /></td>\
                                						<td>&nbsp;</td>\
                                					</tr>\
                                				</tbody>');
        		}else{
        			$('#btnActualizarTIC').css("display", "block");
					$('#btnGuardarTIC').css("display", "none");	
        		}
               	if(data.ensenanza_horas_Innovar == 0){
					$('#btnActualizarInnovar').css("display", "none");
					$('#btnGuardarInnovar').css("display", "block");	
                    
                    $('#expense_table_Innovar').html('<thead>\
                                					<tr>\
                                						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
                                						<th>&nbsp;</th>\
                                					</tr>\
                                				</thead>\
                                				<tbody>\
                                					<tr>\
                                						<td><input class="actividad" type="text" id="t0" name="Innovar[]" maxlength="255" />\
                                                        <input type="hidden" value="0" id="oculto_t0" /></td>\
                                						<td>&nbsp;</td>\
                                					</tr>\
                                				</tbody>');
        		}else{
        			$('#btnActualizarInnovar').css("display", "block");
					$('#btnGuardarInnovar').css("display", "none");	
        		}
				var plan_ensenanza = data.plan_ensenanza;				
				var tabla = '';
				var tipo = data.plan_ensenanza_tipo;
				var indicador = '';
				var imprimir = '<thead><tr><th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th><th>&nbsp;</th></tr></thead><tbody>';
				$.each(plan_ensenanza, function( index, value ){
					
					if(data.plan_ensenanza_tipo[index] == 2){
						
						tabla = 'laboratorios';
						indicador = 'l';
					}
					if(data.plan_ensenanza_tipo[index] == 3){
						
						tabla = 'pae';
						indicador = 'p';
						
					}
					if(data.plan_ensenanza_tipo[index] == 4){
						tabla = 'tic';
						indicador = 't';
					}
                    if(data.plan_ensenanza_tipo[index] == 5){
						tabla = 'Innovar';
						indicador = 'i';
					}
					imprimir = imprimir + '<tr><td><input class="actividad" type="text" name="'+tabla+'[]" maxlength="255" id="'+indicador+index+'" value="'+data.plan_ensenanza_nombre[index]+'" /><input type="hidden" id="oculto_'+indicador+index+'" value="'+plan_ensenanza[index]+'" /><input type="hidden" id="txtPlanEnsenanza" name="txtPlanEnsenanza" value="'+data.ensenanza_id+'" /></td><td><input type="button" value="Delete" class="del_ExpenseRow_'+tabla+'" onclick="deleteActividad('+plan_ensenanza[index]+')" /></td></tr>';
					tipo = data.plan_ensenanza_tipo[index];

					});
				imprimir = imprimir + '</tbody></table>';
				if(tipo == 1){
					$('#expense_table').html(imprimir);						
				}
				if(tipo == 2){
					$('#expense_table_laboratorios').html(imprimir);
				}
				if(tipo == 3){
					$('#expense_table_pae').html(imprimir);
				}
				if(tipo == 4){
					$('#expense_table_tic').html(imprimir);
				}
               	if(tipo == 5){
					$('#expense_table_Innovar').html(imprimir);
				}
			}else{
				$('#btnActualizar').css("display", "none");
				$('#btnGuardar').css("display", "block");
				$('#HorasTaller_').val('');
				$('#expense_table_laboratorios').html('<thead>\
                                        					<tr>\
                                        						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
                                        						<th>&nbsp;</th>\
                                        					</tr>\
                                        				</thead>\
                                        				<tbody>\
                                        					<tr>\
                                        						<td><input class="actividad" type="text" id="l0" name="laboratorios[]" maxlength="255" />\
                                                                <input type="hidden" value="0" id="oculto_l0" /></td>\
                                        						<td>&nbsp;</td>\
                                        					</tr>\
                                        				</tbody>');
               
               
               
        		$('#btnActualizarPAE').css("display", "none");
				$('#btnGuardarPAE').css("display", "block");
        		$('#HorasPAE_').val('');
				$('#expense_table_pae').html('<thead>\
                                        					<tr>\
                                        						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
                                        						<th>&nbsp;</th>\
                                        					</tr>\
                                        				</thead>\
                                        				<tbody>\
                                        					<tr>\
                                        						<td><input class="actividad" type="text" id="p0" name="pae[]" maxlength="255" />\
                                                                <input type="hidden" value="0" id="oculto_p0" /></td>\
                                        						<td>&nbsp;</td>\
                                        					</tr>\
                                        				</tbody>');
               
                $('#btnActualizarTIC').css("display", "none");
				$('#btnGuardarTIC').css("display", "block");
                $('#HorasTIC_').val('');
				$('#expense_table_tic').html('<thead>\
                                        					<tr>\
                                        						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
                                        						<th>&nbsp;</th>\
                                        					</tr>\
                                        				</thead>\
                                        				<tbody>\
                                        					<tr>\
                                        						<td><input class="actividad" type="text" id="t0" name="tic[]" maxlength="255" />\
                                                                <input type="hidden" value="0" id="oculto_t0" /></td>\
                                        						<td>&nbsp;</td>\
                                        					</tr>\
                                        				</tbody>');
                
                
                $('#btnActualizarInnovar').css("display", "none");
				$('#btnGuardarInnovar').css("display", "block");
                $('#HorasInnovar_').val('');
				$('#expense_table_Innovar').html('<thead>\
                                        					<tr>\
                                        						<th style="width:95%">Planeaci&oacute;n de actividades a desarrollar</th>\
                                        						<th>&nbsp;</th>\
                                        					</tr>\
                                        				</thead>\
                                        				<tbody>\
                                        					<tr>\
                                        						<td><input class="actividad" type="text" id="t0" name="Innovar[]" maxlength="255" />\
                                                                <input type="hidden" value="0" id="oculto_t0" /></td>\
                                        						<td>&nbsp;</td>\
                                        					</tr>\
                                        				</tbody>');
				
				}
            
       		}
       });
}
function cargar_plan_ensenanzaEO(ensenanza_otros_id, codigomateria, tipoHorasE){
	
	$('#table_asignatura').css('display', 'none');
        $('#table_laboratorios').css('display', 'none');
        $('#table_pae').css('display', 'none');
        $('#table_tic').css('display', 'none');
        $('#table_Innovar').css('display', 'none');
	
		if(codigomateria == 'T'){
			var programa = $('#programa').val();
        	var periodo = $('#Periodo').val();
        	var id_docente = $('#Docente_id').val();
			$('#tipo_ensenanza').val(2);
			var TipoHorasEnsenanza = tipoHorasE;
			var tipo_Actividad = 2;
			$('#cmbTipoHorasEnsenanza').val(TipoHorasEnsenanza);
			$('#table_laboratorios').slideDown();
			$('#btnActualizar').css("display", "block");
			$('#btnGuardar').css("display", "none");
			$('#table_tipoHorasEnsenanza').slideDown();
            $('#table_asignatura').slideUp();
            $('#table_materia').slideUp();
            consultar_antiguos_EO(programa, periodo, id_docente, TipoHorasEnsenanza, tipo_Actividad);
		}
		if(codigomateria == 'P'){
			var programa = $('#programa').val();
        	var periodo = $('#Periodo').val();
        	var id_docente = $('#Docente_id').val();
			
			var TipoHorasEnsenanza = tipoHorasE;
			$('#tipo_ensenanza').val(3);
			$('#cmbTipoHorasEnsenanza').val(TipoHorasEnsenanza);
			var tipo_Actividad = 3;
			$('#table_pae').slideDown();
			$('#btnActualizarPAE').css("display", "block");
			$('#btnGuardarPAE').css("display", "none");
			$('#table_tipoHorasEnsenanza').slideDown();
            $('#table_asignatura').slideUp();
            $('#table_materia').slideUp();
            consultar_antiguos_EO(programa, periodo, id_docente, TipoHorasEnsenanza, tipo_Actividad);
		}
		if(codigomateria == 'I'){
			var programa = $('#programa').val();
        	var periodo = $('#Periodo').val();
        	var id_docente = $('#Docente_id').val();
			$('#tipo_ensenanza').val(4);
			var TipoHorasEnsenanza = tipoHorasE;
			var tipo_Actividad = 4;
			$('#cmbTipoHorasEnsenanza').val(TipoHorasEnsenanza);
			$('#table_tic').slideDown();
			$('#btnActualizarTIC').css("display", "block");
			$('#btnGuardarTIC').css("display", "none");
			$('#table_tipoHorasEnsenanza').slideDown();
            $('#table_asignatura').slideUp();
            $('#table_materia').slideUp();
            consultar_antiguos_EO(programa, periodo, id_docente, TipoHorasEnsenanza, tipo_Actividad);
		}
        if(codigomateria == 'N'){
			var programa = $('#programa').val();
        	var periodo = $('#Periodo').val();
        	var id_docente = $('#Docente_id').val();
			$('#tipo_ensenanza').val(5);
			var TipoHorasEnsenanza = tipoHorasE;
			var tipo_Actividad = 5;
			$('#cmbTipoHorasEnsenanza').val(TipoHorasEnsenanza);
			$('#table_Innovar').slideDown();
			$('#btnActualizarInnovar').css("display", "block");
			$('#btnGuardarInnovar').css("display", "none");
			$('#table_tipoHorasEnsenanza').slideDown();
            $('#table_asignatura').slideUp();
            $('#table_materia').slideUp();
            consultar_antiguos_EO(programa, periodo, id_docente, TipoHorasEnsenanza, tipo_Actividad);
		}

	
}



function fechaActualD(){
	var d = new Date();

	var month = d.getMonth()+1;
	var day = d.getDate();
	var output = d.getFullYear() + '/' +
    	((''+month).length<2 ? '0' : '') + month + '/' +
    	((''+day).length<2 ? '0' : '') + day;
    /*
     * Caso 101123
     * @modified Luis Dario Gualteros <castroluisd@unbosque.edu.co>
     * Se habilitan los meses de Junio y Noviembre para el registro de actividades de acuerdo a la solicitud de Liliana Ahumada.
     * @since Junio 12 de 2018.
    */ 
    var rango = [1,2,3,4,5,6,7,8,9,10,11,12];
   //End Caso 101123.
	if( rango.indexOf(month) > -1 ){
	   	$("#contenedores").fadeIn(2000);

	}else{
		alert("El tiempo límite para ingresar su Plan de Trabajo ha terminado.");
		$("#contenedores").fadeOut();
		$("#planTrabajo").prop("disabled", true);
		$("#planTrabajo").css({'background':'grey'});
		//$("#contenedores").fadeIn(2000);
	} 
}


function deleteActividad( idProyecto ){
	var id_Proyecto = idProyecto;
	$.ajax({
        type: 'POST',
        url: 'peticiones_ajax.php',
        async: false,
        dataType: 'json',
        data:({actionID: 'deleteActividad',
            id_Proyecto:id_Proyecto
        }),
        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        success: function(data){
            if(data.val=='FALSE'){
                alert(data.descrip);
                return false;
            }
         }   
    });
}


function deleteActividadOtros( idProyectoOtros ){
	var id_ProyectoOtros = idProyectoOtros;
	$.ajax({
        type: 'POST',
        url: 'peticiones_ajax.php',
        async: false,
        dataType: 'json',
        data:({actionID: 'deleteActividadOtros',
            id_ProyectoOtros:id_ProyectoOtros
        }),
        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
        success: function(data){
            if(data.val=='FALSE'){
                alert(data.descrip);
                return false;
            }
         }   
    });
}



