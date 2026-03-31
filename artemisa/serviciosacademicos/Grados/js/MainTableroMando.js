/**
 * @author suarezcarlos
 */

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}


$(".nicefile").niceFileInput({
	  'width'         : '300', //width of button - minimum 150
	  'height'		  : '30',  //height of text
	  'btnText'       : 'Examinar', //text of the button     
	  'btnWidth'	  : '100' ,  // width of button
	  'margin'        : '14',	// gap between textbox and button - minimum 14 		  
});	

$( "#mensageActualizarEstudiante" ).dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		title: "Actualizar Datos de Estudiante",
		width: 'auto',
		height: 'auto',
		show: {
	        effect: "blind",
	        duration: 500
	      },
	    hide: {
	        effect: "explode",
	        duration: 500
	    },
		buttons: {
					"Cerrar": function( ) { 
						$(this).dialog("close"); 
					}
				}
});

$( "#mensageDocumentos" ).dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		title: "Detalle de Documentos Pendientes",
		width: 'auto',
		height: 'auto',
		show: {
	        effect: "blind",
	        duration: 500
	      },
	    hide: {
	        effect: "explode",
	        duration: 500
	    },
		buttons: {
					"Cerrar": function( ) { 
						$(this).dialog("close"); 
					}
				}
});

$( "#mensageTrabajoGrado" ).dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		title: "Detalle de Trabajo de Grado",
		width: 'auto',
		height: 'auto',
		show: {
	        effect: "blind",
	        duration: 500
	      },
	    hide: {
	        effect: "explode",
	        duration: 500
	    },
		buttons: {
					"Cerrar": function( ) { 
						$(this).dialog("close"); 
					}
				}
});


$( "#mensageDerechoGrado" ).dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		title: "Detalle de Derecho de Grado",
		width: 'auto',
		height: 'auto',
		show: {
	        effect: "blind",
	        duration: 500
	      },
	    hide: {
	        effect: "explode",
	        duration: 500
	    },
		buttons: {
					"Cerrar": function( ) { 
						$(this).dialog("close"); 
					}
				}
});

$( "#mensageDocIngles" ).dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		title: "Detalle de Inglés",
		width: 'auto',
		height: 'auto',
		show: {
	        effect: "blind",
	        duration: 500
	      },
	    hide: {
	        effect: "explode",
	        duration: 500
	    },
		buttons: {
					"Cerrar": function( ) { 
						$(this).dialog("close"); 
					}
				}
});

$( "#mensageDeudaOtros" ).dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		title: "Detalle Otros",
		width: 'auto',
		height: 'auto',
		show: {
	        effect: "blind",
	        duration: 500
	      },
	    hide: {
	        effect: "explode",
	        duration: 500
	    },
		buttons: {
					"Cerrar": function( ) { 
						$(this).dialog("close"); 
					}
				}
});

$( "#mensageMaterias" ).dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		title: "Detalle Plan Estudiantil",
		width: 'auto',
		height: 'auto',
		show: {
	        effect: "blind",
	        duration: 500
	      },
	    hide: {
	        effect: "explode",
	        duration: 500
	    },
		buttons: {
					"Cerrar": function( ) { 
						$(this).dialog("close"); 
					}
				}
});

$( "#mensageDeudaPeople" ).dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		title: "Detalle Deuda People",
		width: 'auto',
		height: 'auto',
		show: {
	        effect: "blind",
	        duration: 500
	      },
	    hide: {
	        effect: "explode",
	        duration: 500
	    },
		buttons: {
					"Cerrar": function( ) {
						var txtActualizaPeople = $("#txtActualizaDeuda").val( );
						if( txtActualizaPeople !== undefined ){
							$(this).dialog("close");
							$( "#btnBuscarTMando" ).trigger( "click" );
						}else{
							$(this).dialog("close");
						}
						
					}
				}
});

$( "#actaAcuerdo" ).dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		title: "Registrar Acta",
		width: 950,
		height: 'auto',
		show: {
	        effect: "blind",
	        duration: 500
	      },
	    hide: {
	        effect: "explode",
	        duration: 500
	    },
		buttons: {
					"Cerrar": function( ) { 
						$(this).dialog("close"); 
					}
				}
});



