function BuscarModulos(){
    /***********************************/
    
    var Categoria = $('#Rol').val();
    
    if(Categoria=='-1' || Categoria==-1){
        /*********************************/
        alert('Selecione una Categoria');
        $('#Categoria').effect("pulsate", {times:3}, 500);
        $('#Categoria').css('border-color','#F00');
        return false;
        /*********************************/
    }
	 /*************************************/
    $.ajax({//Ajax
		  type: 'POST',
		  url: 'Consola_Permisos.html.php',
		  async: false,
		  dataType: 'json',
		  data:({actionID: 'PermisosUsuariosRol',id_Rol:Categoria}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		       //console.log(data);
               $('#PermisosCargados').val(data);
               
			}//data 
	  }); //AJAX
      
    var PermisosCargados = $('#PermisosCargados').val();
    
    $.ajax({//Ajax
		  type: 'POST',
		  url: 'Consola_Permisos.html.php',
		  async: false,
		  dataType: 'html',
		  data:({actionID: 'CargarPermisos',PermisosCargados:PermisosCargados,id_Usuario:Categoria}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		        $('#Categoria').val('-1');
                $('#Modulo').val('-1');
                $('#Editar').attr('checked',false);
                $('#Ver').attr('checked',false);
                $('#Eliminar').attr('checked',false);
                $('#Consultar').attr('checked',false);
                /*********************************/
				$('#DIV_DataPermisos').html(data);
			}//data 
	  }); //AJAX
    /*************************************/
    /*$.ajax({//Ajax
			  type: 'POST',
			  url: 'Consola_Permisos.html.php',
			  async: false,
			  dataType: 'html',
			  data:({actionID: 'BuscarModulos',Categoria:Categoria}),
			  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			  success: function(data){
					$('#Th_Modulo').html(data);
				}//data 
		  }); //AJAX*/
    /***********************************/
}/*BuscarModulos*/
function LoadPermiso(){
    /****************************/
    
    var id_Usuario = $('#id_Usuario').val();

    var  usuarioSession = $('#idUsuarioSe').val();
	
    if(!$.trim(id_Usuario)){
        /*********************************/
        alert('Digite la Busqueda del usuario...!');
        $('#UsuarioData').effect("pulsate", {times:3}, 500);
        $('#UsuarioData').css('border-color','#F00');
        return false;
        /*********************************/
    } 
    
    var Categoria = $('#Rol').val();
    
    if(Categoria=='-1' || Categoria==-1){
        /*********************************/
        alert('Selecione un Rol');
        $('#Modulo').val('-1');
        $('#Categoria').effect("pulsate", {times:3}, 500);
        $('#Categoria').css('border-color','#F00');
        return false;
        /*********************************/
    }//if
    
    var Modulo = $('#Modulo').val();
    
    if(Modulo=='-1' || Modulo==-1){
        /*********************************/
        alert('Selecione un Rol');
        $('#Modulo').effect("pulsate", {times:3}, 500);
        $('#Modulo').css('border-color','#F00');
        return false;
        /*********************************/
    }//if
    
   // if($('#Editar').is(':checked')===false && $('#Ver').is(':checked')===false && $('#Eliminar').is(':checked')===false && $('#Consultar').is(':checked')===false){
        /***************************************/
        /*alert('Selecione una de los Tipos de Permisos. \n Editar \n Ver \n Eliminar \n Consultar');
        $('#Editar').effect("pulsate", {times:3}, 500);
        $('#Editar').css('border-color','#F00');*/
        /***************************************/
        /*$('#Ver').effect("pulsate", {times:3}, 500);
        $('#Ver').css('border-color','#F00');*/
        /***************************************/
        /*$('#Eliminar').effect("pulsate", {times:3}, 500);
        $('#Eliminar').css('border-color','#F00');*/
        /***************************************/
        /*$('#Consultar').effect("pulsate", {times:3}, 500);
        $('#Consultar').css('border-color','#F00');*/
        /***************************************/
      //  return false;
        /***************************************/

    //}//if
    
    /*if($('#Editar').is(':checked')){
       var Editar = 1; 
    }else{
        var Editar = 0;
    }
    if($('#Ver').is(':checked')){
        var Ver = 1;
    }else{
        var Ver = 0;
    }
    if($('#Eliminar').is(':checked')){
        var Eliminar = 1;
    }else{
        var Eliminar = 0;
    }
    if($('#Consultar').is(':checked')){
        var Consultar = 1;
    }else{
        var Consultar = 0;

    }*/
    
   /* var Permisos = Editar+'-'+Ver+'-'+Eliminar+'-'+Consultar;
    
    var Valida = Categoria+'-'+Modulo+'-'+Permisos;*/
    
    /****************************************************/
    

  /*  var PermisosCargados = $('#PermisosCargados').val();
    
    var C_Permiso = PermisosCargados.split("::");
    
    //console.log(C_Permiso);
    
    var num = C_Permiso.length;
    
    for(i=0;i<num;i++){*/
        /*************************/
       // var C_Data = C_Permiso[i].split('-');
        
        //console.log(C_Data);
        
       // var Num2 = C_Data.length;
        
            /****************************/
         //   if(C_Data[0]==Categoria){
                /************************/
             /*   if(C_Data[1]==Modulo){
                    alert('El Usuario ya tiene Permisos para este Modulo.');
                    return false;

                }*/
                /************************/

         //   }//ir
            /****************************/
            
        /*************************/
   // }/*for*/
    
    
    /*******************************************************/
    
   // $('#PermisosCargados').val($('#PermisosCargados').val()+'::'+Categoria+'-'+Modulo+'-'+Permisos);
    
    var PermisosCargados = $('#PermisosCargados').val();

    
    $.ajax({//Ajax
		  type: 'POST',
		  url: 'Consola_Permisos.html.php',
		  async: false,
		  dataType: 'html',
		  data:({actionID: 'InsertRolUsuario',PermisosCargados:PermisosCargados,id_Usuario:id_Usuario,usuarioSession:usuarioSession,Rol:Categoria}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		       /*********************************/
			   if(data == ''){
				   alert("El usuario ya tiene asignado el rol seleccionado");
			   }else{
					alert("Se agrego el Rol al Usuario correctamente");
					/*************************************/
				$.ajax({//Ajax
					  type: 'POST',
					  url: 'Consola_Permisos.html.php',
					  async: false,
					  dataType: 'json',
					  data:({actionID: 'PermisosUsuarios',id_Usuario:id_Usuario,Rol:Categoria}),
					  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					  success: function(data){
						   //console.log(data);
						   $('#PermisosCargados').val(data);
						   
						}//data 
				  }); //AJAX
				  
				   var PermisosCargados = $('#PermisosCargados').val();
    
				$.ajax({//Ajax
					  type: 'POST',
					  url: 'Consola_Permisos.html.php',
					  async: false,
					  dataType: 'html',
					  data:({actionID: 'CargarPermisos',PermisosCargados:PermisosCargados,id_Usuario:id_Usuario,Rol:1}),
					  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					  success: function(data){
							$('#Categoria').val('-1');
							$('#Modulo').val('-1');
							$('#Editar').attr('checked',false);
							$('#Ver').attr('checked',false);
							$('#Eliminar').attr('checked',false);
							$('#Consultar').attr('checked',false);
							/*********************************/
							$('#DIV_DataPermisos').html(data);
						}//data 
				  }); //AJAX
			   }
			}//data 
	  }); //AJAX
      
    /****************************/
}/*function LoadPermiso*/
function EliminarPermiso(Data){
    /******************************************/
    
    if(confirm('Seguro desea Eliminar Este Permiso...?')){
    
    var PermisosCargados = $('#PermisosCargados').val();
    
    var Cambiar = '::'+Data;
    
    var id_Usuario = $('#id_Usuario').val();
    /******************************************************/
    $.ajax({//Ajax
		  type: 'POST',
		  url: 'Consola_Permisos.html.php',
		  async: false,
		  dataType: 'json',
		  data:({actionID: 'EliminarPermiso',id_Usuario:id_Usuario,Data:Data}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		       if(data.val=='FALSE'){
		          alert(data.descrip);
                  return false;
		       }
               
			}//data 
	  }); //AJAX
    /******************************************************/
    
    var DelectePermiso = PermisosCargados.replace(Cambiar,'');
    
    $('#PermisosCargados').val('');
    
    $('#PermisosCargados').val(DelectePermiso);
    
    
    
    var PermisosCargados = $('#PermisosCargados').val();
    
    $.ajax({//Ajax
		  type: 'POST',
		  url: 'Consola_Permisos.html.php',
		  async: false,
		  dataType: 'html',
		  data:({actionID: 'CargarPermisos',PermisosCargados:PermisosCargados}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		        $('#Categoria').val('-1');
                $('#Modulo').val('-1');
                $('#Editar').attr('checked',false);
                $('#Ver').attr('checked',false);
                $('#Eliminar').attr('checked',false);
                $('#Consultar').attr('checked',false);
                /*********************************/
				$('#DIV_DataPermisos').html(data);
			}//data 
	  }); //AJAX
   
   }//if confirm
    /******************************************/
}/*function EliminarPermiso*/
function AutocompleteUsuario(){
    /******************************************/
	
	$('#UsuarioData').autocomplete({

			
		source: "Consola_Permisos.html.php?actionID=AutocompleteUsuario",
		minLength: 3,
		select: function( event, ui ) {
			$('#id_Usuario').val(ui.item.id_Usuario);
			
			$('#Tr_Titulo').css('visibility','visible');
			$('#Tr_Detalle').css('visibility','visible');
			
			$('#Td_Nombre').html(ui.item.Nombre);
			$('#Td_Documento').html(ui.item.NumeroDocumento);
			$('#Td_Usuario').html(ui.item.Usuario);
			
			CargarInfo(ui.item.id_Usuario);
			}
	});	
		
    /******************************************/
}/*function AutocompleteUsuario*/
function CargarInfo(id_Usuario,Rol){
	var Rol=1;
    /*************************************/
    $.ajax({//Ajax
		  type: 'POST',
		  url: 'Consola_Permisos.html.php',
		  async: false,
		  dataType: 'json',
		  data:({actionID: 'PermisosUsuarios',id_Usuario:id_Usuario,Rol:Rol}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		       //console.log(data);
               $('#PermisosCargados').val(data);
               
			}//data 
	  }); //AJAX
      
    var PermisosCargados = $('#PermisosCargados').val();
    
    $.ajax({//Ajax
		  type: 'POST',
		  url: 'Consola_Permisos.html.php',
		  async: false,
		  dataType: 'html',
		  data:({actionID: 'CargarPermisos',PermisosCargados:PermisosCargados,id_Usuario:id_Usuario,Rol:Rol}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		        $('#Categoria').val('-1');
                $('#Modulo').val('-1');
                $('#Editar').attr('checked',false);
                $('#Ver').attr('checked',false);
                $('#Eliminar').attr('checked',false);
                $('#Consultar').attr('checked',false);
                /*********************************/
				$('#DIV_DataPermisos').html(data);
			}//data 
	  }); //AJAX
    /*************************************/
}/*function CargarInfo*/
function Format(){
    /****************************/
    $('#UsuarioData').val('');
    $('#id_Usuario').val('');
    
    $('#Tr_Titulo').css('visibility','collapse');
    $('#Tr_Detalle').css('visibility','collapse');
    
    $('#Td_Nombre').html('');
    $('#Td_Documento').html('');
    $('#Td_Usuario').html('');
    
     $('#PermisosCargados').val('');
     
     $('#DIV_DataPermisos').html('');
    /****************************/
}/*function Format*/
function FormatDocente(){
    /***************************************/
    $('#Docente').val('');
    $('#id_Docente').val('');
    
    $('#id_Carrera').val('-1');
    $('#DIV_AsignacionCarrera').html('<br /><span style="color: silver;text-align: center;">No hay Informaci&oacute;n...</span><br />');
    /***************************************/
}//function FormatDocente
function AutocompleteDocente(){
    /******************************************/
    $('#Docente').autocomplete({
					
			source: "AsignarCarrera.html.php?actionID=AutocompleteDocente",
			minLength: 3,
			select: function( event, ui ) {
				
                $('#id_Docente').val(ui.item.id_iddocente);
                BuscarDataAsigancionCarrera(ui.item.id_iddocente);
                
                }
		});
    /******************************************/
}/*function AutocompleteDocente*/
function SaveAsignar(){
    /********************************************/
    var id_Docente  = $('#id_Docente').val();
    var id_Carrera  = $('#id_Carrera').val();
    
    if(!$.trim(id_Docente)){
        alert('Debe Buscar un Docente.');
        $('#Docente').effect("pulsate", {times:3}, 500);
        $('#Docente').css('border-color','#F00');
        return false;
    }
    
    if(id_Carrera==-1 || id_Carrera=='-1'){
        alert('Debe Selecionar un Programa Academico.');
        $('#id_Carrera').effect("pulsate", {times:3}, 500);
        $('#id_Carrera').css('border-color','#F00');
        return false;
    }
    /********************************************/
    $.ajax({//Ajax
		  type: 'GET',
		  url: 'AsignarCarrera.html.php',
		  async: false,
		  dataType: 'json',
		  data:({actionID: 'SaveDocenteCarrera',id_Docente:id_Docente,id_Carrera:id_Carrera}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		        if(data.val=='FALSE'){
		           alert(data.descrip);
                   return false;
		        }else{
		           alert(data.descrip);
                   BuscarDataAsigancionCarrera(id_Docente);
		        }
			}//data 
	  }); //AJAX
    /********************************************/
}//function SaveAsignar
function BuscarDataAsigancionCarrera(id_Docente){
    /*************************************************/
    $.ajax({//Ajax
		  type: 'GET',
		  url: 'AsignarCarrera.html.php',
		  async: false,
		  dataType: 'html',
		  data:({actionID: 'BuscarDataASigancion',id_Docente:id_Docente}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		        $('#DIV_AsignacionCarrera').html(data);
			}//data 
	  }); //AJAX
    /*************************************************/
}//function BuscarDataAsigancionCarrera
function EliminarAsinacion(id){
    /**********************************************/
    var id_Docente  = $('#id_Docente').val();
    var CodPeriodo  = $('#codigoperiodoinicial').val();    
	
    $.ajax({//Ajax
		  type: 'GET',
		  url: 'AsignarCarrera.html.php',
		  async: false,
		  dataType: 'json',
		  data:({actionID: 'EliminarAsignacion',id:id,codigoperiodo:CodPeriodo}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		       if(data.val=='FALSE'){
		          alert(data.descrip);
                  return false;
		       }else{
		          alert(data.descrip);
                  BuscarDataAsigancionCarrera(id_Docente);
		       }
			}//data 
	  }); //AJAX
    /**********************************************/
}//function EliminarAsinacion

