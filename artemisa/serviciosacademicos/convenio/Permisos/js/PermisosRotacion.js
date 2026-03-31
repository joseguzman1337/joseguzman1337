function AutoCompleteUser(){
    /*************************************************/
    $('#BuscarUser').autocomplete({
					
			source: "../../../EspacioFisico/Permisos/PermisosEspacioFisico_html.php?actionID=AutocompleteUsuario",
			minLength: 3,
			select: function( event, ui ) {
				$('#BuscarUser_id').val(ui.item.id_Usuario);
                 BuscarInformacion(ui.item.id_Usuario);
                }
			
		});
    /*************************************************/
}//function AutoCompleteUser
function FormatUser(){
    /******************************************/
    $('#BuscarUser').val('');
    $('#BuscarUser_id').val('');
    $('.ModulosClass').attr('checked',false);
    $('#Rol').val('-1');
    /******************************************/
}//function FormatUser
function NewRolModuloConvenio(){
    var user = $('#BuscarUser_id').val();
    var rol  = $('#Rol').val();    
    
    if(!$.trim(user)){
        alert('Indique un Usuario del Sistema...!!!');
        return false;
    }
    
    if(rol==-1 || rol=='-1'){
        alert('Selecione un Rol...!!!');
        return false;
    }
   
    $('#actionID').val('NewRolModulos');
    
    $.ajax({//Ajax
		  type: 'POST',
		  url: '../control/PermisosRotacion_html.php',
		  async: false,
		  dataType: 'json',
		  data:$('#FromRolModuloConvenio').serialize(),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		       if(data.val==false){
		          alert(data.descrip);
                  return false;
		       }else{
		          alert(data.descrip);
                  location.href='../control/PermisosRotacion_html.php';
		       }
               
			}//data 
	  }); //AJAX
}//function NewRolModuloConvenio
function BuscarInformacion(User){
    $.ajax({//Ajax
		  type: 'POST',
		  url: '../control/PermisosRotacion_html.php',
		  async: false,
		  dataType: 'html',
		  data:({actionID: 'BuscarInfo',id:User}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		        $('#TD_Rol').html(data);
			}//data 
	  }); //AJAX
     /****************************************/
     $.ajax({//Ajax
		  type: 'POST',
		  url: '../control/PermisosRotacion_html.php',
		  async: false,
		  dataType: 'html',
		  data:({actionID: 'BuscarInfo2',id:User}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		        $('#TD_Modulos').html(data);
			}//data 
	  }); //AJAX 
}//function BuscarInformacion
function ModuloRoles(id){
    $.ajax({//Ajax
		  type: 'POST',
		  url: '../control/PermisosRotacion_html.php',
		  async: false,
		  dataType: 'html',
		  data:({actionID: 'ModulosActivar',id:id}),
		  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
		  success: function(data){
		        $('#TD_Modulos').html(data);
			}//data 
	  }); //AJAX 
}//function ModuloRoles