$( "#mensageDetalleActaAcuerdo" ).dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		title: "Detalle Acta",
		width: 'auto',
		height: 'auto',
		show: {
	        effect: "blind",
	        duration: 500
	      },
	    hide: {
	        effect: "explode",
	        duration: 500
	    },
		buttons: {
					"Cerrar": function( ) { 
						$(this).dialog("close"); 
					}
				}
});


$( "#mensageAnularActaAcuerdo" ).dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		title: "Anular Acta - Acuerdo",
		width: 700,
		height: 'auto',
		show: {
	        effect: "blind",
	        duration: 500
	      },
	    hide: {
	        effect: "explode",
	        duration: 500
	    },
		buttons: {
					"Cerrar": function( ) { 
						$(this).dialog("close"); 
					}
				}
});


$( "#mensageRAcuerdo" ).dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		title: "Registrar Acuerdo",
		width: 650,
		height: 'auto',
		show: {
	        effect: "blind",
	        duration: 500
	      },
	    hide: {
	        effect: "explode",
	        duration: 500
	    },
		buttons: {
					"Cerrar": function( ) { 
						$(this).dialog("close"); 
					}
				}
});


$( "#mensageImpresion" ).dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		title: "Imprimir Documentos de Grado",
		width: 'auto',
		height: 'auto',
		show: {
	        effect: "blind",
	        duration: 500
	      },
	    hide: {
	        effect: "explode",
	        duration: 500
	    },
		buttons: {
					"Cerrar": function( ) { 
						$(this).dialog("close"); 
					}
				}
});

$( "#verArchivos" ).dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		title: "Ver Anexos",
		width: 'auto',
		height: 'auto',
		show: {
	        effect: "blind",
	        duration: 500
	      },
	    hide: {
	        effect: "explode",
	        duration: 500
	    },
		buttons: {
					"Cerrar": function( ) { 
						$(this).dialog("close"); 
					}
				}
});

$( "#dvFolio" ).dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		title: "Módulo de Folios",
		width: 700,
		height: "auto",
		show: {
	        effect: "blind",
	        duration: 500
	      },
	    hide: {
	        effect: "explode",
	        duration: 500
	    },
		buttons: {
					"Cerrar": function( ) { 
						$(this).dialog("close"); 
					}
				}
});

$( "#dvFirma" ).dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		title: "Registrar Firmas",
		width: 700,
		height: 350,
		show: {
	        effect: "blind",
	        duration: 500
	      },
	    hide: {
	        effect: "explode",
	        duration: 500
	    },
		buttons: {
					"Cerrar": function( ) { 
						$(this).dialog("close"); 
					}
				}
});

$( "#actualizaDiploma" ).dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		title: "Actualizar Número de Diploma",
		width: "auto",
		height: "auto",
		show: {
	        effect: "blind",
	        duration: 500
	      },
	    hide: {
	        effect: "explode",
	        duration: 500
	    },
		buttons: {
					"Cerrar": function( ) { 
						$(this).dialog("close"); 
					}
				}
});


$( "#cmbFacultadTMando" ).change( function( ) {
			var tipoOperacion = 'listaCarreras';
			var cmbFacultad = $( "#cmbFacultadTMando" ).val( );

			$.ajax({
		  		url: "../servicio/carrera.php",
		  		type: "POST",
		  		data: { tipoOperacion : tipoOperacion , cmbFacultad : cmbFacultad },
		  		cache: false,
				success: function( data ){
					$( "#cmbCarreraTMando").html( data );
				}
			});
		});


var txtIdRol = $("#txtIdRol").val( );
var txtCuentaFacultad = $("#txtCuentaFacultad").val( );
/**
 * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se agrega txtIdRol == "104" para que sean los mismos permisos de rol 97
 * @since Enero 28, 2019
 */ 

if( txtIdRol == "3" || txtIdRol == "93" || txtIdRol == "97" || txtIdRol == "104"|| txtIdRol == "98" ){

	if( txtCuentaFacultad == "1" ){
		$( "#cmbFacultadTMando option[value!='-1']" ).attr("selected", "selected").change( );
		$("#tdFacultadTMando").hide( );
		$("#tdCmbFacultadTMando").hide( );
		$("#txtCuentaFacultad").val("0");
	}
}

