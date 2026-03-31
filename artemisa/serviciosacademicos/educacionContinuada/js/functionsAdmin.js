/*Cargar Datos*/
$(function() {
   var esAdmin = $("#admin").val();
	$.ajax({
		dataType: 'html',
		type: 'POST',
		url: 'Controller.php',
		data: {
				action: 'consultaData',
				esAdmin: esAdmin
		},                
		success:function(data){
			$("#idData").html(data);
		},
		error: function(data,error,errorThrown){alert(error + errorThrown);}
	});

});

/*Eliminar Estudiante*/
function deletePermiso(id){
		$.ajax({
            type: 'POST',
            url: 'Controller.php',
            data: {'action':'deletePermiso','idEstudiante':id,'esAdmin':'1'},
            success: function() {			
				$('#delete-ok').empty();
				$('#delete-ok').append('<div class="correcto">Se ha eliminado correctamente </div>').fadeIn("slow");
				$('#'+id).fadeOut("slow");
				$.ajax({
					dataType: 'html',
					type: 'POST',
					url: 'Controller.php',
					data: {
							action: 'consultaData',
							esAdmin:'1'
					},                
					success:function(data){
						$("#idData").html(data);
						 setTimeout(function() {
										$(".correcto").fadeOut(1500);
									},2000);
					},
					error: function(data,error,errorThrown){alert(error + errorThrown);}
				});
            }
        });
}
/*PopUP*/	
$(document).ready(function(){
	$('#insertEstudiante').hide(); //oculto mediante id
	$('#vacio').hide(); //oculto mediante id
	$('#correcto').hide(); //oculto mediante id
  $('#crearEstudiante').click(function(){
		$('#correcto').hide(); //oculto mediante id
		$('#insertEstudiante').hide(); //oculto mediante id
		$('#idDataEstudiante').hide(); //oculto mediante id
		$('#popup').fadeIn('slow');
		$('.popup-overlay').fadeIn('slow');
		$('.popup-overlay').height($(window).height());
		return false;
	});
	
	$('#close').click(function(){
		$('#popup').fadeOut('slow');
		$('.popup-overlay').fadeOut('slow');
		var esAdmin = '1';
		$.ajax({
			dataType: 'html',
			type: 'POST',
			url: 'Controller.php',
			data: {
					action: 'consultaData',
					esAdmin: esAdmin
			},                
			success:function(data){
				$("#idData").html(data);
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		});
		return false;
	});
	$('#consultarEstudiante').click(function(){
		$('#idDataEstudiante').hide(); //muestro mediante id
		var documento = $("#documento").val();
		if(documento == ''){
			alert('Debe digitar documento');return false;
		}
		$.ajax({
			dataType: 'html',
			type: 'POST',
			url: 'Controller.php',
			data: {
					action: 'ConsultarEstudiante',
					esAdmin: '1',
					documento : documento
			},                
			success:function(data){
				if(data !== ''){
					$("#idDataEstudiante").html(data);
					$('#insertEstudiante').show(); //muestro mediante id
					$('#idDataEstudiante').show(); //muestro mediante id
					$('#vacio').hide(); //muestro mediante id
				}else{
					$('#vacio').show(); //muestro mediante id
					$('#idDataEstudiante').hide(); //muestro mediante id
					$('#insertEstudiante').hide(); //oculto mediante id
				}
			},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		});
	});
	$('#insertEstudiante').click(function(){
		var documento = $("#documento").val();
		$.ajax({
			dataType: 'html',
			type: 'POST',
			url: 'Controller.php',
			data: {
					action: 'guardarEstudiante',
					esAdmin: '1',
					documento : documento
			},                
			success:function(data){
				$('#correcto').show();
					setTimeout(function() {
										$("#correcto").fadeOut(1500);
									},2000);				
				},
			error: function(data,error,errorThrown){alert(error + errorThrown);}
		});
	});
});