$(document).ready(function(){
    initialize();
    initializeBreacCrumb();
});
function initialize(){
    $('.menuItem').click(function(e){
        e.stopPropagation();
        e.preventDefault();
        loadMenuContent(this);
    });
    /*$("#txt_buscador").keyup(function() {
        ajax_showOptions(this,'leeMenus',$(this).val()); 
    });/**/
    $("#txt_buscador").devbridgeAutocomplete({
        serviceUrl: HTTP_SITE+'/index.php?tmpl=json&option=mainMenu&task=buscarMenu',
        minChars : 5,
        /*type : 'POST',*/
        deferRequestBy : 500,
        onSelect: function (suggestion) {
            //alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
            triggerMenu(suggestion.data);
        }
    });
}
function initializeBreacCrumb(){
    $('#page-breadCrumb .menuItem').click(function(e){
        e.stopPropagation();
        e.preventDefault();
        loadMenuContent(this);
    });
}
function loadMenuContent(obj){
    validarVidaSesion("click");
    clearTimeout(timeOutVar);
    //console.log(alowNavigate);
    var qtipObj = $(".qtip");
    if(typeof qtipObj !== "undefined"){
        $(".qtip").attr("aria-hidden","true");
        $(".qtip").css("display","none");
    }
    
    var flotToolTip = $("#flot-tooltip");
    if(typeof flotToolTip !== "undefined"){ 
        $("#flot-tooltip").css("display","none");
    }
    
    updateSessionActivity();
    var hr = $(obj).attr('href').trim();
    var reliframe = $(obj).attr('rel').trim();
    var menuId = $(obj).attr('id').trim();
    var itemId = menuId.split("_");
    $("ul#mainnav-menu>li, ul.collapse>li").removeClass("active-link");
    $(obj).parent().addClass("active-link");
    //alert(itemId);
    //alert(hr);
    if(!alowNavigate){
        contentHTML = alertContent.replace("fa-icon", dataAlert[0].icon);
        contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">Aun no puede navegar por las opciones</span>');
        showAlert(dataAlert[0].type,contentHTML);
    }else{
        if(reliframe=="iframe" && (hr!="" && hr!="#")){
            showLoader();
            /**
             * Caso 278.
             * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
             * Se crea la funcion activarMenuEnSesion para que permita administrar el itemId por la Sesión.  
             * Ajuste de acceso por usuario por la opción de Gestion de Permisos del plan de Desarrollo.
             * @since 21 de Febrero 2019.
            */
            activarMenuEnSesion(itemId[1]);
            if(hr.indexOf('?') != -1){
                //hr = hr+"&itemId="+itemId[1];
            }else{
                //hr = hr+"?itemId="+itemId[1];
            }
            var height = $(window).outerHeight() - 175;
            if(height<492){
                height = 492;
            }
            var frame = '<iframe width="100%" height="'+height+'" frameborder="0" scrolling="auto" marginheight="0" marginwidth="0" name="contenidocentral" id="contenidocentral" src="'+hr+'"></iframe>';
            $( "#page-content" ).html( frame ); 
            $('#page-content #contenidocentral').on("load", function() {
                hideLoader();
            });
            timeOutVar = window.setTimeout(function(){
                $("#mensajeLoader").html("La carga esta tardando demasiado...");
                timeOutVar = window.setTimeout(function(){hideLoader();}, 5000);
            }, 15000);
            showHideAsideModule(itemId[1]);
            //alert(boxed); 
        }else if(reliframe=="" && hr!="" && hr!="#" ){
            showLoader();
            $.ajax({
                url: $(obj).attr('href'),
                type: "POST",
                data: {
                    tmpl : 'json',
                    itemId : itemId[1]
                },
                success: function( data ){
                    $( "#page-content" ).html( data );
                },
                complete: function( ){
                    hideLoader();
                }
            }).always(function() {
                hideLoader();
            });
            showHideAsideModule(itemId[1]);
        }
        updateTitle(hr,menuId);
    }
}

function showHideAsideModule(itemId){
    if(itemId=="0"){
        showAsideModule();
    }else{
        hideAsideModule();
    }
}
function showAsideModule(){
    $("#container").addClass("aside-in");
    $("#container").addClass("aside-left");
    $("#container").addClass("aside-bright");
    //aside-in aside-left aside-bright
}
function hideAsideModule(){
    $("#container").removeClass("aside-in");
    $("#container").removeClass("aside-left");
    $("#container").removeClass("aside-bright");
}

function hideMainMenu(){
    if( $("#container").hasClass("mainnav-lg") ){
        triggerToogleMenu();
    }
}

function triggerToogleMenu(){
    $(".mainnav-toggle").trigger("click");
}

function updateTitle(hr,menuId){
    //alert(hr,menuId);
    if(hr!="" && hr!="#" ){
        $.ajax({
            url: HTTP_SITE+"/index.php",
            type: "POST",
            dataType: "json",
            data: {
                tmpl : 'json',
                menuId : menuId,
                action : "getTituloSeccion",
                option : "mainMenu"
            },
            success: function( data ){
                if(data.s){
                    $("#page-title h1").html(data.title);
                    $("#page-breadCrumb").html(data.breadCrumbs);
                    initializeBreacCrumb();
                    var uri = hr.split(HTTP_ROOT); 
                    
                    var page = uri[1];
                    var title = data.title;
                    trackPage(page, title);
                }
            }
        });
    }
}
function triggerMenu(obj){
    $('#menuId_'+obj ).trigger('click');
    var hr = $('#menuId_'+obj ).attr('href').trim();
    var menuId = 'menuId_'+obj;
    updateTitle(hr,menuId);
}
/**
 * Caso 278.
 * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
 * Se crea la funcion activarMenuEnSesion para que permita administrar el itemId por la Sesión.  
 * Ajuste de acceso por usuario por la opción de Gestion de Permisos del plan de Desarrollo.
 * @since 21 de Febrero 2019.
 */
function activarMenuEnSesion(itemId){
    $.ajax({
        url: HTTP_SITE+"/index.php", 
        type: "POST",
        dataType: "json",
        data: {
            tmpl : 'json',
            action : "activarMenuEnSesion",
            option : "adminMenu",
            itemId : itemId 
        },
        success: function( data ){
            if(data.s){
                
            }
        }
    }) ;// function activarMenuEnSesion
 //End Caso 278   
}