function AutoCompleteUser(){
    /*************************************************/
    $('#BuscarUser').autocomplete({
					
			source: "PermisosEspacioFisico_html.php?actionID=AutocompleteUsuario",
			minLength: 3,
			select: function( event, ui ) {
				$('#BuscarUser_id').val(ui.item.id_Usuario);
                 BuscarPermisos(ui.item.id_Usuario);
                 BuscarRol(ui.item.id_Usuario);
                }
			
		});
    /*************************************************/
}//function AutoCompleteUser
function FormatUser(){
    /******************************************/
    $('#BuscarUser').val('');
    $('#BuscarUser_id').val('');
    $('.PermisoCheck').attr('checked',false);
    $('#RolPermiso').val('0');
    /******************************************/
}//function FormatUser
function AutoCompleteUserName(){
    /*************************************************/
    $('#BuscarUserName').autocomplete({
					
			source: "PermisosEspacioFisico_html.php?actionID=AutocompleteUsuario",
			minLength: 3,
			select: function( event, ui ) {
				$('#BuscarUserName_id').val(ui.item.id_Usuario);
                 VerEspaciosAsignados(ui.item.id_Usuario);                 
                }
			
		});
    /*************************************************/
}//function AutoCompleteUserName
function FormatUserName(){
     /******************************************/
    $('#BuscarUserName').val('');
    $('#BuscarUserName_id').val('');
    $('#Espacio').val('-1');
    $('#TipoAula').val('-1');
    $('#VerUserEspacio').html('');
    /******************************************/
}//function FormatUserName
function GuardarPeriso(){
    /************************************************/
    $('#actionID').val('PermisoRolEspacioFisico');
    
    $.ajax({//Ajax
		  type: 'POST',
		  url: 'PermisosEspacioFisico_html.php',
		  async: false,
		  dataType: 'json',
		  data:$('#FromRolEspacioFisico').serialize(),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		       if(data.val==false){
		          alert(data.descrip);
                  return false;
		       }else{
		          alert(data.descrip);
                  location.href='PermisosEspacioFisico_html.php';
		       }
               
			}//data 
	  }); //AJAX
    /************************************************/
}//function SavePermisoRol
function BuscarPermisos(id){
    /**********************************************/
     $.ajax({//Ajax
		  type: 'POST',
		  url: 'PermisosEspacioFisico_html.php',
		  async: false,
		  dataType: 'html',
		  data:({actionID: 'BuscarPermisos',id:id}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		        $('#CargaModulos').html(data);
			}//data 
	  }); //AJAX
    /**********************************************/
}//function BuscarPermisos
function BuscarRol(id){
    /**********************************************/
     $.ajax({//Ajax
		  type: 'POST',
		  url: 'PermisosEspacioFisico_html.php',
		  async: false,
		  dataType: 'html',
		  data:({actionID: 'BuscarRol',id:id}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		        $('#CargaRol').html(data);
			}//data 
	  }); //AJAX
    /**********************************************/
}//function BuscarRol
function CambioCheck(i,id,Modulo=''){
    /********************************************/
    if($('#Permiso_'+i).is(':checked')){
        var caso = 100;
    }else{
        var caso = 200;
    }
    
    var UsuarioId = $('#BuscarUser_id').val();
    var RolPermiso = $('#RolPermiso').val();
    /********************************************/
    $.ajax({//Ajax
		  type: 'POST',
		  url: 'PermisosEspacioFisico_html.php',
		  async: false,
		  dataType: 'json',
		  data:({actionID: 'CheckCambio',
                 id:id,
                 caso:caso,
                 Modulo:Modulo,
                 UsuarioId:UsuarioId,
                 RolPermiso:RolPermiso}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		       if(data.val==false){
		          alert(data.descrip);
                  return false;
		       }
               
			}//data 
	  }); //AJAX
    /********************************************/
}//function CambioCheck
function VerEspaciosAsignados(id){
    /**********************************************************/
    $.ajax({//Ajax
		  type: 'POST',
		  url: 'PermisosEspacioFisico_html.php',
		  async: false,
		  dataType: 'html',
		  data:({actionID: 'VerEspaciosAsigandos',id:id}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		        $('#VerUserEspacio').html(data);
			}//data 
	  }); //AJAX
    /**********************************************************/
}//function VerEspaciosAsignados
function GuardarRespon(){
    /************************************************/
    
    var UserId =  $('#BuscarUserName_id').val();
    var Espacio = $('#Espacio').val();
    var TipoAula = $('#TipoAula').val();
     
     
   if(!$.trim(UserId)){
    $('#BuscarUserName').effect("pulsate", {times:3}, 500);
    $('#BuscarUserName').css('border-color','#F00');
    return false;
   }  
   
   if(Espacio==-1 || Espacio=='-1'){
    $('#Espacio').effect("pulsate", {times:3}, 500);
    $('#Espacio').css('border-color','#F00');
    return false;
   }
   
   if(TipoAula==-1 || TipoAula=='-1'){
    $('#TipoAula').effect("pulsate", {times:3}, 500);
    $('#TipoAula').css('border-color','#F00');
    return false;
   }
   
    
    $.ajax({//Ajax
		  type: 'POST',
		  url: 'PermisosEspacioFisico_html.php',
		  async: false,
		  dataType: 'json',
		  data:({actionID: 'SaveResponsable',UserId:UserId,Espacio:Espacio,TipoAula:TipoAula}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		       if(data.val==false){
		          alert(data.descrip);
                  return false;
		       }else{
		          alert(data.descrip);
                  VerEspaciosAsignados(UserId);
		       }
               
			}//data 
	  }); //AJAX
    /************************************************/
}//function GuardarRespon
function ValidarExite(id,User,indi,Espacio){  
   /************************************************/ 
    $.ajax({//Ajax
		  type: 'POST',
		  url: 'PermisosEspacioFisico_html.php',
		  async: false,
		  dataType: 'json',
		  data:({actionID: 'ValidaExite',id:id,User:User,Espacio:Espacio}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		       if(data.val==false){
		          VerEspaciosAsignados(User);
		       }else{
		          if(confirm('Desea Modificar la Responsabilidad sobre el Espacio Fisico...?')){
		              UpdateResponsabilidad(id,User,indi,Espacio);
		          }else{
		              VerEspaciosAsignados(User);
		          }		          
		       }
               
			}//data 
	  }); //AJAX
     /************************************************/ 
}//function ValidarExite
function EliminarResponsabilidad(Espacio,User,id,TipoAula){
    if(confirm('Desea Eliminar la Responsabilidad sobre el Espacio Fisico...?')){
        
       /************************************************/ 
        $.ajax({//Ajax
    		  type: 'POST',
    		  url: 'PermisosEspacioFisico_html.php',
    		  async: false,
    		  dataType: 'json',
    		  data:({actionID: 'EliminarRespo',id:id,User:User,Espacio:Espacio,TipoAula:TipoAula}),
    		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    		  success: function(data){
    		     if(data.val==false){
    		          alert(data.descrip);
                      return false;
    		       }else{
    		          alert(data.descrip);
                      VerEspaciosAsignados(User);
    		       }
                   
    			}//data 
    	  }); //AJAX
         /************************************************/  
    }
}//function EliminarResponsabilidad
function UpdateResponsabilidad(TipoAula,User,id,Espacio){
       
       /************************************************/ 
        $.ajax({//Ajax
    		  type: 'POST',
    		  url: 'PermisosEspacioFisico_html.php',
    		  async: false,
    		  dataType: 'json',
    		  data:({actionID: 'UpdateRespo',id:id,User:User,Espacio:Espacio,TipoAula:TipoAula}),
    		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    		  success: function(data){
    		     if(data.val==false){
    		          alert(data.descrip);
                      return false;
    		       }else{
    		          alert(data.descrip);
                      VerEspaciosAsignados(User);
    		       }
                   
    			}//data 
    	  }); //AJAX
         /************************************************/  
  
}//function EliminarResponsabilidad
function BuscarTipoAula(id){
    /************************************************/
    $.ajax({//Ajax
		  type: 'POST',
		  url: 'PermisosEspacioFisico_html.php',
		  async: false,
		  dataType: 'html',
		  data:({actionID: 'TipoAula',id:id}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		      $('#Div_TipoAula').html(data);
			}//data 
	  }); //AJAX
      /************************************************/
}//function BuscarTipoAula
function BuscarTipoAulaDetalle(id){
    /************************************************/
    $.ajax({//Ajax
		  type: 'POST',
		  url: 'OtrosPermisosEspacioFisico_html.php',
		  async: false,
		  dataType: 'html',
		  data:({actionID: 'TipoAulaDetalle',id:id}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		      $('#Div_TipoAula').html(data);
			}//data 
	  }); //AJAX
      /************************************************/
}//function BuscarTipoAulaDetalle
function BuscarEspcaioFisico(id){
    /************************************************/
    var Espacio = $('#Espacio').val();
    
    $.ajax({//Ajax
		  type: 'POST',
		  url: 'OtrosPermisosEspacioFisico_html.php',
		  async: false,
		  dataType: 'html',
		  data:({actionID: 'BuscarEspcaioFisico',id:id,Espacio:Espacio}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		      $('#Div_EspacioFisicoDetalle').html(data);
			}//data 
	  }); //AJAX
      /************************************************/
}//function BuscarEspcaioFisico
function SaveCalsificacion(){
   $('#actionID').val('SaveClasificacionEspacio');
    
    $.ajax({//Ajax
		  type: 'POST',
		  url: 'OtrosPermisosEspacioFisico_html.php',
		  async: false,
		  dataType: 'json',
		  data:$('#FromOtherPermiso').serialize(),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		       if(data.val==false){
    		          alert(data.descrip);
                      return false;
    		       }else{
    		          alert(data.descrip);
                      VerResponsabilidad(data.User_id);
                      $('#Espacio').val('-1');
                      $('#TipoAula').val('-1');
                      $('#ClasificacionEspacio').val('-1');
		       }               
			}//data 
	  }); //AJAX 
}//function SaveCalsificacion
function VerResponsabilidad(User){
    $.ajax({//Ajax
		  type: 'POST',
		  url: 'OtrosPermisosEspacioFisico_html.php',
		  async: false,
		  dataType: 'html',
		  data:({actionID: 'ResponClasificacionEspacio',User:User}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		      $('#VerClasificacionEspacio').html(data);
			}//data 
	  }); //AJAX
}//function VerResponsabilidad
function EliminarClasificacionResponsabilidad(User,id){
    $.ajax({//Ajax
		  type: 'POST',
		  url: 'OtrosPermisosEspacioFisico_html.php',
		  async: false,
		  dataType: 'html',
		  data:({actionID: 'EliminarClasificacion',User:User,id:id}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		     if(data.val==false){
    		          alert(data.descrip);
                      return false;
    		       }else{
    		          alert('Se ha Eliminado Correctamente.');
                      VerResponsabilidad(User);
                      $('#Espacio').val('-1');
                      $('#TipoAula').val('-1');
                      $('#ClasificacionEspacio').val('-1');
		       }    
			}//data 
	  }); //AJAX
}//function EliminarClasificacionResponsabilidad