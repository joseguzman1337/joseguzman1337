/**
 * @author Carlos
 */

$(function(){
	/*$( "#menuFacilitador" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
    $( "#menuFacilitador li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );*/
	/*$( "#menuFacilitador" ).tabs({
		selected: 0,
		spinner: "Cargando <img width='16' height='16' src='../css/images/cargando.gif' />"
	});*/
	
	
	
	
	$( "#mensageConfirmacion" ).dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		title: "Confirmacion",
		hide: "explode",
		buttons: {
                            "Cancelar": function( ) { 
                                    $( this ).dialog("close"); 
                            },
                            "Continuar": function( ) { 
                                    $( "#" + objeto ).dialog("close"); $( this ).dialog("close");
                            }
                          }
	});
	
	$(".cargaMenu").click(function(event){
		/*modified diego rivera<riveradiego@unbosque.edu.co>
		 *se añade distractor mientras se carga los menus al dar click en mene gestion del plan de desarrollo 
		 *since march 16 2017
		 */
		
		$("#contenidoPlan").html("<h1 align='Center'>Cargando...</h1>");  
		$("#contenidoPlan").fadeTo(100, 0.1).fadeTo(200, 1.0);
		var href = $(this).attr("href");
		$("#menuPlanDesarrollo").css("display", "none");
		event.preventDefault(); 
		$("#contenidoPlan").load( href );
		
		//fin 
	});
	
	$( "#mensageDialogo" ).dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		hide: "explode",
		buttons: {
                            "Cerrar": function( ) { 
                                    $(this).dialog("close"); 
                            }
			},
		open: function() {
		    $buttonPane = $(this).next();
		    $buttonPane.find('button').addClass('btn').addClass('btn-warning');
        }
	});
	
	$( "#mensageAlert" ).dialog({
		autoOpen: false,
		modal: true,
		width: 700,
		resizable: false,
		hide: "explode",
		buttons: {
                            "Cerrar": function( ) { 
                                    $(this).dialog("close"); 
                            }
			},
		open: function() {
		    $buttonPane = $(this).next();
		    $buttonPane.find('button').addClass('btn').addClass('btn-warning');
        }
	});
	
	$( "#mensageRegistrar" ).dialog({
		
		autoOpen: false,
		show: "blind",
		modal: true,
		resizable: false,
		title: "Mensaje de Confirmación",
		width: 350,
		height: 200,
		hide: "explode",
		open: function() {
            $buttonPane = $(this).next();
            $buttonPane.find('button').addClass('btn').addClass('btn-warning');
        }
	});
	
	/*Modified Diego Rivera <riveradiego@unbosque.edu.co>
	 * Se crean parametro al dialog eliminarmeta
	 *Since July 19 ,2017 
	 */
		$( "#eliminarMeta" ).dialog({
			autoOpen: false,
			modal: true,
			draggable: true,
			resizable: false,
			title: "Eliminar Meta",
			width: 'auto',
			height: 'auto',
			show: {
		        effect: "blind",
		        duration: 500
		      },
		    hide: {
		        effect: "blind",
		        duration: 500
		    },
			buttons: {
                                    "Cerrar": function( ) { 
                                            $(this).dialog("close"); 
                                    }
					},
		open: function() {
		    $buttonPane = $(this).next();
		    $buttonPane.find('button').addClass('btn').addClass('btn-warning');
        }
	});
	
	
	//
	$( "#eliminarMetaSecundaria" ).dialog({
			autoOpen: false,
			modal: true,
			draggable: true,
			resizable: false,
			title: "Eliminar Meta Secundaria",
			width: 'auto',
			height: 'auto',
			show: {
		        effect: "blind",
		        duration: 500
		      },
		    hide: {
		        effect: "blind",
		        duration: 500
		    },
			buttons: {
						"Cerrar": function( ) { 
							$(this).dialog("close"); 
						}
					},
		open: function() {
		    $buttonPane = $(this).next();
		    $buttonPane.find('button').addClass('btn').addClass('btn-warning');
        }
	});
	
	$( "#mensageActualizarMetaSec" ).dialog({
		
		autoOpen: false,
		show: "blind",
		modal: true,
		resizable: false,
		title: "Mensaje de Confirmación",
		width: 350,
		height: 200,
		hide: "explode",
		open: function() {
            $buttonPane = $(this).next();
            $buttonPane.find('button').addClass('btn').addClass('btn-warning');
        }
	});
		
});

function crearMensaje( data ){
	$.ajax({
			url: "../servicio/mensajes.php",
			type: "POST",
			data: data,
			success: function(data){
				$( "#dialogo" ).html( data );
				$( "#mensageDialogo" ).dialog( "open" );
			}
	});
}

function trim ( dato ){
	dato = String( dato );
	return dato.replace(/^\s+/g,'').replace(/\s+$/g,'');
}

function llenarFormulario( data ){
	var datos = data.split('&');
	for( var i = 0 ; i < datos.length ; i++ ){
		var campo = datos[i].split('=');
		$( "#"+campo[0] ).val( trim( campo[1] ) );
		//alert(campo[0] + ' ' + campo[1]);
	}
}

function validar( errores ){
	var mensaje = "controlCampos";
	if( errores != "" ){
		$.ajax({
                    url: "../servicio/mensajes.php",
                    type: "POST",
                    data: { mensaje :  mensaje , errores : errores },
                    success: function( data ){
                            $( "#alerta" ).html( data );
                            $( "#mensageAlert" ).dialog( "option", "buttons", [
                                {
                                    text: "Aceptar",
                                    click: function() { 
                                            $( this ).dialog("close"); 
                                    }
                                }
                            ] );				

                            $( "#mensageAlert" ).dialog( "open" );
                    }
		});
	}else{
		return true;
	}
}

