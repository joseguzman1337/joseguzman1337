$(document).ready(function(){
    showAsideModule();
    hideMainMenu();
    
    pulsarIcono();
    var pulsar = setInterval(function(){
        pulsarIcono();
    }, 10000);
    
    $("#contenido-estudiante .menuBoton").click(function(e){ 
        e.stopPropagation();
        e.preventDefault();
        loadMenuEstudiante(this);
    });
    $(".menu-estudiante .menuBoton").click(function(e){ 
        e.stopPropagation();
        e.preventDefault();
        loadMenuEstudiante(this);
    });
    $("#show-hide-student-menu").click(function(e){
        e.stopPropagation();
        e.preventDefault();
        clearInterval(pulsar);
        showHideStudentMenu(this);
    });
    
    resize(); // call once initially
});
function pulsarIcono(){
    $('#show-hide-student-menu').effect("pulsate", {times:3}, 1000);
}
function loadMenuEstudiante(obj){
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
    //console.log(obj);
    updateSessionActivity();
    var hr = $(obj).attr('href').trim();
    var reliframe = $(obj).attr('data-rel').trim();
    var menuId = $(obj).attr('id').trim();
    var itemId = menuId.split("_");
    $("ul#mainnav-menu>li, ul.collapse>li").removeClass("active-link");
    $(obj).parent().addClass("active-link");
    //alert(itemId);
    //console.log(hr);
    //console.log(reliframe);
    if(reliframe=="iframe" && (hr!="" && hr!="#")){
        showLoader();
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
        $( "#contenido-estudiante" ).html( frame ); 
        $('#contenido-estudiante #contenidocentral').on("load", function() {
            hideLoader();
        });
        timeOutVar = window.setTimeout(function(){
            $("#mensajeLoader").html("La carga esta tardando demasiado...");
            timeOutVar = window.setTimeout(function(){hideLoader();}, 5000);
        }, 15000); 
        
        hideAsideModule(10);
        //alert(boxed); 
    }else if(reliframe=="" && hr!="" && hr!="#" ){
        if(itemId[1]==164){
            triggerMenu(itemId[1]);
        }else{
            showLoader();
            $.ajax({
                url: $(obj).attr('href'),
                type: "POST",
                data: {
                    tmpl : 'json',
                    itemId : itemId[1]
                },
                success: function( data ){
                    $( "#contenido-estudiante" ).html( data );
                },
                complete: function( ){
                    hideLoader();
                }
            }).always(function() {
                hideLoader();
            });

            hideAsideModule(10);
        }
    }
}
function showHideStudentMenu(obj){
    var clase = $(obj).hasClass("show-menu");
    if(clase){
        $(obj).addClass("hide-menu");
        $(obj).removeClass("show-menu");
        $("#arrowIcon").removeClass("fa-chevron-left");
        $("#arrowIcon").addClass("fa-chevron-right");
        $("aside.aside-right").removeClass("hidden-xs");
        $("aside.aside-right").removeClass("hidden-sm");
    }else{
        $(obj).removeClass("hide-menu");
        $(obj).addClass("show-menu");
        $("#arrowIcon").addClass("fa-chevron-left");
        $("#arrowIcon").removeClass("fa-chevron-right");
        $("aside.aside-right").addClass("hidden-xs");
        $("aside.aside-right").addClass("hidden-sm");        
    }
}
function resize() {
    var w = parseInt($(window).width());
    if(w<972 && w>749){
        $(".left-col").addClass("left-col-100");
    }else{
        $(".left-col").removeClass("left-col-100");
    }
}
$(window).on("resize", resize);