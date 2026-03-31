/**
 * @author suarezcarlos
 */

$(function() {
$("#btn-Actualizar").on("click",function(){
	
	modalidad = $(this).val();
	
	var actividades= new Array();
    var actividades_id = new Array();
    var ocultos_actividades = new Array();
    
    var txtPlanEnsenanza = $('#txtPlanEnsenanza').val(); 
    ////datos generales para guardar
    docente_id=$('#DocenteId').val();
    programaAcademicoId=$('#programa').val();
    asignatura_id=$('#materia').val();
    periodo=$('#Periodo').val();
    var TipoHorasEnsenanza = $('#cmbTipoHorasEnsenanza').val();
    
    
    ////horas de ense�anza
    /*
    * Caso 87930
    * @modified Luis Dario Gualteros 
    * <castroluisd@unbosque.edu.co>
    * Se crea la opcion para visulización del nuevo campo de innovación para nueva funcionalidad de Innovación según
    * solicitud de Liliana Ahumada.
    * @since Marzo 6 de 2017
    */ 
    horasTaller=$('#HorasTaller_').val();
    horasPae=$('#HorasPAE_').val();
    horasTic = $('#HorasTIC_').val();
    horasInnovar = $('#HorasInnovar_').val();
    tipo_ensenanza = $('#tipo_ensenanza').val();
    oculto_ensenanza = $('#oculto_ensenanza').val();
    
    if(asignatura_id == 0)
        asignatura_id = 'NULL';
        
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
    
    if(modalidad == 'laboratorios' ){
		asignatura_id = 1;
        $('input[name="laboratorios[]"]').each(function(i) {
            actividades[i]=$(this).val();
            actividades_id[i]=$(this).attr('id');
            ocultos_actividades[i] = $('#oculto_'+actividades_id[i]).val();
            i++;
        });
    }
    if(actividades[0] == ''){
        alert("Favor ingresar al menos una actividad antes de guardar");
        return false;
    }else{
			
			$.ajax({
				type: 'POST',
				url: 'peticiones_ajax.php',
				async: false,
				dataType: 'json',
				data:({actionID: 'actualizar_ensenanzayapredizaje_varios',
					programaAcademicoId:programaAcademicoId,
					asignatura_id:asignatura_id,
					docente_id: docente_id,
					periodo:periodo,
					horasTic:horasTic,
                    horasInnovar:horasInnovar,   
					horasTaller:horasTaller,
					horasPae:horasPae,
					tipo_ensenanza:tipo_ensenanza,
					oculto_ensenanza:oculto_ensenanza,
					modalidad:modalidad,
					TipoHorasEnsenanza:TipoHorasEnsenanza,
					actividades:actividades,
					ocultos_actividades: ocultos_actividades,
					txtPlanEnsenanza:txtPlanEnsenanza
				}),
				error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
				success: function(data){
					if(data.val=='FALSE'){
						alert(data.descrip);
						return false;
					}else{
						$('#oculto_ensenanza').val(data.plan_ensenanza);
						var str = data.arr_id_actividades;
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
	return false;
});
});

$(function() {
$("#btn-ActualizarPAE").on("click",function(){
	
	modalidad = $(this).val();
	
	var actividades= new Array();
    var actividades_id = new Array();
    var ocultos_actividades = new Array();
    
    var txtPlanEnsenanza = $('#txtPlanEnsenanza').val(); 
    ////datos generales para guardar
    docente_id=$('#DocenteId').val();
    programaAcademicoId=$('#programa').val();
    asignatura_id=$('#materia').val();
    periodo=$('#Periodo').val();
    var TipoHorasEnsenanza = $('#cmbTipoHorasEnsenanza').val();
    
    
    ////horas de ense�anza
    horasTaller=$('#HorasTaller_').val();
    horasPae=$('#HorasPAE_').val();
    horasTic = $('#HorasTIC_').val();
    horasInnovar = $('#HorasInnovar_').val();
    tipo_ensenanza = $('#tipo_ensenanza').val();
    oculto_ensenanza = $('#oculto_ensenanza').val();
    
    if(asignatura_id == 0)
        asignatura_id = 'NULL';
        
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
    
    if(modalidad == 'pae'){
		asignatura_id = 1;
        $('input[name="pae[]"]').each(function(i) {
            actividades[i]=$(this).val();
            actividades_id[i]=$(this).attr('id');
            ocultos_actividades[i] = $('#oculto_'+actividades_id[i]).val();
            i++;
        });
    }
  // alert(txtPlanEnsenanza);
  // var cadena=programaAcademicoId+','+asignatura_id+','+docente_id+','+periodo+','+horasSemana+','+horasPreparacion+','+horasEvaluacion+','+horasAsesoria+','+horasTic+','+horasTaller+','+horasPae+','+tipo_ensenanza+','+oculto_ensenanza+','+tipo_actividad+','+modalidad+','+TipoHorasEnsenanza;
   
    if(actividades[0] == ''){
        alert("Favor ingresar al menos una actividad antes de guardar");
        return false;
    }else{
			//var TipoHorasEnsenanzaEO = $('#cmbTipoHorasEnsenanza').val();
			//alert("Entro a Actualizar");
			$.ajax({
				type: 'POST',
				url: 'peticiones_ajax.php',
				async: false,
				dataType: 'json',
				data:({actionID: 'actualizar_ensenanzayapredizaje_varios',
					programaAcademicoId:programaAcademicoId,
					asignatura_id:asignatura_id,
					docente_id: docente_id,
					periodo:periodo,
					horasTic:horasTic,
                    horasInnovar:horasInnovar,   
					horasTaller:horasTaller,
					horasPae:horasPae,
					tipo_ensenanza:tipo_ensenanza,
					oculto_ensenanza:oculto_ensenanza,
					modalidad:modalidad,
					TipoHorasEnsenanza:TipoHorasEnsenanza,
					actividades:actividades,
					ocultos_actividades: ocultos_actividades,
					txtPlanEnsenanza:txtPlanEnsenanza
				}),
				error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				success: function(data){
					if(data.val=='FALSE'){
						alert(data.descrip);
						return false;
					}else{
						
						$('#oculto_ensenanza').val(data.plan_ensenanza);
						var str = data.arr_id_actividades;
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
	return false;
});
});

$(function() {
$("#btn-ActualizarTIC").on("click",function(){
	
	modalidad = $(this).val();
	
	var actividades= new Array();
    var actividades_id = new Array();
    var ocultos_actividades = new Array();
    
    var txtPlanEnsenanza = $('#txtPlanEnsenanza').val(); 
    ////datos generales para guardar
    docente_id=$('#DocenteId').val();
    programaAcademicoId=$('#programa').val();
    asignatura_id=$('#materia').val();
    periodo=$('#Periodo').val();
    var TipoHorasEnsenanza = $('#cmbTipoHorasEnsenanza').val();
    
    
    ////horas de ense�anza
    horasTaller=$('#HorasTaller_').val();
    horasPae=$('#HorasPAE_').val();
    horasTic = $('#HorasTIC_').val();
    horasInnovar = $('#HorasInnovar_').val();
    tipo_ensenanza = $('#tipo_ensenanza').val();
    oculto_ensenanza = $('#oculto_ensenanza').val();
    
    if(asignatura_id == 0)
        asignatura_id = 'NULL';
        
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
    
    if( modalidad == 'tic' ){
		asignatura_id = 1;
        $('input[name="tic[]"]').each(function(i) {
            actividades[i]=$(this).val();
            actividades_id[i]=$(this).attr('id');
			ocultos_actividades[i] = $('#oculto_'+actividades_id[i]).val();
            i++;
        });
    }
    if(actividades[0] == ''){
        alert("Favor ingresar al menos una actividad antes de guardar");
        return false;
    }else{
		
			$.ajax({
				type: 'POST',
				url: 'peticiones_ajax.php',
				async: false,
				dataType: 'json',
				data:({actionID: 'actualizar_ensenanzayapredizaje_varios',
					programaAcademicoId:programaAcademicoId,
					asignatura_id:asignatura_id,
					docente_id: docente_id,
					periodo:periodo,
					horasTic:horasTic,
                    horasInnovar:horasInnovar,
					horasTaller:horasTaller,
					horasPae:horasPae,
					tipo_ensenanza:tipo_ensenanza,
					oculto_ensenanza:oculto_ensenanza,
					modalidad:modalidad,
					TipoHorasEnsenanza:TipoHorasEnsenanza,
					actividades:actividades,
					ocultos_actividades: ocultos_actividades,
					txtPlanEnsenanza:txtPlanEnsenanza
				}),
				error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				success: function(data){
					if(data.val=='FALSE'){
						alert(data.descrip);
						return false;
					}else{
						
						$('#oculto_ensenanza').val(data.plan_ensenanza);
						var str = data.arr_id_actividades;
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
	return false;
});
});

//
$(function() {
$("#btn-ActualizarInnovar").on("click",function(){
	
	modalidad = $(this).val();
	
	var actividades= new Array();
    var actividades_id = new Array();
    var ocultos_actividades = new Array();
    
    var txtPlanEnsenanza = $('#txtPlanEnsenanza').val(); 
    ////datos generales para guardar
    docente_id=$('#DocenteId').val();
    programaAcademicoId=$('#programa').val();
    asignatura_id=$('#materia').val();
    periodo=$('#Periodo').val();
    var TipoHorasEnsenanza = $('#cmbTipoHorasEnsenanza').val();
    
    
    ////horas de ense�anza
    horasTaller=$('#HorasTaller_').val();
    horasPae=$('#HorasPAE_').val();
    horasTic = $('#HorasTIC_').val();
    horasInnovar = $('#HorasInnovar_').val();
    tipo_ensenanza = $('#tipo_ensenanza').val();
    oculto_ensenanza = $('#oculto_ensenanza').val();
    
    if(asignatura_id == 0)
        asignatura_id = 'NULL';
        
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
    
    if( modalidad == 'Innovar' ){
		asignatura_id = 1;
        $('input[name="Innovar[]"]').each(function(i) {
            actividades[i]=$(this).val();
            actividades_id[i]=$(this).attr('id');
			ocultos_actividades[i] = $('#oculto_'+actividades_id[i]).val();
            i++;
        });
    }
    if(actividades[0] == ''){
        alert("Favor ingresar al menos una actividad antes de guardar");
        return false;
    }else{
		
			$.ajax({
				type: 'POST',
				url: 'peticiones_ajax.php',
				async: false,
				dataType: 'json',
				data:({actionID: 'actualizar_ensenanzayapredizaje_varios',
					programaAcademicoId:programaAcademicoId,
					asignatura_id:asignatura_id,
					docente_id: docente_id,
					periodo:periodo,
					horasTic:horasTic,
                    horasInnovar:horasInnovar,
					horasTaller:horasTaller,
					horasPae:horasPae,
					tipo_ensenanza:tipo_ensenanza,
					oculto_ensenanza:oculto_ensenanza,
					modalidad:modalidad,
					TipoHorasEnsenanza:TipoHorasEnsenanza,
					actividades:actividades,
					ocultos_actividades: ocultos_actividades,
					txtPlanEnsenanza:txtPlanEnsenanza
				}),
    /*END Caso 87930*/            
				error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				success: function(data){
					if(data.val=='FALSE'){
						alert(data.descrip);
						return false;
					}else{
						
						$('#oculto_ensenanza').val(data.plan_ensenanza);
						var str = data.arr_id_actividades;
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
	return false;
});
});


//
$(function() {
	$("#btnPortafolio").click(function(){
	
		$("#contenedorPortafolio").slideToggle(function(){
		//$("#tabs-2").load("index.php?id_Docente="+id_Docente+" #tabs-2");
		var propertyDisplay = $("#contenedores").css("display");
		var propertyDisplay2 = $("#contenedorAutoevaluacion").css("display");
		var propertyDisplay3 = $("#contenedorPlanMejora").css("display");
		
		if( propertyDisplay == "block" || propertyDisplay2 == "block" || propertyDisplay3 == "block" ){
		$("#contenedores").css("display", "none");
		$("#contenedorAutoevaluacion").css("display", "none");
		$("#contenedorPlanMejora").css("display", "none");
		
		}else{
				var programa = $("#programa").val( );
				if( programa != 0 ){
					var propertyProp = $("#planTrabajo").prop("disabled");
					if( propertyProp === true ){
						$("#contenedores").css("display", "none");
					}else{
						$("#contenedores").css("display", "block");
					}
				}
			}
		});
	
	});
});

$(function(){
	$("#btnAutoevaluacion").click(function(){
		$("#contenedorAutoevaluacion").slideToggle(function(){
			var propertyDisplay = $("#contenedores").css("display");
			var propertyDisplay2 = $("#contenedorPortafolio").css("display");
			var propertyDisplay3 = $("#contenedorPlanMejora").css("display");
			
			if( propertyDisplay == "block" || propertyDisplay2 == "block" || propertyDisplay3 == "block" ){
				$("#contenedores").css("display", "none");
				$("#contenedorPortafolio").css("display", "none");
				$("#contenedorPlanMejora").css("display", "none");
			}else{
					var programa = $("#programa").val( );
					if( programa != 0 ){
						var propertyProp = $("#planTrabajo").prop("disabled");
						if( propertyProp === true ){
							$("#contenedores").css("display", "none");
						}else{
							$("#contenedores").css("display", "block");
						}	
					}
				}
		});
	});
});


$(function(){
	$("#btnPlanMejora").click(function(){
		$("#contenedorPlanMejora").slideToggle(function(){
			var propertyDisplay = $("#contenedores").css("display");
			var propertyDisplay2 = $("#contenedorPortafolio").css("display");
			var propertyDisplay3 = $("#contenedorAutoevaluacion").css("display");
			
			if( propertyDisplay == "block" || propertyDisplay2 == "block" || propertyDisplay3 == "block" ){
				$("#contenedores").css("display", "none");
				$("#contenedorPortafolio").css("display", "none");
				$("#contenedorAutoevaluacion").css("display", "none");
			}else{
					var programa = $("#programa").val( );
					if( programa != 0 ){
						var propertyProp = $("#planTrabajo").prop("disabled");
						if( propertyProp === true ){
							$("#contenedores").css("display", "none");
						}else{
							$("#contenedores").css("display", "block");
						}	
					}
				}
		});
	});
});


$(function(){
	$( "#btnDocenteSobreSueldo").button( ).click(function( ){
		var txtIdDocente = $("#txtIdDocente").val( );
		$.ajax({
        url: "verHorasSobreSueldo.php",
        type: "POST",
        data: { txtIdDocente : txtIdDocente },
        success: function( data ){
        	alert(data);
            $( "#dialog_HoraSobreSueldo" ).html( data );
        	}
    	});
		$( "#dialog_HoraSobreSueldo" ).dialog( "open" );
		return false
	});
});

$(function(){
	$( "#dvEnviarCorreo" ).dialog({
		autoOpen: false,
		width: 'auto',
		show: {
			effect: "blind",
			duration: 1000
		},
		hide: {
			effect: "explode",
			duration: 1000
		}
	});
});

/*$(function(){
	$("#btnGuardaAEvaluacion").click(function(){
		
		var oEditor = CKEDITOR.instances['txtAutoEvaluacion'].getData();
		var porcentaje = $("#cmbAutoEvaluacion").val();
		alert(oEditor);
		alert(porcentaje);
		
		return false;
	});
});*/

//Funcionalidad del botón para enviar correo masivo

/*$(function(){
	$("#btnCorreoPortafolio").button( ).click(function( ){
		alert("Prueba");
		var tipoOperacionCorreo = "enviarCorreoPortafolio";
		$.ajax({
	        url: "enviarCorreoPortafolio.php",
	        type: "POST",
	        data: { tipoOperacionCorreo : tipoOperacionCorreo },
	        success: function( data ){
        	//alert(data);
            $( "#dvEnviarCorreo" ).html( data );
    	}
    	});
		$( "#dvEnviarCorreo" ).dialog( "open" );
		return false;
	});
});*/

///*************//////