function validarFormulario( data ){
	var datosVacios = "";
	var datos = data.split('&');
	for( var i = 0 ;  i < datos.length ; i++ ){
		var campos = datos[i].split('=');
		var valor = trim( campos[1] );
		
		if( valor == "" || valor == "-1" ){
		
			if( campos[0] != "cmbCarrera" ){ 
				var titulo = $( "#" + campos[0] ).attr("title");
				datosVacios = datosVacios + campos[0] + "=" +titulo + "&";
			}
		}
	}
	if( datosVacios != "" )
		datosVacios = datosVacios + "mensaje=ValidarCampos";
	return datosVacios;
}

/*
function llenarFormulario( data ){
	var datos = data.split('&');
	for( var i = 0 ; i < datos.length ; i++ ){
		var campo = datos[i].split('=');
		$( "#"+campo[0] + "" + txtNumeroCarga ).val( trim( campo[1] ) );
	}
}*/



function conexion(  ) {
	$.ajax({
		url: "../servicio/estadoConexion.php",
		success: function(data){
			$( "#conexion" ).html( data );
		}
	});
    setTimeout( "conexion( )" ,10000);
}

function mensajeConfirmacion( objeto ){
	$( "#mensageConfirmacion" ).dialog( "option", "buttons", [
	    {
	        text: "Cancelar",
	        click: function() { $( this ).dialog("close"); }
	    },
	    {
	        text: "Continuar",
	        click: function() { 
	        	$( "#" + objeto ).dialog("close"); 
	        	$( this ).dialog("close"); }
	    }
	] );
	$( "#mensageConfirmacion" ).dialog( "open" );
}
/*$(function(){
       $('#formInscribirPersona').validate({
           rules: {
           'nombre': 'required'           
           },
       messages: {
           'nombre': 'Debe ingresar el nombre'           
       },
       debug: true,
       /*errorElement: 'div',*/
       //errorContainer: $('#errores'),
      /* submitHandler: function(form){
           alert('El formulario ha sido validado correctamente!');
       }
    });
});*/

function validarForm( data ){
		var datos = "";
		
		
		$("#"+data).find("input[type=text]").each(function( ){
			var valor = trim($( this ).val( ));
			var name = $( this ).attr("name");
		
			if( valor == "" ){
						 	
			 if( name == 'txtMeta[0][0][]'  || name == 'txtFechaInicioMeta[0][0][]' || name == 'txtFechaFinalMeta[0][0][]' || name == 'txtValorMeta[0][0][]' || name == 'txtResponsableMeta[0][0][]' || name == 'txtResponsableMetaEmail[0][0][]' ){
				 	
				 } else {
						
						/*Modified Diego Rivera <riveradiego@unbosque.edu.co>
						 *se añade funcion indexOf con el fin de validar los campos cuando se agrega nuevo proyectos
						 * Since July 05,2017 
						 */
						 
						 
						verificar=name.indexOf("txtMetaPrincipal");
						verificarValor = name.indexOf("txtValorMetaPrincipal");
						verificarIndicador = name.indexOf("txtIndicador");	
						
							if( verificar==-1 ){
							
							
							} else {
							
								name='txtMetaPrincipal[0][]';
								
							}
							
							
							if( verificarValor==-1 ){
							
							
							} else {
							
								name='txtValorMetaPrincipal[0][]';
								
							}
							
							
							
							if( verificarIndicador ==-1 ){
							
							
							} else {
							
								name='txtIndicador[0][]';
								
							}
							// fin modificaciones
							
							datos = trim(datos+traducirCampos(name)+"\n"+",");
				}
			}
		});
		return datos;
		
}


function traducirCampos( datos ){
	var traductor = "";
	switch (datos) {
	    case "txtPrograma":
	        traductor = "Programa";
	        break;
	    case "txtResponsableProgramaEmail":
	       traductor = "Responsable Programa email";
	    break;    
	    
	    case "txtResponsableProyectoEmail[]":
	     traductor = "Responsable Proyecto email";
	    break;  
	    case "txtResponsablePrograma":
	        traductor = "Responsable Programa";
	        break;
	    case "txtProyecto[]":
	        traductor = "Proyecto";
	        break;
	    case "txtResponsableProyecto[]":
	        traductor = "Responsable Proyecto";
	        break;
	    case "txtIndicador[0][]":
	        traductor = "Indicador";
	        break;
	    case "txtMetaPrincipal[0][]":
	        traductor = "Meta Principal";
	        break;
	    case  "txtValorMetaPrincipal[0][]":
	        traductor = "Valor Meta Principal";
	        break;
	    case "txtMeta":
	        traductor = "Nombre Meta Secundaria";
	        break;
	    case "txtFechaInicioMeta[0][0][]":
	        traductor = "Fecha Inicio";
	        break;
	    case  "txtFechaFinalMeta[0][0][]":
	        traductor = "Fecha Final";
	    case "txtValorMeta[0][0][]":
	        traductor = "Valor Meta Secundaria";
	        break;
	    case  "txtResponsableMeta[0][0][]":
	        traductor = "Responsable Meta Secundaria";
	    break;
	    
	     
	}
	
	return traductor;
}
