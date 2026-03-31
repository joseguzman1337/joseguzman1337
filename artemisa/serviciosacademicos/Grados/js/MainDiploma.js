/**
 * @author suarezcarlos
 */

$("#btnGuardarDiploma").button( ).click(function( ){
	var tipoOperacion = "actualizarDiploma";
	$( "#mensageActualizarDiploma" ).dialog( "option", "buttons", {
		"Aceptar": function() {
				$.ajax({
			  		url: "../servicio/registrarGrado.php",
			  		type: "POST",
			  		data: $( "#formNumeroDiploma" ).serialize( ) + "&tipoOperacion="+tipoOperacion,
					success: function( data ){
						/*alert(data);
						$( "#log").html( data );*/
						if( data.length > 0 ){
							alert("Ha ocurrido un problema");
							$( "#mensageActualizarDiploma" ).dialog( "close" );
						}else{
							alert("Se ha actualizado el número del diploma");
							$( "#mensageActualizarDiploma" ).dialog( "close" );
							$( "#actualizaDiploma" ).dialog( "close" );
							$( "#btnBuscarTMando" ).trigger( "click" );
						}
						
					}
				});
		},
		"Cancelar":function(){
			$( "#mensageActualizarDiploma" ).dialog( "close" );
		}
	});
	$( "#mensageActualizarDiploma" ).dialog( "open" );
});
