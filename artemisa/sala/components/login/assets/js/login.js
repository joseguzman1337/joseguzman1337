var images = [
    HTTP_SITE+"/assets/images/bloqueA.jpg",
    HTTP_SITE+"/assets/images/bloqueJ.jpg",
    HTTP_SITE+"/assets/images/bloqueM.jpg",
    HTTP_SITE+"/assets/images/fundadores-interno.jpg",
    HTTP_SITE+"/assets/images/gimnasio.jpg"
];

$.preloadImages = function() {
  for (var i = 0; i < images.length; i++) {
    $("<img />").attr("src", images[i]);
  }
};

// FORM VALIDATION FEEDBACK ICONS
// =================================================================
var faIcon = {
        valid: 'fa fa-check-circle fa-lg text-success',
        invalid: 'fa fa-times-circle fa-lg',
        validating: 'fa fa-refresh'
};
var allowContinue = false;
$(document).ready(function(){
    $.preloadImages(images);
    var i = 0;
    setInterval(function() {
        var image = $('.img-acceso');
        image.fadeOut(200, function () {
            image.css("background-image", "url("+images[i]+")");
            image.fadeIn(1000);
        });
        i = i + 1;
        if (i == images.length) {
            i =  0;
        }
    }, 8000);
    
    /*$("#login_btn").click(function(e){
        e.preventDefault();
        e.stopPropagation();
        login();
    });/**/
    $("#login-form").submit(function(e){
        e.preventDefault();
        e.stopPropagation();
        $("#login_btn").removeAttr("disabled");
        if (allowContinue){
            login();
        }
        return false;
    });/**/
    
    $("#cambiarDeUsuario").click(function(e){
        e.preventDefault();
        e.stopPropagation();
        cerrarSesion();
        return false;
    });/**/
    
    if(lanzarAlerta){
        lanzarAlertaSegClave("Ahora debe digitar la segunda clave");
    }
        
    
    // FORM VALIDATION
    // =================================================================
    $('#login-form').bootstrapValidator({
        excluded: [':disabled'],
        feedbackIcons: faIcon,
        fields: {
            login: {
                validators: {
                    notEmpty: {
                        message: 'El nombre de usuario es requerido'
                    }
                }
            },
            clave: {
                validators: {
                    notEmpty: {
                        message: 'La contraseña es requerida'
                    },
                    regexp: {
                            regexp: /^[a-zA-Z0-9_\.@#$%&*-+\/{}[\]!"-]+$/,
                            message: 'La contraseña solo puede ser alfanumerica, sin espacios'
                    }
                }
            }
        }
    }).on('success.form.bv', function(e, data) {
        allowContinue = true;
    }).on('error.form.bv', function(e, data) {
        allowContinue = false;
    });
    
});

var theDocument;
var http;
var browser=navigator.appName;
var estiloXLST;
var msxml2DOM;
var rta;

if(browser=='Microsoft Internet Explorer')
{
	http=new ActiveXObject("Microsoft.XMLHTTP");
}
else
{
	http=new XMLHttpRequest();
}
/**
 * @author SALA Legacy
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package js login
 */

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

function login(){
    if(allowContinue){
        var clave = $("#clave").val();
        //clave = trasearclave(clave.trim());
        clave = clave.trim();

        var login = $("#login").val();
        login = login.trim();

        var cadena="login="+login+"&password="+clave;

        $.ajax({
            url: HTTP_ROOT+'/serviciosacademicos/consulta/loginv2.php',
            type: "POST",
            dataType: "json",
            data: {
                tmpl : 'json',
                password : clave,
                login : login,
                action : "ingresar",
                option : "login"
            },
            success: function( data ){
                var autenticacion = data.aut;
                var codigotipousuario = data.codigotipousuario*1;
                if(autenticacion=='SEGCLAVE'){
                    if(codigotipousuario!=0 && codigotipousuario==500){
                        lanzarAlertaSegClave(data.mensaje);

                        $.ajax({
                            url: HTTP_SITE+"/index.php",
                            type: "GET",
                            dataType: "json",
                            data: {
                                tmpl : 'json',
                                action : "setSegClaveReq",
                                option : "login",
                                autenticacion : 'SEGCLAVE'
                            },
                            success: function( data ){
                            }
                        });
                        $("#login").attr("disabled", "disabled");
                        $("#clave").attr("placeholder", "Segunda contraseña");
                        $("#clave").val("");
                        $("#cambiarDeUsuario").css("display","");
                        //alert('facultadeslv2.php?segClave');
                    }
                }else if(autenticacion=='SEGCLAVEREQ'){
                    lanzarAlertaSegClave(data.mensaje);

                    var url = data.url;
                    url = url.replace("../",HTTP_ROOT+"/serviciosacademicos/consulta/");
                    var frame = '<iframe width="100%" height="380" frameborder="0" scrolling="auto" marginheight="0" marginwidth="0" name="contenidocentral" id="contenidocentral" src="'+url+'"></iframe>';
                    window.setTimeout(function() { 
                        var box = bootbox.dialog({
                            title: "Actualizar segunda clave",
                            message: frame
                        });
                        box.on("shown.bs.modal", function() {
                            window.setTimeout(function() { 
                                $(".modal-dialog").addClass("modal-lg");
                            }, 500); 
                        });
                    }, 1500);

                    $("#login").attr("disabled", "disabled");
                    $("#cambiarDeUsuario").css("display","");
                }else if(autenticacion=='OK'){
                    contentHTML = alertContent.replace("fa-icon", dataAlert[2].icon);
                    contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">'+data.mensaje+'</span>');

                    showAlert(dataAlert[2].type,contentHTML);

                    if(codigotipousuario!=0){
                        switch(codigotipousuario){
                            case 400:
                            case 600:
                            case 900:
                            case 500://2
                                window.setTimeout(function() {
                                    var tipoUsuario = "";
                                    if(codigotipousuario == 400){
                                        tipoUsuario = "administrativo-";
                                    }else if(codigotipousuario == 500){
                                        tipoUsuario = "docente-";
                                    }else if(codigotipousuario == 600){
                                        tipoUsuario = "estudiante-";
                                    }else if(codigotipousuario == 900){
                                        tipoUsuario = "padre-";
                                    }
                                    ga('send', {
                                        hitType: 'pageview',
                                        page: "/usuario-"+tipoUsuario+login,
                                        title: "Ingreso - "+tipoUsuario+login
                                    });
                                    window.location.href = HTTP_SITE+"/";
                                }, 500);
                                break;
                        }
                    }else{
                        contentHTML = alertContent.replace("fa-icon", dataAlert[4].icon);
                        contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">'+data.mensaje+'</span>');
                        showAlert(dataAlert[4].type,contentHTML);
                    }             
                }else{
                    contentHTML = alertContent.replace("fa-icon", dataAlert[4].icon);
                    contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">'+data.mensaje+'</span>');
                    showAlert(dataAlert[4].type,contentHTML);
                    if(parseInt(data.contadorintentosfallidos) >= parseInt(data.cantidadintentosaccesopermitidos) || data.claveviva==="caduca"){
                        var url = data.url;
                        url = url.replace("../",HTTP_ROOT+"/serviciosacademicos/consulta/");
                        var frame = '<iframe width="100%" height="380" frameborder="0" scrolling="auto" marginheight="0" marginwidth="0" name="contenidocentral" id="contenidocentral" src="'+url+'"></iframe>';
                        window.setTimeout(function() { 
                            var box = bootbox.dialog({
                                title: "Recuperar clave",
                                message: frame
                            });
                            box.on("shown.bs.modal", function() {
                                window.setTimeout(function() { 
                                    $(".modal-dialog").addClass("modal-lg");
                                }, 500); 
                            });
                        }, 1500);
                    }
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                contentHTML = alertContent.replace("fa-icon", dataAlert[4].icon);
                contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">El servidor no responde, por favor comuniquese con la mesa de servicio</span>');
                showAlert(dataAlert[4].type,contentHTML);
            }
        });
    }
}

/**
 * @author SALA Legacy
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package js login
 */
function trasearclave(clave){
    var nuevacadena="";
    for(i=0;i<=(clave.length-1);i++){
        switch(clave.charAt(i)){
            case "&":
                nuevacadena+="%26";
                break;
            case "%":
                nuevacadena+="%25";
                break;
            case "°":
                nuevacadena+="%b0";
                break;
            case "\"":
                return false;
                break;
            case "'":
                return false;
                break;
            case ";":
                return false;
                break;
            case "¡":
                nuevacadena+="%a1";
                break;
            case "¿":
                nuevacadena+="%bf";
                break;
            case "Á":
                nuevacadena+="%c1";
                break;
            case "á":
                nuevacadena+="%e1";
                break;
            case "É":
                nuevacadena+="%c9";
                break;
            case "é":
                nuevacadena+="%e9";
                break;
            case "Í":
                nuevacadena+="%cd";
                break;
            case "í":
                nuevacadena+="%ed";
                break;
            case "Ó":
                nuevacadena+="%d3";
                break;
            case "ó":
                nuevacadena+="%f3";
                break;
            case "Ú":
                nuevacadena+="%da";
                break;
            case "ú":
                nuevacadena+="%fa";
                break;
            case "Ö":
                nuevacadena+="%f6";
                break;
            case "ö":
                nuevacadena+="%d6";
                break;
            case "Ü":
                nuevacadena+="%dc";
                break;
            case "ü":
                nuevacadena+="%fc";
                break;
            case "+":
                nuevacadena+="%2b";
                break;
            case "\\":
                nuevacadena+="%5c";
                break;
            case "ñ":
                nuevacadena+="%f1";
                break;
            case "Ñ":
                nuevacadena+="%d1";
                break;
            case "\$":
                nuevacadena+="%24";
                break;
            default :
                nuevacadena+=clave.charAt(i);
                break;
        }
    }
    return nuevacadena;
}
function showAlert(type, contentHtml){
    $.niftyNoty({
        type: type,
        container : '#page-alert',
        html : contentHtml,
        focus: true,
        timer : autoClose ? 6000 : 0
    });
}

function cerrarSesion(){   
    var confirma = '<div class="text-2x alert alert-warning fade in"><strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> Está a punto de cambiar de usuario, está seguro?</div>';
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

function lanzarAlertaSegClave(mensaje){
    contentHTML = alertContent.replace("fa-icon", dataAlert[0].icon);
    contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">'+mensaje+'</span>');
    showAlert(dataAlert[0].type,contentHTML);
}
