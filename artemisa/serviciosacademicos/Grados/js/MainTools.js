/**
 * @author Carlos
 */

function seleccionarPersona( documentoPersona , tipoDocumentoPersona , idPersona ){
	$( ".txtDocumentoRadicacion" ).val( documentoPersona );
	$( ".cmbTipoDocumentoRadicacion" ).val( tipoDocumentoPersona );
	$( ".txtIdPersonaRadicacion" ).val( idPersona );
}


function verPDF( txtCodigoEstudiante, txtFechaGrado ) {
	var txtCarpeta = "digital";
	$.ajax({//Ajax
          type: "POST",
          url: "../interfaz/verArchivos.php",
		  data: { txtCarpeta : txtCarpeta, txtCodigoEstudiante : txtCodigoEstudiante, txtFechaGrado : txtFechaGrado },
		  success: function( data ){
		  	$( "#verArchivos" ).html( data );
			$( "#verArchivos" ).dialog( "open" );
          }
       });
	/*var target = "_blank";
	var ancho = 900; 
	var alto = screen.height - 100; 
	var posicion_x = (screen.width/2)-(ancho/2);
	var posicion_y = 0;  
	window.open( url , target, "width="+ancho+",height="+alto+",left="+posicion_x+",top="+posicion_y+"");
	return false;*/
}

function verCertificado( ) {
	var target = "_blank";
	var ancho = 900; 
	var alto = screen.height - 100; 
	var posicion_x = (screen.width/2)-(ancho/2);
	var posicion_y = 0;  
	window.open( url , target, "width="+ancho+",height="+alto+",left="+posicion_x+",top="+posicion_y+"");
	return false;
}

function verRECIBO( url ) {
	var target = "_blank";
	var ancho = 900; 
	var alto = screen.height - 100; 
	var posicion_x = (screen.width/2)-(ancho/2);
	var posicion_y = 0;  
	window.open( url , target, "width="+ancho+",height="+alto+",left="+posicion_x+",top="+posicion_y+"");
	return false;
}



function verDocumentosPendientes( txtCodigoCarrera, txtCodigoEstudiante ) {
	$.ajax({
  		url: "../interfaz/documentosPendiente.php",
  		type: "POST",
  		data: { txtCodigoCarrera : txtCodigoCarrera, txtCodigoEstudiante : txtCodigoEstudiante },
		success: function( data ){
			//$( "#log").html( data );
			//alert(data);
			$( "#mensageDocumentos" ).html( data );
			$( "#mensageDocumentos" ).dialog( "open" );
		}
	});
}

function verActualizarEstudiante( txtCodigoEstudiante , txtActualizaDatos) {
	$.ajax({
  		url: "../interfaz/actualizarEstudiante.php",
  		type: "POST",
  		data: { txtCodigoEstudiante : txtCodigoEstudiante , txtActualizaDatos : txtActualizaDatos },
		success: function( data ){
			//$( "#log").html( data );
			//alert(data);
			$( "#mensageActualizarEstudiante" ).html( data );
			$( "#mensageActualizarEstudiante" ).dialog( "open" );
		}
	});
}

/*function verActualizarEstudiante( txtCodigoCarrera, txtCodigoEstudiante, txtActualizaDatos ) {
	var usuarioeditar = "facultad";
	var identificadorGrado = "grado";
	$.ajax({
  		url: "../../consulta/facultades/creacionestudiante/editarestudiante.php",
  		type: "GET",
  		data: { usuarioeditar : usuarioeditar , facultad : txtCodigoCarrera, codigocreado : txtCodigoEstudiante, txtActualizaDatos : txtActualizaDatos, identificadorGrado : identificadorGrado },
		success: function( data ){
			//$( "#log").html( data );
			//alert(data);
			$( "#mensageActualizarEstudiante" ).html( data );
			$( "#mensageActualizarEstudiante" ).dialog( "open" );
		}
	});
}*/



