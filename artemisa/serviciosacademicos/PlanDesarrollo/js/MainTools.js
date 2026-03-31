/**
 * @author Carlos
 */

function seleccionarPersona( documentoPersona , tipoDocumentoPersona , idPersona ){
	$( ".txtDocumentoRadicacion" ).val( documentoPersona );
	$( ".cmbTipoDocumentoRadicacion" ).val( tipoDocumentoPersona );
	$( ".txtIdPersonaRadicacion" ).val( idPersona );
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

function verPlan( txtIdMetaSecundaria, tipoOperacion ){
	$.ajax({
		type: "POST",
	    url: "../interfaz/detallePlan.php",
		data: { txtIdMetaSecundaria : txtIdMetaSecundaria , tipoOperacion : tipoOperacion },
		success: function( data ){
		  	$( "#detallePlan" ).html( data );
		  	$( "#detallePlan" ).dialog( "open" );
	    }
	});
}


function registrarEvidenciaPlan( txtProyectoPlanDesarrolloId ,txtIndicadorPlanDesarrolloId , tipoOperacion , numerador , tipoIndicadores , numeradorMeta ,alcance ){

	$.ajax({
		type: "POST",
	    url: "../interfaz/detallePlan.php",
		data: { txtProyectoPlanDesarrolloId : txtProyectoPlanDesarrolloId , txtIndicadorPlanDesarrolloId : txtIndicadorPlanDesarrolloId , tipoOperacion : tipoOperacion, numerador : numerador , tipoIndicadores : tipoIndicadores , numeradorMeta : numeradorMeta , alcance : alcance},
		success: function( data ){
		  	$( "#detallePlan" ).html( data );
		  	$( "#detallePlan" ).dialog( "open" );
	    }
	});
	
	
}
/*Modified DIego Rivera <riveradiego@unbosque.edu.co>
 * Se añade parametro a funcion verEvidenciaPlan 
 * Since March 28,2017
 */
/*Modified Diego Rivera<riveradiego@unbosque.edu.co>
 *Se añade parametro facultadplan para identificar plan institucional
 *Since May 25,2018
 */
function verEvidenciaPlan( txtProyectoPlanDesarrolloId ,txtIndicadorPlanDesarrolloId , tipoOperacion , idMetaPrincipal , facultadPlan ){
  
        $.ajax({
        type: "POST",
        url: "../interfaz/detallePlan.php",
        dataType: "html",
        data: { txtProyectoPlanDesarrolloId : txtProyectoPlanDesarrolloId , txtIndicadorPlanDesarrolloId : txtIndicadorPlanDesarrolloId , tipoOperacion : tipoOperacion , idMetaPrincipal : idMetaPrincipal , facultadPlan : facultadPlan },
        success: function( data ){
            ///console.log(data);
            //alert(idMetaPrincipal);
            $( "#verAvance" ).html(" ");
            $( "#verAvance" ).html( data );
            $( "#verAvance" ).dialog( "open" );
           // alert(data);
           
            delete data;
        }
    }); 
   
}

//fin modificacion 


/*Modified Diego Rivera<riveradiego@unbosque.edu.co
	 *se cambia variable idAvanceIndicador  por  $idMetaSecundaria 
	 * SInce April 10 , 2017
	 * */

function actualizarObservacion( tipoOperacion , idMetaSecundaria , aprobacion , contador ){
	
	$.ajax({
		type: "POST",
		url: "../interfaz/detallePlan.php",
		data:{ tipoOperacion : tipoOperacion , idMetaSecundaria : idMetaSecundaria , aprobacion : aprobacion ,contador : contador },
		success : function( data ){
			$( "#actualizarObservacion" ).html( data );
		   	$( "#actualizarObservacion" ).dialog( "open" );
		}
	});
}

//fin modificacion

function actualizarEvidencia( tipoOperacion , idAvanceIndicador , contador){
	$.ajax({
		type: "POST",
		url: "../interfaz/detallePlan.php",
		data:{ tipoOperacion : tipoOperacion , idAvanceIndicador : idAvanceIndicador , contador : contador },
		success : function( data ){
			$( "#actualizarEvidencia" ).html( data );
		   	$( "#actualizarEvidencia" ).dialog( "open" );
		}
	});
}


function actualizarPlan( txtIdMetaPrincipal ){
	$.ajax({
		type: "POST",
	    url: "../interfaz/actualizarPlan.php",
		data: { txtIdMetaPrincipal : txtIdMetaPrincipal },
		success: function( data ){
		  	$( "#actualizaPlan" ).html( data );
		  	$( "#actualizaPlan" ).dialog( "open" );
	    }
	});
}


function eliminarMetaPrincipal ( txtIdMeta , txtIndicador ){
	var tipoOperacion = "eliminarMetaPrincipal";
	
	$( "#eliminarMeta" ).dialog( 
	    "option", "buttons", {
		"Aceptar": function() {
			$.ajax({
				url: "../servicio/meta.php",
		  		type: "POST",
		  		data: { tipoOperacion : tipoOperacion, txtIdMeta : txtIdMeta , txtIndicador : txtIndicador },
				success: function( data ){
						if ( data.length > 0 ) {
							alert( "Ha ocurrido un problema" );
							$( "#eliminarMeta" ).dialog( "close" );
						} else{
							alert("Se han guardado los cambios");
							$( "#eliminarMeta" ).dialog( "close" );
							$( "#dvTablaConsultarPlan" ).css( "display", "none" );
						 	$( "#cmbMetaConsultar option:selected").remove();
				
						}
				}
			});
		},
		"Cancelar":function(){
			$( "#eliminarMeta" ).dialog( "close" );
		}
	});
	
	$( "#eliminarMeta" ).dialog( "open" );
}


function eliminarMetaSecundaria( txtIdMetaSecundaria ){
	var tipoOperacion = "eliminarMetaSecundaria";
	$( "#eliminarMetaSecundaria" ).dialog( 
	    "option", "buttons", {
		"Aceptar": function() {
			$.ajax({
				url: "../servicio/meta.php",
		  		type: "POST",
		  		data: { tipoOperacion : tipoOperacion, txtIdMetaSecundaria : txtIdMetaSecundaria },
				success: function( data ){
						if( data.length > 0 ){
							alert( "Ha ocurrido un problema" );
							$( "#eliminarMetaSecundaria" ).dialog( "close" );
						}else{
							alert("Se han guardado los cambios");
							$( "#eliminarMetaSecundaria" ).dialog( "close" );
							$( "#btnConsultar" ).trigger( "click" );
						}
				}
			});
		},
		"Cancelar":function(){
			$( "#eliminarMetaSecundaria" ).dialog( "close" );
		}
	});
	$( "#eliminarMetaSecundaria" ).dialog( "open" );
}

function actualizarMetaSecundaria( txtIdMetaPrincipal,txtIdMetaSecundaria ){
	$.ajax({
		type: "POST",
	    url: "../interfaz/seguimientoPlanDesarrollo.php",
		data: { 
				txtIdMetaPrincipal : txtIdMetaPrincipal,
				txtIdMetaSecundaria : txtIdMetaSecundaria,
				option : 'actualizarMetaSecundaria'
			},
		success: function( data ){
		  	$( "#actualizaPlan" ).html( data );
		  	$( "#actualizaPlan" ).dialog( "open" );
	    }
	});
	
	
}


function volver( ){
	var url = "../interfaz/index.php";
	location.href = url;
}

function rotar( principal, secundario ){
	var display = $( "#"+secundario ).css( "display" );
	if( display == "block" ){
		$( "#"+principal ).addClass( "rot90");
	}else{
		$( "#"+principal ).removeClass( "rot90" );
	}
}

function verPDF( txtIdMetaPrincipal, txtIdMetaSecundaria ) {
	var txtCarpeta = "evidencia";
	$.ajax({//Ajax
	      type: "POST",
	      url: "../interfaz/verArchivos.php",
		  data: { txtCarpeta : txtCarpeta , txtIdMetaPrincipal : txtIdMetaPrincipal, txtIdMetaSecundaria : txtIdMetaSecundaria },
		  success: function( data ){
		  	$( "#verArchivos" ).html( data );
			$( "#verArchivos" ).dialog( "open" );
	      }
	   });
}
/*Modified Diego Rivera<riveradiego@unbosque.edu.co>
 *Se añade parametro facultadPlan captura el codigo de facultad referente al plan de desarrollo seleccionado
 *Since May 25 ,2018
 */
function verEvidencias( idMetaSecundaria , tipoOperacion , fecha , actividad , avance , aprabado , facultadPlan) {
				
		$.ajax({
	      type: "POST",
	      url: "../interfaz/verEvidencias.php",
		  data: { idMetaSecundaria : idMetaSecundaria , tipoOperacion : tipoOperacion ,fecha : fecha , actividad :actividad  , avance : avance , aprabado : aprabado ,facultadPlan : facultadPlan  },
		  success: function( data ){
		  	$( "#verEvidencias" ).html( data );
			$( "#verEvidencias" ).dialog( "open" );
		  }
	   });
}



function eliminarEvidencia( idAvance , tipoOperacion , archivo  ){
	
	$.ajax({
	      type: "POST",
	      url: "../interfaz/verEvidencias.php",
		  data: { idAvance : idAvance, tipoOperacion : tipoOperacion , archivo : archivo },
		  success: function( data ){
		  $( "#verEvidencias" ).dialog( "close" );
		  }
	   });
}





