/*Traer datos del modulo seleccionado*/
$(document).ready(function(){
	$("#dataModulos").change(function() {	
	var dataModulos = $("#dataModulos").val();
	var idRol = $("#id_Usuario").val();
	var UsuarioData = $("#RolData").val();
	if(UsuarioData == ''){
		alert("Debe digitar Rol para agregar permisos");
		return false;
	}
		
	  $.ajax({
            dataType: 'html',
            type: 'POST',
            url: '../interfaz/funcionesPermisos.php',
            data: {'action':'dataPermisosModulos','dataModulos':dataModulos,'idRol':idRol},
            success:function(data){
					$("#DIV_DataPermisos").html(data);
            },
            error: function(data,error){ alert("Ocurrio un error en la consulta");}
        }); 
	});
/*Guardar Permiso*/	
	$( "#adicionar" ).click(function() {
		var dataModulo = $("#dataModulos").val();
		var UsuarioData = $("#RolData").val();
		var idRol = $("#id_Usuario").val();
		var permisos = [];
		 $('input.permiso').each( function() {
                                if($(this).attr('checked')) {
                                        permisos.push($(this).attr('rel'));
                                }
                        } );
		
		if(dataModulo == ''){
			alert("Debe seleccionar un Modulo");
			return false;
		}
		if(UsuarioData == ''){
			alert("Debe digitar el nombre de un Rol");
			return false;
		}
		if(permisos == ''){
			alert("Debe agregarle permisos al rol");
			return false;
		}
		if(idRol == ''){
			idRol = UsuarioData;
			if(idRol == ''){
				alert("Debe digitar el nombre de un Rol");
			return false;	
			}
		}
	  	$.ajax({
            dataType: 'json',
            type: 'POST',
            url: '../interfaz/funcionesPermisos.php',
            data: {'action':'guardarPermisosModulos','dataModulos':dataModulo,'UsuarioData':UsuarioData, 'permiso': permisos},
            success:function(data){
					$.ajax({
					
						type: 'POST',
						url: '../interfaz/funcionesPermisos.php',
						data: {'action':'consultaPermisosActuales','UsuarioData':UsuarioData},
						success:function(data){
								$("#DIV_DataActuales").html(data);
								alert("Permisos Agregados Correctamente");
								$.ajax({
									dataType: 'html',
									type: 'POST',
									url: '../interfaz/funcionesPermisos.php',
									data: {'action':'dataPermisosModulos','dataModulos':dataModulo,'idRol':idRol},
									success:function(data){
											$("#DIV_DataPermisos").html(data);
															$.ajax({
																	type: 'POST',
																	url: '../interfaz/funcionesPermisos.php',
																	data: {'action':'consultaPermisosActuales','UsuarioData':UsuarioData},
																	success:function(data){
																			$("#DIV_DataActuales").html(data);
																	},
																	error: function(data,error){ alert("Ocurrio un error en la consulta");}
																});
									},
									error: function(data,error){ alert("Ocurrio un error en la consulta");}
								}); 
						},
						error: function(data,error){ alert("Ocurrio un error en la consulta");}
					});							
					
            },
            error: function(data,error){ alert("Ocurrio un error en la consulta");}
        }); 
	});
	/*Limpiar permisos actuales, cada que se cambie de rol*/
	 $('#RolData').keyup(function () { limpiar(); });
/*Auto Cargar Roles Existentes*/
    $('#RolData').autocomplete({
			source: "../interfaz/funcionesPermisos.php?action=AutocompleteRol",
			minLength: 3,
			select: function( event, ui ) {
				$('#id_Usuario').val(ui.item.id_Usuario);
				var UsuarioData = $("#id_Usuario").val();
				$( "#DIV_DataPermisos" ).empty();
				$.ajax({
						type: 'POST',
						url: '../interfaz/funcionesPermisos.php',
						data: {'action':'consultaPermisosActuales','UsuarioData':UsuarioData},
						success:function(data){
								$("#DIV_DataActuales").html(data);
								$("select#dataModulos").val(" ");
						},
						error: function(data,error){ alert("Ocurrio un error en la consulta");}
					});
			}
			
		});
});
function deletePermiso(id){
		var UsuarioData = $("#id_Usuario").val();
		var dataModulo = $("#dataModulos").val();
		
		if(UsuarioData == ''){
			UsuarioData = $("#RolData").val();
		}
		$.ajax({
            type: 'POST',
            url: '../interfaz/funcionesPermisos.php',
            data: {'action':'deletePermiso','idPermiso':id},
            success: function() {			
				$('#delete-ok').empty();
				$('#delete-ok').append('<div class="correcto">Se ha eliminado correctamente el permiso .</div>').fadeIn("slow");
				$('#'+id).fadeOut("slow");
				$.ajax({
						type: 'POST',
						url: '../interfaz/funcionesPermisos.php',
						data: {'action':'consultaPermisosActuales','UsuarioData':UsuarioData},
						success:function(data){
								$("#DIV_DataActuales").html(data);
								   setTimeout(function() {
										$(".correcto").fadeOut(1500);
									},2000);
						},
						error: function(data,error){ alert("Ocurrio un error en la consulta");}
					});
					$.ajax({
						dataType: 'html',
						type: 'POST',
						url: '../interfaz/funcionesPermisos.php',
						data: {'action':'dataPermisosModulos','dataModulos':dataModulo,'idRol':UsuarioData},
						success:function(data){
								$("#DIV_DataPermisos").html(data);
						},
						error: function(data,error){ alert("Ocurrio un error en la consulta");}
					}); 
				
            }
        });
}
function limpiar(){
	$("select#dataModulos").val(" ");
	$( "#DIV_DataPermisos" ).empty();
	$("#DIV_DataActuales").empty();

}


 