function verTrabajoGrado( txtCodigoEstudiante ) {
	$.ajax({
  		url: "../interfaz/detalleTrabajoGrado.php",
  		type: "POST",
  		data: { txtCodigoEstudiante : txtCodigoEstudiante },
		success: function( data ){
			//$( "#log").html( data );
			//alert(data);
			$( "#mensageTrabajoGrado" ).html( data );
			$( "#mensageTrabajoGrado" ).dialog( "open" );
		}
	});
}


function verDerechoGrado( txtCodigoEstudiante ) {
	$.ajax({
  		url: "../interfaz/detalleDerechoGrado.php",
  		type: "POST",
  		data: { txtCodigoEstudiante : txtCodigoEstudiante },
		success: function( data ){
			//$( "#log").html( data );
			//alert(data);
			$( "#mensageDerechoGrado" ).html( data );
			$( "#mensageDerechoGrado" ).dialog( "open" );
		}
	});
}

function verDocIngles( txtCodigoEstudiante, txtCodigoCarrera ) {
	$.ajax({
  		url: "../interfaz/detalleIngles.php",
  		type: "POST",
  		data: { txtCodigoEstudiante : txtCodigoEstudiante, txtCodigoCarrera : txtCodigoCarrera },
		success: function( data ){
			//$( "#log").html( data );
			//alert(data);
			$( "#mensageDocIngles" ).html( data );
			$( "#mensageDocIngles" ).dialog( "open" );
		}
	});
}

function verOtros( txtCodigoEstudiante, txtCodigoPeriodo ) {
	$.ajax({
  		url: "../interfaz/detalleOtros.php",
  		type: "POST",
  		data: { txtCodigoEstudiante : txtCodigoEstudiante, txtCodigoPeriodo : txtCodigoPeriodo },
		success: function( data ){
			//$( "#log").html( data );
			//alert(data);
			$( "#mensageDeudaOtros" ).html( data );
			$( "#mensageDeudaOtros" ).dialog( "open" );
		}
	});
}

function verMaterias( txtCodigoEstudiante, validarMateria ) {
	$.ajax({
  		url: "../../consulta/facultades/planestudioestudiante/planestudioestudianteGrado.php",
  		type: "POST",
  		data: { codigoestudiante : txtCodigoEstudiante, validarMateria : validarMateria },
		success: function( data ){
			//$( "#log").html( data );
			//alert(data);
			$( "#mensageMaterias" ).html( data );
			$( "#mensageMaterias" ).dialog( "open" );
		}
	});
}

function verDeuda( txtCodigoEstudiante, txtCodigoCarrera , txtFinanciera ) {
	$.ajax({
  		url: "../interfaz/detalleDeudaPeople.php",
  		type: "POST",
  		data: { txtCodigoEstudiante : txtCodigoEstudiante, txtCodigoCarrera : txtCodigoCarrera , txtFinanciera : txtFinanciera },
  		//data: { txtItems : txtItems },
		success: function( data ){
			//alert(data);
			//$( "#log").html( data );
			//alert(data);
			$( "#mensageDeudaPeople" ).html( data );
			$( "#mensageDeudaPeople" ).dialog( "open" );
		}
	});
}

function verActa( txtFechaGrado, txtIdActa, txtCodigoCarrera, txtCodigoEstudiante  ) {
	var tipoOperacion = "consultarActa";
	$.ajax({
  		url: "../interfaz/detalleActaAcuerdo.php",
  		type: "POST",
  		data: { tipoOperacion : tipoOperacion, txtFechaGrado : txtFechaGrado, txtIdActa : txtIdActa, txtCodigoCarrera : txtCodigoCarrera, txtCodigoEstudiante : txtCodigoEstudiante },
		success: function( data ){
			//alert(data);
			//$( "#log").html( data );
			//alert(data);
			$( "#mensageDetalleActaAcuerdo" ).html( data );
			$( "#mensageDetalleActaAcuerdo" ).dialog( "open" );
		}
	});
}

