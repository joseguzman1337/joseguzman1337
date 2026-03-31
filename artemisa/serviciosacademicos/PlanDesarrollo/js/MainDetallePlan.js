/**
 * @author Ivan quintero 
 * Febrero 22, 2017
 */

$( "#verArchivos" ).dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		title: "Ver Anexos",
		width: 'auto',
		height: 'auto',
		show: {
	        effect: "blind",
	        duration: 500
	      },
	    hide: {
	        effect: "explode",
	        duration: 500
	    },
		buttons: {
					"Cerrar": function( ) { 
						$(this).dialog("close"); 
					}
			},
		open: function() {
		    $buttonPane = $(this).next();
		    $buttonPane.find('button').addClass('btn').addClass('btn-warning');
        }
});


$("#btnGuardarObservacion").button( ).click(function( e ){
	e.stopPropagation();
	e.preventDefault();
	var tipoOperacion = "guardarObservacion";
	var txtObservacionSupervisor = $("#txtObservacionSupervisor").val( );
	var txtAvanceSupervisor = $("#txtAvanceSupervisor").val( );
	var txtIdActividadMetaSecundaria = $("#txtIdActividadMetaSecundaria").val( );
	var txtAvancePropuesto = $("#txtAvancePropuesto").val( );
	var txtIdTipoIndicador = $("#txtIdTipoIndicador").val( );
	var txtIdMetaSecundaria = $( "#txtIdMetaSecundaria" ).val( );
	$.ajax({
		 type: "POST",
          url: "../servicio/actividad.php",
		  data: { tipoOperacion : tipoOperacion, txtObservacionSupervisor : txtObservacionSupervisor, txtAvanceSupervisor : txtAvanceSupervisor, txtIdActividadMetaSecundaria : txtIdActividadMetaSecundaria, txtAvancePropuesto : txtAvancePropuesto, txtIdTipoIndicador : txtIdTipoIndicador, txtIdMetaSecundaria : txtIdMetaSecundaria },
		  success: function( data ){
		  	//$("#log").html( data );
		  	if( data.length > 0 ){
		  		alert( data );
		  	}else{
		  		alert( "Cambios guardados correctamente" );
		  		$("#detallePlan").dialog("close");
		  	}
          }
	});
});

$("#btnRestaurarObservacion").click(function( e ){
	e.stopPropagation();
	e.preventDefault();
	$("#detallePlan").dialog("close");
});
