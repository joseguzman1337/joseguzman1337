/**
 * @author suarezcarlos
 */

$( "#cmbFacultad" ).change( function( ) {
			var tipoOperacion = 'listaCarreras';
			var cmbFacultad = $( "#cmbFacultad" ).val( );
			$.ajax({
		  		url: "../servicio/carrera.php",
		  		type: "POST",
		  		data: { tipoOperacion : tipoOperacion , cmbFacultad : cmbFacultad },
				success: function( data ){
					$( "#cmbCarrera").html( data );
				}
			});
	});


var txtIdRol = $("#txtIdRol").val( );
var txtCuentaFacultad = $("#txtCuentaFacultadE").val( );

if( txtIdRol == "3" || txtIdRol == "93"){
	if( txtCuentaFacultad == "1" ){
		$( "#cmbFacultad option[value!='-1']" ).attr("selected", "selected").change( );
		$("#tdFacultad").hide( );
		$("#tdCmbFacultad").hide( );
	}
}


$( "#cmbFacultadDistancia" ).change( function( ) {
			var tipoOperacion = 'listaCarreras';
			var cmbFacultad = $( "#cmbFacultadDistancia" ).val( );
			$.ajax({
		  		url: "../servicio/carrera.php",
		  		type: "POST",
		  		data: { tipoOperacion : tipoOperacion , cmbFacultad : cmbFacultad },
				success: function( data ){
					$( "#cmbCarreraDistancia").html( data );
				}
			});
	});