function verAcuerdo( txtFechaGrado, txtIdActa, txtCodigoCarrera, txtCodigoEstudiante  ) {
	var tipoOperacion = "consultarAcuerdo";
	$.ajax({
  		url: "../interfaz/detalleActaAcuerdo.php",
  		type: "POST",
  		data: { tipoOperacion : tipoOperacion, txtFechaGrado : txtFechaGrado, txtIdActa : txtIdActa, txtCodigoCarrera : txtCodigoCarrera, txtCodigoEstudiante : txtCodigoEstudiante },
		success: function( data ){
			//alert(data);
			//$( "#log").html( data );
			//alert(data);
			$( "#mensageDetalleActaAcuerdo" ).html( data );
			$( "#mensageDetalleActaAcuerdo" ).dialog( "open" );
		}
	});
}

function eliminarRGrado( txtIdRegistroGrado, txtFechaGrado, txtIdActa, txtCodigoCarrera, txtCodigoEstudiante  ) {
	var tipoOperacion = "eliminarRGrado";
	$( "#mensageEliminarRegistroGrado" ).dialog( "option", "buttons", {
		"Aceptar": function() {
				$.ajax({
			  		url: "../servicio/registrarGrado.php",
			  		type: "POST",
			  		data: { tipoOperacion : tipoOperacion, txtIdRegistroGrado : txtIdRegistroGrado, txtFechaGrado : txtFechaGrado, txtIdActa : txtIdActa, txtCodigoCarrera : txtCodigoCarrera, txtCodigoEstudiante : txtCodigoEstudiante },
					success: function( data ){
						/*alert(data);
						$( "#log").html( data );*/
						if( data.length > 0 ){
							alert("Ha ocurrido un problema");
							$( "#mensageEliminarRegistroGrado" ).dialog( "close" );
						}else{
							alert("Se ha eliminado el registro de grado del estudiante");
							$( "#mensageEliminarRegistroGrado" ).dialog( "close" );
							$( "#btnBuscarTMando" ).trigger( "click" );
						}
						
					}
				});
		},
		"Cancelar":function(){
			$( "#mensageEliminarRegistroGrado" ).dialog( "close" );
		}
	});
	$( "#mensageEliminarRegistroGrado" ).dialog( "open" );
}


function actualizarDiploma( txtIdRegistroGrado, txtNumeroDiploma, txtCodigoEstudiante) {
	$.ajax({
  		url: "../interfaz/actualizarDiploma.php",
  		type: "POST",
  		data: { txtIdRegistroGrado : txtIdRegistroGrado , txtNumeroDiploma : txtNumeroDiploma , txtCodigoEstudiante : txtCodigoEstudiante },
		success: function( data ){
			$( "#actualizaDiploma" ).html( data );
		}
	});
	$( "#actualizaDiploma" ).dialog( "open" );
}



function eliminarRegistros( tabla ){
	var oSettings = $( tabla ).dataTable().fnSettings();
	var iTotalRecords = oSettings.fnRecordsTotal();
	for ( i=0; i <= iTotalRecords ; i++ ) {
		$( tabla ).dataTable().fnDeleteRow( 0 );
	}
	
}


jQuery.fn.reset = function () {
  $(this).each (function() { this.reset(); });
}

function abrirVentana(url) {
    window.open(url, "_blank");
}



function consultar( cantidadInicio , cantidadFinal ) {
	var cantidadInicio = cantidadInicio;
	var cantidadFinal = cantidadFinal;	
	$.ajax({
  		url: "../servicio/digitalizar.php",
  		type: "POST",
  		data: $("#formDigitalizar").serialize( ) + 
  				"&tipoOperacionDigitalizar=consultarDigitalizar"+
  				"&inicio=" + cantidadInicio+
  				"&limite=" + cantidadFinal ,
			success: function( data ){
			data = trim( data );
			$( "#TablaDigitalizar" ).html( data );
			$( "#mensageCargando" ).dialog( "close" );
		}
	});
}


function verNota( txtIdRegistroGrado ) {
	$.ajax({
  		url: "observacion.php",
  		type: "POST",
  		data: {txtIdRegistroGrado : txtIdRegistroGrado },
		success: function(data){
			$( "#dialogNota" ).html( data ) ;
		}
	});
	$( "#dialogNota" ).dialog( "option", "title", 'Observaciones ' + txtIdRegistroGrado );
	$( "#dialogNota" ).dialog( "open" );	
}


	






