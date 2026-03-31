/*
 * @modified Luis Dario Gualteros 
 * <castroluisd@unbosque.edu.co>
 * Ajuste de formulario y creacion de horarios de Entrevistas para los programas de Postgrados.
 * @since Abril 13, 2018.
*/ 
$(document).ready(function() {

	valorEntevistaId ="";

	$( ".Guardar" ).attr( "disabled" , "disabled" );


	$(document).on('click', '.equivalente', function( ) {

			/*idActual captura elemento al que se dio click de la clase equivalente
			 *claseActiva verifica y cambia de color  los botones referentes a los dias de la semana en el formulario
			 *valor almacena valores de los botones activos
			 *identificador captura los id de los elementos con clase btn recorridos en el foreach
			*/
			 idActual = $(this).attr( 'id' );			
			 claseActiva = $( "#" + idActual ).hasClass( "active" );
			 carrera =  $( "#codigoCarrera" ).val( );
	
			if ( claseActiva == true ) {
				$( "#" + idActual ).removeClass( "active" );
				$( "#" + idActual ).removeClass( "btn-success" );

			} else {
				$( "#" + idActual ).addClass( "active" );	
				$( "#" + idActual ).addClass( "btn-success" );
			}


			valor = "";	
       		
       		$( ".equivalente" ).each(function( ) {

       			$( ".Guardar" ).attr( "disabled" , "disabled" );
       			identificador=($(this).attr('id'));
       			elementosActivos = $( "#" + identificador ).hasClass( "active" );
       			jornada = $( "#tipoJornada" ).val( );
       			
       			if( elementosActivos == true ){
       				valor = valor + $( "#" + identificador ).val()+',';
       			}

       		}); 

			 accion ="verFechas";
			 datos={valor:valor,carrera:carrera ,jornada:jornada,accion:accion}
			
			consulta('../serviciosacademicos/AgendadeEntrevistas/asignarEntrevista/cargaFechas.php',datos,function(result){

				if ( result == "" ){
					result ="<p style='color:red'>No hay programación de entrevista para el día y jornada seleccionada</p>";
					
				}

			$( "#fechas" ).html( result );

		});

	});


	$(document).on('click', '.equivalenteA', function( ) {

			/*idActual captura elemento al que se dio click de la clase equivalente
			 *claseActiva verifica y cambia de color  los botones referentes a los dias de la semana en el formulario
			 *valor almacena valores de los botones activos
			 *identificador captura los id de los elementos con clase btn recorridos en el foreach
			*/
			 idActual = $(this).attr( 'id' );			
			 claseActiva = $( "#" + idActual ).hasClass( "active" );
			 carrera =  $( "#codigoCarrera" ).val( );
			


			if ( claseActiva == true ) {
				$( "#" + idActual ).removeClass( "active" );
				$( "#" + idActual ).removeClass( "btn-success" );

			} else {
				$( "#" + idActual ).addClass( "active" );	
				$( "#" + idActual ).addClass( "btn-success" );
			}


			 valor = "";	
       		
       		$( ".equivalenteA" ).each(function( ) {
       		
       			identificador=($(this).attr('id'));
       			elementosActivos = $( "#" + identificador ).hasClass( "active" );
       			jornada = $( "#tipoJornadaA" ).val( );
       			
       			if( elementosActivos == true ){
       				valor = valor + $( "#" + identificador ).val()+',';
       			}

       		}); 
       		accion ="verFechas";
       		datos={						
						 valor:valor ,carrera:carrera ,jornada:jornada ,accion:accion
			}

			consulta('../serviciosacademicos/AgendadeEntrevistas/asignarEntrevista/cargaFechas.php',datos,function(result){
				if ( result == "" ){
					result ="<p style='color:red'>No hay programación de entrevista para el día y jornada seleccionada</p>";
					
				}

			$( "#fechasA" ).html( result );

		});
		
	});

//activa e inactiva los dias de las semana
	$(document).on('change', '#tipoJornada', function( ) {
		jornada = $( "#tipoJornada" ).val( );

		if ( jornada == "" ){
			$( ".equivalente" ).attr( "disabled" , "disabled" );
			$( ".equivalente" ).removeClass( "active" );
			$( ".equivalente" ).removeClass( "btn-success" );
			$( "#fechas" ).html( "<p style='color: red'>Seleccione Jornada de preferencia Para realizar la asignación de la entrevista</p>" ); 
			$( ".Guardar" ).attr( "disabled" , "disabled" ); 
		} else {
			$( ".equivalente" ).removeAttr( "disabled" );
			$( "#fechas" ).html( "<p style='color: red'>Seleccione día de preferencia para la entrevista</p>" );
			$( ".equivalente" ).removeClass( "btn-success" );
			
		 }
	});


	$(document).on('change', '#tipoJornadaA', function( ) {
		jornada = $( "#tipoJornadA" ).val( );

		if ( jornada == "" ){
			$( ".equivalenteA" ).attr( "disabled" , "disabled" );
			$( ".equivalenteA" ).removeClass( "active" );
			$( ".equivalenteA" ).removeClass( "btn-success" );
			$( "#fechasA" ).html( "<p style='color: red'>Seleccione Jornada de preferencia Para realizar la asignación de la entrevista</p>" ); 
			 
		} else {
			$( ".equivalenteA" ).removeAttr( "disabled" );
			$( "#fechasA" ).html( "<p style='color: red'>Seleccione día de preferencia para la entrevista</p>" );
			$( ".equivalenteA" ).removeClass( "btn-success" );
			
		 }
	});

// fin activacion de dias

//Captura valor de la fecha seleccionada para entrevista
	$(document).on('click', '.entrevista', function( ) {
	  	entrevistaId = $(this).attr( "id" );
	  	valorEntevistaId = $( "#"+entrevistaId ).val();
	 	$( ".Guardar" ).removeAttr( "disabled" );

	 });
 //fin captura

 	$(document).on('click', '#asignarEntrevista', function( ) {

		$( "#asignarEntrevista" ).off( );

		 codigoCarreraAspirante = $( "#codigoCarreraAspirante" ).val( ); 
 		 nombreAspirante = $( "#nombreAspirante" ).val( );
		 nombreCarreraAspirante = $( "#nombreCarreraAspirante" ).val( );
		 idEstudianteCarreraInscripcion = $( "idEstudianteCarreraInscripcion" ).val( );
		 elemento=$(this);
		 icono = elemento.attr('data-clase');
		 entrevistado = $("#entrevistado").val( );
		 activarAsignacion = $("#activarAsignacion").val();


		if( activarAsignacion == '1_1' ){

			 if( entrevistado == 0 ) {

					 $( ".equivalente" ).removeClass( "active" );

					 datos={
						codigoCarreraAspirante:codigoCarreraAspirante , nombreAspirante:nombreAspirante , nombreCarreraAspirante:nombreCarreraAspirante 
					 }

					 consulta('../serviciosacademicos/AgendadeEntrevistas/asignarEntrevista/asignarEntrevista.php',datos,function( result ){
					
							bootbox.dialog({
							title : "Asignacion Entrevista",
							message : result,
							size: "large",
							buttons : {
								success : {
								label : 'Asignar',
								className: 'btn-success Guardar col-xs-12  col-sm-12 col-md-2 col-md-push-8',
								callback : function( ){
													
												idEstudianteCarreraInscripcion = $("#idEstudianteCarreraInscripcion").val( );
												accion = "insertar" ;
											
											    datos={
													idEstudianteCarreraInscripcion:idEstudianteCarreraInscripcion, valorEntevistaId:valorEntevistaId , accion:accion	
												}	

												transaccion('../serviciosacademicos/AgendadeEntrevistas/asignarEntrevista/cargaFechas.php',datos,function(result){
									
														if( result == 0 ){
															result = 'Ha ocurrido un error...'			

														}
														else if (result == 1){
															$(".identificador").removeClass( icono );
															$(".identificador").addClass('fa-check-circle');
															$(".identificador").css('color' , 'green');
															$("#entrevistado").val( 1 );
														   //Mensaje para los programas de Postgrados.
															resultado = 'Entrevista Programada. Recuerde que si aún no ha hecho el envío de los documentos, puede hacerlos llegar en un solo archivo formato PDF al correo atencionalusuario@unbosque.edu.co';										
														}else if (result == 2){
														  $(".identificador").removeClass( icono );
															$(".identificador").addClass('fa-check-circle');
															$(".identificador").css('color' , 'green');
															$("#entrevistado").val( 1 );
														   //Mensaje para los programas de Pregrado.
															resultado = 'Entrevista Programada. Recuerde que si aún no ha hecho el envío de los documentos, puede hacerlos llegar en un solo archivo formato PDF al correo atencionalusuario@unbosque.edu.co';										  
														}else {
															bootbox.alert("Entrevista asignada Correctamente");	
															window.setTimeout('location.reload()', 2000);
															 
														}
														bootbox.alert(resultado);	

												});//cierra funcion transaccion
								
											}
										},//cierra boton success
								cancel : {
						        label : "Cerrar",
						        className : 'btn-danger col-md-2  col-xs-12  col-sm-12  col-md-push-8',
						        callback : function( ){

						 					
						        	}
				  				}// cierra boton cancel

							}
						});//cierra dialog bootbox

					});// cierra funcion consulta

			 } else {
		 		
		 		 idEstudianteCarreraInscripcion = $("#idEstudianteCarreraInscripcion").val( );
		 	 
			 	 datos={
			 	 	codigoCarreraAspirante:codigoCarreraAspirante , nombreAspirante:nombreAspirante ,   nombreCarreraAspirante:nombreCarreraAspirante  ,  idEstudianteCarreraInscripcion:idEstudianteCarreraInscripcion
			     }

				consulta('../serviciosacademicos/AgendadeEntrevistas/asignarEntrevista/actualizarEntrevista.php',datos,function( result ){

			 		var principal = bootbox.dialog({
						title : "Actualizar Fecha Entrevista",
						message : result,
						size: "large",
						buttons : {
							success : {
							label : 'Actualizar',
							className: 'btn-success col-md-2 col-xs-12  col-sm-12 col-md-push-4',
							callback : function( ){
									accion ='actualizar';
									entrevistaAsignacionId = $("#entrevistaAsignacionId").val();
									observacion = $("#observacion").val(); 
									datos = {
										accion : accion , entrevistaAsignacionId : entrevistaAsignacionId ,  valorEntrevistaId : valorEntevistaId , observacion : observacion
									}  

									$('#formActualizarEntrevista').validate({
										rules:{
											observacion:{ required:true , minlength: 8 , onlyText:true},
											'optradio[]':{required:true}
											},
										 messages:{
										 	observacion:{required:"Debe digitar  la observacion" , minlength:'Minimo 8 caracteres',onlyText:'Solo se admite texto'},
										 	'optradio[]':{required:"Debe seleccionar una fecha nueva"}
										 
										 },
										  errorPlacement: function(error, element) {
									            if ( element.is(":radio") ) 
									            {
									                error.appendTo( element.parents('.validacion') );
									            } else { 
									                error.insertAfter( element );
									            }
									         }
										});//cierra valifate

									if($('#formActualizarEntrevista').valid()){

									    	transaccion('../serviciosacademicos/AgendadeEntrevistas/asignarEntrevista/cargaFechas.php',datos,function(result){
												
												if ( result == 0 ){
										    			result = 'Ha ocurrido un error...'										
												} else if ( result == 1 ){
															$(".identificador").removeClass( icono );
															$(".identificador").addClass('fa-check-circle');
															$(".identificador").css('color' , 'green');
															$("#entrevistado").val( 1 );
															resultado = 'Fecha y hora de entrevista actualizada';										
												}	else {
														bootbox.alert("Entrevista reprogramada, ha ocurrido un error al enviar el email");	
													    window.setTimeout('location.reload()', 5000);
												}
														
														bootbox.alert(resultado);	

												});	//cierra fucncion transaccion

									} else {
										return false;
									}
								}//cierra calbalck
							},//cierra boton succes
							cancel : {
					        label : "Cancelar Entrevista",
					        className : 'btn-warning col-md-4  col-xs-12  col-sm-12 col-md-push-4',
					        callback : function( ){
									
						        	$( '#formActualizarEntrevista' ).validate({
						        		rules:{
										    observacion:{ required:true , minlength: 8 , onlyText:true}
										},
										 messages:{
										 	observacion:{required:"Debe digitar  la observacion" , minlength:'Minimo 8 caracteres',onlyText:'Solo se admite texto'},
											 }
						        	});//cierra validate


									if($( '#formActualizarEntrevista' ).valid()){
											estado ="";
											var dialog = bootbox.dialog({
													
														title: 'Entrevista Cancelada',
														message: "<p>Desea reprogramarla ?</p>",
														buttons: {
															      success: {
															        label: "Si",
															        className: 'btn-success',
															        callback: function(){
															        	
															        		principal.modal('show');
															        		dialog.modal('hide');


															        }
															    },
															    cancel: {
															        label: "No",
															        className: 'btn-danger',
															        callback: function(){
															   				observacion = $( "#observacion" ).val(); 
																			entrevistaAsignacionId = $("#entrevistaAsignacionId").val();
																			accion ='eliminar';
																			
																			datos = {
																					accion : accion , entrevistaAsignacionId : entrevistaAsignacionId  , observacion : observacion
																				} 
															        		transaccion('../serviciosacademicos/AgendadeEntrevistas/asignarEntrevista/cargaFechas.php',datos,function(result){
															        			
															        				if( result == 0 ){
																						result = 'Ha ocurrido un error...'										
																					} else if ( result == 1 ){
																						result = 'Fecha y hora de entrevista cancelada';	
																						$(".identificador").removeClass( 'fa-check-circle' );
																						$(".identificador").addClass('fa-times-circle');
																						$(".identificador").css('color' , 'red');
																						$("#entrevistado").val( 0 );
																						principal.modal('hide');
																						
																						
																					}else{
                                                                                                                                                                        	bootbox.alert("Entrevista cancelada, ha ocurrido un error al enviar el email");	
                                                                                                                                                                                window.setTimeout('location.reload()', 2000);
																						 //window.location.reload();
																					}



															        		});
															        }
															    }
														  
														    }
														});
												return false;

									} else {

										return false;
									}	
						       	}//cierra calback
			  			},//cierra boton cancel
			  			ok : {
					        label : "Cerrar",
					        className : 'btn-danger col-md-2 col-xs-12  col-sm-12 col-md-push-4',
					        callback : function( ){
					 					
					        	}//cierra callball
			  				}//cierra boton ok
						}//cierra buttons
					});//cierra bootbox.dialog
			 	});//cierra funcion consulta

		} 
	} else {

		bootbox.alert( "Recuerde que los anteriores pasos son obligatorios para programar su prueba o entrevista" );	
	  }
	});
	
});

function consulta( url , parametros , respuesta ){
	$.ajax({
		type : 'get',
		url : url,
		data : parametros,
		success : respuesta
		
	});
}

function transaccion( url , parametros , respuesta ){
	$.ajax({
		type : 'post',
		url : url,
		data : parametros,
		success : respuesta
	});
}