function deletePermisoRol(rol){
	if(confirm('Seguro desea Eliminar Este Rol...?')){
    var id_Usuario = $('#id_Usuario').val();
    /******************************************************/
    $.ajax({//Ajax
		  type: 'POST',
		  url: 'Consola_Permisos.html.php',
		  async: false,
		  dataType: 'json',
		  data:({actionID: 'EliminarRol',id_Usuario:id_Usuario,rol:rol}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		       if(data.val=='FALSE'){
		          alert(data.descrip);
                  return false;
		       }else{
				   alert(data.descrip);
				   var Rol=1;
				/*************************************/
				$.ajax({//Ajax
					  type: 'POST',
					  url: 'Consola_Permisos.html.php',
					  async: false,
					  dataType: 'json',
					  data:({actionID: 'PermisosUsuarios',id_Usuario:id_Usuario,Rol:Rol}),
					  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					  success: function(data){
						   //console.log(data);
						   $('#PermisosCargados').val(data);
						   
						}//data 
				  }); //AJAX
				  
				   var PermisosCargados = $('#PermisosCargados').val();
    
				$.ajax({//Ajax
					  type: 'POST',
					  url: 'Consola_Permisos.html.php',
					  async: false,
					  dataType: 'html',
					  data:({actionID: 'CargarPermisos',PermisosCargados:PermisosCargados,id_Usuario:id_Usuario,Rol:Rol}),
					  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					  success: function(data){
							$('#Categoria').val('-1');
							$('#Modulo').val('-1');
							$('#Editar').attr('checked',false);
							$('#Ver').attr('checked',false);
							$('#Eliminar').attr('checked',false);
							$('#Consultar').attr('checked',false);
							/*********************************/
							$('#DIV_DataPermisos').html(data);
						}//data 
				  }); //AJAX
			   }
               
			}//data 
	  }); //AJAX
    /******************************************************/
    
   
   
   }//if confirm
    /******************************************/
}