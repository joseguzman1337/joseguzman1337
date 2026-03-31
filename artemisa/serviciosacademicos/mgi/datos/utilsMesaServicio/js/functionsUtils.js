$(document).ready(function()
{
	$("#guardar").hide();
	$("#correo").hide();
	$('#buscar').on("click",function() {
		var documento = $("#documento").val();
		/*if (documento == ''){
			alert("Debe digitar documento");
			return false;
		}*/
		$.ajax({
			dataType: 'html',
			type: 'POST',
			url: 'Controller.php',
			data: {
					documento: documento,
					action: 'consultaEstudiante'
			},                
			success:function(data){
				
				if(data == ''){
					$("#guardar").hide();
					$("#correo").show();
				}else{
					$("#idData").html(data);
					$("#guardar").show();
					$("#enviarCorreo").hide();
					
				}
				
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		});
	});
	$('#guardar').on("click",function() {
		
		var email = $("#email").val();
		validarEmail(email);
		var documento = $("#documento").val();
		var claveTemporal = $("#claveTemporal").val();
		$.ajax({
			dataType: 'html',
			type: 'POST',
			url: 'Controller.php',
			data: {
					email: email,
					documento: documento,
					claveTemporal,claveTemporal,
					action: 'actualizarEstudiante'
			},                
			success:function(data){
				$("#idDataCorrecto").html(data);
						alert("Se cambio la clave temporal exitosamente") ; 
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		});
	}); 	
	$('#enviarCorreo').on("click",function() {
		
		var correo = $("#correoEnviar").val();
		validarEmail(correo);
		$.ajax({
			dataType: 'html',
			type: 'POST',
			url: 'Controller.php',
			data: {
					correo: correo,
					action: 'enviarCorreo'
			},                
			success:function(data){
				$("#idDataCorrecto").html(data);
						alert("Se envio un E-mail al correo descrito.");
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		});
	});
});

function validarEmail( email ) {
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !expr.test(email) )
        alert("Error: La dirección de correo " + email + " es incorrecta.");
}