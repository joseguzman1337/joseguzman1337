/**
 * @author suarezcarlos
 */


$( "#mensageAnularAcuerdo" ).dialog({
	autoOpen: false,
	show: "blind",
	modal: true,
	resizable: false,
	title: "Anular Acuerdo",
	width: 250,
	height: 200,
	hide: "explode"
});



var tableAcuerdo = $("#TablaAnularAcuerdo").dataTable({
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


if($('#selectAllAcuerdo').is(':checked')){
	$("#ckAnularAcuerdo", tableAcuerdo.fnGetNodes()).each(function(){ //loop through each checkbox
	        this.checked = true;  //select all checkboxes with class "checkbox1"               
    });
}


$('#selectAllAcuerdo').change(function(event) {  //on click 
	if(this.checked) {
		 // check select status
	    $("#ckAnularAcuerdo", tableAcuerdo.fnGetNodes()).each(function(){ //loop through each checkbox
	        this.checked = true;  //select all checkboxes with class "checkbox1"               
	    });
	}else{
	    $("#ckAnularAcuerdo", tableAcuerdo.fnGetNodes()).each(function(){ //loop through each checkbox
	        this.checked = false; //deselect all checkboxes with class "checkbox1"                       
	        });         
	    }
});




$( "#btnEstudianteAnularAcuerdo" ).button( ).click(function( ){
	var tipoOperacion = "anularAcuerdoEstudiante";
	var txtIdDetalleActas = $("#ckAnularAcuerdo", tableAcuerdo.fnGetNodes()).serialize( );
	//alert( txtIdDetalleActas );
	//var txtCodigoEstudiantes = $(".txtCodigoEstudiante").serialize( );
	var txtCodigoCarrera = $("#txtCodigoCarreraAcuerdo").val( );
	$( "#mensageAnularAcuerdo" ).dialog( "option", "buttons", {
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
							$( "#mensageAnularAcuerdo" ).dialog( "close" );
							$( "#mensageAnularActaAcuerdo" ).dialog( "close" );
							$( "#btnBuscarTMando" ).trigger( "click" );
						}
					}
				});
			},
			"No":function(){
				$( "#mensageAnularAcuerdo" ).dialog( "close" );
			}
	});
	$( "#mensageAnularAcuerdo" ).dialog( "open" );
	
});