switch( txtIdRol ){
        /**
         * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Se agrega case "104" para que sean los mismos permisos de rol 97
         * @since Enero 28, 2019
         */ 
	/*
	
        
/**
*@modified Diego Rivera<riveradiego@unbosque.edu.co>
*se agreaga case por default para temas de consulta 
*se eliminan los siguientes casos: 
    case "3":
    case "20":
    case "93":
    case "97":
    case "104":
    case "98":
* @since Enero 28, 2019
        break;*/
    	/*
	Administrador Tecnologia
	Auditoria Externa
	rol para el boton terminar
	*/
	case "13":
	case "89":
	case "75":
		var tipoOperacion = "consultarConsejoDirectivo";
	break;
	/*
	Secretaria General(Administrador)
	Secretaria Postgrados Ingenieira Industrial
	*/
	case "25":
	case "53":
	var tipoOperacion = "consultarSecretaria";
	break;
        
        default :
        var tipoOperacion = "consultar";
        break;
}


$( "#btnBuscarTMando" ).button( ).on("click",function() {

	var datos = $( "#formTableroMando" ).serialize( );
	var camposVacios = validarFormulario( datos );
	if( camposVacios == "" ){
	$( "#btnBuscarTMando" ).button({ label: "Buscando <img width='16' height='16' src='../css/images/cargando.gif' />" });
	$( "#btnBuscarTMando" ).button( "option" , "disabled" , true );
	$( "#btnBuscarTMando" ).button( ).off('click');
	$.ajax({
	  		url: "../servicio/estudiante.php",
	  		type: "POST",
	  		data: $( "#formTableroMando" ).serialize( ) + "&tipoOperacion="+tipoOperacion,
	  		cache: false,
			success: function( data ){
				if( data != 0 && data != 2 ){
					
				  var respuesta = data.search("0");

				  if( respuesta == 2) {
				
					  	$( "#mensageCargando" ).dialog( "close" );			
						$( "#btnBuscarTMando" ).button({ label: "Consultar" });
						$( "#btnBuscarTMando" ).button( "option", "disabled", false );
						validarSinDatos();
				  
				  } else {
				  		
						$( "#mensageCargando" ).dialog( "close" );
						data = trim( data );
						$( "#btnBuscarTMando" ).button({ label: "Consultar" });
						$( "#TablaEstudiante" ).html( data );
						$( "#btnBuscarTMando" ).button( "option", "disabled", false );
				  }
				
				}
				else if( data == 2 ){
			
					$( "#mensageCargando" ).dialog( "close" );			
					$( "#btnBuscarTMando" ).button({ label: "Consultar" });
					$( "#btnBuscarTMando" ).button( "option", "disabled", false );
					validarTipos("");
					
				}else if ( data == 0 ){
		
					$( "#mensageCargando" ).dialog( "close" );
					//alert("No existen registros para consultar");
					$( "#btnBuscarTMando" ).button({ label: "Consultar" });
					$( "#btnBuscarTMando" ).button( "option", "disabled", false );
					validarSinDatos();
				}
				
			}
		});



		
	
		$( "#mensageCargando" ).dialog( "open" );
	}else{
		crearMensaje( camposVacios );
	}
	
});

