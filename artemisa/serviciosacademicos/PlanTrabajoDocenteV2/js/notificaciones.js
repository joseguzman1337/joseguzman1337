/**
 * @author suarezcarlos
 */

(function($){
    
    $.fn.notificaciones = function(options)
    {
        
        //establecemos las opciones de nuestro plugin
        var settings = {
            
            cssClass : 'info',
            mensaje : null,
            width : '100px',
            timeout : null,
            fadeout : 300,
            radius : null,
            mensaje2: null
            
            
        };
        
        //añadimos las opciones para poder utilizarlas
        if(options)
        {
            
            $.extend(settings, options);
            
        }
        
        //asignamos a contenedor_notificaciones el div con id notificaciones
        var contenedor_notificaciones = $("#notificaciones");
        
        //creamos la notificación con window.document.createElement y le añadimos
        //las clases notificacion y notificaciones + la clase que le
        //asigne el usuario, ésta será útil para darle css y distinguirla
        var notificacion = $(window.document.createElement('div')).addClass("notificacion").addClass('notificaciones-' + settings['cssClass']);
 
        //añadimos dentro de notificaciones la nueva notificación ya que 
        //notificaciones será quién tenga una posición fija
        contenedor_notificaciones.append(notificacion);
 
        //asignamos como minimo un segundo a la notificación para evitar problemas
        settings['timeout'] = settings['timeout'] < 1000 ? 100 : settings['timeout'];
        
        //damos la funcionalidad para qué en caso de no interactuar con la notificación
        //siga su proceso natural
            
        notificacion.show().delay(settings['timeout']).fadeOut(settings['fadeout']);
 
        //al entrar con el ratón en la notificación limpiamos la cola, así
        //no se desvanecerá
        notificacion.mouseenter(function () {
            
            $(this).clearQueue();
    
          });
          
          //al salir de la zona de la notificación hacemos que continúe la cola
          //para que se pueda desvanecer con un fadeout
          
     	/*notificacion.mouseleave(function () {
            
            $(this).delay(settings['timeout']).fadeOut(settings['fadeout']);
    
          });*/
          
          
          //asignamos los css propios a la notificación
        notificacion.css({'width':settings['width'],
        'top':settings['top'],'border-radius':settings['radius'],'margin-top' : '10px'});
        
      /*  var enlace = $("$txtIdPrograma").val();
        
        var id_Programa = '<a href=\"observacion.php?id_Programa='+enlace+'\">Prueba</a>';
       // alert(id_Programa);*/
        
        //añadimos el mensaje a la notificación
        notificacion.html(settings['mensaje']);    
    
    }
    
    //asignamos a $.notificaciones $.fn.notificaciones para poder llamarla
    //de esta forma cuando deseemos
    $.notificaciones = $.fn.notificaciones;
    
})(jQuery);