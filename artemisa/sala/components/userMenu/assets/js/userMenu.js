$(document).ready(function(){
    $(".logout").click(function(e){
        e.stopPropagation();
        e.preventDefault();
        cerrarSesion();
    });
    
    $(".changeRol").click(function(e){
        e.preventDefault();
        e.stopPropagation();
        changeRol(this);
    });
    
    $("#menuId_220").click(function(e){
        validarNombreCarrera();
    });
});

function cerrarSesion(){   
    var confirma = '<div class="text-2x alert alert-warning fade in"><strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> Está a punto de cerrar sesión, está seguro?</div>';
    //bootbox.setLocale("es");
    bootbox.setDefaults({
        locale: "es"
    });
    bootbox.confirm(confirma, function(result) {
        if (result) {
            showLoader();
            $.ajax({
                url: HTTP_SITE+"/index.php",
                type: "POST",
                dataType: "json",
                data: {
                    tmpl : 'json',
                    action : "logout",
                    option : "login"
                },
                success: function( data ){
                    if(data.s){
                        window.location.href = HTTP_SITE+"/?tmpl=login&option=login";
                    }
                } ,
                complete: function( ){
                    hideLoader();
                }
            }).always(function() {
                hideLoader();
            });
        }
    });    
}

function changeRol(obj){
    var rolId = $(obj).attr("data-rol-id");
    
    var rol;
    var texto;
    switch(rolId){
        case '1':{       
            texto = ('cambiar a rol de Estudiante');
            rol = '600';
        }break;
        case '2':{                   
            texto = ('cambiar a rol de docente');
            rol = '500';
        }break;
        case '3':{
            texto = ('cambiar a rol Administrador');  
            rol = '400';
        }break;
        case '4':{
            texto = ('cambiar a rol Padre');  
            rol = '900';
        }break;
    }//switch
    
    var confirma = '<div class="text-2x alert alert-warning fade in"><strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> Está seguro de '+texto+'?</div>';
    //bootbox.setLocale("es");
    bootbox.setDefaults({
        locale: "es"
    });
    bootbox.confirm(confirma, function(result) {
        if (result) {
            showLoader();
            $.ajax({//Ajax
                type: 'POST',
                url: HTTP_SITE+"/index.php",
                dataType: "json",
                data:{
                    cambiorol:rol, 
                    rol:rolId,
                    tmpl : 'json',
                    action : "changeRol",
                    option : "login"
                },
                success: function(data){
                    if(data.s){
                        switch(data.action){
                            case "reload":
                                window.location.reload();
                                break;
                            case "gologin":
                                window.location.href = HTTP_SITE+"/?option=login&tmpl=login";
                                break;
                        }
                    }
                },
                complete: function( ){
                    hideLoader();
                }
            }).always(function() {
                hideLoader();
            });
        }
    });  
    
    
}

function validarNombreCarrera(){
    var idCurrentCarrera = $("#nombreCarrera").attr("data-idCarrera");
    var validar = setInterval(function() {
        //alert(idCurrentCarrera);
        $.ajax({
            type: 'GET',
            url: HTTP_SITE+"/index.php",
            dataType: "json",
            data:{
                idCarrera:idCurrentCarrera,  
                tmpl : 'json',
                action : "validarNombreCarrera"
            },
            success: function(data){
                if(data.s){
                    $("#nombreCarrera").attr("data-idCarrera",data.idCarrera);
                    $("#nombreCarrera").html(data.nombreCarrera);
                    clearInterval(validar);
                }
            }
        }); 
    }, 5000);/**/
}