var timeOutVar = window.setTimeout(function(){},1);
var dataAlert = [{
            type : "info",
            icon : "fa-info-circle"
        },{
            type : "primary",
            icon : ""
        },{
            type : "success",
            icon : "fa-check-circle"
        },{
            type : "warning",
            icon : "fa-exclamation-triangle"
        },{
            type : "danger",
            icon : "fa-exclamation-triangle"
        },{
            type : "mint",
            icon : ""
        },{
            type : "purple",
            icon : ""
        },{
            type : "pink",
            icon : ""
        },{
            type : "dark",
            icon : ""
        }
    ];
var alertContent = '<center><strong><i class="fa fa-icon fa-2x" aria-hidden="true"></i></strong> <span class="text-2x"></span><center>';
var autoClose = true;
var timerClose = 6000;
function showAlert(type, contentHtml, focus){ 
    $.bthemeNoty({
        type: type,
        container : '#page-alert',
        html : contentHtml,
        focus: focus,
        timer : autoClose ? timerClose : 0
    });
}
function showLoader(){
    $(".loaderContent").fadeIn();
    $("#mensajeLoader").html("");
}
function hideLoader(){
    if($("#dropdown-user").hasClass("open")){
       $("#dropdown-user").removeClass("open"); 
    }
    $(".loaderContent").fadeOut();
}

function abrirModal(titulo,cuerpo){
    bootbox.dialog({
        title: titulo,
        message: cuerpo,
        buttons: {
            /*confirm: {
                label: "Save"
            }/**/
        }
    });
}
function updateSessionActivity(){
    $.ajax({
        url: HTTP_SITE+"/index.php",
        type: "POST",
        dataType: "json",
        data: {
            option: 'login',
            action: 'updateSessionActivity',
            tmpl : 'json'
        },
        success: function( data ){
        }
    });
}
function pulsarMenuUsuario(){
    if(typeof disablePulsar === "undefined"){
        disablePulsar = false;
    }
    if(!disablePulsar){
        $('#dropdown-user img').effect("pulsate", {times:4}, 1500);
    }
}

function desactivarMenuPulsante(){    
    $.ajax({
        url: HTTP_SITE+"/index.php",
        type: "POST",
        dataType: "json",
        data: {
            option: 'userMenu',
            action: 'desactivarMenuPulsante',
            tmpl : 'json'
        },
        success: function( data ){
        }
    });
}

$(function(){
    if(typeof $("#dropdown-user") !== "undefined"){
        pulsarMenuUsuario();
        var pulsarUserMneu = setInterval(function(){
            pulsarMenuUsuario(); 
        }, 7000);
        $("#dropdown-user").click(function(e){
            clearInterval(pulsarUserMneu);
            desactivarMenuPulsante();
        });        
    }
    
    $( window ).resize(function() { 
        if($("iframe#contenidocentral").length > 0){
            var height = $(window).outerHeight() - 175;
            if(height<492){
                height = 492;
            }
            $("#contenidocentral").attr("height",height);
        }
    });
});
function uppercase(obj){
    obj.value = obj.value.toUpperCase();
}