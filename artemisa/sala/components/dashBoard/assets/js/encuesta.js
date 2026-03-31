$(function(){    
    var obligar = $("#obligatoria").val();
    if(obligar === '1'){
        alowNavigate = false;    
    }
});

function cargarEncuesta(url, idgrupo, codigoestudiante, documento, materia, categoria){
    showLoader();
    //Evaluacion docente    
    if(categoria === 'EDOCENTES'){
        hr = HTTP_ROOT+"/serviciosacademicos/mgi/autoevaluacion/interfaz/instrumento_aplicar.php?id_instrumento="+url+"&Ver=1&documento="+documento+"&Grupo_id="+idgrupo+"&materia="+materia+"&CodigoEstudiante="+codigoestudiante+"&CodigoJornada=01";
    }
    if(categoria === 'OTRAS' || categoria === 'BIENESTAR'){
        hr = HTTP_ROOT+"/serviciosacademicos/mgi/autoevaluacion/interfaz/instrumento_aplicar.php?id_instrumento="+url+"&Ver=2"; 
    }    
    
    var height = $(window).outerHeight() - 175;
    var frame = '<iframe width="100%" height="'+height+'" frameborder="0" scrolling="auto" marginheight="0" marginwidth="0" name="contenidocentral" id="contenidocentral" src="'+hr+'"></iframe>';
    $( "#page-content" ).html( frame ); 
    $('#page-content #contenidocentral').on("load", function() {
        hideLoader();
    });
    timeOutVar = window.setTimeout(function(){
        $("#mensajeLoader").html("La carga esta tardando demaciado...");
        timeOutVar = window.setTimeout(function(){hideLoader();}, 5000);
    }, 15000);
    hideAsideModule();
}


function InicarEncuesta(encuesta){
    var url = $(encuesta).attr("data-id");
    var categoria = $(encuesta).attr("data-cat");

    if(categoria === 'OTRAS' || categoria === 'BIENESTAR'){        
        cargarEncuesta(url, idgrupo, codigoestudiante, documento, materia, categoria);
    }else{  
        if(categoria === 'EDOCENTES'){
            var idgrupo = $(encuesta).attr("value");
            var materia = $(encuesta).attr("data-mat");

            if(idgrupo > 0){                
                var documento = $(encuesta).attr("data-doc");
                var codigoestudiante = $(encuesta).attr("data-est");
    
                cargarEncuesta(url, idgrupo, codigoestudiante, documento, materia, categoria);
            }
        }
    }
}
