/**
 * @author suarezcarlos
 */

$( "#mensageAnularActa" ).dialog({
	autoOpen: false,
	show: "blind",
	modal: true,
	resizable: false,
	title: "Anular Acta",
	width: 250,
	height: 200,
	hide: "explode"
});


var table = $("#TablaAnularActa").dataTable({
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


if($('#selectAllActa').is(':checked')){
	$("#ckAnularActa", table.fnGetNodes()).each(function(){ //loop through each checkbox
	        this.checked = true;  //select all checkboxes with class "checkbox1"               
    });
}


$('#selectAllActa').change(function(event) {  //on click 
	if(this.checked) {
		 // check select status
	    $("#ckAnularActa", table.fnGetNodes()).each(function(){ //loop through each checkbox
	        this.checked = true;  //select all checkboxes with class "checkbox1"               
	    });
	}else{
	    $("#ckAnularActa", table.fnGetNodes()).each(function(){ //loop through each checkbox
	        this.checked = false; //deselect all checkboxes with class "checkbox1"                       
	        });         
	    }
});


$( "#btnEstudianteAnularActa" ).button( ).click(function( ){
	var tipoOperacion = "anularActaEstudiante";
	var txtIdDetalleActas = $("#ckAnularActa", table.fnGetNodes()).serialize( );
	//var txtCodigoEstudiantes = $(".txtCodigoEstudiante").serialize( );
	var txtCodigoCarrera = $("#txtCodigoCarrera").val( );
	$( "#mensageAnularActa" ).dialog( "option", "buttons", {
		"Sí": function() {
				$.ajax({
		  		url: "../servicio/actaAcuerdo.php",
		  		type: "POST",
		  		data: { tipoOperacion: tipoOperacion, txtIdDetalleActas: txtIdDetalleActas, txtCodigoCarrera : txtCodigoCarrera },
				success: function( data ){
					//alert( data );
						if( data.length > 0 ){
							alert( "Ha ocurrido un problema" );
						}else{
							alert("Registro Actualizado");
							$( "#mensageAnularActa" ).dialog( "close" );
							$( "#mensageAnularActaAcuerdo" ).dialog( "close" );
							$( "#btnBuscarTMando" ).trigger( "click" );
						}
					}
				});
			},
			"No":function(){
				$( "#mensageAnularActa" ).dialog( "close" );
			}
	});
	$( "#mensageAnularActa" ).dialog( "open" );
	
});




