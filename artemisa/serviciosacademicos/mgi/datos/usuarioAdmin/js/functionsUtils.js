$(document).ready(function()
{
	if ($("#submitRegistro").val() != 'Solicitar registro de correo' ){
	$("#fechavencimientousuario").datepicker({ 
	dateFormat: 'yy-mm-dd' ,
	changeMonth: true,
	changeYear: true
	});
	$("#crearUsuario").hide();
	$("#editarUsuario").hide();
	$("#guardarEdit").hide();
	$("#crearUsuarioDocente").hide();
	$("#vencimiento").hide();
	$('#crear').on("click",function() {
		$("#crearUsuario").show();
		$("#editarUsuario").hide();
		$("#crearUsuarioDocente").hide();
		$("#idDataUsuario").empty();
		$("#guardarEdit").hide();
		$("#vencimiento").hide();
		 clearInputs();
        /*Consultar select de roles*/
			$.ajax({
			dataType: 'html',
			type: 'POST',
			url: 'Controller.php',
			data: {action: 'consultaRol'},                
			success:function(data){                
				$("#idSelectRol").html(data);
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		});
	   /* **** */
	});	
	$('#crearDocente').on("click",function() {
		$("#crearUsuario").hide();
		$("#editarUsuario").hide();
		$("#crearUsuarioDocente").show();
		$("#idDataUsuario").empty();
		$("#guardarEdit").hide();
		$("#vencimiento").hide();
		 clearInputs();
	});
	$('#editar').on("click",function() {
		$("#editarUsuario").show();
		$("#crearUsuario").hide();
		$("#crearUsuarioDocente").hide();
		 clearInputs();
	});
	//autocomplete
	$("#documentoB").autocomplete({
		source: "Controller.php?action=autocomplete",
		minLength: 1,
		select: function( event, ui ) {
				$('#id_usuario').val(ui.item.id_diploma);
			}
	});	
	/*Guardar Nuevo Admin*/
	$('#guardarNew').on("click",function() {
		$("#idDataCorrecto").show();
		var documento = $("#documento").val();
		var nombre = $("#nombre").val();
		var apellido = $("#apellido").val();
		var usuario = $("#usuario").val();
		var rol = $("#rol").val();
		var expreg = /^[A-Z]{1,2}\s\d{4}\s([B-D]|[F-H]|[J-N]|[P-T]|[V-Z]){3}$/;
		if (documento == ''){
			alert("Debe digitar Documento");
			return false;
		}else{
                    /**
                     * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
                     * Se comenta la validacion de numero de documento para que quede alfanumerico
                     * @since Enero 23, 2019
                     */ 
			/*if (!/^([0-9])*$/.test(documento)){
				alert("El documento " + documento + " no es correcto");
				return false;
			}*/
		}
		if (nombre == ''){
			alert("Debe digitar Nombre");
			return false;
		}				
		if(soloLetras(nombre)== '1'){
			alert("El nombre digitado no es correcto");
			return false;
		}
		if (apellido == ''){
			alert("Debe digitar Apellido");
			return false;
		}
		if(soloLetras(apellido)== '1'){
			alert("El apellido digitado no es correcto");
			return false;
		}
		if (usuario == ''){
			alert("Debe digitar Usuario");
			return false;
		}
		if(alfanumerico(usuario)== '2'){
			alert("El usuario digitado no es correcto");
			return false;
		}
		if (rol == ''){
			alert("Debe seleccionar Rol");
			return false;
		}
		
		$.ajax({
			dataType: 'html',
			type: 'POST',
			url: 'Controller.php',
			data: {
					nombre: nombre,
					apellido: apellido,
					usuario : usuario,
					rol : rol,
					documento:documento,
					action: 'guardarNew'
			},                
			success:function(data){
				$("#idDataCorrecto").html(data);
				if (data !== '<script>alert("No fue posible guardar los cambios. El usuario digitado ya existe");</script>'){
					clearInputs();	
				}
				 
				$('#idDataCorrecto').hide(20000,function() {
				});
				 
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		});
	});
	/* guardar usuario docente*/
	$('#guardarNewD').on("click",function() {
		var documento = $("#documentoD").val();
		var nombre = $("#nombreD").val();
		var apellido = $("#apellidoD").val();
		var usuario = $("#usuarioD").val();
		var tipoUsuario = $("#TipoUsuario").val();
		$("#idDataCorrectoD").show();
		var expreg = /^[A-Z]{1,2}\s\d{4}\s([B-D]|[F-H]|[J-N]|[P-T]|[V-Z]){3}$/;
		if (documento == ''){
			alert("Debe digitar Documento");
			return false;
		}else{
                        /**
                         * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
                         * Se comenta la validacion de numero de documento para que quede alfanumerico
                         * @since Enero 23, 2019
                         */ 
			/*if (!/^([0-9])*$/.test(documento)){
				alert("El documento " + documento + " no es correcto");
				return false;
			}*/
		}
		if (nombre == ''){
			alert("Debe digitar Nombre");
			return false;
		}				
		if(soloLetras(nombre)== '1'){
			alert("El nombre digitado no es correcto");
			return false;
		}
		if (apellido == ''){
			alert("Debe digitar Apellido");
			return false;
		}
		if(soloLetras(apellido)== '1'){
			alert("El apellido digitado no es correcto");
			return false;
		}
		if (usuario == ''){
			alert("Debe digitar Usuario");
			return false;
		}
		if(alfanumerico(usuario)== '2'){
			alert("El usuario digitado no es correcto");
			return false;
		}
		if (tipoUsuario == ''){
			alert("Debe seleccionar Tipo Usuario");
			return false;
		}		
		$.ajax({
			dataType: 'html',
			type: 'POST',
			url: 'Controller.php',
			data: {
					nombre: nombre,
					apellido: apellido,
					usuario : usuario,
					tipoUsuario : tipoUsuario,
					documento:documento,
					action: 'guardarNew'
			},                
			success:function(data){
				$("#idDataCorrectoD").html(data);
				 clearInputs();
				$('#idDataCorrectoD').hide(20000,function() {
				});
				 
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		});
	});/* fin save docente */
	
	$('#buscarEdit').on("click",function() {
		
		var documento = $("#documentoB").val();
		if (documento == ''){
			alert("Debe digitar Usuario");
			return false;
		}
		$.ajax({
			dataType: 'html',
			type: 'POST',
			url: 'Controller.php',
			data: {
					documento: documento,
					action: 'busacarUsuario'
			},                
			success:function(data){
				if(data !== '1'){
					$("#idDataUsuario").html(data);
					if(data !== "<script> alert('El usuario digitado no es válido') ;</script>"){
						$("#guardarEdit").show();
						$("#vencimiento").show();
						capturar( );
					}
					
				}else{
					alert("No existen datos para mostrar");
					clearInputs();
				}
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		});
	});
	
	/* Guardar datos editados*/
	$('#guardarEdit').on("click",function() {
		var documento = $("#documentoB").val();
		var nombre = $("#nombres").val();
		var apellido = $("#apellidos").val();
		var usuario = $("#usuarioE").val();
		var codigoestadousuario = $("#codigoestadousuario").val();
		var rol = $("#rolD").val();
		var numerodocumento = $("#numerodocumento").val();
		
		var fechavencimientousuario = $('#fechavencimientousuario').val();
		var tipoUsuario = $('#tipoUsuario').val();
		if(codigoestadousuario == '200'){
			if(fechavencimientousuario == ''){
				alert("Debe digitar la fecha de vencimiento del usuario");
				$("#vencimiento").show();
				return false;
			}
			if(fechavencimientousuario == ''){
				alert("Debe digitar la fecha de vencimiento del usuario");
				$("#vencimiento").show();
				return false;
			}
			if (validarFecha(fechavencimientousuario) == false){
				alert("La fecha de vencimiento debe tener un formato válido Y-m-d");
				$("#vencimiento").show();
				return false;
			}
		}
		$("#idDataCorrectoUpdate").show();
		if (nombre == ''){
			alert("Debe digitar Nombre");
			return false;
		}
		if(soloLetras(nombre)== '1'){
			alert("El nombre digitado no es correcto");
			return false;
		}
		
		if (apellido == ''){
			alert("Debe digitar Apellido");
			return false;
		}
		if(soloLetras(apellido)== '1'){
			alert("El apellido digitado no es correcto");
			return false;
		}
		
		if (usuario == ''){
			alert("Debe digitar Usuario");
			return false;
		}
			/*	if(alfanumerico(usuario)== '2'){
			alert("El usuario digitado no es correcto3");
			return false;
		}*/
		if (codigoestadousuario == ''){
			alert("Debe seleccionar Estado");
			return false;
		}	
		if (numerodocumento == ''){
			alert("Debe sdigitar el número de documento");
			return false;
		}		
		if (confirm("La fecha es correcta?") == true) {			
		
			$.ajax({
				dataType: 'html',
				type: 'POST',
				url: 'Controller.php',
				data: {
						documento:documento,
						nombre: nombre,
						apellido: apellido,
						usuario : usuario,
						codigoestadousuario : codigoestadousuario,
						fechavencimientousuario:fechavencimientousuario,
						tipoUsuario : tipoUsuario,
						rol : rol,
						numerodocumento : numerodocumento,
						action: 'guardarEdit'
				},                
				success:function(data){
					$("#idDataCorrectoUpdate").html(data);
					 clearInputs();
					$('#idDataCorrectoUpdate').hide(20000,function() {
					});
					 
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
			});
		}
	});
	}
});
function clearInputs(){
$("#documento").val('');
$("#documentoB").val('');
$("#nombre").val('');
$("#apellido").val('');
$("#usuario").val('');
$("#usuarioE").val('');
$("#rol").val('');
$("#numerodocumento").val('');
$("#nombres").val('');
$("#apellidos").val('');
$("#codigoestadousuario").val('');
$("#documentoD").val('');
$("#nombreD").val('');
$("#apellidoD").val('');
$("#usuarioD").val('');
$("#fechavencimientousuario").val('');
$("#TipoUsuario").val('');
}
/* funciones varias*/
function capturar( ){
		var fechaVencimiento2 = $("#fechavencimientousuario2").val( );
		$("#fechavencimientousuario").val(fechaVencimiento2);
		$("#fechavencimientousuario2").empty( );
	}
function validarEmail( email ) {
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) )
        alert("Error: La dirección de correo " + email + " es incorrecta.");
}
function soloLetras(e){
	var filter6 = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]*$/;
	if (!filter6.test(e.replace(/\s/g, ''))){
		return 1;
	}
}

function alfanumerico(val){
	var regex=/^[0-9A-Za-z]+$/;
	if(regex.test(val)){
		return true;
	} 
	else {
		return 2;
	}
}
function validarFecha(dateString)
  {
         // First check for the pattern
		if(!/^\d{4}\-\d{1,2}\-\d{1,2}$/.test(dateString))
			return false;

		// Parse the date parts to integers
		var parts = dateString.split("-");
		var day = parseInt(parts[2], 10);
		var month = parseInt(parts[1], 10);
		var year = parseInt(parts[0], 10);
		//alert("dia "+day + " mes " + month + " año "+ year);

		// Check the ranges of month and year
		if(year < 1000 || year > 3000 || month == 0 || month > 12)
			return false;

		var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

		// Adjust for leap years
		if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
			monthLength[1] = 29;

		// Check the range of the day
		return day > 0 && day <= monthLength[month - 1];  
  }