/**
 * @author suarezcarlos
 */

$( "#cmbFacultadDuplicar" ).change( function( ) {
	var tipoOperacion = 'listaCarreras';
	var cmbFacultad = $( "#cmbFacultadDuplicar" ).val( );
	$.ajax({
  		url: "../servicio/carrera.php",
  		type: "POST",
  		data: { tipoOperacion : tipoOperacion , cmbFacultad : cmbFacultad },
		success: function( data ){
			//alert(data);
			$( "#cmbCarreraDuplicar").html( data );
		}
	});
});

$( ".txtNumeroDocumento" ).focusout( function(){
	var tipoOperacion = "buscar";
	var txtNumeroDocumento = $( this ).val( );
	var txtCodigoCarrera = $("#cmbCarreraDuplicar").val( );
	$.ajax({
	  		url: "../servicio/contacto.php",
	  		type: "POST",
	  		data: { tipoOperacion: tipoOperacion ,txtNumeroDocumento: txtNumeroDocumento, txtCodigoCarrera : txtCodigoCarrera },
			success: function( data ){
				//alert( data );
				//$("#log").html( data );
				if( data.length > 0 ){
					llenarFormulario( data );
				}else{
					alert("No existe Registro de Grado del Estudiante");
				}
				
			}
	});
});


/*$( "#btnDuplicar" ).button( ).click(function() {
	
	var ckDuplicado =  $("#ckDuplicado:checked").serialize( );
	var txtCodigoEstudiante = $("#txtIdEstudiante").val( );
	var txtCodigoCarrera = $("#cmbCarreraDuplicar").val( );
	var urlDiploma = "../../consulta/facultades/graduar_estudiantes/impresion_diploma/folios.php?tipogeneracion=generacionmasiva"; 
	$.ajax({
	  		url: "../servicio/duplicar.php",
	  		type: "POST",
	  		data: { ckDuplicado : ckDuplicado, txtCodigoEstudiante : txtCodigoEstudiante, txtCodigoCarrera : txtCodigoCarrera },//$( "#formDuplicar" ).serialize( ),
			success: function( data ){
				alert( data );
				if( data == 1 ){
					location.href = urlDiploma;
				}
			}
	});
});*/

$("#trNumeroDuplicadoDiploma").css( "display", "none" );

$(".ckDuplicado").change( function( ){
	if(this.checked) {
		if( $(this).val( ) == 5 ){
			$("#trNumeroDuplicadoDiploma").css( "display", "block" );
		}else{
			$("#trNumeroDuplicadoDiploma").css( "display", "none" );
		}
	}else{
		$("#trNumeroDuplicadoDiploma").css( "display", "none" );
	}
});


$( "#btnDuplicar" ).button( );

$( "#btnRestaurarDuplicar" ).button( );


$("#txtDirectivo").keyup(function(){
	//source: function( ) {
		var tipoOperacion = "listaUsuarios";
		var txtNombres = $("#txtDirectivo").val( );
		$.ajax({
	  		url: "../servicio/contacto.php",
	  		type: "POST",
	  		data: { tipoOperacion : tipoOperacion, txtNombres : txtNombres },
	  		beforeSend: function(){
				$("#txtDirectivo").css('background','#FFF url("../css/images/LoaderIcon.gif") no-repeat 100px');
			},
			success: function( data ){
				$("#suggesstion-box").show();
				$("#suggesstion-box").html(data);
				$("#txtDirectivo").css("background","#FFF");
				//$("#txtDirectivo").append( data );
			}
		});
	//}
});



function selectUser(val) {
	$("#txtDirectivo").val(val);
	$("#suggesstion-box").hide();
	
}

function selectId( txtIdDirectivo ){
	$("#idDirectivo").val(txtIdDirectivo);
}
