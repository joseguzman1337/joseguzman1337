/**
 * @author suarezcarlos
 */

$( "#cmbFacultadDigitalizar" ).off( ).change( function( ) {
	var tipoOperacion = 'listaCarreras';
	var cmbFacultad = $( "#cmbFacultadDigitalizar" ).val( );
	$.ajax({
  		url: "../servicio/carrera.php",
  		type: "POST",
  		data: { tipoOperacion : tipoOperacion , cmbFacultad : cmbFacultad },
		success: function( data ){
			//alert(data);
			$( "#cmbCarreraDigitalizar").html( data );
		}
	});
});

/*Modified Diego Rivera<riveradiego@unbosque.edu.co>
 *Se añade opcion de carga de archivos de manera masiva 
 *Since June 16,2017
 */

	$(".jfilestyle  ").off( ).click( function ( e ) {
		   $(".count-jfilestyle").show( );
	});
	
	
	$( "#btnCargarArchivos" ).button( ).off().click(function( e ) {
		e.stopPropagation();
		e.preventDefault();

			
		var inputFile = document.getElementById( "txtFileAvance" );
	    var file = inputFile.files;
	    var data = new FormData();
	  	
	  
	  	if( file.length > 10 ){
		  	 
		  	 $( "#dialogo" ).html( "La carpeta debe contener maximo 10 archivos" );
		     $( "#mensageDialogo" ).dialog( "open" );   
		  	 
	  		 $(".count-jfilestyle").hide( );
	  		
	  	} else {
		
			for(i=0; i<file.length; i++){
				data.append('fileToUpload'+i,file[i]); //Añadimos cada archivo a el arreglo con un indice direfente
				//	alert(file[i].name);
			}
					

				$.ajax({
				
					 type: "POST",
			         url: "../servicio/cargaDocumentos.php",
			         contentType:false,
					 data: data ,
					 processData:false,
					 cache:false,
					 beforeSend: function( data ) {

							  	$( "#dialogo" ).html( "<strong>Cargando</strong> <img width='16' height='16' src='../css/images/cargando.gif' />" );
							  	$( "#mensageDialogo" ).dialog( "open" );   
					  },
					  success: function( data ) {
							    $(".count-jfilestyle").hide( );
							 	$( "#dialogo" ).html( data );
								$( "#mensageDialogo" ).dialog( "open" );   
									
									$( "#CargarReporte" ).click ( function ( ) {
											$( "#verArchivo" ).submit( );
										
											$.ajax({
												type: "POST",
										         url: "../servicio/cargaDocumentos.php",
										         contentType:false,
												 data: data ,
												 processData:false,
												 cache:false,
												 beforeSend: function( data ) {
												  	 $( "#dialogo" ).html( "<strong>Generando pdf</strong> <img width='16' height='16' src='../css/images/cargando.gif' />" );
								  					 $( "#mensageDialogo" ).dialog( "open" );  

					  							 },
					  							   success: function( data ) {
							  						 $( "#dialogo" ).html( data );
									  				 $( "#mensageDialogo" ).dialog( "open" ); 

									  				  
					  							  },
					  							  complete:function ( data ){
					  							  	$( "#mensageDialogo" ).dialog( "close" ); 
					  							  	}
											});
											
												
											
										});

							 //$("#btnCargarArchivos").off('click');

							  }
				});

		}

		if( $( "#cmbFacultadDigitalizar" ).val( ) == -1) {

		}else{

			$( "#btnBuscarDigitalizar" ).trigger( "click" );
		}

	});

//fin modificacion



