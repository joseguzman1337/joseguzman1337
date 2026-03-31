/**
 * @author suarezcarlos
 */


var dates = $( ".txtFechaIncentivo" ).datepicker({
	defaultDate: "0w",
	changeMonth: true,
	numberOfMonths: 2,
	changeYear: true,
	dateFormat : 'yy-mm-dd',
	onSelect: function( selectedDate ) {
		var option = this.id == "txtFechaIncentivo",
			instance = $( this ).data( "datepicker" ),
			date = $.datepicker.parseDate(
				instance.settings.dateFormat ||
				$.datepicker._defaults.dateFormat,
				selectedDate, instance.settings );
		dates.not( this ).datepicker( "option", option, date );
	}
},$.datepicker.regional["es"]);

$("#btnActualizarIncentivo").button( ).click( function( ){
	var txtIdIncentivos = $(".txtIdIncentivo").serialize( );
	var txtNumeroActaIncentivos = $(".txtNumeroActaIncentivo").serialize( );
	var txtNumeroAcuerdoIncentivos = $(".txtNumeroAcuerdoIncentivo").serialize( );
	var txtFechaIncentivos = $(".txtFechaIncentivo").serialize( );
	var txtNumeroConsecutivoIncentivos = $(".txtNumeroConsecutivoIncentivo").serialize( );
	var txtCodigoEstudiante = $("#txtCodigoEstudiante").val( );
	var txtCodigoCarrera = $("#txtCodigoCarrera").val( );
	$.ajax({
		url: "../servicio/incentivo.php",
  		type: "POST",
  		data: {txtIdIncentivos : txtIdIncentivos, txtNumeroActaIncentivos : txtNumeroActaIncentivos, txtNumeroAcuerdoIncentivos : txtNumeroAcuerdoIncentivos, txtFechaIncentivos : txtFechaIncentivos, txtNumeroConsecutivoIncentivos : txtNumeroConsecutivoIncentivos, txtCodigoEstudiante : txtCodigoEstudiante, txtCodigoCarrera : txtCodigoCarrera  },
		success: function(data){
			if( data.length > 0 ){
				alert( "Ha Ocurrido un problema" );
			}else{
				alert( "Cambios Guardados Correctamente" );
				$( "#mensageDetalleActaAcuerdo" ).dialog( "close" );
				$( "#btnBuscarTMando" ).trigger( "click" );
			}
		}
	});
});
