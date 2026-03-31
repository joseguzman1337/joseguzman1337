/**
 * @author suarezcarlos
 */


var table = $("#registroGrado").dataTable({
	"bJQueryUI": true,
      "sPaginationType": "full_numbers",
      "responsive" : true,
      "order": [[1, "asc"]],
      "oLanguage": {
      	  "sLoadingRecords": "Espere un momento, cargando...",
	      "sSearch": "Buscar:",
	      "sZeroRecords": "No hay datos con esa busqueda",
      	  "oPaginate": {
          "sFirst": "Primero",
	      "sLast": "Ultimo",
	      "sNext": "Siguiente",
	      "sPrevious": "Anterior",
      		}
    	},
    "bDestroy": true
});

$( "#btnImprimirDocumentos" ).button( );

/*$( "#btnImprimirDocumentos" ).button( ).click(function( ){
	var ckImprimirDocumentos = $("#ckImprimirDocumentos[]").val( );
	alert( ckImprimirDocumentos );
	$(this).submit( function( ){
		
	});
	//return false;
});*/

/*$( "#btnImprimirDocumentos" ).button( function( ){
	
	var txtCodigoEstudiantes = $("#txtCodigoEstudiante", table.fnGetNodes( )).serialize( );
	alert( txtCodigoEstudiantes );
	var txtCodigoImprimir = $( "#ckImprimirDocumentos:checked").serialize( );
	alert( txtCodigoEstudiantes );
	$.ajax({
  		url: "../servicio/imprimir.php",
  		type: "POST",
  		data: { txtCodigoImprimir : txtCodigoImprimir, txtCodigoEstudiantes : txtCodigoEstudiantes },
		success: function( data ){
			alert( data );
		}
	});
	
	
});*/