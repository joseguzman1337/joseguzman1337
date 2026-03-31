/**
 * @author suarezcarlos
 */


$( "#mensageAcuerdo" ).dialog({
	autoOpen: false,
	show: "blind",
	modal: true,
	resizable: false,
	title: "Guardar Acta",
	width: 250,
	height: 200,
	hide: "explode"
});



var dates = $( "#fechaAcuerdo" ).datepicker({
	defaultDate: "0w",
	changeMonth: true,
	numberOfMonths: 2,
	changeYear: true,
	dateFormat : 'yy-mm-dd',
	onSelect: function( selectedDate ) {
		var option = this.id == "fechaAcuerdo" ? "minDate" : "maxDate",
			instance = $( this ).data( "datepicker" ),
			date = $.datepicker.parseDate(
				instance.settings.dateFormat ||
				$.datepicker._defaults.dateFormat,
				selectedDate, instance.settings );
		dates.not( this ).datepicker( "option", option, date );
	}
},$.datepicker.regional["es"]);

var table = $("#registroAcuerdo").dataTable({
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


$( "#btnRegistrarAcuerdo" ).button( ).click(function( ){
	var tipoOperacion = "crearAcuerdo";
	var txtIdActas = $("#ckSeleccionarAcuerdo", table.fnGetNodes()).serialize( );
	var txtNumeroAcuerdo = $("#txtNumeroAcuerdo").val( );
	var txtFechaAcuerdo = $("#fechaAcuerdo").val( );
	var txtFechaGrado = $("#txtCodigoFechaGrado").val( );
	var txtCodigoCarrera = $("#txtCodigoCarrera").val( );
	var txtNumeroActaAcuerdo = $("#txtNumeroActaAcuerdo").val( );
	var datos = "txtNumeroAcuerdo="+txtNumeroAcuerdo+"&txtFechaAcuerdo="+txtFechaAcuerdo;
	var camposVacios = validarFormulario( datos );
	if( camposVacios == "" ){
	$( "#btnRegistrarAcuerdo" ).button({ label: "Registrando <img width='16' height='16' src='../css/images/cargando.gif' />" });
	$( "#btnRegistrarAcuerdo" ).button( "option" , "disabled" , true );
	$( "#mensageAcuerdo" ).dialog( "option", "buttons", {
	"Sí": function() {
		$.ajax({
		  		url: "../servicio/actaAcuerdo.php",
		  		type: "POST",
		  		data: { tipoOperacion : tipoOperacion, txtNumeroAcuerdo : txtNumeroAcuerdo, txtFechaAcuerdo : txtFechaAcuerdo, txtNumeroActaAcuerdo : txtNumeroActaAcuerdo, txtIdActas : txtIdActas, txtFechaGrado : txtFechaGrado, txtCodigoCarrera : txtCodigoCarrera },
				success: function( data ){
					//alert(data);
					if( data.length > 0 ){
							alert("Ocurrió un error");
							$( "#mensageAcuerdo" ).dialog( "close" );
							$( "#btnRegistrarAcuerdo" ).button({ label: "Registrar" });
							$( "#btnRegistrarAcuerdo" ).button( "option", "disabled", false );
							$("#txtNumeroActa").val("");
							$("#fechaActa").val("");
					}else{
							alert("Registro Guardado Correctamente");
							$( "#mensageAcuerdo" ).dialog( "close" );
							$( "#btnRegistrarAcuerdo" ).button({ label: "Registrar" });
							$( "#btnRegistrarAcuerdo" ).button( "option", "disabled", false );
							$( "#mensageRAcuerdo" ).dialog( "close" );
							$( "#btnBuscarTMando" ).trigger( "click" );
					}	
				}
			});
		},
		"No":function(){
			$( "#mensageAcuerdo" ).dialog( "close" );
			$( "#btnRegistrarAcuerdo" ).button({ label: "Registrar" });
			$( "#btnRegistrarAcuerdo" ).button( "option", "disabled", false );
		}
	});
		$( "#mensageAcuerdo" ).dialog( "open" );
	}else{
		crearMensaje( camposVacios );
	}
	
	/*$("#ckSeleccionar:checked", table.fnGetNodes()).each(function(){
    	txtCodigoEstudiante += new Array($( this ).val( ));
	});
	alert(txtCodigoEstudiante);*/
});


/*$("#selectAll").change(function(){
 	("#ckSeleccionar", table.fnGetNodes( )).attr('checked',this.checked);
});*/

if($('#selectAllAcu').is(':checked')){
	$("#ckSeleccionarAcuerdo", table.fnGetNodes()).each(function(){ //loop through each checkbox
	        this.checked = true;
	          //select all checkboxes with class "checkbox1"               
    });
    /*$("#ckSeleccionarEstudiante", table.fnGetNodes()).each(function(){ //loop through each checkbox
	        this.checked = true;  //select all checkboxes with class "checkbox1"               
    });*/
}


$('#selectAllAcu').change(function(event) {  //on click 
	if(this.checked) {
		 // check select status
	    $("#ckSeleccionarAcuerdo", table.fnGetNodes()).each(function(){ //loop through each checkbox
	        this.checked = true;
	         //select all checkboxes with class "checkbox1"               
	    });
	    
	    /*$("#ckSeleccionarEstudiante", table.fnGetNodes()).each(function(){ //loop through each checkbox
	        this.checked = true;  //select all checkboxes with class "checkbox1"               
    	});*/
	    
	}else{
	    	$("#ckSeleccionarAcuerdo", table.fnGetNodes()).each(function(){ //loop through each checkbox
	        	this.checked = false; //deselect all checkboxes with class "checkbox1"                       
	        }); 
	        
	        /*$("#ckSeleccionarEstudiante", table.fnGetNodes()).each(function(){ //loop through each checkbox
	        	this.checked = false;  //select all checkboxes with class "checkbox1"               
    		});*/        
	    }
});