$("#estudiantes").dataTable({
	  "bJQueryUI": true,
      "sPaginationType": "full_numbers",
      "bProcessing": true,
      "bServerSide": false,
      "bDeferRender": true,
      "bRetrieve":true,
      //"deferRender": true,
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

$("#estudiantesAcuerdo").dataTable({
	"bJQueryUI": true,
  	"sPaginationType": "full_numbers",
  	"bProcessing": true,
  	"bServerSide": false,
   	"bDeferRender": true,
   	"bRetrieve":true,
      /*"paging": false,
      "processing": true,
      "bServerSide": false,
      "deferRender": true,*/
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

var table = $("#estudiantesSecretaria").dataTable({
	"bJQueryUI": true,
      //"sPaginationType": "full_numbers",
      "sPaginationType": "full_numbers",
      "bProcessing": true,
      "bServerSide": false,
       "bDeferRender": true,
       "bRetrieve":true,
      /*"paging": false,
      "processing": true,
      "bServerSide": false,
      "deferRender": true,*/
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


$( "#btnRestaurarTMando" ).button( ).click(function() {
	$("#formTableroMando").reset( );
});

$( "#btnRActa" ).button( ).on("click",function() {
	var txtEstudianteSeleccionados = $("#txtEstudianteSeleccionados").val( );
	var txtFechaGrado = $("#txtFechaGrado").val( );
	var txtCodigoCarrera = $("#txtCodigoCarrera").val( );
	$.ajax({
		url: "../interfaz/registrarActa.php",
  		type: "POST",
  		data: { txtEstudianteSeleccionados : txtEstudianteSeleccionados, txtFechaGrado : txtFechaGrado, txtCodigoCarrera : txtCodigoCarrera },
  		cache: false,
		success: function( data ){
			$( "#actaAcuerdo" ).html( data );
			$( "#actaAcuerdo" ).dialog( "open" );
				//$("#ckSeleccionar").each(function(){ this.checked = true; });
		}
	});
});

$( "#btnAnularActa" ).button( ).click(function( ){
	var tipoOperacion = "anularActa";
	var txtFechaGrado = $("#txtFechaGrado").val( );
	var txtCodigoCarrera = $("#txtCodigoCarrera").val( );
	$.ajax({
		url: "../interfaz/anularActa.php",
  		type: "POST",
  		data: { tipoOperacion : tipoOperacion , txtFechaGrado : txtFechaGrado, txtCodigoCarrera : txtCodigoCarrera },
  		cache: false,
		success: function( data ){
			$( "#mensageAnularActaAcuerdo" ).html( data );
			$( "#mensageAnularActaAcuerdo" ).dialog( "open" );
				//$("#ckSeleccionar").each(function(){ this.checked = true; });
		}
	});
});


$( "#btnGenerarActa" ).button( ).click(function( ){
	var txtEstudianteSeleccionados = $("#txtEstudianteSeleccionados").val( );
	var txtCodigoCarrera = $("#txtCodigoCarrera").val( );
	var txtTipoGrado = $("#txtTipoGrado").val( );
	$("#formGenerarActa").append('<input type="hidden" id="txtCodigoEstudiantes" name="txtCodigoEstudiantes" value="'+
                         htmlEntities(txtEstudianteSeleccionados)+'" />'+
                         '<input type="hidden" id="txtCodigoCarrera" name="txtCodigoCarrera" value="'+
                         txtCodigoCarrera+'" /><input type="hidden" id="txtTipoGrado" name="txtTipoGrado" value="'+
                         txtTipoGrado+'" />');
    $( "#formGenerarActa" ).submit( );
});

$( "#btnEnviarSecretaria" ).button( ).click(function( ){
	var tipoOperacion = "enviarComunicado";
	var txtFechaGrado = $("#txtFechaGrado").val( );
	var txtCodigoCarrera = $("#txtCodigoCarrera").val( );
	/*
	*Modidied Diego Rivera <riveradiego@unbosque.edu.co>
	*Se añade variable txtUsuarioActual captura el value del campo oculto y se envia como parametro en el data
	*Since February 20 ,2018
	*/
	var txtUsuarioActual = $("#txtUsuarioActual").val( );
	var txtTipoGrado = $("#txtTipoGrado").val( );
	$.ajax({
		url: "../servicio/pdf.php",
  		type: "POST",
  		data: { tipoOperacion : tipoOperacion , txtFechaGrado : txtFechaGrado, txtCodigoCarrera : txtCodigoCarrera, txtTipoGrado : txtTipoGrado ,txtUsuarioActual : txtUsuarioActual },
  		cache: false,
		success: function( data ){
			alert( data );		
		}
	});
});

$( "#btnDescargarActa" ).button( );


$( "#btnRAcuerdo" ).button( ).click(function() {
	var txtEstudianteSeleccionados = $("#txtEstudianteSeleccionados").val( );
	var txtFechaGrado = $("#txtFechaGrado").val( );
	var txtCodigoCarrera = $("#txtCodigoCarrera").val( );
	$.ajax({
		url: "../interfaz/registrarAcuerdo.php",
  		type: "POST",
  		data: { txtEstudianteSeleccionados : txtEstudianteSeleccionados, txtFechaGrado : txtFechaGrado, txtCodigoCarrera : txtCodigoCarrera },
  		cache: false,
		success: function( data ){
			$( "#mensageRAcuerdo" ).html( data );
			$( "#mensageRAcuerdo" ).dialog( "open" );
		}
	});
});

$( "#btnAnularAcuerdo" ).button( ).click(function(){
	var tipoOperacion = "anularAcuerdo";
	var txtFechaGrado = $("#txtFechaGrado").val( );
	var txtCodigoCarrera = $("#txtCodigoCarrera").val( );
	$.ajax({
		url: "../interfaz/anularActa.php",
  		type: "POST",
  		data: { tipoOperacion : tipoOperacion , txtFechaGrado : txtFechaGrado, txtCodigoCarrera : txtCodigoCarrera },
  		cache: false,
		success: function( data ){
			$( "#mensageAnularActaAcuerdo" ).html( data );
			$( "#mensageAnularActaAcuerdo" ).dialog( "open" );
				//$("#ckSeleccionar").each(function(){ this.checked = true; });
		}
	});
});


if($('#selectAllSecretaria').is(':checked')){
	$("#ckSeleccionarSecretaria", table.fnGetNodes()).each(function(){ //loop through each checkbox
	        this.checked = true;
	          //select all checkboxes with class "checkbox1"               
    });
}


$('#selectAllSecretaria').change(function(event) {  //on click 
	if(this.checked) {
		 // check select status
	    $("#ckSeleccionarSecretaria", table.fnGetNodes()).each(function(){ //loop through each checkbox
	        this.checked = true;
	         //select all checkboxes with class "checkbox1"               
	    });
	    
	}else{
	    	$("#ckSeleccionarSecretaria", table.fnGetNodes()).each(function(){ //loop through each checkbox
	        	this.checked = false; //deselect all checkboxes with class "checkbox1"                       
	        });        
	    }
});


$( "#btnGenerarAcuerdo" ).button( );

$( "#btnDescargarAcuerdo" ).button( );

$( "#btnRGrado" ).button( ).click(function( ){
	var tipoOperacion = "registrarGrado";
	var txtCodigoEstudiantes = $("#ckSeleccionarSecretaria", table.fnGetNodes( )).serialize( );
	var txtNumeroDiplomas = $("#txtNumeroDiploma", table.fnGetNodes( )).serialize( );
	var txtFechaGrado = $("#txtFechaGrado").val( );
	var txtCodigoCarrera = $("#txtCodigoCarrera").val( );
	var txtNumeroPromocion = $("#txtNumeroPromocion").val( );
	var txtIdDirectivo = $("#idDirectivoSecretaria").val( );
	$( "#mensageRegistroGrado" ).dialog( "option", "buttons", {
	"Sí": function() {
		$.ajax({
				url: "../servicio/registrarGrado.php",
		  		type: "POST",
		  		data: { tipoOperacion : tipoOperacion , txtCodigoEstudiantes : txtCodigoEstudiantes, txtNumeroDiplomas : txtNumeroDiplomas, txtFechaGrado : txtFechaGrado, txtCodigoCarrera : txtCodigoCarrera, txtNumeroPromocion : txtNumeroPromocion, txtIdDirectivo : txtIdDirectivo },
		  		cache: false,
				success: function( data ){
					if( data.length > 0 ){
						if( data == "1" ){
							alert("No existen estudiantes para registrar grado");
							$( "#mensageRegistroGrado" ).dialog( "close" );
							$( "#btnRGrado" ).button({ label: "Registrar Grado" });
							
						}else{
							if( data == "0"){
								alert("Por favor recuerde ingresar el número de diploma a los estudiantes seleccionados");
								$( "#mensageRegistroGrado" ).dialog( "close" );
								$( "#btnRGrado" ).button({ label: "Registrar Grado" });
								$( "#btnRGrado" ).button( "option", "disabled", false );
								
							}else{
								alert("Ha ocurrido un problema");
								$( "#mensageRegistroGrado" ).dialog( "close" );
								$( "#btnRGrado" ).button({ label: "Registrar Grado" });
								$( "#btnRGrado" ).button( "option", "disabled", false );
							}
						}
					}else{
						alert("Registro Guardado Correctamente");
						$( "#mensageRegistroGrado" ).dialog( "close" );
						$( "#btnRGrado" ).button({ label: "Registrar Grado" });
						$( "#btnRGrado" ).button( "option", "disabled", false );
						$( "#btnBuscarTMando" ).trigger( "click" );
					}
					
				}
			});
		},
		"No":function(){
			$( "#mensageRegistroGrado" ).dialog( "close" );
			$( "#btnRGrado" ).button({ label: "Registrar Grado" });
			$( "#btnRGrado" ).button( "option", "disabled", false );
		}
	});
	$( "#mensageRegistroGrado" ).dialog( "open" );


	
});




$( "#btnImprimirGrado" ).button( ).click(function( ){
	var txtFechaGrado = $("#txtFechaGrado").val( );
	var txtCodigoCarrera = $("#txtCodigoCarrera").val( );
	var txtCodigoModalidadAcademica = $("#txtCodigoModalidadAcademica").val( );
	$.ajax({
		url: "../interfaz/imprimirDocumentos.php",
  		type: "POST",
  		data: { txtFechaGrado : txtFechaGrado, txtCodigoCarrera : txtCodigoCarrera, txtCodigoModalidadAcademica : txtCodigoModalidadAcademica },
  		cache: false,
		success: function( data ){
			$( "#mensageImpresion" ).html( data );
			$( "#mensageImpresion" ).dialog( "open" );
		}
	});
});


$( "#btnDocumentosGrado" ).button( ).click(function( ){
	var url = $( this ).val( );
	verPDF( url );
});

$("#btnCargar").button( ).click(function( ){
	var txtFechaGrado = $("#txtFechaGrado").val( );
	var inputFile = document.getElementById("flCargarArchivo");
    var file = inputFile.files[0];
    var data = new FormData();
    data.append("tipoOperacionPrincipal","cargarArchivo");
    data.append("fileToUpload",file);
    data.append("txtFechaGrado",txtFechaGrado);
    data.append("tipoOperacion","submit");
    	$.ajax({//Ajax
                  type: "POST",
                  url: "../servicio/cargarArchivo.php",
                  contentType:false,
				  data: data ,
				  processData:false,
				  cache:false,
				  success: function( data ){
				  	if( data == 1 ){
	                     alert( "Archivo Cargado Correctamente" );
	                     $( "#btnBuscarTMando" ).trigger( "click" );
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
                    		alert("Solo se permiten archivos pdf");
                    	}
                    }
                  }
       });
	
	
});

$("#btnDescargarArchivo").button( ).click(function( ){
	var txtFechaGrado = $("#txtFechaGrado").val( );
	var txtCarpeta = "actas";
	$.ajax({//Ajax
          type: "POST",
          url: "../interfaz/verArchivos.php",
		  data: { txtFechaGrado : txtFechaGrado, txtCarpeta : txtCarpeta },
		  success: function( data ){
		  	$( "#verArchivos" ).html( data );
			$( "#verArchivos" ).dialog( "open" );
          }
       });
});



$("#btnEnviarVicerrectoria").button( );


$(".txtNumeroDiploma").focusout(function( ){
	var txtSeleccionados = $("#ckSeleccionarSecretaria:checked", table.fnGetNodes( ));
	var txtCodigoCarrera = $("#txtCodigoCarrera").val( );
	var datos = $( this ).val( );
	if( datos != ""){
		datos = parseInt( datos );
		for( var i = 0 ; i < txtSeleccionados.length; i++ ){
				$(".txtNumeroDiploma", table.fnGetNodes( )).each( function( ){
					/*
					 * @modified Andres Ariza <arizaandres@unbosque.edu.co>
					 * Se comento las lineas que agregan 0 ante del numero del diploma cuando es licenciatura o medicina
					 * @since  December 16, 2016
					*/
					/*/if( txtCodigoCarrera == 10 || txtCodigoCarrera == 90 || txtCodigoCarrera == 93 ){
						var datosLlenar = datos + i++;
						datosLlenar = "0"+datosLlenar;
					}else{/**/
						var datosLlenar = datos + i++;	
					//}
					/* END */
					$( this ).val( datosLlenar );
				});
			
		}
	}
});



$("#txtDirectivoSecretaria").keyup(function(){
		var tipoOperacion = "listaUsuarios";
		var txtNombres = $("#txtDirectivoSecretaria").val( );
		$.ajax({
	  		url: "../servicio/contacto.php",
	  		type: "POST",
	  		data: { tipoOperacion : tipoOperacion, txtNombres : txtNombres },
	  		beforeSend: function(){
				$("#txtDirectivoSecretaria").css('background','#FFF url("../css/images/LoaderIcon.gif") no-repeat 100px');
			},
			success: function( data ){
				$("#suggesstion-box").show();
				$("#suggesstion-box").html(data);
				$("#txtDirectivoSecretaria").css("background","#FFF");
			}
		});
});





function selectUser(val) {
	$("#txtDirectivoSecretaria").val(val);
	$("#suggesstion-box").hide();
	
}

function selectId( txtIdDirectivo ){
	$("#idDirectivoSecretaria").val(txtIdDirectivo);
}



