function SaveSalon(){
    /**************************************/
    var T_Salon = $('#T_Salon').val();
    var EspacioFisico = $('#EspacioFisico').val();
    if(!$.trim(T_Salon)){
        /******************************************************/
        $('#T_Salon').effect("pulsate", {times:3}, 500);
        $('#T_Salon').css('border-color','#F00');
        return false;
        /******************************************************/ 
    }
    
    if(EspacioFisico==-1 || EspacioFisico=='-1'){
       $('#EspacioFisico').effect("pulsate", {times:3}, 500);
       $('#EspacioFisico').css('border-color','#F00');
        return false; 
    }
       $.ajax({//Ajax
              type: 'POST',
              url: '../Administradores/Admin_TipoSalon_html.php',
              async: false,
              dataType: 'json',
              data:({actionID: 'InsertSalon',T_Salon:T_Salon,EspacioFisico:EspacioFisico}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
              success: function(data){
                    if(data.val==false){
                        $("#msg-success").addClass('msg-error');
                        $("#msg-success").css('display','');
                        $("#msg-success").html('<p>' + data.descrip + '</p>');
                    }else{
                        $("#msg-success").removeClass('msg-error');
                        $("#msg-success").css('display','');
                        $("#msg-success").html('<p>' + data.descrip + '</p>');
                        $("#msg-success").delay(900).fadeOut(800);
                        $('#Categoria').val('');
                         CategoriasView();
                    }
            	}//data 
        }); //AJAX
    /**************************************/
}//function SaveSalon
function CambiarEstado(id,estado){
    /*********************************************/
    if(estado==100){
        var text = 'Desea Activar...?';
    }else{
        var text = 'Desea Inactivar...?';
    }
    if(confirm(text)){
       $.ajax({//Ajax
              type: 'POST',
              url: '../Administradores/Admin_TipoSalon_html.php',
              async: false,
              dataType: 'json',
              data:({actionID: 'stado',id:id,estado:estado}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
              success: function(data){
                    if(data.val==false){
                        $("#msg-success").addClass('msg-error');
                        $("#msg-success").css('display','');
                        $("#msg-success").html('<p>' + data.descrip + '</p>');
                    }else{
                        $("#msg-success").removeClass('msg-error');
                        $("#msg-success").css('display','');
                        $("#msg-success").html('<p>' + data.descrip + '</p>');
                        $("#msg-success").delay(900).fadeOut(800);
                         CategoriasView();
                    }
            	}//data 
        }); //AJAX 
    }
    
    /*********************************************/   
}//function CambiarEstado
function CategoriasView(){
    /*********************************************/
    $.ajax({//Ajax
              type: 'POST',
              url: '../Administradores/Admin_TipoSalon_html.php',
              async: false,
              dataType: 'html',
              data:({actionID: 'View'}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
              success: function(data){
                    $('#View').html(data);
            	}//data 
        }); //AJAX
    /*********************************************/    
}//function CategoriasView
/***************************Inicio****************************/
$(function(){
       $("td[contenteditable=true]").blur(function(){
        
        var field_userid = $(this).attr("id") ;
        var value = $(this).text() ;
        
            $.ajax({//Ajax
                  type: 'POST',
                  url: '../Administradores/Admin_TipoSalon_html.php',
                  async: false,
                  dataType: 'json',
                  data:({actionID: 'Editar',id:field_userid,value:value}),
                  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                  success: function(data){
                       if(data.val==false){
                        $("#msg-success").addClass('msg-error');
                        $("#msg-success").css('display','');
                        $("#msg-success").html('<p>' + data.descrip + '</p>');
                    }else{
                        $("#msg-success").removeClass('msg-error');
                        $("#msg-success").css('display','');
                        $("#msg-success").html('<p>' + data.descrip + '</p>');
                        $("#msg-success").delay(900).fadeOut(800);
                    }
           	    }//data 
            }); //AJAX 
        });
    });
/***************************Fin****************************/
function EjecutarCambio(id){ 
    /******************************************************/
    var Espacio = $('#EsapcioFisico_'+id).val();
    
    if(Espacio==-1 || Espacio=='-1'){
       $('#EsapcioFisico_'+id).effect("pulsate", {times:3}, 500);
       $('#EsapcioFisico_'+id).css('border-color','#F00');
        return false; 
    }
    
      $.ajax({//Ajax
              type: 'POST',
              url: '../Administradores/Admin_TipoSalon_html.php',
              async: false,
              dataType: 'json',
              data:({actionID: 'CambiarTipo',Espacio:Espacio,id:id}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
              success: function(data){
                    if(data.val==false){
                        $("#msg-success").addClass('msg-error');
                        $("#msg-success").css('display','');
                        $("#msg-success").html('<p>' + data.descrip + '</p>');
                    }else{
                        $("#msg-success").removeClass('msg-error');
                        $("#msg-success").css('display','');
                        $("#msg-success").html('<p>' + data.descrip + '</p>');
                        $("#msg-success").delay(900).fadeOut(800);
                        $('#Categoria').val('');
                         CategoriasView();
                    }
            	}//data 
        }); //AJAX
    /******************************************************/
}//function EjecutarCambio