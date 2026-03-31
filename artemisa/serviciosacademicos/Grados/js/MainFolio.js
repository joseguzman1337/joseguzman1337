/**
 * @author suarezcarlos
 */

$("#btnFolio").button( ).click(function( ){
	var txtFechaGrado = $("#txtFechaGrado").val( );
	var txtCodigoCarrera = $("#txtCodigoCarrera").val( );
	$.ajax({
  		url: "../interfaz/folio.php",
  		type: "POST",
  		data: { txtFechaGrado : txtFechaGrado, txtCodigoCarrera : txtCodigoCarrera },
  		cache: false,
		success: function( data ){
			$("#dvFolio").html( data );
		}
	});
	$("#dvFolio").dialog("open");
});


/*$("#btnOpcionFolio").button( ).click(function( ){
	var cmbOpcionFolio = $("#cmbOpcionFolio").val( );
	alert( cmbOpcionFolio );
});*/

$("#cmbOpcionFolio").change(function( ){
	
	var cmbOpcionFolio = $( this ).val( );
	if( cmbOpcionFolio != 0 ){
		if( cmbOpcionFolio == 1 ){
			$("#dvGenerarFolio").css("display", "block");
			$("#dvReImprimirFolio").css("display", "none");
		}else{ 
			$("#dvGenerarFolio").css("display", "none");
			$("#dvReImprimirFolio").css("display", "block");
		}
	}
});

$("#btnEnviarGenerarFolio").button( ).click(function( ){
	var rdPrevisualizar = $("#rdPrevisualizar:checked").val( );
	var rdGenerar = $("#rdGenerar:checked").val( );
	var tipoOperacion = "";
	/*var txtFechaGrado = $("#txtFechaGrado").val( );
	var txtCodigoCarrera = $("#txtCodigoCarrera").val( );*/
	if( rdPrevisualizar == "on"){
		tipoOperacion = "previsualizar";
	}	
	if( rdGenerar == "on"){
		tipoOperacion = "generar";
	}
	$("#formMenuFolio").append('<input type="hidden" id="tipoOperacion" name="tipoOperacion" value="'+
                         tipoOperacion+'" />');
	 $( "#formMenuFolio" ).submit( );
	/*$.ajax({
  		url: "../servicio/folio.php",
  		type: "POST",
  		data: { tipoOperacion : tipoOperacion , txtFechaGrado : txtFechaGrado , txtCodigoCarrera : txtCodigoCarrera },
  		cache: false,
		success: function( data ){
			$("#log").html( data );
		}
	});*/
	/*alert( rdGenerar );
	alert( rdPrevisualizar );*/
	
	
	
});

$("#btnEnviarReImpresion").button( ).click(function( ){
	
});

/*$("#btnRegresarReImpresion").button( ).click(function( ){
	
});*/
