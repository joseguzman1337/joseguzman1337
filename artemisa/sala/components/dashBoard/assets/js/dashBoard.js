$(document).ready(function(){
    EventosView();
});
function EventosView(){
    $.ajax({//Ajax
        type: 'GET',
        url: HTTP_SITE+'/index.php',
        dataType: 'json',
        data:({
            option: 'eventosTelevisorDinamico',
            action: 'ConsultaEvento',
            tmpl: 'json'
        }),
        success: function(data){
            if(data.s==false){
                $("#EventoDinamico").parent().fadeOut();
            }else{
                var images = data.images;
                cargarEvento(images,0); 
            }
        }
    });
}//function EventosView

function cargarEvento(images, pos){
    var newPos = getNewPos(images,pos);
    
    var i = images[pos];
    var imgEvento = $("#imgEvento");
    if(typeof imgEvento === 'undefined' ){
        $("#imgEvento").fadeOut();
    }
    $('#EventoDinamico').html("<img class='img-responsive' style='display:none;' id='imgEvento' src='"+HTTP_ROOT+"/serviciosacademicos/EspacioFisico/Interfas/"+i.UbicacionImagen+"'>");
    $("#imgEvento").fadeIn();
    if(images.length > 1){ 
        setTimeout(function(){
            cargarEvento(images,newPos);
        }, 7500);
    }
}//function CargaEvento

function getNewPos(images, pos){
    if(images.length > 1){
        var newPos = Math.floor(Math.random() * images.length);
        if(pos != newPos){
            return newPos;
        }else{
            return getNewPos(images, pos);
        }
    }else{
        return 0;
    }
}