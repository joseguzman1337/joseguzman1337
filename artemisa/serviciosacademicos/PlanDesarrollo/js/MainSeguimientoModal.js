
/*
* @author Ivan quintero 
 * Febrero 22, 2017
 */
$(document).ready(function(){ 
	$( "#myModal" ).modal({
			"show" : true,
		   	 
	});
	
	$("#btnGuardarActividad").button( ).click( function( ){
	$("#btnGuardarActividad").remove();
	var txtIdMetaPrincipal = $( "#txtIdMetaPrincipal" ).val( );
	var txtIdMetaSecundaria = $( "#txtIdMetaSecundaria" ).val( );
	var txtNombreActividad = $( "#txtNombreActividad" ).val( );
	var txtFechaActividad = $( "#txtFechaActividad" ).val( );
	var txtAvancePropuesto = $( "#txtAvancePropuesto" ).val( );
	var inputFile = document.getElementById("txtFileAvance");
    var file = inputFile.files;
    var data = new FormData();
    var cuenta = "";
	for(i=0; i<file.length; i++){
		cuenta = cuenta+data.append('fileToUpload'+i,file[i]); //Añadimos cada archivo a el arreglo con un indice direfente
	}
    data.append("cuenta", cuenta);
    data.append("txtIdMetaPrincipal",txtIdMetaPrincipal);
    data.append("txtIdMetaSecundaria",txtIdMetaSecundaria);
    data.append("txtNombreActividad",txtNombreActividad);
    data.append("txtFechaActividad",txtFechaActividad);
    data.append("txtAvancePropuesto",txtAvancePropuesto);
    data.append("tipoOperacion","submit");
    	$.ajax({//Ajax
                  type: "POST",
                  url: "../servicio/evidencia.php",
                  contentType:false,
				  data: data ,
				  processData:false,
				  cache:false,
				  success: function( data ){
				  	//$("#log").html( data );
				  	if( data == 1 ){
	                     alert( "Se han guardado los cambios" );
	                     $("#myModal").modal("hide");
	                     $("#detallePlan").modal("hide");
	                     $("#btnConsultar").trigger("click");
                    }else{
                    	if( data == 0 ){
                    		alert( "Por favor seleccione un archivo" );
                    	}
                    	if( data == -1 ){
                    		alert("Disculpa, el archivo ya existe");
                    	}
                    	if( data == -2 ){
                    		alert("Disculpa, el archivo es demasiado pesado");
                    	}
                    	if( data == -3 ){
                    		alert("Archivo Inválido");
                    	}
                    }
                  
               }
       });
});

$("#txtFileAvance").filestyle({
	 input: false, buttonName: "btn-warning", buttonText: "Examinar" 
	 });


$("#btnRestaurarActividad").click(function(){
	$("#btnRestaurarActividad").remove();
	$("#myModal").modal();
	$("#detallePlan").modal();
	$("#myModal").modal("hide");
	$("#detallePlan").modal("hide");

} );
	
});