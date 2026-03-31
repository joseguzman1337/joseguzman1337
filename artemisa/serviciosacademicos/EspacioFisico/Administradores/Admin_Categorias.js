function SaveCategoria(){
    /*********************************************/
    var Categoria = $('#Categoria').val();
    
    if(!$.trim(Categoria)){
        /******************************************************/
        $('#Categoria').effect("pulsate", {times:3}, 500);
        $('#Categoria').css('border-color','#F00');
        return false;
        /******************************************************/ 
    }
     
     if($('#ActivarPermitir').is(':checked')){
        var Check  = 1;
     }else{
        var Check  = 0;
     }
     
       $.ajax({//Ajax
              type: 'POST',
              url: '../Administradores/Admin_Categorias_html.php',
              async: false,
              dataType: 'json',
              data:({actionID: 'InsertCategoria',Categoria:Categoria,Check:Check}),
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
    /*********************************************/
}//function SaveCategoria
function CategoriasView(){
    /*********************************************/
    $.ajax({//Ajax
              type: 'POST',
              url: '../Administradores/Admin_Categorias_html.php',
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
              url: '../Administradores/Admin_Categorias_html.php',
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
function CambiarActivar(id){
    if($('#ActivarPermitir_'+id).is(':checked')){
         var Check  = 1;
    }else{
         var Check  = 0;
    }
    
        $.ajax({//Ajax
              type: 'POST',
              url: '../Administradores/Admin_Categorias_html.php',
              async: false,
              dataType: 'json',
              data:({actionID: 'CambiarCheck',id:id,Check:Check}),
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
}//function CambiarActivar
$(function(){
       $("td[contenteditable=true]").blur(function(){
        
        var field_userid = $(this).attr("id") ;
        var value = $(this).text() ;
        
            $.ajax({//Ajax
                  type: 'POST',
                  url: '../Administradores/Admin_Categorias_html.php',
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

