function cargarContenido(url){
    $("#pageContainer").load(""+url+"&renderPartial=1");
}

function cargarContenidoParametros(url, parameters){
    $("#pageContainer").load(""+url+"&renderPartial=1", parameters);
}

function cargarContenidoParametrosFuncion(url, parameters, funcion){
    $("#pageContainer").load(""+url+"&renderPartial=1", parameters, funcion);
}

jQuery(document).ready(function($){
        $('#barraLateral ul li a').removeClass('active');
        
        // Get current url
        // Select an a element that has the matching href and apply a class of 'active'. Also prepend a - to the content of the link
        var url = window.location.href;
        
        // Will also work for relative and absolute hrefs
        $('#barraLateral ul li a').filter(function() {
            return this.href == url;
        }).addClass('active');
        
        $("#pageContainer").on({
            ajaxStart: function() { 
                $('#loadingDiv').show(); 
                $('#pageContainer').hide();
            },
            ajaxStop: function() { 
                $('#loadingDiv').hide();  
                $('#pageContainer').show();  
                calculateHeight();
                if($("#pageContainer img").length > 0){
                  waitForElement();
                }
            }    
        });
        
        $(window).load(function() {
            calculateHeight();
        });
});

$(window).resize(function() {
    clearTimeout(this.id);
    this.id = setTimeout(calculateHeight, 250);
    
});

function waitForElement(){
    if($("#pageContainer img").height()>20){
        calculateHeight();
    }
    else{
        setTimeout(function(){
            waitForElement();
        },250);
    }
}

function calculateHeight(){
                if ($('#barraLateral').height() < $('#container').height()) 
                {
                    //$('#pageContainer').css("max-height",$('#pageContainer').height()); 
                    $('#barraLateral').height($('#container').height()); 
                } 
                else{ 
                    $('#barraLateral').height('100%'); 
                }
}