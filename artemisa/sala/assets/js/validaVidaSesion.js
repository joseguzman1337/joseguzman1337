$(document).ready(function(){
    validarVidaSesion();
    $(document).click(function(){
        validarVidaSesion("click");
    });
    /*/$(document).mousemove(function(){
        validarVidaSesion();
    });/**/
});

function validarVidaSesion(accion){
    if(typeof accion === "undefined"){
        accion = "";
    }
    var now = new Date();
    $.ajax({
        url: HTTP_SITE+"/index.php",
        type: "POST",
        dataType: "json",
        data: {
            tmpl : 'json',
            action : "validarVidaSesion",
            option : "login"
        },
        success: function( data ){
            if(data.s){
                if(accion === "click"){
                    updateSessionActivity();
                }else{
                    window.setTimeout(function() {
                        validarVidaSesion();
                    }, 300000);
                    //}, 2000);
                }
            }else{
                window.location.reload();
            }
        }
    });
}
