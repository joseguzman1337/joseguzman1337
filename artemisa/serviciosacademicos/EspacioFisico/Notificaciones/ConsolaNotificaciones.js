function EnviarNotificacion(){
    if(!$('.Enviar').is(':checked')){
      alert('Por Favor Idique la Solicitud que Desea Notificar...');
      return false;  
    }
    /*************************************************************/
    
    $.ajax({//Ajax
          type: 'POST',
          url: 'ConsolaNotificaciones_html.php',
          async: false,
          dataType: 'json',
          data:$('#NotificacionSolicitud').serialize(),
          error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
          success: function(data){
               if(data.val===true){
                    alert(data.descrip);
                    location.href='ConsolaNotificaciones_html.php';
               }else{
                    alert('Error');
                    return false;
               }
               
          }  
    });      
    
}//function EnviarNotificacion
