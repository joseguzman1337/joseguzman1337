/**
 * @author suarezcarlos
 */


$("#btnFirma").button( ).click(function( ){
	var txtFechaGrado = $("#txtFechaGrado").val( );
	var txtCodigoCarrera = $("#txtCodigoCarrera").val( );
	
	$.ajax({
  		url: "../interfaz/firma.php",
  		type: "POST",
  		data: { txtFechaGrado : txtFechaGrado, txtCodigoCarrera : txtCodigoCarrera },
  		cache: false,
		success: function( data ){
			$("#dvFirma").html( data );
		}
	});
	$("#dvFirma").dialog("open");
    $("#btnFirma").off('click');		
});

$( "#btnGuardarFirma" ).button( ).click(function() {
	var ckFirmas = $( "#ckFirma:checked" ).serialize( );
	var txtFechaGrado = $("#txtFechaGrado").val( );
	var txtCodigoCarrera = $("#txtCodigoCarrera").val( );
	var cmbTipoDocumentoGrado = $("#cmbTipoDocumentoGrado").val( );
	$.ajax({
  		url: "../servicio/firma.php",
  		type: "POST",
  		data: { ckFirmas : ckFirmas, txtFechaGrado : txtFechaGrado, txtCodigoCarrera : txtCodigoCarrera, cmbTipoDocumentoGrado : cmbTipoDocumentoGrado },
  		cache: false,
		success: function( data ){
			if( data.length > 0 ){
				alert( "Ha Ocurrido un Problema" );
			}else{
				alert( "Datos Guardados Correctamente" );
			}
			
		}
	});
});