$( "#btnBuscarDigitalizar" ).button( ).off('click').on('click',function(){ 
	var cantidadFinal = 10;
	var datosDigitalizar = $("#formDigitalizar").serialize( );
	var camposVacios = validarFormulario( datosDigitalizar );
	if( camposVacios == "" ){
	//$( "#mensageCargando" ).dialog( "open" );
	$( "#btnBuscarDigitalizar" ).button({ label: "Buscando <img width='16' height='16' src='../css/images/cargando.gif' />" });
	$( "#btnBuscarDigitalizar" ).button( "option" , "disabled" , true );
						    
										    
	$.ajax({
	  		url: "../servicio/digitalizar.php",
	  		type: "POST",
	  		data: $( "#formDigitalizar" ).serialize( )+ "&tipoOperacionDigitalizar=crearPaginador"+
  				"&cantidadFinal=" + cantidadFinal,
	  		cache: false,
			success: function( data ){
				
				//alert( data );$("#log").html( data );*/
			
			if( data != 0 ){
					$( "#mensageCargando" ).dialog( "close" );
					data = trim( data );
					$( "#btnBuscarDigitalizar" ).button({ label: "Consultar" });
					$( "#reportePaginador" ).html( data );
					$( "#btnBuscarDigitalizar" ).button( "option", "disabled", false );
					consultar(0, 10);

				}
				else{

					
					$( "#btnBuscarDigitalizar" ).button({ label: "Consultar" });
					$( "#btnBuscarDigitalizar" ).button( "option", "disabled", false );
					validarSinDatos();
				}
			}
		});
	}else{
		crearMensaje( camposVacios );
	}
});


$( "#btnRestaurarDigitalizar" ).button( ).off( ).click(function() {
});


$("#estudiantesBuscarDigitalizar").keyup(function(){
		// When value of the input is not blank
		if( $(this).val() != "")
		{
			// Show only matching TR, hide rest of them
			$("#TablaDigitalizar tbody>tr").hide( );
			$("#TablaDigitalizar td:contains-ci('" + $(this).val() + "')").parent("tr").show();
		}
		else
		{
			// When there is no input or clean again, show everything back
			$("#TablaDigitalizar tbody>tr").show();
		}
	});
	

$.extend($.expr[":"], 
{
    "contains-ci": function(elem, i, match, array) 
	{
		return (elem.textContent || elem.innerText || $(elem).text() || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
	}
});


$(".txtCodigoEstudiante").each(function( ){
	
	var txtCodigoEstudiante = $( this ).val( );
	var txtFechaGrado = $("#txtFechaGrado").val( );
	var tipoOperacionDigitalizar = "guardarDigitalizar";
	var txtRutaDocumento = "../documentos/digital/"+txtFechaGrado+"/"+txtCodigoEstudiante;
	var txtIdUsuario = $("#txtIdUsuario").val( );
	$( "#txtIdSubirArchivo"+txtCodigoEstudiante ).uploadifive({
			"auto"             : false,
			"fileTypeDesc"	   : "archivos",
			"fileTypeExts"     : "*.pdf",
			"multi"			   : false,
			"buttonText" 	   : "Seleccionar",
			"checkScript"      : "../tema/uploadify/check-exists.php",
			"formData"         : {
								   "folder": "../documentos/digital/"+txtFechaGrado+"/"+txtCodigoEstudiante, 
			                     },
			"queueID"          : "listaArchivos"+txtCodigoEstudiante,
			"uploadScript"     : "../tema/uploadify/uploadifive.php",
			"cancelImg": "../tema/uploadify/imagenes/cancel.png",
			"onUploadComplete" : function(file, data) {
				console.log(data);
				$.ajax({
				    type: "POST",
				    url: "../servicio/digitalizar.php",
				    data: { tipoOperacionDigitalizar : tipoOperacionDigitalizar, txtCodigoEstudiante : txtCodigoEstudiante, txtRutaDocumento : txtRutaDocumento,txtIdUsuario : txtIdUsuario },
				    success: function (data) {
				       alert("Documento Cargado");
				    }
				});
				//$("#TablaDigitalizar").load( 'digitalizar.php' );
				//$( "#btnBuscarDigitalizar" ).trigger( "click" );
			}
	});

	
});
